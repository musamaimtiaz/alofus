@extends('admin.layouts.app')
@section('page_title', __('Shipping'))

@section('css')
    <link rel="stylesheet" href="{{ asset('Modules/Shipping/Resources/assets/css/shipping.min.css') }}">
@endsection

@section('content')
    <div class="col-sm-12 list-container">
        <div class="card" id="shipping-container">
            <div class="card-body row">
                <div class="col-sm-3 ltr:ps-1 ltr:ps-md-3 ltr:pe-0 rtl:pe-1 rtl:pe-md-3 rtl:ps-0" aria-labelledby="navbarDropdown">
                    <div class="card card-info shadow-none">
                        <div class="card-header p-t-20 border-bottom mb-2">
                            <h5>{{ __('Shipping') }}</h5>
                        </div>
                        <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <li><a class="nav-link active text-left tab-name" id="v-pills-general-tab" data-bs-toggle="pill" href="#v-pills-general" role="tab" aria-controls="v-pills-general" aria-selected="true" data-id = "{{ __('Shipping Options') }}">{{ __('Options') }}</a></li>
                            <li><a class="nav-link text-left tab-name" id="v-pills-class-tab" data-bs-toggle="pill" href="#v-pills-class" role="tab" aria-controls="v-pills-class" aria-selected="true" data-id = "{{ __('Shipping Classes') }}">{{ __('Classes') }}</a></li>
                            <li><a class="nav-link text-left tab-name" id="v-pills-zone-tab" data-bs-toggle="pill" href="#v-pills-zone" role="tab" aria-controls="v-pills-zone" aria-selected="true" data-id = "{{ __('Shipping Zones') }}">{{ __('Zones') }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-9 ltr:ps-1 ltr:ps-md-0 rtl:pe-1 rtl:pe-md-0">
                    <div class="card card-info shadow-none mb-0">
                        <div class="card-header p-t-20 border-bottom">
                            <h5><span id="theme-title">{{ __('Shipping Options') }}</span></h5>
                            <div class="card-header-right d-inline-block ltr:end-0 ltr:ms-0 rtl:start-0 rtl:me-0 mt-2">
                                <a class="nav-link p-0 tab-name tab-help" id="v-pills-help-tab" data-bs-toggle="pill" href="#v-pills-help" role="tab" aria-controls="v-pills-help" aria-selected="true" data-id = "{{ __('Help') }}"><i class="fa fa-question-circle fa-2x" aria-hidden="true"></i></a>
                            </div>
                        </div>

                        <div class="tab-content p-0 shadow-none shipping-content" id="topNav-v-pills-tabConten">
                            {{-- Setting --}}
                            <div class="tab-pane fade parent shipping-setting-parent show active" id="v-pills-general" role="tabpanel" aria-labelledby="v-pills-general-tab">
                                @include('shipping::layout.shipping-setting')
                            </div>
                            {{-- Classes --}}
                            <div class="tab-pane fade parent shipping-classes-parent" id="v-pills-class" role="tabpanel" aria-labelledby="v-pills-class-tab">
                                @include('shipping::layout.shipping-classes')
                            </div>
                            {{-- Zones --}}
                            <div class="tab-pane fade parent shipping-zones-parent" id="v-pills-zone" role="tabpanel" aria-labelledby="v-pills-zone-tab">
                                @include('shipping::layout.shipping-zones')
                            </div>
                            {{-- Documentation --}}
                            <div class="tab-pane fade parent tax-setting-parent mt-25" id="v-pills-help" role="tabpanel" aria-labelledby="v-pills-help-tab">
                                @include('shipping::layout.help')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add new location --}}
    @include('shipping::layout.add-new-location')

    {{-- Add new zone --}}
    @include('shipping::layout.add-new-zone')

    {{-- Add new class --}}
    @include('shipping::layout.add-new-class')

    {{-- Delete modal --}}
    @include('admin.layouts.includes.delete-modal')

@endsection
@section('js')
    <script>
        var currencySymbol = "{!! preg_replace('/[0-9\.]+/', '', formatNumber('')) !!}"
    </script>
    <script src="{{ asset('public/dist/js/condition.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/xss.min.js') }}"></script>
    <script src="{{ asset('Modules/Shipping/Resources/assets/js/shipping.min.js') }}"></script>
@endsection
