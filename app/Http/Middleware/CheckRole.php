<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!session('is_authenticated')) {
            return redirect('/login');
        }

        $userRole = session('role');

        if (!in_array($userRole, $roles)) {
            return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        return $next($request);
    }
}
