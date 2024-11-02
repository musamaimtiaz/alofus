<section class="mx-4 lg:mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92 my-10 md:my-12"
    style="margin-top:{{ $component->mt }};margin-bottom:{{ $component->mb }};">
    <div class="flex justify-center md:justify-between md:items-center md:mb-5 mb-2.5">
        @if ($component->title)
            <P class="dm-bold text-sm text-center md:text-left md:text-22 text-gray-12 uppercase">
                {!! $component->title !!}</P>
        @endif
        <a href="{{ route('blog.all') }}"
        class="process-goto justify-center text-gray-10 font-medium text-base dm-sans hidden md:inline-flex items-center dm-sans hover:text-gray-12 trans-2 ltr:ml-auto">
        <span>{{ __('Read Blogs') }}</span>
        <svg class="relative ltr:ml-2 rtl:mr-2 neg-transition-scale" width="15" height="10" viewBox="0 0 15 10" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M9.70696 0L8.29274 1.41421L10.5856 3.70711H0.999849C0.447564 3.70711 -0.000150681 4.15482 -0.000150681 4.70711C-0.000150681 5.25939 0.447564 5.70711 0.999849 5.70711H10.5856L8.29274 8L9.70696 9.41421L14.4141 4.70711L9.70696 0Z"
                fill="currentColor"></path>
        </svg>
    </a>
    </div>
    <div class="flex overflow-x-auto md:overflow-hidden md:gap-30p gap-5">
        <div class="w-4/5 md:w-1/3">
            <div class="skeleton-box bg-gray-11 rev-img rounded-md relative w-260p md:w-auto h-48 overflow-hidden">
                <div class="p-10 flex justify-center items-center h-40">
                </div>
            </div>
            <div>
                <p class="text-13 text-gray-10 roboto-medium mt-3 skeleton-box py-2 inline-block w-full"></p>
                <p class="skeleton-box py-2 inline-block w-9/12 text-20 text-gray-12 dm-sans mt-0.5 font-medium">
                </p>
                <div class="item-rating mt-1p skeleton-box py-2 inline-block w-full">
                </div>
            </div>
        </div>
        <div class="w-4/5 md:w-1/3">
            <div class="skeleton-box bg-gray-11 rev-img rounded-md relative w-260p md:w-auto h-48 overflow-hidden">
                <div class="p-10 flex justify-center items-center h-40">
                </div>
            </div>
            <div>
                <p class="text-13 text-gray-10 roboto-medium mt-3 skeleton-box py-2 inline-block w-full"></p>
                <p class="skeleton-box py-2 inline-block w-9/12 text-20 text-gray-12 dm-sans mt-0.5 font-medium">
                </p>
                <div class="item-rating mt-1p skeleton-box py-2 inline-block w-full">

                </div>
            </div>
        </div>
        <div class="w-4/5 md:w-1/3">
            <div class="skeleton-box bg-gray-11 rev-img rounded-md relative w-260p md:w-auto h-48 overflow-hidden">
                <div class="p-10 flex justify-center items-center h-40">

                </div>
            </div>
            <div>
                <p class="text-13 text-gray-10 roboto-medium mt-3 skeleton-box py-2 inline-block w-full"></p>
                <p class="skeleton-box py-2 inline-block w-9/12 text-20 text-gray-12 dm-sans mt-0.5 font-medium">
                </p>
                <div class="item-rating mt-1p skeleton-box py-2 inline-block w-full">
                </div>
            </div>
        </div>
        <button class="has-ajax-load-data opacity-0 invisible" onclick="ajaxProductLoad(this)"
            data-component="{{ $component->id }}"></button>
    </div>
</section>
