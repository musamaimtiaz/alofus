<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 01-02-2022
 */

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class OrderStatusRole extends Model
{
    use ModelTrait;

    /**
     * Foreign key with Product model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orderStatus()
    {
        return $this->belongsTo('App\Models\OrderStatus', 'order_status_id');
    }

    /**
     * Store
     *
     * @param  array  $data
     * @return object
     */
    public function store($data = [])
    {
        if (parent::insert($data)) {
            self::forgetCache();

            return true;
        } else {
            return false;
        }
    }

    /**
     * update
     *
     * @return bool
     */
    public function statusUpdate($data, $id)
    {
        if (parent::where('id', $id)->update($data)) {
            self::forgetCache();

            return true;
        }

        return false;
    }

    /**
     * Status Role Delete
     *
     * @return array
     */
    public function remove($statusId = null, $roleId = null)
    {
        $data = ['type' => 'fail', 'message' => __('Something went wrong, please try again.')];
        $roleInfo = parent::where('order_status_id', $statusId)->where('role_id', $roleId);

        if ($roleInfo->exists()) {
            $roleInfo->delete();
            self::forgetCache();
            $data = ['type'    => 'success', 'message' => __('The :x has been successfully deleted.', ['x' => __('Role')])];
        }

        return $data;
    }
}
