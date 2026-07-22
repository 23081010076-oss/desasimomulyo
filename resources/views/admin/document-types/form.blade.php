@extends('layouts.admin')

@section('content')
    <h1 class="mb-6 text-2xl font-semibold text-white">Form Tipe Surat</h1>
    <form method="POST" action="{{ $documentType->exists ? route('admin.document-types.update', $documentType) : route('admin.document-types.store') }}" class="grid max-w-2xl gap-4 rounded-2xl border border-white/10 bg-white/5 p-6">
        @csrf
        @if ($documentType->exists)
            @method('PUT')
        @endif
        <input name="name" value="{{ old('name', $documentType->name) }}" placeholder="Nama" class="rounded-lg border border-white/10 bg-slate-950/80 p-3 text-white">
        <input name="code" value="{{ old('code', $documentType->code) }}" placeholder="Kode" class="rounded-lg border border-white/10 bg-slate-950/80 p-3 text-white">
        <textarea name="description" placeholder="Deskripsi" class="rounded-lg border border-white/10 bg-slate-950/80 p-3 text-white">{{ old('description', $documentType->description) }}</textarea>
        <button class="rounded-lg bg-cyan-500 px-4 py-2 font-medium text-slate-950">Simpan</button>
    </form>
@endsection
