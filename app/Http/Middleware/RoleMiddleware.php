<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // 2. Ambil nama role dari user saat ini
        // Method getRoleName() harus ada di Model User (sudah ada di file yang Anda upload)
        $userRole = $user->getRoleName(); 

        // 3. Cek apakah role user ada di daftar yang diizinkan
        // Contoh penggunaan di route: 'role:Admin,Guru' -> $roles = ['Admin', 'Guru']
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // 4. Jika tidak punya akses, lempar error 403 (Forbidden)
        abort(403, 'Akses Ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
    }
}