<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Website resmi Kelurahan Simomulyo — informasi, berita, UMKM, hotline, dan layanan warga terpadu.">
    <title>{{ config('app.name', 'Profil Desa') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    
    <script>
        // Check local storage or system preference before rendering to prevent flash
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }

        .nav-link {
            @apply relative text-sm text-slate-600 transition-colors duration-200 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white;
        }
        .nav-link.active { @apply text-slate-900 dark:text-white; }

        #mobile-menu { max-height: 0; overflow: hidden; transition: max-height 0.3s ease; }
        #mobile-menu.open { max-height: 400px; }

        /* Transparent Header Overrides (For Homepage Top) */
        #main-header.is-transparent .nav-link { color: rgba(255, 255, 255, 0.8) !important; }
        #main-header.is-transparent .nav-link:hover { color: #ffffff !important; }
        #main-header.is-transparent .nav-link.active { color: #ffffff !important; font-weight: 600; }
        #main-header.is-transparent .logo-text { color: #ffffff !important; }
        #main-header.is-transparent .theme-toggle, 
        #main-header.is-transparent #menu-toggle { color: rgba(255, 255, 255, 0.8) !important; }
        #main-header.is-transparent .theme-toggle:hover, 
        #main-header.is-transparent #menu-toggle:hover { color: #ffffff !important; }
        #main-header.is-transparent .admin-link { color: rgba(255, 255, 255, 0.8) !important; }
        #main-header.is-transparent .admin-link:hover { color: #ffffff !important; }
        
        /* Make Surabaya logo slightly white/brighter on transparent header by using brightness filter */
        #main-header.is-transparent .logo-img { filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5)); }
    </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100 transition-colors duration-300">

    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute left-[-20%] top-[-5%] h-[550px] w-[550px] rounded-full bg-emerald-500/10 blur-[130px] dark:bg-emerald-500/10"></div>
        <div class="absolute right-[-15%] top-[20%] h-[450px] w-[450px] rounded-full bg-cyan-500/10 blur-[130px] dark:bg-cyan-500/10"></div>
    </div>

    <header id="main-header" class="fixed inset-x-0 top-0 z-50 transition-all duration-500 border-b {{ request()->routeIs('home') ? 'is-transparent bg-transparent border-transparent' : 'bg-white/85 backdrop-blur-xl border-slate-200 dark:border-white/8 dark:bg-slate-950/85' }}">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">

                <a href="{{ route('home') }}" class="group flex items-center gap-3">
                    <img src="{{ asset('images/surabaya-logo.svg') }}" alt="Logo Surabaya" class="logo-img h-8 w-auto transition-all">
                    <span class="logo-text text-sm font-semibold uppercase tracking-[0.25em] text-slate-900 transition group-hover:text-emerald-500 dark:text-white dark:group-hover:text-emerald-300">Simomulyo</span>
                </a>

                <nav class="hidden items-center gap-6 md:flex">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                    <a href="{{ route('profile') }}" class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}">Profil</a>
                    <a href="{{ route('map') }}" class="nav-link {{ request()->routeIs('map') ? 'active' : '' }}">Peta</a>
                    <a href="{{ route('news') }}" class="nav-link {{ request()->routeIs('news*') ? 'active' : '' }}">Berita</a>
                    <a href="{{ route('products') }}" class="nav-link {{ request()->routeIs('products*') ? 'active' : '' }}">UMKM</a>
                    <a href="{{ route('documents') }}" class="nav-link {{ request()->routeIs('documents*') ? 'active' : '' }}">Surat Menyurat</a>
                    <a href="{{ route('budget.transparency') }}" class="nav-link {{ request()->routeIs('budget.transparency') ? 'active' : '' }}">Dana Desa</a>
                </nav>

                <div class="flex items-center gap-3">
                    <button onclick="toggleTheme()" class="theme-toggle p-2 rounded-full text-slate-500 hover:bg-slate-200 dark:text-slate-400 dark:hover:bg-white/10 transition" aria-label="Toggle Theme">
                        <svg id="theme-icon-dark" class="hidden h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg id="theme-icon-light" class="hidden h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </button>

                    <a href="{{ route('hotline') }}" class="hidden rounded border border-amber-500/30 bg-amber-500/10 px-4 py-2 text-sm font-medium text-amber-600 transition hover:bg-amber-500/20 dark:border-amber-400/30 dark:bg-amber-400/10 dark:text-amber-300 dark:hover:bg-amber-400/20 md:block">Hotline</a>
                    


                    <button id="menu-toggle" class="p-1 text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white md:hidden" onclick="toggleMenu()">
                        <span id="icon-open" class="block text-xl leading-none">☰</span>
                        <span id="icon-close" class="hidden text-xl leading-none">✕</span>
                    </button>
                </div>
            </div>

            <div id="mobile-menu" class="border-t border-slate-200 dark:border-white/8 md:hidden">
                <nav class="flex flex-col py-3">
                    <a href="{{ route('home') }}" class="px-2 py-2.5 text-sm text-slate-600 hover:text-slate-900 dark:text-slate-300 dark:hover:text-white">Beranda</a>
                    <a href="{{ route('profile') }}" class="px-2 py-2.5 text-sm text-slate-600 hover:text-slate-900 dark:text-slate-300 dark:hover:text-white">Profil Desa</a>
                    <a href="{{ route('map') }}" class="px-2 py-2.5 text-sm text-slate-600 hover:text-slate-900 dark:text-slate-300 dark:hover:text-white">Peta Desa</a>
                    <a href="{{ route('news') }}" class="px-2 py-2.5 text-sm text-slate-600 hover:text-slate-900 dark:text-slate-300 dark:hover:text-white">Berita</a>
                    <a href="{{ route('products') }}" class="px-2 py-2.5 text-sm text-slate-600 hover:text-slate-900 dark:text-slate-300 dark:hover:text-white">UMKM</a>
                    <a href="{{ route('documents') }}" class="px-2 py-2.5 text-sm text-slate-600 hover:text-slate-900 dark:text-slate-300 dark:hover:text-white">Surat Menyurat</a>
                    <a href="{{ route('budget.transparency') }}" class="px-2 py-2.5 text-sm text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300">Dana Desa</a>
                    <a href="{{ route('hotline') }}" class="mt-2 px-2 py-2.5 text-sm font-medium text-amber-600 dark:text-amber-300">Hotline Darurat</a>
                    

                </nav>
            </div>
        </div>
    </header>

    <main class="{{ request()->routeIs('home') ? '' : 'pt-16' }}">
        @yield('content')
    </main>

    <footer class="mt-20 border-t border-slate-200 dark:border-white/8 transition-colors duration-300">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-4">
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-2.5">
                        <img src="{{ asset('images/surabaya-logo.svg') }}" alt="Logo Surabaya" class="h-7 w-auto">
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-900 dark:text-white">Kelurahan Simomulyo</p>
                    </div>
                    <p class="mt-3 max-w-xs text-sm leading-7 text-slate-600 dark:text-slate-500">Sistem informasi desa yang terbuka, transparan, dan responsif untuk seluruh warga Simomulyo, Kota Surabaya.</p>
                </div>

                <div>
                    <p class="mb-4 text-xs font-semibold uppercase tracking-[0.15em] text-slate-800 dark:text-slate-600">Layanan</p>
                    <ul class="space-y-2.5 text-sm text-slate-600 dark:text-slate-500">
                        <li><a href="{{ route('profile') }}" class="transition hover:text-slate-900 dark:hover:text-slate-300">Profil Kelurahan</a></li>
                        <li><a href="{{ route('map') }}" class="transition hover:text-slate-900 dark:hover:text-slate-300">Peta Desa</a></li>
                        <li><a href="{{ route('news') }}" class="transition hover:text-slate-900 dark:hover:text-slate-300">Berita & Artikel</a></li>
                        <li><a href="{{ route('products') }}" class="transition hover:text-slate-900 dark:hover:text-slate-300">Produk UMKM</a></li>
                        <li><a href="{{ route('hotline') }}" class="transition hover:text-amber-600 dark:hover:text-amber-300">Hotline</a></li>
                    </ul>
                </div>

                <div>
                    <p class="mb-4 text-xs font-semibold uppercase tracking-[0.15em] text-slate-800 dark:text-slate-600">Kontak</p>
                    <ul class="space-y-2.5 text-sm text-slate-600 dark:text-slate-500">
                        <li>Kec. Sukomanunggal</li>
                        <li>Kota Surabaya, Jawa Timur</li>
                        <li class="pt-2"><a href="{{ route('hotline') }}" class="text-amber-600/90 transition hover:text-amber-500 dark:text-amber-400/80 dark:hover:text-amber-300">Buka Hotline &rarr;</a></li>
                    </ul>
                </div>
            </div>

            <div class="mt-10 border-t border-slate-200 dark:border-white/8 pt-6 flex flex-col items-start justify-between gap-3 text-xs text-slate-500 dark:text-slate-600 sm:flex-row sm:items-center">
                <p>© {{ date('Y') }} Kelurahan Simomulyo. Semua hak dilindungi.</p>
                <a href="{{ route('login') }}" class="transition hover:text-slate-800 dark:hover:text-slate-400">Portal Admin</a>
            </div>
        </div>
    </footer>

    <script>
        // Update theme icons
        function updateThemeIcon() {
            const isDark = document.documentElement.classList.contains('dark');
            if (isDark) {
                document.getElementById('theme-icon-light').classList.remove('hidden');
                document.getElementById('theme-icon-dark').classList.add('hidden');
            } else {
                document.getElementById('theme-icon-dark').classList.remove('hidden');
                document.getElementById('theme-icon-light').classList.add('hidden');
            }
        }
        
        // Setup initial icon
        updateThemeIcon();

        // Toggle theme
        function toggleTheme() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            updateThemeIcon();
        }

        function toggleMenu() {
            const menu = document.getElementById('mobile-menu');
            const iconOpen = document.getElementById('icon-open');
            const iconClose = document.getElementById('icon-close');
            menu.classList.toggle('open');
            iconOpen.classList.toggle('hidden');
            iconClose.classList.toggle('hidden');
        }

        // Header scroll effect
        window.addEventListener('scroll', () => {
            const header = document.getElementById('main-header');
            const isHome = {{ request()->routeIs('home') ? 'true' : 'false' }};
            
            if (isHome) {
                if (window.scrollY > 50) {
                    header.classList.remove('is-transparent', 'bg-transparent', 'border-transparent');
                    header.classList.add('bg-white/85', 'backdrop-blur-xl', 'border-slate-200', 'dark:bg-slate-950/85', 'dark:border-white/8');
                } else {
                    header.classList.add('is-transparent', 'bg-transparent', 'border-transparent');
                    header.classList.remove('bg-white/85', 'backdrop-blur-xl', 'border-slate-200', 'dark:bg-slate-950/85', 'dark:border-white/8');
                }
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
