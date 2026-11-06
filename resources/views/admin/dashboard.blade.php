@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="min-w-0">
    <!-- Welcome Header -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-primary text-2xl">dashboard</span>
            </div>
            <div>
                <h1 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white">Admin Dashboard</h1>
                <p class="text-slate-500 dark:text-slate-400 text-sm sm:text-base mt-1">Welcome! Manage your content from here.</p>
            </div>
        </div>
    </div>
    
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 gap-4 sm:gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <!-- Total Services Card -->
        <div class="group bg-white dark:bg-slate-900 shadow-md sm:shadow-lg rounded-xl border border-slate-200 dark:border-slate-800 hover:shadow-xl hover:border-primary/30 dark:hover:border-primary/50 transition-all duration-300">
            <div class="p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center group-hover:bg-primary group-hover:scale-110 transition-transform duration-300 shrink-0 overflow-hidden">
                        <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 group-hover:text-white" style="font-size: 28px; line-height: 1;">business_center</span>
                    </div>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Total Services</p>
                    <p class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white leading-tight">{{ $stats['services_count'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Active Services Card -->
        <div class="group bg-white dark:bg-slate-900 shadow-md sm:shadow-lg rounded-xl border border-slate-200 dark:border-slate-800 hover:shadow-xl hover:border-green-300 dark:hover:border-green-500/50 transition-all duration-300">
            <div class="p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-xl bg-green-50 dark:bg-green-900/20 flex items-center justify-center group-hover:bg-green-600 group-hover:scale-110 transition-transform duration-300 shrink-0 overflow-hidden">
                        <span class="material-symbols-outlined text-green-600 dark:text-green-400 group-hover:text-white" style="font-size: 28px; line-height: 1;">check_circle</span>
                    </div>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Active Services</p>
                    <p class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white leading-tight">{{ $stats['active_services'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Total Insights Card -->
        <div class="group bg-white dark:bg-slate-900 shadow-md sm:shadow-lg rounded-xl border border-slate-200 dark:border-slate-800 hover:shadow-xl hover:border-purple-300 dark:hover:border-purple-500/50 transition-all duration-300">
            <div class="p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-xl bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center group-hover:bg-purple-600 group-hover:scale-110 transition-transform duration-300 shrink-0 overflow-hidden">
                        <span class="material-symbols-outlined text-purple-600 dark:text-purple-400 group-hover:text-white" style="font-size: 28px; line-height: 1;">article</span>
                    </div>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Total Insights</p>
                    <p class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white leading-tight">{{ $stats['insights_count'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Total Jobs Card -->
        <div class="group bg-white dark:bg-slate-900 shadow-md sm:shadow-lg rounded-xl border border-slate-200 dark:border-slate-800 hover:shadow-xl hover:border-amber-300 dark:hover:border-amber-500/50 transition-all duration-300">
            <div class="p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-xl bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center group-hover:bg-amber-600 group-hover:scale-110 transition-transform duration-300 shrink-0 overflow-hidden">
                        <span class="material-symbols-outlined text-amber-600 dark:text-amber-400 group-hover:text-white" style="font-size: 28px; line-height: 1;">work</span>
                    </div>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Total Jobs</p>
                    <p class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white leading-tight">{{ $stats['jobs_count'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="bg-white dark:bg-slate-900 shadow-md sm:shadow-lg rounded-xl border border-slate-200 dark:border-slate-800 p-6 md:p-8 hover:shadow-xl dark:hover:border-slate-700 transition-all duration-300">
        <div class="flex items-center gap-3 mb-6">
            <span class="material-symbols-outlined text-primary text-2xl">bolt</span>
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">Quick Actions</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="{{ route('admin.services.create') }}" class="group flex items-center justify-center gap-3 px-6 py-4 border border-transparent rounded-xl shadow-md text-base font-bold text-white bg-primary hover:bg-primary/90 transition-all hover:shadow-xl hover:scale-105">
                <span class="material-symbols-outlined text-xl sm:text-2xl shrink-0" style="font-size: 24px; line-height: 1;">add_business</span>
                <span class="text-center">Create Service</span>
            </a>
            <a href="{{ route('admin.insights.create') }}" class="group flex items-center justify-center gap-3 px-6 py-4 border border-transparent rounded-xl shadow-md text-base font-bold text-white bg-green-600 hover:bg-green-700 transition-all hover:shadow-xl hover:scale-105">
                <span class="material-symbols-outlined text-xl sm:text-2xl shrink-0" style="font-size: 24px; line-height: 1;">add_circle</span>
                <span class="text-center">Create Insight</span>
            </a>
            <a href="{{ route('admin.jobs.create') }}" class="group flex items-center justify-center gap-3 px-6 py-4 border border-transparent rounded-xl shadow-md text-base font-bold text-white bg-blue-600 hover:bg-blue-700 transition-all hover:shadow-xl hover:scale-105">
                <span class="material-symbols-outlined text-xl sm:text-2xl shrink-0" style="font-size: 24px; line-height: 1;">post_add</span>
                <span class="text-center">Create Job Posting</span>
            </a>
        </div>
    </div>

    <!-- Navigation Cards -->
    <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <a href="{{ route('admin.services.index') }}" class="group flex items-center gap-4 p-5 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-primary/50 hover:shadow-lg transition-all">
            <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center group-hover:bg-primary transition-colors shrink-0 overflow-hidden">
                <span class="material-symbols-outlined text-primary group-hover:text-white" style="font-size: 24px; line-height: 1;">business_center</span>
            </div>
            <div class="min-w-0 flex-1">
                <p class="font-bold text-slate-900 dark:text-white">Services</p>
                <p class="text-xs text-slate-500 dark:text-slate-400">Manage services</p>
            </div>
            <span class="material-symbols-outlined text-slate-400 group-hover:text-primary shrink-0" style="font-size: 20px; line-height: 1;">chevron_right</span>
        </a>

        <a href="{{ route('admin.leaders.index') }}" class="group flex items-center gap-4 p-5 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-primary/50 hover:shadow-lg transition-all">
            <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center group-hover:bg-primary transition-colors shrink-0 overflow-hidden">
                <span class="material-symbols-outlined text-primary group-hover:text-white" style="font-size: 24px; line-height: 1;">group</span>
            </div>
            <div class="min-w-0 flex-1">
                <p class="font-bold text-slate-900 dark:text-white">Leadership</p>
                <p class="text-xs text-slate-500 dark:text-slate-400">Manage leaders</p>
            </div>
            <span class="material-symbols-outlined text-slate-400 group-hover:text-primary shrink-0" style="font-size: 20px; line-height: 1;">chevron_right</span>
        </a>

        <a href="{{ route('admin.milestones.index') }}" class="group flex items-center gap-4 p-5 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-primary/50 hover:shadow-lg transition-all">
            <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center group-hover:bg-primary transition-colors shrink-0 overflow-hidden">
                <span class="material-symbols-outlined text-primary group-hover:text-white" style="font-size: 24px; line-height: 1;">timeline</span>
            </div>
            <div class="min-w-0 flex-1">
                <p class="font-bold text-slate-900 dark:text-white">Milestones</p>
                <p class="text-xs text-slate-500 dark:text-slate-400">Manage timeline</p>
            </div>
            <span class="material-symbols-outlined text-slate-400 group-hover:text-primary shrink-0" style="font-size: 20px; line-height: 1;">chevron_right</span>
        </a>

        <a href="{{ route('admin.settings.index') }}" class="group flex items-center gap-4 p-5 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-primary/50 hover:shadow-lg transition-all">
            <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center group-hover:bg-primary transition-colors shrink-0 overflow-hidden">
                <span class="material-symbols-outlined text-primary group-hover:text-white" style="font-size: 24px; line-height: 1;">settings</span>
            </div>
            <div class="min-w-0 flex-1">
                <p class="font-bold text-slate-900 dark:text-white">Settings</p>
                <p class="text-xs text-slate-500 dark:text-slate-400">Configure app</p>
            </div>
            <span class="material-symbols-outlined text-slate-400 group-hover:text-primary shrink-0" style="font-size: 20px; line-height: 1;">chevron_right</span>
        </a>
    </div>
</div>
@endsection
