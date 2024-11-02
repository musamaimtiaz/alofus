@extends('admin.layouts.app')
@section('page_title', __('Slide'))
@section('css')
    <link rel="stylesheet" href="{{ asset('Modules/MediaManager/Resources/assets/css/media-manager.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/lightbox/css/lightbox.min.css') }}">

    {{-- Color picker --}}
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/mini-color/css/jquery.minicolors.min.css') }}">
@endsection
@section('content')
    <div class="col-sm-12 list-container" id="slide-add-container">
        <div class="card">
            <div class="card-body">
                <div class="row mt-1" id="theme-container">
                    <div class="col-lg-3 ltr:pe-0 rtl:ps-0" aria-labelledby="navbarDropdown">
                        <div class="card card-info mx-auto-sm box-shadow-unset" id="nav">
                            <ul class="nav flex-column nav-pills p-0" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                <nav id="column_left">
                                    <div class="card-header pb-5 p-t-20 border-bottom mb-2">
                                        <h5><a href="javascript:void(0)" id="general-settings" class="text-black">{{ __('Add Slide') }}</a>
                                        </h5>
                                    </div>
                                    <ul class="nav nav-list flex-column mt-25 slider-nav">
                                        <li><a class="nav-link active text-left tab-name" id="v-pills-general-tab"
                                                data-bs-toggle="pill" href="#v-pills-image-and-button" role="tab"
                                                aria-controls="v-pills-image-and-button" aria-selected="true"
                                                data-id="{{ __('Image and Button') }}">{{ __('Image and Button') }}</a></li>
                                        <li><a class="nav-link text-left tab-name" id="v-pills-title-tab" data-bs-toggle="pill"
                                                href="#v-pills-title" role="tab" aria-controls="v-pills-title"
                                                aria-selected="true" data-id="Title">{{ __('Title') }}</a></li>
                                        <li><a class="nav-link text-left tab-name" id="v-pills-sub-title-tab"
                                                data-bs-toggle="pill" href="#v-pills-sub-title" role="tab"
                                                aria-controls="v-pills-sub-title" aria-selected="true"
                                                data-id="Sub Title">{{ __('Sub Title') }}</a></li>
                                        <li><a class="nav-link text-left tab-name" id="v-pills-description-tab"
                                                data-bs-toggle="pill" href="#v-pills-description" role="tab"
                                                aria-controls="v-pills-description" aria-selected="true"
                                                data-id="Description">{{ __('Description') }}</a></li>
                                    </ul>
                                </nav>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-9 ltr:ps-0 rtl:pe-0">
                        <div class="card box-shadow-unset">
                            <div class="card-body border-bottom p-0">
                                <ul class="d-flex flex-wrap ltr:ps-4 rtl:pe-4 mb-0">
                                    <a class="slide-create slide" href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="{{ __('Add slide') }}">
                                        <li class="list-unstyled m-2 active submitting"><span
                                                class="d-block add-slide "><i class="fa fa-plus fa-2x"></i></span></li>
                                        <div class="boxes d-none">
                                            <div class="box"></div>
                                            <div class="box"></div>
                                            <div class="box"></div>
                                            <div class="box"></div>
                                        </div>

                                    </a>
                                    @foreach ($slider->slides as $slide)
                                        <a href="#" class="slide-edit slide m-2" data-id="{{ $slide->id }}">
                                            <li class="list-unstyled"><img width="70" height="70" class="rounded object-cover neg-transition-scale"
                                                    src="{{ $slide->fileUrl() }}" alt="chat-user"></li>
                                            <div class="boxes d-none">
                                                <div class="box"></div>
                                                <div class="box"></div>
                                                <div class="box"></div>
                                                <div class="box"></div>
                                            </div>
                                            @if (in_array('Modules\CMS\Http\Controllers\SlideController@delete', $prms))
                                                <form method="post"
                                                    action="{{ route('slide.delete', ['id' => $slide->id]) }}"
                                                    id="delete-slide-{{ $slide->id }}" accept-charset="UTF-8"
                                                    class="display_inline">
                                                    @csrf
                                                    <span class="close-slide delete-button" data-bs-toggle="modal"
                                                        data-label="Delete" data-delete="slide" data-bs-target="#confirmDelete"
                                                        data-id="{{ $slide->id }}" title="{{ __('Delete slide') }}"
                                                        data-title="{{ __('Delete :x', ['x' => __('Slide')]) }}"
                                                        data-message="{{ __('Are you sure to delete this?') }}">
                                                        x
                                                    </span>
                                                </form>
                                            @endif
                                        </a>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div id="load-slide-data">
                            @include('cms::partials.add_slide')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Delete slide --}}
    @include('admin.layouts.includes.delete-modal')

    @include('mediamanager::image.modal_image')

@endsection
@section('js')
    <script src="{{ asset('public/dist/plugins/lightbox/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/condition.min.js') }}"></script>

    <!-- minicolors Js -->
    <script src="{{ asset('public/datta-able/plugins/mini-color/js/jquery.minicolors.min.js') }}"></script>

    <script src="{{ asset('Modules/CMS/Resources/assets/js/slider.min.js') }}"></script>
@endsection
