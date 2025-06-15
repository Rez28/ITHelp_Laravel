<?php

namespace App\Http\Middleware;

use Closure;

class RestrictAdminLoginByIp
{
    public function handle($request, Closure $next)
    {
        // Ganti dengan IP komputer admin/server Anda
        $allowedIps = ['192.168.1.2', '127.0.0.1'];
        if (!in_array($request->ip(), $allowedIps)) {
            abort(403, 'Akses ke halaman admin hanya dari komputer tertentu.');
        }
        return $next($request);
    }
}
