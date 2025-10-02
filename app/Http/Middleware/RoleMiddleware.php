<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $role = Auth::user()->role;

        // Cek role dan arahkan ke route yang sesuai
        switch ($role) {
            case 'super_admin':
            return redirect()->route('superadmin');
            case 'admin':
            return redirect()->route('admin');
            case 'operator':
            return redirect()->route('operator');
            case 'user':
            return $next($request);
            default:
            // Jika role tidak dikenali, bisa diarahkan ke halaman error atau login
            abort(403, 'Unauthorized action.');
        }
    }
}
