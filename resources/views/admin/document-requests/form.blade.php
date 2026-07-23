@extends('layouts.admin')

@section('page-title', 'Layanan Publik')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-900 dark:text-white">Tinjau Permohonan Surat</h1>
        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Tinjau detail dan perbarui status permohonan surat warga</p>
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

    <form method="POST" action="{{ $documentRequest->exists ? route('admin.document-requests.update', $documentRequest) : route('admin.document-requests.store') }}" class="grid max-w-4xl gap-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-slate-900/50 dark:shadow-xl dark:backdrop-blur-sm">
        @csrf
        @if ($documentRequest->exists)
            @method('PUT')
        @endif
        
        <div class="grid gap-6 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Nomor Permohonan</label>
                <input name="request_number" value="{{ old('request_number', $documentRequest->request_number) }}" placeholder="Otomatis terisi" class="w-full rounded-lg border border-slate-200 bg-slate-100 p-3 text-slate-500 dark:border-white/10 dark:bg-slate-900/80 dark:text-slate-400" readonly>
            </div>
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Kode Pelacakan (Tracking Code)</label>
                <input name="tracking_code" value="{{ old('tracking_code', $documentRequest->tracking_code) }}" placeholder="Kode unik" class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white font-mono">
            </div>
        </div>
        
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Jenis Surat</label>
            <select name="document_type_id" class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">
                <option value="">Pilih Jenis Surat</option>
                @foreach ($documentTypes as $documentType)
                    <option value="{{ $documentType->id }}" @selected(old('document_type_id', $documentRequest->document_type_id) == $documentType->id)>{{ $documentType->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="border-t border-slate-200 pt-6 dark:border-white/10">
            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Data Pemohon</h3>
            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Nama Lengkap</label>
                    <input name="applicant_name" value="{{ old('applicant_name', $documentRequest->applicant_name) }}" placeholder="Nama Pemohon" class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">NIK (Nomor Induk Kependudukan)</label>
                    <input name="applicant_nik" value="{{ old('applicant_nik', $documentRequest->applicant_nik) }}" placeholder="NIK Pemohon" class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">
                </div>
                <div class="sm:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Nomor Telepon / WhatsApp</label>
                    <input name="applicant_phone" value="{{ old('applicant_phone', $documentRequest->applicant_phone) }}" placeholder="Contoh: 08123456789" class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">
                </div>
                <div class="sm:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Keperluan Surat</label>
                    <textarea name="purpose" rows="3" placeholder="Jelaskan tujuan permohonan surat ini..." class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white">{{ old('purpose', $documentRequest->purpose) }}</textarea>
                </div>
            </div>
        </div>

        <div class="border-t border-slate-200 pt-6 dark:border-white/10">
            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Penyelesaian</h3>
            
            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Status Permohonan</label>
                    <select name="status" class="w-full rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-900 transition focus:border-cyan-500/50 focus:outline-none focus:ring-1 focus:ring-cyan-500/50 dark:border-white/10 dark:bg-slate-950/80 dark:text-white font-medium">
                        @foreach(\App\Enums\DocumentRequestStatus::cases() as $status)
                            <option value="{{ $status->value }}" @selected(old('status', $documentRequest->status?->value) === $status->value)>
                                {{ $status->value }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if($documentRequest->exists)
                <div class="mt-4 rounded-xl border border-cyan-500/20 bg-cyan-50/50 p-4 dark:border-cyan-500/20 dark:bg-cyan-500/5">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <div class="flex h-5 items-center">
                            <input type="checkbox" name="mark_completed" value="1" class="h-4 w-4 rounded border-slate-300 text-cyan-600 focus:ring-cyan-600 dark:border-white/20 dark:bg-slate-900 dark:checked:bg-cyan-500">
                        </div>
                        <div>
                            <span class="text-sm font-medium text-slate-900 dark:text-white">Tandai Selesai & Dokumen Siap</span>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Ini akan mencatat waktu penyelesaian (completed_at) menjadi sekarang secara otomatis.</p>
                        </div>
                    </label>
                </div>
            @endif
        </div>

        <div class="mt-4 flex gap-3">
            <button type="submit" class="rounded-lg bg-cyan-600 px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-cyan-700 dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400">Simpan Perubahan</button>
            <a href="{{ route('admin.document-requests.index') }}" class="rounded-lg border border-slate-200 bg-transparent px-6 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-white/10 dark:text-slate-300 dark:hover:bg-white/5">Kembali</a>
        </div>
    </form>
@endsection
