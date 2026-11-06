@extends('layouts.app')

@section('title', 'Contact 9Associates | Premium Global Consulting Support')

@section('meta_description', \Illuminate\Support\Str::limit(
    strip_tags(($contactDetail->additional_info ?? '') . ' ' . ($contactDetail->address ?? '')) ,
    160
))

@section('content')

@php
    $phone1 = $contactDetail->phone ?? null;
    $phone2 = $contactDetail->phone_2 ?? null;
    $mobile = $contactDetail->mobile ?? null;
    $email  = $contactDetail->email ?? null;
    $address = $contactDetail->address ?? null;

    $clean = fn($n) => $n ? preg_replace('/[^0-9]/', '', $n) : null;
    $wa = $clean($mobile ?? $phone1 ?? $phone2);

    $mapQuery = $address ? urlencode($address) : '9Associates Office';

    // AI style prefilled message
    $waMessage = urlencode("Hello 9Associates, I would like to get consultation regarding your services.");
@endphp

<!-- BACKGROUND LAYER -->
<div class="fixed inset-0 -z-10 bg-gradient-to-br from-slate-50 via-white to-slate-100 dark:from-slate-950 dark:via-slate-900"></div>

<!-- HERO -->
<section class="max-w-6xl mx-auto px-4 pt-16 pb-10 text-center">
    <h1 class="text-5xl md:text-6xl font-black tracking-tight text-slate-900 dark:text-white">
        Contact
    </h1>
    <p class="mt-4 text-slate-500 dark:text-slate-400 max-w-2xl mx-auto">
        Premium consulting support — instantly connect with our experts
    </p>
</section>

<!-- MAIN GRID -->
<section class="max-w-7xl mx-auto px-4 pb-16">

    <div class="grid lg:grid-cols-3 gap-8">

        <!-- LEFT: CONTACT -->
        <div class="lg:col-span-2 space-y-6">

            <!-- CARD -->
            <div class="backdrop-blur-xl bg-white/70 dark:bg-slate-900/60 border border-white/20 rounded-3xl p-6 shadow-xl hover:shadow-2xl transition">

                <h2 class="text-xl font-bold mb-6 text-slate-900 dark:text-white">
                    Direct Contact
                </h2>

                <div class="space-y-5">

                    @foreach([$phone1, $phone2, $mobile] as $phone)
                        @if($phone)
                            @php $w = $clean($phone); @endphp

                            <div class="flex items-center justify-between group">

                                <a href="tel:{{ $phone }}"
                                   class="text-slate-700 dark:text-slate-300 group-hover:text-primary transition">
                                    {{ $phone }}
                                </a>

                                @if($w)
                                <a href="https://wa.me/{{ $w }}?text={{ $waMessage }}"
                                   target="_blank"
                                   class="flex items-center gap-2 text-[#25D366] font-medium">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="w-5 h-5"
                                         viewBox="0 0 32 32"
                                         fill="currentColor">
                                        <path d="M19.11 17.53c-.27-.14-1.6-.79-1.85-.88-.25-.09-.43-.14-.61.14-.18.27-.7.88-.86 1.06-.16.18-.32.2-.59.07-.27-.14-1.13-.42-2.15-1.34-.79-.7-1.32-1.56-1.48-1.83-.16-.27-.02-.42.12-.56.12-.12.27-.32.41-.48.14-.16.18-.27.27-.45.09-.18.05-.34-.02-.48-.07-.14-.61-1.47-.84-2.02-.22-.53-.44-.46-.61-.47h-.52c-.18 0-.48.07-.73.34-.25.27-.95.93-.95 2.27 0 1.34.98 2.64 1.12 2.82.14.18 1.93 2.95 4.68 4.14.65.28 1.16.45 1.56.57.65.21 1.24.18 1.71.11.52-.08 1.6-.65 1.82-1.28.23-.63.23-1.18.16-1.28-.07-.09-.25-.14-.52-.27z"/>
                                    </svg>

                                    WhatsApp
                                </a>
                                @endif

                            </div>
                        @endif
                    @endforeach

                </div>
            </div>

            <!-- EMAIL CARD -->
            <div class="backdrop-blur-xl bg-white/70 dark:bg-slate-900/60 border border-white/20 rounded-3xl p-6 shadow-xl">

                <h2 class="text-xl font-bold mb-3 text-slate-900 dark:text-white">
                    Email Support
                </h2>

                @if($email)
                <a href="mailto:{{ $email }}" class="text-primary hover:underline break-words">
                    {{ $email }}
                </a>
                @endif

            </div>

            <!-- ADDRESS CARD -->
            @if($address)
            <div class="backdrop-blur-xl bg-white/70 dark:bg-slate-900/60 border border-white/20 rounded-3xl p-6 shadow-xl">

                <h2 class="text-xl font-bold mb-3 text-slate-900 dark:text-white">
                    Office Location
                </h2>

                <p class="text-slate-600 dark:text-slate-400 whitespace-pre-line">
                    {{ $address }}
                </p>

            </div>
            @endif

        </div>

        <!-- RIGHT: MAP CARD -->
        <div class="backdrop-blur-xl bg-white/70 dark:bg-slate-900/60 border border-white/20 rounded-3xl overflow-hidden shadow-xl">

            <div class="p-5 border-b border-white/10">
                <h2 class="text-xl font-bold text-slate-900 dark:text-white">
                    Find Us
                </h2>
            </div>

            <div class="h-[520px]">
                <iframe
                    class="w-full h-full"
                    loading="lazy"
                    src="https://www.google.com/maps?q={{ $mapQuery }}&output=embed">
                </iframe>
            </div>

        </div>

    </div>

