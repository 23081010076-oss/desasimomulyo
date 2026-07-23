@extends('layouts.admin')

@section('page-title', 'Galeri Profil')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-900 dark:text-white">{{ $image->exists ? 'Edit Gambar Profil' : 'Tambah Gambar Profil' }}</h1>
        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Pilih gambar berkualitas untuk ditampilkan pada profil desa.</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-lg border border-red-500/30 bg-red-500/10 p-4">
            <ul class="list-inside list-disc text-sm text-red-400">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" enctype="multipart/form-data" action="{{ $image->exists ? route('admin.profile-gallery-images.update', $image) : route('admin.profile-gallery-images.store') }}" class="grid max-w-3xl gap-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-slate-900/50 dark:shadow-xl dark:backdrop-blur-sm">
        @csrf
        @if ($image->exists)
            @method('PUT')
        @endif

        <div class="grid gap-6 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Judul Gambar</label>
                <input name="title" value="{{ old('title', $image->title) }}" placeholder="Contoh: Balai Desa Tampak Depan" class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">
            </div>
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Urutan Tampil (Angka)</label>
                <input name="sort_order" type="number" min="0" value="{{ old('sort_order', $image->sort_order ?? 0) }}" placeholder="0" class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">
            </div>
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Keterangan Gambar (Caption)</label>
            <textarea name="caption" rows="2" placeholder="Deskripsi singkat mengenai foto..." class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">{{ old('caption', $image->caption) }}</textarea>
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">File Gambar</label>
            @if ($image->exists && $image->image_path)
                <div class="mb-3 overflow-hidden rounded-xl border border-slate-200 dark:border-white/10">
                    <img src="{{ asset($image->image_path) }}" alt="{{ $image->title }}" class="h-48 w-full object-cover">
                </div>
            @endif
            <input type="file" name="image" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:rounded-full file:border-0 file:bg-slate-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-slate-700 hover:file:bg-slate-200 dark:text-slate-400 dark:file:bg-white/10 dark:file:text-white dark:hover:file:bg-white/20">
            <p class="mt-1 text-xs text-slate-500">Format: JPG, PNG, WEBP. Maks 2MB.</p>
        </div>

        <div class="flex items-center gap-3">
            <input type="checkbox" name="is_active" value="1" id="is_active" class="h-4 w-4 rounded border-slate-300 bg-white accent-cyan-600 dark:border-white/10 dark:bg-slate-950 dark:accent-cyan-500" {{ old('is_active', $image->exists ? $image->is_active : true) ? 'checked' : '' }}>
            <label for="is_active" class="text-sm font-medium text-slate-700 dark:text-slate-300">Tampilkan di halaman profil</label>
        </div>

        <div class="mt-4 flex gap-3">
            <button type="submit" class="rounded-lg bg-cyan-600 px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-cyan-700 dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400">Simpan Gambar</button>
            <a href="{{ route('admin.profile-gallery-images.index') }}" class="rounded-lg border border-slate-200 bg-transparent px-6 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-white/10 dark:text-slate-300 dark:hover:bg-white/5">Batal</a>
        </div>
    </form>
@endsection