<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 19-07-2022
 */

namespace Modules\Shipping\Entities;

use App\Models\Model;
use DB;

class ShippingClass extends Model
{
    /**
     * timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Foreign key with ShippingZoneShippingClass model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shippingZoneShippingClasses()
    {
        return $this->hasMany(ShippingZoneShippingClass::class, 'shipping_class_slug', 'slug');
    }

    /**
     * Foreign key with ShippingZoneShippingClass model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shippingZoneShippingMethods()
    {
        return $this->hasMany(ShippingZoneShippingClass::class);
    }

    /**
     * Store Shipping Class
     *
     * @param  array  $data
     * @return bool
     */
    public function store($data = [])
    {
        try {
            DB::beginTransaction();
            parent::whereNotNull('id')->delete();
            if (! empty($data)) {
                parent::insert($data);
            }
            self::forgetCache();
            DB::commit();
        } catch (\Exception $th) {
            DB::rollback();

            return false;
        }

        return true;
    }

    /**
     * Store Shipping Class for API
     *
     * @param  array  $data
     * @return array $response
     */
    public function storeData($data)
    {
        $response = ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];
        $id = parent::insertGetId($data);
        if ($id) {
            $response = ['status' => 'success', 'id' => $id, 'message' => __('The :x has been successfully saved.', ['x' => __('Shipping class')])];
        }

        return $response;
    }

    /**
     * Update Shipping Class for API
     *
     * @param  array  $data
     * @param  int  $id
     * @return array $response
     */
    public function updateData($data, $id)
    {
        $response = ['status' => 'fail', 'message' => __('Shipping class not found.')];
        $result = parent::where('id', $id);
        if ($result->exists()) {
            $result->update($data);
            $response = ['status' => 'success', 'message' => __('The :x has been successfully saved.', ['x' => __('Shipping class')])];
        }

        return $response;
    }

    /**
     * Delete Shipping Class for API
     *
     * @param  int  $id
     * @return array $response
     */
    public function removeData($id = null)
    {
        $response = ['status' => 'fail', 'message' => __('Shipping class not found.')];
        $record = parent::find($id);
        if (! empty($record)) {
            $record->delete();
            $response = ['status' => 'success', 'message' =>  __('The :x has been successfully deleted.', ['x' => __('Shipping class')])];
        }

        return $response;
    }
}
