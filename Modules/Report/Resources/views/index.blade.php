@extends('admin.layouts.app')
@section('page_title', __('Reports'))
@section('css')
  <link rel="stylesheet" href="{{ asset('public/dist/plugins/Responsive-2.2.5/css/responsive.dataTables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}">
  <link rel="stylesheet" href="{{ asset('Modules/Report/Resources/assets/css/style.min.css') }}">
@endsection
@section('content')
<div class="col-sm-12 list-container">
    <div class="card-header d-md-flex justify-content-between align-items-center bg-white py-3 px-4">
        <h5 class="border-blue report-title mb-0">{{ __('Reports') }}</h5>
    </div>
        <div class="row">
            <div class="col-sm-7 col-md-7 col-lg-8 col-xl-9 mt-3">
                <div class="bg-white p-4" id="report-module">
                    <div id="report">
                    </div>
                </div>
            </div>
            <div class="col-sm-5 col-md-5 col-lg-4 col-xl-3 px-3 mt-3">
                <div class="p-3 pt-4 bg-white">
                    <h3 class="tab-content-title">{{ __('Filter') }}</h3>
                        <form action='' method="get" class="form-horizontal" id="reportForm">
                            <div class="form-group">
                            <label for="report-type">{{ __('Report Type') }}</label>
                            <select class="form-select inputFieldDesign cursor-pointer" id="report_name" name="type">
                                @foreach ($reportTypes as $key => $report)
                                <option value="{{ $key }}">{{ $report }}</option>
                                @endforeach
                            </select>
                            </div>
                            <div id="filter-data">
                                <div id="filter-data">
                                    <div class="form-group filter-data CouponReport date-picker-field" id="date-picker-field">
                                        <label for="to">{{ __('Date Range') }}</label>
                                        <button type="button" class="form-control date-range py-2 rounded-sm" id="daterange-btn">
                                            <span class="ltr:float-left rtl:float-right">
                                            <i class="fa fa-calendar"></i>
                                            {{ __('Pick a date range') }}
                                            </span>
                                            <i class="fa fa-caret-down ltr:float-right rtl:float-left pt-1"></i>
                                        </button>
                                        <input class="form-control" id="startfrom" type="hidden" name="from" value="{{ isset($from) ? $from : '' }}">
                                        <input class="form-control" id="endto" type="hidden" name="to" value="{{ isset($to) ? $to : '' }}">
                                    </div>
                                    <div class="form-group filter-data CouponReport" id="coupon-field">
                                        <label for="customer-name">{{ __('Coupon Code') }}</label>
                                        <input type="text" name="coupon_code" class="form-control inputFieldDesign" id="coupon-code">
                                    </div>
                                    <div class="form-group filter-data BrandedProductReport" id="brand-field">
                                        <label for="customer-name">{{ __('Brand') }}</label>
                                        <input type="text" name="brand_name" class="form-control inputFieldDesign" id="brand-name">
                                    </div>
                                    <div class="form-group filter-data ProductStockReport">
                                        <label for="customer-name">{{ __('Qty Above') }}</label>
                                        <input type="text" name="qty_above" class="form-control inputFieldDesign" id="qty-above">
                                    </div>
                                    <div class="form-group filter-data ProductStockReport" >
                                        <label for="customer-name">{{ __('Qty Bellow') }}</label>
                                        <input type="text" name="qty_bellow" class="form-control inputFieldDesign" id="qty-bellow">
                                    </div>
                                    <div class="form-group filter-data ProductStockReport">
                                        <label for="report-type">{{ __('Stock Availability') }}</label>
                                        <select class="mb-3 form-select inputFieldDesign" name="stock_availability" id="stock_availability">
                                            <option value="">{{ __('Select One') }}</option>
                                            <option value="in_stock">{{ __('In Stock') }}</option>
                                            <option value="out_of_stock">{{ __('Out Of Stock') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group filter-data CategorizedProductReport">
                                        <label for="customer-name">{{ __('Category') }}</label>
                                        <input type="text" name="category_name" class="form-control inputFieldDesign" id="category-name">
                                    </div>
                                    <div class="form-group filter-data TaggedProductReport">
                                        <label for="customer-name">{{ __('Tag') }}</label>
                                        <input type="text" name="tag_name" class="form-control inputFieldDesign" id="tag-name">
                                    </div>
                                    <div class="form-group filter-data order-status-field CustomerOrderReport">
                                        <label for="report-type">{{ __('Order Status') }}</label>
                                        <select class="form-control" id="order_status" name="order_status">
                                            <option value="">{{ __('Please select one') }}</option>
                                            @foreach ($orderStatus as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group filter-data CustomerOrderReport">
                                        <label for="customer-name">{{ __('Customer Name') }}</label>
                                        <input type="text" name="customer_name" class="form-control inputFieldDesign" id="customer-name">
                                    </div>
                                    <div class="form-group filter-data CustomerOrderReport">
                                        <label for="customer-email">{{ __('Customer Email') }}</label>
                                        <input type="text" name="customer_email" class="form-control inputFieldDesign" id="customer-email">
                                    </div>
                                    <div class="mb-3 form-group filter-data ShippingReport">
                                        <label for="report-type">{{ __('Shipping Method') }}</label>
                                        <select class="form-select inputFieldDesign" id="shipping_method" name="shipping_method">
                                            <option value="">{{ __('Please select one') }}</option>
                                            @foreach ($shippingMethod as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group filter-data CommissionReport">
                                        <label for="customer-name">{{ __('Vendor Name') }}</label>
                                        <input type="text" name="vendor_name" class="form-control inputFieldDesign" id="vendor-name">
                                    </div>
                                    <div class="form-group filter-data SearchReport" id="search-field">
                                        <label for="customer-name">{{ __('Keyword') }}</label>
                                        <input type="text" name="search_field" class="form-control inputFieldDesign" id="search-keyword">
                                    </div>
                                    <button type="submit" class="btn custom-btn-submit search-btn" data-loading="">
                                        {{ __('Filter') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
    'use strict';
    var startDate = "{!! isset($from) ? $from : 'undefined' !!}";
    var endDate   = "{!! isset($to) ? $to : 'undefined' !!}";
</script>
<script src="{{ asset('public/dist/js/moment.min.js') }}"></script>
<script src="{{ asset('public/dist/plugins/DataTables-1.10.21/js/jquery.dataTablesCus.min.js') }}"></script>
<script src="{{ asset('public/dist/plugins/Responsive-2.2.5/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}"></script>
<script src="{{ asset('Modules/Report/Resources/assets/js/report.min.js') }}"></script>
@endsection
