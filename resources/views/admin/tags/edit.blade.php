@extends('layouts.admin')

@section('title', 'Edit Tag')

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
                <form action="{{ route('admin.tags.update', $tag) }}" method="POST">
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
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="icon" class="form-label">Icon Emoji</label>
                                <input type="text" 
                                       class="form-control @error('icon') is-invalid @enderror" 
                                       id="icon" 
                                       name="icon" 
                                       value="{{ old('icon', $tag->icon) }}"
                                       placeholder="🏝️">
                                @error('icon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Optional emoji</small>
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

                    <div class="d-flex justify-content-between">
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
                                <small class="text-muted">{{ $package->category->name }} • Rp {{ number_format($package->price) }}</small>
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
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Preview</h5>
            </div>
            <div class="card-body">
                <div id="tagPreview" class="text-center p-4">
                    <span class="badge" style="font-size: 1.2rem; padding: 0.6rem 1.2rem; background-color: {{ $tag->color }};">
                        <span id="previewIcon">{{ $tag->icon }}</span>
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
    const icon = document.getElementById('icon').value;
    const color = document.getElementById('color').value;
    const description = document.getElementById('description').value || 'No description';
    
    document.getElementById('previewName').textContent = name;
    document.getElementById('previewIcon').textContent = icon ? icon + ' ' : '';
    document.getElementById('previewDescription').textContent = description;
    document.querySelector('#tagPreview .badge').style.backgroundColor = color;
}

// Update preview on input
document.getElementById('name').addEventListener('input', updatePreview);
document.getElementById('icon').addEventListener('input', updatePreview);
document.getElementById('description').addEventListener('input', updatePreview);
</script>
@endpush
