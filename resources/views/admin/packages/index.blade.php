@extends('layouts.admin')

@section('title', 'Packages')

@section('content')
<div class="page-title-box mb-4">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h4 class="page-title mb-1">Packages</h4>
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Packages</li>
            </ol>
        </div>
        <div class="col-md-4">
            <div class="float-end">
                <a href="{{ route('admin.packages.create') }}" class="btn btn-primary">
                    <i class="ri-add-line me-1"></i> Add Package
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="card-title mb-0">Package List</h5>
                        <small class="text-muted">Manage your travel packages</small>
                    </div>
                    <div class="col-md-6">
                        <form method="GET" class="d-flex gap-2">
                            <select name="status" class="form-select" style="max-width: 150px;">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                            <input type="text" name="search" class="form-control"
                                   placeholder="Search packages..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="ri-search-line"></i>
                            </button>
                            @if(request('search') || request('status'))
                            <a href="{{ route('admin.packages.index') }}" class="btn btn-outline-secondary">
                                <i class="ri-close-line"></i>
                            </a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($packages->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Package</th>
                                    <th>Category</th>
                                    <th>Duration</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($packages as $package)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($package->main_image)
                                                <img src="{{ Storage::url($package->main_image) }}"
                                                     alt="{{ $package->name }}"
                                                     class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center"
                                                     style="width: 50px; height: 50px;">
                                                    <i class="ri-image-line text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-0">{{ $package->name }}</h6>
                                                <small class="text-muted">{{ Str::limit($package->short_description, 50) }}</small>
                                                @if($package->tags && $package->tags->count() > 0)
                                                <div class="mt-1">
                                                    @foreach($package->tags->take(3) as $tag)
                                                        <span class="badge badge-sm" style="background-color: {{ $tag->color }}; font-size: 0.7rem;">
                                                            {{ $tag->icon }} {{ $tag->name }}
                                                        </span>
                                                    @endforeach
                                                    @if($package->tags->count() > 3)
                                                        <span class="badge bg-secondary badge-sm" style="font-size: 0.7rem;">+{{ $package->tags->count() - 3 }}</span>
                                                    @endif
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {{-- @if($package->category)
                                            <span class="badge bg-info">{{ $package->category->name }}</span>
                                        @else
                                            <span class="text-muted">No Category</span>
                                        @endif --}}
                                    </td>
                                    <td>
                                        {{ $package->duration_days }}D {{ $package->duration_nights }}N
                                    </td>
                                    <td>
                                        <strong>IDR {{ number_format($package->adult_price, 0, ',', '.') }}</strong>
                                        @if($package->child_price)
                                            <br><small class="text-muted">Child: IDR {{ number_format($package->child_price, 0, ',', '.') }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @switch($package->status)
                                            @case('active')
                                                <span class="badge bg-success">Active</span>
                                                @break
                                            @case('inactive')
                                                <span class="badge bg-secondary">Inactive</span>
                                                @break
                                            @case('draft')
                                                <span class="badge bg-warning">Draft</span>
                                                @break
                                            @case('archived')
                                                <span class="badge bg-dark">Archived</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.packages.show', $package) }}"
                                               class="btn btn-sm btn-outline-info">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="{{ route('admin.packages.edit', $package) }}"
                                               class="btn btn-sm btn-outline-warning">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                    onclick="deletePackage({{ $package->id }})">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            Showing {{ $packages->firstItem() }} to {{ $packages->lastItem() }} of {{ $packages->total() }} results
                        </div>
                        <div>
                            {{ $packages->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="ri-gift-line" style="font-size: 3rem; color: #ccc;"></i>
                        <h5 class="text-muted mt-2">No packages found</h5>
                        <p class="text-muted">Create your first travel package to get started.</p>
                        <a href="{{ route('admin.packages.create') }}" class="btn btn-primary">
                            <i class="ri-add-line me-1"></i> Add Package
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this package? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function deletePackage(packageId) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const form = document.getElementById('deleteForm');
    form.action = `/admin/packages/${packageId}`;
    modal.show();
}
</script>
@endpush
