<div class="hover:shadow-md border bg-white rounded layout relative pb-10">
    <div class="border-gray-600">
        <div class="relative group">
            @if (array_key_exists($item->id, $itemFiles) && file_exists('public/uploads/items/'. $itemFiles[$item->id]))
                <img src="{{ asset('public/uploads/items/'. $itemFiles[$item->id]) }}" alt="{{ __('Image') }}" class="w-full h-44 sm:h-60" />
            @else
                <img src="{{ asset('public/dist/img/default-image.png') }}" alt="{{ __('Image') }}" class="w-full h-44 sm:h-60" />
            @endif
            <div class="layout1">
                @if (\App\Models\Product::discountPercent($item->id) > 0)
                    <div class="absolute left-2 top-2 item-percent">
                        <h4 class="px-3 py-1 rounded text-base font-medium text-green-500 bg-gray-200 shadow">
                            {{ \App\Models\Product::discountPercent($item->id) . '% ' . __('off') }}
                        </h4>
                    </div>
                @endif

                <div class="quick-view absolute inset-0 rounded opacity-0 group-hover:opacity-100 flex justify-center items-center bg-secondary bg-opacity-85 transition-opacity">
                    <a href="{{ route('site.productDetails', ['code' => $item->code, 'name' => cleanedUrl($item->name)]) }}">
                        <button class="bg-white px-4 py-2">{{ __('Quick View') }}</button>
                    </a>
                </div>

                <div class="item-wishlist absolute inset-0 rounded opacity-0 group-hover:opacity-100 flex justify-end items-center bg-secondary bg-opacity-85 transition-opacity">
                    <div>
                        <div>
                            <div x-data="{ tooltip: false }" class="relative z-30 inline-flex wishlist bg-gray-100" data-id="{{ $item->id }}">
                                <div x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false" class="cursor-pointer shadow px-4 py-1">
                                    <i class="fa {{ \App\Models\Product::isWishlist($item->id, optional(auth()->user())->id) ? 'fa-heart text-green-500' : 'fa-heart-o' }}"></i>
                                </div>
                                <div x-on:mouseover="tooltip = true" class="relative d-none" x-show.transition.origin.top="tooltip">
                                    <div class="absolute top-0 z-10 w-32 p-2 -mt-1 text-sm leading-tight text-white transform -translate-x-1/2 -translate-y-full bg-gray-500 rounded-lg shadow-lg">
                                    <span>{{ \App\Models\Product::isWishlist($item->id, optional(auth()->user())->id) ? __('Remove from wishlist') : __('Add to wishlist') }}</span>
                                    </div>
                                    <svg class="absolute z-10 w-6 h-6 text-gray-500 transform -translate-x-12 -translate-y-3 fill-current stroke-current" width="8" height="8">
                                    <rect x="12" y="-10" width="8" height="8" transform="rotate(45)"></rect>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 item-detail">
                            <a href="{{ route('site.productDetails', ['code' => $item->code, 'name' => cleanedUrl($item->name)]) }}"><button class="bg-gray-100 px-4 py-2  "><i class="fa fa-eye"></i></button></a>
                        </div>
                        <div class="mt-2 item-compare">
                            <button data-itemId="{{ $item->id }}" class="bg-gray-100 px-4 py-2 add-to-compare"><i class="fa fa-random"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-4">
            @if (isset($offerAvailable) && $offerAvailable == true)
                <div class="mt-4 text-center timer">
                    <div data-offer_end="{{ strtotime($item->discount_to) - strtotime(now()) }}" class="offer border border-gray-200 p-0 sm:p-2 rounded-lg">
                        <svg class="-ml-10" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100%" height="20px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                            <g transform="translate(100 50)">
                            <circle cx="0" cy="0" r="40" fill="#e15b64">
                              <animateTransform attributeName="transform" type="scale" begin="-0.375s" calcMode="spline" keySplines="0.3 0 0.7 1;0.3 0 0.7 1" values="0;1;0" keyTimes="0;0.5;1" dur="1s" repeatCount="indefinite"></animateTransform>
                            </circle>
                            </g><g transform="translate(200 50)">
                            <circle cx="0" cy="0" r="40" fill="#f8b26a">
                              <animateTransform attributeName="transform" type="scale" begin="-0.25s" calcMode="spline" keySplines="0.3 0 0.7 1;0.3 0 0.7 1" values="0;1;0" keyTimes="0;0.5;1" dur="1s" repeatCount="indefinite"></animateTransform>
                            </circle>
                            </g><g transform="translate(300 50)">
                            <circle cx="0" cy="0" r="40" fill="#abbd81">
                              <animateTransform attributeName="transform" type="scale" begin="-0.125s" calcMode="spline" keySplines="0.3 0 0.7 1;0.3 0 0.7 1" values="0;1;0" keyTimes="0;0.5;1" dur="1s" repeatCount="indefinite"></animateTransform>
                            </circle>
                            </g><g transform="translate(400 50)">
                            <circle cx="0" cy="0" r="40" fill="#81a3bd">
                              <animateTransform attributeName="transform" type="scale" begin="0s" calcMode="spline" keySplines="0.3 0 0.7 1;0.3 0 0.7 1" values="0;1;0" keyTimes="0;0.5;1" dur="1s" repeatCount="indefinite"></animateTransform>
                            </circle>
                            </g>
                        </svg>
                    </div>
                </div>
            @endif
            <a href="{{ route('site.productDetails', ['code' => $item->code, 'name' => cleanedUrl($item->name)]) }}">
                <h4 class="text-center mt-2 text-lg text-gray-800">
                    {{ $item->name }}
                </h4>
            </a>

            <div class="flex space-x-3 justify-center items-center">
                <div class="self-top">
                    <h3 class="text-base {{ $item->id ? 'line-through text-gray-500' : 'font-semibold' }} ">
                        {{ currency()->symbol }}{{ formatCurrencyAmount($item->price) }}
                    </h3>
                </div>
                @if (\App\Models\Product::isDiscountable($item->id))
                    <div>
                        <h3 class="text-base font-semibold">
                            {{ currency()->symbol }}{{ formatCurrencyAmount($item->discounted_price) }}
                        </h3>
                    </div>
                @endif
            </div>

            <div class="my-2 pb-2 flex justify-between absolute inset-x-2 bottom-0">
                <div class="item-rating">
                    <div class="self-top">
                        <ul class="flex ">
                            <li class="mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 text-green-500" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </li>

                            <li class="ml-1 text-gray-900">
                                {{ \App\Models\Product::rating($item->id) }} ({{ \App\Models\Product::reviewCount($item->id) }})</li>
                        </ul>
                    </div>
                </div>
                @if(!hasOption($item->id))
                <a href="javascript:void(0)" class="add-to-cart" data-itemId={{ $item->id }}>
                    <div class="text-green-500 text-center underline text-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </a>
                @else
                    <a href="{{ route('site.productDetails', ['code' => $item->code, 'name' => cleanedUrl($item->name)]) }}">
                        <div class="text-green-500 text-center underline text-lg">
                            <i class="fa fa-eye"></i>
                        </div>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
