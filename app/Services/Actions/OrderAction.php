<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md. Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 06-06-2022
 */

namespace App\Services\Actions;

use App\Models\{
    Address, OrderMeta, User
};
use App\Traits\ApiResponse;
use Modules\GeoLocale\Entities\Country;
use Modules\GeoLocale\Entities\Division;

class OrderAction
{
    use ApiResponse;

    /**
     * Order api relations for index and detail
     *
     * @return array
     */
    public function relationsWith()
    {
        return [
            'orderDetails:id,order_id,product_name,product_id,parent_id,vendor_id,quantity,is_delivery,price,tax_charge,shipping_charge,payloads,discount_amount,estimate_delivery',
            'paymentMethod:id,code,unique_code,gateway,payment_id,total,currency_code,status,created_at,updated_at',
            'couponRedeems:id,coupon_id,user_id,order_id,discount_amount',
            'statusHistories:id,order_id,order_status_id,product_id,user_id,created_at',
        ];
    }

    /**
     * Store Order Meta
     *
     * @param  int  $addressId
     * @param  int  $userId
     * @return bool
     */
    public function store($addressId, $userId, $orderId, $downloadData = [], $request = null)
    {
        $address = ! is_null($userId) ? Address::select('id', 'first_name', 'last_name', 'phone', 'email', 'city', 'state', 'zip', 'country', 'type_of_place', 'address_1', 'address_2', 'created_at', 'updated_at')->where('id', $addressId)->first()->toArray() : $addressId;
        $user = User::select(['id', 'name', 'email', 'phone', 'address'])->where('id', $userId)->first();

        $countryCode = $address['country'];
        $address['country'] = Country::getNameByCode($countryCode);
        $address['state'] = Division::getStateNameByCountryStateCode($countryCode, $address['state']);

        $billing = [];
        foreach ($address as $key => $value) {
            $billing['billing_address_' . $key] = $value;
        }

        $shipping = [
            'shipping_address_first_name' => isset($request->ship_different) && $request->ship_different == 'on' ? $request->shipping_address_first_name : $address['first_name'],
            'shipping_address_last_name' => isset($request->ship_different) && $request->ship_different == 'on' ? $request->shipping_address_last_name : $address['last_name'],
            'shipping_address_phone' => $address['phone'],
            'shipping_address_email' => $address['email'],
            'shipping_address_city' => isset($request->ship_different) && $request->ship_different == 'on' ? $request->shipping_address_city : $address['city'],
            'shipping_address_state' => isset($request->ship_different) && $request->ship_different == 'on' ? Division::getStateNameByCountryStateCode($request->shipping_address_country, $request->shipping_address_state) : Division::getStateNameByCountryStateCode($address['country'], $address['state']),
            'shipping_address_zip' => isset($request->ship_different) && $request->ship_different == 'on' ? $request->shipping_address_zip : $address['zip'],
            'shipping_address_country' => isset($request->ship_different) && $request->ship_different == 'on' ? Country::getNameByCode($request->shipping_address_country) : Country::getNameByCode($countryCode),
            'shipping_address_type_of_place' => isset($request->ship_different) && $request->ship_different == 'on' ? $request->shipping_address_type_of_place : $address['type_of_place'],
            'shipping_address_address_1' => isset($request->ship_different) && $request->ship_different == 'on' ? $request->shipping_address_address_1 : $address['address_1'],
            'shipping_address_address_2' => isset($request->ship_different) && $request->ship_different == 'on' ? $request->shipping_address_address_2 : $address['address_2'],
            'shipping_address_created_at' => ! empty($user) ? $user->created_at : now(),
            'shipping_address_updated_at' => ! empty($user) ? $user->updated_at : now(),
        ];

        $address = array_merge($billing, $shipping);

        $formatData = [];
        foreach ($address as $key => $value) {
            $formatData[] = [
                'order_id' => $orderId,
                'type' => 'string',
                'key' => $key,
                'value' => $value,
            ];
        }

        $formatData[] = [
            'order_id' => $orderId,
            'type' => 'string',
            'key' => 'track_code',
            'value' => strtoupper(\Str::random(10)),
        ];

        foreach ($request->all() as $key => $reqData) {

            if (str_contains($key, 'meta_')) {
                $reqData = xss_clean($reqData);
                $formatData[] = [
                    'order_id' => $orderId,
                    'type' => gettype($reqData),
                    'key' => $key,
                    'value' => is_array($reqData) ? json_encode($reqData) : $reqData,
                ];
            }
        }

        if (OrderMeta::upsert($formatData, ['order_id', 'key'])) {

            if (is_array($downloadData) && count($downloadData) > 0) {
                OrderMeta::updateOrCreate(
                    ['order_id' => $orderId, 'key' => 'download_data'],
                    ['type' => 'array', 'value' => $downloadData]
                );
            }

            return true;
        }

        return false;
    }

    /**
     * Get product image and url
     *
     * @param  object  $lineItem
     * @return array
     */
    public function getProductInfo($lineItem)
    {
        $data = ['image' => asset(defaultImage('products')), 'url' => 'javascript:void(0)'];
        if (! is_null($lineItem->parent_id)) {
            $product = $lineItem->parentProduct;
            if ($product && $lineItem->product) {
                if (is_array($lineItem->product->getImages(true, 'small'))) {
                    $data['image'] = $lineItem->product->getImages(true, 'small')[0];
                } else {
                    $data['image'] = $lineItem->product->getImages(true, 'small');
                }
            }
        } else {
            $product = $lineItem->product;
            if ($product) {
                $data['image'] = $product->getFeaturedImage('small');
            }
        }

        if (! is_null($product) && ! is_null($product->slug)) {
            $data['url'] = route('site.productDetails', ['slug' => $product->slug]);
        }

        return $data;
    }
}
