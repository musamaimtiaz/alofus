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

class ShippingZoneGeolocale extends Model
{
    /**
     * timestamps
     *
     * @var bool
     */
    public $timestamps = false;

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
     * Store Shipping Zone Geolocale
     *
     * @param  array  $data
     * @return void
     */
    public function store($data = [])
    {
        parent::insert($data);
    }

    /**
     * Store Shipping Zone Geolocale for API
     *
     * @param  array  $data
     * @return array $response
     */
    public function storeData($data)
    {
        $response = ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];
        $id = parent::insertGetId($data);
        if ($id) {
            $response = ['status' => 'success', 'id' => $id, 'message' => __('The :x has been successfully saved.', ['x' => __('Shipping zone location')])];
        }

        return $response;
    }

    /**
     * Update Shipping Zone Geolocale for API
     *
     * @param  array  $data
     * @param  int  $id
     * @return array $response
     */
    public function updateData($data, $id)
    {
        $response = ['status' => 'fail', 'message' => __('Shipping zone location not found.')];
        $result = parent::where('id', $id);
        if ($result->exists()) {
            $result->update($data);
            $response = ['status' => 'success', 'message' => __('The :x has been successfully saved.', ['x' => __('Shipping zone location')])];
        }

        return $response;
    }

    /**
     * Delete Shipping Zone Geolocale for API
     *
     * @param  array  $data
     * @return array $response
     */
    public function removeData($id = null)
    {
        $response = ['status' => 'fail', 'message' => __('Shipping zone location not found.')];
        $record = parent::find($id);
        if (! empty($record)) {
            $record->delete();
            $response = ['status' => 'success', 'message' =>  __('The :x has been successfully deleted.', ['x' => __('Shipping zone location')])];
        }

        return $response;
    }
}
