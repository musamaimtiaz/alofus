<?php

namespace Modules\Coupon\Http\Models;

use App\Models\MetaData;
use App\Traits\ModelTraits\Cachable;

class CouponMeta extends MetaData
{
    use Cachable;

    protected $table = 'coupons_meta';

    public $timestamps = false;

    protected $fillable = [
        'coupon_id',
        'type',
        'key',
        'value',
    ];

    /**
     * Store coupon meta data
     *
     * @param  array  $data
     * @return bool
     */
    public function store($data)
    {
        return parent::upsert($data, ['coupon_id', 'key']);
    }
}
