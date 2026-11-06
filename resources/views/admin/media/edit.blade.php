@extends('layouts.admin')

@section('title', 'Edit Media')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h1>✏️ Edit Media</h1>
            <p class="text-muted mb-4">Update media information or replace the file</p>

            {{-- Error Messages --}}
            @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.media.update', $media) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                {{-- Current File Display --}}
                <div class="mb-4 p-3 bg-light rounded">
                    <h6 class="fw-bold mb-2">Current Media</h6>
                    @if($media->isImage())
                    <img src="{{ $media->file_url }}" alt="{{ $media->alt_text ?? $media->title }}" 
                         class="img-fluid rounded" style="max-height: 300px;">
                    @else
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-file fa-2x"></i><br>
                        {{ $media->title }}
                    </div>
                    @endif
                    <p class="text-muted small mt-2 mb-0">Uploaded: {{ $media->created_at->format('M d, Y H:i') }}</p>
                </div>

                {{-- File Upload (Optional) --}}
                <div class="mb-4">
                    <label for="file" class="form-label fw-bold">Replace Media File (Optional)</label>
                    <div class="mb-2 text-muted small">
                        Leave empty to keep current file. Supported: JPEG, PNG, GIF, WebP, SVG (max 50MB)
                    </div>
                    <input type="file" class="form-control form-control-lg @error('file') is-invalid @enderror" 
                           id="file" name="file" accept="image/*,video/*,.pdf" 
                           onchange="previewFile(this)">
                    @error('file')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    
                    {{-- Preview --}}
                    <div id="preview" class="mt-3" style="display: none;">
                        <h6>New File Preview:</h6>
                        <div id="imagePreview"></div>
                    </div>
                </div>

                {{-- Title --}}
                <div class="mb-3">
                    <label for="title" class="form-label fw-bold">Title *</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                           id="title" name="title" value="{{ old('title', $media->title) }}" required>
                    @error('title')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Category --}}
                <div class="mb-3">
                    <label for="category" class="form-label fw-bold">Category *</label>
                    <select class="form-select @error('category') is-invalid @enderror" 
                            id="category" name="category" required>
                        @foreach($categories as $key => $label)
                        <option value="{{ $key }}" {{ old('category', $media->category) == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                    @error('category')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $media->description) }}</textarea>
                </div>

                {{-- Alt Text --}}
                <div class="mb-3">
                    <label for="alt_text" class="form-label fw-bold">Alt Text (for SEO)</label>
                    <input type="text" class="form-control" id="alt_text" name="alt_text" 
                           value="{{ old('alt_text', $media->alt_text) }}" 
                           placeholder="Describe what the image shows">
                </div>

                {{-- Media URL (Read-only) --}}
                <div class="mb-3">
                    <label for="url" class="form-label fw-bold">Media URL</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="url" value="{{ $media->file_url }}" readonly>
                        <button class="btn btn-outline-secondary" type="button" onclick="copyUrl()">
                            <i class="fas fa-copy"></i> Copy
                        </button>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="d-flex gap-2 mt-5">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Update Media
                    </button>
                    <a href="{{ route('admin.media.index') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewFile(input) {
    const preview = document.getElementById('preview');
    const imagePreview = document.getElementById('imagePreview');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.innerHTML = `<img src="${e.target.result}" class="img-fluid rounded" 
                                             style="max-height: 300px;">`;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }
}

function copyUrl() {
    const urlInput = document.getElementById('url');
    urlInput.select();
    document.execCommand('copy');
    alert('URL copied to clipboard!');
}
</script>
@endsection
