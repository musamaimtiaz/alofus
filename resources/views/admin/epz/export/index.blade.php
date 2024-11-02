@extends('admin.layouts.app')

@section('page_title', __('Export'))

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
                                    <h4 class="text-muted f-w-600">{{ __('Export Products') }}</h4>
                                    <p>{{ __('Share your excellence with the world – export top-quality products effortlessly and make a global impact.') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="border-top px-3 import-button">
                            <a href="{{ route('epz.export.products') }}" class="d-flex justify-content-between align-items-center">
                                <p class="pt-3">{{ __('Proceed to Export') }}</p>
                                <i class="feather feather icon-arrow-right f-20 neg-transition-scale"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
