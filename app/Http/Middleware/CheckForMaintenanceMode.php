<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Http\MaintenanceModeBypassCookie;

class CheckForMaintenanceMode
{
    /**
     * The application implementation.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * Create a new middleware instance.
     *
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function handle($request, Closure $next)
    {
        if ($this->app->isDownForMaintenance()) {
            $data = json_decode(file_get_contents($this->app->storagePath() . '/framework/down'), true);

            if (isset($data['secret']) && isset($request->bypass_key) && $request->bypass_key === $data['secret']) {
                return redirect()->back()->withCookie(
                    MaintenanceModeBypassCookie::create($request->bypass_key)
                );
            }
        }

        return $next($request);
    }
}
