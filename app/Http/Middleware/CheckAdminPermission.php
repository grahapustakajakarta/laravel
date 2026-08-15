<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $module): Response
    {
        $user = auth()->user();

        // Jika belum login atau bukan admin/superadmin, tolak
        if (!$user || !in_array($user->role, ['superadmin', 'admin'])) {
            return redirect()->route('admin.login')->with('error', 'Akses ditolak.');
        }

        // Cek izin modul spesifik
        if (!$user->hasPermission($module)) {
            return redirect()->route('admin.dashboard')->with('error', "Akses Ditolak: Anda tidak memiliki izin untuk mengelola modul '{$module}'.");
        }

        return $next($request);
    }
}
