<link rel="stylesheet" href="{{ asset('public/dist/plugins/Responsive-2.2.5/css/responsive.dataTables.min.css') }}">
 {{--  --}}
<!-- daterange picker -->
<link rel="stylesheet" href="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}">
@if (\Cache::get(config('cache.prefix') . '-language-direction') == 'rtl')
<link rel="stylesheet" href="{{ asset('public/datta-able/css/layouts/rtl.min.css') }}">
@endif

<div class="table-responsive yajra-data-table-main">
    {!! $dataTable->table([
        'class' => 'table table-bordered dt-responsive',
        'width' => '100%',
        'cellspacing' => '0',
    ]) !!}
</div>

<script src="{{ asset('public/dist/plugins/DataTables-1.10.21/js/jquery.dataTablesCus.min.js') }}"></script>
<script src="{{ asset('public/dist/plugins/Responsive-2.2.5/js/dataTables.responsive.min.js') }}"></script>

{!! $dataTable->scripts() !!}

<script src="{{ asset('public/dist/js/custom/yajra-custom.min.js') }}"></script>
