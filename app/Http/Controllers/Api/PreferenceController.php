<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 26-05-2021
 */

namespace App\Http\Controllers\Api;

use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Preference;

class PreferenceController extends Controller
{
    public function index(Request $request)
    {
        $data           = [];
        $preference     = Preference::where('category', 'preference')->pluck('value', 'field')->toArray();
        if ($request->isMethod('get')) {
            return $this->response(['data' => $preference]);
        } elseif ($request->isMethod('post')) {
            $validator  = Preference::validation($request->all());
            if ($validator->fails()) {
                return $this->unprocessableResponse($validator->messages());
            }
            $request['date_format'] = getDateformatId($request->date_format, 'value', 'key');
            unset($request['_token']);

            switch ($request['date_format']) {
                case 0:
                    $request['date_format_type'] = 'yyyy' . $request['date_sepa'] . 'mm' . $request['date_sepa'] . 'dd';

                    break;
                case 1:
                    $request['date_format_type'] = 'dd' . $request['date_sepa'] . 'mm' . $request['date_sepa'] . 'yyyy';

                    break;
                case 2:
                    $request['date_format_type'] = 'mm' . $request['date_sepa'] . 'dd' . $request['date_sepa'] . 'yyyy';

                    break;
                case 3:
                    $request['date_format_type'] = 'dd' . $request['date_sepa'] . 'M' . $request['date_sepa'] . 'yyyy';

                    break;
                case 4:
                    $request['date_format_type'] = 'yyyy' . $request['date_sepa'] . 'M' . $request['date_sepa'] . 'dd';

                    break;
            }

            $i              = 0;
            $preferenceData = [];
            foreach ($request->all() as $key => $value) {
                $preferenceData[$i]['category'] = 'preference';
                $preferenceData[$i]['field']    = $key;
                $preferenceData[$i++]['value']  = $value;
            }

            foreach ($preferenceData as $key => $value) {
                if ((new Preference())->storeOrUpdate($value)) {
                    $data = $this->okResponse([], __('The :x has been successfully saved.', ['x' => __('Preference')]));
                }
            }

            return $data;
        }
    }

    /**
     * Get default preference data
     *
     * @return json $array
     */
    public function defaultPreferenceData()
    {
        $configs = $this->initialize([], null);

        return [
            'preference' => [
                'row_per_page' => $configs['rows_per_page'],
                'date_format' => '1',
                'date_sepa' => '-',
                'date_format_type' => 'dd-mm-yyyy',
                'default_timezone' => 'Asia/Dhaka',
                'thousand_separator' => ',',
                'decimal_digits' => '3',
                'symbol_position' => 'before',
                'pdf' => 'mPdf',
                'file_size' => '10',
                'sso_service' => '["Facebook","Google"]',
                'order_prefix' => 'Ord-',
            ],
            'company' => [

                'site_short_name' => 'ME',
                'company_name' => 'Multivendor',
                'company_email' => 'admin@techvill.net',
                'company_phone' => '+12013828901',
                'company_street' => 'City Hall Park Path',
                'company_city' => 'New york',
                'company_state' => 'New yorktt',
                'company_zip_code' => '116',
                'dflt_lang' => 'en',
                'dflt_currency_id' => '3',
                'dflt_currency_symbol' => '$',
                'company_gstin' => '11',
                'company_icon' => '',
                'company_logo' => '',

            ],
            'verification' => [
                'email' => 'both',
            ],
            'product_inventory' => [
                'manage_stock' => '1',
                'hold_stock' => '20',
                'notification_low_stock' => '1',
                'notification_out_of_stock' => '1',
                'stock_threshold' => '1',
                'out_of_stock_visibility' => '1',
                'stock_display_format' => 'always_show',
            ],
            'product_general' => [
                'taxes' => '1',
                'coupons' => '1',
                'calculate_coupon' => '1',
                'measurement_weight' => 'kg',
                'measurement_dimension' => 'm',
                'reviews_enable_product_review' => '1',
                'reviews_verified_owner_label' => '1',
                'review_left' => '1',
                'rating_enable' => '1',
                'rating_required' => '1',
            ],
            'product_vendor' => [
                'show_sold_by' => '1',
            ],
            'shipping_setting' => [
                'hide_shipping_cost' => '0',
                'shipping_destination' => 'shipping_address',
                'shipping_calculator_cart_page' => '1',
            ],
            'password' => [
                'length' => '4',
                'uppercase' => true,
                'lowercase' => true,
                'number' => true,
                'symbol' => true,
            ],
        ];
    }

    /**
     * Preference list
     *
     * @return json $data
     */
    public function preference(Request $request)
    {
        $preference = Preference::select('*');
        $defaultPreference = $this->defaultPreferenceData();
        $catArr = ['preference', 'company', 'verification', 'product_general', 'product_vendor', 'shipping_setting', 'password'];
        $category = isset($request->category) ? $request->category : null;
        if (in_array($category, $catArr)) {
            $preference->where('category', strtolower($category));
            $defaultPreference = $defaultPreference[$category];
        }

        $preference = $preference->get();

        $conditions = explode('|', env('PASSWORD_STRENGTH'));
        if (env('PASSWORD_STRENGTH') != null && env('PASSWORD_STRENGTH') != '') {
            $passwordPreference = [
                'length' => filter_var(env('PASSWORD_STRENGTH'), FILTER_SANITIZE_NUMBER_INT),
                'uppercase' => in_array('UPPERCASE', $conditions),
                'lowercase' => in_array('LOWERCASE', $conditions),
                'number' => in_array('NUMBERS', $conditions),
                'symbol' => in_array('SYMBOLS', $conditions),
            ];

            foreach ($passwordPreference as $key => $value) {
                $preference->push([
                    'category' => 'password',
                    'field' => $key,
                    'value' => $value,
                ]);
            }
        }
        $dbPreference = [];

        foreach ($preference as $key => $pref) {
            if (in_array($pref['field'], ['company_icon', 'company_logo'])) {
                $pref['value'] = Preference::where('field', $pref['field'])->first()->fileUrl();
            }
            $dbPreference[$pref['category']][$pref['field']] = $pref['value'];

            if ($pref['field'] == 'dflt_currency_id') {
                $dbPreference[$pref['category']]['dflt_currency_symbol'] = Currency::getAll()->where('id', $pref['value'])->first()->symbol;
            }
        }

        if (in_array($category, $catArr)) {
            return $this->response(['data' => array_merge($defaultPreference, $dbPreference[$category])]);
        }

        return $this->response(['data' => array_merge($defaultPreference, $dbPreference)]);
    }
}
