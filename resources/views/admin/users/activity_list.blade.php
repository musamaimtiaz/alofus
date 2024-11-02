@extends('admin.layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('public/dist/css/user-activity-list.min.css') }}">
@endsection
@section('page_title', __('Users Activity'))

<!-- Main content -->
@section('content')
<div class="col-sm-12 list-container" id="activity-list-container">
    <div class="card">
        <div class="card-header bb-none pb-0">
            <h5>{{ __('Users Activity') }}</h5>
            <x-backend.group-filters :groups="$groups" :column="'log_name'" />
            <div class="card-header-right my-2 mx-md-0 mx-sm-4">
                <x-backend.button.filter />
            </div>
        </div>
        
        <x-backend.datatable.filter-panel>
            <div class="col-md-9">
                <x-backend.datatable.input-search />
            </div>
            <div class="col-md-3 d-flex align-items-center">
                <select class="select2 filter ajax_users" name="userId">
                    <option value="">{{ __('All Users') }}</option>
                </select>
            </div>
        </x-backend.datatable.filter-panel>
        
        <x-backend.datatable.table-wrapper class="user_activity_list">
            @include('admin.layouts.includes.yajra-data-table')
        </x-backend.datatable.table-wrapper>

        @include('admin.layouts.includes.delete-modal')
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    var searchURI = "{{ route('find.users.ajax') }}";
</script>
<script src="{{ asset('public/dist/js/custom/users-activity-list.min.js') }}"></script>
@endsection
