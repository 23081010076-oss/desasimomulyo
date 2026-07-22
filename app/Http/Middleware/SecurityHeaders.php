<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Cegah Clickjacking: halaman tidak boleh di-embed dalam iframe
        $response->headers->set('X-Frame-Options', 'DENY');

        // Cegah MIME sniffing: browser wajib ikuti Content-Type yang dideklarasikan
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Aktifkan proteksi XSS bawaan browser lama
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Batasi informasi referrer yang dikirim ke situs lain
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Nonaktifkan fitur browser berbahaya yang tidak dibutuhkan
        $response->headers->set(
            'Permissions-Policy',
            'camera=(), microphone=(), geolocation=(), payment=(), usb=()'
        );

        // Paksa koneksi HTTPS (aktifkan di production)
        // $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');

        // Content Security Policy (CSP) — whitelist sumber konten (nonaktif di local agar Vite dev server berjalan lancar)
        if (!app()->environment('local')) {
            $csp = implode('; ', [
                "default-src 'self'",
                "script-src 'self' 'unsafe-inline' https://unpkg.com https://fonts.googleapis.com",
                "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://unpkg.com",
                "font-src 'self' https://fonts.gstatic.com",
                "img-src 'self' data: https: blob:",
                "connect-src 'self'",
                "frame-src 'none'",
                "object-src 'none'",
                "base-uri 'self'",
                "form-action 'self' https://wa.me",
            ]);
            $response->headers->set('Content-Security-Policy', $csp);
        }

        // Hapus header yang membocorkan informasi server
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        return $response;
    }
}
