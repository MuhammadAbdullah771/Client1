@extends('layouts.app')

{{-- SEO sections --}}
@section('title', ($service->translated_title ?? $service->title) . ' | 9Associates')

@section('meta_description', $service->meta_description
    ?? \Illuminate\Support\Str::limit(strip_tags(
        $service->intro_text
        ?? $service->content_paragraph_1
        ?? $service->description
        ?? $service->section_content_1
        ?? ''
    ), 160))

@section('meta_keywords', ($service->translated_title ?? $service->title) . ', 9Associates services, accounting, tax, audit, consulting, GCC, UAE, KSA')

@section('content')
@php
    $heroImage = $service->display_image_url ?? stock_img('photo-1451187580459-43490279c0fa');
@endphp

<!-- Hero Section -->
<section class="relative w-full overflow-hidden bg-navy-deep" style="min-height: clamp(280px, 40vw, 480px);">
    <div class="absolute inset-0 z-0 bg-cover bg-center" style="background-image: url('{{ $heroImage }}'); opacity: 0.35;"></div>
    <div class="absolute inset-0 z-0" style="background: linear-gradient(180deg, rgba(13,20,27,0.3) 0%, rgba(13,20,27,0.65) 60%, rgba(13,20,27,0.92) 100%);"></div>
    <div class="absolute top-0 left-0 right-0 h-px" style="background: linear-gradient(90deg, transparent, rgba(19,127,236,0.5), transparent);" aria-hidden="true"></div>

    <div class="relative z-10 max-w-[1280px] mx-auto px-4 sm:px-6 md:px-10 flex flex-col items-center justify-center text-center py-20 sm:py-24 md:py-32">

        <div class="inline-flex items-center gap-3 mb-5">
            <div class="h-px w-8 bg-primary/70 rounded-full"></div>
            <span class="text-primary font-bold tracking-[0.26em] uppercase text-[0.66rem]">Our Services</span>
            <div class="h-px w-8 bg-primary/70 rounded-full"></div>
        </div>

        <h1 class="text-white text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black leading-tight tracking-tight mb-5">
            {{ $service->translated_title ?? $service->title }}
        </h1>
        <p class="text-slate-300 text-base sm:text-lg font-normal max-w-2xl mx-auto px-4 leading-relaxed">
            {{ __('common.we_provide_services') }}
        </p>

        <div class="flex flex-col sm:flex-row gap-3 mt-8">
            <button type="button" onclick="openContactModal('{{ $service->translated_title ?? $service->title }}')"
                class="inline-flex items-center justify-center gap-2 rounded-xl h-11 sm:h-12 px-7 sm:px-9 bg-primary text-white text-xs sm:text-sm font-bold tracking-wide transition-all hover:bg-primary/90 hover:-translate-y-0.5 shadow-lg shadow-primary/30">
                Get a Free Consultation
                <span class="material-symbols-outlined text-base">arrow_forward</span>
            </button>
            <a href="{{ route('services') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl h-11 sm:h-12 px-7 sm:px-9 border-2 border-white/30 text-white text-xs sm:text-sm font-bold tracking-wide transition-all hover:bg-white/10 hover:border-white/50">
                All Services
            </a>
        </div>
    </div>
</section>

