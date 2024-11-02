<div class="noti-alert pad no-print warningMessage mt-2 px-4">
    <div class="alert warning-message abc">
        <strong id="warning-msg" class="msg"></strong>
    </div>
</div>
<div class="row px-4 shipping-setting">
    <div class="col-sm-12">
        <div class="card-body border-bottom table-border-style p-0">
            <div class="form-tabs">
                <div class="tab-content box-shadow-unset px-0 py-2">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="form-group row mt-14">
                            <label class="col-md-3 col-4 control-label">{{ __('Calculations') }}</label>
                            <div class="col-8 col-md-7">
                                <div class="checkbox checkbox-warning checkbox-fill d-block">
                                    @csrf
                                    <input type="checkbox" name="shipping_calculator_cart_page" id="calculator_shipping" value="1" {{ preference('shipping_calculator_cart_page') == 1 ? 'checked' : '' }}>
                                    <label class="cr" for="calculator_shipping">{{ __('Enable the shipping calculator on the cart page') }}</label>
                                </div>
                                <div class="checkbox checkbox-warning checkbox-fill d-block">
                                    <input type="checkbox" name="hide_shipping_cost" id="hide_shipping_cost" value="1" {{ preference('hide_shipping_cost') == 1 ? 'checked' : '' }}>
                                    <label class="cr" for="hide_shipping_cost">{{ __('Hide shipping costs until an address is entered') }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-4 control-label">{{ __('Shipping destination') }}</label>
                            <div class="col-8 col-md-7">
                                <div class="row radio ">
                                    <div class="col-sm-12 mb-2">
                                        <div class="radio radio-warning d-inline">
                                            <input type="radio" name="shipping_destination" id="shipping_address" value="shipping_address" {{ preference('shipping_destination') == 'shipping_address' ? 'checked' : '' }}>
                                            <label class="cr" for="shipping_address">{{ __('Default to customer shipping address') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 mb-2">
                                        <div class="radio radio-warning d-inline">
                                            <input type="radio" name="shipping_destination" id="billing_address" value="billing_address" {{ preference('shipping_destination') == 'billing_address' ? 'checked' : '' }}>
                                            <label class="cr" for="billing_address">{{ __('Default to customer billing address') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="radio radio-warning d-inline">
                                            <input type="radio" name="shipping_destination" id="force_billing_address" value="force_billing_address" {{ preference('shipping_destination') == 'force_billing_address' ? 'checked' : '' }}>
                                            <label class="cr" for="force_billing_address">{{ __('Force shipping to the customer billing address') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer p-0">
            <div class="form-group row">
                <label for="btn_save" class="col-sm-3 control-label"></label>
                <div class="col-sm-12">
                    <button type="submit" class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left shipping-class-submit shipping-setting-btn" id="footer-btn">
                        {{ __('Save') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
