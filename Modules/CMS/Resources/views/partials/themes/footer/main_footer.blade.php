<div class="card tab-pane fade box-shadow-unset" id="v-pills-footer-main" role="tabpanel" aria-labelledby="v-pills-footer-main-tab">
    <div class="card-body p-0">
        @php
            $widgets = [];
            foreach ($footer['main'] as $key => $widget) {
                if (is_array($widget)) {
                    $widgets[$widget['sort']] = [$key => $widget];
                }
            }
        @endphp
        <div class="card-block pt-2 px-2">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group row">
                        <label for="footer-bottom-title" class="col-sm-4 text-left col-form-label ">{{ __('Text Color') }}</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control demo inputFieldDesign" data-control="hue"
                                name="{{ $layout }}_template_footer[main][text_color]"
                                value="{{ isset($footer['main']['text_color']) ? $footer['main']['text_color'] : '' }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="footer-bottom-title" class="col-sm-4 text-left col-form-label ">{{ __('Background Color') }}</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control demo inputFieldDesign" data-control="hue"
                            name="{{ $layout }}_template_footer[main][bg_color]"
                            value="{{ isset($footer['main']['bg_color']) ? $footer['main']['bg_color'] : '' }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="meta_title" class="col-sm-4 text-left col-form-label">{{ __('Alignment') }}</label>
                        <div class="col-sm-8">
                            <div class="form-group d-inline mr-2">
                                <div class="radio radio-warning d-inline">
                                    <input type="radio" name="{{ $layout }}_template_footer[main][direction]" value="left" id="footer-main-alignment-left" {{ isset($footer['main']['direction']) && $footer['main']['direction'] == 'left' ? 'checked' : '' }}>
                                    <label for="footer-main-alignment-left" class="cr">{{ __('Left') }}</label>
                                </div>
                            </div>
                            <div class="form-group d-inline mr-2">
                                <div class="radio radio-warning d-inline">
                                    <input type="radio" name="{{ $layout }}_template_footer[main][direction]" value="center" id="footer-main-alignment-center" {{ isset($footer['main']['direction']) && $footer['main']['direction'] == 'center' ? 'checked' : '' }}>
                                    <label for="footer-main-alignment-center" class="cr">{{ __('Center') }}</label>
                                </div>
                            </div>
                            <div class="form-group d-inline mr-2">
                                <div class="radio radio-warning d-inline">
                                    <input type="radio" name="{{ $layout }}_template_footer[main][direction]" value="right" id="footer-main-alignment-right" {{ isset($footer['main']['direction']) && $footer['main']['direction'] == 'right' ? 'checked' : '' }}>
                                    <label for="footer-main-alignment-right" class="cr">{{ __('Right') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <ul id="sortable" class="selector footer-main mt-3 mt-md-0">
                 @foreach ($widgets as $key => $data)
                    @foreach ($data as $title => $widget)
                        <li class="ui-state-default" data-id="">
                            <div class="component-header">
                                <i class="feather feather icon-move"></i>
                                <div class="header-text">
                                    <h5 class="header-title">
                                        {{ $widget['title'] }}
                                    </h5>
                                </div>
                                <div class="header-btns">
                                    <span class="-mt-8">
                                        <input class="is_default sort-data" name="{{ $layout }}_template_footer[main][{{ $title }}][sort]" type="hidden">
                                        <input name="{{ $layout }}_template_footer[main][{{ $title }}][status]" type="hidden" value="0">
                                        <div class="switch switch-bg d-inline m-r-10">
                                            <input class="is_default" name="{{ $layout }}_template_footer[main][{{ $title }}][status]" type="checkbox" {{ $footer['main'][$title]['status'] ? 'checked' : '' }} value="{{ $footer['main'][$title]['status'] }}" id="{{ $title }}]_status">
                                            <label for="{{ $title }}]_status" class="cr"></label>
                                        </div>
                                    </span>
                                    <span class="header-btn folding closed btn-primary">
                                        <i class="feather icon-chevron-up"></i>
                                    </span>
                                </div>

                            </div>
                            @include('cms::partials.themes.footer.' . $title)
                        </li>
                    @endforeach
                @endforeach
            </ul>
        </div>
    </div>
</div>
