@extends('admin.layout')

@section('title', 'Portfolio Items')

@section('content')
<div class="mb-4 flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
    <a href="{{ route('admin.it-services.index') }}" class="hover:text-primary transition-colors">IT Services</a>
    <span class="material-symbols-outlined text-sm">chevron_right</span>
    <span class="text-slate-700 dark:text-slate-300">Portfolio</span>
</div>

<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
    <div class="flex flex-col">
        <h2 class="text-slate-900 dark:text-white text-4xl font-black tracking-tight">Portfolio Items (IT Services)</h2>
        <p class="text-slate-500 dark:text-slate-400 mt-1">Manage portfolio services shown on the IT Services page: Full Stack Laravel, Flutter, C# Desktop, etc.</p>
    </div>
    <a href="{{ route('admin.portfolio-items.create') }}" class="flex items-center justify-center gap-2 px-6 h-11 bg-primary hover:bg-primary/90 text-white rounded-lg font-bold transition-all shadow-md shadow-primary/20">
        <span class="material-symbols-outlined text-[20px]">add</span>
        <span>New Portfolio Item</span>
    </a>
</div>

<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="admin-table-scroll overflow-x-auto">
        <table class="w-full text-left min-w-[640px]">
            <thead class="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Portfolio Item</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Service</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Order</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Status</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($items as $item)
                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined text-primary text-xl">{{ $item->icon ?? 'code' }}</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-base font-bold text-slate-900 dark:text-white break-words" title="{{ $item->title }}">{{ $item->title }}</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-1 break-words" title="{{ $item->description }}">{{ Str::limit($item->description, 50) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="max-w-[200px] text-sm text-slate-600 dark:text-slate-400 break-words" title="{{ $item->service->title ?? '-' }}">{{ $item->service->title ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap"><span class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $item->order }}</span></td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $item->is_active ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300' : 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300' }}">
                            {{ $item->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.portfolio-items.edit', $item) }}" class="p-2 text-primary hover:bg-primary/10 dark:hover:bg-primary/20 rounded-lg transition-colors" title="Edit">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </a>
                            <form action="{{ route('admin.portfolio-items.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this portfolio item?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors" title="Delete">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <span class="material-symbols-outlined text-6xl text-slate-300 dark:text-slate-600 mb-4 block">code</span>
                        <p class="text-slate-500 dark:text-slate-400 text-lg mb-2">No portfolio items yet</p>
                        <p class="text-slate-400 dark:text-slate-500 text-sm mb-4">Add Full Stack Laravel, Flutter, C# Desktop, etc. for IT Services.</p>
                        <div class="flex flex-wrap justify-center gap-3">
                            <a href="{{ route('admin.portfolio-items.create') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-lg text-white bg-primary hover:bg-primary/90 font-semibold transition-all">
                                <span class="material-symbols-outlined">add</span>
                                <span>Add Portfolio Item</span>
                            </a>
                            <a href="{{ route('admin.it-services.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-lg border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-semibold hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">Back to IT Services</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($items->hasPages())
<div class="mt-6">{{ $items->links() }}</div>
@endif
@endsection
