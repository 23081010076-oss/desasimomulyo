<?php

use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\LogSuspiciousActivity;
use App\Http\Middleware\SecurityHeaders;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // ─── Global Security Headers ───────────────────────────────────────
        $middleware->append(SecurityHeaders::class);

        // ─── Log request mencurigakan (SQLi, XSS, path traversal) ─────────
        $middleware->append(LogSuspiciousActivity::class);

        // ─── Alias Middleware ──────────────────────────────────────────────
        $middleware->alias([
            'admin'     => EnsureAdmin::class,
            'honeypot'  => \App\Http\Middleware\HoneypotMiddleware::class,
        ]);

        $middleware->redirectUsersTo('/admin/dashboard');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->booted(function () {
        // ─── Rate Limiters ─────────────────────────────────────────────────

        // Login: maks 5 percobaan per menit per IP+email
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)
                ->by($request->input('email') . '|' . $request->ip())
                ->response(function () {
                    return redirect()->back()->withErrors([
                        'email' => 'Terlalu banyak percobaan login. Silakan coba lagi dalam 1 menit.',
                    ]);
                });
        });

        // Register: maks 3 akun per jam per IP
        RateLimiter::for('register', function (Request $request) {
            return Limit::perHour(3)
                ->by($request->ip())
                ->response(function () {
                    return redirect()->back()->withErrors([
                        'email' => 'Terlalu banyak pendaftaran dari IP ini. Coba lagi nanti.',
                    ]);
                });
        });

        // Hotline: maks 3 pengiriman per menit per IP
        RateLimiter::for('hotline', function (Request $request) {
            return Limit::perMinute(3)
                ->by($request->ip())
                ->response(function () {
                    return redirect()->back()->withErrors([
                        'message' => 'Terlalu banyak pengiriman laporan. Silakan tunggu sebentar.',
                    ]);
                });
        });
    })
    ->create();
