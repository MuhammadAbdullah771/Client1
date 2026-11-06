@extends('layouts.app')

@section('title', $subService->title . ' | 9Associates')

@section('meta_description', \Illuminate\Support\Str::limit(
    strip_tags(
        $subService->description
        ?? $subService->content_1
        ?? $subService->content_2
        ?? ''
    ),
    160
))

@section('meta_keywords', $subService->title . ', ' . ($subService->service->translated_title ?? $subService->service->title) . ', 9Associates services, accounting, tax, consulting, GCC')

@section('content')

@php
$combinedText = strtolower(
    $subService->title . ' ' .
    ($subService->description ?? '') . ' ' .
    ($subService->content_1 ?? '')
);

// UNIQUE IMAGE POOLS
$imagePools = [
    'tech' => [
        stock_img('photo-1519389950473-47ba0277781c'),
        stock_img('photo-1492724441997-5dc865305da7'),
        stock_img('photo-1555066931-4365d14bab8c'),
        stock_img('photo-1504639725590-34d0984388bd'),
    ],
    'finance' => [
        stock_img('photo-1554224154-26032ffc0d07'),
        stock_img('photo-1556742049-0cfed4f6a45d'),
        stock_img('photo-1565514020179-026b92b2d0c3'),
        stock_img('photo-1450101499163-c8848c66ca85'),
    ],
    'business' => [
        stock_img('photo-1521737604893-d14cc237f11d'),
        stock_img('photo-1552664730-d307ca884978'),
        stock_img('photo-1507679799987-c73779587ccf'),
        stock_img('photo-1556761175-129418cb2dfe'),
    ]
];

// CATEGORY DETECTION
$category = 'business';

if (str_contains($combinedText, 'app') || str_contains($combinedText, 'mobile') || str_contains($combinedText, 'software')) {
    $category = 'tech';
} elseif (str_contains($combinedText, 'tax') || str_contains($combinedText, 'account') || str_contains($combinedText, 'finance')) {
    $category = 'finance';
}

// SHUFFLE → NO DUPLICATE
$images = $imagePools[$category];
shuffle($images);

$mainImage = $subService->image_url ?? ($images[0] . '?auto=format&fit=crop&w=900&q=80');
$galleryImages = array_slice($images, 1, 3);
@endphp

{{-- MAIN SECTION --}}
<section class="bg-white dark:bg-slate-900 py-16 md:py-24">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-10">

        {{-- BACK --}}
        <div class="mb-8">
            <a href="{{ route('services.show', $subService->service->id) }}"
               class="inline-flex items-center gap-2 text-slate-500 hover:text-primary transition">
                ← Back to {{ $subService->service->title }}
            </a>
        </div>

        <div class="flex flex-col lg:flex-row gap-10">

            {{-- LEFT: IMAGES --}}
            <div class="w-full lg:w-1/2 space-y-4">

                <div class="relative group rounded-2xl overflow-hidden shadow-2xl">
                    <img src="{{ $mainImage }}"
                         class="w-full h-[400px] object-cover transition duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition"></div>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    @foreach($galleryImages as $img)
                    <div class="overflow-hidden rounded-xl group cursor-pointer">
                        <img src="{{ $img }}?auto=format&fit=crop&w=400&q=80"
                             class="w-full h-28 object-cover group-hover:scale-110 transition duration-300">
                    </div>
                    @endforeach
                </div>

            </div>

            {{-- RIGHT: CONTENT --}}
            <div class="w-full lg:w-1/2">

                <h1 class="text-4xl md:text-5xl font-extrabold mb-6 leading-tight bg-gradient-to-r from-primary to-indigo-600 bg-clip-text text-transparent">
                    {{ $subService->title }}
                </h1>

                @if($subService->description)
                <p class="text-lg text-slate-600 dark:text-slate-400 mb-6 leading-relaxed">
                    {!! nl2br(e($subService->description)) !!}
                </p>
                @endif

                {{-- CONTENT BLOCKS --}}
                <div class="space-y-6">
                    @for($i = 1; $i <= 5; $i++)
                        @php
                            $heading = $subService->{"heading_{$i}"};
                            $content = $subService->{"content_{$i}"};
                        @endphp

                        @if($heading || $content)
                        <div class="p-5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:shadow-lg transition">

                            @if($heading)
                            <h3 class="font-bold text-lg mb-2 text-primary">
                                {{ $heading }}
                            </h3>
                            @endif

                            @if($content)
                            <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                                {!! nl2br(e($content)) !!}
                            </p>
                            @endif

                        </div>
                        @endif
                    @endfor
                </div>

                {{-- CTA BUTTON --}}
                <div class="mt-8">
                    <a href="#" onclick="openContactModal(); return false;"
                       class="inline-flex items-center gap-2 px-8 py-4 rounded-xl bg-gradient-to-r from-primary to-indigo-600 text-white font-semibold shadow-xl hover:scale-105 transition">
                        Contact Us →
                    </a>
                </div>

            </div>

        </div>
    </div>
</section>

{{-- CTA SECTION --}}
<section class="max-w-[1200px] mx-auto px-6 pb-20">
    <div class="bg-gradient-to-r from-primary to-indigo-600 rounded-3xl p-12 text-center text-white shadow-2xl">

        <h3 class="text-3xl font-bold mb-4">
            Start Your Project 🚀
        </h3>

        <p class="text-white/90 mb-6 max-w-xl mx-auto">
            Let’s build something amazing together. Contact us now and get quick response.
        </p>

        <a href="#" onclick="openContactModal(); return false;"
           class="bg-white text-primary px-10 py-4 rounded-xl font-semibold hover:scale-105 transition shadow-lg">
            Contact Now
        </a>

    </div>
</section>

@endsection