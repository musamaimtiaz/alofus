<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 * @contributor Soumik Datta <[soumik.techvill@gmail.com]>
 *
 * @created 17-10-2022
 */

namespace App\Http\Controllers;

use App\Models\{
    Country,
    Currency,
    Language,
    Preference,
    File
};
use Illuminate\Http\Request;

class AccountSettingController extends Controller
{
    public function __construct(Request $request)
    {
        //this middleware should be for POST request only
        if ($request->isMethod('post')) {
            $this->middleware('checkForDemoMode')->only('index');
        }
    }

    /**
     * Account setting options
     *
     * return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            $list_menu = 'options';
            $customer_signup = preference('customer_signup');
            $vendor_signup = preference('vendor_signup');

            return view('admin.account_settings.index', compact('list_menu', 'customer_signup', 'vendor_signup'));
        }

        $request->mergeIfMissing(['customer_signup' => '0', 'vendor_signup' => '0']);
        $response = ['status' => 'fail', 'message' => __('Failed to save :x!', ['x' => __('Preference')])];

        $i = $success = 0;
        $preferenceData = [];

        foreach ($request->except('_token') as $key => $value) {
            $preferenceData[$i]['category'] = 'preference';
            $preferenceData[$i]['field'] = $key;
            $preferenceData[$i]['value'] = $value;

            $i++;
        }

        foreach ($preferenceData as $key => $value) {
            if ((new Preference())->storeOrUpdate($value)) {
                $success = 1;
                session([$value['field'] => $value['value']]);          //update preferences on session
            } else {
                $success = 0;

                break;
            }
        }

        if ($success == 1) {
            $response['status'] = 'success';
            $response['message'] = __('The :x has been successfully saved.', ['x' => __('Preference')]);
        }

        //flash response
        $this->setSessionValue($response);

        return redirect()->route('account.setting.option');
    }
}
