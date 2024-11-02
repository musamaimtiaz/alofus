<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 11-24-2021
 */

namespace App\Services\Product;

use App\Http\Resources\ProductDetailResource;
use App\Models\Product;
use App\Models\Vendor;
use App\Services\Actions\Facades\ProductActionFacade as ProductAction;
use Cart;
use Cache;

class AddToCartService
{
    public static $instance;

    protected $shippingMethod = [];

    protected $itemizedTax = [];

    protected $withOutTaxInShipping = [];

    /**
     * use for b2b instance
     */
    private $b2bSerive;

    /**
     * CartController Constructor
     *
     * @return void
     */
    public function __construct()
    {
        if (isActive('B2B')) {
            $this->b2bSerive = new \Modules\B2B\Service\B2BService();
        }
    }

    /**
     * get object
     *
     * @return AddToCartService
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new AddToCartService();
        }

        return self::$instance;
    }

    /**
     * add cart data
     *
     * @return array
     */
    public function add($request)
    {
       // return $request->all();
        $response['status'] = 0;
        $response['message'] = __('Failed to added to cart! try again.');
        $product = ProductAction::execute('getProductWithAttributeAndVariations', $request);
        $data = (new ProductDetailResource($product))->toArray(null);
        $variation = null;
        $variationPhoto = null;
        $image = $product->getFeaturedImage('small');

        if ($product->isVariableProduct()) {
            $variation = $data['variations']->where('id', $request->variation_id)->first();
            $variationPhoto = $variation->getImages(false, 'small')['url'] ?? $variation->getFeaturedImage('small');
        }

        if (! $product->availability() && $product->status == 'Published' || $product->isExternalProduct() || $product->isGroupedProduct()) {
            return $response;
        }

        $salePrice = $product->isVariableProduct() ? $variation->sale_price : $product->sale_price;
        $saleTo = $product->isVariableProduct() ? $variation->sale_to : $data['sale_to'];
        $regularPrice = $product->isVariableProduct() ? $variation->regular_price : $product->regular_price;
        $isManageStock = $product->isVariableProduct() ? $variation->isStockManageable() : $product->isStockManageable();
        $totalStock = $product->isVariableProduct() ? $variation->getStockQuantity() : $product->getStockQuantity();
        $backOrder = $product->isVariableProduct() ? $variation->meta_backorder : $product->meta_backorder;

        if ($isManageStock == 0 && $product->isVariableProduct()) {
            $isManageStock = $product->isStockManageable();
            $totalStock = $product->getStockQuantity();
            $backOrder = $product->meta_backorder;
        }

        if ($isManageStock == 1 && $request->qty > $totalStock && $backOrder == 0 || $isManageStock == 1 && $this->existQty($totalStock, $request->qty, $product->isVariableProduct() ? $variation->id : $data['id']) && $backOrder == 0 || $isManageStock == 0 && $data['stock_status'] == 'Out Of Stock') {
            $response['message'] =  __('Stock is not available.');

            return $response;
        }

        $offerFlag = $product->isVariableProduct() ? $variation->offerCheck() : $product->offerCheck();
        $price = $offerFlag ? $salePrice : $regularPrice;
        $cartOldPrice = $price;

        if (isActive('B2B')) {
            $b2bPrice = $this->b2bSerive->addToCartCustomization($product, $variation, $price);
            $price = $b2bPrice['price'];
            $cartOldPrice = $b2bPrice['cartOldPrice'];
        }

        // return $product;
         $add = Cart::add(
            [
                'id' => $product->isVariableProduct() ? $variation->id : $data['id'],
                'code' => $product->isVariableProduct() ? $variation->code : $data['code'],
                'slug' => $data['slug'],
                'vendor_id' => isset($product->vendor) ? $data['vendor_id'] : null,
                'shop_id' => $data['shop_id'],
                'name' => $data['name'],
                'quantity' => $request->qty ?? 1,
                'price' => $price,
                'actual_price' => $regularPrice,
                'photo' => $product->isVariableProduct() ? $variationPhoto : $image,
                'parent_id' => $product->isVariableProduct() ? $variation->parent_id : null,
                'parent_code' => $product->isVariableProduct() ? $data['code'] : null,
                'parent_slug' => $product->isVariableProduct() ? $data['slug'] : null,
                'variation_id' => $request->variation_id,
                'variation_photo' => $product->isVariableProduct() ? $variationPhoto : [],
                'variation_meta' => $product->isVariableProduct() ? $this->getAttributeWithValue($variation, $product->getVariationAttributes(), $data['attribute_values']) : [],
                'type' => $data['type'],
                'is_individual_sale' => isset($data['meta']['individual_sale']) ? $data['meta']['individual_sale'] : 0,
            ]
        );


        if ($add) {
            $response = [
                'status' => 1,
                'message' => __('Product successfully added to your cart.'),
                'totalProduct' => Cart::totalProduct(),
                'totalPrice' => Cart::totalPrice(),
                'carts' => Cart::cartCollection(),
                'b2bPriceActive' => isActive('B2B') && $this->b2bSerive->isB2BPriceActive($product, $variation, $cartOldPrice),
            ];
        }

        return $response;
    }