</section>

<!-- MOBILE BOTTOM BAR (PRO UX) -->
<div class="fixed bottom-0 left-0 right-0 lg:hidden z-50 bg-white/80 backdrop-blur border-t flex justify-around py-3">

    @if($phone1)
    <a href="tel:{{ $phone1 }}" class="text-slate-700 font-medium">Call</a>
    @endif

    @if($email)
    <a href="mailto:{{ $email }}" class="text-slate-700 font-medium">Email</a>
    @endif

    @if($wa)
    <a href="https://wa.me/{{ $wa }}?text={{ $waMessage }}" class="text-[#25D366] font-semibold">
        WhatsApp
    </a>
    @endif

</div>

<!-- PREMIUM FLOATING WHATSAPP -->
@if($wa)
<a href="https://wa.me/{{ $wa }}?text={{ $waMessage }}"
   target="_blank"
   class="fixed bottom-6 right-6 z-50 group">

    <div class="w-14 h-14 rounded-full bg-[#25D366] shadow-xl flex items-center justify-center
                hover:scale-110 transition">

        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-6 h-6 text-white"
             viewBox="0 0 32 32"
             fill="currentColor">
            <path d="M19.11 17.53c-.27-.14-1.6-.79-1.85-.88-.25-.09-.43-.14-.61.14-.18.27-.7.88-.86 1.06-.16.18-.32.2-.59.07-.27-.14-1.13-.42-2.15-1.34-.79-.7-1.32-1.56-1.48-1.83-.16-.27-.02-.42.12-.56.12-.12.27-.32.41-.48.14-.16.18-.27.27-.45.09-.18.05-.34-.02-.48-.07-.14-.61-1.47-.84-2.02-.22-.53-.44-.46-.61-.47h-.52c-.18 0-.48.07-.73.34-.25.27-.95.93-.95 2.27 0 1.34.98 2.64 1.12 2.82.14.18 1.93 2.95 4.68 4.14.65.28 1.16.45 1.56.57.65.21 1.24.18 1.71.11.52-.08 1.6-.65 1.82-1.28.23-.63.23-1.18.16-1.28-.07-.09-.25-.14-.52-.27z"/>
        </svg>

    </div>

</a>
@endif

@endsection