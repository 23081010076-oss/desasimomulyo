<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogSuspiciousActivity
{
    // Pola yang sering digunakan dalam SQL Injection & XSS
    private const SUSPICIOUS_PATTERNS = [
        '/(\bUNION\b|\bSELECT\b|\bINSERT\b|\bDROP\b|\bDELETE\b|\bUPDATE\b|\bEXEC\b)/i',
        '/(<script|javascript:|vbscript:|on\w+\s*=)/i',
        '/(\.\.\/|\.\.\\\\)/',       // Path traversal
        '/(%00|%0d%0a|%0a%0d)/i',    // Null byte & CRLF injection
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $this->inspectRequest($request);

        return $next($request);
    }

    private function inspectRequest(Request $request): void
    {
        $inputs = $request->except(['password', 'password_confirmation', '_token']);
        $inputString = json_encode($inputs);

        foreach (self::SUSPICIOUS_PATTERNS as $pattern) {
            if (preg_match($pattern, $inputString) || preg_match($pattern, $request->getRequestUri())) {
                Log::warning('[SECURITY] Suspicious request detected', [
                    'ip'      => $request->ip(),
                    'method'  => $request->method(),
                    'url'     => $request->fullUrl(),
                    'agent'   => $request->userAgent(),
                    'pattern' => $pattern,
                    'inputs'  => $inputs,
                ]);
                break;
            }
        }
    }
}
