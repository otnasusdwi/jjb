@extends('layouts.admin')

@section('title', 'Package Details - ' . $package->name)

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-title-box mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="page-title mb-1">Package Details</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.packages.index') }}">Packages</a></li>
                    <li class="breadcrumb-item active">{{ Str::limit($package->name, 30) }}</li>
                </ol>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('package.show', $package->slug) }}" target="_blank" class="btn btn-info">
                        <i class="ri-eye-line me-1"></i> View Public
                    </a>
                    <a href="{{ route('admin.packages.edit', $package) }}" class="btn btn-warning">
                        <i class="ri-edit-line me-1"></i> Edit
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Package Header Card -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <h3 class="mb-3">{{ $package->name }}</h3>
                            <div class="d-flex flex-wrap gap-3 mb-3">
                                @if($package->category)
                                <span class="badge bg-primary">{{ ucfirst($package->category) }}</span>
                                @endif
                                <span class="text-muted">
                                    <i class="ri-time-line me-1"></i>{{ $package->duration_days }}D {{ $package->duration_nights }}N
                                </span>
                                <span class="text-muted">
                                    <i class="ri-map-pin-line me-1"></i>{{ $package->location }}
                                </span>
                                <span class="text-muted">
                                    <i class="ri-group-line me-1"></i>{{ $package->min_participants }}-{{ $package->max_participants }} pax
                                </span>
                            </div>
                            
                            <!-- Tags -->
                            @if($package->tags && $package->tags->count() > 0)
                            <div class="mb-2">
                                @foreach($package->tags as $tag)
                                <span class="badge me-1" style="background-color: {{ $tag->color }}">
                                    {{ $tag->name }}
                                </span>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        <div class="col-md-3 text-end">
                            @switch($package->status)
                                @case('active')
                                    <span class="badge bg-success badge-lg mb-2">Active</span>
                                    @break
                                @case('inactive')
                                    <span class="badge bg-secondary badge-lg mb-2">Inactive</span>
                                    @break
                                @case('draft')
                                    <span class="badge bg-warning badge-lg mb-2">Draft</span>
                                    @break
                                @case('archived')
                                    <span class="badge bg-dark badge-lg mb-2">Archived</span>
                                    @break
                            @endswitch
                            <div class="d-grid gap-2">
                                @if($package->status !== 'active')
                                <button onclick="changeStatus('active')" class="btn btn-sm btn-success">
                                    <i class="ri-check-line"></i> Activate
                                </button>
                                @else
                                <button onclick="changeStatus('inactive')" class="btn btn-sm btn-secondary">
                                    <i class="ri-pause-line"></i> Deactivate
                                </button>
                                @endif
                                <button onclick="deletePackage()" class="btn btn-sm btn-outline-danger">
                                    <i class="ri-delete-bin-line"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Featured Image -->
            @if($package->featured_image)
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Featured Image</h5>
                </div>
                <div class="card-body">
                    <img src="{{ Storage::url($package->featured_image) }}" 
                         alt="{{ $package->name }}" 
                         class="img-fluid rounded" 
                         style="width: 100%; max-height: 400px; object-fit: cover;">
                </div>
            </div>
            @endif

            <!-- Description -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Description</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $package->description }}</p>
                </div>
            </div>

            <!-- Itinerary -->
            @if($package->itineraries && $package->itineraries->count() > 0)
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Itinerary</h5>
                </div>
                <div class="card-body" style="max-height: 500px; overflow-y: auto;">
                    <div class="timeline">
                        @php
                            $groupedItineraries = $package->itineraries->groupBy('day_number')->sortKeys();
                        @endphp
                        @foreach($groupedItineraries as $dayNumber => $dayItems)
                        <div class="timeline-item mb-4">
                            <div class="timeline-marker">
                                <span class="badge bg-primary">Day {{ $dayNumber }}</span>
                            </div>
                            <div class="timeline-content ps-3">
                                @foreach($dayItems->sortBy('order') as $item)
                                <div class="mb-3">
                                    <h6 class="mb-1">{{ $item->title }}</h6>
                                    <p class="mb-0 text-muted">{{ $item->description }}</p>
                                </div>
                                @if(!$loop->last)
                                <hr class="my-2">
                                @endif
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Pricing -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Pricing Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="border rounded p-3 text-center">
                                <small class="text-muted d-block">Adult Price ({{ $package->currency }})</small>
                                <h4 class="mb-0 text-primary">{{ $package->currency }} {{ number_format($package->price, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                        @if($package->child_price)
                        <div class="col-md-6">
                            <div class="border rounded p-3 text-center">
                                <small class="text-muted d-block">Child Price ({{ $package->currency }})</small>
                                <h4 class="mb-0 text-info">{{ $package->currency }} {{ number_format($package->child_price, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Inclusions & Exclusions -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">What's Included & Excluded</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            @if($package->inclusions && $package->inclusions->count() > 0)
                            <h6 class="text-success"><i class="ri-check-line me-2"></i>Included</h6>
                            <ul class="list-unstyled">
                                @foreach($package->inclusions->sortBy('order') as $inclusion)
                                <li class="mb-1"><i class="ri-check-line text-success me-2"></i>{{ $inclusion->description }}</li>
                                @endforeach
                            </ul>
                            @else
                            <p class="text-muted mb-0">No inclusions added</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if($package->exclusions && $package->exclusions->count() > 0)
                            <h6 class="text-danger"><i class="ri-close-line me-2"></i>Excluded</h6>
                            <ul class="list-unstyled">
                                @foreach($package->exclusions->sortBy('order') as $exclusion)
                                <li class="mb-1"><i class="ri-close-line text-danger me-2"></i>{{ $exclusion->description }}</li>
                                @endforeach
                            </ul>
                            @else
                            <p class="text-muted mb-0">No exclusions added</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gallery -->
            @if($package->galleries && $package->galleries->count() > 0)
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Gallery Images</h5>
                </div>
                <div class="card-body">
                    <div id="galleryCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($package->galleries->sortBy('order') as $gallery)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="Gallery" class="d-block w-100 rounded" style="height: 400px; object-fit: cover;">
                            </div>
                            @endforeach
                        </div>
                        @if($package->galleries->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#galleryCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#galleryCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Recent Bookings -->
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Recent Bookings</h5>
                    <a href="{{ route('admin.bookings.index', ['package' => $package->id]) }}" class="btn btn-sm btn-outline-primary">
                        View All
                    </a>
                </div>
                <div class="card-body">
                    @if($package->bookings && $package->bookings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Booking #</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Pax</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($package->bookings->take(5) as $booking)
                                <tr>
                                    <td>{{ $booking->booking_code }}</td>
                                    <td>{{ $booking->user->name ?? 'N/A' }}</td>
                                    <td>{{ $booking->travel_date ? $booking->travel_date->format('d M Y') : 'N/A' }}</td>
                                    <td>{{ $booking->total_participants ?? 0 }}</td>
                                    <td>
                                        <span class="badge bg-{{ $booking->booking_status === 'confirmed' ? 'success' : 'warning' }}">
                                            {{ ucfirst($booking->booking_status ?? 'pending') }}
                                        </span>
                                    </td>
                                    <td>-</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="ri-calendar-line" style="font-size: 3rem; color: #ccc;"></i>
                        <p class="text-muted mt-2 mb-0">No bookings yet</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Stats -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Performance Stats</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block">Total Bookings</small>
                        <h4 class="mb-0">{{ $package->bookings()->count() }}</h4>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Total Revenue</small>
                        <h4 class="mb-0">-</h4>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Average Rating</small>
                        <h4 class="mb-0">
                            @if($package->average_rating > 0)
                                {{ number_format($package->average_rating, 1) }} <i class="ri-star-fill text-warning"></i>
                            @else
                                <span class="text-muted">No ratings yet</span>
                            @endif
                        </h4>
                    </div>
                    <div class="mb-0">
                        <small class="text-muted d-block">Total Reviews</small>
                        <h4 class="mb-0">{{ $package->total_reviews ?? 0 }}</h4>
                    </div>
                </div>
            </div>

            <!-- Package Features -->
            {{-- <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Package Features</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <i class="ri-fire-fill {{ $package->is_popular ? 'text-danger' : 'text-muted' }} me-2"></i>
                        <span>Popular Package</span>
                    </div>
                    <div class="d-flex align-items-center mb-0">
                        <i class="ri-flashlight-fill {{ $package->instant_booking ? 'text-success' : 'text-muted' }} me-2"></i>
                        <span>Instant Booking</span>
                    </div>
                </div>
            </div> --}}

            <!-- Package Info -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Package Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block">Location</small>
                        <p class="mb-0">{{ $package->location ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Slug</small>
                        <p class="mb-0">{{ $package->slug }}</p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Created</small>
                        <p class="mb-0">{{ $package->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div class="mb-0">
                        <small class="text-muted d-block">Last Updated</small>
                        <p class="mb-0">{{ $package->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- SEO Info -->
            @if($package->meta_title || $package->meta_description || $package->keywords)
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">SEO Information</h5>
                </div>
                <div class="card-body">
                    @if($package->meta_title)
                    <div class="mb-3">
                        <small class="text-muted d-block">Meta Title</small>
                        <p class="mb-0">{{ $package->meta_title }}</p>
                    </div>
                    @endif
                    @if($package->meta_description)
                    <div class="mb-3">
                        <small class="text-muted d-block">Meta Description</small>
                        <p class="mb-0">{{ $package->meta_description }}</p>
                    </div>
                    @endif
                    @if($package->keywords)
                    <div class="mb-0">
                        <small class="text-muted d-block">Keywords</small>
                        <div>
                            @foreach(explode(',', $package->keywords) as $keyword)
                            <span class="badge bg-light text-dark me-1">{{ trim($keyword) }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Status Change Form -->
<form id="statusForm" action="{{ route('admin.packages.update', $package) }}" method="POST" class="d-none">
    @csrf
    @method('PUT')
    <input type="hidden" name="status" id="statusInput">
    <input type="hidden" name="name" value="{{ $package->name }}">
    <input type="hidden" name="category" value="{{ $package->category }}">
    <input type="hidden" name="location" value="{{ $package->location }}">
    <input type="hidden" name="description" value="{{ $package->description }}">
    <input type="hidden" name="duration_days" value="{{ $package->duration_days }}">
    <input type="hidden" name="duration_nights" value="{{ $package->duration_nights }}">
    <input type="hidden" name="max_participants" value="{{ $package->max_participants }}">
    <input type="hidden" name="currency" value="{{ $package->currency }}">
    <input type="hidden" name="price" value="{{ $package->price }}">
</form>

<!-- Delete Form -->
<form id="deleteForm" action="{{ route('admin.packages.destroy', $package) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
function changeStatus(status) {
    if (confirm(`Are you sure you want to ${status} this package?`)) {
        document.getElementById('statusInput').value = status;
        document.getElementById('statusForm').submit();
    }
}

function deletePackage() {
    if (confirm('Are you sure you want to delete this package? This action cannot be undone.')) {
        document.getElementById('deleteForm').submit();
    }
}
</script>
@endpush
