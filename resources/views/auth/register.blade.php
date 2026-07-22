@extends('layouts.auth')

@section('content')
<div class="w-full max-w-md rounded-3xl border border-white/10 bg-white/5 p-8 shadow-2xl backdrop-blur">
    <p class="text-sm uppercase tracking-[0.3em] text-cyan-300/80">Buat Akun</p>
    <h1 class="mt-2 text-3xl font-semibold text-white">Register</h1>

    <form method="POST" action="{{ route('register.store') }}" class="mt-8 grid gap-4">
        @csrf
        <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama" class="rounded-xl border border-white/10 bg-slate-950/80 p-3 text-white outline-none focus:border-cyan-400">
        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="rounded-xl border border-white/10 bg-slate-950/80 p-3 text-white outline-none focus:border-cyan-400">
        <input type="password" name="password" placeholder="Password" class="rounded-xl border border-white/10 bg-slate-950/80 p-3 text-white outline-none focus:border-cyan-400">
        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" class="rounded-xl border border-white/10 bg-slate-950/80 p-3 text-white outline-none focus:border-cyan-400">
        <button class="rounded-xl bg-cyan-500 px-4 py-3 font-medium text-slate-950">Daftar</button>
    </form>

    <p class="mt-6 text-sm text-slate-400">Sudah punya akun? <a href="{{ route('login') }}" class="text-cyan-300">Login</a></p>
</div>
@endsection
