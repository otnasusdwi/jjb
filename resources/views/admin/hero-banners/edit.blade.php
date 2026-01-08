@extends('layouts.admin')

@section('title', 'Edit Hero Banner')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
<style>
.crop-modal .modal-dialog { max-width: 900px; }
.crop-container { max-height: 500px; overflow: hidden; }
.crop-container img { max-width: 100%; display: block; }
.aspect-ratio-btns .btn { margin: 0 5px; }
.image-preview-box { min-height: 250px; border: 2px dashed #ddd; display: flex; align-items: center; justify-content: center; border-radius: 8px; }
.image-preview-box img { max-width: 100%; max-height: 250px; object-fit: contain; }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-title-box mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4 class="page-title mb-1">Edit Hero Banner</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.hero-banners.index') }}">Hero Banners</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
            <div class="col-md-4">
                <div class="float-end">
                    <a href="{{ route('admin.hero-banners.index') }}" class="btn btn-outline-secondary">
                        <i class="ri-arrow-left-line me-1"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.hero-banners.update', $heroBanner) }}" method="POST" enctype="multipart/form-data" id="bannerForm">
        @csrf
        @method('PUT')

        <!-- Hidden input for cropped base64 image -->
        <input type="hidden" name="image_data" id="image_data">

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Banner Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Banner Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ old('title', $heroBanner->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="subtitle" class="form-label">Subtitle (Optional)</label>
                            <input type="text" class="form-control @error('subtitle') is-invalid @enderror"
                                   id="subtitle" name="subtitle" value="{{ old('subtitle', $heroBanner->subtitle) }}">
                            @error('subtitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description (Optional)</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="4">{{ old('description', $heroBanner->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="order" class="form-label">Display Order</label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror"
                                   id="order" name="order" value="{{ old('order', $heroBanner->order) }}" min="0">
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="hidden" name="is_active" id="is_active_hidden" value="0">
                            <input type="checkbox" class="form-check-input" id="is_active" 
                                   {{ old('is_active', $heroBanner->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Banner Image</h5>
                        <small class="text-muted d-block mt-2">Aspect Ratio: 16:9 (1920x1080px)</small>
                    </div>
                    <div class="card-body">
                        <div class="image-preview-box mb-3">
                            <img id="image-preview" src="{{ asset('storage/' . $heroBanner->image_path) }}" alt="Current Image">
                        </div>

                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                               id="image" name="image" accept="image/*" onchange="openCropModal(event)">
                        @error('image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                        <div class="form-text mt-2">
                            <small>Max file size: 5MB. Recommended: 1920x1080px (16:9)</small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ri-save-line me-1"></i> Update Banner
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Crop Modal -->
<div class="modal fade crop-modal" id="cropModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crop Hero Banner Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 text-center aspect-ratio-btns">
                    <label class="form-label d-block mb-2">Aspect Ratio (16:9 locked for hero):</label>
                    <button type="button" class="btn btn-sm btn-primary" disabled>16:9 (Hero)</button>
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

function openCropModal(event) {
    const file = event.target.files[0];
    if (!file) return;
    
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
                aspectRatio: 16 / 9,
                viewMode: 1,
                autoCropArea: 1,
                responsive: true,
                background: false,
                guides: true,
                gridLines: true,
            });
        }, { once: true });
    };
    reader.readAsDataURL(file);
}

function applyCrop() {
    if (!cropper) return;
    
    const canvas = cropper.getCroppedCanvas({
        maxWidth: 1920,
        maxHeight: 1080,
        imageSmoothingEnabled: true,
        imageSmoothingQuality: 'high'
    });
    
    // Reduce quality to 0.65 to keep base64 size manageable
    const base64Data = canvas.toDataURL('image/jpeg', 0.65);
    document.getElementById('image_data').value = base64Data;
    
    const preview = document.getElementById('image-preview');
    preview.src = base64Data;
    
    bootstrap.Modal.getInstance(document.getElementById('cropModal')).hide();
    cropper.destroy();
    cropper = null;
}

// Form submission handler
document.getElementById('bannerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Set is_active hidden field based on checkbox
    const isActiveCheckbox = document.getElementById('is_active');
    document.getElementById('is_active_hidden').value = isActiveCheckbox.checked ? '1' : '0';
    
    // Get form data
    const formData = new FormData(this);
    const action = this.action;
    const method = this.method;
    
    // Submit via fetch for better handling
    fetch(action, {
        method: method.toUpperCase(),
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        },
        credentials: 'same-origin'
    })
    .then(response => {
        // Check if redirect happened (success)
        if (response.ok || response.redirected) {
            window.location.href = response.url || '{{ route("admin.hero-banners.index") }}';
        } else if (response.status === 422) {
            // Validation error
            return response.text().then(html => {
                document.body.innerHTML = html;
            });
        } else {
            throw new Error('HTTP error, status = ' + response.status);
        }
    })
    .catch(error => {
        console.error('Form submission error:', error);
        alert('Error submitting form: ' + error.message);
    });
});

document.getElementById('cropModal').addEventListener('hidden.bs.modal', function() {
    if (cropper) {
        cropper.destroy();
        cropper = null;
    }
});
</script>
@endsection
