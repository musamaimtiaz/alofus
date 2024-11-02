<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Favicon icon -->
    @include('gateway::partial.favicon')
    <title>{{ __('Something Went Wrong.') }}</title>
    <link href="{{ asset('Modules/Gateway/Resources/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('Modules/Gateway/Resources/assets/css/gateway.min.css') }}">
</head>

<body>
    <section class="card-width card2 pb-5 failed-block">
        <div class="svg-1">
            @include('gateway::partial.logo')
        </div>
        <h5 class="text-center my-4">
            {{ $message ?? __('Something went wrong when processing the payment. Please retry later.') }}</h5>
    </section>
    <script src="{{ asset('Modules/Gateway/Resources/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('Modules/Gateway/Resources/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        var response = {
            {
                status: "failed",
                message: "{{ __('Payment failed') }}",
            }
        }
    </script>
    <script src="{{ asset('Modules/Gateway/Resources/assets/js/app.min.js') }}"></script>
</body>

</html>
