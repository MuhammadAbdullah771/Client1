<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') | 9Associates</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#136dec",
                        "background-light": "#f6f7f8",
                        "background-dark": "#101822",
                        "navy-deep": "#0d141b",
                        "slate-muted": "#4c739a"
                    },
                    fontFamily: {
                        "display": ["Manrope", "sans-serif"]
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
        body {
            font-family: 'Manrope', sans-serif;
        }
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined';
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            font-feature-settings: 'liga';
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            overflow: visible !important;
            text-overflow: clip !important;
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
        main > * { min-width: 0; }
        .admin-table-scroll { min-width: 0; overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .break-words {
            word-wrap: break-word;
            word-break: break-word;
            overflow-wrap: break-word;
        }
        /* Ensure all cards contain their content properly */
        .bg-white, .dark\:bg-slate-900 {
            box-sizing: border-box;
        }
        /* Fix icon display - ensure icons render as icons, not text */
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined' !important;
            speak: none;
            font-style: normal;
            font-weight: normal;
            font-variant: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }
        /* Prevent text overflow in all admin containers */
        .rounded-xl, .rounded-lg {
            box-sizing: border-box;
        }
        /* Ensure proper text containment */
        p, span, div, h1, h2, h3, h4, h5, h6 {
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        /* Ensure all admin cards properly contain content */
        .rounded-xl, .rounded-lg {
            box-sizing: border-box;
            overflow: hidden;
        }
        /* Fix icon containers */
        [class*="w-14"], [class*="w-12"] {
            box-sizing: border-box;
            overflow: hidden;
        }
        /* Ensure Material Symbols render correctly */
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined' !important;
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 min-h-screen flex flex-col overflow-x-hidden transition-colors duration-300">
    @auth
    <header class="bg-background-dark border-b border-slate-800 px-4 sm:px-6 lg:px-8 py-3 sticky top-0 z-50 shrink-0">
        <div class="max-w-[1200px] mx-auto flex items-center justify-between gap-4 min-w-0">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 sm:gap-3 min-w-0">
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-primary flex items-center justify-center text-white font-black text-lg sm:text-xl shrink-0">
                    9A
                </div>
                <h1 class="text-white text-lg sm:text-xl font-bold tracking-tight truncate">9Associates</h1>
            </a>

            <nav class="hidden lg:flex items-center gap-6 xl:gap-8 shrink-0">
                <a class="{{ request()->routeIs('admin.dashboard') ? 'text-primary text-sm font-semibold border-b-2 border-primary pb-1' : 'text-slate-400 hover:text-white text-sm font-medium transition-colors whitespace-nowrap' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a class="{{ request()->routeIs('admin.services.*') ? 'text-primary text-sm font-semibold border-b-2 border-primary pb-1' : 'text-slate-400 hover:text-white text-sm font-medium transition-colors whitespace-nowrap' }}" href="{{ route('admin.services.index') }}">Services</a>
                <a class="{{ request()->routeIs('admin.leaders.*') ? 'text-primary text-sm font-semibold border-b-2 border-primary pb-1' : 'text-slate-400 hover:text-white text-sm font-medium transition-colors whitespace-nowrap' }}" href="{{ route('admin.leaders.index') }}">Leadership</a>
                <a class="{{ request()->routeIs('admin.milestones.*') ? 'text-primary text-sm font-semibold border-b-2 border-primary pb-1' : 'text-slate-400 hover:text-white text-sm font-medium transition-colors whitespace-nowrap' }}" href="{{ route('admin.milestones.index') }}">Milestones</a>
                <a class="{{ request()->routeIs('admin.jobs.*') ? 'text-primary text-sm font-semibold border-b-2 border-primary pb-1' : 'text-slate-400 hover:text-white text-sm font-medium transition-colors whitespace-nowrap' }}" href="{{ route('admin.jobs.index') }}">Career Paths</a>
                <a class="{{ request()->routeIs('admin.insights.*') ? 'text-primary text-sm font-semibold border-b-2 border-primary pb-1' : 'text-slate-400 hover:text-white text-sm font-medium transition-colors whitespace-nowrap' }}" href="{{ route('admin.insights.index') }}">Content</a>
                <a class="{{ request()->routeIs('admin.pages.*') ? 'text-primary text-sm font-semibold border-b-2 border-primary pb-1' : 'text-slate-400 hover:text-white text-sm font-medium transition-colors whitespace-nowrap' }}" href="{{ route('admin.pages.index') }}">Pages</a>
                <a class="{{ request()->routeIs('admin.contact-details.*') ? 'text-primary text-sm font-semibold border-b-2 border-primary pb-1' : 'text-slate-400 hover:text-white text-sm font-medium transition-colors whitespace-nowrap' }}" href="{{ route('admin.contact-details.edit') }}">Contact Details</a>
                <a class="{{ request()->routeIs('admin.settings.*') ? 'text-primary text-sm font-semibold border-b-2 border-primary pb-1' : 'text-slate-400 hover:text-white text-sm font-medium transition-colors whitespace-nowrap' }}" href="{{ route('admin.settings.index') }}">Settings</a>
            </nav>

            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                <button type="button" id="admin-mobile-menu-btn" class="lg:hidden flex items-center justify-center size-10 rounded-lg text-slate-400 hover:text-white hover:bg-slate-700/50 transition-colors" aria-label="Open menu" aria-expanded="false">
                    <span class="material-symbols-outlined text-2xl">menu</span>
                </button>
                <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="flex items-center justify-center size-9 sm:size-10 rounded-lg bg-slate-800 hover:bg-red-600 text-slate-300 hover:text-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-slate-900" title="Logout" aria-label="Logout">
                        <span class="material-symbols-outlined text-lg">logout</span>
                    </button>
                </form>
            </div>
        </div>

        <div id="admin-mobile-menu" class="lg:hidden hidden absolute left-0 right-0 top-full bg-background-dark border-b border-slate-800 shadow-xl max-h-[calc(100vh-3.5rem)] overflow-y-auto">
            <nav class="max-w-[1200px] mx-auto px-4 py-4 flex flex-col gap-1">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'text-primary bg-primary/10' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} rounded-lg px-4 py-3 text-sm font-medium transition-colors" href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a class="nav-link {{ request()->routeIs('admin.services.*') ? 'text-primary bg-primary/10' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} rounded-lg px-4 py-3 text-sm font-medium transition-colors" href="{{ route('admin.services.index') }}">Services</a>
                <a class="nav-link {{ request()->routeIs('admin.leaders.*') ? 'text-primary bg-primary/10' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} rounded-lg px-4 py-3 text-sm font-medium transition-colors" href="{{ route('admin.leaders.index') }}">Leadership</a>
                <a class="nav-link {{ request()->routeIs('admin.milestones.*') ? 'text-primary bg-primary/10' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} rounded-lg px-4 py-3 text-sm font-medium transition-colors" href="{{ route('admin.milestones.index') }}">Milestones</a>
                <a class="nav-link {{ request()->routeIs('admin.jobs.*') ? 'text-primary bg-primary/10' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} rounded-lg px-4 py-3 text-sm font-medium transition-colors" href="{{ route('admin.jobs.index') }}">Career Paths</a>
                <a class="nav-link {{ request()->routeIs('admin.insights.*') ? 'text-primary bg-primary/10' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} rounded-lg px-4 py-3 text-sm font-medium transition-colors" href="{{ route('admin.insights.index') }}">Content</a>
                <a class="nav-link {{ request()->routeIs('admin.pages.*') ? 'text-primary bg-primary/10' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} rounded-lg px-4 py-3 text-sm font-medium transition-colors" href="{{ route('admin.pages.index') }}">Pages</a>
                <a class="nav-link {{ request()->routeIs('admin.contact-details.*') ? 'text-primary bg-primary/10' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} rounded-lg px-4 py-3 text-sm font-medium transition-colors" href="{{ route('admin.contact-details.edit') }}">Contact Details</a>
                <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'text-primary bg-primary/10' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} rounded-lg px-4 py-3 text-sm font-medium transition-colors" href="{{ route('admin.settings.index') }}">Settings</a>
            </nav>
        </div>
    </header>
    @endauth

    <main class="flex-grow w-full max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-10 min-w-0">
        @if(session('success'))
        <div class="mb-6 flex items-center gap-3 rounded-xl border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/20 text-green-800 dark:text-green-200 px-4 py-3 shadow-sm" role="alert">
            <span class="material-symbols-outlined text-green-600 dark:text-green-400 shrink-0">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 flex items-center gap-3 rounded-xl border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/20 text-red-800 dark:text-red-200 px-4 py-3 shadow-sm" role="alert">
            <span class="material-symbols-outlined text-red-600 dark:text-red-400 shrink-0">error</span>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        @yield('content')
    </main>

    <footer class="mt-auto shrink-0 py-6 text-center border-t border-slate-200 dark:border-slate-800 text-slate-400 text-sm">
        <p>© {{ date('Y') }} 9Associates Admin. All rights reserved.</p>
    </footer>

    @auth
    <script>
        (function() {
            var btn = document.getElementById('admin-mobile-menu-btn');
            var menu = document.getElementById('admin-mobile-menu');
            if (btn && menu) {
                btn.addEventListener('click', function() {
                    var open = menu.classList.toggle('hidden');
                    btn.setAttribute('aria-expanded', open ? 'false' : 'true');
                    btn.querySelector('.material-symbols-outlined').textContent = open ? 'menu' : 'close';
                });
                menu.querySelectorAll('.nav-link').forEach(function(link) {
                    link.addEventListener('click', function() { menu.classList.add('hidden'); btn.setAttribute('aria-expanded', 'false'); btn.querySelector('.material-symbols-outlined').textContent = 'menu'; });
                });
            }
            
            // Session activity tracker - keeps session alive
            var lastActivity = Date.now();
            var sessionTimeout = {{ config('session.lifetime') * 60 * 1000 }}; // Convert minutes to milliseconds
            
            function updateActivity() {
                lastActivity = Date.now();
            }
            
            // Track user activity
            ['mousedown', 'keydown', 'scroll', 'touchstart'].forEach(function(event) {
                document.addEventListener(event, updateActivity, true);
            });
            
            // Ping server every 5 minutes to keep session alive
            setInterval(function() {
                if (Date.now() - lastActivity < 300000) { // If active in last 5 minutes
                    fetch('{{ route('admin.dashboard') }}', {
                        method: 'HEAD',
                        credentials: 'same-origin'
                    }).catch(function() {});
                }
            }, 300000); // 5 minutes
        })();
    </script>
    @endauth
    @stack('scripts')
</body>
</html>

