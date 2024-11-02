@extends('gateway::layouts.master')

@section('content')
    @forelse ($gateways as $gateway)
        <a href="{{ route('gateway.pay', withOldQueryIntegrity(['gateway' => $gateway->alias])) }}" class="pay-box">
            <div class="grow">
                <img class="image-2" src="{{ asset(moduleConfig($gateway->alias . '.logo')) }}" alt="{{ __('Image') }}" />
            </div>
        </a>
    @empty
        <a href="javascript:void(0)" onclick="history.back()" class="pay-box">
            <div class="grow">
                <h3>{{ __('No gateway found.') }}</h3>
            </div>
        </a>
    @endforelse
@endsection