    /**
     * get attribute name with value
     *
     * @return false|string
     */
    protected function getAttributeWithValue($variation, $attributes, $attributesValue)
    {
        $variationAttributes = [];
        foreach ($variation->attributes as $key => $varAtr) {
            $details = null;

            if (isset($attributesValue[str_replace('attribute_', '', $key)])) {
                $details = $attributesValue[str_replace('attribute_', '', $key)]->where('id', $varAtr)->first();
            }

            $key = $attributes[str_replace('attribute_', '', $key)]['name'] ?? null;

            if (isset($key)) {
                $variationAttributes[$key] = isset($details) ? $details->value : $varAtr;
            }
        }

        return json_encode($variationAttributes);
    }

    /**
     * check request qty with totalStock
     *
     * @return bool
     */
    protected function existQty($totalStock, $reqQty, $productId)
    {
        $data = Cart::cartCollection()->where('id', $productId)->first();

        if (! empty($data)) {
            $reqQty = $data['quantity'] + $reqQty;
        }

        if ($reqQty > $totalStock) {
            return true;
        }

        return false;
    }

    /**
     * delete specific cart data
     *
     * @return array
     */
    public function delete($request)
    {
        $response['status'] = 0;
        $response['message'] = __('Something went wrong, please try again.');

        if (Cart::destroy($request->cartIndex)) {
            $response = [
                'status' => 1,
                'message' => __('Deleted Successfully'),
                'totalProduct' => Cart::totalProduct(),
                'totalPrice' => Cart::totalPrice(),
                'carts' => Cart::cartCollection(),
            ];
        }

        return $response;
    }

