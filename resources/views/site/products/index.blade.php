@extends('layouts.site')

@section('content')
<section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
    <div class="mb-12 max-w-3xl">
        <p class="text-xs font-medium uppercase tracking-[0.3em] text-slate-500">UMKM Desa</p>
        <h1 class="mt-4 text-4xl font-semibold text-slate-900 dark:text-white">Produk warga yang aktif dan siap dipromosikan.</h1>
    </div>

    <div class="grid gap-8 sm:grid-cols-2 xl:grid-cols-3">
        @forelse ($products as $product)
            <div class="group rounded border border-slate-200 bg-white transition hover:border-slate-300 dark:border-white/8 dark:bg-transparent dark:hover:border-white/20">
                @if($product->image_path)
                    <div class="overflow-hidden rounded-t border-b border-slate-200 dark:border-white/8">
                        <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" class="h-64 w-full object-cover transition duration-500 group-hover:scale-105">
                    </div>
                @else
                    <div class="h-64 w-full rounded-t bg-slate-50 border-b border-slate-200 dark:bg-white/2 dark:border-white/8"></div>
                @endif
                <div class="p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-lg font-medium text-slate-900 dark:text-white">{{ $product->name }}</p>
                            <p class="mt-1 text-xs text-slate-500">{{ $product->vendor_name }}</p>
                        </div>
                        <p class="text-base font-semibold text-emerald-600 whitespace-nowrap dark:text-emerald-400">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</p>
                    </div>
                    <p class="mt-5 text-sm leading-6 text-slate-600 dark:text-slate-400">{{ $product->description }}</p>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded border border-slate-200 bg-white p-8 text-slate-500 dark:border-white/8 dark:bg-transparent">Belum ada produk aktif.</div>
        @endforelse
    </div>
</section>
@endsection
