<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" dir="{{ languageDirection() }}">

<head>
    @doAction('after_vendor_panel_head')

    <title>{{ trimWords(preference('company_name'), 17) }} | @yield('page_title', env('APP_NAME', ''))</title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
        <script src="{{ asset('public/dist/js/respond.min.js') }}"></script>
    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    @include('vendor.layouts.includes.meta')
    <!-- Favicon icon -->
    @php
        $favicon = App\Models\Preference::getFavicon();
    @endphp
    @if (!empty($favicon))
        <link rel='shortcut icon' href="{{ $favicon }}" type='image/x-icon' />
    @endif
    <link rel="stylesheet" href="{{ asset('public/datta-able/fonts/fontawesome/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/datta-able/fonts/material/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/datta-able/fonts/flag/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/animation/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/bootstrap-v5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/datta-able/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/datta-able/fonts/feather/css/feather.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/jquery-scrollbar/css/jquery.scrollbar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/datta-able//fonts/datta/datta-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/jquery-scrollbar/css/perfect-scrollbar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/custom.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/vendor-responsiveness.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/select2/css/select2.min.css') }}">

    <!--Custom CSS that was written on view-->

    @doAction("before_vendor_panel_css_{$view_name}")

    @yield('parent-css')

    @doAction("after_vendor_panel_css_{$view_name}")

    <!-- Theme style RTL -->
    @if (\Cache::get(config('cache.prefix') . '-language-direction') == 'rtl')
        <link rel="stylesheet" href="{{ asset('public/datta-able/css/layouts/rtl.min.css') }}">
    @endif


    @if (file_exists(base_path('public/js/lang/' . config('app.locale') . '.js')))
        <script src="{{ asset('public/js/lang/' . config('app.locale') . '.js') }}"></script>
    @else
        <script type="text/javascript">
            const translates = {};
        </script>
    @endif
    <script type="text/javascript">
        'use strict';
        var SITE_URL = "{{ URL::to('/vendor') }}";
        var ADMIN_SITE_URL = "{{ URL::to('/admin') }}";
        var currencySymbol = '{!! currency()->symbol !!}';
        var decimal_digits = '{!! preference('decimal_digits') !!}';
        var thousand_separator = '{!! preference('thousand_separator') !!}';
        var symbol_position = '{!! preference('symbol_position') !!}';
        var dateFormat = '{!! preference('date_format_type') !!}';
        var token = '{!! csrf_token() !!}';
        var app_locale_url = "{!! url('/resources/lang/' . config('app.locale') . '.json') !!}";
        var row_per_page = '{!! preference('row_per_page') !!}';
        var language_direction = '{!! \Cache::get(config('cache.prefix') . '-language-direction') !!}';
        var summernote_regex = /<\/*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|ilayer|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|t(?:itle|extarea)|xml)[^>]*?>/gi;
    </script>

    <!-- Required Js -->
    <script src="{{ asset('public/datta-able/plugins/bootstrap-v5/js/popper.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/bootstrap-v5/js/jquery.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/bootstrap-v5/js/slim.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/bootstrap-v5/js/bootstrap.min.js') }}"></script>
    @doAction('before_vendor_panel_head')
</head>

@php
    $appName = env('APP_NAME', '');
    $appName = !empty($appName) && mb_strlen($appName) > 19 ? mb_substr($appName, 0, 17) . '..' : $appName;
@endphp

<body <?php echo apply_filters('vendor_panel_body_tag', ''); ?>>
    @doAction('after_vendor_panel_body')
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <!-- [ navigation menu ] start -->
    @doAction('before_vendor_panel_sidebar')
    @include('vendor.layouts.includes.sidebar')
    <!-- [ navigation menu ] end -->

    <!-- [ Header ] start -->
    @doAction('before_vendor_panel_header')
    @include('vendor.layouts.includes.header')
    @doAction('after_vendor_panel_header')
    <!-- [ Header ] end -->

    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <!-- [ breadcrumb ] start -->
                    @include('vendor.layouts.includes.notifications')
                    <!-- [ breadcrumb ] end -->
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            @doAction('before_vendor_panel_content')
                            @doAction("before_vendor_panel_content_{$view_name}")
                            <div class="row">
                                <div class="col-sm-12 list-container">
                                    @yield('parent-content')
                                </div>
                            </div>
                            @doAction('after_vendor_panel_content')
                            @doAction("after_vendor_panel_content_{$view_name}")
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- [ Main Content ] end -->

    <!-- Warning Section start -->
    <!-- Older IE warning message -->
    <!--[if lt IE 11]>
        <div class="ie-warning">
            <h1>{{ __('Warning') }}!!</h1>
            <p>{{ __('You are using an outdated version of Internet Explorer, please upgrade to any of the following web browsers to access this website.') }}
            </p>
            <div class="iew-container">
                <ul class="iew-download">
                    <li>
                        <a href="//www.google.com/chrome/">
                            <img src="{{ asset('public/datta-able/images/browser/chrome.png') }}" alt="Chrome">
                            <div>Chrome</div>
                        </a>
                    </li>
                    <li>
                        <a href="//www.mozilla.org/en-US/firefox/new/">
                            <img src="{{ asset('public/datta-able/images/browser/firefox.png') }}" alt="Firefox">
                            <div>Firefox</div>
                        </a>
                    </li>
                    <li>
                        <a href="//www.opera.com">
                            <img src="{{ asset('public/datta-able/images/browser/opera.png') }}" alt="Opera">
                            <div>Opera</div>
                        </a>
                    </li>
                    <li>
                        <a href="//www.apple.com/safari/">
                            <img src="{{ asset('public/datta-able/images/browser/safari.png') }}" alt="Safari">
                            <div>Safari</div>
                        </a>
                    </li>
                    <li>
                        <a href="//windows.microsoft.com/en-us/internet-explorer/download-ie">
                            <img src="{{ asset('public/datta-able/images/browser/ie.png') }}" alt="{{ __('Image') }}">
                            <div>IE (11 & above)</div>
                        </a>
                    </li>
                </ul>
            </div>
            <p>{{ __('Sorry for the inconvenience!') }}</p>
        </div>
    <![endif]-->
    <!-- Warning Section Ends -->
    {{-- Custom Js --}}
    <!-- Required Js -->
    <script src="{{ asset('public/dist/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/js/pcoded.min.js') }}"></script>
    <!-- Custom Js -->
    <script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/app-layout.min.js?v=2.0') }}"></script>
    @doAction("before_vendor_panel_js_{$view_name}")
    @yield('parent-js')
    @doAction("after_vendor_panel_js_{$view_name}")
    
    @doAction('before_vendor_panel_body')
</body>

</html>
