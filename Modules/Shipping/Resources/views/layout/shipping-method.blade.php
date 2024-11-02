@php
    $flat = $zone->shippingZoneShippingMethods->where('shipping_method_id', 3)->first();
    $local = $zone->shippingZoneShippingMethods->where('shipping_method_id', 2)->first();
    $free = $zone->shippingZoneShippingMethods->where('shipping_method_id', 1)->first();
@endphp
{{-- Free Shipping --}}
<div class="method-tab shipping-animation active" id="free_shipping-{{ $freeId }}" role="tabpanel" aria-labelledby="free-shipping">
    <div class="form-group row">
        <label for="free_shipping_name" class="col-3 control-label">{{ __('Title') }}</label>
        <div class="col-4">
            <input type="hidden" name="free_shipping_id" value="1">
            <input type="text" class="form-control inputFieldDesign" name="free_shipping_name" placeholder="{{ __('Free Shipping') }}" id="free_shipping_name" value="{{ isset($free->method_title) ? $free->method_title : '' }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-3 control-label text-left">{{ __('Free shipping requires') }}</label>
        <div class="col-4">
            <select class="form-select select h-40" name="free_shipping_requirement">
                <option value="" {{ isset($free->requirements) && $free->requirements == '' ? 'selected' : '' }}>N/A</option>
                <option value="coupon" {{ isset($free->requirements) && $free->requirements == 'coupon' ? 'selected' : '' }}>{{ __('A valid free shipping coupon') }}</option>
                <option value="min_amount" {{ isset($free->requirements) && $free->requirements == 'min_amount' ? 'selected' : '' }}>{{ __('A minimum order amount') }}</option>
                <option value="either" {{ isset($free->requirements) && $free->requirements == 'either' ? 'selected' : '' }}>{{ __('A minimum order amount OR a coupon') }}</option>
                <option value="both" {{ isset($free->requirements) && $free->requirements == 'both' ? 'selected' : '' }}>{{ __('A minimum order amount AND a coupon') }}</option>
            </select>
        </div>
    </div>
    <div class="free_shipping_condition d-none">
        <div class="form-group row">
            <label for="free_shipping_cost" class="col-3 control-label">{{ __('Minimum order amount') }}</label>
            <div class="col-4">
                <div class="input-group flex-wrap h-44p">
                    <div class="input-group-prepend">
                        <span class="input-group-text rounded-0  ltr:rounded-start rtl:rounded-end h-44p">{{ preg_replace('/[0-9\.]+/', '', formatNumber('')) }}</span>
                    </div>
                    <input type="text" class="form-control positive-float-number float-validation" name="free_shipping_cost" placeholder="0" id="free_shipping_cost" value="{{ isset($free->cost) && !empty((float) $free->cost) ? formatCurrencyAmount($free->cost) : '' }}">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-3 control-label">{{ __('Coupons discounts') }}</label>
            <div class="col-7">
                <div class="mt-2 checkbox checkbox-fill">
                    <input type="checkbox" name="free_calculation_type" value="{{ isset($free->calculation_type) ? $free->calculation_type : 0 }}" {{ isset($free->calculation_type) && $free->calculation_type == 1 ? 'checked' : '' }}>
                    <label class="cr free_shipping_checkbox">{{ __('Apply minimum order rule before coupon discount') }}</label>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-3 control-label">{{ __('Status') }}</label>
        <div class="col-4">
            <div class="switch switch-bg d-inline m-r-10">
                <input type="checkbox" name="free_shipping_status" class="checkActivity" id="free_shipping_status-{{ $mainId }}" value="{{ isset($free->status) ? $free->status : 0 }}" {{ isset($free->status) && $free->status == 1 ? 'checked' : '' }}>
                <label for="free_shipping_status-{{ $mainId }}" class="cr"></label>
            </div>
        </div>
    </div>
