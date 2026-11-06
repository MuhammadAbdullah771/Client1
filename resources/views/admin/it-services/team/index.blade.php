@extends('admin.layout')

@section('title', 'IT Services Team')

@section('content')
@php
    $q = request('q', '');
@endphp

<div class="mb-4 flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
    <a href="{{ route('admin.it-services.index') }}" class="hover:text-primary transition-colors">IT Services</a>
    <span class="material-symbols-outlined text-sm">chevron_right</span>
    <span class="text-slate-700 dark:text-slate-300">IT Services Team</span>
</div>

<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
    <div class="flex flex-col">
        <h2 class="text-slate-900 dark:text-white text-4xl font-black tracking-tight">IT Services Team</h2>
        <p class="text-slate-500 dark:text-slate-400 mt-1">Team members with LinkedIn profiles shown on the IT Services page.</p>
    </div>

    <a href="{{ route('admin.it-services.team.create') }}" class="flex items-center justify-center gap-2 px-6 h-11 bg-primary hover:bg-primary/90 text-white rounded-lg font-bold transition-all shadow-md shadow-primary/20">
        <span class="material-symbols-outlined text-[20px]">person_add</span>
        <span>Add Team Member</span>
    </a>
</div>

<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100 dark:border-slate-800">
        <form method="GET" class="relative w-full md:max-w-md">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                <span class="material-symbols-outlined text-[22px]">search</span>
            </div>
            <input name="q" value="{{ $q }}" class="block w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" placeholder="Search by name or role..." type="text"/>
        </form>
    </div>

    <div class="admin-table-scroll overflow-x-auto">
        <table class="w-full text-left min-w-[640px]">
            <thead class="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Name</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Role</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Status</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($members as $member)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="size-10 rounded-full border border-slate-200 dark:border-slate-700 overflow-hidden bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                                    @if($member->image)
                                        <img alt="{{ $member->name }}" class="size-full object-cover" src="{{ asset($member->image) }}" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <span class="material-symbols-outlined text-slate-400" style="display: none;">person</span>
                                    @else
                                        <span class="material-symbols-outlined text-slate-400">person</span>
                                    @endif
                                </div>
                                <span class="font-bold text-slate-900 dark:text-white max-w-[220px] text-truncate break-words" title="{{ $member->name }}">{{ $member->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-slate-600 dark:text-slate-300">
                            <div class="max-w-[240px] text-truncate break-words" title="{{ $member->role }}">{{ $member->role }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('admin.it-services.team.toggle', $member) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold transition-colors {{ $member->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 hover:bg-green-200 dark:hover:bg-green-900/50' : 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700' }}" title="Click to toggle status">
                                    {{ $member->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.it-services.team.edit', $member) }}" class="p-2 text-primary hover:bg-primary/10 dark:hover:bg-primary/20 rounded-lg transition-colors" title="Edit">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </a>
                                <form action="{{ route('admin.it-services.team.destroy', $member) }}" method="POST" onsubmit="return confirm('Remove this team member?');" class="inline">
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
                        <td colspan="4" class="px-6 py-10 text-center text-slate-500 dark:text-slate-400">
                            No IT Services team members yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 p-6 border-t border-slate-100 dark:border-slate-800">
        <span class="text-sm text-slate-500 dark:text-slate-400">
            Showing <span class="font-semibold text-slate-900 dark:text-white">{{ $members->firstItem() ?? 0 }}</span>
            to <span class="font-semibold text-slate-900 dark:text-white">{{ $members->lastItem() ?? 0 }}</span>
            of <span class="font-semibold text-slate-900 dark:text-white">{{ $members->total() }}</span> team members
        </span>

        @if(method_exists($members, 'hasPages') && $members->hasPages())
            <div class="flex items-center gap-1">
                @if($members->onFirstPage())
                    <button disabled class="size-10 flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-700 text-slate-400 cursor-not-allowed">
                        <span class="material-symbols-outlined text-lg">chevron_left</span>
                    </button>
                @else
                    <a href="{{ $members->previousPageUrl() }}" class="size-10 flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-700 text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        <span class="material-symbols-outlined text-lg">chevron_left</span>
                    </a>
                @endif

                @foreach($members->getUrlRange(1, min(6, $members->lastPage())) as $page)
                    @if($page == $members->currentPage())
                        <button class="size-10 flex items-center justify-center rounded-lg bg-primary text-white font-bold transition-all shadow-sm">{{ $page }}</button>
                    @else
                        <a href="{{ $members->url($page) }}" class="size-10 flex items-center justify-center rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors font-medium">{{ $page }}</a>
                    @endif
                @endforeach

                @if($members->hasMorePages())
                    <span class="px-2 text-slate-400">...</span>
                    <a href="{{ $members->url($members->lastPage()) }}" class="size-10 flex items-center justify-center rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors font-medium">{{ $members->lastPage() }}</a>
                @endif

                @if($members->hasMorePages())
                    <a href="{{ $members->nextPageUrl() }}" class="size-10 flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-700 text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
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
@endsection
