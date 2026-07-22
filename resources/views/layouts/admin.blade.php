<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - {{ config('app.name', 'Profil Desa') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        }

        #sidebar { transition: transform 0.3s ease; }
    </style>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100">

    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute left-[-15%] top-[-5%] h-[400px] w-[400px] rounded-full bg-emerald-500/8 blur-[100px]"></div>
        <div class="absolute right-[-10%] top-[30%] h-[350px] w-[350px] rounded-full bg-cyan-500/8 blur-[100px]"></div>
    </div>

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-30 flex w-60 flex-col border-r border-white/8 bg-slate-950/95 backdrop-blur-xl lg:translate-x-0 -translate-x-full">

            {{-- Logo --}}
            <div class="flex h-14 items-center gap-3 border-b border-white/8 px-5">
                <img src="{{ asset('images/surabaya-logo.svg') }}" alt="Logo Surabaya" class="h-7 w-auto">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-white">Desa Portal</p>
                    <p class="text-[10px] text-slate-600 mt-0.5">Admin Panel</p>
                </div>
            </div>

            {{-- Nav --}}
            <nav class="flex-1 overflow-y-auto py-4">
                {{-- Menu Admin --}}
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-cyan-50 text-cyan-600 dark:bg-cyan-500/10 dark:text-cyan-400' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-white/5 dark:hover:text-white' }} flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium transition">
                    <span class="text-lg">📊</span>
                    Dashboard
                </a>
                <a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.*') ? 'bg-cyan-50 text-cyan-600 dark:bg-cyan-500/10 dark:text-cyan-400' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-white/5 dark:hover:text-white' }} flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium transition">
                    <span class="text-lg">📢</span>
                    Laporan Warga
                </a>
                
                <p class="mb-1 mt-5 px-5 text-[10px] font-semibold uppercase tracking-[0.15em] text-slate-600">Layanan</p>

                <a href="{{ route('admin.document-types.index') }}" class="{{ request()->routeIs('admin.document-types.*') ? 'bg-cyan-50 text-cyan-600 dark:bg-cyan-500/10 dark:text-cyan-400' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-white/5 dark:hover:text-white' }} flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium transition">
                    <span class="text-lg">📄</span>
                    Surat & Dokumen
                </a>
                <a href="{{ route('admin.articles.index') }}" class="{{ request()->routeIs('admin.articles.*') ? 'bg-cyan-50 text-cyan-600 dark:bg-cyan-500/10 dark:text-cyan-400' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-white/5 dark:hover:text-white' }} flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium transition">
                    <span class="text-lg">📰</span>
                    Artikel & Berita
                </a>
                <a href="{{ route('admin.profile-gallery-images.index') }}" class="{{ request()->routeIs('admin.profile-gallery-images.*') ? 'bg-cyan-50 text-cyan-600 dark:bg-cyan-500/10 dark:text-cyan-400' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-white/5 dark:hover:text-white' }} flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium transition">
                    <span class="text-lg">🖼️</span>
                    Galeri Profil
                </a>

                <p class="mb-1 mt-5 px-5 text-[10px] font-semibold uppercase tracking-[0.15em] text-slate-600">Keuangan</p>

                <a href="{{ route('admin.budgets.index') }}" class="{{ request()->routeIs('admin.budgets.*') ? 'bg-cyan-50 text-cyan-600 dark:bg-cyan-500/10 dark:text-cyan-400' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-white/5 dark:hover:text-white' }} flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium transition">
                    <span class="text-lg">💰</span>
                    APBDes & Anggaran
                </a>
                <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'bg-cyan-50 text-cyan-600 dark:bg-cyan-500/10 dark:text-cyan-400' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-white/5 dark:hover:text-white' }} flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium transition">
                    <span class="text-lg">🛍️</span>
                    Katalog UMKM
                </a>
                
                {{-- Divider --}}
                <div class="my-2 border-t border-slate-200 dark:border-white/10"></div>

                <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'bg-cyan-50 text-cyan-600 dark:bg-cyan-500/10 dark:text-cyan-400' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-white/5 dark:hover:text-white' }} flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium transition">
                    <span class="text-lg">⚙️</span>
                    Pengaturan
                </a>
            </nav>

            {{-- User + logout --}}
            <div class="border-t border-white/8 p-4">
                <div class="mb-3 border border-white/8 px-3 py-2">
                    <p class="text-xs font-medium text-white">Administrator</p>
                    <p class="text-[10px] text-slate-500 mt-0.5">{{ auth()->user()->email ?? 'admin@desa.id' }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full px-3 py-2 text-left text-xs text-slate-500 transition hover:text-red-300">Logout</button>
                </form>
            </div>
        </aside>

        {{-- Sidebar overlay (mobile) --}}
        <div id="sidebar-overlay" class="fixed inset-0 z-20 hidden bg-slate-950/70 lg:hidden" onclick="toggleSidebar()"></div>

        {{-- Main --}}
        <div class="flex flex-1 flex-col lg:pl-60">

            {{-- Top bar --}}
            <header class="sticky top-0 z-10 flex h-14 items-center gap-4 border-b border-white/8 bg-slate-950/90 px-4 backdrop-blur-xl sm:px-6">
                <button class="text-slate-400 hover:text-white lg:hidden" onclick="toggleSidebar()">☰</button>

                <div class="flex-1">
                    <p class="text-sm font-medium text-white">@yield('page-title', 'Dashboard')</p>
                    <p class="text-[10px] text-slate-600">{{ date('l, d F Y') }}</p>
                </div>

                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2 border border-emerald-400/20 bg-emerald-400/8 px-3 py-1.5">
                        <span class="relative flex h-1.5 w-1.5">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                        </span>
                        <span class="text-xs text-emerald-300">Online</span>
                    </div>
                    <a href="{{ route('home') }}" target="_blank" class="hidden border border-white/10 px-3 py-1.5 text-xs text-slate-400 transition hover:text-white sm:block">Lihat Situs</a>
                </div>
            </header>

            {{-- Content --}}
            <main class="flex-1 px-4 py-8 sm:px-6">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>
</body>
</html>
