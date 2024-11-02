<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $favicon = App\Models\Preference::getFavicon();
    @endphp
    @if (!empty($favicon))
        <link rel='shortcut icon' href="{{ $favicon }}" type='image/x-icon' />
    @endif
    <title>{{ trimWords(preference('company_name'), 17) }} | @yield('page_title', env('APP_NAME', ''))</title>

    @include('admin.layouts.includes.meta')

    <link rel="stylesheet" type="text/css"
        href="{{ asset('Modules/FormBuilder/Resources/assets/js/footable/css/footable.standalone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/datta-able/fonts/fontawesome/css/fontawesome-all.min.css') }}">
    <!-- vendor css -->
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/bootstrap-v5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/datta-able/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/datta-able/fonts/feather/css/feather.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('public/datta-able/plugins/jquery-scrollbar/css/jquery.scrollbar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/datta-able/fonts/datta/datta-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/jquery-scrollbar/css/perfect-scrollbar.min.css') }}">


    <link rel="stylesheet" href="{{ asset('public/dist/css/custom.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('Modules/FormBuilder/Resources/assets/css/styles.min.css') }}">
    @yield('css')
    @if(file_exists(base_path('public/js/lang/' . config('app.locale') . '.js')))
        <script src="{{ asset('public/js/lang/' . config('app.locale') . '.js') }}"></script>
    @else
        <script type="text/javascript">const translates = {}</script>
    @endif
    <script type="text/javascript">
        'use strict';
        var SITE_URL = "{{ URL::to('/admin') }}";
        var ADMIN_SITE_URL = "{{ URL::to('/admin') }}";
        var currencySymbol = '{!! currency()->symbol !!}';
        var token = '{!! csrf_token() !!}';
        var decimal_digits = '{!! preference('decimal_digits') !!}';
        var thousand_separator = '{!! preference('thousand_separator') !!}';
        var symbol_position = '{!! preference('symbol_position') !!}';
        var dateFormat = '{!! preference('date_format_type') !!}';
        var app_locale_url = "{!! url('/resources/lang/' . config('app.locale') . '.json') !!}";
        var row_per_page = '{!! preference('row_per_page') !!}';
        var language_direction = '{!! \Cache::get(config('cache.prefix') . '-language-direction') !!}';
    </script>

</head>

<body>
    <div class="container">
        <div class="row justify-content-center min-h-100 align-items-center">
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('public/datta-able/plugins/bootstrap-v5/js/popper.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/bootstrap-v5/js/jquery.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/bootstrap-v5/js/slim.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/bootstrap-v5/js/bootstrap.min.js') }}"></script>

    <script type="text/javascript">
        window.FormBuilder = {
            csrfToken: '{{ csrf_token() }}',
        }
    </script>
    <script src="{{ asset('Modules/FormBuilder/Resources/assets/js/jquery-ui.min.js') }}" defer></script>
    <script src="{{ asset('Modules/FormBuilder/Resources/assets/js/sweetalert.min.js') }}" defer></script>

    <script src="{{ asset('Modules/FormBuilder/Resources/assets/js/jquery-formbuilder/form-render.min.js') }}" defer>
    </script>
    <script src="{{ asset('Modules/FormBuilder/Resources/assets/js/parsleyjs/parsley.min.js') }}" defer></script>
    <script src="{{ asset('Modules/FormBuilder/Resources/assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('Modules/FormBuilder/Resources/assets/js/script.min.js') }}" defer></script>
    @yield('script')
</body>

</html>
