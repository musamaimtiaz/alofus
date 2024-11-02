<div class="mini-form-holder tab-pane fade {{ isset($product) && ($product->isGroupedProduct() || $product->isVariableProduct()) ? '' : 'show active' }} pb-3"
    id="tabs-a" role="tabpanel" aria-labelledby="tabs-one">
    <div
        class="border-bottom mx-2 pb-3 conditional-dom not-variable-dom not-simple-dom not-grouped-dom {{ isset($product) && $product->isExternalProduct() ? '' : 'd-none' }}">
        <div class="form-group row mt-5">
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-4 p-0-res">
                        <label class="sp-title">{{ __('Product URL') }}</label>
                    </div>
                    <div class="col-md-8 p-0-res">
                        <input type="text" placeholder="https://" class="form-control inputFieldDesign"
                            name="meta_external_product[url]"
                            value="{{ isset($product) && $product->meta_external_product ? $product->meta_external_product['url'] : '' }}">
                        <p class="mb-0 f-13 color-89 mt-2">{{ __('Enter the external URL to the product.') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row mt-4">
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-4 p-0-res">
                        <label class="sp-title">{{ __('Button text') }}</label>
                    </div>
                    <div class="col-md-8 p-0-res">
                        <input type="text" placeholder="{{ __('Buy Product') }}"
                            class="form-control inputFieldDesign" name="meta_external_product[text]"
                            value="{{ isset($product) && $product->meta_external_product ? $product->meta_external_product['text'] : '' }}">
                        <p class="mb-0 f-13 color-89 mt-2 w-space">
                            {{ __('This text will be shown on the button linking to the external product.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row px-2 mt-4 price_div">
        <div class="col-md-5 p-0-res">
            <div class="row">
                <div class="col-md-4">
                    <label for="price" class="sp-title control-label">{{ __('Regular Price') }}
                        ({{ \App\Models\Currency::getDefault()->symbol }})</label>
                </div>
                <div class="col-md-8">
                    <input type="number" placeholder="{{ __('Price') }}"
                        class="form-control inputFieldDesign regular_price" step="any" name="regular_price"
                        value="{{ isset($product) && $product->regular_price ? formatDecimal($product->regular_price) : '' }}">
                </div>
            </div>
        </div>
        <div class="col-md-7 p-0-res">
            <div class="row">
                <div class="col-md-3 mt-10-res">
                    <label for="price" class="sp-title control-label ml-5 mt-px">{{ __('Sale Price') }}
                        ({{ \App\Models\Currency::getDefault()->symbol }})</label>
                </div>
                <div class="col-md-6">
                    <input type="number" step="any" placeholder="{{ __('Sale Price') }}"
                        class="form-control sale_price inputFieldDesign" name="sale_price"
                        value="{{ isset($product) && $product->sale_price ? formatDecimal($product->sale_price) : '' }}">
                </div>
                <div class="col-md-3 d-flex align-items-center fold">
                    <span class="m-change fold_p" data-bs-toggle="collapse" href="#general-schedule"
                        aria-expanded="{{ isset($product) && $product->isScheduledSale() ? 'true' : 'false' }}"
                        aria-controls="general-schedule"><span
                            class="inner_text">{{ isset($product) && $product->isScheduledSale() ? __('Cancel') : __('Schedule') }}</span>
                    </span>
                    <div
                        class="tooltips cursor-pointer neg-transition-scale  ltr:ms-2 rtl:me-2">
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M12 6C12 9.31371 9.31371 12 6 12C2.68629 12 0 9.31371 0 6C0 2.68629 2.68629 0 6 0C9.31371 0 12 2.68629 12 6ZM6.66667 10C6.66667 10.3682 6.36819 10.6667 6 10.6667C5.63181 10.6667 5.33333 10.3682 5.33333 10C5.33333 9.63181 5.63181 9.33333 6 9.33333C6.36819 9.33333 6.66667 9.63181 6.66667 10ZM6 1.33333C4.52724 1.33333 3.33333 2.52724 3.33333 4H4.66667C4.66667 3.26362 5.26362 2.66667 6 2.66667H6.06287C6.76453 2.66667 7.33333 3.23547 7.33333 3.93713V4.27924C7.33333 4.62178 7.11414 4.92589 6.78918 5.03421C5.91976 5.32402 5.33333 6.13765 5.33333 7.05409V8.66667H6.66667V7.05409C6.66667 6.71155 6.88586 6.40744 7.21082 6.29912C8.08024 6.00932 8.66667 5.19569 8.66667 4.27924V3.93713C8.66667 2.49909 7.50091 1.33333 6.06287 1.33333H6Z"
                                fill="#898989" />
                        </svg>
                        <span class="tooltiptexts">{{ __('Schedule when sale starts and ends.') }}</span>
                    </div>
                </div>
            </div>
            <div class="collapse date-container {{ isset($product) && $product->isScheduledSale() ? 'show' : '' }}"
                id="general-schedule">
                <div class="row mt-3 align-items-center">
                    <div class="col-md-3">
                        <label for="sale_from" class="sp-title label-title ml-5 mt-2">{{ __('Sale From') }}</label>
                        <input type="hidden" name="sale-dates" value="1">
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="sale_from" name="sale_from" readonly="readonly"
                            class="form-control inputFieldDesign start_date date-ranges-picker"
                            placeholder="{{ __('Sale From') }}"
                            value="{{ isset($product) ? $product->sale_from : '' }}">
                    </div>
                </div>
                <div class="row mt-3 align-items-center">
                    <div class="col-md-3">
                        <label for="available_to" class="sp-title label-title ml-5 mt-2">{{ __('Sale To') }}</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="sale_to" name="sale_to" readonly="readonly"
                            class="form-control inputFieldDesign end_date date-ranges-picker"
                            placeholder="{{ __('Available To') }}"
                            value="{{ isset($product) ? $product->sale_to : '' }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        if (isset($product)) {
            $downloadables = $product->getDownloadables();
        }
    @endphp
    <div id="collapseExampl" data-name="downloadable"
        class="collapse {{ isset($product) && $product->isDownloadable() ? 'show' : '' }} mt-4 border-top mx-2">
        <div class="form-group row mt-4">
            <div class="w-14pt">
                <span class="sp-title control-label pl-0-res w-break-n">{{ __('Downloadable files') }}</span>
            </div>
            <div class="col-md-9 p-0-res">
                <div id="custom-option-value-1">
                    <div class="table-responsive option_div section-downloadable">
                        <input type="hidden" name="has_downloadables" class="empty-download" value="1">
                        <table class="options table table-bordered t-table">
                            <thead class="t-heads">
                                <tr>
                                    <th colspan="2" class="label">
                                        {{ __('Name') }}</th>
                                    <th colspan="5">
                                        {{ __('File URL') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="option-values-2" class="drag_and_drop ui-sortable">
                                @if (isset($downloadables) && count($downloadables) > 0)
                                    @foreach ($downloadables as $downloadable)
                                        <tr draggable="false"
                                            class="ui-sortable-handle downloadable-row attribute-dlt">
                                            <td colspan="2" class="label">
                                                <div class="d-flex align-items-center">
                                                    <svg class="me-2" width="16" height="11"
                                                        viewBox="0 0 16 11" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <rect width="16" height="1" fill="#898989">
                                                        </rect>
                                                        <rect y="5" width="16" height="1"
                                                            fill="#898989"></rect>
                                                        <rect y="10" width="16" height="1"
                                                            fill="#898989"></rect>
                                                    </svg>
                                                    <input type="text"
                                                        name="meta_downloadable_files[{{ $loop->index }}][name]"
                                                        value="{{ $downloadable['name'] }}"
                                                        class="form-control downloadable-name">
                                                </div>
                                            </td>
                                            <td colspan="2">
                                                <input type="text"
                                                    name="meta_downloadable_files[{{ $loop->index }}][url]"
                                                    class="form-control downloadable-url"
                                                    value="{{ $downloadable['url'] }}">
                                            </td>
                                            <td>
                                                <div class="position-relative downloadable-file">
                                                    <a class="add-files-button has-media-manager"
                                                        data-val="single">{{ __('Choose file') }}</a>
                                                    <svg class="sec-dlt position-absolute top-11p right-n6"
                                                        width="8" height="8" viewBox="0 0 8 8"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M0.292893 0.292893C0.683417 -0.0976311 1.31658 -0.0976311 1.70711 0.292893L7.70711 6.29289C8.09763 6.68342 8.09763 7.31658 7.70711 7.70711C7.31658 8.09763 6.68342 8.09763 6.29289 7.70711L0.292893 1.70711C-0.0976311 1.31658 -0.0976311 0.683417 0.292893 0.292893Z"
                                                            fill="#898989"></path>
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M7.70711 0.292893C7.31658 -0.0976311 6.68342 -0.0976311 6.29289 0.292893L0.292893 6.29289C-0.0976315 6.68342 -0.0976315 7.31658 0.292893 7.70711C0.683417 8.09763 1.31658 8.09763 1.70711 7.70711L7.70711 1.70711C8.09763 1.31658 8.09763 0.683417 7.70711 0.292893Z"
                                                            fill="#898989"></path>
                                                    </svg>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr draggable="false" id="option-value-rowid-2"
                                        class="ui-sortable-handle downloadable-row attribute-dlt">
                                        <td colspan="2" class="label">
                                            <div class="d-flex align-items-center rtl:gap-2">
                                                <svg class="me-2" width="16" height="11"
                                                    viewBox="0 0 16 11" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect width="16" height="1" fill="#898989">
                                                    </rect>
                                                    <rect y="5" width="16" height="1"
                                                        fill="#898989"></rect>
                                                    <rect y="10" width="16" height="1"
                                                        fill="#898989"></rect>
                                                </svg>
                                                <input type="text" name="meta_downloadable_files[0][name]"
                                                    class="form-control downloadable-name">
                                            </div>
                                        </td>
                                        <td colspan="2">
                                            <input type="text" name="meta_downloadable_files[0][url]"
                                                class="form-control downloadable-url">
                                        </td>
                                        <td>
                                            <div class="position-relative downloadable-file">
                                                <a class="add-files-button has-media-manager"
                                                    data-val="single">{{ __('Choose file') }}</a>
                                                <svg class="sec-dlt position-absolute top-11p right-n6" width="8"
                                                    height="8" viewBox="0 0 8 8" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M0.292893 0.292893C0.683417 -0.0976311 1.31658 -0.0976311 1.70711 0.292893L7.70711 6.29289C8.09763 6.68342 8.09763 7.31658 7.70711 7.70711C7.31658 8.09763 6.68342 8.09763 6.29289 7.70711L0.292893 1.70711C-0.0976311 1.31658 -0.0976311 0.683417 0.292893 0.292893Z"
                                                        fill="#898989"></path>
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M7.70711 0.292893C7.31658 -0.0976311 6.68342 -0.0976311 6.29289 0.292893L0.292893 6.29289C-0.0976315 6.68342 -0.0976315 7.31658 0.292893 7.70711C0.683417 8.09763 1.31658 8.09763 1.70711 7.70711L7.70711 1.70711C8.09763 1.31658 8.09763 0.683417 7.70711 0.292893Z"
                                                        fill="#898989"></path>
                                                </svg>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <a class="options-add-two mt-2 add-downloadables" data-idx="">
                            {{ __('Add File') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row mt-4">
            <div class="col-md-5 p-0-res">
                <div class="row">
                    <div class="col-md-4">
                        <label class="sp-title mt-2">{{ __('Download limit') }}</label>
                    </div>
                    <div class="col-md-8">
                        <input type="number" placeholder="-1" class="form-control inputFieldDesign"
                            name="meta_download_limit"
                            value="{{ isset($product) ? $product->meta_download_limit : '' }}">
                        <p class="mb-0 f-13 color-89 mt-2">{{ __('-1 for unlimited re-downloads') }}.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row mt-4">
            <div class="col-md-5 p-0-res">
                <div class="row">
                    <div class="col-md-4">
                        <label class="sp-title mt-2">{{ __('Download expiry') }}</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" placeholder="0"
                            class="form-control positive-float-number inputFieldDesign" name="meta_download_expiry"
                            value="{{ isset($product) ? $product->meta_download_expiry : '' }}">
                        <p class="mb-0 f-13 color-89 mt-2 w-space">
                            {{ __('Enter the number of days before a download link expires, or leave blank') }}.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @ifSettings('taxes')
    <div class="form-group row px-2 mt-4">
        <div class="col-md-5 p-0-res">
            <div class="row">
                <div class="col-md-4">
                    <label for="price" class="sp-title control-label">{{ __('Tax class') }}</label>
                </div>
                <div class="col-md-8">
                    <div class="d-flex align-items-center">
                        @php
                            if (isset($product) && count($taxes) > 0) {
                                $productTC = $product->getTaxClass();
                            }
                        @endphp
                        <select name="meta_tax_classes" class="select2clearable">
                            <option value="">{{ __('Select Tax Class') }}</option>
                            @foreach ($taxes as $taxProduct)
                                <option {{ isset($productTC) && $taxProduct->slug == $productTC ? 'selected' : '' }}
                                    value="{{ $taxProduct->slug }}">{{ $taxProduct->name }}</option>
                            @endforeach
                        </select>
                        <div
                            class="tooltips cursor-pointer neg-transition-scale  ltr:ms-2 rtl:me-2">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M12 6C12 9.31371 9.31371 12 6 12C2.68629 12 0 9.31371 0 6C0 2.68629 2.68629 0 6 0C9.31371 0 12 2.68629 12 6ZM6.66667 10C6.66667 10.3682 6.36819 10.6667 6 10.6667C5.63181 10.6667 5.33333 10.3682 5.33333 10C5.33333 9.63181 5.63181 9.33333 6 9.33333C6.36819 9.33333 6.66667 9.63181 6.66667 10ZM6 1.33333C4.52724 1.33333 3.33333 2.52724 3.33333 4H4.66667C4.66667 3.26362 5.26362 2.66667 6 2.66667H6.06287C6.76453 2.66667 7.33333 3.23547 7.33333 3.93713V4.27924C7.33333 4.62178 7.11414 4.92589 6.78918 5.03421C5.91976 5.32402 5.33333 6.13765 5.33333 7.05409V8.66667H6.66667V7.05409C6.66667 6.71155 6.88586 6.40744 7.21082 6.29912C8.08024 6.00932 8.66667 5.19569 8.66667 4.27924V3.93713C8.66667 2.49909 7.50091 1.33333 6.06287 1.33333H6Z"
                                    fill="#898989" />
                            </svg>
                            <span
                                class="tooltiptexts">{{ __('Tax classes are used to apply different tax rates specific to certain types of product.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endifSettings
</div>
