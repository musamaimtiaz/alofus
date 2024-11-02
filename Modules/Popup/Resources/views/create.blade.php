@extends('admin.layouts.app')
@section('page_title', __('Create Popup'))
@section('css')
    <link rel="stylesheet" href="{{ asset('Modules/CMS/Resources/assets/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/MediaManager/Resources/assets/css/media-manager.min.css') }}">
@endsection
@section('content')
    <div class="col-sm-12" id="popup-add-container">
        <div class="card">
            <div class="card-body">
                <div class="row" id="theme-container">
                    <div class="col-md-3 col-12 z-index-10 ltr:ps-md-3 ltr:pe-0 ltr:ps-0 rtl:pe-md-3 rtl:ps-0 rtl:pe-0"
                        aria-labelledby="navbarDropdown">
                        <div class="card card-info shadow-none" id="nav">
                            <div class="card-header text-nowrap pt-4 border-bottom">
                                <h5 id="general-settings">{{ __('Popup Create') }}
                                </h5>
                            </div>
                            <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                <li><a class="nav-link active text-left tab-name" id="v-pills-general-tab"
                                        data-bs-toggle="pill" href="#v-pills-target" role="tab"
                                        aria-controls="v-pills-target" aria-selected="true"
                                        data-id="{{ __('Targeting') }}">{{ __('Targeting') }}</a></li>
                                <li><a class="nav-link text-left tab-name" id="v-pills-display-tab" data-bs-toggle="pill"
                                        href="#v-pills-display" role="tab" aria-controls="v-pills-display"
                                        aria-selected="true" data-id="{{ __('Display') }}">{{ __('Display') }}</a></li>
                                <li><a class="nav-link text-left tab-name" id="v-pills-content-tab" data-bs-toggle="pill"
                                        href="#v-pills-content" role="tab" aria-controls="v-pills-content"
                                        aria-selected="true" data-id="{{ __('Content') }}">{{ __('Content') }}</a></li>
                                <li><a class="nav-link text-left tab-name" id="v-pills-popupType-tab" data-bs-toggle="pill"
                                        href="#v-pills-popupType" role="tab" aria-controls="v-pills-popupType"
                                        aria-selected="true" data-id="{{ __('Type') }}">{{ __('Type') }}</a></li>
                                <li><a class="nav-link text-left tab-name" id="v-pills-setting-tab" data-bs-toggle="pill"
                                        href="#v-pills-setting" role="tab" aria-controls="v-pills-setting"
                                        aria-selected="true" data-id="{{ __('Setting') }}">{{ __('Setting') }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-9 col-12 ltr:ps-0 rtl:pe-0">
                        <div class="card card-info shadow-none mb-0">
                            <div class="card-header pt-4 border-bottom">
                                <h5><span id="theme-title"></span></h5>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{ route('popup.store') }}" class="form-horizontal"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="tab-content min-h-210" id="topNav-v-pills-tabContent">
                                        {{-- Targetting --}}
                                        <div class="tab-pane fade" id="v-pills-target" role="tabpanel"
                                            aria-labelledby="v-pills-general-tab">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 control-label require"
                                                            for="name">{{ __('Name') }}</label>
                                                        <div class="col-lg-4 col-md-10">
                                                            <input type="text" placeholder="{{ __('Name') }}"
                                                                class="form-control inputFieldDesign" id="name"
                                                                name="name" required maxlength="120"
                                                                oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                                                value="{{ old('name') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 text-right control-label"
                                                            for="page_link">{{ __('Link') }}</label>
                                                        <div class="col-lg-4 col-md-10">
                                                            <select
                                                                class="form-control select2-hide-search sl_common_bx inputFieldDesign"
                                                                id="page_link" name="page_link" required
                                                                oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                                                <option {{ old('page_link') == 'Home' ? 'selected' : '' }}
                                                                    value="Home">{{ __('Home') }}</option>
                                                                <option
                                                                    {{ old('page_link') == 'Product Details' ? 'selected' : '' }}
                                                                    value="Product Details">{{ __('Product Details') }}
                                                                </option>
                                                                <option {{ old('page_link') == 'Cart' ? 'selected' : '' }}
                                                                    value="Cart">{{ __('Cart') }}</option>
                                                                <option
                                                                    {{ old('page_link') == 'Checkout' ? 'selected' : '' }}
                                                                    value="Checkout">{{ __('Checkout') }}</option>
                                                                <option
                                                                    {{ old('page_link') == 'Confirm Order' ? 'selected' : '' }}
                                                                    value="Confirm Order">{{ __('Confirm Order') }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="form-group md-row">
                                                    <label for="btn_save" class="col-md-3 control-label"></label>
                                                    <div class="d-flex col-md-12">
                                                        <button type="button"
                                                            class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left"
                                                            disabled>{{ __('Previous') }}</button>
                                                        <button data-id="v-pills-display-tab" type="button"
                                                            class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left switch-tab">{{ __('Next') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Display --}}
                                        <div class="tab-pane fade" id="v-pills-display" role="tabpanel"
                                            aria-labelledby="v-pills-display-tab">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 control-label require text-left"
                                                            for="background">{{ __('Background') }}</label>
                                                        <div class="col-lg-4 col-md-10">
                                                            <select class="form-control select2-hide-search sl_common_bx"
                                                                id="background" name="background" required
                                                                oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                                                <option value="">{{ __('Select One') }}</option>
                                                                <option
                                                                    {{ old('background') == 'Image' ? 'selected' : '' }}
                                                                    value="Image">{{ __('Image') }}</option>
                                                                <option
                                                                    {{ old('background') == 'Color' ? 'selected' : '' }}
                                                                    value="Color">{{ __('Color') }}</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-1 offset-md-2 mt-lg-0 mt-3 col-md-10 d-none">
                                                            <input type="color" name="popup_bg_color"
                                                                id="popup_bg_color" value="{{ old('popup_bg_color') }}">
                                                        </div>
                                                        <div
                                                            class="col-lg-5 mt-lg-0 mt-3 col-md-10">
                                                            <div class="custom-file position-relative mb-5"
                                                                data-val="single" id="image-status">
                                                                <input name="logo" id="popup_image" maxlength="50"
                                                                    accept="image/*">
                                                                <label
                                                                    class="custom-file-label overflow_hidden d-flex align-items-center"
                                                                    for="validatedCustomFile">{{ __('Upload image') }}</label>
                                                                <div class="offset-7 mt-3 popup-image-position"
                                                                    id="img-container">
                                                                    <!-- img will be shown here -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 control-label require"
                                                            for="position">{{ __('Position') }}</label>
                                                        <div class="col-lg-4 col-md-10">
                                                            <select class="form-control select2-hide-search sl_common_bx"
                                                                id="position" name="position" required
                                                                oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                                                <option {{ old('position') == 'Center' ? 'selected' : '' }}
                                                                    value="Center">{{ __('Center') }}</option>
                                                                <option
                                                                    {{ old('position') == 'Top Left' ? 'selected' : '' }}
                                                                    value="Top Left">{{ __('Top Left') }}</option>
                                                                <option
                                                                    {{ old('position') == 'Top Right' ? 'selected' : '' }}
                                                                    value="Top Right">{{ __('Top Right') }}</option>
                                                                <option
                                                                    {{ old('position') == 'Bottom Left' ? 'selected' : '' }}
                                                                    value="Bottom Left">{{ __('Bottom Left') }}</option>
                                                                <option
                                                                    {{ old('position') == 'Bottom Right' ? 'selected' : '' }}
                                                                    value="Bottom Right">{{ __('Bottom Right') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-2 control-label require"
                                                            for="width">{{ __('Width') }}</label>
                                                        <div class="col-lg-4 col-md-10">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <button class="border-0 btn-sm h-40"
                                                                        type="button">Px</button>
                                                                </div>
                                                                <input type="text" maxlength="3" placeholder="400"
                                                                    class="form-control positive-int-number inputFieldDesign"
                                                                    id="width" name="width"
                                                                    value="{{ old('width') }}" required
                                                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 control-label text-right require"
                                                            for="height">{{ __('Height') }}</label>
                                                        <div class="col-lg-4 col-md-10">
                                                            <div class="input-group">
                                                                <div class="input-group-append">
                                                                    <button class="border-0 btn-sm h-40"
                                                                        type="button">Px</button>
                                                                </div>
                                                                <input type="text" maxlength="3" placeholder="400"
                                                                    class="form-control positive-int-number inputFieldDesign"
                                                                    id="height" name="height"
                                                                    value="{{ old('height') }}" required
                                                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <div class="form-group md-row">
                                                    <label for="btn_save" class="col-md-3 control-label"></label>
                                                    <div class="d-flex col-md-12">
                                                        <button data-id="v-pills-general-tab" type="button"
                                                            class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left switch-tab">{{ __('Previous') }}</button>
                                                        <button data-id="v-pills-content-tab" type="button"
                                                            class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left switch-tab">{{ __('Next') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Content --}}
                                        <div class="tab-pane fade" id="v-pills-content" role="tabpanel"
                                            aria-labelledby="v-pills-content-tab">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div id="text">
                                                        @if (empty(old('text')))
                                                            <div class="text-area border p-3">
                                                                <div
                                                                    class="popup-content-remove d-flex justify-content-end align-items-end">
                                                                    <span class="remove-text cursor-pointer py-2">x</span>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-2 control-label"
                                                                        for="text1">{{ __('Text') }}</label>
                                                                    <div
                                                                        class="row col-sm-10 col-12 margin-auto padding-0">
                                                                        <div class="col-lg-7 col-9">
                                                                            <input type="text" maxlength="300"
                                                                                placeholder="{{ __('Text') }}"
                                                                                class="form-control inputFieldDesign"
                                                                                id="text1" name="text[text1][text]">
                                                                        </div>
                                                                        <div class="col-lg-1 p-0 col-2">
                                                                            <input type="color"
                                                                                class="w-100 cursor-pointer p-1"
                                                                                name="text[text1][text_color]"
                                                                                id="text1_color">
                                                                        </div>
                                                                        <div class="col-lg-4 col-12 mt-lg-0 mt-3">
                                                                            <div class="input-group">
                                                                                <input type="text" maxlength="3"
                                                                                    placeholder="{{ __('Font size') }}"
                                                                                    class="form-control positive-int-number inputFieldDesign"
                                                                                    id="text1_size"
                                                                                    name="text[text1][text_size]"
                                                                                    >
                                                                                <div class="input-group-append">
                                                                                    <button class="border-0 btn-sm h-40"
                                                                                        type="button">Px</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-2 col-12 control-label text-left"
                                                                        for="text1_margin_left">{{ __('Text Margin') }}</label>
                                                                    <div class="col-sm-7 col-12 margin-auto row">
                                                                        <div class="col-sm-6 padding-0 col-12">
                                                                            <div class="input-group">
                                                                                <input type="text" maxlength="3"
                                                                                    placeholder="{{ __('Left') }}"
                                                                                    class="form-control positive-int-number inputFieldDesign"
                                                                                    id="text1_margin_left"
                                                                                    name="text[text1][text_margin_left]"
                                                                                    >
                                                                                <div class="input-group-append">
                                                                                    <button class="border-0 btn-sm h-40"
                                                                                        type="button">Px</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="col-sm-6 padding-0 col-12 mt-sm-0 mt-3">
                                                                            <div class="input-group">
                                                                                <input type="text" maxlength="3"
                                                                                    placeholder="{{ __('Top') }}"
                                                                                    class="form-control positive-int-number inputFieldDesign"
                                                                                    id="text1_margin_top"
                                                                                    name="text[text1][text_margin_top]"
                                                                                    >
                                                                                <div class="input-group-append">
                                                                                    <button class="border-0 btn-sm h-40"
                                                                                        type="button">Px</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6 padding-0 col-12 mt-3">
                                                                            <div class="input-group">
                                                                                <input type="text" maxlength="3"
                                                                                    placeholder="{{ __('Right') }}"
                                                                                    class="form-control positive-int-number inputFieldDesign"
                                                                                    id="text1_margin_right"
                                                                                    name="text[text1][text_margin_right]"
                                                                                    >
                                                                                <div class="input-group-append">
                                                                                    <button class="border-0 btn-sm h-40"
                                                                                        type="button">Px</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6 padding-0 mt-3 col-12">
                                                                            <div class="input-group">
                                                                                <input type="text" maxlength="3"
                                                                                    placeholder="{{ __('Bottom') }}"
                                                                                    class="form-control positive-int-number inputFieldDesign"
                                                                                    id="text1_margin_bottom"
                                                                                    name="text[text1][text_margin_bottom]"
                                                                                    >
                                                                                <div class="input-group-append">
                                                                                    <button class="border-0 btn-sm h-40"
                                                                                        type="button">Px</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-3 ltr:ps-sm-0 rtl:pe-sm-0 mt-3 mt-sm-0">
                                                                        <div class="col-12 col-sm-12 h-40 mb-3 p-0">
                                                                            <select
                                                                                class="form-select inputFieldDesign cursor-pointer sl_common_bx"
                                                                                id="text1_alignment"
                                                                                name="text[text1][text_alignment]" required
                                                                                oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                                                                <option value="left">{{ __('Left') }}
                                                                                </option>
                                                                                <option value="center">{{ __('Center') }}
                                                                                </option>
                                                                                <option value="right">{{ __('Right') }}
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-12 col-sm-12 h-40 p-0">
                                                                            <select
                                                                                class="form-select inputFieldDesign cursor-pointer sl_common_bx"
                                                                                id="text1_font_weight"
                                                                                name="text[text1][text_font_weight]"
                                                                                required
                                                                                oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                                                                <option value="normal">{{ __('Normal') }}
                                                                                </option>
                                                                                <option value="bold">{{ __('Bold') }}
                                                                                </option>
                                                                                <option value="italic">{{ __('Italic') }}
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            @foreach (old('text') as $text)
                                                                @php
                                                                    $textIteration = $loop->iteration;
                                                                @endphp
                                                                <div class="text-area border p-3">
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-2 control-label"
                                                                            for="text{{ $loop->iteration }}">{{ __('Text') }}</label>
                                                                        <div class="col-sm-5">
                                                                            <input type="text" maxlength="300"
                                                                                placeholder="{{ __('Text') }}"
                                                                                class="form-control inputFieldDesign"
                                                                                id="text{{ $loop->iteration }}"
                                                                                name="text[text{{ $loop->iteration }}][text]"
                                                                                value='{{ $text['text'] }}'>
                                                                        </div>
                                                                        <div class="col-1">
                                                                            <input type="color"
                                                                                class="w-100 cursor-pointer p-1"
                                                                                name="text[text{{ $loop->iteration }}][text_color]"
                                                                                id="text{{ $loop->iteration }}_color">
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <div class="input-group">
                                                                                <input type="text" maxlength="3"
                                                                                    placeholder="{{ __('Font size') }}"
                                                                                    class="form-control positive-int-number inputFieldDesign"
                                                                                    id="text{{ $loop->iteration }}_size"
                                                                                    name="text[text{{ $loop->iteration }}][text_size]"
                                                                                    value='{{ $text['text_size'] }}'>
                                                                                <div class="input-group-append">
                                                                                    <button class="border-0 btn-sm h-40"
                                                                                        type="button">Px</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-1 popup-content-remove">
                                                                            <span
                                                                                class="remove-text cursor-pointer px-3 py-2">x</span>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                        <label class="col-sm-2 control-label text-left"
                                                                            for="text{{ $loop->iteration }}_margin_left">{{ __('Text Margin') }}</label>
                                                                        <div class="col-sm-3">
                                                                            <div class="input-group">
                                                                                <input type="text" maxlength="3"
                                                                                    placeholder="{{ __('Left') }}"
                                                                                    class="form-control positive-int-number inputFieldDesign"
                                                                                    id="text{{ $loop->iteration }}_margin_left"
                                                                                    name="text[text{{ $loop->iteration }}][text_margin_left]"
                                                                                    value='{{ $text['text_margin_left'] }}'>
                                                                                <div class="input-group-append">
                                                                                    <button class="border-0 btn-sm h-40"
                                                                                        type="button">Px</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <div class="input-group">
                                                                                <input type="text" maxlength="3"
                                                                                    placeholder="{{ __('Top') }}"
                                                                                    class="form-control positive-int-number inputFieldDesign"
                                                                                    id="text{{ $loop->iteration }}_margin_top"
                                                                                    name="text[text{{ $loop->iteration }}][text_margin_top]"
                                                                                    value='{{ $text['text_margin_top'] }}'>
                                                                                <div class="input-group-append">
                                                                                    <button class="border-0 btn-sm h-40"
                                                                                        type="button">Px</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <select
                                                                                class="form-control select2 sl_common_bx"
                                                                                id="text{{ $loop->iteration }}_font_weight"
                                                                                name="text[text{{ $loop->iteration }}][text_font_weight]"
                                                                                value='{{ $text['text_font_weight'] }}'>
                                                                                <option value="normal">
                                                                                    {{ __('Normal') }}
                                                                                </option>
                                                                                <option value="bold">
                                                                                    {{ __('Bold') }}
                                                                                </option>
                                                                                <option value="italic">
                                                                                    {{ __('Italic') }}
                                                                                </option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="col-sm-3 offset-2 mt-14">
                                                                            <div class="input-group">
                                                                                <input type="text" maxlength="3"
                                                                                    placeholder="{{ __('Right') }}"
                                                                                    class="form-control positive-int-number inputFieldDesign"
                                                                                    id="text{{ $loop->iteration }}_margin_right"
                                                                                    name="text[text{{ $loop->iteration }}][text_margin_right]"
                                                                                    value='{{ $text['text_margin_right'] }}'>
                                                                                <div class="input-group-append">
                                                                                    <button class="border-0 btn-sm h-40"
                                                                                        type="button">Px</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-3 mt-14">
                                                                            <div class="input-group">
                                                                                <input type="text" maxlength="3"
                                                                                    placeholder="{{ __('Bottom') }}"
                                                                                    class="form-control positive-int-number inputFieldDesign"
                                                                                    id="text{{ $loop->iteration }}_margin_bottom"
                                                                                    name="text[text{{ $loop->iteration }}][text_margin_bottom]"
                                                                                    value='{{ $text['text_margin_bottom'] }}'>
                                                                                <div class="input-group-append">
                                                                                    <button class="border-0 btn-sm h-40"
                                                                                        type="button">Px</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4 mt-14">
                                                                            <select
                                                                                class="form-control select2 sl_common_bx"
                                                                                id="text{{ $loop->iteration }}_alignment"
                                                                                name="text[text{{ $loop->iteration }}][text_alignment]"
                                                                                value='{{ $text['text_alignment'] }}'>
                                                                                <option value="left">
                                                                                    {{ __('Left') }}
                                                                                </option>
                                                                                <option value="center">
                                                                                    {{ __('Center') }}
                                                                                </option>
                                                                                <option value="right">
                                                                                    {{ __('Right') }}
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>

                                                    <div class="col-10 mt-14 mb-3 px-0 w-full">
                                                        <button class="btn form-submit custom-btn-submit" type="button"
                                                            data-id="{{ isset($textIteration) ? $textIteration + 1 : 2 }}"
                                                            id="add_text">{{ __('Add text') }}</button>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <div class="form-group md-row">
                                                    <label for="btn_save" class="col-md-3 control-label"></label>
                                                    <div class="d-flex col-md-12">
                                                        <button data-id="v-pills-display-tab" type="button"
                                                            class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left switch-tab">{{ __('Previous') }}</button>
                                                        <button data-id="v-pills-popupType-tab" type="button"
                                                            class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left switch-tab">{{ __('Next') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Setting --}}
                                        <div class="tab-pane fade" id="v-pills-setting" role="tabpanel"
                                            aria-labelledby="v-pills-setting-tab">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 control-label require"
                                                            for="name">{{ __('Popup show after') }}</label>
                                                        <div class="col-lg-4 col-md-7">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <button class="border-0 btn-sm h-40"
                                                                        type="button">{{ __('Sec') }}</button>
                                                                </div>
                                                                <input type="text" maxlength="5" placeholder="30"
                                                                    class="form-control positive-int-number inputFieldDesign"
                                                                    id="show_after" name="show_time" required
                                                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                                                    min="1"
                                                                    data-min="{{ __('This value must be greater than 0.') }}"
                                                                    value="{{ old('show_time') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="from-group row">
                                                        <label for="start_date"
                                                            class="control-label col-sm-3 require">{{ __('Start Date') }}</label>
                                                        <div class="col-lg-4 col-md-7">
                                                            <input type="text" id="start_date" name="start_date"
                                                                readonly="readonly"
                                                                class="form-control start_date inputFieldDesign"
                                                                value="{{ old('start_date') }}">
                                                        </div>
                                                    </div>
                                                    <div class="for-group row mt-14">
                                                        <label for="end_date"
                                                            class="control-label col-sm-3 require">{{ __('End Date') }}</label>
                                                        <div class="col-lg-4 col-md-7">
                                                            <input type="text" id="end_date" name="end_date"
                                                                readonly="readonly"
                                                                class="form-control end_date inputFieldDesign"
                                                                value="{{ old('end_date') }}">
                                                        </div>
                                                    </div>
                                                    <div class="from-group row mt-14">
                                                        <label for="login-ndeeded"
                                                            class="control-label col-sm-3 require">{{ __('Login needed') }}</label>
                                                        <div class="col-lg-4 col-md-7">
                                                            <select
                                                                class="form-control select2-hide-search sl_common_bx inputFieldDesign"
                                                                id="login_enabled" name="login_enabled" required
                                                                oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                                                <option
                                                                    {{ old('login_enabled') == '0' ? 'selected' : '' }}
                                                                    value="0">{{ __('No') }}</option>
                                                                <option
                                                                    {{ old('login_enabled') == '1' ? 'selected' : '' }}
                                                                    value="1">{{ __('Yes') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="from-group row mt-14 mb-3">
                                                        <label for="status"
                                                            class="control-label col-sm-3 require">{{ __('Status') }}</label>
                                                        <div class="col-lg-4 col-md-7">
                                                            <select
                                                                class="form-control select2-hide-search sl_common_bx inputFieldDesign"
                                                                id="status" name="status" required
                                                                oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                                                <option {{ old('status') == 'Active' ? 'selected' : '' }}
                                                                    value="Active">{{ __('Active') }}</option>
                                                                <option
                                                                    {{ old('status') == 'Inactive' ? 'selected' : '' }}
                                                                    value="Inactive">{{ __('Inactive') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="form-group md-row">
                                                    <label for="btn_save" class="col-md-3 control-label"></label>
                                                    <div class="col-md-12 d-flex">
                                                        <a href="{{ route('popup.index') }}"
                                                            class="btn form-submit custom-btn-cancel all-cancel-btn ltr:float-right rtl:float-left coupon-submit-button">{{ __('Cancel') }}</a>
                                                        <button type="submit"
                                                            class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left popup-store-button"
                                                            id="footer-btn">{{ __('Save') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Popup Type --}}
                                        <div class="tab-pane fade" id="v-pills-popupType" role="tabpanel"
                                            aria-labelledby="v-pills-popupType-tab">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 control-label"
                                                            for="type">{{ __('Popup Type') }}</label>
                                                        <div class="col-lg-5 col-md-10">
                                                            <select class="form-control select2-hide-search sl_common_bx"
                                                                id="popup_type" name="type">
                                                                <option
                                                                    {{ old('type') == 'Information' ? 'selected' : '' }}
                                                                    value="Information">{{ __('Information') }}</option>
                                                                <option
                                                                    {{ old('type') == 'Another page link' ? 'selected' : '' }}
                                                                    value="Another page link">
                                                                    {{ __('Another page link') }}
                                                                </option>
                                                                <option {{ old('type') == 'Send mail' ? 'selected' : '' }}
                                                                    value="Send mail">{{ __('Send mail') }}</option>
                                                                <option
                                                                    {{ old('type') == 'Subscribed' ? 'selected' : '' }}
                                                                    value="Subscribed">{{ __('Subscribed') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    {{-- Go to another page --}}
                                                    <div id="page_links" class="d-none mt-25">
                                                        <div class="form-group row mt-14">
                                                            <label class="col-sm-2 control-label"
                                                                for="button_title">{{ __('Button') }}</label>
                                                            <div class="col-sm-5">
                                                                <input type="text" maxlength="30"
                                                                    placeholder="{{ __('Button Title') }}"
                                                                    class="form-control inputFieldDesign"
                                                                    id="button_title" name="button_title"
                                                                    value="{{ old('button_title') }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mt-14">
                                                            <div class="col-sm-5 offset-md-2">
                                                                <input type="text" placeholder="{{ __('Web Link') }}"
                                                                    class="form-control inputFieldDesign" id="button_link"
                                                                    name="button_link" value="{{ old('button_link') }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 offset-md-2 control-label text-left"
                                                                for="button_text_color">{{ __('Text color') }}</label>
                                                            <div class="col-sm-2">
                                                                <input type="color" class="w-100 cursor-pointer p-1"
                                                                    name="button_text_color" id="button_text_color"
                                                                    value="{{ old('button_text_color') }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 offset-md-2 control-label text-left"
                                                                for="button_bg_color">{{ __('Background color') }}</label>
                                                            <div class="col-sm-2">
                                                                <input type="color" class="w-100 cursor-pointer p-1"
                                                                    name="button_bg_color" id="button_bg_color"
                                                                    value="{{ old('button_bg_color') }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 offset-md-2 control-label text-left"
                                                                for="button_hover_text_color">{{ __('Text color on hover') }}</label>
                                                            <div class="col-sm-2">
                                                                <input type="color" class="w-100 cursor-pointer p-1"
                                                                    name="button_hover_text_color"
                                                                    id="button_hover_text_color"
                                                                    value="{{ old('button_hover_text_color') }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 offset-md-2 control-label text-left"
                                                                for="button_hover_bg_color">{{ __('Background on hover') }}</label>
                                                            <div class="col-sm-2">
                                                                <input type="color" class="w-100 cursor-pointer p-1"
                                                                    name="button_hover_bg_color"
                                                                    id="button_hover_bg_color"
                                                                    value="{{ old('button_hover_bg_color') }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 offset-md-2 control-label text-left"
                                                                for="button_margin_left">{{ __('Button Margin') }}</label>
                                                            <div class="col-sm-3">
                                                                <div class="input-group">
                                                                    <input type="text" maxlength="3"
                                                                        placeholder="{{ __('Left') }}"
                                                                        class="form-control positive-int-number inputFieldDesign"
                                                                        id="button_margin_left" name="button_margin_left"
                                                                        value="{{ old('button_margin_left') }}">
                                                                    <div class="input-group-append">
                                                                        <button class="border-0 btn-sm h-40"
                                                                            type="button">Px</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3 mt-3 mt-md-0">
                                                                <div class="input-group">
                                                                    <input type="text" maxlength="3"
                                                                        placeholder="{{ __('Top') }}"
                                                                        class="form-control positive-int-number inputFieldDesign"
                                                                        id="button_margin_top" name="button_margin_top"
                                                                        value="{{ old('button_margin_top') }}">
                                                                    <div class="input-group-append">
                                                                        <button class="border-0 btn-sm h-40"
                                                                            type="button">Px</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3 offset-sm-5 mt-14">
                                                                <div class="input-group">
                                                                    <input type="text" maxlength="3"
                                                                        placeholder="{{ __('Right') }}"
                                                                        class="form-control positive-int-number inputFieldDesign"
                                                                        id="button_margin_right"
                                                                        name="button_margin_right"
                                                                        value="{{ old('button_margin_right') }}">
                                                                    <div class="input-group-append">
                                                                        <button class="border-0 btn-sm h-40"
                                                                            type="button">Px</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3 mt-14">
                                                                <div class="input-group">
                                                                    <input type="text" maxlength="3"
                                                                        placeholder="{{ __('Bottom') }}"
                                                                        class="form-control positive-int-number inputFieldDesign"
                                                                        id="button_margin_bottom"
                                                                        name="button_margin_bottom"
                                                                        value="{{ old('button_margin_bottom') }}">
                                                                    <div class="input-group-append">
                                                                        <button class="border-0 btn-sm h-40"
                                                                            type="button">Px</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Mail --}}
                                                    <div id="mail" class="d-none mt-25">
                                                        <div class="form-group row mt-14">
                                                            <label class="col-sm-2 control-label"
                                                                for="email_placeholder">{{ __('Mail') }}</label>
                                                            <div class="col-sm-5">
                                                                <input type="text" maxlength="100"
                                                                    placeholder="{{ __('Email placeholder') }}"
                                                                    class="form-control inputFieldDesign"
                                                                    id="email_placeholder" name="email_placeholder"
                                                                    value="{{ old('email_placeholder') }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mt-14">
                                                            <div class="col-sm-5 offset-md-2">
                                                                <input type="text" maxlength="20"
                                                                    placeholder="{{ __('Submit button name') }}"
                                                                    class="form-control inputFieldDesign"
                                                                    id="email_button_name" name="email_button_name"
                                                                    value="{{ old('email_button_name') }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-sm-3 offset-md-2 control-label text-left"
                                                                for="email_button_text_color">{{ __('Text color') }}</label>
                                                            <div class="col-sm-2">
                                                                <input type="color" class="w-100 cursor-pointer p-1"
                                                                    name="email_button_text_color"
                                                                    id="email_button_text_color"
                                                                    value="{{ old('email_button_text_color') }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 offset-md-2 control-label text-left"
                                                                for="email_button_bg_color">{{ __('Background color') }}</label>
                                                            <div class="col-sm-2">
                                                                <input type="color" class="w-100 cursor-pointer p-1"
                                                                    name="email_button_bg_color"
                                                                    id="email_button_bg_color"
                                                                    value="{{ old('email_button_bg_color') }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-sm-3 offset-md-2 control-label text-left"
                                                                for="email_button_hover_text_color">{{ __('Text color on hover') }}</label>
                                                            <div class="col-sm-2">
                                                                <input type="color" class="w-100 cursor-pointer p-1"
                                                                    name="email_button_hover_text_color"
                                                                    id="email_button_hover_text_color"
                                                                    value="{{ old('email_button_hover_text_color') }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 offset-md-2 control-label text-left"
                                                                for="email_button_hover_bg_color">{{ __('Background on hover') }}</label>
                                                            <div class="col-sm-2">
                                                                <input type="color" class="w-100 cursor-pointer p-1"
                                                                    name="email_button_hover_bg_color"
                                                                    id="email_button_hover_bg_color"
                                                                    value="{{ old('email_button_hover_bg_color') }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 offset-md-2 control-label text-left"
                                                                for="email_button_margin_left">{{ __('Box Margin') }}</label>
                                                            <div class="col-sm-3">
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        placeholder="{{ __('Left') }}"
                                                                        class="form-control positive-int-number inputFieldDesign"
                                                                        id="email_button_margin_left"
                                                                        name="email_button_margin_left"
                                                                        value="{{ old('email_button_margin_left') }}">
                                                                    <div class="input-group-append">
                                                                        <button class="border-0 btn-sm h-40"
                                                                            type="button">Px</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3 mt-3 mt-md-0">
                                                                <div class="input-group">
                                                                    <input type="text" maxlength="3"
                                                                        placeholder="{{ __('Top') }}"
                                                                        class="form-control positive-int-number inputFieldDesign"
                                                                        id="email_margin_top" name="email_margin_top"
                                                                        value="{{ old('email_margin_top') }}">
                                                                    <div class="input-group-append">
                                                                        <button class="border-0 btn-sm h-40"
                                                                            type="button">Px</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3 offset-sm-5 mt-14">
                                                                <div class="input-group">
                                                                    <input type="number" maxlength="3"
                                                                        placeholder="{{ __('Right') }}"
                                                                        class="form-control positive-int-number inputFieldDesign"
                                                                        id="email_margin_right" name="email_margin_right"
                                                                        value="{{ old('email_margin_right') }}">
                                                                    <div class="input-group-append">
                                                                        <button class="border-0 btn-sm h-40"
                                                                            type="button">Px</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3 mt-14">
                                                                <div class="input-group">
                                                                    <input type="text" maxlength="3"
                                                                        placeholder="{{ __('Bottom') }}"
                                                                        class="form-control positive-int-number inputFieldDesign"
                                                                        id="email_margin_bottom"
                                                                        name="email_margin_bottom"
                                                                        value="{{ old('email_margin_bottom') }}">
                                                                    <div class="input-group-append">
                                                                        <button class="border-0 btn-sm h-40"
                                                                            type="button">Px</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mt-3 mt-md-0 row">
                                                            <div class="col-12 col-md-10 offset-sm-2">
                                                                <textarea class="form-control" maxlength="1000" name="email_content" id="email_content" rows="5"
                                                                    placeholder="{{ __('Mail content will be here.') }}">{{ old('email_content') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Subscription --}}
                                                    <div id="subscription" class="d-none mt-25">
                                                        <div class="form-group row mt-14">
                                                            <label class="col-sm-2 control-label"
                                                                for="subscription_email_placeholder">{{ __('Subscription') }}</label>
                                                            <div class="col-sm-5">
                                                                <input type="text" maxlength="30"
                                                                    placeholder="{{ __('Email placeholder') }}"
                                                                    class="form-control"
                                                                    id="subscription_email_placeholder"
                                                                    name="subscription_email_placeholder"
                                                                    value="{{ old('subscription_email_placeholder') }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mt-14">
                                                            <div class="col-sm-5 offset-md-2">
                                                                <input type="text" maxlength="20"
                                                                    placeholder="{{ __('Submit button name') }}"
                                                                    class="form-control" id="subscription_button_name"
                                                                    name="subscription_button_name"
                                                                    value="{{ old('subscription_button_name') }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-sm-3 offset-md-2 control-label text-left"
                                                                for="subscription_button_text_color">{{ __('Text color') }}</label>
                                                            <div class="col-sm-2">
                                                                <input type="color" class="w-100 cursor-pointer p-1"
                                                                    name="subscription_button_text_color"
                                                                    id="subscription_button_text_color"
                                                                    value="{{ old('subscription_button_text_color') }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 offset-md-2 control-label text-left"
                                                                for="subscription_button_bg_color">{{ __('Background color') }}</label>
                                                            <div class="col-sm-2">
                                                                <input type="color" class="w-100 cursor-pointer p-1"
                                                                    name="subscription_button_bg_color"
                                                                    id="subscription_button_bg_color"
                                                                    value="{{ old('subscription_button_bg_color') }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-sm-3 offset-md-2 control-label text-left"
                                                                for="subscription_button_hover_text_color">{{ __('Text color on hover') }}</label>
                                                            <div class="col-sm-2">
                                                                <input type="color" class="w-100 cursor-pointer p-1"
                                                                    name="subscription_button_hover_text_color"
                                                                    id="subscription_button_hover_text_color"
                                                                    value="{{ old('subscription_button_hover_text_color') }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 offset-md-2 control-label text-left"
                                                                for="subscription_button_hover_bg_color">{{ __('Background on hover') }}</label>
                                                            <div class="col-sm-2">
                                                                <input type="color" class="w-100 cursor-pointer p-1"
                                                                    name="subscription_button_hover_bg_color"
                                                                    id="subscription_button_hover_bg_color"
                                                                    value="{{ old('subscription_button_hover_bg_color') }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-sm-3 offset-md-2 control-label text-left"
                                                                for="subscription_button_margin_left">{{ __('Box Margin') }}</label>
                                                            <div class="col-sm-3">
                                                                <div class="input-group">
                                                                    <input type="text" maxlength="3"
                                                                        placeholder="{{ __('Left') }}"
                                                                        class="form-control positive-int-number"
                                                                        id="subscription_button_margin_left"
                                                                        name="subscription_button_margin_left"
                                                                        value="{{ old('subscription_button_margin_left') }}">
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-sm"
                                                                            type="button">Px</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3 mt-3 mt-md-0">
                                                                <div class="input-group">
                                                                    <input type="text" maxlength="3"
                                                                        placeholder="{{ __('Top') }}"
                                                                        class="form-control positive-int-number"
                                                                        id="subscription_margin_top"
                                                                        name="subscription_margin_top"
                                                                        value="{{ old('subscription_margin_top') }}">
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-sm"
                                                                            type="button">Px</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3 offset-sm-5 mt-14">
                                                                <div class="input-group">
                                                                    <input type="text" maxlength="3"
                                                                        placeholder="{{ __('Right') }}"
                                                                        class="form-control positive-int-number"
                                                                        id="subscription_margin_right"
                                                                        name="subscription_margin_right"
                                                                        value="{{ old('subscription_margin_right') }}">
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-sm"
                                                                            type="button">Px</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3 mt-14">
                                                                <div class="input-group">
                                                                    <input type="text" maxlength="3"
                                                                        placeholder="{{ __('Bottom') }}"
                                                                        class="form-control positive-int-number"
                                                                        id="subscription_margin_bottom"
                                                                        name="subscription_margin_bottom"
                                                                        value="{{ old('subscription_margin_bottom') }}">
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-sm"
                                                                            type="button">Px</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="form-group md-row">
                                                    <label for="btn_save" class="col-md-3 control-label"></label>
                                                    <div class="col-md-12 d-flex">
                                                        <button data-id="v-pills-content-tab" type="button"
                                                            class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left switch-tab">{{ __('Previous') }}</button>
                                                        <button data-id="v-pills-setting-tab" type="button"
                                                            class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left switch-tab">{{ __('Next') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    @include('mediamanager::image.modal_image')
@endsection

@section('js')
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/condition.min.js') }}"></script>
    <!-- date range picker Js -->
    <script src="{{ asset('public/dist/js/moment.min.js') }}"></script>
    <script src="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/popup.min.js') }}"></script>
@endsection
