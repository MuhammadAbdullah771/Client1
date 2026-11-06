@extends('layouts.admin')

@section('title', 'Media Management')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>📸 Media Library</h1>
            <p class="text-muted">Manage all photos and media for your website</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.media.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus"></i> Upload New Media
            </a>
            <a href="{{ route('admin.media.links') }}" class="btn btn-info btn-lg ms-2">
                <i class="fas fa-link"></i> Copy Links
            </a>
        </div>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Media Grid --}}
    <div class="row">
        @forelse($media as $item)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm hover-shadow">
                @if($item->isImage())
                <img src="{{ $item->file_url }}" alt="{{ $item->alt_text ?? $item->title }}" 
                     class="card-img-top" style="height: 250px; object-fit: cover;">
                @else
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                     style="height: 250px;">
                    <div class="text-center">
                        <i class="fas fa-file fa-3x text-muted"></i>
                        <p class="text-muted mt-2">{{ strtoupper($item->file_type) }}</p>
                    </div>
                </div>
                @endif

                <div class="card-body">
                    <h5 class="card-title">{{ $item->title }}</h5>
                    @if($item->description)
                    <p class="card-text text-muted small">{{ substr($item->description, 0, 60) }}...</p>
                    @endif
                    
                    <div class="mb-3">
                        <span class="badge bg-secondary">{{ $item->category }}</span>
                        <span class="badge bg-info">{{ $item->file_type }}</span>
                    </div>

                    <div class="input-group input-group-sm mb-3">
                        <input type="text" class="form-control" value="{{ $item->file_url }}" 
                               id="url-{{ $item->id }}" readonly>
                        <button class="btn btn-outline-secondary" type="button" 
                                onclick="copyToClipboard('url-{{ $item->id }}')">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>

                <div class="card-footer bg-transparent">
                    <a href="{{ route('admin.media.edit', $item) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('admin.media.destroy', $item) }}" method="POST" 
                          style="display: inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" 
                                onclick="return confirm('Delete this media?')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center py-5">
                <i class="fas fa-image fa-3x mb-3"></i>
                <p>No media found. <a href="{{ route('admin.media.create') }}">Upload your first media</a></p>
            </div>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-5">
        {{ $media->links() }}
    </div>
</div>

<style>
.hover-shadow {
    transition: box-shadow 0.3s ease;
}
.hover-shadow:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
</style>

<script>
function copyToClipboard(elementId) {
    const element = document.getElementById(elementId);
    element.select();
    document.execCommand('copy');
    
    // Show feedback
    const btn = event.target.closest('button');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-check"></i>';
    setTimeout(() => {
        btn.innerHTML = originalText;
    }, 2000);
}
</script>
@endsection
