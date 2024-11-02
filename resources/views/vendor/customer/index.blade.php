@extends('vendor.layouts.app')
@section('page_title', __('Customers'))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/dist/css/vendor-responsiveness.min.css') }}">
@endsection
@section('content')

    <!-- Main content -->
    <div class="list-container" id="vendor-customer-list-container">
        <div class="card">
            <div class="card-header bb-none pb-0 mb-1">
                <h5>{{ __('Customers') }}</h5>
                <div class="card-header-right my-2 mx-md-0 mx-sm-4">
                    <x-backend.button.filter />
                </div>
            </div>

            <x-backend.datatable.filter-panel>
                <div class="col-md-12 px-3">
                    <x-backend.datatable.input-search />
                </div>
            </x-backend.datatable.filter-panel>

            <x-backend.datatable.table-wrapper class="order-list-table">
                @include('vendor.layouts.includes.yajra-data-table')
            </x-backend.datatable.table-wrapper>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('public/dist/js/moment.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/permission.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/yajra-export.min.js') }}"></script>
@endsection
