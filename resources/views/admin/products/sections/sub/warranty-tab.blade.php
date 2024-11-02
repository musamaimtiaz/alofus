<div class="mini-form-holder tab-pane fade pb-4" id="tabs-d" role="tabpanel" aria-labelledby="tabs-4">
    <div class="form-group row px-2 mt-4">
        <div class="col-md-5 p-0-res">
            <div class="row">
                <div class="col-md-4">
                    <label for="Color" class="sp-title control-label">{{ __('Warranty Type') }}
                    </label>
                </div>
                <div class="col-md-8">
                    <select class="form-control select2 attribute_information" id="warranty_type"
                        name="meta_warranty_type">
                        @foreach (getServiceData(1, 0) as $warrantyType)
                            <option value="{{ $warrantyType }}"
                                {{ isset($product) && $product->warranty_type == $warrantyType ? 'selected' : '' }}>
                                {{ __($warrantyType) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-7 p-0-res">
            <div class="row">
                <div class="col-md-3">
                    <label class="sp-titl control-label h-40" id="warranty_period_lbl" for="warranty_period">
                        {{ __('Warranty Period') }} </label>
                </div>
                <div class="col-md-6">
                    <select class="form-control select2clearable attribute_information h-40" id="warranty_period"
                        name="meta_warranty_period">
                        <option value="">{{ __('Select One') }}</option>
                        @foreach (getServiceData(0, 1) as $warrantyPeriod)
                            <option value="{{ $warrantyPeriod }}"
                                {{ isset($product) && $product->warranty_period == $warrantyPeriod ? 'selected' : '' }}>
                                {{ __($warrantyPeriod) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row px-2 mt-3">
        <div class="col-md-5 p-0-res">
            <div class="row">
                <div class="col-md-4">
                    <label for="Protection" class="sp-title control-label">
                        {{ __('Warranty Policy') }} </label>
                </div>
                <div class="col-md-8">
                    <textarea type="text" rows="2" class="form-control" name="meta_warranty_policy" id="warranty_policy">{{ isset($product) ? $product->warranty_policy : '' }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
