@extends('vendor.layouts.app')
@section('page_title', __('Vendor Profile'))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/lightbox/css/lightbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/MediaManager/Resources/assets/css/media-manager.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/intl-tel-input/intlTelInput.min.css') }}">
@endsection

@section('content')
    <!-- Main content -->
    <div class="col-sm-12" id="user-edit-container">
        <div class="card">
            <div class="card-header">
                <h5><a href="{{ url('vendor/dashboard') }}">{{ __('Dashboard') }}</a> >> {{ $user->name }} >> {{ __('Profile') }}</h5>
            </div>
            <div class="card-body px-4" id="no_shadow_on_card">
                @include('admin.layouts.includes.vendor_menu')
                <div class="col-sm-12 m-t-20 form-tabs">
                    <ul class="nav nav-tabs " id="myTab" role="tablist">
                        <li class="nav-item" id="kk">
                            <a class="nav-link active text-uppercase fragment-url font-bold" id="user-info-tab" data-bs-toggle="tab" href="#user-info" role="tab" aria-controls="user-info" aria-selected="true">{{ __(':x Information',['x' => __('User')]) }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-uppercase fragment-url font-bold" id="password-tab" data-bs-toggle="tab" data-rel="{{ $user->id }}" href="#password" role="tab" aria-controls="password" aria-selected="false">{{ __('Update Password') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-uppercase fragment-url font-bold" id="vendor-info-tab" data-bs-toggle="tab"
                                data-rel="{{ $user->id }}" href="#vendor-info" role="tab" aria-controls="vendor-info"
                                aria-selected="false">{{ __(':x Information',['x' => __('Vendor')]) }}</a>
                        </li>
                    </ul>
                    <div class="col-sm-12 tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="user-info" role="tabpanel" aria-labelledby="user-info-tab">
                            <form action='{{ route("user.update", ["id" => Auth::user()->id]) }}' method="post" class="form-horizontal" id="userEdit" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group row">
                                            <label for="first_name" class="col-sm-2 col-form-label require pr-0">
                                                {{ __('Name') }}
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="{{ __('Name') }}" class="form-control inputFieldDesign" id="name" name="name" required minlength="3" value="{{ !empty(old('name')) ? old('name') : $user->name }}" oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')" data-min-length="{{ __(':x should contain at least :y characters.', ['x' => __('Name'), 'y' => 3]) }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="email" class="col-sm-2 col-form-label require">{{ __('Email') }}</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control inputFieldDesign" id="email" name="email" value="{{ !empty(old('email')) ? old('email') : $user->email }}" placeholder="{{ __('Email') }}" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')" data-type-mismatch="{{ __('Enter a valid :x.', [ 'x' => strtolower(__('Email'))]) }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="phone" class="col-sm-2 col-form-label require">{{ __('Phone') }}</label>
                                            <div class="col-sm-10">
                                                <input type="phone" class="form-control inputFieldDesign" id="phone" name="phone" value="{{ !empty(old('phone')) ? old('phone') : $user->phone }}" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="role_id" class="col-sm-2 control-label">{{ __('Role') }}</label>
                                            <div class="col-sm-10">
                                                <select class="form-control select2" disabled name="role_ids[]" id="role_id">
                                                    @foreach ($roles as $key => $role)
                                                        <option value="{{ $role->id }}" {{ in_array($role->id, $roleIds) ? 'selected' : '' }}>{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="Status" class="col-sm-2 col-form-label require">{{ __('Status') }}</label>
                                            <div class="col-sm-10">
                                                <select class="form-control select2" disabled name="status" id="status">
                                                    <option value="Pending" {{ old('status', $user->status) == 'Pending' ? 'selected' : ''}}>{{ __('Pending') }}</option>
                                                    <option value="Active" {{ old('status', $user->status) == 'Active' ? 'selected' : ''}}>{{ __('Active') }}</option>
                                                    <option value="Inactive" {{ old('status', $user->status) == 'Inactive' ? 'selected' : ''}}>{{ __('Inactive') }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="designation"
                                                class="col-sm-2 col-form-label pr-0">{{ __('Designation') }}
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="{{ __('Designation') }}"
                                                    class="form-control inputFieldDesign" id="designation" name="designation"
                                                    value="{{ $user->designation }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="description"
                                                class="col-sm-2 col-form-label pr-0">{{ __('Description') }}
                                            </label>
                                            <div class="col-sm-10 editor">
                                                <textarea class="form-control" name="description" id="description">{{ $user->description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="facebook"
                                                class="col-sm-2 col-form-label pr-0">{{ __('facebook') }}
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="url" placeholder="https://www.facebook.com"
                                                    class="form-control inputFieldDesign" id="facebook" name="facebook"
                                                    value="{{ $user->facebook }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="twitter" class="col-sm-2 col-form-label pr-0">{{ __('twitter') }}
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="url" placeholder="https://www.twitter.com"
                                                    class="form-control inputFieldDesign" id="twitter" name="twitter"
                                                    value="{{ $user->twitter }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="instagram"
                                                class="col-sm-2 col-form-label pr-0">{{ __('Instagram') }}
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="url" placeholder="https://www.instagram.com"
                                                    class="form-control inputFieldDesign" id="instagram" name="instagram"
                                                    value="{{ $user->instagram }}">
                                            </div>
                                        </div>

                                        <div class="form-group row conditional preview-parent">
                                            <label class="col-sm-2 control-label">{{ __('Picture') }}</label>
                                            <div class="col-sm-10">
                                                <div class="custom-file position-relative media-manager-img" data-val="single" data-returntype="ids" id="image-status" data-type="{{ implode(',', getFileExtensions(2)) }}">
                                                    <input class="custom-file-input is-image form-control">
                                                    <label class="custom-file-label overflow_hidden"
                                                        for="validatedCustomFile">{{ __('Upload Image') }}</label>
                                                </div>
                                                <div class="preview-image" id="#">
                                                    <!-- img will be shown here -->
                                                    <div class="d-flex flex-wrap mt-2">
                                                        <div class="position-relative border boder-1 p-1 mr-2 rounded mt-2">
                                                            <img class="upl-img p-1 neg-transition-scale"
                                                                src="{{ $user->fileUrl() }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row" id="divNote">
                                            <label class="col-sm-2 control-label"></label>
                                            <div class="col-sm-10" id='note_txt_1'>
                                                <span class="badge badge-danger">{{ __('Note') }}!</span> {{ __('Allowed File Extensions: jpg, png, gif, bmp') }}
                                            </div>
                                            <div class="col-md-9" id='note_txt_2'>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-10 px-0 m-l-5">
                                    <a href="{{ route('vendor-dashboard') }}" class="btn custom-btn-cancel all-cancel-btn">{{ __('Cancel') }}</a>
                                    <button class="btn custom-btn-submit" type="submit" id="btnSubmit">{{ __('Update') }}</button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form action='{{ route("vendor.password", ["id" => Auth::user()->id]) }}' class="form-horizontal" id="password-form" method="POST">
                                        @csrf
                                        <div class="form-group row">
                                            <label for="password" class="col-sm-2 text-left col-form-label require">{{ __('Password') }}</label>
                                            <div class="col-sm-6">
                                                <input type="password" class="form-control inputFieldDesign" id="password" name="password"  placeholder="{{ __('Password') }}" value="{{ old('password') }}" required minlength="5" oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')" data-min-length="{{ __(':x should contain at least :y characters.', ['x' => __('Password'), 'y' => 5]) }}">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-1">
                                            <label for="password" class="col-sm-2 text-left col-form-label require">{{ __('Confirm Password') }}</label>
                                            <div class="col-sm-6">
                                                <input type="password" class="form-control inputFieldDesign" id="confirm_password" name="confirm_password"  placeholder="{{ __('Confirm Password') }}" value="{{ old('confirm_password') }}" required minlength="5" oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                            </div>
                                        </div>
                                        <div class="col-sm-10 px-0 m-l-5">
                                            <button class="btn custom-btn-submit" type="submit" id="btnSubmit1">{{ __('Save') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="vendor-info" role="tabpanel" aria-labelledby="vendor-info-tab">
                            <form action='{{ route("vendor.update", ["id" => $vendor->id]) }}' method="post" class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group row">
                                            <label for="first_name" class="col-sm-3 col-form-label require pr-0">{{ __('Name') }}</label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="{{ __('Name') }}" class="form-control inputFieldDesign" name="name" required minlength="3" value="{{ !empty(old('name')) ? old('name') : $vendor->name }}" oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')" data-min-length="{{ __(':x should contain at least :y characters.', ['x' => __('Name'), 'y' => 3]) }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="email" class="col-sm-3 col-form-label require">{{ __('Email') }}</label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control inputFieldDesign" name="email" value="{{ !empty(old('email')) ? old('email') : $vendor->email }}" placeholder="{{ __('Email') }}" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')" data-type-mismatch="{{ __('Enter a valid :x.', [ 'x' => strtolower(__('Email'))]) }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="phone" class="col-sm-3 col-form-label require">{{ __('Phone') }}</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control inputFieldDesign" name="phone" value="{{ !empty(old('phone')) ? old('phone') : $vendor->phone }}" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="phone" class="col-sm-3 col-form-label">{{ __('Commission') }}(%)</label>
                                            <div class="col-sm-9">
                                                <span class="form-control inputFieldDesign">{{ $vendor->sell_commissions }}</span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="Status" class="col-sm-3 col-form-label require">{{ __('Status') }}</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2" disabled name="status">
                                                    <option value="Pending" {{ old('status', $vendor->status) == 'Pending' ? 'selected' : ''}}>{{ __('Pending') }}</option>
                                                    <option value="Active" {{ old('status', $vendor->status) == 'Active' ? 'selected' : ''}}>{{ __('Active') }}</option>
                                                    <option value="Inactive" {{ old('status', $vendor->status) == 'Inactive' ? 'selected' : ''}}>{{ __('Inactive') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <input type="hidden" name="status" value="{{ $vendor->status }}">
                                        <div class="form-group row">
                                            <label class="col-sm-3 control-label">{{ __('Description') }}</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" name="description" id="v-description">{{ $vendor->description }}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row preview-parent">
                                            <label class="col-sm-3 control-label">{{ __('Logo') }}</label>
                                            <div class="col-sm-9">
                                                <div class="custom-file media-manager-img position-relative" data-val="single" data-returntype="ids" id="image-status">
                                                    <input class="custom-file-input is-image form-control" name="vendor_logo" value="{{ $vendor->vendor_logo }}">

                                                    <label class="custom-file-label overflow_hidden"
                                                        for="validatedCustomFile">{{ __('Upload Logo') }}</label>
                                                </div>

                                                <div class="preview-image" id="#">
                                                    <!-- img will be shown here -->
                                                    <div class="d-flex flex-wrap mt-2">
                                                        <div class="position-relative border boder-1 p-1 mr-2 rounded mt-2">
                                                            <img class="upl-img p-1 neg-transition-scale"
                                                                src="{{ optional($vendor->logo)->fileUrl() ?? $vendor->fileUrl() }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 control-label"></label>
                                            <div class="col-sm-9" id='note_txt_1'>
                                                <div class="d-flex">
                                                    <span class="badge badge-danger h-100 mt-1">{{ __('Note') }}!</span>
                                                    <ul>
                                                        <li>{{__('Allowed File Extensions: jpg, png, gif, bmp and Maximum File Size :x MB',['x' => preference('file_size')]) }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row conditional preview-parent">
                                            <label class="col-sm-3 control-label">{{ __('Cover Photo') }}</label>
                                            <div class="col-sm-9">
                                                <div class="custom-file media-manager-img position-relative" data-val="single" data-returntype="ids" id="image-status">
                                                    <input class="custom-file-input is-image form-control" name="cover_photo" >

                                                    <label class="custom-file-label overflow_hidden"
                                                        for="validatedCustomFile">{{ __('Upload Logo') }}</label>
                                                </div>
                                                <div class="preview-image" id="#">
                                                    <!-- img will be shown here -->
                                                    <div class="d-flex flex-wrap mt-2">
                                                        <div class="position-relative border boder-1 p-1 mr-2 rounded mt-2">
                                                            <img class="upl-img p-1 neg-transition-scale"
                                                                src="{{ optional($vendor->cover)->fileUrl() ?? $vendor->fileUrl() }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 control-label"></label>
                                            <div class="col-sm-9" id='note_txt_1'>
                                                <div class="d-flex">
                                                    <span class="badge badge-danger h-100 mt-1">{{ __('Note') }}!</span>
                                                    <ul>
                                                        <li>{{ __('Allowed File Extensions: jpg, png, gif, bmp and Maximum File Size :x MB',['x' => preference('file_size')]) }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-10 px-0 m-l-5">
                                    <a href="{{ route('vendor-dashboard') }}" class="btn custom-btn-cancel all-cancel-btn">{{ __('Cancel') }}</a>
                                    <button class="btn custom-btn-submit" type="submit">{{ __('Update') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('mediamanager::image.modal_image')
@endsection

@section('js')
    <script type="text/javascript">
        "use strict";
        var user_id = '{{ $user->id }}';
        const utilJs = "{{ asset('public/dist/js/intl-tel-input/utils.min.js') }}";
    </script>
    
    <script src="{{ asset('public/dist/js/intl-tel-input/intlTelInput.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/set-dial-code.min.js') }}"></script>

    <script src="{{ asset('public/dist/plugins/lightbox/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/user.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
@endsection
