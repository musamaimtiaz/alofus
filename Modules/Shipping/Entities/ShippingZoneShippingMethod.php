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

class ShippingZoneShippingMethod extends Model
{
    /**
     * timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Foreign key with ShippingMethod model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class);
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
     * Store Shipping Zone Method
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
     * Store Shipping Zone Method for API
     *
     * @param  array  $data
     * @return array $response
     */
    public function storeData($data)
    {
        $response = ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];
        $id = parent::insertGetId($data);
        if ($id) {
            $response = ['status' => 'success', 'id' => $id, 'message' => __('The :x has been successfully saved.', ['x' => __('Shipping zone method')])];
        }

        return $response;
    }

    /**
     * Update Shipping Zone Method for API
     *
     * @param  array  $data
     * @param  int  $id
     * @return array $response
     */
    public function updateData($data, $id)
    {
        $response = ['status' => 'fail', 'message' => __('Shipping zone method not found.')];
        $result = parent::where('id', $id);
        if ($result->exists()) {
            $result->update($data);
            $response = ['status' => 'success', 'message' => __('The :x has been successfully saved.', ['x' => __('Shipping zone method')])];
        }

        return $response;
    }

    /**
     * Delete Shipping Zone Method for API
     *
     * @param  int  $id
     * @return array $response
     */
    public function removeData($id = null)
    {
        $response = ['status' => 'fail', 'message' => __('Shipping zone method not found.')];
        $record = parent::find($id);
        if (! empty($record)) {
            $record->delete();
            $response = ['status' => 'success', 'message' =>  __('The :x has been successfully deleted.', ['x' => __('Shipping zone method')])];
        }

        return $response;
    }
}
