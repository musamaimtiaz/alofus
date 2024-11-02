@extends('admin.layouts.app')
@section('page_title', __('Popups'))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/dist/css/marketing.min.css') }}">
@endsection
@section('content')
    <!-- Main content -->
    <div class="col-sm-12 list-container" id="popup-list-container">
        <div class="card">
            <div class="card-header bb-none pb-0">
                <h5>{{ __('Popups') }}</h5>
                <x-backend.group-filters :groups="$groups" :column="'status'" />
                <div class="card-header-right my-2 mx-md-0 mx-sm-4">
                    <x-backend.button.batch-delete />
                    @if (in_array('Modules\Popup\Http\Controllers\PopupController@create', $prms))
                        <x-backend.button.add-new href="{{ route('popup.create') }}" />
                    @endif
                    <x-backend.button.filter />
                </div>
            </div>

            <x-backend.datatable.filter-panel>
                <div class="col-md-9">
                    <x-backend.datatable.input-search />
                </div>
                <div class="col-md-3">
                    <select class="select2-hide-search filter" name="login_enabled">
                        <option>{{ __('Login required') . ': ' . __('All') }}</option>
                        <option value="1">{{ __('Login required') . ': ' . __('Yes') }}</option>
                        <option value="0">{{ __('Login required') . ': ' . __('No') }}</option>
                    </select>
                </div>
            </x-backend.datatable.filter-panel>

            <x-backend.datatable.table-wrapper class="need-batch-operation"
            data-namespace="\Modules\Popup\Entities\Popup" data-column="id">
                @include('admin.layouts.includes.yajra-data-table')
            </x-backend.datatable.table-wrapper>
            
            @include('admin.layouts.includes.delete-modal')
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        'use strict';
        var pdf = 0;
        var csv = 0;
    </script>
    <script src="{{ asset('public/dist/js/custom/popup.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/permission.min.js') }}"></script>
@endsection
