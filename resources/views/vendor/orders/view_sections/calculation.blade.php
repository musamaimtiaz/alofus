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
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @php
                                                        $subTotal = 0;
                                                        $shippingCharge = 0;
                                                        $tax = 0;
                                                        $discountAmount = $order->vendorCouponDiscount();
                                                    @endphp
                                                    @foreach ($order->vendorOrderProduct($vendorId, $order->id) as $details)
                                                        @if(isset($details->shop->name) && isActive('Shop'))
                                                            <tr>
                                                                <td colspan="5" class="pl-31p">{{ $details->shop->name }}</td>
                                                            </tr>
                                                        @elseif(isset($details->vendor->name))
                                                            <tr>
                                                                <td colspan="5" class="pl-31p">{{ $details->vendor->name }}</td>
                                                            </tr>
                                                        @endif
                                                        @php
                                                            if (isActive('Refund')) {
                                                            $orderDeliverId = $details->orderStatus->where('order_by', $details->orderStatus->max('order_by'))->first()->id;
                                                            }

                                                            $opName = '';
                                                            if ($details->payloads != null) {
                                                                $option = (array)json_decode($details->payloads);
                                                                $itemCount = count($option);
                                                                $i = 0;
                                                                foreach ($option as $key => $value) {
                                                                    $opName .= $key . ': ' . $value . (++$i == $itemCount ? '' : ', ');
                                                                }
                                                            }
                                                            $subTotal += $details->price * $details->quantity;
                                                            $shippingCharge += $details->shipping_charge;
                                                            $tax += $details->tax_charge;

                                                            $productInfo = $orderAction->getProductInfo($details);
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
                                                                            <a class="order-item-name mt-9 d-block" href="{{ $productInfo['url'] }}" title="{{ $details->product_name }}">
                                                                                {{ trimWords($details->product_name, 25) }}
                                                                                <br>
                                                                            </a>
                                                                        </h6>
                                                                        <p class="order-item-attr">{{ $opName }} </p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span title="{{ optional($details->product)->sku }}">{{ trimWords(optional($details->product)->sku, 10) }}</span>
                                                            </td>
                                                            @php $totalRefund = $details->refunds()->where('status','Accepted')->sum('quantity_sent') @endphp
                                                            <td>
                                                                @if ($totalRefund != $details->quantity)
                                                                    @if($details->is_delivery == 1)
                                                                        <span class="d-block mt-22p">{{ __('Completed') }}</span>
                                                                    @else
                                                                        @php $orderStatusIds = $orderStatus->pluck('id')->toArray(); $isPresent = in_array($details->order_status_id, $orderStatusIds); $flag = true; @endphp
                                                                        <select class="form-select status order-status {{ $details->is_delivery == 1 ? 'delivery' : '' }}" name="status" data-id = "{{ $details->id }}" {{ $details->is_delivery == 1 ? 'disabled' : '' }}>
                                                                            @foreach ($orderStatus as $status)

                                                                                @if(strtolower(optional($details->orderStatus)->payment_scenario) == 'unpaid' && $status->payment_scenario == 'unpaid')
                                                                                    <option value="{{ $status->id }}" {{ $status->id == $details->order_status_id ? 'selected' : '' }}>{{ $status->name }}</option>
                                                                                @endif

                                                                                @if($status->payment_scenario == 'paid')
                                                                                    <option value="{{ $status->id }}" {{ $details->order_status_id == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                                                                                @endif

                                                                                @if(!$isPresent && $flag)
                                                                                    @php $flag = false @endphp
                                                                                    <option value="{{ $details->order_status_id }}" selected disabled>{{ optional($details->orderStatus)->name }}</option>
                                                                                @endif

                                                                            @endforeach
                                                                        </select>
                                                                    @endif
                                                                @else
                                                                    <span class="d-block mt-22p">{{ __('Refunded') }}</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ formatCurrencyAmount($details->price) }}</td>
                                                            <td class="d-flex">
                                                                <span class="order-q-icon">x</span>
                                                                {{ formatCurrencyAmount($details->quantity) }}
                                                            </td>
                                                            <td>{{ formatNumber($details->price * $details->quantity, optional($order->currency)->symbol) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 invoice-table-container">
                                        <table class="table table-responsive invoice-table invoice-total invoice-total-customize table-spa">
                                            <tbody class="pe-5">
                                                <tr>
                                                    <th>{{ __('Sub Total') }} :</th>
                                                    <td class="text-left">{{ formatNumber($subTotal, optional($order->currency)->symbol) }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="py-3">{{ __('Shipping') }} {{ !is_null($order->shipping_title) ? "( ". $order->shipping_title . " )" : null }} :</th>
                                                    <td class="py-3">{{ formatNumber($shippingCharge, optional($order->currency)->symbol) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Tax') }} :</th>
                                                    <td>{{ formatNumber($tax, optional($order->currency)->symbol) }}</td>
                                                </tr>
                                                @if($discountAmount > 0)
                                                <tr>
                                                    <th class="pt-3">{{ __('Coupon offer') }} :</th>
                                                    <td class="pt-3">{{ formatNumber($discountAmount, optional($order->currency)->symbol) }}</td>
                                                </tr>
                                                @endif
                                                <tr class="text-info">
                                                    <td>
                                                        <hr />
                                                        <h5 class="order-grand-total">{{ __('Grand Total') }} :</h5>
                                                    </td>
                                                    <td>
                                                        <hr />
                                                        <h5 class="order-grand-currency">{{ formatNumber($subTotal + $shippingCharge + $tax - $discountAmount, optional($order->currency)->symbol) }}</h5>
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
