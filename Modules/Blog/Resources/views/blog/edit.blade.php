@extends('admin.layouts.app')
@section('page_title', __('Edit :x', ['x' => __('Blog')]))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/summer-note/summernote-lite.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/MediaManager/Resources/assets/css/media-manager.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/Blog/Resources/assets/css/blog.min.css') }}">
@endsection
@section('content')
    <div class="col-sm-12" id="page-container" data-val="edit">
        <div class="card">
            <div class="card-header">
                <h5><a href="{{ route('blog.index') }}">{{ __('Blog') }}</a> >> {{ __('Edit') }}</h5>
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
                    <form action='{{ route('blog.update', $blog->id) }}' method="post" class="form-horizontal"
                        id="blogForm" enctype="multipart/form-data">
                        <div class="col-sm-12 tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                                <input type="hidden" value="{{ $blog->id }}" name="id" id="token">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <div class="form-group row">
                                            <label for="first_name"
                                                class="col-sm-2 col-form-label require ltr:pe-0 rtl:ps-0">{{ __('Category') }}
                                            </label>
                                            <div class="col-sm-10">
                                                <select class="form-control sl_common_bx select2-hide-search"
                                                    id="category_id" name="category_id" required
                                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                                    <option value="">{{ __('Select One') }}</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ $category->id == $blog->category_id ? 'selected' : '' }}>
                                                            {{ $category->name }}</option>
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
                                                    required maxlength="191"
                                                    value="{{ !empty(old('title')) ? old('title') : $blog->title }}"
                                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                                <input type="hidden" class="form-control" id="slug" name="slug"
                                                    required maxlength="191"
                                                    value="{{ !empty(old('slug')) ? old('slug') : $blog->slug }}">
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
                                                    <div class="d-flex flex-wrap mt-2">
                                                        @if (!empty($blog->objectFile->file_id))
                                                            <div
                                                                class="position-relative border boder-1 p-1 ltr:me-2 rtl:ms-2 rounded mt-2">
                                                                <input type="hidden" name="file_id[]"
                                                                    value="{{ optional($blog->objectFile)->file_id }}">
                                                                <div
                                                                    class="position-absolute rounded-circle text-center img-remove-icon">
                                                                    <i class="fa fa-times"></i>
                                                                </div>

                                                                <img class="upl-img neg-transition-scale" class="p-1"
                                                                    src="{{ $blog->fileUrl() }}">
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="description"
                                                class="col-sm-2 col-form-label require ltr:pe-0 rtl:ps-0">{{ __('Description') }}
                                            </label>
                                            <div class="col-sm-10">
                                                <textarea class="blog_message form-control" name="description" id="summernote">{{ $blog->description }}</textarea>
                                                <label id="blog_messages-error" class="error"
                                                    for="blog_messages"></label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="description"
                                                class="col-sm-2 col-form-label require ltr:pe-0 rtl:ps-0">{{ __('Summary') }}
                                            </label>
                                            <div class="col-sm-10 editor">
                                                <textarea class="form-control" name="summary" required maxlength="191"> {{ $blog->summary }} </textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row mt-1 mb-1">
                                            <label for="Status"
                                                class="col-sm-2 col-3 col-form-label require">{{ __('Status') }}</label>
                                            <div class="col-sm-10 col-9 s margin-top-6">
                                                <input type="hidden" name="status" value="Inactive">
                                                <div class="switch switch-bg d-inline m-r-10">
                                                    <input class="status" type="checkbox" value="Active" name="status"
                                                        id="is_private" {{ $blog->status == 'Active' ? 'checked' : '' }}>
                                                    <label for="is_private" class="cr"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-4 pb-2">
                                <a href="{{ route('blog.index') }}"
                                    class="btn all-cancel-btn custom-btn-cancel">{{ __('Cancel') }}</a>
                                <button class="btn custom-btn-submit" type="submit"
                                    id="btnSubmit">{{ __('Update') }}</button>
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
    <script src="{{ asset('public/datta-able/plugins/summer-note/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
    <script src="{{ asset('Modules/Blog/Resources/assets/js/blog.min.js') }}"></script>
@endsection