<!-- Service Content -->
<section class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-10 py-12 sm:py-16 bg-white dark:bg-slate-900">
    <div class="space-y-8 service-content-animate">
        @if($service->intro_text)
        <p class="text-slate-500 dark:text-slate-400 text-sm">{{ $service->intro_text }}</p>
        @endif

        @if($service->main_heading)
        <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-navy-deep dark:text-white">{{ $service->main_heading }}</h2>
        @endif

        @if($service->content_paragraph_1)
        <div class="text-slate-600 dark:text-slate-400 leading-relaxed text-base sm:text-lg">
            {!! nl2br(e($service->content_paragraph_1)) !!}
        </div>
        @endif

        @if($service->content_paragraph_2)
        <div class="text-slate-600 dark:text-slate-400 leading-relaxed text-base sm:text-lg">
            {!! nl2br(e($service->content_paragraph_2)) !!}
        </div>
        @endif

        @if($service->services_list)
        <div class="grid sm:grid-cols-2 gap-3 my-2">
            @foreach(explode("\n", $service->services_list) as $serviceItem)
                @if(trim($serviceItem))
                <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800">
                    <span class="material-symbols-outlined text-primary text-lg mt-0.5 flex-shrink-0" style="font-variation-settings:'FILL' 1">check_circle</span>
                    <span class="text-slate-700 dark:text-slate-300 leading-relaxed text-sm sm:text-base">{{ trim($serviceItem) }}</span>
                </div>
                @endif
            @endforeach
        </div>
        @endif

        @if($service->additional_info_content)
        <div class="text-slate-600 dark:text-slate-400 leading-relaxed text-base sm:text-lg">
            {!! nl2br(e($service->additional_info_content)) !!}
            @if($service->additional_info_link)
            <a href="{{ $service->additional_info_link }}" target="_blank" class="text-primary hover:underline font-semibold ml-1">{{ __('common.read_more') }}</a>
            @endif
        </div>
        @endif

        @if($service->section_title)
        <div class="pt-8 mt-8 border-t border-slate-200 dark:border-slate-700">
            <h3 class="text-2xl sm:text-3xl font-bold text-navy-deep dark:text-white mb-4">{{ $service->section_title }}</h3>
            
            @if($service->section_content_1)
            <div class="text-slate-600 dark:text-slate-400 leading-relaxed text-base sm:text-lg mb-4">
                {!! nl2br(e($service->section_content_1)) !!}
            </div>
            @endif

            @if($service->section_content_2)
            <div class="text-slate-600 dark:text-slate-400 leading-relaxed text-base sm:text-lg mb-4">
                {!! nl2br(e($service->section_content_2)) !!}
            </div>
            @endif

            @if($service->section_content_3)
            <div class="text-slate-600 dark:text-slate-400 leading-relaxed text-base sm:text-lg">
                {!! nl2br(e($service->section_content_3)) !!}
            </div>
            @endif
        </div>
        @endif

        @if($service->contact_cta_text)
        <div class="pt-6 mt-6 border-t border-slate-200 dark:border-slate-700">
            <p class="text-slate-600 dark:text-slate-400 leading-relaxed text-base sm:text-lg">
                @if($service->contact_cta_link)
                <a href="{{ $service->contact_cta_link }}" class="text-primary hover:underline font-semibold">{{ $service->contact_cta_text }}</a>
                @else
                {{ $service->contact_cta_text }}
                @endif
                @if($service->contact_cta_link && strpos($service->contact_cta_link, '#') !== 0)
                <a href="{{ $service->contact_cta_link }}" class="text-primary hover:underline ml-1">{{ __('common.here') }}</a>
                @endif
            </p>
        </div>
        @endif

        @if(!$service->intro_text && !$service->main_heading && !$service->content_paragraph_1 && !$service->content_paragraph_2 && !$service->services_list && !$service->section_title)
        <!-- Fallback to description if no structured content -->
        <div class="prose prose-lg dark:prose-invert max-w-none">
            <div class="text-slate-600 dark:text-slate-400 leading-relaxed text-lg">{!! nl2br(e($service->description)) !!}</div>
        </div>
        @endif
    </div>
</section>

