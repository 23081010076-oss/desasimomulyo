@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-white">Galeri Profil</h1>
            <p class="mt-2 text-sm text-slate-400">Kelola gambar yang tampil di halaman profil desa.</p>
        </div>
        <a href="{{ route('admin.profile-gallery-images.create') }}" class="rounded-lg bg-cyan-500 px-4 py-2 text-sm font-medium text-slate-950">Tambah Gambar</a>
    </div>

    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
        @foreach ($images as $image)
            <article class="overflow-hidden rounded-2xl border border-white/10 bg-white/5">
                <img src="{{ asset($image->image_path) }}" alt="{{ $image->title }}" class="h-56 w-full object-cover">
                <div class="space-y-3 p-4">
                    <div>
                        <p class="font-medium text-white">{{ $image->title }}</p>
                        <p class="text-sm text-slate-400">Urutan: {{ $image->sort_order }} · {{ $image->is_active ? 'Aktif' : 'Nonaktif' }}</p>
                    </div>
                    @if ($image->caption)
                        <p class="text-sm leading-6 text-slate-300">{{ $image->caption }}</p>
                    @endif
                    <div class="flex items-center gap-3 text-sm">
                        <a class="text-cyan-300" href="{{ route('admin.profile-gallery-images.edit', $image) }}">Edit</a>
                        <form method="POST" action="{{ route('admin.profile-gallery-images.destroy', $image) }}">@csrf @method('DELETE')<button class="text-rose-300" type="submit">Hapus</button></form>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
@endsection