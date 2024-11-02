@extends('admin.layouts.app')
@section('page_title', __('SMS Setup'))

@section('content')
    <!-- Main content -->
    <div class="col-sm-12" id="sms-configuration-settings-container">
        <div class="card">
            <div class="card-body row">
                <div class="col-lg-3 ltr:ps-1 ltr:ps-lg-3 ltr:pe-0 rtl:pe-1 rtl:pe-lg-3 rtl:ps-0">
                    @include('admin.layouts.includes.sms-settings-menu')
                </div>
                <div class="col-lg-9 ltr:ps-1 ltr:ps-lg-0 rtl:pe-1 rtl:pe-lg-0">
                    <div class="card card-info shadow-none mb-0">
                        <x-backend.sms.error-message />
                        
                        <x-backend.sms.card-title title="{{ __('Zender') }}" />
                    </div>
                    
                    <div>
                        <form action="{{ route('sms.config.zender.update') }}" method="post" class="form-horizontal">
                            @csrf
                            <div class="card-body p-l-15">
                                <div class="form-group row">
                                    <label class="col-sm-3 control-label require">{{ __('Site Url') }}</label>

                                    <div class="col-sm-8">
                                        <input type="text"
                                            value="{{ isset($gateway->data['site_url']) ? $gateway->data['site_url'] : '' }}"
                                            class="form-control inputFieldDesign" name="site_url" required
                                            placeholder="https://previews.titansystems.ph/zender/"
                                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                    </div>
                                    <label class="offset-3 f-12 col-sm-8" for="">{{ __('The site url of your Zender. Do not add ending slash.') }}</label>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 control-label require">{{ __('Api Key') }}</label>

                                    <div class="col-sm-8">
                                        <input type="text"
                                            value="{{ isset($gateway->data['api_key']) ? $gateway->data['api_key'] : '' }}"
                                            class="form-control inputFieldDesign" name="api_key" required
                                            placeholder="6f915812345553ce647442ef1bd58d6614bd794f"
                                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                    </div>
                                    <label class="offset-3 f-12 col-sm-8">{{ __('Your Zender API key. Please make sure that it is correct and required permissions are granted: :x', ['x' => 'sms_send, wa_send']) }}</label>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 control-label require">{{ __('Service') }}</label>

                                    <div class="col-sm-8">
                                        <select name="service" id="service" class="form-control select2-hide-search">
                                            <option @selected(isset($gateway->data['service']) && $gateway->data['service'] == '1') value="1">{{ __('SMS') }}</option>
                                            <option @selected(isset($gateway->data['service']) && $gateway->data['service'] == '2') value="2">{{ __('WhatsApp') }}</option>
                                        </select>
                                    </div>
                                    <label class="offset-3 f-12 col-sm-8">{{ __('Select the sending service. Please make sure that the API key has the following permissions: :x', ['x' => 'sms_send, wa_send']) }}</label>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 control-label">{{ __('WhatsApp') }}</label>

                                    <div class="col-sm-8">
                                        <input type="text"
                                            value="{{ isset($gateway->data['whatsapp']) ? $gateway->data['whatsapp'] : '' }}"
                                            class="form-control inputFieldDesign" name="whatsapp"
                                            placeholder="1698563217950a4152c2b4aa3ad78bdd6b366cc17964edd53976b07">
                                    </div>
                                    <label class="offset-3 f-12 col-sm-8">{{ __('For WhatsApp service only. WhatsApp account ID you want to use for sending.') }}</label>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 control-label">{{ __('Device') }}</label>

                                    <div class="col-sm-8">
                                        <input type="text"
                                            value="{{ isset($gateway->data['device']) ? $gateway->data['device'] : '' }}"
                                            class="form-control inputFieldDesign" name="device">
                                    </div>
                                    <label class="offset-3 f-12 col-sm-8">{{ __('For SMS service only. Linked device unique ID. Please only enter this field if you are sending using one of your devices.') }}</label>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 control-label">{{ __('Gateway') }}</label>

                                    <div class="col-sm-8">
                                        <input type="text"
                                            value="{{ isset($gateway->data['gateway']) ? $gateway->data['gateway'] : '' }}"
                                            class="form-control inputFieldDesign" name="gateway">
                                    </div>
                                    <label class="offset-3 f-12 col-sm-8">{{ __('For SMS service only. Partner device unique ID or gateway ID. Please only enter this field if you are sending using a partner device or third party gateway.') }}</label>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 control-label require">{{ __('SIM') }}</label>

                                    <div class="col-sm-8">
                                        <select name="sim" id="sim" class="form-control select2-hide-search">
                                            <option @selected(isset($gateway->data['sim']) && $gateway->data['sim'] == '1') value="1">SIM 1</option>
                                            <option @selected(isset($gateway->data['sim']) && $gateway->data['sim'] == '2') value="2">SIM 2</option>
                                        </select>
                                    </div>
                                    <label class="offset-3 f-12 col-sm-8">{{ __('For SMS service only. Select the sim slot you want to use for sending the messages. Please only enter this field if you are sending using your device. This is ignored for partner devices and third party gateways.') }}</label>
                                </div>
                                
                                <x-backend.sms.default-switcher provider="zender" />
                            </div>
                            
                            <x-backend.sms.save-button />
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
