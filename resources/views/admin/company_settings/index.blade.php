@extends('admin.layouts.app')
@section('page_title', __('Company Settings'))
@section('css')
    {{-- Media manager --}}
    <link rel="stylesheet" href="{{ asset('Modules/MediaManager/Resources/assets/css/media-manager.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/product.min.css') }}">
@endsection

@section('content')
    <!-- Main content -->
    <div class="col-sm-12" id="company-settings-container">
        <div class="card">
            <div class="card-body row">
                <div
                    class="col-lg-3 col-12 z-index-10 ltr:ps-md-3 ltr:pe-0 ltr:ps-0 rtl:pe-md-3 rtl:ps-0 rtl:pe-0">
                    @include('admin.layouts.includes.general_settings_menu')
                </div>
                <div class="col-lg-9 col-12 ltr:ps-0 rtl:pe-0">
                    <div class="card card-info shadow-none mb-0">
                        <div class="card-header p-t-20 border-bottom">
                            <h5>{{ __('System Setup') }}</h5>
                            <div class="card-header-right">

                            </div>
                        </div>
                        <form action="{{ route('companyDetails.setting') }}" method="post" id="settingForm"
                            class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group row p-t-10">
                                    <label class="col-sm-3 control-label require" for="inputEmail3">
                                        {{ __('Name') }}
                                    </label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control form-height" name="company_name"
                                            id="company_name"
                                            value="{{ isset($companyData['company']['company_name']) ? $companyData['company']['company_name'] : '' }}"
                                            required
                                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label id='siteshortlabel' class="col-sm-3 control-label require" for="inputEmail3">
                                        {{ __('Site Short Name') }}
                                    </label>

                                    <div class="col-sm-7">
                                        <input type="text" name="site_short_name" readonly="readyonly"
                                            value="{{ isset($companyData['company']['site_short_name']) ? $companyData['company']['site_short_name'] : '' }}"
                                            id="site_short_name" class="form-control form-height" required
                                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                    </div>
                                </div>

                                <div class="form-group row marginTop">
                                    <label class="col-sm-3 control-label require" for="inputEmail3">
                                        {{ __('Email') }}
                                    </label>

                                    <div class="col-sm-7">
                                        <input type="email" class="form-control form-height" name="company_email"
                                            id="company_email"
                                            value="{{ isset($companyData['company']['company_email']) ? $companyData['company']['company_email'] : '' }}"
                                            required
                                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                            data-type-mismatch="{{ __('Enter a valid :x.', ['x' => strtolower(__('Email'))]) }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 control-label require" for="inputEmail3">
                                        {{ __('Phone') }}
                                    </label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control phone-number form-height"
                                            name="company_phone" id="company_phone"
                                            value="{{ isset($companyData['company']['company_phone']) ? $companyData['company']['company_phone'] : '' }}"
                                            required minlength="8"
                                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                            data-min-length="{{ __(':x should contain at least :y digits.', ['x' => __('Phone Number'), 'y' => 8]) }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <label class="d-inline control-label require" for="inputEmail3">
                                            {{ __('Tax Id') }}
                                        </label>
                                    </div>
                                    <div class="col-sm-7">
                                        <input type="text"
                                            value="{{ isset($companyData['company']['company_gstin']) ? $companyData['company']['company_gstin'] : '' }}"
                                            class="form-control form-height" name="company_tax_id" required
                                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 control-label require" for="inputEmail3">
                                        {{ __('Street') }}
                                    </label>

                                    <div class="col-sm-7">
                                        <input type="text" class="form-control form-height" name="company_street"
                                            id="company_street"
                                            value="{{ isset($companyData['company']['company_street']) ? $companyData['company']['company_street'] : '' }}"
                                            required
                                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 control-label require" for="inputEmail3">
                                        {{ __('Country') }}
                                    </label>

                                    <div class="col-sm-7">
                                        <select
                                            class="form-control js-example-basic-single form-height addressSelect sl_common_bx"
                                            name="company_country" id="company_country" required
                                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                            <option value="">{{ __('Select Country') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 control-label require" for="inputEmail3">
                                        {{ __('State') }}
                                    </label>

                                    <div class="col-sm-7">
                                        <select
                                            class="form-control js-example-basic-single form-height addressSelect sl_common_bx"
                                            name="company_state" id="company_state" required
                                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                            <option value="">{{ __('Select State') }}</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-sm-3 control-label require" for="inputEmail3">
                                        {{ __('City') }}
                                    </label>

                                    <div class="col-sm-7">

                                        <select
                                            class="form-control js-example-basic-single form-height addressSelect sl_common_bx"
                                            name="company_city" id="company_city" required
                                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                            <option value="">{{ __('Select City') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 control-label require" for="inputEmail3">
                                        {{ __('Zip code') }}
                                    </label>

                                    <div class="col-sm-7">
                                        <input type="text" class="form-control form-height" name="company_zip_code"
                                            id="company_zip_code"
                                            value="{{ isset($companyData['company']['company_zip_code']) ? $companyData['company']['company_zip_code'] : '' }}"
                                            required
                                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label id="default-language" class="col-sm-3 control-label "
                                        for="inputEmail3">{{ __('Default language') }}</label>

                                    <div class="col-sm-7">
                                        <select name="dflt_lang" id="dflt_lang"
                                            class="form-control js-example-basic-single form-height">
                                            @foreach ($languageData as $language)
                                                <option data-rel="{{ $language->id }}"
                                                    value="{{ $language->short_name }}"
                                                    {{ $companyData['company']['dflt_lang'] == $language->short_name ? 'selected' : '' }}>
                                                    {{ $language->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label id="default-currency" class="col-sm-3 control-label require"
                                        for="inputEmail3">{{ __('Default currency') }}</label>

                                    <div class="col-sm-7">
                                        <select class="form-control select-currency select2 sl_common_bx form-height"
                                            id="dflt_currency_id" name="dflt_currency_id">
                                            {{-- currency will be load here --}}
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row preview-parent" id="logo">
                                    <label class="col-sm-3 control-label " for="inputEmail3">{{ __('Logo') }}</label>
                                    <div class="col-sm-7">
                                        <div class="custom-file media-manager-img" data-val="single"
                                            data-returntype="ids" id="image-status"
                                            data-type="{{ implode(',', getFileExtensions(3)) }}">
                                            <input type="hidden"
                                                class="custom-file-input is-image form-control form-height"
                                                name="company_logo_id">
                                            <label
                                                class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                                                for="validatedCustomFile">{{ __('Upload image') }}</label>
                                        </div>
                                        <div class="preview-image">
                                            <!-- img will be shown here -->
                                            <div class="d-flex flex-wrap mt-2">
                                                <div class="position-relative border boder-1 p-1 mr-2 rounded mt-2">
                                                    <img width="80" class="p-1 neg-transition-scale" src="{{ $companyData['logo'] }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="py-1" id="note_txt_1">
                                            <div class="d-flex mt-1 mb-3">
                                                <span class="badge badge-danger h-100 mt-1">{{ __('Note') }}!</span>
                                                <ul class="list-unstyled ltr:ms-3 rtl:me-3">
                                                    <li>{{ __('Allowed File Extensions: :y and Maximum File Size :x', ['x' => preference('file_size') . 'MB.', 'y' => implode(',', getFileExtensions(3))]) }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row preview-parent" id="iconTop">
                                    <label class="col-sm-3 control-label " for="inputEmail3">{{ __('Favicon') }}</label>
                                    <div class="col-sm-7">
                                        <div class="custom-file media-manager-img" data-val="single"
                                            data-returntype="ids" id="image-status"
                                            data-type="{{ implode(',', getFileExtensions(4)) }}">
                                            <input type="hidden"
                                                class="custom-file-input is-image form-control form-height">
                                            <label
                                                class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                                                for="validatedCustomFile">{{ __('Upload image') }}</label>
                                        </div>
                                        <div class="preview-image" id="company_favicon">
                                            <!-- img will be shown here -->
                                            <div class="d-flex flex-wrap mt-2">
                                                <div class="position-relative border boder-1 p-1 mr-2 rounded mt-2">
                                                    <img width="80" class="old-img neg-transition-scale" class="p-1"
                                                        src="{{ $companyData['icon'] }}" alt="{{ __('Image') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="py-1" id="note_txt_1">
                                            <div class="d-flex mt-1 mb-3">
                                                <span class="badge badge-danger h-100 mt-1">{{ __('Note') }}!</span>
                                                <ul class="list-unstyled ltr:ms-3 rtl:me-3">
                                                    <li>{{ __('Allowed File Extensions: :y and Maximum File Size :x', ['x' => preference('file_size') . 'MB.', 'y' => implode(',', getFileExtensions(4))]) }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer p-0">
                                <div class="form-group row">
                                    <label for="btn_save" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left"
                                            id="footer-btn">
                                            {{ __('Save') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('mediamanager::image.modal_image')

@endsection

@section('js')
    {{-- Using local does not have the required file --}}
    <script>
        'use strict';
        let imageSize = '{{ preference('file_size') }}';
        let currencyId = '{{ preference('dflt_currency_id') }}';
        let currencyName = '{{ currency()->name }}';
        let oldCountry = "{!! isset($companyData['company']['company_country']) ? $companyData['company']['company_country'] : 'null' !!}";
        let oldState = "{!! isset($companyData['company']['company_state']) ? $companyData['company']['company_state'] : 'null' !!}";
        let oldCity = "{!! isset($companyData['company']['company_city']) ? $companyData['company']['company_city'] : 'null' !!}";
        let url = "{{ URL::to('/') }}";
    </script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/settings.min.js') }}"></script>
@endsection
