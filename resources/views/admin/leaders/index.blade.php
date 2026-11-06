@extends('admin.layout')

@section('title', 'Leadership')

@section('content')
@php
    $q = request('q', '');
@endphp

<div class="mb-4 flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a>
    <span class="material-symbols-outlined text-sm">chevron_right</span>
    <span class="text-slate-700 dark:text-slate-300">Leadership</span>
</div>

<!-- Page Heading -->
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
    <div class="flex flex-col">
        <h2 class="text-slate-900 dark:text-white text-4xl font-black tracking-tight">Leadership</h2>
        <p class="text-slate-500 dark:text-slate-400 mt-1">Manage leaders shown on the About and Team pages. IT team is managed from IT Services.</p>
    </div>

    <a href="{{ route('admin.leaders.create') }}" class="flex items-center justify-center gap-2 px-6 h-11 bg-primary hover:bg-primary/90 text-white rounded-lg font-bold transition-all shadow-md shadow-primary/20">
        <span class="material-symbols-outlined text-[20px]">person_add</span>
        <span>Add New Leader</span>
    </a>
</div>

<!-- Success Message -->
@if(session('success'))
    <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl">
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-green-600 dark:text-green-400">check_circle</span>
            <p class="text-sm font-semibold text-green-800 dark:text-green-200">{{ session('success') }}</p>
        </div>
    </div>
@endif

<!-- Error Message -->
@if($errors->has('error'))
    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-red-600 dark:text-red-400">error</span>
            <p class="text-sm font-semibold text-red-800 dark:text-red-200">{{ $errors->first('error') }}</p>
        </div>
    </div>
@endif

<!-- Content Card -->
<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
    <!-- Search Bar -->
    <div class="p-6 border-b border-slate-100 dark:border-slate-800">
        <form method="GET" class="relative w-full md:max-w-md">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                <span class="material-symbols-outlined text-[22px]">search</span>
            </div>
            <input name="q" value="{{ $q }}" class="block w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" placeholder="Search by name, role or department..." type="text"/>
        </form>
    </div>

    <!-- Table -->
    <div class="admin-table-scroll overflow-x-auto">
        <table class="w-full text-left min-w-[640px]">
            <thead class="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Name</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Role</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Department</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Status</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($leaders as $leader)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="size-10 rounded-full border border-slate-200 dark:border-slate-700 overflow-hidden bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                                    @if($leader->image)
                                        <img alt="{{ $leader->name }}" class="size-full object-cover" src="{{ $leader->image_url }}" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <span class="material-symbols-outlined text-slate-400" style="display: none;">person</span>
                                    @else
                                        <span class="material-symbols-outlined text-slate-400">person</span>
                                    @endif
                                </div>
                                <span class="font-bold text-slate-900 dark:text-white max-w-[220px] text-truncate break-words" title="{{ $leader->name }}">{{ $leader->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-slate-600 dark:text-slate-300">
                            <div class="max-w-[240px] text-truncate break-words" title="{{ $leader->role }}">{{ $leader->role }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-slate-600 dark:text-slate-300">
                            <div class="max-w-[220px] text-truncate break-words" title="{{ $leader->department ?? '' }}">{{ $leader->department ?? '—' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('admin.leaders.toggle', $leader) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold transition-colors {{ $leader->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 hover:bg-green-200 dark:hover:bg-green-900/50' : 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700' }}" title="Click to toggle status">
                                    {{ $leader->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.leaders.edit', $leader) }}" class="p-2 text-primary hover:bg-primary/10 rounded-lg transition-colors" title="Edit">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </a>
                                <form action="{{ route('admin.leaders.destroy', $leader) }}" method="POST" onsubmit="return confirm('Delete this leader?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors" title="Delete" type="submit">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-slate-500 dark:text-slate-400">
                            No leaders found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 p-6 border-t border-slate-100 dark:border-slate-800">
        <span class="text-sm text-slate-500 dark:text-slate-400">
            Showing <span class="font-semibold text-slate-900 dark:text-white">{{ $leaders->firstItem() ?? 0 }}</span>
            to <span class="font-semibold text-slate-900 dark:text-white">{{ $leaders->lastItem() ?? 0 }}</span>
            of <span class="font-semibold text-slate-900 dark:text-white">{{ $leaders->total() }}</span> leaders
        </span>

        @if(method_exists($leaders, 'hasPages') && $leaders->hasPages())
            <div class="flex items-center gap-1">
                @if($leaders->onFirstPage())
                    <button disabled class="size-10 flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-700 text-slate-400 cursor-not-allowed">
                        <span class="material-symbols-outlined text-lg">chevron_left</span>
                    </button>
                @else
                    <a href="{{ $leaders->previousPageUrl() }}" class="size-10 flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-700 text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        <span class="material-symbols-outlined text-lg">chevron_left</span>
                    </a>
                @endif

                @foreach($leaders->getUrlRange(1, min(6, $leaders->lastPage())) as $page)
                    @if($page == $leaders->currentPage())
                        <button class="size-10 flex items-center justify-center rounded-lg bg-primary text-white font-bold transition-all shadow-sm">{{ $page }}</button>
                    @else
                        <a href="{{ $leaders->url($page) }}" class="size-10 flex items-center justify-center rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors font-medium">{{ $page }}</a>
                    @endif
                @endforeach

                @if($leaders->hasMorePages())
                    <span class="px-2 text-slate-400">...</span>
                    <a href="{{ $leaders->url($leaders->lastPage()) }}" class="size-10 flex items-center justify-center rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors font-medium">{{ $leaders->lastPage() }}</a>
                @endif

                @if($leaders->hasMorePages())
                    <a href="{{ $leaders->nextPageUrl() }}" class="size-10 flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-700 text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        <span class="material-symbols-outlined text-lg">chevron_right</span>
                    </a>
                @else
                    <button disabled class="size-10 flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-700 text-slate-400 cursor-not-allowed">
                        <span class="material-symbols-outlined text-lg">chevron_right</span>
                    </button>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Summary Cards -->
@php
    $base = fn () => \App\Models\Leader::where(function ($q) { $q->where('department', '!=', 'IT')->orWhereNull('department'); });
    $totalLeaders = $base()->count();
    $activeLeaders = $base()->where('is_active', true)->count();
    $inactiveLeaders = $base()->where('is_active', false)->count();
@endphp

<div class="grid md:grid-cols-3 gap-6 mt-12">
    <div class="p-6 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center gap-4">
        <div class="size-12 rounded-full bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-primary">
            <span class="material-symbols-outlined">group</span>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Total Leaders</p>
            <p class="text-2xl font-black text-slate-900 dark:text-white">{{ $totalLeaders }}</p>
        </div>
    </div>

    <div class="p-6 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center gap-4">
        <div class="size-12 rounded-full bg-green-50 dark:bg-green-900/20 flex items-center justify-center text-green-600">
            <span class="material-symbols-outlined">check_circle</span>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Active</p>
            <p class="text-2xl font-black text-slate-900 dark:text-white">{{ $activeLeaders }}</p>
        </div>
    </div>

    <div class="p-6 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center gap-4">
        <div class="size-12 rounded-full bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center text-amber-600">
            <span class="material-symbols-outlined">pending_actions</span>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Inactive</p>
            <p class="text-2xl font-black text-slate-900 dark:text-white">{{ $inactiveLeaders }}</p>
        </div>
    </div>
</div>
@endsection

