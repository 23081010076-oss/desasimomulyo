@extends('layouts.admin')

@section('page-title', 'Pengaturan Desa')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-900 dark:text-white">Pengaturan Desa</h1>
        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Konfigurasi informasi kontak dan lokasi kantor desa</p>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg border border-emerald-500/30 bg-emerald-50 p-4 dark:bg-emerald-500/10">
            <p class="text-sm text-emerald-600 dark:text-emerald-400">{{ session('success') }}</p>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}" class="grid max-w-3xl gap-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-slate-900/50 dark:shadow-xl dark:backdrop-blur-sm">
        @csrf
        @method('PUT')

        <div class="grid gap-6 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Nomor WhatsApp (Hotline)</label>
                <input name="whatsapp" value="{{ old('whatsapp', $settings['whatsapp'] ?? '') }}" placeholder="6281234567890" class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Gunakan kode negara tanpa +, contoh: 628...</p>
            </div>
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Nomor Telepon Kantor</label>
                <input name="phone" value="{{ old('phone', $settings['phone'] ?? '') }}" placeholder="031-5551234" class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">
            </div>
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Alamat Kantor Desa/Kelurahan</label>
            <textarea name="address" rows="3" class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">{{ old('address', $settings['address'] ?? '') }}</textarea>
        </div>

        <div class="grid gap-6 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Latitude (Koordinat Peta)</label>
                <input name="latitude" value="{{ old('latitude', $settings['latitude'] ?? '') }}" placeholder="-7.2647640" class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">
            </div>
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Longitude (Koordinat Peta)</label>
                <input name="longitude" value="{{ old('longitude', $settings['longitude'] ?? '') }}" placeholder="112.7117945" class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">
            </div>
        </div>

        <div class="mt-4 flex gap-3">
            <button type="submit" class="rounded-lg bg-cyan-600 px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-cyan-700 dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400">Simpan Pengaturan</button>
        </div>
    </form>
@endsection
