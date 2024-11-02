<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class IsLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userId  = ! empty(Auth::guard('user')->user()) ? Auth::guard('user')->user()->id : null;
        $adminId  = ! empty(Auth::guard('admin')->user()) ? Auth::guard('admin')->user()->id : null;

        if (! $userId && ! $adminId) {
            return redirect('/');
        }

        return $next($request);
    }
}
