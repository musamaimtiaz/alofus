<div class="tab-pane fade pb-28p pb-4" id="tabs-f" role="tabpanel" aria-labelledby="tabs-6">
    <div class="mt-5 mx-2 mx-9r-res pb-5">
        <div class="d-flex col-reverse align-unset justify-content-between align-items-center">
            <div class="d-flx d-flx-n mt-10-res">
                <div class="w-320p w-n">
                    <select class="form-control select2" id="attribute-list">
                        <option value="0">{{ __('Custom product attribute') }}</option>
                        @foreach ($attributeList as $attribute)
                            <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="options-add ltr:ms-3 rtl:me-3 px-2 ml-0-res mt-10-res h-40 add-new-attribute">
                    {{ __('Add')}}
                </div>
            </div>

            <div class="mt-10-res">
                <p class="mb-0 f-12 font-italic">
                    <span class="attribute-count pe-2">{{ isset($product) && isset($product->attributes) ? count($product->attributes) : 0 }}</span>{{ __('attributes') }} (
                    <span class="cursor-pointer color-A9 collapse-expand">{{ __('Expand') }}</span> /
                    <span class="cursor-pointer color-9E collapse-collapse">{{ __('Close') }}</span> )
                </p>
            </div>
        </div>
    </div>


    <div class="attribute_sortable put-attrs attribute-parent-box attribute-item-lists drag_and_drop ui-sortable">
        @include('admin.products.pieces.attributes')
    </div>

    <div class="mt-25p mx-7p px-6 border-t mx-25n px-32p">
        <a href="javascript:void(0)" class="w-175p btn-confirms mt-24p save_attributes">{{ __('Save Attributes') }}</a>
    </div>


</div>
