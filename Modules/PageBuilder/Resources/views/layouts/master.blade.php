<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0, minimal-ui">
    @include('admin.layouts.includes.meta')
    <!-- Favicon icon -->
    @php
        $favicon = App\Models\Preference::getFavicon();
    @endphp
    @if (!empty($favicon))
        <link rel='shortcut icon' href="{{ $favicon }}" type='image/x-icon' />
    @endif
    <title>@yield('page_title', env('APP_NAME', '')) | {{ __('Page Builder') }}</title>


    @stack('styles')
    <script type="text/javascript">
        'use strict';
        var csrfToken = '{!! csrf_token() !!}';
    </script>
</head>

<body>
    @yield('content')
    @if(file_exists(base_path('public/js/lang/' . config('app.locale') . '.js')))
        <script src="{{ asset('public/js/lang/' . config('app.locale') . '.js') }}"></script>
    @else
        <script type="text/javascript">const translates = {}</script>
    @endif
    <script src="{{ asset('public/dist/js/jquery.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/bootstrap-v5/js/slim.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/bootstrap-v5/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/js/pcoded.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/app-layout.min.js') }}"></script>
    @stack('scripts')
</body>

</html>
