@extends('layouts.app')

{{-- SEO sections --}}
@section('title', 'Careers at 9Associates | Join Our Expert Financial & Consulting Team')

@section('meta_description', 'Explore career opportunities at 9Associates. Join our expert team in accounting, tax, audit and strategic consulting, and build your career across the GCC with professional growth and impactful work.')

@section('meta_keywords', '9Associates careers, jobs, accounting jobs, tax jobs, audit jobs, consulting careers, GCC, UAE, KSA, join our team')

@section('content')

<section class="px-4 sm:px-6 md:px-10 py-8 sm:py-10 md:py-16">

    <div class="relative overflow-hidden rounded-xl bg-slate-900 min-h-[400px] sm:min_h-[500px] flex items-center justify-center text-center px-4 sm:px-6">

        <!-- Careers Slideshow -->

        <div class="absolute inset-0 careers-slideshow">

            <!-- Slide 1: Professional team collaboration -->

            <div class="career-slide active" style="background-image: linear-gradient(rgba(10, 25, 34, 0.6) 0%, rgba(10, 25, 34, 0.8) 100%), url('{{ stock_img('photo-1522071820081-009f0129c71c') }}');"></div>

            <!-- Slide 2: Team meeting and discussion -->

            <div class="career-slide" style="background-image: linear-gradient(rgba(10, 25, 34, 0.6) 0%, rgba(10, 25, 34, 0.8) 100%), url('{{ stock_img('photo-1552664730-d307ca884978') }}');"></div>

            <!-- Slide 3: Modern office team workspace -->

            <div class="career-slide" style="background-image: linear-gradient(rgba(10, 25, 34, 0.6) 0%, rgba(10, 25, 34, 0.8) 100%), url('{{ stock_img('photo-1497366216548-37526070297c') }}');"></div>

            <!-- Slide 4: Business team brainstorming -->

            <div class="career-slide" style="background-image: linear-gradient(rgba(10, 25, 34, 0.6) 0%, rgba(10, 25, 34, 0.8) 100%), url('{{ stock_img('photo-1521737604893-d14cc237f11d') }}');"></div>

            <!-- Slide 5: Professional team working together -->

            <div class="career-slide" style="background-image: linear-gradient(rgba(10, 25, 34, 0.6) 0%, rgba(10, 25, 34, 0.8) 100%), url('{{ stock_img('photo-1556761175-5973dc0f32e7') }}');"></div>

        </div>

        <!-- Slide Indicators -->

        <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 z-20 flex gap-2 items-center">

            <button class="career-indicator active" data-slide="0" aria-label="Slide 1" type="button"></button>

            <button class="career-indicator" data-slide="1" aria-label="Slide 2" type="button"></button>

            <button class="career-indicator" data-slide="2" aria-label="Slide 3" type="button"></button>

            <button class="career-indicator" data-slide="3" aria-label="Slide 4" type="button"></button>

            <button class="career-indicator" data-slide="4" aria-label="Slide 5" type="button"></button>

        </div>

        <div class="relative z-10 max-w-2xl">

            <h1 class="text-white text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight tracking-tight mb-4 sm:mb-6">

                {{ __('common.join_team_experts') }}

            </h1>

            <p class="text-slate-200 text-base sm:text-lg md:text-xl font-normal mb-8 sm:mb-10">

                {{ __('common.empowering_career') }}

            </p>

            <a href="#openings" class="inline-flex h-12 sm:h-14 px-6 sm:px-8 items-center justify-center rounded-lg bg-primary text-white text-sm sm:text-base font-bold shadow-lg hover:shadow-primary/30 transition-all">

                {{ __('common.view_openings') }}

            </a>

        </div>

    </div>

</section>



