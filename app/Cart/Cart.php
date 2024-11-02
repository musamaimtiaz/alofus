<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 24-11-2021
 */

namespace App\Cart;

use App\Models\Product;
use Validator;
use Cache;
use Auth;

class Cart
{
    /**
     * Added product in cart
     *
     * @param  array  $data
     * @return bool
     */
    public static function add($data = [])
    {
        $validator = self::validate($data);

        if ($validator->fails()) {
            return false;
        }

        $cart = self::getCartData();

        if (! $cart) {
            $cart[$data['id']] = [
                'id' => $data['id'],
                'code' => $data['code'],
                'slug' => $data['slug'],
                'vendor_id' => $data['vendor_id'],
                'shop_id' => $data['shop_id'],
                'name' => $data['name'],
                'quantity' => (int) $data['is_individual_sale'] == 1 ? 1 : $data['quantity'],
                'price' => $data['price'],
                'actual_price' => $data['actual_price'],
                'photo' => $data['photo'],
                'parent_id' => $data['parent_id'],
                'parent_code' => $data['parent_code'],
                'parent_slug' => $data['parent_slug'],
                'variation_id' => $data['variation_id'],
                'variation_photo' => $data['variation_photo'],
                'variation_meta' => $data['variation_meta'],
                'type' => $data['type'],
                'is_individual_sale' => $data['is_individual_sale'],
            ];
            self::save($cart);
            self::destroyCoupon();

            return true;
        } elseif (isset($cart[$data['id']]['id']) && $cart[$data['id']]['id'] == $data['id']) {
            if ($cart[$data['id']]['is_individual_sale'] == 0) {
                $cart[$data['id']]['quantity'] = $cart[$data['id']]['quantity'] + $data['quantity'];
                self::save($cart);
            }

            return true;
        } else {
            $cart[$data['id']] = [
                'id' => $data['id'],
                'code' => $data['code'],
                'slug' => $data['slug'],
                'vendor_id' => $data['vendor_id'],
                'shop_id' => $data['shop_id'],
                'name' => $data['name'],
                'quantity' => $data['quantity'],
                'price' => $data['price'],
                'actual_price' => $data['actual_price'],
                'photo' => $data['photo'],
                'parent_id' => $data['parent_id'],
                'parent_code' => $data['parent_code'],
                'parent_slug' => $data['parent_slug'],
                'variation_id' => $data['variation_id'],
                'variation_photo' => $data['variation_photo'],
                'variation_meta' => $data['variation_meta'],
                'type' => $data['type'],
                'is_individual_sale' => $data['is_individual_sale'],
            ];
            self::save($cart);
            self::destroyCoupon();

            return true;
        }
    }

    /**
     * cart product decrement
     *
     * @return bool|void
     */
    public static function reduceQuantity($index)
    {
        $cart = self::getCartData();
        if (isset($cart[$index])) {
            if ($cart[$index]['quantity'] > 1) {
                $cart[$index]['quantity']--;
                self::save($cart);

                return true;
            }
        }
    }

    /**
     * return all cart product
     *
     * @return mixed
     */
    public static function getCartData()
    {
        return ! empty(self::userId()) ? Cache::get(config('cache.prefix') . '.cart.' . self::userId()) : Cache::get(config('cache.prefix') . '.cart.' . getUniqueAddress());
    }

    /**
     * return coupon data
     *
     * @return mixed
     */
    public static function getCouponData($calculateDataOnly = true)
    {
        $data = ! empty(self::userId()) ? Cache::get(config('cache.prefix') . '.coupon.' . self::userId()) : Cache::get(config('cache.prefix') . '.coupon.' . getUniqueAddress());

        if ($calculateDataOnly) {
            $data = collect($data);
            $calculatedDiscount = $data->sum(function ($data) {
                return $data['calculated_discount'];
            });

            return $calculatedDiscount;
        }

        return $data;
    }

    /**
     * check free shipping allow in coupon or not
     *
     * @return bool
     */
    public static function checkCouponFreeShipping()
    {
        $couponData = collect(self::getCouponData(false))->where('is_allow_free_shipping', true)->first();

        if (! empty($couponData)) {
            return true;
        }

        return false;
    }

