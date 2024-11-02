@extends('admin.layouts.app')
@section('page_title', __('Transaction'))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/product.min.css') }}">
@endsection
@section('content')

<!-- Main content -->
<div class="col-sm-12 list-container" id="transaction-list-container">
    <div class="card">
        <div class="card-header bb-none pb-0">
            <h5>{{ __('Transactions') }}</h5>
            <x-backend.group-filters :groups="$groups" :column="'status'" />
            <div class="card-header-right my-2 mx-md-0 mx-sm-4">
                <x-backend.button.filter />
            </div>
        </div>

        <x-backend.datatable.filter-panel>
            <div class="col-md-2">
                <x-backend.datatable.input-search />
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <button type="button" class="form-control filter-drop-down h-40 inputFiedlDesign" id="daterange-btn">
                        <span class="ltr:float-left rtl:float-right"><i class="fa fa-calendar"></i> {{ __('Date range picker') }}</span>
                        <i class="fa fa-caret-down ltr:float-right rtl:float-left pt-1"></i>
                    </button>
                </div>
            </div>
            <input class="form-control" id="startfrom" type="hidden" name="from">
            <input class="form-control" id="endto" type="hidden" name="to">
            <div class="col-md-3">
                <select class="select2 filter" name="transaction_type">
                    <option value="">{{ __('All Transaction Type') }}</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->transaction_type }}">{{ str_replace("_", " ", $type->transaction_type) }}</option>
                    @endforeach
                </select>
            </div>

            <select class="filter display-none" name="start_date" id="start_date"></select>

            <select class="filter display-none" name="end_date" id="end_date"></select>
            @if(isset($users))
            <div class="col-md-2">
                <select class="select2default filter filter-drop-down" name="user_id">
                    <option value="">{{ __('All Users') }}</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->user->id }}">{{ $user->user->name }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            @if(isset($vendors))
            <div class="col-md-2">
                <select class="select2default filter filter-drop-down" name="vendor_id">
                    <option value="">{{ __('All Vendors') }}</option>
                    @foreach ($vendors as $vendor)
                        <option value="{{ $vendor->vendor->id }}">{{ $vendor->vendor->name }}</option>
                    @endforeach
                </select>
            </div>
            @endif
        </x-backend.datatable.filter-panel>
        
        <x-backend.datatable.table-wrapper>
            @include('admin.layouts.includes.yajra-data-table')
        </x-backend.datatable.table-wrapper>

        @include('admin.layouts.includes.delete-modal')
    </div>
</div>
@endsection

@section('js')
    <script type="text/javascript">
        'use strict';
        var pdf = "{{ (in_array('App\Http\Controllers\TransactionController@pdf', $prms)) ? '1' : '0' }}";
        var csv = "{{ (in_array('App\Http\Controllers\TransactionController@csv', $prms)) ? '1' : '0' }}";
    </script>
    <script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/moment.min.js') }}"></script>
    <script src="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/permission.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/withdrawal.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/transaction.min.js') }}"></script>
@endsection