    /**
     * cart list
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function cartList()
    {
        Cart::checkCartData();
        $data['vendors'] = Vendor::getAll()->where('status', 'Active')->pluck('name', 'id');
        $this->destroySessionAddress();

        if (isActive('Shop')) {
            $data['shops'] = \Modules\Shop\Http\Models\Shop::getAll()->where('status', 'Active')->pluck('name', 'id');
        }

        $cartWithIndex = [];
        $selectedCarts = Cart::getSelected() ?? [];
        $cartsValue = Cart::cartCollection()->sortKeys();
        $totalPrice = 0;
        $selectAllDisable = false;
        foreach ($cartsValue as $key => $val) {
            $shipping = 0;
            $tax = 0;
            $totalPrice += in_array($key, $selectedCarts) ? $val['price'] : 0;
            $product = Product::select('id', 'available_from', 'available_to', 'status', 'manage_stocks', 'total_stocks', 'shop_id', 'sale_to', 'sale_price', 'regular_price', 'type', 'parent_id')->where('id', $val['id'])->with('parentDetail:id')->first();

            if (empty($product)) {
                Cart::destroy($key);

                continue;
            }

            $availability = 0;
            $inventoryEnable = true;

            if (! empty($product->available_from) && availableFrom($product->available_from) || empty($product->available_from)) {
                if (! empty($product->available_to) && availableTo($product->available_to) || empty($product->available_to)) {
                    if ($product->status == 'Published') {
                        $availability = 1;
                    }
                }
            }

            if ($product->manage_stocks == 1 && $product->meta_backorder == 0) {
                $inventoryEnable = $this->isQtyAvailable($product->total_stocks, $val['quantity']);
            }

            if ($inventoryEnable == false || $availability == 0) {
                if ($selectAllDisable == false) {
                    $selectAllDisable = true;
                }
            }

            $offerFlag = $product->offerCheck();
            $cartWithIndex[] = [
                'index' => $key,
                'id' => $val['id'],
                'code' => $val['code'],
                'slug' => $val['slug'],
                'vendor_id' => $val['vendor_id'],
                'shop_id' => $val['shop_id'],
                'name' => $val['name'],
                'quantity' => $val['quantity'],
                'price' => $val['price'],
                'actual_price' => $val['actual_price'],
                'photo' => $val['photo'],
                'parent_id' => $val['parent_id'],
                'parent_code' => $val['parent_code'],
                'parent_slug' => $val['parent_slug'],
                'variation_id' => $val['variation_id'],
                'variation_photo' => $val['variation_photo'],
                'variation_meta' => $val['variation_meta'],
                'type' => $val['type'],
                'availability' => $availability,
                'inventoryEnable' => $inventoryEnable,
                'tax_rate' => $offerFlag ? $product->priceWithTax('including tax', 'sale', false, true) * $val['quantity'] : $product->priceWithTax('including tax', 'regular', false, true) * $val['quantity'],
                'shipping' => 0,
                'is_individual_sale' => $val['is_individual_sale'],
                'estimated_delivery' => $product->type == 'Variation' ? $product->parentDetail->estimated_delivery : $product->estimated_delivery,
            ];
        }
        $data['cartData'] = collect($cartWithIndex);
        $data['selectedCarts'] = $selectedCarts;
        $data['selectAllDisable'] = $selectAllDisable;

        if (isActive('Coupon')) {
            $data['coupon'] = Cart::getCouponData();
        }

        $data['totalPrice'] = $totalPrice;

        if (request()->route()->getPrefix() == 'api/user') {
            return $data;
        }

        return view('site.cart.index', $data);
    }

    /**
     * merge & addition shipping method
     *
     * @param  $data
     * @return array
     */
    public function mergeShippingMethod($zoneCost)
    {
        $data = $this->shippingMethod;
        $this->shippingMethod = [];
        $methodCost = 0;
        $calculationType = 'class';
        $flagOnce = true;
        $localOnce = true;
        $maxZoneCost = collect($zoneCost)->max();

        if (is_array($data) && count($data) > 0) {
            foreach ($data as $key => $shippings) {
                foreach ($shippings as $shipping) {
                    if ($shipping['shipping_id'] == 3) {

                        if ($flagOnce == true || $shipping['method_cost_type'] == 'cost_per_quantity') {
                            $flagOnce = false;
                            $methodCost = $shipping['method_cost'];
                            $calculationType = $shipping['calculation_type'];
                        } else {
                            $methodCost = 0;
                        }
                        if ($calculationType == 'order') {
                            if ($shipping['method_cost_type'] == 'cost_per_quantity') {
                                $this->shippingMethod[$shipping['title']] = isset($this->shippingMethod[$shipping['title']]) ? $this->shippingMethod[$shipping['title']] + $methodCost + $maxZoneCost : $methodCost + $maxZoneCost;
                                $maxZoneCost = 0;
                            } else {
                                ! isset($this->shippingMethod[$shipping['title']]) ? $this->shippingMethod[$shipping['title']] = $methodCost + $maxZoneCost : '';
                            }
                        } else {
                            $this->shippingMethod[$shipping['title']] = isset($this->shippingMethod[$shipping['title']]) ? $this->shippingMethod[$shipping['title']] + $methodCost + $shipping['zone_cost'] : $methodCost + $shipping['zone_cost'];
                        }

                    } else {
                        if ($localOnce == true && $shipping['method_cost_type'] == 'percent_sub_total_item_price' && $shipping['shipping_id'] == 2) {
                            $localOnce = false;
                            $this->shippingMethod[$shipping['title']] = isset($this->shippingMethod[$shipping['title']]) ? $this->shippingMethod[$shipping['title']] + $shipping['method_cost'] : $shipping['method_cost'];
                        } elseif ($shipping['method_cost_type'] != 'percent_sub_total_item_price' || $shipping['shipping_id'] == 1) {
                            if ($shipping['shipping_id'] == 2 && $shipping['method_cost_type'] == 'cost_per_order') {
                                $this->shippingMethod[$shipping['title']] = $shipping['method_cost'];
                            } else {
                                $this->shippingMethod[$shipping['title']] = isset($this->shippingMethod[$shipping['title']]) ? $this->shippingMethod[$shipping['title']] + $shipping['method_cost'] + $shipping['zone_cost'] : $shipping['method_cost'] + $shipping['zone_cost'];
                            }
                        }
                    }

                    if ($shipping['tax_status'] != 'taxable' && ! isset($this->withOutTaxInShipping[$shipping['title']])) {
                        $this->withOutTaxInShipping[] = $shipping['title'];
                    }
                }
            }
        } else {
            $this->shippingMethod = [];
        }

        return $this->shippingMethod = array_reverse($this->shippingMethod);
    }

