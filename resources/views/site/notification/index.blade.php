@extends('../site/layouts.user_panel.app')
@section('page_title', __('Notifications'))
@section('content')
    <div class="dark:bg-red-1 h-full xl:px-74p px-5 pt-30p xl:pt-14" id="user_notification_container">
        <div>
            <div class="flex items-center">
                <span class="mr-4 lg:mt-0 mt-1">
                    <svg class="h-30p w-10 lg:w-53p lg:h-11" xmlns="http://www.w3.org/2000/svg" width="53" height="44" viewBox="0 0 53 44" fill="none">
                        <rect x="36.1779" y="27.377" width="16.6222" height="16.6222" rx="2" fill="#FCCA19" />
                        <rect width="32.2667" height="32.2667" rx="2" fill="#FCCA19" />
                    </svg>
                </span>
                <h1 class="dark:text-gray-2 dm-sans font-medium lg:pt-0 text-2xl lg:text-4xl text-gray-12 mb-1 dark:text-gray-2">
                    {{ __('Notifications') }}
                </h1>
            </div>
            <p class="dark:text-gray-2 lg:mt-1.5 roboto-medium font-medium text-base lg:text-xl mt-4 text-20 text-gray-10 leading-6">
                {{ __('All the notifications you received from us..') }}</p>
            <p class="lg:mt-90p mt-10 dm-bold lg:hidden block font-bold text-gray-12 lg:text-2xl text-lg uppercase">{{ __('Notifications') }}</p>
        </div>
        <div>
            <div class="lg:flex lg:justify-between lg:mt-7 mt-15p">
                <div class="mt-14 lg:block hidden dm-bold font-bold text-gray-12 lg:text-2xl text-lg uppercase">
                    <p>{{ __('Notifications') }}</p>
                </div>
                <div class="flex justify-between lg:mt-10 mt-15p">
                    <h1 class="dm-sans font-medium mt-2 lg:text-lg text-sm whitespace-nowrap lg:mr-15p mr-0 text-gray-12 ">
                        {{ __('Filter By') }}
                    </h1>
                    <div class="flex">
                        <div x-data="{ dropdownOpen: false }" class="mr-2">
                            <div>
                                <button @click="dropdownOpen = !dropdownOpen" class="inline-flex justify-between lg:w-168p w-24 border border-gray-2 px-2 lg:py-2.5 py-1 bg-white text-sm font-medium text-gray-10 hover:bg-gray-11 ">
                                    <div class="roboto-medium font-medium text-gray-10 lg:text-base text-xss whitespace-nowrap dark:text-gray-2 ">
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
                                            @elseif(request('filter_day') == null && $key === 'all_time')
                                                <span>{{ __('All Time') }}</span>
                                            @endif
                                        @endforeach
                                        @if (request('filter_day') && !in_array(request('filter_day'), array_flip($filterDay)))
                                            <span>{{ __('All Time') }}</span>
                                        @endif
                                    </div>
                                    <span class="mt-2 hidden lg:block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="7" viewBox="0 0 13 7" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.89383e-08 1.21895L1.37054 1.63436e-08L6.5 4.5621L11.6295 1.3868e-07L13 1.21895L6.5 7L6.89383e-08 1.21895Z"
                                                fill="#898989" />
                                        </svg>
                                    </span>
                                    <span class=" mt-2 lg:hidden block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="8" height="4" viewBox="0 0 8 4" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.93933e-08 0.696543L0.843412 1.00576e-08L4 2.60691L7.15659 8.53415e-08L8 0.696543L4 4L3.93933e-08 0.696543Z" fill="#898989" />
                                        </svg>
                                    </span>
                                </button>
                            </div>
                            <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full z-10">
                            </div>
                            <div x-show="dropdownOpen" class="absolute lg:w-168p w-24 border-t-0 border-gray-2 border bg-white z-20">
                                @foreach ($filterDay as $key => $value)
                                    <a href="{{ request()->fullUrlWithQuery(['filter_day' => $key]) }}" class="block whitespace-nowrap pt-3.5 lg:w-168p w-24 lg:text-sm text-xss roboto-medium text-gray-10 font-medium border-t-0 capitalize lg:h-47p hover:bg-gray-11 hover:text-gray-12">
                                        @if (request('filter_day') == $key)
                                            <span class="text-green-1 ml-1">✓</span>
                                            <span class="inline-block ml-1.5 lg:ml-3 text-green-1">{{ $value }}</span>
                                        @elseif(request('filter_day') == null && $key === 'all_time')
                                            <span class="text-green-1 ml-1.5 lg:ml-1">✓</span>
                                            <span class="inline-block lg:ml-1 pb-2 text-green-1">{{ __('All Time') }}</span>
                                        @else
                                            <span class="inline-block ml-1.5 lg:ml-2">{{ $value }}</span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div x-data="{ dropdownOpen: false }">
                            <div>
                                <button @click="dropdownOpen = !dropdownOpen" class="inline-flex justify-between lg:w-168p w-24 border border-gray-2 px-2 lg:py-2.5 py-1 bg-white text-sm font-medium text-gray-10 hover:bg-gray-11 ">
                                    <div class="roboto-medium font-medium text-gray-10 lg:text-base text-xss whitespace-nowrap dark:text-gray-2 ">
                                        @php
                                            $filterType = [
                                                'read' => __('Read'),
                                                'unread' => __('Unread'),
                                                'all_notification' => __('All Notification'),
                                            ];
                                        @endphp
                                        @foreach ($filterType as $key => $value)
                                            @if (request('filter_type') == $key)
                                                <span>{{ $value }}</span>
                                            @elseif(request('filter_type') == null && $key === 'all_notification')
                                                <span>{{ __('All Notification') }}</span>
                                            @endif
                                        @endforeach
                                        @if (request('filter_type') && !in_array(request('filter_type'), array_flip($filterType)))
                                            <span>{{ __('All Notification') }}</span>
                                        @endif
                                    </div>
                                    <span class="mt-2 hidden lg:block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="7" viewBox="0 0 13 7" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.89383e-08 1.21895L1.37054 1.63436e-08L6.5 4.5621L11.6295 1.3868e-07L13 1.21895L6.5 7L6.89383e-08 1.21895Z"
                                                fill="#898989" />
                                        </svg>
                                    </span>
                                    <span class=" mt-2 lg:hidden block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="8" height="4" viewBox="0 0 8 4" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.93933e-08 0.696543L0.843412 1.00576e-08L4 2.60691L7.15659 8.53415e-08L8 0.696543L4 4L3.93933e-08 0.696543Z" fill="#898989" />
                                        </svg>
                                    </span>
                                </button>
                            </div>
                            <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full z-10">
                            </div>
                            <div x-show="dropdownOpen" class="absolute lg:w-168p w-24 border-t-0 border-gray-2 border bg-white z-20">
                                @foreach ($filterType as $key => $value)
                                    <a href="{{ request()->fullUrlWithQuery(['filter_type' => $key]) }}" class="block whitespace-nowrap pt-3.5 lg:w-168p w-24 lg:text-sm text-xss roboto-medium text-gray-10 font-medium border-t-0 capitalize lg:h-47p hover:bg-gray-11 hover:text-gray-12">
                                        @if (request('filter_type') == $key)
                                            <span class="text-green-1 ml-1">✓</span>
                                            <span class="inline-block ml-1.5 lg:ml-3 text-green-1">{{ $value }}</span>
                                        @elseif(request('filter_type') == null && $key === 'all_notification')
                                            <span class="text-green-1 ml-1.5 lg:ml-1">✓</span>
                                            <span class="inline-block lg:ml-1 pb-2 text-green-1">{{ __('All Notification') }}</span>
                                        @else
                                            <span class="inline-block ml-1.5 lg:ml-2">{{ $value }}</span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:mt-30p mt-15p lg:mb-30p mb-6">
            @forelse ($notifications as $notification)
                <div class="transition delay-150 bg-white hover:bg-gray-11 border border-gray-2 rounded lg:px-30p px-3 lg:flex items-center justify-between mb-6">
                    <div class="flex justify-between gap-2 py-2">
                        <img class="lg:h-10 h-7 lg:w-10 w-7 lg:my-30p my-4" src="{{ asset($notification->type::$image) }}" alt="{{ __('Image') }}" />
                        <a href="{{ !empty($notification->data['url']) ? route('site.notifications.view', ['id' => $notification->id, 'url' => $notification->data['url']]) : '' }}" class="flex flex-col justify-center">
                            <p class="roboto-medium font-medium lg:text-base text-11 lg:ml-5 ml-2.5  hover:text-gray-12 "> {{ $notification->data['label'] }}</p>
                            <p class="roboto-medium font-medium lg:text-base text-11 lg:ml-5 ml-2.5 text-gray-10 hover:text-gray-12 "> {{ $notification->data['message'] }}</p>
                            <p class="roboto-medium font-medium text-gray-10 lg:text-sm text-xss lg:ml-5 ml-2.5 mt-2">{{ timeToGo($notification->created_at, false, 'ago'); }}</p>                    
                        </a>
                    </div>

                    <div class="flex gap-3 items-center lg:w-[150px] justify-end pb-2 lg:pb-0">                    
                        {{-- read and unread button --}}
                        <a href="javascript:void(0)" data-id="{{ $notification->id }}" class="action-icon marked-action">
                            <img src="{{ asset('public/frontend/svg/' . ($notification->read_at ? 'icon-eye' : 'icon-eye-off') . '.svg') }}" alt="read svg">   
                        </a>

                        <div x-data="{ notific_dlt_modal: false }" :class="{ 'overflow-y-hidden': notific_dlt_modal }">
                            <main class="w-full flex flex-col sm:flex-row items-center">
                                <div class="flex flex-col">
                                    <div class="flex items-center justify-center">
                                        <button @click="notific_dlt_modal = true">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.02924 12.0576C5.55357 12.0576 5.16797 11.672 5.16797 11.1963L5.16797 8.61252C5.16797 8.13685 5.55357 7.75124 6.02924 7.75124C6.50491 7.75124 6.89052 8.13685 6.89052 8.61252L6.89052 11.1963C6.89052 11.672 6.50491 12.0576 6.02924 12.0576Z" fill="#898989"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.47456 12.0576C8.99889 12.0576 8.61328 11.672 8.61328 11.1963L8.61328 8.61252C8.61328 8.13685 8.99889 7.75124 9.47456 7.75124C9.95022 7.75124 10.3358 8.13685 10.3358 8.61252L10.3358 11.1963C10.3358 11.672 9.95023 12.0576 9.47456 12.0576Z" fill="#898989"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.883875 5.18226C0.67977 5.16833 0.413088 5.16786 0 5.16786V3.44531C0.00921245 3.44531 0.0183945 3.44531 0.0275462 3.44531C0.0460398 3.44531 0.0644092 3.44531 0.082654 3.44531H15.4203C15.4385 3.44531 15.4569 3.44531 15.4754 3.44531L15.5029 3.44531V5.16786C15.0899 5.16786 14.8232 5.16833 14.6191 5.18226C14.4227 5.19565 14.3479 5.21858 14.3121 5.23342C14.101 5.32084 13.9334 5.48851 13.846 5.69954C13.8311 5.73538 13.8082 5.81017 13.7948 6.00654C13.7809 6.21064 13.7804 6.47732 13.7804 6.89041L13.7804 12.1147C13.7804 12.8783 13.7805 13.5361 13.7097 14.0629C13.6337 14.6275 13.4626 15.1687 13.0236 15.6077C12.5847 16.0466 12.0435 16.2178 11.4789 16.2937C10.9521 16.3645 10.2942 16.3645 9.53072 16.3644H5.97222C5.20871 16.3645 4.55086 16.3645 4.02406 16.2937C3.45948 16.2178 2.91829 16.0466 2.47933 15.6077C2.04037 15.1687 1.8692 14.6275 1.7933 14.0629C1.72247 13.5361 1.7225 12.8783 1.72255 12.1148L1.72255 6.89041C1.72255 6.47732 1.72208 6.21064 1.70816 6.00654C1.69476 5.81017 1.67183 5.73538 1.65699 5.69954C1.56957 5.48851 1.40191 5.32084 1.19087 5.23342C1.15503 5.21858 1.08024 5.19565 0.883875 5.18226ZM12.2067 5.16786H3.29627C3.37705 5.40696 3.41026 5.64815 3.42671 5.88928C3.44512 6.15908 3.44511 6.48506 3.4451 6.86286L3.4451 12.0581C3.4451 12.8944 3.44693 13.4351 3.50048 13.8334C3.55071 14.207 3.6318 14.3241 3.69736 14.3896C3.76292 14.4552 3.88001 14.5363 4.25358 14.5865C4.65193 14.6401 5.19256 14.6419 6.02892 14.6419H9.47402C10.3104 14.6419 10.851 14.6401 11.2494 14.5865C11.6229 14.5363 11.74 14.4552 11.8056 14.3896C11.8711 14.3241 11.9522 14.207 12.0025 13.8334C12.056 13.4351 12.0578 12.8944 12.0578 12.0581V6.86286C12.0578 6.48506 12.0578 6.15908 12.0762 5.88928C12.0927 5.64815 12.1259 5.40696 12.2067 5.16786Z" fill="#898989"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.96309 0.104413C8.59794 0.0343653 8.17358 0 7.75221 0C7.33084 5.1336e-08 6.90648 0.0343654 6.54133 0.104413C6.35878 0.139431 6.18006 0.185421 6.01815 0.246001C5.87108 0.301027 5.6705 0.39238 5.5008 0.550715C5.153 0.875213 5.13412 1.42022 5.45862 1.76801C5.76482 2.0962 6.26738 2.13152 6.61529 1.8618C6.61728 1.86102 6.61944 1.8602 6.62178 1.85932C6.66773 1.84213 6.74756 1.81881 6.86585 1.79612C7.10237 1.75074 7.4152 1.72255 7.75221 1.72255C8.08922 1.72255 8.40205 1.75074 8.63857 1.79612C8.75686 1.81881 8.83669 1.84213 8.88264 1.85932C8.88498 1.8602 8.88714 1.86102 8.88913 1.8618C9.23704 2.13152 9.7396 2.0962 10.0458 1.76801C10.3703 1.42021 10.3514 0.875212 10.0036 0.550714C9.83392 0.392379 9.63334 0.301026 9.48627 0.246001C9.32436 0.185421 9.14564 0.13943 8.96309 0.104413Z" fill="#898989"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </main>
                            <!-- Modal1 -->
                            <div class="fixed inset-0 w-full h-full bg-black bg-opacity-50 z-50 pt-60 duration-300 overflow-y-auto" x-show="notific_dlt_modal" x-transition:enter="transition duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                <div class="relative sm:w-3/4 md:w-1/2 lg:w-1/2 xl:w-1/3 mx-2 sm:mx-auto my-10 opacity-100">
                                    <div class="relative bg-white shadow-lg p-4 rounded-md text-gray-900 z-50" @click.away="notific_dlt_modal = false" x-show="notific_dlt_modal" x-transition:enter="transition transform duration-300" x-transition:enter-start="scale-0" x-transition:enter-end="scale-100" x-transition:leave="transition transform duration-300" x-transition:leave-start="scale-100" x-transition:leave-end="scale-0" style="display: none;">
                                        <svg class="lg:block hidden  ltr:ml-auto rtl:mr-auto cursor-pointer hover:text-gray-12 text-gray-10" @click="notific_dlt_modal = false" xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.455612 0.455612C1.06309 -0.151871 2.04802 -0.151871 2.6555 0.455612L11.9888 9.78895C12.5963 10.3964 12.5963 11.3814 11.9888 11.9888C11.3814 12.5963 10.3964 12.5963 9.78895 11.9888L0.455612 2.6555C-0.151871 2.04802 -0.151871 1.06309 0.455612 0.455612Z" fill="currentColor"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9887 0.455612C11.3812 -0.151871 10.3963 -0.151871 9.78884 0.455612L0.455503 9.78895C-0.151979 10.3964 -0.151979 11.3814 0.455503 11.9888C1.06298 12.5963 2.04791 12.5963 2.65539 11.9888L11.9887 2.6555C12.5962 2.04802 12.5962 1.06309 11.9887 0.455612Z" fill="currentColor"></path>
                                        </svg>
                                        <div>
                                            <div class="flex">
                                                <div class="flex flex-col justify-center bg-red-100 ltr:ml-4 rtl:mr-4 items-center h-10 w-10 rounded-full dark:text-gray-2">
                                                    <svg class="lg:w-8 lg:h-8 w-26p h-26p" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                                                        <circle cx="16" cy="16" r="16" fill="#F9E8E8"></circle>
                                                        <path d="M17.7925 8L17.5367 18.9463H15.3411L15.0746 8H17.7925ZM15 22.3037C15 21.9129 15.1279 21.586 15.3837 21.3231C15.6466 21.0531 16.009 20.9181 16.4709 20.9181C16.9256 20.9181 17.2845 21.0531 17.5474 21.3231C17.8103 21.586 17.9417 21.9129 17.9417 22.3037C17.9417 22.6803 17.8103 23.0036 17.5474 23.2736C17.2845 23.5365 16.9256 23.668 16.4709 23.668C16.009 23.668 15.6466 23.5365 15.3837 23.2736C15.1279 23.0036 15 22.6803 15 22.3037Z" fill="#C8191C"></path>
                                                    </svg>
                                                </div>
                                                <div class="flex flex-col">
                                                    <span class="leading-4 dm-sans font-medium lg:text-lg text-gray-12 lg:mb-1.5 mb-1 text-sm mt-2.5 ltr:lg:pr-0 ltr:pr-3 ltr:ml-2 rtl:lg:pl-0 rtl:pl-3 rtl:mr-2">{{ __('Are you sure you want to delete this?') }}</span>
                                                    <p class="ltr:ml-2 ltr:lg:pr-0 ltr:pr-10 rtl:mr-2 rtl:lg:pl-0 rtl:pl-10 text-gray-10 roboto-medium font-medium lg:text-sm text-11 whitespace-pre-line">{{ __('Please keep in mind that once deleted, you can not undo it.') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex justify-end lg:mt-8 lg:mx-0 mx-2 mt-6 ltr:lg:mr-30p rtl:lg:ml-30p">
                                            <button class="dm-sans items-center transition duration-200 rounded px-3 lg:px-8 cursor-pointer font-medium lg:text-sm text-gray-12 lg:h-46p w-max h-10 bg-white border border-gray-2 text-xs hover:border-gray-12" @click="notific_dlt_modal = false">{{ __('Cancel') }}
                                            </button>
                                            <form action="{{ route('site.notifications.destroy', ['id' => $notification->id]) }}" method="post">
                                                @csrf
                                                @method('delete')                                                                
                                                <button type="submit" class="dm-sans ltr:ml-3 rtl:mr-3 transition duration-200 items-center cursor-pointer py-3.5 lg:px-6 font-medium lg:text-sm text-white lg:h-46p bg-gray-12 hover:bg-yellow-1 hover:text-gray-12 text-xs w-max px-3 h-10 rounded">{{ __('Yes, Delete') }}</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div>
                    <p class="text-center dm-sans font-medium text-xl text-gray-10">{{ __('You Have No Notification Yet') }}</p>
                </div>
            @endforelse
        </div>
        <div class="flex lg:justify-between justify-center">
            <div class="lg:block hidden">
                <a class="roboto-medium text-left font-medium text-base mt-30p text-gray-10">{{ __("Total Records: :x", ['x' => $notifications->total()]) }}</a>
            </div>
            {{ $notifications->onEachSide(1)->links('site.layouts.partials.pagination') }}
        </div>
    </div>
@endsection
@section('js')
 <script src="{{ asset('/public/dist/js/custom/validation.min.js') }}"></script>
 <script>
    const markReadUrl = SITE_URL + '/user/notifications/mark-as-read/'
    const markUnreadUrl = SITE_URL + '/user/notifications/mark-as-unread/'
</script>
<script src="{{ asset('public/dist/js/custom/notification.min.js') }}"></script>
@endsection
