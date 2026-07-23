@extends('layouts.admin')

@section('page-title', 'Layanan Publik')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900 dark:text-white">Permohonan Surat</h1>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Daftar permohonan surat dari warga</p>
        </div>
        <a href="{{ route('admin.document-requests.create') }}" class="flex items-center gap-2 rounded-lg bg-cyan-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-cyan-700 dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400">
            <span>+</span> Tambah Permohonan
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg border border-emerald-500/30 bg-emerald-50 p-4 dark:bg-emerald-500/10">
            <p class="text-sm text-emerald-600 dark:text-emerald-400">{{ session('success') }}</p>
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-slate-900/50 dark:shadow-xl dark:backdrop-blur-sm">
        @forelse ($requests as $requestItem)
            <div class="flex items-center justify-between border-b border-slate-200 p-5 last:border-b-0 hover:bg-slate-50 transition dark:border-white/10 dark:hover:bg-white/5">
                <div class="flex items-start gap-4">
                    <div class="mt-1 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-slate-100 text-slate-500 dark:border-white/10 dark:bg-slate-800 dark:text-slate-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9 12h6M9 16h6M14 3H6a2 2 0 00-2 2v14a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 3v5h5"/></svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <p class="font-semibold text-slate-900 dark:text-white">{{ $requestItem->request_number }}</p>
                            <span class="text-xs text-slate-400">({{ $requestItem->documentType->name }})</span>
                        </div>
                        <p class="mt-1 text-sm text-slate-600 dark:text-slate-300">Pemohon: <span class="font-medium">{{ $requestItem->applicant_name ?? 'Tanpa Nama' }}</span></p>
                        
                        <div class="mt-2 flex flex-wrap items-center gap-3 text-xs text-slate-500 dark:text-slate-400">
                            @php
                                $statusVal = $requestItem->status->value ?? $requestItem->status;
                                $statusColors = [
                                    'DRAFT' => 'border-slate-200 bg-slate-50 text-slate-600 dark:border-white/10 dark:bg-white/5 dark:text-slate-400',
                                    'VERIFYING' => 'border-amber-500/30 bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400',
                                    'SIGNED' => 'border-blue-500/30 bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400',
                                    'COMPLETED' => 'border-emerald-500/30 bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400',
                                ];
                                $statusClass = $statusColors[$statusVal] ?? $statusColors['DRAFT'];
                            @endphp
                            <span class="inline-flex rounded-full border {{ $statusClass }} px-2.5 py-0.5 font-medium">{{ $statusVal }}</span>
                            <span class="h-1 w-1 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                            <span>{{ $requestItem->created_at->format('d M Y, H:i') }}</span>
                            @if($requestItem->tracking_code)
                                <span class="h-1 w-1 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                                <span>Track: <span class="font-mono text-cyan-600 dark:text-cyan-400">{{ $requestItem->tracking_code }}</span></span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3 text-sm font-medium">
                    <a class="text-cyan-600 transition hover:text-cyan-700 dark:text-cyan-400 dark:hover:text-cyan-300" href="{{ route('admin.document-requests.edit', $requestItem) }}">Tinjau</a>
                    <form method="POST" action="{{ route('admin.document-requests.destroy', $requestItem) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus permohonan ini?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-rose-600 transition hover:text-rose-700 dark:text-rose-400 dark:hover:text-rose-300">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="p-8 text-center text-slate-500 dark:text-slate-400">Belum ada permohonan surat masuk.</div>
        @endforelse
    </div>

    @if(method_exists($requests, 'hasPages') && $requests->hasPages())
        <div class="mt-6">
            {{ $requests->links() }}
        </div>
    @endif
@endsection
