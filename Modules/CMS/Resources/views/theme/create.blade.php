@extends('admin.layouts.app')
@section('page_title', __('Appearance'))
@section('css')
    <link rel="stylesheet" href="{{ asset('Modules/CMS/Resources/assets/css/style.min.css') }}">
    <link href="{{ asset('Modules/CMS/Resources/assets/css/draganddrop.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('Modules/MediaManager/Resources/assets/css/media-manager.min.css') }}">

    {{-- Color picker --}}
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/mini-color/css/jquery.minicolors.min.css') }}">

@endsection
@section('content')
    <div class="col-sm-12 list-container mt-10">
        <div class="card">
            <div class="card-body" id="main-appearance">
                @include('cms::theme.appearance')
            </div>
        </div>
    </div>
    @include('mediamanager::image.modal_image')
    @include('cms::partials.themes.page.add-layout')
    @include('cms::partials.themes.page.edit-layout')

    {{-- Delete modal --}}
    @include('admin.layouts.includes.delete-modal')
@endsection
@section('js')
    <script>
        'use strict';
        var appearance_menu = "{{ session('appearanceMenu') }}";
    </script>

    <!-- minicolors Js -->
    <script src="{{ asset('public/datta-able/plugins/mini-color/js/jquery.minicolors.min.js') }}"></script>

    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/condition.min.js') }}"></script>
    <script src="{{ asset('Modules/CMS/Resources/assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/jquery.blockUI.min.js') }}"></script>
    <script src="{{ asset('Modules/CMS/Resources/assets/js/theme.min.js') }}"></script>
@endsection
