<!DOCTYPE html>
  <head>
      <title>{{ trimWords(preference('company_name'), 17) }} | {{ !empty($page_title) ? $page_title : __('Customer Relationship & Project Management')}}</title>
      <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 10]>
        <script src="{{ asset('public/dist/js/respond.min.js') }}"></script>
      <![endif]-->
      <!-- Meta -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0, minimal-ui">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      @include('layouts.includes.meta')
      <!-- Favicon icon -->
      @php
        $favicon = App\Models\Preference::getFavicon();
      @endphp
      @if(!empty($favicon))
        <link rel='shortcut icon' href="{{ $favicon }}" type='image/x-icon' />
      @endif

      <!-- fontawesome icon -->
      <link rel="stylesheet" href="{{ asset('public/datta-able/fonts/fontawesome/css/fontawesome-all.min.css') }}">
      <!-- material icon -->
      <link rel="stylesheet" href="{{ asset('public/datta-able/fonts/material/css/materialdesignicons.min.css') }}">
      <!-- flaq icon -->
      <link rel="stylesheet" href="{{ asset('public/datta-able/fonts/flag/css/flag-icon.min.css') }}">
      <!-- animation css -->
      <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/animation/css/animate.min.css') }}">
      <!-- vendor css -->
      <link rel="stylesheet" href="{{ asset('public/datta-able/css/style.min.css') }}">
      <link rel="stylesheet" href="{{ asset('public/dist/css/custom.min.css') }}">

      <!--Custom CSS that was written on view-->
      @yield('css')

      <!-- Theme style RTL -->
      @php
        if (\Cache::get(config('cache.prefix') . '-language-direction') == 'rtl') {
      @endphp
          <link rel="stylesheet" href="{{ asset('public/datta-able/css/layouts/rtl.min.css') }}">
      @php } @endphp
    @if(file_exists(base_path('public/js/lang/' . config('app.locale') . '.js')))
        <script src="{{ asset('public/js/lang/' . config('app.locale') . '.js') }}"></script>
    @else
        <script type="text/javascript">const translates = {}</script>
    @endif
      <script type="text/javascript">
        'use strict';
        var SITE_URL              = "{{ URL::to('/') }}";
        var currencySymbol        = '{!! currency()->symbol !!}';
        var decimal_digits = '{!! preference('decimal_digits') !!}';
        var thousand_separator = '{!! preference('thousand_separator') !!}';
        var symbol_position = '{!! preference('symbol_position') !!}';
        var dateFormat = '{!! preference('date_format_type') !!}';
        var token                 = '{!! csrf_token() !!}';
        var app_locale_url        = "{!! url('/resources/lang/' . config('app.locale') . '.json') !!}";
        var row_per_page          = '{!! preference('row_per_page') !!}';
        var language_direction    = '{!! \Cache::get(config('cache.prefix') . '-language-direction') !!}';
    </script>

      <!-- Required Js -->
      <script src="{{ asset('public/datta-able/js/vendor-all.min.js') }}"></script>

  </head>

  <?php
    $appName = env('APP_NAME', '');
    $appName = (!empty($appName) && mb_strlen($appName) > 19) ? mb_substr($appName, 0, 17) .'..' : $appName;
  ?>

  <body>
      <!-- [ Pre-loader ] start -->
      <div class="loader-bg">
          <div class="loader-track">
              <div class="loader-fill"></div>
          </div>
      </div>
      <!-- [ Pre-loader ] End -->

      <!-- [ navigation menu ] start -->
      @include('layouts.includes.customer_sidebar')
      <!-- [ navigation menu ] end -->

      <!-- [ Header ] start -->
      @include('layouts.includes.customer_header')
      <!-- [ Header ] end -->

      <!-- [ Main Content ] start -->
      <div class="pcoded-main-container">
          <div class="pcoded-wrapper">
              <div class="pcoded-content">
                  <div class="pcoded-inner-content">
                      <!-- [ breadcrumb ] start -->
                      @include('layouts.includes.notifications')

                      {{--@include('layouts.partial.notifications')--}}

                      <!-- [ breadcrumb ] end -->
                      <div class="main-body">
                          <div class="page-wrapper">
                              <!-- [ Main Content ] start -->
                              <div class="row">
                                  @yield('content')
                              </div>
                              <!-- [ Main Content ] end -->
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <div class="modal fade" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">{{ __('Delete Parmanently') }}</h4>
            </div>
            <div class="modal-body">
              <p>{{ __('Are you sure about this?') }}</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
              <button type="button" class="btn btn-danger" id="confirm">{{ __('Delete') }}</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Required Js -->
      <script src="{{ asset('public/datta-able/js/pcoded.min.js') }}"></script>
      <script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>

      <script src="{{ asset('public/dist/js/moment.min.js') }}"></script>
      <script src="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}"></script>
      <!-- Custom Js -->
      <script type="text/javascript">
        'use strict';
        var startDate = "{!! isset($from) ? $from : 'undefined' !!}";
        var endDate   = "{!! isset($to) ? $to : 'undefined' !!}";
        </script>
      <script src="{{ asset('public/dist/js/custom/customer-panel.min.js') }}"></script>
      @yield('js')
  </body>

</html>
