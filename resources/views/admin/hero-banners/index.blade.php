@extends('layouts.admin')

@section('title', 'Hero Banners')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-title-box mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4 class="page-title mb-1">Hero Banners</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Hero Banners</li>
                </ol>
            </div>
            <div class="col-md-4">
                <div class="float-end">
                    <a href="{{ route('admin.hero-banners.create') }}" class="btn btn-primary">
                        <i class="ri-add-line me-1"></i> Add Banner
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="ri-check-line me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">All Hero Banners</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Order</th>
                        <th>Title</th>
                        <th>Subtitle</th>
                        <th>Preview</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($heroBanners as $banner)
                    <tr>
                        <td><span class="badge bg-info">{{ $banner->order }}</span></td>
                        <td><strong>{{ $banner->title }}</strong></td>
                        <td>{{ $banner->subtitle ?? '-' }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $banner->image_path) }}" alt="{{ $banner->title }}" 
                                 style="height: 50px; width: auto; object-fit: cover; border-radius: 4px;">
                        </td>
                        <td>
                            @if($banner->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td><small>{{ $banner->created_at->format('d M Y') }}</small></td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('admin.hero-banners.edit', $banner) }}" class="btn btn-outline-warning" title="Edit">
                                    <i class="ri-edit-line"></i>
                                </a>
                                <form action="{{ route('admin.hero-banners.destroy', $banner) }}" method="POST" style="display:inline;" 
                                      onsubmit="return confirm('Delete this banner?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Delete">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No hero banners found. <a href="{{ route('admin.hero-banners.create') }}">Create one</a></td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($heroBanners->hasPages())
        <div class="card-footer">
            {{ $heroBanners->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
