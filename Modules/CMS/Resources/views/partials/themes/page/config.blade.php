<div class="tab-pane fade" id="v-pills-page-config" role="tabpanel" aria-labelledby="v-pills-page-config-tab">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label">{{ __('Terms & Condition') }}</label>
                <div class="col-sm-6">
                    <div class="switch switch-bg d-inline m-r-10">
                        <select class="form-control select2-hide-search" name="{{ $layout }}_template_page[term_condition]">
                            @foreach ($pages as $page)
                                <option {{ isset($pageConfig['term_condition']) && $pageConfig['term_condition'] == $page->slug ? 'selected' : '' }} value="{{ $page->slug }}">{{ $page->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label">{{ __('Default Slider') }}</label>
                <div class="col-sm-6">
                    <select class="form-control select2-hide-search" name="{{ $layout }}_template_page[slider]">
                        @foreach ($sliders as $slider)
                            <option {{ isset($pageConfig['slider']) && $pageConfig['slider'] == $slider->slug ? 'selected' : '' }} value="{{ $slider->slug }}">{{ $slider->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
