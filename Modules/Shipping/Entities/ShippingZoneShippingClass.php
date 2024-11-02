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

class ShippingZoneShippingClass extends Model
{
    /**
     * timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Foreign key with ShippingClass model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shippingClass()
    {
        return $this->belongsTo(ShippingClass::class, 'shipping_class_slug', 'slug');
    }

    /**
     * Foreign key with ShippingZone model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shippingZone()
    {
        return $this->belongsTo(ShippingZone::class);
    }

    /**
     * Foreign key with ShippingZoneGeolocale model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ShippingZoneGeolocale()
    {
        return $this->hasOne('Modules\Shipping\Entities\ShippingZoneGeolocale', 'shipping_zone_id', 'shipping_zone_id');
    }

    /**
     * Foreign key with ShippingZoneGeolocale hasMany relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ShippingZoneGeolocales()
    {
        return $this->hasMany('Modules\Shipping\Entities\ShippingZoneGeolocale', 'shipping_zone_id', 'shipping_zone_id');
    }

    /**
     * Foreign key with ShippingZoneShippingMethod model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ShippingZoneShippingMethod()
    {
        return $this->hasMany('Modules\Shipping\Entities\ShippingZoneShippingMethod', 'shipping_zone_id', 'shipping_zone_id');
    }

    /**
     * Store Shipping Zone Class
     *
     * @param  array  $data
     * @return void
     */
    public function store($data = [])
    {
        foreach ($data as &$value) {
            $value['cost'] = validateNumbers($value['cost']);
        }

        parent::insert($data);
    }

    /**
     * Store Shipping Zone Class for API
     *
     * @param  array  $data
     * @return array $response
     */
    public function storeData($data)
    {
        $response = ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];
        $id = parent::insertGetId($data);
        if ($id) {
            $response = ['status' => 'success', 'id' => $id, 'message' => __('The :x has been successfully saved.', ['x' => __('Shipping zone class')])];
        }

        return $response;
    }

    /**
     * Update Shipping Zone Class for API
     *
     * @param  array  $data
     * @param  int  $id
     * @return array $response
     */
    public function updateData($data, $id)
    {
        $response = ['status' => 'fail', 'message' => __('Shipping zone class not found.')];
        $result = parent::where('id', $id);
        if ($result->exists()) {
            $result->update($data);
            $response = ['status' => 'success', 'message' => __('The :x has been successfully saved.', ['x' => __('Shipping zone class')])];
        }

        return $response;
    }

    /**
     * Remove Shipping Zone Class for API
     *
     * @param  int  $id
     * @return array $response
     */
    public function removeData($id = null)
    {
        $response = ['status' => 'fail', 'message' => __('Shipping zone class not found.')];
        $record = parent::find($id);
        if (! empty($record)) {
            $record->delete();
            $response = ['status' => 'success', 'message' =>  __('The :x has been successfully deleted.', ['x' => __('Shipping zone class')])];
        }

        return $response;
    }
}
