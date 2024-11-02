@extends('gateway::layouts.payment')

@section('logo', asset(moduleConfig('stripe.logo')))

@section('gateway', moduleConfig('stripe.name'))

@section('content')
    <p class="para-6">{{ __('Fill in the required information') }}</p>
    <div class="straight-line"></div>

    @include('gateway::partial.instruction')

    <form class="pay-form needs-validation"
        action="{{ route('gateway.complete', withOldQueryIntegrity(['gateway' => moduleConfig('stripe.alias')])) }}" method="post"
        id="payment-form">
        @csrf

        <button type="submit" class="pay-button sub-btn">{{ __('Pay With Stripe') }}</button>
    </form>
@endsection

@section('css')
@endsection

@section('js')
@endsection