</div>
{{-- Local pickup --}}
<div class="method-tab shipping-animation" id="local_pickup-{{ $localId }}" role="tabpanel" aria-labelledby="local-pickup">
    <div class="form-group row">
        <label for="local_pickup_name" class="col-3 control-label">{{ __('Title') }}</label>
        <div class="col-4">
            <input type="hidden" name="local_pickup_id" value="2">
            <input type="text" class="form-control inputFieldDesign" name="local_pickup_name" placeholder="{{ __('Local Pickup') }}" id="local_pickup_name" value="{{ isset($local->method_title) ? $local->method_title : '' }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="local_pickup_tax_status" class="col-3 control-label">{{ __('Tax Status') }}</label>
        <div class="col-4">
            <select class="form-select select h-40" name="local_pickup_tax_status" id="local_pickup_tax_status">
                <option value="taxable" {{ isset($local->tax_status) && $local->tax_status == 'taxable' ? 'selected' : '' }} >{{ __('Taxable') }}</option>
                <option value="none" {{ isset($local->tax_status) && $local->tax_status == 'none' ? 'selected' : '' }}>{{ __('None') }}</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="local_pickup_cost" class="col-3 control-label">{{ __('Cost') }}</label>
        <div class="col-4">
            <div class="input-group flex-wrap h-44p">
                <div class="input-group-prepend">
                    <span class="input-group-text rounded-0  ltr:rounded-start rtl:rounded-end h-44p">{{ preg_replace('/[0-9\.]+/', '', formatNumber('')) }}</span>
                </div>
                <input type="text" class="form-control positive-float-number float-validation" name="local_pickup_cost" placeholder="0" id="local_pickup_cost" value="{{ isset($local->cost) && !empty((float) $local->cost) ? formatCurrencyAmount($local->cost) : '' }}">
            </div>
        </div>

        <div class="col-4">
            <select class="form-select select h-40" name="local_pickup_cost_type">
                <option value="cost_per_order" {{ isset($local->cost_type) && $local->cost_type == 'cost_per_order' ? 'selected' : '' }}>{{ __('Cost per order') }}</option>
                <option value="cost_per_quantity" {{ isset($local->cost_type) && $local->cost_type == 'cost_per_quantity' ? 'selected' : '' }}>{{ __('Cost per quantity') }}</option>
                <option value="percent_sub_total_item_price" {{ isset($local->cost_type) && $local->cost_type == 'percent_sub_total_item_price' ? 'selected' : '' }}>{{ __('Percent sub total of product price') }}</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-3 control-label">{{ __('Status') }}</label>
        <div class="col-4">
            <div class="switch switch-bg d-inline m-r-10">
                <input type="checkbox" name="local_pickup_status" class="checkActivity" id="local_pickup_status-{{ $mainId }}" value="{{ isset($local->status) ? $local->status : 0 }}" {{ isset($local->status) && $local->status == 1 ? 'checked' : '' }}>
                <label for="local_pickup_status-{{ $mainId }}" class="cr"></label>
            </div>
        </div>
    </div>
