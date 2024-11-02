@extends('../site/layouts.user_panel.app')
@section('page_title', __('Order Refund'))
@section('content')
    <div class="dark:bg-red-1 h-full xl:px-74p px-5 pt-30p xl:pt-14">
        <div class="flex justify-between">
            <div>
                <div class="flex items-center">
                    <span class="ltr:mr-4 rtl:ml-4 lg:mt-0 mt-1">
                        <svg class="h-30p w-10 xl:w-53p xl:h-11 neg-transition-scale" xmlns="http://www.w3.org/2000/svg" width="53" height="44" viewBox="0 0 53 44" fill="none">
                            <rect x="36.1779" y="27.377" width="16.6222" height="16.6222" rx="2" fill="#FCCA19" />
                            <rect width="32.2667" height="32.2667" rx="2" fill="#FCCA19" />
                        </svg>
                    </span>
                    <h1 class="dm-sans font-medium lg:pt-0 text-2xl xl:text-4xl text-gray-12 mb-1 dark:text-gray-2">{{ __('Your Refund') }} </h1>
                </div>
                <p class="dark:text-gray-2 lg:mt-1.5 roboto-medium font-medium text-base xl:text-xl mt-2 text-20 text-gray-10 leading-6"> {{ __('Customer satisfaction is our top priority..') }}</p>
            </div>
            @if (count($orders) && preference('order_refund'))
                <div class="xl:block hidden">
                    <p class="text-gray-12 mb-15p text-sm dm-sans font-medium ltr:text-right rtl:text-left">{{ __('Want a Refund? Click the button below') }}</p>
                    <a href="{{ url('/user/create-refund-request') }}">
                        <span class="bg-yellow-1 py-3.5 px-9 w-190 h-12 rounded dm-sans text-sm ltr:ml-68p rtl:mr-68p">{{ __('Request A Refund') }}</span>
                    </a>
                </div>
            @endif
        </div>

        @if (count($orders) && preference('order_refund'))
            <div class="xl:hidden block">
                <p class="text-gray-12 text-sm text-center mt-7 dm-sans font-medium">{{ __('Want a Refund? Click the button below') }}</p>
                <div class="bg-yellow-1 py-3.5 px-9 rounded dm-sans text-sm flex justify-center mx-16 items-center mt-15p">
                    <a href="{{ url('/user/create-refund-request') }}">{{ __('Request A Refund') }}</a>
                </div>
            </div>
        @endif
        <div class="lg:mt-20 mt-12">
            <div class="xl:flex xl:justify-between">
                <div class="dm-bold font-bold text-gray-12 xl:text-2xl text-lg uppercase">
                    <p>{{ __('refund list') }}</p>
                </div>
                <div class="flex justify-between mt-5 xl:mt-0">
                    <h1 class="dm-sans font-medium mt-2 lg:text-lg text-sm whitespace-nowrap text-gray-12 ltr:mr-15p rtl:ml-15p">
                        {{ __('Filter By') }}
                    </h1>
                    <div class="flex">
                        <div x-data="{ dropdownOpen: false }">
                            <div class="flex items-center">
                                <button @click="dropdownOpen = !dropdownOpen"
                                    class="inline-flex justify-between lg:w-168p w-24 border border-gray-2 px-2 lg:py-2.5 py-1 bg-white text-sm font-medium text-gray-10 hover:bg-gray-11">
                                    <div class="roboto-medium font-medium text-gray-10 lg:text-base text-xss whitespace-nowrap dark:text-gray-2">
                                        @if (isset(request()->filter_status))
                                            <span>{{ request()->filter_status }}</span>
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
                            <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10">
                            </div>
                            <div x-show="dropdownOpen" class="absolute lg:w-168p w-24 border-t-0 border-gray-2 border bg-white z-20">
                                <div>
                                    @php
                                        $statuses = ['Opened' => __('Opened'), 'In progress' => __('In progress'), 'Accepted' => __('Accepted'), 'Declined' => __('Declined'), 'All Status' => __('All Status')];
                                    @endphp

                                    @foreach ($statuses as $key => $status)
                                    <a href="{{ request()->fullUrlWithQuery(['filter_status' => $status]) }}" class="block whitespace-nowrap lg:py-2.5 py-1 lg:w-168p w-24 lg:text-sm text-xss roboto-medium text-gray-10 font-medium border-t-0 capitalize lg:h-47p hover:bg-gray-11 hover:text-gray-12">
                                        @if (request('filter_status') == $status || (request('filter_status') == null && $key == 'All Status'))
                                            <span class="text-green-1 ltr:ml-1.5 ltr:lg:ml-3 rtl:mr-1.5 rtl:lg:mr-3 neg-transition-scale">✓</span><span
                                                class="inline-block text-green-1 ltr:ml-1.5 rtl:mr-1.5">{{ $status }}</span>
                                        @else
                                            <span class="inline-block lg:py-1 py-0 ltr:ml-1.5 ltr:lg:ml-3.5 rtl:mr-1.5 rtl:lg:mr-3.5">{{ $status }}</span>
                                        @endif
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div x-data="{ dropdownOpen: false }">
                            <div class="flex items-center ltr:ml-3 rtl:mr-3">
                                <button @click="dropdownOpen = !dropdownOpen" class="inline-flex justify-between lg:w-168p w-24 rounded-sm border border-gray-2 px-2 lg:py-2.5 py-1 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none dark:bg-gray-2">
                                    <div class="roboto-medium font-medium text-gray-10 lg:text-base text-xss whitespace-nowrap dark:text-gray-2">
                                        @if (isset(request()->filter_day))
                                            <span>{{ ucwords(str_replace('_', ' ', request()->filter_day)) }}</span>
                                        @else
                                            <span>{{ __('All') }}</span>
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
                            <div x-show="dropdownOpen"class="absolute lg:w-168p w-24 ltr:ml-3 rtl:mr-3 border-t-0 border-gray-2 border bg-white z-20">
                                <div>
                                    @php
                                        $statuses = ['today' => __('Today'), 'last_week' => __('Last Week'), 'last_month' => __('Last Month'), 'last_year' => __('Last Year'), 'all' => __('All')];
                                    @endphp

                                    @foreach ($statuses as $key => $status)
                                    <a href="{{ request()->fullUrlWithQuery(['filter_day' => $key]) }}" class="block whitespace-nowrap pt-3.5 lg:w-168p w-24 lg:text-sm text-xss roboto-medium text-gray-10 font-medium border-t-0 capitalize lg:h-47p hover:bg-gray-11 hover:text-gray-12">
                                        @if (request('filter_day') == $key || (request('filter_day') == null && $key == 'all'))
                                            <span class="text-green-1 text-md ltr:ml-2 rtl:mr-2 neg-transition-scale">✓</span><span
                                                class="inline-block text-green-1 mb-2 ltr:lg:ml-3 ltr:ml-1 rtl:lg:mr-3 rtl:mr-1">{{ $status }}</span>
                                        @else
                                            <span class="inline-block mb-2 ltr:lg:ml-3 ltr:ml-2 rtl:lg:mr-3 rtl:mr-2">{{ $status }}</span>
                                        @endif
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="md:max-w-8xl md:mx-auto lg:py-23p py-0">
            <div class="overflow-x-auto hidden lg:block rounded-sm">
                <table class="w-full whitespace-no-wrap bg-white dark:bg-gray-2 overflow-hidden table-striped">
                    <thead>
                        <tr class="ltr:text-left rtl:text-right bg-gray-11 border border-gray-2 rounded-t dark:bg-gray-2 text-gray-500 font-thin text-xs">
                            <th class="ltr:pl-10 ltr:pr-14 rtl:pr-10 rtl:pl-14 py-4 dm-sans font-medium text-gray-12 xl:text-xl md:text-base text-lg dark:text-gray-2 tracking-wider">
                                {{ __('ID Number') }}
                            </th>
                            <th class="px-6 py-4 dm-sans font-medium text-gray-12 xl:text-xl md:text-base text-lg dark:text-gray-2 tracking-wider">
                                {{ __('Date') }}
                            </th>
                            <th class="ltr:pl-10 rtl:pr-10 py-4 dm-sans font-medium text-gray-12 xl:text-xl md:text-base text-lg dark:text-gray-2 tracking-wider">
                                {{ __('Amount') }}
                            </th>
                            <th class="ltr:pl-72p rtl:pr-72p py-4 dm-sans font-medium text-gray-12 xl:text-xl md:text-base text-lg dark:text-gray-2 tracking-wider">
                                {{ __('Status') }}
                            </th>
                            <th class="px-6 py-4 dm-sans font-medium text-gray-12 xl:text-xl md:text-base text-lg dark:text-gray-2">
                                {{ __('View') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($refunds) > 0)
                            @foreach ($refunds as $refund)
                                <tr class="focus-within:bg-gray-200 overflow-hidden border border-gray-2">
                                    <td class="dark:border-t-gray-2 dark:bg-gray-3">
                                        <span class="roboto-medium font-medium text-gray-10 ltr:pl-10 rtl:pr-10 py-4 flex items-center dark:text-gray-2">{{ $refund->orderDetail->order->reference }}</span>
                                    </td>
                                    <td class="dark:border-t-gray-2 dark:bg-gray-3">
                                        <span class="roboto-medium font-medium text-gray-10 px-6 py-18p flex items-center dark:text-gray-2">{{ timeZoneFormatDate($refund->created_at) }}
                                        </span>
                                    </td>
                                    <td class="dark:border-t-gray-2 dark:bg-gray-3 ltr:pl-4 rtl:pr-4">
                                        <span class="roboto-medium font-medium text-gray-10 px-6 py-4 flex items-center dark:text-gray-2"> {{ $refund->quantity_sent . ' x ' . formatNumber($refund->orderDetail->price) }}</span>
                                    </td>
                                    <td class="border-t dark:border-t-gray-2 dark:bg-gray-3">
                                        <span class="roboto-medium font-medium text-base py-4 flex items-center dark:text-gray-2 ltr:ml-68p rtl:mr-68p">
                                            @php
                                                $color = ['Opened' => 'bg-gray-11 ; text-gray-10 ', 'In progress' => 'bg-green-2 ; text-green-1', 'Accepted' => 'bg-green-2 ; text-green-1', 'Declined' => 'bg-pinks-2 ; text-reds-3'];
                                            @endphp
                                            <span class="{{ $color[$refund->status] }} py-2 px-9 rounded text-xs">{{ $refund->status }}</span>
                                        </span>
                                    </td>
                                    <td class="dark:border-t-gray-2 dark:bg-gray-3 ltr:pl-6 rtl:pr-6">
                                        <div>
                                            <a href="{{ route('site.refundDetails', $refund->id) }}">
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
                        @else
                            <tr class="h-36 border rounded-b">
                                <td colspan="5">
                                    <p class="text-center dm-sans font-medium text-xl text-gray-10">{{ __('You Have No Refund Requests Yet') }} </p>
                                    @if (count($orders) && preference('order_refund'))
                                        <div class="w-full text-center mt-9">
                                            <a class="hover:bg-yellow-1 hover:border-white delay-120 hover:text-gray-12 border-gray-12 border py-3.5 px-9 w-190 h-12 rounded dm-sans text-sm" href="{{ url('/user/create-refund-request') }}">{{ __('Request A Refund') }}</a>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div>
            <div class="block mt-5 lg:hidden">
                @if (count($refunds) > 0)
                    @foreach ($refunds as $refund)
                        <a href="{{ route('site.refundDetails', $refund->id) }}" class="flex cursor-pointer justify-between p-15p border-t border border-gray-2">
                            <div>
                                <p class="capitalized text-gray-10 text-xs roboto-medium font-medium mb-1.5">{{ __('Refund ID') }}</p>
                                <p class="roboto-medium text-xl font-medium text-gray-12 mb-1.5">{{ $refund->orderDetail->order->reference }}</p>
                                <p class="roboto-medium font-medium text-gray-10 text-xs">{{ timeZoneFormatDate($refund->created_at) }}</p>
                            </div>
                            <div>
                                <p class="roboto-medium font-medium mb-3 text-gray-10 ltr:text-right rtl:text-left">
                                    @php
                                        $color = ['Opened' => 'bg-gray-11 ; text-gray-10 ', 'In progress' => 'bg-green-2 ; text-green-1', 'Accepted' => 'bg-green-2 ; text-green-1', 'Declined' => 'bg-pinks-2 ; text-reds-3'];
                                    @endphp
                                    <span class="{{ $color[$refund->status] }} px-7 py-1.5 text-center rounded text-xs">
                                        {{ $refund->status }}
                                    </span>
                                </p>
                                <p class="roboto-medium font-medium text-gray-12 text-xl ltr:text-right rtl:text-left dark:text-gray-2">
                                    {{ formatNumber($refund->orderDetail->price) }}</p>
                            </div>
                        </a>
                    @endforeach
                @else
                    <p class="dm-sans font-medium text-gray-10 text-lg cursor-pointer text-center py-10 border-t border border-gray-2">{{ __('You Have No Refund Requests Yet.') }}</p>
                @endif
            </div>
        </div>
        {{ $refunds->onEachSide(1)->links('site.layouts.partials.pagination') }}
    </div>
@endsection
@section('js')
    <script src="{{ asset('public/dist/js/custom/site/common.min.js') }}"></script>
@endsection
