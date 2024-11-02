<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 30-06-2022
 */

namespace Modules\Tax\Entities;

use App\Models\Model;

class TaxRate extends Model
{
    /**
     * timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Foreign key with TaxClass model
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function taxClass()
    {
        return $this->belongsTo(TaxClass::class);
    }

    /**
     * Store tax rate
     *
     * @param  array  $data
     * @return array $response
     */
    public function store($data)
    {
        $response = ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];
        $id = parent::insertGetId($data);
        if ($id) {
            $response = ['status' => 'success', 'id' => $id, 'message' => __('The :x has been successfully saved.', ['x' => __('Tax rate')])];
        }

        return $response;
    }

    /**
     * Remove star
     *
     * @param  string  $value
     * @return null|string
     */
    private function removeStar($value)
    {
        return $value == '*' ? null : $value;
    }

    /**
     * Update tax rate
     *
     * @param  mixed  $data
     * @return [type]
     */
    public function updateData($data)
    {
        $response = ['status' => 'fail', 'message' => __('Tax rate not found.')];
        if (empty($data)) {
            return $response;
        }

        if (count($data[0]) > 10) {
            foreach ($data as &$value) {
                $value['tax_rate'] = validateNumbers($value['tax_rate']);
                $value['country'] = $this->removeStar($value['country']);
                $value['state'] = $this->removeStar($value['state']);
                $value['city'] = $this->removeStar($value['city']);
                $value['postcode'] = $this->removeStar($value['postcode']);
            }
        }

        if (parent::where('tax_class_id', $data[0]['tax_class_id'])->delete()) {
            $response = ['status' => 'success', 'message' =>  __('The :x has been successfully deleted.', ['x' => __('Tax rate')])];
        }

        if (count($data[0]) > 10 && parent::upsert($data, ['id'], array_keys($data[0]))) {
            $response = ['status' => 'success', 'message' => __('The :x has been successfully saved.', ['x' => __('Tax rate')])];
        }

        return $response;
    }

    /**
     * Delete tax rate
     *
     * @param  int  $id
     * @return array $response
     */
    public function remove($id = null)
    {
        $response = ['status' => 'fail', 'message' => __('Tax rate not found.')];
        $record = parent::find($id);
        if (! empty($record)) {
            $record->delete();
            $response = ['status' => 'success', 'message' =>  __('The :x has been successfully deleted.', ['x' => __('Tax rate')])];
        }

        return $response;
    }

    /**
     * Update tax rate for API
     *
     * @param  array  $request
     * @param  int  $id
     * @return array $data
     */
    public function updateTaxRate($request = [], $id = null)
    {
        $data = ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];
        $result = parent::where('id', $id);
        if ($result->exists()) {
            if (isset($request['rate'])) {
                $request['tax_rate'] = $request['rate'];
            }
            if (isset($request['compound'])) {
                $request['compound'] = ! empty($request['compound']) ? 1 : 0;
            }
            if (isset($request['shipping'])) {
                $request['shipping'] = ! empty($request['shipping']) ? 1 : 0;
            }
            $result->update(array_intersect_key($request, array_flip((array) ['country', 'state', 'postcode', 'city', 'tax_rate', 'name', 'priority', 'compound', 'shipping', 'tax_class_id'])));
            self::forgetCache();

            $data['status'] = 'success';
            $data['message'] = __('The :x has been successfully saved.', ['x' => __('Tax Rate')]);
        }

        return $data;
    }
}
