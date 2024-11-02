<div class="c-tab review md:mt-6" id="product-review-panel">
    <div class="c-tab__content">
        <div class="md:mt-4">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-1 md:grid-cols-6 lg:grid-cols-6">
                @if(preference('rating_enable'))
                <div class="col-span-3">
                    <div class="flex items-center">
                        <p class="text-52 text-gray-12 dm-bold">{{ round($avg, 1) }}</p>
                        <div class="ltr:pl-2.5 rtl:pr-2.5">
                            <p class="roboto-medium text-base text-gray-12">{{ __('Average Rating') }}</p>
                            <ul class="flex sm:justify-center gap-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($avg >= $i)
                                        {{-- Full star --}}
                                        <li class="mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class=" primary-text-color" width="12" height="12" viewBox="0 0 12 12" fill="currentColor">
                                                <path d="M6.07621 0L7.4575 4.25119H11.9275L8.31119 6.87857L9.69249 11.1298L6.07621 8.50238L2.45993 11.1298L3.84123 6.87857L0.224947 4.25119H4.69491L6.07621 0Z" fill="currentColor"/>
                                            </svg>
                                        </li>
                                    @elseif ($avg < $i && $avg > $i-1)
                                        {{-- Half star --}}
                                        <li class="mt-1">
                                            <svg class="h-3 w-3" viewBox="0 0 142 142" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M71 0L86.9405 49.0598H138.525L96.7923 79.3804L112.733 128.44L71 98.1196L29.2672 128.44L45.2077 79.3804L3.47499 49.0598H55.0595L71 0Z"
                                                    fill="#C4C4C4"/>
                                                <mask id="mask0_2170_1814" class="mask-type-alpha"
                                                        maskUnits="userSpaceOnUse" x="3" y="0" width="136" height="129">
                                                    <path
                                                        d="M71 0L86.9405 49.0598H138.525L96.7923 79.3804L112.733 128.44L71 98.1196L29.2672 128.44L45.2077 79.3804L3.47499 49.0598H55.0595L71 0Z"
                                                        fill="#C4C4C4"/>
                                                </mask>
                                                <g mask="url(#mask0_2170_1814)">
                                                    <rect x="-39" y="-36" width="110" height="201" fill="var(--primary-color)"/>
                                                </g>
                                            </svg>
                                        </li>
                                    @else
                                        {{-- Empty star --}}
                                        <li class="mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class=" text-gray-300" width="12" height="12" viewBox="0 0 12 12" fill="currentColor">
                                                <path d="M6.07621 0L7.4575 4.25119H11.9275L8.31119 6.87857L9.69249 11.1298L6.07621 8.50238L2.45993 11.1298L3.84123 6.87857L0.224947 4.25119H4.69491L6.07621 0Z" fill="currentColor"/>
                                            </svg>
                                        </li>
                                    @endif
                                @endfor
                                <p class="text-gray-10 text-xs roboto-medium ltr:ml-1 rtl:mr-1"> ({{ $reviewCount }} {{ $reviewCount > 1 ? __('Reviews') : __('Review') }})</p>
                            </ul>
                        </div>
                    </div>
                    <div class="mb-1 tracking-wide mt-2 md:mt-0 md:py-4" >
                        <div class="md:pb-3">
                            @for($i = 5; $i >= 1; $i--)
                                <div class="flex items-center mt-1">
                                    <div class=" text-indigo-500 tracking-tighter ltr:mr-4 rtl:ml-4">
                                        <ul class="flex">
                                            @for($j = 1; $j <= 5; $j++)
                                                @if ($i >= $j)
                                                    <li>
                                                        <svg class="primary-text-color" width="13" height="12" viewBox="0 0 13 12" fill="var(--primary-color)" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M6.15238 0L7.53368 4.25119H12.0036L8.38736 6.87857L9.76866 11.1298L6.15238 8.50238L2.5361 11.1298L3.9174 6.87857L0.301119 4.25119H4.77109L6.15238 0Z"/>
                                                        </svg>
                                                    </li>
                                                @else
                                                    <li>
                                                        <svg width="13" height="12" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7.9048 0L9.72229 5.59367H15.6038L10.8456 9.05074L12.6631 14.6444L7.9048 11.1873L3.14654 14.6444L4.96404 9.05074L0.205779 5.59367H6.08731L7.9048 0Z" fill="#C4C4C4"/>
                                                        </svg>
                                                    </li>
                                                @endif
                                            @endfor
                                        </ul>
                                    </div>
                                    @php
                                        $percent = 0;
                                        if ($reviewCount > 0) {
                                            $percent = intval((\App\Models\Review::where('status', 'Active')->where('product_id', $id)->where('rating', $i)->count() / $reviewCount) * 100);
                                        }
                                    @endphp
                                    <div class="w-49%">
                                        <div class="bg-gray-6 w-full rounded-lg h-2">
                                            <div data-width="{{ $percent }}" class="rating-width primary-bg-color rounded-lg h-2"></div>
                                        </div>
                                    </div>
                                    <div class="w-1/5 text-gray-700 ltr:pl-3 rtl:pr-3">
                                        <span class="text-sm">{{ $percent }}%</span>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
                @endif
                <div class="col-span-3">
                    @if (!auth()->user())
                        <div class="flex flex-col justify-center items-center">
                            <p class="dm-sans text-lg md:text-20 text-gray-12 md:mt-24">{{ __('To give a review, you need to login first.') }}</p>
                            <a href="javascript:void(0)" class="border w-52 py-1 text-center mt-18p text-base dm-sans text-gray-12 rounded open-login-modal">{{ __('Login') }}</a>
                        </div>
                    @endif

                    @if(auth()->user() && auth()->user()->review()->where('product_id', $id)->count() == 0 && (auth()->user()->isPurchaseProduct($id) || preference('review_left') == 0))
                        <section class="text-gray-600 body-font mt-4 review-store-section">
                            <form method="post" id="reviewFrom" enctype="multipart/form-data">
                                @csrf
                                <div class="flex flex-col">
                                    <h1 class="text-lg font-medium dm-sans text-gray-12">{{ __('Add A Review') }}</h1>
                                </div>
                                <input type="hidden" id="deleted-files" name="deleted_files">
                                @if(preference('rating_enable'))
                                <div class="flex justify-between items-center cursor-pointer mt-4 border rounded px-15p py-13p">
                                    <p class="dm-sans text-sm fonr-medium text-gray-12">{{ __('Add Your Rating') }} </p>
                                    <div class='rating-stars text-center'>
                                        <ul id='stars' class="text-xs">
                                            <li class='star' title="{{ __('Poor') }}" data-value='1'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title="{{ __('Fair') }}" data-value='2'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title="{{ __('Good') }}" data-value='3'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title="{{ __('Excellent') }}" data-value='4'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title="{{ __('WOW') }}" data-value='5'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                @endif
                                <input type="hidden" id="product_id" value="{{ $id }}">
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                                    <label class="block ltr:text-left rtl:text-right mt-3 col-span-2 c-label">
                                        <span class="text-sm text-gray-12 dm-sans">{{ __('Write Your Review') }}</span>
                                        <textarea class="form-control form-textarea block w-full rounded text-13 roboto-medium h-32 mt-2.5"
                                            id="comments" name="comments" rows="3" placeholder="{{ __('Your review') }}"
                                            value="{{ old('name') }}"></textarea>
                                    </label>
                                    <label class="block ltr:text-left rtl:text-right md:mt-3 col-span-2 md:col-span-0">
                                        <span class="text-sm text-gray-12 dm-sans">{{ __('Attachments') }}</span>
                                        <div class="relative h-24 rounded border-dashed mt-2.5 py-16 border bg-white flex justify-center items-center hover:cursor-pointer">
                                            <div class="absolute">
                                                <div class="flex flex-col items-center justify-center">
                                                    <div class="text-xl mb-3">
                                                        <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <circle cx="19" cy="19" r="19" fill="#F3F3F3"/>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12.4232 20.4614C12.8267 20.4614 13.1539 20.7886 13.1539 21.1922V24.1153C13.1539 24.3091 13.2309 24.495 13.368 24.632C13.505 24.769 13.6909 24.846 13.8847 24.846H24.1155C24.3093 24.846 24.4951 24.769 24.6322 24.632C24.7692 24.495 24.8462 24.3091 24.8462 24.1153V21.1922C24.8462 20.7886 25.1734 20.4614 25.577 20.4614C25.9806 20.4614 26.3078 20.7886 26.3078 21.1922V24.1153C26.3078 24.6967 26.0768 25.2543 25.6657 25.6655C25.2545 26.0766 24.6969 26.3076 24.1155 26.3076H13.8847C13.3033 26.3076 12.7456 26.0766 12.3345 25.6655C11.9234 25.2543 11.6924 24.6967 11.6924 24.1153V21.1922C11.6924 20.7886 12.0196 20.4614 12.4232 20.4614Z" fill="#898989"/>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M18.4831 11.9062C18.7685 11.6208 19.2312 11.6208 19.5166 11.9062L23.1704 15.56C23.4558 15.8454 23.4558 16.3081 23.1704 16.5935C22.885 16.8789 22.4223 16.8789 22.137 16.5935L18.9998 13.4564L15.8627 16.5935C15.5774 16.8789 15.1147 16.8789 14.8293 16.5935C14.5439 16.3081 14.5439 15.8454 14.8293 15.56L18.4831 11.9062Z" fill="#898989"/>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M19.0003 11.6921C19.4039 11.6921 19.7311 12.0193 19.7311 12.4229V21.1921C19.7311 21.5957 19.4039 21.9229 19.0003 21.9229C18.5967 21.9229 18.2695 21.5957 18.2695 21.1921V12.4229C18.2695 12.0193 18.5967 11.6921 19.0003 11.6921Z" fill="#898989"/>
                                                        </svg>
                                                    </div>
                                                    <span class="block text-gray-400 font-normal text-xss">{{ __('Attach you files here') }}</span>
                                                    <p class="flex text-xss">{{ __('or') }} <span class="block text-blue-400 text-xss ltr:ml-0.5 rtl:mr-0.5">{{ __('browse files') }}</span></p>
                                                </div>
                                            </div>
                                            <input type="file" id="image" name="image[]" multiple class="h-full w-full opacity-0">
                                        </div>
                                    </label>
                                </div>
                                <div id="message" class="mt-4">

                                </div>
                                <div id="imgs" class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mt-2.5">

                                </div>
                                <button class="text-white bg-black mt-2.5 rounded-sm text-xs p-2 w-33 text-center dm-regular save-review">
                                    {{ __('Submit Review') }}
                                </button>
                            </form>
                        </section>
                    @endif
                </div>
            </div>

            <div id="review-section" class="flex justify-between items-center border-b pb-1 mt-5 md:mt-0">
                <h2 class="font-bold text-gray-12 dm-bold text-base md:text-20">
                    {{ __('Product Reviews') }}
                </h2>

                <div class="flex justify-center ltr:md:pr-4 rtl:md:pl-4 items-center">
                    <div x-data="{ dropdownOpen: false }" class="relative ltr:ml-2 rtl:mr-2">
                        <button @click="dropdownOpen = !dropdownOpen" class="flex justify-between items-center w-full gap-3 md:w-48 rounded md:px-2 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                            <div class="flex text-gray-500 items-center">
                                <svg class="md:block hidden ltr:mr-5p rtl:ml-5p" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 1.57238C0 0.703977 0.696446 0 1.55556 0H12.4444C13.3036 0 14 0.703977 14 1.57238V2.8191C14 3.23612 13.8361 3.63606 13.5444 3.93094L10.1111 7.40135V11.5095C10.1111 12.0171 9.78977 12.4677 9.31337 12.6283L5.42448 13.9386C4.66903 14.1931 3.88888 13.6247 3.88888 12.8198V7.40134L0.455612 3.93094C0.163888 3.63606 0 3.23612 0 2.8191V1.57238ZM12.4444 1.57238H1.55556V2.8191L4.98883 6.2895C5.28055 6.58438 5.44444 6.98432 5.44444 7.40134V12.2744L8.55555 11.2262V7.40135C8.55555 6.98433 8.71944 6.58439 9.01116 6.28951L12.4444 2.8191V1.57238Z" fill="#898989"/>
                                </svg>
                                <svg class="md:hidden ltr:mr-5p rtl:ml-5p" width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 1.23544C0 0.553125 0.547208 0 1.22222 0H9.77778C10.4528 0 11 0.553125 11 1.23544V2.21501C11 2.54267 10.8712 2.85691 10.642 3.0886L7.94444 5.81535V9.04318C7.94444 9.44201 7.69196 9.79609 7.31765 9.92221L4.26209 10.9517C3.66852 11.1517 3.05555 10.7052 3.05555 10.0727V5.81534L0.357981 3.0886C0.12877 2.85691 0 2.54267 0 2.21501V1.23544ZM9.77778 1.23544H1.22222V2.21501L3.91979 4.94175C4.149 5.17344 4.27777 5.48768 4.27777 5.81534V9.64419L6.72222 8.82057V5.81535C6.72222 5.48769 6.85099 5.17345 7.0802 4.94176L9.77778 2.21501V1.23544Z" fill="#898989"/>
                                </svg>

                                <div class="roboto-medium text-13 md:text-base text-gray-10">{{ __('Filter') }}: <span class="filter-value" data-item="{{ $id }}" data-filter-star="0">{{ __('All Star') }}</span></div>
                            </div>
                            <svg class="w-2 h-1 md:w-0 md:h-0" width="15" height="8" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.87867e-08 1.39309L1.5814 1.8858e-08L7.5 5.21383L13.4186 1.60015e-07L15 1.39309L7.5 8L7.87867e-08 1.39309Z" fill="#898989"/>
                            </svg>
                        </button>
                        <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"></div>

                        <div x-show="dropdownOpen" class="absolute ltr:right-0 rtl:left-0 mt-2 py-2 w-full md:w-48 bg-white rounded shadow z-20 roboto-medium">
                            <button @click="dropdownOpen = false" data-star="0" data-item="{{ $id }}" class="filter w-full ltr:text-left rtl:text-right px-3 py-2 text-sm capitalize hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-gray-200">
                                <span class="primary-text-color text-md">✓</span><span class="inline-block ltr:ml-3 rtl:mr-3 primary-text-color">{{ __('All Star') }}</span>
                            </button>

                            @for($star = 5; $star >= 1; $star--)
                                <button @click="dropdownOpen = false"  data-star="{{ $star }}" data-item="{{ $id }}" class="filter w-full ltr:text-left rtl:text-right px-3 py-2 text-sm capitalize hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-gray-200">
                                    <span class="inline-block ltr:ml-6 rtl:mr-6">{{ $star . ' ' . __('Star') }}</span>
                                </button>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
            <div class="md:p-4">
                <div id="load_review">
                    @include('site.product.review')
                </div>
                <hr class="mt-4">
            </div>
        </div>
    </div>
</div>
