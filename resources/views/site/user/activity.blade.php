@extends('../site/layouts.user_panel.app')
@section('page_title', __('Activity'))

@section('content')
    <div class="dark:bg-red-1 settings-page h-full xl:pl-74p px-5 pt-30p lg:pt-14 bg-white">
        <div>
            <div class="flex items-center">
                <span class="ltr:mr-4 rtl:ml-4 lg:mt-0 mt-1">
                    <svg class="h-30p w-10 xl:w-53p xl:h-11 neg-transition-scale" xmlns="http://www.w3.org/2000/svg" width="53" height="44"
                        viewBox="0 0 53 44" fill="none">
                        <rect x="36.1779" y="27.377" width="16.6222" height="16.6222" rx="2" fill="#FCCA19" />
                        <rect width="32.2667" height="32.2667" rx="2" fill="#FCCA19" />
                    </svg>
                </span>
                <h1 class="dm-sans font-medium lg:pt-0 text-2xl xl:text-4xl text-gray-12 mb-1 dark:text-gray-2">{{ __('Activity') }}</h1>
            </div>
            <p class="dark:text-gray-2 lg:mt-1.5 roboto-medium font-medium text-base xl:text-xl mt-4 text-20 text-gray-10 leading-6">{{ __('Please check your login activities below.') }}</p>
        </div>

        @if(!count($userActivities) == 0)
            <div class="lg:py-23p py-0 mt-10 lg:mt-20">
                <div class="overflow-x-auto rounded-sm">
                    <table class="w-full whitespace-nowrap bg-white dark:bg-gray-2 overflow-hidden">
                        <thead>
                            <tr class="ltr:text-left rtl:text-right bg-gray-11 border border-gray-2 dark:bg-gray-2">
                                <th class="ltr:pl-10 rtl:pr-10 py-4 dm-sans font-medium text-gray-12 xl:text-xl text-base dark:text-gray-2">{{ __('Browser') }}</th>
                                <th class="py-4 ltr:pl-4 rtl:pr-4 dm-sans font-medium capitalize text-gray-12 xl:text-xl text-base dark:text-gray-2">{{ __('Platform') }} </th>
                                <th class="py-4 ltr:pl-4 rtl:pr-4 dm-sans font-medium capitalize text-gray-12 xl:text-xl text-base dark:text-gray-2">{{ __('IP') }}</th>
                                <th class="py-4 ltr:pl-4 rtl:pr-4 dm-sans font-medium capitalize text-gray-12 xl:text-xl text-base dark:text-gray-2">{{ __('Time') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $properties = [];
                            @endphp

                            @foreach ($userActivities as $activity)
                                @php
                                    $properties = json_decode($activity->properties, true)
                                @endphp

                                <tr class="focus-within:bg-gray-200 overflow-hidden border border-gray-2">
                                    <td class="ltr:pl-10 rtl:pr-10 dark:border-t-gray-2 dark:bg-gray-3">
                                        <span class="roboto-medium font-medium text-gray-10 text-sm xl:text-base dark:text-gray-2 py-4 flex items-center">{{ $properties['browser'] }}
                                        </span>
                                    </td>
                                    <td class="dark:border-t-gray-2 dark:bg-gray-3">
                                        <span class="roboto-medium font-medium text-gray-10 text-sm xl:text-base dark:text-gray-2 px-4 py-4 flex items-center"> {{ $properties['platform'] }}
                                        </span>
                                    </td>
                                    <td class="dark:border-t-gray-2 dark:bg-gray-3">
                                        <span class="roboto-medium font-medium text-gray-10 text-sm xl:text-base dark:text-gray-2 px-4 py-4 flex items-center">{{ $properties['ip_address'] }}
                                        </span>
                                    </td>
                                    <td class="dark:border-t-gray-2 dark:bg-gray-3">
                                        <span class="roboto-medium font-medium text-gray-10 text-sm xl:text-base dark:text-gray-2 px-4 py-4 flex items-center">{{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $userActivities->links('pagination::tailwind') !!}
                </div>
            </div>
        @else
            <div class="flex flex-col justify-center items-center lg:mt-40 mt-90p">
                <svg enable-background="new 0 0 512 512" version="1.1" width="40" height="40" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                    <path d="m452 0h-392c-33.084 0-60 26.916-60 60v80h40v-80c0-11.028 8.972-20 20-20h392c11.028 0 20 8.972 20 20v392c0 11.028-8.972 20-20 20h-392c-11.028 0-20-8.972-20-20v-80h-40v80c0 33.084 26.916 60 60 60h392c33.084 0 60-26.916 60-60v-392c0-33.084-26.916-60-60-60z"/>
                    <polygon points="240 131.72 211.72 160 287.72 236 0 236 0 276 287.72 276 211.72 352 240 380.28 364.28 256"/>
                </svg>
                <h1 class="text-center dm-sans font-medium lg:text-28 text-lg text-gray-14 mt-4">
                    <span>{{ __("No activites found.") }}</span>
                </h1>
            </div>
        @endif
    </div>
@endsection
