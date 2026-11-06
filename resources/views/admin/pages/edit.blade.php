@extends('admin.layout')

@section('title', 'Edit Page')

@section('content')
<div class="px-4 py-5 sm:p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-navy-deep dark:text-white mb-2">Edit Page</h1>
        <p class="text-slate-600 dark:text-slate-400">Update page content and settings.</p>
    </div>

    <div class="bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-800 p-6 md:p-8">
        <form action="{{ route('admin.pages.update', $page) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <div>
                    <label for="title" class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Page Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" required value="{{ old('title', $page->title) }}" class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors" placeholder="Enter page title">
                    @error('title')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="content" class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Content <span class="text-red-500">*</span></label>
                    <textarea name="content" id="content" rows="20" required class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors resize-none" placeholder="Enter page content...">{{ old('content', $page->content) }}</textarea>
                    <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">You can use line breaks. HTML will be escaped for security.</p>
                    @error('content')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $page->is_active) ? 'checked' : '' }} class="w-4 h-4 text-primary border-slate-300 rounded focus:ring-primary">
                    <label for="is_active" class="text-sm font-semibold text-navy-deep dark:text-slate-200">Active (Page will be visible on website)</label>
                </div>

                <div class="flex justify-end gap-3 pt-6 border-t border-slate-200 dark:border-slate-700">
                    <a href="{{ route('admin.pages.index') }}" class="px-6 py-3 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-semibold hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">Cancel</a>
                    <button type="submit" class="px-6 py-3 rounded-xl bg-primary text-white font-bold hover:bg-primary/90 transition-colors">Update Page</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

