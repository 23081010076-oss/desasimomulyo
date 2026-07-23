@extends('layouts.admin')

@section('page-title', 'Galeri Profil')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900 dark:text-white">Galeri Profil</h1>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Kelola gambar yang tampil di halaman profil desa</p>
        </div>
        <a href="{{ route('admin.profile-gallery-images.create') }}" class="flex items-center gap-2 rounded-lg bg-cyan-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-cyan-700 dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400">
            <span>+</span> Tambah Gambar
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg border border-emerald-500/30 bg-emerald-50 p-4 dark:bg-emerald-500/10">
            <p class="text-sm text-emerald-600 dark:text-emerald-400">{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @forelse ($images as $image)
            <article class="group relative flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-md dark:border-white/10 dark:bg-slate-900/50 dark:shadow-xl dark:backdrop-blur-sm dark:hover:bg-slate-900/80">
                <div class="relative h-48 w-full overflow-hidden bg-slate-100 dark:bg-slate-800">
                    <img src="{{ asset($image->image_path) }}" alt="{{ $image->title }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
                </div>
                
                <div class="flex flex-1 flex-col p-5">
                    <div class="mb-3 flex items-start justify-between gap-2">
                        <h3 class="font-semibold leading-tight text-slate-900 dark:text-white">{{ $image->title }}</h3>
                        <span class="inline-flex shrink-0 items-center rounded-full border {{ $image->is_active ? 'border-emerald-200 bg-emerald-50 text-emerald-600 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-400' : 'border-slate-200 bg-slate-50 text-slate-500 dark:border-white/10 dark:bg-white/5 dark:text-slate-400' }} px-2 py-0.5 text-[10px] font-medium uppercase tracking-wider">
                            {{ $image->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                    
                    @if ($image->caption)
                        <p class="mb-4 line-clamp-2 text-xs text-slate-600 dark:text-slate-400">{{ $image->caption }}</p>
                    @endif
                    
                    <div class="mt-auto flex items-center justify-between border-t border-slate-100 pt-4 dark:border-white/10">
                        <span class="text-xs text-slate-500 dark:text-slate-400">Urutan: {{ $image->sort_order }}</span>
                        
                        <div class="flex items-center gap-3 text-sm font-medium">
                            <a class="text-cyan-600 transition hover:text-cyan-700 dark:text-cyan-400 dark:hover:text-cyan-300" href="{{ route('admin.profile-gallery-images.edit', $image) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.profile-gallery-images.destroy', $image) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus gambar ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-rose-600 transition hover:text-rose-700 dark:text-rose-400 dark:hover:text-rose-300">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full py-12 text-center text-slate-500 dark:text-slate-400">Belum ada gambar di galeri.</div>
        @endforelse
    </div>
@endsection