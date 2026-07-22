@extends('layouts.admin')

@section('content')
    <h1 class="mb-6 text-2xl font-semibold text-slate-900 dark:text-white">Form Artikel</h1>

    @if ($errors->any())
        <div class="mb-6 rounded-lg border border-red-500/30 bg-red-500/10 p-4">
            <ul class="list-inside list-disc text-sm text-red-400">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ $article->exists ? route('admin.articles.update', $article) : route('admin.articles.store') }}" enctype="multipart/form-data" class="grid max-w-3xl gap-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-slate-900/50 dark:shadow-xl dark:backdrop-blur-sm">
        @csrf
        @if ($article->exists)
            @method('PUT')
        @endif

        <div class="grid gap-6 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Judul Artikel</label>
                <input name="title" value="{{ old('title', $article->title) }}" placeholder="Judul artikel berita" class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">
            </div>
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Slug (URL)</label>
                <input name="slug" value="{{ old('slug', $article->slug) }}" placeholder="judul-artikel-berita" class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">
            </div>
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Gambar Fitur (Featured Image)</label>
            @if($article->featured_image)
                <div class="mb-3">
                    <img src="{{ asset($article->featured_image) }}" alt="Preview" class="h-32 w-auto rounded-lg border border-slate-200 object-cover dark:border-white/10">
                </div>
            @endif
            <input type="file" name="image" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:rounded-full file:border-0 file:bg-slate-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-slate-700 hover:file:bg-slate-200 dark:text-slate-400 dark:file:bg-white/10 dark:file:text-white dark:hover:file:bg-white/20">
            <p class="mt-1 text-xs text-slate-500">Format: JPG, PNG, WEBP. Maks 2MB.</p>
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Ringkasan (Excerpt)</label>
            <textarea name="excerpt" rows="3" placeholder="Ringkasan singkat artikel..." class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">{{ old('excerpt', $article->excerpt) }}</textarea>
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Konten Lengkap</label>
            <textarea name="content" rows="8" placeholder="Tulis isi artikel selengkapnya di sini..." class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">{{ old('content', $article->content) }}</textarea>
        </div>

        <div class="flex items-center gap-3">
            <input type="checkbox" name="is_published" value="1" id="is_published" class="h-4 w-4 rounded border-slate-300 bg-white accent-cyan-600 dark:border-white/10 dark:bg-slate-950 dark:accent-cyan-500" {{ old('is_published', $article->is_published) ? 'checked' : '' }}>
            <label for="is_published" class="text-sm font-medium text-slate-700 dark:text-slate-300">Publikasikan Artikel</label>
        </div>

        <div class="mt-4 flex gap-3">
            <button type="submit" class="rounded-lg bg-cyan-600 px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-cyan-700 dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400">Simpan Artikel</button>
            <a href="{{ route('admin.articles.index') }}" class="rounded-lg border border-slate-200 bg-transparent px-6 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-white/10 dark:text-slate-300 dark:hover:bg-white/5">Batal</a>
        </div>
    </form>
@endsection