    /**
     * check quantity available or not
     *
     * @return bool
     */
    protected function isQtyAvailable($totalStock, $qty)
    {
        if ($qty > $totalStock) {
            return false;
        }

        return true;
    }

    /**
     * select index & add from cart list
     *
     * @return array
     */
    public function addSelected($request)
    {
        $response['status'] = 0;
        $response['message'] = __('Something went wrong, please try again.');
        Cart::selectedStore($request->code);
        $taxShipping = $this->getTaxShipping();
        $response = [
            'status' => 1,
            'shipping' => $taxShipping['shipping'],
            'tax' => $taxShipping['tax'],
            'totalPrice' => Cart::totalPrice('selected'),
            'shippingIndex' => $this->getShippingIndex(),
            'displayTax' => preference('display_tax_totals'),
            'message' => __('Saved Successfully.'),
        ];

        return $response;
    }

    /**
     * get tax shipping
     *
     * @return array
     */
    public function getTaxShipping($address = null, $from = null, $isSessionAble = false)
    {
        $cartsValue = Cart::selectedCartCollection();
        $tax = 0;
        $displayTaxTotal = $from == null ? preference('display_tax_totals') : '';
        $zoneCost = [];
        $GLOBALS['shipping_slug'] = [];

        if ($isSessionAble) {
            $this->setSessionAddressData($address);
        }

        $sessionAddress = $this->getSessionAddress();
        if (! is_null($sessionAddress)) {
            $address = $sessionAddress;
        }

        foreach ($cartsValue as $val) {
            $product = Product::select('id', 'available_from', 'available_to', 'status', 'manage_stocks', 'total_stocks', 'shop_id', 'sale_to', 'sale_price', 'regular_price', 'sale_from', 'type')->where('id', $val['id'])->first();
            $shipping = $product->shipping(['qty' => $val['quantity'], 'price' => $val['price'], 'address' => $address]);
            $this->shippingMethod[] = $shipping;
            $shippingCollection = collect($shipping);
            $flatRate = $shippingCollection->where('shipping_id', 3)->first();
            ! empty($flatRate) && count($flatRate) > 0 ? $zoneCost[] = $flatRate['zone_cost'] : '';
        }

        $this->mergeShippingMethod($zoneCost);
        $data = $this->getSelectedShippingAmount($this->shippingMethod);
        $shipCharge = isset($data['singleData']) && ! in_array($data['key'], $this->withOutTaxInShipping) ? $data['singleData'] : null;

        foreach ($cartsValue as $val) {
            $product = Product::select('id', 'available_from', 'available_to', 'status', 'manage_stocks', 'total_stocks', 'shop_id', 'sale_to', 'sale_price', 'regular_price', 'sale_from')->where('id', $val['id'])->first();
            $offerFlag = $product->offerCheck();

            if ($displayTaxTotal == 'itemized') {
                $itemizedTax = $offerFlag ? $product->priceWithTax('including tax', 'sale', false, false, true, $address, $shipCharge, ['qty' => $val['quantity'], 'cart_price' => $val['price']]) : $product->priceWithTax('including tax', 'regular', false, false, true, $address, $shipCharge, ['qty' => $val['quantity'], 'cart_price' => $val['price']]);
                $tax = $this->mergeProductizedTax($itemizedTax);
            } else {
                $tax += $offerFlag ? $product->priceWithTax('including tax', 'sale', false, true, false, $address, $shipCharge, ['qty' => $val['quantity'], 'cart_price' => $val['price']]) : $product->priceWithTax('including tax', 'regular', false, true, false, $address, $shipCharge, ['qty' => $val['quantity'], 'cart_price' => $val['price']]);
            }
        }

        return [
            'tax' => $tax,
            'displayTaxTotal' => $displayTaxTotal,
            'shipping' => $from == 'order' ? $data['singleData'] : $this->shippingMethod,
            'key' => $data['key'],
        ];
    }