    /**
     * cart product in collection
     *
     * @return CartCollection
     */
    public static function cartCollection()
    {
        return ! empty(self::userId()) ? new CartCollection(Cache::get(config('cache.prefix') . '.cart.' . self::userId())) : new CartCollection(Cache::get(config('cache.prefix') . '.cart.' . getUniqueAddress()));
    }

    /**
     * selected cart product in collection
     *
     * @return array
     */
    public static function selectedCartCollection()
    {
        $data = [];
        $cart = self::cartCollection();
        $selectedIndex = self::getSelected() ?? [];

        foreach ($cart as $key => $product) {
            if (in_array($key, $selectedIndex)) {
                $data[$key] = $product;
            }
        }

        return $data;
    }

    /**
     * selected cart product destroy
     *
     * @return CartCollection
     */
    public static function selectedCartProductDestroy()
    {
        $cart = self::cartCollection();
        $selectedIndex = self::getSelected() ?? [];

        foreach ($cart as $key => $product) {
            if (in_array($key, $selectedIndex)) {
                self::destroy($key);
            }
        }

        self::destroyCoupon();
        self::selectedDestroy();
    }

    /**
     * total product of cart
     *
     * @return int
     */
    public static function totalProduct()
    {
        $cart = self::cartCollection();

        return $cart->count();
    }

    /**
     * total quantity of cart
     *
     * @return int|mixed
     */
    public static function totalQuantity($action = 'all')
    {
        if ($action == 'selected') {
            $cart = new CartCollection(self::selectedCartCollection());
        } else {
            $cart = self::cartCollection();
        }

        if ($cart->isEmpty()) {
            return 0;
        }

        $count = $cart->sum(function ($cart) {
            return $cart['quantity'];
        });

        return $count;
    }

    /**
     * total price of cart
     *
     * two types "all" & "selected" if selected then calculate will be selected products
     *
     * @return float|int|mixed
     */
    public static function totalPrice($type = 'all')
    {
        $cart = self::cartCollection();
        $count = 0;

        if ($type == 'selected') {
            $selectedIndex = self::getSelected() ?? [];

            foreach ($cart as $key => $product) {
                if (in_array($key, $selectedIndex)) {
                    $count += $product['price'] * $product['quantity'];
                }
            }
        } else {
            if ($cart->isEmpty()) {
                return 0;
            }

            $count = $cart->sum(function ($cart) {
                return $cart['price'] * $cart['quantity'];
            });
        }

        return $count;
    }

    /**
     * validate cart product
     *
     * @param  array  $product
     * @return mixed
     */
    public static function validate($product = [])
    {
        $validator = Validator::make($product, [
            'id' => 'required',
            'code' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric|min:1',
            'name' => 'required',
        ]);

        return $validator;
    }

    /**
     * removes an product on cart by product ID
     *
     * @return bool
     */
    public static function destroy($index = null, $action = 'single')
    {
        if ($action == 'single') {
            $cart = self::getCartData();
            unset($cart[$index]);
            self::save($cart);
        } else {
            ! empty(self::userId()) ? Cache::forget(config('cache.prefix') . '.cart.' . self::userId()) : Cache::forget(config('cache.prefix') . '.cart.' . getUniqueAddress());
            self::destroyCoupon();
            self::selectedDestroy();
        }

        return true;
    }

    /**
     * removes coupon
     *
     * @return void
     */
    public static function destroyCoupon()
    {
        if (! empty(self::userId()) && ! empty(Cache::get(config('cache.prefix') . '.coupon.' . self::userId()))) {
            Cache::forget(config('cache.prefix') . '.coupon.' . self::userId());
        } elseif (! empty(Cache::get(config('cache.prefix') . '.coupon.' . getUniqueAddress()))) {
            Cache::forget(config('cache.prefix') . '.coupon.' . getUniqueAddress());
        }
    }

    /**
     * save the cart
     *
     * @return void
     */
    protected static function save($cart)
    {
        if (! empty(self::userId())) {
            Cache::put(config('cache.prefix') . '.cart.' . self::userId(), $cart, 30 * 86400);
        } else {
            Cache::put(config('cache.prefix') . '.cart.' . getUniqueAddress(), $cart, 30 * 86400);
        }
    }

