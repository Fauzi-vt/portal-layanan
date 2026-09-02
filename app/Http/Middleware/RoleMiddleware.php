<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware untuk memproteksi route berdasarkan role.
 *
 * Penggunaan di routes:
 *   ->middleware('role:super_admin')
 *   ->middleware('role:admin_kabupaten,super_admin')   // salah satu boleh
 *   ->middleware('role.min:admin_kecamatan')           // minimal role ini ke atas
 */
class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): Response  $next
     * @param  string  ...$roles  Role yang diizinkan (bisa lebih dari satu, dipisah koma)
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Pastikan user sudah login
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $user = $request->user();

        // Cek apakah user memiliki salah satu dari role yang diberikan
        foreach ($roles as $role) {
            try {
                $enumRole = UserRole::from($role);
                if ($user->role === $enumRole) {
                    return $next($request);
                }
            } catch (\ValueError) {
                // Role tidak valid — abaikan
            }
        }

        // Role tidak cocok → 403
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}
