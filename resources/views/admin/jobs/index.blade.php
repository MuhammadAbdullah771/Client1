@extends('admin.layout')

@section('title', 'Jobs Management')

@section('content')
<div class="px-4 py-5 sm:p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-navy-deep dark:text-white mb-2">Career Posts Management</h1>
            <p class="text-slate-600 dark:text-slate-400">Manage open positions and job postings</p>
        </div>
        <a href="{{ route('admin.jobs.create') }}" class="inline-flex items-center gap-2 px-6 py-3 border border-transparent text-sm font-semibold rounded-lg text-white bg-primary hover:bg-primary/90 shadow-lg shadow-primary/20 transition-all hover:shadow-xl">
            <span class="material-symbols-outlined">work</span>
            <span>Job Posting</span>
        </a>
    </div>

    <div class="bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden">
        <ul class="divide-y divide-slate-200 dark:divide-slate-800">
            @forelse($jobs as $job)
            <li class="hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                <div class="px-6 py-5 flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-2 gap-4">
                            <h3 class="text-lg font-bold text-navy-deep dark:text-white break-words flex-1 min-w-0" title="{{ $job->title }}">{{ $job->title }}</h3>
                            <div class="flex items-center gap-2 ml-4">
                                @if($job->is_active)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                    <span class="material-symbols-outlined text-sm mr-1">check_circle</span>
                                    Active
                                </span>
                                @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300">
                                    <span class="material-symbols-outlined text-sm mr-1">cancel</span>
                                    Inactive
                                </span>
                                @endif
                            </div>
                        </div>
                        @if($job->description)
                        <p class="text-sm text-slate-600 dark:text-slate-400 mb-3 line-clamp-2 break-words" title="{{ $job->description }}">{{ Str::limit($job->description, 120) }}</p>
                        @endif
                        <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500 dark:text-slate-400">
                            <span class="flex items-center">
                                <span class="material-symbols-outlined text-sm mr-1">business_center</span>
                                {{ $job->department }}
                            </span>
                            <span class="flex items-center">
                                <span class="material-symbols-outlined text-sm mr-1">location_on</span>
                                {{ $job->location }}
                            </span>
                            <span class="flex items-center">
                                <span class="material-symbols-outlined text-sm mr-1">work</span>
                                {{ $job->employment_type }}
                            </span>
                            <span class="flex items-center">
                                <span class="material-symbols-outlined text-sm mr-1">schedule</span>
                                {{ $job->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                    <div class="ml-6 flex items-center gap-2">
                        <a href="{{ route('admin.jobs.edit', $job) }}" class="p-2 text-primary hover:bg-primary/10 dark:hover:bg-primary/20 rounded-lg transition-colors" title="Edit Job">
                            <span class="material-symbols-outlined">edit</span>
                        </a>
                        <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this job posting? This action cannot be undone.');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors" title="Delete Job">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            </li>
            @empty
            <li class="px-6 py-12 text-center">
                <span class="material-symbols-outlined text-6xl text-slate-300 dark:text-slate-600 mb-4 block">work</span>
                <p class="text-slate-500 dark:text-slate-400 text-lg mb-2">No job postings found</p>
                <p class="text-slate-400 dark:text-slate-500 text-sm mb-4">Create your first job posting to start attracting candidates</p>
                <a href="{{ route('admin.jobs.create') }}" class="inline-flex items-center gap-2 px-6 py-3 border border-transparent text-sm font-semibold rounded-lg text-white bg-primary hover:bg-primary/90 shadow-lg transition-all hover:shadow-xl">
                    <span class="material-symbols-outlined">work</span>
                    <span>Create Job Posting</span>
                </a>
            </li>
            @endforelse
        </ul>
    </div>

    @if($jobs->hasPages())
    <div class="mt-6">
        {{ $jobs->links() }}
    </div>
    @endif
</div>
@endsection
