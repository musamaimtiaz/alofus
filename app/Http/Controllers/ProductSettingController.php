<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 13-06-2022
 */

namespace App\Http\Controllers;

use App\Models\Preference;
use App\Models\WithdrawalMethod;
use Illuminate\Http\Request;
use Modules\Commission\Http\Models\Commission;

class ProductSettingController extends Controller
{
    public function __construct(Request $request)
    {
        //this middleware should be for POST request only
        if ($request->isMethod('post')) {
            $this->middleware('checkForDemoMode')->only('general', 'inventory', 'vendor');
        }
    }

    /**
     * Product general setting
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function general(Request $request)
    {
        if ($request->isMethod('GET')) {
            $data['list_menu'] = 'general';
            $data['commission'] = Commission::first();
            $data['withdrawalMethods'] = WithdrawalMethod::getAll();

            return view('admin.product_settings.index', $data);
        }

        $response = $this->storeData($request->except('_token'), 'product_general');

        return $response;
    }

    /**
     * Product inventory setting
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function inventory(Request $request)
    {
        $response = $this->storeData($request->except('_token'), 'product_inventory');

        return $response;
    }

    /**
     * Product vendor setting
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function vendor(Request $request)
    {
        $response = $this->storeData($request->only('show_sold_by', 'is_publish_product', 'is_vendor_customer_list_active', 'vendor_category', 'system_suggestion', 'vendor_cat_commission', 'access_system_category', 'is_vendor_shop_decoration_active'), 'product_vendor');

        if ($response['status'] == 'success') {
            if (! (new Commission())->storeOrUpdate($request->only('amount', 'is_active', 'is_category_based', 'order_status_id'))) {
                $response = $this->messageArray(__('Commission update failed.'), 'fail');
            }
            (new WithdrawalMethod())->updateData($request->only('paypal', 'bank'));
            $this->storeData($request->only('chat'), 'product_vendor');
        }

        return $response;
    }

    /**
     * Store product setting
     *
     * @param  array  $request
     * @param  string  $category
     * @return $response;
     */
    private function storeData($request, $category)
    {
        $response = $this->messageArray(__('Invalid Request'), 'fail');

        $i = 0;
        foreach ($request as $key => $value) {
            $data[$i]['category'] = $category;
            $data[$i]['field'] = $key;
            $data[$i]['value'] = $value;
            $i++;
        }

        foreach ($data as $key => $value) {
            if ((new Preference())->storeOrUpdate($value)) {
                $response = $this->messageArray(__('The :x has been successfully saved.', ['x' => __('Product setting')]), 'success');
            }
        }

        return $response;
    }
}
