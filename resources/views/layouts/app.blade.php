<!DOCTYPE html>

<html class="light" lang="{{ $currentLocale ?? 'en' }}" dir="{{ ($currentLocale ?? 'en') === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="theme-color" content="#137fec">
    <meta http-equiv="x-ua-compatible" content="IE=edge">

    {{-- CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script>
        window.openContactModal = function (serviceType) {
            var value = String(serviceType || '');
            if (typeof window.showSiteContactModal === 'function') {
                window.showSiteContactModal(value);
                return;
            }
            window.__contactModalPending = value;
            document.addEventListener('DOMContentLoaded', function onReady() {
                document.removeEventListener('DOMContentLoaded', onReady);
                if (typeof window.showSiteContactModal === 'function') {
                    window.showSiteContactModal(window.__contactModalPending || '');
                    window.__contactModalPending = undefined;
                }
            });
        };
    </script>

    {{-- SEO: dynamic title + meta tags --}}
    <title>@yield('title', '9Associates | VAT Tax & Taxation Advisory Saudi Arabia | KSA, UAE & GCC')</title>

    <meta name="description"
        content="@yield('meta_description', 'Leading VAT tax and taxation advisory in Saudi Arabia (KSA), UAE and GCC. VAT compliance, corporate tax, ZATCA filing, tax consultant, accounting, audit and business setup.')">

    <meta name="keywords"
        content="@yield('meta_keywords', 'VAT tax Saudi Arabia, taxation Saudi Arabia, VAT KSA, tax advisory Saudi Arabia, ZATCA, corporate tax KSA, tax consultant Riyadh, VAT compliance, taxation services, 9Associates, UAE, GCC')">

    <meta name="author" content="@yield('meta_author', '9Associates')">

    {{-- Basic SEO / indexing --}}
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">
    <meta name="googlebot" content="@yield('meta_robots', 'index, follow')">

    {{-- Canonical URL --}}
    <link rel="canonical" href="@yield('canonical', url()->current())" />

    {{-- Open Graph (Facebook / LinkedIn) --}}
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title"
        content="@yield('og_title', trim(View::yieldContent('title')) ?: '9Associates | Tax, Payroll & Business Setup Advisory | UAE, KSA & GCC')">
    <meta property="og:description"
        content="@yield('og_description', trim(View::yieldContent('meta_description')) ?: 'Tax, payroll, business setup & company formation, VAT and corporate tax advisory for UAE, KSA, GCC and global businesses.')">
    <meta property="og:url" content="@yield('og_url', url()->current())">
    <meta property="og:site_name" content="9Associates">
    <meta property="og:image" content="@yield('og_image', asset('images/seo-default.jpg'))">
    <meta property="og:image:alt"
        content="@yield('og_image_alt', '9Associates — tax, payroll, and business setup advisory')">
    <meta property="og:locale"
        content="{{ ($currentLocale ?? 'en') === 'ar' ? 'ar_AR' : (($currentLocale ?? 'en') === 'fr' ? 'fr_FR' : 'en_US') }}">
    @php
        $__ogCurrent = ($currentLocale ?? 'en') === 'ar' ? 'ar_AR' : (($currentLocale ?? 'en') === 'fr' ? 'fr_FR' : 'en_US');
        $__ogAll = ['en_US', 'fr_FR', 'ar_AR'];
    @endphp
    @foreach($__ogAll as $__loc)
        @if($__loc !== $__ogCurrent)
            <meta property="og:locale:alternate" content="{{ $__loc }}">
        @endif
    @endforeach

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title"
        content="@yield('twitter_title', trim(View::yieldContent('og_title')) ?: '9Associates | Tax, Payroll & Business Setup Advisory | UAE, KSA & GCC')">
    <meta name="twitter:description"
        content="@yield('twitter_description', trim(View::yieldContent('og_description')) ?: 'Tax, payroll, business setup & company formation, VAT and corporate tax advisory for UAE, KSA, GCC and global businesses.')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/seo-default.jpg'))">
    <meta name="twitter:image:alt"
        content="@yield('twitter_image_alt', '9Associates — tax, payroll, and business setup advisory')">

    <link rel="sitemap" type="application/xml" title="Sitemap" href="{{ url('/sitemap.xml') }}">

    @stack('hreflang')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://unpkg.com">

    @if(request()->routeIs('home'))
        <link rel="preload" as="image" fetchpriority="high"
            href="{{ stock_img('photo-1497366216548-37526070297c') }}">
    @endif

    {{-- Favicon --}}
    <link rel="icon" type="image/jpeg" href="{{ url('/logo.jpeg') }}">
    <link rel="icon" type="image/jpeg" sizes="32x32" href="{{ url('/logo.jpeg') }}">
    <link rel="icon" type="image/jpeg" sizes="16x16" href="{{ url('/logo.jpeg') }}">
    <link rel="apple-touch-icon" href="{{ url('/logo.jpeg') }}">
    <link rel="shortcut icon" type="image/jpeg" href="{{ url('/logo.jpeg') }}">

    @php
        $schemaSocialLinks = array_values(array_filter([
            \App\Models\Setting::get('social_linkedin', ''),
            \App\Models\Setting::get('social_twitter', ''),
            \App\Models\Setting::get('social_facebook', ''),
        ]));
    @endphp
    <script type="application/ld+json">
        {!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    'name' => '9Associates',
    'url' => url('/'),
    'logo' => asset('logo-dark.png'),
    'sameAs' => $schemaSocialLinks,
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>

    <script type="application/ld+json">
        {!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'WebSite',
    'name' => '9Associates',
    'url' => url('/'),
    'potentialAction' => [
        '@type' => 'SearchAction',
        'target' => url('/insights') . '?q={search_term_string}',
        'query-input' => 'required name=search_term_string',
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>

    <script type="application/ld+json">
        {!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'ProfessionalService',
    'name' => '9Associates',
    'url' => url('/'),
    'image' => asset('logo-dark.png'),
    'description' => 'VAT tax and taxation advisory in Saudi Arabia (KSA), UAE and GCC. ZATCA VAT compliance, corporate tax, payroll, business setup, audit and accounting.',
    'areaServed' => [
        ['@type' => 'Country', 'name' => 'Saudi Arabia'],
        ['@type' => 'Place', 'name' => 'United Arab Emirates'],
        ['@type' => 'Place', 'name' => 'Gulf Cooperation Council'],
        ['@type' => 'Place', 'name' => 'Worldwide'],
    ],
    'knowsAbout' => [
        'Taxation',
        'Tax advisory',
        'VAT',
        'Corporate tax',
        'Tax compliance',
        'Payroll',
        'Payroll outsourcing',
        'Business setup',
        'Company formation',
        'Accounting',
        'Audit',
        'Financial consulting',
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>

    <script type="application/ld+json">
        {!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'ItemList',
    'name' => '9Associates advisory focus areas',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Taxation and tax advisory'],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'VAT and corporate tax compliance'],
        ['@type' => 'ListItem', 'position' => 3, 'name' => 'Payroll and HR compliance'],
        ['@type' => 'ListItem', 'position' => 4, 'name' => 'Business setup and company formation'],
        ['@type' => 'ListItem', 'position' => 5, 'name' => 'Accounting and audit'],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>

    @stack('structured_data')

    {{--
    === SEO implemented in this layout (steps done in code) ===
    1. Default title, meta description, keywords (override per page with @section).
    2. Canonical, robots, Open Graph, Twitter Card, theme-color.
    3. JSON-LD: Organization, WebSite (SearchAction), ProfessionalService, ItemList (focus areas).
    4. Sitemap link rel (ensure public/sitemap.xml or route exists on server).
    5. Stacks: @stack('hreflang') for language alternates; @stack('structured_data') for extra JSON-LD per page.

    Remaining steps (cannot be “only layout” — do in app + marketing):
    - Publish sitemap.xml and submit in Google Search Console; verify property.
    - Each important page: unique @section('title'), @section('meta_description'), strong H1 + body copy.
    - Ongoing content (Insights/blog), backlinks, GBP if local office, performance (Core Web Vitals).
    --}}

    {{-- Tailwind CDN is convenient but heavy on mobile PSI; for production use npm build + purged CSS. --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script defer src="https://unpkg.com/alpinejs@3.14.3/dist/cdn.min.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400..800;1,9..144,400..700&family=Manrope:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#137fec",
                        "background-light": "#f6f7f8",
                        "background-dark": "#101922",
                        "navy-deep": "#0d141b",
                        "slate-muted": "#4c739a"
                    },
                    fontFamily: {
                        "display": ["Fraunces", "Georgia", "serif"],
                        "sans": ["Manrope", "system-ui", "sans-serif"],
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>

    <style>
        html,
        body {
            width: 100%;
            max-width: 100%;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html {
            overflow-x: clip;
        }

        body {
            font-family: 'Manrope', sans-serif;
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
            overflow-x: clip;
            max-width: 100vw;
        }

        main.main-premium {
            overflow-x: clip;
        }

        img,
        svg,
        video,
        canvas,
        iframe {
            max-width: 100%;
            height: auto;
        }

        .ai-bot-logo-img {
            max-width: none !important;
            height: auto;
            object-fit: contain;
            background: transparent !important;
            border: none;
            box-shadow: none;
            display: block;
        }

        .ai-bot-logo-wrap {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: transparent !important;
            border: none;
            box-shadow: none;
            padding: 0;
        }

        .ai-chat-avatar .ai-bot-logo-img {
            width: 2rem;
            height: 2rem;
            filter: drop-shadow(0 2px 4px rgba(15, 23, 42, 0.12));
        }

        /* Mobile rendering safeguards for long strings and inline content */
        p,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        a,
        span,
        li {
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        .container,
        .max-w-\[1280px\],
        .max-w-\[1320px\] {
            width: min(100%, 100vw);
        }

        /* Global form polish */
        .form-shell-elevated label {
            font-size: 0.85rem;
            letter-spacing: 0.03em;
        }

        .form-shell-elevated input[type="text"],
        .form-shell-elevated input[type="email"],
        .form-shell-elevated input[type="tel"],
        .form-shell-elevated input[type="file"],
        .form-shell-elevated select,
        .form-shell-elevated textarea {
            border-radius: 0.75rem;
            border-color: rgba(148, 163, 184, 0.55);
            background: rgba(255, 255, 255, 0.96);
            transition: border-color 160ms ease, box-shadow 160ms ease, background 160ms ease, transform 120ms ease;
        }

        .dark .form-shell-elevated input[type="text"],
        .dark .form-shell-elevated input[type="email"],
        .dark .form-shell-elevated input[type="tel"],
        .dark .form-shell-elevated input[type="file"],
        .dark .form-shell-elevated select,
        .dark .form-shell-elevated textarea {
            background: rgba(15, 23, 42, 0.98);
            border-color: rgba(51, 65, 85, 0.9);
        }

        .form-shell-elevated input:focus,
        .form-shell-elevated select:focus,
        .form-shell-elevated textarea:focus {
            outline: none;
            border-color: rgba(19, 127, 236, 0.95);
            box-shadow: 0 0 0 1px rgba(19, 127, 236, 0.78), 0 14px 30px -18px rgba(15, 23, 42, 0.8);
            transform: translateY(-0.5px);
        }

        .form-shell-elevated textarea {
            border-radius: 1rem;
        }

        .form-shell-elevated .field-error,
        .form-shell-elevated [id$="_error"] {
            font-size: 0.78rem;
            margin-top: 0.15rem;
        }

        .form-shell-elevated .primary-action {
            border-radius: 999px;
        }

        /* Prevent horizontal overflow on all site forms and modals */
        form,
        .form-shell-elevated,
        .site-form,
        #contact-page-form {
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
            overflow-x: hidden;
        }

        #ai-chat-form,
        #ai-chat-messages {
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
            overflow-x: hidden;
        }

        .site-form input:not([type="checkbox"]):not([type="radio"]):not([type="file"]),
        .site-form select,
        .site-form textarea,
        .form-shell-elevated input:not([type="checkbox"]):not([type="radio"]):not([type="file"]),
        .form-shell-elevated select,
        .form-shell-elevated textarea,
        #contact-page-form input:not([type="checkbox"]):not([type="radio"]),
        #contact-page-form select,
        #contact-page-form textarea,
        #ai-chat-input {
            width: 100%;
            max-width: 100%;
            min-width: 0;
            box-sizing: border-box;
        }

        .form-shell-elevated .grid,
        .form-shell-elevated .flex,
        #contact-page-form .grid {
            min-width: 0;
            max-width: 100%;
        }

        /* Site contact modal — responsive on all screens */
        #site-contact-modal {
            position: fixed;
            inset: 0;
            z-index: 100060;
            display: none;
            align-items: center;
            justify-content: center;
            padding: max(0.75rem, env(safe-area-inset-top)) max(0.75rem, env(safe-area-inset-right)) max(0.75rem, env(safe-area-inset-bottom)) max(0.75rem, env(safe-area-inset-left));
            overflow: hidden;
            overscroll-behavior: contain;
        }

        #site-contact-modal:not(.hidden) {
            display: flex;
        }

        #site-contact-modal > .absolute.inset-0,
        #site-contact-modal [data-close-contact-modal].absolute {
            position: absolute;
            inset: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
        }

        #site-contact-modal .site-contact-modal__panel,
        #site-contact-modal > .relative.z-10 {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: min(900px, 100%);
            max-height: min(95vh, 100%);
            min-height: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border-radius: 1rem;
            background: #fff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35);
        }

        .dark #site-contact-modal .site-contact-modal__panel,
        .dark #site-contact-modal > .relative.z-10 {
            background: #0f172a;
            border-color: #334155;
        }

        #site-contact-modal-form {
            width: 100%;
            max-width: 100%;
            min-width: 0;
            box-sizing: border-box;
        }

        #site-contact-modal-form input,
        #site-contact-modal-form select,
        #site-contact-modal-form textarea {
            width: 100%;
            max-width: 100%;
            min-width: 0;
            box-sizing: border-box;
            font-size: 16px;
        }

        #site-contact-modal-form .modal-file-row {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            width: 100%;
            min-width: 0;
        }

        @media (min-width: 640px) {
            #site-contact-modal {
                padding: 1.5rem;
            }

            #site-contact-modal .site-contact-modal__panel,
            #site-contact-modal > .relative.z-10 {
                border-radius: 1.5rem;
            }

            #site-contact-modal-form .modal-file-row {
                flex-direction: row;
                align-items: center;
                flex-wrap: wrap;
            }
        }

        .flex,
        .grid,
        .form-shell-elevated,
        .site-form {
            min-width: 0;
        }

        .flex>*,
        .grid>* {
            min-width: 0;
        }

        .grid>*,
        .grid-cols-1>*,
        .grid-cols-2>* {
            min-width: 0;
        }

        /* 9A Assistant — pinned bottom-right, never scrolls with page */
        #ai-chatbot-widget.ai-chatbot-fixed {
            position: fixed !important;
            bottom: max(1.25rem, env(safe-area-inset-bottom, 0px)) !important;
            right: max(1.25rem, env(safe-area-inset-right, 0px)) !important;
            top: auto !important;
            left: auto !important;
            z-index: 2147483000 !important;
            display: flex !important;
            flex-direction: column;
            align-items: flex-end;
            justify-content: flex-end;
            gap: 0.75rem;
            pointer-events: none;
            margin: 0 !important;
            padding: 0 !important;
            transform: none !important;
            translate: none !important;
            width: auto !important;
            max-width: none !important;
            min-width: 0 !important;
            flex: none !important;
            isolation: isolate;
        }

        .ai-assistant-icon-wrap {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        .ai-assistant-icon-symbol {
            font-size: 1.5rem;
            line-height: 1;
            color: #fff;
        }

        .ai-assistant-logo-img {
            width: 72%;
            height: 72%;
            object-fit: contain;
            display: block;
        }

        .ai-chat-avatar .ai-assistant-icon-wrap,
        span.ai-assistant-icon-wrap.ai-chat-avatar {
            width: 2rem;
            height: 2rem;
            border-radius: 999px;
            background: linear-gradient(135deg, #0d141b, #1e293b);
        }

        .ai-chat-avatar .ai-assistant-icon-symbol {
            font-size: 1.1rem;
        }

        .ai-chat-suggestions {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            padding: 0 0.25rem 0.5rem;
        }

        .ai-chat-suggestion {
            display: block;
            width: 100%;
            text-align: left;
            padding: 0.55rem 0.75rem;
            border-radius: 0.75rem;
            border: 1px solid rgba(19, 127, 236, 0.22);
            background: #fff;
            color: #0f172a;
            font-size: 0.78rem;
            line-height: 1.35;
            cursor: pointer;
            transition: background 0.15s ease, border-color 0.15s ease;
        }

        .ai-chat-suggestion:hover {
            background: rgba(19, 127, 236, 0.08);
            border-color: rgba(19, 127, 236, 0.45);
        }

        .dark .ai-chat-suggestion {
            background: #0f172a;
            color: #e2e8f0;
            border-color: rgba(96, 165, 250, 0.25);
        }

        #ai-chatbot-widget .ai-chatbot-toggle {
            pointer-events: auto;
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            min-height: 3.25rem;
            padding: 0.35rem 0.35rem 0.35rem 0.35rem;
            padding-right: 1rem;
            border-radius: 999px;
            background: linear-gradient(135deg, #0d141b 0%, #1e293b 100%) !important;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.12);
            cursor: pointer;
            flex-shrink: 0;
            box-shadow: 0 14px 30px -10px rgba(2, 6, 23, 0.6), 0 4px 12px rgba(15, 23, 42, 0.18);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            overflow: visible;
        }

        #ai-chatbot-widget .ai-chatbot-toggle-icon-wrap {
            width: 2.75rem;
            height: 2.75rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.16);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        #ai-chatbot-widget .ai-chatbot-toggle-icon-wrap .ai-assistant-icon-symbol {
            font-size: 1.45rem;
        }

        #ai-chatbot-widget .ai-chatbot-toggle-label {
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            white-space: nowrap;
            color: #fff;
            line-height: 1.1;
        }

        #ai-chatbot-widget .ai-chatbot-toggle::before {
            display: none;
        }

        #ai-chatbot-widget .ai-chatbot-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 32px -10px rgba(19, 127, 236, 0.6), 0 6px 16px rgba(15, 23, 42, 0.14);
        }

        #ai-chatbot-widget .ai-chatbot-toggle:active {
            transform: translateY(0) scale(0.98);
        }

        @media (max-width: 480px) {
            #ai-chatbot-widget .ai-chatbot-toggle-label {
                display: none;
            }

            #ai-chatbot-widget .ai-chatbot-toggle {
                padding: 0;
                width: 3.25rem;
                height: 3.25rem;
                justify-content: center;
            }
        }

        #ai-chatbot-widget .ai-chatbot-toggle.is-open {
            padding: 0;
            width: 3.25rem;
            height: 3.25rem;
            justify-content: center;
            border-radius: 999px;
        }

        #ai-chatbot-widget .ai-chatbot-toggle-badge {
            position: absolute;
            top: 0.15rem;
            right: 0.15rem;
            width: 0.65rem;
            height: 0.65rem;
            border-radius: 9999px;
            background: #22c55e;
            border: 2px solid #fff;
            box-shadow: 0 0 0 1px rgba(19, 127, 236, 0.35);
        }

        @keyframes ai-chatbot-ring {
            0% {
                transform: scale(1);
                opacity: 0.55;
            }

            70% {
                transform: scale(1.22);
                opacity: 0;
            }

            100% {
                transform: scale(1.22);
                opacity: 0;
            }
        }

        @media (min-width: 640px) {
            #ai-chatbot-widget .ai-chatbot-toggle-icon {
                width: 3.35rem;
                height: 3.35rem;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            #ai-chatbot-widget .ai-chatbot-toggle::before {
                animation: none;
            }

            #ai-chatbot-widget .ai-chatbot-toggle {
                transition: none;
            }
        }

        #ai-chatbot-widget .ai-chat-window {
            pointer-events: auto;
            display: none;
            flex-direction: column;
            position: fixed;
            right: max(1.25rem, env(safe-area-inset-right, 0px));
            top: calc(var(--site-header-offset, 7.5rem) + 0.75rem);
            left: auto;
            bottom: auto;
            width: min(360px, calc(100vw - 2rem));
            max-width: min(360px, calc(100vw - 2rem));
            height: min(480px, calc(100vh - var(--site-header-offset, 7.5rem) - 2.5rem));
            max-height: calc(100vh - var(--site-header-offset, 7.5rem) - 2.5rem);
            border-radius: 1rem;
            overflow: hidden;
            box-sizing: border-box;
            background: #fff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35);
            opacity: 0;
            transform: translateY(-8px) scale(0.96);
            transform-origin: top right;
            transition: opacity 0.25s ease, transform 0.25s ease;
            z-index: 2147483001;
        }

        .dark #ai-chatbot-widget .ai-chat-window {
            background: #0f172a;
            border-color: #334155;
        }

        #ai-chatbot-widget .ai-chat-window.is-open {
            display: flex !important;
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: auto !important;
        }

        body.ai-chat-open {
            overflow: hidden;
        }

        #ai-chat-messages {
            overscroll-behavior: contain;
        }

        #ai-chat-messages .break-words {
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        a,
        button {
            transition: all 180ms ease;
        }

        ::selection {
            background: rgba(19, 127, 236, 0.18);
            color: #0d141b;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-4 {
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Subtle page background texture for agency feel */
        .app-shell-gradient {
            background-image:
                radial-gradient(circle at 0% 0%, rgba(19, 127, 236, 0.10), transparent 55%),
                radial-gradient(circle at 100% 100%, rgba(148, 163, 184, 0.18), transparent 55%);
        }

        /* Desktop nav underline hover */
        .nav-link {
            position: relative;
        }

        .nav-link::after {
            content: "";
            position: absolute;
            inset-inline-start: 0;
            bottom: -0.35rem;
            width: 0;
            height: 2px;
            border-radius: 999px;
            background: linear-gradient(90deg, #137fec, #4f46e5);
            transition: width 160ms ease-out;
        }

        .nav-link:hover::after,
        .nav-link.nav-link-active::after {
            width: 100%;
        }

        .site-fixed-chrome {
            position: fixed !important;
            inset: 0 0 auto 0 !important;
            width: 100vw !important;
            max-width: 100vw !important;
            z-index: 1000000 !important;
            transform: none !important;
            translate: none !important;
            margin: 0 !important;
            padding: 0 !important;
            display: block !important;
            overflow: visible !important;
            isolation: isolate;
            pointer-events: auto;
            backface-visibility: hidden;
        }

        html,
        body {
            transform: none !important;
        }

        .premium-header {
            position: relative !important;
            top: auto !important;
            left: auto;
            right: auto;
            width: 100%;
            z-index: 3;
            margin-top: 0 !important;
            padding-top: 0 !important;
            background: #ffffff !important;
            box-shadow: none;
            border-bottom: none !important;
            transition: background 0.35s ease, box-shadow 0.35s ease;
            transform: none !important;
            will-change: auto;
            isolation: isolate;
        }

        /* Luxury split navigation */
        .luxury-header-inner {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            gap: 1rem;
            max-width: 1680px;
            margin: 0 auto;
            padding: 0.85rem 1.25rem;
        }

        @media (min-width: 1280px) {
            .luxury-header-inner {
                padding: 1rem 2.5rem;
            }
        }

        .luxury-nav-left,
        .luxury-nav-right {
            display: none;
            align-items: center;
            gap: clamp(1rem, 2vw, 2.25rem);
        }

        @media (min-width: 1280px) {
            .luxury-nav-left,
            .luxury-nav-right {
                display: flex;
            }
        }

        .luxury-nav-left {
            justify-self: start;
        }

        .luxury-nav-right {
            justify-self: end;
        }

        .luxury-logo-center {
            justify-self: center;
            display: none;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 2;
        }

        .luxury-nav-link {
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.16em;
            line-height: 1;
            text-transform: uppercase;
            white-space: nowrap;
            color: #0f172a;
            text-decoration: none;
            transition: color 0.25s ease;
            position: relative;
            padding-bottom: 0;
        }
        .luxury-nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            right: 0;
            height: 2px;
            background: #137fec;
            border-radius: 999px;
            transform: scaleX(0);
            transform-origin: left center;
            transition: transform 0.32s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .luxury-nav-link:hover::after,
        .luxury-nav-link.luxury-nav-active::after {
            transform: scaleX(1);
        }

        .luxury-nav-link:hover,
        .luxury-nav-link.luxury-nav-active {
            color: #137fec;
            opacity: 1;
        }

        .luxury-nav-item {
            position: relative;
        }

        .luxury-nav-ai {
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 0;
        }

        .luxury-nav-ai-icon {
            font-size: 1.05rem;
            line-height: 1;
        }

        .luxury-nav-item .luxury-nav-caret {
            font-size: 1rem;
            line-height: 1;
            opacity: 0.7;
            transition: transform 0.2s ease;
        }

        .luxury-nav-item:hover .luxury-nav-caret {
            transform: rotate(180deg);
        }

        .luxury-dropdown {
            position: absolute;
            top: calc(100% + 0.9rem);
            left: 50%;
            transform: translateX(-50%) translateY(10px);
            min-width: 240px;
            padding: 0.5rem;
            background: #fff;
            border-radius: 0.875rem;
            border: 1px solid rgba(15, 23, 42, 0.07);
            box-shadow: 0 24px 64px -24px rgba(15, 23, 42, 0.22), 0 4px 20px rgba(15,23,42,0.08);
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity 0.22s ease, transform 0.28s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.22s ease;
            z-index: 1000002;
        }

        .luxury-nav-item:hover .luxury-dropdown,
        .luxury-nav-item:focus-within .luxury-dropdown {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
            transform: translateX(-50%) translateY(0);
        }

        .luxury-dropdown a {
            display: block;
            padding: 0.6rem 0.875rem;
            font-size: 0.74rem;
            font-weight: 600;
            letter-spacing: 0.03em;
            text-transform: none;
            color: #334155;
            text-decoration: none;
            border-radius: 0.5rem;
            transition: background 0.18s ease, color 0.18s ease, padding-left 0.22s ease;
        }

        .luxury-dropdown a:hover,
        .luxury-dropdown a.luxury-dropdown-active {
            background: rgba(19, 127, 236, 0.08);
            color: #137fec;
            padding-left: 1.15rem;
        }

        .luxury-mobile-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            grid-column: 1 / -1;
        }

        .luxury-mobile-menu {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            z-index: 1000002;
            max-height: calc(100vh - var(--topbar-height) - var(--header-height));
            max-height: calc(100svh - var(--topbar-height) - var(--header-height));
            overflow-y: auto;
            overscroll-behavior: contain;
            box-shadow: 0 18px 40px -28px rgba(15, 23, 42, 0.42);
        }

        @media (min-width: 1280px) {
            .luxury-mobile-bar {
                display: none;
            }

            .luxury-logo-center {
                display: flex;
                grid-column: auto;
            }
        }

        .logo-premium {
            height: 2.75rem;
            width: auto;
            object-fit: contain;
        }

        @media (min-width: 768px) {
            .logo-premium {
                height: 3.25rem;
            }
        }

        .logo-premium.logo-dark {
            display: none;
        }

        .premium-header .logo-light {
            display: block;
        }

        .premium-header .logo-dark {
            display: none;
        }

        body:not(.is-home) .premium-header .logo-light {
            display: none;
        }

        body:not(.is-home) .premium-header .logo-dark {
            display: block;
        }

        body.is-home .premium-header .logo-light {
            display: block !important;
        }

        body.is-home .premium-header .logo-dark {
            display: none !important;
        }

        body.is-home .premium-header.header-scrolled .logo-light {
            display: none !important;
        }

        body.is-home .premium-header.header-scrolled .logo-dark {
            display: block !important;
        }

        .luxury-announcement-bar,
        .top-services-ticker {
            background: linear-gradient(180deg, #0d141b 0%, #16222e 100%);
            border-bottom: 1px solid rgba(56, 189, 248, 0.12);
            box-shadow: inset 0 1px 0 rgba(56, 189, 248, 0.18);
        }

        .top-services-inner {
            height: 100%;
            overflow: hidden;
            -webkit-mask-image: linear-gradient(90deg, transparent 0%, #000 6%, #000 94%, transparent 100%);
            mask-image: linear-gradient(90deg, transparent 0%, #000 6%, #000 94%, transparent 100%);
        }

        .top-services-track {
            display: flex;
            align-items: center;
            gap: 1rem;
            white-space: nowrap;
            height: var(--topbar-height);
            padding: 0 1rem;
            width: max-content;
            animation: topServicesMarquee 38s linear infinite;
            will-change: transform;
        }

        .top-services-ticker:hover .top-services-track {
            animation-play-state: paused;
        }

        .top-services-item {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            color: rgba(226, 232, 240, 0.95);
            font-size: 0.68rem;
            line-height: 1;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            font-weight: 600;
            white-space: nowrap;
            padding: 0.28rem 0.72rem;
            border-radius: 999px;
            border: 1px solid rgba(56, 189, 248, 0.28);
            background: rgba(255, 255, 255, 0.04);
            flex-shrink: 0;
        }

        .top-services-dot {
            width: 6px;
            height: 6px;
            border-radius: 999px;
            background: #1ea0ff;
            box-shadow: 0 0 0 3px rgba(30, 160, 255, 0.16);
            flex-shrink: 0;
            animation: tickerDotPulse 2.2s ease-in-out infinite;
        }

        @keyframes tickerDotPulse {
            0%, 100% {
                transform: scale(1);
                opacity: 0.95;
            }
            50% {
                transform: scale(1.15);
                opacity: 1;
            }
        }

        @keyframes topServicesMarquee {
            0% {
                transform: translate3d(0, 0, 0);
            }
            100% {
                transform: translate3d(calc(-1 * var(--top-services-distance, 50%)), 0, 0);
            }
        }

        /* Home: transparent header over video hero */
        body.is-home {
            padding-top: 0 !important;
        }

        body.is-home .premium-header {
            background: transparent !important;
            border-bottom: none !important;
            box-shadow: none !important;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
            transition: background 0.35s ease, box-shadow 0.35s ease, border-color 0.35s ease;
        }

        body.is-home .premium-header .luxury-nav-link {
            color: rgba(255, 255, 255, 0.95);
            transition: color 0.35s ease;
        }

        body.is-home .premium-header .luxury-nav-link:hover,
        body.is-home .premium-header .luxury-nav-link.luxury-nav-active {
            color: #fff;
        }

        body.is-home .premium-header.header-scrolled {
            background: #faf9f7 !important;
            border-bottom: 1px solid rgba(15, 23, 42, 0.08) !important;
            box-shadow: 0 1px 0 rgba(15, 23, 42, 0.04) !important;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }

        .dark body.is-home .premium-header.header-scrolled {
            background: #faf9f7 !important;
        }

        body.is-home .premium-header.header-scrolled .luxury-nav-link {
            color: #0f172a;
        }

        body.is-home .premium-header.header-scrolled .luxury-nav-link:hover,
        body.is-home .premium-header.header-scrolled .luxury-nav-link.luxury-nav-active {
            color: #137fec;
        }

        body.is-home .premium-header.header-scrolled .luxury-lang-btn {
            color: #0f172a;
        }

        body.is-home .premium-header.header-scrolled .luxury-mobile-bar .luxury-lang-btn,
        body.is-home .premium-header.header-scrolled .luxury-mobile-bar button[type="button"] {
            color: #0f172a;
            border-color: rgba(15, 23, 42, 0.12);
            background: rgba(255, 255, 255, 0.92);
        }

        body.is-home .premium-header.header-scrolled .luxury-mobile-bar .material-symbols-outlined {
            color: #0f172a;
        }

        body.is-home .premium-header .luxury-lang-btn {
            color: #fff;
        }

        body.is-home .premium-header .luxury-mobile-bar .luxury-lang-btn,
        body.is-home .premium-header .luxury-mobile-bar button[type="button"] {
            color: #fff;
            border-color: rgba(255, 255, 255, 0.28);
            background: rgba(255, 255, 255, 0.08);
        }

        body.is-home .premium-header .luxury-mobile-bar .material-symbols-outlined {
            color: #fff;
        }

        /* Full-screen video hero */
        .home-hero-video {
            position: relative;
            background: #0b1220;
            min-height: 100vh;
            min-height: 100svh;
            width: 100vw;
            max-width: 100vw;
            margin-left: calc(50% - 50vw);
            margin-right: calc(50% - 50vw);
            display: flex;
            align-items: flex-end;
            overflow: hidden;
        }

        .home-hero-video__media {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .home-hero-video__overlay {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(180deg, rgba(0, 0, 0, 0.35) 0%, rgba(0, 0, 0, 0.08) 38%, rgba(0, 0, 0, 0.55) 100%);
            pointer-events: none;
        }

        .home-hero-video__content {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 1680px;
            margin: 0 auto;
            padding: calc(var(--topbar-height) + var(--header-height) + 2rem) 1.5rem 4rem;
        }

        @media (min-width: 768px) {
            .home-hero-video__content {
                padding: calc(var(--topbar-height) + var(--header-height) + 3rem) 3rem 6rem;
            }
        }

        .home-hero-video__title {
            font-family: 'Fraunces', Georgia, serif;
            font-size: clamp(2.85rem, 7.5vw, 6.5rem);
            font-weight: 700;
            line-height: 1.02;
            letter-spacing: -0.03em;
            color: #fff;
            max-width: 14ch;
            text-shadow: 0 4px 48px rgba(0,0,0,0.28), 0 1px 6px rgba(0,0,0,0.18);
        }

        .home-hero-video__subtitle {
            margin-top: 1.5rem;
            max-width: 34rem;
            color: rgba(255, 255, 255, 0.74);
            font-size: clamp(1rem, 1.5vw, 1.15rem);
            line-height: 1.75;
            font-weight: 400;
            letter-spacing: 0.01em;
        }

        .is-home .home-hero-video {
            border-radius: 0 !important;
            box-shadow: none !important;
        }

        .dark .premium-header {
            background: #101922 !important;
            box-shadow: none;
            border-bottom: none !important;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }

        :root {
            --topbar-height: 44px;
            --header-height: 72px;
        }

        /* Always reserve space for the fixed top ticker + header (non-home pages). */
        body:not(.is-home) {
            padding-top: calc(var(--topbar-height) + var(--header-height)) !important;
        }

        body.has-top-services:not(.is-home) {
            padding-top: var(--chrome-height, calc(var(--topbar-height) + var(--header-height))) !important;
        }

        html {
            scroll-padding-top: var(--chrome-height, calc(var(--topbar-height) + var(--header-height)));
        }

        /* Top Services Marquee Bar */
        .top-services-ticker {
            position: relative !important;
            top: auto !important;
            left: auto;
            right: auto;
            z-index: 2;
            overflow: hidden;
            height: var(--topbar-height);
            display: block;
            flex-shrink: 0;
        }

        /* Home growth chart (Why Choose section) */
        .home-growth-chart__bars {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 0.5rem;
            height: 200px;
            padding-top: 0.5rem;
        }

        .home-growth-chart__col {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
            gap: 0.45rem;
            flex: 1;
            height: 100%;
            min-width: 0;
        }

        .home-growth-chart__bar {
            width: 100%;
            max-width: 26px;
            height: var(--bar-h, 40%);
            border-radius: 6px 6px 2px 2px;
            background: linear-gradient(180deg, #4ea3ff 0%, #137fec 55%, #0c5cbb 100%);
            box-shadow: 0 6px 18px -6px rgba(19, 127, 236, 0.55);
            transform: scaleY(0);
            transform-origin: bottom;
            transition: transform 700ms cubic-bezier(0.22, 0.9, 0.3, 1);
            transition-delay: var(--bar-delay, 0ms);
        }

        .home-growth-chart.chart-visible .home-growth-chart__bar {
            transform: scaleY(1);
        }

        .home-growth-chart__year {
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            color: rgba(148, 163, 184, 0.85);
            white-space: nowrap;
        }

        @media (max-width: 480px) {
            .home-growth-chart__bars {
                height: 150px;
                gap: 0.3rem;
            }

            .home-growth-chart__col:nth-child(odd) .home-growth-chart__year {
                visibility: hidden;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .home-growth-chart__bar {
                transform: scaleY(1);
                transition: none;
            }
        }

        /* Home Stats Table (Animated) */
        .home-stats-table-wrap {
            position: relative;
            transform: translateY(16px);
            opacity: 0;
            transition: opacity 700ms ease, transform 700ms ease;
        }

        .home-stats-table-wrap::before {
            content: "";
            position: absolute;
            inset: -24px;
            border-radius: 2rem;
            background:
                radial-gradient(circle at 15% 20%, rgba(19, 127, 236, 0.12), transparent 35%),
                radial-gradient(circle at 85% 80%, rgba(79, 70, 229, 0.12), transparent 38%);
            filter: blur(22px);
            z-index: 0;
            pointer-events: none;
        }

        .home-stats-table-wrap.visible {
            transform: translateY(0);
            opacity: 1;
        }

        .home-stats-table {
            position: relative;
            z-index: 1;
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0.94) 0%, rgba(248, 250, 252, 0.84) 100%);
            border: 1px solid rgba(19, 127, 236, 0.14);
            box-shadow:
                0 35px 90px -58px rgba(15, 23, 42, 0.42),
                0 0 0 1px rgba(255, 255, 255, 0.5) inset;
            border-radius: 1.5rem;
            overflow: hidden;
            backdrop-filter: blur(14px) saturate(1.06);
            -webkit-backdrop-filter: blur(14px) saturate(1.06);
        }

        .dark .home-stats-table {
            background:
                linear-gradient(180deg, rgba(15, 23, 42, 0.84) 0%, rgba(2, 6, 23, 0.74) 100%);
            border: 1px solid rgba(96, 165, 250, 0.2);
            box-shadow:
                0 35px 90px -58px rgba(0, 0, 0, 0.82),
                0 0 0 1px rgba(148, 163, 184, 0.08) inset;
        }

        .home-stats-head td {
            padding: 1rem 1.25rem 0.9rem;
            background: linear-gradient(90deg, rgba(19, 127, 236, 0.08), rgba(79, 70, 229, 0.08));
            border-bottom: 1px solid rgba(148, 163, 184, 0.14);
        }

        .dark .home-stats-head td {
            background: linear-gradient(90deg, rgba(19, 127, 236, 0.13), rgba(79, 70, 229, 0.12));
            border-bottom-color: rgba(148, 163, 184, 0.1);
        }

        .home-stats-kicker {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.45rem 0.8rem;
            border-radius: 999px;
            border: 1px solid rgba(19, 127, 236, 0.16);
            background: rgba(255, 255, 255, 0.6);
            color: #0f172a;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        .dark .home-stats-kicker {
            background: rgba(15, 23, 42, 0.52);
            color: rgba(226, 232, 240, 0.95);
            border-color: rgba(96, 165, 250, 0.18);
        }

        .home-stats-kicker-dot {
            width: 0.45rem;
            height: 0.45rem;
            border-radius: 999px;
            background: linear-gradient(135deg, #137fec 0%, #4f46e5 100%);
            box-shadow: 0 0 0 4px rgba(19, 127, 236, 0.12);
        }

        .home-stats-row {
            transition: transform 240ms cubic-bezier(.2, .9, .2, 1), background-color 240ms ease;
        }

        .home-stats-row+.home-stats-row td {
            border-top: 1px solid rgba(148, 163, 184, 0.14);
        }

        .home-stats-row:hover {
            transform: translateY(-1px);
            background: rgba(19, 127, 236, 0.03);
        }

        .dark .home-stats-row:hover {
            background: rgba(96, 165, 250, 0.05);
        }

        .home-stats-table td {
            padding: 1.2rem 1.25rem;
            vertical-align: middle;
        }

        .home-stats-label {
            color: #0f172a;
            font-weight: 800;
            letter-spacing: -0.015em;
            font-size: 1rem;
        }

        .dark .home-stats-label {
            color: rgba(241, 245, 249, 0.95);
        }

        .home-stats-note {
            display: block;
            margin-top: 0.28rem;
            color: rgba(100, 116, 139, 0.92);
            font-weight: 600;
            font-size: 0.84rem;
        }

        .dark .home-stats-note {
            color: rgba(148, 163, 184, 0.92);
        }

        .home-stats-value {
            font-weight: 900;
            font-size: clamp(1.8rem, 3vw, 2.4rem);
            letter-spacing: -0.03em;
            background: linear-gradient(135deg, #137fec 0%, #4f46e5 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-shadow: 0 10px 28px rgba(19, 127, 236, 0.08);
        }

        .home-stats-meta {
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(100, 116, 139, 0.88);
        }

        .dark .home-stats-meta {
            color: rgba(148, 163, 184, 0.86);
        }

        /* Overall premium motion */
        .premium-reveal {
            opacity: 0;
            transform: translate3d(0, 26px, 0) scale(0.985);
            transition:
                opacity 760ms cubic-bezier(0.16, 1, 0.3, 1),
                transform 760ms cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }

        .premium-reveal.is-visible {
            opacity: 1;
            transform: translate3d(0, 0, 0) scale(1);
        }

        .premium-lift {
            transition:
                transform 260ms cubic-bezier(0.16, 1, 0.3, 1),
                box-shadow 260ms cubic-bezier(0.16, 1, 0.3, 1),
                filter 260ms cubic-bezier(0.16, 1, 0.3, 1);
            will-change: transform;
        }

        .premium-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 42px -24px rgba(15, 23, 42, 0.28);
        }

        .section-sheen {
            position: relative;
            overflow: hidden;
        }

        .section-sheen::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, transparent 38%, rgba(255, 255, 255, 0.18) 50%, transparent 62%);
            transform: translateX(-130%);
            transition: transform 820ms cubic-bezier(0.16, 1, 0.3, 1);
            pointer-events: none;
        }

        .section-sheen:hover::after {
            transform: translateX(130%);
        }

        @media (prefers-reduced-motion: reduce) {

            .premium-reveal,
            .premium-lift,
            .section-sheen::after {
                transition: none !important;
                animation: none !important;
                transform: none !important;
                opacity: 1 !important;
            }

            .top-services-track {
                animation: none !important;
                transform: none !important;
            }
        }

        .logo-premium {
            transition: transform 180ms ease, filter 180ms ease, opacity 180ms ease;
            filter: saturate(1.06) contrast(1.05);
            max-width: min(200px, 36vw);
        }

        .logo-premium:hover {
            transform: translateY(-1px) scale(1.02);
        }

        .header-cta-premium {
            box-shadow: 0 10px 28px -16px rgba(19, 127, 236, 0.9);
            letter-spacing: 0.14em;
        }

        .header-cta-premium:hover {
            box-shadow: 0 16px 30px -18px rgba(19, 127, 236, 0.95);
        }

        .header-cta-premium:active {
            transform: translateY(0) scale(0.99);
        }

        @media (max-width: 1279px) {
            .logo-premium {
                max-width: min(210px, 38vw);
            }
        }

        @media (max-width: 767px) {
            .logo-premium {
                max-width: min(185px, 46vw);
            }
        }

        /* Home: full-bleed hero / slideshow — spans full viewport width */
        .is-home main {
            overflow-x: clip;
            max-width: 100%;
        }

        .is-home main>section:first-of-type,
        .is-home .home-hero-root {
            position: relative;
            min-height: min(88vh, 920px);
            overflow: hidden;
            width: 100vw;
            max-width: 100vw;
            margin-left: calc(50% - 50vw);
            margin-right: calc(50% - 50vw);
            border-radius: 0;
            box-shadow: 0 28px 72px -44px rgba(15, 23, 42, 0.55);
        }

        @media (min-width: 768px) {

            .is-home main>section:first-of-type,
            .is-home .home-hero-root {
                border-radius: 0 0 1.5rem 1.5rem;
            }
        }

        @media (min-width: 1280px) {

            .is-home main>section:first-of-type,
            .is-home .home-hero-root {
                border-radius: 0 0 1.75rem 1.75rem;
            }
        }

        .is-home main .swiper,
        .is-home .home-hero-root .swiper,
        .is-home main [class*="swiper-container"] {
            min-height: min(84vh, 900px);
        }

        .is-home main .swiper-slide,
        .is-home .home-hero-root .swiper-slide {
            min-height: min(84vh, 900px);
            background-size: cover;
            background-position: center;
        }

        .is-home main .swiper-pagination,
        .is-home .home-hero-root .swiper-pagination {
            bottom: 1.75rem !important;
        }

        .is-home main .swiper-pagination-bullet,
        .is-home .home-hero-root .swiper-pagination-bullet {
            width: 10px;
            height: 10px;
            opacity: 0.45;
            background: #fff;
            transition: transform 160ms ease, opacity 160ms ease, width 160ms ease;
        }

        .is-home main .swiper-pagination-bullet-active,
        .is-home .home-hero-root .swiper-pagination-bullet-active {
            opacity: 1;
            width: 28px;
            border-radius: 999px;
            background: linear-gradient(90deg, #137fec, #4f46e5);
        }

        .home-hero-mega {
            min-height: min(92vh, 980px) !important;
            border-radius: 0 0 2rem 2rem !important;
        }

        /* Premium home hero (partials/home-hero-premium.blade.php) */
        .home-hero-premium {
            min-height: min(90vh, 960px);
        }

        @media (prefers-reduced-motion: no-preference) {
            .hero-ken-burns {
                animation: heroKenBurns 22s ease-in-out infinite alternate;
            }
        }

        @keyframes heroKenBurns {
            0% {
                transform: scale(1.02) translate3d(0, 0, 0);
            }

            100% {
                transform: scale(1.08) translate3d(-1.2%, -0.6%, 0);
            }
        }

        /* —— Client-facing “luxury” layer (fills in missing styles for premium-* classes) —— */
        .site-premium-v2 {
            font-feature-settings: "kern" 1, "liga" 1;
        }

        .site-premium-v2 .app-shell-gradient {
            background-color: #f3f5f7;
            background-image:
                radial-gradient(1200px 600px at 10% -10%, rgba(19, 127, 236, 0.09), transparent 55%),
                radial-gradient(900px 500px at 90% 0%, rgba(99, 102, 241, 0.06), transparent 50%),
                radial-gradient(800px 500px at 50% 100%, rgba(148, 163, 184, 0.12), transparent 45%);
        }

        .dark .site-premium-v2 .app-shell-gradient {
            background-color: #0f1419;
            background-image:
                radial-gradient(1000px 500px at 15% 0%, rgba(19, 127, 236, 0.12), transparent 55%),
                radial-gradient(800px 400px at 100% 30%, rgba(79, 70, 229, 0.08), transparent 50%);
        }

        .main-premium {
            padding-bottom: clamp(2rem, 5vw, 4rem);
        }

        .footer-premium {
            position: relative;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            box-shadow: 0 -32px 80px -48px rgba(0, 0, 0, 0.65);
        }

        .footer-premium h4 {
            font-family: Fraunces, Georgia, serif;
            font-weight: 600;
            letter-spacing: -0.02em;
        }

        .modal-luxury-shell {
            box-shadow:
                0 0 0 1px rgba(255, 255, 255, 0.06) inset,
                0 25px 50px -12px rgba(15, 23, 42, 0.45),
                0 0 80px -20px rgba(19, 127, 236, 0.25);
        }

        .dark .modal-luxury-shell {
            box-shadow:
                0 0 0 1px rgba(255, 255, 255, 0.05) inset,
                0 25px 50px -12px rgba(0, 0, 0, 0.65),
                0 0 60px -24px rgba(19, 127, 236, 0.2);
        }

        .modal-backdrop-luxury {
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        .nav-link {
            letter-spacing: 0.02em;
        }

        .home-hero-premium .hero-glass-panel {
            border: 1px solid rgba(255, 255, 255, 0.14);
            background: linear-gradient(145deg,
                    rgba(12, 18, 32, 0.78) 0%,
                    rgba(15, 23, 42, 0.5) 48%,
                    rgba(15, 23, 42, 0.22) 100%);
            backdrop-filter: blur(22px) saturate(1.15);
            -webkit-backdrop-filter: blur(22px) saturate(1.15);
            box-shadow:
                0 32px 90px -40px rgba(0, 0, 0, 0.9),
                inset 0 1px 0 rgba(255, 255, 255, 0.12),
                inset 0 -1px 0 rgba(0, 0, 0, 0.2);
        }

        .hero-font-display {
            font-family: Fraunces, Georgia, serif;
            font-weight: 700;
            font-variation-settings: "OPSZ" 72;
            letter-spacing: -0.03em;
            text-shadow: 0 2px 40px rgba(0, 0, 0, 0.35);
        }

        .hero-cta-premium {
            position: relative;
            overflow: hidden;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            font-size: 0.8125rem;
        }

        .hero-cta-premium::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, transparent 40%, rgba(255, 255, 255, 0.2) 50%, transparent 60%);
            transform: translateX(-100%);
            transition: transform 0.6s ease;
        }

        .hero-cta-premium:hover::after {
            transform: translateX(100%);
        }

        /* ============================================================
           Luxury site-wide theme — carries the home page design
           language (editorial serif, refined gradients, calm surfaces)
           to every page.
           ============================================================ */

        /* Editorial serif display headings, like the video hero */
        main.main-premium h1,
        main.main-premium h2 {
            font-family: 'Fraunces', Georgia, serif;
            font-weight: 500;
            letter-spacing: -0.02em;
        }

        main.main-premium h1 {
            line-height: 1.05;
        }

        main.main-premium h2 {
            line-height: 1.12;
        }

        /* Soften the heavy black weights into editorial ones */
        main.main-premium h1.font-black,
        main.main-premium h2.font-black,
        main.main-premium h1.font-extrabold,
        main.main-premium h2.font-extrabold {
            font-weight: 500;
        }

        /* Calm, warm page surface with a faint luxury gradient */
        .app-shell-gradient {
            background-image:
                radial-gradient(circle at 8% 0%, rgba(19, 127, 236, 0.05), transparent 46%),
                radial-gradient(circle at 100% 100%, rgba(13, 20, 27, 0.05), transparent 50%),
                linear-gradient(180deg, #fbfcfe 0%, #f6f8fb 100%);
        }

        .dark .app-shell-gradient {
            background-image:
                radial-gradient(circle at 8% 0%, rgba(19, 127, 236, 0.08), transparent 46%),
                linear-gradient(180deg, #0b1118 0%, #0d141b 100%);
        }

        /* Kicker labels (small uppercase text above headings) */
        main.main-premium .uppercase.tracking-widest,
        main.main-premium .uppercase.tracking-wider {
            letter-spacing: 0.26em;
            font-weight: 600;
        }

        /* Primary CTAs: editorial squared style, like the hero buttons */
        main.main-premium a.bg-primary,
        main.main-premium button.bg-primary {
            border-radius: 2px;
            text-transform: uppercase;
            letter-spacing: 0.16em;
            font-weight: 600;
            font-size: 0.8rem;
            background: linear-gradient(135deg, #137fec 0%, #0c5cbb 100%);
            box-shadow: 0 14px 30px -14px rgba(19, 127, 236, 0.55);
        }

        main.main-premium a.bg-primary:hover,
        main.main-premium button.bg-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 18px 34px -14px rgba(19, 127, 236, 0.6);
        }

        /* Cards: softer radius, calmer borders, luxury hover lift */
        main.main-premium .rounded-2xl,
        main.main-premium .rounded-xl {
            border-radius: 0.75rem;
        }

        main.main-premium .shadow-2xl {
            box-shadow: 0 30px 70px -42px rgba(13, 20, 27, 0.45);
        }

        /* Dark sections: match the hero's deep cinematic navy */
        main.main-premium .bg-navy-deep {
            background:
                radial-gradient(circle at 85% 15%, rgba(19, 127, 236, 0.12), transparent 44%),
                linear-gradient(160deg, #0d141b 0%, #101a24 55%, #0d141b 100%);
        }

        /* Footer: same cinematic navy treatment */
        .footer-premium {
            background:
                radial-gradient(circle at 12% 0%, rgba(19, 127, 236, 0.1), transparent 42%),
                linear-gradient(180deg, #0d141b 0%, #0a0f15 100%) !important;
            border-top: 1px solid rgba(148, 163, 184, 0.12);
        }

        /* Section rhythm: gentle divider glow between light sections */
        main.main-premium>section {
            position: relative;
        }

        /* Links get the understated luxury hover */
        main.main-premium a:not(.bg-primary):hover {
            opacity: 0.85;
        }

        /* ── Page section entrance animation ───────────────────── */
        .premium-reveal {
            opacity: 0;
            transform: translate3d(0, 22px, 0);
            transition:
                opacity 680ms cubic-bezier(0.16, 1, 0.3, 1),
                transform 680ms cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .premium-reveal.is-visible {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }

        /* ── Better dark nav section subtle texture ─────────────── */
        section.bg-navy-deep,
        section.bg-navy-deep.dark\:bg-black {
            background-image:
                radial-gradient(ellipse 900px 500px at 90% 10%, rgba(19,127,236,0.12), transparent 55%),
                radial-gradient(ellipse 700px 400px at 5% 85%, rgba(79,70,229,0.08), transparent 50%);
        }

        /* ── Footer form tweak ───────────────────────────────────── */
        .footer-premium input[type="email"]::placeholder {
            color: rgba(148, 163, 184, 0.6);
        }

        /* ── Better about page card hover ───────────────────────── */
        .hover\:shadow-primary\/8:hover {
            box-shadow: 0 20px 44px -16px rgba(19, 127, 236, 0.08);
        }

        /* ── Stats strip counter text ────────────────────────────── */
        .stat-counter {
            font-variant-numeric: tabular-nums;
        }

        /* ── Smooth scroll ──────────────────────────────────────────── */
        html { scroll-behavior: smooth; }

        /* ── Gradient text utility ──────────────────────────────────── */
        .gradient-text {
            background: linear-gradient(135deg, #137fec 0%, #4f46e5 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            display: inline;
        }

        /* ── Hero floating badge animation ──────────────────────────── */
        @keyframes heroFloat1 {
            0%, 100% { transform: translateY(0px) rotate(-1deg); }
            50% { transform: translateY(-12px) rotate(1deg); }
        }
        @keyframes heroFloat2 {
            0%, 100% { transform: translateY(-6px) rotate(1deg); }
            50% { transform: translateY(6px) rotate(-1deg); }
        }
        @keyframes heroFloat3 {
            0%, 100% { transform: translateY(4px) rotate(-0.5deg); }
            50% { transform: translateY(-8px) rotate(0.5deg); }
        }
        .hero-float-1 { animation: heroFloat1 5s ease-in-out infinite; }
        .hero-float-2 { animation: heroFloat2 6.5s ease-in-out infinite; }
        .hero-float-3 { animation: heroFloat3 7s ease-in-out 1s infinite; }
        .hero-float-4 { animation: heroFloat1 5.5s ease-in-out 2s infinite; }

        /* ── Hero stagger reveal animation ──────────────────────────── */
        @keyframes heroReveal {
            from { opacity: 0; transform: translateY(26px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .hero-stagger > * {
            animation: heroReveal 1s cubic-bezier(0.16, 1, 0.3, 1) both;
        }
        .hero-stagger > *:nth-child(1) { animation-delay: 0.05s; }
        .hero-stagger > *:nth-child(2) { animation-delay: 0.18s; }
        .hero-stagger > *:nth-child(3) { animation-delay: 0.3s; }
        .hero-stagger > *:nth-child(4) { animation-delay: 0.44s; }
        .hero-stagger > *:nth-child(5) { animation-delay: 0.58s; }

        /* ── Button shimmer ─────────────────────────────────────────── */
        @keyframes shimmerSlide {
            0%   { left: -65%; }
            100% { left: 125%; }
        }
        .btn-shimmer {
            position: relative;
            overflow: hidden;
        }
        .btn-shimmer::after {
            content: '';
            position: absolute;
            top: 0;
            left: -65%;
            width: 42%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.22), transparent);
            transform: skewX(-15deg);
        }
        .btn-shimmer:hover::after {
            animation: shimmerSlide 0.65s ease forwards;
        }

        /* ── Neon glow primary button ───────────────────────────────── */
        .btn-glow {
            box-shadow: 0 0 28px rgba(19,127,236,0.45), 0 8px 20px rgba(19,127,236,0.2);
            transition: box-shadow 0.3s ease, transform 0.2s ease;
        }
        .btn-glow:hover {
            box-shadow: 0 0 42px rgba(19,127,236,0.65), 0 12px 28px rgba(19,127,236,0.3);
        }

        /* ── Glass morphism card ────────────────────────────────────── */
        .glass-card {
            background: rgba(255,255,255,0.07);
            backdrop-filter: blur(18px) saturate(1.3);
            -webkit-backdrop-filter: blur(18px) saturate(1.3);
            border: 1px solid rgba(255,255,255,0.12);
        }

        /* ── Process step large numeral ─────────────────────────────── */
        .process-step-num {
            font-family: 'Fraunces', Georgia, serif;
            font-size: clamp(3.5rem, 6vw, 5.5rem);
            font-weight: 700;
            line-height: 1;
            background: linear-gradient(135deg, #137fec 0%, #4f46e5 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            opacity: 0.14;
            transition: opacity 0.35s ease;
            user-select: none;
            pointer-events: none;
        }
        .process-card:hover .process-step-num { opacity: 0.3; }

        /* ── Scroll indicator bounce ────────────────────────────────── */
        @keyframes scrollBounce {
            0%, 100% { transform: translateY(0);  opacity: 0.8; }
            50%       { transform: translateY(8px); opacity: 0.35; }
        }
        .scroll-indicator { animation: scrollBounce 2s ease-in-out infinite; }

        /* ── Service card image zoom ────────────────────────────────── */
        .svc-img-zoom { transition: transform 0.55s cubic-bezier(0.16,1,0.3,1); }
        .group:hover .svc-img-zoom { transform: scale(1.08); }

        /* ── Gradient pill tag on service cards ─────────────────────── */
        .svc-card-tag {
            position: absolute;
            top: 0.75rem;
            left: 0.75rem;
            padding: 0.22rem 0.65rem;
            border-radius: 999px;
            background: rgba(19,127,236,0.88);
            color: #fff;
            font-size: 0.6rem;
            font-weight: 800;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            z-index: 2;
            backdrop-filter: blur(8px);
        }

        /* ── Header glass blur on scroll ────────────────────────────── */
        .premium-header.header-scrolled {
            backdrop-filter: blur(24px) saturate(1.5);
            -webkit-backdrop-filter: blur(24px) saturate(1.5);
        }

        /* ── Animated gradient border on process cards ──────────────── */
        @keyframes borderShift {
            0%, 100% { background-position: 0% 50%; }
            50%       { background-position: 100% 50%; }
        }
        .process-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        }
        .process-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 56px -24px rgba(19,127,236,0.18);
        }

        /* ── Trust bar pill items ────────────────────────────────────── */
        .trust-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 1rem;
            border-radius: 999px;
            border: 1px solid rgba(19,127,236,0.15);
            background: rgba(19,127,236,0.04);
            color: #334155;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            white-space: nowrap;
        }
        .dark .trust-pill {
            border-color: rgba(96,165,250,0.18);
            background: rgba(96,165,250,0.06);
            color: #94a3b8;
        }

        /* ── Animated gradient heading ──────────────────────────────── */
        @keyframes gradientShift {
            0%   { background-position:   0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position:   0% 50%; }
        }
        .gradient-heading {
            background: linear-gradient(90deg, #137fec 0%, #4f46e5 40%, #0ea5e9 70%, #137fec 100%);
            background-size: 300% 100%;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: gradientShift 7s ease infinite;
        }

        /* ── Pulsing dot ────────────────────────────────────────────── */
        @keyframes tickerDotPulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%      { opacity: 0.6; transform: scale(1.45); }
        }
        .pulse-dot { animation: tickerDotPulse 2.2s ease-in-out infinite; }

        /* ── Premium card lift (hover raise) ────────────────────────── */
        .premium-lift {
            transition: transform 0.35s cubic-bezier(0.16,1,0.3,1),
                        box-shadow 0.35s ease,
                        border-color 0.35s ease,
                        background-color 0.2s ease;
        }
        .premium-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 48px -20px rgba(19,127,236,0.25);
        }

        /* ── Growth chart hover glow ────────────────────────────────── */
        .home-growth-chart {
            transition: box-shadow 0.4s ease, border-color 0.4s ease;
        }
        .home-growth-chart:hover {
            box-shadow: 0 32px 80px -24px rgba(19,127,236,0.38), 0 0 0 1px rgba(19,127,236,0.2) !important;
            border-color: rgba(19,127,236,0.28) !important;
        }

        /* ── Stats strip lg dividers ────────────────────────────────── */
        @media (min-width: 1024px) {
            .stat-item + .stat-item {
                border-left: 1px solid rgba(19,127,236,0.12);
                padding-left: 2.5rem;
            }
            .stat-item { padding-right: 2.5rem; }
            .stat-item:last-child { padding-right: 0; }
        }

        /* ── Process card color-coded hover borders ─────────────────── */
        .process-card-blue:hover  { border-color: rgba(19,127,236,0.38)  !important; }
        .process-card-amber:hover { border-color: rgba(245,158,11,0.38)  !important; }
        .process-card-green:hover { border-color: rgba(16,185,129,0.38)  !important; }

        /* ── Section heading consistent scale ───────────────────────── */
        .section-h2 {
            font-size: clamp(1.75rem, 4vw, 3rem);
            font-weight: 800;
            letter-spacing: -0.025em;
            line-height: 1.12;
            color: #0d141b;
        }
        .dark .section-h2 { color: #fff; }

        /* ── Eyebrow label consistent style ─────────────────────────── */
        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            font-size: 0.63rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.3em;
            color: #137fec;
        }
        .eyebrow::before,
        .eyebrow::after {
            content: '';
            display: block;
            width: 1.75rem;
            height: 1px;
            background: rgba(19,127,236,0.55);
            border-radius: 999px;
        }

        /* ── Trust pill hover ───────────────────────────────────────── */
        .trust-pill {
            transition: border-color 0.25s ease, background-color 0.25s ease, transform 0.25s ease;
        }
        .trust-pill:hover {
            border-color: rgba(19,127,236,0.35);
            background: rgba(19,127,236,0.09);
            transform: translateY(-1px);
        }
    </style>

    @stack('styles')

</head>

<body
    class="site-premium-v2 bg-background-light dark:bg-background-dark text-navy-deep dark:text-slate-50 min-h-screen flex flex-col app-shell-gradient {{ request()->routeIs('home') ? 'is-home' : '' }}">

    @php
        $tickerServices = [];
        foreach (($navServices ?? []) as $svc) {
            $title = $svc->translated_title ?? ($svc->title ?? null);
            if ($title) {
                $tickerServices[] = $title;
            }
        }
        if (empty($tickerServices)) {
            $tickerServices = ['Tax Advisory', 'VAT & Corporate Tax', 'Payroll Management', 'Business Setup', 'Audit & Assurance', 'Accounting'];
        }
    @endphp

    <div class="site-fixed-chrome" id="siteFixedChrome">
    <section id="topServicesTicker" class="top-services-ticker luxury-announcement-bar" aria-label="Services ticker">
        <div class="top-services-inner">
            <div class="top-services-track" aria-hidden="true">
                @for($i = 0; $i < 2; $i++)
                    @foreach($tickerServices as $svcLabel)
                        <span class="top-services-item"><span class="top-services-dot"></span>{{ $svcLabel }}</span>
                    @endforeach
                @endfor
            </div>
        </div>
    </section>

    <header
        class="premium-header w-full transition-shadow duration-200"
        x-data="{ mobileMenuOpen: false, mobileAboutOpen: {{ request()->routeIs('about') ? 'true' : 'false' }}, mobileServicesOpen: {{ request()->routeIs('services*') ? 'true' : 'false' }} }" style="pointer-events: auto !important;" id="siteHeader">

        <div class="luxury-header-inner">

            <nav class="luxury-nav-left" aria-label="Primary navigation left">
                <a class="luxury-nav-link {{ request()->routeIs('home') ? 'luxury-nav-active' : '' }}"
                    href="{{ route('home') }}">{{ __('common.home') }}</a>

                <div class="luxury-nav-item">
                    <a class="luxury-nav-link inline-flex items-center gap-1 {{ request()->routeIs('about') ? 'luxury-nav-active' : '' }}"
                        href="{{ route('about') }}">
                        {{ __('common.about') }}
                        <span class="material-symbols-outlined luxury-nav-caret">expand_more</span>
                    </a>
                    <div class="luxury-dropdown" role="menu">
                        <a href="{{ route('about') }}?section=about"
                            class="{{ request()->routeIs('about') && request()->get('section', 'about') === 'about' ? 'luxury-dropdown-active' : '' }}"
                            role="menuitem">{{ __('common.about_us') }}</a>
                        <a href="{{ route('about') }}?section=mission"
                            class="{{ request()->routeIs('about') && request()->get('section') === 'mission' ? 'luxury-dropdown-active' : '' }}"
                            role="menuitem">{{ __('common.mission_vision') }}</a>
                        <a href="{{ route('about') }}?section=why-choose"
                            class="{{ request()->routeIs('about') && request()->get('section') === 'why-choose' ? 'luxury-dropdown-active' : '' }}"
                            role="menuitem">{{ __('common.why_choose_us') }}</a>
                    </div>
                </div>

                <div class="luxury-nav-item">
                    <a class="luxury-nav-link inline-flex items-center gap-1 {{ request()->routeIs('services*') ? 'luxury-nav-active' : '' }}"
                        href="{{ route('services') }}">
                        {{ __('common.services') }}
                        <span class="material-symbols-outlined luxury-nav-caret">expand_more</span>
                    </a>
                    <div class="luxury-dropdown" role="menu">
                        <a href="{{ route('services') }}"
                            class="{{ request()->routeIs('services') && !request()->routeIs('services.show') ? 'luxury-dropdown-active' : '' }}"
                            role="menuitem">{{ __('common.services') }}</a>
                        @foreach($navServices ?? [] as $navService)
                            <a href="{{ route('services.show', $navService->id) }}"
                                class="{{ request()->routeIs('services.show') && request()->route('id') == $navService->id ? 'luxury-dropdown-active' : '' }}"
                                role="menuitem">{{ $navService->translated_title }}</a>
                        @endforeach
                    </div>
                </div>

                <a class="luxury-nav-link {{ request()->routeIs('team') ? 'luxury-nav-active' : '' }}"
                    href="{{ route('team') }}">{{ __('common.team') }}</a>
            </nav>

            <a href="{{ route('home') }}" class="luxury-logo-center" aria-label="9Associates home">
                <img src="{{ asset('logo.png') }}" alt="9Associates"
                    class="logo-premium logo-light object-contain" loading="eager">
                <img src="{{ asset('logo-dark.png') }}" alt="9Associates"
                    class="logo-premium logo-dark object-contain" loading="eager">
            </a>

            <nav class="luxury-nav-right" aria-label="Primary navigation right">
                <a class="luxury-nav-link {{ request()->routeIs('careers') ? 'luxury-nav-active' : '' }}"
                    href="{{ route('careers') }}">{{ __('common.careers') }}</a>
                <a class="luxury-nav-link {{ request()->routeIs('insights') ? 'luxury-nav-active' : '' }}"
                    href="{{ route('insights') }}">{{ __('common.insights') }}</a>
                <a class="luxury-nav-link {{ request()->routeIs('contact*') ? 'luxury-nav-active' : '' }}"
                    href="{{ route('contact-details.show') }}">{{ __('common.contact') }}</a>

                <button type="button" class="luxury-nav-link luxury-nav-ai inline-flex items-center gap-1.5"
                    data-open-ai-chat aria-label="Open AI assistant">
                    <span class="material-symbols-outlined luxury-nav-ai-icon">smart_toy</span>
                    AI
                </button>

                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open"
                        class="luxury-lang-btn flex items-center gap-1.5 px-2 py-1.5 text-[0.65rem] font-medium tracking-[0.16em] uppercase transition-colors bg-transparent border-0"
                        type="button">
                        <span class="material-symbols-outlined text-base">language</span>
                        <span>{{ $currentLocale ?? 'en' }}</span>
                    </button>
                    <div x-show="open" x-cloak x-transition
                        class="absolute top-full mt-2 w-44 bg-white dark:bg-slate-900 rounded-lg shadow-xl border border-slate-200 dark:border-slate-800 z-[100001] ltr:right-0 rtl:left-0">
                        <div class="py-2">
                            <a href="{{ route('language.switch', 'en') }}"
                                class="flex items-center gap-3 px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-primary hover:text-white transition-colors {{ ($currentLocale ?? 'en') === 'en' ? 'bg-primary text-white' : '' }}">
                                <span class="text-xs font-bold text-slate-400">EN</span><span>{{ __('common.english') }}</span>
                            </a>
                            <a href="{{ route('language.switch', 'fr') }}"
                                class="flex items-center gap-3 px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-primary hover:text-white transition-colors {{ ($currentLocale ?? 'en') === 'fr' ? 'bg-primary text-white' : '' }}">
                                <span class="text-xs font-bold text-slate-400">FR</span><span>{{ __('common.french') }}</span>
                            </a>
                            <a href="{{ route('language.switch', 'ar') }}"
                                class="flex items-center gap-3 px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-primary hover:text-white transition-colors {{ ($currentLocale ?? 'en') === 'ar' ? 'bg-primary text-white' : '' }}">
                                <span class="text-xs font-bold text-slate-400">AR</span><span>{{ __('common.arabic') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="luxury-mobile-bar">
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open"
                        class="luxury-lang-btn flex items-center gap-1 px-2.5 py-2 rounded-full border border-slate-200/70 dark:border-slate-700/70 bg-white/75 dark:bg-slate-900/55"
                        type="button">
                        <span class="material-symbols-outlined text-lg">language</span>
                        <span class="text-xs font-semibold uppercase">{{ $currentLocale ?? 'en' }}</span>
                    </button>
                    <div x-show="open" x-cloak x-transition
                        class="absolute top-full mt-2 w-44 bg-white dark:bg-slate-900 rounded-lg shadow-xl border border-slate-200 dark:border-slate-800 z-[100001] ltr:left-0 rtl:right-0">
                        <div class="py-2">
                            <a href="{{ route('language.switch', 'en') }}" class="block px-4 py-2 text-sm hover:bg-primary hover:text-white {{ ($currentLocale ?? 'en') === 'en' ? 'bg-primary text-white' : '' }}">{{ __('common.english') }}</a>
                            <a href="{{ route('language.switch', 'fr') }}" class="block px-4 py-2 text-sm hover:bg-primary hover:text-white {{ ($currentLocale ?? 'en') === 'fr' ? 'bg-primary text-white' : '' }}">{{ __('common.french') }}</a>
                            <a href="{{ route('language.switch', 'ar') }}" class="block px-4 py-2 text-sm hover:bg-primary hover:text-white {{ ($currentLocale ?? 'en') === 'ar' ? 'bg-primary text-white' : '' }}">{{ __('common.arabic') }}</a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('home') }}" class="flex items-center">
                    <img src="{{ asset('logo.png') }}" alt="9Associates" class="logo-premium logo-light h-10 w-auto object-contain">
                    <img src="{{ asset('logo-dark.png') }}" alt="9Associates" class="logo-premium logo-dark h-10 w-auto object-contain">
                </a>

                <div class="flex items-center gap-2">
                    <button type="button"
                        class="flex items-center justify-center w-10 h-10 rounded-full border border-slate-200/70 dark:border-slate-700 bg-white/80 dark:bg-slate-900/80"
                        data-open-ai-chat aria-label="Open AI assistant">
                        <span class="material-symbols-outlined">smart_toy</span>
                    </button>

                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="flex items-center justify-center w-10 h-10 rounded-full border border-slate-200/70 dark:border-slate-700 bg-white/80 dark:bg-slate-900/80"
                        type="button" aria-label="Menu">
                        <span class="material-symbols-outlined" x-show="!mobileMenuOpen">menu</span>
                        <span class="material-symbols-outlined" x-show="mobileMenuOpen" style="display: none;">close</span>
                    </button>
                </div>
            </div>

        </div>

        <!-- Mobile Menu -->

        <div x-show="mobileMenuOpen" x-transition
            class="luxury-mobile-menu xl:hidden bg-white/98 dark:bg-background-dark backdrop-blur-md"
            style="display: none;">

            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 py-2 divide-y divide-slate-100 dark:divide-slate-800/70">

                <a class="block px-3 py-3.5 text-navy-deep dark:text-slate-200 text-xs font-bold tracking-[0.16em] uppercase {{ request()->routeIs('home') ? 'text-primary' : '' }}"
                    href="{{ route('home') }}">{{ __('common.home') }}</a>

                <div>
                    <button type="button" @click="mobileAboutOpen = !mobileAboutOpen"
                        class="w-full flex items-center justify-between px-3 py-3.5 text-navy-deep dark:text-slate-200 text-xs font-bold tracking-[0.16em] uppercase {{ request()->routeIs('about') ? 'text-primary' : '' }}">
                        <span>{{ __('common.about') }}</span>
                        <span class="material-symbols-outlined text-base transition-transform" :class="mobileAboutOpen ? 'rotate-180' : ''">expand_more</span>
                    </button>
                    <div x-show="mobileAboutOpen" x-cloak class="pl-4 pb-1 space-y-0.5">
                        <a href="{{ route('about') }}?section=about"
                            class="block px-3 py-2.5 text-xs font-semibold tracking-wide text-slate-500 dark:text-slate-400 rounded-lg hover:bg-primary/8 hover:text-primary transition-colors {{ request()->routeIs('about') && request()->get('section', 'about') === 'about' ? 'text-primary' : '' }}">{{ __('common.about_us') }}</a>
                        <a href="{{ route('about') }}?section=mission"
                            class="block px-3 py-2.5 text-xs font-semibold tracking-wide text-slate-500 dark:text-slate-400 rounded-lg hover:bg-primary/8 hover:text-primary transition-colors {{ request()->routeIs('about') && request()->get('section') === 'mission' ? 'text-primary' : '' }}">{{ __('common.mission_vision') }}</a>
                        <a href="{{ route('about') }}?section=why-choose"
                            class="block px-3 py-2.5 text-xs font-semibold tracking-wide text-slate-500 dark:text-slate-400 rounded-lg hover:bg-primary/8 hover:text-primary transition-colors {{ request()->routeIs('about') && request()->get('section') === 'why-choose' ? 'text-primary' : '' }}">{{ __('common.why_choose_us') }}</a>
                    </div>
                </div>

                <div>
                    <button type="button" @click="mobileServicesOpen = !mobileServicesOpen"
                        class="w-full flex items-center justify-between px-3 py-3.5 text-navy-deep dark:text-slate-200 text-xs font-bold tracking-[0.16em] uppercase {{ request()->routeIs('services*') ? 'text-primary' : '' }}">
                        <span>{{ __('common.services') }}</span>
                        <span class="material-symbols-outlined text-base transition-transform" :class="mobileServicesOpen ? 'rotate-180' : ''">expand_more</span>
                    </button>
                    <div x-show="mobileServicesOpen" x-cloak class="pl-3 space-y-0.5">
                        <a href="{{ route('services') }}"
                            class="block px-3 py-2 text-sm text-slate-600 dark:text-slate-400 {{ request()->routeIs('services') && !request()->routeIs('services.show') ? 'text-primary font-medium' : '' }}">{{ __('common.all_services') ?? __('common.services') }}</a>
                        @foreach($navServices ?? [] as $navService)
                            <a href="{{ route('services.show', $navService->id) }}"
                                class="block px-3 py-2 text-sm text-slate-600 dark:text-slate-400 {{ request()->routeIs('services.show') && request()->route('id') == $navService->id ? 'text-primary font-medium' : '' }}">{{ $navService->translated_title }}</a>
                        @endforeach
                    </div>
                </div>

                <a class="block px-3 py-3.5 text-navy-deep dark:text-slate-200 text-xs font-bold tracking-[0.16em] uppercase {{ request()->routeIs('team') ? 'text-primary' : '' }}"
                    href="{{ route('team') }}">{{ __('common.team') }}</a>

                <a class="block px-3 py-3.5 text-navy-deep dark:text-slate-200 text-xs font-bold tracking-[0.16em] uppercase {{ request()->routeIs('careers') ? 'text-primary' : '' }}"
                    href="{{ route('careers') }}">{{ __('common.careers') }}</a>

                <a class="block px-3 py-3.5 text-navy-deep dark:text-slate-200 text-xs font-bold tracking-[0.16em] uppercase {{ request()->routeIs('insights') ? 'text-primary' : '' }}"
                    href="{{ route('insights') }}">{{ __('common.insights') }}</a>

                <a class="block px-3 py-3.5 text-primary text-xs font-bold tracking-[0.16em] uppercase"
                    href="{{ route('contact-details.show') }}">{{ __('common.contact') }}</a>

                <button type="button"
                    class="w-full flex items-center gap-2 px-3 py-3.5 text-navy-deep dark:text-slate-200 text-xs font-bold tracking-[0.16em] uppercase"
                    data-open-ai-chat
                    @click="mobileMenuOpen = false">
                    <span class="material-symbols-outlined text-lg text-primary">smart_toy</span>
                    AI Assistant
                </button>

            </div>

        </div>

    </header>
    </div>



    <main class="flex-grow relative z-[1] main-premium">

        @if(session('success'))

            <div class="max-w-[1280px] mx-auto px-6 md:px-10 pt-4">

                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">

                    <span class="block sm:inline">{{ session('success') }}</span>

                </div>

            </div>

        @endif



        @yield('content')

    </main>



    <footer class="footer-premium relative z-[1] bg-navy-deep text-white overflow-hidden">

        {{-- Subtle top-gradient mesh --}}
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
            <div class="absolute left-0 top-0 w-1/2 h-full" style="background: radial-gradient(ellipse 600px 400px at -5% 0%, rgba(19,127,236,0.14), transparent 65%);"></div>
            <div class="absolute right-0 top-0 w-1/3 h-full" style="background: radial-gradient(ellipse 500px 350px at 110% 0%, rgba(79,70,229,0.1), transparent 65%);"></div>
        </div>

        <div class="relative max-w-[1280px] mx-auto px-4 sm:px-6 md:px-10">

            {{-- Logo + tagline row --}}
            <div class="pt-12 sm:pt-16 md:pt-20 pb-8 sm:pb-10 border-b border-white/8 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                <a href="{{ route('home') }}" class="flex items-center" aria-label="9Associates home">
                    <img src="{{ asset('logo.png') }}" alt="9Associates" class="h-10 sm:h-12 w-auto object-contain filter brightness-0 invert" loading="lazy">
                </a>
                <p class="text-slate-400 text-xs sm:text-sm max-w-[380px] leading-relaxed">
                    {{ __('common.footer_description') }}
                </p>
                <div class="flex gap-3">
                    @php
                        $linkedinUrl = \App\Models\Setting::get('social_linkedin', '');
                        $twitterUrl  = \App\Models\Setting::get('social_twitter', '');
                        $facebookUrl = \App\Models\Setting::get('social_facebook', '');
                    @endphp
                    @if(!empty($linkedinUrl))
                        <a class="w-9 h-9 rounded-lg bg-white/8 hover:bg-primary border border-white/10 hover:border-primary flex items-center justify-center transition-all" href="{{ $linkedinUrl }}" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                        </a>
                    @endif
                    @if(!empty($twitterUrl))
                        <a class="w-9 h-9 rounded-lg bg-white/8 hover:bg-primary border border-white/10 hover:border-primary flex items-center justify-center transition-all" href="{{ $twitterUrl }}" target="_blank" rel="noopener noreferrer" aria-label="Twitter / X">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                    @endif
                    @if(!empty($facebookUrl))
                        <a class="w-9 h-9 rounded-lg bg-white/8 hover:bg-primary border border-white/10 hover:border-primary flex items-center justify-center transition-all" href="{{ $facebookUrl }}" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.324v-21.35c0-.732-.593-1.325-1.325-1.325z"/></svg>
                        </a>
                    @endif
                </div>
            </div>

            {{-- 3-column links + newsletter --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 sm:gap-10 md:gap-12 py-10 sm:py-12">

                <div class="flex flex-col gap-5">
                    <h4 class="text-sm font-bold uppercase tracking-[0.18em] text-white/80">{{ __('common.quick_links') }}</h4>
                    <ul class="flex flex-col gap-3">
                        <li><a class="text-slate-400 text-sm hover:text-white transition-colors inline-flex items-center gap-1.5 group" href="{{ route('home') }}"><span class="w-3 h-px bg-slate-600 group-hover:bg-primary group-hover:w-4 transition-all"></span>{{ __('common.home') }}</a></li>
                        <li><a class="text-slate-400 text-sm hover:text-white transition-colors inline-flex items-center gap-1.5 group" href="{{ route('about') }}"><span class="w-3 h-px bg-slate-600 group-hover:bg-primary group-hover:w-4 transition-all"></span>{{ __('common.about_us') }}</a></li>
                        <li><a class="text-slate-400 text-sm hover:text-white transition-colors inline-flex items-center gap-1.5 group" href="{{ route('services') }}"><span class="w-3 h-px bg-slate-600 group-hover:bg-primary group-hover:w-4 transition-all"></span>{{ __('common.services') }}</a></li>
                        <li><a class="text-slate-400 text-sm hover:text-white transition-colors inline-flex items-center gap-1.5 group" href="{{ route('team') }}"><span class="w-3 h-px bg-slate-600 group-hover:bg-primary group-hover:w-4 transition-all"></span>{{ __('common.team') }}</a></li>
                        <li><a class="text-slate-400 text-sm hover:text-white transition-colors inline-flex items-center gap-1.5 group" href="{{ route('insights') }}"><span class="w-3 h-px bg-slate-600 group-hover:bg-primary group-hover:w-4 transition-all"></span>{{ __('common.insights') }}</a></li>
                        <li><a class="text-slate-400 text-sm hover:text-white transition-colors inline-flex items-center gap-1.5 group" href="{{ route('careers') }}"><span class="w-3 h-px bg-slate-600 group-hover:bg-primary group-hover:w-4 transition-all"></span>{{ __('common.careers') }}</a></li>
                    </ul>
                </div>

                <div class="flex flex-col gap-5">
                    <h4 class="text-sm font-bold uppercase tracking-[0.18em] text-white/80">{{ __('common.services') }}</h4>
                    <ul class="flex flex-col gap-3">
                        @foreach($navServices ?? [] as $navService)
                            <li><a class="text-slate-400 text-sm hover:text-white transition-colors inline-flex items-center gap-1.5 group" href="{{ route('services.show', $navService->id) }}"><span class="w-3 h-px bg-slate-600 group-hover:bg-primary group-hover:w-4 transition-all"></span>{{ $navService->translated_title }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="flex flex-col gap-5">
                    <h4 class="text-sm font-bold uppercase tracking-[0.18em] text-white/80">Contact</h4>
                    <ul class="flex flex-col gap-3 text-slate-400 text-sm">
                        <li class="flex items-start gap-2.5">
                            <span class="material-symbols-outlined text-primary text-base mt-0.5 shrink-0">location_on</span>
                            <span>Saudi Arabia, UAE &amp; GCC Region</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="material-symbols-outlined text-primary text-base mt-0.5 shrink-0">language</span>
                            <span>KSA · UAE · GCC · Worldwide</span>
                        </li>
                        <li>
                            <a href="{{ route('contact-details.show') }}" class="inline-flex items-center gap-1.5 text-primary text-sm font-semibold hover:gap-2.5 transition-all mt-2">
                                Get in touch
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="flex flex-col gap-5">
                    <h4 class="text-sm font-bold uppercase tracking-[0.18em] text-white/80">Stay Informed</h4>
                    <p class="text-slate-400 text-sm leading-relaxed">Get the latest tax and advisory insights from our team.</p>
                    <div class="flex flex-col gap-2.5">
                        <div class="relative">
                            <input type="email" id="footer-newsletter-email" placeholder="Your email address"
                                class="w-full h-11 pl-4 pr-4 rounded-lg bg-white/8 border border-white/12 text-white text-sm placeholder-slate-500 focus:outline-none focus:border-primary focus:bg-white/12 transition-all"
                                autocomplete="email">
                        </div>
                        <a href="{{ route('contact-details.show') }}"
                            class="h-11 rounded-lg bg-primary hover:bg-primary/90 text-white text-xs font-bold uppercase tracking-[0.18em] transition-all hover:shadow-lg hover:shadow-primary/30 active:scale-[0.98] flex items-center justify-center">
                            Subscribe
                        </a>
                    </div>
                </div>

            </div>

            {{-- Bottom bar --}}
            <div class="pt-6 sm:pt-8 border-t border-white/8 flex flex-col sm:flex-row justify-between items-center gap-3 sm:gap-4 pb-8 sm:pb-10">
                <a href="https://9digitalsolutions.online" target="_blank" rel="noopener noreferrer"
                   class="text-xs text-center sm:text-left transition-colors duration-200"
                   style="background: linear-gradient(90deg, #137fec, #818cf8); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    Powered by 9 Digital Solutions
                </a>
                <div class="flex flex-wrap justify-center sm:justify-end gap-5 sm:gap-8 text-xs text-slate-400">
                    <a class="hover:text-primary transition-colors" href="{{ route('privacy-policy') }}">{{ __('common.privacy_policy') ?? 'Privacy Policy' }}</a>
                    <a class="hover:text-primary transition-colors" href="{{ route('terms-of-service') }}">{{ __('common.terms_of_service') ?? 'Terms of Service' }}</a>
                    <a class="hover:text-primary transition-colors" href="{{ route('contact-details.show') }}">{{ __('common.contact') }}</a>
                </div>
            </div>

        </div>

    </footer>



    @stack('scripts')

    <script>
        // Global scroll-reveal for .premium-reveal elements
        (function () {
            if (typeof IntersectionObserver === 'undefined') {
                document.querySelectorAll('.premium-reveal').forEach(function (el) {
                    el.classList.add('is-visible');
                });
                return;
            }
            var revealObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12, rootMargin: '0px 0px -32px 0px' });
            document.querySelectorAll('.premium-reveal').forEach(function (el) {
                revealObserver.observe(el);
            });
        })();

    </script>

    <div id="react-root" data-all-services='@json($allServices)' data-all-jobs='@json($allJobs)'
        data-contact-submit-url="{{ route('contact.form.submit') }}"
        data-job-submit-url="{{ route('careers.application.submit') }}"></div>

    @vite('resources/js/app.jsx')


    <!-- Cookie Consent Modal - Optimized for Performance & SEO -->
    <!-- Loaded after page content for better LCP -->
    <div id="cookieConsentModal" class="cookie-modal hidden" role="dialog" aria-labelledby="cookie-title"
        aria-modal="true" aria-hidden="true">
        <div class="cookie-modal-overlay" aria-hidden="true"></div>
        <div class="cookie-modal-container">
            <div class="cookie-modal-content">
                <div class="cookie-modal-header">
                    <span class="material-symbols-outlined cookie-icon" aria-hidden="true">cookie</span>
                    <h3 id="cookie-title" class="cookie-modal-title">{{ __('common.cookie_policy') }}</h3>
                </div>
                <p class="cookie-modal-text">
                    {{ __('common.cookie_message') }}
                    <a href="javascript:void(0);" onclick="openPrivacyPolicyModal()" class="cookie-link"
                        aria-label="{{ __('common.privacy_policy') }}">{{ __('common.privacy_policy') }}</a>
                </p>
                <div class="cookie-modal-actions">
                    <button onclick="acceptAllCookies()" class="cookie-btn cookie-btn-primary"
                        aria-label="{{ __('common.accept_all') }}">
                        {{ __('common.accept_all') }}
                    </button>
                    <button onclick="openCookieSettings()" class="cookie-btn cookie-btn-secondary"
                        aria-label="{{ __('common.cookie_settings') }}">
                        {{ __('common.cookie_settings') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Cookie Settings Modal -->
    <div id="cookieSettingsModal" class="cookie-modal hidden" role="dialog" aria-labelledby="settings-title"
        aria-modal="true" aria-hidden="true">
        <div class="cookie-modal-overlay" aria-hidden="true"></div>
        <div class="cookie-modal-container cookie-modal-large">
            <div class="cookie-modal-content">
                <div class="cookie-modal-header">
                    <div class="cookie-modal-title-group">
                        <span class="material-symbols-outlined cookie-icon" aria-hidden="true">settings</span>
                        <h3 id="settings-title" class="cookie-modal-title">{{ __('common.cookie_settings') }}</h3>
                    </div>
                    <button onclick="closeCookieSettings()" class="cookie-close-btn" aria-label="Close cookie settings">
                        <span class="material-symbols-outlined" aria-hidden="true">close</span>
                    </button>
                </div>
                <p class="cookie-modal-text">
                    {{ __('common.manage_cookie_preferences') }}
                    <a href="javascript:void(0);" onclick="openPrivacyPolicyModal()" class="cookie-link"
                        aria-label="{{ __('common.privacy_policy') }}">{{ __('common.privacy_policy') }}</a>
                </p>

                <div class="cookie-settings-list">
                    <div class="cookie-setting-item">
                        <div class="cookie-setting-header">
                            <div class="cookie-setting-info">
                                <span class="material-symbols-outlined cookie-setting-icon cookie-icon-essential"
                                    aria-hidden="true">lock</span>
                                <div>
                                    <h4 class="cookie-setting-title">{{ __('common.essential_cookies') }}</h4>
                                    <p class="cookie-setting-subtitle">{{ __('common.essential_cookies_required') }}</p>
                                </div>
                            </div>
                            <label class="cookie-toggle cookie-toggle-disabled"
                                aria-label="Essential cookies (required)">
                                <input type="checkbox" id="essential_cookies" checked disabled aria-disabled="true"
                                    class="cookie-toggle-input">
                                <span class="cookie-toggle-slider"></span>
                            </label>
                        </div>
                        <p class="cookie-setting-desc">{{ __('common.essential_cookies_desc') }}</p>
                    </div>

                    <div class="cookie-setting-item">
                        <div class="cookie-setting-header">
                            <div class="cookie-setting-info">
                                <span class="material-symbols-outlined cookie-setting-icon cookie-icon-analytics"
                                    aria-hidden="true">analytics</span>
                                <div>
                                    <h4 class="cookie-setting-title">{{ __('common.analytics_cookies') }}</h4>
                                    <p class="cookie-setting-subtitle">{{ __('common.analytics_cookies_optional') }}</p>
                                </div>
                            </div>
                            <label class="cookie-toggle" aria-label="Analytics cookies">
                                <input type="checkbox" id="analytics_cookies" class="cookie-toggle-input">
                                <span class="cookie-toggle-slider"></span>
                            </label>
                        </div>
                        <p class="cookie-setting-desc">{{ __('common.analytics_cookies_desc') }}</p>
                    </div>

                    <div class="cookie-setting-item">
                        <div class="cookie-setting-header">
                            <div class="cookie-setting-info">
                                <span class="material-symbols-outlined cookie-setting-icon cookie-icon-marketing"
                                    aria-hidden="true">campaign</span>
                                <div>
                                    <h4 class="cookie-setting-title">{{ __('common.marketing_cookies') }}</h4>
                                    <p class="cookie-setting-subtitle">{{ __('common.marketing_cookies_optional') }}</p>
                                </div>
                            </div>
                            <label class="cookie-toggle" aria-label="Marketing cookies">
                                <input type="checkbox" id="marketing_cookies" class="cookie-toggle-input">
                                <span class="cookie-toggle-slider"></span>
                            </label>
                        </div>
                        <p class="cookie-setting-desc">{{ __('common.marketing_cookies_desc') }}</p>
                    </div>
                </div>

                <div class="cookie-modal-actions">
                    <button onclick="saveCookieSettings()" class="cookie-btn cookie-btn-primary"
                        aria-label="{{ __('common.save_preferences') }}">
                        {{ __('common.save_preferences') }}
                    </button>
                    <button onclick="acceptAllCookies()" class="cookie-btn cookie-btn-secondary"
                        aria-label="{{ __('common.accept_all_cookies') }}">
                        {{ __('common.accept_all_cookies') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Privacy Policy Modal -->
    <div id="privacyPolicyModal" class="cookie-modal hidden" role="dialog" aria-labelledby="privacy-title"
        aria-modal="true" aria-hidden="true">
        <div class="cookie-modal-overlay" aria-hidden="true"></div>
        <div class="cookie-modal-container cookie-modal-extra-large">
            <div class="cookie-modal-content">
                <div class="cookie-modal-header">
                    <div class="cookie-modal-title-group">
                        <span class="material-symbols-outlined cookie-icon" aria-hidden="true">privacy_tip</span>
                        <h3 id="privacy-title" class="cookie-modal-title">{{ __('common.privacy_policy') }}</h3>
                    </div>
                    <button onclick="closePrivacyPolicyModal()" class="cookie-close-btn"
                        aria-label="Close privacy policy">
                        <span class="material-symbols-outlined" aria-hidden="true">close</span>
                    </button>
                </div>
                <div class="cookie-modal-body">
                    @php
                        $currentLocaleForPage = app()->getLocale();
                        $privacyPage = \App\Models\Page::getBySlug('privacy-policy', $currentLocaleForPage);
                        if (!$privacyPage && $currentLocaleForPage !== 'en') {
                            $privacyPage = \App\Models\Page::getBySlug('privacy-policy', 'en');
                        }
                    @endphp
                    @if($privacyPage)
                        <div class="cookie-privacy-content">
                            <h2 class="cookie-privacy-heading">{{ $privacyPage->title }}</h2>
                            <div class="cookie-privacy-text">{!! nl2br(e($privacyPage->content)) !!}</div>
                        </div>
                    @else
                        <p class="cookie-modal-text">{{ __('common.privacy_policy') }}
                            {{ __('common.content_is_being_updated') ?? 'content is being updated. Please check back soon.' }}
                        </p>
                    @endif
                </div>
                <div class="cookie-modal-actions cookie-modal-actions-footer">
                    <button onclick="closePrivacyPolicyModal()" class="cookie-btn cookie-btn-primary"
                        aria-label="{{ __('common.back_to_cookie_settings') }}">
                        {{ __('common.back_to_cookie_settings') }}
                    </button>
                    <button onclick="acceptAllCookiesFromPrivacy()" class="cookie-btn cookie-btn-secondary"
                        aria-label="{{ __('common.accept_all') }}">
                        {{ __('common.accept_all') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Optimized CSS (Add to your stylesheet, not inline) -->
    <style>
        /* Cookie Modal Styles - Optimized */
        .cookie-modal {
            position: fixed;
            inset: 0;
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
            pointer-events: none;
        }

        .cookie-modal:not(.hidden) {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        .cookie-modal-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(2px);
        }

        .cookie-modal-container {
            position: relative;
            width: 100%;
            max-width: 30rem;
            max-height: 90vh;
            overflow-y: auto;
            transform: scale(0.95);
            transition: transform 0.3s ease;
        }

        .cookie-modal:not(.hidden) .cookie-modal-container {
            transform: scale(1);
        }

        .cookie-modal-large {
            max-width: 34rem;
        }

        .cookie-modal-extra-large {
            max-width: 44rem;
        }

        .cookie-modal-content {
            background: white;
            border-radius: 1.25rem;
            border: 1px solid rgba(226, 232, 240, 0.95);
            box-shadow:
                0 0 0 1px rgba(255, 255, 255, 0.8) inset,
                0 28px 60px -24px rgba(15, 23, 42, 0.35),
                0 0 50px -20px rgba(19, 127, 236, 0.15);
            padding: 1.75rem 1.5rem;
        }

        @media (prefers-color-scheme: dark) {
            .cookie-modal-content {
                background: #0f172a;
            }
        }

        .cookie-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            margin-bottom: 1.15rem;
        }

        .cookie-modal-title-group {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .cookie-icon {
            font-size: 1.5rem;
            color: var(--primary-color, #3b82f6);
        }

        .cookie-modal-title {
            font-family: "Fraunces", Georgia, serif;
            font-size: 1.35rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: #0f172a;
            margin: 0;
        }

        @media (prefers-color-scheme: dark) {
            .cookie-modal-title {
                color: white;
            }
        }

        .cookie-close-btn {
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            padding: 0.25rem;
            display: flex;
            align-items: center;
            transition: color 0.2s;
        }

        .cookie-close-btn:hover {
            color: #374151;
        }

        @media (prefers-color-scheme: dark) {
            .cookie-close-btn {
                color: #9ca3af;
            }

            .cookie-close-btn:hover {
                color: #e5e7eb;
            }
        }

        .cookie-modal-text {
            color: #475569;
            font-size: 0.875rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        @media (prefers-color-scheme: dark) {
            .cookie-modal-text {
                color: #94a3b8;
            }
        }

        .cookie-link {
            color: var(--primary-color, #3b82f6);
            text-decoration: underline;
            transition: opacity 0.2s;
        }

        .cookie-link:hover {
            opacity: 0.8;
        }

        .cookie-modal-actions {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }

        .cookie-btn {
            width: 100%;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .cookie-btn-primary {
            background: linear-gradient(135deg, #137fec 0%, #2563eb 100%);
            color: white;
            box-shadow: 0 12px 28px -14px rgba(19, 127, 236, 0.65);
        }

        .cookie-btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .cookie-btn-secondary {
            background: #e5e7eb;
            color: #374151;
        }

        @media (prefers-color-scheme: dark) {
            .cookie-btn-secondary {
                background: #1e293b;
                color: #cbd5e1;
            }
        }

        .cookie-btn-secondary:hover {
            background: #d1d5db;
        }

        @media (prefers-color-scheme: dark) {
            .cookie-btn-secondary:hover {
                background: #334155;
            }
        }

        .cookie-settings-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .cookie-setting-item {
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 1rem;
        }

        @media (prefers-color-scheme: dark) {
            .cookie-setting-item {
                border-color: #334155;
            }
        }

        .cookie-setting-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .cookie-setting-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex: 1;
        }

        .cookie-setting-icon {
            font-size: 1.25rem;
        }

        .cookie-icon-essential {
            color: var(--primary-color, #3b82f6);
        }

        .cookie-icon-analytics {
            color: #3b82f6;
        }

        .cookie-icon-marketing {
            color: #10b981;
        }

        .cookie-setting-title {
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 0.25rem 0;
            font-size: 1rem;
        }

        @media (prefers-color-scheme: dark) {
            .cookie-setting-title {
                color: white;
            }
        }

        .cookie-setting-subtitle {
            font-size: 0.75rem;
            color: #64748b;
            margin: 0;
        }

        @media (prefers-color-scheme: dark) {
            .cookie-setting-subtitle {
                color: #94a3b8;
            }
        }

        .cookie-setting-desc {
            font-size: 0.75rem;
            color: #475569;
            margin: 0.5rem 0 0 0;
            line-height: 1.5;
        }

        @media (prefers-color-scheme: dark) {
            .cookie-setting-desc {
                color: #94a3b8;
            }
        }

        .cookie-toggle {
            position: relative;
            display: inline-flex;
            align-items: center;
            width: 2.75rem;
            height: 1.5rem;
            cursor: pointer;
        }

        .cookie-toggle-disabled {
            cursor: not-allowed;
            opacity: 0.6;
        }

        .cookie-toggle-input {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .cookie-toggle-slider {
            position: absolute;
            inset: 0;
            background: #e5e7eb;
            border-radius: 9999px;
            transition: background 0.3s;
        }

        @media (prefers-color-scheme: dark) {
            .cookie-toggle-slider {
                background: #1e293b;
            }
        }

        .cookie-toggle-slider::before {
            content: '';
            position: absolute;
            height: 1.25rem;
            width: 1.25rem;
            left: 0.125rem;
            top: 0.125rem;
            background: white;
            border-radius: 50%;
            transition: transform 0.3s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        @media (prefers-color-scheme: dark) {
            .cookie-toggle-slider::before {
                background: #cbd5e1;
            }
        }

        .cookie-toggle-input:checked+.cookie-toggle-slider {
            background: var(--primary-color, #3b82f6);
        }

        .cookie-toggle-input:checked+.cookie-toggle-slider::before {
            transform: translateX(1.25rem);
        }

        .cookie-modal-body {
            max-height: 60vh;
            overflow-y: auto;
            margin-bottom: 1.5rem;
        }

        .cookie-privacy-content {
            color: #475569;
        }

        @media (prefers-color-scheme: dark) {
            .cookie-privacy-content {
                color: #94a3b8;
            }
        }

        .cookie-privacy-heading {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 1rem;
        }

        @media (prefers-color-scheme: dark) {
            .cookie-privacy-heading {
                color: white;
            }
        }

        .cookie-privacy-text {
            white-space: pre-wrap;
            line-height: 1.6;
            font-size: 0.875rem;
        }

        .cookie-modal-actions-footer {
            border-top: 1px solid #e2e8f0;
            padding-top: 1.5rem;
            margin-top: 1.5rem;
        }

        @media (prefers-color-scheme: dark) {
            .cookie-modal-actions-footer {
                border-color: #334155;
            }
        }

        /* Prevent body scroll - Better performance */
        body.cookie-modal-open {
            overflow: hidden;
            position: fixed;
            width: 100%;
            height: 100%;
        }

        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {

            .cookie-modal,
            .cookie-modal-container,
            .cookie-btn {
                transition: none;
            }
        }
    </style>

    <!-- Home ticker + stats + unique image logic -->
    <script>
            (function () {
                'use strict';

                function hashStr(str) {
                    str = String(str || '');
                    var h = 0;
                    for (var i = 0; i < str.length; i++) h = ((h << 5) - h) + str.charCodeAt(i), h |= 0;
                    return Math.abs(h);
                }

                function normalizeSrc(src) {
                    if (!src) return '';
                    return String(src).split('?')[0].split('#')[0].trim();
                }

                function extractBgUrl(el) {
                    try {
                        var bg = el && el.style ? el.style.backgroundImage : '';
                        if (!bg) return '';
                        if (bg.indexOf('/images/photo-') === -1) return '';
                        var m = bg.match(/url\((['"]?)(.*?)\1\)/);
                        return m && m[2] ? m[2] : '';
                    } catch (e) {
                        return '';
                    }
                }

                function classifyCategory(el) {
                    if (!el) return 'other';
                    var anc = el.closest('section, article, div, a') || el.parentElement || el;
                    var txt = '';
                    try {
                        txt = (anc && anc.textContent ? anc.textContent : '') + ' ' + (anc.id || '') + ' ' + (anc.className || '');
                    } catch (e) {
                        txt = '';
                    }
                    txt = String(txt || '').toLowerCase();

                    if (txt.indexOf('insight') !== -1) return 'insight';
                    if (txt.indexOf('sub') !== -1 && txt.indexOf('service') !== -1) return 'sub-service';
                    if (txt.indexOf('service') !== -1) return 'service';
                    return 'other';
                }

                function generateUnsplashUrl(keywords, seed) {
                    var pools = {
                        service: [
                            'photo-1554224155-6726b3ff858f',
                            'photo-1454165804606-c3d57bc86b40',
                            'photo-1553729459-efe14ef6055d',
                            'photo-1520607162513-77705c0f0d4a',
                            'photo-1556155092-490a1ba16284',
                            'photo-1460925895917-afdab827c52f'
                        ],
                        'sub-service': [
                            'photo-1554224154-26032ffc0d07',
                            'photo-1450101499163-c8848c66ca85',
                            'photo-1521737604893-d14cc237f11d',
                            'photo-1450101215322-bf5cd27642fc',
                            'photo-1579621970795-87facc2f976d',
                            'photo-1556740749-887f6717d7e4'
                        ],
                        insight: [
                            'photo-1460925895917-afdab827c52f',
                            'photo-1543286386-713bdd548da4',
                            'photo-1551288049-bebda4e38f71',
                            'photo-1518186285589-2f7649de83e0',
                            'photo-1526628953301-3e589a6a8b74',
                            'photo-1556157382-97eda2d62296'
                        ]
                    };
                    var type = String(seed || '').split(':')[0];
                    var pool = pools[type] || pools.service;
                    var idx = hashStr(String(seed || '0')) % pool.length;
                    return @json(asset('images')) + '/' + pool[idx] + '.jpg';
                }

                function syncTopServicesTicker() {
                    var ticker = document.getElementById('topServicesTicker');
                    if (!ticker) return;
                    var track = ticker.querySelector('.top-services-track');
                    if (!track) return;
                    var header = document.querySelector('.premium-header');
                    var chrome = document.getElementById('siteFixedChrome');

                    document.body.classList.add('has-top-services');

                    function sync() {
                        var totalWidth = track.scrollWidth || 0;
                        if (totalWidth) {
                            track.style.setProperty('--top-services-distance', Math.round(totalWidth / 2) + 'px');
                        }
                        if (header) {
                            var headerHeight = Math.round(header.getBoundingClientRect().height || 76);
                            document.documentElement.style.setProperty('--header-height', headerHeight + 'px');
                        }
                        if (chrome) {
                            var chromeHeight = Math.round(chrome.getBoundingClientRect().height || 0);
                            if (chromeHeight > 0) {
                                document.documentElement.style.setProperty('--chrome-height', chromeHeight + 'px');
                            }
                        }
                    }

                    sync();
                    window.addEventListener('resize', sync, { passive: true });
                    window.addEventListener('load', sync, { once: true });
                    window.addEventListener('pageshow', sync);
                    window.addEventListener('scroll', sync, { passive: true });
                }

                function pinSiteChrome() {
                    var chrome = document.getElementById('siteFixedChrome');
                    if (!chrome) return;

                    if (chrome.parentElement !== document.body) {
                        document.body.prepend(chrome);
                    }

                    chrome.style.setProperty('position', 'fixed', 'important');
                    chrome.style.setProperty('top', '0', 'important');
                    chrome.style.setProperty('left', '0', 'important');
                    chrome.style.setProperty('right', '0', 'important');
                    chrome.style.setProperty('bottom', 'auto', 'important');
                    chrome.style.setProperty('width', '100vw', 'important');
                    chrome.style.setProperty('max-width', '100vw', 'important');
                    chrome.style.setProperty('z-index', '1000000', 'important');
                    chrome.style.setProperty('transform', 'none', 'important');
                    chrome.style.setProperty('translate', 'none', 'important');
                    chrome.style.setProperty('margin', '0', 'important');
                    chrome.style.setProperty('overflow', 'visible', 'important');
                }

                function initHomeStatsTable() {
                    if (!document.body.classList.contains('is-home')) return;
                    if (document.getElementById('homeStatsTableWrap')) return;

                    var main = document.querySelector('main');
                    if (!main) return;

                    var servicesLabel = {!! json_encode(__('common.services')) !!};
                    servicesLabel = (servicesLabel || '').toString().toLowerCase();

                    var candidates = main.querySelectorAll('section, article, div');
                    var anchor = null;
                    for (var i = 0; i < candidates.length; i++) {
                        var t = (candidates[i].textContent || '').toString().trim().toLowerCase();
                        if (!t) continue;
                        if (t.indexOf(servicesLabel) !== -1 || t.indexOf('services') !== -1) {
                            anchor = candidates[i];
                            break;
                        }
                    }

                    var wrap = document.createElement('section');
                    wrap.id = 'homeStatsTableWrap';
                    wrap.className = 'home-stats-table-wrap premium-reveal';
                    wrap.setAttribute('aria-label', 'Company stats');

                    wrap.innerHTML = "\
            <div class=\"max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-10 py-10 sm:py-14\">\
              <table class=\"home-stats-table\" role=\"table\" aria-label=\"Active customers and satisfaction\">\
                <tbody>\
                  <tr class=\"home-stats-head\">\
                    <td colspan=\"2\">\
                      <div class=\"flex items-center justify-between gap-4 flex-wrap\">\
                        <span class=\"home-stats-kicker\"><span class=\"home-stats-kicker-dot\"></span>Trusted Performance</span>\
                        <span class=\"home-stats-meta\">Real-time client confidence snapshot</span>\
                      </div>\
                    </td>\
                  </tr>\
                  <tr class=\"home-stats-row premium-lift section-sheen\">\
                    <td><span class=\"home-stats-label\">Active Customers</span><span class=\"home-stats-note\">Consistent support across client engagements</span></td>\
                    <td class=\"home-stats-value\" style=\"text-align:right;\">\
                      <div class=\"home-stats-meta\">Live Growth</div>\
                      <span class=\"home-stats-value\" data-target=\"150\" data-suffix=\"+\" data-from=\"65\">0</span>\
                    </td>\
                  </tr>\
                  <tr class=\"home-stats-row premium-lift section-sheen\">\
                    <td><span class=\"home-stats-label\">Enterprises</span><span class=\"home-stats-note\">Trusted by expanding businesses and groups</span></td>\
                    <td class=\"home-stats-value\" style=\"text-align:right;\">\
                      <div class=\"home-stats-meta\">Scale Ready</div>\
                      <span class=\"home-stats-value\" data-target=\"300\" data-suffix=\"+\" data-from=\"180\">0</span>\
                    </td>\
                  </tr>\
                  <tr class=\"home-stats-row premium-lift section-sheen\">\
                    <td><span class=\"home-stats-label\">Satisfaction</span><span class=\"home-stats-note\">High-retention experience with responsive delivery</span></td>\
                    <td class=\"home-stats-value\" style=\"text-align:right;\">\
                      <div class=\"home-stats-meta\">Client Confidence</div>\
                      <span class=\"home-stats-value\" data-target=\"98\" data-suffix=\"%\" data-from=\"78\">0</span>\
                    </td>\
                  </tr>\
                  <tr class=\"home-stats-row premium-lift section-sheen\">\
                    <td><span class=\"home-stats-label\">24/7 Availability</span><span class=\"home-stats-note\">Always-on access when urgent decisions matter</span></td>\
                    <td class=\"home-stats-value\" style=\"text-align:right;\">\
                      <div class=\"home-stats-meta\">Always On</div>\
                      <span class=\"home-stats-value\" data-target=\"24\" data-suffix=\"/7\" data-from=\"10\">0</span>\
                    </td>\
                  </tr>\
                </tbody>\
              </table>\
              <div class=\"mt-4 text-xs sm:text-sm text-slate-500\">A premium, executive-style snapshot of client trust and availability.</div>\
            </div>\
        ";

                    if (anchor && anchor.parentNode) {
                        anchor.insertAdjacentElement('afterend', wrap);
                    } else {
                        main.appendChild(wrap);
                    }

                    var values = wrap.querySelectorAll('[data-target]');
                    if (!values.length) return;

                    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

                    function start() {
                        wrap.classList.add('visible');

                        if (reduce) {
                            values.forEach(function (span) {
                                var t = parseFloat(span.getAttribute('data-target') || '0');
                                var suffix = span.getAttribute('data-suffix') || '';
                                span.textContent = String(Math.round(t)) + suffix;
                            });
                            return;
                        }

                        var fmt = new Intl.NumberFormat('en');
                        var duration = 1200;
                        var startedAt = null;

                        function step(ts) {
                            if (!startedAt) startedAt = ts;
                            var p = Math.min((ts - startedAt) / duration, 1);
                            var eased = 1 - Math.pow(1 - p, 3); // ease-out

                            values.forEach(function (span) {
                                var t = parseFloat(span.getAttribute('data-target') || '0');
                                var from = parseFloat(span.getAttribute('data-from') || '0');
                                var suffix = span.getAttribute('data-suffix') || '';
                                var current = from + (t - from) * eased;
                                span.textContent = fmt.format(Math.round(current)) + suffix;
                            });

                            if (p < 1) {
                                window.requestAnimationFrame(step);
                            }
                        }

                        window.requestAnimationFrame(step);
                    }

                    var io = new IntersectionObserver(function (entries) {
                        entries.forEach(function (e) {
                            if (!e.isIntersecting) return;
                            start();
                            io.unobserve(e.target);
                        });
                    }, { threshold: 0.25, rootMargin: '0px 0px -10% 0px' });

                    io.observe(wrap);
                }

                function initServiceImageDiversity() {
                    if (!document.body.classList.contains('is-home')) return;
                    if (window.__serviceImageDiversityDone) return;
                    window.__serviceImageDiversityDone = true;

                    var main = document.querySelector('main') || document.body;

                    var imgs = Array.prototype.slice.call(main.querySelectorAll('img'));
                    var bgEls = Array.prototype.slice.call(main.querySelectorAll('[style]'));

                    var items = [];

                    imgs.forEach(function (img, idx) {
                        if (!img) return;
                        var src = img.getAttribute('src') || img.src || '';
                        src = normalizeSrc(src);
                        if (!src) return;
                        var lower = src.toLowerCase();
                        if (lower.indexOf('/images/photo-') === -1) return;

                        if (img.closest('#topServicesTicker')) return;
                        if (img.closest('.premium-header')) return;
                        if (img.closest('.home-hero-root')) return;

                        items.push({ kind: 'img', el: img, src: src, idx: idx, category: classifyCategory(img) });
                    });

                    bgEls.forEach(function (el, idx) {
                        if (!el || !el.style) return;
                        var bgUrl = extractBgUrl(el);
                        if (!bgUrl) return;
                        var src = normalizeSrc(bgUrl);
                        if (!src) return;
                        if (el.closest('#topServicesTicker')) return;
                        if (el.closest('.premium-header')) return;
                        if (el.closest('.home-hero-root')) return;
                        items.push({ kind: 'bg', el: el, src: src, idx: items.length, category: classifyCategory(el) });
                    });

                    if (!items.length) return;

                    // Replace every Service / Sub-service / Insight image with a themed charted/accounted image
                    // and a unique `sig`, so pictures don't repeat across those sections.
                    items.forEach(function (it) {
                        var cat = it.category;
                        if (cat !== 'service' && cat !== 'sub-service' && cat !== 'insight') return;

                        var around = '';
                        try {
                            var anc = it.el.closest('section, article, div, a') || it.el.parentElement;
                            around = anc && anc.textContent ? anc.textContent : '';
                        } catch (e) {
                            around = '';
                        }

                        around = String(around || '').toLowerCase();

                        var base = [];
                        if (cat === 'service') base = ['accounting', 'audit', 'charted', 'accounted', 'compliance', 'finance'];
                        else if (cat === 'sub-service') base = ['ledger', 'documents', 'accounting', 'audit', 'charted', 'accounted'];
                        else if (cat === 'insight') base = ['chart', 'report', 'analysis', 'financial', 'charted', 'accounted'];
                        else base = ['accounting', 'audit', 'charted', 'accounted', 'finance'];

                        var extra = [];
                        if (around.indexOf('vat') !== -1) extra.push('vat');
                        if (around.indexOf('payroll') !== -1) extra.push('payroll');
                        if (around.indexOf('hr') !== -1) extra.push('hr');
                        if (around.indexOf('audit') !== -1) extra.push('audit');
                        if (around.indexOf('tax') !== -1) extra.push('tax');
                        if (around.indexOf('business') !== -1) extra.push('business');
                        if (around.indexOf('company') !== -1) extra.push('company formation');

                        var keywords = base.concat(extra);
                        keywords.push('charted', 'accounted', 'accounting');

                        var seed = cat + ':' + it.idx + ':' + hashStr(it.src);
                        var url = generateUnsplashUrl(keywords, seed);

                        try {
                            if (it.kind === 'img') {
                                it.el.src = url;
                            } else {
                                it.el.style.backgroundImage = "url('" + url + "')";
                            }
                        } catch (e) {
                            // no-op
                        }
                    });
                }

                function initGlobalPremiumMotion() {
                    var root = document.querySelector('main');
                    if (!root) return;

                    var revealSelector = [
                        'main > section',
                        'main article',
                        '[class*="card"]',
                        '[class*="panel"]',
                        '[class*="service"]',
                        '[class*="feature"]',
                        '.home-stats-table-wrap'
                    ].join(', ');

                    var revealTargets = Array.prototype.slice.call(root.querySelectorAll(revealSelector))
                        .filter(function (el) {
                            return el && !el.closest('.home-hero-root');
                        });

                    revealTargets.forEach(function (el) {
                        el.classList.add('premium-reveal');
                    });

                    var liftSelector = [
                        '.header-cta-premium',
                        '.hero-cta-premium',
                        '[class*="card"]',
                        '[class*="panel"]',
                        '[class*="service"]'
                    ].join(', ');

                    Array.prototype.slice.call(document.querySelectorAll(liftSelector)).forEach(function (el) {
                        // Never lift body/html: a transform there breaks position:fixed
                        // children (header, chatbot) by making body the containing block.
                        if (el === document.body || el === document.documentElement) return;
                        if (el.closest('.top-services-ticker')) return;
                        if (el.closest('#ai-chatbot-widget')) return;
                        el.classList.add('premium-lift');
                    });
                    document.body.classList.remove('premium-lift');

                    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                    if (reduce) {
                        revealTargets.forEach(function (el) { el.classList.add('is-visible'); });
                        return;
                    }

                    var io = new IntersectionObserver(function (entries) {
                        entries.forEach(function (entry) {
                            if (!entry.isIntersecting) return;
                            entry.target.classList.add('is-visible');
                            io.unobserve(entry.target);
                        });
                    }, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' });

                    revealTargets.forEach(function (el) { io.observe(el); });
                }

                function initHomeGrowthChart() {
                    var chart = document.querySelector('.home-growth-chart');
                    if (!chart) return;
                    if (!('IntersectionObserver' in window)) {
                        chart.classList.add('chart-visible');
                        return;
                    }
                    var io = new IntersectionObserver(function (entries) {
                        entries.forEach(function (entry) {
                            if (entry.isIntersecting) {
                                chart.classList.add('chart-visible');
                                io.unobserve(entry.target);
                            }
                        });
                    }, { threshold: 0.35 });
                    io.observe(chart);
                }

                function initLuxuryHeaderScroll() {
                    var header = document.getElementById('siteHeader');
                    if (!header) return;

                    function update() {
                        var scrolled = window.scrollY > 24;
                        header.classList.toggle('header-scrolled', scrolled);
                    }

                    update();
                    window.addEventListener('scroll', update, { passive: true });
                    window.addEventListener('resize', update, { passive: true });
                }

                document.addEventListener('DOMContentLoaded', function () {
                    pinSiteChrome();
                    syncTopServicesTicker();
                    initHomeStatsTable();
                    initServiceImageDiversity();
                    initGlobalPremiumMotion();
                    initLuxuryHeaderScroll();
                    initHomeGrowthChart();
                    window.addEventListener('scroll', pinSiteChrome, { passive: true });
                    window.addEventListener('resize', pinSiteChrome, { passive: true });
                });
            })();
    </script>

    <!-- Optimized JavaScript - Deferred Loading -->
    <script>
        (function () {
            'use strict';

            // Cache DOM elements for better performance
            const elements = {
                consentModal: null,
                settingsModal: null,
                privacyModal: null,
                analyticsCheckbox: null,
                marketingCheckbox: null
            };

            // Initialize DOM cache (called after DOM is ready)
            function initElements() {
                elements.consentModal = document.getElementById('cookieConsentModal');
                elements.settingsModal = document.getElementById('cookieSettingsModal');
                elements.privacyModal = document.getElementById('privacyPolicyModal');
                elements.analyticsCheckbox = document.getElementById('analytics_cookies');
                elements.marketingCheckbox = document.getElementById('marketing_cookies');
            }

            // Optimized cookie functions
            function setCookie(name, value, days) {
                const expires = new Date();
                expires.setTime(expires.getTime() + days * 24 * 60 * 60 * 1000);
                document.cookie = `${name}=${value};expires=${expires.toUTCString()};path=/;SameSite=Lax`;
            }

            function getCookie(name) {
                const nameEQ = `${name}=`;
                const cookies = document.cookie.split(';');
                for (let i = 0; i < cookies.length; i++) {
                    let cookie = cookies[i].trim();
                    if (cookie.indexOf(nameEQ) === 0) {
                        return cookie.substring(nameEQ.length);
                    }
                }
                return null;
            }

            // Better scroll lock implementation
            function lockBodyScroll() {
                const scrollY = window.scrollY;
                document.body.style.position = 'fixed';
                document.body.style.top = `-${scrollY}px`;
                document.body.style.width = '100%';
                document.body.classList.add('cookie-modal-open');
                document.documentElement.style.scrollBehavior = 'auto';
            }

            function unlockBodyScroll() {
                const scrollY = document.body.style.top;
                document.body.style.position = '';
                document.body.style.top = '';
                document.body.style.width = '';
                document.body.classList.remove('cookie-modal-open');
                document.documentElement.style.scrollBehavior = '';
                if (scrollY) {
                    window.scrollTo(0, parseInt(scrollY || '0') * -1);
                }
            }

            // Modal management with better performance
            function showModal(modal) {
                if (!modal) return;
                modal.classList.remove('hidden');
                modal.setAttribute('aria-hidden', 'false');
                lockBodyScroll();
            }

            function hideModal(modal) {
                if (!modal) return;
                modal.classList.add('hidden');
                modal.setAttribute('aria-hidden', 'true');
            }

            function hideAllModals() {
                hideModal(elements.consentModal);
                hideModal(elements.settingsModal);
                hideModal(elements.privacyModal);
                unlockBodyScroll();
            }

            // Cookie consent functions
            window.acceptAllCookies = function () {
                const cookiePreferences = {
                    essential: true,
                    analytics: true,
                    marketing: true
                };
                sessionStorage.setItem('cookie_consent', 'accepted');
                sessionStorage.setItem('cookie_preferences', JSON.stringify(cookiePreferences));
                setCookie('cookie_consent', '', -1); // Remove old cookie
                hideAllModals();
            };

            window.acceptAllCookiesFromPrivacy = function () {
                window.acceptAllCookies();
            };

            window.openCookieSettings = function () {
                hideModal(elements.consentModal);
                showModal(elements.settingsModal);

                // Restore saved preferences
                const savedPrefs = sessionStorage.getItem('cookie_preferences');
                if (savedPrefs) {
                    try {
                        const prefs = JSON.parse(savedPrefs);
                        if (elements.analyticsCheckbox) {
                            elements.analyticsCheckbox.checked = prefs.analytics || false;
                        }
                        if (elements.marketingCheckbox) {
                            elements.marketingCheckbox.checked = prefs.marketing || false;
                        }
                    } catch (e) {
                        console.warn('Error parsing cookie preferences:', e);
                    }
                } else {
                    if (elements.analyticsCheckbox) elements.analyticsCheckbox.checked = false;
                    if (elements.marketingCheckbox) elements.marketingCheckbox.checked = false;
                }
            };

            window.closeCookieSettings = function () {
                hideModal(elements.settingsModal);
                showModal(elements.consentModal);
            };

            window.openPrivacyPolicyModal = function () {
                hideModal(elements.consentModal);
                hideModal(elements.settingsModal);
                showModal(elements.privacyModal);
            };

            window.closePrivacyPolicyModal = function () {
                hideModal(elements.privacyModal);
                // Return to settings if it was open, otherwise consent modal
                if (elements.settingsModal && !elements.settingsModal.classList.contains('hidden')) {
                    // Settings was open, do nothing (it's already visible)
                } else {
                    showModal(elements.consentModal);
                }
            };

            window.saveCookieSettings = function () {
                const cookiePreferences = {
                    essential: true,
                    analytics: elements.analyticsCheckbox ? elements.analyticsCheckbox.checked : false,
                    marketing: elements.marketingCheckbox ? elements.marketingCheckbox.checked : false
                };
                sessionStorage.setItem('cookie_consent', 'accepted');
                sessionStorage.setItem('cookie_preferences', JSON.stringify(cookiePreferences));
                setCookie('cookie_consent', '', -1); // Remove old cookie
                hideAllModals();
            };

            // Initialize on DOM ready - Deferred for better performance
            function initCookieConsent() {
                initElements();

                const consent = sessionStorage.getItem('cookie_consent');
                const oldCookie = getCookie('cookie_consent');

                // Clean up old cookie
                if (oldCookie) {
                    setCookie('cookie_consent', '', -1);
                }

                // Show modal if consent not given
                if (!consent) {
                    // Use requestIdleCallback for better performance (fallback to setTimeout)
                    if ('requestIdleCallback' in window) {
                        requestIdleCallback(() => {
                            showModal(elements.consentModal);
                        }, { timeout: 2000 });
                    } else {
                        setTimeout(() => {
                            showModal(elements.consentModal);
                        }, 100);
                    }
                }
            }

            // Load after page content (better for LCP)
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initCookieConsent);
            } else {
                // Use requestIdleCallback to not block rendering
                if ('requestIdleCallback' in window) {
                    requestIdleCallback(initCookieConsent, { timeout: 2000 });
                } else {
                    setTimeout(initCookieConsent, 100);
                }
            }

            // Handle escape key for accessibility
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    if (elements.privacyModal && !elements.privacyModal.classList.contains('hidden')) {
                        window.closePrivacyPolicyModal();
                    } else if (elements.settingsModal && !elements.settingsModal.classList.contains('hidden')) {
                        window.closeCookieSettings();
                    }
                }
            });

            // Close modal on overlay click
            document.addEventListener('click', function (e) {
                if (e.target.classList.contains('cookie-modal-overlay')) {
                    const modal = e.target.closest('.cookie-modal');
                    if (modal === elements.settingsModal) {
                        window.closeCookieSettings();
                    } else if (modal === elements.privacyModal) {
                        window.closePrivacyPolicyModal();
                    }
                }
            });
        })();
    </script>



    @stack('scripts')

    @include('components.contact-modal')

    <!-- AI Chatbot -->
    @include('components.chatbot')

</body>

</html>
