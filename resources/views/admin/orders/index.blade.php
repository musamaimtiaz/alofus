@extends('admin.layouts.app')
@section('page_title', __('Orders'))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/dist/css/admin-order.min.css') }}">
@endsection
@section('content')
    <!-- Main content -->
    <div class="col-sm-12 list-container" id="order-list-container">
        <div class="card">
            <div class="card-header bb-none pb-0">
                <h5>{{ __('Orders') }}</h5>
                <x-backend.group-filters :groups="$groups" :column="'order_status_id'" />
                <div class="card-header-right my-2 mx-md-0 mx-sm-4">
                    
                    @if(isActive('BulkPayment'))
                    @include('bulkpayment::admin.batch_pay_button')
                    @endif
                    <x-backend.button.batch-delete />
                    <x-backend.button.filter />
                </div>
            </div>

            <x-backend.datatable.filter-panel>
                <div class="col-md-3">
                    <x-backend.datatable.input-search />
                </div>
                <div class="col-md-3 ">
                    <div class="input-group">
                        <button type="button" class="form-control date-drop-down" id="daterange-btn">
                            <span class="ltr:float-left rtl:float-right"><i class="fa fa-calendar"></i> {{ __('Date range picker') }}</span>
                            <i class="fa fa-caret-down ltr:float-right rtl:float-left pt-1"></i>
                        </button>
                    </div>
                </div>
                <input class="form-control" id="startfrom" type="hidden" name="from">
                <input class="form-control" id="endto" type="hidden" name="to">

                <select class="filter display-none" name="start_date" id="start_date"></select>

                <select class="filter display-none" name="end_date" id="end_date"></select>

                <div class="col-md-3">
                    <select class="select2 filter" name="vendor_id" id="vendor_id">
                        <option value="">{{ __('All :x', ['x' => __('Vendors')]) }}</option>
                        @foreach ($vendors as $allVendor)
                            <option value="{{ $allVendor->vendor_id }}">{{ optional($allVendor->vendor)->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <select class="select2-hide-search filter" name="payment_status" id="payment_status">
                        <option value="">{{ __('All :x', ['x' => __('Payment Status')]) }}</option>
                            <option value="Paid">{{ __('Paid') }}</option>
                           <option value="Unpaid">{{ __('Unpaid') }}</option>
                        <option value="Partial">{{ __('Partial') }}</option>
                    </select>
                </div>
            </x-backend.datatable.filter-panel>

            <x-backend.datatable.table-wrapper class="order-list-table need-batch-operation" data-namespace="\App\Models\Order" data-column="id">
                @include('admin.layouts.includes.yajra-data-table')
            </x-backend.datatable.table-wrapper>
            
            @include('admin.layouts.includes.delete-modal')
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('public/dist/js/moment.min.js') }}"></script>
    <script src="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}"></script>
    <script type="text/javascript">
        'use strict';
        var pdf = "{{ (in_array('App\Http\Controllers\OrderController@pdf', $prms)) ? '1' : '0' }}";
        var csv = "{{ (in_array('App\Http\Controllers\OrderController@csv', $prms)) ? '1' : '0' }}";
        var startDate = "{!! isset($from) ? $from : 'undefined' !!}";
        var endDate   = "{!! isset($to) ? $to : 'undefined' !!}";
    </script>
    <script src="{{ asset('public/dist/js/custom/permission.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/order.min.js') }}"></script>
    @if(isActive('BulkPayment'))
        <script>
            var countBulkPayment = '{{ preference('bulk_pay_count') }}';
        </script>
        <script src="{{ asset('Modules/BulkPayment/Resources/assets/js/bulk_payment.min.js') }}"></script>
    @endif
@endsection
