@extends('admin.layouts.app')
@section('page_title', __('Create :x', ['x' => __('Brand')]))
@section('css')
    <!--custom css-->
    <link rel="stylesheet" href="{{ asset('Modules/MediaManager/Resources/assets/css/media-manager.min.css') }}">
@endsection
@section('content')
    <!-- Main content -->
    <div class="col-sm-12" id="brand-add-container">
        <div class="card">
            <div class="card-header">
                <h5> <a href="{{ route('brands.index') }}">{{ __('Brands') }} </a>
                    >>{{ __('Create :x', ['x' => __('Brand')]) }}</h5>
            </div>
            <div class="card-block table-border-style">
                <div class="row form-tabs">
                    <form action="{{ route('brands.store') }}" method="post" id="brandAdd" class="form-horizontal"
                        enctype="multipart/form-data">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active text-uppercase font-bold" id="home-tab" data-bs-toggle="tab"
                                    href="#home" role="tab" aria-controls="home"
                                    aria-selected="true">{{ __(':x Information', ['x' => __('Brand')]) }}</a>
                            </li>
                        </ul>
                        <div class="tab-content form-edit-con" id="myTabContent">
                            <div class="tab-pane fade show active form-con" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <div class="form-group row">
                                            <label for="name" class="control-label require ltr:ps-3 rtl:pe-3">{{ __('Name') }}
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="text" placeholder="{{ __('Name') }}"
                                                    class="form-control form-width inputFieldDesign" id="name"
                                                    name="name" value="{{ old('name') }}" required
                                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="description" class="control-label ltr:ps-3 rtl:pe-3">{{ __('Description') }}
                                            </label>
                                            <div class="col-sm-12">
                                                <textarea name="description" class="form-control form-width">{{ old('description') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="Status" class="control-label ltr:ps-3 rtl:pe-3">{{ __('Status') }}</label>
                                            <div class="col-sm-12">
                                                <select class="form-control select2-hide-search inputFieldDesign"
                                                    name="status" id="status">
                                                    <option value="Active"
                                                        {{ old('status') == 'Active' ? 'selected' : '' }}>
                                                        {{ __('Active') }}</option>
                                                    <option value="Inactive"
                                                        {{ old('status') == 'Inactive' ? 'selected' : '' }}>
                                                        {{ __('Inactive') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label ltr:ps-3 rtl:pe-3">{{ __('Upload Image') }}</label>
                                            <div class="col-sm-12">
                                                <div class="custom-file" data-val="single" id="image-status">
                                                    <input class="custom-file-input form-control d-none inputFieldDesign"
                                                        name="attachments" id="validatedCustomFile" accept="image/*">
                                                    <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                                                        for="validatedCustomFile">{{ __('Upload image') }}</label>
                                                </div>
                                            </div>
                                            <div id="img-container">
                                                <!-- img will be shown here -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-md-flex justify-content-start align-items-center mt-3 mt-md-0 ltr:ms-0 ltr:ms-md-5 rtl:me-0 rtl:me-md-5">
                                <a href="{{ route('brands.index') }}"
                                    class="custom-btn-cancel all-cancel-btn ltr:ms-0 ltr:ms-md-2 ltr:me-3 rtl:me-0 rtl:me-md-2 rtl:ms-3">{{ __('Cancel') }}</a>
                                <button class="btn custom-btn-submit mb-0 mt-3 mt-md-0" type="submit" id="btnSubmit"><i
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
@section('js')
    <script src="{{ asset('public/dist/js/custom/common.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/brand.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
@endsection
