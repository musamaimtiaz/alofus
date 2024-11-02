@extends('vendor.layouts.app')
@section('page_title', __('Edit :x', ['x' => __('Shop')]))
@section('css')
    {{-- Select2  --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('public/datta-able/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/MediaManager/Resources/assets/css/media-manager.min.css') }}">
@endsection

@section('content')
    <div class="col-sm-12" id="shop-edit-container">
        <div class="card">
            <div class="card-header">
                <h5><a href="{{ route('vendor.shop.index') }}">{{ __('Shops') }}</a> >>
                    {{ __('Edit :x', ['x' => __('Shop')]) }}</h5>
            </div>
            <div class="card-body table-border-style">
                <div class="form-tabs">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active text-uppercase">{{ __('Shop Information') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <form action="{{ route('vendor.shop.update', ['id' => $shop->id]) }}" method="post"
                                id="shopUpdate" class="form-horizontal">
                                @csrf

                                <div class="form-group row">
                                    <label class="col-sm-2 control-label require"
                                        for="name">{{ __('Shop Name') }}</label>
                                    <div class="col-sm-6">
                                        <input type="text" placeholder="{{ __('Shop Name') }}" class="form-control"
                                            id="name" name="name" required
                                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                            value="{{ !empty(old('name')) ? old('name') : $shop->name }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 control-label" for="vendor_id">{{ __('Vendor') }}</label>
                                    <div class="col-sm-6">
                                        <select class="form-control select2" disabled id="vendor_id" name="vendor_id">
                                            <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 control-label require"
                                        for="email">{{ __('Email') }}</label>
                                    <div class="col-sm-6">
                                        <input type="email" placeholder="{{ __('Email') }}" class="form-control"
                                            id="email" name="email" required
                                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                            data-type-mismatch="{{ __('Enter a valid :x.', ['x' => strtolower(__('Email'))]) }}"
                                            value="{{ !empty(old('email')) ? old('email') : $shop->email }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 control-label" for="website">{{ __('Website') }}</label>
                                    <div class="col-sm-6">
                                        <input type="text" placeholder="{{ __('Website') }}" class="form-control"
                                            id="website" name="website"
                                            pattern="(http[s]?:\/\/)?(www\.)?([\.]?[a-z]+[a-zA-Z0-9\-]{1,})?[\.]?[a-z]+[a-zA-Z0-9\-]+\.[a-zA-Z]{2,5}([\.]?[a-zA-Z]{2,5})?"
                                            data-pattern="{{ __('Enter a valid :x.', ['x' => __('URL')]) }}"
                                            value="{{ !empty(old('website')) ? old('website') : $shop->website }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="alias"
                                        class="col-sm-2 control-label require">{{ __('Alias') }}</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="alias" name="alias"
                                            placeholder="{{ __('Alias') }}"
                                            value="{{ isset($shop->alias) ? $shop->alias : '' }}" required maxlength="45"
                                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 control-label require"
                                        for="phone">{{ __('Phone') }}</label>
                                    <div class="col-sm-6">
                                        <input type="text" placeholder="{{ __('Phone') }}"
                                            class="form-control phone-number" id="phone" name="phone" required
                                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                            value="{{ !empty(old('phone')) ? old('phone') : $shop->phone }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 control-label" for="fax">{{ __('Fax') }}</label>
                                    <div class="col-sm-6">
                                        <input type="text" placeholder="{{ __('Fax') }}" class="form-control"
                                            id="fax" name="fax"
                                            value="{{ !empty(old('fax')) ? old('fax') : $shop->fax }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 control-label require"
                                        for="address">{{ __('Address') }}</label>
                                    <div class="col-sm-6">
                                        <textarea placeholder="{{ __('Address') }}" id="address" class="form-control" name="address" required
                                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">{{ !empty(old('address')) ? old('address') : $shop->address }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 control-label require"
                                        for="description">{{ __('Description') }}</label>
                                    <div class="col-sm-6">
                                        <textarea placeholder="{{ __('Description') }}" id="description" class="form-control" name="description" required
                                            maxlength="5000" oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">{{ !empty(old('description')) ? old('description') : $shop->description }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 control-label" for="status">{{ __('Status') }}</label>
                                    <div class="col-sm-6">
                                        <select class="form-control select2" id="status" name="status">
                                            <option value="Active"
                                                {{ old('status', $shop->status) == 'Active' ? 'selected' : '' }}>
                                                {{ __('Active') }}</option>
                                            <option value="Inactive"
                                                {{ old('status', $shop->status) == 'Inactive' ? 'selected' : '' }}>
                                                {{ __('Inactive') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2">{{ __('Cover Image') }}</label>
                                    <div class="col-sm-6">
                                        <div class="custom-file" data-val="single" id="image-status">
                                            <input class="form-control up-images attachment d-none" name="attachment"
                                                id="validatedCustomFile" accept="image/*">
                                            <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                                                for="validatedCustomFile">{{ __('Upload image') }}</label>
                                        </div>
                                        <div id="img-container">
                                            <div class="d-flex flex-wrap mt-2">
                                                <div class="position-relative border boder-1 p-1 ltr:me-2 rtl:ms-2 rounded mt-2">
                                                    <div
                                                        class="position-absolute rounded-circle text-center img-remove-icon">
                                                        <i class="fa fa-times"></i>
                                                    </div>
                                                    <img class="upl-img neg-transition-scale" class="p-1" src="{{ $shop->fileUrl() }}"
                                                        alt="{{ __('Image') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-8 px-0">
                                    <button class="btn btn-primary custom-btn-small" type="submit" id="submitBtn"><i
                                            class="comment_spinner spinner fa fa-spinner fa-spin custom-btn-small display_none"></i><span
                                            id="spinnerText">{{ __('Update') }}</span></button>
                                    <a href="{{ route('vendor.shop.index') }}"
                                        class="btn btn-info custom-btn-small">{{ __('Cancel') }}</a>
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
    <script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/shops.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
@endsection
