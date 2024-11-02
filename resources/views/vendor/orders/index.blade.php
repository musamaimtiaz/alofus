@extends('vendor.layouts.app')
@section('page_title', __('Orders'))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/dist/css/vendor-responsiveness.min.css') }}">
@endsection
@section('content')

    <!-- Main content -->
    <div class="list-container" id="vendor-order-list-container">
        <div class="card">
            <div class="card-header bb-none pb-0">
                <h5>{{ __('Orders') }}</h5>
                <x-backend.group-filters :groups="$groups" :column="'order_status_id'" />
                <div class="card-header-right my-2 mx-md-0 mx-sm-4">
                    @if(isActive('BulkPayment'))
                        @php 
                        $accessBulk = json_decode(preference('bulk_payment_user_role'), true) ?? [];
                        $vendorRoleId = \App\Models\Role::where('slug', 'vendor-admin')->first()->id;
                        @endphp
                        @if(in_array($vendorRoleId, $accessBulk))
                         @include('bulkpayment::admin.batch_pay_button')
                        @endif
                    @endif
                    <x-backend.button.filter />
                </div>
            </div>
            
            <x-backend.datatable.filter-panel class="mx-1">
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
                    <select class="filter select2-hide-search" name="order_status_id" id="order_status_id">
                        <option value="">{{ __('All :x', ['x' => __('Order Status')]) }}</option>
                        @foreach ($statuses as $allStatus)
                            <option value="{{ $allStatus->id }}">{{ $allStatus->name }}</option>
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

             <x-backend.datatable.table-wrapper class="order-list-table {{ isActive('BulkPayment') && isset($accessBulk) && in_array($vendorRoleId, $accessBulk) ? 'need-batch-operation' : '' }}">
                @include('vendor.layouts.includes.yajra-data-table')
            </x-backend.datatable.table-wrapper>

            @include('vendor.layouts.includes.delete-modal')

        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('public/dist/js/moment.min.js') }}"></script>
    <script src="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}"></script>
    <script type="text/javascript">
        'use strict';
        var pdf = "{{ (in_array('App\Http\Controllers\Vendor\OrderController@pdf', $prms)) ? '1' : '0' }}";
        var csv = "{{ (in_array('App\Http\Controllers\Vendor\OrderController@csv', $prms)) ? '1' : '0' }}";
        var startDate = "{!! isset($from) ? $from : 'undefined' !!}";
        var endDate   = "{!! isset($to) ? $to : 'undefined' !!}";
    </script>
    <script src="{{ asset('public/dist/js/custom/order.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/permission.min.js') }}"></script>
    @if(isActive('BulkPayment') && isset($accessBulk) && in_array($vendorRoleId, $accessBulk))
        <script>
            var countBulkPayment = '{{ preference('bulk_pay_count') }}';
        </script>
        <script src="{{ asset('Modules/BulkPayment/Resources/assets/js/bulk_payment.min.js') }}"></script>
    @endif
@endsection