<section class="px-6 py-16 bg-white dark:bg-slate-900/50 rounded-xl mx-6 mb-16 shadow-sm">

    <div class="mb-12">

        <h2 class="text-3xl md:text-4xl font-extrabold mb-4">{{ __('common.why_join_wal') }}</h2>

        <p class="text-[#4c739a] dark:text-slate-400 text-lg max-w-2xl">{{ __('common.environment_fosters') }}</p>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        <div class="p-6 rounded-xl border border-[#cfdbe7] dark:border-slate-700 bg-background-light dark:bg-background-dark hover:border-primary/50 transition-colors">

            <span class="material-symbols-outlined text-primary text-3xl mb-4">trending_up</span>

            <h3 class="text-xl font-bold mb-2">{{ __('common.professional_growth') }}</h3>

            <p class="text-[#4c739a] dark:text-slate-400 leading-relaxed">{{ __('common.professional_growth_desc') }}</p>

        </div>

        <div class="p-6 rounded-xl border border-[#cfdbe7] dark:border-slate-700 bg-background-light dark:bg-background-dark hover:border-primary/50 transition-colors">

            <span class="material-symbols-outlined text-primary text-3xl mb-4">groups</span>

            <h3 class="text-xl font-bold mb-2">{{ __('common.collaborative_culture') }}</h3>

            <p class="text-[#4c739a] dark:text-slate-400 leading-relaxed">{{ __('common.collaborative_culture_desc') }}</p>

        </div>

        <div class="p-6 rounded-xl border border-[#cfdbe7] dark:border-slate-700 bg-background-light dark:bg-background-dark hover:border-primary/50 transition-colors">

            <span class="material-symbols-outlined text-primary text-3xl mb-4">public</span>

            <h3 class="text-xl font-bold mb-2">{{ __('common.impactful_work') }}</h3>

            <p class="text-[#4c739a] dark:text-slate-400 leading-relaxed">{{ __('common.impactful_work_desc') }}</p>

        </div>

    </div>

</section>



<section class="px-6 py-10 mb-20" id="openings">

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">

        <div>

            <h2 class="text-3xl font-extrabold mb-2">{{ __('common.open_positions') }}</h2>

            <p class="text-[#4c739a] dark:text-slate-400">{{ __('common.join_world_class') }}</p>

        </div>

    </div>



    <div class="space-y-4">

        @foreach($jobs as $job)

        <div class="group flex flex-col md:flex-row md:items-center justify-between p-6 bg-white dark:bg-slate-900 border border-[#e7edf3] dark:border-slate-800 rounded-xl hover:shadow-md hover:border-primary/30 transition-all">

            <div class="flex flex-col gap-2 mb-4 md:mb-0">

                <span class="text-xs font-bold text-primary uppercase tracking-wider">{{ $job->department }}</span>

                <h3 class="text-xl font-extrabold group-hover:text-primary transition-colors">{{ $job->title }}</h3>

                <div class="flex items-center gap-4 text-sm text-[#4c739a] dark:text-slate-400">

                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">location_on</span> {{ $job->location }}</span>

                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">schedule</span> {{ $job->employment_type }}</span>

                </div>

            </div>

            <button type="button" onclick="openJobApplicationModal({{ $job->id }})" class="h-11 px-6 rounded-lg bg-primary text-white text-sm font-bold hover:bg-primary/90 transition-all">

                {{ __('common.apply_now') }}

            </button>

        </div>

        @endforeach

    </div>

</section>



<!-- Job Application Modal is now in layouts/app.blade.php -->



@if(session('success'))

<div id="successMessage" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 flex items-center gap-3">

    <span class="material-symbols-outlined">check_circle</span>

    <span>{{ session('success') }}</span>

</div>

@endif



@push('scripts')

<script>

    // Job application modal is now handled in layouts/app.blade.php

    // This function is available globally from the layout

</script>

@endpush



@push('styles')

<style>

    .careers-slideshow {

        position: absolute;

        top: 0;

        left: 0;

        width: 100%;

        height: 100%;

        overflow: hidden;

    }

    

    .career-slide {

        position: absolute;

        top: 0;

        left: 0;

        width: 100%;

        height: 100%;

        background-size: cover;

        background-position: center;

        background-repeat: no-repeat;

        opacity: 0;

        transition: opacity 2.5s ease-in-out;

        z-index: 1;

    }

    

    .career-slide.active {

        opacity: 1;

        z-index: 2;

    }

    

    .career-indicator {

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

    

    .career-indicator:hover {

        border-color: rgba(255, 255, 255, 0.9);

        background-color: rgba(255, 255, 255, 0.5);

        transform: scale(1.1);

    }

    

    .career-indicator.active {

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

        

        function initCareersSlideshow() {

            const slides = document.querySelectorAll('.career-slide');

            const indicators = document.querySelectorAll('.career-indicator');

            

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

                slideInterval = setInterval(nextSlide, 7000);

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

            document.addEventListener('DOMContentLoaded', initCareersSlideshow);

        } else {

            initCareersSlideshow();

        }

    })();

</script>

@endpush

@endsection