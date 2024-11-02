@if (is_array($component->disp_categories))
    <section class="mx-4 lg:mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92 md:my-12 my-10"
        style="margin-top:{{ $component->mt }};margin-bottom:{{ $component->mb }};">
        <P class="text-center font-bold text-sm md:text-22 text-gray-12 mb-2.5 md:mb-5 uppercase dm-bold">{!! $component->title !!}
        </P>
        <div id="{{ uniqid('id_') }}" class="p_tabs c-tabs">
            <div class="flex justify-center dm-sans md:mb-5 mb-2">
                <div class="c-tabs-nav dm-sans flex font-medium homepage-menu-tab">
                    @foreach ($component->disp_categories as $type)
                        <a href="#"
                            class="mr-4 c-tabs-nav__link {{ $loop->iteration == 1 ? 'is-active' : '' }}">{{ $homeService->getCategoryTitle($type) }}</a>
                    @endforeach
                    <div class="c-tab-nav-marker"></div>
                </div>
            </div>
            <div class="product-tab">
                @foreach ($component->disp_categories as $type)
                    <div class="c-tab {{ $loop->iteration == 1 ? 'is-active' : '' }}">
                        <div class="c-tab__content">
                            <div class="grid lg:grid-cols-5 md:grid-cols-4 grid-cols-2 gap-8">
                                <div>
                                    <div class="skeleton-box bg-gray-11 rev-img rounded-md relative">
                                        <div class="p-10 flex justify-center items-center h-40">
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <p
                                            class="text-13 text-gray-10 roboto-medium mt-3 skeleton-box py-2 inline-block w-full">
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
                                        <p
                                            class="text-13 text-gray-10 roboto-medium mt-3 skeleton-box py-2 inline-block w-full">
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
                                        <p
                                            class="text-13 text-gray-10 roboto-medium mt-3 skeleton-box py-2 inline-block w-full">
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
                                        <p
                                            class="text-13 text-gray-10 roboto-medium mt-3 skeleton-box py-2 inline-block w-full">
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
                                        <p
                                            class="text-13 text-gray-10 roboto-medium mt-3 skeleton-box py-2 inline-block w-full">
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
                                        <p
                                            class="text-13 text-gray-10 roboto-medium mt-3 skeleton-box py-2 inline-block w-full">
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
                                        <p
                                            class="text-13 text-gray-10 roboto-medium mt-3 skeleton-box py-2 inline-block w-full">
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
                                        <p
                                            class="text-13 text-gray-10 roboto-medium mt-3 skeleton-box py-2 inline-block w-full">
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
                                        <p
                                            class="text-13 text-gray-10 roboto-medium mt-3 skeleton-box py-2 inline-block w-full">
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
                                        <p
                                            class="text-13 text-gray-10 roboto-medium mt-3 skeleton-box py-2 inline-block w-full">
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
                    </div>
                @endforeach
                <button class="has-ajax-load-data opacity-0 invisible" onclick="ajaxProductLoad(this)"
                    data-component="{{ $component->id }}"></button>
            </div>
        </div>
    </section>

@endif
