<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('public/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/tailwind-custom.min.css') }} ">
</head>
<body>
    <div class="ml-10 mr-5 xxs:mx-auto lg:mx-4 xl:mx-32 2xl:mx-50 3xl:mx-354p">
        <div class="md:flex justify-center">
            <div class="flex mt-174 mt-30p">
                <div class="items-end">
                    <div>
                        <p class="lg:mt-60p mt-0 text-right dm-sans font-medium text-66 lg:text-108 lg:leading-140p leading-none errors text-yellow-1">@yield('code')</p>
                        <div class="uppercase dm-sans font-medium lg:text-32 text-sm text-center rounded float-right lg:-mt-4 lg:leading-42p text-white bg-gray-12 lg:py-1 py-1p lg:px-23p px-4"><span class="text-center">@yield('name')</span>
                        </div>

                    </div>
                </div>
                <div class="flex">
                    <div class="lg:ml-23p ml-21p mt-2.5 lg:mt-18p">
                        <div class="flex flex-col">
                            <div class="border-l ml-7p border-dashed h-130p border-gray-27 lg:border-l-0">

                            </div>
                        </div>
                       <div class="flex">
                      <span class="relative ml-2p md:ml-0">
                        <svg class="w-11p h-11p md:w-15p md:h-15p" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none"><circle cx="7.5" cy="7.5" r="7.5" fill="#FCCA19" />
                        </svg>
                      </span>
                        <div class="md:w-300p border-l md:-ml-2 -ml-1.5 border-dashed border-gray-27">
                            <p class="text-gray-12 dm-sans md:mb-28 mb-10 md:-mt-1.5 -mt-1 md:pl-23p pl-21p font-medium lg:text-xl lg:w-full leading-30px leading-21px leading-17px xs:text-sm text-xs">@yield('message')</p>
                        </div>
                       </div>
                       <div class="flex md:-ml-137p -ml-120p">
                        <div class="text-left">
                            <a href="{{ Url('/') }}" class="flex -mt-1.5 md:mr-23p mr-5 relative arrow-hover font-medium dm-sans text-gray-10 lg:text-base pl-3 text-sm">
                                <svg class="lg:mt-7p mt-5p mr-2 absolute" width="15" height="10"viewBox="0 0 15 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.70711 0L6.12132 1.41421L3.82843 3.70711H13.4142C13.9665 3.70711 14.4142 4.15482 14.4142 4.70711C14.4142 5.25939 13.9665 5.70711 13.4142 5.70711H3.82843L6.12132 8L4.70711 9.41421L0 4.70711L4.70711 0Z" fill="currentColor" />
                                </svg>
                                <span class="ml-4">{{ __('Back Home') }}</span>
                            </a>
                        </div>
                        <svg class="w-11p h-11p ml-0 md:ml-1p md:w-15p md:h-15p" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none"><circle cx="7.5" cy="7.5" r="7.5" fill="#2C2C2C" />
                        </svg>
                       </div>
                       <div class="flex flex-col">
                        <div class="border-l ml-7p -mt-3p border-dashed h-77p border-gray-27">
                        </div>
                       <div class="flex">
                        <svg class="w-11p h-11p md:w-15p md:h-15p -mt-3p relative ml-2p md:ml-0" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15"fill="none"><circle cx="7.5" cy="7.5" r="7.5" fill="#DFDFDF" />
                        </svg>
                        <p class="text-gray-2 dm-sans ml-18p -mt-2 font-medium lg:text-xl text-sm">{{ __('Dead end') }}</p>
                       </div>
                       </div>
                    </div>
                </div>
            </div>
            <div>
                <img class="lg:ml-53p mx-auto w-296p h-270p md:w-430p md:h-354p 3xl:w-556p 3xl:h-505p lg:mt-225p md:mt-120p mt-10" src="{{ asset('public/frontend/assets/img/error/error-page-image-one.svg') }}">
            </div>
        </div>
    </div>

</body>
</html>
