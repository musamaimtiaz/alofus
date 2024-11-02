<div
    class="mini-form-holder card-border mt-2 card section pb-20-res transition-none option-value-rowid ui-sortable-handle common_c">
    <div class="card-header cursor-pointer d-flex justify-content-between align-items-center head-click" data-bs-toggle="collapse" href="#Item_Detail">
        <p class="mb-0 add-title">{{ __('Add Product Details') }}</p>
       <div class="d-flex justify-content-end align-items-center">
        <span class="cursor-move mt-0">
            <svg width="16" height="11" viewBox="0 0 16 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="16" height="1" fill="#898989"></rect>
                <rect y="5" width="16" height="1" fill="#898989"></rect>
                <rect y="10" width="16" height="1" fill="#898989"></rect>
            </svg>
        </span>
        <span class="toggle-btn mt-0 icon-collapse ltr:ms-3 rtl:me-3">
            <svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M4.18767 0.0921111L7.81732 4.65639C8.24162 5.18994 7.87956 6 7.21678 6L0.783223 6C0.120445 6 -0.241618 5.18994 0.182683 4.65639L3.81233 0.092111C3.91 -0.0307037 4.09 -0.0307036 4.18767 0.0921111Z"
                    fill="#2C2C2C"></path>
            </svg>
        </span>
       </div>
    </div>

    <div id="Item_Detail" class="collapse show pb-11p txt-enable blockable">
        <div class="card-body mt-20p px-3-res px-32p">
            <div class="form-group row">
                <div class="col-md-2 px-2 mt-1">
                    <label for="description" class="control-label label-title">{{ __('Description') }}</label>
                </div>
                <div class="col-md-10 mt-1 description-color-div">
                    <textarea class="form-control rounded summernote" name="description">{{ isset($product) ? $product->description : '' }}</textarea>
                </div>
            </div>
            <div class="form-group row mt-20p">
                <label for="summary" class="col-md-2 control-label label-title">{{ __('Summary') }}
                </label>
                <div class="col-md-10 custom-details-form">
                    <textarea class="form-control" name="summary">{{ isset($product) ? $product->summary : '' }}</textarea>
                </div>
            </div>
        </div>
    </div>

</div>
