@extends('admin.layout')

@section('title', 'Create Sub-Service')

@section('content')
    <div class="px-4 py-5 sm:p-6">
        <!-- Breadcrumb -->
        <div class="mb-4 flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
            <a href="{{ route('admin.services.index') }}" class="hover:text-primary transition-colors">Services</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <a href="{{ route('admin.sub-services.index', $service) }}"
                class="hover:text-primary transition-colors">Sub-Services</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-slate-700 dark:text-slate-300">Create</span>
        </div>

        <!-- Success/Error Messages -->
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                <div class="flex items-center gap-3 mb-2">
                    <span class="material-symbols-outlined text-red-600 dark:text-red-400">error</span>
                    <p class="text-red-800 dark:text-red-300 font-medium">Please fix the following errors:</p>
                </div>
                <ul class="list-disc list-inside text-red-700 dark:text-red-400 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-6">
            <h1 class="text-3xl font-bold text-navy-deep dark:text-white mb-2">Create Sub-Service</h1>
            <p class="text-slate-600 dark:text-slate-400">Add a new sub-service for {{ $service->title }}</p>
        </div>

        <div
            class="bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-800 p-6 md:p-8">
            <form action="{{ route('admin.sub-services.store', $service) }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Title
                            <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" required value="{{ old('title') }}"
                            class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors"
                            placeholder="e.g., Bookkeeping">
                        @error('title')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description"
                            class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Description</label>
                        <textarea name="description" id="description" rows="4"
                            class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors"
                            placeholder="Brief description...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="image" class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Image
                            Link (URL)</label>
                        <input type="url" name="image" id="image" required value="{{ old('image') }}"
                            class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors"
                            placeholder="https://example.com/image.jpg">
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Enter the full image URL for the
                            sub-service, including a public Google Drive share link. No file upload is required.</p>
                        @error('image')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label for="order"
                                class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Display
                                Order</label>
                            <input type="number" name="order" id="order" value="{{ old('order', 0) }}" min="0"
                                class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors">
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Lower numbers appear first</p>
                        </div>

                        <div class="flex items-center pt-8">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                class="h-5 w-5 text-primary focus:ring-primary border-slate-300 dark:border-slate-600 rounded bg-white dark:bg-slate-800">
                            <label for="is_active"
                                class="ml-3 block text-sm font-medium text-navy-deep dark:text-slate-200">
                                Active Sub-Service
                            </label>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-200 dark:border-slate-700">
                        <h3 class="text-lg font-bold text-navy-deep dark:text-white mb-4">Content Sections (Editable
                            Headings)</h3>
                        @for($i = 1; $i <= 5; $i++)
                            <div class="mb-6 p-4 bg-slate-50 dark:bg-slate-800 rounded-lg">
                                <h4 class="text-md font-semibold text-navy-deep dark:text-white mb-3">Section {{ $i }}</h4>
                                <div class="space-y-4">
                                    <div>
                                        <label for="heading_{{ $i }}"
                                            class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Heading
                                            {{ $i }}</label>
                                        <input type="text" name="heading_{{ $i }}" id="heading_{{ $i }}"
                                            value="{{ old("heading_{$i}") }}"
                                            class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors"
                                            placeholder="Section heading...">
                                    </div>
                                    <div>
                                        <label for="content_{{ $i }}"
                                            class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Content
                                            {{ $i }}</label>
                                        <textarea name="content_{{ $i }}" id="content_{{ $i }}" rows="4"
                                            class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors"
                                            placeholder="Section content...">{{ old("content_{$i}") }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>

                    <div class="flex justify-end items-center gap-3 pt-4 border-t border-slate-200 dark:border-slate-700">
                        <a href="{{ route('admin.sub-services.index', $service) }}"
                            class="inline-flex items-center justify-center px-6 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm text-sm font-semibold text-navy-deep dark:text-slate-200 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all">
                            Create Sub-Service
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function previewImage(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
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
