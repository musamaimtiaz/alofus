@extends('admin.layouts.app')
@section('page_title', __('Categories'))
@section('css')
    <!--custom css-->
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/jstree/jstree.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/MediaManager/Resources/assets/css/media-manager.min.css') }}">
@endsection
@section('content')
    <!-- Main content -->
    <div class="col-sm-12" id="category-info-container">
        <div class="card">
            <div class="card-header d-md-flex justify-content-between align-items-center">
                <h5> <a href="{{ route('categories.index') }}">{{ __('Categories') }} </a> </h5>
                <div class="d-md-flex justify-content-end align-items-center">
                    <div>
                        <button
                            class="btn btn-outline-primary mb-0 custom-btn-small root-category">{{ __('New :x', ['x' => __('Root Category')]) }}</button>
                    </div>
                    <div>
                        <button
                            class="btn btn-outline-primary mb-0 ltr:me-0 rtl:ms-0 custom-btn-small sub-category">{{ __('New :x', ['x' => __('Sub Category')]) }}</button>
                    </div>
                </div>
            </div>
            <div class="card-block table-border-style">
                <div class="row form-tabs" id="add-category">
                    <form action="{{ route('categories.store') }}" method="post" id="categoryFrom"
                        class="form-horizontal col-sm-12" enctype="multipart/form-data">
                        @csrf
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active text-uppercase fw-bold" id="home-tab" data-bs-toggle="tab"
                                    href="#home" role="tab" aria-controls="home"
                                    aria-selected="true">{{ __('Category Information') }}</a>
                            </li>
                        </ul>
                        <div class="col-sm-12 tab-content form-edit-con mt-5" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div id="evts" class="demo"></div>
                                    </div>
                                    <div class="col-sm-5" id="formBlock">
                                        <div class="form-group row">
                                            <label for="name" class="control-label require ltr:ps-3 rtl:pe-3">{{ __('Name') }}
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="text" placeholder="{{ __('Name') }}"
                                                    class="form-control form-width inputFieldDesign" id="name"
                                                    name="name" required minlength="3"
                                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                                    data-min-length="{{ __(':x should contain at least :y characters.', ['x' => __('Name'), 'y' => 3]) }}"
                                                    data-related="slug" value="{{ old('name') }}">
                                            </div>
                                        </div>
                                        <input type="hidden" name="type" id="type" value="store">
                                        @if (in_array('App\Http\Controllers\CategoryController@edit', $prms))
                                            <input type="hidden" name="edit_id" id="edit_id">
                                        @endif
                                        <div class="form-group row">
                                            <label for="slug" class="control-label require ltr:ps-3 rtl:pe-3">{{ __('Slug') }}
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="text" placeholder="{{ __('Slug') }}"
                                                    class="form-control form-width inputFieldDesign" id="slug"
                                                    name="slug" required pattern="^[a-zA-Z\-]*$"
                                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                                    data-pattern="{{ __('Only alphabet and white space are allowed.') }}"
                                                    value="{{ old('slug') }}">
                                            </div>
                                        </div>

                                        <div class="form-group row" id="parentBlock">
                                            <label for="parent_id"
                                                class="control-label ltr:ps-3 rtl:pe-3">{{ __('Parent Category') }}</label>
                                            <div class="col-sm-12">
                                                <select class="form-control select2 inputFieldDesign" name="parent_id"
                                                    id="parent_id">
                                                    <option value="">{{ __('Select One') }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="status" class="control-label ltr:ps-3 rtl:pe-3">{{ __('Status') }}</label>
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
                                            <label for="is_searchable"
                                                class="control-label ltr:ps-3 rtl:pe-3">{{ __('Is Searchable') }}</label>
                                            <div class="col-sm-12">
                                                <select class="form-control select2-hide-search inputFieldDesign"
                                                    name="is_searchable" id="is_searchable">
                                                    <option value=1>{{ __('Yes') }}</option>
                                                    <option value=0>{{ __('No') }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="is_features"
                                                class="control-label ltr:ps-3 rtl:pe-3">{{ __('Is Featured') }}</label>
                                            <div class="col-sm-12">
                                                <select class="form-control select2-hide-search inputFieldDesign"
                                                    name="is_featured" id="is_featured">
                                                    <option value=0>{{ __('No') }}</option>
                                                    <option value=1>{{ __('Yes') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        @if (!empty($commission) && $commission->is_category_based == 1)
                                            <div class="form-group row">
                                                <label for="sell_commissions"
                                                    class="control-label ltr:ps-3 rtl:pe-3">{{ __('Commission') }}(%)</label>
                                                <div class="col-sm-12">
                                                    <input type="text"
                                                        class="form-control positive-float-number form-width inputFieldDesign"
                                                        name="sell_commissions" id="sell_commissions">
                                                </div>
                                            </div>
                                        @endif
                                        <div class="form-group row">
                                            <label class="control-label ltr:ps-3 rtl:pe-3">{{ __('Upload Image') }}</label>
                                            <div class="col-sm-12">
                                                <div class="custom-file position-relative" data-val="single"
                                                    id="image-status">
                                                    <input class="custom-file-input form-control d-none inputFieldDesign"
                                                        name="attachments" id="validatedCustomFile" accept="image/*">
                                                    <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                                                        for="validatedCustomFile">{{ __('Upload Image') }}</label>
                                                </div>
                                            </div>
                                            <div class="ltr:ps-3 rtl:pe-3" id="img-container">
                                                <!-- img will be shown here -->
                                            </div>
                                        </div>

                                        <div class="form-group row" id="divNote">
                                            <label class="control-label"></label>
                                            <div class="col-sm-12" id='note_txt_1'>
                                                <span class="badge badge-danger">{{ __('Note') }}!</span>
                                                {{ __('Allowed File Extensions: jpg, jpeg, png') }}
                                            </div>
                                            <div class="col-md-8" id='note_txt_2'>
                                            </div>
                                        </div>
                                        <div class="d-flex p-0 mt-2">

                                            @if (in_array('App\Http\Controllers\CategoryController@destroy', $prms))
                                                <a href="javascript:void(0)"
                                                    class="btn custom-btn-cancel delete all-cancel-btn">{{ __('Delete') }}</a>
                                            @endif

                                            @if (array_intersect(
                                                ['App\Http\Controllers\CategoryController@store', 'App\Http\Controllers\CategoryController@update'],
                                                $prms))
                                                <button class="btn custom-btn-submit" type="submit" id="btnSubmit"><i
                                                        class="comment_spinner spinner fa fa-spinner fa-spin custom-btn-small display_none"></i><span
                                                        id="spinnerText">{{ __('Save') }}</span></button>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-3" id="imageBlock">
                                        <div class="form-group">
                                            <div class="col-sm-9">
                                                <div class="fixSize">
                                                    <a class="cursor_pointer" href="javascript:void(0)"
                                                        data-lightbox="image-1"> <img
                                                            class="profile-user-img img-responsive fixSize neg-transition-scale" src=''
                                                            alt="{{ __('Image') }}" class="img-thumbnail attachment-styles"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-10 px-0 m-l-5">

                                    </div>
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
    <script src="{{ asset('public/dist/plugins/jstree/jstree.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/sweetalert/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/common.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/category.min.js') }}"></script>
@endsection
