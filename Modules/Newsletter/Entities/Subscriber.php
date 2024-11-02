<?php

namespace Modules\Newsletter\Entities;

use App\Models\Model;

class Subscriber extends Model
{
    protected $fillable = [];

    /**
     * Store Subscriber
     *
     * @param  array  $data
     * @return array $response
     */
    public function store($data = [])
    {
        $response = ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];
        if ($id = parent::insertGetId($data)) {
            self::forgetCache();
            $response = ['id' => $id, 'status' => 'success', 'message' => __('Thanks, you have successfully subscribed.')];
        }

        return $response;
    }

    /**
     * Update Subscriber
     *
     * @param  array  $request
     * @param  int  $id
     * @return array $data
     */
    public function updateData($request = [], $id = null)
    {
        $data = ['status' => 'fail', 'message' => __('Subscriber not found.')];
        $result = parent::where('id', $id);
        if ($result->exists()) {
            $request['confirmation_date'] = DbDateFormat($request['confirmation_date']);
            $result->update($request);
            self::forgetCache();
            $data = ['status' => 'success', 'message' => __('The :x has been successfully saved.', ['x' => __('Subscriber information')])];
        }

        return $data;
    }

    /**
     * Delete subscriber
     *
     * @param  int  $id
     * @return array $data
     */
    public function remove($id = null)
    {
        $data = ['status' => 'fail', 'message' => __('Subscriber not found.')];
        $record = parent::find($id);
        if (! empty($record)) {
            $record->delete();
            self::forgetCache();
            $data = ['status' => 'success', 'message' => __('The :x has been successfully deleted.', ['x' => __('Subscriber')])];
        }

        return $data;
    }
}
