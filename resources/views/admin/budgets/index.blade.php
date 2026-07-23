@extends('layouts.admin')

@section('page-title', 'Keuangan & Anggaran')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900 dark:text-white">Transaksi Anggaran</h1>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Kelola catatan pendapatan dan belanja desa</p>
        </div>
        <a href="{{ route('admin.budgets.create') }}" class="flex items-center gap-2 rounded-lg bg-cyan-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-cyan-700 dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400">
            <span>+</span> Tambah Transaksi
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg border border-emerald-500/30 bg-emerald-50 p-4 dark:bg-emerald-500/10">
            <p class="text-sm text-emerald-600 dark:text-emerald-400">{{ session('success') }}</p>
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-slate-900/50 dark:shadow-xl dark:backdrop-blur-sm">
        @forelse ($transactions as $transaction)
            <div class="flex items-center justify-between border-b border-slate-200 p-5 last:border-b-0 hover:bg-slate-50 transition dark:border-white/10 dark:hover:bg-white/5">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border {{ $transaction->type === 'income' ? 'border-emerald-200 bg-emerald-50 text-emerald-600 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-400' : 'border-red-200 bg-red-50 text-red-600 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-400' }}">
                        {!! $transaction->type === 'income' ? '▲' : '▼' !!}
                    </div>
                    <div>
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $transaction->title }}</p>
                        <div class="mt-1 flex flex-wrap items-center gap-3 text-xs text-slate-500 dark:text-slate-400">
                            <span class="font-medium {{ $transaction->type === 'income' ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }}">
                                Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </span>
                            <span class="h-1 w-1 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                            <span>{{ $transaction->category }}</span>
                            <span class="h-1 w-1 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                            <span>{{ $transaction->transaction_date ? $transaction->transaction_date->format('d M Y') : '-' }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3 text-sm font-medium">
                    <a class="text-cyan-600 transition hover:text-cyan-700 dark:text-cyan-400 dark:hover:text-cyan-300" href="{{ route('admin.budgets.edit', $transaction) }}">Edit</a>
                    <form method="POST" action="{{ route('admin.budgets.destroy', $transaction) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-rose-600 transition hover:text-rose-700 dark:text-rose-400 dark:hover:text-rose-300">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="p-8 text-center text-slate-500 dark:text-slate-400">Belum ada transaksi anggaran.</div>
        @endforelse
    </div>
    
    @if(method_exists($transactions, 'hasPages') && $transactions->hasPages())
        <div class="mt-6">
            {{ $transactions->links() }}
        </div>
    @endif
@endsection
