<?php

namespace Modules\Gateway\Facades;

use Illuminate\Support\Facades\Facade;

class GatewayHandler extends Facade
{
    /**
     * Cart alias
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'GatewayHandler';
    }
}
