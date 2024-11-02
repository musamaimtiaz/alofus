<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ __('Invoice') }}</title>
    <link rel="stylesheet" href="{{ asset('public/bootstrap/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/pdf-invoice.min.css') }}">
</head>

<body>
    <div id="invoice-view-container">
        <div id="printTable">
            @if ($invoiceSetting?->document?->header?->logo == 'logo')
                <span>
                    <img class="martvill-logo" src="{{ domPdfImageSource($logo) }}">
                </span>
            @endif
            @if ($invoiceSetting?->document?->header?->logo == 'name')
                <span>
                    {{ empty($invoiceSetting?->general?->company_name) ? preference('company_name') : $invoiceSetting?->general?->company_name }}
                </span>
            @endif
            <div>
                <div class="invoice-side">
                    @if ($invoiceSetting?->document?->header?->is_invoice_no_show)
                        <p class="order-invoice">
                            {{ empty($invoiceSetting?->document?->header?->invoice_label) ? __('Order Invoice') : $invoiceSetting?->document?->header?->invoice_label }}</p>
                        <p class="order-reference">#{{ $order->reference }}</p>
                    @endif
                </div>
                <div class="address-side">
                    @if ($invoiceSetting?->document?->header?->is_show_customer_info)
                        @if (isset($user) && !empty($user->name))
                            <p class="name">{{ $user->name }}</p>
                        @endif
                        @if (isset($user) && !empty($user->phone))
                            <p class="phone">{{ $user->phone }}</p>
                        @endif
                        @if (isset($user) && !empty($user->email))
                            <p class="email">{{ $user->email }}</p>
                        @endif
                    @endif
                </div>
                <div class="clear-both"></div>
            </div>
            <div>
                <table class="table">
                    <thead class="thead">
                        @if (isActive('Shop'))
                            @php $shop = true; @endphp
                        @endif
                        <tr>
                            <th colspan="{{ $invoiceSetting?->document?->product_table?->is_image ? 2 : 0 }}">
                                {{ empty($invoiceSetting?->document?->product_table?->product_label) ? __('Product Name') : $invoiceSetting?->document?->product_table?->product_label }}
                            </th>

                            @if ($shop && $invoiceSetting?->document?->product_table?->is_vendor_name)
                                <th>
                                    {{ empty($invoiceSetting?->document?->product_table?->vendor_name_label) ? __('Shop Name') : $invoiceSetting?->document?->product_table?->vendor_name_label }}
                                </th>
                            @endif

                            @if ($invoiceSetting?->document?->product_table?->is_quentity)
                                <th>
                                    {{ empty($invoiceSetting?->document?->product_table?->quentity_label) ? __('Quantity') : $invoiceSetting?->document?->product_table?->quentity_label }}
                                </th>
                            @endif

                            <th>{{ __('Amount') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderDetails as $detail)
                            @php
                                $opName = '';
                                if ($detail->payloads != null) {
                                    $option = (array) json_decode($detail->payloads);
                                    $itemCount = count($option);
                                    $i = 0;
                                    foreach ($option as $key => $value) {
                                        $opName .= $key . ': ' . $value . (++$i == $itemCount ? '' : ', ');
                                    }
                                }
                                $productInfo = $orderAction->getProductInfo($detail);
                            @endphp
                            <tr>


                                @if ($invoiceSetting?->document?->product_table?->is_image)
                                    <td class="td">
                                        <img class="product-image" src="{{ domPdfImageSource($productInfo['image']) }}" />
                                    </td>
                                @endif


                                <td class="product-name-td">
                                    <p>
                                        {{ $detail->product_name }} <br>
                                    </p>
                                    @if ($invoiceSetting?->document?->product_table?->is_attribute)
                                        <p class="op-name">
                                            {{ $opName }}
                                        </p>
                                    @endif
                                </td>
                                {{-- <td class="td"></td> --}}

                                @if ($shop && $invoiceSetting?->document?->product_table?->is_vendor_name)
                                    <td class="td">
                                        <p class="vendor-name">{{ optional($detail->vendor)->name }}</p>
                                    </td>
                                @endif


                                @if ($invoiceSetting?->document?->product_table?->is_quentity)
                                    <td class="td">
                                        <p class="product-details">{{ formatCurrencyAmount($detail->quantity) }}</p>
                                    </td>
                                @endif

                                <td class="td">
                                    <p class="product-details currency_symbol">
                                        {{ formatNumber($detail->price * $detail->quantity, optional($order->currency)->symbol) }}
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div>
                <table class="table">
                    <tbody>
                        @php
                            $couponOffer = isset($order->couponRedeems) && $order->couponRedeems->sum('discount_amount') > 0 && isActive('Coupon') ? $order->couponRedeems->sum('discount_amount') : 0;
                        @endphp
                        <tr>
                            <td class="width-380"> </td>
                            <td class="footer-information">{{ __('Sub Total') }} :</td>
                            <td class="width-80"></td>
                            @php
                                $couponOffer = isset($order->couponRedeems) && $order->couponRedeems->sum('discount_amount') > 0 && isActive('Coupon') ? $order->couponRedeems->sum('discount_amount') : 0;
                            @endphp
                            <td class="footer-information currency_symbol">
                                {{ formatNumber($order->total + $order->other_discount_amount + $couponOffer - ($order->shipping_charge + $order->tax_charge), optional($order->currency)->symbol) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="width-380"> </td>
                            <td class="footer-information">
                                {{ __('Shipping') }}{{ !is_null($order->shipping_title) ? '( ' . $order->shipping_title . ' )' : null }}:
                            </td>
                            <td class="width-80"></td>
                            <td class="footer-information currency_symbol">
                                {{ formatNumber($order->shipping_charge, optional($order->currency)->symbol) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="width-380"> </td>
                            <td class="footer-information">{{ __('Tax') }} :</td>
                            <td class="width-80"></td>
                            <td class="footer-information currency_symbol">{{ formatNumber($order->tax_charge, optional($order->currency)->symbol) }}
                            </td>
                        </tr>
                        @if ($couponOffer > 0)
                            <tr>
                                <td class="width-380"> </td>
                                <td class="footer-information">{{ __('Coupon offer') }} :</td>
                                <td class="width-80"></td>
                                <td class="footer-information currency_symbol">{{ formatNumber($couponOffer, optional($order->currency)->symbol) }}
                                </td>
                            </tr>
                        @endif
                        @if ($order->other_discount_amount > 0)
                            <tr>
                                <td class="width-380"> </td>
                                <td class="footer-information">{{ __('Discount') }} :</td>
                                <td class="width-80"></td>
                                <td class="footer-information currency_symbol">{{ formatNumber($order->other_discount_amount, optional($order->currency)->symbol) }}
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td class="width-380"> </td>
                            <td class="footer-information border-top">{{ __('Total') }} :</td>
                            <td class="footer-information border-top width-80"></td>
                            <td class="footer-information border-top currency_symbol">
                                {{ formatNumber($order->total, optional($order->currency)->symbol) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @if ($invoiceSetting?->document?->delivery_details?->is_delivery_details)
                <div class="delivery-side">
                    <p class="delivery-details">
                        {{ empty($invoiceSetting?->document?->delivery_details?->delivery_details_labal) ? __('Delivery Details') : $invoiceSetting?->document?->delivery_details?->delivery_details_labal }}
                    </p>
                    <div>
                        @if ($invoiceSetting?->document?->delivery_details?->is_shopping_address)
                            @php
                                $shippingAddress = $order->getShippingAddress();
                                $billingAddress = $order->getBillingAddress();
                            @endphp
                            <div class="addresses">
                                <p class="shipping-address">
                                    {{ empty($invoiceSetting?->document?->delivery_details?->shopping_address_label) ? __('Shipping Address') : $invoiceSetting?->document?->delivery_details?->shopping_address_label }}
                                    :</p>
                                <p class="shipping-information">
                                    {{ $shippingAddress->first_name . ' ' . $shippingAddress->last_name }}</p>
                                <p class="shipping-information">{{ __('Street Address') }}:
                                    {{ $shippingAddress->address_1 }}{{ !empty($shippingAddress->address_2) ? ', ' . $shippingAddress->address_2 : '' }}
                                </p>
                                <p class="shipping-information">{{ __('City') }}: {{ $shippingAddress->city }}</p>
                                <p class="shipping-information">
                                    {{ __('Postcode') . ' / ' . __('ZIP') }}:{{ $shippingAddress->zip }}
                                </p>
                                <p class="shipping-information">{{ __('Country') }}: {{ $shippingAddress->country }}
                                </p>
                                <p class="shipping-information">
                                    {{ __('State') . ' / ' . __('Province') }}:{{ $shippingAddress->state }}
                                </p>
                                @if (!empty($shippingAddress->phone))
                                    <p class="shipping-information">{{ __('Phone') }}: {{ $shippingAddress->phone }}
                                    </p>
                                @endif

                            </div>
                        @endif
                        <div class="payment">
                            @if ($invoiceSetting?->document?->delivery_details?->is_estimate_time_section)
                                <div>
                                    <p class="shipping-address">
                                        {{ empty($invoiceSetting?->document?->delivery_details?->estimate_time_label) ? __('ESTIMATED DELIVERY TIME') : $invoiceSetting?->document?->delivery_details?->estimate_time_label }}
                                    </p>
                                    <p class="shipping-information">{{ __('Office Days') }}</p>
                                </div>
                            @endif
                            @if ($invoiceSetting?->document?->delivery_details?->is_payment_section)
                                <div>
                                    <p class="shipping-address">
                                        {{ empty($invoiceSetting?->document?->delivery_details?->payment_label) ? __('PAYMENT') : $invoiceSetting?->document?->delivery_details?->payment_label }}
                                    </p>
                                    @if (!empty(optional($order->paymentMethod)->gateway))
                                        <p class="shipping-information">{{ optional($order->paymentMethod)->gateway }}
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="clear-both"></div>
                    </div>

                </div>
            @endif
            @if ($invoiceSetting?->document?->footer?->is_footer)
                @if ($invoiceSetting?->document?->footer?->is_main_footer)
                    <p class="keep-in-touch"
                        style="color: {{ $invoiceSetting?->document?->footer?->main_footer?->text_color }}; text-align: {{ $invoiceSetting?->document->footer?->main_footer?->align }};">
                        {{ empty($invoiceSetting?->document?->footer?->main_footer?->label) ? __('Keep in touch') : $invoiceSetting?->document?->footer?->main_footer?->label }}</p>
                    <p class="concern-queries mb-5"
                        style="color: {{ $invoiceSetting?->document?->footer?->main_footer?->text_color }}; text-align: {{ $invoiceSetting?->document->footer?->main_footer?->align }};">
                        {{ $invoiceSetting?->document?->footer?->main_footer?->content }}</p>
                @endif

                @if ($invoiceSetting?->document?->footer?->is_copy_right_footer)
                    @if (!$invoiceSetting?->document?->footer?->is_main_footer)
                        <p></p>
                    @endif
                    <p class="copy-right"
                        style="color: {{ $invoiceSetting?->document?->footer?->copy_right_footer?->text_color }}; text-align: {{ $invoiceSetting?->document->footer?->copy_right_footer?->align }};">
                        @if ($invoiceSetting?->document?->footer?->copy_right_footer?->content)
                            {{ $invoiceSetting?->document?->footer?->copy_right_footer?->content }}
                        @else
                            © {{ date('Y') }}, {{ preference('company_name') }}.
                            {{ __('All rights reserved.') }}
                        @endif
                    </p>
                @endif
            @endif
        </div>
    </div>
</body>

</html>
