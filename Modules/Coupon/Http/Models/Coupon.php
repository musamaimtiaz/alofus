<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 18-11-2021
 */

namespace Modules\Coupon\Http\Models;

use Carbon\Carbon;
use App\Models\{
    Model, Product
};
use App\Rules\{
    CheckValidDate,
    DateCompare
};
use Validator;

class Coupon extends Model
{
    /**
     * timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Stores meta information in array
     *
     * @var array
     */
    protected $metaArray = [];

    /**
     * Checks if the meta is already fetched or not
     *
     * @var bool
     */
    protected $metaFetched = false;

    /**
     * Foreign key with Vendor model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor', 'vendor_id');
    }

    /**
     * Foreign key with Shop model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shop()
    {
        return $this->belongsTo('Modules\Shop\Http\Models\Shop', 'shop_id');
    }

    /**
     * Relation with CouponRedeem model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function couponRedeems()
    {
        return $this->hasMany('Modules\Coupon\Http\Models\CouponRedeem', 'coupon_id');
    }

    /**
     * Foreign key with product model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_coupons');
    }

    /**
     * Relation with Coupon Meta model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function metadata()
    {
        return $this->hasMany(CouponMeta::class, 'coupon_id', 'id');
    }

    /**
     * Get metadata array
     *
     * @return array
     */
    public function getMeta()
    {
        if (! isset($this->relations['metadata'])) {
            $this->relations['metadata'] = $this->getMetaCollection();
        }
        $this->metaArray = $this->relations['metadata']->pluck('value', 'key')->toArray();
        $this->metaFetched = true;
        $metaData = [
            'allow_free_shipping' => '0',
        ];

        return array_merge($metaData, $this->metaArray);
    }

    /**
     * Return metadata collection of the product
     *
     * @return Collection
     */
    public function getMetaCollection()
    {
        if (! isset($this->relations['metadata'])) {
            $this->relations['metadata'] = $this->metadata()->get();
        }

        return $this->relations['metadata'];
    }

    /**
     * Store Validation
     *
     * @param  array  $data
     * @return mixed
     */
    protected static function storeValidation($data = [])
    {
        $data['start_date'] = isset($data['start_date']) ? $data['start_date'] : null;
        $data['condition'] = empty($data['minimum_spend']) ? '' : 'lt:minimum_spend';
        $maximumDiscount = $data['maximum_discount_amount'] == '0' ? 'gt:0' : '';
        $discountType = ['Flat' => __('amount'), 'Percentage' => __('percentage')];

        $validator = Validator::make($data, [
            'name' => 'required|min:3|max:30|unique:coupons,name',
            'vendor_id' => 'nullable',
            'shop_id' => 'nullable',
            'usage_limit' => 'nullable|max:11',
            'minimum_spend' => ['nullable', 'regex:/^[0-9]{1,8}(\.[0-9]{1,8})?$/'],
            'code' => 'required|min:3|max:30|unique:coupons,code',
            'discount_type' => 'required|in:Flat,Percentage',
            'discount_amount' => ['required', 'regex:/^[0-9]{1,8}(\.[0-9]{1,8})?$/', $data['condition']],
            'maximum_discount_amount' => ['nullable', 'regex:/^[0-9]{1,8}(\.[0-9]{1,8})?$/', $maximumDiscount],
            'start_date' => ['required', new CheckValidDate()],
            'end_date' => ['required', new CheckValidDate(), new DateCompare($data['start_date'])],
            'status' => 'required|in:Active,Inactive,Expired',
        ], [
            'discount_amount.lt' => __('Minimum spend must be greater than Discount amount.'),
            'discount_amount.regex' => __('Discount :x format is invalid.', ['x' => $discountType[$data['discount_type']]]),
            'maximum_discount_amount.gt' => __('Maximum discount must be greater than 0'),
        ]);

        return $validator;
    }

