@extends('admin.layout')

@section('title', 'Edit Milestone')

@section('content')
<!-- Breadcrumbs -->
<div class="mb-4 flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a>
    <span class="material-symbols-outlined text-sm">chevron_right</span>
    <a href="{{ route('admin.milestones.index') }}" class="hover:text-primary transition-colors">Milestones</a>
    <span class="material-symbols-outlined text-sm">chevron_right</span>
    <span class="text-slate-700 dark:text-slate-300">Edit Milestone</span>
</div>

<!-- Page Heading -->
<div class="mb-8">
    <h2 class="text-slate-900 dark:text-white text-4xl font-black tracking-tight mb-2">Edit Milestone</h2>
    <p class="text-slate-500 dark:text-slate-400">Update this milestone on the company timeline.</p>
</div>

<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
    <form action="{{ route('admin.milestones.update', $milestone) }}" method="POST" class="p-6 md:p-8 space-y-8">
        @csrf
        @method('PUT')

        <!-- Milestone Information Section -->
        <div class="space-y-6">
            <div class="flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary">edit</span>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Milestone Information</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="year" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                        Year <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        name="year" 
                        id="year" 
                        required 
                        min="1900" 
                        max="{{ date('Y') + 10 }}"
                        value="{{ old('year', $milestone->year) }}" 
                        class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" 
                        placeholder="e.g. 2024"
                    >
                    @error('year')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="order" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                        Display Order
                    </label>
                    <input 
                        type="number" 
                        name="order" 
                        id="order" 
                        min="0"
                        value="{{ old('order', $milestone->order) }}" 
                        class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" 
                        placeholder="0"
                    >
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Lower numbers appear first</p>
                    @error('order')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="title" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                    Title <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    required 
                    maxlength="255"
                    value="{{ old('title', $milestone->title) }}" 
                    class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm break-words" 
                    placeholder="e.g. Company Founded"
                >
                @error('title')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                    Description <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <textarea 
                        name="description" 
                        id="description" 
                        rows="5" 
                        required 
                        maxlength="1000"
                        class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm resize-none break-words" 
                        placeholder="Describe this milestone and its significance..."
                    >{{ old('description', $milestone->description) }}</textarea>
                    <div class="absolute top-3 right-3 text-xs text-slate-400">
                        <span id="desc-counter">{{ strlen(old('description', $milestone->description)) }}</span>/1000 characters
                    </div>
                </div>
                @error('description')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="position" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                    Timeline Position <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="relative flex items-center p-4 border-2 rounded-xl cursor-pointer transition-all {{ old('position', $milestone->position) === 'left' ? 'border-primary bg-primary/5' : 'border-slate-200 dark:border-slate-700 hover:border-primary/50' }}">
                        <input type="radio" name="position" value="left" class="sr-only peer" {{ old('position', $milestone->position) === 'left' ? 'checked' : '' }}>
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary text-2xl">arrow_back</span>
                            <div>
                                <p class="font-bold text-slate-900 dark:text-white">Left Side</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Appears on left of timeline</p>
                            </div>
                        </div>
                    </label>
                    <label class="relative flex items-center p-4 border-2 rounded-xl cursor-pointer transition-all {{ old('position', $milestone->position) === 'right' ? 'border-primary bg-primary/5' : 'border-slate-200 dark:border-slate-700 hover:border-primary/50' }}">
                        <input type="radio" name="position" value="right" class="sr-only peer" {{ old('position', $milestone->position) === 'right' ? 'checked' : '' }}>
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary text-2xl">arrow_forward</span>
                            <div>
                                <p class="font-bold text-slate-900 dark:text-white">Right Side</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Appears on right of timeline</p>
                            </div>
                        </div>
                    </label>
                </div>
                @error('position')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100 dark:border-slate-800">
            <a href="{{ route('admin.milestones.index') }}" class="px-6 h-11 inline-flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors font-bold text-sm">
                <span class="material-symbols-outlined text-lg mr-2">close</span>
                Cancel
            </a>
            <button type="submit" class="px-6 h-11 inline-flex items-center justify-center bg-primary hover:bg-primary/90 text-white rounded-lg font-bold transition-all shadow-md shadow-primary/20">
                <span class="material-symbols-outlined text-[20px]">save</span>
                <span class="ml-2">Save Changes</span>
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Description character counter
    const descTextarea = document.getElementById('description');
    const descCounter = document.getElementById('desc-counter');
    
    if (descTextarea && descCounter) {
        descTextarea.addEventListener('input', function() {
            descCounter.textContent = this.value.length;
        });
    }
</script>
@endpush
@endsection

