@extends('layouts.admin')

@section('title', 'Payments')

@section('content')
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h4 class="page-title mb-1">Payments</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Payments</li>
            </ol>
        </div>
        <div class="col-md-4">
            <div class="float-end">
                <a href="{{ route('admin.payments.pending') }}" class="btn btn-warning">
                    <i class="ri-time-line me-1"></i> Pending Payments
                    @if(\App\Models\Payment::where('status', 'pending')->count() > 0)
                        <span class="badge bg-white text-warning ms-1">
                            {{ \App\Models\Payment::where('status', 'pending')->count() }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('admin.payments.commissions') }}" class="btn btn-info">
                    <i class="ri-money-dollar-circle-line me-1"></i> Commissions
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted mb-0">Total Payments</h6>
                        <h4 class="mt-1">IDR {{ number_format(\App\Models\Payment::where('status', 'verified')->sum('amount'), 0, ',', '.') }}</h4>
                    </div>
                    <div class="align-self-center">
                        <div class="icon-sm">
                            <i class="ri-money-dollar-circle-line text-success" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted mb-0">Pending Payments</h6>
                        <h4 class="mt-1">{{ \App\Models\Payment::where('status', 'pending')->count() }}</h4>
                    </div>
                    <div class="align-self-center">
                        <div class="icon-sm">
                            <i class="ri-time-line text-warning" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted mb-0">Commission Pending</h6>
                        <h4 class="mt-1">IDR {{ number_format(\App\Models\Commission::where('status', 'pending')->sum('amount'), 0, ',', '.') }}</h4>
                    </div>
                    <div class="align-self-center">
                        <div class="icon-sm">
                            <i class="ri-hand-coin-line text-info" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted mb-0">Commission Paid</h6>
                        <h4 class="mt-1">IDR {{ number_format(\App\Models\Commission::where('status', 'paid')->sum('amount'), 0, ',', '.') }}</h4>
                    </div>
                    <div class="align-self-center">
                        <div class="icon-sm">
                            <i class="ri-check-double-line text-success" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
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
                        <h5 class="card-title mb-0">Payment List</h5>
                    </div>
                    <div class="col-md-6">
                        <form method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control me-2"
                                   placeholder="Search payments..." value="{{ request('search') }}">
                            <select name="status" class="form-select me-2">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="ri-search-line"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($payments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Payment ID</th>
                                    <th>Booking</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $payment)
                                <tr>
                                    <td>
                                        <strong>#{{ $payment->id }}</strong>
                                    </td>
                                    <td>
                                        <strong>{{ $payment->booking->booking_code }}</strong>
                                        <br><small class="text-muted">{{ $payment->booking->travelPackage->name }}</small>
                                    </td>
                                    <td>
                                        {{ $payment->booking->customer_name }}
                                        <br><small class="text-muted">{{ $payment->booking->customer_email }}</small>
                                    </td>
                                    <td>
                                        <strong>IDR {{ number_format($payment->amount, 0, ',', '.') }}</strong>
                                    </td>
                                    <td>
                                        @switch($payment->payment_method)
                                            @case('bank_transfer')
                                                <span class="badge bg-primary">Bank Transfer</span>
                                                @break
                                            @case('credit_card')
                                                <span class="badge bg-info">Credit Card</span>
                                                @break
                                            @case('e_wallet')
                                                <span class="badge bg-warning">E-Wallet</span>
                                                @break
                                            @case('cash')
                                                <span class="badge bg-success">Cash</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        @switch($payment->status)
                                            @case('pending')
                                                <span class="badge bg-warning">Pending</span>
                                                @break
                                            @case('verified')
                                                <span class="badge bg-success">Verified</span>
                                                @break
                                            @case('rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        {{ $payment->created_at->format('d M Y') }}
                                        <br><small class="text-muted">{{ $payment->created_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.payments.show', $payment) }}"
                                               class="btn btn-sm btn-outline-info">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            @if($payment->status === 'pending')
                                                <button type="button" class="btn btn-sm btn-outline-success"
                                                        onclick="verifyPayment({{ $payment->id }})">
                                                    <i class="ri-check-line"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="rejectPayment({{ $payment->id }})">
                                                    <i class="ri-close-line"></i>
                                                </button>
                                            @endif
                                            @if($payment->proof_of_payment)
                                                <a href="{{ route('admin.payments.download-proof', $payment) }}"
                                                   class="btn btn-sm btn-outline-secondary">
                                                    <i class="ri-download-line"></i>
                                                </a>
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
                            Showing {{ $payments->firstItem() }} to {{ $payments->lastItem() }} of {{ $payments->total() }} results
                        </div>
                        <div>
                            {{ $payments->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="ri-money-dollar-circle-line" style="font-size: 3rem; color: #ccc;"></i>
                        <h5 class="text-muted mt-2">No payments found</h5>
                        <p class="text-muted">Payments will appear here once customers make payments.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Verification Modal -->
<div class="modal fade" id="verificationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="verificationForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Verify Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Admin Notes (Optional)</label>
                        <textarea name="admin_notes" class="form-control" rows="3"
                                  placeholder="Add any verification notes..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Verify Payment</button>
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
                    <h5 class="modal-title">Reject Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Rejection Reason <span class="text-danger">*</span></label>
                        <textarea name="rejection_reason" class="form-control" rows="3"
                                  placeholder="Explain why this payment is being rejected..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function verifyPayment(paymentId) {
    const modal = new bootstrap.Modal(document.getElementById('verificationModal'));
    const form = document.getElementById('verificationForm');
    form.action = `/admin/payments/${paymentId}/verify`;
    modal.show();
}

function rejectPayment(paymentId) {
    const modal = new bootstrap.Modal(document.getElementById('rejectionModal'));
    const form = document.getElementById('rejectionForm');
    form.action = `/admin/payments/${paymentId}/reject`;
    modal.show();
}
</script>
@endpush
