@extends('admin.layouts.app')
@section('page_title', __('GeoLocale'))

@section('css')
    <link rel="stylesheet" href="{{ asset('Modules/Addons/Resources/assets/css/addon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/GeoLocale/Resources/assets/css/geolocale.min.css') }}">
@endsection

@section('content')
<!-- Main content -->
<div class="col-sm-12 list-container" id="geolocale-container">
    <div class="card">
        <div class="card-header">
            <h5>{{ __('GeoLocale') }}</h5>
        </div>

        <div class="card-body p-0 mx-md-5">
            <div class="card-block pt-2 px-2">
                <div class="row">
                    <div class="col-lg-4 col-12 table-auto">
                        <div class="header d-">
                            <h6 class="px-4 py-2 m-0 text-left text-dark font-weight-bold d-flex justify-content-between">
                                <span class="ltr:ms-3 rtl:me-3">{{ __('Countries') }}</span>
                                <span title="{{ __('Add Country') }}" data-bs-toggle="modal" data-bs-target="#add-country" class="ltr:me-3 rtl:ms-3 add-country cursor_pointer">
                                    <i class="fa fa-plus"></i>
                                </span>
                            </h6>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text rounded-0 text-secondary pt-3" id="basic-addon1"><i class="fas fa-search"></i></span>
                                </div>
                                <input type="text" class="p-2 rounded-0 form-control search-table" placeholder="{{ __('Search for names') }}..">
                            </div>

                        </div>
                        <div class="geolocale-table border-bottom">
                            <table id="countries" class="w-100">
                                <tbody class="countries-tb overflow-y-scroll">
                                    {{-- Countries data will be load here. --}}
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-lg-4 col-12 mt-3 mt-md-0 table-auto">
                        <div class="header">
                            <h6 class="px-4 py-2 m-0 text-left text-dark font-weight-bold d-flex justify-content-between">
                                <span class="ltr:ms-3 rtl:me-3">{{ __('States') }}</span>
                                <span title="{{ __('Add State') }}" data-bs-toggle="modal" data-bs-target="#add-state" class="ltr:me-3 rtl:ms-3 add-state cursor_pointer">
                                    <i class="fa fa-plus"></i>
                                </span>
                            </h6>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text rounded-0 text-secondary pt-3" id="basic-addon"><i class="fas fa-search"></i></span>
                                </div>
                                <input type="text" class="p-2 rounded-0 form-control search-table" placeholder="{{ __('Search for names') }}..">
                            </div>

                        </div>
                        <div class="geolocale-table border-bottom">
                            <table id="states" class="w-100">
                                <tbody class="states-tb">
                                    <tr>
                                        <td class="search py-2 px-3 d-flex justify-content-between">
                                            <div>
                                                <span class="text-dark font-weight-bold">{{ __('Select a country') }}</span>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-lg-4 col-12 mt-3 mt-md-0 table-auto">
                        <div class="header">
                            <h6 class="px-4 py-2 m-0 text-left text-dark font-weight-bold d-flex justify-content-between">
                                <span class="ltr:ms-3 rtl:me-3">{{ __('Cities') }}</span>
                                <span title="{{ __('Add City') }}" data-bs-toggle="modal" data-bs-target="#add-city" class="ltr:me-3 rtl:ms-3 add-city cursor_pointer">
                                    <i class="fa fa-plus"></i>
                                </span>
                            </h6>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text rounded-0 text-secondary pt-3" id="basic-addon1"><i class="fas fa-search"></i></span>
                                </div>
                                <input type="text" class="p-2 rounded-0 form-control search-table" placeholder="{{ __('Search for names') }}..">
                            </div>
                        </div>
                        <div class="geolocale-table border-bottom">
                            <table id="cities" class="w-100">
                                <tbody class="cities-tb">
                                    <tr>
                                        <td class="search py-2 px-3 d-flex justify-content-between cursor-pointer">
                                            <div>
                                                <span class="text-dark font-weight-bold">{{ __('Select a state') }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('geolocale::includes.add-city')

        @include('geolocale::includes.edit-city')

        @include('geolocale::includes.add-state')

        @include('geolocale::includes.edit-state')

        @include('geolocale::includes.add-country')

        @include('geolocale::includes.edit-country')

        @include('admin.layouts.includes.delete-modal')
    </div>
</div>

@endsection

@section('js')
    <script src="{{ asset('Modules/GeoLocale/Resources/assets/js/geolocale.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
@endsection


