@extends('layouts.admin')

@section('title', 'Upload Media')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h1>📤 Upload New Media</h1>
            <p class="text-muted mb-4">Upload photos and media files to manage on your website</p>

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

            <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" 
                  class="needs-validation">
                @csrf

                {{-- File Upload --}}
                <div class="mb-4">
                    <label for="file" class="form-label fw-bold">Select Media File</label>
                    <div class="mb-2 text-muted small">
                        Supported: JPEG, PNG, GIF, WebP, SVG (max 50MB)
                    </div>
                    <input type="file" class="form-control form-control-lg @error('file') is-invalid @enderror" 
                           id="file" name="file" accept="image/*,video/*,.pdf" required 
                           onchange="previewFile(this)">
                    @error('file')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    
                    {{-- Preview --}}
                    <div id="preview" class="mt-3" style="display: none;">
                        <div id="imagePreview"></div>
                    </div>
                </div>

                {{-- Title --}}
                <div class="mb-3">
                    <label for="title" class="form-label fw-bold">Title *</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                           id="title" name="title" value="{{ old('title') }}" required 
                           placeholder="e.g., Hero Banner Image">
                    @error('title')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Category --}}
                <div class="mb-3">
                    <label for="category" class="form-label fw-bold">Category *</label>
                    <select class="form-select @error('category') is-invalid @enderror" 
                            id="category" name="category" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $key => $label)
                        <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
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
                    <textarea class="form-control" id="description" name="description" rows="3" 
                              placeholder="Optional description for this media file...">{{ old('description') }}</textarea>
                </div>

                {{-- Alt Text (for images) --}}
                <div class="mb-3">
                    <label for="alt_text" class="form-label fw-bold">Alt Text (for SEO)</label>
                    <input type="text" class="form-control" id="alt_text" name="alt_text" 
                           value="{{ old('alt_text') }}" 
                           placeholder="Describe what the image shows for accessibility">
                </div>

                {{-- Buttons --}}
                <div class="d-flex gap-2 mt-5">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-upload"></i> Upload Media
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
        
        // Update title if empty
        const titleInput = document.getElementById('title');
        if (!titleInput.value) {
            titleInput.value = file.name.split('.')[0];
        }
        
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.innerHTML = `<img src="${e.target.result}" class="img-fluid rounded" 
                                             style="max-height: 300px;">`;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.innerHTML = `<div class="alert alert-info">
                                        <i class="fas fa-file fa-2x"></i><br>
                                        ${file.name}
                                      </div>`;
            preview.style.display = 'block';
        }
    }
}
</script>
@endsection
