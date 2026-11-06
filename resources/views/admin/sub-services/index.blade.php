@extends('admin.layout')

@section('title', 'Sub-Services Management')

@section('content')
<div class="px-4 py-5 sm:p-6">
    <!-- Breadcrumb -->
    <div class="mb-4 flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
        <a href="{{ route('admin.services.index') }}" class="hover:text-primary transition-colors">Services</a>
        <span class="material-symbols-outlined text-sm">chevron_right</span>
        <span class="text-slate-700 dark:text-slate-300">Sub-Services: {{ $service->title }}</span>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg flex items-center gap-3">
        <span class="material-symbols-outlined text-green-600 dark:text-green-400">check_circle</span>
        <p class="text-green-800 dark:text-green-300 font-medium">{{ session('success') }}</p>
    </div>
    @endif

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

    <!-- Page Heading -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
        <div class="flex flex-col">
            <h2 class="text-slate-900 dark:text-white text-4xl font-black tracking-tight">Sub-Services</h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Manage sub-services for {{ $service->title }}</p>
        </div>
        <a href="{{ route('admin.sub-services.create', $service) }}" class="flex items-center justify-center gap-2 px-6 h-11 bg-primary hover:bg-primary/90 text-white rounded-lg font-bold transition-all shadow-md shadow-primary/20">
            <span class="material-symbols-outlined text-[20px]">add</span>
            <span>New Sub-Service</span>
        </a>
    </div>

    <!-- Sub-Services List -->
    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
        @if($subServices->count() > 0)
        <div class="admin-table-scroll overflow-x-auto">
            <table class="w-full text-left min-w-[640px]">
                <thead class="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Sub-Service</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Order</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Status</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach($subServices as $subService)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                @if($subService->image)
                                <img src="{{ $subService->image_url }}" alt="{{ $subService->title }}" class="w-16 h-16 rounded-lg object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                @else
                                <div class="w-16 h-16 rounded-lg bg-primary/10 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-primary text-2xl">description</span>
                                </div>
                                @endif
                                <div class="min-w-0 flex-1">
                                    <h3 class="text-base font-bold text-slate-900 dark:text-white break-words" title="{{ $subService->title }}">{{ $subService->title }}</h3>
                                    @if($subService->description)
                                    <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-1 break-words" title="{{ $subService->description }}">{{ Str::limit($subService->description, 60) }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $subService->order }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('admin.sub-services.toggle', $subService) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold transition-colors {{ $subService->is_active ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 hover:bg-green-200 dark:hover:bg-green-900/50' : 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 hover:bg-red-200 dark:hover:bg-red-900/50' }}">
                                    <span class="material-symbols-outlined text-sm mr-1">{{ $subService->is_active ? 'check_circle' : 'cancel' }}</span>
                                    {{ $subService->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.sub-services.edit', $subService) }}" class="p-2 text-primary hover:bg-primary/10 dark:hover:bg-primary/20 rounded-lg transition-colors" title="Edit">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </a>
                                <form action="{{ route('admin.sub-services.destroy', $subService) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this sub-service?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors" title="Delete">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="p-12 text-center">
            <span class="material-symbols-outlined text-6xl text-slate-300 dark:text-slate-600 mb-4">description</span>
            <p class="text-slate-500 dark:text-slate-400 text-lg mb-4">No sub-services yet</p>
            <a href="{{ route('admin.sub-services.create', $service) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary hover:bg-primary/90 text-white rounded-lg font-bold transition-all">
                <span class="material-symbols-outlined">add</span>
                Create First Sub-Service
            </a>
        </div>
        @endif
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.services.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-lg border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors font-bold text-sm">
            <span class="material-symbols-outlined">arrow_back</span>
            Back to Services
        </a>
    </div>
</div>
@endsection

