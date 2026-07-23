@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="mb-10">
        <p class="text-xs font-medium uppercase tracking-[0.3em] text-cyan-600 dark:text-cyan-400/80">Sistem Informasi Desa</p>
        <h2 class="mt-2 text-2xl font-semibold text-slate-900 dark:text-white sm:text-4xl">Admin Dashboard</h2>
        <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">Pantau semua aktivitas kelurahan, layanan publik, dan transaksi dari satu panel terpusat.</p>
    </div>

    {{-- Stats Overview --}}
    <div class="mb-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @php
            $statCards = [
                ['label' => 'Total Laporan', 'value' => $stats['reports'], 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z', 'color' => 'cyan'],
                ['label' => 'Laporan Darurat', 'value' => $stats['emergency'], 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z', 'color' => 'rose'],
                ['label' => 'Permohonan Surat', 'value' => $stats['documents'], 'icon' => 'M9 12h6M9 16h6M14 3H6a2 2 0 00-2 2v14a2 2 0 002 2h12a2 2 0 002-2V8z', 'color' => 'emerald'],
                ['label' => 'Katalog UMKM', 'value' => $stats['products'], 'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z', 'color' => 'amber'],
            ];
        @endphp

        @foreach ($statCards as $card)
            <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:border-{{ $card['color'] }}-500/30 hover:shadow-md dark:border-white/10 dark:bg-slate-900/50 dark:shadow-xl dark:backdrop-blur-sm dark:hover:bg-slate-900/80">
                <div class="absolute -right-4 -top-4 h-24 w-24 rounded-full bg-{{ $card['color'] }}-500/10 blur-2xl transition group-hover:bg-{{ $card['color'] }}-500/20 dark:bg-{{ $card['color'] }}-500/10 dark:group-hover:bg-{{ $card['color'] }}-500/20"></div>
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-{{ $card['color'] }}-50 text-{{ $card['color'] }}-600 dark:bg-{{ $card['color'] }}-500/10 dark:text-{{ $card['color'] }}-400">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="{{ $card['icon'] }}"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-slate-500 dark:text-slate-400">{{ $card['label'] }}</p>
                        <p class="mt-0.5 text-2xl font-bold text-slate-900 dark:text-white">{{ $card['value'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Charts Section --}}
    <div class="mb-8 grid gap-6 lg:grid-cols-2">
        {{-- Reports Chart --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-slate-900/50 dark:shadow-xl dark:backdrop-blur-sm">
            <h3 class="mb-6 text-sm font-semibold text-slate-900 dark:text-white">Status Laporan Warga</h3>
            <div class="relative h-[250px] w-full flex items-center justify-center">
                <canvas id="reportsChart"></canvas>
            </div>
        </div>

        {{-- Budget Chart --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-slate-900/50 dark:shadow-xl dark:backdrop-blur-sm">
            <h3 class="mb-6 text-sm font-semibold text-slate-900 dark:text-white">Ikhtisar Keuangan Desa</h3>
            <div class="relative h-[250px] w-full flex items-center justify-center">
                <canvas id="budgetChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Laporan terbaru --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-slate-900/50 dark:shadow-xl dark:backdrop-blur-sm">
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
                        <div class="mt-1 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-slate-100 text-slate-500 dark:border-white/10 dark:bg-slate-800 dark:text-slate-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
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
                        <span class="inline-flex rounded-full border {{ $statusClass }} px-3 py-1 text-[10px] font-semibold uppercase tracking-wider">{{ $statusVal }}</span>
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-12">
                    <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400 dark:bg-slate-800 dark:text-slate-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="text-sm font-medium text-slate-900 dark:text-white">Semua Aman</p>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Belum ada laporan warga terbaru yang masuk.</p>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check Theme
            const isDark = document.documentElement.classList.contains('dark');
            const textColor = isDark ? '#94a3b8' : '#64748b';
            const gridColor = isDark ? 'rgba(255, 255, 255, 0.05)' : '#f1f5f9';

            Chart.defaults.color = textColor;
            Chart.defaults.font.family = "'Inter', sans-serif";

            // Data for Reports
            const rawReports = @json($reportsByStatus);
            // Normalize keys if they are enum strings like PENDING, RESOLVED
            const reportData = [
                rawReports['PENDING'] || rawReports['pending'] || 0,
                rawReports['PROCESSED'] || rawReports['diproses'] || 0,
                rawReports['RESOLVED'] || rawReports['selesai'] || 0,
                rawReports['REJECTED'] || rawReports['ditolak'] || 0,
            ];

            const ctxReports = document.getElementById('reportsChart').getContext('2d');
            new Chart(ctxReports, {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'Diproses', 'Selesai', 'Ditolak'],
                    datasets: [{
                        data: reportData,
                        backgroundColor: ['#f59e0b', '#06b6d4', '#10b981', '#f43f5e'],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: { position: 'right', labels: { usePointStyle: true, boxWidth: 8 } }
                    }
                }
            });

            // Data for Budget
            const budgetData = @json($budgetStats);
            const income = parseFloat(budgetData.income || 0);
            const expense = parseFloat(budgetData.expense || 0);

            const ctxBudget = document.getElementById('budgetChart').getContext('2d');
            new Chart(ctxBudget, {
                type: 'bar',
                data: {
                    labels: ['Pemasukan', 'Pengeluaran'],
                    datasets: [{
                        label: 'Total (Rp)',
                        data: [income, expense],
                        backgroundColor: ['#10b981', '#f43f5e'],
                        borderRadius: 6,
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: gridColor, drawBorder: false },
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + (value / 1000000) + 'Jt';
                                }
                            }
                        },
                        x: {
                            grid: { display: false, drawBorder: false }
                        }
                    }
                }
            });
        });
    </script>
@endsection
