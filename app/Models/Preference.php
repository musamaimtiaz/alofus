<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sabbir Al-Razi <[sabbir.techvill@gmail.com]>
 *
 * @created 20-05-2021
 */

namespace App\Models;

use App\Rules\{
    CheckDateFormat,
    CheckDefaultTimeZone,
    CheckThousandSeparator,
    CheckValidEmail,
    CheckValidFile,
    CheckValidPhone
};
use App\Traits\ModelTraits\hasFiles;
use Cache;
use Validator;

class Preference extends Model
{
    use hasFiles;

    /**
     * timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = ['category', 'field', 'value'];

    /**
     * Validation
     *
     * @param  array  $data
     * @return mixed
     */
    protected static function validation($data = [])
    {
        $rules = [
            'row_per_page' => 'required|in:10,25,50,100',
            'date_sepa' => 'required|in:-,/,.',
            'decimal_digits' => 'required|digits_between:0,8',
            'file_size' => 'required|integer|min:0',
            'symbol_position' => 'required|in:before,after',
            'thousand_separator' => ['required', new CheckThousandSeparator()],
            'default_timezone' => ['required', new CheckDefaultTimeZone()],
            'date_format' => ['required', new CheckDateFormat()],
        ];
        $messages = [
            'date_sepa.required' => __('The separator field is required.'),
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
     * @param  array  $data
     * @return mixed
     */
    protected static function companySettingValidation($data = [])
    {
        $validator = Validator::make($data, [
            'company_name' => 'required|max:500',
            'site_short_name' => 'required|max:500',
            'company_email' => ['required', 'email', new CheckValidEmail()],
            'company_phone' => ['required', 'min:10', 'max:45', new CheckValidPhone()],
            'company_tax_id' => 'required|max:500',
            'company_street' => 'required|max:500',
           /// 'company_city' => 'required|max:500',
            'company_state' => 'required|max:500',
            'company_zip_code' => 'required|max:500',
            'company_country' => 'required|max:500',
            'dflt_lang' => 'required|max:500|exists:languages,short_name',
            'dflt_currency_id' => 'required|exists:currencies,id',
            'company_logo' => ['nullable', new CheckValidFile(getFileExtensions(3))],
            'company_icon' => ['nullable', new CheckValidFile(getFileExtensions(4))],
        ]);

        return $validator;
    }

    /**
     * Store or Update
     *
     * @param  array  $data
     * @return bool
     */
    public function storeOrUpdate($data = [])
    {

        if (parent::updateOrInsert(['category' => $data['category'], 'field' => $data['field']], $data)) {
            if (! empty(request()->file_id)) {
                foreach (request()->file_id as $key => $value) {
                    if ($value == request()->company_logo_id) {
                        $result = parent::where('field', 'company_logo');
                    } else {
                        $result = parent::where('field', 'company_icon');
                    }
                    request()->file_id = [$value];
                    $result->first()->updateFiles(['isUploaded' => false, 'isOriginalNameRequired' => true, 'thumbnail' => true]);
                }
            }

            self::forgetCache();
            Cache::forget(config('cache.prefix') . '-defaultCurrency');
            Cache::forget(config('cache.prefix') . '-favicon');
            Cache::forget(config('cache.prefix') . '-logo');

            return true;
        }

        return false;
    }

    /**
     * Get the specified option value.
     * If field not found default will return
     *
     * @param  string  $field
     * @param  mixed  $default
     * @return mixed
     */
    public function get($field, $default = null)
    {
        if ($preference = self::getAll()->where('field', $field)->first()) {
            return $preference->value;
        }

        return $default;
    }

    /**
     * Set a given option value.
     *
     * @param  array|string  $field
     * @param  mixed  $value
     * @return void
     */
    public function set($field, $value = null)
    {
        $fields = is_array($field) ? $field : [$field => $value];

        foreach ($fields as $field => $value) {
            if (is_array($value)) {
                foreach ($value as $sField => $sValue) {
                    self::updateOrCreate(['field' => $sField], ['category' => $field, 'field' => $sField, 'value' => $sValue]);
                }
            } else {
                self::updateOrCreate(['field' => $field], ['value' => $value]);
            }

            self::forgetCache();
            Cache::forget(config('cache.prefix') . '-defaultCurrency');
        }
    }

    /**
     * To get favicon picture
     *
     * @return string $image [ favicon picture]
     */
    public static function getFavicon()
    {
        $image = Cache::get(config('cache.prefix') . '-favicon');
        if (empty($image)) {
            $image = Preference::where('field', 'company_icon')->first()->fileUrl();
            Cache::put(config('cache.prefix') . '-favicon', $image, 604800);
        }

        return $image;
    }

    /**
     * To get logo picture
     *
     * @return string $image [ logo picture]
     */
    public static function getLogo()
    {
        $image = Cache::get(config('cache.prefix') . '-logo');
        if (empty($image)) {
            $image = Preference::where('field', 'company_logo')->first()->fileUrl();
            Cache::put(config('cache.prefix') . '-logo', $image, 604800);
        }

        return $image;
    }

    /**
     * preference data store or update if exists
     *
     * @return bool
     */
    public static function store($preference = [])
    {
        if (is_array($preference)) {
            parent::upsert($preference, ['field']);
            self::forgetCache();

            return true;
        }

        return false;
    }
}
