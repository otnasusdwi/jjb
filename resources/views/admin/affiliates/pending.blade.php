@extends('layouts.admin')

@section('title', 'Pending Affiliates')
@section('page-title', 'Pending Affiliates')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">Pending Affiliate Applications</h4>
                    <p class="text-muted mb-0">Review and approve affiliate registrations</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.affiliates.index') }}" class="btn btn-outline-primary">
                        <i class="ri-arrow-left-line me-1"></i>Back to All Affiliates
                    </a>
                    <button type="button" class="btn btn-success" onclick="bulkApprove()">
                        <i class="ri-check-double-line me-1"></i>Bulk Approve Selected
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card border-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm bg-warning rounded me-3">
                            <i class="ri-time-line text-white fs-5"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Pending</h6>
                            <h3 class="mb-0 text-warning">{{ $pending_affiliates->total() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-info">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm bg-info rounded me-3">
                            <i class="ri-calendar-today-line text-white fs-5"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Today's Applications</h6>
                            <h3 class="mb-0 text-info">
                                {{ \App\Models\User::affiliates()->where('status', 'pending')->whereDate('created_at', today())->count() }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm bg-success rounded me-3">
                            <i class="ri-check-line text-white fs-5"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">This Week Approved</h6>
                            <h3 class="mb-0 text-success">
                                {{ \App\Models\User::affiliates()->where('status', 'active')->whereBetween('approved_at', [now()->startOfWeek(), now()->endOfWeek()])->count() }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm bg-primary rounded me-3">
                            <i class="ri-user-add-line text-white fs-5"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Approved</h6>
                            <h3 class="mb-0 text-primary">
                                {{ \App\Models\User::affiliates()->where('status', 'active')->count() }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Affiliates Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title mb-0">Pending Applications</h5>
                        </div>
                        <div class="col-auto">
                            <div class="d-flex gap-2">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                    <label class="form-check-label" for="selectAll">Select All</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($pending_affiliates->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">
                                            <input type="checkbox" class="form-check-input" id="selectAllTable">
                                        </th>
                                        <th>Applicant</th>
                                        <th>Contact Info</th>
                                        <th>Applied Date</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                        <th width="150">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pending_affiliates as $affiliate)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="form-check-input affiliate-checkbox"
                                                       value="{{ $affiliate->id }}">
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-3">
                                                        @if($affiliate->avatar)
                                                            <img src="{{ Storage::url($affiliate->avatar) }}"
                                                                 alt="{{ $affiliate->name }}"
                                                                 class="rounded-circle" width="40" height="40">
                                                        @else
                                                            <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center">
                                                                <span class="text-white fw-bold">
                                                                    {{ substr($affiliate->name, 0, 1) }}
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $affiliate->name }}</h6>
                                                        <small class="text-muted">{{ $affiliate->email }}</small>
                                                        @if($affiliate->affiliate_code)
                                                            <br><small class="badge bg-light text-dark">{{ $affiliate->affiliate_code }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    @if($affiliate->phone)
                                                        <div class="mb-1">
                                                            <i class="ri-phone-line me-1"></i>{{ $affiliate->phone }}
                                                        </div>
                                                    @endif
                                                    @if($affiliate->whatsapp)
                                                        <div>
                                                            <i class="ri-whatsapp-line me-1 text-success"></i>{{ $affiliate->whatsapp }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <div class="fw-medium">{{ $affiliate->created_at->format('M d, Y') }}</div>
                                                    <small class="text-muted">{{ $affiliate->created_at->diffForHumans() }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    @if($affiliate->city)
                                                        <div>{{ $affiliate->city }}</div>
                                                    @endif
                                                    @if($affiliate->country)
                                                        <small class="text-muted">{{ $affiliate->country }}</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-warning-subtle text-warning">
                                                    <i class="ri-time-line me-1"></i>Pending Review
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                                            onclick="viewAffiliate({{ $affiliate->id }})"
                                                            title="View Details">
                                                        <i class="ri-eye-line"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-success"
                                                            onclick="approveAffiliate({{ $affiliate->id }})"
                                                            title="Approve">
                                                        <i class="ri-check-line"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                            onclick="rejectAffiliate({{ $affiliate->id }})"
                                                            title="Reject">
                                                        <i class="ri-close-line"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="card-footer border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Showing {{ $pending_affiliates->firstItem() }} to {{ $pending_affiliates->lastItem() }}
                                    of {{ $pending_affiliates->total() }} results
                                </div>
                                {{ $pending_affiliates->links() }}
                            </div>
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-5">
                            <div class="avatar-lg mx-auto mb-4">
                                <div class="avatar-lg bg-light rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="ri-user-check-line text-muted" style="font-size: 2rem;"></i>
                                </div>
                            </div>
                            <h5 class="mb-1">No Pending Applications</h5>
                            <p class="text-muted mb-4">All affiliate applications have been reviewed.</p>
                            <a href="{{ route('admin.affiliates.index') }}" class="btn btn-primary">
                                <i class="ri-arrow-left-line me-1"></i>Back to All Affiliates
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View Details Modal -->
<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Affiliate Application Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalContent">
                <!-- Content loaded via JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="modalApproveBtn">
                    <i class="ri-check-line me-1"></i>Approve
                </button>
                <button type="button" class="btn btn-danger" id="modalRejectBtn">
                    <i class="ri-close-line me-1"></i>Reject
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Select all functionality
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.affiliate-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    document.getElementById('selectAllTable').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.affiliate-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        document.getElementById('selectAll').checked = this.checked;
    });

    // Individual checkbox change
    document.querySelectorAll('.affiliate-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allCheckboxes = document.querySelectorAll('.affiliate-checkbox');
            const checkedCheckboxes = document.querySelectorAll('.affiliate-checkbox:checked');

            document.getElementById('selectAll').checked = allCheckboxes.length === checkedCheckboxes.length;
            document.getElementById('selectAllTable').checked = allCheckboxes.length === checkedCheckboxes.length;
        });
    });

    // View affiliate details
    function viewAffiliate(id) {
        fetch(`/admin/affiliates/${id}`)
            .then(response => response.text())
            .then(html => {
                // Extract content from the response
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const content = doc.querySelector('.container-fluid').innerHTML;

                document.getElementById('modalContent').innerHTML = content;

                // Update modal buttons
                document.getElementById('modalApproveBtn').onclick = () => approveAffiliate(id);
                document.getElementById('modalRejectBtn').onclick = () => rejectAffiliate(id);

                new bootstrap.Modal(document.getElementById('viewModal')).show();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load affiliate details');
            });
    }

    // Approve affiliate
    function approveAffiliate(id) {
        if (confirm('Are you sure you want to approve this affiliate?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/affiliates/${id}/approve`;

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            form.appendChild(csrfToken);
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Reject affiliate
    function rejectAffiliate(id) {
        const reason = prompt('Please provide a reason for rejection:');
        if (reason) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/affiliates/${id}/suspend`;

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const reasonInput = document.createElement('input');
            reasonInput.type = 'hidden';
            reasonInput.name = 'reason';
            reasonInput.value = reason;

            form.appendChild(csrfToken);
            form.appendChild(reasonInput);
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Bulk approve
    function bulkApprove() {
        const checkedBoxes = document.querySelectorAll('.affiliate-checkbox:checked');

        if (checkedBoxes.length === 0) {
            alert('Please select at least one affiliate to approve.');
            return;
        }

        if (confirm(`Are you sure you want to approve ${checkedBoxes.length} affiliate(s)?`)) {
            const ids = Array.from(checkedBoxes).map(cb => cb.value);

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.affiliates.bulk-action") }}';

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            actionInput.value = 'approve';

            const idsInput = document.createElement('input');
            idsInput.type = 'hidden';
            idsInput.name = 'affiliate_ids';
            idsInput.value = JSON.stringify(ids);

            form.appendChild(csrfToken);
            form.appendChild(actionInput);
            form.appendChild(idsInput);
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endpush
