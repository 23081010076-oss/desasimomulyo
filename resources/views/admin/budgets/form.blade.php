@extends('layouts.admin')

@section('content')
    <h1 class="mb-6 text-2xl font-semibold text-white">Form Anggaran</h1>
    <form method="POST" action="{{ $transaction->exists ? route('admin.budgets.update', $transaction) : route('admin.budgets.store') }}" class="grid max-w-2xl gap-4 rounded-2xl border border-white/10 bg-white/5 p-6">
        @csrf
        @if ($transaction->exists)
            @method('PUT')
        @endif
        <input name="title" value="{{ old('title', $transaction->title) }}" placeholder="Judul / Uraian" class="rounded-lg border border-white/10 bg-slate-950/80 p-3 text-white">
        <input name="category" value="{{ old('category', $transaction->category) }}" placeholder="Kategori (contoh: Infrastruktur, Sosial)" class="rounded-lg border border-white/10 bg-slate-950/80 p-3 text-white">
        <select name="type" class="rounded-lg border border-white/10 bg-slate-950/80 p-3 text-white">
            <option value="expense" @selected(old('type', $transaction->type ?? 'expense') === 'expense')>▼ Belanja / Pengeluaran</option>
            <option value="income"  @selected(old('type', $transaction->type) === 'income')>▲ Pendapatan / Penerimaan</option>
        </select>
        <input name="amount" type="number" step="0.01" value="{{ old('amount', $transaction->amount) }}" placeholder="Jumlah (Rp)" class="rounded-lg border border-white/10 bg-slate-950/80 p-3 text-white">
        <input name="transaction_date" type="date" value="{{ old('transaction_date', $transaction->transaction_date?->format('Y-m-d')) }}" placeholder="Tanggal" class="rounded-lg border border-white/10 bg-slate-950/80 p-3 text-white">
        <textarea name="notes" placeholder="Catatan tambahan (opsional)" class="rounded-lg border border-white/10 bg-slate-950/80 p-3 text-white">{{ old('notes', $transaction->notes) }}</textarea>
        <button class="rounded-lg bg-cyan-500 px-4 py-2 font-medium text-slate-950">Simpan</button>
    </form>
@endsection