    /**
     * coupon save
     *
     * @return bool
     */
    public static function couponSave($data)
    {
        $coupon = self::getCouponData(false);
        $coupon[$data['id']] = [
            'id' => $data['id'],
            'code' => $data['code'],
            'discount_type' => $data['discount_type'],
            'discount_amount' => $data['discount_amount'],
            'calculated_discount' => $data['calculated_discount'],
            'is_allow_free_shipping' => $data['is_allow_free_shipping'],
        ];
        self::multipleCouponStore($coupon);

        return true;
    }

    /**
     * save multiple coupon
     *
     * @return void
     */
    public static function multipleCouponStore($data)
    {
        if (! empty(self::userId())) {
            Cache::put(config('cache.prefix') . '.coupon.' . self::userId(), $data, 30 * 86400);
        } else {
            Cache::put(config('cache.prefix') . '.coupon.' . getUniqueAddress(), $data, 30 * 86400);
        }
    }

    /**
     * check existing coupon
     *
     * @return bool
     */
    public static function checkExistsCoupon($id = null)
    {
        $coupon = self::getCouponData(false);

        if (isset($coupon[$id])) {
            return true;
        }

        return false;
    }

    /**
     * check existing coupon
     *
     * @return bool
     */
    public static function deleteSelectedCoupon($index = null)
    {
        $coupon = self::getCouponData(false);

        if (isset($coupon[$index])) {
            unset($coupon[$index]);
            self::multipleCouponStore($coupon);

            return true;
        }

        return false;
    }

    /**
     * product selected
     *
     * @return void
     */
    public static function selectedStore($data = [], $action = 'destroyCoupon')
    {
        if (! empty(self::userId())) {
            Cache::put(config('cache.prefix') . '.selected.' . self::userId(), $data, 30 * 86400);
        } else {
            Cache::put(config('cache.prefix') . '.selected.' . getUniqueAddress(), $data, 30 * 86400);
        }

        if ($action == 'destroyCoupon') {
            self::destroyCoupon();
        }
    }

    /**
     * get selected product
     *
     * @return mixed
     */
    public static function getSelected()
    {
        return ! empty(self::userId()) ? Cache::get(config('cache.prefix') . '.selected.' . self::userId()) : Cache::get(config('cache.prefix') . '.selected.' . getUniqueAddress());
    }

    /**
     * product selected destroy
     *
     * @return void
     */
    public static function selectedDestroy()
    {
        if (! empty(self::userId()) && ! empty(Cache::get(config('cache.prefix') . '.selected.' . self::userId()))) {
            Cache::forget(config('cache.prefix') . '.selected.' . self::userId());
        } elseif (! empty(Cache::get(config('cache.prefix') . '.selected.' . getUniqueAddress()))) {
            Cache::forget(config('cache.prefix') . '.selected.' . getUniqueAddress());
        }
    }

    /**
     * cart data transfer local to user
     *
     * @return void
     */
    public static function cartDataTransfer()
    {
        if (! empty(self::userId()) && empty(Cache::get(config('cache.prefix') . '.cart.' . self::userId()))) {
            if (! empty(Cache::get(config('cache.prefix') . '.cart.' . getUniqueAddress()))) {
                Cache::put(config('cache.prefix') . '.cart.' . self::userId(), Cache::get(config('cache.prefix') . '.cart.' . getUniqueAddress()), 30 * 86400);
                if (! empty(Cache::get(config('cache.prefix') . '.selected.' . getUniqueAddress()))) {
                    Cache::put(config('cache.prefix') . '.selected.' . self::userId(), Cache::get(config('cache.prefix') . '.selected.' . getUniqueAddress()), 30 * 86400);
                }
            }
        } elseif (! empty(self::userId()) && ! empty(Cache::get(config('cache.prefix') . '.cart.' . self::userId())) && ! empty(Cache::get(config('cache.prefix') . '.cart.' . getUniqueAddress()))) {
            $authUserCarts = Cache::get(config('cache.prefix') . '.cart.' . self::userId());
            $browserCarts = Cache::get(config('cache.prefix') . '.cart.' . getUniqueAddress());

            foreach ($browserCarts as $key => $cart) {
                $unique = [
                    'id' => $cart['id'],
                    'optionId' => isset($cart['option_id']) ? json_decode($cart['option_id']) : null,
                    'option' => isset($cart['option']) ? json_decode($cart['option']) : null,
                ];
                if (self::authCartsSearch($unique, $authUserCarts) == false) {
                    self::add($cart);
                }
            }

            Cache::forget(config('cache.prefix') . '.cart.' . getUniqueAddress());
            Cache::forget(config('cache.prefix') . '.selected.' . getUniqueAddress());
            Cache::put(config('cache.prefix') . '.cart.' . getUniqueAddress(), Cache::get(config('cache.prefix') . '.cart.' . self::userId()), 30 * 86400);
        }
    }

