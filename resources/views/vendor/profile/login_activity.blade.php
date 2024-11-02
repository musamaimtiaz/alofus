@extends('vendor.layouts.app')
@section('page_title', __('Vendor Login Activity'))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/user-activity-list.min.css') }}">
@endsection

@section('content')
<!-- Main content -->
<div class="col-sm-12 list-container" id="activity-list-container">
    <div class="card">
        <div class="card-header d-md-flex justify-content-between align-items-center">
            <h5><a href="{{ url('vendor/dashboard') }}">{{ __('Dashboard') }}</a> >> {{ \Auth::user()->name }} >> {{ __('Login Activities') }}</h5>
            <div class="d-md-flex mt-2 mt-md-0 justify-content-end align-items-center">
                <button class="btn btn-outline-primary custom-btn-small mb-0 collapsed filterbtn me-0" type="button" data-bs-toggle="collapse" data-bs-target="#filterPanel" aria-expanded="true" aria-controls="filterPanel">
                    <span class="fas fa-filter mr-1"></span>{{ __('Filter') }}
                </button>
            </div>
        </div>

        <div class="card-header collapse p-0" id="filterPanel">
            <div class="row py-2 px-4">
                <div class="col-md-3 d-flex text-nowrap align-items-center">
                    <select class="select2 filter" name="log_name">
                        <option value="">{{ __('All Types') }}</option>
                        @foreach ($logTypes as $logType)
                            <option value="{{ $logType }}">{{ $logType }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="card-body px-4" id="no_shadow_on_card">
            <div class="card-block pt-2 px-0">
                <div class="col-sm-12 form-tabs">
                    @include('admin.layouts.includes.yajra-data-table')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="{{ asset('public/dist/js/custom/users-activity-list.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>
@endsection

