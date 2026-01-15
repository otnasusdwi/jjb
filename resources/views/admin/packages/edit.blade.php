@extends('layouts.admin')

@section('title', 'Edit Package')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
<style>
.crop-modal .modal-dialog { max-width: 800px; }
.crop-container { max-height: 500px; overflow: hidden; }
.crop-container img { max-width: 100%; display: block; }
.aspect-ratio-btns .btn { margin: 0 5px; }
</style>
@endpush

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
                        <li class="breadcrumb-item active">Edit</li>
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

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Validation Errors:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('admin.packages.update', $package) }}" method="POST" enctype="multipart/form-data"
            id="packageForm">
            @csrf
            @method('PUT')

            <!-- Hidden inputs for cropped base64 images -->
            <input type="hidden" name="featured_image_data" id="featured_image_data">
            <div id="gallery_data_container"></div>

            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs mb-4" id="packageTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic"
                        type="button" role="tab">
                        <i class="ri-file-list-3-line me-1"></i> Basic Info & Pricing
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="images-tab" data-bs-toggle="tab" data-bs-target="#images" type="button"
                        role="tab">
                        <i class="ri-gallery-line me-1"></i> Images
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="itinerary-tab" data-bs-toggle="tab" data-bs-target="#itinerary"
                        type="button" role="tab">
                        <i class="ri-route-line me-1"></i> Itinerary
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="inclusions-tab" data-bs-toggle="tab" data-bs-target="#inclusions"
                        type="button" role="tab">
                        <i class="ri-check-double-line me-1"></i> Inclusions & Exclusions
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings"
                        type="button" role="tab">
                        <i class="ri-settings-3-line me-1"></i> Settings & SEO
                    </button>
                </li>
            </ul>

            <!-- Tabs Content -->
            <div class="tab-content" id="packageTabsContent">
                <!-- Basic Info & Pricing Tab -->
                <div class="tab-pane fade show active" id="basic" role="tabpanel">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Basic Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Package Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name', $package->name) }}"
                                            required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description <span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                            rows="5" required>{{ old('description', $package->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="location" class="form-label">Location <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('location') is-invalid @enderror"
                                                    id="location" name="location"
                                                    value="{{ old('location', $package->location) }}" required>
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
                                                    <option value="cultural"
                                                        {{ old('category', $package->category) === 'cultural' ? 'selected' : '' }}>
                                                        Cultural Tours</option>
                                                    <option value="adventure"
                                                        {{ old('category', $package->category) === 'adventure' ? 'selected' : '' }}>
                                                        Adventure</option>
                                                    <option value="beach"
                                                        {{ old('category', $package->category) === 'beach' ? 'selected' : '' }}>
                                                        Beach & Marine</option>
                                                    <option value="spiritual"
                                                        {{ old('category', $package->category) === 'spiritual' ? 'selected' : '' }}>
                                                        Spiritual</option>
                                                    <option value="nature"
                                                        {{ old('category', $package->category) === 'nature' ? 'selected' : '' }}>
                                                        Nature</option>
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
                                                <label for="duration_days" class="form-label">Days <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" min="1" max="30"
                                                    class="form-control @error('duration_days') is-invalid @enderror"
                                                    id="duration_days" name="duration_days"
                                                    value="{{ old('duration_days', $package->duration_days) }}" required>
                                                @error('duration_days')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="duration_nights" class="form-label">Nights</label>
                                                <input type="number" min="0" max="30"
                                                    class="form-control @error('duration_nights') is-invalid @enderror"
                                                    id="duration_nights" name="duration_nights"
                                                    value="{{ old('duration_nights', $package->duration_nights) }}">
                                                @error('duration_nights')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="max_participants" class="form-label">Max Participants</label>
                                                <input type="number" min="1" max="100"
                                                    class="form-control @error('max_participants') is-invalid @enderror"
                                                    id="max_participants" name="max_participants"
                                                    value="{{ old('max_participants', $package->max_participants) }}">
                                                @error('max_participants')
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
                                        <label for="currency" class="form-label">Currency <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select @error('currency') is-invalid @enderror" id="currency"
                                            name="currency" required>
                                            <option value="IDR"
                                                {{ old('currency', $package->currency) === 'IDR' ? 'selected' : '' }}>IDR -
                                                Indonesian Rupiah</option>
                                            <option value="USD"
                                                {{ old('currency', $package->currency) === 'USD' ? 'selected' : '' }}>USD -
                                                US Dollar</option>
                                        </select>
                                        @error('currency')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="price" class="form-label">Adult Price <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" step="0.01" min="0"
                                                    class="form-control @error('price') is-invalid @enderror"
                                                    id="price" name="price"
                                                    value="{{ old('price', $package->price) }}" required>
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
                                                    id="child_price" name="child_price"
                                                    value="{{ old('child_price', $package->child_price) }}">
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
                                    <div class="image-preview mb-3"
                                        style="min-height: 250px; border: 2px dashed #ddd; display: flex; align-items: center; justify-content: center;">
                                        @if ($package->featured_image)
                                            <img id="image-preview"
                                                src="{{ asset('storage/' . $package->featured_image) }}" alt="Preview"
                                                style="max-width: 100%; max-height: 250px;">
                                        @else
                                            <img id="image-preview" src="#" alt="Preview"
                                                style="max-width: 100%; max-height: 250px; display: none;">
                                            <div id="image-placeholder" class="text-muted">
                                                <i class="ri-upload-2-line" style="font-size: 48px;"></i>
                                                <p class="mt-2">Upload featured image</p>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="file"
                                        class="form-control @error('featured_image') is-invalid @enderror"
                                        id="featured_image" name="featured_image" accept="image/*"
                                        onchange="openCropModal(event, 'featured')">
                                    @error('featured_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Max file size: 5MB. Recommended: 1200x800px. Click to crop after selecting.</div>
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
                                    <h5 class="card-title mb-0">What's Excluded</h5>
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
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h5 class="card-title mb-0"><i class="ri-price-tag-3-line"></i> Tags</h5>
                                </div>
                                <div class="card-body">
                                    <label for="tags" class="form-label">Select Tags</label>
                                    <select id="tags" name="tags[]" class="form-select" multiple>
                                        @if (isset($tags) && $tags->count() > 0)
                                            @foreach ($tags as $type => $typeTags)
                                                <optgroup label="{{ ucfirst($type) }}">
                                                    @foreach ($typeTags as $tag)
                                                        <option value="{{ $tag->id }}"
                                                            {{ collect(old('tags', $package->tags->pluck('id')->toArray()))->contains($tag->id) ? 'selected' : '' }}>
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
                            <!-- Settings -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Settings</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select @error('status') is-invalid @enderror" id="status"
                                            name="status">
                                            <option value="draft"
                                                {{ old('status', $package->status) === 'draft' ? 'selected' : '' }}>Draft
                                            </option>
                                            <option value="active"
                                                {{ old('status', $package->status) === 'active' ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="inactive"
                                                {{ old('status', $package->status) === 'inactive' ? 'selected' : '' }}>
                                                Inactive</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
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
                                        <input type="text"
                                            class="form-control @error('meta_title') is-invalid @enderror"
                                            id="meta_title" name="meta_title"
                                            value="{{ old('meta_title', $package->meta_title) }}" maxlength="60">
                                        @error('meta_title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Recommended: 50-60 characters</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="meta_description" class="form-label">Meta Description</label>
                                        <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description"
                                            name="meta_description" rows="3" maxlength="160">{{ old('meta_description', $package->meta_description) }}</textarea>
                                        @error('meta_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Recommended: 150-160 characters</div>
                                    </div>

                                    <div class="mb-0">
                                        <label for="keywords" class="form-label">Keywords</label>
                                        <input type="text"
                                            class="form-control @error('keywords') is-invalid @enderror" id="keywords"
                                            name="keywords" value="{{ old('keywords', $package->keywords) }}"
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
                            <i class="ri-save-line"></i> Update Package
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
                    <i class="ri-upload-2-line" style="font-size: 32px;"></i>
                    <p class="mt-1 mb-0" style="font-size: 0.875rem;">Upload image</p>
                </div>
            </div>
            <input type="file" class="form-control form-control-sm" 
                   id="gallery-file-${galleryCounter}"
                   data-gallery-id="${galleryCounter}"
                   accept="image/*"
                   onchange="openCropModal(event, 'gallery', ${galleryCounter})">
            <input type="hidden" name="gallery_images_data[]" id="gallery-data-${galleryCounter}">
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
    const container = document.getElementById('itinerary-container');
    const existingDays = container.querySelectorAll('.border.rounded.p-3.mb-3');
    dayCounter = existingDays.length + 1;
    const dayHtml = `
        <div class="border rounded p-3 mb-3" id="day-${dayCounter}">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Day ${dayCounter}</h6>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeDay(${dayCounter})">
                    <i class="ri-delete-bin-line"></i> Remove Day
                </button>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" name="itinerary[${dayCounter}][day_title]" placeholder="Day title/description (e.g. NORTH-WEST SIDE AND EAST SIDE)">
            </div>
            <div class="mb-2">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="form-label mb-0"><strong>Items:</strong></label>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addDayItem(${dayCounter})">
                        <i class="ri-add-line"></i> Add Item
                    </button>
                </div>
                <div id="day-${dayCounter}-items" class="ms-4">
                    <div class="item-group mb-2" id="day-${dayCounter}-item-0">
                        <input type="text" class="form-control form-control-sm" name="itinerary[${dayCounter}][items][0][title]" placeholder="Item 1">
                    </div>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', dayHtml);
}

// Add item to a specific day
function addDayItem(dayId) {
    const itemsContainer = document.getElementById(`day-${dayId}-items`);
    const currentItems = itemsContainer.querySelectorAll('.item-group');
    const newItemIndex = currentItems.length;
    const itemHtml = `
        <div class="item-group mb-2" id="day-${dayId}-item-${newItemIndex}">
            <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="itinerary[${dayId}][items][${newItemIndex}][title]" placeholder="Item ${newItemIndex + 1}">
                <button type="button" class="btn btn-outline-danger" onclick="removeDayItem(${dayId}, ${newItemIndex})">
                    <i class="ri-delete-bin-line"></i>
                </button>
            </div>
        </div>
    `;
    itemsContainer.insertAdjacentHTML('beforeend', itemHtml);
}

// Remove a specific item from a day
function removeDayItem(dayId, itemIndex) {
    document.getElementById(`day-${dayId}-item-${itemIndex}`).remove();
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

// Character counter function
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

// Initialize with first items or load existing data
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('itinerary-container');
    const oldItinerary = @json(old('itinerary', []));
    const hasOldData = Object.keys(oldItinerary).length > 0;

    if (hasOldData) {
        Object.keys(oldItinerary).forEach(function(dayNum) {
            dayCounter++;
            const dayData = oldItinerary[dayNum] || {};
            const dayTitle = dayData.day_title || '';
            const items = dayData.items || {};

            let itemsHtml = '';
            const itemKeys = Object.keys(items);
            if (itemKeys.length > 0) {
                itemKeys.forEach(function(itemIdx) {
                    const item = items[itemIdx] || {};
                    itemsHtml += `
                        <div class="item-group mb-2" id="day-${dayCounter}-item-${itemIdx}">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" name="itinerary[${dayCounter}][items][${itemIdx}][title]" value="${item.title || ''}" placeholder="Item ${parseInt(itemIdx, 10) + 1}">
                                <button type="button" class="btn btn-outline-danger" onclick="removeDayItem(${dayCounter}, ${itemIdx})">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </div>
                    `;
                });
            } else {
                itemsHtml = `
                    <div class="item-group mb-2" id="day-${dayCounter}-item-0">
                        <input type="text" class="form-control form-control-sm" name="itinerary[${dayCounter}][items][0][title]" placeholder="Item 1">
                    </div>
                `;
            }

            const dayHtml = `
                <div class="border rounded p-3 mb-3" id="day-${dayCounter}">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">Day ${dayCounter}</h6>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeDay(${dayCounter})">
                            <i class="ri-delete-bin-line"></i> Remove Day
                        </button>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="itinerary[${dayCounter}][day_title]" value="${dayTitle}" placeholder="Day title/description (e.g. NORTH-WEST SIDE AND EAST SIDE)">
                    </div>
                    <div class="mb-2">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label mb-0"><strong>Items:</strong></label>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addDayItem(${dayCounter})">
                                <i class="ri-add-line"></i> Add Item
                            </button>
                        </div>
                        <div id="day-${dayCounter}-items" class="ms-4">
                            ${itemsHtml}
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', dayHtml);
        });
    } else {
        const itinerariesRaw = {!! json_encode($package->itineraries ?? []) !!} || [];
        if (itinerariesRaw.length > 0) {
            itinerariesRaw.forEach(function(itinerary) {
                dayCounter++;
                const displayDayNumber = itinerary.day_number || dayCounter;
                const dayTitle = itinerary.day_title || '';
                const items = itinerary.items || [];

                let itemsHtml = '';
                if (items.length > 0) {
                    items.forEach(function(item, idx) {
                        itemsHtml += `
                            <div class="item-group mb-2" id="day-${dayCounter}-item-${idx}">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" name="itinerary[${dayCounter}][items][${idx}][title]" value="${item.title || ''}" placeholder="Item ${idx + 1}">
                                    <button type="button" class="btn btn-outline-danger" onclick="removeDayItem(${dayCounter}, ${idx})">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    itemsHtml = `
                        <div class="item-group mb-2" id="day-${dayCounter}-item-0">
                            <input type="text" class="form-control form-control-sm" name="itinerary[${dayCounter}][items][0][title]" placeholder="Item 1">
                        </div>
                    `;
                }

                const dayHtml = `
                    <div class="border rounded p-3 mb-3" id="day-${dayCounter}">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Day ${displayDayNumber}</h6>
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeDay(${dayCounter})">
                                <i class="ri-delete-bin-line"></i> Remove Day
                            </button>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="itinerary[${dayCounter}][day_title]" value="${dayTitle}" placeholder="Day title/description (e.g. NORTH-WEST SIDE AND EAST SIDE)">
                        </div>
                        <div class="mb-2">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label mb-0"><strong>Items:</strong></label>
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="addDayItem(${dayCounter})">
                                    <i class="ri-add-line"></i> Add Item
                                </button>
                            </div>
                            <div id="day-${dayCounter}-items" class="ms-4">
                                ${itemsHtml}
                            </div>
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', dayHtml);
            });
        } else {
            addItineraryDay();
        }
    }

    const inclusionData = {!! json_encode(old('inclusions') ?? ($package->inclusions->pluck('description') ?? [])) !!} || [];
    const exclusionData = {!! json_encode(old('exclusions') ?? ($package->exclusions->pluck('description') ?? [])) !!} || [];
    const galleryData = {!! json_encode($package->galleries ?? []) !!} || [];

    if (Array.isArray(inclusionData) && inclusionData.length > 0) {
        inclusionData.forEach(function(inclusion) {
            inclusionCounter++;
            const incValue = inclusion || '';
            const inclusionHtml = document.createElement('div');
            inclusionHtml.className = 'input-group mb-2';
            inclusionHtml.id = 'inclusion-' + inclusionCounter;
            inclusionHtml.innerHTML = `
                <span class="input-group-text"><i class="ri-check-line text-success"></i></span>
                <input type="text" class="form-control" name="inclusions[]" value="" placeholder="e.g., Hotel pickup and drop-off">
                <button type="button" class="btn btn-outline-danger" onclick="removeInclusion(${inclusionCounter})">
                    <i class="ri-delete-bin-line"></i>
                </button>
            `;
            document.getElementById('inclusions-container').appendChild(inclusionHtml);
            inclusionHtml.querySelector('input[name="inclusions[]"]').value = incValue;
        });
    }

    if (Array.isArray(exclusionData) && exclusionData.length > 0) {
        exclusionData.forEach(function(exclusion) {
            exclusionCounter++;
            const excValue = exclusion || '';
            const exclusionHtml = document.createElement('div');
            exclusionHtml.className = 'input-group mb-2';
            exclusionHtml.id = 'exclusion-' + exclusionCounter;
            exclusionHtml.innerHTML = `
                <span class="input-group-text"><i class="ri-close-line text-danger"></i></span>
                <input type="text" class="form-control" name="exclusions[]" value="" placeholder="e.g., Personal expenses">
                <button type="button" class="btn btn-outline-danger" onclick="removeExclusion(${exclusionCounter})">
                    <i class="ri-delete-bin-line"></i>
                </button>
            `;
            document.getElementById('exclusions-container').appendChild(exclusionHtml);
            exclusionHtml.querySelector('input[name="exclusions[]"]').value = excValue;
        });
    }

    if (Array.isArray(galleryData) && galleryData.length > 0) {
        galleryData.forEach(function(gallery) {
            galleryCounter++;
            const src = "{{ asset('storage') }}/" + gallery.image_path;
            const galleryHtml = `
                <div class="border rounded p-3 mb-3" id="gallery-${galleryCounter}" data-gallery-id="${gallery.id}">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Image ${galleryCounter}</h6>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeExistingGallery(${galleryCounter}, ${gallery.id})">
                            <i class="ri-delete-bin-line"></i> Delete
                        </button>
                    </div>
                    <div class="image-preview mb-2" style="min-height: 150px; border: 2px dashed #ddd; display: flex; align-items: center; justify-content: center;">
                        <img src="${src}" alt="Gallery" style="max-width: 100%; max-height: 150px;">
                    </div>
                    <input type="hidden" name="existing_galleries[]" value="${gallery.id}">
                    <div class="form-text">Existing image - click delete to remove</div>
                </div>
            `;
            document.getElementById('gallery-container').insertAdjacentHTML('beforeend', galleryHtml);
        });
    }
});

// Remove existing gallery image (mark for deletion)
function removeExistingGallery(galleryId, dbId) {
    const galleryDiv = document.getElementById(`gallery-${galleryId}`);
    const form = document.getElementById('packageForm');
    const deleteInput = document.createElement('input');
    deleteInput.type = 'hidden';
    deleteInput.name = 'delete_galleries[]';
    deleteInput.value = dbId;
    form.appendChild(deleteInput);
    galleryDiv.remove();
}

// Save as draft
function saveDraft() {
    document.getElementById('status').value = 'draft';
    document.getElementById('packageForm').submit();
}

// Debug: Log form data before submission
document.getElementById('packageForm').addEventListener('submit', function(e) {
    const formData = new FormData(this);
    console.log('=== FORM SUBMISSION DEBUG ===');
    const itineraryData = {};
    for (let [key, value] of formData.entries()) {
        if (key.startsWith('itinerary[')) {
            console.log(key, '=', value);
            itineraryData[key] = value;
        }
    }
    console.log('Total itinerary fields:', Object.keys(itineraryData).length);
    console.log('=== END DEBUG ===');
});

// Auto-generate meta title from name
document.getElementById('name').addEventListener('input', function() {
    const metaTitle = document.getElementById('meta_title');
    if (!metaTitle.value) {
        metaTitle.value = this.value;
    }
});

// Initialize character counters
addCharacterCounter('meta_title', 60);
addCharacterCounter('meta_description', 160);
</script>

<!-- Crop Modal -->
<div class="modal fade crop-modal" id="cropModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crop Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 text-center aspect-ratio-btns">
                    <label class="form-label d-block mb-2">Aspect Ratio:</label>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="setAspectRatio(1)">1:1</button>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="setAspectRatio(16/9)">16:9</button>
                    <button type="button" class="btn btn-sm btn-outline-primary active" onclick="setAspectRatio(NaN)">Free</button>
                </div>
                <div class="crop-container">
                    <img id="crop-image" src="" alt="Crop">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="applyCrop()">Apply Crop</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<script>
let cropper = null;
let currentCropType = null;
let currentGalleryId = null;

function openCropModal(event, type, galleryId = null) {
    const file = event.target.files[0];
    if (!file) return;
    
    currentCropType = type;
    currentGalleryId = galleryId;
    
    const reader = new FileReader();
    reader.onload = function(e) {
        const image = document.getElementById('crop-image');
        image.src = e.target.result;
        
        if (cropper) {
            cropper.destroy();
        }
        
        const modal = new bootstrap.Modal(document.getElementById('cropModal'));
        modal.show();
        
        document.getElementById('cropModal').addEventListener('shown.bs.modal', function() {
            cropper = new Cropper(image, {
                aspectRatio: NaN,
                viewMode: 1,
                autoCropArea: 1,
                responsive: true,
                background: false
            });
        }, { once: true });
    };
    reader.readAsDataURL(file);
}

function setAspectRatio(ratio) {
    if (cropper) {
        cropper.setAspectRatio(ratio);
    }
    document.querySelectorAll('.aspect-ratio-btns .btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
}

function applyCrop() {
    if (!cropper) return;
    
    const canvas = cropper.getCroppedCanvas({
        maxWidth: 1920,
        maxHeight: 1920,
        imageSmoothingEnabled: true,
        imageSmoothingQuality: 'high'
    });
    
    const base64Data = canvas.toDataURL('image/jpeg', 0.9);
    
    if (currentCropType === 'featured') {
        document.getElementById('featured_image_data').value = base64Data;
        const preview = document.getElementById('image-preview');
        const placeholder = document.getElementById('image-placeholder');
        preview.src = base64Data;
        preview.style.display = 'block';
        if (placeholder) placeholder.style.display = 'none';
    } else if (currentCropType === 'gallery' && currentGalleryId !== null) {
        document.getElementById(`gallery-data-${currentGalleryId}`).value = base64Data;
        const preview = document.getElementById(`gallery-preview-${currentGalleryId}`);
        const placeholder = document.getElementById(`gallery-placeholder-${currentGalleryId}`);
        if (preview && placeholder) {
            preview.src = base64Data;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        }
    }
    
    bootstrap.Modal.getInstance(document.getElementById('cropModal')).hide();
    cropper.destroy();
    cropper = null;
}

document.getElementById('cropModal').addEventListener('hidden.bs.modal', function() {
    if (cropper) {
        cropper.destroy();
        cropper = null;
    }
});

// Auto-switch to tab with validation errors
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('packageForm');
    const invalidFields = form.querySelectorAll('.is-invalid');
    
    if (invalidFields.length > 0) {
        // Map fields to their tabs
        const fieldToTab = {
            'name': 'basic-tab',
            'description': 'basic-tab',
            'category_id': 'basic-tab',
            'duration_days': 'basic-tab',
            'included_nights': 'basic-tab',
            'destination': 'basic-tab',
            'currency': 'basic-tab',
            'base_price': 'basic-tab',
            'selling_price': 'basic-tab',
            'featured_image': 'images-tab',
            'meta_title': 'settings-tab',
            'meta_description': 'settings-tab',
            'meta_keywords': 'settings-tab'
        };
        
        // Get the first invalid field
        const firstInvalidField = invalidFields[0];
        const fieldName = firstInvalidField.name;
        const tabId = fieldToTab[fieldName];
        
        if (tabId) {
            // Switch to the appropriate tab
            const tabButton = document.getElementById(tabId);
            if (tabButton) {
                const tab = new bootstrap.Tab(tabButton);
                tab.show();
                
                // Scroll to the field after tab switch
                setTimeout(() => {
                    firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstInvalidField.focus();
                }, 100);
            }
        }
    }
});
</script>
@endpush
