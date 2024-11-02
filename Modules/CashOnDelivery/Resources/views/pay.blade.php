@extends('gateway::layouts.payment')

@section('logo', asset(moduleConfig('cashondelivery.logo')))

@section('gateway', moduleConfig('cashondelivery.name'))

@section('content')
    <div class="straight-line"></div>

    <div class="col-md-12">
        <h3 class="text-center my-4">{{ __('Cash On Delivery') }}</h3>
        @include('gateway::partial.instruction')
    </div>
    <div class="col-md-12 p-4 payment-box align-center mt-2">
        @php
            $codResponse = \App\Models\Order::checkCashOnDelivery($purchaseData);
        @endphp
        @if ($codResponse['status'] == true && $codResponse['notAvailable'] == false)
            <form
                action="{{ route('gateway.complete', withOldQueryIntegrity(['gateway' => moduleConfig('cashondelivery.alias')])) }}"
                method="post" id="payment-form">
                @csrf
                <button type="submit" class="pay-button sub-btn">
                    <span>{{ __('Confirm') }}
                </button>
            </form>
        @else
            <div class="field full align-left">
                <div id="card-errors">
                    <span> {{ __('Cash on delivery is not available for this order') }} </span>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('css')
@endsection
