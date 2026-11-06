@extends('layouts.app')

@section('title')
@php
    $category = request('category');

    echo match($category) {
        'Taxation' => 'Taxation Insights | 9Associates CA & Tax Advisory',
        'Economy'  => 'Economic Insights | 9Associates Market Intelligence',
        default    => 'Insights | 9Associates Finance, Tax & Business Intelligence',
    };
@endphp
@endsection

@section('meta_description')
@php
    $desc = $featured->excerpt
        ?? optional($insights->first())->excerpt
        ?? 'Expert insights on accounting, taxation, audit and business strategy from 9Associates.';

    echo \Illuminate\Support\Str::limit(strip_tags($desc), 160);
@endphp
@endsection

@section('content')

@php
    // 🔥 BUSINESS / CA / FINANCE ONLY SLIDER POOL
    $businessSlides = [
        stock_img('photo-1554224155-6726b3ff858f'), // accounting desk
        stock_img('photo-1551288049-bebda4e38f71'), // financial charts
        stock_img('photo-1521737604893-d14cc237f11d'), // business meeting
        stock_img('photo-1552664730-d307ca884978'), // analytics dashboard
        stock_img('photo-1508385082359-f38ae991e8f2'), // finance planning
        stock_img('photo-1554224154-26032fced8bd'), // corporate office
    ];

    $usedImages = [];

    $active = request('category');
@endphp


<!-- HERO SLIDER -->
@if($featured)
<section class="max-w-7xl mx-auto px-4 pt-14 pb-10">

    <div class="relative rounded-3xl overflow-hidden shadow-2xl min-h-[480px]">

        @foreach($businessSlides as $i => $img)
            <div class="featured-slide {{ $i==0 ? 'active' : '' }}"
                 style="background-image:url('{{ $img }}')"></div>
        @endforeach

        <!-- dark premium overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/40 to-black/20"></div>

        <!-- CONTENT -->
        <div class="relative z-10 p-10 md:p-16 flex flex-col justify-end h-full">

            <span class="inline-flex w-fit px-4 py-1 rounded-full bg-white/10 text-white text-xs backdrop-blur">
                Finance • Tax • Audit Intelligence
            </span>

            <h1 class="mt-4 text-white text-4xl md:text-6xl font-black leading-tight">
                {{ $featured->heading ?? $featured->title }}
            </h1>

            <p class="mt-4 text-white/80 max-w-2xl text-base md:text-lg">
                {{ $featured->excerpt }}
            </p>

        </div>
    </div>
</section>
@endif


