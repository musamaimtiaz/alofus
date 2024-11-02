@extends('vendor.layouts.app')
@section('page_title', __('Coupons'))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/dist/css/vendor-responsiveness.min.css') }}">
@endsection
@section('content')

    <!-- Main content -->
    <div class="list-container" id="vendor-coupon-list-container">
        <div class="card">
            <div class="card-header bb-none pb-0">
                <h5>{{ __('Coupons') }}</h5>
                <x-backend.group-filters :groups="$groups" :column="'status'" />
                <div class="card-header-right my-2 mx-md-0 mx-sm-4">
                    <x-backend.button.batch-delete />
                    @if (in_array('Modules\Coupon\Http\Controllers\Vendor\CouponController@create', $prms))
                        <x-backend.button.add-new href="{{ route('vendor.couponCreate') }}" />
                    @endif
                    <x-backend.button.export />
                    <x-backend.button.filter />
                </div>
            </div>

            <x-backend.datatable.filter-panel>
                <div class="col-md-12 px-3">
                    <x-backend.datatable.input-search />
                </div>
            </x-backend.datatable.filter-panel>
            
            <x-backend.datatable.table-wrapper class="marketing-processing-table need-batch-operation"
            data-namespace="\Modules\Coupon\Http\Models\Coupon" data-column="id">
                @include('vendor.layouts.includes.yajra-data-table')
            </x-backend.datatable.table-wrapper>

            @include('vendor.layouts.includes.delete-modal')
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        'use strict';
        var pdf = "{{ in_array('Modules\Coupon\Http\Controllers\Vendor\CouponController@pdf', $prms) ? '1' : '0' }}";
        var csv = "{{ in_array('Modules\Coupon\Http\Controllers\Vendor\CouponController@csv', $prms) ? '1' : '0' }}";
    </script>
    <script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/coupon.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/permission.min.js') }}"></script>
@endsection
