<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // 1. Pastikan user sudah login
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // 2. Cek apakah role user ada dalam parameter middleware (admin/reseller)
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // 3. Jika tidak punya akses, arahkan sesuai role yang dimiliki
        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        } elseif ($user->role === 'reseller') {
            return redirect('/reseller/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        // 4. Default jika role tidak dikenal atau kosong
        return redirect('/')->with('error', 'Akses ditolak.');
    }
}