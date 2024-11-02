<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 29-11-2021
 */

namespace Modules\Coupon\Http\Models;

use App\Models\Model;
use Validator;

class ProductCoupon extends Model
{
    /**
     * timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'product_coupons';

    /**
     * Foreign key with Coupon model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coupon()
    {
        return $this->belongsTo('Modules\Coupon\Http\Models\Coupon', 'coupon_id');
    }

    /**
     * Foreign key with Product model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    /**
     * Store Validation
     *
     * @param  array  $data
     * @return mixed
     */
    protected static function storeValidation($data = [])
    {
        $validator = Validator::make($data, [
            'coupon_id' => 'required|numeric',
            'product_id' => 'required|numeric',
        ]);

        return $validator;
    }

    /**
     * Store Product Coupon
     *
     * @param  array  $data
     * @return bool
     */
    public function store($data = [])
    {
        if (parent::insert($data)) {
            return true;
        }

        return false;
    }

    /**
     * Update Product Coupon
     *
     * @param  array  $data
     * @param  int  $id
     * @return bool
     */
    public function updateData($data = [], $id = null)
    {
        $result = parent::where('coupon_id', $id);
        if ($result->exists()) {
            $result->delete();
        }
        if (! empty($data)) {
            parent::insert($data);

            return true;
        }

        return false;
    }
}
