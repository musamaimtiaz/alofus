<div class="card card-width">
    <div class="col-sm-12 form-tabs">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="row">
                    <div class="container" id="printTable">
                        <div>
                            <div>
                                <div class="row m-0 order-info-table-container">
                                    <div class="col-sm-12 order-info-table">
                                        <div class="table-responsive order-details-table-responsive">
                                            <table class="table invoice-detail-table">
                                                <thead>
                                                    @if(isActive('Shop'))
                                                        @php $shop = true; @endphp
                                                    @endif
                                                    <tr class="thead-default order-info-thead">
                                                        <th>{{__('')}}</th>
                                                        <th>{{ __('Products') }}</th>
                                                        <th>{{ __('SKU') }}</th>
                                                        <th>{{ __('Status') }}</th>
                                                        <th>{{ __('Cost') }}</th>
                                                        <th>{{ __('Qty') }}</th>
                                                        <th>{{ __('Total') }}</th>
                                                        <th>{{ __('Refund') }}</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach ($orderDetails as $details)
                                                        @if (!is_null($details[0]->vendor_id))
                                                            <tr>
                                                                <td colspan="5" class="pl-31p">{{ optional($details[0]->vendor)->name }}</td>
                                                            </tr>
                                                        @endif

                                                        @foreach ($details as $detail)
                                                            @php
                                                                if (isActive('Refund')) {
                                                                    $orderDeliverId = \App\Models\Order::getFinalOrderStatus();
                                                                }

                                                                $opName = '';
                                                                if ($detail->payloads != null) {
                                                                    $option = (array)json_decode($detail->payloads);
                                                                    $itemCount = count($option);
                                                                    $i = 0;
                                                                    foreach ($option as $key => $value) {
                                                                        $opName .= $key . ': ' . $value . (++$i == $itemCount ? '' : ', ');
                                                                    }
                                                                }

                                                                $productInfo = $orderAction->getProductInfo($detail);
                                                            @endphp
                                                            <tr>
                                                                <td></td>
                                                                <td>
                                                                    <div class="d-flex">
                                                                        <div class="order-itm-img-con">
                                                                            <img src="{{ $productInfo['image'] }}" alt="{{ __('Image') }}">
                                                                        </div>
                                                                        <div class="order-item-name-attribute">
                                                                            <h6>
                                                                                <a class="order-item-name mt-9 d-block" href="{{ $productInfo['url'] }}" title="{{ $detail->product_name }}">
                                                                                    {{ trimWords($detail->product_name, 25) }}
                                                                                    <br>
                                                                                </a>
                                                                            </h6>
                                                                            <p class="order-item-attr">{{ $opName }} </p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span title="{{ optional($detail->product)->sku }}">{{ trimWords(optional($detail->product)->sku, 10) }}</span>
                                                                </td>
                                                                @php $totalRefund = $detail->refunds()->where('status','Accepted')->sum('quantity_sent') @endphp
                                                                <td>
                                                                    @if ($totalRefund != $detail->quantity)
                                                                        @if($detail->is_delivery == 1)
                                                                            <span class="d-block mt-22p">{{ __('Completed') }}</span>
                                                                        @else
                                                                            <select class="form-select status order-status  {{ $detail->is_delivery == 1 ? 'delivery' : '' }}" name="status" data-id = "{{ $detail->id }}" {{ $detail->is_delivery == 1 ? 'disabled' : '' }}>
                                                                                @foreach ($orderStatus as $status)
                                                                                    @if (strtolower(optional($detail->orderStatus)->payment_scenario) == 'unpaid' && $status->payment_scenario == 'unpaid')
                                                                                        <option value="{{ $status->id }}" {{ $status->id == $detail->order_status_id ? 'selected' : '' }}>{{ $status->name }}</option>
                                                                                    @endif
                                                                                    @if ($status->payment_scenario == 'paid')
                                                                                        <option value="{{ $status->id }}" {{ $detail->order_status_id == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                        @endif
                                                                    @else
                                                                        <span class="d-block mt-22p">{{ __('Refunded') }}</span>
                                                                    @endif
                                                                </td>
                                                                <td>{{ formatCurrencyAmount($detail->price) }}</td>
                                                                <td class="d-flex">
                                                                    <span class="order-q-icon">x</span>
                                                                    {{ formatCurrencyAmount($detail->quantity) }}
                                                                </td>
                                                                <td>{{ formatNumber($detail->price * $detail->quantity, optional($order->currency)->symbol) }}</td>
                                                                @if ($detail->isRefundable() && preference('order_refund'))
                                                                    <td>
                                                                        @if ($detail->is_delivery == 1 && $totalRefund != $detail->quantity)
                                                                            <a href="javascript:void(0)" class="d-block mt-22p" id="refundApply" data-detailId = "{{ $detail->id }}" data-qty = {{ $detail->quantity -  $totalRefund }}><span>{{ __('Apply') }}</span></a>
                                                                        @endif
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 invoice-table-container ">
                                        <table class="table table-responsive invoice-table invoice-total invoice-total-customize table-spa">
                                            <tbody class="total-amount-design">
                                            @php
                                            $couponOffer = isset($order->couponRedeems) && $order->couponRedeems->sum('discount_amount') > 0 && isActive('Coupon') ? $order->couponRedeems->sum('discount_amount') : 0;
                                            @endphp
                                                <tr>
                                                    <th>{{ __('Sub Total') }} :</th>
                                                    <td class="text-right">{{ formatNumber(($order->total + $order->other_discount_amount + $couponOffer) - ($order->shipping_charge + $order->tax_charge), optional($order->currency)->symbol) }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="py-3">{{ __('Shipping') }} {{ !is_null($order->shipping_title) ? "( ". $order->shipping_title . " )" : null }} :</th>
                                                    <td class="py-3 text-right">{{ formatNumber($order->shipping_charge, optional($order->currency)->symbol) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Tax') }} :</th>
                                                    <td class="text-right">{{ formatNumber($order->tax_charge, optional($order->currency)->symbol) }}</td>
                                                </tr>
                                                @if($couponOffer > 0)
                                                <tr>
                                                    <th class="py-3">{{ __('Coupon offer') }} :</th>
                                                    <td class="py-3 text-right">{{ formatNumber($couponOffer, optional($order->currency)->symbol) }}</td>
                                                </tr>
                                                @endif
                                                @if($order->other_discount_amount > 0)
                                                <tr>
                                                    <th class="py-3">{{ __('Discount') }} :</th>
                                                    <td class="py-3 text-right">{{ formatNumber($order->other_discount_amount, optional($order->currency)->symbol) }}</td>
                                                </tr>
                                                @endif
                                                <tr class="text-info">
                                                    <td>
                                                        <hr />
                                                        <h5 class="order-grand-total">{{ __('Grand Total') }} :</h5>
                                                    </td>
                                                    <td>
                                                        <hr />
                                                        <h5 class="order-grand-currency">{{ formatNumber($order->total, optional($order->currency)->symbol) }}</h5>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
