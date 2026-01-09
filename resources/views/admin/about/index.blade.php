@extends('layouts.admin')

@section('title', 'About Us Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">About Us Page Settings</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.about.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Page Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ $aboutPage->title }}" required>
                                    <small class="text-muted">Digunakan sebagai judul utama di halaman About.</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="meta_title" class="form-label">Promise / Meta Title</label>
                                    <input type="text" class="form-control" id="meta_title" name="meta_title" value="{{ $aboutPage->meta_title }}">
                                    <small class="text-muted">Dipakai sebagai tagline "Promise" di highlight serta judul SEO.</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control" id="meta_description" name="meta_description" rows="2">{{ $aboutPage->meta_description }}</textarea>
                            <small class="text-muted">Ringkasan pendek untuk SEO dan summary hero.</small>
                        </div>

                        <div class="mb-3">
                            <label for="hero_image" class="form-label">Hero Image</label>
                            <div class="image-upload-container">
                                <input type="file" class="form-control" id="hero_image_input" accept="image/*">
                                <input type="hidden" name="hero_image" id="hero_image_data" value="{{ old('hero_image') }}">
                                <small class="text-muted">Ditampilkan sebagai background hero di halaman About.</small>
                                
                                <!-- Image Preview -->
                                <div id="hero_image_preview" class="mt-3">
                                    @if($aboutPage->hero_image)
                                        <img src="{{ asset('storage/' . $aboutPage->hero_image) }}" alt="Hero Image" class="img-thumbnail" style="max-height: 200px;">
                                        <br>
                                        <small class="text-muted">Current image</small>
                                    @endif
                                </div>
                                
                                <!-- Cropper Modal -->
                                <div class="modal fade" id="heroImageCropperModal" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Crop Hero Image</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="cropper-container">
                                                    <img id="hero_image_cropper" style="max-width: 100%;">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn btn-primary" id="hero_image_crop_confirm">Crop & Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control tinymce-editor" id="description" name="description" rows="6">{{ $aboutPage->description }}</textarea>
                            <small class="text-muted">Konten utama "Who We Are".</small>
                        </div>

                        <div class="mb-3">
                            <label for="mission" class="form-label">Mission</label>
                            <textarea class="form-control tinymce-editor" id="mission" name="mission" rows="4">{{ $aboutPage->mission }}</textarea>
                            <small class="text-muted">Muncul di blok "Our Mission" pada halaman About.</small>
                        </div>

                        <div class="mb-3">
                            <label for="vision" class="form-label">Vision</label>
                            <textarea class="form-control tinymce-editor" id="vision" name="vision" rows="4">{{ $aboutPage->vision }}</textarea>
                            <small class="text-muted">Muncul di blok "Our Vision" pada halaman About.</small>
                        </div>

                        <div class="mb-3">
                            <label for="story" class="form-label">Our Story</label>
                            <textarea class="form-control tinymce-editor" id="story" name="story" rows="8">{{ $aboutPage->story }}</textarea>
                            <small class="text-muted">Ditampilkan pada bagian "Our Story" (background oranye).</small>
                        </div>

                        <!-- CEO Section -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">CEO Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="ceo_name" class="form-label">CEO Name</label>
                                            <input type="text" class="form-control" id="ceo_name" name="ceo_name" value="{{ $aboutPage->ceo_name }}" placeholder="Enter CEO name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="ceo_position" class="form-label">CEO Position</label>
                                            <input type="text" class="form-control" id="ceo_position" name="ceo_position" value="{{ $aboutPage->ceo_position }}" placeholder="e.g., Chief Executive Officer">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="ceo_message" class="form-label">CEO Message</label>
                                    <textarea class="form-control tinymce-editor" id="ceo_message" name="ceo_message" rows="4" placeholder="CEO's message or quote">{{ $aboutPage->ceo_message }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="ceo_image_input" class="form-label">CEO Photo</label>
                                    <div class="image-upload-container">
                                        <input type="file" class="form-control" id="ceo_image_input" accept="image/*">
                                        <input type="hidden" name="ceo_image" id="ceo_image_data" value="{{ old('ceo_image') }}">
                                        
                                        <!-- CEO Image Preview -->
                                        <div id="ceo_image_preview" class="mt-3">
                                            @if($aboutPage->ceo_image)
                                                <img src="{{ asset('storage/' . $aboutPage->ceo_image) }}" alt="CEO" class="img-thumbnail" style="max-height: 200px;">
                                                <br>
                                                <small class="text-muted">Current CEO image</small>
                                            @endif
                                        </div>
                                        
                                        <!-- CEO Cropper Modal -->
                                        <div class="modal fade" id="ceoImageCropperModal" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Crop CEO Photo</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="cropper-container">
                                                            <img id="ceo_image_cropper" style="max-width: 100%;">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="button" class="btn btn-primary" id="ceo_image_crop_confirm">Crop & Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <small class="text-muted">Recommended: Square image (1:1 ratio)</small>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.about.team.index') }}" class="btn btn-info">
                                <i class="fas fa-users"></i> Manage Team Members
                            </a>
                            <div>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tinymce@6.8.2/tinymce.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" rel="stylesheet">
<style>
.cropper-container {
    max-height: 400px;
    overflow: hidden;
}
.image-upload-container .img-thumbnail {
    cursor: pointer;
    transition: opacity 0.3s;
}
.image-upload-container .img-thumbnail:hover {
    opacity: 0.8;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.2/tinymce.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize TinyMCE
    tinymce.init({
        selector: '.tinymce-editor',
        height: 300,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | blocks | bold italic forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | help',
        content_style: 'body { font-family: Arial, sans-serif; font-size: 14px; }'
    });

    // Image Cropper functionality
    let heroCropper = null;
    const heroImageInput = document.getElementById('hero_image_input');
    const heroImageData = document.getElementById('hero_image_data');
    const heroImagePreview = document.getElementById('hero_image_preview');
    const heroImageCropperModal = new bootstrap.Modal(document.getElementById('heroImageCropperModal'));
    const heroImageCropperImg = document.getElementById('hero_image_cropper');

    // CEO Image Cropper
    let ceoCropper = null;
    const ceoImageInput = document.getElementById('ceo_image_input');
    const ceoImageData = document.getElementById('ceo_image_data');
    const ceoImagePreview = document.getElementById('ceo_image_preview');
    const ceoImageCropperModal = new bootstrap.Modal(document.getElementById('ceoImageCropperModal'));
    const ceoImageCropperImg = document.getElementById('ceo_image_cropper');

    heroImageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                heroImageCropperImg.src = e.target.result;
                heroImageCropperModal.show();
                
                // Initialize cropper
                if (heroCropper) {
                    heroCropper.destroy();
                }
                heroCropper = new Cropper(heroImageCropperImg, {
                    aspectRatio: 16/9,
                    viewMode: 1,
                    guides: true,
                    center: true,
                    highlight: false,
                    background: true,
                    autoCrop: true,
                    autoCropArea: 0.8,
                    movable: true,
                    rotatable: false,
                    scalable: true,
                    zoomable: true,
                    zoomOnTouch: true,
                    zoomOnWheel: true,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    toggleDragModeOnDblclick: true,
                });
            };
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('hero_image_crop_confirm').addEventListener('click', function() {
        if (heroCropper) {
            const canvas = heroCropper.getCroppedCanvas({
                width: 1920,
                height: 1080,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });
            
            if (canvas) {
                const croppedImage = canvas.toDataURL('image/jpeg', 0.85);
                heroImageData.value = croppedImage;
                
                // Update preview
                const img = document.createElement('img');
                img.src = croppedImage;
                img.className = 'img-thumbnail';
                img.style.maxHeight = '200px';
                heroImagePreview.innerHTML = '';
                heroImagePreview.appendChild(img);
                
                heroImageCropperModal.hide();
                heroCropper.destroy();
                heroCropper = null;
            }
        }
    });

    // Clean up cropper when modal is hidden
    document.getElementById('heroImageCropperModal').addEventListener('hidden.bs.modal', function() {
        if (heroCropper) {
            heroCropper.destroy();
            heroCropper = null;
        }
        heroImageInput.value = '';
    });

    // CEO Image Cropper Event Listeners
    ceoImageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                ceoImageCropperImg.src = e.target.result;
                ceoImageCropperModal.show();
                
                // Initialize cropper
                if (ceoCropper) {
                    ceoCropper.destroy();
                }
                ceoCropper = new Cropper(ceoImageCropperImg, {
                    aspectRatio: 1/1,
                    viewMode: 1,
                    guides: true,
                    center: true,
                    highlight: false,
                    background: true,
                    autoCrop: true,
                    autoCropArea: 0.8,
                    movable: true,
                    rotatable: false,
                    scalable: true,
                    zoomable: true,
                    zoomOnTouch: true,
                    zoomOnWheel: true,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    toggleDragModeOnDblclick: true,
                });
            };
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('ceo_image_crop_confirm').addEventListener('click', function() {
        if (ceoCropper) {
            const canvas = ceoCropper.getCroppedCanvas({
                width: 400,
                height: 400,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });
            
            if (canvas) {
                const croppedImage = canvas.toDataURL('image/jpeg', 0.9);
                ceoImageData.value = croppedImage;
                
                // Update preview
                const img = document.createElement('img');
                img.src = croppedImage;
                img.className = 'img-thumbnail';
                img.style.maxHeight = '200px';
                ceoImagePreview.innerHTML = '';
                ceoImagePreview.appendChild(img);
                
                ceoImageCropperModal.hide();
                ceoCropper.destroy();
                ceoCropper = null;
            }
        }
    });

    // Clean up CEO cropper when modal is hidden
    document.getElementById('ceoImageCropperModal').addEventListener('hidden.bs.modal', function() {
        if (ceoCropper) {
            ceoCropper.destroy();
            ceoCropper = null;
        }
        ceoImageInput.value = '';
    });
});
</script>
@endpush
