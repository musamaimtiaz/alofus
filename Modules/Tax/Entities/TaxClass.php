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

class TaxClass extends Model
{
    /**
     * timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = ['name', 'slug'];

    /**
     * Foreign key with TaxRate model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taxRates()
    {
        return $this->hasMany(TaxRate::class);
    }

    /**
     * Store tax class
     *
     * @param  array  $data
     * @return array $response
     */
    public function store($data)
    {
        $response = ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];

        if ($taxClass = parent::create($data)) {
            $response = [
                'status' => 'success',
                'id' => $taxClass->id,
                'name' => $taxClass->name,
                'slug' => $taxClass->slug,
                'message' => __('The :x has been successfully saved.', ['x' => __('Tax class')]),
            ];
        }

        static::forgetCache();

        return $response;
    }

    /**
     * Update tax class
     *
     * @param  array  $data
     * @param  int  $id
     * @return array $response
     */
    public function updateData($data, $id)
    {
        $response = ['status' => 'fail', 'message' => __('Tax class not found.')];
        $result = parent::where('id', $id);

        if ($result->exists()) {
            $result->update($data);

            $response = [
                'status' => 'success',
                'name' => $data['name'],
                'slug' => $data['slug'],
                'message' => __('The :x has been successfully saved.', ['x' => __('Tax class')])];
        }

        static::forgetCache();

        return $response;
    }

    /**
     * Remove tax class
     *
     * @param  int  $id
     * @return array $response
     */
    public function remove($id = null)
    {
        $response = ['status' => 'fail', 'message' => __('Tax class not found.')];
        $record = parent::where('id', $id)->orWhere('slug', $id)->first();
        if (! empty($record)) {
            if ($record->id == 1) {
                $response['message'] = __('Standard tax class can not be deleted.');

                return $response;
            }
            $record->delete();
            $response = ['status' => 'success', 'message' =>  __('The :x has been successfully deleted.', ['x' => __('Tax class')])];
        }
        static::forgetCache();

        return $response;
    }
}
