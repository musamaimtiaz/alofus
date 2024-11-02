@php
    $offerFlag = $product->offerCheck();
    $outOfStock = $product->isOutOfStock();
    $outStock = false;
@endphp
<div class="w-full sm:w-1/2 lg:w-36% md:order-none ltr:sm:pr-2 rtl:sm:pl-2">
    @doAction('before_signle_product_summary_slider', $definedData)
    <div class="product-left mb-5 mb-lg-0 relative">
        <div class="swiper border rounded-md w-full swiper-container-main">
            <div class="swiper-wrapper" id="zoomImage">
                @foreach ($images as $ProductImage)
                    <div class="relative">
                        <div class="absolute z-10 left-3.5 top-3.5">
                            @if ($outOfStock['outOfStockVisibility'] == 1 && !$product->isVariableProduct())
                                @php $outStock = true @endphp
                                <p
                                    class="bg-pinks-2 relative z-20 h-4 text-reds-3 mb-2.5 w-max px-1.5 flex items-center rounded-sm leading-3 roboto-medium font-medium pt-2p text-8 whitespace-nowrap text-11">
                                    {{ __('Stock Out') }}
                                </p>
                            @endif
                            @if (isset($featured) && $outStock == false)
                                <p
                                    class="primary-bg-color h-5 w-max mb-2.5 justify-center text-white px-2 flex items-center text-center rounded-sm leading-3 roboto-medium font-medium text-11">
                                    {{ __('Featured') }}
                                </p>
                            @endif
                            @if ($review_average == 5 && $outStock == false)
                                <div
                                    class="flex justify-center items-center px-1.5 whitespace-nowrap mb-2.5 bg-green-5 h-5 leading-3 w-max roboto-medium font-medium text-white text-11 rounded-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                        viewBox="0 0 12 12" fill="none">
                                        <path
                                            d="M5 0L6.12257 3.45492H9.75528L6.81636 5.59017L7.93893 9.04508L5 6.90983L2.06107 9.04508L3.18364 5.59017L0.244718 3.45492H3.87743L5 0Z"
                                            fill="white" />
                                    </svg>
                                    <p>{{ __('Top Rated') }}</p>
                                </div>
                            @endif
                            @if ($offerFlag && !$product->isVariableProduct() && $outStock == false && !$product->isGroupedProduct())
                                <p
                                    class="primary-bg-color h-5 text-gray-12 px-2 mb-2.5 justify-center flex items-center rounded-sm leading-3 roboto-medium font-medium text-11 whitespace-nowrap uppercase w-max">
                                    {{ formatCurrencyAmount($product->getDiscountAmount()) }}% {{ __('off') }}
                                </p>
                            @endif
                        </div>
                    </div>

                    @php
                        $isvideo = false;
                        if (in_array(pathinfo($ProductImage, PATHINFO_EXTENSION), getFileExtensions(6))) {
                            $isVideo = true;
                            $src =
                                '
                                <video
                                    controls autoplay muted loop
                                    class="w-full h-[336px] md:h-[370px]"
                                    >
                                    <source src="' .
                                $ProductImage .
                                '" type="video/mp4">
                                </video>
                                ';
                        } else {
                            $isVideo = false;
                            $src =
                                '
                                <img class="swiper-slide-img neg-transition-scale" src="' .
                                $ProductImage .
                                '" alt="...">
                                ';
                        }
                    @endphp
                    <div class="swiper-slide minimum-height {{ $isVideo ? '' : 'zoom' }} neg-transition-scale w-full"
                        style="background-image: url({{ getBackgroundImage($ProductImage) }});">
                        {!! $src !!}
                    </div>
                @endforeach
            </div>
        </div>
        <!-- Swiper thumbnails -->
        <div dir="ltr" class="w-full flex justify-center items-center">
            @if (count($images) > 1)
                <div class="swiper-button-prev swiper-thumbsnail bg-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" viewBox="0 0 9 14"
                        fill="none">
                        <path
                            d="M2 7L1.29289 7.70711L0.585786 7L1.29289 6.29289L2 7ZM7.29289 13.7071L1.29289 7.70711L2.70711 6.29289L8.70711 12.2929L7.29289 13.7071ZM1.29289 6.29289L7.29289 0.292893L8.70711 1.70711L2.70711 7.70711L1.29289 6.29289Z"
                            fill="#898989" />
                    </svg>
                </div>
            @endif
            <div class="swiper product-slider gallery-thumbs mt-5">
                <div class="swiper-wrapper cursor-pointer" id="sliderImage">
                    @foreach ($images as $ProductImage)
                        @if (count($images) > 1)
                            @php
                                $isvideo = false;
                                if (in_array(pathinfo($ProductImage, PATHINFO_EXTENSION), getFileExtensions(6))) {
                                    $isVideo = true;
                                    $src =
                                        '
                                <video
                                    class="p-1.5 object-cover h-12 cursor-pointer"
                                    >
                                    <source src="' .
                                        $ProductImage .
                                        '" type="video/mp4">
                                </video>
                                ';
                                } else {
                                    $isVideo = false;
                                    $src =
                                        '
                                <img class="p-1.5 object-cover h-12 cursor-pointer" src="' .
                                        $ProductImage .
                                        '" alt="Image...">
                                ';
                                }
                            @endphp
                            <div
                                class="swiper-slide flex justify-center items-center border-gray-2 rounded-sm swiper-slide-thumbs">
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
    @doAction('after_signle_product_summary_slider', $definedData)
</div>
