<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sabbir Al-Razi <[sabbir.techvill@gmail.com]>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 24-03-2021
 * modified 25-01-2022
 */

namespace App\Http\Middleware\Api;

use Closure;

/**
 * Check user has the permission to see the records or not
 */
class CheckPermission
{
    /**
     *  Handle an incoming request.
     *
     * @param  Request  $request
     * @param  string  $permissions
     * @return json $data
     */
    public function handle($request, Closure $next)
    {
        if (! hasPermission()) {
            $data['status']  = ['code' => 403, 'text' => __('Forbidden')];
            $data['message'] = __('You do not have permission to access these records.');

            return response()->json(['response' => $data]);
        }

        return $next($request);
    }
}
