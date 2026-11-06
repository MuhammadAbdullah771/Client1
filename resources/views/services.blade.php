@extends('layouts.app')

@section('title', '9Associates Services | Accounting, Tax, Audit & Consulting')

@section('content')

{{-- HERO --}}
<section class="relative text-center py-16 sm:py-20 md:py-24 overflow-hidden">
    {{-- Decorative glow background --}}
    <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
        <div class="absolute left-1/2 -translate-x-1/2 top-0 w-[600px] h-[400px] rounded-full" style="background: radial-gradient(ellipse at center, rgba(19,127,236,0.08) 0%, transparent 70%);"></div>
    </div>
    <div class="max-w-[860px] mx-auto px-4 relative">
        <div class="inline-flex items-center gap-3 mb-6">
            <div class="h-px w-8 bg-primary rounded-full"></div>
            <span class="text-primary font-bold tracking-[0.26em] uppercase text-[0.68rem]">What We Do</span>
            <div class="h-px w-8 bg-primary rounded-full"></div>
        </div>
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold mb-5 text-navy-deep dark:text-white tracking-tight leading-tight">
            Expert Advisory &amp;<br><span class="bg-gradient-to-r from-primary to-indigo-600 bg-clip-text text-transparent">Financial Services</span>
        </h1>
        <p class="text-base sm:text-lg text-slate-500 dark:text-slate-400 max-w-xl mx-auto leading-relaxed mb-8">
            Explore professional accounting, tax, audit &amp; consulting solutions tailored for your business growth across the GCC.
        </p>
        {{-- SEARCH --}}
        <div class="relative max-w-md mx-auto">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl pointer-events-none">search</span>
            <input id="search"
                   type="text"
                   placeholder="Search services..."
                   class="w-full h-12 pl-12 pr-5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-navy-deep dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-primary focus:border-transparent outline-none shadow-sm text-sm transition-all">
        </div>
    </div>
</section>

{{-- SERVICES GRID --}}
<section class="max-w-[1300px] mx-auto px-4 pb-20">

@php
function getUniqueImage($service)
{
    $title = strtolower($service->translated_title ?? $service->title ?? '');
    $id = $service->id;

    $images = [

        'accounting' => [
            stock_img('photo-1554224154-26032fced8bd'),
            stock_img('photo-1565514020179-026b92b2d7c5'),
            stock_img('photo-1554224155-1696413565d3'),
        ],

        'tax' => [
            stock_img('photo-1589829545856-d10d557cf95f'),
            stock_img('photo-1605902711622-cfb43c4437d3'),
            stock_img('photo-1581091012184-5c3a2f8d7b7a'),
        ],

        'audit' => [
            stock_img('photo-1589652717521-10c0d092dea9'),
            stock_img('photo-1454165804606-c3d57bc86b40'),
            stock_img('photo-1520607162513-77705c0f0d4a'),
        ],

        'consulting' => [
            stock_img('photo-1552664730-d307ca884978'),
            stock_img('photo-1521737604893-d14cc237f11d'),
            stock_img('photo-1557804506-669a67965ba0'),
        ],

        'finance' => [
            stock_img('photo-1554224155-1696413565d3'),
            stock_img('photo-1554224156-6726b3ff858f'),
        ],

        'business' => [
            stock_img('photo-1521737604893-d14cc237f11d'),
            stock_img('photo-1556761175-b413da4baf72'),
        ],

        'analysis' => [
            stock_img('photo-1551288049-bebda4e38f71'),
            stock_img('photo-1556742049-0cfed4f6a45d'),
        ],

        'default' => [
            stock_img('photo-1526378722484-bd91ca387e72'),
            stock_img('photo-1504384308090-c894fdcc538d'),
        ],
    ];

    foreach ($images as $key => $list) {
        if ($key !== 'default' && str_contains($title, $key)) {
            return $list[$id % count($list)];
        }
    }

    return $images['default'][$id % count($images['default'])];
}
@endphp

