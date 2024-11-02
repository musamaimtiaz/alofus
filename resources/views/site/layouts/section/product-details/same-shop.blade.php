@if (count($sameShop) > 0)
<div class="mt-15p md:mt-30p">
    <p class="font-medium dm-sans text-base md:text-17 text-gray-12">{{ __('More Products From Them') }}</p>
    <div class="mt-2 md:mt-3 lg:mt-3 lg:flex-col flex overflow-auto gap-5 delivery-scrollbar">
        @foreach ($sameShop as $item)
            @php
                $offerFlag = $item->offerCheck();
                $outOfStock = $item->isOutOfStock();
            @endphp
        @if($outOfStock['isApprove'])
             <div class="flex gap-x-3.5 md:gap-x-5 md:mb-5">
                <div class="md:w-1/3 md:h-24">
                    <div class="relative product-hover">
                        <div class="flex justify-center bg-gray-11 w-84p rounded">
                            <div class="absolute top-1.5 ltr:left-1.5 rtl:right-1.5">
                                @php $outStock = false; @endphp
                                @if($outOfStock['outOfStockVisibility'] == 1)
                                    @php $outStock = true @endphp
                                    <p class="bg-pinks-2 mb-1 z-30 relative text-reds-3 px-1.5 py-1 flex items-center justify-center rounded-sm leading-3 roboto-medium font-medium text-8 w-14 break-all">{{ __('Stock Out') }}</p>
                                @endif
                                @if(isset($item->featured) && $outStock == false)
                                    <p class="primary-bg-color z-30 relative w-16 py-1 text-white px-1.5 break-all flex mb-1 items-center justify-center rounded-sm leading-3 roboto-medium font-medium text-xss text-center">{{ __('Featured') }}</p>
                                @endif
                                @if($item->review_average == 5 && $outStock == false)
                                    <div class="flex z-30 relative items-center px-1.5 mb-1 bg-green-5 py-1 rounded-sm w-16 break-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
                                            <path d="M5 0L6.12257 3.45492H9.75528L6.81636 5.59017L7.93893 9.04508L5 6.90983L2.06107 9.04508L3.18364 5.59017L0.244718 3.45492H3.87743L5 0Z" fill="white"/>
                                        </svg>
                                        <p class="leading-3 roboto-medium font-medium text-white text-8">{{ __('Top Rated') }}</p>
                                    </div>
                                @endif
                                @if($offerFlag && !$item->isVariableProduct() && $outStock == false)
                                    <p class="primary-bg-color z-30 relative py-1 text-gray-12 w-14 break-all justify-center mb-1 flex items-center rounded-sm leading-3 px-1.5 roboto-medium font-medium text-8 uppercase">{{ formatCurrencyAmount($item->getDiscountAmount()) }}% {{ __('off') }}</p>
                                @endif
                            </div>
                            <a href="{{ route('site.productDetails', ['slug' => $item->slug]) }}" class="w-full h-full z-10"><img class="w-full object-cover rounded" src="{{ $item->getFeaturedImage('small') }}" alt="{{ __('Image') }}"></a>
                        </div>
                        @if(!$item->isVariableProduct() && $outStock == false && !$item->isExternalProduct() && !$item->isGroupedProduct())
                        <div class="w-full h-full hover-icon absolute top-0" data-itemId={{ $item->id }}>
                            <div class="absolute flex justify-center h-6 w-6 cursor-pointer bottom-2 ltr:right-2 rtl:left-2">
                                <div slot="icon" class="relative">
                                    <a href="javascript:void(0)" class="add-to-cart relative z-20" data-itemCode={{ $item->code }}>
                                        <div class="h-6 w-6 p-1 text-gray-12 primary-bg-hover border border-gray-2 rounded-full bg-white">
                                        <svg viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.81845 6.09833C3.48337 6.09833 3.21173 5.82669 3.21173 5.49161L3.21173 3.06475C3.21173 1.38935 4.56991 0.0311725 6.24531 0.0311728C7.92071 0.0311726 9.27889 1.38935 9.27889 3.06475L9.27889 5.49161C9.27889 5.82669 9.00725 6.09833 8.67217 6.09833C8.33709 6.09833 8.06545 5.82669 8.06545 5.49161L8.06545 3.06475C8.06545 2.05951 7.25055 1.2446 6.24531 1.2446C5.24007 1.2446 4.42516 2.05951 4.42516 3.06475L4.42516 5.49161C4.42516 5.82669 4.15353 6.09833 3.81845 6.09833Z" fill="#2C2C2C"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.58666 3.06488C3.59925 3.06488 3.61187 3.06488 3.62454 3.06488L8.9038 3.06488C9.40133 3.06485 9.83213 3.06483 10.18 3.11C10.5538 3.15855 10.9128 3.26765 11.2149 3.54562C11.517 3.82358 11.6555 4.17222 11.7349 4.54078C11.8088 4.88366 11.8446 5.31296 11.8859 5.80877L12.2008 9.5876C12.2017 9.5992 12.2027 9.61078 12.2037 9.62235C12.2268 9.8996 12.2491 10.1666 12.2371 10.3873C12.2236 10.6348 12.1639 10.9229 11.9392 11.1671C11.7146 11.4113 11.4323 11.4947 11.1869 11.5287C10.9679 11.559 10.7 11.559 10.4218 11.5589C10.4102 11.5589 10.3986 11.5589 10.3869 11.5589H2.10355C2.09191 11.5589 2.08029 11.5589 2.06868 11.5589C1.79046 11.559 1.52258 11.559 1.30358 11.5287C1.05812 11.4947 0.775903 11.4113 0.551227 11.1671C0.326551 10.9229 0.266872 10.6348 0.253375 10.3873C0.241334 10.1666 0.263631 9.8996 0.286789 9.62234C0.287755 9.61078 0.288722 9.5992 0.289688 9.5876L0.601444 5.84654C0.602496 5.83391 0.603543 5.82133 0.604588 5.80879C0.645877 5.31297 0.681628 4.88366 0.755526 4.54078C0.834957 4.17222 0.97349 3.82358 1.27559 3.54562C1.57768 3.26765 1.93662 3.15855 2.3105 3.11C2.65833 3.06483 3.08913 3.06485 3.58666 3.06488ZM2.46675 4.31332C2.22362 4.3449 2.14342 4.39604 2.09721 4.43856C2.051 4.48108 1.99338 4.55675 1.94172 4.79642C1.8864 5.05311 1.85605 5.40287 1.81068 5.94731L1.49893 9.68837C1.47182 10.0136 1.45811 10.1948 1.46501 10.3212C1.46509 10.3229 1.46519 10.3245 1.46528 10.326C1.46684 10.3263 1.46843 10.3265 1.47006 10.3267C1.59552 10.3441 1.77714 10.3455 2.10355 10.3455H10.3869C10.7133 10.3455 10.8949 10.3441 11.0204 10.3267C11.022 10.3265 11.0236 10.3263 11.0252 10.326C11.0253 10.3245 11.0254 10.3229 11.0255 10.3212C11.0324 10.1948 11.0186 10.0136 10.9915 9.68837L10.6798 5.94731C10.6344 5.40287 10.6041 5.05311 10.5487 4.79642C10.4971 4.55675 10.4395 4.48108 10.3932 4.43856C10.347 4.39604 10.2668 4.3449 10.0237 4.31332C9.76332 4.27951 9.41224 4.27831 8.86592 4.27831H3.62454C3.07822 4.27831 2.72714 4.27951 2.46675 4.31332Z" fill="#2C2C2C"/>
                                        </svg>
                                    </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="md:w-2/3 w-28 flex items-center">
                    <div class="item-rating">
                        <div class="self-top">
                            <ul class="flex gap-1 mb-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if (round($item->review_average) >= $i)
                                        <li>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="primary-text-color" width="12" height="12" viewBox="0 0 12 12" fill="var(--primary-color)">
                                                <path d="M6.07621 0L7.4575 4.25119H11.9275L8.31119 6.87857L9.69249 11.1298L6.07621 8.50238L2.45993 11.1298L3.84123 6.87857L0.224947 4.25119H4.69491L6.07621 0Z" fill="var(--primary-color)"/>
                                            </svg>
                                        </li>
                                    @else
                                        <li>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="currentColor">
                                                <path d="M6.07621 0L7.4575 4.25119H11.9275L8.31119 6.87857L9.69249 11.1298L6.07621 8.50238L2.45993 11.1298L3.84123 6.87857L0.224947 4.25119H4.69491L6.07621 0Z" fill="#C4C4C4"/>
                                            </svg>
                                        </li>
                                    @endif
                                @endfor
                            </ul>
                        </div>
                        <div class="-mt-1">
                            <a href="{{ route('site.productDetails', ['slug' => $item->slug]) }}">
                             <p class="text-xs md:text-sm text-gray-12 dm-sans my-1 md:hidden">{{ trimWords($item->name, 40) }}</p>
                             <p class="text-sm text-gray-12 dm-sans md:block hidden">{{ trimWords($item->name, 50) }}</p></a>
                            @if($item->isVariableProduct())
                                @php
                                    $filterVariationSameShop = $item->filterVariation();
                                @endphp
                                <p class="text-xs md:text-sm text-gray-10 dm-sans mt-0.5">{{ formatNumber($filterVariationSameShop['min']) }} - {{ formatNumber($filterVariationSameShop['max']) }}</p>
                            @elseif($item->isGroupedProduct())
                                @php $groupProductPrice = $item->groupProducts() @endphp
                                <p class="text-xs md:text-sm text-gray-10 dm-sans mt-0.5">{{ formatNumber($groupProductPrice['min']) }} - {{ formatNumber($groupProductPrice['max']) }}</p>
                            @else
                                <p class="text-xs md:text-sm text-gray-10 dm-sans mt-0.5">{{ $offerFlag ? formatNumber($item->sale_price) : formatNumber($item->regular_price) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @endforeach
    </div>
</div>
@endif
