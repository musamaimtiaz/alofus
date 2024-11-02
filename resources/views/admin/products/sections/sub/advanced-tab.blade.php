<div class="tab-pane mini-form-holder fade {{ !preference('manage_stock') && isset($product) && ($product->isGroupedProduct() || $product->isVariableProduct()) ? 'show active' : '' }}"
    id="tabs-h" role="tabpanel" aria-labelledby="tabs-8">
    <div
        class="form-group row px-2 mt-4 conditional-dom not-simple-dom not-variable-dom not-external-dom {{ isset($product) && $product->isGroupedProduct() ? '' : 'd-none' }}">
        <div class="col-md-2 px-0 px-md-2">
            <label for="Upsells" class="sp-title control-label">{{ __('Group Products') }}</label>
        </div>
        <div class="col-md-8 px-0 px-md-2">
            <div class="d-flex align-items-center">
                <select class="form-control select-ajax" name="meta_grouped_products[]" multiple="multiple">
                    @isset($groupedProducts)
                        @foreach ($groupedProducts as $id => $name)
                            <option value="{{ $id }}" selected="selected">{{ $name }}</option>
                        @endforeach
                    @endisset
                </select>

                <div
                    class="tooltips cursor-pointer neg-transition-scale  ltr:ms-2 rtl:me-2">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M12 6C12 9.31371 9.31371 12 6 12C2.68629 12 0 9.31371 0 6C0 2.68629 2.68629 0 6 0C9.31371 0 12 2.68629 12 6ZM6.66667 10C6.66667 10.3682 6.36819 10.6667 6 10.6667C5.63181 10.6667 5.33333 10.3682 5.33333 10C5.33333 9.63181 5.63181 9.33333 6 9.33333C6.36819 9.33333 6.66667 9.63181 6.66667 10ZM6 1.33333C4.52724 1.33333 3.33333 2.52724 3.33333 4H4.66667C4.66667 3.26362 5.26362 2.66667 6 2.66667H6.06287C6.76453 2.66667 7.33333 3.23547 7.33333 3.93713V4.27924C7.33333 4.62178 7.11414 4.92589 6.78918 5.03421C5.91976 5.32402 5.33333 6.13765 5.33333 7.05409V8.66667H6.66667V7.05409C6.66667 6.71155 6.88586 6.40744 7.21082 6.29912C8.08024 6.00932 8.66667 5.19569 8.66667 4.27924V3.93713C8.66667 2.49909 7.50091 1.33333 6.06287 1.33333H6Z"
                            fill="#898989" />
                    </svg>
                    <span
                        class="tooltiptexts">{{ __('This lets you choose which products are part of this group.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div
        class="form-group row px-2 mt-4 conditional-dom not-grouped-dom {{ isset($product) && $product->isGroupedProduct() ? 'd-none' : '' }}">
        <div class="col-md-2 px-0 px-md-2">
            <label for="Upsells" class="sp-title control-label">{{ __('Upsells') }}</label>
        </div>
        <div class="col-md-8 px-0 px-md-2">
            <div class="d-flex align-items-center">
                <select class="form-control select-ajax" name="upsells[]" multiple="multiple">
                    @isset($productUpsells)
                        @foreach ($productUpsells as $id => $name)
                            <option value="{{ $id }}" selected="selected">{{ $name }}</option>
                        @endforeach
                    @endisset
                </select>

                <div
                    class="tooltips cursor-pointer neg-transition-scale  ltr:ms-2 rtl:me-2">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M12 6C12 9.31371 9.31371 12 6 12C2.68629 12 0 9.31371 0 6C0 2.68629 2.68629 0 6 0C9.31371 0 12 2.68629 12 6ZM6.66667 10C6.66667 10.3682 6.36819 10.6667 6 10.6667C5.63181 10.6667 5.33333 10.3682 5.33333 10C5.33333 9.63181 5.63181 9.33333 6 9.33333C6.36819 9.33333 6.66667 9.63181 6.66667 10ZM6 1.33333C4.52724 1.33333 3.33333 2.52724 3.33333 4H4.66667C4.66667 3.26362 5.26362 2.66667 6 2.66667H6.06287C6.76453 2.66667 7.33333 3.23547 7.33333 3.93713V4.27924C7.33333 4.62178 7.11414 4.92589 6.78918 5.03421C5.91976 5.32402 5.33333 6.13765 5.33333 7.05409V8.66667H6.66667V7.05409C6.66667 6.71155 6.88586 6.40744 7.21082 6.29912C8.08024 6.00932 8.66667 5.19569 8.66667 4.27924V3.93713C8.66667 2.49909 7.50091 1.33333 6.06287 1.33333H6Z"
                            fill="#898989" />
                    </svg>
                    <span class="tooltiptexts">{{ __('Upsale products that you want attach to this product.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div
        class="form-group row px-2 mt-4 conditional-dom not-external-dom not-grouped-dom {{ isset($product) && ($product->isExternalProduct() || $product->isGroupedProduct()) ? 'd-none' : '' }}">
        <div class="col-md-2 px-md-2">
            <label for="Cross-sells" class="sp-title control-label">{{ __('Cross Sales') }}</label>
        </div>
        <div class="col-md-8 px-0 px-md-2">
            <div class="d-flex align-items-center">
                <select class="form-control select-ajax" name="cross_sells[]" multiple="multiple">
                    @isset($productCrossSells)
                        @foreach ($productCrossSells as $id => $name)
                            <option value="{{ $id }}" selected="selected">{{ $name }}</option>
                        @endforeach
                    @endisset
                </select>
                <div
                    class="tooltips cursor-pointer neg-transition-scale  ltr:ms-2 rtl:me-2">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M12 6C12 9.31371 9.31371 12 6 12C2.68629 12 0 9.31371 0 6C0 2.68629 2.68629 0 6 0C9.31371 0 12 2.68629 12 6ZM6.66667 10C6.66667 10.3682 6.36819 10.6667 6 10.6667C5.63181 10.6667 5.33333 10.3682 5.33333 10C5.33333 9.63181 5.63181 9.33333 6 9.33333C6.36819 9.33333 6.66667 9.63181 6.66667 10ZM6 1.33333C4.52724 1.33333 3.33333 2.52724 3.33333 4H4.66667C4.66667 3.26362 5.26362 2.66667 6 2.66667H6.06287C6.76453 2.66667 7.33333 3.23547 7.33333 3.93713V4.27924C7.33333 4.62178 7.11414 4.92589 6.78918 5.03421C5.91976 5.32402 5.33333 6.13765 5.33333 7.05409V8.66667H6.66667V7.05409C6.66667 6.71155 6.88586 6.40744 7.21082 6.29912C8.08024 6.00932 8.66667 5.19569 8.66667 4.27924V3.93713C8.66667 2.49909 7.50091 1.33333 6.06287 1.33333H6Z"
                            fill="#898989" />
                    </svg>
                    <span
                        class="tooltiptexts">{{ __('Cross sale products that you want attach to this product.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row px-2 mt-4">
        <div class="col-md-2 px-0 px-md-2">
            <label for="Cross-sells" class="sp-title control-label">{{ __('Related Products') }}</label>
        </div>
        <div class="col-md-8 px-0 px-md-2">
            <div class="d-flex align-items-center">
                <select class="form-control select-ajax h-40" name="related_products[]" multiple="multiple">
                    @isset($productRelatedProducts)
                        @foreach ($productRelatedProducts as $id => $name)
                            <option value="{{ $id }}" selected="selected">{{ $name }}</option>
                        @endforeach
                    @endisset
                </select>
                <div
                    class="tooltips cursor-pointer neg-transition-scale  ltr:ms-2 rtl:me-2">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M12 6C12 9.31371 9.31371 12 6 12C2.68629 12 0 9.31371 0 6C0 2.68629 2.68629 0 6 0C9.31371 0 12 2.68629 12 6ZM6.66667 10C6.66667 10.3682 6.36819 10.6667 6 10.6667C5.63181 10.6667 5.33333 10.3682 5.33333 10C5.33333 9.63181 5.63181 9.33333 6 9.33333C6.36819 9.33333 6.66667 9.63181 6.66667 10ZM6 1.33333C4.52724 1.33333 3.33333 2.52724 3.33333 4H4.66667C4.66667 3.26362 5.26362 2.66667 6 2.66667H6.06287C6.76453 2.66667 7.33333 3.23547 7.33333 3.93713V4.27924C7.33333 4.62178 7.11414 4.92589 6.78918 5.03421C5.91976 5.32402 5.33333 6.13765 5.33333 7.05409V8.66667H6.66667V7.05409C6.66667 6.71155 6.88586 6.40744 7.21082 6.29912C8.08024 6.00932 8.66667 5.19569 8.66667 4.27924V3.93713C8.66667 2.49909 7.50091 1.33333 6.06287 1.33333H6Z"
                            fill="#898989" />
                    </svg>
                    <span class="tooltiptexts">{{ __('Products related to this product.') }}</span>
                </div>
            </div>
        </div>
    </div>
    <hr class="mt-30p mx-6p">
    <div
        class="form-group row px-7 mt-27p conditional-dom not-external-dom not-grouped-dom {{ isset($product) && ($product->isExternalProduct() || $product->isGroupedProduct()) ? 'd-none' : '' }}">
        <div class="col-md-2 p-0-res">
            <label for="Protection" class="sp-title control-label"> {{ __('Purchase note') }}</label>
        </div>
        <div class="col-md-8 px-0 px-md-2">
            <textarea type="text" rows="2" class="form-control" name="meta_purchase_note">{{ isset($product) ? $product->purchase_note : '' }}</textarea>
        </div>
    </div>
    <div
        class="form-group row px-7 mt-27p conditional-dom not-grouped-dom {{ isset($product) && $product->isGroupedProduct() ? 'd-none' : '' }}">
        <div class="col-md-2 p-0-res">
            <label for="meta_estimated_delivery" class="sp-title control-label"> {{ __('Estimated Delivery') }}
                ({{ __('days') }})</label>
        </div>
        <div class="col-md-8 px-0 px-md-2">
            <input type="number" name="meta_estimated_delivery" placeholder="{{ __('No. of days') }}"
                class="form-control inputFieldDesign"
                value="{{ isset($product) ? $product->meta_estimated_delivery : '' }}">
        </div>
    </div>

    <input type="hidden" name="meta_enable_reviews" value="0">
    @ifSettings('reviews_enable_product_review')
    <div class="form-group row px-7 mt-30p">
        <div class="col-md-2 col-5">
            <label for="enable-reviews" class="crs sp-title">{{ __('Enable Reviews') }}</label>
        </div>
        <div class="col-md-5 col-7">
            <div class="checkbox checkbox-primary d-inline">
                <input type="checkbox" id="enable-reviews"
                    {{ isset($product) && $product->isReviewEnabled() ? 'checked' : '' }} value="1"
                    name="meta_enable_reviews">
                <label for="enable-reviews" class="crs sp-title"> </label>
            </div>
        </div>
    </div>
    @endifSettings
</div>
