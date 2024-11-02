<div class="tab-pane fade mini-form-holder" id="tabs-c" role="tabpanel" aria-labelledby="tabs-three">
    <div class="form-group row px-2 mt-4 d-flex align-items-center">
        <div class="col-md-5 p-0-res">
            <div class="row">
                <div class="col-md-4">
                    <label for="shipping_id" class="sp-title control-label">{{ __('Shipping') }}</label>
                </div>
                <div class="col-md-8">
                    <select class="form-control select2 sl_common_bx" name="meta_shipping_id">
                        <option>{{ __('Select One') }}</option>
                        @foreach ($shippings as $shiping)
                            <option value="{{ $shiping->slug }}"
                                {{ isset($product) && $shiping->slug == $product->shipping_id ? 'selected' : '' }}>
                                {{ $shiping->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-7 p-0-res">
            <div class="row mt-15-res mt-2">
                <div class="col-md-5 col-6">
                    <label for="is_cash_on_delivery"
                        class="crs sp-title d-flx-n d-unset">{{ __('Cash On Delivery') }}</label>
                </div>
                <div class="col-md-2 col-6">
                    <div class="checkbox checkbox-primary d-inline">
                        <input type="hidden" name="meta_cash_on_delivery" value="0">
                        <input type="checkbox" id="is_cash_on_delivery" name="meta_cash_on_delivery" value="1"
                            {{ isset($product) && $product->cash_on_delivery == 1 ? 'checked' : '' }}>
                        <label for="is_cash_on_delivery" class="crs sp-title d-flx-n d-unset"></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="mt-4 mx-2">
    <div class="form-group row px-2 mt-4">
        <div class="col-md-5 p-0-res">
            <div class="row">
                <div class="col-md-4">
                    <label for="Weight" class="sp-title control-label">{{ __('Weight') }}
                        (@preference('measurement_weight'))</label>
                </div>
                <div class="col-md-8">
                    <div class="d-flex align-items-center">
                        <input type="text" placeholder="0"
                            class="form-control positive-float-number inputFieldDesign" maxlength="8" id="Weight"
                            name="meta_weight" value="{{ isset($product) ? $product->weight : '' }}">
                        <div
                            class="tooltips cursor-pointer neg-transition-scale  ltr:ms-2 rtl:me-2">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M12 6C12 9.31371 9.31371 12 6 12C2.68629 12 0 9.31371 0 6C0 2.68629 2.68629 0 6 0C9.31371 0 12 2.68629 12 6ZM6.66667 10C6.66667 10.3682 6.36819 10.6667 6 10.6667C5.63181 10.6667 5.33333 10.3682 5.33333 10C5.33333 9.63181 5.63181 9.33333 6 9.33333C6.36819 9.33333 6.66667 9.63181 6.66667 10ZM6 1.33333C4.52724 1.33333 3.33333 2.52724 3.33333 4H4.66667C4.66667 3.26362 5.26362 2.66667 6 2.66667H6.06287C6.76453 2.66667 7.33333 3.23547 7.33333 3.93713V4.27924C7.33333 4.62178 7.11414 4.92589 6.78918 5.03421C5.91976 5.32402 5.33333 6.13765 5.33333 7.05409V8.66667H6.66667V7.05409C6.66667 6.71155 6.88586 6.40744 7.21082 6.29912C8.08024 6.00932 8.66667 5.19569 8.66667 4.27924V3.93713C8.66667 2.49909 7.50091 1.33333 6.06287 1.33333H6Z"
                                    fill="#898989" />
                            </svg>
                            <span class="tooltiptexts">{{ __('Weight unit is set by admin.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7 p-0-res">
            <div class="row">
                <div class="col-md-3">
                    <label for="Dimensions" class="sp-title control-label">{{ __('Dimensions') }}
                        (@preference('measurement_dimension'))</label>
                </div>
                <div class="col-md-3 mt-15-res">
                    <input type="text" placeholder="{{ __('Length') }}"
                        class="form-control positive-float-number inputFieldDesign" maxlength="8"
                        name="meta_dimension[length]"
                        value="{{ isset($product) ? array_val($product->dimension, 'length', '') : '' }}">
                </div>
                <div class="col-md-3 mt-15-res">
                    <input type="text" placeholder="{{ __('Width') }}"
                        class="form-control positive-float-number inputFieldDesign" maxlength="8"
                        name="meta_dimension[width]"
                        value="{{ isset($product) ? array_val($product->dimension, 'width', '') : '' }}">
                </div>
                <div class="col-md-3 mt-15-res">
                    <div class="d-flx align-items-center">
                        <input type="text" placeholder="{{ __('Height') }}"
                            class="form-control positive-float-number inputFieldDesign" maxlength="8"
                            name="meta_dimension[height]"
                            value="{{ isset($product) ? array_val($product->dimension, 'height', '') : '' }}">
                        <div
                            class="tooltips cursor-pointer neg-transition-scale  ltr:ms-2 rtl:me-2">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M12 6C12 9.31371 9.31371 12 6 12C2.68629 12 0 9.31371 0 6C0 2.68629 2.68629 0 6 0C9.31371 0 12 2.68629 12 6ZM6.66667 10C6.66667 10.3682 6.36819 10.6667 6 10.6667C5.63181 10.6667 5.33333 10.3682 5.33333 10C5.33333 9.63181 5.63181 9.33333 6 9.33333C6.36819 9.33333 6.66667 9.63181 6.66667 10ZM6 1.33333C4.52724 1.33333 3.33333 2.52724 3.33333 4H4.66667C4.66667 3.26362 5.26362 2.66667 6 2.66667H6.06287C6.76453 2.66667 7.33333 3.23547 7.33333 3.93713V4.27924C7.33333 4.62178 7.11414 4.92589 6.78918 5.03421C5.91976 5.32402 5.33333 6.13765 5.33333 7.05409V8.66667H6.66667V7.05409C6.66667 6.71155 6.88586 6.40744 7.21082 6.29912C8.08024 6.00932 8.66667 5.19569 8.66667 4.27924V3.93713C8.66667 2.49909 7.50091 1.33333 6.06287 1.33333H6Z"
                                    fill="#898989" />
                            </svg>
                            <span class="tooltiptexts">{{ __('Dimension unit is set by admin.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
