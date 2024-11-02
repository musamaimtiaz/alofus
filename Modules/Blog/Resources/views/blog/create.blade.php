@extends('admin.layouts.app')
@section('page_title', __('Blogs'))
@section('css')
    <link rel="stylesheet" href="{{ asset('Modules/Blog/Resources/assets/css/blog.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/summer-note/summernote-lite.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/MediaManager/Resources/assets/css/media-manager.min.css') }}">

@endsection
@section('content')
    <div class="col-sm-12" id="page-container">
        <div class="card">
            <div class="card-header">
                <h5><a href="{{ route('blog.index') }}">{{ __('Blog') }}</a> >> {{ __('Create') }}</h5>
            </div>
            <div class="card-body px-3" id="no_shadow_on_card">
                <div class="col-sm-12 m-t-20 form-tabs">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link font-bold active text-uppercase" id="home-tab" data-bs-toggle="tab" href="#home"
                                role="tab" aria-controls="home"
                                aria-selected="true">{{ __(':x Information', ['x' => __('Blog')]) }}</a>
                        </li>
                    </ul>
                    <div class="col-sm-12 tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <form action="{{ route('blog.store') }}" method="post" class="form-horizontal" id="blogForm"
                                enctype="multipart/form-data" onsubmit="return formValidation()" novalidate>
                                <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label for="first_name"
                                                class="col-sm-2 col-form-label require ltr:pe-0 rtl:ps-0">{{ __('Category') }}
                                            </label>
                                            <div class="col-sm-10">
                                                <select class="form-control sl_common_bx select2-hide-search" id="category_id" name="category_id">
                                                    <option value="">{{ __('Select One') }}</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ $category->id == old('category_id') ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="first_name"
                                                class="col-sm-2 col-form-label require ltr:pe-0 rtl:ps-0">{{ __('Title') }}
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="{{ __('Title') }}"
                                                    class="form-control inputFieldDesign" id="title" name="title"
                                                    value="{{ !empty(old('title')) ? old('title') : '' }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="first_name"
                                                class="col-sm-2 col-form-label require ltr:pe-0 rtl:ps-0">{{ __('Slug') }}
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control inputFieldDesign" id="slug"
                                                    name="slug" value="{{ !empty(old('slug')) ? old('slug') : '' }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 control-label">{{ __('Featured Image') }}</label>
                                            <div class="col-sm-10">
                                                <div class="custom-file has-media-manager has-thumbnail" data-val="single"
                                                    id="image-status">
                                                    <input class="form-control up-images attachment d-none" name="attachment"
                                                        id="validatedCustomFile" accept="image/*">
                                                    <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                                                        for="validatedCustomFile">{{ __('Upload image') }}</label>
                                                </div>
                                                <div class="d-flex" id="blog-image">
                                                    <!-- img will be shown here -->

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="description"
                                                class="col-sm-2 col-form-label require ltr:pe-0 rtl:ps-0">{{ __('Description') }}
                                            </label>
                                            <div class="col-sm-10">
                                                <textarea class="blog_message form-control" name="description" id="summernote">{{ old('description') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="description"
                                                class="col-sm-2 col-form-label require ltr:pe-0 rtl:ps-0">{{ __('Summary') }}
                                            </label>
                                            <div class="col-sm-10 editor">
                                                <textarea class="form-control" name="summary" id="summary">{{ old('summary') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row mt-1 mb-1">
                                            <label for="Status"
                                                class="col-md-2 col-3 col-form-label require">{{ __('Status') }}</label>
                                            <div class="col-md-10 col-9 s margin-top-6">
                                                <input type="hidden" name="status" value="Inactive">
                                                <div class="switch switch-bg d-inline m-r-10">
                                                    <input class="status" type="checkbox" value="Active" name="status"
                                                        id="is_private" checked>
                                                    <label for="is_private" class="cr"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="px-0 pt-4 pb-2">
                                    <a href="{{ route('blog.index') }}"
                                        class="btn all-cancel-btn custom-btn-cancel">{{ __('Cancel') }}</a>
                                    <button class="btn custom-btn-submit" id="btnSubmit">{{ __('Create') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @include('mediamanager::image.modal_image')

                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('public/datta-able/plugins/summer-note/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
    <script src="{{ asset('Modules/Blog/Resources/assets/js/blog.min.js') }}"></script>

@endsection
