@extends('admin.layouts.app')
@section('page_title', __('Edit :x', ['x' => __('User')]))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/lightbox/css/lightbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/MediaManager/Resources/assets/css/media-manager.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/user-list.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/intl-tel-input/intlTelInput.min.css') }}">
@endsection
@section('content')
    <div class="col-sm-12" id="user-edit-container">
        <div class="card">
            <div class="card-header">
                <h5><a href="{{ route('users.index') }}">{{ __('Users') }}</a> >> {{ $user->name }} >>
                    {{ __('Profile') }}</h5>
            </div>
            <div class="card-body p-0" id="no_shadow_on_card">
                @include('admin.layouts.includes.user_menu')
                <div class="col-sm-12 form-tabs px-3">
                    <ul class="nav nav-tabs " id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active text-uppercase font-bold" id="home-tab" data-bs-toggle="tab" href="#home"
                                role="tab" aria-controls="home"
                                aria-selected="true">{{ __(':x Information', ['x' => __('User')]) }}</a>
                        </li>
                        @if (in_array('App\Http\Controllers\UserController@updatePassword', $prms))
                            <li class="nav-item">
                                <a class="nav-link text-uppercase font-bold" id="profile-tab" data-bs-toggle="tab"
                                    data-rel="{{ $user->id }}" href="#profile" role="tab" aria-controls="profile"
                                    aria-selected="false">{{ __('Update Password') }}</a>
                            </li>
                        @endif
                    </ul>

                    <div class="col-md-12 tab-content form-edit-con" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <form action='{{ route('users.update', ['id' => $user->id]) }}' method="post"
                                class="form-horizontal" id="userEdit" enctype="multipart/form-data">
                                <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                                <div class="row">
                                    <div class="col-md-3 col-xl-2 mt-2 px-3">
                                        <div class="form-group">
                                            <div class="col-md-9 px-3">
                                                <div class="fixSize user-img-con">
                                                    <a class="cursor_pointer" href='{{ $user->fileUrl() }}'
                                                        data-lightbox="image-1"> <img
                                                            class="profile-user-img img-responsive fixSize rounded-circle neg-transition-scale"
                                                            src='{{ $user->fileUrl() }}' alt="{{ __('Image') }}"
                                                            class="img-thumbnail attachment-styles"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-8 px-3 form-container">
                                        <div class="form-group row">
                                            <label for="first_name" class="col-form-label require ltr:ps-3 rtl:pe-3">{{ __('Name') }}
                                            </label>
                                            <div class="col-sm-12 px-3">
                                                <input type="text" placeholder="{{ __('Name') }}"
                                                    class="form-control form-width inputFieldDesign" id="name"
                                                    name="name" required minlength="3"
                                                    value="{{ !empty(old('name')) ? old('name') : $user->name }}"
                                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                                    data-min-length="{{ __(':x should contain at least :y characters.', ['x' => __('Name'), 'y' => 3]) }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="email"
                                                class="col-form-label require ltr:ps-3 rtl:pe-3">{{ __('Email') }}</label>
                                            <div class="col-sm-12 px-3">
                                                <input type="email" class="form-control form-width inputFieldDesign"
                                                    id="email" name="email"
                                                    value="{{ !empty(old('email')) ? old('email') : $user->email }}"
                                                    placeholder="{{ __('Email') }}" required
                                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                                    data-type-mismatch="{{ __('Enter a valid :x.', ['x' => strtolower(__('Email'))]) }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="phone" class="col-form-label require ltr:ps-3 rtl:pe-3">{{ __('Phone') }}</label>
                                            <div class="col-sm-12 px-3">
                                                <input type="phone" class="form-control form-width inputFieldDesign" id="phone" name="phone" value="{{ !empty(old('phone')) ? old('phone') : $user->phone }}" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="role_id"
                                                class="control-label require ltr:ps-3 rtl:pe-3">{{ __('Role') }}</label>
                                            <div class="col-sm-12">
                                                <select class="form-control select2-hide-search inputFieldDesign"
                                                    {{ auth()->user()->id == $user->id ? 'disabled' : '' }}
                                                    name="role_ids[]"
                                                    id="role_id">
                                                    @foreach ($roles as $key => $role)
                                                        <option value="{{ $role->id }}"
                                                            {{ in_array($role->id, $roleIds) ? 'selected' : '' }}>
                                                            {{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="Status"
                                                class="col-form-label require ltr:ps-3 rtl:pe-3">{{ __('Status') }}</label>
                                            <div class="col-sm-12">
                                                <select class="form-control select2-hide-search inputFieldDesign"
                                                    {{ auth()->user()->id == $user->id ? 'disabled' : '' }}
                                                    name="status"
                                                    id="status">
                                                    <option value="Pending"
                                                        {{ old('status', $user->status) == 'Pending' ? 'selected' : '' }}>
                                                        {{ __('Pending') }}</option>
                                                    <option value="Active"
                                                        {{ old('status', $user->status) == 'Active' ? 'selected' : '' }}>
                                                        {{ __('Active') }}</option>
                                                    <option value="Inactive"
                                                        {{ old('status', $user->status) == 'Inactive' ? 'selected' : '' }}>
                                                        {{ __('Inactive') }}</option>
                                                    <option value="Deleted"
                                                        {{ old('status', $user->status) == 'Deleted' ? 'selected' : '' }}>
                                                        {{ __('Deleted') }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="designation"
                                                class="col-form-label ltr:ps-3 rtl:pe-3">{{ __('Designation') }}</label>
                                            <div class="col-sm-12">
                                                <input type="text" placeholder="{{ __('Designation') }}"
                                                    class="form-control form-width inputFieldDesign" id="designation"
                                                    name="designation" value="{{ $user->designation }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="description"
                                                class="col-form-label ltr:ps-3 rtl:pe-3">{{ __('Description') }}</label>
                                            <div class="col-sm-12">
                                                <textarea type="text" placeholder="{{ __('Description') }}" class="form-control form-width" id="description"
                                                    name="description">{{ $user->description }}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="facebook"
                                                class="col-form-label ltr:ps-3 rtl:pe-3">{{ __('Facebook') }}</label>
                                            <div class="col-sm-12">
                                                <input type="text" placeholder="{{ __('Facebook') }}"
                                                    class="form-control form-width inputFieldDesign" id="facebook"
                                                    name="facebook" value="{{ $user->facebook }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="twitter" class="col-form-label ltr:ps-3 rtl:pe-3">{{ __('Twitter') }}</label>
                                            <div class="col-sm-12">
                                                <input type="text" placeholder="{{ __('Twitter') }}"
                                                    class="form-control form-width inputFieldDesign" id="twitter"
                                                    name="twitter" value="{{ $user->twitter }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="instagram"
                                                class="col-form-label ltr:ps-3 rtl:pe-3">{{ __('Instagram') }}</label>
                                            <div class="col-sm-12">
                                                <input type="text" placeholder="{{ __('Instagram') }}"
                                                    class="form-control form-width inputFieldDesign" id="instagram"
                                                    name="instagram" value="{{ $user->instagram }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="control-label ltr:ps-3 rtl:pe-3">{{ __('Picture') }}</label>
                                            <div class="col-sm-12">
                                                <div class="custom-file position-relative" data-val="single"
                                                    id="image-status">
                                                    <input class="form-control up-images attachment d-none" name="attachment"
                                                        id="validatedCustomFile" accept="image/*">
                                                    <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                                                        for="validatedCustomFile">{{ __('Upload image') }}</label>
                                                </div>
                                                <div id="img-container">
                                                    <div class="d-flex flex-wrap mt-2">
                                                        <div
                                                            class="position-relative border boder-1 p-1  ltr:me-2 rtl:ms-2 rounded mt-2">
                                                            <div
                                                                class="position-absolute rounded-circle text-center img-remove-icon">
                                                                <i class="fa fa-times"></i>
                                                            </div>
                                                            <img class="upl-img object-fit-contain neg-transition-scale" class="p-1"
                                                                src="{{ $user->fileUrl() }}" alt="{{ __('Image') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row px-0">
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-9 btn-con">
                                        <a href="{{ route('users.index') }}"
                                            class="btn custom-btn-cancel all-cancel-btn">{{ __('Cancel') }}</a>
                                        <button class="btn custom-btn-submit" type="submit"
                                            id="btnSubmit">{{ __('Update') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form action='{{ route('users.password', ['id' => $user->id]) }}'
                                        class="form-horizontal from-class-id" id="password-form" method="POST"
                                        onsubmit="return passwordValidation()">
                                        <input type="hidden" value="{{ csrf_token() }}" name="_token"
                                            id="token2">
                                        <div class="form-group row">
                                            <label for="password"
                                                class="col-sm-2 text-left col-form-label require">{{ __('Password') }}</label>
                                            <div class="col-sm-6">
                                                <input type="password"
                                                    class="form-control password-validation inputFieldDesign"
                                                    id="password" name="password" placeholder="{{ __('Password') }}"
                                                    value="{{ old('password') }}" required minlength="5"
                                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                                    data-min-length="{{ __(':x should contain at least :y characters.', ['x' => __('Password'), 'y' => 5]) }}">
                                                <div class="password-validation-error mt-1"></div>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-1">
                                            <label for="password"
                                                class="col-sm-2 text-left col-form-label require">{{ __('Confirm Password') }}</label>
                                            <div class="col-sm-6">
                                                <input type="password" class="form-control inputFieldDesign"
                                                    id="confirm_password" name="confirm_password"
                                                    placeholder="{{ __('Confirm Password') }}"
                                                    value="{{ old('confirm_password') }}" required minlength="5"
                                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                            </div>
                                        </div>
                                        <div class="form-group row send-email-checkbox">
                                            <label class="col-sm-2 control-label"></label>
                                            <div class="col-sm-10">
                                                <div class="checkbox checkbox-warning checkbox-fill d-inline">
                                                    <input type="checkbox" class="form-control" name="send_mail"
                                                        id="checkbox-p-fill-1">
                                                    <label for="checkbox-p-fill-1"
                                                        class="cr">{{ __('Send email to the user') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-10 px-0 m-l-5 mt-3">
                                            <button class="btn custom-btn-submit admin-password-update" type="submit"
                                                id="btnSubmit1">{{ __('Update') }}</button>
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
    <script src="{{ asset('public/dist/plugins/lightbox/js/lightbox.min.js') }}"></script>

    <script type="text/javascript">
        "use strict";
        var user_id = '{{ $user->id }}';
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
    
    <script src="{{ asset('public/dist/js/custom/user.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
@endsection
