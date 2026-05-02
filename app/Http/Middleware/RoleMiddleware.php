<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Jika belum login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Jika role tidak sesuai
        if (Auth::user()->role != $role) {
            abort(403, 'Akses ditolak!');
        }

        return $next($request);
    }
}