@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
    <div class="mb-10">
        <p class="text-xs font-medium uppercase tracking-[0.3em] text-cyan-600 dark:text-cyan-400/80">Sistem Informasi Desa</p>
        <h2 class="mt-2 text-2xl font-semibold text-slate-900 dark:text-white sm:text-4xl">Admin Dashboard</h2>
        <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">Pantau semua aktivitas kelurahan, layanan publik, dan transaksi dari satu panel terpusat.</p>
    </div>

    {{-- Stats --}}
    <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
        @foreach ($stats as $label => $value)
            <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-all hover:-translate-y-1 hover:border-cyan-500/30 hover:shadow-md dark:border-white/10 dark:bg-slate-900/50 dark:shadow-xl dark:backdrop-blur-sm dark:hover:bg-slate-900/80">
                <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-cyan-500/5 blur-2xl transition group-hover:bg-cyan-500/10 dark:bg-cyan-500/10 dark:group-hover:bg-cyan-500/20"></div>
                <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500 dark:text-slate-400">{{ $label }}</p>
                <p class="mt-4 text-5xl font-bold text-slate-900 dark:text-white">{{ $value }}</p>
            </div>
        @endforeach
    </div>

    {{-- Laporan terbaru --}}
    <div class="mt-10 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-slate-900/50 dark:shadow-xl dark:backdrop-blur-sm">
        <div class="flex items-center justify-between border-b border-slate-200 bg-slate-50 px-6 py-5 dark:border-white/10 dark:bg-white/5">
            <div>
                <p class="text-base font-semibold text-slate-900 dark:text-white">Laporan Warga Terbaru</p>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Menampilkan 5 laporan terakhir yang butuh tindak lanjut</p>
            </div>
            <a href="{{ route('admin.reports.index') }}" class="rounded-lg border border-slate-200 bg-transparent px-4 py-2 text-xs font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 dark:border-white/10 dark:text-slate-300 dark:hover:bg-white/5 dark:hover:text-white">Lihat Semua</a>
        </div>

        <div class="divide-y divide-slate-100 dark:divide-white/5">
            @forelse ($recentReports as $report)
                <div class="flex flex-col gap-4 px-6 py-5 transition hover:bg-slate-50 dark:hover:bg-white/5 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-start gap-4">
                        <div class="mt-1 flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-slate-100 text-lg dark:border-white/10 dark:bg-slate-800">
                            📝
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $report->title }}</p>
                            <p class="mt-1 max-w-2xl text-xs leading-relaxed text-slate-500 dark:text-slate-400">{{ Str::limit($report->description, 100) }}</p>
                            <div class="mt-2 flex items-center gap-2 text-[10px] uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                <span>{{ $report->created_at->format('d M Y') }}</span>
                                <span class="h-1 w-1 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                                <span>{{ $report->user->name ?? 'Anonim' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="shrink-0">
                        @php
                            $statusVal = $report->status->value ?? $report->status;
                            $statusColors = [
                                'pending'  => 'border-amber-500/30 bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400',
                                'diproses' => 'border-cyan-500/30 bg-cyan-50 text-cyan-600 dark:bg-cyan-500/10 dark:text-cyan-400',
                                'selesai'  => 'border-emerald-500/30 bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400',
                                'ditolak'  => 'border-rose-500/30 bg-rose-50 text-rose-600 dark:bg-rose-500/10 dark:text-rose-400',
                            ];
                            $statusClass = $statusColors[strtolower($statusVal)] ?? 'border-slate-200 bg-slate-50 text-slate-500 dark:border-white/10 dark:bg-white/5 dark:text-slate-400';
                        @endphp
                        <span class="inline-flex rounded-full border {{ $statusClass }} px-3 py-1 text-xs font-medium tracking-wide">{{ $statusVal }}</span>
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-12">
                    <div class="mb-3 rounded-full bg-slate-100 p-4 text-2xl dark:bg-slate-800">✨</div>
                    <p class="text-sm font-medium text-slate-900 dark:text-white">Semua Aman</p>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Belum ada laporan warga terbaru yang masuk.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
