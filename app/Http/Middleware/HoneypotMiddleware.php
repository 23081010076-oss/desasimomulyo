<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class HoneypotMiddleware
{
    /**
     * Field tersembunyi yang harus KOSONG.
     * Jika bot mengisi field ini (karena bot membaca semua input),
     * maka request langsung dianggap spam dan dibuang diam-diam.
     */
    private const HONEYPOT_FIELD = 'website_url';

    public function handle(Request $request, Closure $next): Response
    {
        // Jika field honeypot terisi → ini bot, bukan manusia
        if ($request->filled(self::HONEYPOT_FIELD)) {
            Log::warning('[SECURITY] Honeypot triggered — bot detected', [
                'ip'    => $request->ip(),
                'url'   => $request->fullUrl(),
                'agent' => $request->userAgent(),
            ]);

            // Redirect diam-diam ke halaman yang sama tanpa pesan error
            // Bot mengira request berhasil, padahal tidak ada yang disimpan
            return redirect()->back()->with('success', 'Pesan Anda telah terkirim.');
        }

        return $next($request);
    }
}
