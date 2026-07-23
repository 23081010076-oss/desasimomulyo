@extends('layouts.admin')

@section('page-title', 'Layanan Publik')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900 dark:text-white">Laporan Warga</h1>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Kelola dan tindak lanjuti laporan keluhan dari warga</p>
        </div>
        <a href="{{ route('admin.reports.create') }}" class="flex items-center gap-2 rounded-lg bg-cyan-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-cyan-700 dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400">
            <span>+</span> Tambah Laporan
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg border border-emerald-500/30 bg-emerald-50 p-4 dark:bg-emerald-500/10">
            <p class="text-sm text-emerald-600 dark:text-emerald-400">{{ session('success') }}</p>
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-slate-900/50 dark:shadow-xl dark:backdrop-blur-sm">
        @forelse ($reports as $report)
            <div class="flex flex-col gap-4 border-b border-slate-200 p-5 last:border-b-0 hover:bg-slate-50 transition dark:border-white/10 dark:hover:bg-white/5 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-start gap-4">
                    <div class="mt-1 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-slate-100 text-slate-500 dark:border-white/10 dark:bg-slate-800 dark:text-slate-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $report->title }}</p>
                        <div class="mt-1 flex flex-wrap items-center gap-3 text-xs text-slate-500 dark:text-slate-400">
                            @php
                                $statusVal = strtolower($report->status->value ?? $report->status);
                                $statusColors = [
                                    'pending'  => 'border-amber-500/30 bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400',
                                    'diproses' => 'border-cyan-500/30 bg-cyan-50 text-cyan-600 dark:bg-cyan-500/10 dark:text-cyan-400',
                                    'selesai'  => 'border-emerald-500/30 bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400',
                                    'ditolak'  => 'border-rose-500/30 bg-rose-50 text-rose-600 dark:bg-rose-500/10 dark:text-rose-400',
                                ];
                                $statusClass = $statusColors[$statusVal] ?? 'border-slate-200 bg-slate-50 text-slate-500 dark:border-white/10 dark:bg-white/5 dark:text-slate-400';
                            @endphp
                            <span class="inline-flex rounded-full border {{ $statusClass }} px-2.5 py-0.5 font-medium capitalize">{{ $statusVal }}</span>
                            <span class="h-1 w-1 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                            <span>{{ $report->created_at->format('d M Y, H:i') }}</span>
                            <span class="h-1 w-1 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                            <span>Pelapor: <span class="font-medium text-slate-700 dark:text-slate-300">{{ $report->user->name ?? 'Anonim' }}</span></span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3 text-sm font-medium">
                    <a class="text-cyan-600 transition hover:text-cyan-700 dark:text-cyan-400 dark:hover:text-cyan-300" href="{{ route('admin.reports.edit', $report) }}">Tinjau</a>
                    <form method="POST" action="{{ route('admin.reports.destroy', $report) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-rose-600 transition hover:text-rose-700 dark:text-rose-400 dark:hover:text-rose-300">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="p-8 text-center text-slate-500 dark:text-slate-400">Belum ada laporan warga masuk.</div>
        @endforelse
    </div>

    @if(method_exists($reports, 'hasPages') && $reports->hasPages())
        <div class="mt-6">
            {{ $reports->links() }}
        </div>
    @endif
@endsection