<!-- Sub-Services Section -->
@if($service->activeSubServices && $service->activeSubServices->count() > 0)
@php
    // Get all available photos based on service type (expanded pool to ensure uniqueness)
    $serviceType = strtolower($service->title);
    $allPhotos = [];
    
    if (str_contains($serviceType, 'accounting') || str_contains($serviceType, 'bookkeeping')) {
        $allPhotos = [
            stock_img('photo-1554224155-6726b3ff858f'),
            stock_img('photo-1522071820081-009f0129c71c'),
            stock_img('photo-1552664730-d307ca884978'),
            stock_img('photo-1554224155-8d04cb21cd6c'),
            stock_img('photo-1551288049-bebda4e38f71'),
            stock_img('photo-1556761175-5973dc0f32e7'),
            stock_img('photo-1556761175-4b46a572b786'),
            stock_img('photo-1556761175-b41319ca44b6'),
        ];
    } elseif (str_contains($serviceType, 'tax')) {
        $allPhotos = [
            stock_img('photo-1551288049-bebda4e38f71'),
            stock_img('photo-1554224155-6726b3ff858f'),
            stock_img('photo-1552664730-d307ca884978'),
            stock_img('photo-1522071820081-009f0129c71c'),
            stock_img('photo-1554224155-8d04cb21cd6c'),
            stock_img('photo-1556761175-5973dc0f32e7'),
            stock_img('photo-1556761175-4b46a572b786'),
            stock_img('photo-1556761175-b41319ca44b6'),
        ];
    } elseif (str_contains($serviceType, 'policies') || str_contains($serviceType, 'procedures')) {
        $allPhotos = [
            stock_img('photo-1552664730-d307ca884978'),
            stock_img('photo-1522071820081-009f0129c71c'),
            stock_img('photo-1554224155-6726b3ff858f'),
            stock_img('photo-1554224155-8d04cb21cd6c'),
            stock_img('photo-1551288049-bebda4e38f71'),
            stock_img('photo-1556761175-5973dc0f32e7'),
            stock_img('photo-1556761175-4b46a572b786'),
            stock_img('photo-1556761175-b41319ca44b6'),
        ];
    } elseif (str_contains($serviceType, 'financial') || str_contains($serviceType, 'administration')) {
        $allPhotos = [
            stock_img('photo-1554224155-8d04cb21cd6c'),
            stock_img('photo-1551288049-bebda4e38f71'),
            stock_img('photo-1554224155-6726b3ff858f'),
            stock_img('photo-1522071820081-009f0129c71c'),
            stock_img('photo-1552664730-d307ca884978'),
            stock_img('photo-1556761175-5973dc0f32e7'),
            stock_img('photo-1556761175-4b46a572b786'),
            stock_img('photo-1556761175-b41319ca44b6'),
        ];
    } elseif (str_contains($serviceType, 'it') || str_contains($serviceType, 'support')) {
        $allPhotos = [
            stock_img('photo-1555066931-4365d14bab8c'),
            stock_img('photo-1522071820081-009f0129c71c'),
            stock_img('photo-1550751827-4bd374c3f58b'),
            stock_img('photo-1551650975-87deedd944c3'),
            stock_img('photo-1460925895917-afdab827c52f'),
            stock_img('photo-1498050108023-c5249f4df085'),
            stock_img('photo-1487058792275-0ad4aaf24ca7'),
            stock_img('photo-1551650975-87deedd944c3'),
            stock_img('photo-1558494949-ef010cbdcc31'),
            stock_img('photo-1555949963-aa79dcee981c'),
        ];
    } else {
        $allPhotos = [
            stock_img('photo-1554224155-6726b3ff858f'),
            stock_img('photo-1522071820081-009f0129c71c'),
            stock_img('photo-1551288049-bebda4e38f71'),
            stock_img('photo-1552664730-d307ca884978'),
            stock_img('photo-1554224155-8d04cb21cd6c'),
            stock_img('photo-1556761175-5973dc0f32e7'),
            stock_img('photo-1556761175-4b46a572b786'),
            stock_img('photo-1556761175-b41319ca44b6'),
        ];
    }
    
    // Track used images to ensure uniqueness (no rotation)
    $usedImages = [];
@endphp

