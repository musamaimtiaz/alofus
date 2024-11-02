<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 08-12-2021
 */

namespace App\Models;

use App\Rules\CheckValidPhone;
use App\Rules\CheckValidEmail;
use App\Traits\ModelTrait;
use Auth;
use Validator;
use Modules\GeoLocale\Entities\Country;
use Modules\GeoLocale\Entities\Division;

class Address extends Model
{
    use ModelTrait;

    /**
     * timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Foreign key with User model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * Foreign key with Country model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function geoLocalCountry()
    {
        return $this->belongsTo('Modules\GeoLocale\Entities\Country', 'country', 'code');
    }

    /**
     * Foreign key with Division model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function geoLocalState()
    {
        return $this->belongsTo('Modules\GeoLocale\Entities\Division', 'state', 'code')->where('country_id', optional($this->geoLocalCountry)->id);
    }

    /**
     * Store Validation
     *
     * @param  array  $data
     * @return mixed
     */
    protected static function storeValidation($data = [])
    {
        $validator = Validator::make($data, [
            'user_id' => 'required|numeric',
            'first_name' => 'required|max:191',
            'last_name' => 'nullable|max:191',
            'phone' => ['required', 'min:7', 'max:15', new CheckValidPhone()],
            'email' => ['nullable', new CheckValidEmail()],
            'company_name' => 'nullable',
            'type_of_place' => 'required|in:home,office',
            'address_1' => 'required|max:191',
            'address_2' => 'nullable|max:191',
            'city' => 'required|max:191',
            'zip' => 'nullable|string|max:10',
            'country' => 'required|max:191',
            'state' => 'nullable|max:191',
            'is_default' => 'required|in:0,1',
        ], [
            'is_default.in' => __('Default value must be either 0 or 1'),
            'type_of_place.in' => __('Type of place must be either home or office.'),
        ]);

        return $validator;
    }

    /**
     * Update Validation
     *
     * @param  array  $data
     * @return mixed
     */
    protected static function updateValidation($data, $id)
    {
        $validator = Validator::make($data, [
            'user_id' => 'required|numeric',
            'first_name' => 'required|max:191',
            'last_name' => 'nullable|max:191',
            'phone' => ['required', 'min:7', 'max:15',  new CheckValidPhone()],
            'email' => ['nullable', new CheckValidEmail()],
            'company_name' => 'nullable',
            'type_of_place' => 'required|in:home,office',
            'address_1' => 'required|max:191',
            'address_2' => 'nullable|max:191',
            'city' => 'required|max:191',
            'zip' => 'nullable|string|max:10',
            'country' => 'required|max:191',
            'state' => 'nullable|max:191',
            'is_default' => 'required|in:0,1',
        ], [
            'is_default.in' => __('Default value must be either 0 or 1'),
            'type_of_place.in' => __('Type of place must be either home or office.'),
        ]);

        return $validator;
    }

    /**
     * store
     *
     * @param  array  $data
     * @return bool
     */
    public function store($data = [])
    {
        if ($data['is_default'] == 1) {
            parent::where('is_default', 1)->update(['is_default' => 0]);
        }
        $id = parent::insertGetId($data);
        if ($id) {
            self::forgetCache();

            return $id;
        }

        return false;
    }

    /**
     * Update
     *
     * @param  array  $request
     * @param  int  $id
     * @return array
     */
    public function updateData($request = [], $id = null)
    {
        $data = ['status' => 'fail', 'message' => __('Address does not found.')];
        $result = parent::where('id', $id);
        if ($result->exists()) {
            if ($request['is_default'] == 1) {
                parent::where('is_default', 1)->update(['is_default' => 0]);
            }
            $result->update(array_intersect_key($request, array_flip((array) ['user_id', 'first_name', 'last_name', 'phone', 'email', 'company_name', 'type_of_place', 'address_1', 'address_2', 'state', 'country', 'city', 'zip', 'is_default'])));
            self::forgetCache();
            $data = ['status' => 'success', 'message' => __('The :x has been successfully saved.', ['x' => __('Address')])];
        }

        return $data;
    }

    /**
     * delete
     *
     * @param  int  $id
     * @return array
     */
    public function remove($id = null)
    {
        $data = ['status' => 'fail', 'message' => __('Address does not found.')];
        $record = parent::find($id);
        if ($record->is_default == 1) {
            $data = ['status' => 'fail', 'message' =>  __("You can't delete primary address.")];
        } elseif (! empty($record)) {
            $record->delete();
            $data = ['status' => 'success', 'message' =>  __('The :x has been successfully removed.', ['x' => __('Address')])];
        }

        return $data;
    }

    /**
     * Check address existence
     *
     * @return array
     */
    public function checkAddress()
    {
        $address = parent::where('user_id', Auth::user()->id);
        if ($address->exists() && $address->where('is_default', 1)->count() > 0) {
            return ['status' => 'success', 'message' =>  __('Address found.')];
        }

        return ['status' => 'fail', 'message' =>  __('Address not found.')];
    }

    /**
     * Make default address
     *
     * @param  int  $id
     * @return response
     */
    public function updateDefault($id)
    {
        $address = parent::where('id', $id);
        if ($address->exists()) {
            parent::where(['is_default' => 1, 'user_id' => auth()->user()->id])->update(['is_default' => 0]);
            $address->update(['is_default' => '1']);
            self::forgetCache();

            return ['status' => 'success', 'message' => __('The :x has been successfully saved.', ['x' => __('Address')])];
        }

        return ['status' => 'fail', 'message' =>  __('Address not found.')];
    }

    public function country1()
    {
        return $this->belongsTo(Country::class, 'country', 'code');
    }

    /**
     * relation with division
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function states()
    {
        return $this->belongsTo(Division::class, 'state', 'id');
    }
}
