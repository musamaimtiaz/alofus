<?php

/**
 * @author tehcvillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 07-06-2022
 */

namespace Modules\CashOnDelivery\Entities;

use Modules\Gateway\Entities\Gateway;
use Modules\CashOnDelivery\Scope\CashOnDeliveryScope;

class CashOnDelivery extends Gateway
{
    protected $table = 'gateways';

    protected $appends = ['image_url'];

    protected static function booted()
    {
        static::addGlobalScope(new CashOnDeliveryScope());
    }
}
