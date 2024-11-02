<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 17-10-2022
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Preference;

class OrderSettingController extends Controller
{
    public function __construct(Request $request)
    {
        //this middleware should be for POST request only
        if ($request->isMethod('post')) {
            $this->middleware('checkForDemoMode')->only('index');
        }
    }

    /**
     * Order general setting
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            $data['list_menu'] = 'option';

            return view('admin.order_settings.index', $data);
        }

        foreach ($request->only('order_prefix', 'order_refund', 'guest_order', 'bulk_pay_count', 'disable_bulk_payment', 'bulk_payment_user_role') as $key => $value) {
            $value = is_array($value) ? json_encode($value) : $value;
            (new Preference())->storeOrUpdate([
                'category' => 'preference', 'field' => $key, 'value' => $value ?? '',
            ]);
        }

        $response = $this->messageArray(__('The :x has been successfully saved.', ['x' => __('Order Setting')]), 'success');
        $this->setSessionValue($response);

        return redirect()->route('order.setting.option');
    }
}
