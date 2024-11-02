<div class="tab-pane fade" id="v-pills-bottomHeader" role="tabpanel" aria-labelledby="v-pills-bottomHeader-tab">
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group row">
                        <label for="footer-bottom-title" class="col-sm-4 text-left col-form-label ">{{ __('Header Text Color') }}</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control demo inputFieldDesign" data-control="hue"
                                name="{{ $layout }}_template_header[bottom][text_color]"
                                value="{{ isset($header['bottom']['text_color']) ? $header['bottom']['text_color'] : '' }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="footer-bottom-title" class="col-sm-4 text-left col-form-label ">{{ __('Header Background Color') }}</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control demo inputFieldDesign" data-control="hue"
                                name="{{ $layout }}_template_header[bottom][bg_color]"
                                value="{{ isset($header['bottom']['bg_color']) ? $header['bottom']['bg_color'] : '' }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label ">{{ __('Show Category') }}</label>
                <div class="col-sm-5 -mt-6">
                    <input type="hidden" name="{{ $layout }}_template_header[bottom][show_category]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input class="is_default" name="{{ $layout }}_template_header[bottom][show_category]" {{ $header['bottom']['show_category'] ? 'checked' : '' }} value="{{ $header['bottom']['show_category'] }}" type="checkbox" id="show-category">
                        <label for="show-category" class="cr"></label>
                    </div>
                </div>
            </div>
            <div class="form-group row conditional preview-parent" data-if="#show-category">
                <label for="meta_title" class="col-sm-4 text-left col-form-label ">{{ __('Category Expand') }}</label>
                <div class="col-sm-5 -mt-6">
                    <input type="hidden" name="{{ $layout }}_template_header[bottom][category_expand]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input class="is_default" name="{{ $layout }}_template_header[bottom][category_expand]" {{ $header['bottom']['category_expand'] ? 'checked' : '' }} value="{{ $header['bottom']['category_expand'] }}" type="checkbox" id="category-expand">
                        <label for="category-expand" class="cr"></label>
                    </div>
                </div>
            </div>
            <div class="row conditional" data-if="#show-category">
                <div class="col-sm-12">
                    <div class="form-group row">
                        <label for="footer-bottom-title" class="col-sm-4 text-left col-form-label ">{{ __('Category Text Color') }}</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control demo inputFieldDesign" data-control="hue"
                                name="{{ $layout }}_template_header[bottom_category][text_color]"
                                value="{{ isset($header['bottom_category']['text_color']) ? $header['bottom_category']['text_color'] : '' }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="footer-bottom-title" class="col-sm-4 text-left col-form-label ">{{ __('Category Background Color') }}</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control demo inputFieldDesign" data-control="hue"
                                name="{{ $layout }}_template_header[bottom_category][bg_color]"
                                value="{{ isset($header['bottom_category']['bg_color']) ? $header['bottom_category']['bg_color'] : '' }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group row">
                        <label for="footer-bottom-title" class="col-sm-4 text-left col-form-label">{{ __('Top Border Color') }}</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control demo inputFieldDesign" data-control="hue"
                                name="{{ $layout }}_template_header[bottom][border_top]"
                                value="{{ isset($header['bottom']['border_top']) ? $header['bottom']['border_top'] : '#000000' }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="footer-bottom-title" class="col-sm-4 text-left col-form-label ">{{ __('Bottom Border Color') }}</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control demo inputFieldDesign" data-control="hue"
                                name="{{ $layout }}_template_header[bottom][border_bottom]"
                                value="{{ isset($header['bottom']['border_bottom']) ? $header['bottom']['border_bottom'] : '#000000' }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label ">{{ __('Show Page Menu') }}</label>
                <div class="col-sm-5 -mt-6">
                    <input type="hidden" name="{{ $layout }}_template_header[bottom][show_page_menu]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input class="is_default" name="{{ $layout }}_template_header[bottom][show_page_menu]" {{ $header['bottom']['show_page_menu']  ? 'checked' : '' }} value="{{ $header['bottom']['show_page_menu'] }}" type="checkbox" id="show-page-menu">
                        <label for="show-page-menu" class="cr"></label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label ">{{ __('Show Download App') }}</label>
                <div class="col-sm-5 -mt-6">
                    <input type="hidden" name="{{ $layout }}_template_header[bottom][show_download_app]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input class="is_default" name="{{ $layout }}_template_header[bottom][show_download_app]" {{ $header['bottom']['show_download_app'] ? 'checked' : '' }} value="{{ $header['bottom']['show_download_app'] }}" type="checkbox" id="show-download-app">
                        <label for="show-download-app" class="cr"></label>
                    </div>
                </div>
            </div>

            <div class="form-group row conditional preview-parent" data-if="#show-download-app">
                <label for="meta_title" class="col-sm-4 text-left col-form-label ">{{ __('Show Google Play') }}</label>
                <div class="col-sm-5 -mt-6">
                    <input type="hidden" name="{{ $layout }}_template_header[bottom][show_google_play]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input class="is_default" name="{{ $layout }}_template_header[bottom][show_google_play]" {{ $header['bottom']['show_google_play'] ? 'checked' : '' }} value="{{ $header['bottom']['show_google_play'] }}" type="checkbox" id="show-google-play">
                        <label for="show-google-play" class="cr"></label>
                    </div>
                </div>
            </div>
            <div class="form-group row mb-1 conditional preview-parent" data-if="#show-download-app && #show-google-play">
                <label for="meta_title" class="col-sm-4 text-left col-form-label ">{{ __('Upload Google Play Logo') }}</label>
                <div class="col-sm-5">
                    <div class="custom-file media-manager-img" data-val="single" data-returntype="ids" id="image-status">
                        <input class="custom-file-input is-image form-control d-none" name="{{ $layout }}_template_download_google_play_logo">

                        <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                            for="validatedCustomFile">{{ __('Upload Google Play image') }}</label>
                    </div>
                    <div class="preview-image hide-close" id="company_favicon">
                        <!-- img will be shown here -->
                        <div class="d-flex flex-wrap mt-2">
                            @if($image['id']['download_google_play_logo'])
                                <div class="position-relative border boder-1 p-1 mr-2 rounded mt-2 old-image">
                                    <div
                                        class="position-absolute rounded-circle text-center img-delete-icon"
                                        data-objectId="{{ $image['id']['download_google_play_logo'] }}">
                                        <i class="fa fa-times"></i>
                                    </div>

                                    <img class="upl-img object-contain neg-transition-scale" class="p-1"
                                        src="{{ $image['download_google_play_logo'] }}">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row conditional preview-parent" data-if="#show-download-app && #show-google-play">
                <label for="meta_title" class="col-sm-4 text-left col-form-label ">{{ __('Google Play Link') }}</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control inputFieldDesign" name="{{ $layout }}_template_header[bottom][google_play_link]" placeholder="{{ __('Google Play Link') }}" value="{{ $header['bottom']['google_play_link'] }}">
                </div>
            </div>

            <div class="form-group row conditional preview-parent" data-if="#show-download-app">
                <label for="meta_title" class="col-sm-4 text-left col-form-label ">{{ __('Show App Store') }}</label>
                <div class="col-sm-5 -mt-6">
                    <input type="hidden" name="{{ $layout }}_template_header[bottom][show_app_store]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input class="is_default" name="{{ $layout }}_template_header[bottom][show_app_store]" {{ $header['bottom']['show_app_store'] ? 'checked' : '' }} value="{{ $header['bottom']['show_app_store'] }}" type="checkbox" id="show-app-store">
                        <label for="show-app-store" class="cr"></label>
                    </div>
                </div>
            </div>

            <div class="form-group row mb-1 conditional preview-parent" data-if="#show-download-app  && #show-app-store">
                <label for="meta_title" class="col-sm-4 text-left col-form-label ">{{ __('Upload App Store Logo') }}</label>
                <div class="col-sm-5">
                    <div class="custom-file media-manager-img" data-val="single" data-returntype="ids" id="image-status">
                        <input class="custom-file-input is-image form-control d-none" name="{{ $layout }}_template_download_app_store_logo">

                        <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                            for="validatedCustomFile">{{ __('Upload App Store Image') }}</label>
                    </div>
                    <div class="preview-image hide-close" id="company_favicon">
                        <!-- img will be shown here -->
                        <div class="d-flex flex-wrap mt-2">
                            @if($image['id']['download_app_store_logo'])
                                <div class="position-relative border boder-1 p-1 mr-2 rounded mt-2 old-image">
                                    <div
                                        class="position-absolute rounded-circle text-center img-delete-icon"
                                        data-objectId="{{ $image['id']['download_app_store_logo'] }}">
                                        <i class="fa fa-times"></i>
                                    </div>

                                    <img class="upl-img object-contain neg-transition-scale" class="p-1"
                                        src="{{ $image['download_app_store_logo'] }}">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row conditional preview-parent" data-if="#show-download-app && #show-app-store">
                <label for="meta_title" class="col-sm-4 text-left col-form-label ">{{ __('App Store Link') }}</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control inputFieldDesign" name="{{ $layout }}_template_header[bottom][app_store_link]" placeholder="{{ __('App Store Link') }}" value="{{ $header['bottom']['app_store_link'] }}">
                </div>
            </div>
        </div>
    </div>
</div>
