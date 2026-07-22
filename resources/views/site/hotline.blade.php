@extends('layouts.site')

@push('styles')
<style>
    /* Panic button pulse animation */
    @keyframes panic-ring {
        0%   { transform: scale(1);   opacity: 1; }
        100% { transform: scale(1.6); opacity: 0; }
    }
    .panic-ring::before, .panic-ring::after {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 9999px;
        border: 2px solid #f87171;
        animation: panic-ring 1.8s ease-out infinite;
    }
    .panic-ring::after { animation-delay: 0.9s; }
</style>
@endpush

@section('content')
<section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">

    {{-- Header --}}
    <div class="mb-12 max-w-2xl">
        <p class="text-xs font-medium uppercase tracking-[0.3em] text-amber-600 dark:text-amber-400/70">Hotline Desa</p>
        <h1 class="mt-5 text-4xl font-semibold leading-tight text-slate-900 dark:text-white sm:text-5xl">Laporkan kebutuhan atau keluhan Anda.</h1>
        <p class="mt-5 text-base leading-8 text-slate-600 dark:text-slate-400">Pilih cara yang paling nyaman — kirim via WhatsApp langsung, gunakan panic button untuk darurat, atau isi form untuk laporan resmi.</p>
    </div>

    {{-- Quick action buttons --}}
    <div class="mb-12 grid gap-4 sm:grid-cols-3">

        {{-- WhatsApp --}}
        @php
            $waNumber = $village['whatsapp'] ?? '6281234567890';
            $waText = urlencode('Halo, saya ingin menyampaikan laporan kepada Kelurahan Simomulyo.');
            $waUrl = "https://wa.me/{$waNumber}?text={$waText}";
        @endphp
        <a href="{{ $waUrl }}" target="_blank" rel="noopener"
            class="group flex flex-col gap-4 border border-green-500/30 bg-green-50 p-6 transition hover:border-green-500/50 hover:bg-green-100 dark:bg-green-500/8 dark:hover:border-green-400/50 dark:hover:bg-green-500/15">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-[0.15em] text-green-600 dark:text-green-400/70">WhatsApp</p>
                <span class="relative flex h-2.5 w-2.5">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-green-500 dark:bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-green-500 dark:bg-green-400"></span>
                </span>
            </div>
            <div>
                <p class="text-xl font-semibold text-slate-900 dark:text-white">Chat Langsung</p>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Kirim pesan ke petugas kelurahan via WhatsApp. Respon cepat pada jam kerja.</p>
            </div>
            <p class="text-sm font-medium text-green-600 transition group-hover:text-green-700 dark:text-green-400 dark:group-hover:text-green-300">Buka WhatsApp &rarr;</p>
        </a>

        {{-- Panic Button --}}
        <button id="panic-btn" type="button" onclick="triggerPanic()"
            class="group relative flex flex-col gap-4 border border-red-500/30 bg-red-50 p-6 text-left transition hover:border-red-500/50 hover:bg-red-100 cursor-pointer dark:bg-red-500/8 dark:hover:border-red-400/50 dark:hover:bg-red-500/15">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-[0.15em] text-red-600 dark:text-red-400/70">Darurat</p>
                <div class="relative flex h-3 w-3">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-red-500 dark:bg-red-400 opacity-60"></span>
                    <span class="relative inline-flex h-3 w-3 rounded-full bg-red-600 dark:bg-red-500"></span>
                </div>
            </div>
            <div>
                <p class="text-xl font-semibold text-slate-900 dark:text-white">Panic Button</p>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Tekan jika Anda dalam situasi darurat. Petugas akan dihubungi segera.</p>
            </div>
            <p class="text-sm font-medium text-red-600 transition group-hover:text-red-700 dark:text-red-400 dark:group-hover:text-red-300">Tekan untuk darurat &rarr;</p>
        </button>

        {{-- Telepon --}}
        <a href="tel:{{ $village['phone'] ?? '031-5551234' }}"
            class="group flex flex-col gap-4 border border-slate-200 bg-white p-6 transition hover:border-slate-300 hover:bg-slate-50 dark:border-white/8 dark:bg-white/3 dark:hover:border-white/20 dark:hover:bg-white/8">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Telepon</p>
            </div>
            <div>
                <p class="text-xl font-semibold text-slate-900 dark:text-white">{{ $village['phone'] ?? '031-5551234' }}</p>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Hubungi langsung kantor kelurahan melalui nomor telepon resmi.</p>
            </div>
            <p class="text-sm font-medium text-slate-500 transition group-hover:text-slate-700 dark:text-slate-400 dark:group-hover:text-white">Telepon Sekarang &rarr;</p>
        </a>
    </div>

    {{-- Panic Modal --}}
    <div id="panic-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/90 backdrop-blur-sm dark:bg-slate-950/90">
        <div class="mx-4 w-full max-w-md border border-red-500/30 bg-white p-8 text-center shadow-2xl dark:bg-slate-900">
            <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center">
                <div class="panic-ring relative h-12 w-12 rounded-full bg-red-500/10 flex items-center justify-center dark:bg-red-500/20">
                    <span class="relative z-10 text-2xl">🚨</span>
                </div>
            </div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-red-500 dark:text-red-400">Panic Button Aktif</p>
            <h2 class="mt-3 text-2xl font-semibold text-slate-900 dark:text-white">Situasi Darurat?</h2>
            <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-400">Tekan tombol di bawah untuk langsung menghubungi petugas kelurahan atau layanan darurat terdekat via WhatsApp.</p>

            <div class="mt-8 grid gap-3">
                @php
                    $panicText = urlencode('🚨 DARURAT! Saya membutuhkan bantuan segera. Tolong hubungi saya di lokasi ini.');
                    $panicUrl = "https://wa.me/{$waNumber}?text={$panicText}";
                @endphp
                <a href="{{ $panicUrl }}" target="_blank" rel="noopener"
                    class="block w-full bg-green-500 py-3.5 text-sm font-semibold text-white transition hover:bg-green-600 dark:hover:bg-green-400">
                    Kirim Lokasi via WhatsApp
                </a>
                <a href="tel:{{ $village['phone'] ?? '031-5551234' }}"
                    class="block w-full border border-slate-300 py-3.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-white/15 dark:text-white dark:hover:bg-white/8">
                    Telepon Kelurahan
                </a>
                <button onclick="closePanic()" class="w-full py-3 text-sm text-slate-500 transition hover:text-slate-700 dark:hover:text-slate-300">
                    Batal
                </button>
            </div>
        </div>
    </div>

    {{-- Divider --}}
    <div class="mb-12 border-t border-slate-200 pt-12 dark:border-white/8">
        <p class="text-xs font-medium uppercase tracking-[0.3em] text-slate-500">Form Resmi</p>
        <h2 class="mt-3 text-2xl font-semibold text-slate-900 dark:text-white">Kirim laporan tertulis</h2>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Untuk laporan non-darurat yang memerlukan tindak lanjut resmi dan terdokumentasi.</p>
    </div>

    {{-- Form + info --}}
    <div class="grid gap-10 lg:grid-cols-2">

        {{-- Kiri — proses --}}
        <div class="space-y-6">
            <div class="border border-slate-200 bg-white p-6 dark:border-white/8 dark:bg-transparent">
                <p class="text-[10px] uppercase tracking-[0.2em] text-slate-500">Alur Pengaduan</p>
                <div class="mt-6 space-y-5 divide-y divide-slate-200 dark:divide-white/8">
                    @foreach ([
                        ['num' => '01', 'title' => 'Isi form hotline', 'desc' => 'Masukkan nama, kontak, subjek, dan deskripsi laporan Anda.'],
                        ['num' => '02', 'title' => 'Tandai urgent jika perlu', 'desc' => 'Centang urgent agar laporan diprioritaskan oleh petugas.'],
                        ['num' => '03', 'title' => 'Petugas menindaklanjuti', 'desc' => 'Perangkat kelurahan akan menghubungi Anda dalam 1×24 jam.'],
                    ] as $step)
                        <div class="flex gap-5 pt-5 first:pt-0">
                            <span class="text-sm font-semibold text-slate-400 dark:text-slate-600 tabular-nums">{{ $step['num'] }}</span>
                            <div>
                                <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $step['title'] }}</p>
                                <p class="mt-1 text-xs leading-5 text-slate-600 dark:text-slate-400">{{ $step['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <p class="border-l-2 border-slate-300 pl-4 text-xs leading-6 text-slate-500 dark:border-white/10">
                Semua laporan yang masuk akan diproses dan ditindaklanjuti oleh perangkat Kelurahan Simomulyo. Privasi warga dijaga dengan ketat.
            </p>
        </div>

        {{-- Kanan — form --}}
        <div class="border border-slate-200 bg-white p-6 dark:border-white/8 dark:bg-transparent">
            <p class="text-[10px] uppercase tracking-[0.2em] text-slate-500">Form Pengaduan</p>
            <h3 class="mt-2 text-base font-semibold text-slate-900 dark:text-white">Kirim laporan hotline</h3>

            @if (session('success'))
                <div class="mt-4 border border-emerald-500/30 bg-emerald-50 p-4 text-sm text-emerald-600 dark:border-emerald-400/30 dark:bg-emerald-400/10 dark:text-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('hotline.store') }}" class="mt-6 space-y-4">
                @csrf

                {{--
                    🍯 Honeypot — field ini TIDAK BOLEH diisi oleh manusia.
                    Bot akan mengisi field ini secara otomatis karena mereka membaca semua input.
                    Jika field ini terisi, middleware akan membuang request diam-diam.
                    Field disembunyikan dengan CSS (bukan type="hidden") agar lebih meyakinkan bot.
                --}}
                <div style="position:absolute;left:-9999px;top:-9999px;width:0;height:0;overflow:hidden;" aria-hidden="true" tabindex="-1">
                    <label for="website_url">Website URL (kosongkan)</label>
                    <input type="text" id="website_url" name="website_url" value="" autocomplete="off" tabindex="-1">
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-xs text-slate-500 dark:text-slate-400" for="name">Nama Lengkap</label>
                        <input id="name" name="name" value="{{ old('name') }}" placeholder="Nama Anda"
                            class="w-full rounded-none border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none placeholder:text-slate-400 transition focus:border-amber-400/50 dark:border-white/10 dark:bg-slate-950 dark:text-white dark:placeholder:text-slate-600 @error('name') border-red-400/40 @enderror">
                        @error('name') <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs text-slate-500 dark:text-slate-400" for="phone">No. WhatsApp</label>
                        <input id="phone" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx"
                            class="w-full rounded-none border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none placeholder:text-slate-400 transition focus:border-amber-400/50 dark:border-white/10 dark:bg-slate-950 dark:text-white dark:placeholder:text-slate-600 @error('phone') border-red-400/40 @enderror">
                        @error('phone') <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs text-slate-500 dark:text-slate-400" for="email">Email (opsional)</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="email@anda.com"
                        class="w-full rounded-none border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none placeholder:text-slate-400 transition focus:border-amber-400/50 dark:border-white/10 dark:bg-slate-950 dark:text-white dark:placeholder:text-slate-600">
                </div>

                <div>
                    <label class="mb-1.5 block text-xs text-slate-500 dark:text-slate-400" for="subject">Subjek Laporan</label>
                    <input id="subject" name="subject" value="{{ old('subject') }}" placeholder="Deskripsi singkat"
                        class="w-full rounded-none border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none placeholder:text-slate-400 transition focus:border-amber-400/50 dark:border-white/10 dark:bg-slate-950 dark:text-white dark:placeholder:text-slate-600 @error('subject') border-red-400/40 @enderror">
                    @error('subject') <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-xs text-slate-500 dark:text-slate-400" for="message">Isi Laporan</label>
                    <textarea id="message" name="message" rows="5" placeholder="Ceritakan situasi atau kebutuhan Anda secara lengkap..."
                        class="w-full resize-none rounded-none border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none placeholder:text-slate-400 transition focus:border-amber-400/50 dark:border-white/10 dark:bg-slate-950 dark:text-white dark:placeholder:text-slate-600 @error('message') border-red-400/40 @enderror">{{ old('message') }}</textarea>
                    @error('message') <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <label class="flex cursor-pointer items-start gap-3 border border-slate-200 bg-slate-50 p-4 transition hover:border-slate-300 dark:border-white/8 dark:bg-transparent dark:hover:border-white/15">
                    <input type="checkbox" name="is_urgent" value="1" class="mt-0.5 h-4 w-4 shrink-0 accent-amber-500 dark:accent-amber-400">
                    <div>
                        <p class="text-sm font-medium text-slate-900 dark:text-white">Tandai sebagai urgent</p>
                        <p class="mt-0.5 text-xs text-slate-500">Laporan akan diprioritaskan dan diproses lebih cepat.</p>
                    </div>
                </label>

                <button type="submit"
                    class="w-full bg-amber-500 py-3.5 text-sm font-semibold text-white transition hover:bg-amber-600 active:scale-[0.99] dark:bg-amber-400 dark:text-slate-950 dark:hover:bg-amber-300">
                    Kirim Laporan
                </button>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    function triggerPanic() {
        const modal = document.getElementById('panic-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closePanic() {
        const modal = document.getElementById('panic-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    // Close on backdrop click
    document.getElementById('panic-modal').addEventListener('click', function(e) {
        if (e.target === this) closePanic();
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closePanic();
    });
</script>
@endpush
