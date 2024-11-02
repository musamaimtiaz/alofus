<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 14-12-2021
 */

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\Actions\Facades\OrderActionFacade as OrderAction;
use App\Services\Product\AddToCartService;
use Illuminate\Http\Request;
use Modules\Affiliate\Services\ReferralMailService;
use Modules\Gateway\Facades\GatewayHelper;
use Modules\Gateway\Redirect\GatewayRedirect;
use App\Models\{
    Address,
    Country,
    Currency,
    Product,
    Order,
    OrderDetail,
    OrderMeta,
    OrderStatusHistory,
    Preference,
    OrderStatus
};
use App\Services\Actions\OrderAction as ActionsOrderAction;
use Modules\Commission\Http\Models\{
    Commission,
    OrderCommission
};
use Cart;
use Auth;
use DB;
use Session;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Route;
use App\Services\Mail\{
    UserInvoiceMailService,
    VendorInvoiceMailService
};

class OrderController extends Controller
{
    /**
     * Address view page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $orders = Auth::user()->orders();
        $data['statuses'] = OrderStatus::getAll()->sortBy('order_by');
        $data['filterStatus'] = false;
        $filterDay = ['today' => today(), 'last_week' => now()->subWeek(), 'last_month' => now()->subMonth(), 'last_year' => now()->subYear()];
        if (isset($request->filter_day) && array_key_exists($request->filter_day, $filterDay)) {
            $orders->whereDate('order_date', '>=', $filterDay[$request->filter_day]);
        }
        if (isset($request->filter_status)) {
            $orders->where('order_status_id', $request->filter_status);
            $data['filterStatus'] = true;
        }

        $data['orders'] = $orders->paginate(preference('row_per_page'));

        return view('site.order.index', $data);
    }

    /**
     * Order Checkout
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function checkOut(Request $request)
    {
        Cart::checkCartData();
        $data['selectedTotal'] = Cart::totalPrice('selected');
        $hasCart = Cart::selectedCartCollection();
        $shipping = 0;
        $tax = 0;
        $cartService = new AddToCartService();

        if (is_array($hasCart) && count($hasCart) > 0) {

            if (pageReload()) {
                $cartService->destroySessionAddress();
            }

            $data['addresses'] = [];
            $data['defaultAddresses'] = null;
            $taxShipping = $cartService->getTaxShipping();

            if (Auth::check()) {
                $data['addresses'] = Address::getAll()->where('user_id', Auth::user()->id);
                $data['defaultAddresses'] = Address::getAll()->where('user_id', Auth::user()->id)->where('is_default', 1)->first();
            }

            $data['countries'] = Country::getAll();
            $data['tax'] = $taxShipping['tax'];
            $data['shipping'] = $taxShipping['shipping'];
            $data['shippingIndex'] = $cartService->getShippingIndex();

            if (isActive('Coupon')) {
                $data['coupon'] = Cart::getCouponData();
            }
            $cartService->destroySessionAddress();

            return view('site.order.checkout', $data);
        }

        return redirect()->route('site.cart');
    }

    /**
     * order store
     *
     * @return void
     */
    public function store(Request $request)
    {
        if ($this->c_p_c()) {
            Session::flush();

            return view('errors.installer-error', ['message' => __('This product is facing license validation issue.<br>Please contact admin to fix the issue.')]);
        }
        $order = [];
        $detailData = [];
        $cartData = Cart::selectedCartCollection();
        $cartService = new AddToCartService();
        if (is_array($cartData) && count($cartData) > 0) {
            $coupon = 0;
            if (isActive('Coupon')) {
                $coupon = Cart::getCouponData();
            }
            $defaultCurrency = Currency::getDefault();
            if (isset($request->selected_tab) && $request->selected_tab == 'new') {

                $request['user_id'] = Auth::check() ? Auth::user()->id : 0;
                $request['is_default'] = isset($request->default_future) && $request->default_future == 'on' ? 1 : 0;
                $validator = Address::storeValidation($request->all());

                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                }

                if (Auth::check()) {
                    $existsAddressId = (new Address())->store($request->only('user_id', 'first_name', 'last_name', 'phone', 'address_1', 'address_2', 'state', 'country', 'city', 'zip', 'is_default', 'type_of_place', 'email'));
                    $addressId = $existsAddressId;
                } else {
                    $existsAddressId = ['first_name' => $request->first_name, 'last_name' => $request->last_name, 'phone' => $request->phone, 'address_1' => $request->address_1, 'address_2' => $request->address_2, 'country' => $request->country, 'state' => $request->state, 'city' => $request->city, 'post_code' => $request->zip, 'type_of_place' => $request->type_of_place, 'email' => $request->email, 'zip' => $request->zip];
                    $addressId = (object) $existsAddressId;
                }

                if (isset($request->ship_different) && $request->ship_different == 'on') {
                    $shipDiffAddress = ['country' => $request->shipping_address_country, 'state' => $request->shipping_address_state, 'city' => $request->shipping_address_city, 'post_code' => $request->shipping_address_zip];
                    $addressId = (object) $shipDiffAddress;
                }
            } elseif (isset($request->address_id) && isset($request->selected_tab) && $request->selected_tab == 'old') {
                $defAddress = Address::where('user_id', Auth::user()->id)->where('id', $request->address_id)->first();
                if (! empty($defAddress)) {
                    $existsAddressId = $defAddress->id;
                    $addressId = $existsAddressId;
                } else {
                    return back()->withErrors(['error' => __('Address not found.')])->withInput();
                }
            }

            $taxShipping = $cartService->getTaxShipping($addressId ?? null, 'order');
            $totalTax = $taxShipping['tax'];
            $totalShipping = $taxShipping['shipping'];
            $cartService->destroySessionAddress();
            $cartService->destroyShippingIndex();
            $orderStatus = OrderStatus::getAll()->where('slug', 'pending-payment')->first();
            $userId = Auth::check() ? Auth::user()->id : null;
            $order['user_id'] = $userId;
            $order['order_date'] = DbDateFormat(date('Y-m-d'));
            $order['currency_id'] = $defaultCurrency->id;
            $order['shipping_charge'] = $totalShipping;
            $order['shipping_title'] = $taxShipping['key'] ?? null;
            $order['tax_charge'] = $totalTax;
            $order['total'] = (Cart::totalPrice('selected') + $totalShipping + $totalTax) - $coupon;
            $order['total_quantity'] = Cart::totalQuantity('selected');
            $order['paid'] = 0;
            $order['amount_received'] = 0;
            $order['other_discount_amount'] = 0;
            $order['order_status_id'] = $orderStatus->id;

            $reference = Order::getOrderReference(preference('order_prefix', null));

            $order['reference'] = $reference;

            try {
                DB::beginTransaction();
                $orderId = (new Order())->store($order);
                /* initial history add */
                $history['order_id'] = $orderId;
                $history['order_status_id'] = $orderStatus->id;
                (new OrderStatusHistory())->store($history);
                /* initial history end */
                if (! empty($orderId)) {
                    $downloadable = [];

                    foreach ($cartData as $key => $cart) {
                        $item = Product::where('id', $cart['id'])->published()->first();

                        if ($item->meta_downloadable == 1) {
                            $idCount = 1;
                            foreach ($item->meta_downloadable_files as $files) {
                                if (isset($files['url']) && ! empty($files['url'])) {
                                    $url = urlSlashReplace($files['url'], ['\/', '\\']);
                                    $downloadable[] = [
                                        'id' => $idCount++,
                                        'download_limit' => ! is_null($item->meta_download_limit) && $item->meta_download_limit != '' && $item->meta_download_limit != '-1' ? $item->meta_download_limit * $cart['quantity'] : $item->meta_download_limit,
                                        'download_expiry' => $item->meta_download_expiry,
                                        'link' => $url,
                                        'download_times' => 0,
                                        'is_accessible' => 1,
                                        'vendor_id' => $item->vendor_id,
                                        'name' => $item->name,
                                        'f_name' => $files['name'],
                                    ];
                                }
                            }
                        }

                        $variationMeta = null;
                        if ($cart['type'] == 'Variable Product') {
                            $variationMeta = $cart['variation_meta'];
                        }
                        /*Check Inventory & update*/
                        if (! $item->checkInventory($cart['quantity'], $item->meta_backorder, $orderStatus->slug)) {
                            $response = $this->messageArray(__('Invalid Order!'), 'fail');
                            $this->setSessionValue($response);

                            return redirect()->back();
                        }
                        /*End Inventory & update*/
                        $shipping = 0;
                        $tax = 0;
                        if (! empty($item)) {
                            $offerFlag = $item->offerCheck();
                            $tax = $offerFlag ? $item->priceWithTax('including tax', 'sale', false, true, false, $addressId, 0, ['cart_price' => $cart['price']]) * $cart['quantity'] : $item->priceWithTax('including tax', 'regular', false, true, false, $addressId, 0, ['cart_price' => $cart['price']]) * $cart['quantity'];

                            if (isActive('Shipping')) {
                                $shipping = $item->shipping(['qty' => $cart['quantity'], 'price' => $cart['price'], 'address' => $addressId, 'from' => 'order']);
                                if (is_array($shipping) && count($shipping) > 0) {
                                    $shipping = $shipping[($taxShipping['key'])];
                                } else {
                                    $shipping = 0;
                                }
                            }
                        }
                        $detailData[] = [
                            'product_id' => $cart['id'],
                            'parent_id' => $cart['parent_id'],
                            'order_id' => $orderId,
                            'vendor_id' => $cart['vendor_id'],
                            'shop_id' => $cart['shop_id'],
                            'product_name' => $cart['name'],
                            'price' => $cart['price'],
                            'quantity_sent' => 0,
                            'quantity' => $cart['quantity'],
                            'order_status_id' => $orderStatus->id,
                            'payloads' => $variationMeta,
                            'order_by' => $key,
                            'shipping_charge' => null,
                            'tax_charge' => $tax,
                            'is_stock_reduce' => $item->isStockReduce($orderStatus->slug),
                            'estimate_delivery' => $item->type == 'Variation' ? $item->parentDetail->estimated_delivery : $item->estimated_delivery,
                        ];

                        if ($item->type == 'Variation') {
                            $item->parentDetail->updateCategorySalesCount();
                        } else {
                            $item->updateCategorySalesCount();
                        }
                    }
                    (new OrderDetail())->store($detailData);
                    OrderAction::store($existsAddressId, $userId, $orderId, $downloadable, $request);

                    //commission
                    $commission = Commission::getAll()->first();
                    if (! empty($commission) && $commission->is_active == 1) {
                        $orderDetails = OrderDetail::where('order_id', $orderId)->get();
                        $orderCommission = [];
                        foreach ($orderDetails as $details) {
                            if (isset($details->vendor->sell_commissions) && optional($details->vendor)->sell_commissions > 0) {
                                $orderCommission[] = [
                                    'order_details_id' => $details->id,
                                    'category_id' => null,
                                    'vendor_id' => $details->vendor_id,
                                    'amount' => $details->vendor->sell_commissions,
                                    'status' => 'Pending',
                                ];
                            } elseif ($commission->is_category_based == 1 && isset($details->productCategory->category->sell_commissions) && ! empty($details->productCategory->category->sell_commissions) && $details->productCategory->category->sell_commissions > 0) {
                                $orderCommission[] = [
                                    'order_details_id' => $details->id,
                                    'category_id' => $details->productCategory->category_id,
                                    'vendor_id' => null,
                                    'amount' => $details->productCategory->category->sell_commissions,
                                    'status' => 'Pending',
                                ];
                            } else {
                                $orderCommission[] = [
                                    'order_details_id' => $details->id,
                                    'category_id' => $details->productCategory->category_id ?? null,
                                    'vendor_id' => $details->vendor_id ?? null,
                                    'amount' => $commission->amount,
                                    'status' => 'Pending',
                                ];
                            }
                        }
                        if (is_array($orderCommission) && count($orderCommission) > 0) {
                            (new OrderCommission())->store($orderCommission);
                        }
                    }

                    $latestOrder = Order::where('id', $orderId)->first();

                    //end commission
                    if (isActive('Coupon')) {
                        $coupons = Cart::getCouponData(false);
                        $couponRedem = [];
                        if (is_array($coupons) && count($coupons) > 0) {
                            foreach ($coupons as $coupon) {
                                $couponRedem[] = [
                                    'coupon_id' => $coupon['id'],
                                    'coupon_code' => $coupon['code'],
                                    'user_id' => Auth::check() ? Auth::user()->id : null,
                                    'user_name' => Auth::check() ? Auth::user()->name : null,
                                    'order_id' => $orderId,
                                    'order_code' => $latestOrder->reference,
                                    'discount_amount' => $coupon['calculated_discount'],
                                ];
                            }
                            (new \Modules\Coupon\Http\Models\CouponRedeem())->store($couponRedem);
                        }
                    }

                    if (isActive('Affiliate')) {
                        \Modules\Affiliate\Entities\ReferralPurchase::purchase($latestOrder, $detailData);
                    }

                    DB::commit();
                    Cart::selectedCartProductDestroy();

                    if ($latestOrder->total <= 0) {
                        $route = $this->orderWithoutPayment($latestOrder->reference);

                        return redirect($route);
                    } else {
                        request()->query->add(['payer' => 'user', 'to' => techEncrypt('site.orderpaid')]);

                        $route = GatewayRedirect::paymentRoute($latestOrder, $latestOrder->total, $latestOrder->currency->name, $latestOrder->reference, $request);

                        return redirect($route);
                    }
                }
            } catch (Exception $e) {
                DB::rollBack();

                return redirect()->back();
            }
        }

