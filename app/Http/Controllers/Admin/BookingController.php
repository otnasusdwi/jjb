<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\TravelPackage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'travelPackage', 'affiliate'])
            ->when(request('search'), function ($query) {
                $query->where('booking_code', 'like', '%' . request('search') . '%')
                    ->orWhere('customer_name', 'like', '%' . request('search') . '%')
                    ->orWhere('customer_email', 'like', '%' . request('search') . '%');
            })
            ->when(request('status'), function ($query) {
                $query->where('booking_status', request('status'));
            })
            ->when(request('payment_status'), function ($query) {
                $query->where('payment_status', request('payment_status'));
            })
            ->when(request('affiliate'), function ($query) {
                $query->where('affiliate_id', request('affiliate'));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $affiliates = User::where('role', 'affiliate')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('admin.bookings.index', compact('bookings', 'affiliates'));
    }

    public function pending()
    {
        $bookings = Booking::with(['user', 'travelPackage', 'affiliate'])
            ->where('booking_status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.bookings.pending', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'travelPackage', 'affiliate', 'participants', 'payments']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function approve(Request $request, Booking $booking)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        DB::transaction(function () use ($booking, $request) {
            $booking->update([
                'booking_status' => 'confirmed',
                'admin_notes' => $request->admin_notes,
                'approved_at' => now(),
                'approved_by' => auth()->id()
            ]);

            // Calculate and create commission record
            if ($booking->affiliate_id) {
                $commissionAmount = ($booking->total_amount * $booking->travelPackage->commission_rate) / 100;

                \App\Models\Commission::create([
                    'booking_id' => $booking->id,
                    'affiliate_id' => $booking->affiliate_id,
                    'amount' => $commissionAmount,
                    'rate' => $booking->travelPackage->commission_rate,
                    'status' => 'pending'
                ]);
            }
        });

        // Send approval notification to customer and affiliate
        // TODO: Implement email notifications

        return redirect()->route('admin.bookings.pending')
            ->with('success', 'Booking approved successfully!');
    }

    public function reject(Request $request, Booking $booking)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000'
        ]);

        $booking->update([
            'booking_status' => 'cancelled',
            'admin_notes' => $request->rejection_reason,
            'rejected_at' => now(),
            'rejected_by' => auth()->id()
        ]);

        // Send rejection notification
        // TODO: Implement email notifications

        return redirect()->route('admin.bookings.pending')
            ->with('success', 'Booking rejected successfully!');
    }

    public function edit(Booking $booking)
    {
        $packages = TravelPackage::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('admin.bookings.edit', compact('booking', 'packages'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'travel_package_id' => 'required|exists:travel_packages,id',
            'departure_date' => 'required|date|after:today',
            'return_date' => 'required|date|after:departure_date',
            'adult_count' => 'required|integer|min:1',
            'child_count' => 'nullable|integer|min:0',
            'infant_count' => 'nullable|integer|min:0',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'payment_method' => 'required|in:cash,bank_transfer,credit_card,e_wallet',
            'payment_status' => 'required|in:pending,down_payment,paid',
            'special_requests' => 'nullable|string|max:1000',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $package = TravelPackage::findOrFail($request->travel_package_id);

        // Calculate total amount
        $totalAmount = ($package->adult_price * $request->adult_count) +
                      ($package->child_price * ($request->child_count ?? 0)) +
                      ($package->infant_price * ($request->infant_count ?? 0));

        $booking->update([
            'travel_package_id' => $request->travel_package_id,
            'departure_date' => $request->departure_date,
            'return_date' => $request->return_date,
            'adult_count' => $request->adult_count,
            'child_count' => $request->child_count ?? 0,
            'infant_count' => $request->infant_count ?? 0,
            'total_amount' => $totalAmount,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'payment_method' => $request->payment_method,
            'payment_status' => $request->payment_status,
            'special_requests' => $request->special_requests,
            'admin_notes' => $request->admin_notes
        ]);

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Booking updated successfully!');
    }

    public function destroy(Booking $booking)
    {
        if ($booking->booking_status === 'confirmed' && $booking->payments()->where('status', 'verified')->exists()) {
            return redirect()->route('admin.bookings.index')
                ->with('error', 'Cannot delete confirmed booking with verified payments.');
        }

        $booking->delete();

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking deleted successfully!');
    }

    public function export(Request $request)
    {
        $query = Booking::with(['user', 'travelPackage', 'affiliate']);

        // Apply filters if provided
        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->status) {
            $query->where('booking_status', $request->status);
        }
        if ($request->affiliate_id) {
            $query->where('affiliate_id', $request->affiliate_id);
        }

        $bookings = $query->get();

        // Generate CSV
        $filename = 'bookings_export_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ];

        $callback = function () use ($bookings) {
            $file = fopen('php://output', 'w');

            // CSV headers
            fputcsv($file, [
                'Booking Code', 'Package Name', 'Customer Name', 'Customer Email',
                'Departure Date', 'Total Amount', 'Status', 'Payment Status',
                'Affiliate', 'Created At'
            ]);

            // Data rows
            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->booking_code,
                    $booking->travelPackage->name,
                    $booking->customer_name,
                    $booking->customer_email,
                    $booking->departure_date,
                    $booking->total_amount,
                    $booking->status,
                    $booking->payment_status,
                    $booking->affiliate ? $booking->affiliate->name : '-',
                    $booking->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject,mark_paid,mark_completed',
            'selected_bookings' => 'required|array|min:1',
            'selected_bookings.*' => 'exists:bookings,id'
        ]);

        $bookings = Booking::whereIn('id', $request->selected_bookings);

        switch ($request->action) {
            case 'approve':
                $bookings->where('booking_status', 'pending')->update([
                    'booking_status' => 'confirmed',
                    'approved_at' => now(),
                    'approved_by' => auth()->id()
                ]);
                $message = 'Selected bookings approved successfully!';
                break;

            case 'reject':
                $bookings->where('booking_status', 'pending')->update([
                    'booking_status' => 'cancelled',
                    'rejected_at' => now(),
                    'rejected_by' => auth()->id()
                ]);
                $message = 'Selected bookings rejected successfully!';
                break;

            case 'mark_paid':
                $bookings->update(['payment_status' => 'paid']);
                $message = 'Selected bookings marked as paid!';
                break;

            case 'mark_completed':
                $bookings->where('booking_status', 'confirmed')->update(['booking_status' => 'completed']);
                $message = 'Selected bookings marked as completed!';
                break;
        }

        return redirect()->route('admin.bookings.index')
            ->with('success', $message);
    }
}
