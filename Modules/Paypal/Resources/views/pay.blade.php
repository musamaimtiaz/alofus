@extends('gateway::layouts.payment')

@section('logo', asset(moduleConfig('paypal.logo')))
@section('gateway', moduleConfig('paypal.name'))

@section('content')
    <div class="straight-line"></div>
    @include('gateway::partial.instruction')
    <form action="{{ route('gateway.complete', withOldQueryIntegrity(['gateway' => moduleConfig('paypal.alias')])) }}"
        method="post" id="payment-form" class="pay-form">
        @csrf
        <button type="submit" class="pay-button sub-btn">
            <span>{{ __('Pay With Paypal') }}
        </button>
    </form>
@endsection
