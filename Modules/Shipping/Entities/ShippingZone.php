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

class ShippingZone extends Model
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
        return $this->hasMany(ShippingZoneShippingClass::class);
    }

    /**
     * Get Available Shipping Class
     *
     * @return Collection
     */
    public function availableClasses()
    {
        return $this->shippingZoneShippingClasses()->where('shipping_class_slug', '!=', '');
    }

    /**
     * Foreign key with ShippingZoneShippingMethod model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shippingZoneShippingMethods()
    {
        return $this->hasMany(ShippingZoneShippingMethod::class);
    }

    /**
     * Foreign key with ShippingZoneGeolocales model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shippingZoneGeolocales()
    {
        return $this->hasMany(ShippingZoneGeolocale::class);
    }

    /**
     * Store Shipping Zone
     *
     * @param  array  $data
     * @return void
     */
    public function store($data = [])
    {
        parent::insert($data);
    }

    /**
     * Delete Shipping Zone
     *
     * @return void
     */
    public function remove()
    {
        parent::whereNotNull('id')->delete();
    }

    /**
     * Store Shipping Zone for API
     *
     * @param  array  $data
     * @return array $response
     */
    public function storeData($data)
    {
        $response = ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];
        $id = parent::insertGetId($data);
        if ($id) {
            $response = ['status' => 'success', 'id' => $id, 'message' => __('The :x has been successfully saved.', ['x' => __('Shipping Zone')])];
        }

        return $response;
    }

    /**
     * Update Shipping Zone for API
     *
     * @param  array  $data
     *
     * @parm int $id
     *
     * @return array $response
     */
    public function updateData($data, $id)
    {
        $response = ['status' => 'fail', 'message' => __('Shipping zone not found.')];
        $result = parent::where('id', $id);
        if ($result->exists()) {
            $result->update($data);
            $response = ['status' => 'success', 'message' => __('The :x has been successfully saved.', ['x' => __('Shipping zone')])];
        }

        return $response;
    }

    /**
     * Delete Shipping Zone for API
     *
     * @param  int  $id
     * @return array $response
     */
    public function removeData($id = null)
    {
        $response = ['status' => 'fail', 'message' => __('Shipping zone not found.')];
        $record = parent::find($id);
        if (! empty($record)) {
            $record->delete();
            $response = ['status' => 'success', 'message' =>  __('The :x has been successfully deleted.', ['x' => __('Shipping zone')])];
        }

        return $response;
    }
}