    /**
     * Update Validation
     *
     * @param  array  $data
     * @param  int  $id
     * @return mixed
     */
    protected static function updateValidation($data, $id)
    {
        $data['start_date'] = isset($data['start_date']) ? $data['start_date'] : null;
        $data['condition'] = empty($data['minimum_spend']) ? '' : 'lt:minimum_spend';
        $maximumDiscount = $data['maximum_discount_amount'] == '0' ? 'gt:0' : '';
        $discountType = ['Flat' => __('amount'), 'Percentage' => __('percentage')];

        $validator = Validator::make($data, [
            'name' => 'required|min:3|max:30|unique:coupons,name,' . $id,
            'vendor_id' => 'nullable',
            'shop_id' => 'nullable',
            'usage_limit' => 'nullable|max:11',
            'code' => 'required|min:3|max:30|unique:coupons,code,' . $id,
            'discount_type' => 'required|in:Flat,Percentage',
            'discount_amount' => ['required', 'regex:/^[0-9]{1,8}(\.[0-9]{1,8})?$/', $data['condition']],
            'maximum_discount_amount' => ['nullable', 'regex:/^[0-9]{1,8}(\.[0-9]{1,8})?$/', $maximumDiscount],
            'start_date' => ['required', new CheckValidDate()],
            'end_date' => ['required', new CheckValidDate(), new DateCompare($data['start_date'])],
            'status' => 'required|in:Active,Inactive,Expired',
        ], [
            'discount_amount.lt' => __('Minimum spend must be greater than Discount amount.'),
            'discount_amount.regex' => __('Discount :x format is invalid.', ['x' => $discountType[$data['discount_type']]]),
            'maximum_discount_amount.gt' => __('Maximum discount must be greater than 0'),
        ]);

        return $validator;
    }

    /**
     * Store Coupon
     *
     * @param  array  $data
     * @return bool|int $id
     */
    public function store($data = [])
    {
        $id = parent::insertGetId($data);
        if ($id) {
            self::forgetCache();

            return $id;
        }

        return false;
    }

    /**
     * Update Coupon
     *
     * @param  array  $request
     * @param  int  $id
     * @return array $data
     */
    public function updateData($request = [], $id = null)
    {
        $data = ['status' => 'fail', 'message' => __('Coupon not found.')];
        $result = parent::where('id', $id);
        if ($result->exists()) {
            $result->update(array_intersect_key($request, array_flip((array) ['name', 'vendor_id', 'shop_id', 'usage_limit', 'minimum_spend', 'code', 'discount_type', 'discount_amount', 'maximum_discount_amount', 'start_date', 'end_date', 'status'])));
            self::forgetCache();
            $data = ['status' => 'success', 'message' => __('The :x has been successfully saved.', ['x' => __('Coupon')])];
        }

        return $data;
    }

    /**
     * Delete Coupon
     *
     * @param  int  $id
     * @return array $data
     */
    public function remove($id = null)
    {
        $data = ['status' => 'fail', 'message' => __('Coupon not found.')];
        $record = parent::find($id);
        if (! empty($record)) {
            $record->delete();
            $data = ['status' => 'success', 'message' => __('The :x has been successfully deleted.', ['x' => __('Coupon')])];
        }

        return $data;
    }

    /**
     * return coupon_id, discount_type, discount_amount(will be calculated depend on productIds or $vendorIds or $shopIds)
     *
     * Check Validity
     *
     * @param  string  $code
     * @param  array  $productIds,  $vendorIds, $shopIds
     * @return array $data
     */
    public static function isValid($code = null, $productIds = [], $vendorIds = [], $shopIds = [])
    {
        $data = ['status' => false, 'message' => __('Invalid coupon code.'), 'data' => []];

        $coupon = Coupon::where('code', $code)->first();

        if (empty($code) || empty($coupon) || $coupon->code !== $code) {
            return $data;
        }

        if ($coupon->status == 'Inactive') {
            $data['message'] = __('This coupon is not valid.');
        } elseif (parent::isExpired($code)) {
            $data['message'] = __('This coupon has been expired.');
        } elseif (now() < $coupon['start_date']) {
            $data['message'] = __('This coupon is not activated yet.');
        } else {
            $data = ['status' => true, 'message' => '', 'data' => $coupon];
        }

        return $data;
    }

