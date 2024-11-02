<div class="tab-pane fade" id="v-pills-topNav" role="tabpanel" aria-labelledby="v-pills-topNav-tab">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label">{{ __('Company logo') }}</label>
                <div class="col-sm-6">
                    <div class="switch switch-bg d-inline m-r-10">
                        <select class="form-control select2-hide-search" name="invoice[document][header][logo]">
                            <option value="logo"
                                {{ $invoice?->document?->header?->logo == 'logo' ? 'selected' : '' }}>
                                {{ __('Company logo') }}</option>
                            <option value="name"
                                {{ $invoice?->document?->header?->logo == 'name' ? 'selected' : '' }}>
                                {{ __('Company name') }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label ">{{ __('Show invoice No') }}</label>
                <div class="col-sm-1 -mt-6">
                    <input type="hidden" name="invoice[document][header][is_invoice_no_show]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input type="checkbox" name="invoice[document][header][is_invoice_no_show]"
                            {{ $invoice?->document?->header?->is_invoice_no_show ? 'checked' : '' }}
                            value="{{ $invoice?->document?->header?->is_invoice_no_show }}" id="show-phone-no1">
                        <label for="show-phone-no1" class="cr"></label>
                    </div>
                </div>
            </div>
            <div class="form-group row conditional" data-if="#show-phone-no1">
                <label for="meta_title" class="col-sm-4 text-left col-form-label ">{{ __('Invoice label') }}</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control inputFieldDesign"
                        name="invoice[document][header][invoice_label]" placeholder="{{ __('Invoice label') }}"
                        value="{{ $invoice?->document?->header?->invoice_label }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="meta_title"
                    class="col-sm-4 text-left col-form-label ">{{ __('Show customer info') }}</label>
                <div class="col-sm-1 -mt-6">
                    <input type="hidden" name="invoice[document][header][is_show_customer_info]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input type="checkbox" name="invoice[document][header][is_show_customer_info]"
                            {{ $invoice?->document?->header?->is_show_customer_info ? 'checked' : '' }}
                            value="{{ $invoice?->document?->header?->is_show_customer_info }}" id="show-customer-info">
                        <label for="show-customer-info" class="cr"></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