<section class="bg-white dark:bg-slate-900 py-12 sm:py-16 md:py-20 lg:py-24">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-10">
        @foreach($service->activeSubServices as $index => $subService)
            @php
                $subServiceTitle = strtolower($subService->title);
                $subServiceDesc = strtolower($subService->description ?? '');
                $subServiceContent = strtolower($subService->content_1 ?? '');
                $combinedText = $subServiceTitle . ' ' . $subServiceDesc . ' ' . $subServiceContent;
                
                $subServicePhotos = [];
                $defaultFallback = stock_img('photo-1554224155-6726b3ff858f');
                
                if (str_contains($combinedText, 'flutter') || str_contains($combinedText, 'mobile') || str_contains($combinedText, 'app')) {
                    $subServicePhotos = [
                        stock_img('photo-1512941937669-90a1b58e7e9c'),
                        stock_img('photo-1555774698-0b77e0d5fac6'),
                        stock_img('photo-1551650975-87deedd944c3'),
                    ];
                } elseif (str_contains($combinedText, 'cybersecurity') || str_contains($combinedText, 'security') || str_contains($combinedText, 'cyber')) {
                    $subServicePhotos = [
                        stock_img('photo-1563013544-824ae1b704d3'),
                        stock_img('photo-1558494949-ef010cbdcc31'),
                        stock_img('photo-1555949963-aa79dcee981c'),
                        stock_img('photo-1460925895917-afdab827c52f'),
                        stock_img('photo-1550751827-4bd374c3f58b'),
                    ];
                } elseif (str_contains($combinedText, 'desktop') || str_contains($combinedText, 'c sharp') || str_contains($combinedText, 'c#') || str_contains($combinedText, '.net')) {
                    $subServicePhotos = [
                        stock_img('photo-1498050108023-c5249f4df085'),
                        stock_img('photo-1487058792275-0ad4aaf24ca7'),
                        stock_img('photo-1555066931-4365d14bab8c'),
                    ];
                } elseif (str_contains($combinedText, 'bookkeeping') || str_contains($combinedText, 'book keeping')) {
                    $subServicePhotos = [
                        stock_img('photo-1556761175-5973dc0f32e7'),
                        stock_img('photo-1556761175-4b46a572b786'),
                        stock_img('photo-1556761175-b41319ca44b6'),
                    ];
                } elseif (str_contains($combinedText, 'regulatory') || str_contains($combinedText, 'filing') || str_contains($combinedText, 'vat') || str_contains($combinedText, 'tax return')) {
                    $subServicePhotos = [
                        stock_img('photo-1556761175-b41319ca44b6'),
                        stock_img('photo-1556761175-5973dc0f32e7'),
                        stock_img('photo-1556761175-4b46a572b786'),
                    ];
                } elseif (str_contains($combinedText, 'tax planning') || str_contains($combinedText, 'tax preparation')) {
                    $subServicePhotos = [
                        stock_img('photo-1551288049-bebda4e38f71'),
                        stock_img('photo-1460925895917-afdab827c52f'),
                    ];
                } elseif (str_contains($combinedText, 'policy development') || str_contains($combinedText, 'policy review')) {
                    $subServicePhotos = [
                        stock_img('photo-1522071820081-009f0129c71c'),
                        stock_img('photo-1556761175-4b46a572b786'),
                    ];
                } elseif (str_contains($combinedText, 'financial reporting') || str_contains($combinedText, 'financial report')) {
                    $subServicePhotos = [
                        stock_img('photo-1556761175-b41319ca44b6'),
                        stock_img('photo-1556761175-5973dc0f32e7'),
                    ];
                } elseif (str_contains($combinedText, 'budget') || str_contains($combinedText, 'cash flow')) {
                    $subServicePhotos = [
                        stock_img('photo-1556761175-5973dc0f32e7'),
                        stock_img('photo-1556761175-4b46a572b786'),
                        stock_img('photo-1556761175-b41319ca44b6'),
                    ];
                } else {
                    $subServicePhotos = [
                        stock_img('photo-1556761175-5973dc0f32e7'),
                        stock_img('photo-1556761175-4b46a572b786'),
                        stock_img('photo-1556761175-b41319ca44b6'),
                        stock_img('photo-1522071820081-009f0129c71c'),
                    ];
                }
                
                if ($subService->image_url) {
                    $subServiceImage = $subService->image_url;
                } else {
                    $subServicePhotos = array_values(array_unique($subServicePhotos));
                    if (count($subServicePhotos) > 0) {
                        $photoIndex = ($subService->id % count($subServicePhotos));
                        $subServiceImage = $subServicePhotos[$photoIndex];
                        if (in_array($subServiceImage, $usedImages) && count($subServicePhotos) > 1) {
                            $nextIndex = ($photoIndex + 1) % count($subServicePhotos);
                            $subServiceImage = $subServicePhotos[$nextIndex];
                        }
                        $usedImages[] = $subServiceImage;
                    } else {
                        $availableImages = array_diff($allPhotos, $usedImages);
                        if (empty($availableImages)) {
                            $usedImages = [];
                            $availableImages = $allPhotos;
                        }
                        $subServiceImage = reset($availableImages) ?? stock_img('photo-1554224155-6726b3ff858f');
                        $usedImages[] = $subServiceImage;
                    }
                }
                if (empty($subServiceImage)) {
                    $subServiceImage = $defaultFallback;
                }
            @endphp

            <div class="mb-16 last:mb-0 {{ $index > 0 ? 'pt-16 border-t border-slate-200 dark:border-slate-700' : '' }}">
                <div class="flex flex-col lg:flex-row gap-8 lg:gap-12 items-start">
                    <!-- Left Side: Image -->
                    <div class="w-full lg:w-1/2">
                        <div class="w-full aspect-[4/3] rounded-xl overflow-hidden shadow-xl bg-slate-200 dark:bg-slate-700">
                            <img src="{{ $subServiceImage }}" alt="{{ $subService->translated_title ?? $subService->title }}" class="w-full h-full object-cover" loading="lazy" onerror="this.onerror=null; this.src='{{ stock_img('photo-1554224155-6726b3ff858f') }}';">
                        </div>
                    </div>

                    <!-- Right Side: Content -->
                    <div class="w-full lg:w-1/2 flex flex-col">
                        <h2 class="text-4xl sm:text-5xl md:text-6xl font-black text-primary mb-6 leading-tight">
                            {{ $subService->translated_title ?? $subService->title }}
                        </h2>

                        @if($subService->description)
                        <div class="text-slate-600 dark:text-slate-400 leading-relaxed text-base sm:text-lg mb-6">
                            {!! nl2br(e($subService->description)) !!}
                        </div>
                        @endif

                        @if($subService->content_1 && !$subService->heading_1)
                        <div class="text-slate-600 dark:text-slate-400 leading-relaxed text-base sm:text-lg mb-4">
                            {!! nl2br(e($subService->content_1)) !!}
                        </div>
                        @endif

                        @if($subService->content_2 && !$subService->heading_2)
                        <div class="text-slate-600 dark:text-slate-400 leading-relaxed text-base sm:text-lg mb-6">
                            {!! nl2br(e($subService->content_2)) !!}
                        </div>
                        @endif

                        @php
                            $hasListItems = false;
                            $listItems = [];
                            for($i = 1; $i <= 5; $i++) {
                                $heading = $subService->{"heading_{$i}"};
                                if($heading && !empty(trim($heading))) {
                                    $listItems[] = trim($heading);
                                    $hasListItems = true;
                                }
                            }
                        @endphp

                        @if($hasListItems)
                        <div class="mb-6">
                            <p class="text-slate-600 dark:text-slate-400 text-base sm:text-lg mb-4 font-medium">
                                {{ str_replace(':service', strtolower($subService->translated_title ?? $subService->title), __('common.our_services_include')) }}
                            </p>
                            <ul class="space-y-2">
                                @foreach($listItems as $item)
                                <li class="flex items-start gap-3">
                                    <span class="material-symbols-outlined text-primary text-base mt-0.5 flex-shrink-0" style="font-variation-settings:'FILL' 1">check_circle</span>
                                    <span class="text-slate-600 dark:text-slate-400 leading-relaxed text-sm sm:text-base flex-1">{{ $item }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="mt-auto pt-4">
                            <a href="{{ route('sub-services.show', $subService->id) }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-primary hover:bg-primary/90 text-white rounded-lg font-bold text-lg transition-all shadow-lg hover:shadow-xl">
                                {{ __('common.find_out_more') }}
                                <span class="material-symbols-outlined">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif

{{-- CTA SECTION --}}
<section class="max-w-[1080px] mx-auto px-4 sm:px-6 pb-16 sm:pb-20 mt-8 sm:mt-12">
    <div class="relative rounded-2xl sm:rounded-3xl overflow-hidden" style="background: linear-gradient(135deg, #137fec 0%, #0e6fd4 40%, #3730a3 100%);">
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true" style="background-image: radial-gradient(circle, rgba(255,255,255,0.07) 1px, transparent 1px); background-size: 28px 28px;"></div>
        <div class="absolute -top-24 -right-24 w-80 h-80 bg-white/10 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>
        <div class="relative z-10 p-8 sm:p-10 md:p-14 text-center text-white flex flex-col items-center gap-4">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/15 border border-white/20 text-[0.66rem] font-bold uppercase tracking-[0.22em] text-white/90">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 flex-shrink-0"></span>
                Available for New Engagements
            </div>
            <h3 class="text-2xl sm:text-3xl md:text-4xl font-black leading-tight max-w-[540px]">
                Ready to discuss <span class="text-white/90">{{ $service->translated_title ?? $service->title }}</span>?
            </h3>
            <p class="text-white/80 max-w-md text-sm sm:text-base leading-relaxed">
                Our specialists are ready to help. Reach out for a free initial consultation — no obligation.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 mt-2">
                <button type="button" onclick="openContactModal(‘{{ $service->translated_title ?? $service->title }}’)"
                    class="inline-flex items-center justify-center gap-2 rounded-xl h-12 sm:h-14 px-8 sm:px-10 bg-white text-primary text-sm font-black tracking-wide transition-all hover:scale-105 hover:shadow-2xl shadow-lg cursor-pointer">
                    Get a Free Consultation
                    <span class="material-symbols-outlined text-lg">arrow_forward</span>
                </button>
                <a href="{{ route(‘services’) }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl h-12 sm:h-14 px-8 sm:px-10 bg-transparent border-2 border-white/35 text-white text-sm font-bold tracking-wide transition-all hover:bg-white/12 hover:border-white/55">
                    View All Services
                </a>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    .service-content-animate { 
        opacity: 0; 
        animation: slideUpFadeIn 0.8s ease-out forwards; 
    }

    @keyframes slideUpFadeIn { 
        from { 
            opacity: 0; 
            transform: translateY(30px); 
        } 
        to { 
            opacity: 1; 
            transform: translateY(0); 
        } 
    }
</style>
@endpush

@endsection