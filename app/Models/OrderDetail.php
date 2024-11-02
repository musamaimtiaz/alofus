<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 14-12-2021
 */

namespace App\Models;

use Carbon\Carbon;
use Modules\Refund\Entities\Refund;

class OrderDetail extends Model
{
    /**
     * Foreign key with Shop model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shop()
    {
        return $this->belongsTo('\Modules\Shop\Http\Models\Shop', 'shop_id');
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
     * Foreign key with ProductMeta model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productMeta()
    {
        return $this->hasMany(ProductMeta::class, 'product_id', 'product_id');
    }

    /**
     * Foreign key with productCategory model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productCategory()
    {
        return $this->belongsTo('App\Models\ProductCategory', 'product_id', 'product_id');
    }

    /**
     * Foreign key with Order model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

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
     * Foreign key with OrderStatus model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orderStatus()
    {
        return $this->belongsTo('App\Models\OrderStatus', 'order_status_id');
    }

    /**
     * Relation with Refund model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function refund()
    {
        return $this->hasOne(\Modules\Refund\Entities\Refund::class);
    }

    /**
     * Relation with Refund model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function refunds()
    {
        return $this->hasMany(\Modules\Refund\Entities\Refund::class);
    }

    /**
     * product details
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productDetails()
    {
        return $this->belongsTo('App\Models\ProductDetail', 'product_id', 'product_id');
    }

    /**
     * Relation with Shipping model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shipping()
    {
        return $this->belongsTo(\Modules\Shipping\Entities\Shipping::class);
    }

    /**
     * Relation with Product model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentProduct()
    {
        return $this->belongsTo(Product::class, 'parent_id', 'id');
    }

    /**
     * Store
     *
     * @param  array  $data
     * @return int|null
     */
    public function store($data = [])
    {
        if (parent::insert($data)) {
            return true;
        }

        return false;
    }

    /**
     * Update OrderDetail
     *
     * @param  array  $data
     * @param  null  $id
     * @return bool
     */
    public function updateOrder($data = [], $id = null)
    {
        $result = parent::where('id', $id)->first();

        if (! empty($result)) {

            if (isset($data['order_status_id'])) {
                $res = $result->checkStatus($data['order_status_id']);
                if ($res['status'] == true) {
                    $data['is_stock_reduce'] = $res['is_stock_reduce'];
                }
            }

            parent::where('id', $id)->update($data);

            return true;
        }

        return false;
    }

    /**
     * check order status
     *
     * @return array
     */
    public function checkStatus($statusId)
    {
        $orderStatusInfo = OrderStatus::getAll()->where('id', $statusId)->first();
        $data = ['status' => false, 'is_stock_reduce' => 0];
        $type = 'self';

        if ($this->product->type == 'Variation' && $this->product->isStockManageable() != 1 && isset($this->product->parentDetail) && $this->product->parentDetail->isStockManageable() == 1) {
            $type = 'parent';
        }

        if ($orderStatusInfo->slug == 'cancelled' && $this->is_stock_reduce == 1) {

            if ($type == 'parent') {
                $this->product->parentDetail->incrementTotalStocks($this->quantity);
            } else {
                $this->product->incrementTotalStocks($this->quantity);
            }

            $data = ['status' => true, 'is_stock_reduce' => 0];
        } elseif (in_array($orderStatusInfo->slug, ['processing', 'completed', 'on-hold']) && $this->is_stock_reduce != 1 && optional($this->product)->isStockReduce($orderStatusInfo->slug)) {

            if ($type == 'parent') {
                $this->product->parentDetail->decrementTotalStocks($this->quantity);
            } else {
                $this->product->decrementTotalStocks($this->quantity);
            }

            $data = ['status' => true, 'is_stock_reduce' => 1];
        } elseif ($orderStatusInfo->payment_scenario != 'paid' && $this->is_stock_reduce == 1) {

            if ($type == 'parent') {
                $this->product->parentDetail->incrementTotalStocks($this->quantity);
            } else {
                $this->product->incrementTotalStocks($this->quantity);
            }
            $data = ['status' => true, 'is_stock_reduce' => 0];
        }

        return $data;
    }

    /**
     * Check order product refundable status
     *
     * @return bool
     */
    public function isRefundable()
    {

        if ($this->is_delivery == 0) {
            return false;
        }

        if ($this->quantity > (isset($this->refund) ? $this->refunds()->sum('quantity_sent') : 0)) {
            return true;
        }

        return false;
    }

    /**
     * Check order product refunded status
     *
     * @return bool
     */
    public function isRefunded()
    {

        if ($this->is_delivery == 0) {
            return false;
        }

        if ($this->quantity == (isset($this->refund) ? $this->refunds()->sum('quantity_sent') : 0)) {
            return true;
        }

        return false;
    }

    /**
     * get product ship on time or not
     *
     * @return int
     */
    public function isInTime()
    {
        $deliveryDays = $this->created_at->diffInDays(Carbon::now());
        $estimateDeliveryDays = $this->productMeta->where('key', 'meta_estimated_delivery')->first();
        $inTimeDelivery = ! empty($estimateDeliveryDays) && $estimateDeliveryDays->value != '' && $deliveryDays <= (int) $estimateDeliveryDays->value ||
        ! empty($estimateDeliveryDays) && $estimateDeliveryDays->value == '' || empty($estimateDeliveryDays) ? 1 : 0;

        return $inTimeDelivery;
    }
}
