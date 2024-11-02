<?php

namespace Modules\Gateway\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed getPurchaseData($key = null)
 *
 * @see \Modules\Gateway\Services\GatewayHelper
 */
class GatewayHelper extends Facade
{
    /**
     * Cart alias
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'GatewayHelper';
    }
}
