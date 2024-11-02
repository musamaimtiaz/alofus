@extends('admin.layouts.app')
@section('page_title', __('Roles'))
@section('content')

    <!-- Main content -->
    <div class="col-sm-12 list-container" id="role-list-container">
        <div class="card">
            <div class="card-body row">
                <div
                    class="col-lg-3 col-12 z-index-10 ltr:ps-md-3 ltr:pe-0 ltr:ps-0 rtl:pe-md-3 rtl:ps-0 rtl:pe-0">
                    @include('admin.layouts.includes.account_settings_menu')
                </div>
                <div class="col-lg-9 col-12 ltr:ps-0 rtl:pe-0">
                    <div class="card card-info shadow-none mb-0">
                        <div class="card-header p-t-20 border-bottom role-header">
                            <h5> {{ __('Roles') }} </h5>
                            @if (in_array('App\Http\Controllers\RoleController@create', $prms))
                                <div class="card-header-right pl-3 d-inline-block">
                                    <a href="{{ route('roles.create') }}" class="btn btn-outline-primary custom-btn-small">
                                        <span class="fa fa-plus"> &nbsp;</span>{{ __('Add Role') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="card-body p-0 role-table">
                            <div class="card-block pt-2 px-1 px-lg-4">
                                @include('admin.layouts.includes.yajra-data-table')
                            </div>
                        </div>
                        @include('admin.layouts.includes.delete-modal')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('public/dist/js/custom/roles.min.js') }}"></script>
@endsection
