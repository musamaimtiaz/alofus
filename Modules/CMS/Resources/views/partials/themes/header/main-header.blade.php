<div class="tab-pane fade" id="v-pills-mainHeader" role="tabpanel" aria-labelledby="v-pills-mainHeader-tab">
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group row">
                        <label for="footer-bottom-title" class="col-sm-4 text-left col-form-label ">{{ __('Text Color') }}</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control demo inputFieldDesign" data-control="hue"
                                name="{{ $layout }}_template_header[main][text_color]"
                                value="{{ isset($header['main']['text_color']) ? $header['main']['text_color'] : '' }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="footer-main-title" class="col-sm-4 text-left col-form-label ">{{ __('Background Color') }}</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control demo inputFieldDesign" data-control="hue"
                                name="{{ $layout }}_template_header[main][bg_color]"
                                value="{{ isset($header['main']['bg_color']) ? $header['main']['bg_color'] : '' }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label ">{{ __('Show Logo') }}</label>
                <div class="col-sm-5 -mt-6">
                    <input type="hidden" name="{{ $layout }}_template_header[main][show_logo]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input class="is_default" name="{{ $layout }}_template_header[main][show_logo]" {{ $header['main']['show_logo'] ? 'checked' : '' }} value="{{ $header['main']['show_logo'] }}" type="checkbox" id="show-logo">
                        <label for="show-logo" class="cr"></label>
                    </div>
                </div>
            </div>
            <div class="form-group row mb-1 conditional preview-parent" data-if="#show-logo">
                <label for="meta_title" class="col-sm-4 text-left col-form-label ">{{ __('Upload Logo') }}</label>
                <div class="col-sm-5">
                    <div class="custom-file media-manager-img" data-val="single" data-returntype="ids" id="image-status">
                        <input class="custom-file-input is-image form-control d-none" name="{{ $layout }}_template_header_logo">
                        <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                            for="validatedCustomFile">{{ __('Upload Logo') }}</label>
                    </div>
                    <div class="preview-image" id="company_favicon">
                        <!-- img will be shown here -->
                        <div class="d-flex flex-wrap mt-2">
                            @if($image['id']['header_logo'])
                                <div class="position-relative border boder-1 p-1 mr-2 rounded mt-2 old-image">
                                    <div
                                        class="position-absolute rounded-circle text-center img-delete-icon"
                                        data-objectId="{{ $image['id']['header_logo'] }}">
                                        <i class="fa fa-times"></i>
                                    </div>

                                    <img class="upl-img object-contain neg-transition-scale" class="p-1"
                                        src="{{ $image['header_logo'] }}">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row mb-1 conditional preview-parent" data-if="#show-logo">
                <label for="meta_title" class="col-sm-4 text-left col-form-label ">{{ __('Upload Sidebar & Customer Panel Logo') }}</label>
                <div class="col-sm-5">
                    <div class="custom-file media-manager-img" data-val="single" data-returntype="ids" id="image-status">
                        <input class="custom-file-input is-image form-control d-none" name="{{ $layout }}_template_header_mobile_logo">

                        <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                            for="validatedCustomFile">{{ __('Upload Logo') }}</label>
                    </div>
                    <div class="preview-image hide-close" id="company_favicon">
                        <!-- img will be shown here -->
                        <div class="d-flex flex-wrap mt-2">
                            @if($image['id']['header_mobile_logo'])
                                <div class="position-relative border boder-1 p-1 mr-2 rounded mt-2 old-image">
                                    <div
                                        class="position-absolute rounded-circle text-center img-delete-icon"
                                        data-objectId="{{ $image['id']['header_mobile_logo'] }}">
                                        <i class="fa fa-times"></i>
                                    </div>

                                    <img class="upl-img object-contain neg-transition-scale" class="p-1"
                                        src="{{ $image['header_mobile_logo'] }}">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label">{{ __('Show Searchbar') }}</label>
                <div class="col-sm-5 -mt-6">
                    <input type="hidden" name="{{ $layout }}_template_header[main][show_searchbar]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input class="is_default" name="{{ $layout }}_template_header[main][show_searchbar]" {{ $header['main']['show_searchbar'] ? 'checked' : '' }} value="{{ $header['main']['show_searchbar'] }}" type="checkbox" id="show-searchbar">
                        <label for="show-searchbar" class="cr"></label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label">{{ __('Show Account Icon') }}</label>
                <div class="col-sm-5 -mt-6">
                    <input type="hidden" name="{{ $layout }}_template_header[main][show_account]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input class="is_default" name="{{ $layout }}_template_header[main][show_account]" {{ $header['main']['show_account'] ? 'checked' : '' }} value="{{ $header['main']['show_account'] }}" type="checkbox" id="show-user-icon">
                        <label for="show-user-icon" class="cr"></label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label">{{ __('Show wishlist') }}</label>
                <div class="col-sm-5 -mt-6">
                    <input type="hidden" name="{{ $layout }}_template_header[main][show_wishlist]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input class="is_default" name="{{ $layout }}_template_header[main][show_wishlist]" {{ $header['main']['show_wishlist'] ? 'checked' : '' }} value="{{ $header['main']['show_wishlist'] }}" type="checkbox" id="show-wishlist">
                        <label for="show-wishlist" class="cr"></label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label">{{ __('Show Cart') }}</label>
                <div class="col-sm-5 -mt-6">
                    <input type="hidden" name="{{ $layout }}_template_header[main][show_cart]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input class="is_default" name="{{ $layout }}_template_header[main][show_cart]" {{ $header['main']['show_cart'] ? 'checked' : '' }} value="{{ $header['main']['show_cart'] }}" type="checkbox" id="show-cart">
                        <label for="show-cart" class="cr"></label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label">{{ __('Show Track Order') }}</label>
                <div class="col-sm-5 -mt-6">
                    <input type="hidden" name="{{ $layout }}_template_header[main][show_track]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input class="is_default" name="{{ $layout }}_template_header[main][show_track]" {{ $header['main']['show_track'] ? 'checked' : '' }} value="{{ $header['main']['show_track'] }}" type="checkbox" id="show-track">
                        <label for="show-track" class="cr"></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


