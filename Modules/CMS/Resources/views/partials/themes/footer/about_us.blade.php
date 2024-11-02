<div class="card dd-content card-hide">
    <div class="card-body px-0 px-md-4">
        <div class="form-group row my-0">
            <label class="col-sm-3 control-label">{{ __('Title') }}</label>
            <div class="col-sm-9 input-group bg-transparent">
                <input type="text" class="form-control widget-title inputFieldDesign" name="{{ $layout }}_template_footer[main][about_us][title]" value="{{ $footer['main']['about_us']['title'] }}" maxlength="40">
            </div>
        </div>
        <hr>

        <div class="form-group row preview-parent" id="iconTop">
            <label class="col-sm-3 control-label text-left">{{ __('Footer Logo') }}</label>
            <div class="col-sm-7">
                <div class="custom-file media-manager-img" data-val="single" data-returntype="ids" id="image-status">
                    <input class="custom-file-input is-image form-control d-none" name="{{ $layout }}_template_footer_logo">
                    <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                        for="validatedCustomFile">{{ __('Upload image') }}</label>
                </div>
                <div class="preview-image hide-close" id="company_favicon">
                    <!-- img will be shown here -->
                    <div class="d-flex flex-wrap mt-2">
                        @if($image['id']['footer_logo'])
                            <div class="position-relative border boder-1 p-1 ltr:me-2 rtl:ms-2 rounded mt-2 old-image">
                                <div
                                    class="position-absolute rounded-circle text-center img-delete-icon"
                                    data-objectId="{{ $image['id']['footer_logo'] }}">
                                    <i class="fa fa-times"></i>
                                </div>

                                <img class="upl-img object-contain neg-transition-scale" class="p-1"
                                    src="{{ $image['footer_logo'] }}">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 control-label text-left">{{ __('Short Details') }}</label>
            <div class="col-sm-7">
                <input type="text" class="form-control inputFieldDesign" name="{{ $layout }}_template_footer[main][about_us][data][short_details]" value="{{ $footer['main']['about_us']['data']['short_details'] }}" maxlength="200">
            </div>
        </div>
        <div class="form-group row preview-parent" id="iconTop">
            <label class="col-sm-3 control-label text-left">{{ __('Payment Methods') }}</label>
            <div class="col-sm-7">
                <div class="custom-file media-manager-img" data-val="single" data-returntype="ids" id="image-status">
                    <input class="custom-file-input is-image form-control d-none" name="{{ $layout }}_template_payment_methods">
                    <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                        for="validatedCustomFile">{{ __('Upload image') }}</label>
                </div>
                <div class="preview-image hide-close" id="company_favicon">
                    <!-- img will be shown here -->
                    <div class="d-flex flex-wrap mt-2">
                        @if($image['id']['payment_methods'])
                            <div class="position-relative border boder-1 p-1 mr-2 rounded mt-2 old-image">
                                <div
                                    class="position-absolute rounded-circle text-center img-delete-icon"
                                    data-objectId="{{ $image['id']['payment_methods'] }}">
                                    <i class="fa fa-times"></i>
                                </div>

                                <img class="upl-img object-contain neg-transition-scale" class="p-1"
                                    src="{{ $image['payment_methods'] }}">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 control-label text-left">{{ __('Download App Title') }}</label>
            <div class="col-sm-7">
                <input type="text" class="form-control inputFieldDesign" name="{{ $layout }}_template_footer[main][about_us][data][download_app]" value="{{ $footer['main']['about_us']['data']['download_app'] }}" maxlength="50">
            </div>
        </div>

        <div class="form-group row preview-parent" id="iconTop">
            <label class="col-sm-3 control-label text-left">{{ __('Google Play') }}</label>
            <div class="col-sm-7">
                <div class="custom-file media-manager-img" data-val="single" data-returntype="ids" id="image-status">
                    <input class="custom-file-input is-image form-control d-none" name="{{ $layout }}_template_google_play">
                    <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                        for="validatedCustomFile">{{ __('Upload image') }}</label>
                </div>
                <div class="preview-image hide-close" id="company_favicon">
                    <!-- img will be shown here -->
                    <div class="d-flex flex-wrap mt-2">
                        @if($image['id']['google_play'])
                            <div class="position-relative border boder-1 p-1 mr-2 rounded mt-2 old-image">
                                <div
                                    class="position-absolute rounded-circle text-center img-delete-icon"
                                    data-objectId="{{ $image['id']['google_play'] }}">
                                    <i class="fa fa-times"></i>
                                </div>

                                <img class="upl-img object-contain neg-transition-scale" class="p-1"
                                    src="{{ $image['google_play'] }}">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 control-label text-left">{{ __('Google Play Link') }}</label>
            <div class="col-sm-7">
                <input type="text" class="form-control inputFieldDesign" name="{{ $layout }}_template_footer[main][about_us][data][google_play_link]" value="{{ $footer['main']['about_us']['data']['google_play_link'] }}">
            </div>
        </div>

        <div class="form-group row preview-parent" id="iconTop">
            <label class="col-sm-3 control-label text-left">{{ __('App Store') }}</label>
            <div class="col-sm-7">
                <div class="custom-file media-manager-img" data-val="single" data-returntype="ids" id="image-status">
                    <input class="custom-file-input is-image form-control d-none" name="{{ $layout }}_template_app_store">
                    <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                        for="validatedCustomFile">{{ __('Upload image') }}</label>
                </div>
                <div class="preview-image hide-close" id="company_favicon">
                    <!-- img will be shown here -->
                    <div class="d-flex flex-wrap mt-2">
                        @if($image['id']['app_store'])
                            <div class="position-relative border boder-1 p-1 mr-2 rounded mt-2 old-image">
                                <div
                                    class="position-absolute rounded-circle text-center img-delete-icon"
                                    data-objectId="{{ $image['id']['app_store'] }}">
                                    <i class="fa fa-times"></i>
                                </div>

                                <img class="upl-img object-contain neg-transition-scale" class="p-1"
                                    src="{{ $image['app_store'] }}">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 control-label text-left">{{ __('App Store Link') }}</label>
            <div class="col-sm-7">
                <input type="text" class="form-control inputFieldDesign" name="{{ $layout }}_template_footer[main][about_us][data][app_store_link]" value="{{ $footer['main']['about_us']['data']['app_store_link'] }}">
            </div>
        </div>
    </div>
</div>

