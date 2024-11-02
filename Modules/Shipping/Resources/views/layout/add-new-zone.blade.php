<div class="new-zone-content d-none">
    <div class="accordion accordion-flush" id="accordionFlushExample">
        <div class="card bg-light-gray mb-0">
            <div class="card-header p-0 " id="flush-headingOne">
                <div class="d-flex justify-content-between">
                    <input type="hidden" name="id">
                    <input type="text" class="form-control w-50 border-left-0 border-top-0 bordre-bottom-0" maxlength="120" placeholder="{{ __('Enter zone name') }}" name="name">
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-link text-right location-btn text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            {{ __('Set Locations') }} <i class="fas fa-angle-down"></i>
                          </button>
                          <button class="btn btn-link text-right method-btn text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            {{ __('Set Shipping Methods') }} <i class="fas fa-angle-down"></i>
                          </button>
                        <div class="me-3">
                            <span class="text-dark cursor_pointer delete-zone delete-button action-btn d-flex justify-content-center" title="{{ __('Delete Tax Rate') }}">
                                <i class="fa fa-trash"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-main border-left-right">
                        <thead class="bg-light-gray text-dark border-top-gray">
                            <tr>
                                <th>{{ __('Country') }}</th>
                                <th>{{ __('State') }}</th>
                                <th>{{ __('City') }}</th>
                                <th>{{ __('ZIP') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="10" class="pt-3">
                                    <button type="button" class="btn custom-btn-submit btn-sm add-new-location">{{ __('Add New Location') }}</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                <div class="card-body methods">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link nav-list-button active text-uppercase free-shipping font-bold" data-bs-toggle="tab" href="#free_shipping" role="tab" aria-controls="free_shipping" data-tab="free_shipping" aria-selected="true">{{ __('Free Shipping') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-list-button text-uppercase local-pickup font-bold" data-bs-toggle="tab" href="#local_pickup" role="tab" aria-controls="local_pickup" data-tab="local_pickup" aria-selected="false">{{ __('Local Pickup') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-list-button text-uppercase flat-rate font-bold" data-bs-toggle="tab" href="#flat_rate" role="tab" aria-controls="flat_rate" data-tab="flat_rate" aria-selected="false">{{ __('Flat Rate') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                         {{-- Free Shipping --}}
                         <div class="tab-contents active shipping-animation"  id="free_shipping" role="tabpanel" aria-labelledby="free-shipping">
                            <div class="form-group row">
                                <label for="free_shipping_name" class="col-3 control-label">{{ __('Title') }}</label>
                                <div class="col-4">
                                    <input type="hidden" name="free_shipping_id" value="1">
                                    <input type="text" class="form-control inputFieldDesign" name="free_shipping_name" placeholder="{{ __('Free Shipping') }}" id="free_shipping_name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 control-label text-left">{{ __('Free shipping requires') }}</label>
                                <div class="col-4">
                                    <select class="form-select select h-40" name="free_shipping_requirement">
                                        <option value="">N/A</option>
                                        <option value="coupon">{{ __('A valid free shipping coupon') }}</option>
                                        <option value="min_amount">{{ __('A minimum order amount') }}</option>
                                        <option value="either">{{ __('A minimum order amount OR a coupon') }}</option>
                                        <option value="both">{{ __('A minimum order amount AND a coupon') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="free_shipping_condition d-none">
                                <div class="form-group row">
                                    <label for="free_shipping_cost" class="col-3 control-label">{{ __('Minimum order amount') }}</label>
                                    <div class="col-4">
                                        <div class="input-group flex-wrap">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text rounded-0 ltr:rounded-start rtl:rounded-end">{{ preg_replace('/[0-9\.]+/', '', formatNumber('')) }}</span>
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
                                        <input type="checkbox" name="free_shipping_status" class="checkActivity" id="free_shipping_status" value="0">
                                        <label for="free_shipping_status" class="cr"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Local pickup --}}
                        <div class="tab-contents shipping-animation" id="local_pickup" role="tabpanel" aria-labelledby="local-pickup">
                            <div class="form-group row">
                                <label for="local_pickup_name" class="col-3 control-label">{{ __('Title') }}</label>
                                <div class="col-4">
                                    <input type="hidden" name="local_pickup_id" value="2">
                                    <input type="text" class="form-control inputFieldDesign" name="local_pickup_name" placeholder="{{ __('Local Pickup') }}" id="local_pickup_name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="local_pickup_tax_status" class="col-3 control-label">{{ __('Tax Status') }}</label>
                                <div class="col-4">
                                    <select class="select form-select h-40" name="local_pickup_tax_status" id="local_pickup_tax_status">
                                        <option value="taxable">{{ __('Taxable') }}</option>
                                        <option value="none">{{ __('None') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="local_pickup_cost" class="col-3 control-label">{{ __('Cost') }}</label>
                                <div class="col-4">
                                    <div class="input-group flex-wrap">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text rounded-0  ltr:rounded-start rtl:rounded-end">{{ preg_replace('/[0-9\.]+/', '', formatNumber('')) }}</span>
                                        </div>
                                        <input type="text" class="form-control positive-float-number float-validation" name="local_pickup_cost" placeholder="0" id="local_pickup_cost">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <select class="select form-select h-40" name="local_pickup_cost_type">
                                        <option value="cost_per_order">{{ __('Cost per order') }}</option>
                                        <option value="cost_per_quantity">{{ __('Cost per quantity') }}</option>
                                        <option value="percent_sub_total_item_price">{{ __('Percent sub total of product price') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 control-label">{{ __('Status') }}</label>
                                <div class="col-4">
                                    <div class="switch switch-bg d-inline m-r-10">
                                        <input type="checkbox" name="local_pickup_status" class="checkActivity" id="local_pickup_status" value="0">
                                        <label for="local_pickup_status" class="cr"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Flat Rate --}}
                        <div class="tab-contents shipping-animation" id="flat_rate" role="tabpanel" aria-labelledby="flat-rate">
                            <div class="form-group row">
                                <label for="flat_rate_name" class="col-3 control-label">{{ __('Title') }}</label>
                                <div class="col-4">
                                    <input type="hidden" name="flat_rate_id" value="3">
                                    <input type="text" class="form-control inputFieldDesign" maxlength="120" name="flat_rate_name" placeholder="{{ __('Flat Rate') }}" id="flat_rate_name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="flat_rate_tax_status" class="col-3 control-label">{{ __('Tax Status') }}</label>
                                <div class="col-4">
                                    <select class="select form-select h-40" name="flat_rate_tax_status" id="flat_rate_tax_status">
                                        <option value="taxable">{{ __('Taxable') }}</option>
                                        <option value="none">{{ __('None') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="flat_rate_cost" class="col-3 control-label">{{ __('Cost') }}</label>
                                <div class="col-4 ">
                                    <div class="input-group flex-wrap">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text rounded-0  ltr:rounded-start rtl:rounded-end">{{ preg_replace('/[0-9\.]+/', '', formatNumber('')) }}</span>
                                        </div>
                                        <input type="text" class="form-control positive-float-number float-validation" maxlength="16" name="flat_rate_cost" placeholder="0" id="flat_rate_cost">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <select class="select form-select h-40" name="flat_rate_cost_type">
                                        <option value="cost_per_order">{{ __('Cost per order') }}</option>
                                        <option value="cost_per_quantity">{{ __('Cost per quantity') }}</option>
                                        <option value="percent_sub_total_item_price">{{ __('Percent sub total of product price') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-3 control-label">{{ __('Status') }}</label>
                                <div class="col-4">
                                    <div class="switch switch-bg d-inline m-r-10">
                                        <input type="checkbox" name="flat_rate_status" class="checkActivity" id="flat_rate_status" value="0">
                                        <label for="flat_rate_status" class="cr"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="shipping_classes">
                                <div class="row bg-light-gray py-3 mt-14 mb-4 class_description">
                                    <div class="col-12">
                                        <h5 class="d-block">{{ __('Shipping class costs') }}</h5>
                                        <p class="text-dark m-0">{{ __('These costs can optionally be added based on the product shipping class.') }}</p>
                                    </div>
                                </div>
                                @foreach ($zoneClasses as $class)
                                    <div class="form-group row class">
                                        <label class="col-3 control-label">{{ $class->name }}</label>
                                        <div class="col-4">
                                            <div class="input-group flex-wrap">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text rounded-0  ltr:rounded-start rtl:rounded-end">{{ preg_replace('/[0-9\.]+/', '', formatNumber('')) }}</span>
                                                </div>
                                                <input type="hidden" name="slug" value="{{ $class->slug }}">
                                                <input type="text" class="form-control positive-float-number" name="cost" placeholder="N/A">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <select class="select form-select h-40" name="cost_type">
                                                <option value="cost_per_order">{{ __('Cost per order') }}</option>
                                                <option value="cost_per_quantity">{{ __('Cost per quantity') }}</option>
                                                <option value="percent_sub_total_item_price">{{ __('Percent sub total of product price') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="form-group row">
                                <label class="col-3 control-label">{{ __('Calculation Type') }}</label>
                                <div class="col-4">
                                    <select class="form-select h-40" name="flat_rate_calculation_type">
                                        <option value="class">{{ __('Per class: Charge shipping for each shipping class individually') }}</option>
                                        <option value="order">{{ __('Per order: Charge shipping for the most expensive shipping class') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
