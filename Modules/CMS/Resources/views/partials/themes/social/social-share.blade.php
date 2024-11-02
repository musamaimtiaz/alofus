<div class="tab-pane fade show active" id="v-pills-social-share" role="tabpanel" aria-labelledby="v-pills-social-share-tab">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label">{{ __("Facebook") }}</label>
                <div class="col-sm-6">
                    <input type="hidden" name="{{ $layout }}_template_social[facebook]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input class="is_default" name="{{ $layout }}_template_social[facebook]" type="checkbox"{{ $social['facebook'] ? 'checked' : '' }} id="share-facebook" value="{{ $social['facebook'] }}">
                        <label for="share-facebook" class="cr"></label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label">{{ __("WhatsApp") }}</label>
                <div class="col-sm-6">
                    <input type="hidden" name="{{ $layout }}_template_social[whatsapp]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input type="checkbox" name="{{ $layout }}_template_social[whatsapp]"{{ $social['whatsapp'] ? 'checked' : '' }} id="share-whatsapp" value="{{ $social['whatsapp'] }}">
                        <label for="share-whatsapp" class="cr"></label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label ">{{ __("Instagram") }}</label>
                <div class="col-sm-6">
                    <input type="hidden" name="{{ $layout }}_template_social[instagram]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input type="checkbox" name="{{ $layout }}_template_social[instagram]"{{ $social['instagram'] ? 'checked' : '' }} id="share-instagram" value="{{ $social['instagram'] }}">
                        <label for="share-instagram" class="cr"></label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label ">{{ __("Pinterest") }}</label>
                <div class="col-sm-6">
                    <input type="hidden" name="{{ $layout }}_template_social[pinterest]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input type="checkbox" name="{{ $layout }}_template_social[pinterest]"{{ $social['pinterest'] ? 'checked' : '' }} id="share-pinterest" value="{{ $social['pinterest'] }}">
                        <label for="share-pinterest" class="cr"></label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label">{{ __("Linkedin") }}</label>
                <div class="col-sm-6">
                    <input type="hidden" name="{{ $layout }}_template_social[linkedin]" value="0">
                    <div class="switch switch-bg d-inline m-r-10">
                        <input type="checkbox" name="{{ $layout }}_template_social[linkedin]"{{ $social['linkedin'] ? 'checked' : '' }} id="share-linkedin" value="{{ $social['linkedin'] }}">
                        <label for="share-linkedin" class="cr"></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
