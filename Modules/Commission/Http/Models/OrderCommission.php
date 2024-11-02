<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 08-02-2022
 */

namespace Modules\Commission\Http\Models;

use App\Models\Model;

class OrderCommission extends Model
{
    public function orderDetail()
    {
        return $this->belongsTo('App\Models\OrderDetail', 'order_details_id');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor', 'vendor_id');
    }

    /**
     * store
     *
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
     * Store or Update
     *
     * @param  array  $data
     * @return bool
     */
    public function storeOrUpdate($data = [])
    {
        if (parent::updateOrInsert(['order_id' => $data['order_id'], 'vendor_id' => $data['vendor_id']], $data)) {
            return true;
        }

        return false;
    }

    /**
     * Store or Update
     *
     * @param  array  $data
     * @return bool
     */
    public function storeOrUpdateCategory($data = [])
    {
        if (parent::updateOrInsert(['order_id' => $data['order_id'], 'category_id' => $data['category_id']], $data)) {
            return true;
        }

        return false;
    }

    /**
     * Update Order Commission
     *
     * @param  array  $data
     * @param  null  $id
     * @return bool
     */
    public function updateOrderCommission($data = [], $id = null)
    {
        $result = parent::where('id', $id);
        if ($result->exists()) {
            $result->update($data);

            return true;
        }

        return false;
    }

    /**
     * Update Order Commission By OrderDetail
     *
     * @param  array  $data
     * @param  null  $id
     * @return bool
     */
    public function updateOrderCommissionByOrder($data = [], $id = null)
    {
        $result = parent::where('order_details_id', $id);
        if ($result->exists()) {
            $result->update($data);

            return true;
        }

        return false;
    }
}
