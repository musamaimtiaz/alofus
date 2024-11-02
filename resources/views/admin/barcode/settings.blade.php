@extends('admin.layouts.app')
@section('page_title', __('Barcode Setting'))

@section('css')
    <link rel="stylesheet" href="{{ asset('Modules/CMS/Resources/assets/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/product.min.css') }}">
@endsection

@section('content')
    <div class="col-sm-12">
        <div class="card admin-panel-product-setting" id="theme-container">
            <div class="row">
                <div class="col-lg-3 col-12 z-index-10"
                     aria-labelledby="navbarDropdown">
                    <div class="card card-info shadow-none">
                        <div class="card-header p-t-20 border-bottom mb-2">
                            <h5>{{ __('Product Setting') }}</h5>
                        </div>
                        <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <li><a class="nav-link active text-left tab-name" id="v-pills-general-tab" data-bs-toggle="pill"
                                   href="#v-pills-general" role="tab" aria-controls="v-pills-general"
                                   aria-selected="true" data-id={{ __('General') }}>{{ __('General') }}</a></li>
                            <li><a class="nav-link text-left tab-name" id="v-pills-product-tab" data-bs-toggle="pill"
                                   href="#v-pills-product" role="tab" aria-controls="v-pills-product"
                                   aria-selected="true" data-id={{ __('Products') }}>{{ __('Products') }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9 col-12">
                    <div class="card card-info shadow-none mb-0">
                        <div class="card-header p-t-20 border-bottom">
                            <h5 id="theme-title">{{ __('Products') }}</h5>
                        </div>

                        <div class="tab-content" id="topNav-v-pills-tabContent">
                            {{-- setting --}}
                            <div class="tab-pane fade parent show active" id="v-pills-general" role="tabpanel"
                                 aria-labelledby="v-pills-settings-tab">
                                <div class="noti-alert pad no-print warningMessage mt-2">
                                    <div class="alert warning-message abc">
                                        <strong id="warning-msg" class="msg"></strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <form action="{{ route('barcode.settings') }}" method="post" class="form-horizontal product_setting_form">
                                            @csrf
                                            <input type="hidden" name="type" value="barcode">
                                            <div class="card-body border-bottom table-border-style p-0">
                                                <div class="form-tabs">
                                                    <div class="tab-content box-shadow-unset px-0 py-2">
                                                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                                            <div class="form-group row">
                                                                <label for="taxes" class="col-3 control-label">{{ __('Show Text') }}</label>
                                                                <div class="col-9 d-flex">
                                                                    <div class="ltr:me-3 rtl:ms-3">
                                                                        <input type="hidden" name="barcode_text" value="0">
                                                                        <div class="switch switch-bg d-inline m-r-10">
                                                                            <input type="checkbox" name="barcode_text"
                                                                                   id="barcode_text" value="1"
                                                                                {{ preference('barcode_text', '') == 1 ? 'checked' : '' }}>
                                                                            <label for="barcode_text" class="cr"></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mt-2">
                                                                        <span>{{ __('This option will be allow to show barcode text.') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row mt-14">
                                                                <label class="col-3 control-label">{{ __('Type') }}</label>
                                                                <div class="col-7">
                                                                    <div class="checkbox checkbox-warning checkbox-fill d-block">
                                                                        <select class="form-control select2-hide-search" name="barcode_type" id="barcode_type">
                                                                            @foreach(barcodeData()['type'] as $type)
                                                                                <option value="{{ $type }}"{{ preference('barcode_type', '') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <label class="cr" for="barcode_type">{{ __('Generated barcode type.') }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row mt-14">
                                                                <label class="col-3 control-label">{{ __('Color') }}</label>
                                                                <div class="col-7">
                                                                    <div class="checkbox checkbox-warning checkbox-fill d-block">
                                                                        <select class="form-control select2-hide-search" name="barcode_color" id="barcode_color">
                                                                            @foreach(barcodeData()['color'] as $key => $color)
                                                                            <option value="{{ $color }}"{{ preference('barcode_color', '') == $color ? 'selected' : '' }}>{{ $key }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <label class="cr" for="barcode_type">{{ __('Generated barcode color.') }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="form-group row">
                                                                <label for="calculate_coupon"
                                                                       class="col-sm-3 control-label text-left">{{ __('Barcode Size') }}</label>
                                                                <div class="col-sm-4">
                                                                    <label for="barcode_width"
                                                                           class="control-label">{{ __('Width') }}</label>
                                                                    <input type="number" class="form-control form-height" name="barcode_width" id="barcode_width" min="0" value="{{ preference('barcode_width', '') }}">
                                                                </div>

                                                                <div class="col-sm-4">
                                                                    <label for="barcode_height"
                                                                           class="control-label">{{ __('Height') }}</label>
                                                                    <input type="number" class="form-control form-height" name="barcode_height" id="barcode_height" min="0" value="{{ preference('barcode_height', '') }}">
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer p-0">
                                                <div class="form-group row">
                                                    <label for="btn_save" class="col-sm-3 control-label"></label>
                                                    <div class="col-sm-12">
                                                        <button type="submit"
                                                                class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left save-button"
                                                                id="footer-btn">
                                                            <span
                                                                class="d-none product-spinner spinner-border spinner-border-sm text-secondary"
                                                                role="status"></span>
                                                            {{ __('Save') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- product --}}
                            <div class="tab-pane fade parent" id="v-pills-product" role="tabpanel"
                                 aria-labelledby="v-pills-general-tab">
                                <div class="noti-alert pad no-print warningMessage mt-2">
                                    <div class="alert warning-message abc">
                                        <strong id="warning-msg" class="msg"></strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <form action="{{ route('barcode.settings') }}" method="post"
                                              class="form-horizontal product_setting_form">
                                            @csrf
                                            <input type="hidden" name="type" value="product_barcode">
                                            <div class="card-body border-bottom table-border-style p-0">
                                                <div class="form-tabs">
                                                    <div class="tab-content box-shadow-unset px-0 py-2">
                                                        <div class="tab-pane fade show active" id="home"
                                                             role="tabpanel" aria-labelledby="home-tab">
                                                            <div class="form-group row mt-14">
                                                                <label class="col-3 control-label">{{ __('Link to') }}</label>
                                                                <div class="col-7">
                                                                    <div class="checkbox checkbox-warning checkbox-fill d-block">
                                                                        <select class="form-control select2-hide-search" name="link_to" id="link_to">
                                                                            <option value="code"{{ preference('link_to', '') == 'code' ? 'selected' : '' }}>{{ __('Code') }}</option>
                                                                            <option value="sku"{{ preference('link_to', '') == 'sku' ? 'selected' : '' }}>{{ __('SKU') }}</option>
                                                                            <option value="id"{{ preference('link_to', '') == 'id' ? 'selected' : '' }}>{{ __('Product Id') }}</option>
                                                                            <option value="name"{{ preference('link_to', '') == 'name' ? 'selected' : '' }}>{{ __('Product Name') }}</option>
                                                                        </select>
                                                                        <label class="cr" for="link_to">{{ __('This applies to which product property will be generated for barcode.') }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="taxes"
                                                                       class="col-3 control-label">{{ __('Product Name') }}</label>
                                                                <div class="col-9 d-flex">
                                                                    <div class="ltr:me-3 rtl:ms-3">
                                                                        <input type="hidden" name="show_product_name" value="0">
                                                                        <div class="switch switch-bg d-inline m-r-10">
                                                                            <input type="checkbox" name="show_product_name"
                                                                                   id="show_product_name" value="1"
                                                                                {{ preference('show_product_name', '') == 1 ? 'checked' : '' }}>
                                                                            <label for="show_product_name" class="cr"></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mt-2">
                                                                        <span>{{ __('Each barcode will show the product name if allowed.') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="taxes"
                                                                       class="col-3 control-label">{{ __('Vendor Name') }}</label>
                                                                <div class="col-9 d-flex">
                                                                    <div class="ltr:me-3 rtl:ms-3">
                                                                        <input type="hidden" name="show_vendor_name" value="0">
                                                                        <div class="switch switch-bg d-inline m-r-10">
                                                                            <input type="checkbox" name="show_vendor_name"
                                                                                   id="show_vendor_name" value="1"
                                                                                {{ preference('show_vendor_name', '') == 1 ? 'checked' : '' }}>
                                                                            <label for="show_vendor_name" class="cr"></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mt-2">
                                                                        <span>{{ __('Each barcode will show the vendor name if allowed.') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="taxes"
                                                                       class="col-3 control-label">{{ __('Product Image') }}</label>
                                                                <div class="col-9 d-flex">
                                                                    <div class="ltr:me-3 rtl:ms-3">
                                                                        <input type="hidden" name="show_product_image" value="0">
                                                                        <div class="switch switch-bg d-inline m-r-10">
                                                                            <input type="checkbox" name="show_product_image"
                                                                                   id="show_product_image" value="1"
                                                                                {{ preference('show_product_image', '') == 1 ? 'checked' : '' }}>
                                                                            <label for="show_product_image" class="cr"></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mt-2">
                                                                        <span>{{ __('Each barcode will show the product image if allowed.') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer p-0">
                                                <div class="form-group row">
                                                    <label for="btn_save" class="col-sm-3 control-label"></label>
                                                    <div class="col-sm-12">
                                                        <button type="submit"
                                                                class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left save-button"
                                                                id="footer-btn">
                                                            <span
                                                                class="d-none product-spinner spinner-border spinner-border-sm text-secondary"
                                                                role="status"></span>
                                                            {{ __('Save') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/condition.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/product-setting.min.js') }}"></script>
@endsection
