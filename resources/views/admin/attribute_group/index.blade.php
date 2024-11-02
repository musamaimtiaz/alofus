@extends('admin.layouts.app')
@section('page_title', __('Attribute Groups'))

@section('css')
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/product.min.css') }}">
@endsection

@section('content')
    <!-- Main content -->
    <div class="col-sm-12 list-container" id="attribute_group-list-container">
        <div class="card">
            <div class="card-header d-md-flex justify-content-between align-items-center">
                <h5> <a href="{{ route('attributeGroup.index') }}">{{ __('Attribute Groups') }}</a> </h5>
                @if (in_array('App\Http\Controllers\AttributeGroupController@create', $prms))
                    <div class="d-md-flex justify-content-end align-items-center">
                        <a href="{{ route('attributeGroup.create') }}" class="btn btn-outline-primary mb-0 custom-btn-small">
                            <span class="fa fa-plus"> &nbsp;</span>{{ __('Add Attribute Group') }}
                        </a>
                        <button class="btn btn-outline-primary custom-btn-small mb-0 collapsed filterbtn me-0" type="button" data-bs-toggle="collapse" data-bs-target="#filterPanel" aria-expanded="true" aria-controls="filterPanel"><span class="fas fa-filter">&nbsp;</span>{{ __('Filter') }}</button>
                    </div>
                @endif
            </div>

            <div class="card-header p-0 collapse" id="filterPanel">
                <div class="row mx-2 my-3">
                    <div class="col-md-3">
                        <select class="select2 filter" name="vendor">
                            <option value="">{{ __('All :x', ['x' => __('Vendors')]) }}</option>
                            @foreach ($attributeVendors as $attVen)
                                @if(optional($attVen->vendor)->id)
                                <option value="{{ optional($attVen->vendor)->id }}">{{ optional($attVen->vendor)->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select class="select2 filter" name="status">
                            <option>{{ __('All Status') }}</option>
                            <option value="Active">{{ __('Active') }}</option>
                            <option value="Inactive">{{ __('Inactive') }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-body p-0 product-table">
                <div class="card-block pt-2 px-2">
                    <div class="col-sm-12">
                        @include('admin.layouts.includes.yajra-data-table')
                    </div>
                </div>
            </div>
            @include('admin.layouts.includes.delete-modal')
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>
    <script type="text/javascript">
        'use strict';
        var pdf = "{{ (in_array('App\Http\Controllers\AttributeGroupController@pdf', $prms)) ? '1' : '0' }}";
        var csv = "{{ (in_array('App\Http\Controllers\AttributeGroupController@csv', $prms)) ? '1' : '0' }}";
    </script>
    <script src="{{ asset('public/dist/js/custom/permission.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/attribute.min.js') }}"></script>
@endsection
