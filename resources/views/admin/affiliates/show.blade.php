@extends('layouts.admin')

@section('title', 'Affiliate Details')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Affiliate Details</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.affiliates.index') }}">Affiliates</a></li>
                        <li class="breadcrumb-item active">{{ $affiliate->name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Profile Information -->
        <div class="col-lg-4">
            <!-- Profile Card -->
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar-xxl mx-auto mb-3">
                        @if($affiliate->avatar)
                            <img src="{{ Storage::url($affiliate->avatar) }}"
                                 class="img-fluid rounded-circle" alt="{{ $affiliate->name }}">
                        @else
                            <div class="avatar-title rounded-circle bg-soft-primary text-primary fs-24">
                                {{ substr($affiliate->name, 0, 2) }}
                            </div>
                        @endif
                    </div>
                    <h5 class="mb-1">{{ $affiliate->name }}</h5>
                    <p class="text-muted mb-3">{{ $affiliate->affiliate_code ?? 'No Code' }}</p>

                    <div class="mb-3">
                        @switch($affiliate->status ?? 'pending')
                            @case('active')
                                <span class="badge bg-success fs-12">Active</span>
                                @break
                            @case('pending')
                                <span class="badge bg-warning fs-12">Pending Approval</span>
                                @break
                            @case('inactive')
                                <span class="badge bg-danger fs-12">Inactive</span>
                                @break
                            @case('suspended')
                                <span class="badge bg-dark fs-12">Suspended</span>
                                @break
                        @endswitch
                    </div>

                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('admin.affiliates.edit', $affiliate) }}" class="btn btn-primary btn-sm">
                            <i class="ri-edit-line"></i> Edit
                        </a>
                        @if(($affiliate->status ?? 'pending') === 'pending')
                        <button type="button" class="btn btn-success btn-sm" onclick="approveAffiliate()">
                            <i class="ri-check-line"></i> Approve
                        </button>
                        @endif
                        <button type="button" class="btn btn-outline-info btn-sm" onclick="sendMessage()">
                            <i class="ri-mail-line"></i> Message
                        </button>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Contact Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted">Email</label>
                        <div class="d-flex align-items-center">
                            <span>{{ $affiliate->email }}</span>
                            @if($affiliate->email_verified_at)
                                <i class="ri-check-double-line text-success ms-2" title="Verified"></i>
                            @else
                                <i class="ri-error-warning-line text-warning ms-2" title="Not Verified"></i>
                            @endif
                        </div>
                    </div>

                    @if($affiliate->phone)
                    <div class="mb-3">
                        <label class="form-label text-muted">Phone</label>
                        <div>{{ $affiliate->phone }}</div>
                    </div>
                    @endif

                    @if($affiliate->whatsapp)
                    <div class="mb-3">
                        <label class="form-label text-muted">WhatsApp</label>
                        <div>
                            <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $affiliate->whatsapp) }}"
                               target="_blank" class="text-success">
                                {{ $affiliate->whatsapp }}
                                <i class="ri-external-link-line ms-1"></i>
                            </a>
                        </div>
                    </div>
                    @endif

                    @if($affiliate->address || $affiliate->city || $affiliate->country)
                    <div class="mb-3">
                        <label class="form-label text-muted">Address</label>
                        <div>
                            @if($affiliate->address)
                                {{ $affiliate->address }}<br>
                            @endif
                            @if($affiliate->city)
                                {{ $affiliate->city }}
                            @endif
                            @if($affiliate->city && $affiliate->country), @endif
                            @if($affiliate->country)
                                {{ $affiliate->country }}
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Account Information -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Account Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Commission Rate:</span>
                            <span class="fw-medium">{{ $affiliate->commission_rate ?? 10 }}%</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Member Since:</span>
                            <span class="fw-medium">{{ $affiliate->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Last Login:</span>
                            <span class="fw-medium">{{ $affiliate->last_login_at ? $affiliate->last_login_at->diffForHumans() : 'Never' }}</span>
                        </div>
                    </div>
                    @if($affiliate->approved_at)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Approved:</span>
                            <span class="fw-medium">{{ $affiliate->approved_at->format('d M Y') }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            @if($affiliate->bank_details)
            <!-- Bank Information -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Bank Details</h5>
                </div>
                <div class="card-body">
                    <div class="text-break">{{ $affiliate->bank_details }}</div>
                </div>
            </div>
            @endif
        </div>

        <!-- Performance & Activity -->
        <div class="col-lg-8">
            <!-- Performance Stats -->
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-1">
                                    <h4 class="mb-1">{{ $affiliate->bookings_count ?? 0 }}</h4>
                                    <h6 class="text-muted fw-normal">Total Bookings</h6>
                                </div>
                                <div class="ms-2">
                                    <div class="stat-icon">
                                        <i class="ri-calendar-check-line fs-22 text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-1">
                                    <h4 class="mb-1">{{ $affiliate->formatted_total_revenue ?? 'IDR 0' }}</h4>
                                    <h6 class="text-muted fw-normal">Total Revenue</h6>
                                </div>
                                <div class="ms-2">
                                    <div class="stat-icon">
                                        <i class="ri-money-dollar-circle-line fs-22 text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-1">
                                    <h4 class="mb-1">{{ $affiliate->formatted_total_commissions ?? 'IDR 0' }}</h4>
                                    <h6 class="text-muted fw-normal">Earned Commissions</h6>
                                </div>
                                <div class="ms-2">
                                    <div class="stat-icon">
                                        <i class="ri-hand-coin-line fs-22 text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-1">
                                    <h4 class="mb-1">{{ $affiliate->formatted_pending_commissions ?? 'IDR 0' }}</h4>
                                    <h6 class="text-muted fw-normal">Pending Payout</h6>
                                </div>
                                <div class="ms-2">
                                    <div class="stat-icon">
                                        <i class="ri-time-line fs-22 text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Bookings -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Recent Bookings</h5>
                    <a href="{{ route('admin.bookings.index', ['affiliate' => $affiliate->id]) }}"
                       class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Booking Code</th>
                                    <th>Package</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Commission</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($affiliate->recentBookings ?? [] as $booking)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.bookings.show', $booking) }}"
                                           class="text-primary fw-medium">{{ $booking->booking_code }}</a>
                                    </td>
                                    <td>{{ $booking->package->name ?? 'N/A' }}</td>
                                    <td>{{ $booking->customer_name }}</td>
                                    <td>{{ $booking->formatted_total_amount }}</td>
                                    <td>{{ $booking->formatted_commission_amount }}</td>
                                    <td>
                                        <span class="badge {{ $booking->status_badge_class }}">
                                            {{ ucfirst($booking->booking_status) }}
                                        </span>
                                    </td>
                                    <td>{{ $booking->created_at->format('d M Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="text-muted">No bookings yet</div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Commission History -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Commission History</h5>
                    <a href="{{ route('admin.payments.commissions.index', ['affiliate' => $affiliate->id]) }}"
                       class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Commission ID</th>
                                    <th>Booking</th>
                                    <th>Amount</th>
                                    <th>Rate</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($affiliate->recentCommissions ?? [] as $commission)
                                <tr>
                                    <td>COM-{{ $commission->id }}</td>
                                    <td>
                                        <a href="{{ route('admin.bookings.show', $commission->booking) }}"
                                           class="text-primary">{{ $commission->booking->booking_code }}</a>
                                    </td>
                                    <td>{{ $commission->formatted_amount }}</td>
                                    <td>{{ $commission->commission_rate }}%</td>
                                    <td>
                                        @switch($commission->status)
                                            @case('pending')
                                                <span class="badge bg-warning">Pending</span>
                                                @break
                                            @case('approved')
                                                <span class="badge bg-info">Approved</span>
                                                @break
                                            @case('paid')
                                                <span class="badge bg-success">Paid</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>{{ $commission->created_at->format('d M Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-muted">No commissions yet</div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if($affiliate->bio)
            <!-- Biography -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Biography</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $affiliate->bio }}</p>
                </div>
            </div>
            @endif

            @if($affiliate->admin_notes)
            <!-- Admin Notes -->
            <div class="card border-warning">
                <div class="card-header bg-soft-warning">
                    <h5 class="card-title mb-0 text-warning">
                        <i class="ri-lock-line me-2"></i>Admin Notes (Internal Only)
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $affiliate->admin_notes }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Hidden Forms -->
    <form id="approve-form" action="{{ route('admin.affiliates.approve', $affiliate) }}" method="POST" class="d-none">
        @csrf
        @method('PATCH')
    </form>
</div>

<!-- Send Message Modal -->
<div class="modal fade" id="messageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Send Message to {{ $affiliate->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.affiliates.send-message', $affiliate) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="6" required></textarea>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="send_email" name="send_email" value="1" checked>
                        <label class="form-check-label" for="send_email">
                            Send via email
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-send-plane-line"></i> Send Message
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Approve affiliate
function approveAffiliate() {
    if (confirm('Are you sure you want to approve this affiliate?')) {
        document.getElementById('approve-form').submit();
    }
}

// Send message
function sendMessage() {
    const modal = new bootstrap.Modal(document.getElementById('messageModal'));
    modal.show();
}
</script>
@endpush