        return redirect()->route('site.cart');
    }

    /**
     * order confirmation
     *
     * @return void
     */
    public function confirmation($reference)
    {
        $order = Order::where('reference', $reference)->first();
        if (
            ! empty($order) && Auth::user() && isset(Auth::user()->role()->type) && Auth::user()->role()->type == 'global' && Auth::user()->role()->slug == 'super-admin' ||
            ! empty($order) && $order->user_id == Auth::id() ||
            ! empty($order)  && request()->payer == 'guest'
        ) {
            $data['order'] = $order;
            $data['orderDetails'] = collect($order->orderDetails);
            if (request()->payer == 'guest' || request()->redirect == 'confirmation') {
                return redirect(GatewayRedirect::confirmationRedirect());
            }

            return view('site.order.confirmation', $data);
        }
        if (request()->payer == 'guest') {
            return redirect(GatewayRedirect::failedRedirect('error'));
        }

        return redirect()->back();
    }

    /**
     * order details
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function orderDetails($reference)
    {
        $order = Order::where('reference', $reference)->first();
        $data['orderStatus'] = OrderStatus::getAll()->sortBy('order_by');
        if (! empty($order) && isset(Auth::user()->role()->type) && Auth::user()->role()->type == 'global' && Auth::user()->role()->slug == 'super-admin' || ! empty($order) && $order->user_id == Auth::user()->id) {
            $data['order'] = $order;
            $data['orderDetails'] = collect($order->orderDetails);
            $data['orderHistories'] = collect($order->orderHistories);
            $data['detailGroups'] = $data['orderDetails']->groupBy('vendor_id');
            $data['orderAction'] = new ActionsOrderAction();

            return view('site.order.order-details', $data);
        }

        return redirect()->back();
    }

    /**
     * payment process again if payment status is unpaid
     *
     * @param $reference
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function payment(Request $request)
    {
        $order = Order::where('reference', $request->reference)->first();
        if (! empty($order)) {
            if (optional($order->paymentMethod)->status == 'pending') {
                if (Route::currentRouteName() == 'site.orderPayment.guest') {
                    request()->query->add(['payer' => 'guest', 'to' => techEncrypt('site.orderpaid.guest'), 'integrity' => getIntegrityKey()]);
                } else {
                    request()->query->add(['to' => techEncrypt('site.orderpaid')]);
                }
                $route = GatewayRedirect::paymentRoute($order, $order->total, $order->currency->name, $order->reference, null, optional($order->paymentMethod)->id);

                return redirect($route);
            }
        }

        if (Route::currentRouteName() == 'site.orderPayment.guest') {
            return redirect(GatewayRedirect::failedRedirect());
        }

        return redirect()->back();
    }

    /**
     * order track
     *
     * @param  string  $code
     * @return \Illuminate\Contracts\View\View
     */
    public function track(Request $request)
    {
        if (! $request->filled('code')) {
            return view('site.order.order-track');
        }

        if (! OrderMeta::where(['key' => 'track_code', 'value' => $request->code])->count()) {
            return redirect()->route('site.trackOrder')->withErrors(['code' => $request->code, 'message' => __('Track code is invalid.')]);
        }

        $data['order'] = Order::with(OrderAction::relationsWith())
            ->join('orders_meta', 'orders.id', 'orders_meta.order_id')
            ->where(['orders_meta.key' => 'track_code', 'orders_meta.value' => $request->code])
            ->selectRaw('orders.*, orders_meta.value as track_code')
            ->first();
        $data['statuses'] = OrderStatus::select('id', 'name')->orderBy('order_by')->get();

        return view('site.order.order-track-details', $data);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function orderPaid(Request $request)
    {
        if (! checkRequestIntegrity()) {
            return redirect(GatewayRedirect::failedRedirect('integrity'));
        }

        $isGuest = $request->payer == 'guest';

        try {
            $code = techDecrypt($request->code);
            $order = Order::where('reference', $code)->first();
            $orderStatusInfo = OrderStatus::getAll()->where('slug', 'processing')->first();

            if (! $order) {
                if ($isGuest) {
                    return redirect(GatewayRedirect::failedRedirect())->withErrors(__('Invalid order data.'));
                }

                return redirect()->route('site.cart')->withErrors(__('Order not found.'));
            }

            $log = GatewayHelper::getPaymentLog($code);

            if (! $log) {
                if ($isGuest) {
                    return redirect(GatewayRedirect::failedRedirect())->withErrors(__('Payment data not found.'));
                }

                return redirect()->route('site.cart')->withErrors(__('Payment data not found.'));
            }

            if (! FacadesAuth::id()) {
                FacadesAuth::onceUsingId($order->user_id);
            }

            if ($log->status == 'completed') {
                $data = json_decode($log->response);
                $order->paid = $data->amount;
                $order->amount_received = $data->amount;
                $order->payment_status = 'Paid';
                $order->order_status_id = $orderStatusInfo->id;
                //order transaction
                $order->transactionStore();

                foreach ($order->orderDetails as $detail) {
                    (new OrderDetail())->updateOrder(['order_status_id' => $orderStatusInfo->id], $detail->id);
                }

                if (isActive('Affiliate')) {
                    \Modules\Affiliate\Entities\ReferralPurchase::referralPurchaseUpdate($order->id, $orderStatusInfo);
                }
            }

            $order->checkOrderStatus();
            $order->save();

            // Send invoice to user and vendor
            (new UserInvoiceMailService())->send($order);
            (new VendorInvoiceMailService())->send($order);

            //send referral details to admin
            if (isActive('Affiliate') && preference('refer_details') == 1) {
                (new ReferralMailService())->send($order);
            }

            return redirect()
                ->route($isGuest ? 'site.orderConfirm.guest' : 'site.orderConfirm', withOldQueryString(['reference' => $order->reference]));
        } catch (\Exception $e) {
            if ($isGuest) {
                return redirect(GatewayRedirect::failedRedirect('error'))->withErrors($e->getMessage());
            }

            return redirect()->route('site.cart')->withErrors($e->getMessage());
        }
    }

    /**
     * if order balance will zero then this function will be used
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function orderWithoutPayment($reference = null)
    {
        $orderStatusInfo = OrderStatus::getAll()->where('slug', 'processing')->first();
        $order = Order::where('reference', $reference)->first();

        if (! $order) {
            return redirect()->route('site.cart')->withErrors(__('Order not found.'));
        }

        try {
            $order->payment_status = 'Paid';
            $order->order_status_id = $orderStatusInfo->id;
            //order transaction
            $order->transactionStore();
            foreach ($order->orderDetails as $detail) {
                (new OrderDetail())->updateOrder(['order_status_id' => $orderStatusInfo->id], $detail->id);
            }

            $order->checkOrderStatus();
            $order->save();

            // Send invoice to user and vendor
            (new UserInvoiceMailService())->send($order);
            (new VendorInvoiceMailService())->send($order);

            return route('site.orderConfirm', ['reference' => $order->reference]);
        } catch (\Exception $e) {
            return route('site.cart')->withErrors($e->getMessage());
        }
    }

    public function orderManage()
    {
        return view('site.order.order-manage');
    }

    public function getShippingTax(Request $request)
    {
        $response = ['status' => 0];
        $cartService = new AddToCartService();
        $address = $request->address['address_id'] ?? null;

        if (is_null($address)) {
            $address = ['country' => $request->address['country'], 'state' => $request->address['state'], 'city' => $request->address['city'], 'post_code' => $request->address['zip']];
            $address = (object) $address;
        }
        $cartService->destroyShippingIndex();
        $getTaxShipping = $cartService->getTaxShipping($address, null, true);

        if ($getTaxShipping) {
            $response = ['status' => 1, 'tax' => $getTaxShipping['tax'], 'displayTaxTotal' => $getTaxShipping['displayTaxTotal'], 'shipping' => $getTaxShipping['shipping'], 'totalPrice' => Cart::totalPrice('selected'), 'shippingIndex' => $cartService->getShippingIndex()];
        }

        return $response;
    }

    /**
     * order invoice print
     *
     * @param  Request  $request
     */
    public function invoicePrint($id)
    {
        $order = Order::where('id', $id)->first();
        if (Auth::check() && ! empty($order) && ! empty($order->user_id) || ! Auth::check() && ! empty($order) && empty($order->user_id)) {
            $data['orderStatus'] = OrderStatus::getAll()->sortBy('order_by');
            $data['order'] = $order;
            $data['invoiceSetting'] = json_decode(preference('invoice'));
            $data['logo'] = Preference::where('field', 'company_logo')->first()->fileUrl();
            if ($data['invoiceSetting']?->document?->header?->logo == 'logo' && $data['invoiceSetting']?->general->logo) {
                $data['logo'] = Preference::where('field', 'invoice')->first()->fileUrl();
            }
            $data['orderAction'] = new ActionsOrderAction();
            $data['user'] = $order->user;
            $data['orderDetails'] = $order->orderDetails;
            $data['type'] = request()->get('type') == 'print' || request()->get('type') == 'pdf' ? request()->get('type') : 'print';
            if ($data['type'] == 'pdf' || $data['type'] == 'print') {
                return printPDF($data, $order->reference . '.pdf', 'site.order.invoice_print', view('site.order.invoice_print', $data), $data['type']);
            } else {
                return view('site.order.invoice_print', $data);
            }
        }

        if (! Auth::check()) {
            return redirect()->route('site.index');
        }

        return redirect()->route('site.order');
    }

    /**
     * Check Verification
     *
     * @return bool
     */
    public function c_p_c()
    {
		p_c_v();
		return false;
    }
}
