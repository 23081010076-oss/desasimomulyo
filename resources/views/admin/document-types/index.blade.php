@extends('layouts.admin')

@section('page-title', 'Layanan Publik')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900 dark:text-white">Jenis Surat</h1>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Kelola master data jenis dokumen dan surat</p>
        </div>
        <a href="{{ route('admin.document-types.create') }}" class="flex items-center gap-2 rounded-lg bg-cyan-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-cyan-700 dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400">
            <span>+</span> Tambah Jenis
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg border border-emerald-500/30 bg-emerald-50 p-4 dark:bg-emerald-500/10">
            <p class="text-sm text-emerald-600 dark:text-emerald-400">{{ session('success') }}</p>
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-slate-900/50 dark:shadow-xl dark:backdrop-blur-sm">
        @forelse ($documentTypes as $documentType)
            <div class="flex items-center justify-between border-b border-slate-200 p-5 last:border-b-0 hover:bg-slate-50 transition dark:border-white/10 dark:hover:bg-white/5">
                <div class="flex items-start gap-4">
                    <div class="mt-1 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-slate-100 text-slate-500 dark:border-white/10 dark:bg-slate-800 dark:text-slate-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M7 8h10M7 12h10M7 16h6M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/></svg>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $documentType->name }}</p>
                        <div class="mt-1 flex flex-wrap items-center gap-3 text-xs text-slate-500 dark:text-slate-400">
                            <span class="font-mono text-cyan-600 dark:text-cyan-400">Kode: {{ $documentType->code }}</span>
                            @if($documentType->description)
                                <span class="h-1 w-1 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                                <span class="max-w-md truncate">{{ $documentType->description }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3 text-sm font-medium">
                    <a class="text-cyan-600 transition hover:text-cyan-700 dark:text-cyan-400 dark:hover:text-cyan-300" href="{{ route('admin.document-types.edit', $documentType) }}">Edit</a>
                    <form method="POST" action="{{ route('admin.document-types.destroy', $documentType) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jenis surat ini? Ini mungkin berdampak pada permohonan terkait.');">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-rose-600 transition hover:text-rose-700 dark:text-rose-400 dark:hover:text-rose-300">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="p-8 text-center text-slate-500 dark:text-slate-400">Belum ada jenis surat yang ditambahkan.</div>
        @endforelse
    </div>
@endsection
