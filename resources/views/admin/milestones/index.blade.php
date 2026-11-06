@extends('admin.layout')

@section('title', 'Milestones Management')

@section('content')
<!-- Page Heading -->
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
    <div class="flex flex-col">
        <h2 class="text-slate-900 dark:text-white text-4xl font-black tracking-tight">Milestones Management</h2>
        <p class="text-slate-500 dark:text-slate-400 mt-1">Manage company milestones shown on the About page timeline.</p>
    </div>

    <a href="{{ route('admin.milestones.create') }}" class="flex items-center justify-center gap-2 px-6 h-11 bg-primary hover:bg-primary/90 text-white rounded-lg font-bold transition-all shadow-md shadow-primary/20">
        <span class="material-symbols-outlined text-[20px]">add</span>
        <span>New Milestone</span>
    </a>
</div>

<!-- Content Card -->
<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
    <!-- Milestones List -->
    <div class="admin-table-scroll overflow-x-auto">
        <table class="w-full text-left min-w-[640px]">
            <thead class="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Year</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Title</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Description</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Position</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Order</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($milestones as $milestone)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-lg">calendar_today</span>
                                <span class="text-base font-bold text-slate-900 dark:text-white">{{ $milestone->year }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="max-w-[200px]">
                                <h3 class="text-base font-bold text-slate-900 dark:text-white break-words" title="{{ $milestone->title }}">{{ $milestone->title }}</h3>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="max-w-[300px]">
                                <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-2 break-words" title="{{ $milestone->description }}">{{ $milestone->description }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $milestone->position === 'left' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400' }}">
                                <span class="material-symbols-outlined text-sm mr-1">{{ $milestone->position === 'left' ? 'arrow_back' : 'arrow_forward' }}</span>
                                {{ ucfirst($milestone->position) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $milestone->order }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.milestones.edit', $milestone) }}" class="p-2 text-primary hover:bg-primary/10 dark:hover:bg-primary/20 rounded-lg transition-colors" title="Edit Milestone">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </a>
                                <form action="{{ route('admin.milestones.destroy', $milestone) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this milestone? This action cannot be undone.');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors" title="Delete Milestone">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <span class="material-symbols-outlined text-6xl text-slate-300 dark:text-slate-600 mb-4 block">timeline</span>
                            <p class="text-slate-500 dark:text-slate-400 text-lg mb-2">No milestones found</p>
                            <p class="text-slate-400 dark:text-slate-500 text-sm mb-4">Create your first milestone to get started</p>
                            <a href="{{ route('admin.milestones.create') }}" class="inline-flex items-center gap-2 px-6 py-3 border border-transparent text-sm font-semibold rounded-lg text-white bg-primary hover:bg-primary/90 shadow-lg transition-all hover:shadow-xl">
                                <span class="material-symbols-outlined">add</span>
                                <span>Create Milestone</span>
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

