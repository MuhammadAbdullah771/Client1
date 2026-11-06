@extends('admin.layout')

@section('title', 'Insights Management')

@section('content')
<div class="px-4 py-5 sm:p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-navy-deep dark:text-white mb-2">Insights Management</h1>
            <p class="text-slate-600 dark:text-slate-400">Manage and organize your insight posts</p>
        </div>
        <a href="{{ route('admin.insights.create') }}" class="inline-flex items-center gap-2 px-6 py-3 border border-transparent text-sm font-semibold rounded-lg text-white bg-primary hover:bg-primary/90 shadow-lg shadow-primary/20 transition-all hover:shadow-xl">
            <span class="material-symbols-outlined">article</span>
            <span>Create Insight</span>
        </a>
    </div>

    <div class="bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden">
        <ul class="divide-y divide-slate-200 dark:divide-slate-800">
            @forelse($insights as $insight)
            <li class="hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                <div class="px-6 py-5 flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-2 gap-4">
                            <h3 class="text-lg font-bold text-navy-deep dark:text-white break-words flex-1 min-w-0" title="{{ $insight->title }}">{{ $insight->title }}</h3>
                            <div class="flex items-center gap-2 ml-4">
                                @if($insight->is_featured)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300">
                                    <span class="material-symbols-outlined text-sm mr-1">star</span>
                                    Featured
                                </span>
                                @endif
                            </div>
                        </div>
                        <p class="text-sm text-slate-600 dark:text-slate-400 mb-3 line-clamp-2 break-words" title="{{ $insight->excerpt }}">{{ $insight->excerpt }}</p>
                        <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500 dark:text-slate-400">
                            <span class="flex items-center">
                                <span class="material-symbols-outlined text-sm mr-1">category</span>
                                {{ $insight->category }}
                            </span>
                            <span class="flex items-center">
                                <span class="material-symbols-outlined text-sm mr-1">calendar_today</span>
                                {{ $insight->published_at->format('M d, Y') }}
                            </span>
                            <span class="flex items-center">
                                <span class="material-symbols-outlined text-sm mr-1">schedule</span>
                                {{ $insight->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                    <div class="ml-6 flex items-center gap-2">
                        <a href="{{ route('admin.insights.edit', $insight) }}" class="p-2 text-primary hover:bg-primary/10 dark:hover:bg-primary/20 rounded-lg transition-colors" title="Edit Insight">
                            <span class="material-symbols-outlined">edit</span>
                        </a>
                        <form action="{{ route('admin.insights.destroy', $insight) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this insight? This action cannot be undone.');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors" title="Delete Insight">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            </li>
            @empty
            <li class="px-6 py-12 text-center">
                <span class="material-symbols-outlined text-6xl text-slate-300 dark:text-slate-600 mb-4 block">article</span>
                <p class="text-slate-500 dark:text-slate-400 text-lg mb-2">No insights found</p>
                <p class="text-slate-400 dark:text-slate-500 text-sm mb-4">Get started by creating your first insight post</p>
                <a href="{{ route('admin.insights.create') }}" class="inline-flex items-center gap-2 px-6 py-3 border border-transparent text-sm font-semibold rounded-lg text-white bg-primary hover:bg-primary/90 shadow-lg transition-all hover:shadow-xl">
                    <span class="material-symbols-outlined">article</span>
                    <span>Create Insight</span>
                </a>
            </li>
            @endforelse
        </ul>
    </div>

    @if($insights->hasPages())
    <div class="mt-6">
        {{ $insights->links() }}
    </div>
    @endif
</div>
@endsection
