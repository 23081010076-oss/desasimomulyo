@extends('layouts.site')

@section('content')
<section class="mx-auto max-w-4xl px-4 py-16 sm:px-6 lg:px-8">
    <a href="{{ route('news') }}" class="text-sm text-cyan-600 dark:text-cyan-300">&larr; Kembali ke berita</a>
    <article class="mt-6 rounded-3xl border border-slate-200 bg-white p-8 dark:border-white/10 dark:bg-white/5 transition-colors duration-300">
        <h1 class="text-4xl font-semibold text-slate-900 dark:text-white">{{ $article->title }}</h1>
        <p class="mt-4 text-sm text-slate-500 dark:text-slate-400">{{ optional($article->published_at)->format('d M Y') }}</p>
        <div class="prose prose-slate mt-8 max-w-none dark:prose-invert prose-p:text-slate-600 prose-headings:text-slate-900 dark:prose-p:text-slate-300 dark:prose-headings:text-white">
            {!! nl2br(e($article->content)) !!}
        </div>
    </article>
</section>
@endsection
