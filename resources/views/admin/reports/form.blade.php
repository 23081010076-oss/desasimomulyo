@extends('layouts.admin')

@section('content')
    <h1 class="mb-6 text-2xl font-semibold text-slate-900 dark:text-white">Form Laporan</h1>

    <form method="POST" action="{{ $report->exists ? route('admin.reports.update', $report) : route('admin.reports.store') }}" class="grid max-w-2xl gap-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-white/5">
        @csrf
        @if ($report->exists)
            @method('PUT')
        @endif

        <input name="title" value="{{ old('title', $report->title) }}" placeholder="Judul" class="rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">
        <textarea name="description" placeholder="Deskripsi" class="rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">{{ old('description', $report->description) }}</textarea>
        <input name="latitude" value="{{ old('latitude', $report->latitude) }}" placeholder="Latitude" class="rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">
        <input name="longitude" value="{{ old('longitude', $report->longitude) }}" placeholder="Longitude" class="rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">
        <input name="image_path" value="{{ old('image_path', $report->image_path) }}" placeholder="Path gambar" class="rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">

        <button class="mt-2 justify-self-start rounded-lg bg-cyan-600 px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-cyan-700 dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400">Simpan</button>
    </form>
@endsection
