@extends('admin.layout')

@section('title', 'IT Manager Profile')

@section('content')
<div class="mb-4 flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
    <a href="{{ route('admin.it-services.index') }}" class="hover:text-primary transition-colors">IT Services</a>
    <span class="material-symbols-outlined text-sm">chevron_right</span>
    <span class="text-slate-700 dark:text-slate-300">IT Manager Profile</span>
</div>

<div class="mb-8">
    <h2 class="text-slate-900 dark:text-white text-4xl font-black tracking-tight mb-2">IT Manager Profile</h2>
    <p class="text-slate-500 dark:text-slate-400">Editable profile shown on the IT Services portfolio page. Picture, vision, LinkedIn, email, WhatsApp.</p>
</div>

<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
    <form action="{{ route('admin.it-manager.update') }}" method="POST" class="p-6 md:p-8 space-y-8">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <div class="flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary">person</span>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Profile</h3>
            </div>

            <div>
                <label for="name" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" required value="{{ old('name', $profile->name ?? '') }}" class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" placeholder="e.g. IT Manager">
                @error('name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="image_url" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Profile Image URL</label>
                @if(!empty($profile->image_url))
                <div class="mb-4">
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-2">Current Image:</p>
                    <img src="{{ $profile->image_url }}" alt="Current" class="w-32 h-32 rounded-xl object-cover border border-slate-200 dark:border-slate-700">
                </div>
                @endif
                <input type="url" name="image_url" id="image_url" value="{{ old('image_url', $profile->image ?? '') }}" class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" placeholder="https://example.com/photo.jpg">
                <p class="mt-1 text-xs text-slate-500">Paste a direct image link. Leave blank to keep the current image.</p>
                @error('image_url')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="vision" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">IT Manager Vision</label>
                <textarea name="vision" id="vision" rows="5" class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm resize-none" placeholder="Vision and mission for IT services...">{{ old('vision', $profile->vision ?? '') }}</textarea>
                @error('vision')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="linkedin_url" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">LinkedIn URL</label>
                    <input type="text" name="linkedin_url" id="linkedin_url" value="{{ old('linkedin_url', $profile->linkedin_url ?? '') }}" class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" placeholder="https://linkedin.com/in/username">
                    @error('linkedin_url')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $profile->email ?? '') }}" class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" placeholder="email@example.com">
                    @error('email')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="whatsapp" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">WhatsApp Number</label>
                    <input type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp', $profile->whatsapp ?? '') }}" class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" placeholder="e.g. 923206418200">
                    <p class="mt-1 text-xs text-slate-500">Country code + number, no + or spaces.</p>
                    @error('whatsapp')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label for="order" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Order</label>
                <input type="number" name="order" id="order" min="0" value="{{ old('order', $profile->order ?? 0) }}" class="block w-full max-w-[120px] px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/40 transition-all text-sm">
                @error('order')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-6 border-t border-slate-200 dark:border-slate-700">
            <a href="{{ route('admin.it-services.index') }}" class="px-6 py-3 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-semibold hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">Back to IT Services</a>
            <button type="submit" class="px-6 py-3 rounded-xl bg-primary text-white font-bold hover:bg-primary/90 transition-colors">Update IT Manager Profile</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('image-preview');
                const img = document.getElementById('preview-img');
                if (preview && img) {
                    img.src = e.target.result;
                    preview.classList.remove('hidden');
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection
