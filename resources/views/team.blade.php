@extends('layouts.app')

@section('title', __('common.our_leadership_team') . ' | 9Associates')

@section('meta_description', 'Meet the leadership team of 9Associates, experienced professionals in accounting, taxation, audit and strategic consulting, guiding businesses across the GCC.')

@section('meta_keywords', '9Associates team, leadership, partners, accounting experts, tax experts, audit experts, consulting team, GCC')

@section('content')

<section class="max-w-[1200px] mx-auto px-4 sm:px-6 md:px-10 py-16 md:py-24">

    {{-- Heading --}}
    <div class="text-center mb-16 premium-reveal">
        <div class="inline-flex items-center gap-3 mb-5">
            <div class="h-px w-8 bg-primary rounded-full"></div>
            <span class="text-primary font-bold tracking-[0.26em] uppercase text-[0.68rem]">Our People</span>
            <div class="h-px w-8 bg-primary rounded-full"></div>
        </div>
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4 text-navy-deep dark:text-white">
            {{ __('common.our_leadership_team') }}
        </h1>
        <p class="text-lg text-slate-500 dark:text-slate-400 max-w-2xl mx-auto leading-relaxed">
            {{ __('common.leadership_description') }}
        </p>
    </div>

    {{-- Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">

        @foreach($leaders as $leader)
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-md border border-slate-200 dark:border-slate-800 overflow-hidden transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl group">

            {{-- Image --}}
            <div class="relative overflow-hidden">
                @if($leader->image_url)
                    <img 
                        src="{{ $leader->image_url }}" 
                        alt="{{ $leader->name }}"
                        class="w-full h-72 object-cover transition-transform duration-500 group-hover:scale-110"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                    >
                    <div class="hidden w-full h-72 items-center justify-center bg-slate-100">
                        <span class="material-symbols-outlined text-6xl text-slate-400">person</span>
                    </div>
                @else
                    <div class="w-full h-72 flex items-center justify-center bg-slate-100">
                        <span class="material-symbols-outlined text-6xl text-slate-400">person</span>
                    </div>
                @endif
            </div>

            {{-- Content --}}
            <div class="p-6">

                <h3 class="text-xl font-bold mb-1">
                    {{ $leader->name }}
                </h3>

                <p class="text-primary text-sm font-semibold uppercase tracking-wide mb-1">
                    {{ $leader->role }}
                </p>

                @if($leader->department)
                <p class="text-xs text-slate-500 mb-3">
                    {{ $leader->department }}
                </p>
                @endif

                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed line-clamp-4">
                    {{ $leader->bio }}
                </p>

                {{-- Social Icons --}}
                <div class="flex gap-3 mt-5">
                    @if($leader->linkedin)
                    <a href="{{ $leader->linkedin }}" target="_blank"
                       class="w-9 h-9 flex items-center justify-center rounded-full bg-slate-100 hover:bg-primary hover:text-white transition">
                        <span class="material-symbols-outlined text-sm">work</span>
                    </a>
                    @endif

                    @if($leader->email)
                    <a href="mailto:{{ $leader->email }}"
                       class="w-9 h-9 flex items-center justify-center rounded-full bg-slate-100 hover:bg-primary hover:text-white transition">
                        <span class="material-symbols-outlined text-sm">mail</span>
                    </a>
                    @endif
                </div>

            </div>
        </div>
        @endforeach

    </div>

</section>

{{-- CTA SECTION --}}
<section class="max-w-[1080px] mx-auto px-4 sm:px-6 pb-16 sm:pb-20">
    <div class="relative rounded-2xl sm:rounded-3xl overflow-hidden" style="background: linear-gradient(135deg, #137fec 0%, #0e6fd4 40%, #3730a3 100%);">
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true" style="background-image: radial-gradient(circle, rgba(255,255,255,0.07) 1px, transparent 1px); background-size: 28px 28px;"></div>
        <div class="absolute -top-24 -right-24 w-80 h-80 bg-white/10 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>
        <div class="relative z-10 p-8 sm:p-10 md:p-16 text-center text-white flex flex-col items-center gap-5">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-black leading-tight max-w-[600px]">{{ __('common.ready_to_work') }}</h2>
            <p class="text-sm sm:text-base max-w-xl text-white/85 leading-relaxed">{{ __('common.connect_leadership') }}</p>
            <div class="flex flex-col sm:flex-row gap-3 mt-2">
                <button type="button" onclick="openContactModal('')"
                    class="inline-flex items-center justify-center gap-2 rounded-xl h-12 sm:h-14 px-8 sm:px-10 bg-white text-primary text-sm sm:text-base font-black tracking-wide transition-all hover:scale-105 hover:shadow-2xl shadow-lg">
                    {{ __('common.get_in_touch') }}
                    <span class="material-symbols-outlined text-lg">arrow_forward</span>
                </button>
                <a href="{{ route('services') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl h-12 sm:h-14 px-8 sm:px-10 border-2 border-white/35 text-white text-sm sm:text-base font-bold tracking-wide transition-all hover:bg-white/12 hover:border-white/55">
                    {{ __('common.view_services') }}
                </a>
            </div>
        </div>
    </div>
</section>

@endsection