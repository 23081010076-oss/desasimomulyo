@extends('layouts.admin')

@section('content')
    <h1 class="mb-6 text-2xl font-semibold text-white">Form Permohonan Surat</h1>
    <form method="POST" action="{{ $documentRequest->exists ? route('admin.document-requests.update', $documentRequest) : route('admin.document-requests.store') }}" class="grid max-w-2xl gap-4 rounded-2xl border border-white/10 bg-white/5 p-6">
        @csrf
        @if ($documentRequest->exists)
            @method('PUT')
        @endif
        <input name="request_number" value="{{ old('request_number', $documentRequest->request_number) }}" placeholder="Nomor permohonan" class="rounded-lg border border-white/10 bg-slate-950/80 p-3 text-white">
        <input name="user_id" value="{{ old('user_id', $documentRequest->user_id) }}" placeholder="User ID" class="rounded-lg border border-white/10 bg-slate-950/80 p-3 text-white">
        <select name="document_type_id" class="rounded-lg border border-white/10 bg-slate-950/80 p-3 text-white">
            @foreach ($documentTypes as $documentType)
                <option value="{{ $documentType->id }}">{{ $documentType->name }}</option>
            @endforeach
        </select>
        <textarea name="payload" placeholder="JSON payload" class="rounded-lg border border-white/10 bg-slate-950/80 p-3 text-white">{{ old('payload', is_array($documentRequest->payload) ? json_encode($documentRequest->payload) : $documentRequest->payload) }}</textarea>
        <button class="rounded-lg bg-cyan-500 px-4 py-2 font-medium text-slate-950">Simpan</button>
    </form>
@endsection
