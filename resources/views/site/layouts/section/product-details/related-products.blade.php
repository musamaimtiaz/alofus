@if (count($relatedProducts) > 0)
    @php
        $layout = \Modules\CMS\Entities\Page::firstWhere('default', '1')->layout;
        $productCard = option($layout . '_template_product', '');
    @endphp
    <div class="flex justify-between">
        <div class="w-385p">
            <P class="mt-3 md:mt-0 dm-bold text-base md:text-xl text-gray-12">{{ __('Related Product') }}</P>
        </div>
        @if(count($relatedProducts) > 6)
            <a href="{{ route('site.productSearch', ['related_ids' => urlencode(json_encode($related_ids))]) }}" class="process-goto relative justify-center text-gray-10 font-medium text-sm dm-sans hidden md:inline-flex items-center py-2 dm-sans hover:text-gray-12 trans-2">
                {{ __('See All') }}
                <svg class="ltr:ml-2 rtl:mr-2 mt-0.5 relative" width="15" height="10" viewBox="0 0 15 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M9.70696 0L8.29274 1.41421L10.5856 3.70711H0.999849C0.447564 3.70711 -0.000150681 4.15482 -0.000150681 4.70711C-0.000150681 5.25939 0.447564 5.70711 0.999849 5.70711H10.5856L8.29274 8L9.70696 9.41421L14.4141 4.70711L9.70696 0Z" fill="currentColor"></path>
                </svg>
            </a>
        @endif
    </div>
    <div class="md:grid md:grid-cols-3 flex overflow-auto gap-5 mt-3 md:mt-5 md:mb-0 mb-4">
        @foreach ($relatedProducts as $key => $product)
            @if($key <= 5)
                @php
                    $offerFlag = $product->offerCheck();
                    $outOfStock = $product->isOutOfStock();
                    $outStock = false;
                @endphp
                @if($outOfStock['isApprove'])
                    <div>
                        <div class="border rev-img rounded-md relative product-hover">
                            <div style="height: {{ $productCard['height'] }}px" class="md:h-260p md:w-auto w-32 h-32 flex justify-center items-center">
                                    @if ($productCard['badge'])
                                        <div class="absolute top-2.5 ltr:left-2.5 rtl:right-2.5">
                                            @if($outOfStock['outOfStockVisibility'] == 1)
                                                @php $outStock = true @endphp
                                                <p class="bg-pinks-2 h-4 w-max text-reds-3 mb-2.5 px-1.5 flex items-center rounded-sm leading-3 z-20 roboto-medium font-medium pt-2p text-8 whitespace-nowrap">{{ __('Stock Out') }}</p>
                                            @endif
                                            @if(isset($product->featured) && $outStock == false)
                                                <p class="primary-bg-color relative z-20 h-18p w-max justify-center text-white px-2 flex items-center rounded-sm mb-2.5 leading-3 roboto-medium font-medium text-xss whitespace-nowrap">{{ __('Featured') }}</p>
                                            @endif
                                            @if($product->review_average == 5 && $outStock == false)
                                                <div class="flex items-center relative w-max z-20 px-1.5 whitespace-nowrap mb-2.5 bg-green-5 h-18p rounded-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
                                                        <path d="M5 0L6.12257 3.45492H9.75528L6.81636 5.59017L7.93893 9.04508L5 6.90983L2.06107 9.04508L3.18364 5.59017L0.244718 3.45492H3.87743L5 0Z" fill="white"/>
                                                    </svg>
                                                    <p class="leading-3 pt-2p roboto-medium font-medium text-white text-xss">{{ __('Top Rated') }}</p>
                                                </div>
                                            @endif
                                            @if($offerFlag && !$product->isVariableProduct() && $outStock == false)
                                                <p class="primary-bg-color h-4 relative text-gray-12 mb-2.5 px-2 py-1 flex items-center justify-center rounded-sm leading-3 roboto-medium font-medium z-20 text-8 whitespace-nowrap w-max uppercase">{{ formatCurrencyAmount($product->getDiscountAmount()) }}% {{ __('off') }}</p>
                                            @endif
                                        </div>
                                    @endif
                                    <a href="{{ route('site.productDetails', ['slug' => $product->slug]) }}" class="w-full h-full z-10"><img class="object-cover neg-transition-scale rounded-md w-full h-full" src="{{ $product->getFeaturedImage('medium') }}" alt="{{ __('Image') }}"></a>
                            </div>
                            <div class="w-full h-full hover-icon absolute top-0">
                                <div class="w-full h-full flex justify-end cursor-pointer pt-15p ltr:pr-15p rtl:pl-15p">
                                    <div slot="icon" class="relative">
                                        @if(!$product->isVariableProduct() && $outStock == false && !$product->isExternalProduct() && $productCard['add_to_cart'] && !$product->isGroupedProduct())
                                            <a href="javascript:void(0)" class="add-to-cart relative z-20" data-itemCode={{ $product->code }}>
                                                <div class="relative h-6 w-6 md:h-8 md:w-8 mb-2 p-1.5 flex flex-col justify-center items-center text-gray-12 bg-white primary-bg-hover border border-gray-2 rounded-full">
                                                    <svg viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M3.81845 6.09833C3.48337 6.09833 3.21173 5.82669 3.21173 5.49161L3.21173 3.06475C3.21173 1.38935 4.56991 0.0311725 6.24531 0.0311728C7.92071 0.0311726 9.27889 1.38935 9.27889 3.06475L9.27889 5.49161C9.27889 5.82669 9.00725 6.09833 8.67217 6.09833C8.33709 6.09833 8.06545 5.82669 8.06545 5.49161L8.06545 3.06475C8.06545 2.05951 7.25055 1.2446 6.24531 1.2446C5.24007 1.2446 4.42516 2.05951 4.42516 3.06475L4.42516 5.49161C4.42516 5.82669 4.15353 6.09833 3.81845 6.09833Z" fill="#2C2C2C"/>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M3.58666 3.06488C3.59925 3.06488 3.61187 3.06488 3.62454 3.06488L8.9038 3.06488C9.40133 3.06485 9.83213 3.06483 10.18 3.11C10.5538 3.15855 10.9128 3.26765 11.2149 3.54562C11.517 3.82358 11.6555 4.17222 11.7349 4.54078C11.8088 4.88366 11.8446 5.31296 11.8859 5.80877L12.2008 9.5876C12.2017 9.5992 12.2027 9.61078 12.2037 9.62235C12.2268 9.8996 12.2491 10.1666 12.2371 10.3873C12.2236 10.6348 12.1639 10.9229 11.9392 11.1671C11.7146 11.4113 11.4323 11.4947 11.1869 11.5287C10.9679 11.559 10.7 11.559 10.4218 11.5589C10.4102 11.5589 10.3986 11.5589 10.3869 11.5589H2.10355C2.09191 11.5589 2.08029 11.5589 2.06868 11.5589C1.79046 11.559 1.52258 11.559 1.30358 11.5287C1.05812 11.4947 0.775903 11.4113 0.551227 11.1671C0.326551 10.9229 0.266872 10.6348 0.253375 10.3873C0.241334 10.1666 0.263631 9.8996 0.286789 9.62234C0.287755 9.61078 0.288722 9.5992 0.289688 9.5876L0.601444 5.84654C0.602496 5.83391 0.603543 5.82133 0.604588 5.80879C0.645877 5.31297 0.681628 4.88366 0.755526 4.54078C0.834957 4.17222 0.97349 3.82358 1.27559 3.54562C1.57768 3.26765 1.93662 3.15855 2.3105 3.11C2.65833 3.06483 3.08913 3.06485 3.58666 3.06488ZM2.46675 4.31332C2.22362 4.3449 2.14342 4.39604 2.09721 4.43856C2.051 4.48108 1.99338 4.55675 1.94172 4.79642C1.8864 5.05311 1.85605 5.40287 1.81068 5.94731L1.49893 9.68837C1.47182 10.0136 1.45811 10.1948 1.46501 10.3212C1.46509 10.3229 1.46519 10.3245 1.46528 10.326C1.46684 10.3263 1.46843 10.3265 1.47006 10.3267C1.59552 10.3441 1.77714 10.3455 2.10355 10.3455H10.3869C10.7133 10.3455 10.8949 10.3441 11.0204 10.3267C11.022 10.3265 11.0236 10.3263 11.0252 10.326C11.0253 10.3245 11.0254 10.3229 11.0255 10.3212C11.0324 10.1948 11.0186 10.0136 10.9915 9.68837L10.6798 5.94731C10.6344 5.40287 10.6041 5.05311 10.5487 4.79642C10.4971 4.55675 10.4395 4.48108 10.3932 4.43856C10.347 4.39604 10.2668 4.3449 10.0237 4.31332C9.76332 4.27951 9.41224 4.27831 8.86592 4.27831H3.62454C3.07822 4.27831 2.72714 4.27951 2.46675 4.31332Z" fill="#2C2C2C"/>
                                                    </svg>
                                                </div>
                                            </a>
                                        @endif
                                        @php
                                            $wishlisted = false;
                                            if (auth()->user()) {
                                                $wishlisted = $product->isWishlist($product->id, optional(auth()->user())->id);
                                            }
                                        @endphp
                                        @if (preference('wishlist') && $productCard['wishlist'])
                                            <div data-id="{{ $product->id }}" class="z-20 relative wishlist h-6 w-6 md:h-8 md:w-8 flex flex-col justify-center items-center mb-2 p-1.5 text-gray-12 primary-bg-hover border border-gray-2 rounded-full bg-white {{ $wishlisted ? 'remove-wishlist primary-bg-color' : 'add-wishlist' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        @if (preference('compare') && $productCard['compare'])
                                            <div class="z-20 relative h-6 w-6 md:h-8 md:w-8 flex flex-col justify-center items-center p-1.5 mb-2 text-gray-12 primary-bg-hover border border-gray-2 rounded-full compare-bg bg-white {{ isCompared($product->id) ? 'compare-remove' : 'add-to-compare' }} " data-itemId="{{ $product->id }}">
                                                <svg class="ltr:ml-1p rtl:mr-1p mt-1p" width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M2.3427 0.0144958C2.29968 0.0223179 2.16672 0.0496922 2.0494 0.0731564C1.93208 0.0966206 1.67006 0.194387 1.46671 0.292154C1.15776 0.44076 1.04044 0.522884 0.774518 0.78881C0.508592 1.05865 0.426468 1.17206 0.277862 1.481C0.0471322 1.96201 -0.00370655 2.18883 0.000204123 2.70895C0.00802547 3.35812 0.195738 3.87042 0.625912 4.39445C0.887928 4.71122 1.39632 5.05145 1.82258 5.18832L1.96727 5.23525L1.98292 8.50848C1.99856 12.1454 1.98292 11.9421 2.2684 12.5247C2.60471 13.2169 3.24998 13.741 4.00865 13.9365C4.212 13.9913 4.51704 14.0069 5.64331 14.0186L7.02769 14.0382L6.51148 14.5544L5.99918 15.0667L6.46846 15.536L6.93774 16.0052L8.07575 14.8712C8.70146 14.2454 9.23722 13.6823 9.26851 13.6119C9.3389 13.4516 9.3389 13.2404 9.26851 13.0801C9.23722 13.0097 8.70146 12.4465 8.07575 11.8208L6.93774 10.6867L6.46846 11.156L5.99918 11.6253L6.51539 12.1454L7.03551 12.6655L5.64722 12.6538L4.25893 12.6421L4.0634 12.5365C3.82876 12.4113 3.57847 12.1571 3.45333 11.9186L3.35947 11.7426L3.34774 8.48893L3.33992 5.23916L3.48462 5.18832C4.66564 4.80898 5.44778 3.60059 5.30308 2.3961C5.16621 1.28547 4.45837 0.43685 3.39858 0.112263C3.13657 0.030139 2.51477 -0.0285206 2.3427 0.0144958ZM2.96841 1.37932C3.58238 1.53966 3.97345 2.04023 3.97345 2.66984C3.97345 2.9827 3.90306 3.20952 3.72708 3.44807C3.48071 3.79612 3.10137 3.98383 2.65555 3.98774C2.02202 3.98774 1.52146 3.59667 1.36112 2.96706C1.18905 2.27878 1.61531 1.57486 2.32315 1.38323C2.6008 1.30893 2.69075 1.30893 2.96841 1.37932Z" fill="#2C2C2C"/>
                                                    <path d="M7.88742 1.17211C7.2578 1.80173 6.72595 2.36878 6.70249 2.42744C6.64774 2.57996 6.65165 2.78722 6.71813 2.93583C6.74942 3.00622 7.28518 3.56936 7.91089 4.19507L9.04889 5.32916L9.51817 4.85988L9.98745 4.3906L9.47125 3.87048L8.95113 3.35036L10.3394 3.36209L11.7277 3.37382L11.9232 3.47941C12.1579 3.60455 12.4082 3.85875 12.5333 4.0973L12.6272 4.27328L12.6389 7.52696L12.6467 10.7767L12.502 10.8276C12.0288 10.9801 11.5087 11.3438 11.2154 11.7348C10.8439 12.2237 10.6757 12.7282 10.6757 13.346C10.6757 14.0891 10.9299 14.6991 11.454 15.2232C11.802 15.5712 12.1188 15.7628 12.6076 15.9115C13.0221 16.0405 13.64 16.0405 14.0546 15.9115C14.9657 15.6299 15.6149 14.9885 15.8887 14.093C16.2915 12.779 15.5641 11.3399 14.254 10.8628L14.0194 10.7767L14.0037 7.52305C13.992 4.58613 13.9842 4.24982 13.9255 4.01909C13.7182 3.2565 13.1747 2.5956 12.4786 2.26319C11.978 2.02855 11.892 2.01682 10.3629 1.99727L8.95895 1.97771L9.47516 1.4615L9.98745 0.949205L9.52599 0.487746C9.27571 0.237463 9.05671 0.0301971 9.04889 0.0301971C9.03716 0.0301971 8.51313 0.546406 7.88742 1.17211ZM13.7886 12.0985C14.1914 12.2393 14.5082 12.603 14.6255 13.0488C14.8641 13.9874 13.9724 14.879 13.0339 14.6405C12.1774 14.4215 11.7629 13.5338 12.1461 12.7438C12.4316 12.1572 13.1551 11.8717 13.7886 12.0985Z" fill="#2C2C2C"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <a href="{{ route('site.productDetails', ['slug' => $product->slug]) }}"><p class="text-gray-12 font-medium py-1 z-20 absolute inset-x-0 bottom-0 p-1 text-center text-sm primary-bg-color">{{ __('View') }}</p></a>
                            </div>
                        </div>
                        <div class="flex flex-col leading-2 md:w-auto w-32">
                            <a class="leading-4 md:mt-0 mt-1" href="{{ route('site.productDetails', ['slug' => $product->slug]) }}">
                                <p class="text-sm text-gray-10 mt-13p roboto-medium hidden md:block">{{ optional(optional($product->productCategory)->category)->name }}</p>
                                <p class="text-xs md:text-base text-gray-12 dm-sans md:block hidden">{{ trimWords($product->name, 50) }} </p>
                                <p class="text-xs md:text-base text-gray-12 dm-regular md:dm-sans md:font-medium md:hidden">{{ trimWords($product->name, 30) }} </p>
                            </a>
                            @if ($productCard['price'])
                                <div class="flex leading-6">
                                    @if($product->isVariableProduct())
                                        @php
                                            $filterVariationRelated = $product->filterVariation();
                                        @endphp
                                        <p class="text-13 md:text-xl text-gray-12 dm-bold"> {{ formatNumber($filterVariationRelated['min']) }} - {{ formatNumber($filterVariationRelated['max']) }}</p>
                                    @elseif($product->isGroupedProduct())
                                        @php $groupProductPrice = $product->groupProducts() @endphp
                                        <p class="text-13 md:text-xl text-gray-12 dm-bold"> {{ formatNumber($groupProductPrice['min']) }} - {{ formatNumber($groupProductPrice['max']) }}</p>
                                    @else
                                        <p class="text-13 md:text-xl text-gray-12 dm-bold"> {{ $offerFlag ? formatNumber($product->sale_price) : formatNumber($product->regular_price) }} </p>
                                    @endif

                                </div>
                            @endif
                            @if ($productCard['review'])
                                <div class="item-rating order-first mt-2.5 md:mt-0 md:order-none">
                                    <div class="self-top">
                                        <ul class="flex gap-x-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if (round($product->review_average) >= $i)
                                                    <li class="mt-1">
                                                        <svg class="primary-text-color h-13p w-13p md:h-auto md:w-auto" width="17" height="16" viewBox="0 0 17 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M8.5 0L10.4084 5.87336L16.584 5.87336L11.5878 9.50329L13.4962 15.3766L8.5 11.7467L3.50383 15.3766L5.41219 9.50329L0.416019 5.87336L6.59163 5.87336L8.5 0Z" fill="currentColor"/>
                                                        </svg>
                                                    </li>
                                                @else
                                                    <li class="mt-1">
                                                        <svg class="h-13p w-13p md:h-auto md:w-auto" width="17" height="16" viewBox="0 0 17 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M8.5 0L10.4084 5.87336L16.584 5.87336L11.5878 9.50329L13.4962 15.3766L8.5 11.7467L3.50383 15.3766L5.41219 9.50329L0.416019 5.87336L6.59163 5.87336L8.5 0Z" fill="#C4C4C4"/>
                                                        </svg>
                                                    </li>
                                                @endif
                                            @endfor

                                            <li class="mt-1 text-gray-10 text-sm roboto-medium md:block hidden">
                                                ({{ $product->review_count ?? 0 }})
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            @endif
        @endforeach
    </div>
@endif
