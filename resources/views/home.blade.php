@extends('layouts.app')

{{-- SEO sections --}}
@section('title', 'VAT Tax & Taxation Advisory Saudi Arabia | 9Associates KSA & GCC')

@section('meta_description', 'Expert VAT tax and taxation services in Saudi Arabia. ZATCA VAT filing, corporate tax compliance, tax advisory, accounting and audit for KSA, UAE and GCC businesses.')

@section('meta_keywords', 'VAT tax Saudi Arabia, taxation Saudi Arabia, VAT KSA, ZATCA VAT filing, corporate tax Saudi Arabia, tax advisory KSA, tax consultant Saudi Arabia, VAT compliance, taxation services, 9Associates')

@push('structured_data')
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => 'VAT Tax & Taxation Advisory — Saudi Arabia',
        'provider' => ['@type' => 'Organization', 'name' => '9Associates', 'url' => url('/')],
        'areaServed' => ['@type' => 'Country', 'name' => 'Saudi Arabia'],
        'description' => 'VAT tax registration, ZATCA compliance, corporate tax and full taxation advisory for businesses in Saudi Arabia and the GCC.',
        'serviceType' => ['VAT Tax', 'Taxation', 'Corporate Tax', 'Tax Compliance'],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endpush

@section('content')

    <section class="home-hero-root home-hero-video" aria-label="Hero">
        <video class="home-hero-video__media" autoplay muted loop playsinline preload="auto">
            <source src="{{ asset('video1.mp4') }}" type="video/mp4">
        </video>
        <div class="home-hero-video__overlay" aria-hidden="true"></div>
        {{-- Floating service chips — desktop only, aria-hidden --}}
        <div class="absolute top-1/3 right-14 hidden xl:flex flex-col gap-3 pointer-events-none z-10" aria-hidden="true">
            <div class="hero-float-1 glass-card inline-flex items-center gap-2.5 px-4 py-2.5 rounded-full text-white text-xs font-bold tracking-wide shadow-2xl">
                <span class="w-2 h-2 bg-emerald-400 rounded-full shadow-lg shadow-emerald-400/50"></span>
                VAT Advisory
            </div>
            <div class="hero-float-2 glass-card inline-flex items-center gap-2.5 px-4 py-2.5 rounded-full text-white text-xs font-bold tracking-wide shadow-2xl">
                <span class="w-2 h-2 bg-primary rounded-full shadow-lg shadow-primary/50"></span>
                Corporate Tax
            </div>
            <div class="hero-float-3 glass-card inline-flex items-center gap-2.5 px-4 py-2.5 rounded-full text-white text-xs font-bold tracking-wide shadow-2xl">
                <span class="w-2 h-2 bg-amber-400 rounded-full shadow-lg shadow-amber-400/50"></span>
                ZATCA Compliant
            </div>
            <div class="hero-float-4 glass-card inline-flex items-center gap-2.5 px-4 py-2.5 rounded-full text-white text-xs font-bold tracking-wide shadow-2xl">
                <span class="w-2 h-2 bg-violet-400 rounded-full shadow-lg shadow-violet-400/50"></span>
                Payroll Services
            </div>
        </div>

        <div class="home-hero-video__content hero-stagger">
            <p class="text-white/70 text-[0.62rem] sm:text-xs font-bold tracking-[0.34em] uppercase mb-5 flex items-center gap-2.5">
                <span class="w-6 h-px bg-white/45 rounded-full"></span>
                {{ __('common.strategic_excellence') }}
                <span class="w-6 h-px bg-white/45 rounded-full"></span>
            </p>
            <h1 class="home-hero-video__title">
                {{ str_replace(':attribute', __('common.financial_future'), __('common.empowering_financial_future')) }}
            </h1>
            <p class="home-hero-video__subtitle">
                {{ __('common.bespoke_financial_strategies') }}
            </p>
            <div class="flex flex-col sm:flex-row flex-wrap gap-3 sm:gap-4 mt-8 sm:mt-10">
                <a href="{{ route('services') }}"
                    class="btn-shimmer inline-flex min-w-[200px] items-center justify-center gap-2 rounded-sm h-12 px-8 bg-white text-navy-deep text-xs font-bold tracking-[0.18em] uppercase shadow-lg transition hover:bg-white/92 hover:-translate-y-0.5">
                    {{ __('common.explore_our_services') }}
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
                <button type="button" onclick="openContactModal('')"
                    class="btn-shimmer inline-flex min-w-[200px] items-center justify-center rounded-sm h-12 px-8 border-2 border-white/50 text-white text-xs font-bold tracking-[0.18em] uppercase transition hover:bg-white/10 hover:border-white/75">
                    {{ __('common.get_started_now') }}
                </button>
            </div>
            {{-- Scroll indicator --}}
            <div class="hidden sm:flex items-center gap-3 mt-12 sm:mt-14">
                <div class="scroll-indicator flex flex-col items-center gap-1">
                    <div class="w-px h-8 bg-gradient-to-b from-white/50 to-transparent rounded-full"></div>
                    <span class="material-symbols-outlined text-white/40 text-sm">expand_more</span>
                </div>
                <span class="text-white/30 text-[0.6rem] font-black uppercase tracking-[0.38em]">Scroll</span>
            </div>
        </div>
    </section>

    {{-- ── Stats Strip ─────────────────────────────────────────── --}}
    <section class="relative bg-white dark:bg-slate-900/60 border-y border-slate-100 dark:border-white/5 py-10 sm:py-14 overflow-hidden" style="background-image: radial-gradient(circle, rgba(19,127,236,0.055) 1px, transparent 1px); background-size: 22px 22px;">
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
            <div class="absolute left-0 top-0 w-1/2 h-full bg-gradient-to-r from-primary/[0.04] to-transparent"></div>
            <div class="absolute right-0 top-0 w-1/3 h-full bg-gradient-to-l from-indigo-500/[0.04] to-transparent"></div>
        </div>
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 md:px-10 relative">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8 lg:gap-0">
                <div class="flex flex-col gap-2 premium-reveal stat-item">
                    <div class="flex items-baseline gap-0.5">
                        <span class="text-4xl sm:text-5xl font-black text-navy-deep dark:text-white tracking-tight leading-none stat-counter" data-val="300">0</span>
                        <span class="text-2xl sm:text-3xl font-black text-primary leading-none">+</span>
                    </div>
                    <p class="text-[0.65rem] font-black uppercase tracking-[0.24em] text-slate-400 dark:text-slate-500">Clients Served</p>
                    <div class="w-8 h-[2px] bg-gradient-to-r from-primary to-indigo-500 rounded-full"></div>
                </div>
                <div class="flex flex-col gap-2 premium-reveal stat-item" style="transition-delay:80ms">
                    <div class="flex items-baseline gap-0.5">
                        <span class="text-4xl sm:text-5xl font-black text-navy-deep dark:text-white tracking-tight leading-none stat-counter" data-val="98">0</span>
                        <span class="text-2xl sm:text-3xl font-black text-primary leading-none">%</span>
                    </div>
                    <p class="text-[0.65rem] font-black uppercase tracking-[0.24em] text-slate-400 dark:text-slate-500">Client Retention</p>
                    <div class="w-8 h-[2px] bg-gradient-to-r from-primary to-indigo-500 rounded-full"></div>
                </div>
                <div class="flex flex-col gap-2 premium-reveal stat-item" style="transition-delay:160ms">
                    <div class="flex items-baseline gap-0.5">
                        <span class="text-4xl sm:text-5xl font-black text-navy-deep dark:text-white tracking-tight leading-none stat-counter" data-val="4">0</span>
                        <span class="text-lg sm:text-xl font-black text-primary leading-none ml-1">GCC</span>
                    </div>
                    <p class="text-[0.65rem] font-black uppercase tracking-[0.24em] text-slate-400 dark:text-slate-500">Markets Covered</p>
                    <div class="w-8 h-[2px] bg-gradient-to-r from-primary to-indigo-500 rounded-full"></div>
                </div>
                <div class="flex flex-col gap-2 premium-reveal stat-item" style="transition-delay:240ms">
                    <div class="flex items-baseline gap-0.5">
                        <span class="text-4xl sm:text-5xl font-black text-navy-deep dark:text-white tracking-tight leading-none stat-counter" data-val="10">0</span>
                        <span class="text-2xl sm:text-3xl font-black text-primary leading-none">+</span>
                    </div>
                    <p class="text-[0.65rem] font-black uppercase tracking-[0.24em] text-slate-400 dark:text-slate-500">Years of Excellence</p>
                    <div class="w-8 h-[2px] bg-gradient-to-r from-primary to-indigo-500 rounded-full"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── Capabilities Heading ──────────────────────────────────── --}}
    <section class="pt-16 sm:pt-20 md:pt-24 pb-4 sm:pb-6 bg-gradient-to-b from-slate-50/60 to-white dark:from-transparent dark:to-transparent">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 md:px-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 sm:gap-8">
                <div class="max-w-[580px] premium-reveal">
                    <p class="eyebrow mb-5">{{ __('common.capabilities') }}</p>
                    <h2 class="text-navy-deep dark:text-white text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight leading-tight">
                        {{ __('common.expertise_drives_growth') }}
                    </h2>
                </div>
                <p class="text-slate-500 dark:text-slate-400 text-base sm:text-lg max-w-[380px] leading-relaxed premium-reveal" style="transition-delay:120ms">
                    {{ __('common.specialized_solutions') }}
                </p>
            </div>
        </div>
    </section>

    <section class="py-12 sm:py-16 md:py-20 lg:py-24 bg-navy-deep dark:bg-black text-white">

        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 md:px-10">

            <div class="flex flex-col lg:flex-row gap-8 sm:gap-12 md:gap-16 items-center">

                <div class="lg:w-1/2 flex flex-col gap-6 sm:gap-8">

                    <div>

                        <div class="flex items-center gap-3 mb-5">
                            <span class="text-[0.6rem] font-black uppercase tracking-[0.26em] text-white/30 select-none">02</span>
                            <div class="h-px w-10 bg-primary/50 rounded-full"></div>
                            <p class="text-primary font-bold text-[0.68rem] tracking-[0.28em] uppercase">Why 9Associates</p>
                        </div>
                        <h2 class="text-3xl sm:text-4xl md:text-5xl font-black mb-4 sm:mb-6 leading-tight tracking-tight">
                            {{ __('common.why_choose_wal') }}</h2>
                        <p class="text-slate-300 text-base sm:text-lg leading-relaxed max-w-[500px]">
                            {{ __('common.combine_knowledge') }}
                        </p>

                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                        <div class="flex flex-col gap-3.5 p-5 sm:p-6 rounded-xl border border-white/8 bg-white/[0.04] hover:bg-white/[0.08] hover:border-primary/25 transition-all duration-200 group premium-lift premium-reveal">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center bg-gradient-to-br from-primary/25 to-indigo-500/25 group-hover:from-primary/35 group-hover:to-indigo-500/35 transition-colors">
                                <span class="material-symbols-outlined text-primary text-xl" style="font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24">monitoring</span>
                            </div>
                            <h3 class="text-base sm:text-lg font-bold leading-snug">{{ __('common.growth_driven') }}</h3>
                            <p class="text-slate-400 text-sm leading-relaxed">{{ __('common.growth_driven_desc') }}</p>
                        </div>
                        <div class="flex flex-col gap-3.5 p-5 sm:p-6 rounded-xl border border-white/8 bg-white/[0.04] hover:bg-white/[0.08] hover:border-amber-400/20 transition-all duration-200 group premium-lift premium-reveal" style="transition-delay:90ms">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center bg-gradient-to-br from-amber-400/25 to-orange-500/25 group-hover:from-amber-400/35 group-hover:to-orange-500/35 transition-colors">
                                <span class="material-symbols-outlined text-amber-400 text-xl" style="font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24">lightbulb</span>
                            </div>
                            <h3 class="text-base sm:text-lg font-bold leading-snug">{{ __('common.strategic_insights') }}</h3>
                            <p class="text-slate-400 text-sm leading-relaxed">{{ __('common.strategic_insights_desc') }}</p>
                        </div>
                        <div class="flex flex-col gap-3.5 p-5 sm:p-6 rounded-xl border border-white/8 bg-white/[0.04] hover:bg-white/[0.08] hover:border-emerald-400/20 transition-all duration-200 group premium-lift premium-reveal" style="transition-delay:180ms">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center bg-gradient-to-br from-emerald-400/25 to-teal-500/25 group-hover:from-emerald-400/35 group-hover:to-teal-500/35 transition-colors">
                                <span class="material-symbols-outlined text-emerald-400 text-xl" style="font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24">settings_account_box</span>
                            </div>
                            <h3 class="text-base sm:text-lg font-bold leading-snug">{{ __('common.operational_excellence') }}</h3>
                            <p class="text-slate-400 text-sm leading-relaxed">{{ __('common.operational_excellence_desc') }}</p>
                        </div>
                        <div class="flex flex-col gap-3.5 p-5 sm:p-6 rounded-xl border border-white/8 bg-white/[0.04] hover:bg-white/[0.08] hover:border-violet-400/20 transition-all duration-200 group premium-lift premium-reveal" style="transition-delay:270ms">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center bg-gradient-to-br from-violet-400/25 to-purple-500/25 group-hover:from-violet-400/35 group-hover:to-purple-500/35 transition-colors">
                                <span class="material-symbols-outlined text-violet-400 text-xl" style="font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24">security</span>
                            </div>
                            <h3 class="text-base sm:text-lg font-bold leading-snug">{{ __('common.secure_partners') }}</h3>
                            <p class="text-slate-400 text-sm leading-relaxed">{{ __('common.secure_partners_desc') }}</p>
                        </div>
                    </div>

                </div>

                <div class="lg:w-1/2 relative">

                    <div class="home-growth-chart w-full max-w-[520px] rounded-2xl shadow-2xl border border-white/10 bg-white/5 p-6 sm:p-8"
                        aria-label="9Associates growth chart">

                        <div class="flex items-start justify-between gap-4 mb-6">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-widest text-primary mb-1">
                                    {{ __('common.growth_driven') }}</p>
                                <h3 class="text-lg sm:text-xl font-bold text-white">Client Growth &amp; Trust</h3>
                            </div>
                            <span class="material-symbols-outlined text-primary text-3xl">trending_up</span>
                        </div>

                        <div class="home-growth-chart__bars" role="img"
                            aria-label="Bar chart showing steady growth from 2016 to 2025">
                            @php
                                $chartBars = [
                                    ['year' => '2016', 'value' => 22],
                                    ['year' => '2017', 'value' => 30],
                                    ['year' => '2018', 'value' => 38],
                                    ['year' => '2019', 'value' => 46],
                                    ['year' => '2020', 'value' => 52],
                                    ['year' => '2021', 'value' => 62],
                                    ['year' => '2022', 'value' => 71],
                                    ['year' => '2023', 'value' => 80],
                                    ['year' => '2024', 'value' => 90],
                                    ['year' => '2025', 'value' => 100],
                                ];
                            @endphp
                            @foreach($chartBars as $i => $bar)
                                <div class="home-growth-chart__col">
                                    <div class="home-growth-chart__bar" style="--bar-h: {{ $bar['value'] }}%; --bar-delay: {{ $i * 90 }}ms;"></div>
                                    <span class="home-growth-chart__year">{{ substr($bar['year'], 2) }}'</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="grid grid-cols-3 gap-3 mt-6 pt-6 border-t border-white/10">
                            <div>
                                <p class="text-2xl font-black text-white">300+</p>
                                <p class="text-[0.65rem] font-bold uppercase tracking-widest text-slate-400">Clients</p>
                            </div>
                            <div>
                                <p class="text-2xl font-black text-white">98%</p>
                                <p class="text-[0.65rem] font-bold uppercase tracking-widest text-slate-400">Retention</p>
                            </div>
                            <div>
                                <p class="text-2xl font-black text-white">4</p>
                                <p class="text-[0.65rem] font-bold uppercase tracking-widest text-slate-400">GCC Markets</p>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    @if(($services ?? collect())->isNotEmpty())

        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 md:px-10 pt-16 sm:pt-20 pb-6 sm:pb-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <span class="text-[0.6rem] font-black uppercase tracking-[0.26em] text-slate-400 dark:text-slate-500 select-none">03</span>
                        <div class="h-px w-10 bg-primary/40 rounded-full"></div>
                        <p class="text-primary font-bold text-[0.68rem] tracking-[0.28em] uppercase">{{ __('common.services') }}</p>
                    </div>
                    <h2 class="text-navy-deep dark:text-white text-2xl sm:text-3xl md:text-4xl font-extrabold tracking-tight">
                        What We Offer
                    </h2>
                </div>
                <a href="{{ route('services') }}" class="inline-flex items-center gap-2 text-primary text-xs sm:text-sm font-bold uppercase tracking-wider hover:gap-3 transition-all self-start sm:self-auto shrink-0">
                    View All Services
                    <span class="material-symbols-outlined text-base">arrow_forward</span>
                </a>
            </div>
        </div>

        <section class="home-services-showcase" aria-label="{{ __('common.services') }}">
            <button type="button" class="home-services-showcase__arrow home-services-showcase__arrow--prev"
                aria-label="Previous services">
                <span class="material-symbols-outlined">chevron_left</span>
            </button>

            <div class="home-services-showcase__viewport">
                <div class="home-services-showcase__track">
                    @foreach($services as $service)
                        @php
                            $serviceImage = $service->display_image_url ?? stock_img('photo-1554224155-6726b3ff858f');
                        @endphp
                        <a href="{{ route('services.show', $service->id) }}" class="home-services-showcase__panel"
                            style="background-image: url('{{ $serviceImage }}');"
                            aria-label="{{ $service->translated_title }}">
                            <span class="home-services-showcase__overlay" aria-hidden="true"></span>
                            <span class="home-services-showcase__bottom">
                                <span class="home-services-showcase__label">{{ $service->translated_title }}</span>
                                <span class="home-services-showcase__cta">
                                    <span>View Service</span>
                                    <span class="material-symbols-outlined" style="font-size:14px">arrow_forward</span>
                                </span>
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>

            <button type="button" class="home-services-showcase__arrow home-services-showcase__arrow--next"
                aria-label="Next services">
                <span class="material-symbols-outlined">chevron_right</span>
            </button>
        </section>

    @endif



    {{-- ── How We Work ─────────────────────────────────────────────── --}}
    <section class="py-16 sm:py-20 md:py-24 relative overflow-hidden">
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true" style="background: radial-gradient(ellipse 900px 500px at 50% 60%, rgba(19,127,236,0.05), transparent 70%);"></div>
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 md:px-10 relative">
            {{-- Header --}}
            <div class="text-center mb-12 sm:mb-16">
                <div class="inline-flex items-center gap-3 mb-5">
                    <div class="h-px w-8 bg-primary rounded-full"></div>
                    <span class="text-primary font-bold tracking-[0.26em] uppercase text-[0.68rem]">Our Process</span>
                    <div class="h-px w-8 bg-primary rounded-full"></div>
                </div>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-navy-deep dark:text-white tracking-tight leading-tight mb-4">
                    How We <span class="gradient-heading">Work</span>
                </h2>
                <p class="text-slate-500 dark:text-slate-400 text-base sm:text-lg max-w-[500px] mx-auto leading-relaxed">
                    A proven 3-step framework delivering measurable financial outcomes for your business.
                </p>
            </div>
            {{-- Steps grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8 relative">
                {{-- Desktop connector line --}}
                <div class="hidden md:block absolute top-10 left-[calc(33.333%+2rem)] right-[calc(33.333%+2rem)] h-px" style="background: linear-gradient(90deg, rgba(19,127,236,0.3), rgba(79,70,229,0.25), rgba(19,127,236,0.3));" aria-hidden="true"></div>

                {{-- Step 1 --}}
                <div class="process-card process-card-blue premium-reveal group relative flex flex-col gap-4 p-6 sm:p-8 rounded-2xl border border-slate-200/80 dark:border-slate-800/60 bg-white dark:bg-slate-900/60 overflow-hidden">
                    <div class="absolute -top-2 right-4 process-step-num">01</div>
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center bg-gradient-to-br from-primary/12 to-indigo-500/12 group-hover:from-primary/20 group-hover:to-indigo-500/20 transition-colors">
                        <span class="material-symbols-outlined text-primary text-xl" style="font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24">manage_search</span>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-navy-deep dark:text-white leading-snug">Discovery &amp; Assessment</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed flex-1">We start with a deep-dive consultation to understand your financial position, compliance needs, and strategic goals.</p>
                    <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                        <span class="text-[0.62rem] font-black uppercase tracking-[0.22em] text-primary/65">Phase One</span>
                    </div>
                </div>

                {{-- Step 2 --}}
                <div class="process-card process-card-amber premium-reveal group relative flex flex-col gap-4 p-6 sm:p-8 rounded-2xl border border-slate-200/80 dark:border-slate-800/60 bg-white dark:bg-slate-900/60 overflow-hidden" style="transition-delay:120ms">
                    <div class="absolute -top-2 right-4 process-step-num">02</div>
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center bg-gradient-to-br from-amber-400/12 to-orange-500/12 group-hover:from-amber-400/20 group-hover:to-orange-500/20 transition-colors">
                        <span class="material-symbols-outlined text-amber-500 text-xl" style="font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24">route</span>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-navy-deep dark:text-white leading-snug">Strategic Roadmap</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed flex-1">Our specialists craft a tailored plan — tax-optimised, fully compliant, and aligned with your KPIs and regional requirements.</p>
                    <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                        <span class="text-[0.62rem] font-black uppercase tracking-[0.22em] text-amber-500/65">Phase Two</span>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div class="process-card process-card-green premium-reveal group relative flex flex-col gap-4 p-6 sm:p-8 rounded-2xl border border-slate-200/80 dark:border-slate-800/60 bg-white dark:bg-slate-900/60 overflow-hidden" style="transition-delay:240ms">
                    <div class="absolute -top-2 right-4 process-step-num">03</div>
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center bg-gradient-to-br from-emerald-400/12 to-teal-500/12 group-hover:from-emerald-400/20 group-hover:to-teal-500/20 transition-colors">
                        <span class="material-symbols-outlined text-emerald-500 text-xl" style="font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24">rocket_launch</span>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-navy-deep dark:text-white leading-snug">Execution &amp; Support</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed flex-1">We implement, file, and manage on your behalf — with dedicated support, real-time updates, and proactive guidance year-round.</p>
                    <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                        <span class="text-[0.62rem] font-black uppercase tracking-[0.22em] text-emerald-500/65">Phase Three</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ── Testimonials ─────────────────────────────────────────────── --}}
    <section class="py-16 sm:py-20 md:py-24 bg-slate-50/60 dark:bg-slate-900/40 overflow-hidden">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 md:px-10">

            <div class="text-center mb-12 sm:mb-16 premium-reveal">
                <div class="inline-flex items-center gap-3 mb-5">
                    <div class="h-px w-8 bg-primary rounded-full"></div>
                    <span class="text-primary font-bold tracking-[0.26em] uppercase text-[0.68rem]">Client Voices</span>
                    <div class="h-px w-8 bg-primary rounded-full"></div>
                </div>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-navy-deep dark:text-white tracking-tight leading-tight mb-3">
                    Trusted by <span class="gradient-heading">Industry Leaders</span>
                </h2>
                <p class="text-slate-500 dark:text-slate-400 text-base max-w-[440px] mx-auto leading-relaxed">
                    Real outcomes from businesses that chose precision over guesswork.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">

                <div class="testimonial-card premium-reveal flex flex-col gap-5 p-7 sm:p-8 rounded-2xl bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-xl hover:shadow-primary/8 hover:-translate-y-1.5 transition-all duration-300">
                    <div class="flex gap-0.5 text-amber-400" aria-label="5 star rating">
                        @for($s=0;$s<5;$s++)<span class="material-symbols-outlined text-base" style="font-variation-settings:'FILL' 1">star</span>@endfor
                    </div>
                    <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed flex-1">
                        "9Associates transformed our ZATCA compliance process — zero penalties across three consecutive filing cycles. The precision and responsiveness of their team is unmatched."
                    </p>
                    <div class="flex items-center gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary/20 to-indigo-500/20 flex items-center justify-center flex-shrink-0">
                            <span class="text-primary font-black text-sm">MA</span>
                        </div>
                        <div>
                            <p class="font-bold text-navy-deep dark:text-white text-sm">Mohammed A.</p>
                            <p class="text-slate-400 text-xs">CFO, Al Manahil Group — Riyadh</p>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card premium-reveal flex flex-col gap-5 p-7 sm:p-8 rounded-2xl bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-xl hover:shadow-primary/8 hover:-translate-y-1.5 transition-all duration-300" style="transition-delay:110ms">
                    <div class="flex gap-0.5 text-amber-400" aria-label="5 star rating">
                        @for($s=0;$s<5;$s++)<span class="material-symbols-outlined text-base" style="font-variation-settings:'FILL' 1">star</span>@endfor
                    </div>
                    <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed flex-1">
                        "From corporate tax registration to audit support, their depth of regional knowledge is remarkable. They understood our cross-border GCC structure from day one."
                    </p>
                    <div class="flex items-center gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-400/20 to-teal-500/20 flex items-center justify-center flex-shrink-0">
                            <span class="text-emerald-600 dark:text-emerald-400 font-black text-sm">FS</span>
                        </div>
                        <div>
                            <p class="font-bold text-navy-deep dark:text-white text-sm">Fatima S.</p>
                            <p class="text-slate-400 text-xs">Finance Director, Emirates Ventures</p>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card premium-reveal flex flex-col gap-5 p-7 sm:p-8 rounded-2xl bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-xl hover:shadow-primary/8 hover:-translate-y-1.5 transition-all duration-300" style="transition-delay:220ms">
                    <div class="flex gap-0.5 text-amber-400" aria-label="5 star rating">
                        @for($s=0;$s<5;$s++)<span class="material-symbols-outlined text-base" style="font-variation-settings:'FILL' 1">star</span>@endfor
                    </div>
                    <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed flex-1">
                        "Their payroll outsourcing service saved our team 40+ hours every month. We now focus entirely on growth, not compliance paperwork. Highly recommended for any GCC business."
                    </p>
                    <div class="flex items-center gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-400/20 to-orange-500/20 flex items-center justify-center flex-shrink-0">
                            <span class="text-amber-600 dark:text-amber-400 font-black text-sm">AK</span>
                        </div>
                        <div>
                            <p class="font-bold text-navy-deep dark:text-white text-sm">Ahmed K.</p>
                            <p class="text-slate-400 text-xs">Operations Director, Gulf Dynamics</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ── Trust Bar ─────────────────────────────────────────────────── --}}
    <div class="py-10 sm:py-12 border-y border-slate-200/80 dark:border-slate-800/60 bg-white dark:bg-slate-900/30 overflow-hidden">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 md:px-10">
            <p class="text-center text-[0.62rem] font-black uppercase tracking-[0.32em] text-slate-400 dark:text-slate-600 mb-6">Certified &amp; Compliant Across</p>
            <div class="flex flex-wrap items-center justify-center gap-3 sm:gap-4">
                @foreach(['ZATCA VAT Filing', 'Corporate Tax KSA', 'Payroll Outsourcing', 'Business Setup GCC', 'Audit & Assurance', 'Financial Consulting'] as $trust)
                <span class="trust-pill">
                    <span class="material-symbols-outlined text-primary text-sm" style="font-variation-settings:'FILL' 1">verified</span>
                    {{ $trust }}
                </span>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ── CTA Section ────────────────────────────────────────────── --}}
    <section class="pt-16 sm:pt-20 md:pt-24 pb-12 sm:pb-16 md:pb-20">
        <div class="max-w-[1080px] mx-auto px-4 sm:px-6 md:px-10">
            <div class="relative rounded-2xl sm:rounded-3xl overflow-hidden" style="background: linear-gradient(135deg, #137fec 0%, #0e6fd4 40%, #3730a3 100%);">
                {{-- Grid dot pattern --}}
                <div class="absolute inset-0 pointer-events-none" aria-hidden="true" style="background-image: radial-gradient(circle, rgba(255,255,255,0.07) 1px, transparent 1px); background-size: 28px 28px;"></div>
                {{-- Glow orbs --}}
                <div class="absolute -top-24 -right-24 w-80 h-80 bg-white/10 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>
                <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-black/15 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>
                {{-- Decorative arc --}}
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-white/10 via-white/30 to-white/10" aria-hidden="true"></div>
                {{-- Content --}}
                <div class="relative z-10 p-8 sm:p-10 md:p-16 text-center text-white flex flex-col items-center gap-5 sm:gap-6">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/15 border border-white/20 text-[0.66rem] font-bold uppercase tracking-[0.22em] text-white/90 mb-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 flex-shrink-0 pulse-dot"></span>
                        Available for New Engagements
                    </div>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black leading-tight max-w-[680px]">
                        {{ __('common.ready_transform') }}
                    </h2>
                    <p class="text-sm sm:text-base md:text-lg text-white/82 max-w-[540px] leading-relaxed">
                        {{ __('common.join_enterprises') }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3 mt-2 w-full sm:w-auto">
                        <button type="button" onclick="openContactModal('')"
                            class="inline-flex items-center justify-center gap-2 rounded-xl h-12 sm:h-14 px-8 sm:px-10 bg-white text-primary text-sm sm:text-base font-black tracking-wide transition-all hover:scale-105 hover:shadow-2xl shadow-lg cursor-pointer">
                            {{ __('common.get_started_now') }}
                            <span class="material-symbols-outlined text-lg">arrow_forward</span>
                        </button>
                        <a href="{{ route('services') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl h-12 sm:h-14 px-8 sm:px-10 bg-transparent border-2 border-white/35 text-white text-sm sm:text-base font-bold tracking-wide transition-all hover:bg-white/12 hover:border-white/55">
                            {{ __('common.explore_our_services') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('styles')

    <style>
        .home-services-showcase {
            position: relative;
            display: flex;
            align-items: stretch;
            width: 100vw;
            max-width: 100vw;
            margin-left: calc(50% - 50vw);
            margin-right: calc(50% - 50vw);
            min-height: clamp(320px, 42vw, 520px);
            background: #0d141b;
        }

        .home-services-showcase__viewport {
            flex: 1;
            overflow: hidden;
        }

        .home-services-showcase__track {
            display: flex;
            height: 100%;
            min-height: clamp(320px, 42vw, 520px);
            transition: transform 0.45s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform;
        }

        .home-services-showcase__panel {
            position: relative;
            flex: 0 0 auto;
            min-height: clamp(320px, 42vw, 520px);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            align-items: flex-end;
            text-decoration: none;
            overflow: hidden;
            transition: transform 0.4s ease;
        }

        .home-services-showcase__panel:hover {
            transform: scaleX(1.015);
        }

        @media (min-width: 640px) {
            .home-services-showcase__panel {
                flex-basis: 50%;
            }
        }

        @media (min-width: 1024px) {
            .home-services-showcase__panel {
                flex-basis: 25%;
            }
        }

        .home-services-showcase__overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0,0,0,0.08) 0%, rgba(0,0,0,0.55) 65%, rgba(0,0,0,0.75) 100%);
            transition: background 0.35s ease;
        }

        .home-services-showcase__panel:hover .home-services-showcase__overlay {
            background: linear-gradient(180deg, rgba(19,127,236,0.15) 0%, rgba(0,0,0,0.45) 50%, rgba(0,0,0,0.82) 100%);
        }

        .home-services-showcase__bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1;
            padding: 1.5rem 1.25rem 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            border-top: 2px solid transparent;
            transition: border-color 0.3s ease;
        }

        .home-services-showcase__panel:hover .home-services-showcase__bottom {
            border-top-color: #137fec;
        }

        .home-services-showcase__label {
            color: #fff;
            font-size: clamp(0.9rem, 1.6vw, 1.15rem);
            font-weight: 700;
            letter-spacing: 0.06em;
            text-align: left;
            text-shadow: 0 1px 12px rgba(0, 0, 0, 0.5);
            line-height: 1.3;
        }

        .home-services-showcase__cta {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            color: #137fec;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            opacity: 0;
            transform: translateY(6px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .home-services-showcase__panel:hover .home-services-showcase__cta {
            opacity: 1;
            transform: translateY(0);
        }

        .home-services-showcase__arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2.75rem;
            height: 2.75rem;
            border: none;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.92);
            color: #0d141b;
            cursor: pointer;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.18);
            transition: background 0.2s ease, transform 0.2s ease, opacity 0.2s ease;
        }

        .home-services-showcase__arrow:hover {
            background: #fff;
            transform: translateY(-50%) scale(1.05);
        }

        .home-services-showcase__arrow:disabled {
            opacity: 0.35;
            cursor: not-allowed;
            transform: translateY(-50%);
        }

        .home-services-showcase__arrow--prev {
            left: 0.75rem;
        }

        .home-services-showcase__arrow--next {
            right: 0.75rem;
        }

        @media (min-width: 768px) {
            .home-services-showcase__arrow {
                width: 3.25rem;
                height: 3.25rem;
            }

            .home-services-showcase__arrow--prev {
                left: 1.25rem;
            }

            .home-services-showcase__arrow--next {
                right: 1.25rem;
            }
        }

        .hero-slideshow {

            position: relative;

            width: 100%;

            height: 100%;

        }



        .hero-slide {

            position: absolute;

            top: 0;

            left: 0;

            width: 100%;

            height: 100%;

            background-size: cover;

            background-position: center;

            opacity: 0;

            transition: opacity 1.5s ease-in-out;

        }



        .hero-slide.active {

            opacity: 1;

        }



        .hero-indicator {

            width: 12px;

            height: 12px;

            border-radius: 50%;

            border: 2px solid rgba(255, 255, 255, 0.5);

            background-color: transparent;

            cursor: pointer;

            transition: all 0.3s ease;

            padding: 0;

        }



        .hero-indicator:hover {

            border-color: rgba(255, 255, 255, 0.8);

            background-color: rgba(255, 255, 255, 0.3);

        }



        .hero-indicator.active {

            background-color: #137fec;

            border-color: #137fec;

            width: 32px;

            border-radius: 6px;

        }
    </style>

