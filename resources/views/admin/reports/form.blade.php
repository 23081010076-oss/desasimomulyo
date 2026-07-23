@extends('layouts.admin')

@section('page-title', 'Layanan Publik')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-900 dark:text-white">Tinjau Laporan Warga</h1>
        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Tinjau detail dan perbarui status laporan/keluhan warga</p>
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

    <form method="POST" action="{{ $report->exists ? route('admin.reports.update', $report) : route('admin.reports.store') }}" class="grid max-w-3xl gap-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-slate-900/50 dark:shadow-xl dark:backdrop-blur-sm">
        @csrf
        @if ($report->exists)
            @method('PUT')
        @endif

        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Judul Laporan</label>
            <input name="title" value="{{ old('title', $report->title) }}" placeholder="Contoh: Jalan berlubang di RT 03" class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Deskripsi Lengkap</label>
            <textarea name="description" rows="4" placeholder="Detail laporan..." class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">{{ old('description', $report->description) }}</textarea>
        </div>

        <div class="grid gap-6 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Status Laporan</label>
                <select name="status" class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white font-medium capitalize">
                    @foreach(['pending', 'diproses', 'selesai', 'ditolak'] as $status)
                        <option value="{{ $status }}" @selected(old('status', strtolower($report->status->value ?? $report->status)) === $status)>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">File Lampiran (Opsional)</label>
                <input name="image_path" value="{{ old('image_path', $report->image_path) }}" placeholder="URL Lampiran" class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">
            </div>
        </div>

        <div class="grid gap-6 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Latitude</label>
                <input name="latitude" value="{{ old('latitude', $report->latitude) }}" placeholder="-7.250445" class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white font-mono">
            </div>
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Longitude</label>
                <input name="longitude" value="{{ old('longitude', $report->longitude) }}" placeholder="112.768845" class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white font-mono">
            </div>
        </div>

        <div class="mt-4 flex gap-3">
            <button type="submit" class="rounded-lg bg-cyan-600 px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-cyan-700 dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400">Simpan Perubahan</button>
            <a href="{{ route('admin.reports.index') }}" class="rounded-lg border border-slate-200 bg-transparent px-6 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-white/10 dark:text-slate-300 dark:hover:bg-white/5">Kembali</a>
        </div>
    </form>
@endsection
