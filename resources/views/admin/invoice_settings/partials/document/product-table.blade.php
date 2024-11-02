<div class="tab-pane fade" id="v-pills-mainHeader" role="tabpanel" aria-labelledby="v-pills-mainHeader-tab">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group row">
                <label class="col-sm-3 pt-3 pt-md-2 control-label text-left"
                    for="invoice_product_image">{{ __('Image') }}</label>
                <div class="col-sm-9 d-flex">
                    <div class="mr-3">
                        <input type="hidden" name="invoice[document][product_table][is_image]" value="0">
                        <div class="switch switch-bg d-inline m-r-10 edit-is_default">
                            <input class="invoice_product_image" type="checkbox" value="{{ $invoice?->document?->product_table?->is_image }}"
                                name="invoice[document][product_table][is_image]" id="invoice_product_image"
                                {{ $invoice?->document?->product_table?->is_image ? 'checked' : '' }}>
                            <label for="invoice_product_image" class="cr"></label>
                        </div>
                    </div>
                    <div class="mt-1">
                        <span>{{ __('Show product image on the invoice PDF') }}</span>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="meta_title" class="col-sm-3 text-left col-form-label ">{{ __('Product column label') }}</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control inputFieldDesign" name="invoice[document][product_table][product_label]"
                        placeholder="{{ __('Product column label') }}" value="{{ $invoice?->document?->product_table?->product_label }}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 pt-3 pt-md-2 control-label text-left"
                    for="invoice_product_attribute">{{ __('Attribute') }}</label>
                <div class="col-sm-9 d-flex">
                    <div class="mr-3">
                        <input type="hidden" name="invoice[document][product_table][is_attribute]" value="0">
                        <div class="switch switch-bg d-inline m-r-10 edit-is_default">
                            <input class="invoice_product_attribute" type="checkbox" value="{{ $invoice?->document?->product_table?->is_attribute }}"
                                name="invoice[document][product_table][is_attribute]" id="invoice_product_attribute"
                                {{ $invoice?->document?->product_table?->is_attribute ? 'checked' : '' }}>
                            <label for="invoice_product_attribute" class="cr"></label>
                        </div>
                    </div>
                    <div class="mt-1">
                        <span>{{ __('Show attribute on the invoice PDF') }}</span>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="meta_title" class="col-sm-3 text-left col-form-label ">{{ __('Quantity') }}</label>
                <div class="col-sm-9 d-flex">
                    <div>
                        <input type="hidden" name="invoice[document][product_table][is_quentity]" value="0">
                        <div class="switch switch-bg d-inline m-r-10">
                            <input type="checkbox" name="invoice[document][product_table][is_quentity]" value="{{ $invoice?->document?->product_table?->is_quentity }}" {{ $invoice?->document?->product_table?->is_quentity ? 'checked' : '' }} id="show-quentity-lebal">
                            <label for="show-quentity-lebal" class="cr"></label>
                        </div>
                    </div>
                    <div class="mt-1">
                        <span>{{ __('Show product quantity on the invoice PDF') }}</span>
                    </div>
                </div>
            </div>
            <div class="form-group row conditional" data-if="#show-quentity-lebal">
                <label for="meta_title" class="col-sm-3 text-left col-form-label ">{{ __('Label') }}</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control inputFieldDesign" name="invoice[document][product_table][quentity_label]"
                        placeholder="{{ __('Quentity label') }}" value="{{ $invoice?->document?->product_table?->quentity_label }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="meta_title" class="col-sm-3 text-left col-form-label ">{{ __('Vendor name') }}</label>
                <div class="col-sm-9 d-flex">
                    <div>
                        <input type="hidden" name="invoice[document][product_table][is_vendor_name]" value="0">
                        <div class="switch switch-bg d-inline m-r-10">
                            <input type="checkbox" name="invoice[document][product_table][is_vendor_name]" value="{{ $invoice?->document?->product_table?->is_vendor_name }}" {{ $invoice?->document?->product_table?->is_vendor_name ? 'checked' : '' }} id="show-vendor-name">
                            <label for="show-vendor-name" class="cr"></label>
                        </div>
                    </div>
                    <div class="mt-1">
                        <span>{{ __('Enable the vendor name column in the product table on the invoice PDF') }}</span>
                    </div>
                </div>
            </div>
            <div class="form-group row conditional" data-if="#show-vendor-name">
                <label for="meta_title" class="col-sm-3 text-left col-form-label ">{{ __('Label') }}</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control inputFieldDesign" name="invoice[document][product_table][vendor_name_label]"
                        placeholder="{{ __('Vendor name label') }}" value="{{ $invoice?->document?->product_table?->vendor_name_label }}">
                </div>
            </div>
        </div>
    </div>
</div>
