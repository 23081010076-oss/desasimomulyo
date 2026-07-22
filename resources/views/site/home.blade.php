@extends('layouts.site')

@section('content')

{{-- Hero Carousel --}}
<section class="relative flex h-[600px] w-full items-center justify-center overflow-hidden sm:h-[700px] md:justify-start">
    {{-- Background Images (CSS Crossfade) --}}
    <div class="absolute inset-0 -z-20 bg-slate-900">
        <div class="animate-slideshow absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/hero-1.png') }}'); animation-delay: 0s;"></div>
        <div class="animate-slideshow absolute inset-0 bg-cover bg-center opacity-0" style="background-image: url('{{ asset('images/hero-2.png') }}'); animation-delay: 5s;"></div>
    </div>
    
    {{-- Dark Overlay --}}
    <div class="absolute inset-0 -z-10 bg-gradient-to-r from-slate-950/80 via-slate-900/60 to-transparent"></div>
    <div class="absolute inset-0 -z-10 bg-black/40"></div>

    {{-- Content --}}
    <div class="relative mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 text-center md:text-left">
        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-emerald-400 drop-shadow-md sm:text-lg">Selamat Datang di</p>
        <h1 class="mt-2 text-5xl font-semibold leading-[1.1] text-white drop-shadow-lg sm:text-6xl lg:text-7xl font-serif tracking-wide">
            KELURAHAN<br>SIMOMULYO
        </h1>
        <p class="mt-6 max-w-2xl text-base text-slate-200 drop-shadow md:text-lg mx-auto md:mx-0">
            Selamat datang di website Kelurahan Simomulyo Surabaya! Temukan data statistik lengkap dan berbagai konten bermanfaat lainnya yang siap memenuhi kebutuhan informasi Anda secara mudah dan terpercaya.
        </p>
        
        <div class="mt-10 flex flex-wrap justify-center gap-4 md:justify-start">
            <a href="{{ route('hotline') }}" class="rounded bg-amber-500 px-8 py-3.5 text-sm font-semibold text-white shadow-lg transition hover:bg-amber-400 hover:scale-105">Kirim Laporan</a>
            <a href="{{ route('profile') }}" class="rounded border border-white/40 bg-white/10 px-8 py-3.5 text-sm font-medium text-white shadow-lg backdrop-blur-md transition hover:bg-white/20 hover:border-white">Profil Kelurahan</a>
        </div>
    </div>
</section>

