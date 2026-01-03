@extends('layouts.admin')

@section('title', 'Tags Management')

@section('content')
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h4 class="page-title mb-1">Tags Management</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Tags</li>
            </ol>
        </div>
        <div class="col-md-4">
            <div class="float-end">
                <a href="{{ route('admin.tags.create') }}" class="btn btn-primary">
                    <i class="ri-add-line me-1"></i> Add Tag
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
                    <div class="col-md-4">
                        <h5 class="card-title mb-0">Tags List</h5>
                    </div>
                    <div class="col-md-8">
                        <form method="GET" class="d-flex gap-2">
                            <select name="type" class="form-select" style="max-width: 200px;">
                                <option value="">All Types</option>
                                <option value="destination" {{ request('type') === 'destination' ? 'selected' : '' }}>Destination</option>
                                <option value="activity" {{ request('type') === 'activity' ? 'selected' : '' }}>Activity</option>
                                <option value="theme" {{ request('type') === 'theme' ? 'selected' : '' }}>Theme</option>
                                <option value="duration" {{ request('type') === 'duration' ? 'selected' : '' }}>Duration</option>
                            </select>
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Search tags..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="ri-search-line"></i>
                            </button>
                            @if(request('search') || request('type'))
                            <a href="{{ route('admin.tags.index') }}" class="btn btn-outline-secondary">
                                <i class="ri-close-line"></i>
                            </a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($tags->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Tag</th>
                                    <th>Type</th>
                                    <th>Packages</th>
                                    <th>Sort Order</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tags as $tag)
                                <tr>
                                    <td>
                                        <div>
                                            <h6 class="mb-0">{{ $tag->name }}</h6>
                                            <small class="text-muted">{{ Str::limit($tag->description, 50) }}</small>
                                            <br>
                                            <span class="badge badge-sm mt-1" style="background-color: {{ $tag->color }}">
                                                {{ $tag->color }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        @switch($tag->type)
                                            @case('destination')
                                                <span class="badge bg-primary">Destination</span>
                                                @break
                                            @case('activity')
                                                <span class="badge bg-info">Activity</span>
                                                @break
                                            @case('theme')
                                                <span class="badge bg-warning">Theme</span>
                                                @break
                                            @case('duration')
                                                <span class="badge bg-secondary">Duration</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            {{ $tag->packages()->count() }} packages
                                        </span>
                                    </td>
                                    <td>{{ $tag->sort_order }}</td>
                                    <td>
                                        <form action="{{ route('admin.tags.toggle-status', $tag) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm {{ $tag->is_active ? 'btn-success' : 'btn-secondary' }}">
                                                @if($tag->is_active)
                                                    <i class="ri-check-line"></i> Active
                                                @else
                                                    <i class="ri-close-line"></i> Inactive
                                                @endif
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.tags.show', $tag) }}"
                                               class="btn btn-sm btn-outline-info"
                                               title="View">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="{{ route('admin.tags.edit', $tag) }}"
                                               class="btn btn-sm btn-outline-warning"
                                               title="Edit">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="deleteTag({{ $tag->id }})"
                                                    title="Delete">
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
                            Showing {{ $tags->firstItem() }} to {{ $tags->lastItem() }} of {{ $tags->total() }} results
                        </div>
                        <div>
                            {{ $tags->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="ri-price-tag-3-line" style="font-size: 4rem; color: #ccc;"></i>
                        <h5 class="text-muted mt-3">No tags found</h5>
                        <p class="text-muted">Create your first tag or run seeder to get started.</p>
                        <a href="{{ route('admin.tags.create') }}" class="btn btn-primary">
                            <i class="ri-add-line me-1"></i> Add Tag
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
                Are you sure you want to delete this tag? This action cannot be undone.
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
function deleteTag(tagId) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const form = document.getElementById('deleteForm');
    form.action = `/admin/tags/${tagId}`;
    modal.show();
}
</script>
@endpush
