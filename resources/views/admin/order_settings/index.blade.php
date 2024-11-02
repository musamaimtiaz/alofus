@extends('admin.layouts.app')
@section('page_title', __('Order Setting'))

@section('css')
    {{-- Select2  --}}
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/select2/css/select2.min.css') }}">
@endsection

@section('content')
    <!-- Main content -->
    <div class="col-sm-12" id="order-settings-container">
        <div class="card">
            <div class="card-body row">
                <div
                    class="col-lg-3 col-12 z-index-10 ltr:ps-md-3 ltr:pe-0 ltr:ps-0 rtl:pe-md-3 rtl:ps-0 rtl:pe-0">
                    @include('admin.layouts.includes.order_settings_menu')
                </div>
                <div class="col-lg-9 col-12 ltr:ps-0 rtl:pe-0">
                    <div class="card card-info shadow-none mb-0">
                        <div class="card-header p-t-0 border-bottom">
                            <h5>{{ __('Options') }}</h5>
                        </div>
                        <div class="card-block table-border-style">
                            <form action="{{ route('order.setting.option') }}" method="post" class="form-horizontal"
                                id="order_setting_form">
                                @csrf
                                <div class="card-body p-0">
                                    <div class="form-group row">
                                        <label class="col-sm-3 control-label text-left require"
                                            for="file_size">{{ __('Order Prefix') }}</label>
                                        <div class="col-sm-6 form-group flex-wrap">
                                            <input class="form-control inputFieldDesign" type="text" name="order_prefix"
                                                id="order_prefix"
                                                value="{{ !is_null(preference('order_prefix')) ? preference('order_prefix') : '' }}"
                                                required
                                                oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 control-label text-left require" for="file_size">{{ __('Guest Order') }}</label>
                                        <div class="col-sm-6 form-group flex-wrap">
                                            <select
                                                class="form-control js-example-basic-single form-height addressSelect sl_common_bx select2"
                                                name="guest_order" id="guest_order" required
                                                oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                                <option value="enable" {{ preference('guest_order') == 'enable' ? 'selected' : '' }}>{{ __('Enable') }}</option>
                                                <option value="disable" {{ preference('guest_order') == 'disable' ? 'selected' : '' }}>{{ __('Disable') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 pt-3 pt-md-2 control-label text-left" for="order_refund">{{ __('Refund') }}</label>
                                        <div class="col-sm-6">
                                            <div class="mr-3">
                                                <input type="hidden" name="order_refund" value="0">
                                                <div class="switch switch-bg d-inline m-r-10 edit-is_default">
                                                    <input class="order_refund" type="checkbox" value="1"
                                                        name="order_refund" id="order_refund"
                                                        {{ preference('order_refund') ? 'checked' : '' }}>
                                                    <label for="order_refund" class="cr"></label>
                                                </div>
                                            </div>

                                            <div class="mt-12">
                                                <span class="badge badge-warning ltr:me-1 rtl:ms-1">{{ __('Note') }}!</span>
                                                <span>{{ __('Users can create refund request when the option is enable, otherwise they can not able to create refund request.') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @if(isActive('BulkPayment')) 
                                        @include('bulkpayment::layouts.settings')
                                    @endif
                                    <div class="card-footer p-0">
                                        <div class="form-group row">
                                            <label for="btn_save" class="col-sm-3 control-label"></label>
                                            <div class="col-sm-12">
                                                <button type="submit" class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left"
                                                    id="footer-btn">
                                                    {{ __('Save') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/preference.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
    @if(isActive('BulkPayment'))
        <script src="{{ asset('Modules/BulkPayment/Resources/assets/js/bulk_payment.min.js') }}"></script>
    @endif
@endsection
