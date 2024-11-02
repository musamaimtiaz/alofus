<section class="mx-4 lg:mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92 my-10 md:my-12"
    style="margin-top:{{ $component->mt }};margin-bottom:{{ $component->mb }};">
    <div class="flex md:justify-{{ $component->see_more == 1 ? 'between' : 'center' }} justify-center items-center mb-2.5 md:mb-5">
        <P class="font-bold text-sm md:text-22 text-gray-12 uppercase dm-bold">{{ $component->title }}
        </P>
        @if ($component && $component->see_more && $component->more_link)
            <a href="{{ $component->more_link }}"
                class="process-goto relative justify-center text-gray-10 font-medium text-base dm-sans hidden md:inline-flex items-center dm-sans hover:text-gray-12 trans-2">
                <span class="ltr:-ml-5 rtl:ml-3">{{ __('See More') }}</span>
                <svg class="relative ltr:ml-2 neg-transition-scale" width="15" height="10" viewBox="0 0 15 10" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M9.70696 0L8.29274 1.41421L10.5856 3.70711H0.999849C0.447564 3.70711 -0.000150681 4.15482 -0.000150681 4.70711C-0.000150681 5.25939 0.447564 5.70711 0.999849 5.70711H10.5856L8.29274 8L9.70696 9.41421L14.4141 4.70711L9.70696 0Z"
                        fill="currentColor"></path>
                </svg>
            </a>
        @endif
    </div>
    <div class="md:flex md:gap-5 gap-0">
        @if ($component->sidebar && $component->sidebar_position == 'left')
            <div class="md:w-322p w-full h-full">
                <div class="relative dm-sans h-full">
                    <div class="skeleton-box h-full bg-gray-11 rev-img rounded-md relative">
                        <div class="p-10 flex justify-center items-center h-96">
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($component->showcase_type)
            <div
                class="w-full">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-5 mt-5 md:mt-0">
                    <div>
                        <div class="skeleton-box bg-gray-11 rev-img rounded-md relative">
                            <div class="p-10 flex justify-center items-center h-40">
                            </div>
                        </div>
                        <div class="text-center">
                            <p class="text-13 text-gray-10 roboto-medium mt-3 skeleton-box py-2 inline-block w-full">
                            </p>
                            <p
                                class="skeleton-box py-2 inline-block w-9/12 text-20 text-gray-12 dm-sans mt-0.5 font-medium">
                            </p>
                            <div class="item-rating mt-1p skeleton-box py-2 inline-block w-full">
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="skeleton-box bg-gray-11 rev-img rounded-md relative">
                            <div class="p-10 flex justify-center items-center h-40">
                            </div>
                        </div>
                        <div class="text-center">
                            <p class="text-13 text-gray-10 roboto-medium mt-3 skeleton-box py-2 inline-block w-full">
                            </p>
                            <p
                                class="skeleton-box py-2 inline-block w-9/12 text-20 text-gray-12 dm-sans mt-0.5 font-medium">
                            </p>
                            <div class="item-rating mt-1p skeleton-box py-2 inline-block w-full">
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="skeleton-box bg-gray-11 rev-img rounded-md relative">
                            <div class="p-10 flex justify-center items-center h-40">
                            </div>
                        </div>
                        <div class="text-center">
                            <p class="text-13 text-gray-10 roboto-medium mt-3 skeleton-box py-2 inline-block w-full">
                            </p>
                            <p
                                class="skeleton-box py-2 inline-block w-9/12 text-20 text-gray-12 dm-sans mt-0.5 font-medium">
                            </p>
                            <div class="item-rating mt-1p skeleton-box py-2 inline-block w-full">
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="skeleton-box bg-gray-11 rev-img rounded-md relative">
                            <div class="p-10 flex justify-center items-center h-40">
                            </div>
                        </div>
                        <div class="text-center">
                            <p class="text-13 text-gray-10 roboto-medium mt-3 skeleton-box py-2 inline-block w-full">
                            </p>
                            <p
                                class="skeleton-box py-2 inline-block w-9/12 text-20 text-gray-12 dm-sans mt-0.5 font-medium">
                            </p>
                            <div class="item-rating mt-1p skeleton-box py-2 inline-block w-full">
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="skeleton-box bg-gray-11 rev-img rounded-md relative">
                            <div class="p-10 flex justify-center items-center h-40">
                            </div>
                        </div>
                        <div class="text-center">
                            <p class="text-13 text-gray-10 roboto-medium mt-3 skeleton-box py-2 inline-block w-full">
                            </p>
                            <p
                                class="skeleton-box py-2 inline-block w-9/12 text-20 text-gray-12 dm-sans mt-0.5 font-medium">
                            </p>
                            <div class="item-rating mt-1p skeleton-box py-2 inline-block w-full">
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="skeleton-box bg-gray-11 rev-img rounded-md relative">
                            <div class="p-10 flex justify-center items-center h-40">
                            </div>
                        </div>
                        <div class="text-center">
                            <p class="text-13 text-gray-10 roboto-medium mt-3 skeleton-box py-2 inline-block w-full">
                            </p>
                            <p
                                class="skeleton-box py-2 inline-block w-9/12 text-20 text-gray-12 dm-sans mt-0.5 font-medium">
                            </p>
                            <div class="item-rating mt-1p skeleton-box py-2 inline-block w-full">
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="skeleton-box bg-gray-11 rev-img rounded-md relative">
                            <div class="p-10 flex justify-center items-center h-40">
                            </div>
                        </div>
                        <div class="text-center">
                            <p class="text-13 text-gray-10 roboto-medium mt-3 skeleton-box py-2 inline-block w-full">
                            </p>
                            <p
                                class="skeleton-box py-2 inline-block w-9/12 text-20 text-gray-12 dm-sans mt-0.5 font-medium">
                            </p>
                            <div class="item-rating mt-1p skeleton-box py-2 inline-block w-full">
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="skeleton-box bg-gray-11 rev-img rounded-md relative">
                            <div class="p-10 flex justify-center items-center h-40">
                            </div>
                        </div>
                        <div class="text-center">
                            <p class="text-13 text-gray-10 roboto-medium mt-3 skeleton-box py-2 inline-block w-full">
                            </p>
                            <p
                                class="skeleton-box py-2 inline-block w-9/12 text-20 text-gray-12 dm-sans mt-0.5 font-medium">
                            </p>
                            <div class="item-rating mt-1p skeleton-box py-2 inline-block w-full">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($component->sidebar && $component->sidebar_position == 'right')
            <div class="w-full md:w-322p md:block">
                <div class="relative h-full dm-sans ">
                    <div class="skeleton-box h-full bg-gray-11 rev-img rounded-md relative">
                        <div class="p-10 flex justify-center items-center h-60">
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <button class="has-ajax-load-data opacity-0 invisible" onclick="ajaxProductLoad(this)"
            data-component="{{ $component->id }}"></button>
    </div>
    <div class="flex justify-center mt-5 md:hidden">
        @if ($component && $component->see_more && $component->more_link)
            <a href="{{ $component->more_link }}"
                class="process-goto relative justify-center text-gray-10 font-medium text-sm dm-sans items-center inline-flex dm-sans hover:text-gray-12 trans-2">
                <span class="ltr:-ml-5 rtl:ml-3">{{ __('See More') }}</span>
                <svg class="ltr:ml-2 neg-transition-scale relative" xmlns="http://www.w3.org/2000/svg" width="10" height="7"
                    viewBox="0 0 10 7" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M6.7344 0L5.75327 1.05155L7.34399 2.75644H0.69376C0.310607 2.75644 0 3.08934 0 3.5C0 3.91066 0.310607 4.24356 0.69376 4.24356H7.34399L5.75327 5.94845L6.7344 7L10 3.5L6.7344 0Z"
                        fill="currentColor" />
                </svg>
            </a>
        @endif
    </div>

</section>
