<div class="card mini-form-holder">
    <div class="order-sec-head d-flex justify-content-between align-items-center border-bottom px-3">
        <span class="add-title text-lg">{{ __('Product Stats') }}</span>
    </div>
    <div class="blockable">
        <div>
            <div class="collapse-parent">
                <div class="d-flex flex-column">
                    <div class="d-flex justify-content-between mx-3 mt-20p">
                        <p class="d-flex align-items-center m-0">
                            <svg class="ltr:me-1 rtl:ms-1" width="16" height="15" viewBox="0 0 16 15" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M11 13.75L12.8 12.4C14.8144 10.8892 16 8.51806 16 6V2C16 0.89543 15.1046 0 14 0H2C0.895431 0 0 0.895431 0 2V6C0 8.51806 1.18555 10.8892 3.2 12.4L5 13.75C6.77778 15.0833 9.22222 15.0833 11 13.75ZM6 6C6 6.55228 5.55228 7 5 7C4.44772 7 4 6.55228 4 6C4 5.44772 4.44772 5 5 5C5.55228 5 6 5.44772 6 6ZM9 6C9 6.55228 8.55229 7 8 7C7.44772 7 7 6.55228 7 6C7 5.44772 7.44772 5 8 5C8.55229 5 9 5.44772 9 6ZM11 7C11.5523 7 12 6.55228 12 6C12 5.44772 11.5523 5 11 5C10.4477 5 10 5.44772 10 6C10 6.55228 10.4477 7 11 7Z"
                                    fill="#898989" />
                            </svg>
                            <span class="ml-2 label-title">
                                {{ __('Status') }}:
                            </span>
                        </p>
                        <p class="text-16 m-0 font-weight-600 show-status">
                            {{ isset($product) ? __($product->status) : __('Draft') }}
                        </p>
                    </div>
                    <p class="ml-44p m-change toggle_collapse" data-bs-toggle="collapse" href="#Status">
                        {{ __('Change') }}</p>
                </div>

                <div class="collapse" id="Status">
                    <div class="pb-20p ltr:ps-xxl-4 ltr:ps-0 rtl:pe-xxl-4 rtl:pe-0">
                        <div class="row align-items-center flx-direct">
                            <div class="col-md-7 mx-w-n">
                                <select class="form-control select2 status-select" name="status">
                                    <option {{ isset($product) && $product->status == 'Draft' ? 'selected' : '' }}
                                        value="Draft">{{ __('Draft') }}
                                    </option>
                                    <option
                                        {{ isset($product) && $product->status == 'Pending Review' ? 'selected' : '' }}
                                        value="Pending Review">{{ __('Pending Review') }}</option>
                                    @if ($isAdmin || preference('is_publish_product') == 1 || (isset($product) && $product->status == 'Published'))
                                        <option
                                            {{ isset($product) && $product->status == 'Published' ? 'selected' : '' }}
                                            value="Published">
                                            {{ __('Published') }}</option>
                                    @endif
                                </select>
                            </div>
                            <div class="d-flx col-md-5 mx-w-n mt-16-res align-items-center t-res p-0">
                                <a class="options-add-two toggle_collapse_cancel select-btn">
                                    {{ __('Ok') }}
                                </a>
                                <a class="ml-15p font-weight-500 color-89 cursor-pointer toggle_collapse_cancel">
                                    {{ __('Cancel') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="collapse-parent">
                <div class="d-flex flex-column">
                    <div class="d-flex justify-content-between mx-3 mt-4px">
                        <p class="d-flex align-items-center m-0">
                            <svg class="ltr:me-1 rtl:ms-1" width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M0 5.59844C0 4.08994 0 3.3357 0.468629 2.86707C0.937258 2.39844 1.69151 2.39844 3.2 2.39844H12.8C14.3085 2.39844 15.0627 2.39844 15.5314 2.86707C16 3.3357 16 4.08994 16 5.59844C16 5.97556 16 6.16412 15.8828 6.28128C15.7657 6.39844 15.5771 6.39844 15.2 6.39844H0.8C0.422876 6.39844 0.234315 6.39844 0.117157 6.28128C0 6.16412 0 5.97556 0 5.59844Z"
                                    fill="#898989" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M0 12.8C0 14.3085 0 15.0627 0.468629 15.5314C0.937258 16 1.69151 16 3.2 16H12.8C14.3085 16 15.0627 16 15.5314 15.5314C16 15.0627 16 14.3085 16 12.8V8.8C16 8.42288 16 8.23431 15.8828 8.11716C15.7657 8 15.5771 8 15.2 8H0.8C0.422876 8 0.234315 8 0.117157 8.11716C0 8.23431 0 8.42288 0 8.8V12.8ZM4 10.4C4 10.0229 4 9.83431 4.11716 9.71716C4.23431 9.6 4.42288 9.6 4.8 9.6H6.4C6.77712 9.6 6.96569 9.6 7.08284 9.71716C7.2 9.83431 7.2 10.0229 7.2 10.4C7.2 10.7771 7.2 10.9657 7.08284 11.0828C6.96569 11.2 6.77712 11.2 6.4 11.2H4.8C4.42288 11.2 4.23431 11.2 4.11716 11.0828C4 10.9657 4 10.7771 4 10.4ZM4.11716 12.9172C4 13.0343 4 13.2229 4 13.6C4 13.9771 4 14.1657 4.11716 14.2828C4.23431 14.4 4.42288 14.4 4.8 14.4H6.4C6.77712 14.4 6.96569 14.4 7.08284 14.2828C7.2 14.1657 7.2 13.9771 7.2 13.6C7.2 13.2229 7.2 13.0343 7.08284 12.9172C6.96569 12.8 6.77712 12.8 6.4 12.8H4.8C4.42288 12.8 4.23431 12.8 4.11716 12.9172ZM8.8 10.4C8.8 10.0229 8.8 9.83431 8.91716 9.71716C9.03432 9.6 9.22288 9.6 9.6 9.6H11.2C11.5771 9.6 11.7657 9.6 11.8828 9.71716C12 9.83431 12 10.0229 12 10.4C12 10.7771 12 10.9657 11.8828 11.0828C11.7657 11.2 11.5771 11.2 11.2 11.2H9.6C9.22288 11.2 9.03432 11.2 8.91716 11.0828C8.8 10.9657 8.8 10.7771 8.8 10.4ZM8.91716 12.9172C8.8 13.0343 8.8 13.2229 8.8 13.6C8.8 13.9771 8.8 14.1657 8.91716 14.2828C9.03432 14.4 9.22288 14.4 9.6 14.4H11.2C11.5771 14.4 11.7657 14.4 11.8828 14.2828C12 14.1657 12 13.9771 12 13.6C12 13.2229 12 13.0343 11.8828 12.9172C11.7657 12.8 11.5771 12.8 11.2 12.8H9.6C9.22288 12.8 9.03432 12.8 8.91716 12.9172Z"
                                    fill="#898989" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.00078 -1.80142e-07C4.44261 -8.06521e-08 4.80078 0.358172 4.80078 0.8L4.80078 3.2C4.80078 3.64183 4.44261 4 4.00078 4C3.55895 4 3.20078 3.64183 3.20078 3.2L3.20078 0.8C3.20078 0.358172 3.55895 -2.79631e-07 4.00078 -1.80142e-07Z"
                                    fill="#898989" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M12.0008 -1.80142e-07C12.4426 -8.06521e-08 12.8008 0.358172 12.8008 0.8L12.8008 3.2C12.8008 3.64183 12.4426 4 12.0008 4C11.559 4 11.2008 3.64183 11.2008 3.2L11.2008 0.8C11.2008 0.358172 11.559 -2.79631e-07 12.0008 -1.80142e-07Z"
                                    fill="#898989" />
                            </svg>

                            <span class="ml-2 label-title">
                                {{ __('Publish') }}:
                            </span>
                        </p>
                        <p class="text-16 m-0 font-weight-600 schedule_status">
                            {{ isset($product) && $product->available_from && date($product->available_from) > date('Y-m-d') ? formatDate($product->available_from) : __('Immediately') }}
                        </p>
                    </div>
                </div>
                <p class="ml-44p m-change toggle_collapse" data-bs-toggle="collapse" href="#collapseExample"
                    aria-expanded="false" aria-controls="collapseExample">
                    {{ __('Change') }}</p>

                <div class="collapse mx-3 date-container" id="collapseExample">
                    <input type="hidden" name="available-dates" value="1">
                    <div class="row mx-3">
                        <div class="col-md-12">
                            <label for="available_from" class="label-title text-14">{{ __('Available From') }}</label>
                            <input type="text" name="available_from"
                                value="{{ isset($product) ? $product->available_from : '' }}" readonly="readonly"
                                class="form-control start_date mt-2p date-ranges-picker schedule_start inputFieldDesign"
                                placeholder="{{ __('Available From') }}">
                        </div>

                        <div class="col-md-12">
                            <label for="available_to"
                                class="label-title text-14 mt-10p">{{ __('Available To') }}</label>
                            <input type="text" name="available_to"
                            id="start_date" value="{{ isset($product) ? $product->available_to : '' }}" readonly="readonly"
                                class="form-control end_date mt-2p date-ranges-picker inputFieldDesign"
                                placeholder="{{ __('Available To') }}">
                        </div>
                    </div>

                    <div class="ml-32p mt-10p d-flx align-items-center pb-20p">
                        <a class="options-add-two toggle_collapse_cancel">
                            {{ __('Ok') }}
                        </a>
                        <a class="ml-15p font-weight-500 color-89 cursor-pointer toggle_collapse_cancel">
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column">
                <div
                    class="d-flex justify-content-between align-items-center mx-3 mt-4px {{ isset($product) ? '' : 'mb-4' }}">
                    <p class="d-flex align-items-center m-0">
                        <svg class="ltr:me-1 rtl:ms-1" xmlns="http://www.w3.org/2000/svg" width="17" height="17"
                            viewBox="0 0 17 17" fill="none">
                            <path
                                d="M11.729 0.294504C11.34 -0.0964958 10.708 -0.0984955 10.315 0.290504C10.211 0.394504 10.139 0.517504 10.09 0.645504C9.258 2.3815 8.342 3.3605 7.186 3.9385C5.889 4.5785 4.4 5.0235 2 5.0235C1.87 5.0235 1.74 5.0485 1.618 5.0995C1.373 5.2015 1.179 5.3965 1.077 5.6405C0.976 5.8845 0.976 6.1605 1.077 6.4045C1.128 6.5275 1.201 6.6385 1.294 6.7305L4.537 9.9735L0 16.0235L6.05 11.4865L9.292 14.7285C9.384 14.8225 9.495 14.8945 9.618 14.9455C9.74 14.9965 9.87 15.0235 10 15.0235C10.13 15.0235 10.26 14.9965 10.382 14.9455C10.627 14.8435 10.822 14.6505 10.923 14.4045C10.974 14.2835 11 14.1525 11 14.0235C11 11.6235 11.444 10.1345 12.083 8.8575C12.66 7.7015 13.639 6.7855 15.376 5.9535C15.505 5.9045 15.627 5.8325 15.73 5.7285C16.119 5.3355 16.117 4.7035 15.726 4.3145L11.729 0.294504V0.294504Z"
                                fill="#898989"></path>
                        </svg>

                        <span class="ml-2 label-title">
                            {{ __('Featured Product') }}:
                        </span>
                    </p>
                    <div class="switch switch-bg mt-4px">
                        <input type="hidden" name="isFeatured" value="0">
                        <input {{ isset($product) && $product->featured ? 'checked' : '' }} name="isFeatured"
                            type="checkbox" id="switch-p-2" value="1">
                        <label for="switch-p-2" class="cr cr-bg mb-0 position-static"></label>
                    </div>
                </div>
            </div>
            @isset($product)
                <div class="d-flx justify-content-between align-items-center px-3 item-h mt-20p border-top">
                    <form method="post"
                        action="{{ route($isAdmin ? 'product.destroy' : 'vendor.product.destroy', ['code' => $product->code]) }}"
                        accept-charset="UTF-8" id="delete-product-{{ $product->code }}">
                        {{ method_field('DELETE') }}
                        @csrf
                        <p class="m-trash m-0" title="{{ __('Delete') }}" class="btn btn-xs btn-danger" type="button"
                            data-id="{{ $product->code }}" data-delete="product" data-label="Delete"
                            data-bs-toggle="modal" data-bs-target="#confirmDelete"
                            data-title="{{ __('Delete :x', ['x' => __('Product')]) }}"
                            data-message="{{ __('Are you sure to delete this?') }}">
                            {{ __('Move to trash') }}
                        </p>
                    </form>
                    <a class="preview-link" target="_blank"
                        href="{{ isset($product) ? route('site.productDetails', ['slug' => $product->slug]) : '#' }}">{{ __('Preview') }}</a>
                </div>
            @endisset
            <div class="d-flx border-top px-3 py-20p align-items-center">
                <a class="btn-confirms has-spinner-loader update-item-button w-100 h-44p">{{ isset($product) ? __('Update Product') : __('Save Product') }}</a>
            </div>
        </div>
    </div>
</div>
