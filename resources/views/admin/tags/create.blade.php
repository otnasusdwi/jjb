@extends('layouts.admin')

@section('title', 'Create Tag')

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
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h4 class="page-title mb-1">Create Tag</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.tags.index') }}">Tags</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Tag Information</h5>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h5 class="alert-heading"><i class="ri-error-warning-line me-2"></i>Validation Errors</h5>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="ri-error-warning-line me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('admin.tags.store') }}" method="POST" enctype="multipart/form-data" id="tagForm">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Tag Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               placeholder="e.g. Bali Island, Cultural Tour, Luxury Trip"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Tag Type <span class="text-danger">*</span></label>
                        <select class="form-select @error('type') is-invalid @enderror" 
                                id="type" 
                                name="type" 
                                required>
                            <option value="">Select Type</option>
                            <option value="destination" {{ old('type') === 'destination' ? 'selected' : '' }}>
                                Destination (e.g. Bali, Java, Lombok)
                            </option>
                            <option value="activity" {{ old('type') === 'activity' ? 'selected' : '' }}>
                                Activity (e.g. Beach, Cultural, Adventure)
                            </option>
                            <option value="theme" {{ old('type') === 'theme' ? 'selected' : '' }}>
                                Theme (e.g. Luxury, Budget, Family)
                            </option>
                            <option value="duration" {{ old('type') === 'duration' ? 'selected' : '' }}>
                                Duration (e.g. 1 Day, 2-3 Days, Week)
                            </option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="color" class="form-label">Color <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="color" 
                                           class="form-control form-control-color @error('color') is-invalid @enderror" 
                                           id="color" 
                                           name="color" 
                                           value="{{ old('color', '#FF8C00') }}"
                                           style="width: 80px;">
                                    <input type="text" 
                                           class="form-control" 
                                           id="colorText" 
                                           value="{{ old('color', '#FF8C00') }}"
                                           readonly>
                                </div>
                                @error('color')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Choose a color for this tag badge</small>
                            </div>
                        </div>

                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="3"
                                  placeholder="Brief description of this tag">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sort_order" class="form-label">Sort Order</label>
                                <input type="number" 
                                       class="form-control @error('sort_order') is-invalid @enderror" 
                                       id="sort_order" 
                                       name="sort_order" 
                                       value="{{ old('sort_order', 0) }}"
                                       min="0">
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Lower numbers appear first</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="is_active" 
                                           name="is_active" 
                                           value="1"
                                           {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Active
                                    </label>
                                </div>
                                <small class="text-muted">Only active tags appear on landing page</small>
                            </div>
                        </div>
                    </div>

                    <!-- Gallery Section (Only for Destination Type) -->
                    <div id="gallerySection" style="display: none;">
                        <hr class="my-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Gallery Images</h6>
                            <button type="button" class="btn btn-sm btn-primary" onclick="addGalleryImage()">
                                <i class="ri-add-line"></i> Add Image
                            </button>
                        </div>
                        <div id="gallery-container"></div>
                        <small class="text-muted">Add photos to showcase this destination. Recommended: 1200x800px, Max 2MB per image</small>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">
                            <i class="ri-arrow-left-line me-1"></i> Back
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ri-save-line me-1"></i> Create Tag
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Preview</h5>
            </div>
            <div class="card-body">
                <div id="tagPreview" class="text-center p-4">
                    <span class="badge" style="font-size: 1.2rem; padding: 0.6rem 1.2rem; background-color: #FF8C00;">
                        <span id="previewName">Tag Preview</span>
                    </span>
                    <p class="text-muted mt-3 mb-0" id="previewDescription">
                        Enter tag details to see preview
                    </p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Tips</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="ri-check-line text-success me-2"></i>
                        Use clear, descriptive names
                    </li>
                    <li class="mb-2">
                        <i class="ri-check-line text-success me-2"></i>
                        Choose contrasting colors for readability
                    </li>
                    <li class="mb-2">
                        <i class="ri-check-line text-success me-2"></i>
                        Add emojis to make tags more appealing
                    </li>
                    <li class="mb-0">
                        <i class="ri-check-line text-success me-2"></i>
                        Write brief, helpful descriptions
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

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

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<script>
let cropper = null;
let currentGalleryId = null;

function openCropModal(event, type, galleryId = null) {
    const file = event.target.files[0];
    if (!file) return;
    
    currentGalleryId = galleryId;
    
    const reader = new FileReader();
    reader.onload = function(e) {
        const image = document.getElementById('crop-image');
        image.src = e.target.result;
        
        // Destroy existing cropper
        if (cropper) {
            cropper.destroy();
        }
        
        // Initialize modal
        const modal = new bootstrap.Modal(document.getElementById('cropModal'));
        modal.show();
        
        // Wait for modal to be shown before initializing cropper
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
    // Update button states
    document.querySelectorAll('.aspect-ratio-btns .btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
}

function applyCrop() {
    if (!cropper) return;
    
    // Get cropped canvas
    const canvas = cropper.getCroppedCanvas({
        maxWidth: 1920,
        maxHeight: 1920,
        imageSmoothingEnabled: true,
        imageSmoothingQuality: 'high'
    });
    
    // Convert to base64
    const base64Data = canvas.toDataURL('image/jpeg', 0.9);
    
    // Set gallery image data
    document.getElementById(`gallery-data-${currentGalleryId}`).value = base64Data;
    
    // Update preview
    const preview = document.getElementById(`gallery-preview-${currentGalleryId}`);
    const previewImg = document.getElementById(`gallery-img-${currentGalleryId}`);
    if (preview && previewImg) {
        previewImg.src = base64Data;
        preview.style.display = 'flex';
    }
    
    // Close modal
    bootstrap.Modal.getInstance(document.getElementById('cropModal')).hide();
    
    // Destroy cropper
    cropper.destroy();
    cropper = null;
}

// Clean up on modal hide
document.getElementById('cropModal').addEventListener('hidden.bs.modal', function() {
    if (cropper) {
        cropper.destroy();
        cropper = null;
    }
});
</script>
@endpush

@push('scripts')
<script>
// Color picker sync
const colorPicker = document.getElementById('color');
const colorText = document.getElementById('colorText');

colorPicker.addEventListener('input', function() {
    colorText.value = this.value;
    updatePreview();
});

// Live preview
function updatePreview() {
    const name = document.getElementById('name').value || 'Tag Preview';
    const icon = document.getElementById('icon').value;
    const color = document.getElementById('color').value;
    const description = document.getElementById('description').value || 'Enter tag details to see preview';
    

// Show/hide gallery section based on tag type
const typeSelect = document.getElementById('type');
const gallerySection = document.getElementById('gallerySection');

typeSelect.addEventListener('change', function() {
    if (this.value === 'destination') {
        gallerySection.style.display = 'block';
    } else {
        gallerySection.style.display = 'none';
    }
});

// Gallery management
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
            <div class="mb-2">
                <label class="form-label">Image File</label>
                <input type="file" class="form-control form-control-sm" 
                       id="gallery-file-${galleryCounter}"
                       data-gallery-id="${galleryCounter}"
                       accept="image/*"
                       onchange="openCropModal(event, 'gallery', ${galleryCounter})">
                <input type="hidden" name="gallery_images_data[]" id="gallery-data-${galleryCounter}">
            </div>
            <div class="mb-2">
                <label class="form-label">Caption (Optional)</label>
                <input type="text" class="form-control form-control-sm" 
                       name="gallery_captions[]" 
                       placeholder="e.g., Beautiful sunset at Tanah Lot">
            </div>
            <div class="image-preview" id="gallery-preview-${galleryCounter}" style="min-height: 150px; border: 2px dashed #ddd; display: none; align-items: center; justify-content: center;">
                <img id="gallery-img-${galleryCounter}" src="#" alt="Preview" style="max-width: 100%; max-height: 150px;">
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', imageHtml);
}

function removeGalleryImage(imageId) {
    document.getElementById('gallery-' + imageId).remove();
}

function previewGalleryImage(event, imageId) {
    const file = event.target.files[0];
    const preview = document.getElementById('gallery-preview-' + imageId);
    const img = document.getElementById('gallery-img-' + imageId);

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            preview.style.display = 'flex';
        };
        reader.readAsDataURL(file);
    }
}
    function updatePreview() {
        const name = document.getElementById('name').value || 'Tag Preview';
        const color = document.getElementById('color').value || '#FF8C00';
        const description = document.getElementById('description').value || 'Enter tag details to see preview';
        
        document.getElementById('previewName').textContent = name;
        document.getElementById('previewDescription').textContent = description;
        document.querySelector('#tagPreview .badge').style.backgroundColor = color;
    }

    // Update preview on input
    document.getElementById('name').addEventListener('input', updatePreview);
    document.getElementById('description').addEventListener('input', updatePreview);
</script>
@endpush
