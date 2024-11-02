<?php

/**
 * @author tehcvillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 07-06-2022
 */

namespace Modules\CashOnDelivery\Scope;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class CashOnDeliveryScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('alias', 'cashondelivery');
    }
}
