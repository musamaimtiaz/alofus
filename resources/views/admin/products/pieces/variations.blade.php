<div class="mx-7p form-group mt-27p pb-9p default-variation">
    @include('admin.products.pieces.default-variation')
</div>
<div class="mt-20p mx-6p mx-9r-res pb-20p">
    <div class="d-flex col-reverse align-unset justify-content-between align-items-center">
        <div class="d-flx d-flx-n mt-10-res">
            @if (isset($product) && count($product->getVariationAttributes()) > 0)
                <div class="w-320p w-n">
                    <select class="form-control select2 variation-type">
                        <option value="0">{{ __('Custom variation') }}</option>
                        <option value="all">{{ __('All possible variations') }}</option>
                    </select>
                </div>
                <div class="options-add ltr:ms-3 rtl:me-3 ml-0-res mt-10-res h-40 add-new-variant px-3">
                    {{ __('Add') }}
                </div>
            @else
                <p class="color-9E">{{ __('Variation attribute required to create product variations.') }}</p>
            @endif
        </div>
        <div class="mt-10-res">
            <p class="mb-0 f-12 font-italic">
                <span class="variation-count">{{ isset($product) ? count($product->variations) : 0 }}</span>
                {{ __('variations') }} (<span class="cursor-pointer color-A9 collapse-expand">{{ __('Expand') }}</span>
                /
                <span class="cursor-pointer color-9E collapse-collapse">{{ __('Close') }}</span> )
            </p>
        </div>
    </div>
</div>
<div class="mt-0 mx-6p pb-0 color-9E no-price-warning">
    <p>{{ __("Variations found which don't have price. Empty price variations will not be visible to the customers.") }}
    </p>
