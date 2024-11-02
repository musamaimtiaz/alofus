@extends('admin.layouts.app')
@section('page_title', __('Notification Log'))

@section('content')
<!-- Main content -->
<div class="col-sm-12 list-container" id="activity-list-container">
    <div class="card">
        <div class="card-header d-md-flex justify-content-between align-items-center">
            <h5> {{ __('Notification Log') }}</h5>
            <div class="d-md-flex mt-2 mt-md-0 justify-content-end align-items-center">
                <div class="card-header-right my-2 mx-md-0 mx-sm-4">
                    <x-backend.button.batch-delete />
                    <x-backend.button.filter />
                </div>
            </div>
        </div>
        
        <div class="card-header collapse p-0" id="filterPanel">
            <div class="row py-2 px-4">
                <div class="col-md-3 d-flex text-nowrap align-items-center">
                    <select class="select2 filter" name="users">
                        <option value="">{{ __('All User') }}</option>
                        @foreach ($users as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex text-nowrap align-items-center">
                    <select class="select2 filter" name="types">
                        <option value="">{{ __('All Notification') }}</option>
                        @foreach ($types as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex text-nowrap align-items-center">
                    <select class="select2 filter" name="channels">
                        <option value="">{{ __('All Channel') }}</option>
                        @foreach ($channels as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div id="no_shadow_on_card" class="card-body px-4 need-batch-operation"
            data-namespace="App\Models\NotificationLogItem" data-column="id">
            <div class="card-block pt-2 px-0">
                <div class="col-sm-12 form-tabs">
                    @include('admin.layouts.includes.yajra-data-table')
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.layouts.includes.delete-modal')
@endsection
