<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (! auth()->check() && preference('guest_order') == 'disable' && ! isset(auth()->guard('api')->user()->id)) {
            if ($request->ajax() || $request->wantsJson() || request()->route()->getPrefix() == 'api/user') {
                return response()->json([
                    'status' => 'info',
                    'message' => __('Invalid User! This action can\'t be perform.'),
                ]);
            }

            return redirect()->route('site.login');
        }

        return $next($request);
    }
}
