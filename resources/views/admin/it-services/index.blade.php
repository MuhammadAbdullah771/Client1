@extends('admin.layout')

@section('title', 'IT Services')

@section('content')
<div class="mb-8">
    <h2 class="text-slate-900 dark:text-white text-4xl font-black tracking-tight mb-2">IT Services</h2>
    <p class="text-slate-500 dark:text-slate-400">Manage the IT Services page only. Edit the service, IT Manager, portfolio, and IT Services Team (shown on IT Services page).</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    @if($itService)
    <a href="{{ route('admin.services.edit', $itService) }}" class="group flex flex-col bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-6 hover:border-primary/50 hover:shadow-xl transition-all duration-300">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-14 h-14 rounded-xl bg-primary/10 flex items-center justify-center group-hover:bg-primary group-hover:scale-110 transition-all duration-300 shrink-0 overflow-hidden">
                <span class="material-symbols-outlined text-primary group-hover:text-white transition-colors" style="font-size: 32px; line-height: 1;">computer</span>
            </div>
            <div class="min-w-0 flex-1">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white break-words">IT Service</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 break-words">Title, description, image</p>
            </div>
        </div>
        <p class="text-slate-600 dark:text-slate-400 text-sm flex-1 break-words mb-4">Edit the main IT Services listing: title, description, hero image, contact email & message.</p>
        <span class="mt-auto inline-flex items-center text-primary font-semibold text-sm group-hover:underline">
            Edit IT Service <span class="material-symbols-outlined text-lg ml-1 group-hover:translate-x-1 transition-transform">arrow_forward</span>
        </span>
    </a>
    @endif

    <a href="{{ route('admin.it-manager.edit') }}" class="group flex flex-col bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-6 hover:border-primary/50 hover:shadow-xl transition-all duration-300">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-14 h-14 rounded-xl bg-primary/10 flex items-center justify-center group-hover:bg-primary group-hover:scale-110 transition-all duration-300 shrink-0 overflow-hidden">
                <span class="material-symbols-outlined text-primary group-hover:text-white transition-colors" style="font-size: 32px; line-height: 1;">person</span>
            </div>
            <div class="min-w-0 flex-1">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white break-words">IT Manager</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 break-words">Profile & vision</p>
            </div>
        </div>
        <p class="text-slate-600 dark:text-slate-400 text-sm flex-1 break-words mb-4">Photo, vision, LinkedIn, email, WhatsApp for the IT Services portfolio section.</p>
        <span class="mt-auto inline-flex items-center text-primary font-semibold text-sm group-hover:underline">
            Edit IT Manager <span class="material-symbols-outlined text-lg ml-1 group-hover:translate-x-1 transition-transform">arrow_forward</span>
        </span>
    </a>

    <a href="{{ route('admin.portfolio-items.index') }}" class="group flex flex-col bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-6 hover:border-primary/50 hover:shadow-xl transition-all duration-300">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-14 h-14 rounded-xl bg-primary/10 flex items-center justify-center group-hover:bg-primary group-hover:scale-110 transition-all duration-300 shrink-0 overflow-hidden">
                <span class="material-symbols-outlined text-primary group-hover:text-white transition-colors" style="font-size: 32px; line-height: 1;">code</span>
            </div>
            <div class="min-w-0 flex-1">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white break-words">Portfolio</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 break-words">{{ $portfolioCount }} item(s)</p>
            </div>
        </div>
        <p class="text-slate-600 dark:text-slate-400 text-sm flex-1 break-words mb-4">Full Stack Laravel, Flutter, C# Desktop, and other portfolio services on the IT Services page.</p>
        <span class="mt-auto inline-flex items-center text-primary font-semibold text-sm group-hover:underline">
            Manage Portfolio <span class="material-symbols-outlined text-lg ml-1 group-hover:translate-x-1 transition-transform">arrow_forward</span>
        </span>
    </a>

    <a href="{{ route('admin.it-services.team.index') }}" class="group flex flex-col bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-6 hover:border-primary/50 hover:shadow-xl transition-all duration-300">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-14 h-14 rounded-xl bg-primary/10 flex items-center justify-center group-hover:bg-primary group-hover:scale-110 transition-all duration-300 shrink-0 overflow-hidden">
                <span class="material-symbols-outlined text-primary group-hover:text-white transition-colors" style="font-size: 32px; line-height: 1;">engineering</span>
            </div>
            <div class="min-w-0 flex-1">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white break-words">IT Services Team</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 break-words">{{ $teamCount }} member(s)</p>
            </div>
        </div>
        <p class="text-slate-600 dark:text-slate-400 text-sm flex-1 break-words mb-4">IT team members with LinkedIn profiles shown on the IT Services page.</p>
        <span class="mt-auto inline-flex items-center text-primary font-semibold text-sm group-hover:underline">
            Manage Team <span class="material-symbols-outlined text-lg ml-1 group-hover:translate-x-1 transition-transform">arrow_forward</span>
        </span>
    </a>
</div>
@endsection
