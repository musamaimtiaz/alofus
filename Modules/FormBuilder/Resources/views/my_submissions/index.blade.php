@extends('formbuilder::layout')

@section('page_title', __('Submissions'))

@section('content')
    <div class="col-sm-12 list-container">
        <div class="card">
            <div class="card-header d-md-flex justify-content-between align-items-center">
                <h5><a href="#">{{ __('Submissions') }}</a></h5>
                <div class="">
                    <div class="btn-toolbar " role="toolbar">
                        <div class="btn-group" role="group">
                            <a href="{{ route('formbuilder::forms.index') }}" class="btn btn-primary  btn-sm"
                                title="{{ __('Back To My Forms') }}">
                                <i class="fa fa-th-list neg-transition-scale"></i> {{ __('My Forms') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body px-4">
                <div class="card-block pt-2 px-0">
                    <div class="col-sm-12">
                        @include('admin.layouts.includes.yajra-data-table')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.layouts.includes.delete-modal')
@endsection
