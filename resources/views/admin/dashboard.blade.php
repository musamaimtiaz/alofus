@extends('admin.layouts.app')
@section('page_title', __('Dashboard'))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/gridstack/css/gridstack.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/datta-able/css/pages/gridstack.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/datta-able/fonts/material/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/Responsive-2.2.5/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/custom.min.css') }}">
@endsection

@section('content')   
    @include('admin.dashboxes.widget-option', ['route' => route('dashboard.forget_widget')])
    <!-- Main content -->
    <div class="dashboard grid-stack mb-20p p-0" data-gs-width="12" data-gs-animate="yes">
        @foreach ($widget as $key => $item)
            @continue(isset($value['visibility']) ? !$value['visibility'] : false)
            @php
                $item['gs'] = array_merge(['x' => 0, 'y' => 40, 'width' => 4, 'height' => 1], $item['gs'] ?? []);
            @endphp
            <div class="grid-stack-item" data-gs-id="{{ $key }}" 
                @foreach ($item['gs'] as $k => $v)
                    {{ 'data-gs-' . $k . '=' . $v }}
                @endforeach
                >
                <div class="grid-stack-item-content">
                    <i class="grid-icon fas fa-arrows-alt"></i>
                    <div class="w-100 h-100">
                        @if (is_callable($item['content']))
                            {!! $item['content']() !!}
                        @else
                            @includeIf($item['content'])
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('js')
    <script>
        const localeString = "{{ app()->getLocale() }}";
        const mostSoldProductsUrl = "{{ route('dashboard.most-sold-products') }}";
        const mostActiveUsersUrl = "{{ route('dashboard.most-active-users') }}";
        const vendorStatsUrl = "{{ route('dashboard.vendor-stats') }}";
        const vendorStatsUrlDaily = "{{ route('dashboard.vendor-stats-type','daily') }}";
        const vendorStatsUrlWeekly = "{{ route('dashboard.vendor-stats-type','weekly') }}";
        const vendorStatsUrlMonthly = "{{ route('dashboard.vendor-stats-type','monthly') }}";
        const vendorStatsUrlYearly = "{{ route('dashboard.vendor-stats-type','yearly') }}";
        const salesOfThisMonth = "{{ route('dashboard.sales-of-this-month') }}";
        const vendorEdiUrl = "{{ route('vendors.edit', ['id' => '__id__']) }}";
        const vendorReqsUrl = "{{ route('dashboard.vendor-req') }}";
        const dashboardCacheWidgetElement = @json($dashboardWidgetElement);
        const dashboardCacheWidgetOption = @json($dashboardWidgetOption);
        const widgetOptions = @json(config('martvill.widget_options'));
    </script>
    
    <script src="{{ asset('public/dist/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/gridstack/js/lodash.min.js') }}"></script>
    <script src="{{ asset('public/dist/plugins/jQueryUI/jquery.ui.touch-punch.min.js') }}"></script>

    <script src="{{ asset('public/datta-able/plugins/gridstack/js/gridstack.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/gridstack/js/gridstack.jQueryUI.min.js') }}"></script>

    <script src="{{ asset('public/dist/plugins/DataTables-1.10.21/js/jquery.dataTablesCus.min.js') }}"></script>
    <script src="{{ asset('public/dist/plugins/Responsive-2.2.5/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/moment.min.js') }}"></script>
    <script src="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/chart-chartjs/js/Chart-2019.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/sweetalert/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/dashboard.min.js') }}"></script>
@endsection
