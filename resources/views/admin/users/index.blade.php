@extends('admin.layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('public/dist/css/user-list.min.css') }}">
@endsection
@section('page_title', __('Users'))
@section('content')
    <div class="col-sm-12 list-container" id="user-list-container">
        <div class="card">
            <div class="card-header bb-none pb-0">
                <h5>{{ Route::current()->getName() == 'users.customer' ? __('Customers') : __('Users') }}</h5>
                <x-backend.group-filters :groups="$groups" :column="'status'" />
                <div class="card-header-right my-2 mx-md-0 mx-sm-4">
                    <x-backend.button.batch-delete />
                    @if (in_array('App\Http\Controllers\UserController@create', $prms))
                        <x-backend.button.add-new href="{{ route('users.create') }}" />
                    @endif
                    <x-backend.button.export />
                    <x-backend.button.filter />
                </div>
            </div>

            <x-backend.datatable.filter-panel>
                <div class="col-md-9">
                    <x-backend.datatable.input-search />
                </div>
                <div class="col-md-3">
                    <select class="select2-hide-search filter" name="role">
                        <option value="">{{ __('All Role') }}</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </x-backend.datatable.filter-panel>

            <x-backend.datatable.table-wrapper class="user-list-wallet user-list-processing-message need-batch-operation"
                data-namespace="\App\Models\User" data-column="id">
                @include('admin.layouts.includes.yajra-data-table')
            </x-backend.datatable.table-wrapper>

            @include('admin.layouts.includes.delete-modal')
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        'use strict';
        var pdf = "{{ in_array('App\Http\Controllers\UserController@pdf', $prms) ? '1' : '0' }}";
        var csv = "{{ in_array('App\Http\Controllers\UserController@csv', $prms) ? '1' : '0' }}";
    </script>

    <script src="{{ asset('public/dist/js/custom/permission.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/user.min.js') }}"></script>
@endsection
