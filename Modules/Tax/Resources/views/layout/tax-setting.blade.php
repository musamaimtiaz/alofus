<div class="noti-alert pad no-print warningMessage mt-2 px-4">
    <div class="alert warning-message abc">
        <strong id="warning-msg" class="msg"></strong>
    </div>
</div>
<div class="row px-md-4 tax-setting">
    <div class="col-sm-12">
        <div class="card-body border-bottom table-border-style p-0">
            <div class="form-tabs">
                <div class="tab-content box-shadow-unset px-0 py-2">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="form-group row">
                            <label for="calculate_tax" class="col-lg-3 col-4 control-label">{{ __('Calculate tax based on') }}</label>
                            <div class="col-lg-4 col-8">
                                <select class="form-control select2-hide-search" id="calculate_tax" name="calculate_tax">
                                    <option value="customer shipping address" {{ isset($setting['calculate_tax']) && $setting['calculate_tax'] == "customer shipping address" ? 'selected' : '' }}>{{ __('Customer shipping address') }}</option>
                                    <option value="customer billing address" {{ isset($setting['calculate_tax']) && $setting['calculate_tax'] == "customer billing address" ? 'selected' : '' }}>{{ __('Customer billing address') }}</option>
                                    <option value="base address" {{ isset($setting['calculate_tax']) && $setting['calculate_tax'] == "base address" ? 'selected' : '' }}>{{ __('Base address') }}</option>
                                </select>
                            </div>
                        </div>

                        @csrf

                        <div class="form-group row">
                            <label for="shipping_tax_class" class="col-4 col-lg-3 control-label">{{ __('Shipping tax class') }}</label>
                            <div class="col-lg-4 col-8">
                                <select class="form-control select2-hide-search" id="shipping_tax_class" name="shipping_tax_class">
                                    <option value="shipping tax class base on cart items" {{ isset($setting['shipping_tax_class']) && $setting['shipping_tax_class'] == "shipping tax class base on cart items" ? 'selected' : '' }}>{{ __('Shipping tax class base on cart items') }}</option>
                                    <option value="standard" {{ isset($setting['shipping_tax_class']) && $setting['shipping_tax_class'] == "standard" ? 'selected' : '' }}>{{ __('Standard') }}</option>
                                    @foreach ($tax_classes as $tax)
                                        <option value="{{ $tax->slug }}" {{ isset($setting['shipping_tax_class']) && $setting['shipping_tax_class'] == $tax->slug ? 'selected' : '' }}>{{ $tax->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="rounding" class="col-4 col-lg-3 control-label">{{ __('Rounding') }}</label>
                            <div class="col-8 col-lg-9 d-flex">
                                <div class="ltr:me-3 rtl:ms-3">
                                    <div class="switch p-0 switch-bg m-r-10">
                                        <input type="checkbox" name="rounding" class="checkActivity" id="rounding" value="0" {{ isset($setting['rounding']) && $setting['rounding'] == 1 ? 'checked' : '' }}>
                                        <label for="rounding" class="cr"></label>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <span>{{ __('Round tax at subtotal level, instead of rounding per line') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-4 col-lg-3 control-label">{{ __('Additional tax classes') }}</label>
                            <div class="col-8 col-lg-9 d-flex">
                                <div class="bg-body mb-2 border p-3">
                                    @foreach ($tax_classes as $tax)
                                        <div class="toast rounded-0 shadow-none text-dark border bg-light mb-2 tax-class w-100">
                                            <div class="d-flex justify-content-between p-2 align-items-center">
                                                <div class="toast-body pe-3 font-bold ltr:ps-0 rtl:pe-0 py-0 mr-4 font-weight-bold tax-class-name">
                                                    {{ $tax->name . ' ' . __('Rates') }}
                                                </div>
                                                <div>
                                                    <a href="javascript:void(0)"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#edit-tax-class"
                                                        data-id="{{ $tax->id }}"
                                                        data-name="{{ $tax->name }}"
                                                        data-slug="{{ $tax->slug }}"
                                                        class="text-dark edit-tax-class-btn">
                                                        <span title="{{ __('Edit') }}" class="fa fa-edit neg-transition-scale"> &nbsp;</span>
                                                    </a>
                                                    <form method="post" action="{{ route('tax.delete', ['id' => $tax->id]) }}" id="delete-tax-{{ $tax->id }}" accept-charset="UTF-8" class="display_inline delete_tax_class">
                                                        @csrf
                                                        <span class="text-dark cursor_pointer delete-button" data-bs-toggle="modal" data-label="Delete" data-delete="tax" data-bs-target="#confirmDelete"
                                                            data-id="{{ $tax->id }}" title="{{ __('Delete Tax') }}" data-title="{{ __('Delete :x', ['x' => __('Tax')]) }}" data-message="{{ __('Are you sure to delete this?') }}">
                                                            <i class="fa fa-trash"></i>
                                                        </span>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="toast border-0 rounded-0 shadow-none text-dark bg-warning cursor_pointer add-new-class d-block w-100" data-bs-toggle="modal" data-bs-target="#add-tax-class">
                                        <div class="p-2">
                                            <div class="toast-body text-center p-0">
                                                <a href="javascript:void(0)" class="text-dark">
                                                    <span class="fa fa-plus"> &nbsp;</span>
                                                    {{ __('Add New Class') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="display_tax_totals" class="col-lg-3 col-4 control-label">{{ __('Display tax totals') }}</label>
                            <div class="col-lg-4 col-8">
                                <select class="form-control select2-hide-search" id="display_tax_totals" name="display_tax_totals">
                                    <option value="as a single total" {{ isset($setting['display_tax_totals']) && $setting['display_tax_totals'] == "as a single total" ? 'selected' : '' }}>{{ __('As a single total') }}</option>
                                    <option value="itemized" {{ isset($setting['display_tax_totals']) && $setting['display_tax_totals'] == "itemized" ? 'selected' : '' }}>{{ __('Productized') }}</option>
                                </select>
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
                    <button type="submit" class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left tax-class-submit tax-setting-btn" id="footer-btn">
                        {{ __('Save') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
