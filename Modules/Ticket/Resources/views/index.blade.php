@extends('vendor.layouts.app')
@section('page_title', __('Supports'))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/Ticket/Resources/assets/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/vendor-responsiveness.min.css') }}">
@endsection

@section('content')

    <!-- Main content -->
    <div class="list-container" id="vendor-ticket-list-container">
        <div class="card">
            <div class="card-header bb-none pb-3">
                <h5>{{ __('Supports') }}</h5>
                <div class="card-header-right my-2 mx-md-0 mx-sm-4">
                    @if (in_array('Modules\Ticket\Http\Controllers\Vendor\TicketController@create', $prms))
                        <x-backend.button.add-new href="{{ route('vendor.threadAdd') }}" />
                    @endif
                    <x-backend.button.export />
                    <x-backend.button.filter />
                </div>
            </div>

            <x-backend.datatable.filter-panel>
                <div class="col-md-3">
                    <x-backend.datatable.input-search />
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <button type="button" class="form-control inputFieldDesign" id="daterange-btn">
                            <span class="ltr:float-left rtl:float-right"><i class="fa fa-calendar"></i>
                                {{ __('Date range picker') }}</span>
                            <i class="fa fa-caret-down ltr:float-right rtl:float-left pt-1"></i>
                        </button>
                    </div>
                </div>

                <input class="form-control" id="startfrom" type="hidden" name="from">
                <input class="form-control" id="endto" type="hidden" name="to">
                <select class="filter display-none" name="start_date" id="start_date"></select>
                <select class="filter display-none" name="end_date" id="end_date"></select>

                <div class="col-md-3">
                    <select class="form-control select2-hide-search filter" name="department" id="department_id">
                        <option value="">{{ __('All Department') }}</option>
                        @foreach ($departments as $data)
                            <option value="{{ $data->id }}"
                                {{ $data->id == $department_id ? ' selected="selected"' : '' }}>
                                {{ $data->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-control select2-hide-search filter" name="status" id="status">
                        <option value="">{{ __('All Status') }}</option>
                        @foreach ($statuses as $data)
                            <option value="{{ $data->id }}"
                                {{ $data->id == $status_id ? ' selected="selected"' : '' }}>
                                {{ $data->name }}</option>
                        @endforeach
                    </select>
                </div>
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
        var startDate = "{!! isset($from) ? $from : 'undefined' !!}";
        var endDate = "{!! isset($to) ? $to : 'undefined' !!}";
    </script>
    <script src="{{ asset('public/dist/js/moment.min.js') }}"></script>
    <script src="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('Modules/Ticket/Resources/assets/js/message.min.js') }}"></script>
@endsection
