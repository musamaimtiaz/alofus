<div class="tab-pane fade" id="v-pills-product-card" role="tabpanel" aria-labelledby="v-pills-product-card-tab">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label ">{{ __('Show Add to Cart') }}</label>
                <div class="col-sm-1 -mt-6">
                    <input type="hidden" name="{{ $layout }}_template_product[add_to_cart]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input type="checkbox" name="{{ $layout }}_template_product[add_to_cart]" {{ $product['add_to_cart'] ? 'checked' : '' }} value="{{ $product['add_to_cart'] }}" id="show-add-to-cart">
                        <label for="show-add-to-cart" class="cr"></label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label ">{{ __('Show Wishlist') }}</label>
                <div class="col-sm-1 -mt-6">
                    <input type="hidden" name="{{ $layout }}_template_product[wishlist]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input type="checkbox" name="{{ $layout }}_template_product[wishlist]" {{ $product['wishlist'] ? 'checked' : '' }} value="{{ $product['wishlist'] }}" id="show-card-wishlist">
                        <label for="show-card-wishlist" class="cr"></label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label">{{ __('Show Compare') }}</label>
                <div class="col-sm-1 -mt-6">
                    <input type="hidden" name="{{ $layout }}_template_product[compare]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input type="checkbox" name="{{ $layout }}_template_product[compare]" {{ $product['compare'] ? 'checked' : '' }} value="{{ $product['compare'] }}" id="show-card-compare">
                        <label for="show-card-compare" class="cr"></label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label">{{ __('Show Quick View') }}</label>
                <div class="col-sm-1 -mt-6">
                    <input type="hidden" name="{{ $layout }}_template_product[quick_view]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input type="checkbox" name="{{ $layout }}_template_product[quick_view]" {{ $product['quick_view'] ? 'checked' : '' }} value="{{ $product['quick_view'] }}" id="show-quick-view">
                        <label for="show-quick-view" class="cr"></label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label">{{ __('Show Review') }}</label>
                <div class="col-sm-1 -mt-6">
                    <input type="hidden" name="{{ $layout }}_template_product[review]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input type="checkbox" name="{{ $layout }}_template_product[review]" {{ $product['review'] ? 'checked' : '' }} value="{{ $product['review'] }}" id="show-review">
                        <label for="show-review" class="cr"></label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label">{{ __('Show Price') }}</label>
                <div class="col-sm-1 -mt-6">
                    <input type="hidden" name="{{ $layout }}_template_product[price]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input type="checkbox" name="{{ $layout }}_template_product[price]" {{ $product['price'] ? 'checked' : '' }} value="{{ $product['price'] }}" id="show-price">
                        <label for="show-price" class="cr"></label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label">{{ __('Show Badge') }}</label>
                <div class="col-sm-1 -mt-6">
                    <input type="hidden" name="{{ $layout }}_template_product[badge]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input type="checkbox" name="{{ $layout }}_template_product[badge]" {{ $product['badge'] ? 'checked' : '' }} value="{{ $product['badge'] }}" id="show-badge">
                        <label for="show-badge" class="cr"></label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 text-left col-form-label">{{ __('Height') }}</label>
                <div class="col-md-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text rounded-0 ltr:rounded-start rtl:rounded-end h-40">{{ __('Px') }}</span>
                        </div>
                        <input type="text" data-min="120" data-max="500" placeholder="120 - 500" class="form-control positive-int-number border input-box-limit inputFieldDesign" name="{{ $layout }}_template_product[height]"
                            value="{{ $product['height'] }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
