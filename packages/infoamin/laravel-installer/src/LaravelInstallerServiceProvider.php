<?php

namespace Infoamin\Installer;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Infoamin\Installer\Http\Middleware\CheckInstalled;

class LaravelInstallerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Infoamin\Installer\Interfaces\PurchaseInterface',
            'Infoamin\Installer\Helpers\PurchaseChecker'
        );

        $this->app->bind(
            'Infoamin\Installer\Interfaces\CurlRequestInterface',
            'Infoamin\Installer\Http\Requests\CurlRequest'
        );
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('installed', CheckInstalled::class);
        // Routes
        require __DIR__ . '/Http/routes/web.php';
    }
}
