@php
    $custom = option('default_template_custom', '');
@endphp
<div class="tab-pane fade" id="v-pills-custom-css-js" role="tabpanel" aria-labelledby="v-pills-custom-css-js-tab">
    <div class="row">
        <div class="col-12">
            <div class="border border-gray p-2 mb-3">
                <span class="badge badge-warning">{{ __('Warning') }}</span>
                <span>{{ __('This section is only for developer. Please left this section if you do not have proper knowledge.') }}</span>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group row">
                <label for="meta_title" class="col-sm-2 text-left col-form-label">{{ __('CSS') }}</label>
                <div class="col-sm-10">
                    <textarea class="form-control custom" rows="8" name="custom[css]">@if (File::exists('Modules/CMS/Resources/assets/css/user-custom.css')){{ File::get('Modules/CMS/Resources/assets/css/user-custom.css') }}@endif</textarea>
                </div>
            </div>

            <div class="form-group row">
                <label for="meta_title" class="col-sm-2 text-left col-form-label">{{ __('JS') }}</label>
                <div class="col-sm-10">
                    <textarea class="form-control custom" rows="8" name="custom[js]">@if (File::exists('Modules/CMS/Resources/assets/js/user-custom.js')){{ File::get('Modules/CMS/Resources/assets/js/user-custom.js') }}@endif</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
