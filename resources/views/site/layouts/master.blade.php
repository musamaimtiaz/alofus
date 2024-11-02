<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" dir="{{ languageDirection() }}">

<head>
    @doAction('after_site_head')
    @includeIf('googleanalytics::partials.google_analytics_header')

    <title>{{ trimWords(preference('company_name'), 17) }} | @yield('page_title', env('APP_NAME', ''))</title>
    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @yield('seo')
    @php
        $themeOption = \Modules\CMS\Http\Models\ThemeOption::getAll();

        $layout = 'default';
        if (!isset($page->layout)) {
            $page = \Modules\CMS\Entities\Page::firstWhere('default', '1');
        }
        $layout = $page->layout;
        $primaryColor = option($layout . '_template_primary_color', '#FCCA19');

        [$fontFamily, $genericFamily] = explode(',', option($layout . '_template_font_family', 'DM Sans, sans-serif'));

    @endphp
    <style>
        :root {
            --primary-color: {{ $primaryColor }};
            --global-font: {{ $fontFamily . ',' . $genericFamily }};
            --semi-primary-color: {{ $primaryColor . '11' }};
        }
    </style>
    <link rel="stylesheet" href="{{ asset('public/css/app.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/css/tailwind-custom.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/swiper/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/google-font-roboto.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/jQueryUI/jquery-ui.min.css') }}" type="text/css" />

    @php
        $favicon = App\Models\Preference::getFavicon();
    @endphp
    @if (!empty($favicon))
        <link rel='shortcut icon' href="{{ $favicon }}" type='image/x-icon' />
    @endif
    <!--Custom CSS that was written on view-->
    @doAction("before_site_css_{$view_name}")

    @yield('parent-css')

    @doAction("after_site_css_{$view_name}")
    <!-- Menubar css -->
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/ionicon.min.css') }}" />
    <!-- Menubar css end-->

    <!-- Custom CSS-->
    <link rel="stylesheet" href="{{ asset('public/dist/css/site_custom.min.css') }}">

    <!-- User define custom dynamic css file -->
    @if (File::exists('Modules/CMS/Resources/assets/css/user-custom.css'))
        <link rel="stylesheet" href="{{ asset('Modules/CMS/Resources/assets/css/user-custom.css?v=' . time()) }}">
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
        var SITE_URL = "{{ URL::to('/') }}";
        var currencySymbol = '{!! currency()->symbol !!}';
        var decimal_digits = '{!! preference('decimal_digits') !!}';
        var thousand_separator = '{!! preference('thousand_separator') !!}';
        var symbol_position = '{!! preference('symbol_position') !!}';
        var dateFormat = '{!! preference('date_format_type') !!}';
        var token = '{!! csrf_token() !!}';
        var app_locale_url = "{!! url('/resources/lang/' . config('app.locale') . '.json') !!}";
        var row_per_page = '{!! preference('row_per_page') !!}';
        var language_direction = '{!! \Cache::get(config('cache.prefix') . '-language-direction') !!}';
        var totalProductPerPage = '{!! totalProductPerPage() !!}';
        var variationId = null;
        var itemType = '{{ \App\Enums\ProductType::$Simple }}';
        var tempItemType = '{{ \App\Enums\ProductType::$Simple }}';
        var isManageStock = null;
        var stockQty = null;
        var variationAttributeIds = [];
        var backOrders = 0;
        var qtyArray = [];
        var isGroupProduct = false;
        var offerTimer = null;
        var offerTimerDetailsPage = null;
        var tempIsGroupProduct = false;
        @auth
        var userLoggedIn = true;
        @else
            var userLoggedIn = false;
        @endauth
    </script>
    <!-- Required Js -->
    <script src="{{ asset('public/dist/js/jquery.min.js') }}"></script>
    <!-- Affiliate Code Common Header -->
    
    @doAction('before_site_head')
</head>

<body <?php echo apply_filters('site_body_tag', 'class="antialiased min-h-screen"'); ?> x-data="{ 'layout': 'grid' }">
    @doAction('after_site_body')
    @php

        $headerLogo = $themeOption->where('name', $layout . '_template_header_logo')->first();
        $headerMobileLogo = $themeOption->where('name', $layout . '_template_header_mobile_logo')->first();

        $header = option($layout . '_template_header', '');
        $footer = option($layout . '_template_footer', '');
        $isEnableProduct = option($layout . '_template_product', '');

        $footerLogo = $themeOption->where('name', $layout . '_template_footer_logo')->first();
        $googlePlay = $themeOption->where('name', $layout . '_template_google_play')->first();
        $appStore = $themeOption->where('name', $layout . '_template_app_store')->first();
        $downloadGooglePlay = $themeOption->where('name', $layout . '_template_download_google_play_logo')->first();
        $downloadAppStore = $themeOption->where('name', $layout . '_template_download_app_store_logo')->first();
        $paymentMethods = $themeOption->where('name', $layout . '_template_payment_methods')->first();
    @endphp
    <!-- Top nav start -->
    @doAction('before_site_top_nav')

    @include('../site/layouts.includes.top_nav')
    <!-- Top nav end -->

    <!-- header section start -->
    @doAction('before_site_header')

    @include('../site/layouts.includes.header')

    <!-- header section end -->

    <!-- Bottom nav section start-->
    @doAction('before_site_bottom_nav')

    @include('../site/layouts.includes.bottom_nav')

    @doAction('after_site_bottom_nav')
    <!-- Bottom nav section End-->

    <div class="main-body">
        <div class="page-wrapper">
            <!-- Main content -->
            @doAction('before_site_content')
            @doAction("before_site_content_{$view_name}")

            @yield('parent-content')

            @doAction('after_site_content')
            @doAction("after_site_content_{$view_name}")
            <!-- Main content end -->
        </div>
    </div>

    {{-- Modal --}}
    @include('../site/layouts.includes.login_modal')

    <!-- section footer start -->
    @doAction('before_site_footer')

    @include('../site/layouts.includes.footer')

    @doAction('after_site_footer')
    <!-- section footer end -->
    {{-- Item view modal --}}

    @include('../site/layouts.includes.product_view')


    <script src="{{ asset('public/dist/js/custom/site/formatting.min.js') }}"></script>
    <script src="{{ asset('public/frontend/assets/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Custom Js -->
    <script src="{{ asset('public/dist/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/frontend/assets/js/alpine.min.js') }}" defer></script>
    <script src="{{ asset('public/dist/js/custom/site/drawer.min.js') }}"></script>
    <script src="{{ asset('public/frontend/assets/js/script.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/cart.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/lang.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/site-nav.min.js') }}"></script>
    <script src="{{ asset('public/frontend/assets/js/sweet-alert2.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/site.min.js') }}"></script>
    <script src="{{ asset('public/frontend/assets/js/main.min.js') }}"></script>

    @doAction("before_site_js_{$view_name}")

    @yield('parent-js')

    @doAction("after_site_js_{$view_name}")

    <!-- User define custom dynamic js file -->
    @if (File::exists('Modules/CMS/Resources/assets/js/user-custom.js'))
        <script src="{{ asset('Modules/CMS/Resources/assets/js/user-custom.js?v=' . time()) }}"></script>
    @endif

    @doAction('before_site_body')
</body>

</html>
