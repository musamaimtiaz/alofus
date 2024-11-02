@extends('admin.layouts.app')
@section('page_title', __('Create :x', ['x' => __('Vendor')]))

@section('css')
    <link rel="stylesheet" href="{{ asset('Modules/MediaManager/Resources/assets/css/media-manager.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/intl-tel-input/intlTelInput.min.css') }}">
@endsection

@section('content')
    <!-- Main content -->
    <div class="col-sm-12" id="vendor-add-container">
        <div class="card">
            <div class="card-header">
                <h5> <a href="{{ route('vendors.index') }}">{{ __('Vendors') }} </a>
                    >>{{ __('Create :x', ['x' => __('Vendor')]) }}</h5>
            </div>
            <div class="card-block table-border-style">
                <div class="row form-tabs">
                    <form action="{{ route('vendors.store') }}" method="post" id="vandorAdd"
                        class="form-horizontal col-sm-12" enctype="multipart/form-data"
                        onsubmit="return passwordValidation()">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link font-bold active text-uppercase" id="home-tab" data-bs-toggle="tab" href="#home"
                                    role="tab" aria-controls="home"
                                    aria-selected="true">{{ __(':x Information', ['x' => __('Vendor')]) }}</a>
                            </li>
                        </ul>
                        <div class="col-sm-12 tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-3 control-label require">{{ __('Name') }}
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="{{ __('Name') }}"
                                                    class="form-control inputFieldDesign" id="name" name="name"
                                                    value="{{ old('name') }}" required maxlength="80"
                                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email"
                                                class="col-sm-3 control-label require">{{ __('Email') }}</label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control inputFieldDesign bg-white"
                                                    id="email" name="email" value="{{ old('email') }}"
                                                    placeholder="{{ __('Email') }}" required readonly
                                                    onfocus="this.removeAttribute('readonly');" maxlength="80"
                                                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                                    data-pattern="{{ __('Enter a valid :x.', ['x' => strtolower(__('Email'))]) }}"
                                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="password"
                                                class="col-sm-3 control-label require">{{ __('Password') }}</label>
                                            <div class="col-sm-9">
                                                <input type="password" placeholder="{{ __('Password') }}"
                                                    class="form-control password-validation inputFieldDesign" id="password"
                                                    name="password" required maxlength="190"
                                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                                <div class="password-validation-error mt-1"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="phone"
                                                class="col-sm-3 control-label require">{{ __('Phone') }}</label>
                                            <div class="col-sm-9">
                                                <input type="text"
                                                    class="form-control phone-number inputFieldDesign" id="phone"
                                                    name="phone" value="{{ old('phone') }}" required maxlength="15"
                                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="role_id"
                                                class="col-sm-3 control-label require">{{ __('Role') }}</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2-hide-search inputFieldDesign"
                                                    name="role_ids[]" id="role_id">
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}"
                                                            {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                                            {{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="formal_name"
                                                class="col-sm-3 control-label">{{ __('Formal Name') }}</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control inputFieldDesign"
                                                    id="formal_name" name="formal_name"
                                                    placeholder="{{ __('Formal Name') }}" maxlength="80"
                                                    value="{{ old('formal_name') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="alias"
                                                class="col-sm-3 control-label require">{{ __('Alias') }}</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control inputFieldDesign"
                                                    id="alias" name="alias" placeholder="{{ __('Alias') }}"
                                                    value="{{ old('alias') }}" required maxlength="45"
                                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                            </div>
                                        </div>
                                        <div class="form-group row" id="divNote">
                                            <label class="col-sm-3 control-label"></label>
                                            <div class="col-sm-9" id='note_txt_1'>
                                                <span class="badge badge-primary p-1">{{ __('Note') }}!</span>
                                                {{ __('It will be used as the subdomain of the default shop.') }}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="address"
                                                class="col-sm-3 control-label require">{{ __('Address') }}</label>
                                            <div class="col-sm-9">
                                                <textarea placeholder="{{ __('Address') }}" id="address" class="form-control" name="address" required
                                                    minlength="5" data-min-length="{{ __('Address should be atleast 5 characters.') }}" maxlength="191"
                                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">{{ old('address') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="alias"
                                                class="col-sm-3 control-label">{{ __('Website') }}</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control inputFieldDesign"
                                                    id="website" name="website" placeholder="{{ __('Website') }}"
                                                    maxlength="255"
                                                    pattern="(http[s]?:\/\/)?(www\.)?([\.]?[a-z]+[a-zA-Z0-9\-]{1,})?[\.]?[a-z]+[a-zA-Z0-9\-]+\.[a-zA-Z]{2,5}([\.]?[a-zA-Z]{2,5})?"
                                                    data-pattern="{{ __('Enter a valid :x.', ['x' => __('URL')]) }}"
                                                    value="{{ old('website') }}">
                                            </div>
                                        </div>
                                        @if (!empty($commission) && $commission->is_active == 1)
                                            <div class="form-group row">
                                                <label for="sell_commissions"
                                                    class="col-sm-3 control-label">{{ __('Commission') }}(%)</label>
                                                <div class="col-sm-9">
                                                    <input type="number"
                                                        class="form-control positive-float-number inputFieldDesign"
                                                        id="sell_commissions" name="sell_commissions"
                                                        value="{{ old('sell_commissions') }}" max="100"
                                                        data-max="{{ __('The value not more than be :x', ['x' => 100]) }}">
                                                </div>
                                            </div>
                                        @endif
                                        <div class="form-group row">
                                            <label for="Status"
                                                class="col-sm-3 control-label">{{ __('Description') }}</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" name="description" id="description"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row preview-parent">
                                            <label class="col-sm-3 control-label">{{ __('Logo') }}</label>
                                            <div class="col-sm-9">
                                                <div class="custom-file position-relative media-manager-img" data-val="single"
                                                    data-returntype="ids" id="image-status">
                                                    <input class="custom-file-input is-image form-control inputFieldDesign"
                                                        name="vendor_logo">
                                                    <label class="custom-file-label overflow_hidden d-flex align-items-center"
                                                        for="validatedCustomFile">{{ __('Upload image') }}</label>
                                                </div>
                                                <div class="preview-image" id="#">
                                                    <!-- img will be shown here -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row" id="divNote">
                                            <label class="col-sm-3 control-label"></label>
                                            <div class="col-sm-9" id='note_txt_1'>
                                                <div class="d-flex">
                                                    <span
                                                        class="badge badge-danger h-100 mt-1">{{ __('Note') }}!</span>
                                                    <ul>
                                                        <li>{{ __('Allowed File Extensions: jpg, png, gif, bmp and Maximum File Size :x MB', ['x' => preference('file_size')]) }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row preview-parent">
                                            <label class="col-sm-3 control-label">{{ __('Cover Photo') }}</label>
                                            <div class="col-sm-9">
                                                <div class="custom-file position-relative media-manager-img" data-val="single"
                                                    data-returntype="ids" id="image-status">
                                                    <input class="custom-file-input is-image form-control"
                                                        name="cover_photo">
                                                    <label class="custom-file-label overflow_hidden d-flex align-items-center"
                                                        for="validatedCustomFile">{{ __('Upload image') }}</label>
                                                </div>
                                                <div class="preview-image" id="#">
                                                    <!-- img will be shown here -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row" id="divNote">
                                            <label class="col-sm-3 control-label"></label>
                                            <div class="col-sm-9" id='note_txt_1'>
                                                <div class="d-flex">
                                                    <span class="badge badge-danger h-100 mt-1">{{ __('Note') }}!</span>
                                                    <ul>
                                                        <li>
                                                            {{ __('Allowed File Extensions: jpg, png, gif, bmp and Maximum File Size :x MB', ['x' => preference('file_size')]) }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="Status"
                                                class="col-sm-3 control-label require">{{ __('Status') }}</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2-hide-search inputFieldDesign"
                                                    name="status" id="status">
                                                    <option value="Pending"
                                                        {{ old('status') == 'Pending' || preference('vendor_default_signup_status') == 'Pending' ? 'selected' : '' }}>
                                                        {{ __('Pending') }}</option>
                                                    <option value="Active"
                                                        {{ old('status') == 'Active' || preference('vendor_default_signup_status') == 'Active' ? 'selected' : '' }}>
                                                        {{ __('Active') }}</option>
                                                    <option value="Inactive"
                                                        {{ old('status') == 'Inactive' || preference('vendor_default_signup_status') == 'Inactive' ? 'selected' : '' }}>
                                                        {{ __('Inactive') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row mt-3 ltr:ms-1 rtl:me-1">
                                            <label class="col-sm-3 control-label"></label>
                                            <div class="col-sm-9 px-0">
                                                <div class="checkbox checkbox-primary checkbox-fill d-inline">
                                                    <input type="checkbox" class="form-control" name="send_mail"
                                                        id="checkbox-p-fill-1">
                                                    <label for="checkbox-p-fill-1"
                                                        class="cr">{{ __('Send email to the user') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-10 px-0 mt-3 mt-md-0">
                                <a href="{{ route('vendors.index') }}"
                                    class="btn custom-btn-cancel all-cancel-btn">{{ __('Cancel') }}</a>
                                <button class="btn custom-btn-submit" type="submit" id="btnSubmit"><i
                                    class="comment_spinner spinner fa fa-spinner fa-spin custom-btn-small display_none"></i><span
                                    id="spinnerText">{{ __('Create') }}</span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('mediamanager::image.modal_image')
@endsection
@php
    $uppercase = $lowercase = $number = $symbol = $length = 0;
    if (env('PASSWORD_STRENGTH') != null && env('PASSWORD_STRENGTH') != '') {
        $length = filter_var(env('PASSWORD_STRENGTH'), FILTER_SANITIZE_NUMBER_INT);
        $conditions = explode('|', env('PASSWORD_STRENGTH'));
        $uppercase = in_array('UPPERCASE', $conditions);
        $lowercase = in_array('LOWERCASE', $conditions);
        $number = in_array('NUMBERS', $conditions);
        $symbol = in_array('SYMBOLS', $conditions);
    }
@endphp
@section('js')
    <script>
        'use strict';
        var uppercase = "{!! $uppercase !!}";
        var lowercase = "{!! $lowercase !!}";
        var number = "{!! $number !!}";
        var symbol = "{!! $symbol !!}";
        var length = "{!! $length !!}";
        var currentUrl = "{!! url()->full() !!}";
        var loginNeeded = "{!! session('loginRequired') ? 1 : 0 !!}";
        const utilJs = "{{ asset('public/dist/js/intl-tel-input/utils.min.js') }}";
    </script>
    
    <script src="{{ asset('public/dist/js/intl-tel-input/intlTelInput.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/set-dial-code.min.js') }}"></script>
    
    <script src="{{ asset('public/dist/js/custom/vendors.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
@endsection
