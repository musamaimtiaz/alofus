<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sabbir Al-Razi <[sabbir.techvill@gmail.com]>
 *
 * @created 20-05-2021
 */

namespace App\Models;

use Cache;
use Validator;

class Currency extends Model
{
    /**
     * timestamps
     *
     * @var bool
     */
    public $timestamps = false;

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
     * Get default currency
     *
     * @return object $data
     */
    public static function getDefault()
    {
        $data = Cache::get(config('cache.prefix') . '-defaultCurrency');
        if (empty($data)) {
            $data = self::getAll()->where('id', preference('dflt_currency_id'))->first();
            if (empty($data)) {
                $data = self::getAll()->first();
                Preference::where('field', 'dflt_currency_id')->update(['field' => 'dflt_currency_id', 'value' => $data->id]);
                Cache::clear(config('cache.prefix') . '-preferences');
            }
            Cache::put(config('cache.prefix') . '-defaultCurrency', $data, 30 * 86400);
        }

        return $data;
    }

    /**
     * Get Exchange Rate
     *
     * @param  string  $toCurrency
     * @param  string  $fromCurrency
     * @return number
     */
    public function getExchangeRate($toCurrency = null, $fromCurrency = null)
    {
        $currencies = $this->whereIn('id', [preference('dflt_currency_id'), $fromCurrency, $toCurrency])->get();

        $to = $currencies->where('id', $toCurrency)->first();
        $from = $currencies->where('id', $fromCurrency)->first();
        if (empty($to) || empty($from)) {
            return 1;
        }
        $default = $currencies->where('id', preference('dflt_currency_id'))->first();
        if ($to->id == $from->id) {
            return 1;
        }
        $fromExchangeRate = $from->exchange_from == 'api' ? getCurrencyRate($default->name, $from->name) : $from->exchange_rate;
        $toExchangeRate = $to->exchange_from == 'api' ? getCurrencyRate($default->name, $to->name) : $to->exchange_rate;
        if ($fromExchangeRate == 0 || $toExchangeRate == 0) {
            return 0;
        }

        return number_format((float) ($toExchangeRate / $fromExchangeRate), 2, '.', '');
    }

    /**
     * Store Validation Rules
     *
     * @param  array  $data
     * @return object
     */
    protected static function storeValidation($data = [])
    {
        $validator = Validator::make($data, [
            'name'          => 'required|min:2|max:191|unique:currencies,name',
            'symbol'        => 'required|max:10',
            'exchange_rate' => ['required', 'regex:/^[0-9]{1,8}(\.[0-9]{1,8})?$/'],
            'exchange_from' => 'required | in:local,api',
        ], [
            'exchange_rate.regex' => __('Exchange rate must be 0 to 99999999.99999999'),
        ]);

        return $validator;
    }

    /**
     * Currency update validation rules
     *
     * @param  array  $data
     * @return object
     */
    protected static function updateValidation($data, $id)
    {
        $validator = Validator::make($data, [
            'name'          => ['required', 'min:2|max:191', 'unique:currencies,name,' . $id],
            'symbol'        => 'required|max:10',
            'exchange_rate' => ['required', 'regex:/^[0-9]{1,8}(\.[0-9]{1,8})?$/'],
            'exchange_from' => 'required | in:local,api',
        ], [
            'exchange_rate.regex' => __('Exchange rate must be 0 to 99999999.99999999'),
        ]);

        return $validator;
    }

    /**
     * Store Currency
     *
     * @param  array  $data
     * @return object
     */
    public function store($data = [])
    {
        if (parent::insert($data)) {
            self::forgetCache();

            return true;
        } else {
            return false;
        }
    }

    /**
     * Currency Update
     *
     * @param  array  $data
     * @return object
     */
    public function currencyUpdate($data, $id)
    {
        if (parent::where('id', $id)->update($data)) {
            self::forgetCache();

            return true;
        }

        return false;
    }

    /**
     * Currency Delete
     *
     * @param  null  $id
     * @return array
     */
    public function remove($id = null)
    {
        $data = ['type' => 'fail', 'message' => __('Something went wrong, please try again.')];
        $currencyInfo = Currency::find($id);
        if (! empty($currencyInfo)) {
            if (preference('dflt_currency_id') != $id) {
                $currencyInfo->delete();
                $data = ['type'    => 'success', 'message' => __('The :x has been successfully deleted.', ['x' => __('Currency')])];

            } else {
                $data = ['type' => 'fail', 'message' => __('Can not be deleted. This is default currency.')];
            }

        }

        return $data;
    }
}
