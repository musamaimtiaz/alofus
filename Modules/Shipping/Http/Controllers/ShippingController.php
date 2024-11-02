<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 15-12-2021
 */

namespace Modules\Shipping\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Preference;
use Modules\Shipping\Entities\{
    ShippingZone,
    ShippingZoneGeolocale,
    ShippingZoneShippingMethod,
    ShippingClass,
    ShippingZoneShippingClass
};
use DB;

class ShippingController extends Controller
{
    /**
     * Shipping List
     *
     * @return \illuminate\contracts\View
     */
    public function index()
    {
        $data['shippingZones'] = ShippingZone::with(['shippingZoneGeolocales', 'shippingZoneShippingMethods', 'availableClasses'])->get();
        $classes = ShippingClass::select('*')->get();
        $data['shippingClasses'] = $classes->where('slug', '!=', 'no-class');
        $data['zoneClasses'] = $classes->where('slug', '!=', '');

        return view('shipping::index', $data);
    }

    /**
     * Store Shipping Zone
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $shippingZone = [];
        $shippingZoneMethod = [];
        $shippingZoneGeolocale = [];
        $shippingZoneClass = [];
        foreach (json_decode($request->data) as $key => $value) {
            $shippingZone[] = ['id' => $value->id, 'name' => $value->name];

            $shippingZoneMethod[] = [
                'shipping_zone_id' => $value->id,
                'shipping_method_id' => $value->flat_rate_id,
                'method_title' => $value->flat_rate_name,
                'tax_status' => $value->flat_rate_tax_status,
                'cost' => $value->flat_rate_cost,
                'cost_type' => $value->flat_rate_cost_type,
                'calculation_type' => $value->flat_rate_calculation_type ?? null,
                'requirements' => null,
                'status' => $value->flat_rate_status,
            ];

            $shippingZoneMethod[] = [
                'shipping_zone_id' => $value->id,
                'shipping_method_id' => $value->local_pickup_id,
                'method_title' => $value->local_pickup_name,
                'tax_status' => $value->local_pickup_tax_status,
                'cost' => $value->local_pickup_cost,
                'cost_type' => $value->local_pickup_cost_type,
                'calculation_type' => null,
                'requirements' => null,
                'status' => $value->local_pickup_status,
            ];

            $shippingZoneMethod[] = [
                'shipping_zone_id' => $value->id,
                'shipping_method_id' => $value->free_shipping_id,
                'method_title' => $value->free_shipping_name,
                'tax_status' => null,
                'cost' => $value->free_shipping_cost ?? null,
                'cost_type' => null,
                'calculation_type' => $value->free_calculation_type ?? null,
                'requirements' => $value->free_shipping_requirement,
                'status' => $value->free_shipping_status,
            ];

            foreach ($value->location as $key => $location) {
                $shippingZoneGeolocale[] = [
                    'shipping_zone_id' => $value->id,
                    'country' => $location->country,
                    'state' => $location->state,
                    'city' => $location->city,
                    'zip' => $location->zip,
                ];
            }

            foreach ($value->classes as $key => $class) {
                $shippingZoneClass[] = [
                    'shipping_zone_id' => $value->id,
                    'shipping_class_slug' => $class->slug,
                    'cost' => $class->cost,
                    'cost_type' => $class->cost_type,
                ];
            }
        }

        $response = ['status' => 'success', 'message' => __('The :x has been successfully saved.', ['x' => __('Shipping Zone')])];

        try {
            DB::beginTransaction();
            (new ShippingZone())->remove();

            (new ShippingZone())->store($shippingZone);
            (new ShippingZoneGeolocale())->store($shippingZoneGeolocale);
            (new ShippingZoneShippingMethod())->store($shippingZoneMethod);
            (new ShippingZoneShippingClass())->store($shippingZoneClass);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $response = ['status' => 'fail', 'message' => $e];
        }

        return $response;

    }

    /**
     * Store Shipping Class
     *
     * @return array $response
     */
    public function storeClass(Request $request)
    {
        $response = ['status' => 'success', 'message' => __('The :x has been successfully saved.', ['x' => __('Shipping Class')])];

        try {
            (new ShippingClass())->store($request->data);
        } catch (\Exception $e) {
            $response = ['status' => 'fail', 'message' => $e->getMessage()];
        }

        return $response;
    }

    /**
     * Store Shipping Setting
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function storeSetting(Request $request)
    {
        $response = $this->messageArray(__('Invalid Request'), 'fail');
        $category = 'shipping_setting';
        $request['shipping_calculator_cart_page'] = isset($request->shipping_calculator_cart_page) ? 1 : 0;
        $request['hide_shipping_cost'] = isset($request->hide_shipping_cost) ? 1 : 0;

        $i = 0;
        foreach ($request->only(['shipping_calculator_cart_page', 'hide_shipping_cost', 'shipping_destination']) as $key => $value) {
            $data[$i]['category'] = $category;
            $data[$i]['field']    = $key;
            $data[$i]['value'] = $value;
            $i++;
        }
        foreach ($data as $key => $value) {
            if ((new Preference())->storeOrUpdate($value)) {
                $response = $this->messageArray(__('The :x has been successfully saved.', ['x' => __('Shipping setting')]), 'success');
            }
        }

        return $response;
    }
}
