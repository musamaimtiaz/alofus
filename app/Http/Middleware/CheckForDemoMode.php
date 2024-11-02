<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;

class CheckForDemoMode
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

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // If the application is in demo mode, we will redirect the user to back
        if ($this->app->config->get('martvill.is_demo')) {

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'info',
                    'message' => __('Demo Mode! This action can\'t be perform.'),
                ]);
            }

            return redirect()->back()->with([
                'info' => __('Demo Mode! This action can\'t be perform.'),
            ]);
        }

        // Otherwise, we will continue with the request
        return $next($request);
    }
}
