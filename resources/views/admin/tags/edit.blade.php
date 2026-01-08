@extends('layouts.admin')

@section('title', 'Edit Tag')

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
            <h4 class="page-title mb-1">Edit Tag</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.tags.index') }}">Tags</a></li>
                <li class="breadcrumb-item active">Edit</li>
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

                <form action="{{ route('admin.tags.update', $tag) }}" method="POST" enctype="multipart/form-data" id="tagForm">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Tag Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $tag->name) }}"
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
                            <option value="destination" {{ old('type', $tag->type) === 'destination' ? 'selected' : '' }}>
                                Destination (e.g. Bali, Java, Lombok)
                            </option>
                            <option value="activity" {{ old('type', $tag->type) === 'activity' ? 'selected' : '' }}>
                                Activity (e.g. Beach, Cultural, Adventure)
                            </option>
                            <option value="theme" {{ old('type', $tag->type) === 'theme' ? 'selected' : '' }}>
                                Theme (e.g. Luxury, Budget, Family)
                            </option>
                            <option value="duration" {{ old('type', $tag->type) === 'duration' ? 'selected' : '' }}>
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
                                           value="{{ old('color', $tag->color) }}"
                                           style="width: 80px;">
                                    <input type="text" 
                                           class="form-control" 
                                           id="colorText" 
                                           value="{{ old('color', $tag->color) }}"
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
                                  placeholder="Brief description of this tag">{{ old('description', $tag->description) }}</textarea>
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
                                       value="{{ old('sort_order', $tag->sort_order) }}"
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
                                           {{ old('is_active', $tag->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Active
                                    </label>
                                </div>
                                <small class="text-muted">Only active tags appear on landing page</small>
                            </div>
                        </div>
                    </div>

                    <!-- Gallery Section (Only for Destination Type) -->
                    <div id="gallerySection" style="display: {{ $tag->type === 'destination' ? 'block' : 'none' }};">
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
                            <i class="ri-save-line me-1"></i> Update Tag
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if($tag->packages()->count() > 0)
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Packages Using This Tag ({{ $tag->packages()->count() }})</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    @foreach($tag->packages()->take(5)->get() as $package)
                    <a href="{{ route('admin.packages.edit', $package) }}" 
                       class="list-group-item list-group-item-action">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">{{ $package->title }}</h6>
                                <small class="text-muted">{{ $package->category }}</small>
                            </div>
                            <i class="ri-arrow-right-line"></i>
                        </div>
                    </a>
                    @endforeach
                </div>
                @if($tag->packages()->count() > 5)
                <div class="text-center mt-3">
                    <a href="{{ route('admin.tags.show', $tag) }}" class="btn btn-sm btn-outline-primary">
                        View All {{ $tag->packages()->count() }} Packages
                    </a>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Preview</h5>
            </div>
            <div class="card-body">
                <div id="tagPreview" class="text-center p-4">
                    <span class="badge" style="font-size: 1.2rem; padding: 0.6rem 1.2rem; background-color: {{ $tag->color }};">
                        <span id="previewName">{{ $tag->name }}</span>
                    </span>
                    <p class="text-muted mt-3 mb-0" id="previewDescription">
                        {{ $tag->description ?: 'No description' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Statistics</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Total Packages</small>
                    <h4>{{ $tag->packages()->count() }}</h4>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Created At</small>
                    <p class="mb-0">{{ $tag->created_at->format('d M Y H:i') }}</p>
                </div>
                <div>
                    <small class="text-muted">Last Updated</small>
                    <p class="mb-0">{{ $tag->updated_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteGalleryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this image? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete Image</button>
            </div>
        </div>
    </div>
</div>
@endsection

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
    const color = document.getElementById('color').value;
    const description = document.getElementById('description').value || 'No description';
    
    document.getElementById('previewName').textContent = name;
    document.getElementById('previewDescription').textContent = description;
    document.querySelector('#tagPreview .badge').style.backgroundColor = color;
}

// Update preview on input
document.getElementById('name').addEventListener('input', updatePreview);
document.getElementById('description').addEventListener('input', updatePreview);
document.getElementById('color').addEventListener('input', updatePreview);

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
let deleteModal;
let currentDeleteGalleryId = null;

function addGalleryImage() {
    galleryCounter++;
    const container = document.getElementById('gallery-container');
    const imageHtml = `
        <div class="border rounded p-3 mb-3" id="gallery-${galleryCounter}">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">New Image ${galleryCounter}</h6>
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

function showDeleteModal(galleryId) {
    currentDeleteGalleryId = galleryId;
    deleteModal.show();
}

function deleteGalleryViaAjax() {
    if (!currentDeleteGalleryId) return;

    const tagId = {{ $tag->id }};
    
    fetch(`/admin/tags/${tagId}/gallery/${currentDeleteGalleryId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Delete failed');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Hapus dari DOM
            const galleryDiv = document.querySelector(`[data-gallery-id="${currentDeleteGalleryId}"]`);
            if (galleryDiv) {
                galleryDiv.remove();
            }
            deleteModal.hide();
            
            // Tampilkan success message
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success alert-dismissible fade show';
            alertDiv.innerHTML = `
                <i class="ri-check-line me-2"></i> Image deleted successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.querySelector('.card').insertAdjacentElement('beforebegin', alertDiv);
            setTimeout(() => alertDiv.remove(), 3000);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to delete image. Please try again.');
    });
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

// Load existing galleries
document.addEventListener('DOMContentLoaded', function() {
    // Initialize delete modal
    deleteModal = new bootstrap.Modal(document.getElementById('deleteGalleryModal'));
    
    const galleryData = @json($tag->galleries ?? []);
    
    if (Array.isArray(galleryData) && galleryData.length > 0) {
        galleryData.forEach(function(gallery) {
            galleryCounter++;
            const src = "{{ asset('storage') }}/" + gallery.image_path;
            const galleryHtml = `
                <div class="border rounded p-3 mb-3" id="gallery-${galleryCounter}" data-gallery-id="${gallery.id}">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Image ${galleryCounter}</h6>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="showDeleteModal(${gallery.id})">
                            <i class="ri-delete-bin-line"></i> Delete
                        </button>
                    </div>
                    <div class="image-preview mb-2" style="min-height: 150px; border: 2px dashed #ddd; display: flex; align-items: center; justify-content: center;">
                        <img src="${src}" alt="Gallery" style="max-width: 100%; max-height: 150px;">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Caption</label>
                        <input type="text" class="form-control form-control-sm" 
                               name="existing_gallery_captions[${gallery.id}]"
                               value="${gallery.caption || ''}" 
                               placeholder="e.g., Beautiful sunset at Tanah Lot">
                    </div>
                    <div class="form-text">Existing image - edit caption or click delete to remove</div>
                </div>
            `;
            document.getElementById('gallery-container').insertAdjacentHTML('beforeend', galleryHtml);
        });
    }
});

// Setup delete button in modal
document.addEventListener('DOMContentLoaded', function() {
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', deleteGalleryViaAjax);
    }
});
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
let currentGalleryId = null;

function openCropModal(event, type, galleryId = null) {
    const file = event.target.files[0];
    if (!file) return;
    
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
    
    document.getElementById(`gallery-data-${currentGalleryId}`).value = base64Data;
    
    const preview = document.getElementById(`gallery-preview-${currentGalleryId}`);
    const img = document.getElementById(`gallery-img-${currentGalleryId}`);
    if (preview && img) {
        img.src = base64Data;
        preview.style.display = 'flex';
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
</script>
@endpush
