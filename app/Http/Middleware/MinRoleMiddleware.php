<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware untuk memproteksi route berdasarkan level minimum role.
 *
 * Penggunaan di routes:
 *   ->middleware('role.min:admin_kecamatan')  // admin_kecamatan, admin_kabupaten, super_admin
 *   ->middleware('role.min:admin_kabupaten')  // admin_kabupaten, super_admin
 *   ->middleware('role.min:super_admin')      // super_admin saja
 */
class MinRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): Response  $next
     * @param  string  $minimumRole  Role minimum yang diperlukan
     */
    public function handle(Request $request, Closure $next, string $minimumRole): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        try {
            $minEnum = UserRole::from($minimumRole);
        } catch (\ValueError) {
            abort(500, "Role '{$minimumRole}' tidak valid.");
        }

        if (! $request->user()->hasMinRole($minEnum)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
