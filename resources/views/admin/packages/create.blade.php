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
        
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs mb-4" id="packageTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab">
                    <i class="ri-information-line me-1"></i> Basic Info & Pricing
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="images-tab" data-bs-toggle="tab" data-bs-target="#images" type="button" role="tab">
                    <i class="ri-image-line me-1"></i> Images
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="itinerary-tab" data-bs-toggle="tab" data-bs-target="#itinerary" type="button" role="tab">
                    <i class="ri-route-line me-1"></i> Itinerary
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="inclusions-tab" data-bs-toggle="tab" data-bs-target="#inclusions" type="button" role="tab">
                    <i class="ri-check-double-line me-1"></i> Inclusions & Exclusions
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings" type="button" role="tab">
                    <i class="ri-settings-3-line me-1"></i> Settings & SEO
                </button>
            </li>
        </ul>

        <!-- Tabs Content -->
        <div class="tab-content" id="packageTabsContent">
            <!-- Basic Info & Pricing Tab -->
            <div class="tab-pane fade show active" id="basic" role="tabpanel">
                <div class="row">
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
                                <div class="mb-3">
                                    <label for="currency" class="form-label">Currency <span class="text-danger">*</span></label>
                                    <select class="form-select @error('currency') is-invalid @enderror" id="currency" name="currency" required>
                                        <option value="IDR" {{ old('currency', 'IDR') === 'IDR' ? 'selected' : '' }}>IDR - Indonesian Rupiah</option>
                                        <option value="USD" {{ old('currency') === 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                                    </select>
                                    @error('currency')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="price" class="form-label">Adult Price <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" min="0"
                                                   class="form-control @error('price') is-invalid @enderror"
                                                   id="price" name="price" value="{{ old('price') }}" required>
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="child_price" class="form-label">Child Price</label>
                                            <input type="number" step="0.01" min="0"
                                                   class="form-control @error('child_price') is-invalid @enderror"
                                                   id="child_price" name="child_price" value="{{ old('child_price') }}">
                                            @error('child_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Leave empty if same as adult price</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
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

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1"
                                           {{ old('is_featured') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">Featured Package</label>
                                </div>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="is_popular" name="is_popular" value="1"
                                           {{ old('is_popular') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_popular">Popular Package</label>
                                </div>

                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="checkbox" id="instant_booking" name="instant_booking" value="1"
                                           {{ old('instant_booking') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="instant_booking">Allow Instant Booking</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Images Tab -->
            <div class="tab-pane fade" id="images" role="tabpanel">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Featured Image</h5>
                            </div>
                            <div class="card-body text-center">
                                <div class="image-preview mb-3" style="min-height: 250px; border: 2px dashed #ddd; display: flex; align-items: center; justify-content: center;">
                                    <img id="image-preview" src="#" alt="Preview" style="max-width: 100%; max-height: 250px; display: none;">
                                    <div id="image-placeholder" class="text-muted">
                                        <i class="ri-image-line" style="font-size: 48px;"></i>
                                        <p class="mt-2">Upload featured image</p>
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

                    <div class="col-lg-6">
                        <div class="card mb-3">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Gallery Images</h5>
                                <button type="button" class="btn btn-sm btn-primary" onclick="addGalleryImage()">
                                    <i class="ri-add-line"></i> Add Image
                                </button>
                            </div>
                            <div class="card-body">
                                <div id="gallery-container"></div>
                                <div class="form-text">Recommended: 1200x800px, Max 2MB per image</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Itinerary Tab -->
            <div class="tab-pane fade" id="itinerary" role="tabpanel">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Itinerary</h5>
                        <button type="button" class="btn btn-sm btn-primary" onclick="addItineraryDay()">
                            <i class="ri-add-line"></i> Add Day
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="itinerary-container"></div>
                    </div>
                </div>
            </div>

            <!-- Inclusions & Exclusions Tab -->
            <div class="tab-pane fade" id="inclusions" role="tabpanel">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">What's Included</h5>
                                <button type="button" class="btn btn-sm btn-success" onclick="addInclusion()">
                                    <i class="ri-add-line"></i> Add
                                </button>
                            </div>
                            <div class="card-body">
                                <div id="inclusions-container"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">What's Not Included</h5>
                                <button type="button" class="btn btn-sm btn-danger" onclick="addExclusion()">
                                    <i class="ri-add-line"></i> Add
                                </button>
                            </div>
                            <div class="card-body">
                                <div id="exclusions-container"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings & SEO Tab -->
            <div class="tab-pane fade" id="settings" role="tabpanel">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="ri-price-tag-3-line"></i> Tags</h5>
                            </div>
                            <div class="card-body">
                                <label for="tags" class="form-label">Select Tags</label>
                                <select id="tags" name="tags[]" class="form-select" multiple>
                                    @if(isset($tags) && $tags->count() > 0)
                                        @foreach($tags as $type => $typeTags)
                                            <optgroup label="{{ ucfirst($type) }}">
                                                @foreach($typeTags as $tag)
                                                    <option value="{{ $tag->id }}" 
                                                        {{ collect(old('tags', []))->contains($tag->id) ? 'selected' : '' }}>
                                                        {{ $tag->emoji ?? '' }} {{ $tag->name }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="form-text">Select multiple tags</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="ri-search-line"></i> SEO Settings</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="meta_title" class="form-label">Meta Title</label>
                                    <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                                           id="meta_title" name="meta_title" value="{{ old('meta_title') }}" maxlength="60">
                                    @error('meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Recommended: 50-60 characters</div>
                                </div>

                                <div class="mb-3">
                                    <label for="meta_description" class="form-label">Meta Description</label>
                                    <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                              id="meta_description" name="meta_description" rows="3" maxlength="160">{{ old('meta_description') }}</textarea>
                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Recommended: 150-160 characters</div>
                                </div>

                                <div class="mb-0">
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
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons-fixed">
            <div class="container-fluid">
                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('admin.packages.index') }}" class="btn btn-secondary">
                        <i class="ri-arrow-left-line"></i> Cancel
                    </a>
                    <button type="button" class="btn btn-outline-secondary" onclick="saveDraft()">
                        <i class="ri-draft-line"></i> Save as Draft
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="ri-save-line"></i> Create Package
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<style>
.select2-container .select2-selection--multiple {
    min-height: 120px !important;
}
.select2-container--bootstrap-5 .select2-selection {
    border-color: #dee2e6;
}

/* Fixed Bottom Action Buttons */
.action-buttons-fixed {
    position: fixed;
    bottom: 0;
    left: 250px;
    right: 0;
    background: #fff;
    padding: 15px 0;
    box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
    z-index: 1000;
    border-top: 1px solid #dee2e6;
}

@media (max-width: 991.98px) {
    .action-buttons-fixed {
        left: 0;
    }
}

/* Add padding to bottom of content to prevent overlap */
body {
    padding-bottom: 80px;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
// Initialize Select2 for tags
$(document).ready(function() {
    $('#tags').select2({
        theme: 'bootstrap-5',
        placeholder: 'Select tags for this package',
        allowClear: true,
        width: '100%'
    });
});

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

// Add gallery image
let galleryCounter = 0;
function addGalleryImage() {
    galleryCounter++;
    const container = document.getElementById('gallery-container');
    const imageHtml = `
        <div class="border rounded p-3 mb-3" id="gallery-${galleryCounter}">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">Image ${galleryCounter}</h6>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeGalleryImage(${galleryCounter})">
                    <i class="ri-delete-bin-line"></i>
                </button>
            </div>
            <div class="image-preview mb-2" style="min-height: 150px; border: 2px dashed #ddd; display: flex; align-items: center; justify-content: center;">
                <img id="gallery-preview-${galleryCounter}" src="#" alt="Preview" style="max-width: 100%; max-height: 150px; display: none;">
                <div id="gallery-placeholder-${galleryCounter}" class="text-muted text-center">
                    <i class="ri-image-line" style="font-size: 32px;"></i>
                    <p class="mt-1 mb-0" style="font-size: 0.875rem;">Upload image</p>
                </div>
            </div>
            <input type="file" class="form-control form-control-sm" 
                   name="gallery_images[]" 
                   accept="image/*"
                   onchange="previewGalleryImage(event, ${galleryCounter})">
        </div>
    `;
    container.insertAdjacentHTML('beforeend', imageHtml);
}

// Remove gallery image
function removeGalleryImage(imageId) {
    document.getElementById(`gallery-${imageId}`).remove();
}

// Preview gallery image
function previewGalleryImage(event, imageId) {
    const file = event.target.files[0];
    const preview = document.getElementById(`gallery-preview-${imageId}`);
    const placeholder = document.getElementById(`gallery-placeholder-${imageId}`);

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

// Add inclusion
let inclusionCounter = 0;
function addInclusion() {
    inclusionCounter++;
    const container = document.getElementById('inclusions-container');
    const html = `
        <div class="input-group mb-2" id="inclusion-${inclusionCounter}">
            <span class="input-group-text"><i class="ri-check-line text-success"></i></span>
            <input type="text" class="form-control" name="inclusions[]" placeholder="e.g., Hotel pickup and drop-off">
            <button type="button" class="btn btn-outline-danger" onclick="removeInclusion(${inclusionCounter})">
                <i class="ri-delete-bin-line"></i>
            </button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
}

// Remove inclusion
function removeInclusion(id) {
    document.getElementById(`inclusion-${id}`).remove();
}

// Add exclusion
let exclusionCounter = 0;
function addExclusion() {
    exclusionCounter++;
    const container = document.getElementById('exclusions-container');
    const html = `
        <div class="input-group mb-2" id="exclusion-${exclusionCounter}">
            <span class="input-group-text"><i class="ri-close-line text-danger"></i></span>
            <input type="text" class="form-control" name="exclusions[]" placeholder="e.g., Personal expenses">
            <button type="button" class="btn btn-outline-danger" onclick="removeExclusion(${exclusionCounter})">
                <i class="ri-delete-bin-line"></i>
            </button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
}

// Remove exclusion
function removeExclusion(id) {
    document.getElementById(`exclusion-${id}`).remove();
}

// Initialize with first items
document.addEventListener('DOMContentLoaded', function() {
    addItineraryDay();
    addInclusion();
    addExclusion();
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
    if (!input) return;
    
    const parent = input.parentElement;
    const counter = document.createElement('div');
    counter.className = 'form-text text-end';
    counter.innerHTML = `<span id="${inputId}-count">0</span>/${maxLength}`;
    parent.appendChild(counter);

    input.addEventListener('input', function() {
        const count = this.value.length;
        document.getElementById(`${inputId}-count`).textContent = count;
        counter.classList.remove('text-warning', 'text-danger');
        if (count > maxLength * 0.8) {
            counter.classList.add('text-warning');
        }
        if (count > maxLength * 0.95) {
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
