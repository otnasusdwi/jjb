@extends('layouts.admin')

@section('title', 'Manage Affiliates')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Affiliates Management</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Affiliates</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <h4 class="mb-1">{{ $stats['total_affiliates'] ?? 0 }}</h4>
                            <h6 class="text-muted fw-normal">Total Affiliates</h6>
                        </div>
                        <div class="ms-2">
                            <div class="stat-icon">
                                <i class="ri-team-line fs-22 text-success"></i>
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
                            <h4 class="mb-1">{{ $stats['active_affiliates'] ?? 0 }}</h4>
                            <h6 class="text-muted fw-normal">Active Affiliates</h6>
                        </div>
                        <div class="ms-2">
                            <div class="stat-icon">
                                <i class="ri-user-check-line fs-22 text-info"></i>
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
                            <h4 class="mb-1">{{ $stats['pending_affiliates'] ?? 0 }}</h4>
                            <h6 class="text-muted fw-normal">Pending Approval</h6>
                        </div>
                        <div class="ms-2">
                            <div class="stat-icon">
                                <i class="ri-user-settings-line fs-22 text-warning"></i>
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
                            <h4 class="mb-1">{{ $stats['total_commissions'] ?? 'IDR 0' }}</h4>
                            <h6 class="text-muted fw-normal">Total Commissions</h6>
                        </div>
                        <div class="ms-2">
                            <div class="stat-icon">
                                <i class="ri-money-dollar-circle-line fs-22 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title mb-0">Affiliate List</h5>
                        </div>
                        <div class="col-auto">
                            <div class="d-flex gap-2">
                                <div class="search-box">
                                    <form method="GET" action="{{ route('admin.affiliates.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="search"
                                                   placeholder="Search affiliates..."
                                                   value="{{ request('search') }}">
                                            <button class="btn btn-outline-secondary" type="submit">
                                                <i class="ri-search-line"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown">
                                        <i class="ri-filter-2-line"></i> Filter
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('admin.affiliates.index') }}">All Status</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.affiliates.index', ['status' => 'active']) }}">Active</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.affiliates.index', ['status' => 'pending']) }}">Pending</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.affiliates.index', ['status' => 'inactive']) }}">Inactive</a></li>
                                    </ul>
                                </div>
                                <a href="{{ route('admin.affiliates.create') }}" class="btn btn-success">
                                    <i class="ri-add-line"></i> Add Affiliate
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll">
                                        </div>
                                    </th>
                                    <th scope="col">Affiliate</th>
                                    <th scope="col">Contact</th>
                                    <th scope="col">Commission Rate</th>
                                    <th scope="col">Total Bookings</th>
                                    <th scope="col">Total Earnings</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Joined Date</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($affiliates as $affiliate)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="affiliate_ids[]"
                                                   value="{{ $affiliate->id }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xs me-3">
                                                @if($affiliate->avatar)
                                                    <img src="{{ Storage::url($affiliate->avatar) }}" alt=""
                                                         class="avatar-title rounded-circle">
                                                @else
                                                    <div class="avatar-title rounded-circle bg-soft-primary text-primary">
                                                        {{ substr($affiliate->name, 0, 2) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $affiliate->name }}</h6>
                                                <small class="text-muted">{{ $affiliate->affiliate_code ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <div>{{ $affiliate->email }}</div>
                                            <small class="text-muted">{{ $affiliate->phone ?? 'No phone' }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-soft-info text-info">
                                            {{ $affiliate->commission_rate ?? 10 }}%
                                        </span>
                                    </td>
                                    <td>
                                        <span class="fw-medium">{{ $affiliate->bookings_count ?? 0 }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-medium">{{ $affiliate->formatted_total_earnings ?? 'IDR 0' }}</span>
                                    </td>
                                    <td>
                                        @switch($affiliate->status ?? 'pending')
                                            @case('active')
                                                <span class="badge bg-success">Active</span>
                                                @break
                                            @case('pending')
                                                <span class="badge bg-warning">Pending</span>
                                                @break
                                            @case('inactive')
                                                <span class="badge bg-danger">Inactive</span>
                                                @break
                                            @case('suspended')
                                                <span class="badge bg-dark">Suspended</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>{{ $affiliate->created_at->format('d M Y') }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown">
                                                <i class="ri-more-fill"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.affiliates.show', $affiliate) }}">
                                                        <i class="ri-eye-line me-2"></i>View Details
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.affiliates.edit', $affiliate) }}">
                                                        <i class="ri-edit-line me-2"></i>Edit
                                                    </a>
                                                </li>
                                                @if(($affiliate->status ?? 'pending') === 'pending')
                                                <li>
                                                    <a class="dropdown-item text-success"
                                                       href="{{ route('admin.affiliates.approve', $affiliate) }}"
                                                       onclick="event.preventDefault(); document.getElementById('approve-form-{{ $affiliate->id }}').submit();">
                                                        <i class="ri-check-line me-2"></i>Approve
                                                    </a>
                                                </li>
                                                @endif
                                                @if(($affiliate->status ?? 'pending') !== 'inactive')
                                                <li>
                                                    <a class="dropdown-item text-warning"
                                                       href="{{ route('admin.affiliates.suspend', $affiliate) }}"
                                                       onclick="event.preventDefault(); document.getElementById('suspend-form-{{ $affiliate->id }}').submit();">
                                                        <i class="ri-pause-line me-2"></i>Suspend
                                                    </a>
                                                </li>
                                                @endif
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a class="dropdown-item text-danger" href="#"
                                                       onclick="event.preventDefault(); document.getElementById('delete-form-{{ $affiliate->id }}').submit();">
                                                        <i class="ri-delete-bin-line me-2"></i>Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                        <!-- Hidden Forms -->
                                        <form id="approve-form-{{ $affiliate->id }}"
                                              action="{{ route('admin.affiliates.approve', $affiliate) }}"
                                              method="POST" class="d-none">
                                            @csrf
                                            @method('PATCH')
                                        </form>

                                        <form id="suspend-form-{{ $affiliate->id }}"
                                              action="{{ route('admin.affiliates.suspend', $affiliate) }}"
                                              method="POST" class="d-none">
                                            @csrf
                                            @method('PATCH')
                                        </form>

                                        <form id="delete-form-{{ $affiliate->id }}"
                                              action="{{ route('admin.affiliates.destroy', $affiliate) }}"
                                              method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="ri-team-line fs-48 text-muted mb-3"></i>
                                            <h5 class="text-muted">No affiliates found</h5>
                                            <p class="text-muted">Start by adding your first affiliate partner</p>
                                            <a href="{{ route('admin.affiliates.create') }}" class="btn btn-primary">
                                                <i class="ri-add-line"></i> Add Affiliate
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($affiliates->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Showing {{ $affiliates->firstItem() }} to {{ $affiliates->lastItem() }}
                            of {{ $affiliates->total() }} results
                        </div>
                        {{ $affiliates->appends(request()->query())->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div class="row d-none" id="bulk-actions">
        <div class="col-12">
            <div class="card border-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-1">
                            <span class="fw-medium">
                                <span id="selected-count">0</span> affiliates selected
                            </span>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-success btn-sm" onclick="bulkApprove()">
                                <i class="ri-check-line"></i> Approve Selected
                            </button>
                            <button type="button" class="btn btn-warning btn-sm" onclick="bulkSuspend()">
                                <i class="ri-pause-line"></i> Suspend Selected
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="bulkDelete()">
                                <i class="ri-delete-bin-line"></i> Delete Selected
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Action Forms -->
<form id="bulk-action-form" method="POST" class="d-none">
    @csrf
    @method('PATCH')
    <input type="hidden" name="affiliate_ids" id="bulk-affiliate-ids">
    <input type="hidden" name="action" id="bulk-action">
</form>

@endsection

@push('scripts')
<script>
// Checkbox functionality
document.addEventListener('DOMContentLoaded', function() {
    const checkAll = document.getElementById('checkAll');
    const checkboxes = document.querySelectorAll('input[name="affiliate_ids[]"]');
    const bulkActions = document.getElementById('bulk-actions');
    const selectedCount = document.getElementById('selected-count');

    function updateBulkActions() {
        const checked = document.querySelectorAll('input[name="affiliate_ids[]"]:checked');
        if (checked.length > 0) {
            bulkActions.classList.remove('d-none');
            selectedCount.textContent = checked.length;
        } else {
            bulkActions.classList.add('d-none');
        }
        checkAll.indeterminate = checked.length > 0 && checked.length < checkboxes.length;
        checkAll.checked = checked.length === checkboxes.length;
    }

    checkAll.addEventListener('change', function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActions();
    });

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActions);
    });
});

// Bulk action functions
function bulkApprove() {
    if (confirm('Are you sure you want to approve selected affiliates?')) {
        executeBulkAction('approve');
    }
}

function bulkSuspend() {
    if (confirm('Are you sure you want to suspend selected affiliates?')) {
        executeBulkAction('suspend');
    }
}

function bulkDelete() {
    if (confirm('Are you sure you want to delete selected affiliates? This action cannot be undone.')) {
        executeBulkAction('delete');
    }
}

function executeBulkAction(action) {
    const checked = document.querySelectorAll('input[name="affiliate_ids[]"]:checked');
    const ids = Array.from(checked).map(cb => cb.value);

    if (ids.length === 0) return;

    const form = document.getElementById('bulk-action-form');
    const idsInput = document.getElementById('bulk-affiliate-ids');
    const actionInput = document.getElementById('bulk-action');

    idsInput.value = JSON.stringify(ids);
    actionInput.value = action;
    form.action = '{{ route("admin.affiliates.bulk-action") }}';
    form.submit();
}
</script>
@endpush
