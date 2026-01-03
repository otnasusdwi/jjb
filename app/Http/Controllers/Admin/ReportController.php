<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\TravelPackage;
use App\Models\User;
use App\Models\Payment;
use App\Models\Commission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function dashboard()
    {
        $stats = $this->getDashboardStats();
        $charts = $this->getChartData();

        return view('admin.reports.dashboard', compact('stats', 'charts'));
    }

    public function revenue(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        // Revenue by bookings
        $bookingRevenue = Booking::whereBetween('created_at', [$startDate, $endDate])
            ->where('booking_status', 'confirmed')
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue, COUNT(*) as bookings')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Revenue by packages
        $packageRevenue = Booking::with('travelPackage')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('booking_status', 'confirmed')
            ->selectRaw('travel_package_id, SUM(total_amount) as revenue, COUNT(*) as bookings')
            ->groupBy('travel_package_id')
            ->orderByDesc('revenue')
            ->limit(10)
            ->get();

        // Revenue by affiliates
        $affiliateRevenue = Booking::with('affiliate')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('booking_status', 'confirmed')
            ->whereNotNull('affiliate_id')
            ->selectRaw('affiliate_id, SUM(total_amount) as revenue, COUNT(*) as bookings')
            ->groupBy('affiliate_id')
            ->orderByDesc('revenue')
            ->limit(10)
            ->get();

        $totalStats = [
            'total_revenue' => $bookingRevenue->sum('revenue'),
            'total_bookings' => $bookingRevenue->sum('bookings'),
            'avg_booking_value' => $bookingRevenue->sum('bookings') > 0 ? $bookingRevenue->sum('revenue') / $bookingRevenue->sum('bookings') : 0,
            'commission_paid' => Commission::whereBetween('created_at', [$startDate, $endDate])->where('status', 'paid')->sum('amount'),
        ];

        return view('admin.reports.revenue', compact(
            'bookingRevenue', 'packageRevenue', 'affiliateRevenue', 'totalStats', 'startDate', 'endDate'
        ));
    }

    public function affiliatePerformance(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        $affiliates = User::where('role', 'affiliate')
            ->where('status', 'active')
            ->withCount(['bookings as total_bookings' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->withCount(['bookings as confirmed_bookings' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate])
                    ->where('booking_status', 'confirmed');
            }])
            ->withSum(['bookings as total_revenue' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate])
                    ->where('booking_status', 'confirmed');
            }], 'total_amount')
            ->withSum(['commissions as total_commission' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }], 'amount')
            ->withSum(['commissions as paid_commission' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate])
                    ->where('status', 'paid');
            }], 'amount')
            ->orderByDesc('total_revenue')
            ->paginate(20);

        // Calculate conversion rates
        $affiliates->getCollection()->transform(function ($affiliate) {
            $affiliate->conversion_rate = $affiliate->total_bookings > 0
                ? ($affiliate->confirmed_bookings / $affiliate->total_bookings) * 100
                : 0;
            return $affiliate;
        });

        return view('admin.reports.affiliate-performance', compact('affiliates', 'startDate', 'endDate'));
    }

    public function packagePerformance(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        $packages = TravelPackage::withCount(['bookings as total_bookings' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->withCount(['bookings as confirmed_bookings' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate])
                    ->where('booking_status', 'confirmed');
            }])
            ->withSum(['bookings as total_revenue' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate])
                    ->where('booking_status', 'confirmed');
            }], 'total_amount')
            ->orderByDesc('total_revenue')
            ->paginate(20);

        // Calculate conversion rates and average booking value
        $packages->getCollection()->transform(function ($package) {
            $package->conversion_rate = $package->total_bookings > 0
                ? ($package->confirmed_bookings / $package->total_bookings) * 100
                : 0;
            $package->avg_booking_value = $package->confirmed_bookings > 0
                ? $package->total_revenue / $package->confirmed_bookings
                : 0;
            return $package;
        });

        return view('admin.reports.package-performance', compact('packages', 'startDate', 'endDate'));
    }

    public function customerAnalytics(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        // New customers
        $newCustomers = Booking::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(DISTINCT customer_email) as new_customers')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Repeat customers
        $repeatCustomers = DB::table('bookings')
            ->select('customer_email')
            ->selectRaw('COUNT(*) as booking_count, SUM(total_amount) as total_spent')
            ->where('booking_status', 'confirmed')
            ->groupBy('customer_email')
            ->having('booking_count', '>', 1)
            ->orderByDesc('total_spent')
            ->limit(20)
            ->get();

        // Customer demographics (by departure city)
        $customersByLocation = Booking::with('travelPackage')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('booking_status', 'confirmed')
            ->selectRaw('travel_packages.departure_city, COUNT(*) as bookings, SUM(bookings.total_amount) as revenue')
            ->join('travel_packages', 'bookings.travel_package_id', '=', 'travel_packages.id')
            ->groupBy('travel_packages.departure_city')
            ->orderByDesc('bookings')
            ->get();

        // Customer acquisition by affiliate
        $customersByAffiliate = Booking::with('affiliate')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('booking_status', 'confirmed')
            ->whereNotNull('affiliate_id')
            ->selectRaw('affiliate_id, COUNT(DISTINCT customer_email) as unique_customers, COUNT(*) as total_bookings')
            ->groupBy('affiliate_id')
            ->orderByDesc('unique_customers')
            ->limit(10)
            ->get();

        return view('admin.reports.customer-analytics', compact(
            'newCustomers', 'repeatCustomers', 'customersByLocation', 'customersByAffiliate', 'startDate', 'endDate'
        ));
    }

    public function export(Request $request)
    {
        $reportType = $request->type;
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        switch ($reportType) {
            case 'revenue':
                return $this->exportRevenue($startDate, $endDate);
            case 'affiliates':
                return $this->exportAffiliatePerformance($startDate, $endDate);
            case 'packages':
                return $this->exportPackagePerformance($startDate, $endDate);
            case 'customers':
                return $this->exportCustomerAnalytics($startDate, $endDate);
            default:
                return redirect()->back()->with('error', 'Invalid report type');
        }
    }

    private function getDashboardStats()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();

        return [
            'total_bookings' => Booking::count(),
            'confirmed_bookings' => Booking::where('booking_status', 'confirmed')->count(),
            'pending_bookings' => Booking::where('booking_status', 'pending')->count(),
            'total_revenue' => Booking::where('booking_status', 'confirmed')->sum('total_amount'),
            'monthly_revenue' => Booking::where('booking_status', 'confirmed')
                ->whereBetween('created_at', [$thisMonth, Carbon::now()])
                ->sum('total_amount'),
            'active_affiliates' => User::where('role', 'affiliate')->where('status', 'active')->count(),
            'total_packages' => TravelPackage::where('status', 'active')->count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'commission_pending' => Commission::where('status', 'pending')->sum('amount'),
            'commission_paid' => Commission::where('status', 'paid')->sum('amount'),
        ];
    }

    private function getChartData()
    {
        $last12Months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $last12Months->push([
                'month' => $month->format('M Y'),
                'revenue' => Booking::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->where('booking_status', 'confirmed')
                    ->sum('total_amount'),
                'bookings' => Booking::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->where('booking_status', 'confirmed')
                    ->count(),
            ]);
        }

        return [
            'monthly_revenue' => $last12Months,
            'top_packages' => TravelPackage::withSum(['bookings' => function ($query) {
                $query->where('booking_status', 'confirmed');
            }], 'total_amount')
                ->orderByDesc('bookings_sum_total_amount')
                ->limit(5)
                ->get(),
            'top_affiliates' => User::where('role', 'affiliate')
                ->withSum(['bookings' => function ($query) {
                    $query->where('booking_status', 'confirmed');
                }], 'total_amount')
                ->orderByDesc('bookings_sum_total_amount')
                ->limit(5)
                ->get(),
        ];
    }

    private function exportRevenue($startDate, $endDate)
    {
        $bookings = Booking::with(['travelPackage', 'affiliate'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('booking_status', 'confirmed')
            ->get();

        $filename = 'revenue_report_' . $startDate->format('Y-m-d') . '_to_' . $endDate->format('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ];

        $callback = function () use ($bookings) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Date', 'Booking Code', 'Package', 'Customer', 'Revenue', 'Commission', 'Affiliate', 'Net Revenue'
            ]);

            foreach ($bookings as $booking) {
                $commission = $booking->commissions()->sum('amount');
                fputcsv($file, [
                    $booking->created_at->format('Y-m-d'),
                    $booking->booking_code,
                    $booking->travelPackage->name,
                    $booking->customer_name,
                    $booking->total_amount,
                    $commission,
                    $booking->affiliate ? $booking->affiliate->name : '-',
                    $booking->total_amount - $commission
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportAffiliatePerformance($startDate, $endDate)
    {
        $affiliates = User::where('role', 'affiliate')
            ->with(['bookings' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->get();

        $filename = 'affiliate_performance_' . $startDate->format('Y-m-d') . '_to_' . $endDate->format('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ];

        $callback = function () use ($affiliates) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Affiliate Name', 'Email', 'Total Bookings', 'Confirmed Bookings', 'Conversion Rate',
                'Total Revenue', 'Total Commission', 'Join Date'
            ]);

            foreach ($affiliates as $affiliate) {
                $totalBookings = $affiliate->bookings->count();
                $confirmedBookings = $affiliate->bookings->where('booking_status', 'confirmed')->count();
                $conversionRate = $totalBookings > 0 ? ($confirmedBookings / $totalBookings) * 100 : 0;

                fputcsv($file, [
                    $affiliate->name,
                    $affiliate->email,
                    $totalBookings,
                    $confirmedBookings,
                    round($conversionRate, 2) . '%',
                    $affiliate->bookings->where('booking_status', 'confirmed')->sum('total_amount'),
                    $affiliate->commissions->sum('amount'),
                    $affiliate->created_at->format('Y-m-d')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportPackagePerformance($startDate, $endDate)
    {
        $packages = TravelPackage::with(['bookings' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }])->get();

        $filename = 'package_performance_' . $startDate->format('Y-m-d') . '_to_' . $endDate->format('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ];

        $callback = function () use ($packages) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Package Name', 'Category', 'Price', 'Total Bookings', 'Confirmed Bookings',
                'Conversion Rate', 'Total Revenue', 'Avg Booking Value'
            ]);

            foreach ($packages as $package) {
                $totalBookings = $package->bookings->count();
                $confirmedBookings = $package->bookings->where('booking_status', 'confirmed')->count();
                $conversionRate = $totalBookings > 0 ? ($confirmedBookings / $totalBookings) * 100 : 0;
                $totalRevenue = $package->bookings->where('booking_status', 'confirmed')->sum('total_amount');
                $avgBookingValue = $confirmedBookings > 0 ? $totalRevenue / $confirmedBookings : 0;

                fputcsv($file, [
                    $package->name,
                    $package->category->name ?? 'N/A',
                    $package->adult_price,
                    $totalBookings,
                    $confirmedBookings,
                    round($conversionRate, 2) . '%',
                    $totalRevenue,
                    round($avgBookingValue, 2)
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportCustomerAnalytics($startDate, $endDate)
    {
        $customers = Booking::selectRaw('customer_email, customer_name, COUNT(*) as booking_count, SUM(total_amount) as total_spent, MIN(created_at) as first_booking')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('booking_status', 'confirmed')
            ->groupBy('customer_email', 'customer_name')
            ->orderByDesc('total_spent')
            ->get();

        $filename = 'customer_analytics_' . $startDate->format('Y-m-d') . '_to_' . $endDate->format('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ];

        $callback = function () use ($customers) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Customer Name', 'Email', 'Total Bookings', 'Total Spent', 'Avg Booking Value', 'First Booking', 'Customer Type'
            ]);

            foreach ($customers as $customer) {
                $avgBookingValue = $customer->booking_count > 0 ? $customer->total_spent / $customer->booking_count : 0;
                $customerType = $customer->booking_count > 1 ? 'Repeat' : 'New';

                fputcsv($file, [
                    $customer->customer_name,
                    $customer->customer_email,
                    $customer->booking_count,
                    $customer->total_spent,
                    round($avgBookingValue, 2),
                    Carbon::parse($customer->first_booking)->format('Y-m-d'),
                    $customerType
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