<div id="grid" class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">

@foreach($navServices ?? $services ?? [] as $service)

@php
$image = $service->display_image_url ?: getUniqueImage($service);
@endphp

<div class="card group service-card">
    <div class="relative bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-slate-200/80 dark:border-slate-800/80 shadow-sm hover:shadow-2xl hover:border-primary/25 transition-all duration-400 hover:-translate-y-1.5 flex flex-col h-full">

        {{-- IMAGE --}}
        <div class="relative overflow-hidden bg-slate-100 dark:bg-slate-800" style="height:210px; flex-shrink:0;">
            <img src="{{ $image }}"
                 alt="{{ $service->translated_title }}"
                 loading="lazy"
                 decoding="async"
                 class="svc-img-zoom w-full h-full object-cover">
            {{-- Bottom gradient --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black/45 via-transparent to-transparent pointer-events-none"></div>
            {{-- Category chip --}}
            <span class="svc-card-tag">Advisory</span>
            {{-- Quick-action overlay --}}
            <div class="absolute inset-0 bg-navy-deep/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-3 backdrop-blur-sm">
                <a href="{{ route('services.show',$service->id) }}"
                   class="btn-shimmer inline-flex items-center gap-1.5 h-9 px-5 bg-white text-navy-deep text-xs font-bold uppercase tracking-wider rounded-lg shadow transition hover:-translate-y-0.5">
                    <span class="material-symbols-outlined text-sm">open_in_new</span>View
                </a>
                <button onclick="openContactModal()"
                        class="btn-shimmer inline-flex items-center gap-1.5 h-9 px-5 bg-primary text-white text-xs font-bold uppercase tracking-wider rounded-lg shadow transition hover:-translate-y-0.5">
                    <span class="material-symbols-outlined text-sm">headset_mic</span>Enquire
                </button>
            </div>
        </div>

        {{-- CONTENT --}}
        <div class="p-5 sm:p-6 flex flex-col flex-1 gap-3">
            <h3 class="font-bold text-base sm:text-lg text-navy-deep dark:text-white leading-snug line-clamp-2">
                {{ $service->translated_title }}
            </h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed line-clamp-2 flex-1">
                {{ \Illuminate\Support\Str::limit($service->description, 90) }}
            </p>
            <div class="flex items-center justify-between pt-3 border-t border-slate-100 dark:border-slate-800/70 mt-1">
                <a href="{{ route('services.show',$service->id) }}"
                   class="inline-flex items-center gap-1.5 text-primary text-sm font-bold group-hover:gap-2.5 transition-all">
                    Learn More
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
                <span class="w-5 h-5 rounded-full bg-primary/8 dark:bg-primary/15 flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-xs" style="font-variation-settings:'FILL' 1">check</span>
                </span>
            </div>
        </div>

    </div>
</div>

@endforeach

</div>

</section>

{{-- FLOAT CTA --}}
<div class="fixed bottom-6 right-6 z-30 hidden sm:block">
    <button onclick="openContactModal()"
            class="btn-glow btn-shimmer inline-flex items-center gap-2.5 pl-3.5 pr-5 py-3 bg-primary text-white rounded-full shadow-xl hover:scale-105 active:scale-95 transition-all text-xs font-bold uppercase tracking-[0.16em]">
        <span class="w-7 h-7 rounded-full bg-white/20 flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-sm" style="font-variation-settings:'FILL' 1">headset_mic</span>
        </span>
        Talk to an Expert
    </button>
</div>

{{-- SEARCH SCRIPT (FIXED BLINK ISSUE) --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const search = document.getElementById('search');
    const cards = document.querySelectorAll('.service-card');

    search.addEventListener('input', function () {

        const value = this.value.toLowerCase();

        cards.forEach(card => {
            const text = card.innerText.toLowerCase();
            card.style.display = text.includes(value) ? '' : 'none';
        });

    });

});
</script>

@endsection