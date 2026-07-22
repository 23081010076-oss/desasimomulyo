@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900 dark:text-white">Produk UMKM</h1>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Kelola katalog produk warga</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="flex items-center gap-2 rounded-lg bg-cyan-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-cyan-700 dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400">
            <span>+</span> Tambah Produk
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg border border-emerald-500/30 bg-emerald-50 p-4 dark:bg-emerald-500/10">
            <p class="text-sm text-emerald-600 dark:text-emerald-400">{{ session('success') }}</p>
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-slate-900/50 dark:shadow-xl dark:backdrop-blur-sm">
        @forelse ($products as $product)
            <div class="flex items-center justify-between border-b border-slate-200 p-5 last:border-b-0 hover:bg-slate-50 transition dark:border-white/10 dark:hover:bg-white/5">
                <div class="flex items-center gap-4">
                    @if($product->image_path)
                        <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" class="h-16 w-16 rounded-lg object-cover border border-slate-200 dark:border-white/10">
                    @else
                        <div class="flex h-16 w-16 items-center justify-center rounded-lg border border-slate-200 bg-slate-50 text-xs text-slate-400 dark:border-white/10 dark:bg-slate-800 dark:text-slate-500">No Img</div>
                    @endif
                    <div>
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $product->name }}</p>
                        <div class="mt-1 flex flex-wrap items-center gap-3 text-xs text-slate-500 dark:text-slate-400">
                            <span>Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="h-1 w-1 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                            <span class="text-cyan-600 dark:text-cyan-300">{{ $product->vendor_name }}</span>
                            <span class="h-1 w-1 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                            <span class="{{ $product->is_active ? 'text-emerald-600 dark:text-emerald-400' : 'text-amber-600 dark:text-amber-400' }}">
                                {{ $product->is_active ? 'Aktif' : 'Non-aktif' }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3 text-sm font-medium">
                    <a class="text-cyan-600 transition hover:text-cyan-700 dark:text-cyan-400 dark:hover:text-cyan-300" href="{{ route('admin.products.edit', $product) }}">Edit</a>
                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-rose-600 transition hover:text-rose-700 dark:text-rose-400 dark:hover:text-rose-300">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="p-8 text-center text-slate-500 dark:text-slate-400">Belum ada produk yang ditambahkan.</div>
        @endforelse
    </div>

    @if($products->hasPages())
        <div class="mt-6">
            {{ $products->links() }}
        </div>
    @endif
@endsection