@endpush

@push('scripts')

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            (function initHomeServicesShowcase() {
                const showcase = document.querySelector('.home-services-showcase');
                if (!showcase) return;

                const track = showcase.querySelector('.home-services-showcase__track');
                const panels = showcase.querySelectorAll('.home-services-showcase__panel');
                const prevBtn = showcase.querySelector('.home-services-showcase__arrow--prev');
                const nextBtn = showcase.querySelector('.home-services-showcase__arrow--next');
                const viewport = showcase.querySelector('.home-services-showcase__viewport');
                if (!track || !panels.length || !prevBtn || !nextBtn || !viewport) return;

                let index = 0;

                function visibleCount() {
                    if (window.innerWidth >= 1024) return 4;
                    if (window.innerWidth >= 640) return 2;
                    return 1;
                }

                function maxIndex() {
                    return Math.max(0, panels.length - visibleCount());
                }

                function syncPanelWidths() {
                    const panelWidth = viewport.clientWidth / visibleCount();
                    panels.forEach(function (panel) {
                        panel.style.width = panelWidth + 'px';
                    });
                }

                function update() {
                    syncPanelWidths();
                    const panelWidth = panels[0].getBoundingClientRect().width;
                    track.style.transform = 'translateX(-' + (index * panelWidth) + 'px)';
                    prevBtn.disabled = index <= 0;
                    nextBtn.disabled = index >= maxIndex();
                }

                prevBtn.addEventListener('click', function () {
                    if (index > 0) {
                        index -= 1;
                        update();
                    }
                });

                nextBtn.addEventListener('click', function () {
                    if (index < maxIndex()) {
                        index += 1;
                        update();
                    }
                });

                window.addEventListener('resize', function () {
                    if (index > maxIndex()) index = maxIndex();
                    update();
                });

                update();
            })();

            const slides = document.querySelectorAll('.hero-slide');

            const indicators = document.querySelectorAll('.hero-indicator');

            let currentSlide = 0;

            const totalSlides = slides.length;



            function showSlide(index) {

                slides.forEach(slide => slide.classList.remove('active'));

                indicators.forEach(indicator => indicator.classList.remove('active'));

                slides[index].classList.add('active');

                indicators[index].classList.add('active');

                currentSlide = index;

            }



            function nextSlide() {

                const next = (currentSlide + 1) % totalSlides;

                showSlide(next);

            }



            setInterval(nextSlide, 5000);



            indicators.forEach((indicator, index) => {

                indicator.addEventListener('click', () => {

                    showSlide(index);

                });

            });



            showSlide(0);

        });

    </script>

    <script>
        // Animated stat counters — eased count-up on scroll into view
        (function () {
            function animateCounter(el) {
                var target = parseInt(el.dataset.val || '0', 10);
                var duration = 1500;
                var start = performance.now();
                function update(now) {
                    var elapsed = now - start;
                    var progress = Math.min(elapsed / duration, 1);
                    var ease = 1 - Math.pow(1 - progress, 3);
                    el.textContent = Math.floor(ease * target);
                    if (progress < 1) {
                        requestAnimationFrame(update);
                    } else {
                        el.textContent = target;
                    }
                }
                requestAnimationFrame(update);
            }
            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        animateCounter(entry.target);
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.35 });
            document.querySelectorAll('.stat-counter').forEach(function (el) {
                observer.observe(el);
            });
        })();
    </script>

@endpush