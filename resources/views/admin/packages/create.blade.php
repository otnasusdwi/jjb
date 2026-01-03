@extends('layouts.admin')

@section('title', 'Add New Travel Package')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-title-box mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4 class="page-title mb-1">Add New Travel Package</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.packages.index') }}">Packages</a></li>
                    <li class="breadcrumb-item active">Add New</li>
                </ol>
            </div>
            <div class="col-md-4">
                <div class="float-end">
                    <a href="{{ route('admin.packages.index') }}" class="btn btn-outline-secondary">
                        <i class="ri-arrow-left-line me-1"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Basic Information -->
            <div class="col-lg-8">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Basic Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Package Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('location') is-invalid @enderror"
                                           id="location" name="location" value="{{ old('location') }}" required>
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <select class="form-select @error('category') is-invalid @enderror"
                                            id="category" name="category">
                                        <option value="">Select Category</option>
                                        <option value="cultural" {{ old('category') === 'cultural' ? 'selected' : '' }}>Cultural Tours</option>
                                        <option value="adventure" {{ old('category') === 'adventure' ? 'selected' : '' }}>Adventure</option>
                                        <option value="beach" {{ old('category') === 'beach' ? 'selected' : '' }}>Beach & Marine</option>
                                        <option value="spiritual" {{ old('category') === 'spiritual' ? 'selected' : '' }}>Spiritual</option>
                                        <option value="nature" {{ old('category') === 'nature' ? 'selected' : '' }}>Nature</option>
                                        <option value="city" {{ old('category') === 'city' ? 'selected' : '' }}>City Tours</option>
                                        <option value="romance" {{ old('category') === 'romance' ? 'selected' : '' }}>Romance</option>
                                        <option value="family" {{ old('category') === 'family' ? 'selected' : '' }}>Family</option>
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="duration" class="form-label">Duration (Days) <span class="text-danger">*</span></label>
                                    <input type="number" min="1" max="30"
                                           class="form-control @error('duration') is-invalid @enderror"
                                           id="duration" name="duration" value="{{ old('duration', 1) }}" required>
                                    @error('duration')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="max_participants" class="form-label">Max Participants</label>
                                    <input type="number" min="1" max="100"
                                           class="form-control @error('max_participants') is-invalid @enderror"
                                           id="max_participants" name="max_participants" value="{{ old('max_participants', 20) }}">
                                    @error('max_participants')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="difficulty_level" class="form-label">Difficulty Level</label>
                                    <select class="form-select @error('difficulty_level') is-invalid @enderror"
                                            id="difficulty_level" name="difficulty_level">
                                        <option value="">Select Difficulty</option>
                                        <option value="easy" {{ old('difficulty_level') === 'easy' ? 'selected' : '' }}>Easy</option>
                                        <option value="moderate" {{ old('difficulty_level') === 'moderate' ? 'selected' : '' }}>Moderate</option>
                                        <option value="challenging" {{ old('difficulty_level') === 'challenging' ? 'selected' : '' }}>Challenging</option>
                                        <option value="extreme" {{ old('difficulty_level') === 'extreme' ? 'selected' : '' }}>Extreme</option>
                                    </select>
                                    @error('difficulty_level')
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
                                    <label for="price" class="form-label">Current Price (IDR) <span class="text-danger">*</span></label>
                                    <input type="number" step="1000" min="0"
                                           class="form-control @error('price') is-invalid @enderror"
                                           id="price" name="price" value="{{ old('price') }}" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="original_price" class="form-label">Original Price (IDR)</label>
                                    <input type="number" step="1000" min="0"
                                           class="form-control @error('original_price') is-invalid @enderror"
                                           id="original_price" name="original_price" value="{{ old('original_price') }}">
                                    @error('original_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Leave empty if no discount</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="child_price" class="form-label">Child Price (IDR)</label>
                                    <input type="number" step="1000" min="0"
                                           class="form-control @error('child_price') is-invalid @enderror"
                                           id="child_price" name="child_price" value="{{ old('child_price') }}">
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
                                           id="infant_price" name="infant_price" value="{{ old('infant_price') }}">
                                    @error('infant_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Itinerary -->
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Itinerary</h5>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="addItineraryDay()">
                            <i class="ri-add-line"></i> Add Day
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="itinerary-container">
                            <!-- Itinerary days will be added here -->
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
                                    <label for="inclusions" class="form-label">What's Included</label>
                                    <textarea class="form-control @error('inclusions') is-invalid @enderror"
                                              id="inclusions" name="inclusions" rows="6"
                                              placeholder="Enter each inclusion on a new line">{{ old('inclusions') }}</textarea>
                                    @error('inclusions')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exclusions" class="form-label">What's Not Included</label>
                                    <textarea class="form-control @error('exclusions') is-invalid @enderror"
                                              id="exclusions" name="exclusions" rows="6"
                                              placeholder="Enter each exclusion on a new line">{{ old('exclusions') }}</textarea>
                                    @error('exclusions')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Featured Image -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Featured Image</h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <div class="image-preview mb-3" style="min-height: 200px; border: 2px dashed #ddd; display: flex; align-items: center; justify-content: center;">
                                <img id="image-preview" src="#" alt="Preview" style="max-width: 100%; max-height: 200px; display: none;">
                                <div id="image-placeholder" class="text-muted">
                                    <i class="ri-image-line fs-48 mb-2 d-block"></i>
                                    Upload featured image
                                </div>
                            </div>
                            <input type="file" class="form-control @error('featured_image') is-invalid @enderror"
                                   id="featured_image" name="featured_image" accept="image/*" onchange="previewImage(event)">
                            @error('featured_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Max file size: 5MB. Recommended: 1200x800px</div>
                        </div>
                    </div>
                </div>

                <!-- Additional Images -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Gallery Images</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <input type="file" class="form-control @error('gallery_images') is-invalid @enderror"
                                   id="gallery_images" name="gallery_images[]" accept="image/*" multiple>
                            @error('gallery_images')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Max 10 images, 2MB each</div>
                        </div>
                        <div id="gallery-preview" class="row g-2"></div>
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
                                <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1"
                                   {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                Featured Package
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="is_popular" name="is_popular" value="1"
                                   {{ old('is_popular') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_popular">
                                Popular Package
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="instant_booking" name="instant_booking" value="1"
                                   {{ old('instant_booking') ? 'checked' : '' }}>
                            <label class="form-check-label" for="instant_booking">
                                Allow Instant Booking
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Tags Section -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="ri-price-tag-3-line"></i> Tags
                        </h5>
                        <small class="text-muted">Select relevant tags to help visitors find this package easily</small>
                    </div>
                    <div class="card-body">
                        @if(isset($tags) && $tags->count() > 0)
                            @foreach($tags as $type => $typeTags)
                            <div class="mb-4 pb-3 border-bottom">
                                <h6 class="text-uppercase fw-bold mb-3" style="color: #6c757d; font-size: 0.875rem;">
                                    {{ ucfirst($type) }}
                                </h6>
                                <div class="row g-2">
                                    @foreach($typeTags as $tag)
                                    <div class="col-md-6 col-lg-4">
                                        <div class="form-check p-2 border rounded" style="background-color: #f8f9fa;">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   name="tags[]" 
                                                   value="{{ $tag->id }}"
                                                   id="tag_{{ $tag->id }}"
                                                   {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label w-100" for="tag_{{ $tag->id }}" style="cursor: pointer;">
                                                <span style="font-size: 1.3rem;">{{ $tag->icon }}</span>
                                                <span class="ms-2 fw-medium">{{ $tag->name }}</span>
                                                @if($tag->description)
                                                <br><small class="text-muted ms-4">{{ Str::limit($tag->description, 40) }}</small>
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="alert alert-warning">
                                <i class="ri-alert-line"></i> No tags available. Please run <code>php artisan db:seed --class=TagSeeder</code>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- SEO -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">SEO Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                                   id="meta_title" name="meta_title" value="{{ old('meta_title') }}"
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
                                      maxlength="160">{{ old('meta_description') }}</textarea>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Recommended: 150-160 characters</div>
                        </div>

                        <div class="mb-3">
                            <label for="keywords" class="form-label">Keywords</label>
                            <input type="text" class="form-control @error('keywords') is-invalid @enderror"
                                   id="keywords" name="keywords" value="{{ old('keywords') }}"
                                   placeholder="keyword1, keyword2, keyword3">
                            @error('keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="ri-save-line"></i> Create Package
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="saveDraft()">
                                <i class="ri-draft-line"></i> Save as Draft
                            </button>
                            <a href="{{ route('admin.packages.index') }}" class="btn btn-secondary">
                                <i class="ri-arrow-left-line"></i> Back to List
                            </a>
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
// Preview featured image
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('image-preview');
    const placeholder = document.getElementById('image-placeholder');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        };
        reader.readAsDataURL(file);
    }
}

// Preview gallery images
document.getElementById('gallery_images').addEventListener('change', function(e) {
    const files = e.target.files;
    const preview = document.getElementById('gallery-preview');
    preview.innerHTML = '';

    for (let i = 0; i < files.length && i < 10; i++) {
        const file = files[i];
        const reader = new FileReader();
        reader.onload = function(e) {
            const col = document.createElement('div');
            col.className = 'col-4';
            col.innerHTML = `<img src="${e.target.result}" class="img-fluid rounded" style="height: 60px; object-fit: cover;">`;
            preview.appendChild(col);
        };
        reader.readAsDataURL(file);
    }
});

// Add itinerary day
let dayCounter = 0;
function addItineraryDay() {
    dayCounter++;
    const container = document.getElementById('itinerary-container');
    const dayHtml = `
        <div class="border rounded p-3 mb-3" id="day-${dayCounter}">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">Day ${dayCounter}</h6>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeDay(${dayCounter})">
                    <i class="ri-delete-bin-line"></i>
                </button>
            </div>
            <div class="mb-2">
                <input type="text" class="form-control form-control-sm"
                       name="itinerary[${dayCounter}][title]"
                       placeholder="Day ${dayCounter} title">
            </div>
            <div>
                <textarea class="form-control form-control-sm"
                          name="itinerary[${dayCounter}][description]"
                          rows="3"
                          placeholder="Day ${dayCounter} activities and description"></textarea>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', dayHtml);
}

// Remove itinerary day
function removeDay(dayId) {
    document.getElementById(`day-${dayId}`).remove();
}

// Initialize with first day
document.addEventListener('DOMContentLoaded', function() {
    addItineraryDay();
});

// Save as draft
function saveDraft() {
    document.getElementById('status').value = 'draft';
    document.querySelector('form').submit();
}

// Auto-generate meta title from name
document.getElementById('name').addEventListener('input', function() {
    const metaTitle = document.getElementById('meta_title');
    if (!metaTitle.value) {
        metaTitle.value = this.value;
    }
});

// Character counter for meta fields
function addCharacterCounter(inputId, maxLength) {
    const input = document.getElementById(inputId);
    const parent = input.parentElement;
    const counter = document.createElement('div');
    counter.className = 'form-text text-end';
    counter.innerHTML = `<span id="${inputId}-count">0</span>/${maxLength}`;
    parent.appendChild(counter);

    input.addEventListener('input', function() {
        const count = this.value.length;
        document.getElementById(`${inputId}-count`).textContent = count;
        if (count > maxLength * 0.8) {
            counter.classList.add('text-warning');
        }
        if (count > maxLength * 0.95) {
            counter.classList.remove('text-warning');
            counter.classList.add('text-danger');
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    addCharacterCounter('meta_title', 60);
    addCharacterCounter('meta_description', 160);
});
</script>
@endpush
