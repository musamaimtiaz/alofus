<div class="md:flex gap-5 mt-5 mx-0 lg:mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92">
    <div class="bg-gray-12 md:mx-0 p-5 rounded-md border lg:w-28% md:w-1/3 w-full">
        <div class="flex justify-center items-center">
            <img class="h-84p w-84p rounded-full neg-transition-scale" src="{{ optional($vendor->logo)->fileUrl() ?? $vendor->fileUrl() }}" alt="avatar">
            <div class="ltr:ml-5 rtl:mr-5">
                @if (in_array($shop->vendor_id, $topSellerIds))
                    <p class="primary-bg-color whitespace-nowrap py-1.5 w-max px-2 text-center rounded-sm roboto-medium font-medium text-gray-12 text-xs">{{ __('top Seller') }}</p>
                @endif
                <p class="text-white font-bold dm-bold text-2xl">{{ $vendor->name }}</p>
            </div>
        </div>
        <p class="my-5 roboto-medium font-medium text-gray-2 text-sm">{{ $shop->description }}</p>
        <div class="flex flex-wrap items-center mb-5">
            <div class="flex">
                @for ($star = 1; $star <= 5; $star++)
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="{{ $star <= round($avg) ? 'var(--primary-color)' : '#C4C4C4' }}">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                    </span>
                @endfor
            </div>
            <span class="ltr:pl-2.5 rtl:pr-2.5 pt-1 roboto-medium font-medium font-sm text-white">{{ round($avg) }}</span>
            <span class="ltr:pl-1 rtl:pr-1 pt-1 roboto-medium font-medium font-sm text-gray-10">({{ $reviewCount }} {{ __('Reviews') }})</span>
        </div>
        <div class="flex flex-wrap justify-between items-center">
            <div class="text-white dm-sans font-medium">
                <p class="text-sm">{{ __('Seller Ratings') }}</p>
                <p class="text-2xl"> {{ round($positiveRating) }}%</p>
            </div>
            @if (isActive('Ticket') && preference('chat'))
                <div>
                    <a href="javaScript:void(0);" class="primary-bg-color text-gray-12 font-bold dm-bold text-sm rounded-sm flex justify-between items-center py-3.5 px-8 w-max" id="chat-initiate-vendor" data-vendor="{{ route('chat.initiate-chat-with-vendor', ['code' => base64_encode($vendor->id )]) }}">
                        <span class="whitespace-nowrap"> {{ __('Chat Now') }}</span>
                        <svg class="ltr:ml-2 rtl:mr-2" xmlns="http://www.w3.org/2000/svg" width="17" height="18" viewBox="0 0 17 18"
                            fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.50461 3.79496e-07H9.49539C10.7786 -1.41442e-05 11.8134 -2.59653e-05 12.6436 0.0844338C13.5006 0.171614 14.2438 0.356532 14.9013 0.795839C15.4169 1.14036 15.8596 1.58308 16.2042 2.0987C16.6435 2.75617 16.8284 3.49938 16.9156 4.35638C17 5.18664 17 6.22141 17 7.50459V7.60651C17 8.8897 17 9.92447 16.9156 10.7547C16.8284 11.6117 16.6435 12.3549 16.2042 13.0124C15.8596 13.528 15.4169 13.9707 14.9013 14.3153C14.3271 14.6989 13.688 14.8884 12.9641 14.9885C12.3956 15.0671 11.7374 15.0948 10.9756 15.105L10.1895 16.6773C9.49337 18.0695 7.50663 18.0695 6.81053 16.6773L6.02435 15.105C5.26255 15.0948 4.6044 15.0671 4.03589 14.9885C3.31203 14.8884 2.67291 14.6989 2.0987 14.3153C1.58308 13.9707 1.14036 13.528 0.795839 13.0124C0.356532 12.3549 0.171614 11.6117 0.0844338 10.7547C-2.59653e-05 9.92447 -1.41442e-05 8.88969 3.79496e-07 7.6065V7.50461C-1.41442e-05 6.22142 -2.59653e-05 5.18664 0.0844338 4.35638C0.171614 3.49939 0.356532 2.75617 0.795839 2.0987C1.14037 1.58308 1.58308 1.14036 2.0987 0.795839C2.75617 0.356532 3.49939 0.171614 4.35639 0.0844338C5.18664 -2.59653e-05 6.22142 -1.41442e-05 7.50461 3.79496e-07ZM4.54755 1.96362C3.8399 2.03561 3.44348 2.16903 3.14811 2.36639C2.83874 2.57311 2.57311 2.83873 2.36639 3.14811C2.16903 3.44348 2.03561 3.8399 1.96362 4.54755C1.89003 5.27098 1.88889 6.20946 1.88889 7.55555C1.88889 8.90165 1.89003 9.84013 1.96362 10.5636C2.03561 11.2712 2.16903 11.6676 2.36639 11.963C2.57311 12.2724 2.83874 12.538 3.14811 12.7447C3.40628 12.9172 3.74211 13.041 4.29454 13.1174C4.86215 13.1958 5.59182 13.2165 6.61523 13.2209C6.99724 13.2226 7.32547 13.4509 7.47276 13.7781L8.5 15.8326L9.52724 13.7781C9.67453 13.4509 10.0028 13.2226 10.3848 13.2209C11.4082 13.2165 12.1379 13.1958 12.7055 13.1174C13.2579 13.041 13.5937 12.9172 13.8519 12.7447C14.1613 12.538 14.4269 12.2724 14.6336 11.963C14.831 11.6676 14.9644 11.2712 15.0364 10.5636C15.11 9.84013 15.1111 8.90165 15.1111 7.55555C15.1111 6.20946 15.11 5.27098 15.0364 4.54755C14.9644 3.8399 14.831 3.44348 14.6336 3.14811C14.4269 2.83873 14.1613 2.57311 13.8519 2.36639C13.5565 2.16903 13.1601 2.03561 12.4524 1.96362C11.729 1.89003 10.7905 1.88889 9.44444 1.88889H7.55556C6.20946 1.88889 5.27098 1.89003 4.54755 1.96362Z" fill="#2C2C2C" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.7207 5.6671C4.7207 5.1455 5.14355 4.72266 5.66515 4.72266L11.3318 4.72266C11.8534 4.72266 12.2763 5.1455 12.2763 5.6671C12.2763 6.1887 11.8534 6.61154 11.3318 6.61154L5.66515 6.61154C5.14355 6.61154 4.7207 6.1887 4.7207 5.6671Z" fill="#2C2C2C" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.7207 9.44444C4.7207 8.92284 5.14355 8.5 5.66515 8.5H8.49848C9.02008 8.5 9.44292 8.92284 9.44292 9.44444C9.44292 9.96605 9.02008 10.3889 8.49848 10.3889H5.66515C5.14355 10.3889 4.7207 9.96605 4.7207 9.44444Z" fill="#2C2C2C" />
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </div>
    <div class="lg:w-72% md:w-2/3 w-full mt-5 md:mt-0">
        <img class="object-cover neg-transition-scale rounded-md w-full h-322p" src="{{ optional($vendor->cover)->fileUrl() ?? $vendor->fileUrl() }}" alt="{{ __('Shop Image') }}">
    </div>
</div>
