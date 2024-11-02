<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>{{ __(":x installer", ["x" => env('APP_NAME')]) }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('public/dist/css/materialize.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/dist/css/installer.min.css') }}">
        @yield('style')
    </head>
    <body>
        @yield('content')

        <script src="{{ asset('public/dist/js/jquery.min.js') }}"></script>
        <script src="{{ asset('public/dist/js/materialize.min.js') }}"></script>
        @yield('script')
    </body>
</html>
