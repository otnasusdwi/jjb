@extends('layouts.admin')

@section('title', 'Reports')

@section('content')
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h4 class="page-title mb-1">Reports & Analytics</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Reports</li>
            </ol>
        </div>
    </div>
</div>

<!-- Report Categories -->
<div class="row">
    <!-- Revenue Reports -->
    <div class="col-lg-6 col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="flex-grow-1">
                        <h5 class="card-title">Revenue Reports</h5>
                        <p class="text-muted">Track income, commission payouts, and financial performance across packages and affiliates.</p>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.reports.revenue') }}" class="btn btn-primary btn-sm">
                                <i class="ri-line-chart-line me-1"></i> View Revenue
                            </a>
                            <a href="{{ route('admin.reports.export', ['type' => 'revenue']) }}" class="btn btn-outline-primary btn-sm">
                                <i class="ri-download-line me-1"></i> Export
                            </a>
                        </div>
                    </div>
                    <div class="avatar-sm">
                        <div class="avatar-title bg-soft-primary text-primary rounded">
                            <i class="ri-money-dollar-circle-line" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Affiliate Performance -->
    <div class="col-lg-6 col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="flex-grow-1">
                        <h5 class="card-title">Affiliate Performance</h5>
                        <p class="text-muted">Analyze affiliate sales performance, conversion rates, and commission earnings.</p>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.reports.affiliates') }}" class="btn btn-success btn-sm">
                                <i class="ri-team-line me-1"></i> View Performance
                            </a>
                            <a href="{{ route('admin.reports.export', ['type' => 'affiliates']) }}" class="btn btn-outline-success btn-sm">
                                <i class="ri-download-line me-1"></i> Export
                            </a>
                        </div>
                    </div>
                    <div class="avatar-sm">
                        <div class="avatar-title bg-soft-success text-success rounded">
                            <i class="ri-group-line" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Package Performance -->
    <div class="col-lg-6 col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="flex-grow-1">
                        <h5 class="card-title">Package Performance</h5>
                        <p class="text-muted">Monitor which packages perform best and identify optimization opportunities.</p>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.reports.packages') }}" class="btn btn-info btn-sm">
                                <i class="ri-gift-line me-1"></i> View Packages
                            </a>
                            <a href="{{ route('admin.reports.export', ['type' => 'packages']) }}" class="btn btn-outline-info btn-sm">
                                <i class="ri-download-line me-1"></i> Export
                            </a>
                        </div>
                    </div>
                    <div class="avatar-sm">
                        <div class="avatar-title bg-soft-info text-info rounded">
                            <i class="ri-gift-line" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Analytics -->
    <div class="col-lg-6 col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="flex-grow-1">
                        <h5 class="card-title">Customer Analytics</h5>
                        <p class="text-muted">Understand customer behavior, demographics, and lifetime value patterns.</p>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.reports.customers') }}" class="btn btn-warning btn-sm">
                                <i class="ri-user-line me-1"></i> View Analytics
                            </a>
                            <a href="{{ route('admin.reports.export', ['type' => 'customers']) }}" class="btn btn-outline-warning btn-sm">
                                <i class="ri-download-line me-1"></i> Export
                            </a>
                        </div>
                    </div>
                    <div class="avatar-sm">
                        <div class="avatar-title bg-soft-warning text-warning rounded">
                            <i class="ri-user-line" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Overview Stats -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Overview</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center">
                            <h4 class="text-primary mb-1">{{ number_format(\App\Models\Booking::where('booking_status', 'confirmed')->count()) }}</h4>
                            <p class="text-muted mb-0">Total Confirmed Bookings</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h4 class="text-success mb-1">IDR {{ number_format(\App\Models\Booking::where('booking_status', 'confirmed')->sum('total_amount'), 0, ',', '.') }}</h4>
                            <p class="text-muted mb-0">Total Revenue</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h4 class="text-info mb-1">{{ \App\Models\User::where('role', 'affiliate')->where('status', 'active')->count() }}</h4>
                            <p class="text-muted mb-0">Active Affiliates</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h4 class="text-warning mb-1">{{ \App\Models\TravelPackage::where('status', 'active')->count() }}</h4>
                            <p class="text-muted mb-0">Active Packages</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity Chart -->
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Revenue Trend (Last 6 Months)</h5>
                    <div>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="updateChart('revenue')">Revenue</button>
                        <button type="button" class="btn btn-sm btn-outline-info" onclick="updateChart('bookings')">Bookings</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div style="height: 300px;">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Top Performing Packages</h5>
            </div>
            <div class="card-body">
                @php
                    $topPackages = \App\Models\TravelPackage::withSum(['bookings' => function($query) {
                        $query->where('status', 'confirmed');
                    }], 'total_amount')
                    ->orderByDesc('bookings_sum_total_amount')
                    ->limit(5)
                    ->get();
                @endphp

                @foreach($topPackages as $index => $package)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="mb-0">{{ Str::limit($package->name, 25) }}</h6>
                        <small class="text-muted">{{ $package->bookings()->where('booking_status', 'confirmed')->count() }} bookings</small>
                    </div>
                    <div class="text-end">
                        <strong>IDR {{ number_format($package->bookings_sum_total_amount ?? 0, 0, ',', '.') }}</strong>
                    </div>
                </div>
                @if(!$loop->last)<hr>@endif
                @endforeach

                @if($topPackages->isEmpty())
                <div class="text-center text-muted py-3">
                    <i class="ri-gift-line" style="font-size: 2rem;"></i>
                    <p class="mb-0 mt-2">No package data available</p>
                </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Top Affiliates</h5>
            </div>
            <div class="card-body">
                @php
                    $topAffiliates = \App\Models\User::where('role', 'affiliate')
                        ->withSum(['bookings' => function($query) {
                            $query->where('status', 'confirmed');
                        }], 'total_amount')
                        ->orderByDesc('bookings_sum_total_amount')
                        ->limit(5)
                        ->get();
                @endphp

                @foreach($topAffiliates as $affiliate)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="mb-0">{{ $affiliate->name }}</h6>
                        <small class="text-muted">{{ $affiliate->bookings()->where('booking_status', 'confirmed')->count() }} bookings</small>
                    </div>
                    <div class="text-end">
                        <strong>IDR {{ number_format($affiliate->bookings_sum_total_amount ?? 0, 0, ',', '.') }}</strong>
                    </div>
                </div>
                @if(!$loop->last)<hr>@endif
                @endforeach

                @if($topAffiliates->isEmpty())
                <div class="text-center text-muted py-3">
                    <i class="ri-user-line" style="font-size: 2rem;"></i>
                    <p class="mb-0 mt-2">No affiliate data available</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Initialize chart
