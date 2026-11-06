@extends('layouts.app')

@section('title', ($insight->heading ?? $insight->title) . ' | 9Associates Insights')

@section('meta_description', \Illuminate\Support\Str::limit(
    strip_tags($insight->excerpt ?? $insight->content ?? ''),
    160
))

@section('meta_keywords', ($insight->category ? $insight->category . ', ' : '') . '9Associates insights, finance, tax, audit, GCC')

@section('content')

@php
$fallback = stock_img('photo-1486312338219-ce68d2c6f44d');
$url = url()->current();
$title = $insight->heading ?? $insight->title;
@endphp


<!-- HERO -->
<section class="bg-white dark:bg-slate-900">

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-10 pt-10">

        <!-- CATEGORY -->
        <div class="text-primary text-xs font-bold uppercase tracking-wider mb-3">
            {{ $insight->category }}
        </div>

        <!-- TITLE -->
        <h1 class="text-3xl sm:text-5xl font-black text-slate-900 dark:text-white leading-tight">
            {{ $title }}
        </h1>

        <!-- META -->
        <div class="flex flex-wrap gap-4 text-xs text-slate-500 mt-4">
            <span>📅 {{ $insight->published_at?->format('M d, Y') }}</span>
            <span>⏱ Reading time: ~5 min</span>
        </div>

    </div>

    <!-- IMAGE -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-10 mt-8">
        <div class="rounded-2xl overflow-hidden shadow-xl h-[320px] sm:h-[420px]">
            <img src="{{ $insight->image_url ?? $insight->auto_image ?? $fallback }}"
                 class="w-full h-full object-cover"
                 loading="lazy"
                 onerror="this.src='{{ $fallback }}'">
        </div>
    </div>

</section>


<!-- CONTENT -->
<section class="bg-white dark:bg-slate-900">

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-10 py-10">

        <!-- EXCERPT -->
        @if($insight->excerpt)
        <p class="text-lg text-slate-600 dark:text-slate-300 leading-relaxed mb-8 border-l-4 border-primary pl-4">
            {{ $insight->excerpt }}
        </p>
        @endif

        <!-- MAIN CONTENT -->
        @if($insight->content)
        <article class="prose prose-lg dark:prose-invert max-w-none text-slate-700 dark:text-slate-300">
            {!! nl2br(e($insight->content)) !!}
        </article>
        @endif

    </div>

</section>


<!-- FLOATING ACTION BAR (UX BOOST) -->
<div class="fixed bottom-4 right-4 flex flex-col gap-2 z-50">

    <!-- SHARE -->
    <button onclick="sharePost()"
        class="w-12 h-12 rounded-full bg-blue-600 text-white shadow-lg flex items-center justify-center">
        🔗
    </button>

    <!-- WHATSAPP -->
    <a href="https://wa.me/?text={{ urlencode($title.' '.$url) }}"
       target="_blank"
       class="w-12 h-12 rounded-full bg-green-500 text-white shadow-lg flex items-center justify-center animate-pulse">
        <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/whatsapp.svg"
             class="w-5 h-5 invert">
    </a>

</div>


<!-- RELATED -->
@if($relatedInsights && $relatedInsights->count() > 0)

<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-10 py-12">

    <h2 class="text-2xl font-black text-slate-900 dark:text-white mb-6">
        Related Insights
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        @foreach($relatedInsights as $related)

        <article class="rounded-xl overflow-hidden shadow-sm border bg-white dark:bg-slate-800">

            <div class="h-40 overflow-hidden">
                <img src="{{ $related->image_url ?? $related->auto_image ?? $fallback }}"
                     class="w-full h-full object-cover"
                     loading="lazy"
                     onerror="this.src='{{ $fallback }}'">
            </div>

            <div class="p-4">

                <span class="text-xs text-primary font-bold">
                    {{ $related->category }}
                </span>

                <h3 class="font-bold text-base mt-2 line-clamp-2 text-slate-900 dark:text-white">
                    {{ $related->heading ?? $related->title }}
                </h3>

                <a href="{{ route('insights.show', $related->id) }}"
                   class="text-primary text-sm mt-3 inline-block">
                    Read More →
                </a>

            </div>

        </article>

        @endforeach

    </div>

</section>

@endif


<!-- BACK -->
<section class="max-w-6xl mx-auto px-4 py-10">

    <a href="{{ route('insights') }}"
       class="inline-flex items-center gap-2 px-5 py-3 bg-primary text-white rounded-lg shadow">
        ← Back to Insights
    </a>

</section>

@endsection


@push('scripts')
<script>
function sharePost(){
    const url = window.location.href;
    const title = document.title;

    if(navigator.share){
        navigator.share({title, url});
    } else {
        window.open(`https://wa.me/?text=${encodeURIComponent(title+' '+url)}`);
    }
}
</script>
@endpush