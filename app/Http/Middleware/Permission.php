<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Millat <[millat.techvill@gmail.com]>
 *
 * @created 28-08-2021
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Permission
{
    public function handle($request, Closure $next)
    {
        if (session('impersonator') && $request->segment(2) != 'impersonate' && $request->segment(1) == 'admin') {
            Auth::onceUsingId(session('impersonator'));
        }
        if (! hasPermission()) {
            abort(403, __('Unauthorized! Go home, grow up and get authorization'));
        }

        return $next($request);
    }
}