const ctx = document.getElementById('trendChart').getContext('2d');
let currentChart;

// Chart data (you can fetch this from backend)
const chartData = {
    revenue: {
        labels: @json(collect(range(5, 0))->map(function($i) {
            return \Carbon\Carbon::now()->subMonths($i)->format('M Y');
        })->values()),
        data: @json(collect(range(5, 0))->map(function($i) {
            $month = \Carbon\Carbon::now()->subMonths($i);
            return \App\Models\Booking::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->where('status', 'confirmed')
                ->sum('total_amount');
        })->values())
    },
    bookings: {
        labels: @json(collect(range(5, 0))->map(function($i) {
            return \Carbon\Carbon::now()->subMonths($i)->format('M Y');
        })->values()),
        data: @json(collect(range(5, 0))->map(function($i) {
            $month = \Carbon\Carbon::now()->subMonths($i);
            return \App\Models\Booking::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->where('status', 'confirmed')
                ->count();
        })->values())
    }
};

function updateChart(type) {
    if (currentChart) {
        currentChart.destroy();
    }

    const data = chartData[type];

    currentChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.labels,
            datasets: [{
                label: type === 'revenue' ? 'Revenue (IDR)' : 'Number of Bookings',
                data: data.data,
                borderColor: type === 'revenue' ? '#0d6efd' : '#198754',
                backgroundColor: type === 'revenue' ? 'rgba(13, 110, 253, 0.1)' : 'rgba(25, 135, 84, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return type === 'revenue' ?
                                'IDR ' + new Intl.NumberFormat('id-ID').format(value) :
                                value;
                        }
                    }
                }
            }
        }
    });
}

// Initialize with revenue chart
updateChart('revenue');
</script>
@endpush
