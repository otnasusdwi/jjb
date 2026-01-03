@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Admin Dashboard</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">Total Affiliates</p>
                            <h4 class="mb-2">{{ $stats['total_affiliates'] }}</h4>
                            <p class="text-muted mb-0">
                                <span class="text-success fw-bold font-size-12 me-2">
                                    <i class="ri-arrow-right-up-line me-1 align-middle"></i>
                                    {{ $stats['active_affiliates'] }} Active
                                </span>
                            </p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-primary rounded-3">
                                <i class="ri-group-line font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">Total Bookings</p>
                            <h4 class="mb-2">{{ $stats['total_bookings'] }}</h4>
                            <p class="text-muted mb-0">
                                <span class="text-info fw-bold font-size-12 me-2">
                                    <i class="ri-calendar-check-line me-1 align-middle"></i>
                                    {{ $stats['todays_bookings'] }} Today
                                </span>
                            </p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-info rounded-3">
                                <i class="ri-calendar-line font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">Total Revenue</p>
                            <h4 class="mb-2">IDR {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h4>
                            <p class="text-muted mb-0">
                                <span class="text-warning fw-bold font-size-12 me-2">
                                    <i class="ri-time-line me-1 align-middle"></i>
                                    {{ $stats['pending_bookings'] }} Pending
                                </span>
                            </p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-success rounded-3">
                                <i class="ri-money-dollar-circle-line font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">Travel Packages</p>
                            <h4 class="mb-2">{{ $stats['total_packages'] }}</h4>
                            <p class="text-muted mb-0">
                                <span class="text-success fw-bold font-size-12 me-2">
                                    <i class="ri-check-double-line me-1 align-middle"></i>
                                    {{ $stats['active_packages'] }} Active
                                </span>
                            </p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-warning rounded-3">
                                <i class="ri-gift-line font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Bookings -->
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Recent Bookings</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Booking Code</th>
                                    <th>Customer</th>
                                    <th>Package</th>
                                    <th>Affiliate</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_bookings as $booking)
                                <tr>
                                    <td>
                                        <span class="fw-medium">{{ $booking->booking_code }}</span>
                                    </td>
                                    <td>{{ $booking->customer_name }}</td>
                                    <td>{{ $booking->package->name ?? 'N/A' }}</td>
                                    <td>{{ $booking->affiliate->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge {{ $booking->status_badge_class }}">
                                            {{ ucfirst($booking->booking_status) }}
                                        </span>
                                    </td>
                                    <td>{{ $booking->formatted_total_amount }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No bookings found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Affiliates -->
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Pending Affiliates</h4>
                </div>
                <div class="card-body">
                    @forelse($pending_affiliates as $affiliate)
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-xs me-3">
                            <span class="avatar-title rounded-circle bg-primary-subtle text-primary">
                                {{ substr($affiliate->name, 0, 1) }}
                            </span>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="font-size-14 mb-1">{{ $affiliate->name }}</h5>
                            <p class="text-muted mb-0">{{ $affiliate->email }}</p>
                        </div>
                        <div class="flex-shrink-0">
                            <form action="{{ route('admin.affiliates.approve', $affiliate) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Approve</button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted mb-0">No pending affiliates</p>
                    @endforelse

                    @if($pending_affiliates->count() > 0)
                    <div class="mt-3 text-center">
                        <a href="{{ route('admin.affiliates.pending') }}" class="btn btn-primary btn-sm">View All</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