</div>
{{-- Flat Rate --}}
<div class="method-tab shipping-animation" id="flat_rate-{{ $flatId }}" role="tabpanel" aria-labelledby="flat-rate">
    <div class="form-group row">
        <label for="flat_rate_name" class="col-3 control-label">{{ __('Title') }}</label>
        <div class="col-4">
            <input type="hidden" name="flat_rate_id" value="3">
            <input type="text" class="form-control inputFieldDesign" name="flat_rate_name" placeholder="{{ __('Flat Rate') }}" id="flat_rate_name" value="{{ isset($flat->method_title) ? $flat->method_title : '' }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="flat_rate_tax_status" class="col-3 control-label">{{ __('Tax Status') }}</label>
        <div class="col-4">
            <select class="form-select select h-40" name="flat_rate_tax_status" id="flat_rate_tax_status">
                <option value="taxable" {{ isset($flat->tax_status) && $flat->tax_status == 'taxable' ? 'selected' : '' }} >{{ __('Taxable') }}</option>
                <option value="none" {{ isset($flat->tax_status) && $flat->tax_status == 'none' ? 'selected' : '' }}>{{ __('None') }}</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="flat_rate_cost" class="col-3 control-label">{{ __('Cost') }}</label>
        <div class="col-4">
            <div class="input-group flex-wrap h-44p">
                <div class="input-group-prepend">
                    <span class="input-group-text rounded-0  ltr:rounded-start rtl:rounded-end h-44p">{{ preg_replace('/[0-9\.]+/', '', formatNumber('')) }}</span>
                  </div>
                <input type="text" class="form-control positive-float-number float-validation" maxlength="17" name="flat_rate_cost" placeholder="0" id="flat_rate_cost" value="{{ isset($flat->cost) && !empty((float) $flat->cost) ? formatCurrencyAmount($flat->cost) : '' }}">
            </div>
        </div>

        <div class="col-4">
            <select class="form-select select h-40" name="flat_rate_cost_type">
                <option value="cost_per_order" {{ isset($flat->cost_type) && $flat->cost_type == 'cost_per_order' ? 'selected' : '' }}>{{ __('Cost per order') }}</option>
                <option value="cost_per_quantity" {{ isset($flat->cost_type) && $flat->cost_type == 'cost_per_quantity' ? 'selected' : '' }}>{{ __('Cost per quantity') }}</option>
                <option value="percent_sub_total_item_price" {{ isset($flat->cost_type) && $flat->cost_type == 'percent_sub_total_item_price' ? 'selected' : '' }}>{{ __('Percent sub total of product price') }}</option>
            </select>
        </div>
    </div>

    <div class="form-group row flat_rate_status">
        <label class="col-3 control-label">{{ __('Status') }}</label>
        <div class="col-4">
            <div class="switch switch-bg d-inline m-r-10">
                <input type="checkbox" name="flat_rate_status" class="checkActivity" id="flat_rate_status-{{ $mainId }}" value="{{ isset($flat->status) ? $flat->status : 0 }}" {{ isset($flat->status) && $flat->status == 1 ? 'checked' : '' }}>
                <label for="flat_rate_status-{{ $mainId }}" class="cr"></label>
            </div>
        </div>
    </div>
    @if ($zoneClasses->count() > 1)
    <div class="shipping_classes">
        <div class="row bg-light-gray py-3 mt-14 mb-4 class_description">
            <div class="col-12">
                <h5 class="d-block">{{ __('Shipping class costs') }}</h5>
                <p class="text-dark m-0">{{ __('These costs can optionally be added based on the product shipping class.') }}</p>
            </div>
        </div>
        @foreach ($zoneClasses as $class)
        @php
            $zoneClass = $class->shippingZoneShippingClasses->where('shipping_zone_id', $zone->id)->first();
        @endphp
            <div class="form-group row class">
                <label class="col-3 control-label text-left">{{ $class->slug == 'no-class' ? $class->name : (!empty($class->name) ? $class->name : $class->slug) . ' ' . __('Class shipping costs') }}</label>
                <div class="col-4">
                    <div class="input-group h-44p">
                        <div class="input-group-prepend">
                            <span class="input-group-text rounded-0 ltr:rounded-start rtl:rounded-end h-44p">{{ preg_replace('/[0-9\.]+/', '', formatNumber('')) }}</span>
                        </div>
                        <input type="hidden" name="slug" value="{{ $class->slug }}">
                        <input type="text" class="form-control positive-float-number float-validation" name="cost" placeholder="N/A" value="{{ isset($zoneClass->cost) && !empty((float) $zoneClass->cost) ? formatCurrencyAmount($zoneClass->cost) : '' }}">
                    </div>
                </div>

                <div class="col-4">
                    <select class="form-select select h-40" name="cost_type">
                        <option value="cost_per_order" {{ isset($zoneClass->cost_type) && $zoneClass->cost_type == 'cost_per_order' ? 'selected' : '' }}>{{ __('Cost per order') }}</option>
                        <option value="cost_per_quantity" {{ isset($zoneClass->cost_type) && $zoneClass->cost_type == 'cost_per_quantity' ? 'selected' : '' }}>{{ __('Cost per quantity') }}</option>
                        <option value="percent_sub_total_item_price" {{ isset($zoneClass->cost_type) && $zoneClass->cost_type == 'percent_sub_total_item_price' ? 'selected' : '' }}>{{ __('Percent sub total of product price') }}</option>
                    </select>
                </div>
            </div>
        @endforeach
    </div>

    <div class="form-group row flat_rate_calculation_type">
        <label class="col-3 control-label">{{ __('Calculation Type') }}</label>
        <div class="col-4">
            <select class="form-control" name="flat_rate_calculation_type">
                <option value="class" {{ isset($flat->calculation_type) && $flat->calculation_type == 'class' ? 'selected' : '' }}>{{ __('Per class: Charge shipping for each shipping class individually') }}</option>
                <option value="order" {{ isset($flat->calculation_type) && $flat->calculation_type == 'order' ? 'selected' : '' }}>{{ __('Per order: Charge shipping for the most expensive shipping class') }}</option>
            </select>
        </div>
    </div>
    @endif
</div>
