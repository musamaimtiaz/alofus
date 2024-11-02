<div class="card dd-content card-hide">
    <div class="card-body px-0 px-md-4">
        <div class="form-group row my-0">
            <label class="col-sm-3 control-label">{{ __('Title') }}</label>
            <div class="col-sm-9 input-group bg-transparent">
                <input type="text" class="form-control widget-title inputFieldDesign" name="{{ $layout }}_template_footer[main][contact_us][title]" value="{{ $footer['main']['contact_us']['title'] }}" maxlength="40">
            </div>
        </div>
        <hr>

        <div class="form-group row">
            <label class="col-sm-3 control-label">{{ __('Address') }}</label>
            <div class="col-sm-7">
                <input type="text" class="form-control inputFieldDesign" name="{{ $layout }}_template_footer[main][contact_us][data][address]" value="{{ $footer['main']['contact_us']['data']['address'] }}" maxlength="200">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 control-label">{{ __('Email') }}</label>
            <div class="col-sm-7">
                <input type="text" class="form-control inputFieldDesign" name="{{ $layout }}_template_footer[main][contact_us][data][email]" value="{{ $footer['main']['contact_us']['data']['email'] }}" maxlength="100">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 control-label">{{ __('Phone') }}</label>
            <div class="col-sm-7">
                <input type="text" class="form-control phone-number inputFieldDesign" name="{{ $layout }}_template_footer[main][contact_us][data][phone]" value="{{ $footer['main']['contact_us']['data']['phone'] }}" maxlength="50">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 control-label">{{ __('Social Title') }}</label>
            <div class="col-sm-7">
                <input type="text" class="form-control inputFieldDesign" name="{{ $layout }}_template_footer[main][contact_us][data][social_title]" value="{{ $footer['main']['contact_us']['data']['social_title'] }}" maxlength="40">
            </div>
        </div>

        @foreach ($footer['main']['contact_us']['data']['social_data'] as $social)
            <div class="form-group row">
                <label class="col-sm-3 control-label text-start">{{ ucfirst(str_replace('_', ' ', $social['label'])) }}</label>
                <div class="col-sm-7">
                    <input type="hidden" name="{{ $layout }}_template_footer[main][contact_us][data][social_data][{{ $loop->iteration }}][label]" value="{{ $social['label'] }}">
                    <input type="text" class="form-control inputFieldDesign" name="{{ $layout }}_template_footer[main][contact_us][data][social_data][{{ $loop->iteration }}][link]" value="{{ $social['link'] }}">
                </div>
            </div>
        @endforeach
    </div>
</div>

