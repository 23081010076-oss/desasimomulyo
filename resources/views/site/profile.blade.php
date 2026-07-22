@extends('layouts.site')

@section('content')
<section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">

    {{-- Header --}}
    <div class="max-w-2xl">
        <p class="text-xs font-medium uppercase tracking-[0.3em] text-slate-500">Profil Kelurahan</p>
        <h1 class="mt-5 text-4xl font-semibold leading-tight text-slate-900 dark:text-white sm:text-5xl">Kelurahan Simomulyo</h1>
        <p class="mt-5 text-base leading-8 text-slate-600 dark:text-slate-400">Website ini dirancang untuk menampilkan identitas Kelurahan Simomulyo, berita, potensi UMKM, peta wilayah, dan jalur komunikasi cepat antara warga dan pemerintah kelurahan.</p>
        <div class="mt-5 flex flex-wrap gap-2 text-xs text-slate-500">
            <span class="border border-slate-200 bg-white px-3 py-1.5 dark:border-white/10 dark:bg-transparent">Kec. Sukomanunggal</span>
            <span class="border border-slate-200 bg-white px-3 py-1.5 dark:border-white/10 dark:bg-transparent">Kota Surabaya</span>
            <span class="border border-slate-200 bg-white px-3 py-1.5 dark:border-white/10 dark:bg-transparent">Hotline 24/7</span>
        </div>
    </div>

    {{-- Gallery + info --}}
    <div class="mt-12 grid gap-8 xl:grid-cols-[1.2fr_0.8fr]">

        {{-- Gallery --}}
        <div class="border border-slate-200 bg-white p-5 dark:border-white/8 dark:bg-transparent transition-colors duration-300">
            <div class="flex items-center justify-between gap-4 mb-5">
                <div>
                    <p class="text-[10px] uppercase tracking-[0.2em] text-slate-500">Galeri Visual</p>
                    <h2 class="mt-1 text-base font-semibold text-slate-900 dark:text-white">Dokumentasi Kelurahan</h2>
                </div>
                <a href="{{ route('map') }}" class="text-sm text-slate-500 transition hover:text-slate-900 dark:text-slate-400 dark:hover:text-white">Lihat peta &rarr;</a>
            </div>

            @if ($galleryImages->isNotEmpty())
                @php($featuredImage = $galleryImages->first())
                @php($secondaryImages = $galleryImages->skip(1))

                <div class="grid gap-3 lg:grid-cols-[1.2fr_0.8fr]">
                    <article class="overflow-hidden">
                        <div class="relative overflow-hidden border border-slate-200 dark:border-white/10">
                            <img src="{{ asset($featuredImage->image_path) }}" alt="{{ $featuredImage->title }}" class="h-80 w-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 p-4">
                                <p class="text-sm font-semibold text-white">{{ $featuredImage->title }}</p>
                                @if ($featuredImage->caption)
                                    <p class="mt-0.5 text-xs text-slate-200">{{ $featuredImage->caption }}</p>
                                @endif
                            </div>
                        </div>
                    </article>

                    <div class="grid gap-3">
                        @forelse ($secondaryImages->take(2) as $image)
                            <article class="overflow-hidden">
                                <div class="relative overflow-hidden border border-slate-200 dark:border-white/10">
                                    <img src="{{ asset($image->image_path) }}" alt="{{ $image->title }}" class="h-[9.5rem] w-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-slate-950/10 to-transparent"></div>
                                    <div class="absolute bottom-0 left-0 p-3">
                                        <p class="text-xs font-medium text-white">{{ $image->title }}</p>
                                    </div>
                                </div>
                            </article>
                        @empty
                        @endforelse
                    </div>
                </div>
            @else
                <div class="grid gap-3 lg:grid-cols-[1.2fr_0.8fr]">
                    <div class="flex h-80 items-center justify-center border border-slate-200 bg-slate-50 dark:border-white/8 dark:bg-slate-900/40">
                        <div class="text-center">
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Kantor Kelurahan Simomulyo</p>
                            <p class="mt-1 text-xs text-slate-400 dark:text-slate-600">Pusat layanan warga</p>
                        </div>
                    </div>
                    <div class="grid gap-3">
                        @foreach (['Kegiatan Warga', 'Wilayah Simomulyo'] as $ph)
                            <div class="flex h-[9.5rem] items-center justify-center border border-slate-200 bg-slate-50 dark:border-white/8 dark:bg-slate-900/40">
                                <p class="text-xs text-slate-400 dark:text-slate-600">{{ $ph }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Info sidebar --}}
        <div class="space-y-4">
            <div class="border border-slate-200 bg-white p-6 dark:border-white/8 dark:bg-transparent">
                <p class="text-[10px] uppercase tracking-[0.15em] text-slate-500">Lokasi</p>
                <p class="mt-2 text-lg font-semibold text-slate-900 dark:text-white">Kec. Sukomanunggal</p>
                <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-400">Kelurahan Simomulyo berada di area aktif, padat, dan dekat dengan berbagai pusat layanan warga Surabaya.</p>
            </div>

            <div class="border border-amber-500/20 bg-amber-50 p-6 dark:border-amber-400/20 dark:bg-amber-400/5">
                <p class="text-[10px] uppercase tracking-[0.15em] text-amber-600 dark:text-amber-500/70">Layanan Cepat</p>
                <p class="mt-2 text-lg font-semibold text-slate-900 dark:text-white">Hotline & Pengaduan</p>
                <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-400">Semua kanal informasi dibuat ringkas agar warga bisa cepat menemukan layanan yang dibutuhkan.</p>
                <a href="{{ route('hotline') }}" class="mt-4 inline-block text-sm font-medium text-amber-600 transition hover:text-amber-700 dark:text-amber-300 dark:hover:text-amber-200">Buka Hotline &rarr;</a>
            </div>

            <div class="border border-slate-200 bg-white p-6 dark:border-white/8 dark:bg-transparent">
                <p class="text-[10px] uppercase tracking-[0.15em] text-slate-500">Arah Pengembangan</p>
                <p class="mt-2 text-lg font-semibold text-slate-900 dark:text-white">Terbuka & Terdokumentasi</p>
                <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-400">Visual, berita, dan data pelayanan disajikan berurutan supaya informasi lebih mudah dipahami warga.</p>
            </div>
        </div>
    </div>

    {{-- Visi Misi --}}
    <div class="mt-14 border-t border-slate-200 pt-10 dark:border-white/8">
        <div class="grid gap-8 lg:grid-cols-3">
            <div>
                <p class="text-[10px] uppercase tracking-[0.2em] text-slate-500">Visi</p>
                <p class="mt-4 text-base leading-8 text-slate-700 dark:text-slate-200">Mewujudkan pelayanan kelurahan yang cepat, terbuka, dan berbasis data untuk seluruh warga Simomulyo.</p>
            </div>

            <div class="lg:col-span-2">
                <p class="text-[10px] uppercase tracking-[0.2em] text-slate-500">Misi</p>
                <ul class="mt-4 space-y-3 text-sm leading-7 text-slate-600 dark:text-slate-300">
                    <li>— Menyediakan informasi kelurahan yang selalu terbarui secara real-time.</li>
                    <li>— Membuka kanal hotline dan pengaduan warga yang cepat dan mudah diakses.</li>
                    <li>— Menampilkan transparansi anggaran dan kegiatan kelurahan secara terbuka.</li>
                    <li>— Mendukung promosi dan pertumbuhan produk UMKM warga setempat.</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Fasilitas --}}
    <div class="mt-8 grid gap-4 border-t border-slate-200 pt-8 md:grid-cols-3 dark:border-white/8">
        @foreach ([
            ['label' => 'Fasilitas', 'desc' => 'Kantor kelurahan, layanan administrasi, dan ruang informasi warga.'],
            ['label' => 'Lingkungan', 'desc' => 'Informasi wilayah, batas area, dan titik layanan yang mudah diakses.'],
            ['label' => 'Komunitas', 'desc' => 'Dokumentasi kegiatan, layanan hotline, dan partisipasi masyarakat.'],
        ] as $item)
            <div>
                <p class="text-[10px] uppercase tracking-[0.15em] text-slate-500">{{ $item['label'] }}</p>
                <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300">{{ $item['desc'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- CTA --}}
    <div class="mt-10 flex flex-wrap gap-3">
        <a href="{{ route('map') }}" class="rounded border border-slate-300 bg-white px-6 py-3 text-sm font-medium text-slate-700 transition hover:border-slate-400 hover:text-slate-900 dark:border-white/15 dark:bg-transparent dark:text-slate-300 dark:hover:border-white/30 dark:hover:text-white">Buka Peta Desa</a>
        <a href="{{ route('hotline') }}" class="rounded border border-amber-500/30 bg-amber-50 px-6 py-3 text-sm font-medium text-amber-600 transition hover:bg-amber-100 dark:border-amber-400/30 dark:bg-amber-400/10 dark:text-amber-300 dark:hover:bg-amber-400/20">Hubungi Hotline</a>
    </div>

</section>section>
@endsection
