@extends('layouts.admin')

@section('title', 'View Hero Banner')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-title-box mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4 class="page-title mb-1">{{ $heroBanner->title }}</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.hero-banners.index') }}">Hero Banners</a></li>
                    <li class="breadcrumb-item active">View</li>
                </ol>
            </div>
            <div class="col-md-4">
                <div class="float-end">
                    <a href="{{ route('admin.hero-banners.edit', $heroBanner) }}" class="btn btn-warning me-2">
                        <i class="ri-edit-line me-1"></i> Edit
                    </a>
                    <a href="{{ route('admin.hero-banners.index') }}" class="btn btn-outline-secondary">
                        <i class="ri-arrow-left-line me-1"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title mb-3">Banner Details</h5>
                    
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <p class="text-muted mb-2">Title</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="mb-2">{{ $heroBanner->title }}</p>
                        </div>
                    </div>

                    @if($heroBanner->subtitle)
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <p class="text-muted mb-2">Subtitle</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="mb-2">{{ $heroBanner->subtitle }}</p>
                        </div>
                    </div>
                    @endif

                    @if($heroBanner->description)
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <p class="text-muted mb-2">Description</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="mb-2">{{ $heroBanner->description }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <p class="text-muted mb-2">Order</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="mb-2">{{ $heroBanner->order }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <p class="text-muted mb-2">Status</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="mb-2">
                                @if($heroBanner->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <p class="text-muted mb-2">Created</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="mb-2">{{ $heroBanner->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            <p class="text-muted mb-2">Last Updated</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="mb-2">{{ $heroBanner->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Banner Image</h5>
                </div>
                <div class="card-body">
                    <img src="{{ asset('storage/' . $heroBanner->image_path) }}" alt="{{ $heroBanner->title }}" class="img-fluid rounded">
                    <small class="text-muted d-block mt-2">Aspect Ratio: 16:9</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
