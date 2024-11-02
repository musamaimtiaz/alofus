@extends('admin.layouts.app')

@section('page_title', __('Export Products'))

@push('styles')
    <!-- select2 css -->
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/select2/css/select2.min.css') }}">
@endpush

@section('content')
    <div class="col-sm-12 list-container" id="item-list-container">
        <div class="card">
            <div class="card-header d-md-flex justify-content-between align-items-center">
                <h5>{{ __('Export Products') }}</h5>
            </div>

            <div class="card-body p-0 import-table">
                <div class="card-block px-2">
                    <div class="col-sm-8 col-12 mx-auto py-4 d-flex flex-column justify-content-center align-items-center row-striped">
                        <h4>{{ __('Export CSV File') }}</h4>
                        <form class="col-12" accept="{{ route('epz.export.products') }}" method="POST">
                            @csrf
                                <div class="col-sm-10">
                                    <div class="row mx-2 my-3">
                                        <div class="col-sm-5"><label class="control-label">{{ __('Which column should be exported?') }}</label></div>
                                        <div class="col-sm-5">
                                            <select class="filter" name="exported_column[]" id="exported_column" multiple>
                                                <option value="">{{ __('Export all columns') }}</option>
                                                @foreach ($columns as $key => $column)
                                                    <option value="{{ $column }}">{{ $column }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-10">
                                    <div class="row mx-2 my-3">
                                        <div class="col-sm-5"><label class="control-label">{{ __('Which product types should be exported?') }}</label></div>
                                        <div class="col-sm-5">
                                            <select class="filter" name="product_types[]" id="product_types" multiple>
                                                <option value="">{{ __('Export all products') }}</option>
                                                <option value="Simple Product">{{ __('Simple product') }}</option>
                                                <option value="Grouped Product">{{ __('Grouped product') }}</option>
                                                <option value="External/Affiliate Product">{{ __('External/Affiliate product') }}</option>
                                                <option value="Variable Product">{{ __('Variable product') }}</option>
                                                <option value="Variation">{{ __('Product variations') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <div class="col-sm-10" id="category_div">
                                <div class="row mx-2 my-3">
                                    <div class="col-sm-5"><label class="control-label">{{ __('Which product category should be exported?') }}</label></div>
                                    <div class="col-sm-5">
                                        <select class="filter" name="categories[]" id="categories" multiple>
                                            <option value="">{{ __('Export all categories') }}</option>
                                            @foreach ($productCategories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-10">
                                <div class="row mx-2 my-3">
                                    <div class="col-sm-5"><label class="control-label">{{ __('Which vendor product should be exported?') }}</label></div>
                                    <div class="col-sm-5">
                                        <select class="filter" name="vendors[]" id="vendors" multiple>
                                            <option value="">{{ __('Export all vendors') }}</option>
                                            @foreach ($productVendors as $vendor)
                                                @if(isset($vendor->vendor))
                                                  <option value="{{ $vendor->vendor_id }}">{{ $vendor->vendor->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-10">
                                <div class="row mx-2 my-3">
                                    <div class="col-sm-5"></div>
                                    <div class="col-sm-5">
                                        <button type="submit" class="btn btn-primary py-2 mt-3 me-0 float-right" id="export">{{ __('Export') }} <i class="feather icon-upload-cloud m-0 ms-2"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- select2 JS -->
    <script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/export.min.js') }}"></script>
@endsection
