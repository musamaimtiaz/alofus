<div class="row" id="invoice-setting-container">
    <div class="col-lg-3 col-12 z-index-10 ltr:ps-md-3 ltr:pe-0 ltr:ps-0 rtl:pe-md-3 rtl:ps-0 rtl:pe-0"
        aria-labelledby="navbarDropdown">
        <div class="card card-info shadow-none" id="nav">
            <ul class="nav flex-column nav-pills px-0" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <div class="card-header margin-top-neg-15 border-bottom">
                    <h5>{{ __('Invoice Pdf Settings') }}</h5>
                </div>
                <ul class="nav nav-list flex-column mr-30 mt-3 side-nav">
                    <li><a class="nav-link active text-left tab-name font-weight-normal" id="v-pills-social-share-tab"
                            data-bs-toggle="pill" href="#v-pills-social-share" role="tab"
                            aria-controls="v-pills-social-share" aria-selected="true"
                            data-id="{{ __('General') }}">{{ __('General') }}</a>
                    </li>
                    <li>
                        <a class="accordion-heading position-relative header font-weight-normal"
                            data-bs-toggle="collapse" data-bs-target="#submenu2">{{ __('Documents') }} <span
                                class="pull-right"><b class="caret"></b></span>
                            <span><i class="fa fa-angle-down position-absolute arrow-icon"></i></span>
                        </a>
                        <ul class="nav nav-list flex-column flex-nowrap collapse ml-2 vertical-class show side-nav"
                            id="submenu2">
                            <li><a class="nav-link text-left tab-name font-weight-normal" id="v-pills-topNav-tab"
                                    data-bs-toggle="pill" href="#v-pills-topNav" role="tab"
                                    aria-controls="v-pills-topNav" aria-selected="false"
                                    data-id="{{ __('Documents') }} >> {{ __('Header') }}">{{ __('Header') }}</a>
                            </li>
                            <li><a class="nav-link text-left tab-name font-weight-normal" id="v-pills-mainHeader-tab"
                                    data-bs-toggle="pill" href="#v-pills-mainHeader" role="tab"
                                    aria-controls="v-pills-mainHeader" aria-selected="false"
                                    data-id="{{ __('Documents') }} >> {{ __('Product table') }}">{{ __('Product table') }}</a>
                            </li>
                            <li><a class="nav-link text-left tab-name font-weight-normal" id="v-pills-deliveryDetails-tab"
                                    data-bs-toggle="pill" href="#v-pills-deliveryDetails" role="tab"
                                    aria-controls="v-pills-deliveryDetails" aria-selected="false"
                                    data-id="{{ __('Documents') }} >> {{ __('Delivery details') }}">{{ __('Delivery details') }}</a>
                            </li>
                            <li><a class="nav-link text-left tab-name font-weight-normal" id="v-pills-documentFooter-tab"
                                    data-bs-toggle="pill" href="#v-pills-documentFooter" role="tab"
                                    aria-controls="v-pills-documentFooter" aria-selected="false"
                                    data-id="{{ __('Documents') }} >> {{ __('Footer') }}">{{ __('Footer') }}</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </ul>
        </div>
    </div>
    <div class="col-md-9 col-12 ltr:ps-0 rtl:pe-0">
        <div class="card card-info shadow-none">
            <div class="card-header border-bottom">
                <h5><span id="theme-title"></span></h5>
                <div class="card-header-right d-flex">
                </div>
            </div>
            <div class="noti-alert message pad no-print" id="warning-message">
                <div class="alert abc warning-message">
                    <strong id="warning-msg"></strong>
                </div>
            </div>

            <div class="card-body px-0 px-md-3">
                <form method="post" action="{{ route('invoice.setting.option') }}" id="optionForm" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <div class="tab-content" id="topNav-v-pills-tabContent">

                        @include('admin.invoice_settings.partials.general.setting')

                        @include('admin.invoice_settings.partials.document.header')

                        @include('admin.invoice_settings.partials.document.product-table')

                        @include('admin.invoice_settings.partials.document.delivery-details')

                        @include('admin.invoice_settings.partials.document.footer')

                    </div>

                    <div class="modal-footer appearance py-0">
                        <div class="form-group row">
                            <label for="btn_save" class="col-sm-3 control-label"></label>
                            <div class="col-sm-12">
                                <button type="submit"
                                    class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left invoice-option-save-btn"
                                    id="footer-btn">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>




<!-- form-picker-custom Js -->
<script src="{{ asset('public/datta-able/js/pages/form-picker-custom.min.js') }}"></script>
