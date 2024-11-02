<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" dir="{{ languageDirection() }}">

<head>
    <title>{{ trimWords(preference('company_name'), 17) }} | @yield('page_title', env('APP_NAME', ''))</title>
    <meta charset="UTF-8">
    <meta rel="stylesheet" name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('public/css/tailwind-custom.min.css') }}" />
    <link href="{{ asset('public/frontend/assets/css/google-font-inter.min.css') }}" >
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/main.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/css/app.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/dark.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/datta-able/fonts/fontawesome/css/fontawesome-all.min.css') }}">
    <script src="{{ asset('public/frontend/assets/js/alpine.min.js') }}" defer></script>
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/user-panel.min.css') }}">
    @if(file_exists(base_path('public/js/lang/' . config('app.locale') . '.js')))
        <script src="{{ asset('public/js/lang/' . config('app.locale') . '.js') }}"></script>
    @else
        <script type="text/javascript">const translates = {}</script>
    @endif
    @php
        $favicon = App\Models\Preference::getFavicon();
    @endphp
    @if(!empty($favicon))
        <link rel='shortcut icon' href="{{ $favicon }}" type='image/x-icon' />
    @endif
    @php
        $page = \Modules\CMS\Entities\Page::firstWhere('default', '1');
        $layout = $page->layout;
        $primaryColor = option($layout . '_template_primary_color', '#FCCA19');
    @endphp
    <style>
        :root{
            --primary-color: {{ $primaryColor }};
        }
    </style>
    @yield('parent-css')
    <link rel="stylesheet" href="{{ asset('public/dist/css/site_custom.min.css') }}">
    <script type="text/javascript">
        'use strict';
        var SITE_URL              = "{{ URL::to('/') }}";
        var token                 = '{!! csrf_token() !!}';
        var language_direction = '{!! \Cache::get(config('cache.prefix') . '-language-direction') !!}';
    </script>

    <!-- Required Js -->
    <script src="{{ asset('public/dist/js/jquery.min.js') }}"></script>

</head>

<!-- partial:index.partial.html -->

<body class="antialiased bg-gray-100 overflow-hidden m-0" x-data="{'darkMode': false}" x-init="
darkMode = JSON.parse(localStorage.getItem('darkMode'));
$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))">
@php
    $themeOption = \Modules\CMS\Http\Models\ThemeOption::getAll();
    $headerMobileLogo = $themeOption
        ->where('name', 'default_template_header_mobile_logo')
        ->first();
@endphp
<div :class="{'dark': darkMode === true}">
    <div class=" dark:bg-red-2 dark:text-gray-100 ">


        <div x-data="{ sidemenu: false }" class="h-screen flex overflow-hidden" x-cloak
             @keydown.window.escape="sidemenu = false">
                <!-- sidebar start -->
                @include('site.layouts.user_panel.includes.sidebar')
                <!-- sidebar end -->
                <div class="flex-1 flex-col relative z-0 overflow-y-auto pb-8 dark:bg-red-1 bg-white">
                <!-- header start -->
               @include('../site/layouts.user_panel.includes.header')
                <!-- header end -->
                @include('../site/layouts.user_panel.includes.notifications')
                <!-- content start-->
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- Main content -->
                         @yield('parent-content')
                    </div>
                </div>
                <!-- content end -->
            </div>
        </div>
    </div>
    <!-- partial -->
    <script src="{{ asset('public/frontend/assets/js/user-dashboard.min.js') }}"></script>
@yield('parent-js')

</body>

</html>
