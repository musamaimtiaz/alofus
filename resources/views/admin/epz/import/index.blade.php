@extends('admin.layouts.app')

@section('page_title', __('Import'))

@section('content')
    <div class="col-sm-12 list-container" id="item-list-container">
        <div class="card-block px-2">
            <div class="col-sm-12 row p-0 m-0">
                <div class="col-md-6">
                    <div class="card">
                        <div class="table-card mx-2">
                            <div class="row-table">
                                <div class="col-auto py-5">
                                    <i class="feather icon-package fa-6x neg-transition-scale"></i>
                                </div>
                                <div class="col">
                                    <h4 class="text-muted f-w-600">{{ __('Import products') }}</h4>
                                    <p>{{ __('Transform your experience now! Click to proceed to import and enjoy a seamless blend of style and functionality.') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="border-top px-3 import-button">
                            <a href="{{ route('epz.import.products') }}" class="d-flex justify-content-between align-items-center">
                                <p class="pt-3">{{ __('Proceed to Import') }}</p>
                                <i class="feather feather icon-arrow-right f-20 neg-transition-scale"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="table-card">
                            <div class="row-table">
                                <div class="col-auto py-5">
                                    <i class="feather icon-user-plus fa-6x neg-transition-scale"></i>
                                </div>
                                <div class="col">
                                    <h4 class="text-muted f-w-600">{{ __('Import users') }}</h4>
                                    <p>{{ __('Effortlessly enhance your user experience by importing profiles. Proceed to Import to seamlessly integrate user data') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="border-top px-3 import-button">
                            <a href="{{ route('epz.import.users') }}" class="d-flex justify-content-between align-items-center">
                                <p class="pt-3">{{ __('Proceed to Import') }}</p>
                                <i class="feather feather icon-arrow-right f-20 neg-transition-scale"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @doAction('admin_add_import_data_card')
            </div>
        </div>
    </div>
@endsection
