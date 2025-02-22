<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Google2FAMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('2fa_verified')) {
            return redirect()->route('2fa.setup');
        }

        return $next($request);
    }
}

