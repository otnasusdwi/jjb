<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\Commission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['booking.travelPackage', 'booking.affiliate'])
            ->when(request('search'), function ($query) {
                $query->whereHas('booking', function ($q) {
                    $q->where('booking_code', 'like', '%' . request('search') . '%')
                      ->orWhere('customer_name', 'like', '%' . request('search') . '%');
                });
            })
            ->when(request('status'), function ($query) {
                $query->where('status', request('status'));
            })
            ->when(request('method'), function ($query) {
                $query->where('payment_method', request('method'));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.payments.index', compact('payments'));
    }

    public function pending()
    {
        $payments = Payment::with(['booking.travelPackage', 'booking.affiliate'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.payments.pending', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['booking.travelPackage', 'booking.affiliate', 'booking.participants']);
        return view('admin.payments.show', compact('payment'));
    }

    public function verify(Request $request, Payment $payment)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        DB::transaction(function () use ($payment, $request) {
            $payment->update([
                'status' => 'verified',
                'verified_at' => now(),
                'verified_by' => auth()->id(),
                'admin_notes' => $request->admin_notes
            ]);

            // Update booking payment status
            $booking = $payment->booking;
            $totalPaid = $booking->payments()->where('status', 'verified')->sum('amount');

            if ($totalPaid >= $booking->total_amount) {
                $booking->payment_status = 'paid';
            } elseif ($totalPaid > 0) {
                $booking->payment_status = 'down_payment';
            }
            $booking->save();
        });

        return redirect()->route('admin.payments.pending')
            ->with('success', 'Payment verified successfully!');
    }

    public function reject(Request $request, Payment $payment)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000'
        ]);

        $payment->update([
            'status' => 'rejected',
            'rejected_at' => now(),
            'rejected_by' => auth()->id(),
            'admin_notes' => $request->rejection_reason
        ]);

        return redirect()->route('admin.payments.pending')
            ->with('success', 'Payment rejected successfully!');
    }

    public function commissions()
    {
        $commissions = Commission::with(['booking.travelPackage', 'affiliate'])
            ->when(request('search'), function ($query) {
                $query->whereHas('affiliate', function ($q) {
                    $q->where('name', 'like', '%' . request('search') . '%')
                      ->orWhere('email', 'like', '%' . request('search') . '%');
                });
            })
            ->when(request('status'), function ($query) {
                $query->where('status', request('status'));
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

        return view('admin.payments.commissions', compact('commissions', 'affiliates'));
    }

    public function processCommissionPayout(Request $request)
    {
        $request->validate([
            'selected_commissions' => 'required|array|min:1',
            'selected_commissions.*' => 'exists:commissions,id',
            'payout_notes' => 'nullable|string|max:1000'
        ]);

        DB::transaction(function () use ($request) {
            Commission::whereIn('id', $request->selected_commissions)
                ->where('status', 'pending')
                ->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                    'paid_by' => auth()->id(),
                    'payout_notes' => $request->payout_notes
                ]);
        });

        return redirect()->route('admin.payments.commissions')
            ->with('success', 'Commission payout processed successfully!');
    }

    public function commissionSummary()
    {
        $affiliates = User::where('role', 'affiliate')
            ->where('status', 'active')
            ->with(['commissions' => function ($query) {
                $query->selectRaw('affiliate_id, status, SUM(amount) as total_amount, COUNT(*) as count')
                    ->groupBy('affiliate_id', 'status');
            }])
            ->get();

        $totalStats = [
            'total_pending' => Commission::where('status', 'pending')->sum('amount'),
            'total_paid' => Commission::where('status', 'paid')->sum('amount'),
            'total_commissions' => Commission::sum('amount'),
            'pending_count' => Commission::where('status', 'pending')->count(),
        ];

        return view('admin.payments.commission-summary', compact('affiliates', 'totalStats'));
    }

    public function paymentReport(Request $request)
    {
        $query = Payment::with(['booking.travelPackage', 'booking.affiliate']);

        // Apply date filters
        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $payments = $query->get();

        $stats = [
            'total_amount' => $payments->where('status', 'verified')->sum('amount'),
            'pending_amount' => $payments->where('status', 'pending')->sum('amount'),
            'rejected_amount' => $payments->where('status', 'rejected')->sum('amount'),
            'total_transactions' => $payments->count(),
            'verified_transactions' => $payments->where('status', 'verified')->count(),
            'pending_transactions' => $payments->where('status', 'pending')->count(),
        ];

        $paymentsByMethod = $payments->where('status', 'verified')
            ->groupBy('payment_method')
            ->map(function ($group) {
                return [
                    'count' => $group->count(),
                    'total' => $group->sum('amount')
                ];
            });

        return view('admin.payments.report', compact('payments', 'stats', 'paymentsByMethod'));
    }

    public function downloadProof(Payment $payment)
    {
        if (!$payment->proof_of_payment) {
            abort(404, 'Payment proof not found');
        }

        if (!Storage::disk('public')->exists($payment->proof_of_payment)) {
            abort(404, 'Payment proof file not found');
        }

        return Storage::disk('public')->download($payment->proof_of_payment);
    }

    public function bulkVerify(Request $request)
    {
        $request->validate([
            'selected_payments' => 'required|array|min:1',
            'selected_payments.*' => 'exists:payments,id',
            'bulk_notes' => 'nullable|string|max:1000'
        ]);

        DB::transaction(function () use ($request) {
            $payments = Payment::whereIn('id', $request->selected_payments)
                ->where('status', 'pending')
                ->get();

            foreach ($payments as $payment) {
                $payment->update([
                    'status' => 'verified',
                    'verified_at' => now(),
                    'verified_by' => auth()->id(),
                    'admin_notes' => $request->bulk_notes
                ]);

                // Update booking payment status
                $booking = $payment->booking;
                $totalPaid = $booking->payments()->where('status', 'verified')->sum('amount');

                if ($totalPaid >= $booking->total_amount) {
                    $booking->payment_status = 'paid';
                } elseif ($totalPaid > 0) {
                    $booking->payment_status = 'down_payment';
                }
                $booking->save();
            }
        });

        return redirect()->route('admin.payments.pending')
            ->with('success', 'Selected payments verified successfully!');
    }

    public function exportPayments(Request $request)
    {
        $query = Payment::with(['booking.travelPackage', 'booking.affiliate']);

        // Apply filters
        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $payments = $query->get();

        $filename = 'payments_export_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ];

        $callback = function () use ($payments) {
            $file = fopen('php://output', 'w');

            // CSV headers
            fputcsv($file, [
                'Payment ID', 'Booking Code', 'Package Name', 'Customer Name',
                'Amount', 'Payment Method', 'Status', 'Affiliate', 'Created At', 'Verified At'
            ]);

            // Data rows
            foreach ($payments as $payment) {
                fputcsv($file, [
                    $payment->id,
                    $payment->booking->booking_code,
                    $payment->booking->travelPackage->name,
                    $payment->booking->customer_name,
                    $payment->amount,
                    $payment->payment_method,
                    $payment->status,
                    $payment->booking->affiliate ? $payment->booking->affiliate->name : '-',
                    $payment->created_at->format('Y-m-d H:i:s'),
                    $payment->verified_at ? $payment->verified_at->format('Y-m-d H:i:s') : '-'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