    /**
     * merge & addition tax rates
     *
     * @return array
     */
    public function mergeProductizedTax($data = [])
    {
        if (is_array($this->itemizedTax) && count($this->itemizedTax) > 0 && is_array($data)) {
            foreach ($data as $key => $tax) {

                if ($tax > 0) {
                    $this->itemizedTax[$key] = isset($this->itemizedTax[$key]) ? $this->itemizedTax[$key] + $tax : $tax;
                }
            }
        } elseif (is_array($data)) {
            foreach ($data as $key => $tax) {

                if ($tax > 0) {
                    $this->itemizedTax[$key] = $tax;
                }
            }
        }

        return $this->itemizedTax;
    }

    /**
     * get select shipping
     *
     * @return array
     */
    public function getSelectedShippingAmount($data = [])
    {
        $key = $singleData = null;

        if (is_array($data) && count($data) > 0) {
            $key = array_keys($data)[$this->getShippingIndex() ?? 0] ?? 0;
            $singleData = $data[$key];
        }

        return [
            'key' => $key,
            'singleData' => $singleData,
        ];
    }

    /**
     * delete specific selected data
     *
     * @return array
     */
    public function deleteSelected($request)
    {
        $response['status'] = 0;
        $response['message'] = __('Something went wrong, please try again.');
        foreach ($request->code as $index) {
            Cart::destroy($index);
        }
        $response = [
            'status' => 1,
            'message' => __('Deleted Successfully'),
            'totalProduct' => Cart::totalProduct(),
            'totalPrice' => Cart::totalPrice(),
            'carts' => Cart::cartCollection(),
        ];

        return $response;
    }

    /**
     * delete all selected cart data
     *
     * @return array
     */
    public function deleteAll($request)
    {
        $response['status'] = 0;
        $response['message'] = __('Something went wrong, please try again.');

        if (Cart::destroy(null, 'all')) {
            $response = [
                'status' => 1,
                'message' => __('Deleted Successfully'),
                'totalProduct' => Cart::totalProduct(),
                'totalPrice' => Cart::totalPrice(),
                'carts' => Cart::cartCollection(),
            ];
        }

        return $response;
    }

    /**
     * reduce cart quantity
     *
     * @return array
     */
    public function decrement($request)
    {
        $response['status'] = 0;
        $response['message'] = __('Something went wrong, please try again.');

        if (Cart::reduceQuantity($request->cartIndex)) {
            $response = [
                'status' => 1,
                'message' => __('Saved Successfully'),
                'totalProduct' => Cart::totalProduct(),
                'totalPrice' => Cart::totalPrice(),
                'carts' => Cart::cartCollection(),
                'b2bPriceActive' => isActive('B2B') && $this->b2bSerive->isB2BPriceApply($request->cartIndex),
            ];
        }

        return $response;
    }

    /**
     * check coupon
     *
     * @return array
     */
    public function checkCoupon($request)
    {
        $response['status'] = 0;
        if (isActive('Coupon')) {
            if (! empty(Cart::getSelected())) {
                $coupon = \Modules\Coupon\Http\Models\Coupon::isValid($request->discount_code);
                if ($coupon['status'] == true) {
                    $couponProduct = \Modules\Coupon\Http\Models\ProductCoupon::where('coupon_id', $coupon['data']->id)->pluck('product_id')->toArray();
                    $validCouponWithAmount = $this->couponAmount($coupon['data'], $couponProduct);
                    if ($validCouponWithAmount['status'] == 1) {
                        if (! Cart::checkExistsCoupon($validCouponWithAmount['id'])) {
                            $data = [
                                'id' => $validCouponWithAmount['id'],
                                'code' => $validCouponWithAmount['code'],
                                'discount_type' =>  $validCouponWithAmount['discount_type'],
                                'discount_amount' =>  $validCouponWithAmount['discount_amount'],
                                'calculated_discount' => $validCouponWithAmount['calculated_discount'],
                                'is_allow_free_shipping' => $validCouponWithAmount['is_allow_free_shipping'],
                            ];
                            Cart::couponSave($data);
                            $this->destroyShippingIndex();
                            $taxShipping = $this->getTaxShipping();
                            $response = [
                                'status' => 1,
                                'data' => Cart::getCouponData(false),
                                'shipping' => $taxShipping['shipping'],
                                'tax' => $taxShipping['tax'],
                                'shippingIndex' => $this->getShippingIndex(),
                                'displayTax' => preference('display_tax_totals'),
                                'totalPrice' => Cart::totalPrice('selected'),
                            ];

                            return $response;
                        } else {
                            $response['message'] = __('This coupon has already been applied.');

                            return $response;
                        }

                    } else {
                        $response['message'] = $validCouponWithAmount['message'];

                        return $response;
                    }
                }
                $response['message'] = $coupon['message'];

                return $response;
            } else {
                $response['message'] = __('Select a product first!');
            }
        } else {
            $response['message'] = __('Errors');
        }

        return $response;
    }

