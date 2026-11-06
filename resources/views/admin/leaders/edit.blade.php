@extends('admin.layout')

@section('title', 'Edit Leader')

@section('content')

@php
    $linkedinUsername = '';
    if ($leader->linkedin) {
        $linkedinUsername = str_replace('https://linkedin.com/in/', '', str_replace('http://linkedin.com/in/', '', $leader->linkedin));
    }
    
    // Helper function to convert Google Drive links for display
    function convertGoogleDriveForDisplay($url) {
        if (empty($url)) return $url;
        // If already converted, return as is
        if (str_contains($url, '/uc?export=view&id=')) {
            return $url;
        }
        // Extract file ID from Google Drive share link
        if (preg_match('/\/file\/d\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            $fileId = $matches[1];
            return "https://drive.google.com/uc?export=view&id={$fileId}";
        }
        // Pattern 2: ?id=FILE_ID
        if (preg_match('/[?&]id=([a-zA-Z0-9_-]+)/', $url, $matches)) {
            $fileId = $matches[1];
            return "https://drive.google.com/uc?export=view&id={$fileId}";
        }
        return $url;
    }
@endphp

<!-- Breadcrumbs -->
<div class="mb-4 flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a>
    <span class="material-symbols-outlined text-sm">chevron_right</span>
    <a href="{{ route('admin.leaders.index') }}" class="hover:text-primary transition-colors">Leadership</a>
    <span class="material-symbols-outlined text-sm">chevron_right</span>
    <span class="text-slate-700 dark:text-slate-300">Edit Leader</span>
</div>

<!-- Page Heading -->
<div class="mb-8">
    <h2 class="text-slate-900 dark:text-white text-4xl font-black tracking-tight mb-2">Edit Leader</h2>
    <p class="text-slate-500 dark:text-slate-400">Update this leader shown on the About and Team pages.</p>
</div>

<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
    <form action="{{ route('admin.leaders.update', $leader) }}" method="POST" class="p-6 md:p-8 space-y-8">
        @csrf
        @method('PUT')
        
        <!-- Display general errors -->
        @if($errors->has('error'))
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-red-600 dark:text-red-400">error</span>
                    <p class="text-sm font-semibold text-red-800 dark:text-red-200">{{ $errors->first('error') }}</p>
                </div>
            </div>
        @endif
        
        <!-- Display success message if redirected back with old input -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-green-600 dark:text-green-400">check_circle</span>
                    <p class="text-sm font-semibold text-green-800 dark:text-green-200">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Leader Information Section -->
        <div class="space-y-6">
            <div class="flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary">person</span>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Leader Information</h3>
            </div>

            <div>
                <label for="name" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Full Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" required value="{{ old('name', $leader->name) }}" class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" placeholder="e.g. Dr. Sarah Jenkins">
                @error('name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="role" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Professional Title <span class="text-red-500">*</span></label>
                <input type="text" name="role" id="role" required value="{{ old('role', $leader->role) }}" class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" placeholder="e.g. Chief Operations Officer">
                @error('role')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="bio" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Biography <span class="text-red-500">*</span></label>
                <div class="relative">
                    <textarea name="bio" id="bio" rows="6" required maxlength="1000" class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm resize-none" placeholder="Tell the story of their professional journey and key achievements...">{{ old('bio', $leader->bio) }}</textarea>
                    <div class="absolute top-3 right-3 text-xs text-slate-400">
                        <span id="bio-counter">{{ strlen(old('bio', $leader->bio)) }}</span>/1000 characters
                    </div>
                </div>
                @error('bio')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="department" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Department <span class="text-red-500">*</span></label>
                <select name="department" id="department" required class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/40 transition-all text-sm appearance-none cursor-pointer">
                    <option value="">Select Department</option>
                    @foreach(config('departments.departments', []) as $dept)
                        <option value="{{ $dept }}" {{ old('department', $leader->department) == $dept ? 'selected' : '' }}>
                            {{ $dept }}
                        </option>
                    @endforeach
                </select>
                @error('department')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="linkedin" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">LinkedIn Profile URL</label>
                <div class="flex items-center">
                    <span class="px-4 py-3 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 rounded-l-xl text-sm border-r border-slate-200 dark:border-slate-700 whitespace-nowrap">linkedin.com/in/</span>
                    <input type="text" name="linkedin" id="linkedin" value="{{ old('linkedin', $linkedinUsername) }}" class="flex-1 px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-r-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm min-w-0" placeholder="username">
                </div>
                <p class="mt-2 text-xs text-slate-500 dark:text-slate-500">Tip: Enter just the username (e.g., "john-doe") or full URL</p>
                @error('linkedin')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <!-- Profile Picture Section - UPDATED: URL INPUT WITH GOOGLE DRIVE SUPPORT -->
        <div class="space-y-4 pt-6 border-t border-slate-100 dark:border-slate-800">
            <label for="image_url" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Profile Picture URL</label>
            
            @if($leader->image)
                <div class="mb-4">
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-2">Current Image:</p>
                    <img src="{{ convertGoogleDriveForDisplay($leader->image) }}" alt="{{ $leader->name }}" id="current-image" class="max-w-xs rounded-lg border border-slate-200 dark:border-slate-700" onerror="this.style.display='none';">
                </div>
            @endif

            <div>
                <input type="url" name="image_url" id="image_url" value="{{ old('image_url', $leader->image) }}" class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" placeholder="https://example.com/path/to/image.jpg or Google Drive link">
                <p class="mt-2 text-xs text-slate-500 dark:text-slate-500">Enter the full URL to the profile picture image. Google Drive links will be automatically converted.</p>
                @error('image_url')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <!-- Image Preview -->
            <div id="image-preview" class="hidden mt-4">
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-2">Preview:</p>
                <img id="preview-img" src="" alt="Preview" class="max-w-xs rounded-lg border border-slate-200 dark:border-slate-700" onerror="this.style.display='none';">
            </div>
        </div>

        <!-- Status -->
        <div class="pt-6 border-t border-slate-100 dark:border-slate-800">
            <div class="flex items-center justify-between gap-4 bg-slate-50 dark:bg-slate-800/50 rounded-xl px-4 py-4">
                <div class="min-w-0">
                    <p class="text-sm font-bold text-slate-900 dark:text-white">Active</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">If off, this leader will be hidden on the website.</p>
                </div>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $leader->is_active) ? 'checked' : '' }}>
                    <div class="relative w-11 h-6 bg-slate-300 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/40 rounded-full peer dark:bg-slate-600 peer-checked:bg-primary transition-colors">
                        <div class="absolute top-0.5 left-0.5 bg-white w-5 h-5 rounded-full transition-transform peer-checked:translate-x-5"></div>
                    </div>
                </label>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100 dark:border-slate-800">
            <a href="{{ route('admin.leaders.index') }}" class="px-6 h-11 inline-flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors font-bold text-sm">Cancel</a>
            <button type="submit" class="px-6 h-11 inline-flex items-center justify-center bg-primary hover:bg-primary/90 text-white rounded-lg font-bold transition-all shadow-md shadow-primary/20">
                <span class="material-symbols-outlined text-[20px]">save</span>
                <span class="ml-2">Save Changes</span>
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Biography character counter
    const bioTextarea = document.getElementById('bio');
    const bioCounter = document.getElementById('bio-counter');
    
    if (bioTextarea && bioCounter) {
        bioTextarea.addEventListener('input', function() {
            bioCounter.textContent = this.value.length;
        });
    }

    // Google Drive link converter function
    function convertGoogleDriveLink(url) {
        if (!url) return url;
        
        // If already converted, return as is
        if (url.includes('/uc?export=view&id=') || url.includes('/uc?export=download&id=')) {
            return url;
        }
        
        // Extract file ID from Google Drive share link
        // Pattern 1: /file/d/FILE_ID/
        let match = url.match(/\/file\/d\/([a-zA-Z0-9_-]+)/);
        if (match) {
            const fileId = match[1];
            return `https://drive.google.com/uc?export=view&id=${fileId}`;
        }
        
        // Pattern 2: ?id=FILE_ID or &id=FILE_ID
        match = url.match(/[?&]id=([a-zA-Z0-9_-]+)/);
        if (match) {
            const fileId = match[1];
            return `https://drive.google.com/uc?export=view&id=${fileId}`;
        }
        
        return url;
    }

    // Image URL preview with Google Drive support
    const imageUrlInput = document.getElementById('image_url');
    const previewDiv = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    
    function updatePreview(url) {
        if (!url) {
            previewDiv.classList.add('hidden');
            return;
        }
        
        // Convert Google Drive link if needed
        const convertedUrl = convertGoogleDriveLink(url.trim());
        
        if (isValidUrl(convertedUrl)) {
            previewImg.src = convertedUrl;
            previewDiv.classList.remove('hidden');
        } else {
            previewDiv.classList.add('hidden');
        }
    }
    
    if (imageUrlInput && previewDiv && previewImg) {
        // Auto-convert Google Drive links when pasted
        imageUrlInput.addEventListener('paste', function(e) {
            setTimeout(() => {
                const url = this.value.trim();
                if (url.includes('drive.google.com') && !url.includes('/uc?export=view&id=')) {
                    const converted = convertGoogleDriveLink(url);
                    if (converted !== url) {
                        this.value = converted;
                    }
                }
                updatePreview(this.value);
            }, 10);
        });
        
        // Auto-convert Google Drive links when typing/blur
        imageUrlInput.addEventListener('input', function() {
            const url = this.value.trim();
            if (url.includes('drive.google.com') && !url.includes('/uc?export=view&id=')) {
                const converted = convertGoogleDriveLink(url);
                if (converted !== url) {
                    this.value = converted;
                }
            }
            updatePreview(this.value);
        });
        
        // Also check on blur (when user leaves the field)
        imageUrlInput.addEventListener('blur', function() {
            const url = this.value.trim();
            if (url.includes('drive.google.com') && !url.includes('/uc?export=view&id=')) {
                const converted = convertGoogleDriveLink(url);
                if (converted !== url) {
                    this.value = converted;
                    updatePreview(converted);
                }
            } else {
                updatePreview(url);
            }
        });
        
        // Initial preview if there's a value
        if (imageUrlInput.value) {
            updatePreview(imageUrlInput.value);
        }
    }
    
    // Simple URL validation
    function isValidUrl(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }
</script>
@endpush

@endsection