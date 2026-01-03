@extends('layouts.admin')

@section('title', 'Bookings')

@section('content')
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h4 class="page-title mb-1">Bookings</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Bookings</li>
            </ol>
        </div>
        <div class="col-md-4">
            <div class="float-end">
                <a href="{{ route('admin.bookings.pending') }}" class="btn btn-warning">
                    <i class="ri-time-line me-1"></i> Pending Bookings
                    @if(\App\Models\Booking::where('booking_status', 'pending')->count() > 0)
                        <span class="badge bg-white text-warning ms-1">
                            {{ \App\Models\Booking::where('booking_status', 'pending')->count() }}
                        </span>
                    @endif
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="card-title mb-0">All Bookings</h5>
                    </div>
                    <div class="col-md-6">
                        <form method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control me-2"
                                   placeholder="Search bookings..." value="{{ request('search') }}">
                            <select name="status" class="form-select me-2">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="ri-search-line"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($bookings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Booking Code</th>
                                    <th>Package</th>
                                    <th>Customer</th>
                                    <th>Departure</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                <tr>
                                    <td>
                                        <strong>{{ $booking->booking_code }}</strong>
                                        <br><small class="text-muted">{{ $booking->created_at->format('d M Y') }}</small>
                                    </td>
                                    <td>
                                        <h6 class="mb-0">{{ $booking->travelPackage->name }}</h6>
                                        <small class="text-muted">{{ $booking->travelPackage->duration_days }}D {{ $booking->travelPackage->duration_nights }}N</small>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $booking->customer_name }}</strong>
                                            <br><small class="text-muted">{{ $booking->customer_email }}</small>
                                            <br><small class="text-muted">{{ $booking->customer_phone }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        {{ Carbon\Carbon::parse($booking->departure_date)->format('d M Y') }}
                                        <br><small class="text-muted">{{ $booking->adult_count + $booking->child_count + $booking->infant_count }} pax</small>
                                    </td>
                                    <td>
                                        <strong>IDR {{ number_format($booking->total_amount, 0, ',', '.') }}</strong>
                                        @if($booking->affiliate)
                                            <br><small class="text-info">via {{ $booking->affiliate->name }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @switch($booking->booking_status)
                                            @case('pending')
                                                <span class="badge bg-warning">Pending</span>
                                                @break
                                            @case('confirmed')
                                                <span class="badge bg-success">Confirmed</span>
                                                @break
                                            @case('completed')
                                                <span class="badge bg-info">Completed</span>
                                                @break
                                            @case('cancelled')
                                                <span class="badge bg-danger">Cancelled</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        @switch($booking->payment_status)
                                            @case('pending')
                                                <span class="badge bg-secondary">Pending</span>
                                                @break
                                            @case('down_payment')
                                                <span class="badge bg-warning">Down Payment</span>
                                                @break
                                            @case('paid')
                                                <span class="badge bg-success">Paid</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.bookings.show', $booking) }}"
                                               class="btn btn-sm btn-outline-info">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            @if($booking->booking_status === 'pending')
                                                <button type="button" class="btn btn-sm btn-outline-success"
                                                        onclick="approveBooking({{ $booking->id }})">
                                                    <i class="ri-check-line"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="rejectBooking({{ $booking->id }})">
                                                    <i class="ri-close-line"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            Showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }} of {{ $bookings->total() }} results
                        </div>
                        <div>
                            {{ $bookings->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="ri-calendar-line" style="font-size: 3rem; color: #ccc;"></i>
                        <h5 class="text-muted mt-2">No bookings found</h5>
                        <p class="text-muted">Bookings will appear here once customers start booking packages.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Approval Modal -->
<div class="modal fade" id="approvalModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="approvalForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Approve Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Admin Notes (Optional)</label>
                        <textarea name="admin_notes" class="form-control" rows="3"
                                  placeholder="Add any notes about this approval..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Approve Booking</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Rejection Modal -->
<div class="modal fade" id="rejectionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="rejectionForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Reject Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Rejection Reason <span class="text-danger">*</span></label>
                        <textarea name="rejection_reason" class="form-control" rows="3"
                                  placeholder="Explain why this booking is being rejected..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Booking</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function approveBooking(bookingId) {
    const modal = new bootstrap.Modal(document.getElementById('approvalModal'));
    const form = document.getElementById('approvalForm');
    form.action = `/admin/bookings/${bookingId}/approve`;
    modal.show();
}

function rejectBooking(bookingId) {
    const modal = new bootstrap.Modal(document.getElementById('rejectionModal'));
    const form = document.getElementById('rejectionForm');
    form.action = `/admin/bookings/${bookingId}/reject`;
    modal.show();
}
</script>
@endpush
