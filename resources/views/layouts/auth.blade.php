<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100 transition-colors duration-300">
    <div class="absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute left-[-10%] top-[-10%] h-72 w-72 rounded-full bg-emerald-500/10 blur-3xl dark:bg-emerald-500/20"></div>
        <div class="absolute right-[-5%] top-[20%] h-80 w-80 rounded-full bg-cyan-500/10 blur-3xl dark:bg-cyan-500/20"></div>
    </div>

    <main class="mx-auto flex min-h-screen max-w-7xl items-center justify-center px-4 py-10">
        @yield('content')
    </main>
</body>
</html>
