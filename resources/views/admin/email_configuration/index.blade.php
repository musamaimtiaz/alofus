@extends('admin.layouts.app')
@section('page_title', __('Email Setup'))

@section('content')
    <!-- Main content -->
    <div class="col-sm-12" id="email-configuration-settings-container">
        <div class="card">
            <div class="card-body row">
                <div class="col-lg-3 ltr:ps-1 ltr:ps-lg-3 ltr:pe-0 rtl:pe-1 rtl:pe-lg-3 rtl:ps-0">
                    @include('admin.layouts.includes.email_settings_menu')
                </div>
                <div class="col-lg-9 ltr:ps-1 ltr:ps-lg-0 rtl:pe-1 rtl:pe-lg-0">
                    <div class="card card-info shadow-none mb-0">
                        @if (session('errorMgs'))
                            <div class="alert alert-warning fade in alert-dismissable">
                                <strong>{{ __('Warning') }}!</strong> {{ session('errorMgs') }}. <a class="close" href="#"
                                    data-bs-dismiss="alert" aria-label="close" title="close">×</a>
                            </div>
                        @endif
                        <span id="smtp_head">
                            <div class="card-header p-t-20 border-bottom">
                                <h5>{{ __('Setup') }}
                                    @if ($emailConfigData)
                                        @if ($emailConfigData->status == 1 && $emailConfigData->protocol == 'smtp')
                                            (<span class="color_green"><i class="fa fa-check" aria-hidden="true"></i>
                                                {{ __('Verified') }}</span>)
                                        @endif
                                    @endif
                                </h5>
                            </div>
                        </span>
                        <form action="{{ route('emailConfigurations.index') }}" method="post" id="myform1"
                            class="form-horizontal">
                            <div class="card-body p-l-15">
                                <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                                <div class="form-group row">
                                    <label class="col-sm-3 control-label">{{ __('Email Protocol') }}</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2-hide-search inputFieldDesign" id="type" name="protocol">
                                            <option value="smtp"
                                                {{ $emailConfigData && $emailConfigData->protocol == 'smtp' ? 'selected="selected"' : '' }}>
                                                {{ __('SMTP') }}</option>
                                            <option value="sendmail"
                                                {{ $emailConfigData && $emailConfigData->protocol == 'sendmail' ? 'selected="selected"' : '' }}>
                                                {{ __('Send Mail') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <!--smtp form start here-->
                                <span id="smtp_form">
                                    <input type="hidden" name="type" value="smtp" id="type_val">
                                    <div class="form-group row">
                                        <label class="col-sm-3 control-label require">{{ __('Email Encription') }}</label>

                                        <div class="col-sm-8">
                                            <input type="text"
                                                value="{{ isset($emailConfigData->encryption) ? $emailConfigData->encryption : '' }}"
                                                class="form-control inputFieldDesign" name="encryption" required
                                                oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 control-label require">{{ __('SMTP Host') }}</label>

                                        <div class="col-sm-8">
                                            <input type="text"
                                                value="{{ isset($emailConfigData->smtp_host) && config('martvill.is_demo') ? techEncrypt($emailConfigData->smtp_host) : $emailConfigData->smtp_host ?? '' }}"
                                                class="form-control inputFieldDesign" name="smtp_host" required
                                                oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 control-label require">{{ __('SMTP Port') }}</label>

                                        <div class="col-sm-8">
                                            <input type="text"
                                                value="{{ isset($emailConfigData->smtp_port) ? $emailConfigData->smtp_port : '' }}"
                                                class="form-control inputFieldDesign" name="smtp_port" required
                                                oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 control-label require">{{ __('SMTP Email') }}</label>

                                        <div class="col-sm-8">
                                            <input type="text"
                                                value="{{ isset($emailConfigData->smtp_email) && config('martvill.is_demo') ? techEncrypt($emailConfigData->smtp_email) : $emailConfigData->smtp_email ?? '' }}"
                                                class="form-control inputFieldDesign" name="smtp_email" required
                                                oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                                data-type-mismatch="{{ __('Enter a valid :x.', ['x' => strtolower(__('Email'))]) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 control-label require">{{ __('From Address') }}</label>

                                        <div class="col-sm-8">
                                            <input type="email"
                                                value="{{ isset($emailConfigData->from_address) && config('martvill.is_demo') ? techEncrypt($emailConfigData->from_address) : $emailConfigData->from_address ?? '' }}"
                                                class="form-control inputFieldDesign" name="from_address" required
                                                oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                                data-type-mismatch="{{ __('Enter a valid :x.', ['x' => strtolower(__('Email'))]) }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 control-label require">{{ __('From Name') }}</label>

                                        <div class="col-sm-8">
                                            <input type="text"
                                                value="{{ isset($emailConfigData->from_name) && config('martvill.is_demo') ? techEncrypt($emailConfigData->from_name) : $emailConfigData->from_name ?? '' }}"
                                                class="form-control inputFieldDesign" name="from_name" required
                                                oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 control-label require">{{ __('SMTP username') }}</label>

                                        <div class="col-sm-8">
                                            <input type="text"
                                                value="{{ isset($emailConfigData->smtp_username) && config('martvill.is_demo') ? techEncrypt($emailConfigData->smtp_username) : $emailConfigData->smtp_username ?? '' }}"
                                                class="form-control inputFieldDesign" name="smtp_username" required
                                                oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                                data-type-mismatch="{{ __('Enter a valid :x.', ['x' => strtolower(__('Username'))]) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 control-label require">{{ __('SMTP Password') }}</label>

                                        <div class="col-sm-8">
                                            <input type="password"
                                                value="{{ isset($emailConfigData->smtp_password) && config('martvill.is_demo') ? techEncrypt($emailConfigData->smtp_password) : $emailConfigData->smtp_password ?? '' }}"
                                                class="form-control inputFieldDesign" name="smtp_password" required
                                                oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                        </div>
                                    </div>
                                </span>
                            </div>
                            <div class="card-footer p-0">
                                <div class="form-group row">
                                    <label for="btn_save" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left" id="footer-btn">
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
    <script src="{{ asset('public/dist/js/custom/email-configuration.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
@endsection
