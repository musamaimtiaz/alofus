<?php

namespace Infoamin\Installer\Http\Middleware;

use Closure;

class CheckInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $isAppInstalled = config('installer.verify.installed');

        if (! $isAppInstalled) {
            return $next($request);
        }

        if (
            $isAppInstalled
            && request()->is('install/verify-envato-purchase-code*')
            && request()->bypass == 'purchase_code'
        ) {
            return $next($request);
        }

        return redirect(url('/'));
    }
}
