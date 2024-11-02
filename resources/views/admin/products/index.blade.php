@extends('admin.layouts.app')
@section('page_title', __('Products'))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/dist/css/product.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/summer-note/summernote-lite.min.css') }}">
@endsection
@section('content')
    <!-- Main content -->
    <div class="col-sm-12 list-container" id="item-list-container">
        <div class="card">
            <div class="card-header bb-none pb-0">
                <h5>{{ Route::current()->getName() == "product.pending" ? __('Pending Products') : __('Products') }}</h5>
                <x-backend.group-filters :groups="$groups" :column="'status'" />
                <div class="card-header-right my-2 mx-md-0 mx-sm-4">
                    <x-backend.button.batch-delete />
                    <x-backend.button.add-new href="{{ route('product.create') }}" />
                    <x-backend.button.filter />
                </div>
            </div>

            <x-backend.datatable.filter-panel>
                <div class="col-md-2">
                    <x-backend.datatable.input-search />
                </div>
                <div class="col-md-2">
                    <select class="select2 filter" name="brand">
                        <option value="">{{ __('All Brands') }}</option>
                        @foreach ($productBrands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="select2 filter" name="category">
                        <option value="">{{ __('All Categories') }}</option>
                        @foreach ($productCategories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="select2 filter" name="vendor">
                        <option value="">{{ __('All :x', ['x' => __('Vendors')]) }}</option>
                        @foreach ($vendors as $vendor)
                            @if (optional($vendor->vendor)->name)
                                <option value="{{ $vendor->vendor_id }}">{{ $vendor->vendor->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="select2-hide-search filter" name="stock">
                        <option value="">{{ __('All Stock Status') }}</option>
                        <option value="instock">{{ __('In Stock') }}</option>
                        <option value="backorder">{{ __('On Backorder') }}</option>
                        <option value="outofstock">{{ __('Out Of Stock') }}</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="select2-hide-search filter product_type" name="type">
                        <option value="">{{ __('All Products') }}</option>
                        <option value="{{ \App\Enums\ProductType::$Simple }}">{{ \App\Enums\ProductType::$Simple }}</option>
                        <option value="{{ \App\Enums\ProductType::$Variable }}">{{ \App\Enums\ProductType::$Variable }}</option>
                        <option value="{{ \App\Enums\ProductType::$Grouped }}">{{ \App\Enums\ProductType::$Grouped }}</option>
                        <option value="{{ \App\Enums\ProductType::$External }}">{{ \App\Enums\ProductType::$External }}</option>
                    </select>
                </div>
                <div class="col-md-2 margin-top-1p display_none sub_type">
                    <select class="select2-hide-search filter" name="sub_type">
                        <option value="">{{ __('All Types') }}</option>
                        <option value="meta_downloadable">{{ __('Downloadable') }}</option>
                        <option value="meta_virtual">{{ __('Virtual') }}</option>
                        @includeIf('b2b::admin.b2b-option')
                    </select>
                </div>
            </x-backend.datatable.filter-panel>

            <x-backend.datatable.table-wrapper class="product-table product-table-export-button need-batch-operation" data-namespace="\App\Models\Product" data-column="code">
                @include('admin.layouts.includes.yajra-data-table')
            </x-backend.datatable.table-wrapper>

            @include('admin.layouts.includes.delete-modal')
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('public/datta-able/plugins/summer-note/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/product_list.min.js') }}"></script>
@endsection
