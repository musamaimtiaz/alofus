@extends('admin.layouts.app')
@section('page_title', __('Coupon Redeems'))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/dist/css/marketing.min.css') }}">
@endsection
@section('content')

    <!-- Main content -->
    <div class="col-sm-12 list-container" id="coupon-redeem-list-container">
        <div class="card">
            <div class="card-header bb-none pb-2">
                <h5>{{ __('Coupon Redeems') }}</h5>
                <div class="card-header-right my-2 mx-md-0 mx-sm-4">
                    <x-backend.button.export/>
                </div>
            </div>

            <x-backend.datatable.table-wrapper>
                @include('admin.layouts.includes.yajra-data-table')
            </x-backend.datatable.table-wrapper>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        'use strict';
        var pdf = "{{ in_array('Modules\Coupon\Http\Controllers\CouponRedeemController@pdf', $prms) ? '1' : '0' }}";
        var csv = "{{ in_array('Modules\Coupon\Http\Controllers\CouponRedeemController@csv', $prms) ? '1' : '0' }}";
    </script>
    <script src="{{ asset('public/dist/js/custom/coupon.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/permission.min.js') }}"></script>
@endsection