    /**
     * get coupon amount
     *
     * @return array
     */
    public function couponAmount($coupon = [], $couponProduct = null)
    {
        $selectedCart = collect(Cart::selectedCartCollection());
        $invalidResponse = ['status' => 0, 'message' => __('Invalid :x', ['x' => __('Coupon')])];
        $totalPrice = 0;

        if (! empty($coupon->vendor_id)) {
            if (count($couponProduct) > 0) {
                $cartFilter = $selectedCart->where('vendor_id', $coupon['vendor_id'])->whereIn('id', $couponProduct)->all();
            } else {
                $cartFilter = $selectedCart->where('vendor_id', $coupon['vendor_id'])->all();
            }
            if (! empty($cartFilter)) {
                $totalPrice = $this->filterTotalPrice($cartFilter);
            } else {
                return $invalidResponse;
            }
        } elseif (empty($coupon->vendor_id) && is_array($couponProduct) && count($couponProduct) > 0) {
            $cartFilter = $selectedCart->whereIn('id', $couponProduct)->all();
            if (! empty($cartFilter)) {
                $totalPrice = $this->filterTotalPrice($cartFilter);
            } else {
                return $invalidResponse;
            }
        } else {
            $cartFilter = $selectedCart->all();
            if (! empty($cartFilter)) {
                $totalPrice = $this->filterTotalPrice($cartFilter);
            } else {
                return $invalidResponse;
            }
        }

        if ($coupon['usage_limit'] > $coupon['usage_count'] || is_null($coupon['usage_limit'])) {
            if ($totalPrice >= $coupon['minimum_spend'] || is_null($coupon['minimum_spend'])) {
                $discountPrice = 0;
                if ($coupon['discount_type'] == 'Percentage') {
                    $discountPrice = ($totalPrice * $coupon['discount_amount']) / 100;
                    if (! is_null($coupon['maximum_discount_amount']) && $discountPrice > $coupon['maximum_discount_amount']) {
                        $discountPrice = $coupon['maximum_discount_amount'];
                    }
                } else {
                    $discountPrice = min($totalPrice, $coupon['discount_amount']);
                }

                return [
                    'status' => 1,
                    'id' => $coupon['id'],
                    'code' => $coupon['code'],
                    'discount_type' => $coupon['discount_type'],
                    'discount_amount' => $coupon['discount_amount'],
                    'is_allow_free_shipping' => $coupon->getAllowFreeShippingAttribute(),
                    'calculated_discount' => $discountPrice,
                ];
            } else {
                return [
                    'status' => 0,
                    'message' => __('You have to spend more :x to avail this coupon.', ['x' => formatNumber(abs($coupon['minimum_spend'] - $totalPrice))]),
                ];
            }
        } else {
            return [
                'status' => 0,
                'message' => __('Coupon usage limit has been reached.'),
            ];
        }
    }

    /**
     * get totalPrice
     *
     * @return mixed
     */
    protected function filterTotalPrice($data = null)
    {
        $cartFilterCollect = collect($data);
        $totalPrice = $cartFilterCollect->sum(function ($cartFilterCollect) {
            return $cartFilterCollect['price'] * $cartFilterCollect['quantity'];
        });

        return $totalPrice;
    }

