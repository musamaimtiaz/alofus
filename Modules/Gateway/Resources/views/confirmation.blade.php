<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Favicon icon -->
    @include('gateway::partial.favicon')
    <title>{{ __('Payment confirmed') }}</title>
    <link href="{{ asset('Modules/Gateway/Resources/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('Modules/Gateway/Resources/assets/css/gateway.min.css') }}">
</head>

<body>
    <section class="card-width card2 pb-5 confirmed-block">
        <div class="svg-1">
            @include('gateway::partial.logo')
        </div>
        <div class="amount-gateway">
            <div>
                <p class="para-1">{{ __('Amount paid') }}</p>
                <p class="para-2">{{ formatNumber($purchaseData->total) }}</p>
            </div>
            <div>
                <p class="para-1 text-end">{{ __('GATEAWAY') }}</p>
                <img class="mt-2 gateway-logo" src="{{ asset(moduleConfig(strtolower($purchaseData->gateway) . '.logo')) }}"
                    alt="{{ __('Image') }}" />
            </div>
        </div>
        <h5 class="text-center my-4">{{ __('Payment has been confirmed. You can close this screen in 3 seconds.') }}
        </h5>
    </section>
    <script>
        var response = {!! $purchaseData !!};
    </script>
    <script src="{{ asset('Modules/Gateway/Resources/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('Modules/Gateway/Resources/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('Modules/Gateway/Resources/assets/js/app.min.js') }}"></script>
</body>

</html>
