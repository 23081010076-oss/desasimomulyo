@extends('layouts.site')

@section('content')
<section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
    <div class="mb-12 max-w-3xl">
        <p class="text-xs font-medium uppercase tracking-[0.3em] text-slate-500">Berita Desa</p>
        <h1 class="mt-4 text-4xl font-semibold text-slate-900 dark:text-white">Informasi kegiatan dan pengumuman desa.</h1>
    </div>

    <div class="grid gap-8 lg:grid-cols-2">
        @forelse ($articles as $i => $article)
            <a href="{{ route('news.show', $article) }}" class="group block rounded border border-slate-200 bg-white transition hover:border-slate-300 dark:border-white/8 dark:bg-transparent dark:hover:border-white/20">
                @if($article->featured_image)
                    <div class="overflow-hidden rounded-t border-b border-slate-200 dark:border-white/8">
                        <img src="{{ asset($article->featured_image) }}" alt="{{ $article->title }}" class="h-64 w-full object-cover grayscale transition duration-500 group-hover:scale-105 group-hover:grayscale-0">
                    </div>
                @else
                    <div class="flex h-64 w-full items-center justify-center rounded-t border-b border-slate-200 bg-slate-50 text-4xl font-mono text-slate-300 dark:border-white/8 dark:bg-white/2 dark:text-white/10">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</div>
                @endif
                
                <div class="p-6 sm:p-8">
                    <p class="text-xl font-medium text-slate-900 transition group-hover:text-emerald-600 dark:text-white dark:group-hover:text-emerald-300">{{ $article->title }}</p>
                    <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-400">{{ $article->excerpt }}</p>
                </div>
            </a>
        @empty
            <div class="rounded border border-slate-200 bg-white p-8 text-slate-500 dark:border-white/8 dark:bg-transparent">Belum ada berita publik.</div>
        @endforelse
    </div>
</section>
@endsection
