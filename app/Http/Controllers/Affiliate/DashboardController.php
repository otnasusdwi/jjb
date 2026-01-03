<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\TravelPackage;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $affiliate = auth()->user();

        $stats = [
            'total_bookings' => $affiliate->bookings()->count(),
            'this_month_bookings' => $affiliate->bookings()
                ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                ->count(),
            'confirmed_bookings' => $affiliate->bookings()->where('booking_status', 'confirmed')->count(),
            'total_commission_earned' => $affiliate->bookings()
                ->where('payment_status', 'paid')
                ->sum('commission_amount'),
            'pending_commission' => $affiliate->bookings()
                ->whereIn('payment_status', ['down_payment', 'pending'])
                ->sum('commission_amount'),
            'conversion_rate' => $this->calculateConversionRate($affiliate),
        ];

        // Monthly booking trends for chart
        $monthlyBookings = $affiliate->bookings()
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->pluck('count', 'month');

        // Recent bookings
        $recent_bookings = $affiliate->bookings()
            ->with('package')
            ->latest()
            ->limit(5)
            ->get();

        // Available packages
        $featured_packages = TravelPackage::where('status', 'active')
            ->limit(6)
            ->get();

        return view('affiliate.dashboard', compact(
            'stats',
            'monthlyBookings',
            'recent_bookings',
            'featured_packages'
        ));
    }

    private function calculateConversionRate($affiliate)
    {
        $totalViews = 100; // This would come from landing page tracking
        $totalBookings = $affiliate->bookings()->count();

        return $totalViews > 0 ? round(($totalBookings / $totalViews) * 100, 2) : 0;
    }
}
