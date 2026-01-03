@extends('layouts.admin')

@section('title', 'Tag Details')

@section('content')
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h4 class="page-title mb-1">Tag Details</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.tags.index') }}">Tags</a></li>
                <li class="breadcrumb-item active">{{ $tag->name }}</li>
            </ol>
        </div>
        <div class="col-md-4">
            <div class="float-end">
                <a href="{{ route('admin.tags.edit', $tag) }}" class="btn btn-warning">
                    <i class="ri-edit-line me-1"></i> Edit
                </a>
                <button type="button" class="btn btn-danger" onclick="deleteTag()">
                    <i class="ri-delete-bin-line me-1"></i> Delete
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Tag Information</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <span class="badge" style="font-size: 1.5rem; padding: 0.8rem 1.5rem; background-color: {{ $tag->color }};">
                        @if($tag->icon)
                            <span style="margin-right: 8px;">{{ $tag->icon }}</span>
                        @endif
                        {{ $tag->name }}
                    </span>
                </div>

                <div class="mb-3">
                    <label class="text-muted">Type</label>
                    @switch($tag->type)
                        @case('destination')
                            <p><span class="badge bg-primary">Destination</span></p>
                            @break
                        @case('activity')
                            <p><span class="badge bg-info">Activity</span></p>
                            @break
                        @case('theme')
                            <p><span class="badge bg-warning">Theme</span></p>
                            @break
                        @case('duration')
                            <p><span class="badge bg-secondary">Duration</span></p>
                            @break
                    @endswitch
                </div>

                <div class="mb-3">
                    <label class="text-muted">Description</label>
                    <p>{{ $tag->description ?: 'No description provided' }}</p>
                </div>

                <div class="mb-3">
                    <label class="text-muted">Color</label>
                    <p>
                        <span class="badge badge-sm" style="background-color: {{ $tag->color }}">
                            {{ $tag->color }}
                        </span>
                    </p>
                </div>

                <div class="mb-3">
                    <label class="text-muted">Sort Order</label>
                    <p>{{ $tag->sort_order }}</p>
                </div>

                <div class="mb-3">
                    <label class="text-muted">Status</label>
                    <p>
                        @if($tag->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </p>
                </div>

                <hr>

                <div class="mb-2">
                    <small class="text-muted">Created At</small>
                    <p class="mb-0">{{ $tag->created_at->format('d M Y H:i') }}</p>
                </div>
                <div>
                    <small class="text-muted">Last Updated</small>
                    <p class="mb-0">{{ $tag->updated_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Statistics</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <h3 class="text-primary">{{ $tag->packages()->count() }}</h3>
                        <small class="text-muted">Total Packages</small>
                    </div>
                    <div class="col-6">
                        <h3 class="text-success">{{ $tag->packages()->where('status', 'active')->count() }}</h3>
                        <small class="text-muted">Active Packages</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="card-title mb-0">Packages Using This Tag ({{ $packages->total() }})</h5>
                    </div>
                    <div class="col-auto">
                        <form method="GET" class="d-flex gap-2">
                            <input type="text" 
                                   name="search" 
                                   class="form-control form-control-sm" 
                                   placeholder="Search packages..." 
                                   value="{{ request('search') }}"
                                   style="max-width: 200px;">
                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                <i class="ri-search-line"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($packages->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Package</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Duration</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($packages as $package)
                                <tr>
                                    <td>
                                        <h6 class="mb-0">{{ $package->title }}</h6>
                                        <small class="text-muted">{{ Str::limit($package->description, 60) }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $package->category->name }}</span>
                                    </td>
                                    <td>Rp {{ number_format($package->price) }}</td>
                                    <td>{{ $package->duration }}</td>
                                    <td>
                                        @if($package->status === 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($package->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('landing.package', $package) }}" 
                                               class="btn btn-sm btn-outline-info"
                                               target="_blank"
                                               title="View">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="{{ route('admin.packages.edit', $package) }}" 
                                               class="btn btn-sm btn-outline-warning"
                                               title="Edit">
                                                <i class="ri-edit-line"></i>
                                            </a>
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
                    <div class="text-center py-5">
                        <i class="ri-box-3-line" style="font-size: 4rem; color: #ccc;"></i>
                        <h5 class="text-muted mt-3">No packages found</h5>
                        <p class="text-muted">This tag is not assigned to any packages yet.</p>
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
                <p>Are you sure you want to delete the tag <strong>{{ $tag->name }}</strong>?</p>
                @if($tag->packages()->count() > 0)
                    <div class="alert alert-warning">
                        <i class="ri-alert-line me-2"></i>
                        This tag is currently assigned to <strong>{{ $tag->packages()->count() }}</strong> package(s). 
                        Deleting it will remove the tag from all these packages.
                    </div>
                @endif
                <p class="text-muted mb-0">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Tag</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function deleteTag() {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
@endpush
