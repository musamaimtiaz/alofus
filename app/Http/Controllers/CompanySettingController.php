<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 26-05-2021
 */

namespace App\Http\Controllers;

use App\Models\{
    Country,
    Currency,
    Language,
    Preference
};
use Illuminate\Http\Request;

class CompanySettingController extends Controller
{
    public function __construct(Request $request)
    {
        //this middleware should be for POST request only
        if ($request->isMethod('post')) {
            $this->middleware('checkForDemoMode')->only('index');
        }
    }

    /**
     * company setting
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|void
     */
    public function index(Request $request)
    {
        $response             = $this->messageArray(__('Invalid Request'), 'fail');
        $data['list_menu']    = 'system_setup';
        $data['currencyData'] = Currency::getAll();
        $data['countryData']  = Country::getAll();
        $data['languageData'] = Language::getAll();
        $pref                 = Preference::where('category', 'company')->pluck('value', 'field')->toArray();

        if ($request->isMethod('get')) {
            $data['companyData']['company'] = $pref;
            $data['companyData']['logo']  = Preference::where('field', 'company_logo')->first()->fileUrl();
            $data['companyData']['icon']  = Preference::where('field', 'company_icon')->first()->fileUrl();

            return view('admin.company_settings.index', $data);
        } elseif ($request->isMethod('post')) {

            $validator = Preference::companySettingValidation($request->all());

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $post = $request->only('company_name', 'site_short_name', 'company_email', 'company_phone', 'company_street', 'company_city', 'company_state', 'company_zip_code', 'company_country', 'dflt_lang', 'dflt_currency_id');
            $post['company_gstin'] = $request->company_tax_id;
            unset($data);
            $i = 0;

            foreach ($post as $key => $value) {
                $data[$i]['category'] = 'company';
                $data[$i]['field']    = $key;
                $data[$i]['value'] = $value;
                $i++;
            }

            foreach ($data as $key => $value) {
                if ((new Preference())->storeOrUpdate($value)) {
                    $response = $this->messageArray(__('The :x has been successfully saved.', ['x' => __('Company Settings')]), 'success');
                }
            }

            $prefer = preference();

            if (! empty($prefer)) {
                $curr = Currency::getDefault();
            }

            $language     = Language::getAll()->where('is_default', 1)->first();
            $languageData = [];

            if ($request->dflt_lang != $language->short_name) {
                $updateLanguage             = Language::getAll()->where('short_name', $request->dflt_lang)->first();
                $languageData['is_default'] = 1;
                (new Language())->updateLanguage($languageData, $updateLanguage->id);
            }
            $this->setSessionValue($response);

            return redirect()->route('companyDetails.setting');
        }
    }
}
