@extends('layouts.admin')

@section('page-title', 'Keuangan & Anggaran')

@section('content')
    <h1 class="mb-6 text-2xl font-semibold text-slate-900 dark:text-white">Form Transaksi Anggaran</h1>

    @if ($errors->any())
        <div class="mb-6 rounded-lg border border-red-500/30 bg-red-500/10 p-4">
            <ul class="list-inside list-disc text-sm text-red-400">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ $transaction->exists ? route('admin.budgets.update', $transaction) : route('admin.budgets.store') }}" class="grid max-w-3xl gap-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-slate-900/50 dark:shadow-xl dark:backdrop-blur-sm">
        @csrf
        @if ($transaction->exists)
            @method('PUT')
        @endif

        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Judul / Uraian</label>
            <input name="title" value="{{ old('title', $transaction->title) }}" placeholder="Contoh: Pembangunan Jalan Desa" class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">
        </div>

        <div class="grid gap-6 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Kategori</label>
                <input name="category" value="{{ old('category', $transaction->category) }}" placeholder="Contoh: Infrastruktur" class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">
            </div>
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Jenis Transaksi</label>
                <select name="type" class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">
                    <option value="expense" @selected(old('type', $transaction->type ?? 'expense') === 'expense')>▼ Belanja / Pengeluaran</option>
                    <option value="income"  @selected(old('type', $transaction->type) === 'income')>▲ Pendapatan / Penerimaan</option>
                </select>
            </div>
        </div>

        <div class="grid gap-6 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Jumlah (Rp)</label>
                <input name="amount" type="number" step="0.01" value="{{ old('amount', $transaction->amount) }}" placeholder="0" class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">
            </div>
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Tanggal Transaksi</label>
                <input name="transaction_date" type="date" value="{{ old('transaction_date', $transaction->transaction_date?->format('Y-m-d')) }}" class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">
            </div>
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Catatan (Opsional)</label>
            <textarea name="notes" rows="3" placeholder="Tambahkan catatan jika perlu..." class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">{{ old('notes', $transaction->notes) }}</textarea>
        </div>

        <div class="mt-2 flex gap-3">
            <button type="submit" class="rounded-lg bg-cyan-600 px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-cyan-700 dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400">Simpan Transaksi</button>
            <a href="{{ route('admin.budgets.index') }}" class="rounded-lg border border-slate-200 bg-transparent px-6 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-white/10 dark:text-slate-300 dark:hover:bg-white/5">Batal</a>
        </div>
    </form>
@endsection
