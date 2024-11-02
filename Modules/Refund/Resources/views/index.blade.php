@extends('admin.layouts.app')
@section('page_title', __('Refunds'))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/product.min.css') }}">
@endsection
@section('content')

<!-- Main content -->
<div class="col-sm-12 list-container" id="refund-list-container">
    <div class="card">
        <div class="card-header bb-none pb-0">
            <h5>{{ __('Refunds') }}</h5>
            <x-backend.group-filters :groups="$groups" :column="'status'" />
            <div class="card-header-right my-2 mx-md-0 mx-sm-4">
                <x-backend.button.export />
                <x-backend.button.filter />
            </div>
        </div>

        <x-backend.datatable.filter-panel>
            <div class="col-md-12">
                <x-backend.datatable.input-search />
            </div>
        </x-backend.datatable.filter-panel>
        <x-backend.datatable.table-wrapper>
            @include('admin.layouts.includes.yajra-data-table')
        </x-backend.datatable.table-wrapper>
    </div>
</div>
@endsection

@section('js')
    <script type="text/javascript">
        'use strict';
        var pdf = "{{ (in_array('Modules\Refund\Http\Controllers\RefundController@pdf', $prms)) ? '1' : '0' }}";
        var csv = "{{ (in_array('Modules\Refund\Http\Controllers\RefundController@csv', $prms)) ? '1' : '0' }}";
    </script>
    <script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/permission.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/refund.min.js') }}"></script>
@endsection
