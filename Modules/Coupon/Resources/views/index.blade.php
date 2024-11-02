@extends('admin.layouts.app')
@section('page_title', __('Coupons'))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/dist/css/marketing.min.css') }}">
@endsection
@section('content')
    <!-- Main content -->
    <div class="col-sm-12 list-container" id="coupon-list-container">
        <div class="card">
            <div class="card-header bb-none pb-0">
                <h5>{{ __('Coupons') }}</h5>
                <x-backend.group-filters :groups="$groups" :column="'status'" />
                <div class="card-header-right my-2 mx-md-0 mx-sm-4">
                    <x-backend.button.batch-delete />
                    @if (in_array('Modules\Coupon\Http\Controllers\CouponController@create', $prms))
                        <x-backend.button.add-new href="{{ route('coupon.create') }}" />
                    @endif
                    <x-backend.button.export />
                    <x-backend.button.filter />
                </div>
            </div>

            <x-backend.datatable.filter-panel>
                <div class="col-md-12">
                    <x-backend.datatable.input-search />
                </div>
            </x-backend.datatable.filter-panel>
            
            <x-backend.datatable.table-wrapper class="marketing-processing-table need-batch-operation"
            data-namespace="\Modules\Coupon\Http\Models\Coupon" data-column="id">
                @include('admin.layouts.includes.yajra-data-table')
            </x-backend.datatable.table-wrapper>
            
            @include('admin.layouts.includes.delete-modal')
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        'use strict';
        var pdf = "{{ in_array('Modules\Coupon\Http\Controllers\CouponController@downloadPdf', $prms) ? '1' : '0' }}";
        var csv = "{{ in_array('Modules\Coupon\Http\Controllers\CouponController@downloadCsv', $prms) ? '1' : '0' }}";
    </script>
    <script src="{{ asset('public/dist/js/custom/coupon.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/permission.min.js') }}"></script>
@endsection
