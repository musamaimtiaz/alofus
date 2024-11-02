<div class="tab-pane fade" id="v-pills-deliveryDetails" role="tabpanel" aria-labelledby="v-pills-deliveryDetails-tab">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group row">
                <label for="meta_title" class="col-sm-3 text-left col-form-label ">{{ __('Delivery details') }}</label>
                <div class="col-sm-9 d-flex">
                    <div>
                        <input type="hidden" name="invoice[document][delivery_details][is_delivery_details]" value="0">
                        <div class="switch switch-bg d-inline m-r-10">
                            <input type="checkbox" name="invoice[document][delivery_details][is_delivery_details]" value="{{ $invoice?->document?->delivery_details?->is_delivery_details }}" {{ $invoice?->document?->delivery_details?->is_delivery_details ? 'checked' : '' }} id="show-delivery-details">
                            <label for="show-delivery-details" class="cr"></label>
                        </div>
                    </div>
                    <div class="mt-1">
                        <span>{{ __('Enable invoice pdf delivery details section') }}</span>
                    </div>
                </div>
            </div>
            <div class="conditional" data-if="#show-delivery-details">
                <div class="form-group row">
                    <label for="meta_title" class="col-sm-3 text-left col-form-label ">{{ __('Label') }}</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control inputFieldDesign" name="invoice[document][delivery_details][delivery_details_labal]"
                            placeholder="{{ __('Delivery details label') }}" value="{{ $invoice?->document?->delivery_details?->delivery_details_labal }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="meta_title" class="col-sm-3 text-left col-form-label ">{{ __('Shipping address') }}</label>
                    <div class="col-sm-9 d-flex">
                        <div>
                            <input type="hidden" name="invoice[document][delivery_details][is_shopping_address]" value="0">
                            <div class="switch switch-bg d-inline m-r-10">
                                <input type="checkbox" name="invoice[document][delivery_details][is_shopping_address]" value="{{ $invoice?->document?->delivery_details?->is_shopping_address }}" {{ $invoice?->document?->delivery_details?->is_shopping_address ? 'checked' : '' }} id="show-delivery-shipping-address">
                                <label for="show-delivery-shipping-address" class="cr"></label>
                            </div>
                        </div>
                        <div class="mt-1">
                            <span>{{ __('Enable invoice pdf shipping address section') }}</span>
                        </div>
                    </div>
                </div>
    
                <div class="form-group row conditional" data-if="#show-delivery-shipping-address">
                    <label for="meta_title" class="col-sm-3 text-left col-form-label ">{{ __('Label') }}</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control inputFieldDesign" name="invoice[document][delivery_details][shopping_address_label]"
                            placeholder="{{ __('Shipping address label') }}" value="{{ $invoice?->document?->delivery_details?->shopping_address_label }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="meta_title" class="col-sm-3 text-left col-form-label ">{{ __('Estimated time') }}</label>
                    <div class="col-sm-9 d-flex">
                       <div>
                            <input type="hidden" name="invoice[document][delivery_details][is_estimate_time_section]" value="0">
                            <div class="switch switch-bg d-inline m-r-10">
                                <input type="checkbox" name="invoice[document][delivery_details][is_estimate_time_section]" value="{{ $invoice?->document?->delivery_details?->is_estimate_time_section }}" id="show-estimate-time" {{ $invoice?->document?->delivery_details?->is_estimate_time_section ? 'checked' : '' }}>
                                <label for="show-estimate-time" class="cr"></label>
                            </div>
                       </div>
                        <div class="mt-1">
                            <span>{{ __('Enable invoice pdf estimated time section') }}</span>
                        </div>
                    </div>
                </div>
    
                <div class="form-group row conditional" data-if="#show-estimate-time">
                    <label for="meta_title" class="col-sm-3 text-left col-form-label ">{{ __('Label') }}</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control inputFieldDesign" name="invoice[document][delivery_details][estimate_time_label]"
                            placeholder="{{ __('Estimated time label') }}" value="{{ $invoice?->document?->delivery_details?->estimate_time_label }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="meta_title" class="col-sm-3 text-left col-form-label ">{{ __('Payment') }}</label>
                    <div class="col-sm-9 d-flex">
                        <div>
                            <input type="hidden" name="invoice[document][delivery_details][is_payment_section]" value="0">
                            <div class="switch switch-bg d-inline m-r-10">
                                <input type="checkbox" name="invoice[document][delivery_details][is_payment_section]" value="{{ $invoice?->document?->delivery_details?->is_payment_section }}" id="show-delivery-payment" {{ $invoice?->document?->delivery_details?->is_payment_section ? 'checked' : '' }}>
                                <label for="show-delivery-payment" class="cr"></label>
                            </div>
                        </div>

                        <div class="mt-1">
                            <span>{{ __('Enable invoice pdf payment section') }}</span>
                        </div>
                    </div>
                </div>
    
                <div class="form-group row conditional" data-if="#show-delivery-payment">
                    <label for="meta_title" class="col-sm-3 text-left col-form-label ">{{ __('Label') }}</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control inputFieldDesign" name="invoice[document][delivery_details][payment_label]"
                            placeholder="{{ __('Payment label') }}" value="{{ $invoice?->document?->delivery_details?->payment_label }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
