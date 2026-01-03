<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AffiliateProfile;
use App\Models\Booking;
use App\Models\TravelPackage;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_affiliates' => User::affiliates()->count(),
            'active_affiliates' => User::affiliates()->where('status', 'active')->count(),
            'pending_affiliates' => User::affiliates()->where('status', 'pending')->count(),
            'total_bookings' => Booking::count(),
            'todays_bookings' => Booking::whereDate('created_at', today())->count(),
            'total_revenue' => Booking::where('payment_status', 'paid')->sum('total_amount'),
            'pending_bookings' => Booking::where('booking_status', 'pending')->count(),
            'total_packages' => TravelPackage::count(),
            'active_packages' => TravelPackage::where('status', 'active')->count(),
        ];

        $recent_bookings = Booking::with(['package', 'affiliate'])
            ->latest()
            ->limit(10)
            ->get();

        $pending_affiliates = User::affiliates()
            ->where('status', 'pending')
            ->with('affiliateProfile')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_bookings', 'pending_affiliates'));
    }

    public function affiliates()
    {
        $affiliates = User::affiliates()->with('affiliateProfile')->paginate(20);
        return view('admin.affiliates.index', compact('affiliates'));
    }

    public function pendingAffiliates()
    {
        $pending_affiliates = User::affiliates()
            ->where('status', 'pending')
            ->with('affiliateProfile')
            ->paginate(20);

        return view('admin.affiliates.pending', compact('pending_affiliates'));
    }

    public function approveAffiliate(User $user)
    {
        $user->update(['status' => 'active']);

        if ($user->affiliateProfile) {
            $user->affiliateProfile->update([
                'approved_at' => now(),
                'approved_by' => auth()->id()
            ]);
        }

        return redirect()->back()->with('success', 'Affiliate approved successfully!');
    }

    public function rejectAffiliate(Request $request, User $user)
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        $user->update(['status' => 'rejected']);

        if ($user->affiliateProfile) {
            $user->affiliateProfile->update([
                'rejection_reason' => $request->reason
            ]);
        }

        return redirect()->back()->with('success', 'Affiliate rejected.');
    }
}
