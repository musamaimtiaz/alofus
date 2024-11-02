@extends('admin.layouts.app')
@section('page_title', __('Taxes'))

@section('css')
    <link rel="stylesheet" href="{{ asset('Modules/Tax/Resources/assets/css/tax.min.css') }}">
@endsection

@section('content')
    <div class="col-sm-12 list-container">
        <div class="card" id="tax-container">
            <div class="col-md-12 no-print notification-msg-bar smoothly-hide">
                <div class="noti-alert pad">
                    <div class="alert bg-dark text-light m-0 text-center">
                        <span class="notification-msg"></span>
                    </div>
                </div>
            </div>
            <div class="card-body row">
                <div class="col-md-3 col-12 z-index-10 ltr:ps-md-3 ltr:pe-0 ltr:ps-0 rtl:pe-md-3 rtl:ps-0 rtl:pe-0" aria-labelledby="navbarDropdown">
                    <div class="card card-info shadow-none">
                        <div class="card-header p-t-20 border-bottom mb-2">
                            <h5>{{ __('Taxes') }}</h5>
                        </div>
                        <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <li><a class="nav-link text-left tab-name active" id="v-pills-general-tab" data-bs-toggle="pill"
                                    href="#v-pills-general" role="tab" aria-controls="v-pills-general"
                                    aria-selected="true" data-id="{{ __('Options') }}">{{ __('Options') }}</a></li>
                            <li><a class="nav-link text-left tab-name" id="v-pills-standard-tab" data-bs-toggle="pill"
                                    href="#v-pills-standard" role="tab" aria-controls="v-pills-standard"
                                    aria-selected="true" data-id="{{ __('Standard Rates') }}">{{ __('Standard Rates') }}</a>
                            </li>
                            @foreach ($tax_classes as $tax)
                                <li><a class="nav-link text-left tab-name" id="v-pills-{{ $tax->slug }}-tab"
                                        data-bs-toggle="pill" href="#v-pills-{{ $tax->slug }}" role="tab"
                                        aria-controls="v-pills-standard" aria-selected="true"
                                        data-id="{{ $tax->name . ' ' . __('Rates') }}">{{ $tax->name . ' ' . __('Rates') }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-9 col-12 ltr:ps-0 rtl:pe-0">
                    <div class="card card-info shadow-none mb-0">
                        <div class="card-header p-t-20 border-bottom">
                            <h5><span id="theme-title">{{ __('Options') }}</span></h5>
                            <div class="card-header-right ml-0 d-inline-block right-0">
                                <a class="nav-link p-0 text-left tab-name tab-help active" id="v-pills-help-tab"
                                    data-bs-toggle="pill" href="#v-pills-help" role="tab" aria-controls="v-pills-help"
                                    aria-selected="true" data-id="{{ __('Help') }}"><i
                                        class="fa fa-question-circle fa-2x" aria-hidden="true"></i></a>
                            </div>
                        </div>

                        <div class="tab-content shadow-none tax-content" id="topNav-v-pills-tabContent">
                            @include('tax::layout.contents')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Rate data --}}
    @include('tax::layout.add-data')

    {{-- Add Tax Class --}}
    @include('tax::layout.add-tax-class')

    {{-- Edit Tax Class --}}
    @include('tax::layout.edit-tax-class')

    {{-- Delete modal --}}
    @include('admin.layouts.includes.delete-modal')

@endsection
@section('js')
    <script>
        var is_demo = "{{ config('martvill.is_demo') }}";
    </script>
    <script src="{{ asset('public/dist/js/condition.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/jquery.blockUI.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/geolocale-suggestion.min.js') }}"></script>
    <script src="{{ asset('Modules/Tax/Resources/assets/js/tax.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
@endsection
