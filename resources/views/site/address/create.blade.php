@extends('../site/layouts.user_panel.app')
@section('page_title', __('Create Address'))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/select2/css/select2.min.css') }}">
@endsection
@section('content')
    <div class="dark:bg-red-1 h-full xl:relative xl:px-74p px-5 pt-30p xl:pt-14">
        <div>
            <div class="flex items-center">
                <span class="ltr:mr-4 rtl:ml-4 lg:mt-0 mt-1">
                    <svg class="h-30p w-10 xl:w-53p xl:h-11 neg-transition-scale" xmlns="http://www.w3.org/2000/svg" width="53" height="44" viewBox="0 0 53 44" fill="none">
                        <rect x="36.1779" y="27.377" width="16.6222" height="16.6222" rx="2" fill="#FCCA19" />
                        <rect width="32.2667" height="32.2667" rx="2" fill="#FCCA19" />
                    </svg>
                </span>
                <h1 class="dm-sans font-medium lg:pt-0 text-2xl xl:text-4xl text-gray-12 mb-1 dark:text-gray-2">
                    {{ __('Address Book') }}
                </h1>
            </div>
            <p class="dark:text-gray-2 lg:mt-1.5 roboto-medium font-medium text-base xl:text-xl mt-2 text-20 text-gray-10 leading-6">
                {{ __('Your Location, the place you get all the goods received..') }}</p>
        </div>

        <div class="flex lg:mt-75p mt-10 dm-bold font-bold text-gray-12 text-base xl:text-2xl uppercase">
            <svg class="ltr:mr-3 rtl:ml-3 neg-transition-scale xl:w-5 xl:h-5 w-3.5 h-3.5 mt-1" xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21"
                fill="none">
                <path d="M13.8111 0.06563C13.6306 0.0984421 13.3298 0.176373 13.1451 0.246098C12.3974 0.520903 12.6423 0.30352 7.19391 5.4961C4.26774 8.28106 2.06773 10.4098 1.9732 10.541C1.88727 10.6641 1.77125 10.8691 1.71969 11.0004C1.66383 11.1275 1.4232 12.116 1.18688 13.1947C0.684141 15.4547 0.65836 15.6926 0.856016 16.2258C0.989219 16.5826 1.22125 16.9271 1.48336 17.1486C1.8443 17.4521 2.46734 17.6777 2.9357 17.6777C3.09899 17.6777 6.77711 17.001 7.40875 16.8533C7.52477 16.8246 7.7611 16.7385 7.93727 16.6605C8.25524 16.517 8.34977 16.4309 13.3384 11.673C18.6923 6.5625 18.658 6.59942 18.9287 5.97598C19.122 5.52071 19.1994 5.17207 19.2252 4.63477C19.2595 3.79395 19.0533 3.05977 18.5806 2.39122C18.2756 1.95235 16.9779 0.717777 16.617 0.520903C15.7834 0.06563 14.7693 -0.0984325 13.8111 0.06563ZM14.8381 2.13692C15.2806 2.21485 15.5213 2.37071 16.1959 3.02696C16.8705 3.68321 17.0037 3.88008 17.0896 4.33535C17.1455 4.65118 17.0638 5.08594 16.8877 5.36895C16.8189 5.48379 14.8638 7.39102 11.8861 10.2539L6.99625 14.9502L4.97242 15.2742C3.86383 15.4547 2.9443 15.59 2.9357 15.5818C2.92711 15.5736 3.09898 14.7 3.31813 13.6459L3.71344 11.7223L8.5861 7.0711C12.8529 2.99414 13.4888 2.40352 13.7166 2.29688C14.1162 2.10411 14.417 2.06309 14.8381 2.13692Z" fill="#2C2C2C" />
                <path d="M1.41481 19.0431C0.757386 19.2728 0.551136 20.1341 1.03239 20.6591C1.10114 20.7371 1.24293 20.8396 1.33746 20.8888L1.51364 20.9791L9.82809 20.9914C19.0836 20.9996 18.4261 21.0201 18.7742 20.7207C18.873 20.6386 18.9847 20.4951 19.0277 20.4049C19.1222 20.208 19.1351 19.8224 19.0492 19.6297C18.959 19.4205 18.7226 19.1908 18.4863 19.0883L18.2715 18.9898L9.91403 18.9939C3.59333 18.9939 1.52223 19.0062 1.41481 19.0431Z" fill="#2C2C2C" />
            </svg>
            <p>{{ __('New address') }}</p>
        </div>
        <div class="items-center 3xl:w-1/2 2xl:w-2/3 lg:w-full lg:mt-27p mt-5 address-form">
            <div>
                <form action="{{ route('site.addressStore') }}" method="post" id="addressForm" onsubmit="return formValidation()">
                    @csrf
                    <div class="grid grid-cols-2 lg:gap-3 gap-15p">
                        <div class="lg:mb-3 mb-3.5">
                            <label class="text-sm dm-sans font-medium capitalize text-gray-12 require-profile" for="first_name">
                                {{ __('First Name') }}</label>
                            <input class="border-gray-2 rounded-sm w-full mt-1.5 lg:mt-1p lg:h-46p h-10 roboto-medium font-medium text-sm text-gray-10 form-control border focus:border-gray-12  " type="text" id="first_name" name="first_name" type="text" value="{{ old('first_name') }}" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                        </div>
                        <div class="lg:mb-3 mb-3.5">
                            <label class="text-sm dm-sans font-medium capitalize text-gray-12" for="last_name">{{ __('Last Name') }}</label>
                            <input class="border-gray-2 rounded-sm w-full mt-1.5 lg:mt-1p lg:h-46p h-10 roboto-medium ltr:pl-18p rtl:pr-18p font-medium text-sm text-gray-10 form-control focus:border-gray-12" id="last_name" name="last_name" value="{{ old('last_name') }}" type="text">
                        </div>
                    </div>
                    <div class="lg:mb-3 mb-3.5">
                        <label class=" text-sm dm-sans font-medium capitalize text-gray-12" for="company_name">{{ __('Company Name') . ' ( ' . __('Optional') . ' )' }} </label>
                        <input class="border-gray-2 rounded-sm w-full mt-1.5 lg:mt-1p lg:h-46p h-10 roboto-medium ltr:pl-18p rtl:pr-18p font-medium text-sm text-gray-10 form-control focus:border-gray-12"type="text" name="company_name" id="compnay_name" value="{{ old('company_name') }}">
                    </div>
                    <div class="grid lg:grid-cols-2 grid-cols-1 lg:gap-3">
                        <div class="order-2 lg:order-none lg:mb-3 mb-3.5">
                            <label class="text-sm dm-sans font-medium capitalize text-gray-12 require-profile" for="phone">{{ __('Phone Number') }}
                            </label>
                            <input class="border-gray-2 mt-1.5 lg:mt-1p rounded-sm w-full lg:h-46p h-10 roboto-medium ltr:pl-18p rtl:pr-18p font-medium text-sm text-gray-10 form-control border focus:border-gray-12" type="text" id="phone" name="phone" value="{{ old('phone') }}" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                        </div>
                        <div class="order-first lg:order-none lg:mb-3 mb-3.5">
                            <label class="text-sm dm-sans font-medium capitalize text-gray-12"for="email">{{ __('Email Address') }}</label>
                            <input class="border-gray-2 mt-1.5 lg:mt-1p rounded-sm w-full lg:h-46p h-10 ltr:pl-18p rtl:pr-18p roboto-medium font-medium text-sm text-gray-10 form-control focus:border-gray-12" type="email" name="email" id="email"
                                data-type-mismatch="{{ __('Enter a valid :x.', ['x' => strtolower(__('Email'))]) }}">
                        </div>
                    </div>
                    <div class="lg:mb-3 mb-3.5">
                        <label class="lg:block hidden mt-3p text-sm dm-sans font-medium capitalize text-gray-12 require-profile"
                            for="address_1">{{ __('Street Address 1') }} </label>
                        <label class="lg:hidden block text-sm dm-sans font-medium capitalize text-gray-12 require-profile" for="address_1">{{ __('Street Address') }} </label>
                        <input id="address_1" name="address_1" type="text" value="{{ old('address_1') }}" class="border-gray-2 rounded-sm w-full mt-2 lg:mt-3p lg:h-46p h-10 roboto-medium ltr:pl-18p rtl:pr-18p font-medium text-sm text-gray-10 form-control focus:border-gray-12" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                    </div>
                    <div class="lg:block hidden lg:mb-3 mb-3.5">
                        <label class="text-sm dm-sans font-medium capitalize text-gray-12" for="address_2">{{ __('Street Address 2') }}</label>
                        <input id="address_2" name="address_2" type="text" value="{{ old('address_2') }}" class="border-gray-2 rounded-sm w-full mt-1.5 lg:mt-1p lg:h-46p h-10 roboto-medium ltr:pl-18p rtl:pr-18p font-medium text-sm text-gray-10 form-control focus:border-gray-12">
                    </div>
                    <div class="grid grid-cols-2 lg:gap-3 gap-15p mb-3.5">
                        <div class="w-full validSelect">
                            <label class="text-sm dm-sans font-medium capitalize text-gray-12 require-profile block" for="country"> {{ __('Country') }} </label>
                            <select name="country" id="country" class="border-gray-2 mt-1.5 lg:mt-1p rounded-sm w-full lg:h-46p h-10 roboto-medium ltr:pl-18p rtl:pr-18p font-medium text-sm text-gray-10 form-control border focus:border-gray-12 block required-field addressSelect" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"><option value="">{{ __('Select Country') }}</option>
                            </select>
                        </div>
                        <div class="w-full validSelect">
                            <label class="text-sm dm-sans font-medium capitalize text-gray-12 require-profile block" for="state">{{ __('State') . ' / ' . __('Province') }} </label>
                            <select name="state" id="state" class="border-gray-2 mt-1.5 lg:mt-1p rounded-sm w-full lg:h-46p h-10 roboto-medium ltr:pl-18p rtl:pr-18p font-medium text-sm text-gray-10 form-control border focus:border-gray-12 block required-field addressSelect" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"> <option value="">{{ __('Select State') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 lg:gap-3 gap-15p mb-3.5">
                        <div class="lg:mb-3 mb-3.5 validSelect">
                            <label class="text-sm dm-sans font-medium capitalize mb-2.5 lg:mb-1 text-gray-12 require-profile block" for="city">{{ __('City') }}</label>
                            <select name="city" id="city" class="border-gray-2 rounded-sm w-full lg:h-46p mt-1.5 lg:mt-1p h-10 roboto-medium ltr:pl-18p rtl:pr-18p font-medium text-sm text-gray-10 form-control border focus:border-gray-12 block required-field addressSelect" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"><option value="">{{ __('Select City') }}</option>
                            </select>
                        </div>
                        <div class="lg:mb-3 mb-3.5">
                            <label class="lg:block hidden mt-3p text-sm dm-sans font-medium capitalize text-gray-12" for="zip"> {{ __('Postcode') . ' / ' . __('ZIP') }} </label>
                            <label class="lg:hidden block mt-2p text-sm dm-sans font-medium capitalize text-gray-12" for="zip"> {{ __('Postcode') }} </label>
                            <input id="zip" maxlength="10" name="zip" type="text" value="{{ old('zip') }}" class="border-gray-2 rounded-sm w-full h-46p mt-2 lg:mt-1p roboto-medium ltr:pl-18p rtl:pr-18p font-medium text-sm text-gray-10 form-control border focus:border-gray-12">
                        </div>
                    </div>
                    <div class="lg:mt-15p mt-18p">
                        <p class="lg:block hidden text-sm dm-sans font-medium capitalize text-gray-12">{{ __('Select the type of your place') }} *</p>
                        <p class="lg:hidden block text-sm dm-sans font-medium capitalize text-gray-12">{{ __('type of place') }} *</p>
                        <div class="flex mt-3p">
                            <div class="radio-buttons radio-btn-func">
                                <label class="custom-radio">
                                    <input type="radio" id="optionsRadios1" class="display-none radio-test" name="type_of_place" value="home" />
                                    <span class="radio-btn lg:w-141p lg:h-53p border border-gray-2 rounded dm-sans cursor-pointer relative inline-block font-medium text-center lg:text-sm text-xs ltr:pl-18p rtl:pr-18p text-gray-10">
                                        <svg class="ltr:mr-13p rtl:ml-13p absolute opacity-0 lg:my-22p mt-15p" xmlns="http://www.w3.org/2000/svg" width="11" height="9" viewBox="0 0 11 9" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11 1.41885L4.38163 9L8.22563e-07 4.81748L1.64177 3.25031L4.22561 5.71673L9.21633 -4.01642e-07L11 1.41885Z" fill="currentColor" />
                                        </svg>
                                        <div class="ltr:lg:ml-18p ltr:ml-2 rtl:lg:mr-18p rtl:mr-2">
                                            <div class="flex items-center"><svg class=" my-18p lg:block hidden" xmlns="http://www.w3.org/2000/svg" width="16" height="18" viewBox="0 0 16 18" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"d="M6.57318 1.76695C5.97512 2.15794 5.27179 2.75321 4.27687 3.59733L3.22194 4.49239C2.09056 5.4523 1.68078 5.81759 1.46221 6.28799C1.24439 6.75675 1.23083 7.29905 1.23083 8.77444V13.2024C1.23083 14.2048 1.23218 14.8929 1.30238 15.4097C1.36998 15.9075 1.49089 16.1528 1.66444 16.3246C1.83961 16.498 2.09219 16.6198 2.60059 16.6875C3.12551 16.7573 3.82351 16.7586 4.83519 16.7586H11.1648C12.1765 16.7586 12.8745 16.7573 13.3994 16.6875C13.9078 16.6198 14.1604 16.498 14.3356 16.3246C14.5091 16.1528 14.63 15.9075 14.6976 15.4097C14.7678 14.8929 14.7692 14.2048 14.7692 13.2024V8.77444C14.7692 7.29905 14.7556 6.75675 14.5378 6.28799C14.3192 5.81759 13.9094 5.4523 12.7781 4.49239L11.7231 3.59733C10.7282 2.75321 10.0249 2.15794 9.42682 1.76695C8.84342 1.38555 8.42216 1.24138 8 1.24138C7.57784 1.24138 7.15658 1.38555 6.57318 1.76695ZM5.90376 0.725255C6.59589 0.27277 7.25143 0 8 0C8.74858 0 9.40411 0.27277 10.0962 0.725255C10.7663 1.1633 11.5277 1.80936 12.4835 2.62032L13.5703 3.54241C13.6072 3.57366 13.6435 3.60449 13.6794 3.63494C14.6614 4.4675 15.3044 5.01269 15.6522 5.76119C16.0007 6.51119 16.0004 7.3524 16 8.63193C16 8.67884 15.9999 8.72633 15.9999 8.77444V13.2476C16 14.1936 16 14.9673 15.917 15.5782C15.8301 16.2179 15.642 16.7707 15.1976 17.2106C14.7548 17.6489 14.2011 17.8329 13.5604 17.9182C12.9455 18 12.1659 18 11.2083 18H4.79168C3.83408 18 3.05447 18 2.43959 17.9182C1.79889 17.8329 1.24518 17.6489 0.802382 17.2106C0.357973 16.7707 0.169894 16.2179 0.0830068 15.5782C2.77297e-05 14.9673 4.46799e-05 14.1936 6.54405e-05 13.2476L6.61741e-05 8.77444C6.61741e-05 8.72633 4.92282e-05 8.67883 3.25023e-05 8.63192C-0.000424671 7.3524 -0.0007253 6.51119 0.347765 5.76119C0.695552 5.01269 1.33858 4.46751 2.32056 3.63494C2.35647 3.60449 2.39284 3.57366 2.42967 3.54241L3.51646 2.62033C4.47226 1.80937 5.23373 1.1633 5.90376 0.725255Z" fill="currentColor" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5 11.3333C5 10.597 5.53726 10 6.2 10H9.8C10.4627 10 11 10.597 11 11.3333V17.3333C11 17.7015 10.7314 18 10.4 18C10.0686 18 9.8 17.7015 9.8 17.3333V11.3333H6.2V17.3333C6.2 17.7015 5.93137 18 5.6 18C5.26863 18 5 17.7015 5 17.3333V11.3333Z" fill="currentColor" />
                                                </svg><span class="ltr:ml-2 ltr:lg:mr-0 ltr:mr-9 rtl:mr-2 rtl:lg:ml-0 rtl:ml-9 my-3">{{ __('Home') }}</span>
                                            </div>
                                        </div>
                                    </span>
                                </label>
                                <label class="custom-radio ltr:ml-2 rtl:mr-2">
                                    <input type="radio" class="display-none radio-test" id="optionsRadios2" name="type_of_place" value="office"/>
                                    <span class="radio-btn lg:w-141p lg:h-53p border border-gray-2 rounded dm-sans cursor-pointer relative inline-block font-medium text-center lg:text-sm text-xs ltr:pl-18p rtl:pr-18p text-gray-10">
                                        <svg class="ltr:mr-13p rtl:ml-13p absolute opacity-0 lg:my-22p mt-15p" xmlns="http://www.w3.org/2000/svg" width="11" height="9" viewBox="0 0 11 9" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11 1.41885L4.38163 9L8.22563e-07 4.81748L1.64177 3.25031L4.22561 5.71673L9.21633 -4.01642e-07L11 1.41885Z" fill="currentColor" />
                                        </svg>
                                        <div class="ltr:lg:ml-18p ltr:ml-2 rtl:lg:mr-18p rtl:mr-2">
                                            <div class="flex items-center">
                                                <svg class="my-18p lg:block hidden" xmlns="http://www.w3.org/2000/svg"
                                                    width="20" height="18" viewBox="0 0 20 18" fill="none">
                                                    <path d="M7.66406 0.0578384C7.14453 0.189384 6.56641 0.603956 6.26562 1.06636C6.18359 1.19392 6.0625 1.44107 6 1.61647C5.89062 1.92341 5.88672 1.97124 5.86719 2.76052L5.85156 3.58967H3.14844C0.136719 3.58967 0.277344 3.57771 0.0898438 3.86472L0 4.00025L0.0078125 9.84411L0.0195312 15.688L0.125 15.9989C0.417969 16.8838 1.09375 17.5735 1.97266 17.8884L2.28516 18H10H17.7148L18.0273 17.8884C18.9062 17.5735 19.582 16.8838 19.875 15.9989L19.9805 15.688L19.9922 9.84411L20 4.00025L19.9102 3.86472C19.7227 3.57771 19.8633 3.58967 16.8516 3.58967H14.1484L14.1328 2.78045C14.1172 2.043 14.1055 1.94732 14.0117 1.65633C13.7578 0.879007 13.0938 0.245192 12.3398 0.0618248C12.0039 -0.0179005 7.99219 -0.0218868 7.66406 0.0578384ZM12.2617 1.36135C12.4297 1.44506 12.5547 1.5487 12.6562 1.68423C12.8867 1.97922 12.9297 2.17853 12.9297 2.93991V3.58967H9.99609H7.0625L7.07812 2.86018C7.08984 2.22238 7.10156 2.11076 7.17188 1.95131C7.29297 1.68423 7.47656 1.49688 7.74219 1.35736L7.98047 1.23777H10H12.0195L12.2617 1.36135ZM18.7344 5.02472C18.6562 5.63462 18.2539 6.59132 17.8086 7.23709C17.4727 7.71545 16.7539 8.4529 16.2422 8.83559C15.3086 9.53717 14.2031 10.0634 12.9648 10.4022L12.5469 10.5178L12.5352 9.88796C12.5195 9.19036 12.5 9.13057 12.2266 8.93923L12.0977 8.85153H10H7.90234L7.77344 8.93923C7.5 9.13057 7.48047 9.19036 7.46484 9.88796L7.45312 10.5178L7.09375 10.4221C4.86328 9.81621 3.04688 8.59242 2.05078 7.02582C1.67188 6.42788 1.33594 5.57084 1.26562 5.02472L1.23828 4.82541H10H18.7617L18.7344 5.02472ZM1.37109 8.20177C1.59766 8.5127 2.25781 9.20232 2.62109 9.51325C3.34375 10.1311 4.46875 10.7968 5.44531 11.1835C5.91406 11.3708 6.59766 11.5821 7.12891 11.7057C7.30078 11.7416 7.45703 11.7894 7.47266 11.8014C7.49219 11.8173 7.53125 11.9369 7.5625 12.0645C7.67578 12.5109 7.88281 12.8697 8.22266 13.2165C8.73828 13.7427 9.27734 13.9699 10 13.9699C10.7109 13.9699 11.2617 13.7427 11.7617 13.2364C12.0938 12.9016 12.2578 12.6305 12.3828 12.2199C12.5234 11.7615 12.5039 11.7854 12.7773 11.7296C12.9141 11.6977 13.2461 11.614 13.5117 11.5383C14.9414 11.1277 16.3359 10.3982 17.3711 9.51724C17.7773 9.17043 18.3867 8.52864 18.6328 8.19778L18.8086 7.95861L18.8203 8.3971C18.8281 8.63627 18.8281 10.3025 18.8203 12.1003L18.8086 15.3691L18.7188 15.6082C18.5273 16.1344 18.1328 16.5331 17.6484 16.7005L17.4062 16.7842H10.0156C2.72266 16.7842 2.62109 16.7842 2.37109 16.7045C1.88281 16.549 1.47656 16.1424 1.28125 15.6082L1.19141 15.3691L1.17969 11.6698C1.17188 9.63682 1.17578 7.97455 1.18359 7.97455C1.19531 7.97455 1.27734 8.0782 1.37109 8.20177ZM11.3203 10.8726C11.2969 11.8014 11.25 11.9847 10.9453 12.3156C10.4219 12.8856 9.57812 12.8856 9.05469 12.3156C8.75 11.9847 8.70312 11.8014 8.67969 10.8726L8.66406 10.0873H10H11.3359L11.3203 10.8726Z" fill="currentColor" />
                                                </svg><span class="ltr:ml-2 ltr:lg:mr-0 ltr:mr-9 rtl:mr-2 rtl:lg:ml-0 rtl:ml-9 lg:my-0 my-3">{{ __('Office') }}</span>
                                            </div>
                                        </div>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <br>
                        <p id="radio-error-msg" class="hidden font-normal text-11 text-reds-5 -mt-5 radio-error-msg">{{ __('This field is required.') }}</p>
                    </div>
                    @if ($addresses->count() > 0)
                        <div class="form-check mt-0">
                            <input type="hidden" name="is_default" value="0">
                            <input name="is_default" value="1" class="h-4 w-4 border border-gray-2 rounded-sm bg-white text-gray-12 transition duration-200 lg:mt-1 mt-1.5 align-top ltr:mr-2 rtl:ml-2 neg-transition-scale cursor-pointer"type="checkbox"
                                id="flexCheckDefault">
                            <label class="form-check-label inline-block text-gray-10 lg:text-sm text-xs dm-sans font-medium" for="flexCheckDefault">{{ __('Use this as default address in the future') }}
                            </label>
                        </div>
                    @endif
                    <div class="flex gap-3 lg:mt-5 mt-6">
                        <button class="lg:order-none order-last dm-sans text-center transition duration-200 rounded py-3.5 cursor-pointer font-medium text-sm text-gray-12 w-141p h-46p bg-white border border-gray-2 mb-7p hover:border-gray-12"><a href="{{ route('site.address') }}">{{ __('Cancel') }}</a>
                        </button>
                        <button type="submit" id="btnSubmit" class="dm-sans transition duration-200 items-center cursor-pointer py-3 px-6 font-medium text-sm whitespace-nowrap text-white bg-gray-12 save-add-func hover:bg-yellow-1 hover:text-gray-12 mb-7p rounded">{{ __('Save Address') }}</button>
                    </div>
                </form>
            </div>
        </div>
        {{-- end form --}}
    </div>
@endsection

@section('js')
    <script>
        'use strict';
        let oldCountry = "{!! old('country') ?? 'null' !!}";
        let oldState = "{!! old('state') ?? 'null' !!}";
        let oldCity = "{!! old('city') ?? 'null' !!}";
    </script>
    <script src="{{ asset('/public/dist/js/custom/validation.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('/public/dist/js/custom/site/address.min.js') }}"></script>
@endsection
