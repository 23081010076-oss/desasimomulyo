@extends('layouts.site')

@section('content')
<section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">

    {{-- ── Page Header ── --}}
    <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-600 dark:text-emerald-400">Kelurahan Simomulyo</p>
            <h1 class="mt-3 text-4xl font-semibold leading-tight text-slate-900 dark:text-white sm:text-5xl">Transparansi Dana Desa</h1>
            <p class="mt-4 max-w-2xl text-base leading-8 text-slate-600 dark:text-slate-400">
                Laporan keuangan kelurahan yang terbuka dan dapat diakses oleh seluruh warga. Data ini diperbarui secara berkala untuk menjamin akuntabilitas pengelolaan dana desa.
            </p>
        </div>
        <a href="{{ route('hotline') }}"
           class="shrink-0 rounded border border-amber-500/30 bg-amber-50 px-5 py-2.5 text-sm font-medium text-amber-600 transition hover:bg-amber-100 dark:border-amber-400/30 dark:bg-amber-400/10 dark:text-amber-300 dark:hover:bg-amber-400/20">
            Laporkan Kejanggalan
        </a>
    </div>

    {{-- ── Summary Cards ── --}}
    <div class="mt-10 grid gap-4 sm:grid-cols-3">
        {{-- Total Pendapatan --}}
        <div class="rounded-none border border-emerald-200 bg-emerald-50 p-6 dark:border-emerald-500/20 dark:bg-emerald-500/5">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-100 dark:bg-emerald-500/10">
                    <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8l-8-8-8 8"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-[0.15em] text-emerald-700 dark:text-emerald-400/70">Total Pendapatan {{ $year }}</p>
                    <p class="mt-1 text-xl font-bold text-emerald-800 dark:text-emerald-300">
                        Rp {{ number_format($totalIncome, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Total Belanja --}}
        <div class="rounded-none border border-red-200 bg-red-50 p-6 dark:border-red-500/20 dark:bg-red-500/5">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-500/10">
                    <svg class="h-5 w-5 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20V4m-8 8l8 8 8-8"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-[0.15em] text-red-700 dark:text-red-400/70">Total Belanja {{ $year }}</p>
                    <p class="mt-1 text-xl font-bold text-red-800 dark:text-red-300">
                        Rp {{ number_format($totalExpense, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Saldo / Selisih --}}
        @php $balance = $totalIncome - $totalExpense; @endphp
        <div class="rounded-none border border-slate-200 bg-white p-6 dark:border-white/10 dark:bg-white/3">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-slate-100 dark:bg-white/10">
                    <svg class="h-5 w-5 text-slate-600 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-[0.15em] text-slate-500">Saldo Tahun {{ $year }}</p>
                    <p class="mt-1 text-xl font-bold {{ $balance >= 0 ? 'text-emerald-700 dark:text-emerald-300' : 'text-red-700 dark:text-red-300' }}">
                        Rp {{ number_format(abs($balance), 0, ',', '.') }}
                        <span class="text-sm font-normal text-slate-500">({{ $balance >= 0 ? 'Surplus' : 'Defisit' }})</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Chart + Category Breakdown ── --}}
    <div class="mt-8 grid gap-6 lg:grid-cols-[1fr_340px]">

        {{-- Bar Chart (Canvas) --}}
        <div class="border border-slate-200 bg-white p-6 dark:border-white/8 dark:bg-transparent">
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <p class="text-[10px] uppercase tracking-[0.15em] text-slate-500">Grafik Bulanan</p>
                    <h2 class="mt-1 text-sm font-semibold text-slate-900 dark:text-white">Arus Pendapatan & Belanja {{ $year }}</h2>
                </div>
            </div>
            <div class="relative h-56">
                <canvas id="budgetChart"></canvas>
            </div>
        </div>

        {{-- Category Breakdown --}}
        <div class="border border-slate-200 bg-white p-6 dark:border-white/8 dark:bg-transparent">
            <p class="text-[10px] uppercase tracking-[0.15em] text-slate-500">Breakdown Kategori</p>
            <h2 class="mt-1 text-sm font-semibold text-slate-900 dark:text-white">Per Kategori {{ $year }}</h2>
            <div class="mt-4 space-y-3 max-h-56 overflow-y-auto pr-1">
                @forelse ($categoryBreakdown as $cat)
                    <div>
                        <div class="flex justify-between text-xs text-slate-600 dark:text-slate-400">
                            <span class="font-medium text-slate-900 dark:text-white truncate max-w-[140px]" title="{{ $cat->category }}">{{ $cat->category }}</span>
                            <span class="{{ $cat->type === 'income' ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-500 dark:text-red-400' }}">
                                {{ $cat->type === 'income' ? '+' : '-' }} Rp {{ number_format($cat->total, 0, ',', '.') }}
                            </span>
                        </div>
                        @php
                            $maxForType = $categoryBreakdown->where('type', $cat->type)->max('total');
                            $pct = $maxForType > 0 ? ($cat->total / $maxForType) * 100 : 0;
                        @endphp
                        <div class="mt-1.5 h-1 w-full rounded-full bg-slate-100 dark:bg-white/10">
                            <div class="h-1 rounded-full {{ $cat->type === 'income' ? 'bg-emerald-500' : 'bg-red-400' }}" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-500">Belum ada data kategori untuk tahun ini.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ── Filter Bar ── --}}
    <div class="mt-8 border border-slate-200 bg-slate-50 p-4 dark:border-white/8 dark:bg-white/3">
        <form method="GET" action="{{ route('budget.transparency') }}" class="flex flex-wrap items-end gap-4">

            {{-- Year --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-[10px] uppercase tracking-[0.15em] text-slate-500">Tahun</label>
                <select name="year" class="rounded-none border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 outline-none focus:border-emerald-500 dark:border-white/10 dark:bg-slate-900 dark:text-white">
                    @foreach ($years as $y)
                        <option value="{{ $y }}" @selected($y == $year)>{{ $y }}</option>
                    @endforeach
                    @if ($years->isEmpty())
                        <option value="{{ now()->year }}" selected>{{ now()->year }}</option>
                    @endif
                </select>
            </div>

            {{-- Category --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-[10px] uppercase tracking-[0.15em] text-slate-500">Kategori</label>
                <select name="category" class="rounded-none border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 outline-none focus:border-emerald-500 dark:border-white/10 dark:bg-slate-900 dark:text-white">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}" @selected($cat === $category)>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Type --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-[10px] uppercase tracking-[0.15em] text-slate-500">Jenis</label>
                <select name="type" class="rounded-none border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 outline-none focus:border-emerald-500 dark:border-white/10 dark:bg-slate-900 dark:text-white">
                    <option value="">Semua</option>
                    <option value="income" @selected($type === 'income')>Pendapatan</option>
                    <option value="expense" @selected($type === 'expense')>Belanja</option>
                </select>
            </div>

            <button type="submit" class="rounded-none bg-emerald-600 px-5 py-2 text-sm font-medium text-white transition hover:bg-emerald-700 dark:bg-emerald-500 dark:hover:bg-emerald-400">
                Filter
            </button>
            <a href="{{ route('budget.transparency') }}" class="rounded-none border border-slate-200 bg-white px-5 py-2 text-sm text-slate-600 transition hover:border-slate-300 hover:text-slate-900 dark:border-white/10 dark:bg-transparent dark:text-slate-400 dark:hover:border-white/20 dark:hover:text-white">
                Reset
            </a>
        </form>
    </div>

    {{-- ── Transaction Table ── --}}
    <div class="mt-4 overflow-hidden border border-slate-200 dark:border-white/8">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-100 dark:bg-white/5">
                    <tr>
                        <th class="px-4 py-3 text-left text-[10px] font-semibold uppercase tracking-[0.15em] text-slate-500">Tanggal</th>
                        <th class="px-4 py-3 text-left text-[10px] font-semibold uppercase tracking-[0.15em] text-slate-500">Uraian</th>
                        <th class="px-4 py-3 text-left text-[10px] font-semibold uppercase tracking-[0.15em] text-slate-500">Kategori</th>
                        <th class="px-4 py-3 text-left text-[10px] font-semibold uppercase tracking-[0.15em] text-slate-500">Jenis</th>
                        <th class="px-4 py-3 text-right text-[10px] font-semibold uppercase tracking-[0.15em] text-slate-500">Jumlah (Rp)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                    @forelse ($transactions as $tx)
                        <tr class="bg-white transition hover:bg-slate-50 dark:bg-transparent dark:hover:bg-white/2">
                            <td class="whitespace-nowrap px-4 py-3.5 text-xs text-slate-500">
                                {{ \Carbon\Carbon::parse($tx->transaction_date)->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3.5">
                                <p class="font-medium text-slate-900 dark:text-white">{{ $tx->title }}</p>
                                @if($tx->notes)
                                    <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-500">{{ Str::limit($tx->notes, 80) }}</p>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-4 py-3.5 text-xs text-slate-600 dark:text-slate-400">
                                {{ $tx->category }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3.5">
                                @if($tx->type === 'income')
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                        <span>▲</span> Pendapatan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-700 dark:bg-red-500/10 dark:text-red-400">
                                        <span>▼</span> Belanja
                                    </span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-4 py-3.5 text-right font-semibold {{ $tx->type === 'income' ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ $tx->type === 'income' ? '+' : '-' }} {{ number_format($tx->amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-16 text-center">
                                <p class="text-sm text-slate-500">Belum ada data transaksi untuk filter yang dipilih.</p>
                                <a href="{{ route('budget.transparency') }}" class="mt-3 inline-block text-sm text-emerald-600 hover:underline dark:text-emerald-400">Reset filter</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($transactions->hasPages())
            <div class="border-t border-slate-100 bg-slate-50 px-4 py-3 dark:border-white/5 dark:bg-white/2">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>

    {{-- ── Disclaimer ── --}}
    <div class="mt-6 flex gap-3 border border-slate-200 bg-slate-50 p-4 dark:border-white/8 dark:bg-white/2">
        <svg class="mt-0.5 h-4 w-4 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="text-xs leading-6 text-slate-500 dark:text-slate-500">
            Data keuangan ini bersumber dari administrasi Kelurahan Simomulyo dan diperbarui secara berkala. Jika Anda menemukan ketidaksesuaian atau memiliki pertanyaan, silakan hubungi kami melalui
            <a href="{{ route('hotline') }}" class="text-emerald-600 hover:underline dark:text-emerald-400">Hotline Kelurahan</a>.
        </p>
    </div>

</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const isDark = document.documentElement.classList.contains('dark');

    // Build monthly data from PHP
    const monthlyRaw = @json($monthlyData);
    const labels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
    const incomeData  = new Array(12).fill(0);
    const expenseData = new Array(12).fill(0);

    Object.entries(monthlyRaw).forEach(([month, rows]) => {
        const idx = parseInt(month) - 1;
        rows.forEach(r => {
            if (r.type === 'income')  incomeData[idx]  = parseFloat(r.total);
            if (r.type === 'expense') expenseData[idx] = parseFloat(r.total);
        });
    });

    const ctx = document.getElementById('budgetChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels,
            datasets: [
                {
                    label: 'Pendapatan',
                    data: incomeData,
                    backgroundColor: isDark ? 'rgba(52,211,153,0.6)' : 'rgba(16,185,129,0.5)',
                    borderColor: isDark ? 'rgba(52,211,153,0.9)' : 'rgb(16,185,129)',
                    borderWidth: 1,
                    borderRadius: 3,
                },
                {
                    label: 'Belanja',
                    data: expenseData,
                    backgroundColor: isDark ? 'rgba(248,113,113,0.6)' : 'rgba(239,68,68,0.5)',
                    borderColor: isDark ? 'rgba(248,113,113,0.9)' : 'rgb(239,68,68)',
                    borderWidth: 1,
                    borderRadius: 3,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: isDark ? '#94a3b8' : '#64748b',
                        font: { size: 11 }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: ctx => ctx.dataset.label + ': Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                x: {
                    grid: { color: isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)' },
                    ticks: { color: isDark ? '#64748b' : '#94a3b8', font: { size: 10 } }
                },
                y: {
                    grid: { color: isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)' },
                    ticks: {
                        color: isDark ? '#64748b' : '#94a3b8',
                        font: { size: 10 },
                        callback: v => 'Rp ' + (v >= 1_000_000 ? (v/1_000_000).toFixed(0)+'jt' : v.toLocaleString('id-ID'))
                    }
                }
            }
        }
    });
</script>
@endpush
