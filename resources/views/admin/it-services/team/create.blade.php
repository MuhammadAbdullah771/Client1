@extends('admin.layout')

@section('title', 'Add IT Services Team Member')

@section('content')
<div class="mb-4 flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
    <a href="{{ route('admin.it-services.index') }}" class="hover:text-primary transition-colors">IT Services</a>
    <span class="material-symbols-outlined text-sm">chevron_right</span>
    <a href="{{ route('admin.it-services.team.index') }}" class="hover:text-primary transition-colors">IT Services Team</a>
    <span class="material-symbols-outlined text-sm">chevron_right</span>
    <span class="text-slate-700 dark:text-slate-300">Add Team Member</span>
</div>

<div class="mb-8">
    <h2 class="text-slate-900 dark:text-white text-4xl font-black tracking-tight mb-2">Add IT Services Team Member</h2>
    <p class="text-slate-500 dark:text-slate-400">Add a team member shown on the IT Services page. LinkedIn required for display.</p>
</div>

<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
    <form action="{{ route('admin.it-services.team.store') }}" method="POST" class="p-6 md:p-8 space-y-8">
        @csrf

        <div class="space-y-6">
            <div class="flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary">person_add</span>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Team Member</h3>
            </div>

            <div>
                <label for="name" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Full Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" required value="{{ old('name') }}" class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" placeholder="e.g. Jane Doe">
                @error('name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="role" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Role <span class="text-red-500">*</span></label>
                <input type="text" name="role" id="role" required value="{{ old('role') }}" class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" placeholder="e.g. Full Stack Developer">
                @error('role')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="bio" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Bio <span class="text-red-500">*</span></label>
                <div class="relative">
                    <textarea name="bio" id="bio" rows="6" required maxlength="1000" class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm resize-none" placeholder="Short bio...">{{ old('bio') }}</textarea>
                    <div class="absolute top-3 right-3 text-xs text-slate-400"><span id="bio-counter">0</span>/1000</div>
                </div>
                @error('bio')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Department</label>
                <input type="hidden" name="department" value="IT">
                <input type="text" value="IT" disabled class="block w-full px-4 py-3 bg-slate-100 dark:bg-slate-800 border-none rounded-xl text-slate-600 dark:text-slate-400 text-sm cursor-not-allowed" title="IT Services Team">
            </div>

            <div>
                <label for="linkedin" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">LinkedIn <span class="text-red-500">*</span></label>
                <div class="flex items-center">
                    <span class="px-4 py-3 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 rounded-l-xl text-sm border-r border-slate-200 dark:border-slate-700 whitespace-nowrap">linkedin.com/in/</span>
                    <input type="text" name="linkedin" id="linkedin" value="{{ old('linkedin') }}" class="flex-1 px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-r-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm min-w-0" placeholder="username" required>
                </div>
                <p class="mt-2 text-xs text-slate-500">Required. Team members are shown on the IT Services page with LinkedIn links.</p>
                @error('linkedin')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="space-y-4 pt-6 border-t border-slate-100 dark:border-slate-800">
            <label for="image_url" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Profile Picture URL <span class="text-red-500">*</span></label>
            <input type="url" name="image_url" id="image_url" required value="{{ old('image_url') }}" class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" placeholder="https://example.com/photo.jpg">
            <p class="text-xs text-slate-500">Paste a direct image link (Google Drive share links are supported).</p>
            @error('image_url')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div class="pt-6 border-t border-slate-100 dark:border-slate-800">
            <div class="flex items-center justify-between gap-4 bg-slate-50 dark:bg-slate-800/50 rounded-xl px-4 py-4">
                <div class="min-w-0">
                    <p class="text-sm font-bold text-slate-900 dark:text-white">Active</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Hidden if inactive.</p>
                </div>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', true) ? 'checked' : '' }}>
                    <div class="relative w-11 h-6 bg-slate-300 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/40 rounded-full peer dark:bg-slate-600 peer-checked:bg-primary transition-colors">
                        <div class="absolute top-0.5 left-0.5 bg-white w-5 h-5 rounded-full transition-transform peer-checked:translate-x-5"></div>
                    </div>
                </label>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100 dark:border-slate-800">
            <a href="{{ route('admin.it-services.team.index') }}" class="px-6 h-11 inline-flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors font-bold text-sm">Cancel</a>
            <button type="submit" class="px-6 h-11 inline-flex items-center justify-center bg-primary hover:bg-primary/90 text-white rounded-lg font-bold transition-all shadow-md shadow-primary/20">
                <span class="material-symbols-outlined text-[20px]">save</span>
                <span class="ml-2">Add Team Member</span>
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    const bioTextarea = document.getElementById('bio');
    const bioCounter = document.getElementById('bio-counter');
    if (bioTextarea && bioCounter) {
        bioTextarea.addEventListener('input', function() { bioCounter.textContent = this.value.length; });
        bioCounter.textContent = bioTextarea.value.length;
    }
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const r = new FileReader();
            r.onload = function(e) {
                const p = document.getElementById('image-preview'), i = document.getElementById('preview-img');
                if (p && i) { i.src = e.target.result; p.classList.remove('hidden'); }
            };
            r.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection
