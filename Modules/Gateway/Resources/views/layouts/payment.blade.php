<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Favicon icon -->
    @include('gateway::partial.favicon')
    <title>@yield('gateway') {{ __('Payment') }}</title>
    <link href="{{ asset('Modules/Gateway/Resources/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('Modules/Gateway/Resources/assets/css/gateway.min.css') }}">
    @yield('css')
</head>

<body>
    <section class="card-width card2">
        <div class="payment-loader">
            <div class="sp sp-circle"></div>
        </div>
        </div>
        <div class="svg-1">
            @include('gateway::partial.logo')
        </div>
        <div class="amount-gateway">
            <div>
                <p class="para-1">{{ __('Amount to be paid') }}</p>
                <p class="para-2">{{ formatNumber($purchaseData->total) }}</p>
            </div>
            <div>
                <p class="para-1 text-end">{{ __('GATEAWAY') }}</p>
                <img class="mt-2 gateway-logo" src="@yield('logo')" alt="{{ __('Image') }}" />
            </div>
        </div>
        @yield('content')
        <a href="#" onclick="history.back()" class="d-flex my-4 position-relative back">
            <svg class="arrow position-absolute" xmlns="http://www.w3.org/2000/svg" width="15" height="10"
                viewBox="0 0 15 10" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M4.70711 0L6.12132 1.41421L3.82843 3.70711H13.4142C13.9665 3.70711 14.4142 4.15482 14.4142 4.70711C14.4142 5.25939 13.9665 5.70711 13.4142 5.70711H3.82843L6.12132 8L4.70711 9.41421L0 4.70711L4.70711 0Z" fill="currentColor" />
            </svg>{{ __('Back') }}
        </a>
    </section>

    <script src="{{ asset('Modules/Gateway/Resources/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('Modules/Gateway/Resources/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('Modules/Gateway/Resources/assets/js/app.min.js') }}"></script>
    @yield('js')
</body>

</html>
