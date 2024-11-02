<link rel="stylesheet" href="{{ asset('public/frontend/assets/swiper/swiper-bundle.min.css') }}">
<div id="item-view-load">
    <!--Overlay Effect-->
    <div class="fixed hidden items-center inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
        id="view-modal">
        <!--modal content-->
        <div class="relative mx-auto p-30p border shadow-lg rounded-lg bg-white w-11/12 lg:w-860p overflow-auto h-[500px] [@media(min-width:641px)]:h-auto" id="view-modal-main">
            @if (isset($productView))
                @php $stockDisplayFormat = preference('stock_display_format'); $lowStockThreshold = $product->getStockThreshold() @endphp
                <button class="absolute right-3 -mt-18p open-view-modal-close">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.512559 0.512559C1.19597 -0.170853 2.304 -0.170853 2.98741 0.512559L13.4873 11.0125C14.1707 11.6959 14.1707 12.8039 13.4873 13.4873C12.8039 14.1707 11.6959 14.1707 11.0125 13.4873L0.512559 2.98741C-0.170853 2.304 -0.170853 1.19597 0.512559 0.512559Z"
                            fill="#898989" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M13.4874 0.512559C12.804 -0.170853 11.696 -0.170853 11.0126 0.512559L0.512681 11.0125C-0.170731 11.6959 -0.170731 12.8039 0.512681 13.4873C1.19609 14.1707 2.30412 14.1707 2.98753 13.4873L13.4874 2.98741C14.1709 2.304 14.1709 1.19597 13.4874 0.512559Z"
                            fill="#898989" />
                    </svg>
                </button>
                <div class="placeholder-loader placeholder-loader-animation">
                    <div class="w-full">
                        <div class="sm:flex sm:gap-x-5 flex w-full bg-white p-2 rounded-md">
                            <div class="w-full sm:w-1/2">
                                <div data-placeholder class="mb-2 h-40 md:h-96 overflow-hidden relative bg-gray-200">
                                </div>
                                <div data-placeholder class="mb-2 h-10 sm:h-16 overflow-hidden relative bg-gray-200">
                                </div>

                            </div>
                            <div class="w-full sm:w-1/2 ltr:ml-4 rtl:mr-4">
                                <div data-placeholder class="h-5 sm:h-10 mb-2  relative bg-gray-200">
                                </div>
                                <div data-placeholder class="h-10 sm:h-14 mb-2  relative bg-gray-200">
                                </div>
                                <div data-placeholder
                                    class="h-5 sm:h-10 mb-4 w-52  relative bg-gray-200"></div>
                                <div data-placeholder
                                    class="h-5 sm:h-10 mb-3 w-40  relative bg-gray-200"></div>
                                <div data-placeholder
                                    class="h-5 sm:h-10 mb-3 w-40  relative bg-gray-200"></div>
                                <div data-placeholder
                                    class="h-5 sm:h-10 mb-3 w-40 relative bg-gray-200"></div>
                                <div data-placeholder class="h-5 sm:h-10 mb-2 relative bg-gray-200">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="grid grid-cols-1 min-[641px]:grid-cols-2 [@media(min-width:641px)]:grid-cols-2 item-view-content">
                        {{-- Slider --}}
                        <div class="w-full [@media(min-width:641px)]:w-[93%] xxs:w-72% xxs:transform xxs:translate-x-19%">
                            <div class="product-left md:mb-0 relative">
                                <div class="swiper border rounded-md w-full swiper-container-mainV">
                                    <div class="swiper-wrapper" id="zoomImageV">
                                        @foreach ($images as $ProductImage)
                                            <div class="relative">
                                                <div class="absolute z-10 ltr:left-3.5 rtl:right-3.5 top-3.5">
                                                    @if (isset($featured))
                                                        <p
                                                            class="primary-bg-color py-1 mb-2.5 justify-center text-white px-2 flex items-center text-center rounded-sm leading-3 roboto-medium font-medium text-11 whitespace-nowrap w-max">
                                                            {{ __('Featured') }}</p>
                                                    @endif
                                                    @if ($review_average == 5)
                                                        <div
                                                            class="flex justify-center items-center px-1.5 whitespace-nowrap mb-2.5 bg-green-5 py-1 leading-3 roboto-medium font-medium text-white text-11 rounded-sm w-max">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                                height="12" viewBox="0 0 12 12" fill="none">
                                                                <path
                                                                    d="M5 0L6.12257 3.45492H9.75528L6.81636 5.59017L7.93893 9.04508L5 6.90983L2.06107 9.04508L3.18364 5.59017L0.244718 3.45492H3.87743L5 0Z"
                                                                    fill="white" />
                                                            </svg>
                                                            <p>{{ __('Top Rated') }}</p>
                                                        </div>
                                                    @endif
                                                    @if ($offerFlag && !$product->isVariableProduct())
                                                        <p
                                                            class="primary-bg-color py-1 text-gray-12 px-2 mb-2.5 justify-center flex items-center rounded-sm leading-3 roboto-medium font-medium text-11 whitespace-nowrap uppercase w-max">
                                                            {{ formatCurrencyAmount($product->getDiscountAmount()) }}%
                                                            {{ __('off') }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            @php
                                            $isvideo = false;
                                                if(in_array(pathinfo($ProductImage, PATHINFO_EXTENSION), getFileExtensions(6))) {
                                                    $isVideo = true;
                                                    $src = '
                                                    <video
                                                        controls autoplay muted loop
                                                        class="w-full h-[336px] md:h-[370px]"
                                                        >
                                                        <source src="' . $ProductImage . '" type="video/mp4">
                                                    </video>
                                                    ';

                                                } else{
                                                    $isVideo = false;
                                                    $src = '
                                                    <img class="swiper-slide-img neg-transition-scale" src="' . $ProductImage . '" alt="...">
                                                    ';
                                                }
                                            @endphp
                                            <div class="swiper-slide minimum-height {{ $isVideo ? '' : 'zoom' }} neg-transition-scale" style="background-image: url({{ getBackgroundImage($ProductImage) }});">
                                                {!! $src !!}
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                                <!-- Swiper thumbnails -->
                                <div dir="ltr" class="w-full flex justify-center items-center">
                                    @if (count($images) > 1)
                                        <div class="swiper-button-prev swiper-thumbsnail bg-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14"
                                                viewBox="0 0 9 14" fill="none">
                                                <path
                                                    d="M2 7L1.29289 7.70711L0.585786 7L1.29289 6.29289L2 7ZM7.29289 13.7071L1.29289 7.70711L2.70711 6.29289L8.70711 12.2929L7.29289 13.7071ZM1.29289 6.29289L7.29289 0.292893L8.70711 1.70711L2.70711 7.70711L1.29289 6.29289Z"
                                                    fill="#898989" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="swiper product-slider gallery-thumbsV mt-5">
                                        <div class="swiper-wrapper cursor-pointer" id="sliderImageV">
                                            @foreach ($images as $ProductImage)
                                            @if (count($images) > 1)
                                                <div class="w-12 swiper-slide flex justify-center items-center border-gray-2 rounded-sm swiper-slide-thumbs">
                                                    @php
                                                        $isvideo = false;
                                                            if(in_array(pathinfo($ProductImage, PATHINFO_EXTENSION), getFileExtensions(6))) {
                                                                $isVideo = true;
                                                                $src = '
                                                                <video
                                                                    class="p-1.5 object-cover h-12 cursor-pointer neg-transition-scale"
                                                                    >
                                                                    <source src="' . $ProductImage . '" type="video/mp4">
                                                                </video>
                                                                ';

                                                            } else{
                                                                $isVideo = false;
                                                                $src = '
                                                                <img class="p-1.5 object-cover h-12 cursor-pointer neg-transition-scale" src="' . $ProductImage . '" alt="Image...">
                                                                ';
                                                            }
                                                    @endphp
                                                    {!! $src !!}
                                                </div>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    @if (count($images) > 1)
                                        <div class="swiper-button-next swiper-thumbsnail bg-white">
                                            <svg width="9" height="14" viewBox="0 0 9 14" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M7 7L7.70711 7.70711L8.41421 7L7.70711 6.29289L7 7ZM1.70711 13.7071L7.70711 7.70711L6.29289 6.29289L0.292893 12.2929L1.70711 13.7071ZM7.70711 6.29289L1.70711 0.292893L0.292893 1.70711L6.29289 7.70711L7.70711 6.29289Z"
                                                    fill="#898989" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- end slider --}}
                        <div class="ltr:md:-ml-2 rtl:md:-mr-2 relative">
                            <div>
                                <div class="flex flex-wrap mt-3 mt-md-0">
                                    @if(!empty(end($categories)))
                                    <div class="flex-initial px-2 text-gray-10 bg-gray-11 mb-2 rounded-sm ltr:mr-2 rtl:ml-2">
                                        <p class="roboto-medium font-medium text-xs py-1">{{ __('Category') }}: {{ end($categories) }}</p>
                                    </div>
                                    @endif
                                    @if(!empty($brand))
                                        <div class="flex-initial px-2 text-gray-10 bg-gray-11 mb-2 rounded-sm ltr:mr-2 rtl:ml-2">
                                            <p class="roboto-medium font-medium text-xs py-1">{{ __('Brand') }}: {{ $brand }}</p>
                                        </div>
                                    @endif
                                    @if(!empty($sku))
                                    <div class="flex-initial px-2 text-gray-10 bg-gray-11 mb-2 rounded-sm ltr:mr-2 rtl:ml-2">
                                        <p class="roboto-medium font-medium text-xs py-1">{{ __('SKU') }}: {{ $sku }}</p>
                                    </div>
                                    @endif
                                </div>
                                <!-- Product name -->
                                <div class="mt-3">
                                    <h2
                                        class="text-gray-12 dm-bold font-bold text-sm sm:text-base md:text-lg lg:text-xl 2xl:text-22 -mt-1">
                                        {{ $name }}</h2>
                                </div>
                                <div class="flex md:flex-col flex-wrap lg:flex-row justify-start items-center md:items-start lg:justify-start lg:items-center gap-x-4 md:gap-x-0 lg:gap-x-4 md:mt-3 mt-3">
                                    {{-- ratting --}}
                                    @if($reviews_allowed == 1 && preference('reviews_enable_product_review') == 1)
                                    @include('site.layouts.section.product-details.rating')
                                    @endif
                                    <div class="flex justify-start items-center x:gap-x-3 gap-x-4 mt-0 md:mt-4 lg:mt-0">
                                        {{-- share button --}}
                                        @include('site.layouts.section.product-details.share_button')

                                        @if (preference('wishlist'))
                                            @php
                                                $active = false;
                                                if (auth()->user()) {
                                                    foreach (auth()->user()->wishlist as $key => $wishlist) {
                                                        if ($id == $wishlist->product_id) {
                                                            $active = true;
                                                        }
                                                    }
                                                }
                                            @endphp
                                            {{-- Wish-list --}}
                                            <div>
                                                <div class="flex items-center h-7 w-7 p-1 cursor-pointer text-transparent wishlist" data-id="{{ $id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $active ? 'color_fill svg-bg ' : 'text-gray-10' }} -mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- compare --}}
                                        @if (preference('compare'))
                                            <div data-itemId="{{ $id }}" class="h-7 w-7 p-1 compareText cursor-pointer {{ isCompared($id) ? 'compare-remove' : 'add-to-compare' }}">
                                                <div>
                                                    <svg width="17" height="17" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M2.84923 0.0139465C2.80785 0.0214701 2.67995 0.0478029 2.5671 0.0703735C2.45424 0.0929451 2.2022 0.186991 2.00658 0.281036C1.7094 0.423985 1.59655 0.502984 1.34074 0.758788C1.08494 1.01835 1.00594 1.12745 0.862989 1.42463C0.641041 1.88734 0.592138 2.10552 0.595899 2.60585C0.603423 3.23031 0.783991 3.72311 1.19779 4.22719C1.44983 4.5319 1.93887 4.85918 2.34891 4.99084L2.4881 5.03599L2.50315 8.18463C2.51819 11.6831 2.50315 11.4875 2.77776 12.048C3.10128 12.7139 3.72198 13.218 4.45177 13.4061C4.64739 13.4587 4.94081 13.4738 6.02422 13.485L7.3559 13.5039L6.85934 14.0004L6.36654 14.4932L6.81796 14.9446L7.26938 15.3961L8.36407 14.3051C8.96597 13.7032 9.48134 13.1615 9.51143 13.0938C9.57914 12.9396 9.57914 12.7364 9.51143 12.5822C9.48134 12.5145 8.96597 11.9728 8.36407 11.3709L7.26938 10.28L6.81796 10.7314L6.36654 11.1828L6.8631 11.6831L7.36343 12.1835L6.02798 12.1722L4.69253 12.1609L4.50444 12.0593C4.27873 11.9389 4.03797 11.6944 3.91759 11.4649L3.82731 11.2957L3.81602 8.16583L3.8085 5.03975L3.94769 4.99084C5.08376 4.62595 5.83612 3.46354 5.69694 2.3049C5.56527 1.23654 4.88438 0.420224 3.86493 0.107992C3.61288 0.0289936 3.01475 -0.0274334 2.84923 0.0139465ZM3.45113 1.32682C4.04173 1.48106 4.41792 1.96257 4.41792 2.56823C4.41792 2.86917 4.3502 3.08736 4.18092 3.31683C3.94393 3.65163 3.57903 3.8322 3.15018 3.83596C2.54076 3.83596 2.05925 3.45978 1.90502 2.85413C1.73949 2.19204 2.14953 1.51492 2.83042 1.33059C3.09751 1.25911 3.18404 1.25911 3.45113 1.32682Z" fill="#898989"/>
                                                        <path d="M8.18316 1.12749C7.57751 1.73315 7.0659 2.27861 7.04333 2.33504C6.99066 2.48175 6.99442 2.68113 7.05838 2.82408C7.08847 2.89179 7.60384 3.43349 8.20573 4.03539L9.30042 5.12632L9.75184 4.6749L10.2033 4.22348L9.7067 3.72315L9.20638 3.22283L10.5418 3.23412L11.8773 3.2454L12.0654 3.34697C12.2911 3.46735 12.5318 3.71187 12.6522 3.94134L12.7425 4.11062L12.7538 7.24046L12.7613 10.3665L12.6221 10.4154C12.1669 10.5622 11.6666 10.912 11.3845 11.2882C11.0271 11.7584 10.8653 12.2437 10.8653 12.8381C10.8653 13.5528 11.1099 14.1397 11.6139 14.6437C11.9488 14.9785 12.2535 15.1629 12.7237 15.3058C13.1224 15.43 13.7168 15.43 14.1156 15.3058C14.9921 15.035 15.6165 14.418 15.8799 13.5566C16.2673 12.2926 15.5676 10.9082 14.3074 10.4493L14.0817 10.3665L14.0667 7.2367C14.0554 4.41157 14.0479 4.08805 13.9914 3.8661C13.792 3.13255 13.2692 2.4968 12.5995 2.17704C12.118 1.95133 12.0353 1.94005 10.5644 1.92124L9.2139 1.90243L9.71046 1.40587L10.2033 0.91307L9.75937 0.469173C9.51861 0.228417 9.30795 0.0290403 9.30042 0.0290403C9.28914 0.0290403 8.78505 0.525601 8.18316 1.12749ZM13.8598 11.638C14.2472 11.7735 14.5519 12.1233 14.6648 12.5522C14.8943 13.455 14.0366 14.3127 13.1337 14.0832C12.3099 13.8726 11.9111 13.0186 12.2798 12.2587C12.5544 11.6945 13.2503 11.4199 13.8598 11.638Z" fill="#898989"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div id="countDownV" class="mb-2 display-none">
                                    <p class="text-sm mt-1.5 pt-1p dm-sans font-medium text-gray-12">{{ __('Offer end in') }}:</p>
                                    <div class="w-full flex roboto-medium mt-3">
                                        <div class="border border-dashed border-gray-12 rounded primary-bg-color">
                                            <p class="text-center px-2 text-sm text-black py-1" id="count_daysV"></p>
                                        </div>
                                        <div class="border border-dashed border-gray-12 rounded primary-bg-color ltr:ml-2.5 rtl:mr-2.5">
                                            <p class="text-center px-2 text-sm text-black py-1" id="count_othersV"></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Price -->
                                <div class="flex">
                                    @if ($product->isVariableProduct())
                                        @php
                                            $sale_price = $sale_price[0] ?? 0;
                                            $regular_price = $regular_price[0] ?? 0;
                                        @endphp
                                        <span class="text-2.5xl dm-bold text-gray-12" id="varMinMaxPriceV">{{ formatNumber($filterVariation['min']) }}
                                            - {{ formatNumber($filterVariation['max']) }}</span>
                                    @endif
                                </div>
                                <div class="flex">
                                    @if ($offerFlag)
                                        <p class="dm-bold">
                                            <span
                                                class="text-2.5xl text-gray-12 {{ $product->isVariableProduct() ? 'display-none' : '' }}"
                                                id="item_priceV">{{ !$product->isVariableProduct() ? $product->priceWithTax($displayPrice, 'sale') : $sale_price }}</span>
                                            <span class="text-lg line-through text-gray-10 ltr:pl-1 rtl:pr-1 mt-0.5 {{ $product->isVariableProduct() ? 'display-none' : '' }}">{{ $type != 'Variable Product' ? $product->priceWithTax($displayPrice, 'regular') : $regular_price }}</span>
                                        </p>
                                    @else
                                        <p class="dm-bold">
                                            <span class="text-xl md:text-2.5xl text-gray-12 {{ $product->isVariableProduct() ? 'display-none' : '' }}"
                                                id="item_priceV">{{ !$product->isVariableProduct() ? $product->priceWithTax($displayPrice, 'regular') : $regular_price }}</span>
                                        </p>
                                    @endif
                                </div>
                                <div>
                                    @if ($product->isVariableProduct() && is_array($filterVariation) && count($filterVariation) > 0)
                                        @php
                                            $count = 0;
                                            $position = 1;
                                        @endphp
                                        @foreach ($filterVariation['attrbuteIdsWithKey'] as $key => $attrbuteIdWithKey)
                                            <div class="flex mt-18p option-select items-center">
                                                <h4 class="text-gray-12 text-sm font-medium roboto-medium ltr:mr-2 rtl:ml-2 w-1/5">
                                                    {{ $attributes[$key]['name'] }}
                                                </h4>
                                                <select name="option[]"
                                                    class="option_priceV outline-none rounded border border-gray-2 z-0 block whitespace-no-wrap select2 text-gray-10 text-sm font-medium roboto-medium bg-white w-36 item-variationsV cursor-pointer">
                                                    <option class="border-none"
                                                        data-position="{{ $position }}" value="">{{ __('Select One') }}
                                                    </option>
                                                    @foreach ($attrbuteIdWithKey as $value)
                                                        @php
                                                            if (isset($attribute_values[$key])) {
                                                                $details = $attribute_values[$key]->where('id', $value)->first();
                                                            } else {
                                                                $details = null;
                                                            }
                                                            $backValue = isset($details) ? $details->id : $value;
                                                        @endphp
                                                        <option class="border-none h-10"
                                                            value="{{ isset($details) ? $details->value : $value }}"
                                                            data-id="{{ isset($details) ? $details->id : $value }}"
                                                            {{ isset($default_attributes[$key]) && $default_attributes[$key] == $backValue ? 'selected' : '' }}
                                                            data-position="{{ $position }}">
                                                            {{ isset($details) ? $details->value : $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @php $position++; @endphp
                                        @endforeach
                                        <label class="error display-none" id="availabilityV">{{ __('Not Available') }}</label>
                                     <div class="flex flex-col md:flex-row justify-between md:items-center mt-22p mb-5 ltr:md:mr-10 rtl:md:ml-10">
                                        <div class="flex flex-col md:flex-row justify-start md:items-center">
                                            <span class="text-gray-12 text-sm roboto-medium leading-4 display-none font-medium" id="stock_qtyV">
                                            </span>
                                        </div>
                                        <a href="javascript:void(0)" class="flex md:justify-between justify-start md:mt-0 mt-5 display-none items-center" id="clear-variationV">
                                            <span class="text-gray-10 text-sm roboto-medium leading-4 font-medium ltr:mr-1 rtl:ml-1">{{ __('Clear') }}</span>
                                        <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.8617 9.52856L9.80451 10.4714L7.60925 12.6666L9.80451 14.8619L8.8617 15.8047L5.72363 12.6666L8.8617 9.52856Z" fill="#898989"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.7078 5.08931C11.3889 5.2734 11.2797 5.68113 11.4638 5.99999C11.8148 6.60807 11.9997 7.29784 11.9997 7.99999C11.9997 8.70214 11.8148 9.39191 11.4638 9.99999C11.1127 10.6081 10.6078 11.113 9.99967 11.4641C9.3916 11.8152 8.70182 12 7.99967 12C7.63149 12 7.33301 12.2985 7.33301 12.6667C7.33301 13.0348 7.63149 13.3333 7.99967 13.3333C8.93587 13.3333 9.85557 13.0869 10.6663 12.6188C11.4771 12.1507 12.1504 11.4774 12.6185 10.6667C13.0866 9.85589 13.333 8.93619 13.333 7.99999C13.333 7.06379 13.0866 6.14409 12.6185 5.33332C12.4344 5.01446 12.0267 4.90521 11.7078 5.08931Z" fill="#898989"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.1383 6.47144L6.19549 5.52863L8.39075 3.33336L6.19549 1.1381L7.1383 0.195293L10.2764 3.33336L7.1383 6.47144Z" fill="#898989"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.29221 10.9107C4.61107 10.7266 4.72032 10.3189 4.53622 10C4.18515 9.39193 4.00033 8.70216 4.00033 8.00001C4.00033 7.29786 4.18515 6.60809 4.53622 6.00001C4.8873 5.39193 5.39225 4.88698 6.00033 4.53591C6.6084 4.18484 7.29818 4.00001 8.00033 4.00001C8.36851 4.00001 8.66699 3.70153 8.66699 3.33334C8.66699 2.96515 8.36851 2.66668 8.00033 2.66668C7.06413 2.66668 6.14443 2.91311 5.33366 3.38121C4.52289 3.84931 3.84962 4.52257 3.38152 5.33334C2.91343 6.14411 2.66699 7.06381 2.66699 8.00001C2.66699 8.93621 2.91343 9.85591 3.38152 10.6667C3.56562 10.9855 3.97335 11.0948 4.29221 10.9107Z" fill="#898989"/>
                                            </svg></span>
                                        </a>
                                   </div>
                                    @elseif($manage_stocks == 1 && $stock_status == 'In Stock' && $stock_hide == 0 && $stock_quantity >= 0 && !is_null($stock_quantity))
                                        @if($stockDisplayFormat == 'always_show')
                                            <div class="mt-22p">
                                                <span class="text-gray-12 ltr:ml-1 rtl:mr-1 text-sm roboto-medium leading-4 font-medium" id="stock_qtyV"><span class="text-green-1 ltr:mr-2.5 rtl:ml-2.5 leading-4 bg-green-2 px-4 py-2 text-sm roboto-medium font-medium rounded">{{ __('In Stock') }}</span> <span class="ltr:ml-1 rtl:mr-1">{{ __(':x items remaining', ['x' => $stock_quantity]) }}</span> </span>
                                            </div>
                                        @elseif($stockDisplayFormat == 'sometime_show' && $stock_quantity <= $lowStockThreshold && $lowStockThreshold != 0)
                                            <div class="mt-22p">
                                                <span class="text-gray-12 text-sm roboto-medium font-medium" id="stock_qty">{{__('Only :x left in stock.', ['x' => $stock_quantity])}}</span>
                                            </div>
                                        @endif
                                    @elseif(($manage_stocks == 0 && $stock_status == 'Out Of Stock') ||
                                        ($manage_stocks == 1 && $stock_hide == 0 && $stock_quantity <= 0 && $backorders == 0))
                                        @if($stockDisplayFormat == 'always_show' || $stockDisplayFormat == 'sometime_show')
                                            <div Class="mt-22p">
                                                <span class="text-reds-3 ltr:mr-1 rtl:ml-1 leading-4 bg-pinks-2 px-4 py-2 text-sm roboto-medium font-medium rounded" id="stock_qtyV">{{ __('Out Of Stock') }}</span>
                                            </div>
                                        @endif
                                    @endif
                                </div>

                                    <div id="b2b_tableV">
                                        @includeIf('b2b::site.product-view')
                                    </div>

                            </div>
                            <div
                                class="flex flex-col md:flex-row sm:mt-4 justify-start mt-5 bottom-0 w-full">
                                <!-- Qty section -->
                                @if (!$product->isExternalProduct() && isset($meta['individual_sale']) && $meta['individual_sale'] == 0)
                                    <div class="flex items-center sm:block">
                                        <p class="sm:hidden w-1/5 text-sm roboto-medium text-gray-12 ltr:mr-2 rtl:ml-2">Qty:</p>
                                        <div class="flex flex-wrap justify-start items-center space-x-5">
                                            <div class="flex flex-wrap w-135p h-12 text-xl border rounded bg-white"
                                                id="cart-item-details-{{ $code }}">
                                                <a href="javascript:void(0)"
                                                    class="cart-item-qty-dec m-auto text-2xl flex items-center font-thin text-gray-600 hover:text-gray-700 p-2 rounded-l cursor-pointer outline-none text-center"
                                                    data-itemCode={{ $code }}><span class="inline-block">
                                                        <svg width="13" height="2"
                                                            viewBox="0 0 13 2" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M13 2H0L0 0H13V2Z" fill="#898989" />
                                                        </svg>
                                                    </span>
                                                </a>

                                                <div
                                                    class="flex items-center dm-bold font-bold text-20 text-gray-12 text-center cart-item-quantity">
                                                    1</div>
                                                <a href="javascript:void(0)" class="cart-item-qty-inc m-auto flex items-center text-2xl font-thin text-gray-600 hover:text-gray-700 p-2 rounded-r cursor-pointer text-center" data-type="{{ $type ?? \App\Enums\ProductType::$Simple }}" data-itemCode={{ $code }}>
                                                    <span class="inline-block">
                                                        <svg width="15" height="15" viewBox="0 0 15 15"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M8.87909 -8.02595e-08L8.87909 14.077L7.04297 14.077L7.04297 0L8.87909 -8.02595e-08Z"
                                                                fill="#898989" />
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M15 7.95643L0.923044 7.95642L0.923044 6.1203L15 6.1203L15 7.95643Z"
                                                                fill="#898989" />
                                                        </svg>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="mt-3 md:mt-0 w-full ltr:md:ml-4 rtl:md:mr-4">
                                    @if ($product->isExternalProduct())
                                        @if (isset($external_products['url']) && $external_products['url'] != '')
                                            <a href="{{ $external_products['url'] }}" target="_blank">
                                                <button
                                                    class="primary-bg-color font-bold w-full h-11 rounded flex justify-center items-center">
                                                    <svg width="20" height="19" viewBox="0 0 20 19"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M5.88135 10C5.32906 10 4.88135 9.55228 4.88135 9L4.88135 5C4.88135 2.23858 7.11992 -1.25946e-06 9.88135 -6.82991e-07C12.6428 -1.0602e-06 14.8813 2.23858 14.8813 5L14.8813 9C14.8813 9.55228 14.4336 10 13.8813 10C13.3291 10 12.8813 9.55228 12.8813 9L12.8813 5C12.8813 3.34315 11.5382 2 9.88135 2C8.22449 2 6.88135 3.34314 6.88135 5L6.88135 9C6.88135 9.55228 6.43363 10 5.88135 10Z"
                                                            fill="#2c2c2c" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M5.49955 5C5.52029 5 5.5411 5 5.56198 5L14.2634 5C15.0834 4.99996 15.7934 4.99991 16.3668 5.07436C16.983 5.15438 17.5746 5.33421 18.0725 5.79236C18.5704 6.25051 18.7988 6.82513 18.9297 7.4326C19.0515 7.99774 19.1104 8.70533 19.1785 9.52254L19.6975 15.7509C19.6991 15.77 19.7007 15.7891 19.7023 15.8081C19.7404 16.2651 19.7772 16.7051 19.7573 17.069C19.7351 17.4768 19.6367 17.9518 19.2664 18.3542C18.8961 18.7567 18.431 18.8941 18.0264 18.9502C17.6654 19.0002 17.2239 19.0001 16.7653 19C16.7462 19 16.727 19 16.7079 19H3.05505C3.03587 19 3.01671 19 2.99759 19C2.53902 19.0001 2.09749 19.0002 1.73653 18.9502C1.33195 18.8941 0.866803 18.7567 0.496488 18.3542C0.126173 17.9518 0.0278088 17.4768 0.00556347 17.069C-0.0142834 16.7051 0.0224672 16.2651 0.0606358 15.8081C0.0622278 15.7891 0.0638222 15.77 0.0654151 15.7509L0.579256 9.58478C0.58099 9.56397 0.582717 9.54323 0.584438 9.52256C0.652492 8.70535 0.711417 7.99775 0.833217 7.4326C0.964137 6.82513 1.19247 6.25051 1.69039 5.79236C2.18831 5.33421 2.77991 5.15438 3.39615 5.07436C3.96946 4.99991 4.67951 4.99996 5.49955 5ZM3.6537 7.05771C3.25295 7.10975 3.12078 7.19404 3.04461 7.26412C2.96844 7.33421 2.87347 7.45892 2.78833 7.85396C2.69715 8.27703 2.64713 8.85352 2.57235 9.75087L2.05851 15.917C2.01383 16.4531 1.99123 16.7516 2.00259 16.96C2.00274 16.9627 2.00289 16.9654 2.00305 16.968C2.00562 16.9684 2.00825 16.9687 2.01093 16.9691C2.21772 16.9977 2.51706 17 3.05505 17H16.7079C17.2458 17 17.5452 16.9977 17.752 16.9691C17.7547 16.9687 17.7573 16.9684 17.7599 16.968C17.76 16.9654 17.7602 16.9627 17.7603 16.96C17.7717 16.7516 17.7491 16.4531 17.7044 15.917L17.1906 9.75087C17.1158 8.85352 17.0658 8.27703 16.9746 7.85396C16.8894 7.45892 16.7945 7.33421 16.7183 7.26412C16.6421 7.19404 16.51 7.10975 16.1092 7.05771C15.68 7.00198 15.1014 7 14.2009 7H5.56198C4.66152 7 4.08288 7.00198 3.6537 7.05771Z"
                                                            fill="#2c2c2c" />
                                                    </svg>
                                                    <span
                                                        class="ltr:pl-2 rtl:pr-2 p-5p dm-bold font-bold text-gray-12 text-lg">{{ $external_products['text'] ?? __('Buy Product') }}</span>
                                                </button>
                                            </a>
                                        @endif
                                    @else
                                        <a href="javascript:void(0)" class="add-to-cart cart-details-page"
                                            id="item-add-to-cart" data-itemCode={{ $code }}>
                                            <button
                                                class="primary-bg-color font-bold w-full lg:px-5 h-12 rounded flex justify-center items-center">
                                                <svg width="20" height="19" viewBox="0 0 20 19"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.88135 10C5.32906 10 4.88135 9.55228 4.88135 9L4.88135 5C4.88135 2.23858 7.11992 -1.25946e-06 9.88135 -6.82991e-07C12.6428 -1.0602e-06 14.8813 2.23858 14.8813 5L14.8813 9C14.8813 9.55228 14.4336 10 13.8813 10C13.3291 10 12.8813 9.55228 12.8813 9L12.8813 5C12.8813 3.34315 11.5382 2 9.88135 2C8.22449 2 6.88135 3.34314 6.88135 5L6.88135 9C6.88135 9.55228 6.43363 10 5.88135 10Z"
                                                        fill="#2c2c2c" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.49955 5C5.52029 5 5.5411 5 5.56198 5L14.2634 5C15.0834 4.99996 15.7934 4.99991 16.3668 5.07436C16.983 5.15438 17.5746 5.33421 18.0725 5.79236C18.5704 6.25051 18.7988 6.82513 18.9297 7.4326C19.0515 7.99774 19.1104 8.70533 19.1785 9.52254L19.6975 15.7509C19.6991 15.77 19.7007 15.7891 19.7023 15.8081C19.7404 16.2651 19.7772 16.7051 19.7573 17.069C19.7351 17.4768 19.6367 17.9518 19.2664 18.3542C18.8961 18.7567 18.431 18.8941 18.0264 18.9502C17.6654 19.0002 17.2239 19.0001 16.7653 19C16.7462 19 16.727 19 16.7079 19H3.05505C3.03587 19 3.01671 19 2.99759 19C2.53902 19.0001 2.09749 19.0002 1.73653 18.9502C1.33195 18.8941 0.866803 18.7567 0.496488 18.3542C0.126173 17.9518 0.0278088 17.4768 0.00556347 17.069C-0.0142834 16.7051 0.0224672 16.2651 0.0606358 15.8081C0.0622278 15.7891 0.0638222 15.77 0.0654151 15.7509L0.579256 9.58478C0.58099 9.56397 0.582717 9.54323 0.584438 9.52256C0.652492 8.70535 0.711417 7.99775 0.833217 7.4326C0.964137 6.82513 1.19247 6.25051 1.69039 5.79236C2.18831 5.33421 2.77991 5.15438 3.39615 5.07436C3.96946 4.99991 4.67951 4.99996 5.49955 5ZM3.6537 7.05771C3.25295 7.10975 3.12078 7.19404 3.04461 7.26412C2.96844 7.33421 2.87347 7.45892 2.78833 7.85396C2.69715 8.27703 2.64713 8.85352 2.57235 9.75087L2.05851 15.917C2.01383 16.4531 1.99123 16.7516 2.00259 16.96C2.00274 16.9627 2.00289 16.9654 2.00305 16.968C2.00562 16.9684 2.00825 16.9687 2.01093 16.9691C2.21772 16.9977 2.51706 17 3.05505 17H16.7079C17.2458 17 17.5452 16.9977 17.752 16.9691C17.7547 16.9687 17.7573 16.9684 17.7599 16.968C17.76 16.9654 17.7602 16.9627 17.7603 16.96C17.7717 16.7516 17.7491 16.4531 17.7044 15.917L17.1906 9.75087C17.1158 8.85352 17.0658 8.27703 16.9746 7.85396C16.8894 7.45892 16.7945 7.33421 16.7183 7.26412C16.6421 7.19404 16.51 7.10975 16.1092 7.05771C15.68 7.00198 15.1014 7 14.2009 7H5.56198C4.66152 7 4.08288 7.00198 3.6537 7.05771Z"
                                                        fill="#2c2c2c" />
                                                </svg>
                                                <span
                                                    class="p-5p dm-bold font-bold text-gray-12 text-lg whitespace-nowrap ltr:pl-2 rtl:pr-2">{{ __('Add to Cart') }}</span>
                                            </button>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="flex placeholder-loader-animation">
                    <div class="w-full">
                    <div class="sm:flex sm:gap-x-5  flex w-full bg-white p-2 rounded-md">
                        <div class="w-full sm:w-1/2">
                            <div data-placeholder class="mb-2 h-40 md:h-96 overflow-hidden relative bg-gray-200"></div>
                            <div data-placeholder class="mb-2 h-10 sm:h-16 overflow-hidden relative bg-gray-200"></div>

                        </div>
                        <div class="w-full sm:w-1/2 ltr:ml-4 rtl:mr-4">
                            <div data-placeholder class="h-5 sm:h-10 mb-4 w-52  relative bg-gray-200"></div>
                            <div data-placeholder class="h-10 sm:h-14 mb-2  relative bg-gray-200"></div>
                            <div data-placeholder class="h-5 sm:h-10 mb-4 w-52  relative bg-gray-200">
                            </div>
                            <div data-placeholder class="h-5 sm:h-10 mb-3 w-40  relative bg-gray-200">
                            </div>
                            <div data-placeholder class="h-5 sm:h-10 mb-3 w-40  relative bg-gray-200">
                            </div>
                            <div data-placeholder class="h-5 sm:h-10 mb-3 w-40  relative bg-gray-200">
                            </div>
                            <div data-placeholder class="h-5 sm:h-10 mb-2 relative bg-gray-200"></div>
                        </div>
                    </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

    @php
        $allImage = [];
        if (isset($images)) {
            foreach ($images as $im) {
                $allImage[] = getBackgroundImage($im);
            }
        }
        $format = getFormatedCountdown();
        $formatSaleTo = date($format, strtotime(strtr($sale_to ?? null, " ", '')));
    @endphp
    <script>
        var attributePriceWithId = '{!! json_encode($filterVariation['attributePriceWithId'] ?? null) !!}';
        var defaultImages = '{!! json_encode($allImage) !!}';
        var slideImagecount = {{ isset($images) ? count($images) : 0 }};
        var possbileVariations = '{!! json_encode($filterVariation['possibleVariation'] ?? null) !!}';
        itemType = "{{ $type ?? \App\Enums\ProductType::$Simple }}";
        isManageStock = "{{ $manage_stocks ?? null }}";
        stockQty = "{{ $stock_quantity ?? null }}";
        qty = 1;
        backOrders = "{{ $backorders ?? 0 }}";
        var stockHide = "{{ $stock_hide ?? 0 }}";
        var featured = "{{ isset($featured) ? 1 : 0 }}";
        var reviewAvg = "{{ $review_average ?? 0 }}";
        var offerFlag = "{{ $offerFlag ?? null }}";
        var formatedSaleTo = "{{ $formatSaleTo }}";
        var stockDisplayFormat = "{{ preference('stock_display_format') }}"
        var videoExtensions = @json(getFileExtensions(6));
    </script>
    <script src="{{ asset('public/frontend/assets/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/product-view.min.js') }}"></script>