<!-- FILTER BAR -->
<section class="max-w-7xl mx-auto px-4 py-10 flex flex-wrap justify-between items-center gap-5">
    <div>
        <div class="flex items-center gap-3 mb-2">
            <div class="h-px w-8 bg-primary rounded-full"></div>
            <span class="text-primary font-bold tracking-[0.26em] uppercase text-[0.68rem]">Knowledge Hub</span>
        </div>
        <h2 class="text-3xl font-black text-navy-deep dark:text-white tracking-tight">Insights</h2>
        <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Accounting &bull; Tax &bull; Business Intelligence</p>
    </div>

    <div class="flex gap-2 flex-wrap">
        @foreach(['all'=>'All Insights','Taxation'=>'Taxation','Economy'=>'Economy'] as $key=>$label)
            <a href="{{ route('insights', ['category'=>$key=='all'?null:$key]) }}"
               class="px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider transition-all border
               {{ ($active==$key || (!$active && $key=='all')) ? 'bg-primary text-white border-primary shadow-lg shadow-primary/25' : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:border-primary/40' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>
</section>


<!-- GRID -->
<section class="max-w-7xl mx-auto px-4 mt-10">

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach($insights as $index => $insight)

        @php
            // 🔥 STRICT NO DUPLICATE IMAGE SYSTEM
            $img = $insight->image_url
                ?? $insight->auto_image
                ?? $businessSlides[$index % count($businessSlides)];

            while(in_array($img, $usedImages)) {
                $img = $businessSlides[array_rand($businessSlides)];
            }

            $usedImages[] = $img;

            $readingTime = max(1, ceil(str_word_count(strip_tags($insight->excerpt ?? '')) / 200));
        @endphp

        <article class="group flex flex-col bg-white dark:bg-slate-900 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:shadow-primary/8 transition-all duration-300 hover:-translate-y-1.5 border border-slate-100 dark:border-slate-800 hover:border-primary/20 premium-reveal">

            <!-- IMAGE -->
            <div class="relative overflow-hidden bg-slate-200 dark:bg-slate-800" style="height: 220px; flex-shrink:0;">
                <img
                    src="{{ $img }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition duration-700"
                    loading="lazy"
                    alt="{{ $insight->title }}"
                    onerror="this.onerror=null; this.src='{{ stock_img('photo-1554224155-6726b3ff858f') }}'"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent pointer-events-none"></div>
                @if($insight->category)
                <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-[0.65rem] font-bold uppercase tracking-wider bg-primary text-white shadow">
                    {{ $insight->category }}
                </span>
                @endif
            </div>

            <!-- CONTENT -->
            <div class="flex flex-col flex-1 p-5 sm:p-6 gap-3">
                <div class="flex items-center gap-3 text-xs text-slate-400">
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-xs">calendar_today</span>
                        {{ optional($insight->published_at)->format('M d, Y') ?? 'Recent' }}
                    </span>
                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                    <span>{{ $readingTime }} min read</span>
                </div>

                <h3 class="text-base sm:text-lg font-bold text-navy-deep dark:text-white leading-snug line-clamp-2 group-hover:text-primary transition-colors duration-200">
                    {{ $insight->heading ?? $insight->title }}
                </h3>

                <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed line-clamp-3 flex-1">
                    {{ $insight->excerpt }}
                </p>

                <div class="pt-3 border-t border-slate-100 dark:border-slate-800/70 mt-auto">
                    <a href="{{ route('insights.show', $insight->id) }}"
                       class="inline-flex items-center gap-1.5 text-primary font-bold text-sm group-hover:gap-2.5 transition-all duration-200">
                        Read More
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>

        </article>

        @endforeach

    </div>

</section>

<!-- LIVE NEWS SECTION -->
<section class="py-12 sm:py-16 md:py-20 lg:py-24 bg-slate-50 dark:bg-slate-900/50 mt-10">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-6 md:px-10">
        <div class="text-center mb-8 sm:mb-12">
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-black text-navy-deep dark:text-white mb-4">Latest Market News</h2>
            <p class="text-slate-600 dark:text-slate-400 text-lg max-w-2xl mx-auto">Live updates and business news from around the world</p>
        </div>
        <div class="rounded-2xl overflow-hidden shadow-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900">
            <!-- TradingView Widget BEGIN -->
            <div class="tradingview-widget-container">
              <div class="tradingview-widget-container__widget"></div>
              <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-timeline.js" async>
              {
              "feedMode": "all_symbols",
              "isTransparent": true,
              "displayMode": "regular",
              "width": "100%",
              "height": "600",
              "colorTheme": "light",
              "locale": "en"
            }
              </script>
            </div>
            <!-- TradingView Widget END -->
            <script>
                // Switch theme dynamically if the site has dark mode
                document.addEventListener('DOMContentLoaded', function() {
                    const isDark = document.documentElement.classList.contains('dark');
                    const script = document.querySelector('.tradingview-widget-container script');
                    if (script && isDark) {
                        const json = JSON.parse(script.innerHTML);
                        json.colorTheme = "dark";
                        script.innerHTML = JSON.stringify(json);
                    }
                });
            </script>
        </div>
    </div>
</section>


<!-- PAGINATION -->
<section class="max-w-7xl mx-auto px-4 mt-12 mb-16">
    {{ $insights->links() }}
</section>

@endsection


@push('styles')
<style>
.featured-slide{
    position:absolute;
    inset:0;
    background-size:cover;
    background-position:center;
    opacity:0;
    transition:opacity 1.5s ease;
}
.featured-slide.active{opacity:1;}
</style>
@endpush


@push('scripts')
<script>
(function(){
    const slides = document.querySelectorAll('.featured-slide');
    if(!slides.length) return;

    let i = 0;
    setInterval(()=>{
        slides.forEach(s=>s.classList.remove('active'));
        slides[i % slides.length].classList.add('active');
        i++;
    },5000);
})();
</script>
@endpush