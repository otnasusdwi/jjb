@extends('layouts.admin')

@section('title', 'Edit Team Member')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Team Member</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.about.team.update', $teamMember) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $teamMember->name }}" required>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="position" class="form-label">Position *</label>
                                    <input type="text" class="form-control" id="position" name="position" value="{{ $teamMember->position }}" required>
                                    @error('position')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $teamMember->email }}">
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="{{ $teamMember->phone }}">
                                    @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="linkedin" class="form-label">LinkedIn URL</label>
                                    <input type="url" class="form-control" id="linkedin" name="linkedin" value="{{ $teamMember->linkedin }}" placeholder="https://linkedin.com/in/username">
                                    @error('linkedin')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="instagram" class="form-label">Instagram Username</label>
                                    <input type="text" class="form-control" id="instagram" name="instagram" value="{{ $teamMember->instagram }}" placeholder="@username">
                                    @error('instagram')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Profile Image</label>
                                    <div class="image-upload-container">
                                        <input type="file" class="form-control" id="image_input" accept="image/*">
                                        <input type="hidden" name="image" id="image_data" value="{{ old('image') }}">
                                        
                                        <!-- Image Preview -->
                                        <div id="image_preview" class="mt-3">
                                            @if($teamMember->image)
                                                <img src="{{ asset('storage/' . $teamMember->image) }}" alt="{{ $teamMember->name }}" class="img-thumbnail" style="max-height: 150px;">
                                                <br>
                                                <small class="text-muted">Current image</small>
                                            @endif
                                        </div>
                                        
                                        <!-- Cropper Modal -->
                                        <div class="modal fade" id="imageCropperModal" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Crop Profile Image</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="cropper-container">
                                                            <img id="image_cropper" style="max-width: 100%;">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="button" class="btn btn-primary" id="image_crop_confirm">Crop & Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <small class="text-muted">Recommended: Square image (1:1 ratio), Max size: 2MB</small>
                                    @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="order" class="form-label">Display Order</label>
                                    <input type="number" class="form-control" id="order" name="order" value="{{ $teamMember->order }}" min="0">
                                    @error('order')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">Biography</label>
                            <textarea class="form-control tinymce-editor" id="bio" name="bio" rows="6">{{ $teamMember->bio }}</textarea>
                            @error('bio')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.about.team.index') }}" class="btn btn-secondary">Cancel</a>
                            <div>
                                <button type="button" class="btn btn-warning me-2" onclick="toggleStatus()">
                                    <i class="fas fa-power-off"></i> {{ $teamMember->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Team Member
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
        height: 200,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | blocks | bold italic forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | help',
        content_style: 'body { font-family: Arial, sans-serif; font-size: 14px; }'
    });

    // Image Cropper functionality
    let cropper = null;
    const imageInput = document.getElementById('image_input');
    const imageData = document.getElementById('image_data');
    const imagePreview = document.getElementById('image_preview');
    const imageCropperModal = new bootstrap.Modal(document.getElementById('imageCropperModal'));
    const imageCropperImg = document.getElementById('image_cropper');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imageCropperImg.src = e.target.result;
                imageCropperModal.show();
                
                // Initialize cropper
                if (cropper) {
                    cropper.destroy();
                }
                cropper = new Cropper(imageCropperImg, {
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

    document.getElementById('image_crop_confirm').addEventListener('click', function() {
        if (cropper) {
            const canvas = cropper.getCroppedCanvas({
                width: 500,
                height: 500,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });
            
            if (canvas) {
                const croppedImage = canvas.toDataURL('image/jpeg', 0.9);
                imageData.value = croppedImage;
                
                // Update preview
                const img = document.createElement('img');
                img.src = croppedImage;
                img.className = 'img-thumbnail';
                img.style.maxHeight = '150px';
                imagePreview.innerHTML = '';
                imagePreview.appendChild(img);
                
                imageCropperModal.hide();
                cropper.destroy();
                cropper = null;
            }
        }
    });

    // Clean up cropper when modal is hidden
    document.getElementById('imageCropperModal').addEventListener('hidden.bs.modal', function() {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        imageInput.value = '';
    });
});

function toggleStatus() {
    if (confirm('Are you sure you want to {{ $teamMember->is_active ? 'deactivate' : 'activate' }} this team member?')) {
        fetch('{{ route("admin.about.team.toggle-status", $teamMember) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    }
}
</script>
@endpush
