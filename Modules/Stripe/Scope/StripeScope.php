<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 16-2-22
 */

namespace Modules\Stripe\Scope;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class StripeScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('alias', 'stripe');
    }
}
