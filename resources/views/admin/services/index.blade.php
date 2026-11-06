@extends('admin.layout')

@section('title', 'Services Management')

@section('content')
@php
    $q = request('q', '');
@endphp

<!-- Page Heading -->
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
    <div class="flex flex-col">
        <h2 class="text-slate-900 dark:text-white text-4xl font-black tracking-tight">Services Management</h2>
        <p class="text-slate-500 dark:text-slate-400 mt-1">Manage all services offered by your organization.</p>
    </div>

    <a href="{{ route('admin.services.create') }}" class="flex items-center justify-center gap-2 px-6 h-11 bg-primary hover:bg-primary/90 text-white rounded-lg font-bold transition-all shadow-md shadow-primary/20">
        <span class="material-symbols-outlined text-[20px]">add</span>
        <span>New Service</span>
    </a>
</div>

<!-- Content Card -->
<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
    <!-- Search Bar -->
    <div class="p-6 border-b border-slate-100 dark:border-slate-800">
        <form method="GET" class="relative w-full md:max-w-md">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                <span class="material-symbols-outlined text-[22px]">search</span>
            </div>
            <input name="q" value="{{ $q }}" class="block w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" placeholder="Search services..." type="text"/>
        </form>
    </div>

    <!-- Services List -->
    <div class="admin-table-scroll overflow-x-auto">
        <table class="w-full text-left min-w-[640px]">
            <thead class="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Service</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Order</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Status</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($services as $service)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                @if($service->image)
                                <img src="{{ $service->image_url }}" alt="{{ $service->title }}" class="w-16 h-16 rounded-lg object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                @else
                                <div class="w-16 h-16 rounded-lg bg-primary/10 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-primary text-2xl">{{ $service->icon ?? 'business' }}</span>
                                </div>
                                @endif
                                <div class="min-w-0 flex-1">
                                    <h3 class="text-base font-bold text-slate-900 dark:text-white break-words" title="{{ $service->title }}">{{ $service->title }}</h3>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-1 break-words" title="{{ $service->description }}">{{ Str::limit($service->description, 60) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $service->order }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('admin.services.toggle', $service) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold transition-colors {{ $service->is_active ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 hover:bg-green-200 dark:hover:bg-green-900/50' : 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 hover:bg-red-200 dark:hover:bg-red-900/50' }}">
                                    <span class="material-symbols-outlined text-sm mr-1">{{ $service->is_active ? 'check_circle' : 'cancel' }}</span>
                                    {{ $service->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.sub-services.index', $service) }}" class="p-2 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors" title="Manage Sub-Services">
                                    <span class="material-symbols-outlined text-[20px]">list</span>
                                </a>
                                <a href="{{ route('admin.services.edit', $service) }}" class="p-2 text-primary hover:bg-primary/10 dark:hover:bg-primary/20 rounded-lg transition-colors" title="Edit Service">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </a>
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this service? This action cannot be undone.');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors" title="Delete Service">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <span class="material-symbols-outlined text-6xl text-slate-300 dark:text-slate-600 mb-4 block">business_center</span>
                            <p class="text-slate-500 dark:text-slate-400 text-lg mb-2">No services found</p>
                            <p class="text-slate-400 dark:text-slate-500 text-sm mb-4">Create your first service to get started</p>
                            <a href="{{ route('admin.services.create') }}" class="inline-flex items-center gap-2 px-6 py-3 border border-transparent text-sm font-semibold rounded-lg text-white bg-primary hover:bg-primary/90 shadow-lg transition-all hover:shadow-xl">
                                <span class="material-symbols-outlined">add</span>
                                <span>Create Service</span>
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($services->hasPages())
<div class="mt-6">
    {{ $services->links() }}
</div>
@endif
@endsection


