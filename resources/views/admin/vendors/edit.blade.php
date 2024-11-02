@extends('admin.layouts.app')
@section('page_title', __('Edit :x', ['x' => __('Vendor')]))
@section('css')
    {{-- LightBox --}}
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/lightbox/css/lightbox.min.css') }}">
    {{-- Media manager --}}
    <link rel="stylesheet" href="{{ asset('Modules/MediaManager/Resources/assets/css/media-manager.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/intl-tel-input/intlTelInput.min.css') }}">
@endsection

@section('content')
    <!-- Main content -->
    <div class="col-sm-12" id="vendor-edit-container">
        <div class="card">
            <div class="card-header">
                <h5> <a href="{{ route('vendors.index') }}">{{ __('Vendors') }} </a>
                    >>{{ __('Edit :x', ['x' => __('Vendor')]) }}</h5>
            </div>
            <div class="card-block table-border-style">
                <div class="row form-tabs">
                    <form action="{{ route('vendors.update', $vendors->id) . '?shop=' . $shop_exist }}" method="post"
                        id="vandorEdit" class="form-horizontal col-sm-12" enctype="multipart/form-data">
                        @csrf
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link font-bold active text-uppercase">{{ __(':x Information', ['x' => __('Vendor')]) }}</a>
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
                                                    value="{{ $vendors->name }}" required maxlength="80"
                                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="email"
                                                class="col-sm-3 control-label require">{{ __('Email') }}</label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control inputFieldDesign" id="email"
                                                    name="email" value="{{ $vendors->email }}"
                                                    placeholder="{{ __('Email') }}" required maxlength="100"
                                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                                    data-type-mismatch="{{ __('Enter a valid :x.', ['x' => strtolower(__('Email'))]) }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="phone"
                                                class="col-sm-3 control-label require">{{ __('Phone') }}
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="{{ __('Phone') }}"
                                                    class="form-control phone-number inputFieldDesign" id="phone"
                                                    name="phone" value="{{ $vendors->phone }}" required maxlength="45"
                                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="formal_name"
                                                class="col-sm-3 control-label">{{ __('Formal Name') }}</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control inputFieldDesign" id="formal_name"
                                                    name="formal_name" placeholder="{{ __('Formal Name') }}"
                                                    maxlength="100" value="{{ $vendors->formal_name }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="alias"
                                                class="col-sm-3 control-label">{{ __('Website') }}</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control inputFieldDesign" id="website"
                                                    name="website" placeholder="{{ __('Website') }}" maxlength="255"
                                                    pattern="(http[s]?:\/\/)?(www\.)?([\.]?[a-z]+[a-zA-Z0-9\-]{1,})?[\.]?[a-z]+[a-zA-Z0-9\-]+\.[a-zA-Z]{2,5}([\.]?[a-zA-Z]{2,5})?"
                                                    data-pattern="{{ __('Enter a valid :x.', ['x' => __('URL')]) }}"
                                                    value="{{ $vendors->website }}">
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
                                                        value="{{ formatCurrencyAmount($vendors->sell_commissions) }}"
                                                        data-placement="top" max="100"
                                                        data-max="{{ __('The value not more than be :x', ['x' => 100]) }}">
                                                </div>
                                            </div>
                                        @endif

                                        <div class="form-group row">
                                            <label class="col-sm-3 control-label">{{ __('Description') }}</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" name="description" id="description">{{ $vendors->description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row conditional preview-parent">
                                            <label class="col-sm-3 control-label">{{ __('Logo') }}</label>
                                            <div class="col-sm-9">
                                                <div class="custom-file position-relative position-relative media-manager-img" data-val="single"
                                                    data-returntype="ids" id="image-status">
                                                    <input class="custom-file-input is-image form-control inputFieldDesign"
                                                        name="vendor_logo" value="{{ $vendors->vendor_logo }}">

                                                    <label class="custom-file-label overflow_hidden d-flex align-items-center"
                                                        for="validatedCustomFile">{{ __('Upload image') }}</label>
                                                </div>
                                                <div class="preview-image" id="#">
                                                    <!-- img will be shown here -->
                                                    <div class="d-flex flex-wrap mt-2">
                                                        <div class="position-relative border boder-1 p-1 ltr:me-2 rtl:ms-2 rounded mt-2">
                                                            <img class="upl-img p-1 neg-transition-scale"
                                                                src="{{ optional($vendors->logo)->fileUrl() ?? $vendors->fileUrl() }}">
                                                        </div>
                                                    </div>
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
                                        <div class="form-group row conditional preview-parent">
                                            <label class="col-sm-3 control-label">{{ __('Cover Photo') }}</label>
                                            <div class="col-sm-9">
                                                <div class="custom-file position-relative media-manager-img" data-val="single"
                                                    data-returntype="ids" id="image-status">
                                                    <input class="custom-file-input is-image form-control inputFieldDesign"
                                                        name="cover_photo" value={{ $vendors->cover_photo }}>

                                                    <label class="custom-file-label overflow_hidden d-flex align-items-center"
                                                        for="validatedCustomFile">{{ __('Upload image') }}</label>
                                                </div>
                                                <div class="preview-image" id="#">
                                                    <!-- img will be shown here -->
                                                    <div class="d-flex flex-wrap mt-2">
                                                        <div
                                                            class="position-relative border boder-1 p-1 mr-2 rounded mt-2">
                                                            <img class="upl-img p-1 neg-transition-scale"
                                                                src="{{ optional($vendors->cover)->fileUrl() ?? $vendors->fileUrl() }}">
                                                        </div>
                                                    </div>
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

                                        <div class="form-group row">
                                            <label for="Status"
                                                class="col-sm-3 control-label require">{{ __('Status') }}</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2-hide-search" name="status"
                                                    id="status">
                                                    <option value="Pending"
                                                        {{ $vendors->status == 'Pending' ? 'selected' : '' }}>
                                                        {{ __('Pending') }}</option>
                                                    <option value="Active"
                                                        {{ $vendors->status == 'Active' ? 'selected' : '' }}>
                                                        {{ __('Active') }}</option>
                                                    <option value="Inactive"
                                                        {{ $vendors->status == 'Inactive' ? 'selected' : '' }}>
                                                        {{ __('Inactive') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-10 px-0 mt-3 mt-md-0">
                                    <a href="{{ request('shop') ? route('shop.index') : route('vendors.index') }}"
                                        class="btn all-cancel-btn custom-btn-cancel">{{ __('Cancel') }}</a>
                                    <button class="btn custom-btn-submit" type="submit" id="btnSubmit">
                                        <i class="comment_spinner spinner fa fa-spinner fa-spin custom-btn-small display_none"></i>
                                        <span id="spinnerText">{{ __('Update') }}</span></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('mediamanager::image.modal_image')

@endsection

@section('js')
    <script type="text/javascript">
        "use strict";
        var vendor_id = '{{ isset($shops[0]->vendor_id) ? $shops[0]->vendor_id : null }}';
        const utilJs = "{{ asset('public/dist/js/intl-tel-input/utils.min.js') }}";
    </script>
    
    <script src="{{ asset('public/dist/js/intl-tel-input/intlTelInput.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/set-dial-code.min.js') }}"></script>
    
    <script src="{{ asset('public/dist/js/custom/vendors.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
@endsection
