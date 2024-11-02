@php
    $offerFlag = $item->offerCheck();
    $outOfStock = $item->isOutOfStock();

    $outStock = false;
    $newArrival = isset($type) && $type == 'newArrivals';
@endphp
@if ($outOfStock['isApprove'])
    <div>
        <div class="border rev-img rounded-md relative product-hover">
            <div style="height: {{ empty($component->card_height) ? $isEnableProduct['height'] : $component->card_height }}px" class="h-48 flex justify-center items-center">
                @php
                    $metaData = $item->getMetaCollection();
                @endphp
                @if (isset($isEnableProduct['badge']) && $isEnableProduct['badge'] == 1)
                    <div class="absolute top-2.5 ltr:left-2.5 rtl:right-2.5">
                        @if ($outOfStock['outOfStockVisibility'] == 1)
                            @php $outStock = true @endphp
                                <p class="bg-pinks-2 relative w-max z-30 h-4 text-reds-3 mb-2.5 px-1.5 flex items-center rounded-sm leading-3 roboto-medium font-medium pt-2p text-8 whitespace-nowrap">{{ __('Stock Out') }}</p>
                            @endif
                            @if ($newArrival && $outStock == false)
                                <p class="semi-primary-bg-color h-4 primary-text-color px-1.5 flex items-center rounded-sm relative z-20 mb-2.5 pt-2p leading-3 roboto-medium font-medium text-8 whitespace-nowrap">
                                    {{ __('New Arrival') }}</p>
                            @endif
                            @if (isset($item->featured) && $outStock == false && $newArrival == false)
                                <p class="primary-bg-color relative z-30 h-18p w-max justify-center text-white px-2 flex items-center rounded-sm mb-2.5 leading-3 roboto-medium font-medium text-xss whitespace-nowrap">
                                    {{ __('Featured') }}</p>
                            @endif
                            @if ($item->review_average == 5 && $outStock == false && $newArrival == false)
                                <div class="flex items-center relative z-30 w-max px-1.5 whitespace-nowrap mb-2.5 bg-green-5 h-18p rounded-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10"
                                        fill="none">
                                        <path d="M5 0L6.12257 3.45492H9.75528L6.81636 5.59017L7.93893 9.04508L5 6.90983L2.06107 9.04508L3.18364 5.59017L0.244718 3.45492H3.87743L5 0Z"
                                            fill="white" />
                                    </svg>
                                    <p class="leading-3 pt-2p roboto-medium font-medium text-white text-xss">{{ __('Top Rated') }}</p>
                                </div>
                            @endif
                            @if ($offerFlag && !$item->isVariableProduct() && $outStock == false && $newArrival == false)
                                <p class="primary-bg-color h-4 w-max relative text-gray-12 mb-2.5 px-2 py-1 flex items-center justify-center rounded-sm leading-3 roboto-medium font-medium z-30 text-8 whitespace-nowrap uppercase">{{ formatCurrencyAmount($item->getDiscountAmount()) }}% {{ __('off') }}</p>
                            @endif
                    </div>
                @endif
                <a href="{{ route('site.productDetails', ['slug' => $item->slug]) }}" class="w-full h-full z-10">
                    @if (in_array(pathinfo($item->getFeaturedImage('medium'), PATHINFO_EXTENSION), getFileExtensions(6)))
                    <video class="w-full h-full rounded-md neg-transition-scale" autoplay muted loop>
                        <source src="{{ $item->getFeaturedImage() }}" type="video/mp4">
                    </video>
                    @else
                    <img class="w-full h-full object-cover rounded-md neg-transition-scale" src="{{ $item->getFeaturedImage('medium') }}" alt="{{ __('Image') }}">
                    @endif
                </a>
            </div>
            <div class="w-full h-full hover-icon absolute top-0">
                <div class="w-full h-full flex justify-end cursor-pointer pt-15p ltr:pr-15p rtl:pl-15p">
                    <div slot="icon" class="relative">
                        {{-- Add to cart --}}
                        @if (!$item->isVariableProduct() && $outStock == false && !$item->isExternalProduct() && isset($isEnableProduct['add_to_cart']) && $isEnableProduct['add_to_cart'] == 1 && !$item->isGroupedProduct())
                            <a href="javascript:void(0)" class="add-to-cart relative z-20" data-itemCode={{ $item->code }}>
                                <div
                                    class=" h-6 w-6 p-1 mb-2 text-gray-12 primary-bg-hover border border-gray-2 rounded-full bg-white">
                                    <svg viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M3.81845 6.09833C3.48337 6.09833 3.21173 5.82669 3.21173 5.49161L3.21173 3.06475C3.21173 1.38935 4.56991 0.0311725 6.24531 0.0311728C7.92071 0.0311726 9.27889 1.38935 9.27889 3.06475L9.27889 5.49161C9.27889 5.82669 9.00725 6.09833 8.67217 6.09833C8.33709 6.09833 8.06545 5.82669 8.06545 5.49161L8.06545 3.06475C8.06545 2.05951 7.25055 1.2446 6.24531 1.2446C5.24007 1.2446 4.42516 2.05951 4.42516 3.06475L4.42516 5.49161C4.42516 5.82669 4.15353 6.09833 3.81845 6.09833Z"
                                            fill="#2C2C2C" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M3.58666 3.06488C3.59925 3.06488 3.61187 3.06488 3.62454 3.06488L8.9038 3.06488C9.40133 3.06485 9.83213 3.06483 10.18 3.11C10.5538 3.15855 10.9128 3.26765 11.2149 3.54562C11.517 3.82358 11.6555 4.17222 11.7349 4.54078C11.8088 4.88366 11.8446 5.31296 11.8859 5.80877L12.2008 9.5876C12.2017 9.5992 12.2027 9.61078 12.2037 9.62235C12.2268 9.8996 12.2491 10.1666 12.2371 10.3873C12.2236 10.6348 12.1639 10.9229 11.9392 11.1671C11.7146 11.4113 11.4323 11.4947 11.1869 11.5287C10.9679 11.559 10.7 11.559 10.4218 11.5589C10.4102 11.5589 10.3986 11.5589 10.3869 11.5589H2.10355C2.09191 11.5589 2.08029 11.5589 2.06868 11.5589C1.79046 11.559 1.52258 11.559 1.30358 11.5287C1.05812 11.4947 0.775903 11.4113 0.551227 11.1671C0.326551 10.9229 0.266872 10.6348 0.253375 10.3873C0.241334 10.1666 0.263631 9.8996 0.286789 9.62234C0.287755 9.61078 0.288722 9.5992 0.289688 9.5876L0.601444 5.84654C0.602496 5.83391 0.603543 5.82133 0.604588 5.80879C0.645877 5.31297 0.681628 4.88366 0.755526 4.54078C0.834957 4.17222 0.97349 3.82358 1.27559 3.54562C1.57768 3.26765 1.93662 3.15855 2.3105 3.11C2.65833 3.06483 3.08913 3.06485 3.58666 3.06488ZM2.46675 4.31332C2.22362 4.3449 2.14342 4.39604 2.09721 4.43856C2.051 4.48108 1.99338 4.55675 1.94172 4.79642C1.8864 5.05311 1.85605 5.40287 1.81068 5.94731L1.49893 9.68837C1.47182 10.0136 1.45811 10.1948 1.46501 10.3212C1.46509 10.3229 1.46519 10.3245 1.46528 10.326C1.46684 10.3263 1.46843 10.3265 1.47006 10.3267C1.59552 10.3441 1.77714 10.3455 2.10355 10.3455H10.3869C10.7133 10.3455 10.8949 10.3441 11.0204 10.3267C11.022 10.3265 11.0236 10.3263 11.0252 10.326C11.0253 10.3245 11.0254 10.3229 11.0255 10.3212C11.0324 10.1948 11.0186 10.0136 10.9915 9.68837L10.6798 5.94731C10.6344 5.40287 10.6041 5.05311 10.5487 4.79642C10.4971 4.55675 10.4395 4.48108 10.3932 4.43856C10.347 4.39604 10.2668 4.3449 10.0237 4.31332C9.76332 4.27951 9.41224 4.27831 8.86592 4.27831H3.62454C3.07822 4.27831 2.72714 4.27951 2.46675 4.31332Z"
                                            fill="#2C2C2C" />
                                    </svg>
                                </div>
                            </a>
                        @endif
                        @php
                            $wishlisted = false;
                            if (auth()->user()) {
                                $wishlisted = $item->isWishlist($item->id, optional(auth()->user())->id);
                            }
                        @endphp
                        {{-- Wishlist --}}
                        @if (preference('wishlist') && isset($isEnableProduct['wishlist']) && $isEnableProduct['wishlist'] == 1)
                            <div data-id="{{ $item->id }}"
                                class="z-20 wishlist h-6 w-6 p-1 mb-2 text-gray-12 relative primary-bg-hover border border-gray-2 rounded-full bg-white {{ $wishlisted ? 'remove-wishlist primary-bg-color' : 'add-wishlist' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                    </path>
                                </svg>
                            </div>
                        @endif

                        {{-- Compare --}}
                        @if (preference('compare') && isset($isEnableProduct['compare']) && $isEnableProduct['compare'] == 1)
                            <div data-itemId="{{ $item->id }}"
                                class="z-20 h-6 w-6 p-1 absolute mb-2 text-gray-12 bg-white primary-bg-hover border border-gray-2 rounded-full compare-bg neg-transition-scale {{ isCompared($item->id) ? 'compare-remove' : 'add-to-compare' }} ">
                                <svg width="13" height="14" viewBox="0 0 14 15" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M2.04937 0.737095C2.01173 0.743939 1.89539 0.767892 1.79274 0.788423C1.69008 0.808954 1.46082 0.8945 1.28288 0.980046C1.01256 1.11008 0.9099 1.18193 0.677215 1.41462C0.44453 1.65073 0.372671 1.74996 0.242641 2.02029C0.0407524 2.44117 -0.00373152 2.63964 -0.000309674 3.09474C0.00653401 3.66277 0.170782 4.11103 0.547185 4.56956C0.776448 4.84673 1.22129 5.14443 1.59427 5.26419L1.72088 5.30525L1.73456 8.16933C1.74825 11.3516 1.73456 11.1737 1.98436 11.6836C2.27864 12.2892 2.84324 12.7478 3.50708 12.9188C3.68501 12.9668 3.95192 12.9804 4.93741 12.9907L6.14874 13.0078L5.69706 13.4595L5.2488 13.9078L5.65942 14.3184L6.07004 14.729L7.06579 13.7367C7.61329 13.1892 8.08208 12.6964 8.10946 12.6348C8.17105 12.4945 8.17105 12.3098 8.10946 12.1695C8.08208 12.1079 7.61329 11.6151 7.06579 11.0676L6.07004 10.0753L5.65942 10.4859L5.2488 10.8965L5.70048 11.3516L6.15558 11.8068L4.94083 11.7965L3.72608 11.7862L3.55498 11.6938C3.34967 11.5843 3.13068 11.3619 3.02118 11.1532L2.93905 10.9992L2.92879 8.15223L2.92194 5.30868L3.04855 5.26419C4.08195 4.93227 4.76632 3.87492 4.63971 2.821C4.51994 1.84919 3.90059 1.10665 2.97327 0.822641C2.74401 0.750783 2.19993 0.699455 2.04937 0.737095ZM2.59687 1.93132C3.1341 2.07161 3.47628 2.50961 3.47628 3.06053C3.47628 3.33427 3.41469 3.53274 3.26071 3.74147C3.04513 4.04602 2.71321 4.21026 2.32312 4.21369C1.76878 4.21369 1.33079 3.8715 1.19049 3.32059C1.03993 2.71834 1.41291 2.10241 2.03226 1.93474C2.27521 1.86972 2.35392 1.86972 2.59687 1.93132Z"
                                        fill="#2C2C2C"></path>
                                    <path
                                        d="M6.90107 1.74983C6.35015 2.30075 5.88478 2.79692 5.86425 2.84825C5.81634 2.9817 5.81976 3.16305 5.87794 3.29308C5.90531 3.35468 6.3741 3.84742 6.9216 4.39492L7.91735 5.38725L8.32797 4.97663L8.7386 4.56601L8.28691 4.1109L7.83181 3.6558L9.04656 3.66607L10.2613 3.67633L10.4324 3.76872C10.6377 3.87822 10.8567 4.10064 10.9662 4.30937L11.0483 4.46335L11.0586 7.31033L11.0654 10.1539L10.9388 10.1984C10.5248 10.3318 10.0697 10.65 9.81305 10.9922C9.48798 11.42 9.34084 11.8614 9.34084 12.402C9.34084 13.0522 9.56326 13.586 10.0218 14.0445C10.3263 14.3491 10.6035 14.5167 11.0312 14.6468C11.3939 14.7597 11.9346 14.7597 12.2973 14.6468C13.0946 14.4004 13.6626 13.8392 13.9022 13.0556C14.2546 11.9059 13.6181 10.6466 12.4718 10.2292L12.2665 10.1539L12.2528 7.3069C12.2426 4.7371 12.2357 4.44282 12.1844 4.24093C12.003 3.57368 11.5274 2.99538 10.9183 2.70453C10.4803 2.49922 10.405 2.48895 9.06709 2.47184L7.83865 2.45473L8.29033 2.00305L8.7386 1.55479L8.33482 1.15101C8.11582 0.932014 7.9242 0.750657 7.91735 0.750657C7.90709 0.750657 7.44856 1.20234 6.90107 1.74983ZM12.0646 11.3105C12.4171 11.4336 12.6942 11.7519 12.7969 12.142C13.0056 12.9632 12.2255 13.7434 11.4042 13.5347C10.6548 13.343 10.2921 12.5663 10.6275 11.8751C10.8772 11.3618 11.5103 11.112 12.0646 11.3105Z"
                                        fill="#2C2C2C"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    @if (isset($isEnableProduct['quick_view']) && $isEnableProduct['quick_view'] == 1 && !$item->isGroupedProduct())
                    <button class="open-view-modal"  data-itemCode="{{ $item->code }}">
                        <p class="text-gray-12 font-medium py-1 absolute bottom-0 inset-x-0 rounded rounded-t-none text-center text-11 primary-bg-color z-20">
                            {{ __('Quick View') }}</p>
                    </button>
                    @elseif (isset($isEnableProduct['quick_view']) && $isEnableProduct['quick_view'] == 1)
                        <a  href="{{ route('site.productDetails', ['slug' => $item->slug]) }}">
                            <p class="text-gray-12 font-medium py-1 absolute inset-x-0 bottom-0 text-center text-11 primary-bg-color z-20">
                                {{ __('View') }}</p>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="sm:text-center flex flex-col">
            <a href="{{ route('site.productDetails', ['slug' => $item->slug]) }}">
                <p class="text-13 md:text-sm text-gray-12 md:mt-2 dm-regular line-clamp">{{ $item->name }}</p>
            </a>
            @if (isset($isEnableProduct['review']) && $isEnableProduct['review'] == 1)
                <div class="item-rating order-first md:order-none md:mt-0 mt-2">
                    <div class="self-top">
                        <ul class="flex flex-wrap sm:justify-center ltr:-space-x-1">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($item->review_average >= $i)
                                    {{-- Full star --}}
                                    <li class="mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 primary-text-color"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M6.23333 0L7.6328 4.30712H12.1616L8.49772 6.96907L9.89719 11.2762L6.23333 8.61425L2.56947 11.2762L3.96894 6.96907L0.305081 4.30712H4.83386L6.23333 0Z"
                                                fill="currentColor" />
                                        </svg>
                                    </li>
                                @elseif ($item->review_average < $i && $item->review_average > $i - 1)
                                    {{-- Half star --}}
                                    <li class="mt-5p pr-2">
                                        <svg class="h-3 w-3" viewBox="0 0 142 142" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M71 0L86.9405 49.0598H138.525L96.7923 79.3804L112.733 128.44L71 98.1196L29.2672 128.44L45.2077 79.3804L3.47499 49.0598H55.0595L71 0Z"
                                                fill="#C4C4C4" />
                                            <mask id="mask0_2170_1814" class="mask-type-alpha" maskUnits="userSpaceOnUse"
                                                x="3" y="0" width="136" height="129">
                                                <path
                                                    d="M71 0L86.9405 49.0598H138.525L96.7923 79.3804L112.733 128.44L71 98.1196L29.2672 128.44L45.2077 79.3804L3.47499 49.0598H55.0595L71 0Z"
                                                    fill="#C4C4C4" />
                                            </mask>
                                            <g mask="url(#mask0_2170_1814)">
                                                <rect x="-39" y="-36" width="110" height="201"
                                                    fill="var(--primary-color)" />
                                            </g>
                                        </svg>
                                    </li>
                                @else
                                    {{-- Empty star --}}
                                    <li class="mt-5p">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M6.23333 0L7.6328 4.30712H12.1616L8.49772 6.96907L9.89719 11.2762L6.23333 8.61425L2.56947 11.2762L3.96894 6.96907L0.305081 4.30712H4.83386L6.23333 0Z"
                                                fill="currentColor" />
                                        </svg>
                                    </li>
                                @endif
                            @endfor

                            <li class="mt-0.5 text-gray-10 text-xss dm-sans rtl:pr-2">
                                ({{ $item->review_count }} {{ $item->review_count > 1 ? __('Reviews') : __('Review') }})
                            </li>
                        </ul>
                    </div>
                </div>
            @endif
            @if (isset($isEnableProduct['price']) && $isEnableProduct['price'] == 1)
                @if ($item->isVariableProduct())
                    @php $minMaxPrice = $item->variantMaxMinPrice(); @endphp
                    <p class="text-13 md:text-sm text-gray-12 dm-sans">
                        {{ formatNumber($minMaxPrice['min']) }} - {{ formatNumber($minMaxPrice['max']) }}
                    </p>
                @elseif ($item->isGroupedProduct())
                    @php $groupProductPrice = $item->groupProducts() @endphp
                    <p class="text-13 md:text-sm text-gray-12 dm-sans">
                        {{ formatNumber($groupProductPrice['min']) }} - {{ formatNumber($groupProductPrice['max']) }}
                    </p>
                @else
                    @if ($offerFlag)
                        <p class="text-13 md:text-sm text-gray-12 dm-sans">
                            {{ $item->priceWithTax($displayPrice, 'sale') }}
                        </p>
                    @endif
                    <p
                        class="mt-1 md:mt-0 {{ $offerFlag ? 'text-11 font-medium line-through text-gray-10 pl-1 mt-0.5' : 'text-13 md:text-sm text-gray-12 dm-sans font-medium' }}">
                        {{ $item->priceWithTax($displayPrice, 'regular') }}
                    </p>
                @endif
            @endif
        </div>
    </div>
@endif
