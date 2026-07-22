@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-white">Permohonan Surat</h1>
        <a href="{{ route('admin.document-requests.create') }}" class="rounded-lg bg-cyan-500 px-4 py-2 text-sm font-medium text-slate-950">Tambah</a>
    </div>
    <div class="overflow-hidden rounded-2xl border border-white/10 bg-white/5">
        @foreach ($requests as $requestItem)
            <div class="flex items-center justify-between border-b border-white/10 p-4">
                <div>
                    <p class="font-medium text-white">{{ $requestItem->request_number }}</p>
                    <p class="text-sm text-slate-400">{{ $requestItem->status->value ?? $requestItem->status }}</p>
                </div>
                <div class="flex gap-3 text-sm">
                    <a class="text-cyan-300" href="{{ route('admin.document-requests.edit', $requestItem) }}">Edit</a>
                    <form method="POST" action="{{ route('admin.document-requests.destroy', $requestItem) }}">@csrf @method('DELETE')<button class="text-rose-300">Hapus</button></form>
                </div>
            </div>
        @endforeach
    </div>
@endsection
