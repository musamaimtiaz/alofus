<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $namespace = 'App\\Http\\Controllers';

    protected $vendorNamespace = 'App\\Http\\Controllers\\Vendor';

    protected $siteNamespace = 'App\\Http\\Controllers\\Site';

    protected $apiNamespace = 'App\\Http\\Controllers\\Api';

    protected $userApiNamespace = 'App\\Http\\Controllers\\Api\\User';

    protected $vendorApiNamespace = 'App\\Http\\Controllers\\Api\\Vendor';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::group(apply_filters('api_route_group', [
                'prefix' => 'api',
                'middleware' => ['api'],
                'namespace' => $this->apiNamespace,
            ]), base_path('routes/api.php'));

            Route::group(apply_filters('api_vendor_route_group', [
                'prefix' => 'api/vendor',
                'middleware' => ['api'],
                'namespace' => $this->vendorApiNamespace,
            ]), base_path('routes/vendorApi.php'));

            Route::group(apply_filters('api_user_route_group', [
                'prefix' => 'api/user',
                'middleware' => ['api'],
                'namespace' => $this->userApiNamespace,
            ]), base_path('routes/userApi.php'));

            Route::group(apply_filters('admin_route_group', [
                'prefix' => 'admin',
                'middleware' => ['web'],
                'namespace' => $this->namespace,
            ]), base_path('routes/web.php'));

            Route::group(apply_filters('vendor_route_group', [
                'prefix' => 'vendor',
                'middleware' => ['web'],
                'namespace' => $this->vendorNamespace,
            ]), base_path('routes/vendor.php'));

            Route::group(apply_filters('site_route_group', [
                'middleware' => ['web'],
                'namespace' => $this->siteNamespace,
            ]), base_path('routes/site.php'));

            foreach ($this->app['modules']->allEnabled() as $module) {
                Route::group(apply_filters("{$module->getLowerName()}_route_group", [
                ]), module_path($module->getName(), '/Routes/web.php'));
            }
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
