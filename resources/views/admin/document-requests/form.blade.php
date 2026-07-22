@extends('layouts.admin')

@section('content')
    <h1 class="mb-6 text-2xl font-semibold text-white">Form Permohonan Surat</h1>
    <form method="POST" action="{{ $documentRequest->exists ? route('admin.document-requests.update', $documentRequest) : route('admin.document-requests.store') }}" class="grid max-w-2xl gap-4 rounded-2xl border border-white/10 bg-white/5 p-6">
        @csrf
        @if ($documentRequest->exists)
            @method('PUT')
        @endif
        <input name="request_number" value="{{ old('request_number', $documentRequest->request_number) }}" placeholder="Nomor permohonan (Otomatis)" class="rounded-lg border border-white/10 bg-slate-950/80 p-3 text-white" readonly>
        <input name="tracking_code" value="{{ old('tracking_code', $documentRequest->tracking_code) }}" placeholder="Kode Pelacakan" class="rounded-lg border border-white/10 bg-slate-950/80 p-3 text-white">
        
        <select name="document_type_id" class="rounded-lg border border-white/10 bg-slate-950/80 p-3 text-white">
            <option value="">Pilih Jenis Surat</option>
            @foreach ($documentTypes as $documentType)
                <option value="{{ $documentType->id }}" @selected(old('document_type_id', $documentRequest->document_type_id) == $documentType->id)>{{ $documentType->name }}</option>
            @endforeach
        </select>
        
        <div class="grid gap-4 sm:grid-cols-2">
            <input name="applicant_name" value="{{ old('applicant_name', $documentRequest->applicant_name) }}" placeholder="Nama Pemohon" class="rounded-lg border border-white/10 bg-slate-950/80 p-3 text-white">
            <input name="applicant_nik" value="{{ old('applicant_nik', $documentRequest->applicant_nik) }}" placeholder="NIK Pemohon" class="rounded-lg border border-white/10 bg-slate-950/80 p-3 text-white">
        </div>
        
        <input name="applicant_phone" value="{{ old('applicant_phone', $documentRequest->applicant_phone) }}" placeholder="Nomor Telepon/WA" class="rounded-lg border border-white/10 bg-slate-950/80 p-3 text-white">
        <textarea name="purpose" placeholder="Keperluan Surat" class="rounded-lg border border-white/10 bg-slate-950/80 p-3 text-white">{{ old('purpose', $documentRequest->purpose) }}</textarea>

        <select name="status" class="rounded-lg border border-white/10 bg-slate-950/80 p-3 text-white">
            @foreach(\App\Enums\DocumentRequestStatus::cases() as $status)
                <option value="{{ $status->value }}" @selected(old('status', $documentRequest->status?->value) === $status->value)>
                    Status: {{ $status->value }}
                </option>
            @endforeach
        </select>

        @if($documentRequest->exists)
            <div class="mt-4 flex gap-4">
                <label class="flex items-center gap-2 text-sm text-slate-300">
                    <input type="checkbox" name="mark_completed" value="1" class="rounded border-white/10 bg-slate-900 text-cyan-500">
                    Tandai Selesai (Set completed_at ke waktu sekarang)
                </label>
            </div>
        @endif
        <button class="rounded-lg bg-cyan-500 px-4 py-2 font-medium text-slate-950">Simpan</button>
    </form>
@endsection
