@extends('admin.layout')

@section('title', 'Create Insight')

@section('content')
    <div class="px-4 py-5 sm:p-6">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-navy-deep dark:text-white mb-2">Create Insight</h1>
            <p class="text-slate-600 dark:text-slate-400">Create a new insight post to share with your audience.</p>
        </div>

        <div
            class="bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-800 p-6 md:p-8">
            <form action="{{ route('admin.insights.store') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Title
                            <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" required value="{{ old('title') }}"
                            class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors"
                            placeholder="Enter insight title">
                        @error('title')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="heading"
                            class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Heading</label>
                        <input type="text" name="heading" id="heading" value="{{ old('heading') }}"
                            class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors"
                            placeholder="Enter heading (optional)">
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Optional heading that will be displayed
                            prominently on the insight page. If left empty, the title will be used.</p>
                        @error('heading')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="excerpt"
                            class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Excerpt/Summary
                            <span class="text-red-500">*</span></label>
                        <textarea name="excerpt" id="excerpt" rows="3" required
                            class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors"
                            placeholder="Brief summary or excerpt of the insight">{{ old('excerpt') }}</textarea>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">A short summary that will appear in
                            listings and previews.</p>
                        @error('excerpt')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="key_points"
                            class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Key Points</label>
                        <textarea name="key_points" id="key_points" rows="6"
                            class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors font-mono text-sm"
                            placeholder="Enter key points (one per line)&#10;Example:&#10;Individual Tax Returns&#10;Corporate Tax Returns&#10;Tax Planning Services">{{ old('key_points') }}</textarea>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Enter each key point on a new line. These
                            will be displayed as bullet points on the insight page.</p>
                        @error('key_points')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="content"
                            class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Full Content</label>
                        <textarea name="content" id="content" rows="10"
                            class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors"
                            placeholder="Write the full content of your insight article here...">{{ old('content') }}</textarea>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">The complete article content (optional).
                        </p>
                        @error('content')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category"
                            class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Category <span
                                class="text-red-500">*</span></label>
                        @if($categories->count() > 0)
                            <select name="category" id="category" required
                                class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors">
                                <option value="">Select a Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->name }}" {{ old('category') == $category->name ? 'selected' : '' }}>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                        @else
                            <input type="text" name="category" id="category" required value="{{ old('category') }}"
                                class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors"
                                placeholder="Enter category name">
                            <p class="mt-1 text-xs text-yellow-600 dark:text-yellow-400">⚠️ Categories table not found. Enter
                                category name manually.</p>
                        @endif
                        @error('category')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div
                            class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl">
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 mt-0.5">info</span>
                                <div>
                                    <p class="text-sm font-semibold text-blue-900 dark:text-blue-100 mb-1">Automatic
                                        Professional Images</p>
                                    <p class="text-xs text-blue-800 dark:text-blue-200">Insight images are automatically
                                        generated based on your title, heading, and category keywords. Professional images
                                        are selected to match your insight topic.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="image"
                            class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Insight Image
                            URL</label>
                        <input type="url" name="image" id="image" required value="{{ old('image') }}"
                            class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors"
                            placeholder="https://example.com/insight-image.jpg">
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Provide a direct image URL or public Google Drive share link.</p>
                        @error('image')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="published_at"
                                class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Publish Date
                                <span class="text-red-500">*</span></label>
                            <input type="date" name="published_at" id="published_at" required
                                value="{{ old('published_at', date('Y-m-d')) }}"
                                class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors">
                            @error('published_at')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center pt-8">
                            <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                                class="h-5 w-5 text-primary focus:ring-primary border-slate-300 dark:border-slate-600 rounded bg-white dark:bg-slate-800">
                            <label for="is_featured"
                                class="ml-3 block text-sm font-medium text-navy-deep dark:text-slate-200">
                                Mark as Featured Insight
                                <span class="block text-xs text-slate-500 dark:text-slate-400 mt-1">Featured insights appear
                                    prominently on the insights page.</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end items-center gap-3 pt-4 border-t border-slate-200 dark:border-slate-700">
                        <a href="{{ route('admin.insights.index') }}"
                            class="inline-flex items-center justify-center px-6 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm text-sm font-semibold text-navy-deep dark:text-slate-200 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all">
                            Create Insight
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