    /**
     * select shipping
     *
     * @return array
     */
    public function selectShipping($request)
    {
        $response['status'] = 0;
        $response['message'] = __('Something went wrong, please try again.');

        if (request()->route()->getPrefix() == 'api/user') {
            Cache::put(config('cache.prefix') . '.shippingIndex.' . getUniqueAddress(), $request->code, 30 * 86400);
        } else {
            $request->session()->put('shippingIndex', $request->code);
        }

        $taxShipping = $this->getTaxShipping();
        $response = [
            'status' => 1,
            'shipping' => $taxShipping['shipping'],
            'tax' => $taxShipping['tax'],
            'totalPrice' => Cart::totalPrice('selected'),
            'shippingIndex' => $this->getShippingIndex(),
            'displayTax' => $taxShipping['displayTaxTotal'],
            'message' => __('Saved Successfully.'),
        ];

        return $response;
    }

    /**
     * @return int|mixed
     */
    public function getShippingIndex()
    {
        if (request()->route()->getPrefix() == 'api/user') {
            return Cache::get(config('cache.prefix') . '.shippingIndex.' . getUniqueAddress());
        } else {
            return request()->session()->has('shippingIndex') ? request()->session()->get('shippingIndex') : 0;
        }
    }

    /**
     * @return int|null
     */
    public function destroyShippingIndex()
    {
        if (request()->route()->getPrefix() == 'api/user') {
            return Cache::forget(config('cache.prefix') . '.shippingIndex.' . getUniqueAddress());
        } else {
            return request()->session()->has('shippingIndex') ? request()->session()->forget('shippingIndex') : 0;
        }
    }

    /**
     * delete coupon
     *
     * @return array
     */
    public function deleteCoupon($request)
    {
        $response['status'] = 0;
        $response['message'] = __('Something went wrong, please try again.');

        if (Cart::deleteSelectedCoupon($request->index)) {
            $taxShipping = $this->getTaxShipping();
            $this->destroyShippingIndex();
            $response = [
                'status' => 1,
                'message' => __('The :x has been successfully deleted.', ['x' => __('Coupon')]),
                'totalProduct' => Cart::totalProduct(),
                'totalPrice' => Cart::totalPrice('selected'),
                'carts' => Cart::cartCollection(),
                'coupon_amount' => Cart::getCouponData(),
                'shipping' => $taxShipping['shipping'],
                'tax' => $taxShipping['tax'],
                'shippingIndex' => $this->getShippingIndex(),
                'displayTax' => preference('display_tax_totals'),
            ];

            return (array) $response;
        }

        return $response;
    }

    /**
     * set address in session
     *
     * @return void
     */
    public function setSessionAddressData($data = null)
    {
        if (request()->route()->getPrefix() == 'api/user') {
            Cache::put(config('cache.prefix') . '.address-data.' . getUniqueAddress(), $data, 30 * 86400);
        } else {
            request()->session()->put('address-data', $data);
        }
    }

    /**
     * get session address data
     *
     * @return int|mixed
     */
    public function getSessionAddress()
    {
        if (request()->route()->getPrefix() == 'api/user') {
            return Cache::get(config('cache.prefix') . '.address-data.' . getUniqueAddress());
        } else {
            return request()->session()->has('address-data') ? request()->session()->get('address-data') : null;
        }
    }

    /**
     * destroy session address
     *
     * @return null
     */
    public function destroySessionAddress()
    {
        if (request()->route()->getPrefix() == 'api/user') {
            return Cache::forget(config('cache.prefix') . '.address-data.' . getUniqueAddress());
        } else {
            return request()->session()->has('address-data') ? request()->session()->forget('address-data') : null;
        }
    }

    /**
     * get selected data
     *
     * @return array
     */
    public function getSelected()
    {
        $taxShipping = $this->getTaxShipping();

        return [
            'status' => 1,
            'selected_index' => Cart::getSelected(),
            'selected_products' => Cart::selectedCartCollection(),
            'subTotal' => Cart::totalPrice('selected'),
            'coupon_amount' => Cart::getCouponData(),
            'shipping' => $taxShipping['shipping'],
            'tax' => $taxShipping['tax'],
            'shippingIndex' => $this->getShippingIndex(),
            'displayTax' => preference('display_tax_totals'),
        ];
    }
}