</div>
<div class="drag_and_drop ui-sortable put-attribute variation-item-lists">
    @if (isset($product) && isset($product->variations))
        @foreach ($product->variations as $variation)
            @php
                $idx = $loop->index;
            @endphp
            <div class="option-value-rowid attribute-dlt">
                <div class="position-relative">
                    <div class="mx-7p form-group border-t mx-25n px-32p bg-F5 collapse-header">
                        <div class="row mt-19p">
                            <div class="col-md-1 p-0-res ltr:ps-0 rtl:pe-0">
                                <p class="sp-title control-label font-weight-600">#{{ $variation->id }}</p>
                                <input type="hidden" class="variable_post" value="{{ $variation->id }}"
                                       name="variable_post_id[{{ $idx }}]">
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    @foreach ($product->attributes ?? [] as $key => $attr)
                                        @continue($attr['variation'] != 1)
                                        <div class="col-md-2 ltr:ps-0 rtl:pe-0 pr-10p pb-20p">
                                            <select class="form-control select2"
                                                    name="attribute_{{ $key }}[{{ $idx }}]">
                                                <option value="0">{{ __('Any') }} {{ $attr['name'] }}</option>
                                                @if (!$attr['attribute_id'])
                                                    @foreach ($attr['value'] as $val)
                                                        <option
                                                            {{ isset($variation->attributes['attribute_' . $key]) && $variation->attributes['attribute_' . $key] == $val ? 'selected' : '' }}
                                                            value="{{ $val }}">{{ $val }}</option>
                                                    @endforeach
                                                @else
                                                    @if (isset($product->attributeValues[$key]))
                                                        @foreach ($attr['value'] as $val)
                                                            <option
                                                                {{ isset($variation->attributes['attribute_' . $key]) && $variation->attributes['attribute_' . $key] == $val ? 'selected' : '' }}
                                                                value="{{ $val }}">
                                                                {{ optional($product->attributeValues[$key]->where('id', $val)->first())->value }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                @endif
                                            </select>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center position-absolute right-7p top-30p">
                        <svg class="cursor-move" width="16" height="11" viewBox="0 0 16 11" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <rect width="16" height="1" fill="#898989"></rect>
                            <rect y="5" width="16" height="1" fill="#898989"></rect>
                            <rect y="10" width="16" height="1" fill="#898989"></rect>
                        </svg>

                        <div data-bs-toggle="collapse" href="#{{ $unid = 'var_' . uniqid() }}">
                            <span
                                class="toggle-btn ml-10p d-flex h-20 w-20 align-items-center justify-content-center inactive-sec">
                                <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5"
                                     fill="none">
                                    <path
                                        d="M3.33579 4.92324L0.159846 1.11968C-0.211416 0.675046 0.105388 -4.81444e-07 0.685319 -5.06793e-07L6.31468 -7.52861e-07C6.89461 -7.7821e-07 7.21142 0.675045 6.84015 1.11968L3.66421 4.92324C3.57875 5.02559 3.42125 5.02559 3.33579 4.92324Z"
                                        fill="#2C2C2C"></path>
                                </svg>
                            </span>
                        </div>
                        <form method="post" action="#" accept-charset="UTF-8"
                              id="delete-variation-{{ $uniq = 'vid' . uniqid() }}" class="delete_variation">
                            {{ method_field('DELETE') }}
                            @csrf
                            <span class="f-11 red-9E ml-10p cursor-pointer" title="{{ __('Delete') }}"
                                  class="btn btn-xs btn-danger" type="button" data-id="{{ $uniq }}"
                                  data-delete="variation" data-label="Delete" data-bs-toggle="modal"
                                  data-bs-target="#confirmDelete"
                                  data-title="{{ __('Delete :x', ['x' => __('Variation')]) }}"
                                  data-message="{{ __('Are you sure to delete this variation?') }}">
                                {{ __('Delete') }}
                            </span>
                        </form>
                    </div>
                </div>
                @php
                    $image = $variation->getImagesWithoutDefault();
                    if (isset($image[0])) {
                        $image = $image[0];
                    }
                @endphp
                <div class="collapse collaspe-sec txt-enable" id="{{ $unid }}">
                    <div class="form-group row px-7 mt-29p">
                        <div class="col-md-6 variation-image-container">
                            <div class="d-flex align-items-center">
                                <div class="position-relative border u-img-box">
                                    @if ($image)
                                        <input type="hidden" class="variable-image" value="{{ $image['id'] ?? 0 }}"
                                               name="meta_image[{{ $idx }}]">
                                    @endif
                                    <img class="h-100 w-100 object-fit-contain variation-image-placeholder"
                                         src="{{ $image ? $image['url'] : asset('public/dist/img/not.svg') }}" />
                                </div>
                                <a href="javascript:void(0)" data-name="meta_image[{{ $idx }}]"
                                   data-val="single" class="btn-cancels ml-20p {{ $image ? 'variation-image-remove' : 'variation-image has-media-manager' }}">
                                    {{ $image ? 'Remove' : 'Upload Photo' }}
                                </a>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <label class="sp-title control-label">{{ __('SKU') }}</label>
                                <div class="tooltips ltr:ms-2 rtl:me-2 mt-px cursor-pointer">
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M12 6C12 9.31371 9.31371 12 6 12C2.68629 12 0 9.31371 0 6C0 2.68629 2.68629 0 6 0C9.31371 0 12 2.68629 12 6ZM6.66667 10C6.66667 10.3682 6.36819 10.6667 6 10.6667C5.63181 10.6667 5.33333 10.3682 5.33333 10C5.33333 9.63181 5.63181 9.33333 6 9.33333C6.36819 9.33333 6.66667 9.63181 6.66667 10ZM6 1.33333C4.52724 1.33333 3.33333 2.52724 3.33333 4H4.66667C4.66667 3.26362 5.26362 2.66667 6 2.66667H6.06287C6.76453 2.66667 7.33333 3.23547 7.33333 3.93713V4.27924C7.33333 4.62178 7.11414 4.92589 6.78918 5.03421C5.91976 5.32402 5.33333 6.13765 5.33333 7.05409V8.66667H6.66667V7.05409C6.66667 6.71155 6.88586 6.40744 7.21082 6.29912C8.08024 6.00932 8.66667 5.19569 8.66667 4.27924V3.93713C8.66667 2.49909 7.50091 1.33333 6.06287 1.33333H6Z"
                                              fill="#898989" />
                                    </svg>
                                    <span
                                        class="tooltiptexts">{{ __('SKU: Stock Keeping Unit. An unique identifier of a product.') }}</span>
                                </div>
                            </div>
                            <input type="text" placeholder="SKU" class="form-control inputFieldDesign" maxlength="8"
                                   name="variable_sku[{{ $idx }}]"
                                   value="{{ $variation->sku }}">
                        </div>
                    </div>

                    <div class="d-flx d-flx-n align-items-center mx-7p border-bottom mt-25p">
                        <div class="mr-35p">
                            <div data-bs-toggle="collapse" href="#collapseExampl"
                                 class="checkbox checkbox-primary d-inline w-space align-items-center">
                                <input type="hidden" value="Draft" name="variable_status[{{ $idx }}]">
                                <input type="checkbox" {{ $variation->status == 'Published' ? 'checked' : '' }}
                                name="variable_status[{{ $idx }}]" value="Published"
                                       id="{{ $enabledId = 'ena_' . uniqid() }}">
                                <label for="{{ $enabledId }}"
                                       class="crv sp-title d-flx-n">{{ __('Enabled') }}</label>
                            </div>
                        </div>

                        <div class="mr-35p mt-10-res">
                            <div class="checkbox checkbox-primary d-inline w-space align-items-center">
                                <input type="hidden" value="0" name="meta_downloadable[{{ $idx }}]">
                                <input data-bs-toggle="collapse" href="#{{ $dloadId = 'Down' . uniqid() }}"
                                       type="checkbox" {{ $variation->meta_downloadable == '1' ? 'checked' : '' }}
                                       name="meta_downloadable[{{ $idx }}]" id="{{ $dloadId }}"
                                       class="{{ $variation->meta_downloadable == '1' ? 'collapse show' : 'collapsed collapse' }}"
                                       value="1">
                                <label for="{{ $dloadId }}"
                                       class="crv sp-title d-flx-n">{{ __('Downloadable') }}</label>
                            </div>
                        </div>

                        <div class="mr-35p mt-10-res">
                            <div
                                class="checkbox checkbox-primary d-inline w-space align-items-center float-n ltr:float-right rtl:float-left">
                                <input type="hidden" value="0" name="meta_virtual[{{ $idx }}]">
                                <input data-bs-toggle="collapse" href="#{{ $virId = 'Vir' . uniqid() }}"
                                       type="checkbox" {{ $variation->isVirtual() ? 'checked' : '' }}
                                       class="{{ $variation->isVirtual() ? 'collapse show' : 'collapsed collapse' }}"
                                       name="meta_virtual[{{ $idx }}]" id="{{ $virId }}"
                                       value="1">
                                <label for="{{ $virId }}"
                                       class="crv sp-title d-flx-n">{{ __('Virtual') }}</label>
                            </div>
                        </div>

                        @ifSettings('manage_stock')
                        <div class="mr-35p mt-10-res">
                            <div
                                class="checkbox checkbox-primary d-inline w-space align-items-center float-n ltr:float-right rtl:float-left">
                                <input type="hidden" name="variable_manage_stocks[{{ $idx }}]"
                                       value="0">
                                <input data-bs-toggle="collapse" {{ $variation->manage_stocks == '1' ? 'checked' : '' }}
                                href="#{{ $stockId = 'stock' . uniqid() }}" type="checkbox"
                                       name="variable_manage_stocks[{{ $idx }}]" id="{{ $stockId }}"
                                       class="{{ $variation->manage_stocks == '1' ? 'collapse show' : 'collapsed collapse' }}"
                                       value="1">
                                <label for="{{ $stockId }}"
                                       class="crv sp-title d-flx-n">{{ __('Manage stock?') }}</label>
                            </div>
                        </div>
                        @endifSettings

                        @php $b2bId = 'b2b' . uniqid() @endphp
                        @includeIf('b2b::admin.check-b2b-variations')
                    </div>

                    <div class="form-group price_div row px-7 mt-36p">
                        <div class="col-md-6">
                            <label for="price" class="sp-title control-label">{{ __('Regular Price') }} ({{ \App\Models\Currency::getDefault()->symbol }})</label>
                            <input type="number" step="any" placeholder="{{ __('Price') }}"
                                   class="form-control regular_price h-40" maxlength="8" id="price"
                                   name="variable_regular_price[{{ $idx }}]"
                                   value="{{ $variation->regular_price ? formatDecimal($variation->regular_price) : '' }}">
                        </div>
                        <div class="col-md-6 mt-15-res">
                            <div class="d-flx justify-content-between">
                                <label for="price" class="sp-title control-label">{{ __('Sale Price') }} ({{ \App\Models\Currency::getDefault()->symbol }})</label>
                                <div>
                                    <span class="m-change fold_p" data-bs-toggle="collapse" href="#{{ $vsid = 'vs_' . uniqid() }}"
                                          aria-expanded="{{ $variation->isScheduledSale() ? 'true' : 'false' }}"
                                          aria-controls="{{ $vsid }}"><span
                                            class="inner_text">{{ $variation->isScheduledSale() ? __('Cancel') : __('Schedule') }}</span>
                                        <input type="hidden" class="date-schedular" name="meta_scheduled_sale[{{ $idx }}]"
                                               value="{{ $variation->meta_scheduled_sale ?? 0 }}">
                                    </span>
                                    <div class="tooltips ltr:ms-2 rtl:me-2 mt-4px">
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M12 6C12 9.31371 9.31371 12 6 12C2.68629 12 0 9.31371 0 6C0 2.68629 2.68629 0 6 0C9.31371 0 12 2.68629 12 6ZM6.66667 10C6.66667 10.3682 6.36819 10.6667 6 10.6667C5.63181 10.6667 5.33333 10.3682 5.33333 10C5.33333 9.63181 5.63181 9.33333 6 9.33333C6.36819 9.33333 6.66667 9.63181 6.66667 10ZM6 1.33333C4.52724 1.33333 3.33333 2.52724 3.33333 4H4.66667C4.66667 3.26362 5.26362 2.66667 6 2.66667H6.06287C6.76453 2.66667 7.33333 3.23547 7.33333 3.93713V4.27924C7.33333 4.62178 7.11414 4.92589 6.78918 5.03421C5.91976 5.32402 5.33333 6.13765 5.33333 7.05409V8.66667H6.66667V7.05409C6.66667 6.71155 6.88586 6.40744 7.21082 6.29912C8.08024 6.00932 8.66667 5.19569 8.66667 4.27924V3.93713C8.66667 2.49909 7.50091 1.33333 6.06287 1.33333H6Z"
                                                  fill="#898989" />
                                        </svg>
                                        <span class="tooltiptexts">{{ __('Sale price time duration.') }}</span>
                                    </div>
                                </div>
                            </div>
                            <input type="number" step="any" placeholder="{{ __('Price') }}" class="form-control sale_price inputFieldDesign"
                                   id="price" name="variable_sale_price[{{ $idx }}]"
                                   value="{{ $variation->sale_price ? formatDecimal($variation->sale_price) : '' }}">

                            <div class="collapse date-container {{ $variation->isScheduledSale() ? 'show' : '' }}"
                                 id="{{ $vsid }}">
                                <div class="row mt-16p">
                                    <div class="col-md-3">
                                        <label for="sale_from" class="sp-title label-title">{{ __('Sale From') }}</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="variable_sale_from[{{ $idx }}]" readonly="readonly"
                                               class="form-control start_date mt-2p date-ranges-picker" placeholder="{{ __('Sale From') }}"
                                               value="{{ $variation->sale_from }}">
                                    </div>
                                </div>
                                <div class="row mt-18p">
                                    <div class="col-md-3">
                                        <label for="sale_to" class="sp-title label-title">{{ __('Sale To') }}</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="variable_sale_to[{{ $idx }}]" readonly="readonly"
                                               class="form-control end_date mt-2p date-ranges-picker" placeholder="{{ __('Sale To') }}"
                                               value="{{ $variation->sale_to }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @ifSettings('manage_stock')
                    <div id="{{ $stockId }}"
                         class="form-group row px-7 mt-20p collapse {{ $variation->manage_stocks == '1' ? 'show' : '' }}">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <label class="sp-title control-label">{{ __('Stock quantity') }}</label>
                            </div>
                            <input type="text" placeholder="0" class="form-control inputFieldDesign" maxlength="8"
                                   name="variable_total_stocks[{{ $idx }}]" value="{{ $variation->total_stocks }}"
                            >
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <label class="sp-title control-label pr-6p">{{ __('Allow backorders?') }}</label>
                                <div class="tooltips ltr:ms-2 rtl:me-2 mt-px cursor-pointer">
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M12 6C12 9.31371 9.31371 12 6 12C2.68629 12 0 9.31371 0 6C0 2.68629 2.68629 0 6 0C9.31371 0 12 2.68629 12 6ZM6.66667 10C6.66667 10.3682 6.36819 10.6667 6 10.6667C5.63181 10.6667 5.33333 10.3682 5.33333 10C5.33333 9.63181 5.63181 9.33333 6 9.33333C6.36819 9.33333 6.66667 9.63181 6.66667 10ZM6 1.33333C4.52724 1.33333 3.33333 2.52724 3.33333 4H4.66667C4.66667 3.26362 5.26362 2.66667 6 2.66667H6.06287C6.76453 2.66667 7.33333 3.23547 7.33333 3.93713V4.27924C7.33333 4.62178 7.11414 4.92589 6.78918 5.03421C5.91976 5.32402 5.33333 6.13765 5.33333 7.05409V8.66667H6.66667V7.05409C6.66667 6.71155 6.88586 6.40744 7.21082 6.29912C8.08024 6.00932 8.66667 5.19569 8.66667 4.27924V3.93713C8.66667 2.49909 7.50091 1.33333 6.06287 1.33333H6Z"
                                              fill="#898989" />
                                    </svg>
                                    <span
                                        class="tooltiptexts">{{ __('Allows users to order product even if the stock reaches to 0.') }}</span>
                                </div>
                            </div>
                            <select class="form-control select2" name="meta_backorder[{{ $idx }}]"
                                    data-minimum-results-for-search="Infinity">
                                <option {{ $variation->meta_backorder == '0' ? 'selected' : '' }} value="0">
                                    {{ __('Do not allow') }}</option>
                                <option {{ $variation->meta_backorder == '1' ? 'selected' : '' }} value="1">
                                    {{ __('Allow') }}
                                </option>
                            </select>
                        </div>
                        @ifSettings('stock_threshold')
                        <div class="col-md-12">
                            <div class="d-flex align-items-center">
                                <label class="sp-title control-label">{{ __('Low stock threshold') }}</label>
                                <div class="tooltips ltr:ms-2 rtl:me-2 mt-px cursor-pointer">
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M12 6C12 9.31371 9.31371 12 6 12C2.68629 12 0 9.31371 0 6C0 2.68629 2.68629 0 6 0C9.31371 0 12 2.68629 12 6ZM6.66667 10C6.66667 10.3682 6.36819 10.6667 6 10.6667C5.63181 10.6667 5.33333 10.3682 5.33333 10C5.33333 9.63181 5.63181 9.33333 6 9.33333C6.36819 9.33333 6.66667 9.63181 6.66667 10ZM6 1.33333C4.52724 1.33333 3.33333 2.52724 3.33333 4H4.66667C4.66667 3.26362 5.26362 2.66667 6 2.66667H6.06287C6.76453 2.66667 7.33333 3.23547 7.33333 3.93713V4.27924C7.33333 4.62178 7.11414 4.92589 6.78918 5.03421C5.91976 5.32402 5.33333 6.13765 5.33333 7.05409V8.66667H6.66667V7.05409C6.66667 6.71155 6.88586 6.40744 7.21082 6.29912C8.08024 6.00932 8.66667 5.19569 8.66667 4.27924V3.93713C8.66667 2.49909 7.50091 1.33333 6.06287 1.33333H6Z"
                                              fill="#898989" />
                                    </svg>
                                    <span
                                        class="tooltiptexts">{{ __('Send email to the vendor of the product if stock reaches to this limit.') }}</span>
                                </div>
                            </div>
                            <input type="text" placeholder="{{ __('Low stock threshold') }}" class="form-control inputFieldDesign" maxlength="8"
                                   name="meta_stock_threshold[{{ $idx }}]"
                                   value="{{ $variation->meta_stock_threshold }}">
                        </div>
                        @endifSettings
                    </div>
                    @endifSettings
                    @includeIf('b2b::admin.b2b-variations-data')

                    <div id="{{ $virId }}"
                         class="form-group row px-7 mt-20p collapse {{ $variation->meta_virtual == '1' ? '' : 'show' }}">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <label for="Weight" class="sp-title control-label">{{ __('Weight') }}
                                    (@preference('measurement_weight'))
                                </label>
                                <div class="tooltips ltr:ms-2 rtl:me-2 mt-px cursor-pointer">
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M12 6C12 9.31371 9.31371 12 6 12C2.68629 12 0 9.31371 0 6C0 2.68629 2.68629 0 6 0C9.31371 0 12 2.68629 12 6ZM6.66667 10C6.66667 10.3682 6.36819 10.6667 6 10.6667C5.63181 10.6667 5.33333 10.3682 5.33333 10C5.33333 9.63181 5.63181 9.33333 6 9.33333C6.36819 9.33333 6.66667 9.63181 6.66667 10ZM6 1.33333C4.52724 1.33333 3.33333 2.52724 3.33333 4H4.66667C4.66667 3.26362 5.26362 2.66667 6 2.66667H6.06287C6.76453 2.66667 7.33333 3.23547 7.33333 3.93713V4.27924C7.33333 4.62178 7.11414 4.92589 6.78918 5.03421C5.91976 5.32402 5.33333 6.13765 5.33333 7.05409V8.66667H6.66667V7.05409C6.66667 6.71155 6.88586 6.40744 7.21082 6.29912C8.08024 6.00932 8.66667 5.19569 8.66667 4.27924V3.93713C8.66667 2.49909 7.50091 1.33333 6.06287 1.33333H6Z"
                                              fill="#898989" />
                                    </svg>
                                    <span class="tooltiptexts">{{ __('Weight unit is set by admin.') }}</span>
                                </div>
                            </div>
                            <input type="text" placeholder="0" class="form-control positive-float-number inputFieldDesign" maxlength="8"
                                   id="Weight" name="meta_weight[{{ $idx }}]" value="{{ $variation->meta_weight }}">
                        </div>
                        <div class="col-md-6 mt-10-res">
                            <div class="d-flex align-items-center">
                                <label for="Dimensions" class="sp-title control-label">{{ __('Dimensions') }}
                                    (LxWxH) @preference('measurement_dimension')</label>
                                <div class="tooltips ltr:ms-2 rtl:me-2 mt-px cursor-pointer">
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M12 6C12 9.31371 9.31371 12 6 12C2.68629 12 0 9.31371 0 6C0 2.68629 2.68629 0 6 0C9.31371 0 12 2.68629 12 6ZM6.66667 10C6.66667 10.3682 6.36819 10.6667 6 10.6667C5.63181 10.6667 5.33333 10.3682 5.33333 10C5.33333 9.63181 5.63181 9.33333 6 9.33333C6.36819 9.33333 6.66667 9.63181 6.66667 10ZM6 1.33333C4.52724 1.33333 3.33333 2.52724 3.33333 4H4.66667C4.66667 3.26362 5.26362 2.66667 6 2.66667H6.06287C6.76453 2.66667 7.33333 3.23547 7.33333 3.93713V4.27924C7.33333 4.62178 7.11414 4.92589 6.78918 5.03421C5.91976 5.32402 5.33333 6.13765 5.33333 7.05409V8.66667H6.66667V7.05409C6.66667 6.71155 6.88586 6.40744 7.21082 6.29912C8.08024 6.00932 8.66667 5.19569 8.66667 4.27924V3.93713C8.66667 2.49909 7.50091 1.33333 6.06287 1.33333H6Z"
                                              fill="#898989" />
                                    </svg>
                                    <span class="tooltiptexts">{{ __('Length') }} x {{ __('Witdth') }} x {{ __('Height') }}.
                                        {{ __('Dimension unit is set by admin.') }}</span>
                                </div>
                            </div>
                            <div class="row mx-0">
                                <div class="col-md-3 p-0">
                                    <input type="text" placeholder="{{ __('Length') }}" class="form-control positive-float-number inputFieldDesign"
                                           maxlength="8" id="Dimensions" name="meta_dimension[{{ $idx }}][length]"
                                           value="{{ array_val($variation->dimension, 'length', '') }}">
                                </div>
                                <div class="col-md-3 p-0 mt-15-res">
                                    <input type="text" placeholder="{{ __('Width') }}" class="form-control positive-float-number inputFieldDesign"
                                           maxlength="8" id="Dimensions" name="meta_dimension[{{ $idx }}][width]"
                                           value="{{ array_val($variation->dimension, 'width', '') }}">
                                </div>
                                <div class="col-md-3 p-0 mt-15-res">
                                    <div class="d-flex align-items-center">
                                        <input type="text" placeholder="{{ __('Height') }}" class="form-control positive-float-number inputFieldDesign"
                                               maxlength="8" id="Dimensions" name="meta_dimension[{{ $idx }}][height]"
                                               value="{{ array_val($variation->dimension, 'height', '') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <label for="Shipping Class" class="sp-title control-label">{{ __('Shipping class') }}</label>
                            </div>
                            <select class="form-control select2clearable sl_common_bx" name="meta_shipping_id[{{ $idx }}]">
                                @foreach ($shippings as $shiping)
                                    <option value="{{ $shiping->slug }}"
                                        {{ $shiping->slug == $variation->shipping_id ? 'selected' : '' }}>
                                        {{ $shiping->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @ifSettings('taxes')
                    <div class="form-group row px-7">
                        <div class="col-md-12">
                            <div class="d-flex align-items-center">
                                <label for="tax" class="sp-title control-label">{{ __('Tax class') }}</label>
                            </div>
                            <select class="form-control select2clearable sl_common_bx" name="meta_tax_classes[{{ $idx }}]">
                                @foreach ($taxes as $taxProduct)
                                    <option {{ $taxProduct->slug == $variation->getTaxClass() ? 'selected' : '' }}
                                            value="{{ $taxProduct->slug }}">{{ $taxProduct->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endifSettings

                    <div class="form-group row px-7 mt-20p">
                        <div class="col-md-12">
                            <label class="sp-title control-label">{{ __('Description') }}</label>
                            <textarea class="form-control" placeholder="{{ __('Variable Description') }}" name="variable_description[{{ $idx }}]"
                                      rows="2">{{ $variation->description }}</textarea>
                        </div>
                    </div>
                    @php
                        $downloadables = $variation->getDownloadables();
                    @endphp
                    <div id="{{ $dloadId }}"
                         class="mt-28p mx-7p collapse {{ $variation->meta_downloadable == '1' ? 'show' : '' }}">
                        <div class="form-group row mt-28p">
                            <div class="w-14pt">
                                <span class="sp-title control-label dn-files w-break-n">{{ __('Downloadable files') }}
                                </span>
                            </div>
                            <div class="col-md-9">
                                <div id="custom-option-value-1">
                                    <div class="table-responsive option_div section-downloadable">
                                        <input type="hidden" name="has_downloadables[{{ $idx }}]" class="empty-download"
                                               value="1">
                                        <table class="options table table-bordered t-table">
                                            <thead class="t-heads">
                                            <tr>
                                                <th colspan="2" class="label">
                                                    {{ __('Name') }}</th>
                                                <th colspan="5">
                                                    {{ __('File URL') }}
                                                    <div class="tooltips ml-8p mt-px cursor-pointer">
                                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                  d="M12 6C12 9.31371 9.31371 12 6 12C2.68629 12 0 9.31371 0 6C0 2.68629 2.68629 0 6 0C9.31371 0 12 2.68629 12 6ZM6.66667 10C6.66667 10.3682 6.36819 10.6667 6 10.6667C5.63181 10.6667 5.33333 10.3682 5.33333 10C5.33333 9.63181 5.63181 9.33333 6 9.33333C6.36819 9.33333 6.66667 9.63181 6.66667 10ZM6 1.33333C4.52724 1.33333 3.33333 2.52724 3.33333 4H4.66667C4.66667 3.26362 5.26362 2.66667 6 2.66667H6.06287C6.76453 2.66667 7.33333 3.23547 7.33333 3.93713V4.27924C7.33333 4.62178 7.11414 4.92589 6.78918 5.03421C5.91976 5.32402 5.33333 6.13765 5.33333 7.05409V8.66667H6.66667V7.05409C6.66667 6.71155 6.88586 6.40744 7.21082 6.29912C8.08024 6.00932 8.66667 5.19569 8.66667 4.27924V3.93713C8.66667 2.49909 7.50091 1.33333 6.06287 1.33333H6Z"
                                                                  fill="#898989" />
                                                        </svg>
                                                        <span
                                                            class="tooltiptexts">{{ __('Do no change the url if you are uploading the product.') }}</span>
                                                    </div>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody id="option-values-2" class="drag_and_drop ui-sortable">
                                            @forelse ($downloadables as $downloadable)
                                                @continue(!checkDownloadableData($downloadable))
                                                <tr draggable="false" class="ui-sortable-handle downloadable-row attribute-dlt">
                                                    <td colspan="2" class="label">
                                                        <div class="d-flex align-items-center">
                                                            <svg class="me-2" width="16" height="11" viewBox="0 0 16 11"
                                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <rect width="16" height="1" fill="#898989">
                                                                </rect>
                                                                <rect y="5" width="16" height="1" fill="#898989">
                                                                </rect>
                                                                <rect y="10" width="16" height="1" fill="#898989">
                                                                </rect>
                                                            </svg>
                                                            <input type="text"
                                                                   name="meta_downloadable_files[{{ $idx }}][{{ $loop->index }}][name]"
                                                                   value="{{ isset($downloadable['name']) ? $downloadable['name'] : '' }}"
                                                                   class="form-control downloadable-name">
                                                        </div>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text"
                                                               name="meta_downloadable_files[{{ $idx }}][{{ $loop->index }}][url]"
                                                               class="form-control downloadable-url"
                                                               value="{{ $downloadable['url'] }}">
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
                                            @empty
                                                <tr draggable="false" id="option-value-rowid-2"
                                                    class="ui-sortable-handle downloadable-row attribute-dlt">
                                                    <td colspan="2" class="label">
                                                        <div class="d-flex align-items-center rtl:gap-2">
                                                            <svg class="me-2" width="16" height="11" viewBox="0 0 16 11"
                                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <rect width="16" height="1" fill="#898989">
                                                                </rect>
                                                                <rect y="5" width="16" height="1" fill="#898989">
                                                                </rect>
                                                                <rect y="10" width="16" height="1" fill="#898989">
                                                                </rect>
                                                            </svg>
                                                            <input type="text"
                                                                   name="meta_downloadable_files[{{ $idx }}][0][name]"
                                                                   class="form-control downloadable-name">
                                                        </div>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text"
                                                               name="meta_downloadable_files[{{ $idx }}][0][url]"
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
                                            @endforelse
                                            </tbody>
                                        </table>
                                        <a class="options-add-two mt-10p w-74p add-downloadables" data-idx="{{ '[' . $idx . ']' }}">
                                            {{ __('Add File') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mt-26p pb-14p">
                            <div class="col-md-6">
                                <label class="sp-title">{{ __('Download limit') }}</label>
                                <input type="number" placeholder="0" class="form-control inputFieldDesign"
                                       name="meta_download_limit[{{ $idx }}]" value="{{ $variation->meta_download_limit }}">
                            </div>

                            <div class="col-md-6">
                                <label class="sp-title">{{ __('Download expiry') }}</label>
                                <input type="text" placeholder="0" class="form-control positive-float-number inputFieldDesign"
                                       name="meta_download_expiry[{{ $idx }}]" value="{{ $variation->meta_download_limit }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>

<div class="d-flex mt-20p px-6p pb-19p">
    <a class="btn-confirms save_variations" id="btnSubmit">
        {{ __('Save Changes') }}
    </a>
</div>