@push('styles')
<style>
    @keyframes slideshow {
        0% { opacity: 0; transform: scale(1.05); }
        10% { opacity: 1; transform: scale(1); }
        45% { opacity: 1; transform: scale(1); }
        55% { opacity: 0; transform: scale(1.05); }
        100% { opacity: 0; transform: scale(1.05); }
    }
    .animate-slideshow {
        animation: slideshow 10s infinite cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>
@endpush

{{-- Stats bar --}}
<div class="border-y border-slate-200 bg-slate-100/50 dark:border-white/8 dark:bg-white/3 transition-colors duration-300">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid divide-y divide-slate-200 dark:divide-white/8 sm:grid-cols-3 sm:divide-x sm:divide-y-0 transition-colors duration-300">
            <div class="px-0 py-6 sm:px-8">
                <p class="text-2xl font-semibold text-slate-900 dark:text-white">Rp {{ number_format($budgetTotal, 0, ',', '.') }}</p>
                <p class="mt-1 text-sm text-slate-500">Total APBDes</p>
            </div>
            <div class="px-0 py-6 sm:px-8">
                <p class="text-2xl font-semibold text-slate-900 dark:text-white">{{ $budgetCount }}</p>
                <p class="mt-1 text-sm text-slate-500">Transaksi Anggaran</p>
            </div>
            <div class="px-0 py-6 sm:px-8">
                <p class="text-2xl font-semibold text-slate-900 dark:text-white">24 / 7</p>
                <p class="mt-1 text-sm text-slate-500">Hotline Aktif</p>
            </div>
        </div>
    </div>
</div>

{{-- Berita & UMKM --}}
<section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
    <div class="grid gap-16 lg:grid-cols-[1fr_380px]">

        {{-- Berita terbaru --}}
        <div>
            <div class="mb-8 flex items-baseline justify-between border-b border-slate-200 pb-4 dark:border-white/10 transition-colors duration-300">
                <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Berita Terbaru</h2>
                <a href="{{ route('news') }}" class="text-sm text-slate-500 transition hover:text-slate-700 dark:hover:text-slate-300">Lihat semua &rarr;</a>
            </div>
            <div class="space-y-0 divide-y divide-slate-200 dark:divide-white/8 transition-colors duration-300">
                @forelse ($articles as $i => $article)
                    <a href="{{ route('news.show', $article) }}" class="group flex gap-5 py-6 transition hover:bg-slate-50 dark:hover:bg-white/2 -mx-4 px-4 sm:-mx-6 sm:px-6">
                        @if($article->featured_image)
                            <img src="{{ asset($article->featured_image) }}" alt="{{ $article->title }}" class="h-24 w-32 object-cover shrink-0 grayscale group-hover:grayscale-0 transition duration-300 rounded border border-slate-200 dark:border-white/10">
                        @else
                            <div class="flex h-24 w-32 shrink-0 items-center justify-center rounded border border-slate-200 bg-slate-100 text-sm text-slate-500 font-mono dark:border-white/8 dark:bg-white/2 dark:text-slate-600">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="text-lg font-medium text-slate-900 transition group-hover:text-emerald-600 dark:text-white dark:group-hover:text-emerald-300">{{ $article->title }}</p>
                            <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-500">{{ $article->excerpt }}</p>
                        </div>
                    </a>
                @empty
                    <p class="py-8 text-sm text-slate-500">Belum ada artikel dipublikasikan.</p>
                @endforelse
            </div>
        </div>

        {{-- UMKM sidebar --}}
        <div>
            <div class="mb-8 flex items-baseline justify-between border-b border-slate-200 pb-4 dark:border-white/10 transition-colors duration-300">
                <h2 class="text-xl font-semibold text-slate-900 dark:text-white">UMKM Pilihan</h2>
                <a href="{{ route('products') }}" class="text-sm text-slate-500 transition hover:text-slate-700 dark:hover:text-slate-300">Semua &rarr;</a>
            </div>
            <div class="space-y-4">
                @forelse ($products as $product)
                    <div class="flex gap-4 rounded border border-slate-200 bg-white p-4 transition hover:border-slate-300 dark:border-white/8 dark:bg-transparent dark:hover:border-white/15">
                        @if($product->image_path)
                            <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" class="h-16 w-16 rounded object-cover shrink-0 border border-slate-200 dark:border-white/10">
                        @else
                            <div class="h-16 w-16 shrink-0 rounded bg-slate-100 border border-slate-200 dark:bg-white/5 dark:border-white/8"></div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $product->name }}</p>
                            <p class="mt-1 text-xs text-slate-500">{{ $product->vendor_name }}</p>
                            <p class="mt-2 text-sm font-semibold text-emerald-600 dark:text-emerald-400">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">Belum ada produk aktif.</p>
                @endforelse
            </div>

            {{-- CTA hotline --}}
            <div class="mt-8 rounded border border-amber-500/20 bg-amber-50 p-5 dark:border-amber-400/20 dark:bg-amber-400/5 transition-colors duration-300">
                <p class="text-xs font-semibold uppercase tracking-[0.15em] text-amber-600 dark:text-amber-400/70">Pengaduan Warga</p>
                <p class="mt-2 text-base font-semibold text-slate-900 dark:text-white">Punya laporan atau keluhan?</p>
                <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-400">Sampaikan langsung melalui kanal hotline kelurahan. Respon dalam 1×24 jam.</p>
                <a href="{{ route('hotline') }}" class="mt-4 inline-block text-sm font-medium text-amber-600 transition hover:text-amber-700 dark:text-amber-300 dark:hover:text-amber-200">Buka Hotline &rarr;</a>
            </div>
        </div>
    </div>
</section>

@endsection
