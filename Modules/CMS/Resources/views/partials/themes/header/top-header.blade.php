<div class="tab-pane fade" id="v-pills-topNav" role="tabpanel" aria-labelledby="v-pills-topNav-tab">
    <div class="form-group row">
        <label for="meta_title" class="col-sm-4 text-left col-form-label ">{{ __('Show Top Header') }}</label>
        <div class="col-sm-6 -mt-6">
            <input type="hidden" name="{{ $layout }}_template_header[top][show_header]" value="0">
            <div class="switch switch-bg d-inline m-r-10">
                <input type="checkbox" name="{{ $layout }}_template_header[top][show_header]" {{ $header['top']['show_header'] ? 'checked' : '' }} value="{{ $header['top']['show_header'] }}" id="show-top-nav">
                <label for="show-top-nav" class="cr"></label>
            </div>
        </div>
    </div>
    <div class="row conditional" data-if="#show-top-nav">
        <div class="col-sm-12">
            <div class="form-group row">
                <label for="footer-bottom-title" class="col-sm-4 text-left col-form-label ">{{ __('Text Color') }}</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control demo inputFieldDesign" data-control="hue"
                        name="{{ $layout }}_template_header[top][text_color]"
                        value="{{ isset($header['top']['text_color']) ? $header['top']['text_color'] : '' }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="footer-bottom-title" class="col-sm-4 text-left col-form-label ">{{ __('Background Color') }}</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control demo inputFieldDesign" data-control="hue"
                        name="{{ $layout }}_template_header[top][bg_color]"
                        value="{{ isset($header['top']['bg_color']) ? $header['top']['bg_color'] : '' }}">
                </div>
            </div>
        </div>
    </div>
    <div class="row conditional" data-if="#show-top-nav">
        <div class="col-sm-12">
            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label ">{{ __('Show Phone No') }}</label>
                <div class="col-sm-1 -mt-6">
                    <input type="hidden" name="{{ $layout }}_template_header[top][show_phone]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input type="checkbox" name="{{ $layout }}_template_header[top][show_phone]" {{ $header['top']['show_phone'] ? 'checked' : '' }} value="{{ $header['top']['show_phone'] }}" id="show-phone-no">
                        <label for="show-phone-no" class="cr"></label>
                    </div>
                </div>
            </div>
            <div class="form-group row conditional" data-if="#show-phone-no">
                <label for="meta_title" class="col-sm-4 text-left col-form-label ">{{ __('Phone No') }}</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control phone-number inputFieldDesign" name="{{ $layout }}_template_header[top][phone]" placeholder="{{ __('Phone No') }}" value="{{ $header['top']['phone'] }}" maxlength="18">
                </div>
            </div>
            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label ">{{ __('Show Email') }}</label>
                <div class="col-sm-1 -mt-6">
                    <input type="hidden" name="{{ $layout }}_template_header[top][show_email]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input type="checkbox" name="{{ $layout }}_template_header[top][show_email]" {{ $header['top']['show_email'] ? 'checked' : '' }} value="{{ $header['top']['show_email'] }}" id="show-email">
                        <label for="show-email" class="cr"></label>
                    </div>
                </div>
            </div>
            <div class="form-group row conditional" data-if="#show-email">
                <label for="meta_title" class="col-sm-4 text-left col-form-label ">{{ __('Email') }}</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control inputFieldDesign" name="{{ $layout }}_template_header[top][email]" placeholder="{{ __('Email') }}" value="{{ $header['top']['email'] }}" maxlength="50">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 text-left col-form-label">{{ __('Show be a seller') }}</label>
                <div class="col-sm-6 -mt-6">
                    <input type="hidden" name="{{ $layout }}_template_header[top][show_seller]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input type="checkbox" name="{{ $layout }}_template_header[top][show_seller]" {{ $header['top']['show_seller'] ? 'checked' : '' }} value="{{ $header['top']['show_seller'] }}" id="show_be_seller">
                        <label for="show_be_seller" class="cr"></label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label ">{{ __('Show Compare') }}</label>
                <div class="col-sm-6 -mt-6">
                    <input type="hidden" name="{{ $layout }}_template_header[top][show_compare]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input class="is_default" name="{{ $layout }}_template_header[top][show_compare]" {{ $header['top']['show_compare'] ? 'checked' : '' }} value="{{ $header['top']['show_compare'] }}" type="checkbox" id="show-compare">
                        <label for="show-compare" class="cr"></label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label ">{{ __('Show Currency') }}</label>
                <div class="col-sm-6 -mt-6">
                    <input type="hidden" name="{{ $layout }}_template_header[top][show_currency]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input type="checkbox" name="{{ $layout }}_template_header[top][show_currency]" {{ $header['top']['show_currency'] ? 'checked' : '' }} value="{{ $header['top']['show_currency'] }}" id="show-currency">
                        <label for="show-currency" class="cr"></label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label ">{{ __('Show Language') }}</label>
                <div class="col-sm-6 -mt-6">
                    <input type="hidden" name="{{ $layout }}_template_header[top][show_language]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input type="checkbox" name="{{ $layout }}_template_header[top][show_language]" {{ $header['top']['show_language'] ? 'checked' : '' }} value="{{ $header['top']['show_language'] }}" id="show-language">
                        <label for="show-language" class="cr"></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
