@extends('layouts.admin')

@section('title', 'Copy Media Links')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>🔗 Copy Media Links</h1>
            <p class="text-muted mb-4">Copy the URL of any media file to use on your website</p>

            {{-- No Media Message --}}
            @if($media->isEmpty())
            <div class="alert alert-info text-center py-5">
                <i class="fas fa-image fa-3x mb-3"></i>
                <p>No media found. <a href="{{ route('admin.media.create') }}">Upload your first media</a></p>
            </div>
            @else

            {{-- Media by Category --}}
            @foreach($media as $category => $items)
            <div class="mb-5">
                <h3 class="border-bottom pb-2 mb-3">
                    <span class="badge bg-primary">{{ strtoupper($category) }}</span>
                </h3>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 40%;">Title</th>
                                <th style="width: 40%;">URL</th>
                                <th style="width: 20%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr>
                                <td>
                                    @if($item->isImage())
                                    <img src="{{ $item->file_url }}" alt="{{ $item->title }}" 
                                         class="me-2" style="height: 40px; object-fit: cover; border-radius: 4px;">
                                    @else
                                    <i class="fas fa-file me-2 text-muted"></i>
                                    @endif
                                    <strong>{{ $item->title }}</strong>
                                    @if($item->alt_text)
                                    <br><small class="text-muted">{{ $item->alt_text }}</small>
                                    @endif
                                </td>
                                <td>
                                    <code class="text-break" style="font-size: 0.85rem;">{{ $item->file_url }}</code>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary" 
                                            onclick="copyToClipboard('{{ $item->file_url }}')">
                                        <i class="fas fa-copy"></i> Copy
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach

            {{-- Export All URLs --}}
            <div class="mt-5 p-4 bg-light rounded">
                <h5 class="fw-bold mb-3">📋 Export All URLs</h5>
                <div class="mb-3">
                    <textarea class="form-control" rows="10" id="allUrls" readonly>@foreach($media as $items)@foreach($items as $item){{ $item->file_url }}
@endforeach
@endforeach</textarea>
                </div>
                <button class="btn btn-primary" onclick="copyAllUrls()">
                    <i class="fas fa-copy"></i> Copy All URLs
                </button>
            </div>

            @endif

            <div class="mt-5">
                <a href="{{ route('admin.media.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Media Library
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(url) {
    const temp = document.createElement('textarea');
    temp.value = url;
    document.body.appendChild(temp);
    temp.select();
    document.execCommand('copy');
    document.body.removeChild(temp);
    
    // Show feedback
    alert('Link copied to clipboard!');
}

function copyAllUrls() {
    const textarea = document.getElementById('allUrls');
    textarea.select();
    document.execCommand('copy');
    alert('All URLs copied to clipboard!');
}
</script>
@endsection
