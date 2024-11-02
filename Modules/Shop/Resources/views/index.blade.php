@extends('admin.layouts.app')
@section('page_title', __('Shop'))
@section('css')
{{-- Select2  --}}
  <link rel="stylesheet" type="text/css" href="{{ asset('public/datta-able/plugins/select2/css/select2.min.css') }}">
@endsection
@section('content')

<!-- Main content -->
<div class="col-sm-12 list-container" id="shop-list-container">
    <div class="card">
        <div class="card-header">
            <h5><a href="{{ route('shop.index') }}">{{ __('Shop') }}</a></h5>
            <div class="card-header-right d-inline-block">
                @if (in_array('Modules\Shop\Http\Controllers\ShopController@create', $prms))
                    <a href="{{ route('shop.create') }}" class="btn btn-outline-primary custom-btn-small">
                        <span class="fa fa-plus"> &nbsp;</span>{{ __('Add Shop') }}
                    </a>
                @endif
                <button class="btn btn-outline-primary custom-btn-small collapsed filterbtn" type="button" data-bs-toggle="collapse" data-bs-target="#filterPanel" aria-expanded="true" aria-controls="filterPanel"><span class="fas fa-filter"></span></button>
            </div>
        </div>

        <div class="card-header p-0 collapse" id="filterPanel">
            <div class="row mx-2 my-3">
                <div class="col-md-3">
                    <select class="select2 filter" name="status">
                        <option>{{ __('All Status') }}</option>
                        <option value="Active">{{ __('Active') }}</option>
                        <option value="Inactive">{{ __('Inactive') }}</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
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
<script type="text/javascript">
    'use strict';
    var pdf = "{{ (in_array('Modules\Shop\Http\Controllers\ShopController@pdf', $prms)) ? '1' : '0' }}";
    var csv = "{{ (in_array('Modules\Shop\Http\Controllers\ShopController@csv', $prms)) ? '1' : '0' }}";
</script>
<script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('public/dist/js/custom/shops.min.js') }}"></script>
<script src="{{ asset('public/dist/js/custom/permission.min.js') }}"></script>
@endsection

