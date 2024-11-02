<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain <[sakawat.techvill@gmail.com]>
 *
 * @created 01-10-2022
 */

namespace App\Services\Shipping;

use Cart;

class ShippingCalculation
{
    /**
     * store zone
     *
     * @var null
     */
    protected $zone = null;

    /**
     * store compare address
     *
     * @var null
     */
    protected $compareAddress = null;

    /**
     * stoe quantity
     *
     * @var null
     */
    protected $quantity = null;

    /**
     * store quantity
     *
     * @var null
     */
    protected $from = null;

    /**
     * store product price
     *
     * @var int
     */
    protected $price = 0;

    public function __construct($zone, $compareAddress, $quantity, $from, $price)
    {
        $this->zone = $zone;
        $this->quantity = $quantity;
        $this->compareAddress = $compareAddress;
        $this->from = $from;
        $this->price = $price;
    }

    /**
     * calculate shipping
     *
     * @return array
     */
    public function calculateShipping()
    {
        $zone = $this->zone;
        $compareAddress = $this->compareAddress;
        $from = $this->from;
        $quantity = $this->quantity;
        $price = $this->price;

        $flag = $this->checkApplicableAddress($zone, $compareAddress);
        $methods = [];

        if ($flag == true) {

            foreach ($zone->ShippingZoneShippingMethod as $method) {
                $methodCost = 0;
                $zoneCost = 0;
                if ($method->status == 1) {
                    if ($method->shipping_method_id == 1) {
                        $allowFreeShipping = false;

                        if ($method->requirements == 'min_amount' && Cart::totalPrice('selected') >= $method->cost) {
                            $allowFreeShipping = $this->checkOrderRule($method->cost, $method->calculation_type);
                        } elseif ($method->requirements == 'coupon' && Cart::checkCouponFreeShipping()) {
                            $allowFreeShipping = true;
                        } elseif ($method->requirements == 'either' && Cart::checkCouponFreeShipping() || $method->requirements == 'either' && Cart::totalPrice('selected') >= $method->cost) {
                            $allowFreeShipping = $this->checkOrderRule($method->cost, $method->calculation_type, 'or');
                        } elseif ($method->requirements == 'both' && Cart::checkCouponFreeShipping() && Cart::totalPrice('selected') >= $method->cost) {
                            $allowFreeShipping = $this->checkOrderRule($method->cost, $method->calculation_type);
                        } elseif ($method->requirements == '') {
                            $allowFreeShipping = true;
                        }

                        if ($allowFreeShipping) {
                            if ($from == 'order') {
                                $methods[$method->method_title] = $methodCost + $zoneCost;
                            } else {

                                if (! empty($method->method_title)) {
                                    $methods[] = [
                                        'shipping_id' => $method->shipping_method_id,
                                        'title' => $method->method_title,
                                        'method_cost' => $methodCost,
                                        'zone_cost' => $zoneCost,
                                        'method_cost_type' => $method->cost_type,
                                        'addMethodZone' => $methodCost + $zoneCost,
                                        'calculation_type' => $method->calculation_type,
                                        'tax_status' => $method->tax_status,
                                    ];
                                }

                            }
                        }

                    } else {
                        if ($method->cost_type == 'cost_per_order') {
                            $methodCost = $method->cost;
                        } elseif ($method->cost_type == 'cost_per_quantity') {
                            $methodCost = $method->cost * $quantity;
                        } elseif ($method->cost_type == 'percent_sub_total_item_price') {
                            $methodCost = ($method->cost * Cart::totalPrice('selected')) / 100;
                        }

                        if ($method->shipping_method_id == 3) {

                            if ($zone->cost_type == 'cost_per_order') {

                                if (! isset($GLOBALS['shipping_slug'])) {
                                    $GLOBALS['shipping_slug'] = [];
                                }

                                $zoneCost = ! in_array($zone->shipping_class_slug, $GLOBALS['shipping_slug']) ? $zone->cost : 0;
                                $GLOBALS['shipping_slug'][] = $zone->shipping_class_slug;
                            } elseif ($zone->cost_type == 'cost_per_quantity') {
                                $zoneCost = $zone->cost * $quantity;
                            } elseif ($zone->cost_type == 'percent_sub_total_item_price') {
                                $zoneCost = ($zone->cost * ($price * $quantity)) / 100;
                            }

                        }

                        if ($from == 'order') {
                            ! empty($method->method_title) ? $methods[$method->method_title] = $methodCost + $zoneCost : '';
                        } else {

                            if (! empty($method->method_title)) {
                                $methods[] = [
                                    'shipping_id' => $method->shipping_method_id,
                                    'title' => $method->method_title,
                                    'method_cost' => $methodCost,
                                    'zone_cost' => $zoneCost,
                                    'method_cost_type' => $method->cost_type,
                                    'addMethodZone' => $methodCost + $zoneCost,
                                    'calculation_type' => $method->calculation_type,
                                    'tax_status' => $method->tax_status,
                                ];
                            }

                        }
                    }

                }
            }

        }

        return $methods;
    }

    /**
     * check whether address applicable or not
     *
     * @return bool
     */
    public function checkApplicableAddress($shippingAddress = null, $compareAddress = null)
    {
        $flag = true;

        foreach ($shippingAddress->ShippingZoneGeolocales as $geolocale) {
            $flag = true;

            if ($geolocale->country != '') {

                if (! is_null($compareAddress)) {
                    if (strtolower($geolocale->country) != strtolower($compareAddress->country)) {
                        $flag = false;
                    }
                } else {
                    $flag = false;
                }

            }

            if (($geolocale->state) != '') {

                if (! is_null($compareAddress)) {
                    if ($geolocale->state != $compareAddress->state) {
                        $flag = false;
                    }
                } else {
                    $flag = false;
                }

            }

            if ($geolocale->city != '') {

                if (! is_null($compareAddress)) {
                    if ($geolocale->city != $compareAddress->city) {
                        $flag = false;
                    }
                } else {
                    $flag = false;
                }

            }

            if ($geolocale->zip != '') {

                if (! is_null($compareAddress)) {
                    if ($geolocale->zip != $compareAddress->post_code) {
                        $flag = false;
                    }

                } else {
                    $flag = false;
                }

            }

            if ($flag) {
                return $flag;
            }
        }

        return $flag;
    }

    /**
     * check order rule
     *
     * @return bool
     */
    public function checkOrderRule($methodCost = 0, $isRuleChecked = null, $type = null)
    {
        $orderAmount = Cart::totalPrice('selected') - Cart::getCouponData();

        if ($isRuleChecked == 1) {
            return true;
        } elseif ($type == 'or' && Cart::checkCouponFreeShipping()) {
            return true;
        } elseif ($orderAmount >= $methodCost || is_null($methodCost)) {
            return true;
        }

        return false;
    }
}
