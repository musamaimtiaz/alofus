@extends('admin.layouts.app')
@section('page_title', __('Account Settings'))
@section('css')

@endsection

@section('content')
    <!-- Main content -->
    <div class="col-sm-12" id="account-settings-container">
        <div class="card">
            <div class="card-body row">
                <div
                    class="col-lg-3 col-12 z-index-10 ltr:ps-md-3 ltr:pe-0 ltr:ps-0 rtl:pe-md-3 rtl:ps-0 rtl:pe-0">
                    @include('admin.layouts.includes.account_settings_menu')
                </div>
                <div class="col-lg-9 col-12 ltr:ps-0 rtl:pe-0">
                    <div class="card card-info shadow-none mb-0">
                        <div class="card-header p-t-20 border-bottom">
                            <h5>{{ __('Options') }}</h5>
                        </div>
                        <div class="card-block table-border-style">
                            <form action="{{ route('account.setting.option') }}" method="post" class="form-horizontal"
                                id="preference_form">
                                @csrf
                                <div class="card-body p-0">
                                    <div class="form-group row m-0">
                                        <label class="col-4 control-label"
                                            for="user_login">{{ __('User Login With') }}</label>
                                        <div class="col-6 d-flex">
                                            <div class="radio-item d-flex align-items-center my-2 me-3">
                                                <input type="radio" id="email_check" name="user_login"
                                                    {{ preference('user_login') == 'email' ? 'checked' : '' }} class=""
                                                    value="email">
                                                <label class="custom-control-label ltr:ms-2 rtl:me-2"
                                                    for="email_check">{{ __('Email') }}</label>
                                            </div>
                                            <div class="radio-item d-flex align-items-center my-2 me-3">
                                                <input type="radio" id="phone_check" name="user_login"
                                                    {{ preference('user_login') == 'phone' ? 'checked' : '' }} class=""
                                                    value="phone">
                                                <label class="custom-control-label ltr:ms-2 rtl:me-2"
                                                    for="phone_check">{{ __('Phone') }}</label>
                                            </div>
                                            <div class="radio-item d-flex align-items-center my-2">
                                                <input type="radio" id="both_check" name="user_login"
                                                    {{ preference('user_login', 'both') == 'both' ? 'checked' : '' }} class=""
                                                    value="both">
                                                <label class="custom-control-label ltr:ms-2 rtl:me-2"
                                                    for="both_check">{{ __('Both') }}</label>
                                            </div>
                                        </div>
                                        <div class="offset-4 col-8">
                                            <ul class="ps-4">
                                                <li><small><b>{{ __('Email') }}:</b> {{ __('Customer can log in using registered email address only.') }}</small></li>

                                                <li><small><b>{{ __('Phone') }}:</b> {{ __('Customer can log in using registered phone number only.') }}</small></li>
                                                    
                                                <li><small><b>{{ __('Both') }}:</b> {{ __('Customer can log in using either registered email address or phone number.') }}</small></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-4 control-label"
                                            for="customer_signup">{{ __('Customer Signup') }}</label>
                                        <div class="col-6">
                                            <div class="switch switch-bg d-inline m-r-10 edit-is_default">
                                                <input class="customer-signup" type="checkbox"
                                                    value="{{ $customer_signup }}" name="customer_signup"
                                                    id="customer_signup" {{ $customer_signup == 1 ? 'checked' : '' }}>
                                                <label for="customer_signup" class="cr"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-4 control-label"
                                            for="customer_default_signup_status">{{ __('Customer Default Signup Status') }}</label>
                                        <div class="col-6">
                                            <select name="user_default_signup_status"
                                                class="form-control select2-hide-search">
                                                <option value="Pending"
                                                    {{ preference('user_default_signup_status') == 'Pending' ? 'selected' : '' }}>
                                                    {{ __('Pending') }}</option>
                                                <option value="Active"
                                                    {{ preference('user_default_signup_status') == 'Active' ? 'selected' : '' }}>
                                                    {{ __('Active') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-4 control-label"
                                            for="vendor_signup">{{ __('Vendor Signup') }}</label>
                                        <div class="col-6">
                                            <div class="switch switch-bg d-inline m-r-10 edit-is_default">
                                                <input class="vendor-signup" type="checkbox" value="{{ $vendor_signup }}"
                                                    name="vendor_signup" id="vendor_signup"
                                                    {{ $vendor_signup == 1 ? 'checked' : '' }}>
                                                <label for="vendor_signup" class="cr"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-4 control-label"
                                            for="vendor_default_signup_status">{{ __('Vendor Default Signup Status') }}</label>
                                        <div class="col-6">
                                            <select name="vendor_default_signup_status"
                                                class="form-control select2-hide-search">
                                                <option value="Pending"
                                                    {{ preference('vendor_default_signup_status') == 'Pending' ? 'selected' : '' }}>
                                                    {{ __('Pending') }}</option>
                                                <option value="Active"
                                                    {{ preference('vendor_default_signup_status') == 'Active' ? 'selected' : '' }}>
                                                    {{ __('Active') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-4 control-label"
                                               for="app_open_url">{{ __('App Open URL') }}</label>
                                        <div class="col-6">
                                            <input type="text" name="app_open_url" class="form-control inputFieldDesign" value="{{ preference('app_open_url') }}">
                                        </div>
                                    </div>
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
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/sweetalert/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/settings.min.js') }}"></script>
@endsection
