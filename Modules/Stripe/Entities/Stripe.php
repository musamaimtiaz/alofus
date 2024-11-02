<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 06-02-2022
 */

namespace Modules\Stripe\Entities;

use Modules\Gateway\Entities\Gateway;
use Modules\Stripe\Scope\StripeScope;

class Stripe extends Gateway
{
    protected $table = 'gateways';

    protected $appends = ['image_url'];

    protected static function booted()
    {
        static::addGlobalScope(new StripeScope());
    }
}
