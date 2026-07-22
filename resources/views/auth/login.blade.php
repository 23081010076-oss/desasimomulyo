@extends('layouts.auth')

@section('content')
<div class="w-full max-w-md rounded-3xl border border-slate-200 bg-white/80 p-8 shadow-xl backdrop-blur transition-colors dark:border-white/10 dark:bg-white/5 dark:shadow-2xl">
    <div class="flex items-center gap-3">
        <img src="{{ asset('images/surabaya-logo.svg') }}" alt="Logo Surabaya" class="h-10 w-auto">
        <div>
            <p class="text-sm uppercase tracking-[0.3em] text-cyan-600 dark:text-cyan-300/80">Masuk Sistem</p>
            <h1 class="mt-1 text-3xl font-semibold text-slate-900 dark:text-white">Login</h1>
        </div>
    </div>

    <form method="POST" action="{{ route('login.store') }}" class="mt-8 grid gap-4">
        @csrf
        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="rounded-xl border border-slate-200 bg-slate-50 p-3 text-slate-900 outline-none transition focus:border-cyan-500 dark:border-white/10 dark:bg-slate-950/80 dark:text-white dark:focus:border-cyan-400">
        <input type="password" name="password" placeholder="Password" class="rounded-xl border border-slate-200 bg-slate-50 p-3 text-slate-900 outline-none transition focus:border-cyan-500 dark:border-white/10 dark:bg-slate-950/80 dark:text-white dark:focus:border-cyan-400">
        <label class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-300">
            <input type="checkbox" name="remember" class="rounded border-slate-300 bg-white dark:border-white/20 dark:bg-slate-900">
            Remember me
        </label>
        <button class="mt-2 rounded-xl bg-cyan-600 px-4 py-3 font-medium text-white transition hover:bg-cyan-700 dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400">Masuk</button>
    </form>
</div>
@endsection
