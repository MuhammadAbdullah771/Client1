@extends('layouts.app')

{{-- SEO sections --}}
@section('title', __('common.about_us') . ' | 9Associates')

@section('meta_description', 'Learn about 9Associates, our story, mission, vision and leadership team providing strategic financial, accounting, tax and consulting services across the GCC.')

@section('meta_keywords', '9Associates about, 9Associates company, mission, vision, leadership, financial advisory, accounting, tax, consulting, GCC')

@section('content')
@php
    $section = request()->get('section', 'about');
@endphp

<section class="max-w-[1280px] mx-auto px-4 sm:px-6 md:px-10 py-12 sm:py-16 md:py-24">

    <div>
            @if($section === 'about')
            <!-- About Us Content -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-16">
                <div class="order-2 md:order-1">
                    <!-- Finance Slideshow -->
                    <div class="w-full aspect-video md:aspect-square rounded-xl overflow-hidden shadow-2xl relative finance-slideshow">
                        <!-- Slide 1: Professional accountant with financial charts -->
                        <div class="finance-slide active" style="background-image: url('{{ stock_img('photo-1554224155-6726b3ff858f') }}');"></div>
                        <!-- Slide 2: Financial planning and analysis -->
                        <div class="finance-slide" style="background-image: url('{{ stock_img('photo-1551288049-bebda4e38f71') }}');"></div>
                        <!-- Slide 3: Business growth and strategy -->
                        <div class="finance-slide" style="background-image: url('{{ stock_img('photo-1554224155-8d04cb21cd6c') }}');"></div>
                        <!-- Slide 4: Chartered accountant team meeting -->
                        <div class="finance-slide" style="background-image: url('{{ stock_img('photo-1521737604893-d14cc237f11d') }}');"></div>
                        <!-- Slide 5: Financial success and goals -->
                        <div class="finance-slide" style="background-image: url('{{ stock_img('photo-1552664730-d307ca884978') }}');"></div>
                        <!-- Slide Indicators -->
                        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 z-10 flex gap-2 items-center">
                            <button class="finance-indicator active" data-slide="0" aria-label="Slide 1" type="button"></button>
                            <button class="finance-indicator" data-slide="1" aria-label="Slide 2" type="button"></button>
                            <button class="finance-indicator" data-slide="2" aria-label="Slide 3" type="button"></button>
                            <button class="finance-indicator" data-slide="3" aria-label="Slide 4" type="button"></button>
                            <button class="finance-indicator" data-slide="4" aria-label="Slide 5" type="button"></button>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-5 order-1 md:order-2">
                    <div class="inline-flex items-center gap-3">
                        <span class="w-8 h-[2px] bg-primary rounded-full"></span>
                        <span class="text-primary font-bold tracking-[0.26em] uppercase text-[0.68rem]">{{ __('common.our_story') }}</span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-black leading-tight tracking-tight text-navy-deep dark:text-white">
                        {{ __('common.empowering_businesses') }}
                    </h2>
                    <p class="text-base sm:text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
                        {{ __('common.founded_principles') }}
                    </p>
                    <div class="flex flex-wrap gap-3 mt-2">
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/8 dark:bg-primary/12 border border-primary/15 text-primary text-xs font-bold tracking-wider uppercase">
                            <span class="material-symbols-outlined text-sm" style="font-variation-settings:'FILL' 1">verified</span>
                            ZATCA Compliant
                        </div>
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 text-xs font-bold tracking-wider uppercase">
                            <span class="material-symbols-outlined text-sm" style="font-variation-settings:'FILL' 1">public</span>
                            GCC-Wide
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Strip -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-16 premium-reveal">
                @php
                $stats = [
                    ['value' => '10+',  'label' => 'Years of Excellence',    'icon' => 'workspace_premium'],
                    ['value' => '300+', 'label' => 'Clients Served',          'icon' => 'groups'],
                    ['value' => '98%',  'label' => 'Client Satisfaction',     'icon' => 'thumb_up'],
                    ['value' => '4',    'label' => 'GCC Countries',            'icon' => 'public'],
                ];
                @endphp
                @foreach($stats as $stat)
                <div class="flex flex-col items-center text-center p-6 sm:p-8 rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-sm hover:shadow-lg hover:border-primary/25 transition-all duration-300 group">
                    <span class="material-symbols-outlined text-primary text-2xl mb-3 group-hover:scale-110 transition-transform duration-300" style="font-variation-settings:'FILL' 1">{{ $stat['icon'] }}</span>
                    <span class="stat-count text-3xl sm:text-4xl font-black text-navy-deep dark:text-white tabular-nums" data-target="{{ $stat['value'] }}">{{ $stat['value'] }}</span>
                    <span class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400 mt-2">{{ $stat['label'] }}</span>
                </div>
                @endforeach
            </div>

            <!-- Milestones Section -->
            <section class="relative py-16 sm:py-20 rounded-2xl mb-16 overflow-hidden" style="background: linear-gradient(160deg, #f8fafc 0%, #f1f5f9 100%);">
                <div class="dark:hidden absolute inset-0 rounded-2xl" style="background: linear-gradient(160deg, #f8fafc 0%, #f1f5f9 100%);"></div>
                <div class="hidden dark:block absolute inset-0 rounded-2xl bg-slate-900/80"></div>
                <div class="absolute top-0 left-0 right-0 h-1 rounded-t-2xl bg-gradient-to-r from-transparent via-primary/40 to-transparent" aria-hidden="true"></div>
                <div class="relative px-4 sm:px-6">
                    <div class="text-center mb-12 sm:mb-16">
                        <div class="inline-flex items-center gap-3 mb-5">
                            <div class="h-px w-8 bg-primary rounded-full"></div>
                            <span class="text-primary font-bold tracking-[0.26em] uppercase text-[0.68rem]">Our Journey</span>
                            <div class="h-px w-8 bg-primary rounded-full"></div>
                        </div>
                        <h2 class="text-3xl sm:text-4xl font-bold mb-3 tracking-tight text-navy-deep dark:text-white">{{ __('common.journey_milestones') }}</h2>
                        <p class="text-slate-500 dark:text-slate-400 max-w-2xl mx-auto text-base leading-relaxed">{{ __('common.tracking_growth') }}</p>
                    </div>
                    <div class="relative flex flex-col items-center">
                        <div class="absolute left-1/2 -translate-x-1/2 h-full w-px bg-gradient-to-b from-primary/40 via-primary/20 to-primary/5"></div>
                        @foreach($milestones as $milestone)
                        <div class="relative w-full mb-10 sm:mb-12 flex flex-col md:flex-row items-center justify-between group premium-reveal">
                            @if($milestone->position == 'left')
                            <div class="md:w-[45%] text-right pr-0 md:pr-12 hidden md:block">
                                <span class="text-5xl font-black text-primary/20 group-hover:text-primary/40 transition-colors duration-300 tabular-nums">{{ $milestone->year }}</span>
                            </div>
                            @endif
                            <div class="z-10 flex items-center justify-center w-5 h-5 rounded-full bg-primary shadow-lg shadow-primary/40 border-[3px] border-white dark:border-slate-900 group-hover:scale-125 transition-transform duration-300">
                                <div class="w-1.5 h-1.5 rounded-full bg-white"></div>
                            </div>
                            <div class="w-full md:w-[45%] {{ $milestone->position == 'left' ? 'pl-0 md:pl-12' : 'pr-0 md:pr-12' }} mt-4 md:mt-0 {{ $milestone->position == 'right' ? 'text-left md:text-right' : '' }}">
                                <div class="bg-white dark:bg-slate-900/80 p-5 sm:p-6 rounded-xl border border-slate-200/80 dark:border-slate-700/60 shadow-sm group-hover:shadow-md group-hover:border-primary/25 transition-all duration-300">
                                    <span class="md:hidden text-xl font-black text-primary block mb-2 tabular-nums">{{ $milestone->year }}</span>
                                    <h4 class="text-base sm:text-lg font-bold mb-1.5 text-navy-deep dark:text-white">{{ $milestone->title }}</h4>
                                    <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">{{ $milestone->description }}</p>
                                </div>
                            </div>
                            @if($milestone->position == 'right')
                            <div class="md:w-[45%] text-left pl-0 md:pl-12 hidden md:block">
                                <span class="text-5xl font-black text-primary/20 group-hover:text-primary/40 transition-colors duration-300 tabular-nums">{{ $milestone->year }}</span>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <!-- Leadership Section -->
            <section class="mb-16">
                <div class="flex flex-col md:flex-row justify-between items-end mb-10 sm:mb-12 gap-4">
                    <div class="max-w-xl">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="h-px w-8 bg-primary rounded-full"></div>
                            <p class="text-primary font-bold text-[0.68rem] tracking-[0.28em] uppercase">Leadership</p>
                        </div>
                        <h2 class="text-3xl sm:text-4xl font-bold tracking-tight mb-3">{{ __('common.our_leadership') }}</h2>
                        <p class="text-slate-500 dark:text-slate-400 text-base leading-relaxed">{{ __('common.experienced_minds') }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    @foreach($leaders as $leader)
                    <div class="group relative flex flex-col bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 hover:border-primary/40 hover:shadow-xl hover:shadow-primary/8 transition-all duration-300 overflow-hidden">
                        {{-- Image area --}}
                        @if($leader->image_url)
                        <div class="relative w-full aspect-[4/3] overflow-hidden bg-slate-100 dark:bg-slate-800">
                            <img src="{{ $leader->image_url }}" alt="{{ $leader->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="w-full h-full flex items-center justify-center bg-slate-100 dark:bg-slate-800" style="display: none;"><span class="material-symbols-outlined text-6xl text-slate-300 dark:text-slate-600">person</span></div>
                            {{-- Hover overlay with socials --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-navy-deep/85 via-navy-deep/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-5">
                                <div class="flex gap-2.5">
                                    @if($leader->linkedin)
                                    <a class="w-9 h-9 rounded-lg bg-white/15 hover:bg-primary border border-white/20 flex items-center justify-center text-white transition-all" href="{{ $leader->linkedin }}" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                    </a>
                                    @endif
                                    @if($leader->email)
                                    <a class="w-9 h-9 rounded-lg bg-white/15 hover:bg-primary border border-white/20 flex items-center justify-center text-white transition-all" href="mailto:{{ $leader->email }}" aria-label="Email">
                                        <span class="material-symbols-outlined text-sm">alternate_email</span>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="relative w-full aspect-[4/3] overflow-hidden bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-700 flex items-center justify-center">
                            <span class="material-symbols-outlined text-7xl text-slate-300 dark:text-slate-600">person</span>
                        </div>
                        @endif
                        {{-- Card body --}}
                        <div class="flex flex-col gap-2 p-5 sm:p-6 flex-1">
                            <div>
                                <h3 class="text-lg sm:text-xl font-bold text-navy-deep dark:text-white tracking-tight">{{ $leader->name }}</h3>
                                <p class="text-primary text-xs font-bold mt-0.5 tracking-[0.14em] uppercase">{{ $leader->role }}</p>
                                @if($leader->department)
                                <p class="text-slate-400 dark:text-slate-500 text-xs font-medium mt-0.5">{{ $leader->department }}</p>
                                @endif
                            </div>
                            <div class="h-px w-full bg-slate-100 dark:bg-slate-800 my-1"></div>
                            <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed flex-1 line-clamp-3">
                                {{ $leader->bio }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>

            @elseif($section === 'mission')
            <!-- Mission and Vision Content -->
            <div class="space-y-12">
                <div>
                    <h2 class="text-4xl md:text-5xl font-black leading-tight tracking-tight mb-6">{{ __('common.mission_vision') }}</h2>
                    <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed mb-8">
                        {{ __('common.mission_vision_guide') ?? 'Our mission and vision guide everything we do at 9ASSOCIATES, shaping our strategies and defining our commitment to excellence.' }}
                    </p>
                </div>

                <!-- Mission + Vision side by side -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                    <div class="group relative flex flex-col gap-5 p-8 rounded-2xl border border-primary/20 bg-gradient-to-br from-primary/4 to-transparent dark:from-primary/8 dark:to-transparent overflow-hidden hover:shadow-xl hover:shadow-primary/10 transition-all duration-300">
                        <div class="absolute top-0 right-0 w-40 h-40 bg-primary/5 rounded-full -translate-y-1/2 translate-x-1/2 blur-2xl pointer-events-none"></div>
                        <div class="w-11 h-11 rounded-xl bg-primary/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-xl" style="font-variation-settings:'FILL' 1">target</span>
                        </div>
                        <h3 class="text-xl font-bold text-navy-deep dark:text-white">{{ __('common.our_mission') ?? 'Our Mission' }}</h3>
                        <p class="text-slate-600 dark:text-slate-400 text-base leading-relaxed">
                            {{ __('common.mission_text') ?? 'To deliver exceptional financial consulting services that empower businesses to make informed decisions, optimize their operations, and achieve sustainable growth.' }}
                        </p>
                    </div>
                    <div class="group relative flex flex-col gap-5 p-8 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 overflow-hidden hover:border-indigo-400/30 hover:shadow-xl transition-all duration-300">
                        <div class="absolute top-0 right-0 w-40 h-40 bg-indigo-500/5 rounded-full -translate-y-1/2 translate-x-1/2 blur-2xl pointer-events-none"></div>
                        <div class="w-11 h-11 rounded-xl bg-indigo-500/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-indigo-500 text-xl" style="font-variation-settings:'FILL' 1">lightbulb</span>
                        </div>
                        <h3 class="text-xl font-bold text-navy-deep dark:text-white">{{ __('common.our_vision') ?? 'Our Vision' }}</h3>
                        <p class="text-slate-600 dark:text-slate-400 text-base leading-relaxed italic">
                            "{{ __('common.vision_text') ?? 'To be the global benchmark for strategic consulting, fostering growth and innovation for our clients across the globe.' }}"
                        </p>
                    </div>
                </div>

                <!-- Core Values -->
                <div class="mt-10">
                    <div class="flex items-center gap-3 mb-7">
                        <div class="h-px w-8 bg-primary rounded-full"></div>
                        <span class="text-primary font-bold tracking-[0.26em] uppercase text-[0.68rem]">Core Values</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        @php $values = [
                            ['icon' => 'shield_person', 'color' => 'text-primary bg-primary/8', 'title' => __('common.integrity') ?? 'Integrity', 'desc' => __('common.integrity_desc') ?? 'We maintain the highest ethical standards in all our interactions and recommendations.'],
                            ['icon' => 'workspace_premium', 'color' => 'text-amber-600 bg-amber-500/10', 'title' => __('common.excellence') ?? 'Excellence', 'desc' => __('common.excellence_desc') ?? 'We strive for excellence in every project, delivering quality that exceeds expectations.'],
                            ['icon' => 'tips_and_updates', 'color' => 'text-emerald-600 bg-emerald-500/10', 'title' => __('common.innovation') ?? 'Innovation', 'desc' => __('common.innovation_desc') ?? 'We embrace innovative approaches and cutting-edge technologies to drive client success.'],
                        ]; @endphp
                        @foreach($values as $val)
                        <div class="flex flex-col gap-3 p-6 rounded-xl border border-slate-100 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-900/40 hover:border-slate-200 hover:bg-white dark:hover:bg-slate-900 transition-all duration-200">
                            <span class="material-symbols-outlined text-2xl w-10 h-10 rounded-lg {{ $val['color'] }} flex items-center justify-center" style="font-variation-settings:'FILL' 1">{{ $val['icon'] }}</span>
                            <h4 class="font-bold text-base text-navy-deep dark:text-white">{{ $val['title'] }}</h4>
                            <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">{{ $val['desc'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            @elseif($section === 'why-choose')
            <!-- Why Choose Us Content -->
            <div class="space-y-12">
                <div>
                    <h2 class="text-4xl md:text-5xl font-black leading-tight tracking-tight mb-6">{{ __('common.why_choose_us') }} <span class="text-primary">{{ __('common.wal_consultant') }}</span></h2>
                    <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed mb-8">
                        {{ __('common.combine_knowledge') }}
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">
                    @php
                    $whyCards = [
                        ['icon' => 'monitoring',         'color' => 'from-blue-500/15 to-primary/8',    'border' => 'hover:border-primary/40',   'key_h' => 'growth_driven',            'key_p' => 'growth_driven_desc'],
                        ['icon' => 'lightbulb',          'color' => 'from-amber-500/15 to-orange-400/8','border' => 'hover:border-amber-400/40', 'key_h' => 'strategic_insights',       'key_p' => 'strategic_insights_desc'],
                        ['icon' => 'settings_account_box','color' => 'from-emerald-500/15 to-teal-400/8','border' => 'hover:border-emerald-400/40','key_h' => 'operational_excellence',  'key_p' => 'operational_excellence_desc'],
                        ['icon' => 'security',           'color' => 'from-violet-500/15 to-purple-400/8','border' => 'hover:border-violet-400/40', 'key_h' => 'secure_partners',         'key_p' => 'secure_partners_desc'],
                    ];
                    @endphp
                    @foreach($whyCards as $i => $card)
                    <div class="group flex flex-col gap-4 p-7 rounded-2xl border border-slate-200 dark:border-slate-800 {{ $card['border'] }} bg-white dark:bg-slate-900 shadow-sm hover:shadow-xl hover:shadow-primary/8 transition-all duration-300 premium-reveal" style="transition-delay: {{ $i * 80 }}ms">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br {{ $card['color'] }} flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <span class="material-symbols-outlined text-primary text-2xl" style="font-variation-settings:'FILL' 1">{{ $card['icon'] }}</span>
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold text-navy-deep dark:text-white tracking-tight">{{ __('common.' . $card['key_h']) }}</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">{{ __('common.' . $card['key_p']) }}</p>
                        <div class="h-0.5 w-8 rounded-full bg-gradient-to-r from-primary to-primary/0 group-hover:w-16 transition-all duration-500"></div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
    </div>
</section>

<section class="max-w-[1080px] mx-auto px-4 sm:px-6 pb-16 sm:pb-20">
    <div class="relative rounded-2xl sm:rounded-3xl overflow-hidden" style="background: linear-gradient(135deg, #137fec 0%, #0e6fd4 40%, #3730a3 100%);">
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true" style="background-image: radial-gradient(circle, rgba(255,255,255,0.07) 1px, transparent 1px); background-size: 28px 28px;"></div>
        <div class="absolute -top-24 -right-24 w-80 h-80 bg-white/10 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>
        <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-black/15 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>
        <div class="relative z-10 p-8 sm:p-10 md:p-16 text-center text-white flex flex-col items-center gap-5 sm:gap-6">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-black leading-tight max-w-[600px]">{{ __('common.ready_scale') }}</h2>
            <p class="text-sm sm:text-base md:text-lg max-w-xl text-white/85 leading-relaxed">
                {{ __('common.join_hundreds') }}
            </p>
            <div class="flex flex-col sm:flex-row gap-3 mt-2">
                <button type="button" onclick="openContactModal('')"
                    class="inline-flex items-center justify-center gap-2 rounded-xl h-12 sm:h-14 px-8 sm:px-10 bg-white text-primary text-sm sm:text-base font-black tracking-wide transition-all hover:scale-105 hover:shadow-2xl shadow-lg cursor-pointer">
                    {{ __('common.schedule_consultation') }}
                    <span class="material-symbols-outlined text-lg">arrow_forward</span>
                </button>
                <a href="{{ route('services') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl h-12 sm:h-14 px-8 sm:px-10 bg-transparent border-2 border-white/35 text-white text-sm sm:text-base font-bold tracking-wide transition-all hover:bg-white/12 hover:border-white/55">
                    {{ __('common.view_services') }}
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    .finance-slideshow {
        position: relative;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    
    .finance-slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        opacity: 0;
        transition: opacity 1.5s ease-in-out;
        z-index: 1;
    }
    
    .finance-slide.active {
        opacity: 1;
        z-index: 2;
    }
    
    .finance-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid rgba(255, 255, 255, 0.6);
        background-color: rgba(255, 255, 255, 0.3);
        cursor: pointer;
        transition: all 0.3s ease;
        padding: 0;
        outline: none;
        flex-shrink: 0;
    }
    
    .finance-indicator:hover {
        border-color: rgba(255, 255, 255, 0.9);
        background-color: rgba(255, 255, 255, 0.5);
        transform: scale(1.1);
    }
    
    .finance-indicator.active {
        background-color: #137fec;
        border-color: #137fec;
        width: 32px;
        border-radius: 6px;
    }
</style>
@endpush

@push('scripts')
<script>
    (function() {
        'use strict';
        
        function initFinanceSlideshow() {
            const slides = document.querySelectorAll('.finance-slide');
            const indicators = document.querySelectorAll('.finance-indicator');
            
            if (slides.length === 0 || indicators.length === 0) {
                return;
            }
            
            let currentSlide = 0;
            const totalSlides = slides.length;
            let slideInterval = null;
            
            function showSlide(index) {
                if (index < 0 || index >= totalSlides) {
                    return;
                }
                
                slides.forEach(slide => slide.classList.remove('active'));
                indicators.forEach(indicator => indicator.classList.remove('active'));
                
                if (slides[index] && indicators[index]) {
                    slides[index].classList.add('active');
                    indicators[index].classList.add('active');
                    currentSlide = index;
                }
            }
            
            function nextSlide() {
                const next = (currentSlide + 1) % totalSlides;
                showSlide(next);
            }
            
            function startAutoSlide() {
                if (slideInterval) {
                    clearInterval(slideInterval);
                }
                slideInterval = setInterval(nextSlide, 5000);
            }
            
            function stopAutoSlide() {
                if (slideInterval) {
                    clearInterval(slideInterval);
                    slideInterval = null;
                }
            }
            
            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', function() {
                    stopAutoSlide();
                    showSlide(index);
                    startAutoSlide();
                });
            });
            
            showSlide(0);
            startAutoSlide();
        }
        
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initFinanceSlideshow);
        } else {
            initFinanceSlideshow();
        }
    })();
</script>
@endpush