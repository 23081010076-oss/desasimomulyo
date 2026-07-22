@extends('layouts.site')

@section('content')
<section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
    <div class="max-w-2xl">
        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-600 dark:text-emerald-400">Layanan Warga</p>
        <h1 class="mt-3 text-4xl font-semibold leading-tight text-slate-900 dark:text-white sm:text-5xl">Surat & Dokumen</h1>
        <p class="mt-4 text-base leading-8 text-slate-600 dark:text-slate-400">
            Ajukan permohonan surat pengantar, keterangan, atau dokumen lainnya langsung dari rumah. Anda akan mendapatkan kode pelacakan untuk memantau status permohonan.
        </p>
    </div>

    @if(session('success'))
        <div class="mt-8 rounded border border-emerald-200 bg-emerald-50 p-4 dark:border-emerald-500/20 dark:bg-emerald-500/10">
            <div class="flex gap-3">
                <svg class="h-5 w-5 shrink-0 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm font-medium text-emerald-800 dark:text-emerald-200">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="mt-12 grid gap-12 lg:grid-cols-2">
        {{-- ── Form Permohonan ── --}}
        <div>
            <div class="mb-6 flex items-center justify-between border-b border-slate-200 pb-4 dark:border-white/10">
                <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Form Pengajuan Baru</h2>
            </div>
            
            <form method="POST" action="{{ route('documents.store') }}" class="space-y-5">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Jenis Surat</label>
                    <select name="document_type_id" required class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 dark:border-white/10 dark:bg-slate-900 dark:text-white">
                        <option value="">Pilih Jenis Surat...</option>
                        @foreach($documentTypes as $type)
                            <option value="{{ $type->id }}" {{ old('document_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                        @endforeach
                    </select>
                    @error('document_type_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Nama Lengkap</label>
                        <input type="text" name="applicant_name" value="{{ old('applicant_name') }}" required class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 dark:border-white/10 dark:bg-slate-900 dark:text-white">
                        @error('applicant_name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">NIK (16 Digit)</label>
                        <input type="text" name="applicant_nik" value="{{ old('applicant_nik') }}" required minlength="16" maxlength="16" class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 dark:border-white/10 dark:bg-slate-900 dark:text-white">
                        @error('applicant_nik') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Nomor Telepon / WhatsApp</label>
                    <input type="text" name="applicant_phone" value="{{ old('applicant_phone') }}" required class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 dark:border-white/10 dark:bg-slate-900 dark:text-white">
                    @error('applicant_phone') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Keperluan (Tujuan Pembuatan Surat)</label>
                    <textarea name="purpose" rows="3" required class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 dark:border-white/10 dark:bg-slate-900 dark:text-white">{{ old('purpose') }}</textarea>
                    @error('purpose') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full rounded-md bg-emerald-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-emerald-700 dark:bg-emerald-500 dark:hover:bg-emerald-400">
                        Ajukan Permohonan
                    </button>
                </div>
            </form>
        </div>

        {{-- ── Lacak Status ── --}}
        <div>
            <div class="mb-6 flex items-center justify-between border-b border-slate-200 pb-4 dark:border-white/10">
                <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Lacak Status Surat</h2>
            </div>
            
            <form method="GET" action="{{ route('documents') }}" class="mb-8 flex gap-3">
                <input type="text" name="track" value="{{ $track }}" placeholder="Masukkan Kode Pelacakan (Contoh: X7Y8Z9)" required class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 dark:border-white/10 dark:bg-slate-900 dark:text-white">
                <button type="submit" class="shrink-0 rounded-md bg-slate-900 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-200">
                    Cari
                </button>
            </form>

            @if($track)
                <div class="rounded-lg border border-slate-200 bg-slate-50 p-6 dark:border-white/10 dark:bg-white/5">
                    @if($trackedRequest)
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-semibold text-slate-900 dark:text-white">Hasil Pencarian</h3>
                            @php
                                $statusColors = [
                                    'DRAFT' => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300',
                                    'VERIFYING' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400',
                                    'SIGNED' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400',
                                    'COMPLETED' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400',
                                ];
                                $statusColor = $statusColors[$trackedRequest->status->value] ?? $statusColors['DRAFT'];
                            @endphp
                            <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusColor }}">
                                {{ $trackedRequest->status->value }}
                            </span>
                        </div>
                        
                        <dl class="space-y-3 text-sm">
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <dt class="text-slate-500">Nomor Registrasi</dt>
                                <dd class="font-medium text-slate-900 dark:text-white">{{ $trackedRequest->request_number }}</dd>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <dt class="text-slate-500">Jenis Surat</dt>
                                <dd class="font-medium text-slate-900 dark:text-white">{{ $trackedRequest->documentType->name }}</dd>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <dt class="text-slate-500">Pemohon</dt>
                                <dd class="font-medium text-slate-900 dark:text-white">{{ $trackedRequest->applicant_name }}</dd>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <dt class="text-slate-500">Tanggal Pengajuan</dt>
                                <dd class="font-medium text-slate-900 dark:text-white">{{ $trackedRequest->created_at->format('d M Y, H:i') }}</dd>
                            </div>
                            @if($trackedRequest->completed_at)
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <dt class="text-slate-500">Selesai Diproses</dt>
                                <dd class="font-medium text-emerald-600 dark:text-emerald-400">{{ $trackedRequest->completed_at->format('d M Y, H:i') }}</dd>
                            </div>
                            @endif
                        </dl>
                        
                        @if($trackedRequest->status->value === 'COMPLETED')
                            <div class="mt-5 rounded bg-emerald-50 p-4 dark:bg-emerald-500/10">
                                <p class="text-sm text-emerald-800 dark:text-emerald-300">Surat Anda telah selesai diproses. Silakan ambil di Kantor Kelurahan dengan membawa KTP asli.</p>
                            </div>
                        @elseif($trackedRequest->status->value === 'DRAFT' || $trackedRequest->status->value === 'VERIFYING')
                            <div class="mt-5 rounded bg-amber-50 p-4 dark:bg-amber-500/10">
                                <p class="text-sm text-amber-800 dark:text-amber-300">Permohonan sedang dalam antrean verifikasi petugas kelurahan.</p>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-6">
                            <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-slate-900 dark:text-white">Tidak Ditemukan</h3>
                            <p class="mt-1 text-sm text-slate-500">Kode pelacakan <strong>{{ $track }}</strong> tidak valid atau permohonan tidak ditemukan.</p>
                        </div>
                    @endif
                </div>
            @else
                <div class="rounded-lg border border-slate-200 bg-slate-50 p-6 text-center dark:border-white/10 dark:bg-white/5">
                    <svg class="mx-auto h-10 w-10 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                    </svg>
                    <p class="mt-3 text-sm text-slate-500">Masukkan kode pelacakan untuk memantau proses penyelesaian dokumen Anda.</p>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
