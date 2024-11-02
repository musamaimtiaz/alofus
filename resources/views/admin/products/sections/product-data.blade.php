<div class="card option-value-rowid ui-sortable-handle transition-none impact_parent common_c">
    <div class="mini-form-holder d-flex d-flx-n align-items-center pr-30p relative">
        <div
            class="mr-42p mr-19-res mt-10-res div_h virtual-child conditional-dom not-variable-dom not-grouped-dom not-external-dom {{ isset($product) && $product->isSimpleProduct() ? '' : 'd-none' }}">
            <div class="checkbox checkbox-primary p-0 d-inline w-space align-items-center float-left">
                <input type="hidden" name="meta_virtual" value="0">
                <input type="checkbox" name="meta_virtual" {{ isset($product) && $product->isVirtual() ? 'checked' : '' }}
                    class="has_impact" value="1" data-name="virtual" id="Virtual">
                <label for="Virtual" class="crv sp-title label-res d-unset">{{ __('Virtual') }}</label>
            </div>
        </div>

        <div
            class="mr-42p div_h download-child conditional-dom not-variable-dom not-grouped-dom not-external-dom {{ isset($product) && $product->isSimpleProduct() ? '' : 'd-none' }}">
            <div class="checkbox checkbox-primary m-0 d-inline w-space align-items-center">
                <input type="hidden" name="meta_downloadable" value="0">
                <input data-bs-toggle="collapse" href="#collapseExampl" type="checkbox" name="meta_downloadable"
                    class="has_impact virtual-product" data-name="downloadable" value="1"
                    {{ isset($product) && $product->isDownloadable() ? 'checked' : '' }} id="Downloadable">
                <label for="Downloadable"
                    class="crv sp-title label-res d-unset ml-10-res">{{ __('Downloadable') }}</label>
            </div>
        </div>
        <div class="w-276p mt-15-res select-child">
            <select name="type" class="form-control select2 product-type">
                @foreach ((new \App\Services\Product\Editor\TypeSelector($productForSelector))->productTypeSelectorOnAdd()['options'] as $selector)
                    @if (isset($selector['visibility']) && $selector['visibility'] != '1')
                        @continue
                    @endif
                    @if (isset($selector['option_html']))
                        {!! $selector['option_html'] !!}
                    @endif
                @endforeach
            </select>
        </div>
    </div>

    <div class="order-sec-head cursor-pointer d-flex d-flx-n align-items-center position-relative px-3-res px-32p h-66p head-click"
        data-bs-toggle="collapse" href="#product_data">
        <div class="mt-15-res product-res">
            <span class="add-title">{{ __('Product Data') }}</span>
        </div>
        <svg class="cursor-move position-absolute right-58p" width="16" height="11" viewBox="0 0 16 11"
            fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="16" height="1" fill="#898989"></rect>
            <rect y="5" width="16" height="1" fill="#898989"></rect>
            <rect y="10" width="16" height="1" fill="#898989"></rect>
        </svg>
        <span class="toggle-btn icon-collapse position-absolute right-25p">
            <svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M4.18767 0.0921111L7.81732 4.65639C8.24162 5.18994 7.87956 6 7.21678 6L0.783223 6C0.120445 6 -0.241618 5.18994 0.182683 4.65639L3.81233 0.092111C3.91 -0.0307037 4.09 -0.0307036 4.18767 0.0921111Z"
                    fill="#2C2C2C"></path>
            </svg>
        </span>
    </div>

    <div id="product_data" class="collapse show txt-enable">
        @php
            $tabs = (new \App\Services\Product\Editor\ProductDataTabs($productForSelector))->tabs()['tabs'];
        @endphp

        <ul class="nav nav-tabs cus-tab custom-scroll" id="myTab" role="tablist">
            @foreach ($tabs as $tab)
                @if (isset($tab['visibility']) && $tab['visibility'] != '1')
                    @continue
                @endif

                @if (isset($tab['tab']))
                    {!! $tab['tab'] !!}
                @endif
            @endforeach
        </ul>

        <div class="tab-content shadow-none bg-transparent blockable loder-content" id="myTabContent">

            @doAction('before_product_editor_data_tab_content')

            @foreach ($tabs as $name => $tab)
                @if (isset($tab['visibility']) && $tab['visibility'] != '1')
                    @continue
                @endif

                @if (isset($tab['tab_content']))
                    @if (is_callable($tab['tab_content']))
                        {!! $tab['tab_content']() !!}
                    @else
                        @includeIf($tab['tab_content'])
                    @endif
                @endif
            @endforeach

            @doAction('after_product_editor_data_tab_content')
        </div>

    </div>
</div>
