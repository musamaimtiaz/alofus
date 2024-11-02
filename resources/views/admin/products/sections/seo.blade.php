<div
    class="card-border mini-form-holder mt-2 card section pb-20-res transition-none option-value-rowid ui-sortable-handle common_c">

    <div class="card-header cursor-pointer d-flex align-items-center justify-content-between head-click" data-bs-toggle="collapse" href="#Seo">
        <p class="mb-0 add-title">{{ __('Search Engine Optimization') }} (SEO)</p>
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

    <div id="Seo" class="collapse show pb-11p txt-enable blockable">
        <div class="card-body mt-20p px-3-res px-32p">
            <div class="row pb-20p">
                <div class="col-sm-12">
                    <div class="form-group row">
                        <label for="name"
                            class="col-sm-2 sp-title control-label">{{ __('Meta :x', ['x' => __('Title')]) }}</label>
                        <div class="col-sm-10">
                            <input type="text" name="meta_seo[title]"
                                value="{{ isset($product) ? $product->getSeoTitle() : '' }}"
                                placeholder="{{ __('Title') }}" class="form-control inputFieldDesign">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name"
                            class="col-sm-2 sp-title control-label">{{ __('Meta :x', ['x' => __('Description')]) }}</label>
                        <div class="col-sm-10">
                            <textarea name="meta_seo[description]" class="form-control h-90">{{ isset($product) ? $product->getSeoDescription() : '' }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label
                            class="col-sm-2 sp-title control-label">{{ __('Meta :x', ['x' => __('Images')]) }}</label>
                        <div class="col-sm-10 preview-parent">
                            <div class="custom-file position-relative has-media-manager seo-image" data-name="meta_seo[image]"
                                data-val="single">
                                <input class="custom-file-input form-control d-none" id="validatedCustomFile" maxlength="50"
                                    accept="image/*">
                                <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center" for="validatedCustomFile">{{ __('Upload image') }}</label>
                            </div>
                            <div class="d-flx flex-wrap preview-image">
                                @if (isset($product) && ($seoImage = $product->getSeoImageUrl()))
                                    <div class="img-box-two mt-15p">
                                        <img class="fit-boxed neg-transition-scale" src="{{ $seoImage['url'] }}"
                                            alt="{{ $seoImage['name'] }}">
                                        <input type="hidden" value="{{ $seoImage['id'] }}" name="meta_seo[image]">
                                        <svg class="svg-postion cursor-pointer remove-product-image" width="14" height="14" viewBox="0 0 14 14"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="7" cy="7" r="7" fill="#FCCA19">
                                            </circle>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M4.21967 4.21967C4.51256 3.92678 4.98744 3.92678 5.28033 4.21967L9.78033 8.71967C10.0732 9.01256 10.0732 9.48744 9.78033 9.78033C9.48744 10.0732 9.01256 10.0732 8.71967 9.78033L4.21967 5.28033C3.92678 4.98744 3.92678 4.51256 4.21967 4.21967Z"
                                                fill="#2C2C2C"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M9.78033 4.21967C9.48744 3.92678 9.01256 3.92678 8.71967 4.21967L4.21967 8.71967C3.92678 9.01256 3.92678 9.48744 4.21967 9.78033C4.51256 10.0732 4.98744 10.0732 5.28033 9.78033L9.78033 5.28033C10.0732 4.98744 10.0732 4.51256 9.78033 4.21967Z"
                                                fill="#2C2C2C"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4 offset-sm-2 mt-2">
                            <a class="btn-confirms seo-update" type="submit">{{ __('Save') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
