<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('is_authenticated')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        return $next($request);
    }
}
