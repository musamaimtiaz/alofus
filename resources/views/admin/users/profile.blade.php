@extends('admin.layouts.app')
@section('page_title', __('User Profile'))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/lightbox/css/lightbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/MediaManager/Resources/assets/css/media-manager.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/intl-tel-input/intlTelInput.min.css') }}">
@endsection
@section('content')
    <div class="col-sm-12 user-profile-container" id="user-edit-container">
        <div class="card">
            <div class="card-header">
                <h5><a href="{{ route('users.index') }}">{{ __('Users') }}</a> >> {{ $user->name }} >>
                    {{ __('Profile') }}</h5>
            </div>
            <div class="card-body p-0" id="no_shadow_on_card">
                @include('admin.layouts.includes.admin_profile_menu')
                <div class="col-sm-12 m-t-20 form-tabs">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link font-bold active text-uppercase" id="user-info-tab" data-bs-toggle="tab"
                                href="#user-info" role="tab" aria-controls="user-info-tab"
                                aria-selected="true">{{ __(':x Information', ['x' => __('User')]) }}</a>
                        </li>
                        @if (in_array('App\Http\Controllers\UserController@updatePassword', $prms))
                            <li class="nav-item">
                                <a class="nav-link font-bold text-uppercase" id="password-tab" data-bs-toggle="tab"
                                    data-rel="{{ $user->id }}" href="#password" role="tab"
                                    aria-controls="password-tab" aria-selected="false">{{ __('Update Password') }}</a>
                            </li>
                        @endif
                    </ul>
                    <div class="col-sm-12 tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="user-info" role="tabpanel"
                            aria-labelledby="user-info-tab">
                            <form action='{{ route('users.updateProfile', ['id' => Auth::user()->id]) }}' method="post"
                                class="form-horizontal" id="userEdit" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group row">
                                            <label for="first_name"
                                                class="col-sm-2 col-form-label require pr-0">{{ __('Name') }}
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="{{ __('Name') }}"
                                                    class="form-control inputFieldDesign" id="name" name="name"
                                                    required minlength="3"
                                                    value="{{ !empty(old('name')) ? old('name') : $user->name }}"
                                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                                    data-min-length="{{ __(':x should contain at least :y characters.', ['x' => __('Name'), 'y' => 3]) }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email"
                                                class="col-sm-2 col-form-label require">{{ __('Email') }}</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control inputFieldDesign" id="email"
                                                    name="email"
                                                    value="{{ !empty(old('email')) ? old('email') : $user->email }}"
                                                    placeholder="{{ __('Email') }}" required
                                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                                    data-type-mismatch="{{ __('Enter a valid :x.', ['x' => strtolower(__('Email'))]) }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="phone" class="col-sm-2 col-form-label require">{{ __('Phone') }}</label>
                                            <div class="col-sm-10">
                                                <input type="phone" class="form-control inputFieldDesign" id="phone" name="phone" value="{{ !empty(old('phone')) ? old('phone') : $user->phone }}" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="role_id"
                                                class="col-sm-2 control-label">{{ __('Role') }}</label>
                                            <div class="col-sm-10">
                                                <select class="form-control select2-hide-search inputFieldDesign" disabled
                                                    name="role_ids[]" id="role_id">
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
                                                class="col-sm-2 col-form-label require">{{ __('Status') }}</label>
                                            <div class="col-sm-10">
                                                <select class="form-control select2-hide-search inputFieldDesign" disabled
                                                    name="status" id="status">
                                                    <option value="Pending"
                                                        {{ old('status', $user->status) == 'Pending' ? 'selected' : '' }}>
                                                        {{ __('Pending') }}</option>
                                                    <option value="Active"
                                                        {{ old('status', $user->status) == 'Active' ? 'selected' : '' }}>
                                                        {{ __('Active') }}</option>
                                                    <option value="Inactive"
                                                        {{ old('status', $user->status) == 'Inactive' ? 'selected' : '' }}>
                                                        {{ __('Inactive') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="designation"
                                                class="col-sm-2 col-form-label pr-0">{{ __('Designation') }}
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="{{ __('Designation') }}"
                                                    class="form-control inputFieldDesign" id="designation"
                                                    name="designation"
                                                    value="{{ !empty(old('designation')) ? old('designation') : $user->designation }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="description"
                                                class="col-sm-2 col-form-label pr-0">{{ __('Description') }}
                                            </label>
                                            <div class="col-sm-10 editor">
                                                <textarea class="form-control" name="description" id="description">{{ !empty(old('description')) ? old('description') : $user->description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="facebook"
                                                class="col-sm-2 col-form-label pr-0">{{ __('facebook') }}
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="url" placeholder="https://www.facebook.com"
                                                    class="form-control inputFieldDesign" id="facebook" name="facebook"
                                                    value="{{ !empty(old('facebook')) ? old('facebook') : $user->facebook }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="twitter"
                                                class="col-sm-2 col-form-label pr-0">{{ __('twitter') }}
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="url" placeholder="https://www.twitter.com"
                                                    class="form-control inputFieldDesign" id="twitter" name="twitter"
                                                    value="{{ !empty(old('twitter')) ? old('twitter') : $user->twitter }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="instagram"
                                                class="col-sm-2 col-form-label pr-0">{{ __('Instagram') }}
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="url" placeholder="https://www.instagram.com"
                                                    class="form-control inputFieldDesign" id="instagram" name="instagram"
                                                    value="{{ !empty(old('instagram')) ? old('instagram') : $user->instagram }}">
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label pr-0">{{ __('Picture') }}</label>
                                            <div class="col-sm-10">
                                                <div class="custom-file" data-val="single" id="image-status"
                                                    data-type='{{ implode(',', getFileExtensions(2)) }}'>
                                                    <input class="form-control up-images attachment d-none inputFieldDesign"
                                                        name="attachment" id="validatedCustomFile" accept="image/*">
                                                    <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                                                        for="validatedCustomFile">{{ __('Upload image') }}</label>
                                                </div>
                                                <div id="img-container">
                                                    <div class="d-flex flex-wrap mt-2">
                                                        <div
                                                            class="position-relative border boder-1 p-1 mr-2 rounded mt-2">
                                                            <div
                                                                class="position-absolute rounded-circle text-center img-remove-icon">
                                                                <i class="fa fa-times"></i>
                                                            </div>
                                                            <img class="upl-img neg-transition-scale" class="p-1"
                                                                src="{{ $user->fileUrl() }}" alt="{{ __('Image') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row" id="divNote">
                                            <label class="col-sm-2 control-label"></label>
                                            <div class="col-sm-10 mb-2" id='note_txt_1'>
                                                <span class="badge badge-danger">{{ __('Note') }}!</span>
                                                {{ __('Allowed File Extensions: jpg, png, gif, bmp') }}
                                            </div>
                                            <div class="col-md-9" id='note_txt_2'>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-10 px-0 m-l-5">
                                    <a href="{{ route('users.index') }}"
                                        class="btn custom-btn-cancel all-cancel-btn">{{ __('Cancel') }}</a>
                                    <button class="btn custom-btn-submit" type="submit"
                                        id="btnSubmit">{{ __('Update') }}</button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form action='{{ route('users.profilePassword', ['id' => $user->id]) }}'
                                        class="form-horizontal" id="password-form" method="POST">
                                        @csrf
                                        <div class="form-group row">
                                            <label for="password"
                                                class="col-sm-2 text-left col-form-label require">{{ __('Password') }}</label>
                                            <div class="col-sm-6">
                                                <input type="password" class="form-control inputFieldDesign"
                                                    id="password" name="password" placeholder="{{ __('Password') }}"
                                                    value="{{ old('password') }}" required minlength="5"
                                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                                    data-min-length="{{ __(':x should contain at least :y characters.', ['x' => __('Password'), 'y' => 5]) }}">
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

                                        <div class="form-group row">
                                            <label class="col-sm-2 control-label"></label>
                                            <div class="col-sm-10">
                                                <div class="checkbox checkbox-primary checkbox-fill d-inline">
                                                    <input type="checkbox" class="form-control inputFieldDesign"
                                                        name="send_mail" id="checkbox-p-fill-1">
                                                    <label for="checkbox-p-fill-1"
                                                        class="cr">{{ __('Send email to the user') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-10 px-0 m-l-5">
                                            <button class="btn custom-btn-submit all-cancel-btn" type="submit"
                                                id="btnSubmit1">{{ __('Save') }}</button>
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
    <script src="{{ asset('public/dist/plugins/lightbox/js/lightbox.min.js') }}"></script>

    <script type="text/javascript">
        "use strict";
        var user_id = '{{ $user->id }}';
        const utilJs = "{{ asset('public/dist/js/intl-tel-input/utils.min.js') }}";
    </script>
    
    <script src="{{ asset('public/dist/js/intl-tel-input/intlTelInput.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/set-dial-code.min.js') }}"></script>
    
    <script src="{{ asset('public/dist/js/custom/user.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
@endsection
