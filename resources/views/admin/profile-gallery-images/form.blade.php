@extends('layouts.admin')

@section('content')
    <h1 class="mb-6 text-2xl font-semibold text-white">{{ $image->exists ? 'Edit Gambar Profil' : 'Tambah Gambar Profil' }}</h1>

    <form method="POST" enctype="multipart/form-data" action="{{ $image->exists ? route('admin.profile-gallery-images.update', $image) : route('admin.profile-gallery-images.store') }}" class="grid max-w-3xl gap-4 rounded-2xl border border-white/10 bg-white/5 p-6">
        @csrf
        @if ($image->exists)
            @method('PUT')
        @endif

        <div class="grid gap-4 md:grid-cols-2">
            <input name="title" value="{{ old('title', $image->title) }}" placeholder="Judul gambar" class="rounded-lg border border-white/10 bg-slate-950/80 p-3 text-white">
            <input name="sort_order" type="number" min="0" value="{{ old('sort_order', $image->sort_order ?? 0) }}" placeholder="Urutan" class="rounded-lg border border-white/10 bg-slate-950/80 p-3 text-white">
        </div>

        <textarea name="caption" placeholder="Keterangan gambar" class="rounded-lg border border-white/10 bg-slate-950/80 p-3 text-white">{{ old('caption', $image->caption) }}</textarea>

        <div class="rounded-xl border border-dashed border-white/10 bg-slate-950/40 p-4">
            <label class="mb-2 block text-sm text-slate-300">Upload gambar</label>
            <input type="file" name="image" class="block w-full text-sm text-slate-300 file:mr-4 file:rounded-lg file:border-0 file:bg-cyan-500 file:px-4 file:py-2 file:text-sm file:font-medium file:text-slate-950">
            @if ($image->exists && $image->image_path)
                <div class="mt-4">
                    <p class="mb-2 text-sm text-slate-400">Gambar saat ini</p>
                    <img src="{{ asset($image->image_path) }}" alt="{{ $image->title }}" class="h-48 rounded-xl object-cover">
                </div>
            @endif
        </div>

        <label class="flex items-center gap-3 text-sm text-slate-300">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $image->exists ? $image->is_active : true))>
            Tampilkan di halaman profil
        </label>

        <button class="rounded-lg bg-cyan-500 px-4 py-2 font-medium text-slate-950">Simpan</button>
    </form>
@endsection