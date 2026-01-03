@extends('layouts.admin')

@section('title', 'Edit Package')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-title-box mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4 class="page-title mb-1">Edit Package</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.packages.index') }}">Packages</a></li>
                    <li class="breadcrumb-item active">Edit - {{ Str::limit($package->name, 30) }}</li>
                </ol>
            </div>
            <div class="col-md-4">
                <div class="float-end">
                    <a href="{{ route('admin.packages.show', $package) }}" class="btn btn-outline-secondary">
                        <i class="ri-arrow-left-line me-1"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.packages.update', $package) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <!-- Main Content Column -->
            <div class="col-lg-8">
                <!-- Basic Information -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Basic Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Package Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $package->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="short_description" class="form-label">Short Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('short_description') is-invalid @enderror"
                                      id="short_description" name="short_description" rows="2" required>{{ old('short_description', $package->short_description) }}</textarea>
                            @error('short_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="5" required>{{ old('description', $package->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('location') is-invalid @enderror"
                                           id="location" name="location" value="{{ old('location', $package->location) }}" required>
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                                    <select class="form-select @error('category_id') is-invalid @enderror"
                                            id="category_id" name="category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $package->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="duration_days" class="form-label">Duration Days <span class="text-danger">*</span></label>
                                    <input type="number" min="1" max="30"
                                           class="form-control @error('duration_days') is-invalid @enderror"
                                           id="duration_days" name="duration_days" value="{{ old('duration_days', $package->duration_days) }}" required>
                                    @error('duration_days')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="duration_nights" class="form-label">Duration Nights <span class="text-danger">*</span></label>
                                    <input type="number" min="0" max="30"
                                           class="form-control @error('duration_nights') is-invalid @enderror"
                                           id="duration_nights" name="duration_nights" value="{{ old('duration_nights', $package->duration_nights) }}" required>
                                    @error('duration_nights')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="difficulty_level" class="form-label">Difficulty Level <span class="text-danger">*</span></label>
                                    <select class="form-select @error('difficulty_level') is-invalid @enderror"
                                            id="difficulty_level" name="difficulty_level" required>
                                        <option value="easy" {{ old('difficulty_level', $package->difficulty_level) === 'easy' ? 'selected' : '' }}>Easy</option>
                                        <option value="moderate" {{ old('difficulty_level', $package->difficulty_level) === 'moderate' ? 'selected' : '' }}>Moderate</option>
                                        <option value="challenging" {{ old('difficulty_level', $package->difficulty_level) === 'challenging' ? 'selected' : '' }}>Challenging</option>
                                        <option value="difficult" {{ old('difficulty_level', $package->difficulty_level) === 'difficult' ? 'selected' : '' }}>Difficult</option>
                                    </select>
                                    @error('difficulty_level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="min_participants" class="form-label">Min Participants <span class="text-danger">*</span></label>
                                    <input type="number" min="1" max="100"
                                           class="form-control @error('min_participants') is-invalid @enderror"
                                           id="min_participants" name="min_participants" value="{{ old('min_participants', $package->min_participants) }}" required>
                                    @error('min_participants')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="max_participants" class="form-label">Max Participants <span class="text-danger">*</span></label>
                                    <input type="number" min="1" max="100"
                                           class="form-control @error('max_participants') is-invalid @enderror"
                                           id="max_participants" name="max_participants" value="{{ old('max_participants', $package->max_participants) }}" required>
                                    @error('max_participants')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="departure_city" class="form-label">Departure City <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('departure_city') is-invalid @enderror"
                                           id="departure_city" name="departure_city" value="{{ old('departure_city', $package->departure_city) }}" required>
                                    @error('departure_city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="meeting_point" class="form-label">Meeting Point <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('meeting_point') is-invalid @enderror"
                                           id="meeting_point" name="meeting_point" value="{{ old('meeting_point', $package->meeting_point) }}" required>
                                    @error('meeting_point')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Pricing</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="adult_price" class="form-label">Adult Price (IDR) <span class="text-danger">*</span></label>
                                    <input type="number" step="1000" min="0"
                                           class="form-control @error('adult_price') is-invalid @enderror"
                                           id="adult_price" name="adult_price" value="{{ old('adult_price', $package->adult_price) }}" required>
                                    @error('adult_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="commission_rate" class="form-label">Commission Rate (%) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" min="0" max="100"
                                           class="form-control @error('commission_rate') is-invalid @enderror"
                                           id="commission_rate" name="commission_rate" value="{{ old('commission_rate', $package->commission_rate) }}" required>
                                    @error('commission_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="child_price" class="form-label">Child Price (IDR)</label>
                                    <input type="number" step="1000" min="0"
                                           class="form-control @error('child_price') is-invalid @enderror"
                                           id="child_price" name="child_price" value="{{ old('child_price', $package->child_price) }}">
                                    @error('child_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="infant_price" class="form-label">Infant Price (IDR)</label>
                                    <input type="number" step="1000" min="0"
                                           class="form-control @error('infant_price') is-invalid @enderror"
                                           id="infant_price" name="infant_price" value="{{ old('infant_price', $package->infant_price) }}">
                                    @error('infant_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Inclusions & Exclusions -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Inclusions & Exclusions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="includes" class="form-label">What's Included</label>
                                    <textarea class="form-control @error('includes') is-invalid @enderror"
                                              id="includes" name="includes[]" rows="6"
                                              placeholder="Enter each inclusion on a new line">{{ is_array($package->includes) ? implode("\n", $package->includes) : $package->includes }}</textarea>
                                    @error('includes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="excludes" class="form-label">What's Not Included</label>
                                    <textarea class="form-control @error('excludes') is-invalid @enderror"
                                              id="excludes" name="excludes[]" rows="6"
                                              placeholder="Enter each exclusion on a new line">{{ is_array($package->excludes) ? implode("\n", $package->excludes) : $package->excludes }}</textarea>
                                    @error('excludes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Performance Stats -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="ri-bar-chart-line me-2"></i>Performance Stats</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-3">
                                    <small class="text-muted d-block">Total Bookings</small>
                                    <h4 class="mb-0">{{ $package->bookings()->count() }}</h4>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-3">
                                    <small class="text-muted d-block">Total Revenue</small>
                                    <h4 class="mb-0">IDR {{ number_format($package->bookings()->sum('total_price') ?? 0, 0, ',', '.') }}</h4>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-3">
                                    <small class="text-muted d-block">Average Rating</small>
                                    <h4 class="mb-0">{{ number_format($package->average_rating ?? 0, 1) }}/5</h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3">
                                    <small class="text-muted d-block">Total Reviews</small>
                                    <h4 class="mb-0">{{ $package->total_reviews ?? 0 }}</h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3">
                                    <small class="text-muted d-block">Created</small>
                                    <p class="mb-0">{{ $package->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3">
                                    <small class="text-muted d-block">Last Updated</small>
                                    <p class="mb-0">{{ $package->updated_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEO Settings -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="ri-search-line me-2"></i>SEO Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                                   id="meta_title" name="meta_title" value="{{ old('meta_title', $package->meta_title) }}"
                                   maxlength="60">
                            @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Recommended: 50-60 characters</div>
                        </div>

                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                      id="meta_description" name="meta_description" rows="3"
                                      maxlength="160">{{ old('meta_description', $package->meta_description) }}</textarea>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Recommended: 150-160 characters</div>
                        </div>

                        <div class="mb-0">
                            <label for="keywords" class="form-label">Keywords</label>
                            <input type="text" class="form-control @error('keywords') is-invalid @enderror"
                                   id="keywords" name="keywords" value="{{ old('keywords', $package->keywords) }}"
                                   placeholder="mount batur, sunrise trekking, volcano tour">
                            @error('keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Separate keywords with commas</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Column -->
            <div class="col-lg-4">
                <!-- Featured Image -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Featured Image</h5>
                    </div>
                    <div class="card-body text-center">
                        @if($package->main_image)
                        <div class="mb-3">
                            <img src="{{ Storage::url($package->main_image) }}" 
                                 alt="{{ $package->name }}" 
                                 class="img-fluid rounded"
                                 style="max-height: 200px; object-fit: cover;">
                        </div>
                        @endif
                        <div class="mb-3">
                            <input type="file" class="form-control @error('main_image') is-invalid @enderror"
                                   id="main_image" name="main_image" accept="image/*">
                            @error('main_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Max file size: 5MB. Leave empty to keep current image</div>
                        </div>
                    </div>
                </div>

                <!-- Settings -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="draft" {{ old('status', $package->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="active" {{ old('status', $package->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $package->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="archived" {{ old('status', $package->status) === 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1"
                                   {{ old('is_featured', $package->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                Featured Package
                            </label>
                        </div>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="is_popular" name="is_popular" value="1"
                                   {{ old('is_popular', $package->is_popular) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_popular">
                                Popular Package
                            </label>
                        </div>

                        <div class="form-check mb-0">
                            <input class="form-check-input" type="checkbox" id="instant_booking" name="instant_booking" value="1"
                                   {{ old('instant_booking', $package->instant_booking) ? 'checked' : '' }}>
                            <label class="form-check-label" for="instant_booking">
                                Allow Instant Booking
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Tags Section -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="ri-price-tag-3-line"></i> Tags
                        </h5>
                        <small class="text-muted">Select tags to help visitors find this package</small>
                    </div>
                    <div class="card-body">
                        @if(isset($tags) && $tags->count() > 0)
                            @foreach($tags as $type => $typeTags)
                            <div class="mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <h6 class="text-uppercase fw-bold mb-2" style="color: #6c757d; font-size: 0.75rem;">
                                    {{ ucfirst($type) }}
                                </h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($typeTags as $tag)
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               name="tags[]" 
                                               value="{{ $tag->id }}"
                                               id="tag_{{ $tag->id }}"
                                               {{ in_array($tag->id, old('tags', $package->tags->pluck('id')->toArray())) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tag_{{ $tag->id }}">
                                            @if($tag->icon)<span class="me-1">{{ $tag->icon }}</span>@endif{{ $tag->name }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="alert alert-warning mb-0">
                                No tags available. Please create tags first.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-save-line me-1"></i> Update Package
                            </button>
                            <a href="{{ route('admin.packages.show', $package) }}" class="btn btn-outline-info">
                                <i class="ri-eye-line me-1"></i> View Package
                            </a>
                            <button type="button" onclick="saveDraft()" class="btn btn-outline-secondary">
                                <i class="ri-draft-line me-1"></i> Save as Draft
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// Save as draft
function saveDraft() {
    document.getElementById('status').value = 'draft';
    document.querySelector('form').submit();
}

// Character counter for meta fields
function addCharacterCounter(inputId, maxLength) {
    const input = document.getElementById(inputId);
    if (!input) return;
    
    const parent = input.parentElement;
    const counter = document.createElement('div');
    counter.className = 'form-text text-end';
    counter.innerHTML = `<span id="${inputId}-count">0</span>/${maxLength}`;
    parent.appendChild(counter);

    function updateCounter() {
        const count = input.value.length;
        const countEl = document.getElementById(`${inputId}-count`);
        if (countEl) {
            countEl.textContent = count;
            counter.classList.remove('text-warning', 'text-danger');
            if (count > maxLength * 0.8) {
                counter.classList.add('text-warning');
            }
            if (count > maxLength * 0.95) {
                counter.classList.remove('text-warning');
                counter.classList.add('text-danger');
            }
        }
    }

    input.addEventListener('input', updateCounter);
    updateCounter(); // Initial count
}

document.addEventListener('DOMContentLoaded', function() {
    addCharacterCounter('meta_title', 60);
    addCharacterCounter('meta_description', 160);
});
</script>
@endpush
