@extends('layouts.app')

{{-- SEO sections --}}
@section('title', ($page->meta_title ?? $page->title) . ' | 9Associates')

@section('meta_description', \Illuminate\Support\Str::limit(
    strip_tags($page->meta_description ?? $page->content ?? ''),
    160
))

@section('meta_keywords', ($page->meta_keywords ?? $page->title) . ', 9Associates, legal, policy, terms, GCC')

@section('content')

<section class="max-w-[1200px] mx-auto px-4 sm:px-6 md:px-10 py-12 sm:py-16 md:py-24">
    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 p-6 sm:p-8 md:p-12">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-navy-deep dark:text-white mb-6 sm:mb-8">
            {{ $page->title }}
        </h1>
        <div class="prose prose-lg dark:prose-invert max-w-none">
            <div class="text-slate-600 dark:text-slate-400 leading-relaxed text-base sm:text-lg whitespace-pre-wrap">
                {!! nl2br(e($page->content)) !!}
            </div>
        </div>
    </div>
</section>

@endsection