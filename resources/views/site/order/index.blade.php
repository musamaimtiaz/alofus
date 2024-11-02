@extends('../site/layouts.user_panel.app')
@section('page_title', __('Orders'))
@section('content')
    <div class="dark:bg-red-1 h-full xl:px-74p px-5 pt-30p xl:pt-14">
        <div>
            <div class="flex items-center">
                <span class="lg:mt-0 mt-1 ltr:mr-4 rtl:ml-4">
                    <svg class="h-30p w-10 xl:w-53p xl:h-11 neg-transition-scale" xmlns="http://www.w3.org/2000/svg" width="53" height="44" viewBox="0 0 53 44" fill="none">
                        <rect x="36.1779" y="27.377" width="16.6222" height="16.6222" rx="2" fill="#FCCA19" />
                        <rect width="32.2667" height="32.2667" rx="2" fill="#FCCA19" />
                    </svg>
                </span>
                <h1 class="dm-sans font-medium lg:pt-0 text-2xl xl:text-4xl text-gray-12 mb-1 dark:text-gray-2">
                    {{ __('Your Orders') }}
                </h1>
            </div>
            <p class="dark:text-gray-2 lg:mt-1.5 roboto-medium select-auto font-medium text-base xl:text-xl mt-4 text-20 text-gray-10 leading-6">{{ __('Take a look at all the orders you made, their status and much more..') }}</p>
        </div>
        @if (count($orders) > 0 || request('filter_day') != null || request('filter_status') != null)
            <div class="lg:mt-20 mt-12">
                <div class="xl:flex xl:justify-between items-center">
                    <div class="text-lg dm-bold font-bold text-gray-12 xl:text-2xl uppercase"><p>{{ __('Order list') }}</p>
                    </div>
                    <div class="flex justify-between items-center mt-5 xl:mt-0">
                        <h1 class="dm-sans font-medium lg:text-lg text-sm whitespace-nowrap text-gray-12  ltr:mr-15p rtl:ml-15p">{{ __('Filter By') }}</h1>
                        <div class="flex">
                            <div x-data="{ dropdownOpen: false }" class="relative">
                                <div>
                                    <button @click="dropdownOpen = !dropdownOpen"
                                        class="inline-flex justify-between lg:w-168p w-24 border border-gray-2 px-2 lg:py-2.5 py-1 bg-white text-sm font-medium text-gray-10 hover:bg-gray-11 rounded-sm text-gray-700 hover:bg-gray-50 focus:outline-none dark:bg-gray-2">
                                        <div class="roboto-medium font-medium text-gray-10 lg:text-base text-xss whitespace-nowrap dark:text-gray-2">
                                            @php
                                                $filterDay = [
                                                    'today' => __('Today'),
                                                    'last_week' => __('Last 7 Days'),
                                                    'last_month' => __('Last 30 Days'),
                                                    'last_year' => __('Last 12 Months'),
                                                    'all_time' => __('All Time'),
                                                ];
                                            @endphp
                                            @foreach ($filterDay as $key => $value)
                                                @if (request('filter_day') == $key)
                                                    <span>{{ $value }}</span>
                                                @elseif (request('filter_day') == null && $key === 'all_time')
                                                    <span>{{ __('All Time') }}</span>
                                                @endif
                                            @endforeach
                                            @if (request('filter_day') && !in_array(request('filter_day'), array_flip($filterDay)))
                                                <span>{{ __('All Time') }}</span>
                                            @endif
                                        </div>
                                        <span class="mt-2">
                                            <svg class="w-2 h-1 lg:w-3 lg:h-2" xmlns="http://www.w3.org/2000/svg" width="13" height="7" viewBox="0 0 13 7"
                                                fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.89383e-08 1.21895L1.37054 1.63436e-08L6.5 4.5621L11.6295 1.3868e-07L13 1.21895L6.5 7L6.89383e-08 1.21895Z" fill="#898989" />
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                                <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10">
                                </div>
                                <div x-show="dropdownOpen" class="absolute right-0 lg:w-168p w-24 border-t-0 border-gray-2 border bg-white z-20">
                                    @foreach ($filterDay as $key => $value)
                                        <a href="{{ request()->fullUrlWithQuery(['filter_day' => $key]) }}" class="block whitespace-nowrap py-1 lg:py-2.5 lg:w-168p w-24 lg:text-sm text-xss roboto-medium text-gray-10 font-medium border-t-0 capitalize lg:h-47p hover:bg-gray-11 hover:text-gray-12">
                                            @if (request('filter_day') == $key)
                                                <span class="text-green-1 ltr:ml-1.5 ltr:lg:ml-3 rtl:mr-1.5 rtl:lg:mr-3 neg-transition-scale">✓</span>
                                                <span class="inline-block text-green-1 ltr:ml-1.5 ltr:lg:ml-3 rtl:mr-1.5 rtl:lg:mr-3">{{ $value }}</span>
                                            @elseif(request('filter_day') == null && $key === 'all_time')
                                                <span class="text-green-1 ltr:ml-1.5 ltr:lg:ml-3 rtl:mr-1.5 rtl:lg:mr-3 neg-transition-scale">✓</span>
                                                <span class="inline-block pb-2 text-green-1 ltr:lg:ml-1 rtl:lg:mr-1">{{ __('All Time') }}</span>
                                            @else
                                                <span class="inline-block lg:py-1 py-0 ltr:ml-1.5 ltr:lg:ml-3.5 rtl:mr-1.5 rtl:lg:mr-3.5">{{ $value }}</span>
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            <div x-data="{ dropdownOpen: false }" class="relative ">
                                <div class="flex items-center ltr:ml-3 rtl:mr-3">
                                    <button @click="dropdownOpen = !dropdownOpen"
                                        class="inline-flex justify-between lg:w-168p w-24 rounded-sm border border-gray-2 px-2 lg:py-2.5 py-1 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none dark:bg-gray-2">
                                        <div class="roboto-medium font-medium text-gray-10 lg:text-base text-xss whitespace-nowrap dark:text-gray-2">
                                            @if (isset(request()->filter_status))
                                                <span>{{ $statuses->where('id', request()->filter_status)->first()->name }}</span>
                                            @else
                                                <span>{{ __('All Status') }}</span>
                                            @endif
                                        </div>
                                        <span class="mt-2">
                                            <svg class="w-2 h-1 lg:w-3 lg:h-2" xmlns="http://www.w3.org/2000/svg" width="13" height="7" viewBox="0 0 13 7"
                                                fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.89383e-08 1.21895L1.37054 1.63436e-08L6.5 4.5621L11.6295 1.3868e-07L13 1.21895L6.5 7L6.89383e-08 1.21895Z" fill="#898989" />
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                                <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-47p z-10">
                                </div>
                                <div x-show="dropdownOpen" class="absolute border border-t-0 border-gray-2 lg:w-168p w-24 bg-white z-20  ltr:right-0 rtl:left-0">
                                    <div class=" roboto-medium font-medium text-sm text-gray-10">
                                        @foreach ($statuses as $key => $status)
                                        <a href="{{ request()->fullUrlWithQuery(['filter_status' => $status->id]) }}" class="block whitespace-nowrap lg:py-2.5 py-1 lg:w-168p w-24 lg:text-sm text-xss roboto-medium text-gray-10 font-medium border-t-0 capitalize lg:h-47p hover:bg-gray-11 hover:text-gray-12">
                                            @if (request('filter_status') == $status->id)
                                                <span class="text-green-500 ltr:ml-1.5 ltr:lg:ml-3 rtl:mr-1.5 rtl:lg:mr-3 neg-transition-scale">✓</span>
                                                <span class="inline-block text-green-1 ltr:ml-1.5 rtl:mr-1.5">{{ $status->name }}</span>
                                            @else
                                                <span class="inline-block lg:py-1 py-0 ltr:ml-1.5 ltr:lg:ml-3.5 rtl:mr-1.5 rtl:lg:mr-3.5">{{ $status->name }}</span>
                                            @endif
                                        </a>
                                        @endforeach
                                        <a class="block whitespace-nowrap py-2.5 lg:w-168p w-24 lg:text-sm text-xss roboto-medium text-gray-10 font-medium border-t-0 capitalize lg:h-47p hover:bg-gray-11 hover:text-gray-12" href="{{ url()->current().'?'.http_build_query(request()->except('filter_status')) }}">
                                            @if (!isset(request()->filter_status))
                                                <span class="text-green-500 ltr:ml-1.5 ltr:lg:ml-3 rtl:mr-1.5 rtl:lg:mr-3 neg-transition-scale">✓</span>
                                                <span class="inline-block ltr:ml-1.5 rtl:mr-1.5 text-green-1">{{ __('All Status') }}</span>
                                            @else
                                                <span class="inline-block ltr:ml-1.5 ltr:lg:ml-3 rtl:mr-1.5 rtl:lg:mr-3">{{ __('All Status') }}</span>
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        @endif
    </div>
    <div class="lg:py-23p py-0">
        <div class="overflow-x-auto hidden lg:block rounded-sm">
            <table class="w-full whitespace-nowrap bg-white dark:bg-gray-2 overflow-hidden">
                <thead>
                    @if (count($orders) > 0 || request('filter_day') != null || request('filter_status') != null)
                        <tr class="ltr:text-left rtl:text-right bg-gray-11 border border-gray-2 dark:bg-gray-2 text-gray-500">
                            <th class="py-4 dm-sans font-medium text-gray-12 xl:text-xl md:text-base text-lg dark:text-gray-2 ltr:pl-10 rtl:pr-10">
                                {{ __('Invoice No') }}
                            </th>
                            <th class="px-6 py-4 dm-sans font-medium text-gray-12 xl:text-xl md:text-base text-lg dark:text-gray-2">
                                {{ __('Order Date') }}</th>
                            <th class="px-6 py-4 dm-sans font-medium text-gray-12 xl:text-xl md:text-base text-lg dark:text-gray-2">
                                {{ __('Amount') }}</th>
                            <th class="px-6 py-4 dm-sans font-medium text-gray-12 xl:text-xl md:text-base text-lg dark:text-gray-2">
                                {{ __('Status') }}</th>
                            <th class="px-6 py-4 dm-sans font-medium text-gray-12 xl:text-xl md:text-base text-lg dark:text-gray-2">
                                {{ __('View') }}
                            </th>
                        </tr>
                    @endif
                </thead>
                <tbody>
                    @if (count($orders) > 0)
                        @foreach ($orders as $order)
                            <tr class="focus-within:bg-gray-200 border border-gray-2 overflow-hidden">
                                <td class="dark:border-t-gray-2 dark:bg-gray-3 py-18p  ltr:pl-10 ltr:pr-5 rtl:pr-10 rtl:pl-5">
                                    <a class="flex items-center" href="{{ route('site.orderDetails', $order->reference) }}">
                                        <span class="roboto-medium font-medium text-gray-10 flex xl:text-base text-sm items-center dark:text-gray-2">{{ $order->reference }}</span>
                                            <p class="{{ $order->payment_status == 'Paid' ? 'bg-green-5' : 'bg-orange-5' }} relative h-18p w-max justify-center text-white px-2 flex items-center rounded-sm leading-3 roboto-medium font-medium text-xss whitespace-nowrap ltr:ml-5 rtl:mr-5">{{ $order->payment_status == 'Paid' ? __('Paid') : __('Unpaid') }}</p>
                                    </a>
                                </td>
                                <td class="dark:border-t-gray-2 dark:bg-gray-3 ltr:pl-6 rtl:pr-6">
                                    <span class="roboto-medium font-medium text-gray-10 xl:text-base text-sm flex items-center dark:text-gray-2">{{ formatDate($order->order_date) }}</span>
                                </td>
                                <td class="dark:border-t-gray-2 dark:bg-gray-3 ltr:pl-6 rtl:pr-6">
                                    <span class="roboto-medium font-medium xl:text-base text-sm text-gray-10 flex items-center dark:text-gray-2">{{ optional($order->currency)->symbol . formatCurrencyAmount($order->total) }}</span>
                                </td>
                                <td class="dark:border-t-gray-2 dark:bg-gray-3 ltr:pl-4 rtl:pr-4">
                                    <?php
                                        list($r, $g, $b) = sscanf($order->orderStatus->color, "#%02x%02x%02x");
                                    ?>
                                    <span class="roboto-medium font-medium xl:text-base text-sm py-4 flex items-center dark:text-gray-2">
                                        <span class="h-8 w-32 py-2 text-center rounded text-xs" style="color: {{ $order->orderStatus->color }}; background: rgba({{ $r . ',' . $g . ',' . $b . ', 0.1' }});">
                                            {{ $order->orderStatus->name }}
                                        </span>
                                    </span>
                                </td>
                                <td class="dark:border-t-gray-2 dark:bg-gray-3 ltr:pl-6 rtl:pr-6">
                                    <div>
                                        <a href="{{ route('site.orderDetails', $order->reference) }}">
                                            <button class="px-1 py-1 rounded font-medium">
                                                <svg class="neg-transition-scale" xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4 5C4 4.44772 4.44772 4 5 4L9 4C9.55228 4 10 4.44772 10 5C10 5.55229 9.55228 6 9 6L5 6C4.44772 6 4 5.55228 4 5Z" fill="#828282" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4 13C4 12.4477 4.44772 12 5 12L8 12C8.55228 12 9 12.4477 9 13C9 13.5523 8.55228 14 8 14L5 14C4.44772 14 4 13.5523 4 13Z" fill="#828282" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4 9C4 8.44772 4.44772 8 5 8L11 8C11.5523 8 12 8.44772 12 9C12 9.55229 11.5523 10 11 10L5 10C4.44772 10 4 9.55228 4 9Z" fill="#828282" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.92943 20L8 20V18H7C5.55752 18 4.57625 17.9979 3.84143 17.8991C3.13538 17.8042 2.80836 17.6368 2.58579 17.4142C2.36322 17.1916 2.19585 16.8646 2.10092 16.1586C2.00213 15.4237 2 14.4425 2 13V7C2 5.55751 2.00213 4.57625 2.10092 3.84143C2.19585 3.13538 2.36322 2.80836 2.58579 2.58578C2.80836 2.36321 3.13538 2.19584 3.84143 2.10092C4.57625 2.00212 5.55752 2 7 2H9C10.4425 2 11.4238 2.00212 12.1586 2.10092C12.8646 2.19584 13.1916 2.36321 13.4142 2.58578C13.6368 2.80836 13.8042 3.13538 13.8991 3.84143C13.9979 4.57625 14 5.55751 14 7V9H16L16 6.92942C16 5.5753 16.0001 4.45869 15.8813 3.57493C15.7565 2.6471 15.4845 1.82768 14.8284 1.17157C14.1723 0.515463 13.3529 0.243494 12.4251 0.11875C11.5413 -6.86646e-05 10.4247 -3.8147e-05 9.07055 -1.90735e-06H6.92946C5.57533 -3.8147e-05 4.4587 -6.86646e-05 3.57494 0.11875C2.64711 0.243494 1.82768 0.515463 1.17158 1.17157C0.515467 1.82768 0.243498 2.6471 0.118755 3.57493C-6.35162e-05 4.45869 -3.41884e-05 5.57531 1.21679e-06 6.92943V13.0706C-3.41884e-05 14.4247 -6.35162e-05 15.5413 0.118755 16.4251C0.243498 17.3529 0.515467 18.1723 1.17158 18.8284C1.82768 19.4845 2.64711 19.7565 3.57494 19.8812C4.4587 20.0001 5.57531 20 6.92943 20Z" fill="#828282" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13.5 14C12.6716 14 12 14.6716 12 15.5C12 16.3284 12.6716 17 13.5 17C14.3284 17 15 16.3284 15 15.5C15 14.6716 14.3284 14 13.5 14ZM10 15.5C10 13.567 11.567 12 13.5 12C15.433 12 17 13.567 17 15.5C17 17.433 15.433 19 13.5 19C11.567 19 10 17.433 10 15.5Z" fill="#828282" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14.7929 16.7929C15.1834 16.4024 15.8166 16.4024 16.2071 16.7929L17.7071 18.2929C18.0976 18.6834 18.0976 19.3166 17.7071 19.7071C17.3166 20.0976 16.6834 20.0976 16.2929 19.7071L14.7929 18.2071C14.4024 17.8166 14.4024 17.1834 14.7929 16.7929Z" fill="#828282" />
                                                </svg>
                                            </button>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        @if (count($orders) == 0)
            <div class="flex flex-col justify-center items-center lg:mt-216p my-90p">
                <span class="lg:w-93p lg:h-103p w-75p h-75p">
                    <svg xmlns="http://www.w3.org/2000/svg" width="93" height="103" viewBox="0 0 93 103" fill="none">
                        <path d="M9.54483 0.301765C8.84073 0.4627 7.67393 0.865044 6.9296 1.22716C5.0587 2.13243 2.56417 4.62696 1.67901 6.47775C0.351276 9.19357 0.431745 6.75938 0.471979 49.1262L0.532331 87.6104L0.954791 88.5357C1.51807 89.7428 2.82569 91.0504 4.03272 91.6137C4.93799 92.0361 5.11905 92.0361 18.9396 92.0965C26.6243 92.1166 33.1423 92.0965 33.3837 92.0361C34.1482 91.8551 34.8321 90.9699 34.8321 90.1854C34.8321 89.441 34.4097 88.6565 33.8665 88.3748C33.6855 88.2943 27.248 88.1736 19.6034 88.1133L5.66221 88.0127L5.11905 87.4494L4.55577 86.9063V48.5227C4.55577 12.4727 4.57589 10.0988 4.91788 9.15333C5.40069 7.76524 6.56749 6.27657 7.8751 5.39142C10.0075 3.94298 7.99581 4.02345 41.7323 4.02345H72.0691L71.4857 4.86837C70.7413 5.9547 70.0976 7.22208 69.6751 8.42911C69.3734 9.27403 69.3331 12.5732 69.2325 43.4531L69.132 77.5518L68.6693 78.2961C68.1663 79.1209 66.8386 79.8652 65.8931 79.8652C65.0683 79.8451 63.7405 79.2215 63.2376 78.5777C63.0163 78.276 62.0507 75.701 61.0851 72.8242C59.2343 67.292 58.8118 66.4672 57.3232 65.3809C54.8487 63.5904 51.3081 63.9324 49.1556 66.2057C48.1497 67.2518 47.6066 68.5996 47.4054 70.551L47.2646 72.0195H41.9335C38.413 72.0195 36.4616 72.1 36.18 72.2408C34.6712 73.0254 34.6712 75.0371 36.18 75.8217C36.4616 75.9625 38.413 76.043 41.9536 76.043H47.3048V80.509C47.3048 85.6791 47.5663 89.4008 48.0089 91.1912C48.5319 93.1627 49.3769 95.3354 52.2536 102.115C52.314 102.215 52.6157 102.477 52.9577 102.678C53.8027 103.181 54.7683 102.96 55.4523 102.155C56.1765 101.29 56.096 100.868 54.2855 96.5625C52.6359 92.6397 52.0323 90.9297 51.7306 89.3606C51.5898 88.5357 51.4691 79.483 51.5294 70.8729C51.5294 69.8469 51.6099 69.525 52.0525 69.0221C52.9376 67.9559 54.7482 67.9961 55.4724 69.1025C55.6333 69.3439 56.5185 71.8184 57.464 74.6348C58.4095 77.4311 59.355 80.0061 59.5562 80.3481C60.7028 82.1787 63.0566 83.6473 65.1689 83.8283C67.6835 84.0697 70.4396 82.7621 71.888 80.6498C73.2962 78.5777 73.256 79.1813 73.256 59.567V41.9645L73.8796 42.568C75.1872 43.775 78.245 47.2754 78.9491 48.3416C80.8603 51.2184 82.1277 54.1957 82.8519 57.5352C83.1738 59.1043 83.214 60.4723 83.214 73.7295C83.214 86.9063 83.1738 88.3949 82.8519 90.3061C82.3892 92.9213 81.5241 95.8383 80.4579 98.4736C79.5124 100.727 79.4521 101.371 80.0355 102.155C80.82 103.221 82.4898 103.181 83.1939 102.095C84.0187 100.827 85.6079 96.3815 86.3321 93.2834C87.2374 89.4209 87.338 87.6305 87.338 73.4881C87.338 57.3742 87.2575 56.6098 85.1452 51.4195C83.4554 47.2754 81.7253 44.8815 76.8368 39.9125L73.256 36.2713V35.3459V34.4205L80.6591 34.3602C87.7202 34.2998 88.0823 34.2797 88.9675 33.8773C90.1745 33.3141 91.4821 32.0064 92.0454 30.7994C92.4478 29.8941 92.4679 29.6125 92.5282 20.2982C92.5886 9.63614 92.5282 8.95216 91.3212 6.47775C90.4361 4.62696 87.9415 2.13243 86.0907 1.24728C83.395 -0.0603409 85.5476 7.62939e-06 46.3995 0.0201263C17.1894 0.0201263 10.5708 0.0804749 9.54483 0.301765ZM83.5157 4.52637C84.8032 4.96896 86.312 6.17599 87.1771 7.44337C88.5249 9.39474 88.5651 9.87755 88.5048 20.0971L88.4445 29.1699L87.8812 29.7131L87.338 30.2764L80.2769 30.3367L73.2359 30.3971L73.2962 20.1776C73.3566 11.0443 73.3968 9.85743 73.7187 9.05274C74.5435 6.92032 76.7161 4.92872 78.8888 4.3252C80.1964 3.9631 82.1679 4.04356 83.5157 4.52637Z" fill="#B0B0B0" />
                        <path d="M13.6085 11.2455C12.6429 11.6881 12.0193 12.3318 11.5968 13.3176C11.1542 14.424 11.1542 24.201 11.5968 25.3074C12.0193 26.2932 12.6429 26.9369 13.6085 27.3795C14.3328 27.7215 14.9966 27.7617 19.6035 27.7617C25.3167 27.7617 25.699 27.7014 26.9462 26.4943C28.0326 25.4482 28.1935 24.4826 28.1935 19.3125C28.1935 14.1424 28.0326 13.1768 26.9462 12.1307C25.699 10.9236 25.3167 10.8633 19.6035 10.8633C14.9966 10.8633 14.3328 10.9035 13.6085 11.2455ZM24.1701 19.3125V23.7383H19.7443H15.3185V19.3125V14.8867H19.7443H24.1701V19.3125Z" fill="#B0B0B0" />
                        <path d="M36.1397 23.9599C34.6511 24.8249 34.6712 26.7763 36.2202 27.5608C37.6686 28.3052 39.4188 26.6153 38.7751 25.0864C38.6343 24.7243 38.3727 24.322 38.1917 24.1812C37.7491 23.819 36.6226 23.6983 36.1397 23.9599Z" fill="#B0B0B0" />
                        <path d="M45.3735 23.9391C44.2469 24.3817 43.925 26.1117 44.7699 27.0975L45.2528 27.6608L52.676 27.7211C56.7397 27.7613 60.3004 27.7211 60.5418 27.6608C60.8033 27.6004 61.2459 27.2986 61.5074 27.017C62.3725 26.0916 62.0506 24.5828 60.8436 23.9592C60.3205 23.6977 46.0373 23.6776 45.3735 23.9391Z" fill="#B0B0B0" />
                        <path d="M13.6085 35.3861C12.6429 35.8287 12.0193 36.4725 11.5968 37.4582C11.1542 38.5647 11.1542 48.3416 11.5968 49.448C12.0193 50.4338 12.6429 51.0775 13.6085 51.5201C14.3328 51.8621 14.9966 51.9023 19.6035 51.9023C25.3167 51.9023 25.699 51.842 26.9462 50.635C28.0326 49.5889 28.1935 48.6232 28.1935 43.4531C28.1935 38.283 28.0326 37.3174 26.9462 36.2713C25.699 35.0643 25.3167 35.0039 19.6035 35.0039C14.9966 35.0039 14.3328 35.0442 13.6085 35.3861ZM24.1701 43.4531V47.8789H19.7443H15.3185V43.4531V39.0274H19.7443H24.1701V43.4531Z" fill="#B0B0B0" />
                        <path d="M36.1397 48.1207C34.651 48.9254 34.6711 50.917 36.1799 51.6814C36.8036 52.0033 60.22 52.0033 60.8436 51.6814C61.5477 51.3193 61.9903 50.6555 61.9903 49.891C61.9903 49.1266 61.5477 48.4627 60.8436 48.1006C60.2401 47.7988 36.703 47.7988 36.1397 48.1207Z" fill="#B0B0B0" />
                        <path d="M13.6085 59.5268C12.6429 59.9693 12.0193 60.6131 11.5968 61.5988C11.1542 62.7053 11.1542 72.4822 11.5968 73.5887C12.0193 74.5744 12.6429 75.2182 13.6085 75.6607C14.3328 76.0027 14.9966 76.043 19.6035 76.043C25.3167 76.043 25.699 75.9826 26.9462 74.7756C28.0326 73.7295 28.1935 72.7639 28.1935 67.5938C28.1935 62.4236 28.0326 61.458 26.9462 60.4119C25.699 59.2049 25.3167 59.1445 19.6035 59.1445C14.9966 59.1445 14.3328 59.1848 13.6085 59.5268ZM24.1701 67.5938V72.0195H19.7443H15.3185V67.5938V63.168H19.7443H24.1701V67.5938Z" fill="#B0B0B0" />
                        <path d="M40.4247 88.6967C39.0768 89.9037 39.8614 92.0361 41.6719 92.0361C43.4825 92.0361 44.267 89.9037 42.9192 88.6967C42.5168 88.3346 42.0542 88.1133 41.6719 88.1133C41.2897 88.1133 40.827 88.3346 40.4247 88.6967Z" fill="#B0B0B0" />
                    </svg>
                </span>
                @if (request('filter_day') != null || request('filter_status') != null)
                    <p class="text-center dm-sans font-medium lg:text-32 text-lg text-gray-14 leading-10 mt-22p">{{ __('No order found!') }}</p>
                @else
                    <p class="text-center dm-sans font-medium lg:text-32 text-lg text-gray-14 leading-10 mt-22p">{{ __('No Orders!') }}</p>
                    <p class="text-center dm-sans font-medium lg:text-32 text-lg text-gray-14 leading-10">{{ __("You haven't ordered anything yet.") }}</p>
                @endif
            </div>
         @endif
    </div>
    <div>
        <div class="block mt-15p lg:hidden">
            @if (count($orders) > 0)
                @foreach ($orders as $order)
                    <a href="{{ route('site.orderDetails', $order->reference) }}" class="flex cursor-pointer justify-between p-15p border-t border border-gray-2">
                        <div>
                            <p class="capitalized text-gray-10 text-xs roboto-medium font-medium mb-1.5">{{ __('Order number') }}
                            </p>
                            <div class="flex items-center flex-wrap">
                                <p class="roboto-medium text-xl font-medium text-gray-12 mb-1.5">
                                    {{ $order->reference }}</p>
                                    <p class="{{ $order->payment_status == 'Paid' ? 'bg-green-5' : 'bg-orange-5' }} h-18p w-max justify-center text-white px-2 flex items-center rounded-sm mb-1.5 leading-3 roboto-medium font-medium text-xss whitespace-nowrap  ltr:ml-1 rtl:mr-1">{{ $order->payment_status == 'Paid' ? __('Paid') : __('Unpaid') }}</p>
                            </div>
                            <p class="roboto-medium font-medium text-gray-10 text-xs">
                                {{ formatDate($order->order_date) }}</p>
                        </div>
                        <div>
                            <p class="roboto-medium font-medium mb-3 text-gray-10 text-right">
                                <?php
                                    list($r, $g, $b) = sscanf($order->orderStatus->color, "#%02x%02x%02x");
                                ?>
                                <span class="bg-gray-11 text-gray-10 px-5 w-max py-1.5 text-center rounded text-xs" style="color: {{ $order->orderStatus->color }}; background: rgba({{ $r . ',' . $g . ',' . $b . ', 0.1' }});">
                                    {{ optional($order->orderStatus)->name }}
                                </span>
                            </p>
                            <p class="roboto-medium font-medium text-gray-12 text-xl text-right dark:text-gray-2">
                                {{ optional($order->currency)->symbol . formatCurrencyAmount($order->total) }}
                            </p>
                        </div>
                    </a>
                @endforeach
            @endif
        </div>
      <div class="mt-5">
        {{ $orders->onEachSide(1)->links('site.layouts.partials.pagination') }}
      </div>
    </div>
    </div>
@endsection
