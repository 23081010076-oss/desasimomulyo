@extends('layouts.admin')

@section('page-title', 'Layanan Publik')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-900 dark:text-white">Form Jenis Surat</h1>
        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Buat atau perbarui master data jenis dokumen</p>
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

    <form method="POST" action="{{ $documentType->exists ? route('admin.document-types.update', $documentType) : route('admin.document-types.store') }}" class="grid max-w-2xl gap-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-slate-900/50 dark:shadow-xl dark:backdrop-blur-sm">
        @csrf
        @if ($documentType->exists)
            @method('PUT')
        @endif
        
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Nama Jenis Surat</label>
            <input name="name" value="{{ old('name', $documentType->name) }}" placeholder="Contoh: Surat Keterangan Usaha" class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">
        </div>
        
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Kode Surat</label>
            <input name="code" value="{{ old('code', $documentType->code) }}" placeholder="Contoh: SKU, SKTM" class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white font-mono">
        </div>
        
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Deskripsi (Opsional)</label>
            <textarea name="description" rows="3" placeholder="Penjelasan singkat fungsi surat ini..." class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">{{ old('description', $documentType->description) }}</textarea>
        </div>

        <div class="mt-4 flex gap-3">
            <button type="submit" class="rounded-lg bg-cyan-600 px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-cyan-700 dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400">Simpan Jenis Surat</button>
            <a href="{{ route('admin.document-types.index') }}" class="rounded-lg border border-slate-200 bg-transparent px-6 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-white/10 dark:text-slate-300 dark:hover:bg-white/5">Batal</a>
        </div>
    </form>
@endsection
