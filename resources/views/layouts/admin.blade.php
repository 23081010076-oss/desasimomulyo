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
        #sidebar { transition: transform 0.3s ease; }
    </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100">

    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute left-[-15%] top-[-5%] h-[400px] w-[400px] rounded-full bg-emerald-500/5 blur-[100px] dark:bg-emerald-500/8"></div>
        <div class="absolute right-[-10%] top-[30%] h-[350px] w-[350px] rounded-full bg-cyan-500/5 blur-[100px] dark:bg-cyan-500/8"></div>
    </div>

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-30 flex w-64 flex-col border-r border-slate-200 bg-white/95 backdrop-blur-xl dark:border-white/8 dark:bg-slate-950/95 lg:translate-x-0 -translate-x-full">

            {{-- Logo --}}
            <div class="flex h-14 items-center gap-3 border-b border-slate-200 px-5 dark:border-white/8">
                <img src="{{ asset('images/surabaya-logo.svg') }}" alt="Logo Surabaya" class="h-7 w-auto">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-900 dark:text-white">Desa Portal</p>
                    <p class="text-[10px] text-slate-500 mt-0.5 dark:text-slate-600">Admin Panel</p>
                </div>
            </div>

            {{-- Nav --}}
            <nav class="flex-1 overflow-y-auto py-4 px-3">

                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-cyan-50 text-cyan-600 dark:bg-cyan-500/10 dark:text-cyan-400' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-white/5 dark:hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition">
                    <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                    Dashboard
                </a>

                {{-- Konten --}}
                <p class="mb-1 mt-5 px-2 text-[10px] font-semibold uppercase tracking-[0.15em] text-slate-400 dark:text-slate-600">Konten</p>

                <a href="{{ route('admin.articles.index') }}" class="{{ request()->routeIs('admin.articles.*') ? 'bg-cyan-50 text-cyan-600 dark:bg-cyan-500/10 dark:text-cyan-400' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-white/5 dark:hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition">
                    <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2z"/><path d="M8 10h8M8 14h5"/></svg>
                    Artikel & Berita
                </a>
                <a href="{{ route('admin.profile-gallery-images.index') }}" class="{{ request()->routeIs('admin.profile-gallery-images.*') ? 'bg-cyan-50 text-cyan-600 dark:bg-cyan-500/10 dark:text-cyan-400' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-white/5 dark:hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition">
                    <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                    Galeri Profil
                </a>

                {{-- Surat Menyurat --}}
                <p class="mb-1 mt-5 px-2 text-[10px] font-semibold uppercase tracking-[0.15em] text-slate-400 dark:text-slate-600">Surat Menyurat</p>

                <a href="{{ route('admin.document-requests.index') }}" class="{{ request()->routeIs('admin.document-requests.*') ? 'bg-cyan-50 text-cyan-600 dark:bg-cyan-500/10 dark:text-cyan-400' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-white/5 dark:hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition">
                    <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12h6M9 16h6M14 3H6a2 2 0 00-2 2v14a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 3v5h5"/></svg>
                    Permohonan Surat
                </a>
                <a href="{{ route('admin.document-types.index') }}" class="{{ request()->routeIs('admin.document-types.*') ? 'bg-cyan-50 text-cyan-600 dark:bg-cyan-500/10 dark:text-cyan-400' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-white/5 dark:hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition">
                    <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M7 8h10M7 12h10M7 16h6M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/></svg>
                    Jenis Surat
                </a>

                {{-- Dana Desa --}}
                <p class="mb-1 mt-5 px-2 text-[10px] font-semibold uppercase tracking-[0.15em] text-slate-400 dark:text-slate-600">Dana Desa</p>

                <a href="{{ route('admin.budgets.index') }}" class="{{ request()->routeIs('admin.budgets.*') ? 'bg-cyan-50 text-cyan-600 dark:bg-cyan-500/10 dark:text-cyan-400' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-white/5 dark:hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition">
                    <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    APBDes & Anggaran
                </a>
                <a href="{{ route('budget.transparency') }}" target="_blank" class="text-slate-500 hover:bg-slate-100 hover:text-slate-700 dark:text-slate-500 dark:hover:bg-white/5 dark:hover:text-slate-300 flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition">
                    <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <span class="flex-1">Lihat Transparansi</span>
                    <svg class="h-3 w-3 opacity-40" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><path d="M15 3h6v6"/><path d="M10 14L21 3"/></svg>
                </a>

                {{-- Layanan Warga --}}
                <p class="mb-1 mt-5 px-2 text-[10px] font-semibold uppercase tracking-[0.15em] text-slate-400 dark:text-slate-600">Layanan Warga</p>

                <a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.*') ? 'bg-cyan-50 text-cyan-600 dark:bg-cyan-500/10 dark:text-cyan-400' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-white/5 dark:hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition">
                    <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Laporan Warga
                </a>
                <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'bg-cyan-50 text-cyan-600 dark:bg-cyan-500/10 dark:text-cyan-400' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-white/5 dark:hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition">
                    <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
                    Katalog UMKM
                </a>

                {{-- Divider --}}
                <div class="my-3 border-t border-slate-200 dark:border-white/10"></div>

                <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'bg-cyan-50 text-cyan-600 dark:bg-cyan-500/10 dark:text-cyan-400' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-white/5 dark:hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition">
                    <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 15a3 3 0 100-6 3 3 0 000 6z"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
                    Pengaturan
                </a>
            </nav>

            {{-- User + logout --}}
            <div class="border-t border-slate-200 p-4 dark:border-white/8">
                <div class="mb-3 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 dark:border-white/8 dark:bg-white/5">
                    <p class="text-xs font-medium text-slate-900 dark:text-white">{{ auth()->user()->name ?? 'Administrator' }}</p>
                    <p class="text-[10px] text-slate-500 mt-0.5">{{ auth()->user()->email ?? 'admin@desa.id' }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full rounded-lg px-3 py-2 text-left text-xs text-slate-500 transition hover:bg-slate-100 hover:text-red-500 dark:hover:bg-white/5 dark:hover:text-red-300">Keluar dari Akun</button>
                </form>
            </div>
        </aside>

        {{-- Sidebar overlay (mobile) --}}
        <div id="sidebar-overlay" class="fixed inset-0 z-20 hidden bg-slate-950/70 lg:hidden" onclick="toggleSidebar()"></div>

        {{-- Main --}}
        <div class="flex flex-1 flex-col lg:pl-64">

            {{-- Top bar --}}
            <header class="sticky top-0 z-10 flex h-14 items-center gap-4 border-b border-slate-200 bg-white/90 px-4 backdrop-blur-xl dark:border-white/8 dark:bg-slate-950/90 sm:px-6">
                <button class="text-slate-400 hover:text-slate-900 dark:hover:text-white lg:hidden" onclick="toggleSidebar()">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>

                <div class="flex-1">
                    <p class="text-sm font-medium text-slate-900 dark:text-white">@yield('page-title', 'Dashboard')</p>
                    <p class="text-[10px] text-slate-400 dark:text-slate-600">{{ date('l, d F Y') }}</p>
                </div>

                <div class="flex items-center gap-3">
                    {{-- Theme toggle --}}
                    <button onclick="toggleTheme()" title="Ganti Tema" class="rounded-lg border border-slate-200 p-1.5 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900 dark:border-white/10 dark:text-slate-400 dark:hover:bg-white/5 dark:hover:text-white">
                        <svg class="hidden h-4 w-4 dark:block" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
                        <svg class="block h-4 w-4 dark:hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
                    </button>

                    <div class="flex items-center gap-2 rounded-full border border-emerald-400/20 bg-emerald-400/8 px-3 py-1.5">
                        <span class="relative flex h-1.5 w-1.5">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                        </span>
                        <span class="text-xs text-emerald-600 dark:text-emerald-300">Online</span>
                    </div>
                    <a href="{{ route('home') }}" target="_blank" class="hidden rounded-lg border border-slate-200 px-3 py-1.5 text-xs text-slate-500 transition hover:border-slate-300 hover:text-slate-900 dark:border-white/10 dark:text-slate-400 dark:hover:text-white sm:block">Lihat Situs</a>
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

        function toggleTheme() {
            const html = document.documentElement;
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }
    </script>
</body>
</html>