    /**
     * search & match existing value between user & browser
     *
     * @return bool
     */
    public static function authCartsSearch($existsValue, $authCarts)
    {
        foreach ($authCarts as $cart) {
            $option = isset($cart['option']) ? json_decode($cart['option']) : null;
            $optionId = isset($cart['option_id']) ? json_decode($cart['option_id']) : null;

            if ($cart['id'] == $existsValue['id']) {
                if ($option != null && $optionId != null && $existsValue['option'] != null && $existsValue['optionId'] != null) {
                    if (count(array_diff($existsValue['optionId'], $optionId)) == 0 && count(array_diff($optionId, $existsValue['optionId'])) == 0 && count(array_diff($option, $existsValue['option'])) == 0 && count(array_diff($existsValue['option'], $option)) == 0) {
                        return true;
                    }
                } elseif ($option == null && $optionId == null && $existsValue['option'] == null && $existsValue['optionId'] == null) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * get user id
     *
     * @return null|int $userId
     */
    public static function userId()
    {
        $userId = null;

        if (isset(Auth::user()->id)) {
            $userId = Auth::user()->id;
        } elseif (isset(auth()->guard('api')->user()->id)) {
            $userId = auth()->guard('api')->user()->id;
        } elseif (isset(request()->user_id)) {
            $userId = request()->user_id;
        }

        return $userId;
    }

    /**
     * check cart data
     *
     * @return void
     */
    public static function checkCartData()
    {
        $cartKey = [];
        $data = self::getCartData() ?? [];
        $selectedIndex = self::getSelected() ?? [];
        $itemPrice = 0;

        foreach ($data as $key => $cartData) {
            $item = Product::where('id', $cartData['id'])->published()->first();

            if (!empty($item)) {
                $itemPrice = $item->offerCheck() ? $item->sale_price : $item->regular_price;

                if (isActive('B2B')) {
                    $itemPrice = (new \Modules\B2B\Service\B2BService())->getItemPrice($item, $itemPrice, $cartData['quantity']);
                }
            }

            if (empty($item)) {
                self::destroy($key);
                unset($data[$key]);

                continue;
            } elseif (! isset($item->vendor) || $itemPrice != $cartData['price'] || $item->vendor_id != $cartData['vendor_id']) {

                if ($item->type == 'Variation') {
                    $data[$item->id]['vendor_id'] = ! isset($item->parentDetail->vendor) ? null : $item->parentDetail->vendor_id;
                } else {
                    $data[$item->id]['vendor_id'] = ! isset($item->vendor) ? null : $item->vendor_id;
                }

                $data[$item->id]['price'] = $itemPrice != $cartData['price'] ? $itemPrice : $cartData['price'];
            }

            if (! empty($item) && ! empty($item->available_from) && availableFrom($item->available_from) || ! empty($item) && empty($item->available_from)) {
                if (! empty($item->available_to) && availableTo($item->available_to) || empty($item->available_to)) {
                    if (in_array($key, $selectedIndex) || isset(request()->select) && request()->select == 'all') {
                        $cartKey[] = $key;
                    }
                }
            }
        }

        self::save($data);
        self::selectedStore($cartKey, null);
    }

    /**
     * update specific cart data
     *
     * @return void
     */
    public static function updateCartProperty($productId = null, $property = null, $value = null)
    {
        $cart = self::getCartData() ?? [];

        if (isset($cart[$productId]) && isset($cart[$productId][$property])) {
            $cart[$productId][$property] = $value;
        }

        self::save($cart);
    }
}
