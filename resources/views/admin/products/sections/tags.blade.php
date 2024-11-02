<div class="card mini-form-holder">
    <div class="order-sec-head cursor-pointer d-flex justify-content-between align-items-center px-3 head-click" href="#Product_Taged"
        aria-expanded="false" data-bs-toggle="collapse">
        <span class="add-title text-lg">{{ __('Product Tags') }}</span>
        <span class="icon-collapse mt-0 toggle-btn">
            <svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M4.18767 0.0921111L7.81732 4.65639C8.24162 5.18994 7.87956 6 7.21678 6L0.783223 6C0.120445 6 -0.241618 5.18994 0.182683 4.65639L3.81233 0.092111C3.91 -0.0307037 4.09 -0.0307036 4.18767 0.0921111Z"
                    fill="#2C2C2C"></path>
            </svg>
        </span>
    </div>

    <div id="Product_Taged" class="form-group mb-0 collapse show blockable border-top pb-4p">
        <div class="mt-20p mx-3 d-flx justify-content-between">
            <div>
                <input type="hidden" name="has-tags" value="1">
                <select class="form-control select-ajax-tags" multiple="multiple" name="product_tags[]">
                    @isset($tags)
                        @foreach ($tags as $tagId => $tagName)
                            <option value="{{ $tagId }}" selected>{{ $tagName }}</option>
                        @endforeach
                    @endisset
                </select>
            </div>
        </div>
        <p class="sp-tag mt-14p mx-3"></p>
    </div>
</div>
