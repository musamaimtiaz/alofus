@extends('admin.layouts.app')
@section('page_title', __('User verification'))
@section('content')
    <!-- Main content -->
    <div class="col-sm-12" id="user-verification-container">
        <div class="card">
            <div class="card-body row">
                <div
                    class="col-lg-3 col-12 z-index-10  ltr:ps-md-3 ltr:pe-0 ltr:ps-0 rtl:pe-md-3 rtl:ps-0 rtl:pe-0">
                    @include('admin.layouts.includes.account_settings_menu')
                </div>
                <div class="col-lg-9 col-12 ltr:ps-0 rtl:pe-0">
                    <div class="card card-info shadow-none mb-0">
                        @if (session('errorMgs'))
                            <div class="alert alert-warning fade in alert-dismissable">
                                <strong>{{ __('Warning') }}!</strong> {{ session('errorMgs') }}. <a class="close"
                                    href="#" data-dismiss="alert" aria-label="close" title="close">×</a>
                            </div>
                        @endif
                        <span id="smtp_head">
                            <div class="card-header p-t-20 border-bottom">
                                <h5>{{ __('User Verification') }}</h5>
                            </div>
                        </span>
                        <div class="card-body p-l-15">
                            <form action="{{ route('emailVerifySetting') }}" method="post" id="myform1"
                                class="form-horizontal">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="radio-item d-flex align-items-center my-2">
                                            <input type="radio" id="otp" name="verification"
                                                {{ preference('email') == 'otp' ? 'checked' : '' }} class=""
                                                value="otp">
                                            <label class="custom-control-label ltr:ms-2 rtl:me-2"
                                                for="otp">{{ __('OTP') }}</label>
                                        </div>
                                        <div class="radio-item d-flex align-items-center my-2">
                                            <input type="radio" id="token" name="verification"
                                                {{ preference('email') == 'token' ? 'checked' : '' }} class=""
                                                value="token">
                                            <label class="custom-control-label ltr:ms-2 rtl:me-2"
                                                for="token">{{ __('Token') }}</label>
                                        </div>
                                        <div class="radio-item d-flex align-items-center my-2">
                                            <input type="radio" id="both" name="verification"
                                                {{ preference('email') == 'both' ? 'checked' : '' }} class=""
                                                value="both">
                                            <label class="custom-control-label ltr:ms-2 rtl:me-2"
                                                for="both">{{ __('Both') }}</label>
                                        </div>
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
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('js')
        <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
    @endsection
