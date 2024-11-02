<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 15-2-22
 */

namespace Modules\Paypal\Entities;

use Modules\Gateway\Entities\Gateway;
use Modules\Paypal\Scope\PaypalScope;

class Paypal extends Gateway
{
    protected $table = 'gateways';

    protected $appends = ['image_url'];

    protected static function booted()
    {
        static::addGlobalScope(new PaypalScope());
    }
}
