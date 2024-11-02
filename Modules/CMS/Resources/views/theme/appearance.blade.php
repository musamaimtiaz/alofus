<div class="row" id="theme-container">
    <div class="col-md-3 col-12 z-index-10 ltr:ps-md-3 ltr:pe-0 ltr:ps-0 rtl:pe-md-3 rtl:ps-0 rtl:pe-0"
        aria-labelledby="navbarDropdown">
        <div class="card card-info shadow-none" id="nav">
            <ul class="nav flex-column nav-pills px-0" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <div class="card-header margin-top-neg-15 border-bottom">
                    <h5>{{ __('Appearance') }}</h5>
                </div>
                <ul class="nav nav-list flex-column mr-30 mt-3 side-nav">
                    <li><a class="nav-link active text-left tab-name font-weight-normal" id="v-pills-social-share-tab"
                            data-bs-toggle="pill" href="#v-pills-social-share" role="tab"
                            aria-controls="v-pills-social-share" aria-selected="true"
                            data-id="{{ __('Social Share') }}">{{ __('Social Share') }}</a></li>
                    <li>
                        <a class="accordion-heading position-relative header font-weight-normal"
                            data-bs-toggle="collapse" data-bs-target="#submenu2">{{ __('Header') }} <span
                                class="pull-right"><b class="caret"></b></span>
                            <span><i class="fa fa-angle-down position-absolute arrow-icon"></i></span>
                        </a>
                        <ul class="nav nav-list flex-column flex-nowrap collapse ml-2 vertical-class side-nav"
                            id="submenu2">
                            <li><a class="nav-link text-left tab-name font-weight-normal" id="v-pills-topNav-tab"
                                    data-bs-toggle="pill" href="#v-pills-topNav" role="tab"
                                    aria-controls="v-pills-topNav" aria-selected="false"
                                    data-id="{{ __('Header') }} >> {{ __('Top Header') }}">{{ __('Top Header') }}</a>
                            </li>
                            <li><a class="nav-link text-left tab-name font-weight-normal" id="v-pills-mainHeader-tab"
                                    data-bs-toggle="pill" href="#v-pills-mainHeader" role="tab"
                                    aria-controls="v-pills-mainHeader" aria-selected="false"
                                    data-id="{{ __('Header') }} >> {{ __('Main Header') }}">{{ __('Main Header') }}</a>
                            </li>
                            <li><a class="nav-link text-left tab-name font-weight-normal" id="v-pills-bottomHeader-tab"
                                    data-bs-toggle="pill" href="#v-pills-bottomHeader" role="tab"
                                    aria-controls="v-pills-bottomHeader" aria-selected="false"
                                    data-id="{{ __('Header') }} >> {{ __('Bottom Header') }}">{{ __('Bottom Header') }}</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="accordion-heading position-relative font-weight-normal" data-bs-toggle="collapse"
                            data-bs-target="#footer-main-v-pills-tab">
                            {{ __('Footer') }}
                            <span class="pull-right"><b class="caret"></b></span>
                            <span><i class="fa fa-angle-down position-absolute arrow-icon"></i></span>
                        </a>
                        <ul class="nav nav-list flex-column flex-nowrap collapse ml-2 vertical-class font-weight-normal side-nav"
                            id="footer-main-v-pills-tab" role="tablist" aria-orientation="vertical">
                            <li>
                                <a class="nav-link text-left tab-name font-weight-normal" id="v-pills-footer-main-tab"
                                    data-bs-toggle="pill" href="#v-pills-footer-main" role="tab"
                                    aria-controls="v-pills-footer-main" aria-selected="true"
                                    data-id="{{ __('Footer') }} >> {{ __('Main') }}">{{ __('Main') }}</a>
                            </li>
                            <li>
                                <a class="nav-link text-left tab-name font-weight-normal" id="v-pills-footer-bottom-tab"
                                    data-bs-toggle="pill" href="#v-pills-footer-bottom" role="tab"
                                    aria-controls="v-pills-footer-bottom" aria-selected="true"
                                    data-id="{{ __('Footer') }} >> {{ __('Copyright') }}">{{ __('Copyright') }}</a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="nav-link text-left tab-name font-weight-normal" id="v-pills-product-card-tab"
                            data-bs-toggle="pill" href="#v-pills-product-card" role="tab"
                            aria-controls="v-pills-product-card" aria-selected="true"
                            data-id="{{ __('Product Card') }}">{{ __('Product Card') }}</a>
                    </li>
                    <li><a class="nav-link text-left tab-name font-weight-normal" id="v-pills-custom-css-js-tab"
                            data-bs-toggle="pill" href="#v-pills-custom-css-js" role="tab"
                            aria-controls="v-pills-custom-css-js" aria-selected="true"
                            data-id="{{ __('Custom CSS & JS') }}">{{ __('Custom CSS & JS') }}</a>
                    </li>
                    <li><a class="nav-link text-left tab-name font-weight-normal" id="v-pills-page-config-tab"
                            data-bs-toggle="pill" href="#v-pills-page-config" role="tab"
                            aria-controls="v-pills-page-config" aria-selected="true"
                            data-id="{{ __('Page Configuration') }}">{{ __('Page Configuration') }}</a>
                    </li>
                    <li><a class="nav-link text-left tab-name font-weight-normal" id="v-pills-layout-tab"
                            data-bs-toggle="pill" href="#v-pills-layout" role="tab"
                            aria-controls="v-pills-layout" aria-selected="true"
                            data-id="{{ __('Layout') }}">{{ __('Layout') }}</a>
                    </li>
                    <li><a class="nav-link text-left tab-name font-weight-normal" id="v-pills-font-tab"
                            data-bs-toggle="pill" href="#v-pills-font" role="tab"
                            aria-controls="v-pills-font" aria-selected="true"
                            data-id="{{ __('Font Family') }}">{{ __('Font Family') }}</a>
                    </li>
                </ul>
            </ul>
        </div>
    </div>
    <div class="col-md-9 col-12 ltr:ps-0 rtl:pe-0">
        <div class="card card-info shadow-none">
            <div class="card-header border-bottom">
                <h5><span id="theme-title"></span></h5>
                <div class="card-header-right d-flex">
                    <div class="appearance-dropdown {{ count($layouts) > 1 ? 'enable' : 'cursor-unset' }}"
                        id="myAppearanceDropdown">
                        <span>{{ __(':x Layout', ['x' => ucFirst(str_replace('_', ' ', $layout))]) }}</span>
                        @if (count($layouts) > 1)
                            <ul class="dropdown">
                                @foreach ($layouts as $data)
                                    @if ($data != $layout)
                                        <li data-val="{{ $data }}">
                                            {{ ucFirst(str_replace('_', ' ', $data)) }}
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
            <div class="noti-alert message pad no-print" id="warning-message">
                <div class="alert abc warning-message">
                    <strong id="warning-msg"></strong>
                </div>
            </div>

            <div class="card-body px-0 px-md-3">
                <form method="post" id="optionForm" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="layout" value="{{ $layout }}">
                    <div class="tab-content" id="topNav-v-pills-tabContent">
                        @php $social = option($layout . '_template_social', '') @endphp
                        {{-- Social Share --}}
                        @include('cms::partials.themes.social.social-share')

                        @php $header = option($layout . '_template_header', '') @endphp

                        {{-- Top Header --}}
                        @include('cms::partials.themes.header.top-header')

                        {{-- main header --}}
                        @include('cms::partials.themes.header.main-header')

                        {{-- Bottom Header --}}
                        @include('cms::partials.themes.header.bottom-header')

                        {{-- Custom CSS & JS --}}
                        @include('cms::partials.themes.custom.css-js')

                        {{-- Page Configuration --}}
                        @php $pageConfig = option($layout . '_template_page', '') @endphp
                        @include('cms::partials.themes.page.config')

                        {{-- Product Card --}}
                        @php $product = option($layout . '_template_product', '') @endphp
                        @include('cms::partials.themes.product.card')

                        {{-- Footer->Main --}}
                        @php $footer = option($layout . '_template_footer', '') @endphp
                        @include('cms::partials.themes.footer.main_footer')

                        {{-- Layout --}}
                        @include('cms::partials.themes.page.layout')

                        {{-- Font Family --}}
                        @include('cms::partials.themes.page.font')

                        {{-- Bottom footer Copyright --}}
                        <div class="tab-pane fade" id="v-pills-footer-bottom" role="tabpanel"
                            aria-labelledby="v-pills-footer-bottom-tab" data-tab="footer-bottom">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label for="meta_title"
                                            class="col-sm-3 text-left col-form-label ">{{ __('Show Copyright') }}</label>
                                        <div class="col-sm-6">
                                            <input type="hidden"
                                                name="{{ $layout }}_template_footer[bottom][status]"
                                                value="0">
                                            <div class="switch switch-bg d-inline m-r-10">
                                                <input type="checkbox"
                                                    name="{{ $layout }}_template_footer[bottom][status]"
                                                    {{ $footer['bottom']['status'] ? 'checked' : '' }}
                                                    value="{{ $footer['bottom']['status'] }}"
                                                    id="show-bottom-footer">
                                                <label for="show-bottom-footer" class="cr"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group row conditional" data-if="#show-bottom-footer">
                                                <label for="footer-bottom-title"
                                                    class="col-sm-3 text-left col-form-label ">{{ __('Text Color') }}</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control demo inputFieldDesign"
                                                        data-control="hue"
                                                        name="{{ $layout }}_template_footer[bottom][text_color]"
                                                        value="{{ isset($footer['bottom']['text_color']) ? $footer['bottom']['text_color'] : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row conditional" data-if="#show-bottom-footer">
                                                <label for="footer-bottom-title"
                                                    class="col-sm-3 text-left col-form-label ">{{ __('Background Color') }}</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control demo inputFieldDesign"
                                                        data-control="hue"
                                                        name="{{ $layout }}_template_footer[bottom][bg_color]"
                                                        value="{{ isset($footer['bottom']['bg_color']) ? $footer['bottom']['bg_color'] : '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group row">
                                                <label for="footer-bottom-border"
                                                    class="col-sm-3 text-left col-form-label">{{ __('Top Border Color') }}</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control demo inputFieldDesign"
                                                        data-control="hue"
                                                        name="{{ $layout }}_template_footer[bottom][border_top]"
                                                        value="{{ isset($footer['bottom']['border_top']) ? $footer['bottom']['border_top'] : '#000000' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row conditional" data-if="#show-bottom-footer">
                                        <label for="footer-bottom-title"
                                            class="col-sm-3 text-left col-form-label ">{{ __('Content') }}</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control"
                                                id="footer-bottom-title" name="{{ $layout }}_template_footer[bottom][title]"
                                                value="{{ $footer['bottom']['title'] }}">
                                        </div>
                                    </div>
                                    <div class="form-group row conditional" data-if="#show-bottom-footer">
                                        <label for="footer-bottom-position"
                                            class="col-sm-3 text-left col-form-label ">{{ __('Alignment') }}</label>
                                        <div class="col-md-8">
                                            <div class="form-group d-inline mr-2">
                                                <div class="radio radio-warning d-inline">
                                                    <input type="radio"
                                                        name="{{ $layout }}_template_footer[bottom][position]"
                                                        value="left" id="footer-bottom-direction-left"
                                                        {{ $footer['bottom']['position'] == 'left' ? 'checked' : '' }}>
                                                    <label for="footer-bottom-direction-left"
                                                        class="cr">{{ __('Left') }}</label>
                                                </div>
                                            </div>
                                            <div class="form-group d-inline mr-2">
                                                <div class="radio radio-warning d-inline">
                                                    <input type="radio"
                                                        name="{{ $layout }}_template_footer[bottom][position]"
                                                        value="center" id="footer-bottom-direction-center"
                                                        {{ $footer['bottom']['position'] == 'center' ? 'checked' : '' }}>
                                                    <label for="footer-bottom-direction-center"
                                                        class="cr">{{ __('Center') }}</label>
                                                </div>
                                            </div>
                                            <div class="form-group d-inline mr-2">
                                                <div class="radio radio-warning d-inline">
                                                    <input type="radio"
                                                        name="{{ $layout }}_template_footer[bottom][position]"
                                                        value="right" id="footer-bottom-direction-right"
                                                        {{ $footer['bottom']['position'] == 'right' ? 'checked' : '' }}>
                                                    <label for="footer-bottom-direction-right"
                                                        class="cr">{{ __('Right') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer appearance py-0">
                        <div class="form-group row">
                            <label for="btn_save" class="col-sm-3 control-label"></label>
                            <div class="col-sm-12">
                                <button type="submit"
                                    class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left theme-option-save-btn"
                                    id="footer-btn">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<script>
    'use strict';
    var layout = "{{ $layout }}";
</script>

<!-- form-picker-custom Js -->
<script src="{{ asset('public/datta-able/js/pages/form-picker-custom.min.js') }}"></script>
