@extends('admin.layout')

@section('title', 'Edit Portfolio Item')

@section('content')
<div class="mb-4 flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
    <a href="{{ route('admin.it-services.index') }}" class="hover:text-primary transition-colors">IT Services</a>
    <span class="material-symbols-outlined text-sm">chevron_right</span>
    <a href="{{ route('admin.portfolio-items.index') }}" class="hover:text-primary transition-colors">Portfolio</a>
    <span class="material-symbols-outlined text-sm">chevron_right</span>
    <span class="text-slate-700 dark:text-slate-300">Edit</span>
</div>

<div class="mb-8">
    <h2 class="text-slate-900 dark:text-white text-4xl font-black tracking-tight mb-2">Edit Portfolio Item</h2>
    <p class="text-slate-500 dark:text-slate-400">Update title, description, icon, and order.</p>
</div>

<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
    <form action="{{ route('admin.portfolio-items.update', $portfolioItem) }}" method="POST" class="p-6 md:p-8 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="service_id" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Service <span class="text-red-500">*</span></label>
            <select name="service_id" id="service_id" required class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/40 transition-all text-sm">
                @foreach($services as $s)
                <option value="{{ $s->id }}" {{ old('service_id', $portfolioItem->service_id) == $s->id ? 'selected' : '' }}>{{ $s->title }}</option>
                @endforeach
            </select>
            @error('service_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="title" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" id="title" required value="{{ old('title', $portfolioItem->title) }}" class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" placeholder="e.g. Full Stack Web Applications (Laravel)">
            @error('title')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Description</label>
            <textarea name="description" id="description" rows="4" class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm resize-none" placeholder="Brief description...">{{ old('description', $portfolioItem->description) }}</textarea>
            @error('description')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="icon" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Icon (Material Symbols)</label>
                <input type="text" name="icon" id="icon" value="{{ old('icon', $portfolioItem->icon) }}" class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/40 transition-all text-sm" placeholder="code, phone_android, desktop_windows">
                @error('icon')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="order" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Order</label>
                <input type="number" name="order" id="order" min="0" value="{{ old('order', $portfolioItem->order) }}" class="block w-full max-w-[120px] px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/40 transition-all text-sm">
                @error('order')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex items-center gap-3">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $portfolioItem->is_active) ? 'checked' : '' }} class="rounded text-primary focus:ring-primary/40">
            <label for="is_active" class="text-sm font-medium text-slate-700 dark:text-slate-300">Active</label>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-200 dark:border-slate-700">
            <a href="{{ route('admin.portfolio-items.index') }}" class="px-6 py-3 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-semibold hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">Cancel</a>
            <button type="submit" class="px-6 py-3 rounded-xl bg-primary text-white font-bold hover:bg-primary/90 transition-colors">Update Portfolio Item</button>
        </div>
    </form>
</div>
@endsection
