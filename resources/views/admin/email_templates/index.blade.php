@extends('admin.layouts.app')
@section('page_title', __('Email Templates'))
@section('content')

    <!-- Main content -->
    <div class="col-sm-12 list-container" id="email-template-list-container">
        <div class="card">
            <div class="card-body row">
                <div
                    class="col-lg-3 col-12 z-index-10 ltr:ps-md-3 ltr:pe-0 ltr:ps-0 rtl:pe-md-3 rtl:ps-0 rtl:pe-0">
                    @include('admin.layouts.includes.email_settings_menu')
                </div>
                <div class="col-lg-9 col-12 ltr:ps-0 rtl:pe-0">
                    <div class="card card-info shadow-none mb-0">
                        <div class="card-header p-t-20 border-bottom">
                            @if (in_array('App\Http\Controllers\MailTemplateController@index', $prms))
                                <h5>{{ __('Email Templates') }}</h5>
                            @endif

                            @if (in_array('App\Http\Controllers\MailTemplateController@create', $prms))
                                <div class="card-header-right email-template-header">
                                    <a href="{{ route('emailTemplates.create') }}"
                                        class="btn btn-outline-primary custom-btn-small">
                                        <span class="fa fa-plus"> &nbsp;</span>{{ __('Add Template') }}
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="card-body p-0 role-table email-list-table">
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
    <script type="text/javascript">
        'use strict';
        var pdf = 0;
        var csv = 0;
    </script>
    <script src="{{ asset('public/dist/js/custom/permission.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/templates.min.js') }}"></script>
@endsection
