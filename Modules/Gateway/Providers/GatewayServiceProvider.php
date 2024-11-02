<?php

namespace Modules\Gateway\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Gateway\Entities\GatewayHandler;
use Modules\Gateway\Facades\GatewayHandler as FacadesGatewayHandler;
use Modules\Gateway\Services\GatewayHelper;

class GatewayServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('GatewayHelper', function () {
            return new GatewayHelper();
        });
        $this->app->bind('GatewayHandler', function () {
            return new GatewayHandler();
        });

        FacadesGatewayHandler::registerAllMethods();
    }
}
