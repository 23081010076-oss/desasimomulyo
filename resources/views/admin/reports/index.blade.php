@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-slate-900 dark:text-white">Laporan Warga</h1>
        <a href="{{ route('admin.reports.create') }}" class="rounded-lg bg-cyan-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-cyan-700 dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400">Tambah</a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-white/5">
        @foreach ($reports as $report)
            <div class="flex flex-col gap-3 border-b border-slate-200 p-4 last:border-b-0 hover:bg-slate-50 transition dark:border-white/10 dark:hover:bg-white/5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="font-medium text-slate-900 dark:text-white">{{ $report->title }}</p>
                    <p class="text-sm text-slate-500 dark:text-slate-400">{{ $report->status->value ?? $report->status }}</p>
                </div>
                <div class="flex gap-3 text-sm">
                    <a class="text-cyan-600 transition hover:text-cyan-700 dark:text-cyan-300 dark:hover:text-cyan-200" href="{{ route('admin.reports.edit', $report) }}">Edit</a>
                    <form method="POST" action="{{ route('admin.reports.destroy', $report) }}">
                        @csrf
                        @method('DELETE')
                        <button class="text-rose-600 transition hover:text-rose-700 dark:text-rose-300 dark:hover:text-rose-200">Hapus</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection
