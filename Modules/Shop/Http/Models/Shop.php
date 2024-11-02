<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 28-09-2021
 */

namespace Modules\Shop\Http\Models;

use App\Models\Model;
use App\Traits\ModelTraits\hasFiles;
use App\Rules\{
    CheckValidEmail, CheckValidPhone
};
use Validator;

class Shop extends Model
{
    use hasFiles;

    /**
     * timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Foreign key with Vendor model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor', 'vendor_id');
    }

    /**
     * Relation with coupon model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function coupons()
    {
        return $this->hasMany('Modules\Coupon\Http\Models\Coupon', 'shop_id', 'id');
    }

    /**
     * Foreign key with Product model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function products()
    {
        return $this->hasMany('App\Models\Product', 'shop_id');
    }

    public function scopeIsActiveVendor($query)
    {
        $query->whereHas('vendor', function ($q) {
            $q->where('status', 'Active');
        });
    }

    /**
     * Relation with Transaction model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
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
            'name' => 'required|min:3|max:99|unique:shops,name',
            'vendor_id' => 'required|numeric',
            'email' => ['required', 'max:99', 'unique:shops,email', new CheckValidEmail()],
            'website' => ['nullable', 'max:255', 'regex:/^(http[s]?:\/\/)?(www\.)?([\.]?[a-z]+[a-zA-Z0-9\-]{1,})?[\.]?[a-z]+[a-zA-Z0-9\-]+\.[a-zA-Z]{2,5}([\.]?[a-zA-Z]{2,5})?/i'],
            'alias' => 'required|min:2|max:40|unique:shops,alias',
            'address' => 'nullable|max:255',
            'phone' => ['required', 'min:7', 'max:15', new CheckValidPhone()],
            'fax' => 'nullable|max:45',
            'description' => 'nullable|max:5000',
            'status' => 'in:Active,Inactive',
        ]);

        return $validator;
    }

    /**
     * Update validation
     *
     * @param  array  $data
     * @param  int  $id
     * @return mixed
     */
    protected static function updateValidation($data = [], $id = null)
    {
        $validator = Validator::make($data, [
            'name' => ['required', 'min:3', 'max:99', 'unique:shops,name,' . $id],
            'vendor_id' => 'required|numeric',
            'email' => ['required', 'max:99', 'unique:shops,email,' . $id, new CheckValidEmail()],
            'website' => ['nullable', 'max:255', 'regex:/^(http[s]?:\/\/)?(www\.)?([\.]?[a-z]+[a-zA-Z0-9\-]{1,})?[\.]?[a-z]+[a-zA-Z0-9\-]+\.[a-zA-Z]{2,5}([\.]?[a-zA-Z]{2,5})?/i'],
            'alias' => 'required|min:2|max:40|unique:shops,alias,' . $id,
            'address' => 'nullable|max:255',
            'phone' => ['required', 'min:7', 'max:15', new CheckValidPhone()],
            'fax' => 'nullable|max:45',
            'description' => 'nullable|max:5000',
            'status' => 'in:Active,Inactive',
        ]);

        return $validator;
    }

    /**
     * Store Shop
     *
     * @param  array  $data
     * @return bool
     */
    public function store($data = [])
    {
        if (parent::insert($data)) {
            self::forgetCache();

            return true;
        }

        return false;
    }

    /**
     * Update Shop
     *
     * @param  array  $request
     * @param  int  $id
     * @return array $data
     */
    public function updateShop($request = [], $id = null)
    {
        $data = ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];
        $result = parent::where('id', $id);
        if ($result->exists()) {
            $result->update(array_intersect_key($request, array_flip((array) ['vendor_id', 'name', 'email', 'website', 'alias', 'address', 'phone', 'fax', 'description', 'status'])));
            $result->first()->updateFiles(['isUploaded' => false, 'isOriginalNameRequired' => true, 'thumbnail' => true]);
            self::forgetCache();

            $data['status'] = 'success';
            $data['message'] = __('The :x has been successfully saved.', ['x' => __('Shop')]);
        }

        return $data;
    }

    /**
     * Delete Shop
     *
     * @param  int  $id
     * @return object
     */
    public function remove($id = null)
    {
        $data = ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];
        $record = parent::find($id);
        if (! empty($record)) {
            $record->delete();
            $data['status'] = 'success';
            $data['message'] = __('The :x has been successfully deleted.', ['x' => __('Shop')]);
        }

        return $data;
    }

    /**
     * Shop Count
     *
     * @param  int  $id
     * @return null|int
     */
    public function shopCount($id = null)
    {
        $vendorId = parent::find($id)->vendor_id;
        if (isset($vendorId)) {
            return parent::where('vendor_id', $vendorId)->count();
        }

        return null;
    }
}