    /**
     * Check Coupon Expire
     *
     * @param  string  $code
     * @return bool
     */
    public function isExpired($code = null)
    {
        $coupon = Coupon::getAll()->where('code', $code)->first();
        if ($coupon->status == 'Expired') {
            return 1;
        }

        if ($coupon && now() > $coupon['end_date'] && $coupon['status'] == 'Active') {
            parent::where('code', $code)->update(['status' => 'Expired']);
            self::forgetCache();

            return 1;
        }

        return 0;
    }

    /**
     * Check Coupon Started
     *
     * @param  string  $code
     * @return bool
     */
    public function isStarted($code = null)
    {
        $coupon = Coupon::getAll()->where('code', $code)->first();
        if ($coupon && now() < $coupon['start_date']) {
            return 0;
        }

        return 1;
    }

    /**
     * Check Coupon Discount
     *
     * @param  string  $code
     * @return array $response
     */
    public function checkDiscount($code = null)
    {
        $response = $this->isValid($code);
        if (empty($response['status'])) {
            return ['status' => 'fail', 'message' => $response['message']];
        }
        $coupon = $response['data'];
        if ($coupon['discount_type'] == 'Percentage') {
            if ($coupon['maximum_discount_amount'] <= 0) {
                return ['status' => 'success', 'message' => __('You will get :x discount to use the coupon.', ['x' => formatNumber($coupon->discount_amount) . '%'])];
            }

            return ['status' => 'success', 'message' => __('You will get :x discount to use the coupon. Up to :y.', ['x' => formatCurrencyAmount($coupon->discount_amount) . '%', 'y' => formatNumber($coupon->maximum_discount_amount)])];
        } else {
            return ['status' => 'success', 'message' => __('You will get :x discount.', ['x' => formatNumber($coupon->discount_amount)])];
        }
    }

    /**
     * Check Coupon Expired
     *
     * @param  string  $code
     * @return array $data
     */
    public function checkExpired($code = null)
    {
        $data = ['status' => 'fail', 'message' => ''];

        $coupon = Coupon::getAll()->where('code', $code)->first();
        if (empty($code) || empty($coupon)) {
            $data['message'] = __('Coupon not found');
        } elseif ($coupon->status == 'Inactive') {
            $data['message'] = __('This coupon is not valid.');
        } elseif ($this->isExpired($code)) {
            $data['message'] = __('This coupon has been expired.');
        } else {
            $data = ['status' => 'success', 'message' => timeToGo($coupon->end_date, true)];
        }

        return $data;
    }

    /**
     * Check Started
     *
     * @param  string  $code
     * @return array $data
     */
    public function checkStarted($code = null)
    {
        $data = ['status' => 'fail', 'message' => ''];

        $coupon = Coupon::getAll()->where('code', $code)->first();
        if (empty($code) || empty($coupon)) {
            $data['message'] = __('Coupon not found');
        } elseif ($coupon->status == 'Inactive') {
            $data['message'] = __('This coupon is not valid.');
        } elseif (now() >= $coupon['start_date']) {
            $data['message'] = __('This coupon is already started.');
        } else {
            $data = ['status' => 'success', 'message' => timeToGo($coupon->start_date, true)];
        }

        return $data;
    }

    /**
     * Get Coupon
     *
     * @param  int  $weeklyCoupon,  $exclusiveCoupon
     * @return collection $result
     */
    public static function getCoupons($weeklyCoupon = false, $exclusiveCoupon = false)
    {
        $result['allCoupons'] = Coupon::with('vendor:id,name', 'products:id,name')->where('status', 'Active')->where('end_date', '>=', date('Y/m/d'))->get();
        if ($weeklyCoupon) {
            $result['weeklyCoupons'] = $result['allCoupons']->whereBetween('end_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->take(6);
        }

        if ($exclusiveCoupon) {
            $result['exclusiveCoupons'] = $result['allCoupons']->where('discount_type', 'Percentage')->sortByDesc('discount_amount')->take(3);
        }

        return $result;
    }

    /**
     * Coupon free shipping status
     *
     * @return true|null
     */
    public function getAllowFreeShippingAttribute()
    {
        $freeShipping = $this->metaData()->where('key', 'allow_free_shipping')->first();

        return isset($freeShipping->value) && $freeShipping->value == 1;
    }
}
