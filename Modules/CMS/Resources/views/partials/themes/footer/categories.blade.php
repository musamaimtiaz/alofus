<div class="card dd-content card-hide">
    <div class="card-body px-0 px-md-4">
        <div class="form-group row my-0">
            <label class="col-sm-3 control-label">{{ __('Title') }}</label>
            <div class="col-sm-9 input-group bg-transparent">
                <input type="text" class="form-control widget-title inputFieldDesign" name="{{ $layout }}_template_footer[main][categories][title]" value="{{ $footer['main']['categories']['title'] }}" maxlength="40">
            </div>
        </div>
        <hr>

        <div class="form-group row my-0">
            <label class="col-xl-5 control-label">{{ __('Label') }}</label>
            <label class="col-xl-7 control-label">{{ __('Link') }}</label>
        </div>
        @php
            $data = $footer['main']['categories']['data'] ?? [];
        @endphp
        @foreach ($data as $widget)
            <div class="form-group row mt-3 mt-xl-0">
                <div class="col-xl-5 col-12">
                    <div class="input-group bg-transparent">
                        <input type="text" class="form-control inputFieldDesign" name="{{ $layout }}_template_footer[main][categories][data][{{ $loop->iteration }}][label]" value="{{ $widget['label'] }}" maxlength="40">
                    </div>
                </div>
                <div class="col-xl-6 col-12 mt-3 mt-xl-0">
                    <div class="input-group bg-transparent">
                        <input type="text" class="form-control inputFieldDesign" name="{{ $layout }}_template_footer[main][categories][data][{{ $loop->iteration }}][link]" value="{{ $widget['link'] }}">
                    </div>
                </div>
                <div class="col-xl-1 ltr:ps-0 rtl:pe-0 col-12 mt-3 mt-xl-0">
                    <div class="input-group bg-transparent cursor_pointer remove-widget-title ml-3 ml-md-0">
                        <span class="input-group-text rounded h-40"><i class="feather icon-trash-2 fa-2x"></i></span>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="form-group row">
            <div class="col-12">
                <button type="button" data-id='{{ count($data) + 1 }}' data-widget='categories' class="btn btn-primary btn-sm add-new-widget-title add-btn"><i class="fa fa-plus"></i> {{ __('Add New') }}</button>
            </div>
        </div>
    </div>
</div>

