<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if ($guard == 'user' && Auth::guard('user')->check() && Auth::user()->role()->type == 'global' &&  Auth::user()->role()->slug == 'super-admin') {
            return redirect()->intended(route('dashboard'));
        } elseif ($guard == 'user' && Auth::guard('user')->check() && Auth::user()->role()->type == 'vendor' &&  Auth::user()->role()->slug == 'vendor-admin') {
            return redirect()->intended(route('vendor-dashboard'));
        }

        return $next($request);
    }
}
