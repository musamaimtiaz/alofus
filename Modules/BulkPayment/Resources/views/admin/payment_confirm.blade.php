<div class="row">
    <div class="col-sm-12">
        <table class="table">
            <thead>
            <tr>
                <th class="text-center">{{ __('Reference') }}</th>
                <th class="text-center">{{ __('Transaction Date') }}</th>
                <th class="text-center w-150p">
                    {{ __('Payment Method') }}
                </th>
                <th class="text-center">
                    {{ __('Transaction Id') }}
                </th>
                <th class="text-center">
                    {{ __('Amount Received') }}
                </th>
                <th class="text-center">{{ __('Due') }}</th>
            </tr>
            </thead>

            <tbody>
            @php
                $totalAmount = 0;
                $paymentMethod = json_decode(preference('disable_bulk_payment')) ?? [];
            @endphp
            @foreach($orders as $order)
                @php
                    $totalAmount = $order->total;
                @endphp
                <tr>
                    <td class="text-center">
                        <input type="hidden" name="order_id[]" value="{{ $order->id }}">
                        <a href="{{ route('order.view',  $order->id) }}" target="_blank">{{ $order->reference }}</a>
                    </td>

                    <td class="text-center">
                        <input type="text" class="form-control transaction_date" name="transaction_date[]">
                    </td>

                    <td class="text-center">
                        <select name="payment_method[]" class="form-select">
                            <option value="">{{ __('Select One') }}</option>
                        @foreach($paymentGateways as $gateway)
                            @if(!in_array($gateway->alias, $paymentMethod))
                            <option value="{{ $gateway->alias }}">{{ $gateway->name }}</option>
                            @endif
                        @endforeach
                        </select>
                    </td>

                    <td class="text-center">
                        <input type="text" name="transaction_id[]" class="form-control">
                    </td>

                    @if(Route::currentRouteName() == 'vendor.bulk.payment.order')
                        @php
                            $totalAmount = $order->vendorPayableAmount();
                        @endphp
                        <td class="text-center">
                            <input type="number" class="form-control amount_receive" name="paid[]" value="{{ $totalAmount }}" max="{{ $totalAmount }}" min="0" required step="any">
                        </td>

                        <td class="text-center">
                            {{ formatNumber($totalAmount) }}
                        </td>
                    @else
                        @php 
                        $hasVendorproduct = $order->hasVendorProduct();
                        @endphp
                    <td class="text-center">
                     <input type="number" class="form-control amount_receive" name="paid[]" value="{{ $totalAmount - $order->paid }}" max="{{ $totalAmount - $order->paid }}" min="{{ $hasVendorproduct ? $totalAmount - $order->paid : '0' }}" required step="any" {{ $hasVendorproduct ? 'readonly' : '' }}>
                    </td>

                    <td class="text-center">
                        {{ formatNumber($totalAmount - $order->paid) }}
                    </td>
                    @endif

                </tr>
            @endforeach
            </tbody>

        </table>
        <div class="mt-12">
            <span class="badge badge-warning ltr:me-1 rtl:ms-1">{{ __('Note') }}!</span>
            <span>{{ preference('bulk_pay_count') }}&nbsp;{{ __('Order will payable at a single time') }}</span>
        </div>
    </div>
</div>

    

