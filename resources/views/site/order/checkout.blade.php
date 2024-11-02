@extends('../site/layouts.app')
@section('page_title', __('Check Out'))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/select2/css/select2.min.css') }}">
@endsection
@section('content')
    <section class="mx-4 lg:mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92 mt-70p mb-20">
        @include('site.layouts.includes.order_steps', ['stepsNumber' => 2])
    </section>

    <section class="text-gray-600 body-font relative mx-4 lg:mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92 mt-80p checkout-address-form"
        id="order-checkout-container">
        <form action="{{ route('site.orderStore') }}" method="POST" id="addressForm">
            @csrf
            <div class="flex md:flex-nowrap flex-wrap pt-8">
                <div class="md:w-2/3 overflow-hidden flex justify-start relative mb-10 rtl-direction-space-left-cart">
                    <div class="flex flex-wrap w-full ltr:lg:pr-7 rtl:lg:pl-7">
                        <div class="w-full mb-4">
                            <span
                                class="dm-bold font-bold text-gray-12 text-22">{{ __(':x Information', ['x' => __('Shipping')]) }}</span>
                        </div>
                        <div id="tabs" class="p_tabs w-full mt-4 address-tab">
                            <div class="w-full">
                                <div class="c-tabs-nav a-tab w-full grid-cols-2">
                                    @php
                                        $defaultAddress = null;
                                    @endphp
                                    @if (count($addresses) > 0)
                                        <a href="javascript:void(0)"
                                            class="c-tabs-nav__link {{ count($addresses) > 0 ? 'is-active' : '' }} whitespace-nowrap selected-tab"
                                            data-tab="old"> {{ __('Your Addresses') }}</a>
                                    @endif
                                    <a href="javascript:void(0)"
                                        class="c-tabs-nav__link {{ count($addresses) == 0 ? 'is-active' : '' }} whitespace-nowrap selected-tab"
                                        data-tab="new">{{ Auth::check() ? __('New Address') : __('Guest Address') }}</a>
                                    <div class="c-tab-nav-marker"></div>
                                </div>
                            </div>
                            <input type="hidden" name="selected_tab" id="selected_tab">
                            @if (count($addresses) > 0)
                                <input type="hidden" name="address_id" id="address_id"
                                    value="{{ !empty($defaultAddresses) ? $defaultAddresses->id : '' }}">
                                <div class="c-tab is-active mt-3">
                                    @php $addressCount = 0 @endphp
                                    @foreach ($addresses as $key => $address)
                                        <div class="border {{ $address->is_default == 1 ? 'border-gray-12' : 'border-gray-2' }} rounded p-4 mt-7 adress-container"
                                            id="new-address-border{{ $address->id }}">
                                            <div>
                                                <div class="flex justify-between items-center border-b border-gray-2 pb-4">
                                                    <div class="radio-container-payment">
                                                        <input class="address-radio" type="radio"
                                                            id="new-address{{ $address->id }}" name="new_address"
                                                            {{ $address->is_default == 1 ? 'checked' : '' }}
                                                            data-addressId="{{ $address->id }}" />
                                                        <label class="ab-label dm-sans font-medium text-gray-10 text-base"
                                                            for="new-address{{ $address->id }}">{{ __('Address') . '-' . $key }}
                                                            ({{ ucfirst($address->type_of_place) }})</label>
                                                    </div>
                                                    <div class="{{ $address->is_default == 0 ? 'hidden' : '' }} s-icon">
                                                        <span>
                                                            <svg class="mt-1.5" xmlns="http://www.w3.org/2000/svg"
                                                                width="13" height="11" viewBox="0 0 13 11"
                                                                fill="none">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M13 1.73415L5.17829 11L2.48885e-06 5.88803L1.94028 3.9726L4.9939 6.98711L10.892 -4.74667e-07L13 1.73415Z"
                                                                    fill="#2C2C2C" />
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="mt-4">
                                                    <h3
                                                        class="mb-4 ab-name dm-sans text-gray-12 text-sm font-bold uppercase">
                                                        {{ $address->first_name }} {{ $address->last_name }}</h3>
                                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-1 md:gap-24">
                                                        <div class="flex flex-col break-all">
                                                            <div class="flex items-start mb-1">
                                                                <span
                                                                    class="ltr:mr-2.5 rtl:ml-2.5">
                                                                    <svg class="mt-1" xmlns="http://www.w3.org/2000/svg"
                                                                        width="12" height="10" viewBox="0 0 12 10"
                                                                        fill="none">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M0.585786 0.627628C0 1.25526 0 2.26541 0 4.28571V5.71429C0 7.73459 0 8.74474 0.585786 9.37237C1.17157 10 2.11438 10 4 10H8C9.88562 10 10.8284 10 11.4142 9.37237C12 8.74474 12 7.73459 12 5.71429V4.28571C12 2.26541 12 1.25526 11.4142 0.627628C10.8284 0 9.88562 0 8 0H4C2.11438 0 1.17157 0 0.585786 0.627628ZM2.3698 2.26282C2.06345 2.044 1.64953 2.13269 1.4453 2.46093C1.24106 2.78916 1.32385 3.23264 1.6302 3.45146L5.2604 6.04446C5.70827 6.36437 6.29174 6.36437 6.7396 6.04446L10.3698 3.45146C10.6762 3.23264 10.7589 2.78916 10.5547 2.46093C10.3505 2.13269 9.93655 2.044 9.6302 2.26282L6 4.85582L2.3698 2.26282Z"
                                                                            fill="#898989" />
                                                                    </svg>
                                                                </span>
                                                                <p class="roboto-medium font-medium text-gray-10 text-sm">
                                                                    {{ $address->email }}</p>
                                                            </div>
                                                            <div class="flex items-start">
                                                                <span
                                                                    class="mt-1 ltr:mr-2 rtl:ml-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                                        height="13" viewBox="0 0 12 13" fill="none">
                                                                        <path
                                                                            d="M1.26558 0.70694L1.70722 0.228499C1.98844 -0.0761661 2.44441 -0.0761666 2.72564 0.228499L4.58775 2.24579C4.86898 2.55045 4.86898 3.04441 4.58775 3.34908L3.29697 4.74742C3.08174 4.98059 3.02838 5.3368 3.1645 5.63175C3.95143 7.33676 5.22761 8.71928 6.80147 9.57179C7.07372 9.71926 7.40254 9.66145 7.61777 9.42828L8.90855 8.02994C9.18978 7.72528 9.64574 7.72528 9.92697 8.02994L11.7891 10.0472C12.0703 10.3519 12.0703 10.8459 11.7891 11.1505L11.3474 11.629C9.82699 13.2761 7.41989 13.4614 5.6997 12.0638L4.82948 11.3567C3.57391 10.3366 2.45855 9.12827 1.51687 7.76806L0.864206 6.82533C-0.425942 4.96178 -0.254877 2.3541 1.26558 0.70694Z"
                                                                            fill="#898989" />
                                                                    </svg>
                                                                </span>
                                                                <p class="roboto-medium font-medium text-gray-10 text-sm">
                                                                    {{ $address->phone }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-span-2 break-all">
                                                            <div class="flex">
                                                                <span
                                                                    class="ltr:mr-2.5 rtl:ml-2.5">
                                                                    <svg class="mt-1" xmlns="http://www.w3.org/2000/svg"
                                                                        width="11" height="13" viewBox="0 0 11 13"
                                                                        fill="none">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M5.81274 12.9196C6.9779 12.2908 11 9.82323 11 5.72243C11 2.56202 8.53757 0 5.5 0C2.46243 0 0 2.56202 0 5.72243C0 9.82323 4.0221 12.2908 5.18726 12.9196C5.38593 13.0268 5.61407 13.0268 5.81274 12.9196ZM5.5 8.1749C6.80181 8.1749 7.85714 7.07689 7.85714 5.72243C7.85714 4.36797 6.80181 3.26996 5.5 3.26996C4.19819 3.26996 3.14286 4.36797 3.14286 5.72243C3.14286 7.07689 4.19819 8.1749 5.5 8.1749Z"
                                                                            fill="#898989" />
                                                                    </svg>
                                                                </span>
                                                                <span
                                                                    class="mt-0.5 roboto-medium font-medium text-sm text-gray-10">
                                                                    <p>{{ $address->first_name }}
                                                                        {{ $address->last_name }}</p>
                                                                    <p>{{ $address->email }}</p>
                                                                    <p>{{ $address->phone }}</p>
                                                                    <p>{{ $address->address_1 }}</p>
                                                                    <p>{{ $address->address_2 }}</p>
                                                                    <p> {{ $address->city }}-{{ $address->zip }},
                                                                        {{ optional($address->geoLocalState)->name }},
                                                                        {{ optional($address->geoLocalCountry)->name }}</p>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @php
                                            if ($address->is_default == 1) {
                                                $defaultAddress = $address->id;
                                            }
                                        @endphp
                                        @if ($addressCount == 0)
                                            <label id="errorMsg_address"
                                                class="error display-none">{{ __('Please select an address') }}</label>
                                        @endif
                                        @php $addressCount++ @endphp
                                    @endforeach
                                </div>
                            @endif
                            <input type="hidden" id="defaultAddress" value="{{ $defaultAddress }}">
                            <div class="c-tab {{ count($addresses) == 0 ? 'is-active' : '' }} mt-5 form-tab">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-3 address-form">
                                    <div>
                                        <label class="dm-sans font-medium text-gray-12 text-sm"
                                            for="first_name">{{ __('First Name') }} <span>*</span></label>
                                        <input id="first_name" name="first_name" type="text"
                                            class="block w-full py-2 mt-2 text-gray-700 bg-white border border-gray-2 rounded-sm dark:bg-gray-2 dark:border-gray-0 dark:text-gray-2 focus:border-gray-12 dark:focus:border-purple-500 focus:outline-none form-control required-field"
                                            required
                                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                            maxlength="191" value="{{ old('first_name') }}">
                                    </div>
                                    <div>
                                        <label class="dm-sans font-medium text-gray-12 text-sm"
                                            for="last_name">{{ __('Last Name') }} </label>
                                        <input id="last_name" name="last_name" type="text"
                                            class="block w-full py-2 mt-2 text-gray-700 bg-white border border-gray-2 rounded-sm dark:bg-gray-2 dark:border-gray-0 dark:text-gray-2 focus:border-gray-12 dark:focus:border-purple-500 focus:outline-none form-control"
                                            maxlength="191" value="{{ old('last_name') }}">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-3 mt-3 address-form">
                                    <div>
                                        <label class="dm-sans font-medium text-gray-12 text-sm"
                                            for="com_name">{{ __('Company Name') . ' (' . __('Optional') . ')' }}</label>
                                        <div>
                                            <input id="com_name" name="com_name" type="text"
                                                class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-2 rounded-sm dark:bg-gray-2 dark:border-gray-0 dark:text-gray-2 focus:border-gray-12 dark:focus:border-purple-500 focus:outline-none form-control"
                                                maxlength="191" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-3 address-form">
                                    <div>
                                        <label class="dm-sans font-medium text-gray-12 text-sm"
                                            for="phone">{{ __('Phone Number') }} <span>*</span></label>
                                        <input id="phone" name="phone" type="text"
                                            class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-2 rounded-sm dark:bg-gray-2 dark:border-gray-0 dark:text-gray-2 focus:border-gray-12 dark:focus:border-purple-500 focus:outline-none form-control required-field"
                                            required
                                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                            maxlength="45" value="{{ old('phone') }}">
                                    </div>
                                    <div>
                                        <label class="dm-sans font-medium text-gray-12 text-sm"
                                            for="email">{{ __('Email Address') }}</label>
                                        <input id="email" name="email" type="text"
                                            class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-2 rounded-sm dark:bg-gray-2 dark:border-gray-0 dark:text-gray-2 focus:border-gray-12 dark:focus:border-purple-500 focus:outline-none form-control"
                                            value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-3 mt-3 address-form">
                                    <div>
                                        <label class="dm-sans font-medium text-gray-12 text-sm"
                                            for="address_1">{{ __('Street Address 1') }} <span>*</span></label>
                                        <div>
                                            <input id="address_1" name="address_1" type="text"
                                                class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-2 rounded-sm dark:bg-gray-2 dark:border-gray-0 dark:text-gray-2 focus:border-gray-12 dark:focus:border-purple-500 focus:outline-none form-control required-field"
                                                required
                                                oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                                maxlength="191" value="{{ old('address_1') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-3 mt-3 address-form">
                                    <div>
                                        <label class="dm-sans font-medium text-gray-12 text-sm"
                                            for="address_2">{{ __('Street Address 2') }}</label>
                                        <div>
                                            <input id="address_2" name="address_2" type="text"
                                                class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-2 rounded-sm dark:bg-gray-2 dark:border-gray-0 dark:text-gray-2 focus:border-gray-12 dark:focus:border-purple-500 focus:outline-none form-control"
                                                maxlength="191" value="{{ old('address_2') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3 mt-3 address-form">
                                    <div class="validSelect">
                                        <label class="dm-sans font-medium text-gray-12 text-sm"
                                            for="country">{{ __('Country') }} <span>*</span></label>
                                        <select name="country" id="country"
                                            class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-2 rounded-sm dark:bg-gray-2 dark:border-gray-0 dark:text-gray-2 focus:border-gray-12 dark:focus:border-purple-500 focus:outline-none form-control required-field addressSelect">
                                        </select>
                                    </div>
                                    <div class="validSelect">
                                        <label class="dm-sans font-medium text-gray-12 text-sm"
                                            for="state">{{ __('State') . ' / ' . __('Province') }}<span>
                                                *</span></label>
                                        <select name="state" id="state"
                                            class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-2 rounded-sm dark:bg-gray-2 dark:border-gray-0 dark:text-gray-2 focus:border-gray-12 dark:focus:border-purple-500 focus:outline-none form-control required-field addressSelect">
                                            <option>{{ __('Select Option') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3 mt-3 address-form">
                                    <div class="validSelect">
                                        <label class="dm-sans font-medium text-gray-12 text-sm"
                                            for="city">{{ __('City') }} <span>*</span></label>
                                        <select name="city" id="city"
                                            class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-2 rounded-sm dark:bg-gray-2 dark:border-gray-0 dark:text-gray-2 focus:border-gray-12 dark:focus:border-purple-500 focus:outline-none form-control required-field addressSelect">
                                            <option value="">{{ __('Select Option') }}</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="dm-sans font-medium text-gray-12 text-sm"
                                            for="zip">{{ __('Postcode') . ' / ' . __('ZIP') }}</label>
                                        <input id="zip" name="zip" type="text"
                                            class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-2 rounded-sm dark:bg-gray-2 dark:border-gray-0 dark:text-gray-2 focus:border-gray-12 dark:focus:border-purple-500 focus:outline-none form-control h-11"
                                            maxlength="10" value="{{ old('zip') }}">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-3 mt-3 address-form">
                                    <p class=" text-sm dm-sans font-medium capitalize text-gray-12">
                                        {{ __('Select the type of your place') }} <span>*</span></p>
                                    <div class="flex mt-3p">
                                        <div class="radio-buttons">
                                            <label class="custom-radio">
                                                <input type="radio" id="optionsRadios1"
                                                    class="display-none radio-test type_of_place" name="type_of_place"
                                                    value="home"
                                                    {{ old('type_of_place') == 'home' ? 'checked' : '' }} />
                                                <span
                                                    class="radio-btn lg:w-141p lg:h-53p border border-gray-2 rounded dm-sans cursor-pointer relative inline-block font-medium text-center lg:text-sm text-xs text-gray-10 ltr:pl-18p rtl:pr-18p">
                                                    <svg class="absolute opacity-0 lg:my-22p mt-15p ltr:mr-13p rtl:ml-13p"
                                                        xmlns="http://www.w3.org/2000/svg" width="11" height="9"
                                                        viewBox="0 0 11 9" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M11 1.41885L4.38163 9L8.22563e-07 4.81748L1.64177 3.25031L4.22561 5.71673L9.21633 -4.01642e-07L11 1.41885Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                    <div
                                                        class="ltr:lg:ml-18p ltr:ml-2 rtl:lg:mr-18p rtl:mr-2">
                                                        <div class="flex items-center">
                                                            <svg class="my-18p lg:block hidden"
                                                                xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="18" viewBox="0 0 16 18" fill="none">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M6.57318 1.76695C5.97512 2.15794 5.27179 2.75321 4.27687 3.59733L3.22194 4.49239C2.09056 5.4523 1.68078 5.81759 1.46221 6.28799C1.24439 6.75675 1.23083 7.29905 1.23083 8.77444V13.2024C1.23083 14.2048 1.23218 14.8929 1.30238 15.4097C1.36998 15.9075 1.49089 16.1528 1.66444 16.3246C1.83961 16.498 2.09219 16.6198 2.60059 16.6875C3.12551 16.7573 3.82351 16.7586 4.83519 16.7586H11.1648C12.1765 16.7586 12.8745 16.7573 13.3994 16.6875C13.9078 16.6198 14.1604 16.498 14.3356 16.3246C14.5091 16.1528 14.63 15.9075 14.6976 15.4097C14.7678 14.8929 14.7692 14.2048 14.7692 13.2024V8.77444C14.7692 7.29905 14.7556 6.75675 14.5378 6.28799C14.3192 5.81759 13.9094 5.4523 12.7781 4.49239L11.7231 3.59733C10.7282 2.75321 10.0249 2.15794 9.42682 1.76695C8.84342 1.38555 8.42216 1.24138 8 1.24138C7.57784 1.24138 7.15658 1.38555 6.57318 1.76695ZM5.90376 0.725255C6.59589 0.27277 7.25143 0 8 0C8.74858 0 9.40411 0.27277 10.0962 0.725255C10.7663 1.1633 11.5277 1.80936 12.4835 2.62032L13.5703 3.54241C13.6072 3.57366 13.6435 3.60449 13.6794 3.63494C14.6614 4.4675 15.3044 5.01269 15.6522 5.76119C16.0007 6.51119 16.0004 7.3524 16 8.63193C16 8.67884 15.9999 8.72633 15.9999 8.77444V13.2476C16 14.1936 16 14.9673 15.917 15.5782C15.8301 16.2179 15.642 16.7707 15.1976 17.2106C14.7548 17.6489 14.2011 17.8329 13.5604 17.9182C12.9455 18 12.1659 18 11.2083 18H4.79168C3.83408 18 3.05447 18 2.43959 17.9182C1.79889 17.8329 1.24518 17.6489 0.802382 17.2106C0.357973 16.7707 0.169894 16.2179 0.0830068 15.5782C2.77297e-05 14.9673 4.46799e-05 14.1936 6.54405e-05 13.2476L6.61741e-05 8.77444C6.61741e-05 8.72633 4.92282e-05 8.67883 3.25023e-05 8.63192C-0.000424671 7.3524 -0.0007253 6.51119 0.347765 5.76119C0.695552 5.01269 1.33858 4.46751 2.32056 3.63494C2.35647 3.60449 2.39284 3.57366 2.42967 3.54241L3.51646 2.62033C4.47226 1.80937 5.23373 1.1633 5.90376 0.725255Z"
                                                                    fill="currentColor" />
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M5 11.3333C5 10.597 5.53726 10 6.2 10H9.8C10.4627 10 11 10.597 11 11.3333V17.3333C11 17.7015 10.7314 18 10.4 18C10.0686 18 9.8 17.7015 9.8 17.3333V11.3333H6.2V17.3333C6.2 17.7015 5.93137 18 5.6 18C5.26863 18 5 17.7015 5 17.3333V11.3333Z"
                                                                    fill="currentColor" />
                                                            </svg><span
                                                                class="lg:my-0 my-3 ltr:ml-2 ltr:lg:mr-0 ltr:mr-9 rtl:mr-2 rtl:lg:ml-0 rtl:ml-9">{{ __('Home') }}</span>
                                                        </div>
                                                    </div>
                                                </span>
                                            </label>
                                            <label
                                                class="custom-radio ltr:ml-2 rtl:mr-2">
                                                <input type="radio" class="display-none radio-test type_of_place"
                                                    id="optionsRadios2" name="type_of_place" value="office"
                                                    {{ old('type_of_place') == 'office' ? 'checked' : '' }} />
                                                <span
                                                    class="radio-btn lg:w-141p lg:h-53p border border-gray-2 rounded dm-sans cursor-pointer relative inline-block font-medium text-center lg:text-sm text-xs text-gray-10  ltr:pl-18p rtl:pr-18p">
                                                    <svg class="absolute opacity-0 lg:my-22p mt-15p ltr:mr-13p rtl:ml-13p"
                                                        xmlns="http://www.w3.org/2000/svg" width="11" height="9"
                                                        viewBox="0 0 11 9" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M11 1.41885L4.38163 9L8.22563e-07 4.81748L1.64177 3.25031L4.22561 5.71673L9.21633 -4.01642e-07L11 1.41885Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                    <div
                                                        class="ltr:lg:ml-18p ltr:ml-2 rtl:lg:mr-18p rtl:mr-2">
                                                        <div class="flex items-center">
                                                            <svg class="my-18p lg:block hidden"
                                                                xmlns="http://www.w3.org/2000/svg" width="20"
                                                                height="18" viewBox="0 0 20 18" fill="none">
                                                                <path
                                                                    d="M7.66406 0.0578384C7.14453 0.189384 6.56641 0.603956 6.26562 1.06636C6.18359 1.19392 6.0625 1.44107 6 1.61647C5.89062 1.92341 5.88672 1.97124 5.86719 2.76052L5.85156 3.58967H3.14844C0.136719 3.58967 0.277344 3.57771 0.0898438 3.86472L0 4.00025L0.0078125 9.84411L0.0195312 15.688L0.125 15.9989C0.417969 16.8838 1.09375 17.5735 1.97266 17.8884L2.28516 18H10H17.7148L18.0273 17.8884C18.9062 17.5735 19.582 16.8838 19.875 15.9989L19.9805 15.688L19.9922 9.84411L20 4.00025L19.9102 3.86472C19.7227 3.57771 19.8633 3.58967 16.8516 3.58967H14.1484L14.1328 2.78045C14.1172 2.043 14.1055 1.94732 14.0117 1.65633C13.7578 0.879007 13.0938 0.245192 12.3398 0.0618248C12.0039 -0.0179005 7.99219 -0.0218868 7.66406 0.0578384ZM12.2617 1.36135C12.4297 1.44506 12.5547 1.5487 12.6562 1.68423C12.8867 1.97922 12.9297 2.17853 12.9297 2.93991V3.58967H9.99609H7.0625L7.07812 2.86018C7.08984 2.22238 7.10156 2.11076 7.17188 1.95131C7.29297 1.68423 7.47656 1.49688 7.74219 1.35736L7.98047 1.23777H10H12.0195L12.2617 1.36135ZM18.7344 5.02472C18.6562 5.63462 18.2539 6.59132 17.8086 7.23709C17.4727 7.71545 16.7539 8.4529 16.2422 8.83559C15.3086 9.53717 14.2031 10.0634 12.9648 10.4022L12.5469 10.5178L12.5352 9.88796C12.5195 9.19036 12.5 9.13057 12.2266 8.93923L12.0977 8.85153H10H7.90234L7.77344 8.93923C7.5 9.13057 7.48047 9.19036 7.46484 9.88796L7.45312 10.5178L7.09375 10.4221C4.86328 9.81621 3.04688 8.59242 2.05078 7.02582C1.67188 6.42788 1.33594 5.57084 1.26562 5.02472L1.23828 4.82541H10H18.7617L18.7344 5.02472ZM1.37109 8.20177C1.59766 8.5127 2.25781 9.20232 2.62109 9.51325C3.34375 10.1311 4.46875 10.7968 5.44531 11.1835C5.91406 11.3708 6.59766 11.5821 7.12891 11.7057C7.30078 11.7416 7.45703 11.7894 7.47266 11.8014C7.49219 11.8173 7.53125 11.9369 7.5625 12.0645C7.67578 12.5109 7.88281 12.8697 8.22266 13.2165C8.73828 13.7427 9.27734 13.9699 10 13.9699C10.7109 13.9699 11.2617 13.7427 11.7617 13.2364C12.0938 12.9016 12.2578 12.6305 12.3828 12.2199C12.5234 11.7615 12.5039 11.7854 12.7773 11.7296C12.9141 11.6977 13.2461 11.614 13.5117 11.5383C14.9414 11.1277 16.3359 10.3982 17.3711 9.51724C17.7773 9.17043 18.3867 8.52864 18.6328 8.19778L18.8086 7.95861L18.8203 8.3971C18.8281 8.63627 18.8281 10.3025 18.8203 12.1003L18.8086 15.3691L18.7188 15.6082C18.5273 16.1344 18.1328 16.5331 17.6484 16.7005L17.4062 16.7842H10.0156C2.72266 16.7842 2.62109 16.7842 2.37109 16.7045C1.88281 16.549 1.47656 16.1424 1.28125 15.6082L1.19141 15.3691L1.17969 11.6698C1.17188 9.63682 1.17578 7.97455 1.18359 7.97455C1.19531 7.97455 1.27734 8.0782 1.37109 8.20177ZM11.3203 10.8726C11.2969 11.8014 11.25 11.9847 10.9453 12.3156C10.4219 12.8856 9.57812 12.8856 9.05469 12.3156C8.75 11.9847 8.70312 11.8014 8.67969 10.8726L8.66406 10.0873H10H11.3359L11.3203 10.8726Z"
                                                                    fill="currentColor" />
                                                            </svg><span
                                                                class="lg:my-0 my-3 ltr:ml-2 ltr:lg:mr-0 ltr:mr-9 rtl:mr-2 rtl:lg:ml-0 rtl:ml-9">{{ __('Office') }}</span>
                                                        </div>
                                                    </div>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <label id="errorMsg"></label>
                                </div>
                                @if (Auth::check())
                                    <div class="w-full mt-18p address-form">
                                        <input type="checkbox"
                                            class="border border-gray-2 cursor-pointer form-checkbox cart-item-single cart-shop-0 -mt-0.5"
                                            id="default_future" name="default_future"
                                            {{ old('default_future') == 'on' ? 'checked' : '' }}>
                                        <span
                                            class="dm-sans font-medium text-sm text-gray-10 ltr:ml-2 rtl:mr-2">{{ __('Use the default address in the future.') }}</span>
                                    </div>
                                @endif
                                @if (preference('shipping_destination') != 'force_billing_address')
                                    <div class="w-full mt-18p address-form">
                                        <input type="checkbox"
                                            class="border border-gray-2 cursor-pointer form-checkbox -mt-0.5 neg-transition-scale"
                                            id="ship_different" name="ship_different"
                                            {{ old('ship_different') == 'on' ? 'checked' : '' }}>
                                        <span
                                            class="dm-sans font-medium text-sm text-gray-10 ltr:ml-2 rtl:mr-2">{{ __('Ship to a different address?') }}</span>
                                    </div>

                                    {{-- ship different address --}}
                                    <div id="different-address-form"
                                        class="{{ old('ship_different') != 'on' ? 'display-none' : '' }}">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-3 different-address-form">
                                            <div class="validSelectShipping">
                                                <label class="dm-sans font-medium text-gray-12 text-sm"
                                                    for="shipping_address_first_name">{{ __('First Name') }}
                                                    <span>*</span></label>
                                                <input id="shipping_address_first_name" name="shipping_address_first_name"
                                                    type="text"
                                                    class="block w-full py-2 mt-2 text-gray-700 bg-white border border-gray-2 rounded-sm dark:bg-gray-2 dark:border-gray-0 dark:text-gray-2 focus:border-gray-12 dark:focus:border-purple-500 focus:outline-none form-control shipping_address_required-field"
                                                    maxlength="191" value="{{ old('shipping_address_first_name') }}">
                                            </div>
                                            <div>
                                                <label class="dm-sans font-medium text-gray-12 text-sm"
                                                    for="shipping_address_last_name">{{ __('Last Name') }} </label>
                                                <input id="shipping_address_last_name" name="shipping_address_last_name"
                                                    type="text"
                                                    class="block w-full py-2 mt-2 text-gray-700 bg-white border border-gray-2 rounded-sm dark:bg-gray-2 dark:border-gray-0 dark:text-gray-2 focus:border-gray-12 dark:focus:border-purple-500 focus:outline-none form-control"
                                                    maxlength="191" value="{{ old('shipping_address_last_name') }}">
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3 mt-3 different-address-form">
                                            <div>
                                                <label class="dm-sans font-medium text-gray-12 text-sm"
                                                    for="shipping_address_com_name">{{ __('Company Name') . ' (' . __('Optional') . ')' }}</label>
                                                <div>
                                                    <input id="shipping_address_com_name" name="shipping_address_com_name"
                                                        type="text"
                                                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-2 rounded-sm dark:bg-gray-2 dark:border-gray-0 dark:text-gray-2 focus:border-gray-12 dark:focus:border-purple-500 focus:outline-none form-control"
                                                        maxlength="191">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3 mt-3 different-address-form">
                                            <div>
                                                <label class="dm-sans font-medium text-gray-12 text-sm"
                                                    for="shipping_address_address_1">{{ __('Street Address 1') }}
                                                    <span>*</span></label>
                                                <div class="validSelectShipping">
                                                    <input id="shipping_address_address_1"
                                                        name="shipping_address_address_1" type="text"
                                                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-2 rounded-sm dark:bg-gray-2 dark:border-gray-0 dark:text-gray-2  focus:border-gray-12 dark:focus:border-purple-500 focus:outline-none form-control shipping_address_required-field"
                                                        maxlength="191" value="{{ old('address_1') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3 mt-3 different-address-form">
                                            <div>
                                                <label class="dm-sans font-medium text-gray-12 text-sm"
                                                    for="shipping_address_address_2">{{ __('Street Address 2') }}</label>
                                                <div>
                                                    <input id="shipping_address_address_2"
                                                        name="shipping_address_address_2" type="text"
                                                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-2 rounded-sm dark:bg-gray-2 dark:border-gray-0 dark:text-gray-2 focus:border-gray-12 dark:focus:border-purple-500 focus:outline-none form-control"
                                                        maxlength="191" value="{{ old('address_2') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-2 gap-3 mt-3 different-address-form">
                                            <div class="validSelectShipping">
                                                <label class="dm-sans font-medium text-gray-12 text-sm"
                                                    for="shipping_address_country">{{ __('Country') }}
                                                    <span>*</span></label>
                                                <select name="shipping_address_country" id="shipping_address_country"
                                                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-2 rounded-sm dark:bg-gray-2 dark:border-gray-0 dark:text-gray-2 focus:border-gray-12 dark:focus:border-purple-500 focus:outline-none form-control shipping_address_required-field shippingAddressSelect">
                                                </select>
                                            </div>
                                            <div class="validSelectShipping">
                                                <label class="dm-sans font-medium text-gray-12 text-sm"
                                                    for="shipping_address_state">{{ __('State') . ' / ' . __('Province') }}<span>
                                                        *</span></label>
                                                <select name="shipping_address_state" id="shipping_address_state"
                                                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-2 rounded-sm dark:bg-gray-2 dark:border-gray-0 dark:text-gray-2 focus:border-gray-12 dark:focus:border-purple-500 focus:outline-none form-control shipping_address_required-field shippingAddressSelect">
                                                    <option>{{ __('Select Option') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-2 gap-3 mt-3 different-address-form">
                                            <div class="validSelectShipping">
                                                <label class="dm-sans font-medium text-gray-12 text-sm"
                                                    for="shipping_address_city">{{ __('City') }} <span>*</span></label>
                                                <select name="shipping_address_city" id="shipping_address_city"
                                                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-2 rounded-sm dark:bg-gray-2 dark:border-gray-0 dark:text-gray-2 focus:border-gray-12 dark:focus:border-purple-500 focus:outline-none form-control shipping_address_required-field shippingAddressSelect">
                                                    <option value="">{{ __('Select Option') }}</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="dm-sans font-medium text-gray-12 text-sm"
                                                    for="shipping_address_zip">{{ __('Postcode') . ' / ' . __('ZIP') }}</label>
                                                <input id="shipping_address_zip" name="shipping_address_zip"
                                                    type="text"
                                                    class="block w-full px-4 py-2 h-11 text-gray-700 bg-white border border-gray-2 rounded-sm dark:bg-gray-2 dark:border-gray-0 dark:text-gray-2 focus:border-gray-12 dark:focus:border-purple-500 focus:outline-none form-control"
                                                    maxlength="10" value="{{ old('zip') }}">
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 gap-3 mt-3 different-address-form">
                                            <p class=" text-sm dm-sans font-medium capitalize text-gray-12">
                                                {{ __('Select the type of your place') }}</p>
                                            <div class="flex mt-3p">
                                                <div class="radio-buttons">
                                                    <label class="custom-radio">
                                                        <input type="radio" id="diff_optionsRadios1"
                                                            class="display-none radio-test"
                                                            name="shipping_address_type_of_place" value="home"
                                                            {{ old('shipping_address_type_of_place') == 'home' ? 'checked' : '' }} />
                                                        <span
                                                            class="radio-btn lg:w-141p lg:h-53p border border-gray-2 rounded dm-sans cursor-pointer relative inline-block font-medium text-center lg:text-sm text-xs text-gray-10 ltr:pl-18p rtl:pr-18p">
                                                            <svg class="absolute opacity-0 lg:my-22p mt-15p ltr:mr-13p rtl:ml-13p"
                                                                xmlns="http://www.w3.org/2000/svg" width="11"
                                                                height="9" viewBox="0 0 11 9" fill="none">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M11 1.41885L4.38163 9L8.22563e-07 4.81748L1.64177 3.25031L4.22561 5.71673L9.21633 -4.01642e-07L11 1.41885Z"
                                                                    fill="currentColor" />
                                                            </svg>
                                                            <div
                                                                class="ltr:lg:ml-18p ltr:ml-2 rtl:lg:mr-18p rtl:mr-2">
                                                                <div class="flex items-center">
                                                                    <svg class="my-18p lg:block hidden"
                                                                        xmlns="http://www.w3.org/2000/svg" width="16"
                                                                        height="18" viewBox="0 0 16 18"
                                                                        fill="none">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M6.57318 1.76695C5.97512 2.15794 5.27179 2.75321 4.27687 3.59733L3.22194 4.49239C2.09056 5.4523 1.68078 5.81759 1.46221 6.28799C1.24439 6.75675 1.23083 7.29905 1.23083 8.77444V13.2024C1.23083 14.2048 1.23218 14.8929 1.30238 15.4097C1.36998 15.9075 1.49089 16.1528 1.66444 16.3246C1.83961 16.498 2.09219 16.6198 2.60059 16.6875C3.12551 16.7573 3.82351 16.7586 4.83519 16.7586H11.1648C12.1765 16.7586 12.8745 16.7573 13.3994 16.6875C13.9078 16.6198 14.1604 16.498 14.3356 16.3246C14.5091 16.1528 14.63 15.9075 14.6976 15.4097C14.7678 14.8929 14.7692 14.2048 14.7692 13.2024V8.77444C14.7692 7.29905 14.7556 6.75675 14.5378 6.28799C14.3192 5.81759 13.9094 5.4523 12.7781 4.49239L11.7231 3.59733C10.7282 2.75321 10.0249 2.15794 9.42682 1.76695C8.84342 1.38555 8.42216 1.24138 8 1.24138C7.57784 1.24138 7.15658 1.38555 6.57318 1.76695ZM5.90376 0.725255C6.59589 0.27277 7.25143 0 8 0C8.74858 0 9.40411 0.27277 10.0962 0.725255C10.7663 1.1633 11.5277 1.80936 12.4835 2.62032L13.5703 3.54241C13.6072 3.57366 13.6435 3.60449 13.6794 3.63494C14.6614 4.4675 15.3044 5.01269 15.6522 5.76119C16.0007 6.51119 16.0004 7.3524 16 8.63193C16 8.67884 15.9999 8.72633 15.9999 8.77444V13.2476C16 14.1936 16 14.9673 15.917 15.5782C15.8301 16.2179 15.642 16.7707 15.1976 17.2106C14.7548 17.6489 14.2011 17.8329 13.5604 17.9182C12.9455 18 12.1659 18 11.2083 18H4.79168C3.83408 18 3.05447 18 2.43959 17.9182C1.79889 17.8329 1.24518 17.6489 0.802382 17.2106C0.357973 16.7707 0.169894 16.2179 0.0830068 15.5782C2.77297e-05 14.9673 4.46799e-05 14.1936 6.54405e-05 13.2476L6.61741e-05 8.77444C6.61741e-05 8.72633 4.92282e-05 8.67883 3.25023e-05 8.63192C-0.000424671 7.3524 -0.0007253 6.51119 0.347765 5.76119C0.695552 5.01269 1.33858 4.46751 2.32056 3.63494C2.35647 3.60449 2.39284 3.57366 2.42967 3.54241L3.51646 2.62033C4.47226 1.80937 5.23373 1.1633 5.90376 0.725255Z"
                                                                            fill="currentColor" />
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M5 11.3333C5 10.597 5.53726 10 6.2 10H9.8C10.4627 10 11 10.597 11 11.3333V17.3333C11 17.7015 10.7314 18 10.4 18C10.0686 18 9.8 17.7015 9.8 17.3333V11.3333H6.2V17.3333C6.2 17.7015 5.93137 18 5.6 18C5.26863 18 5 17.7015 5 17.3333V11.3333Z"
                                                                            fill="currentColor" />
                                                                    </svg><span
                                                                        class="lg:my-0 my-3 ltr:ml-2 ltr:lg:mr-0 ltr:mr-9 rtl:mr-2 rtl:lg:ml-0 rtl:ml-9">{{ __('Home') }}</span>
                                                                </div>
                                                            </div>
                                                        </span>
                                                    </label>
                                                    <label
                                                        class="custom-radio ltr:ml-2 rtl:mr-2">
                                                        <input type="radio" class="display-none radio-test"
                                                            id="diff_optionsRadios2" name="shipping_address_type_of_place"
                                                            value="office"
                                                            {{ old('shipping_address_type_of_place') == 'office' ? 'checked' : '' }} />
                                                        <span
                                                            class="radio-btn lg:w-141p lg:h-53p border border-gray-2 rounded dm-sans cursor-pointer relative inline-block font-medium text-center lg:text-sm text-xs text-gray-10 ltr:pl-18p rtl:pr-18p">
                                                            <svg class="absolute opacity-0 lg:my-22p mt-15p ltr:mr-13p rtl:ml-13p"
                                                                xmlns="http://www.w3.org/2000/svg" width="11"
                                                                height="9" viewBox="0 0 11 9" fill="none">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M11 1.41885L4.38163 9L8.22563e-07 4.81748L1.64177 3.25031L4.22561 5.71673L9.21633 -4.01642e-07L11 1.41885Z"
                                                                    fill="currentColor" />
                                                            </svg>
                                                            <div
                                                                class="ltr:lg:ml-18p ltr:ml-2 rtl:lg:mr-18p rtl:mr-2">
                                                                <div class="flex items-center">
                                                                    <svg class="my-18p lg:block hidden"
                                                                        xmlns="http://www.w3.org/2000/svg" width="20"
                                                                        height="18" viewBox="0 0 20 18"
                                                                        fill="none">
                                                                        <path
                                                                            d="M7.66406 0.0578384C7.14453 0.189384 6.56641 0.603956 6.26562 1.06636C6.18359 1.19392 6.0625 1.44107 6 1.61647C5.89062 1.92341 5.88672 1.97124 5.86719 2.76052L5.85156 3.58967H3.14844C0.136719 3.58967 0.277344 3.57771 0.0898438 3.86472L0 4.00025L0.0078125 9.84411L0.0195312 15.688L0.125 15.9989C0.417969 16.8838 1.09375 17.5735 1.97266 17.8884L2.28516 18H10H17.7148L18.0273 17.8884C18.9062 17.5735 19.582 16.8838 19.875 15.9989L19.9805 15.688L19.9922 9.84411L20 4.00025L19.9102 3.86472C19.7227 3.57771 19.8633 3.58967 16.8516 3.58967H14.1484L14.1328 2.78045C14.1172 2.043 14.1055 1.94732 14.0117 1.65633C13.7578 0.879007 13.0938 0.245192 12.3398 0.0618248C12.0039 -0.0179005 7.99219 -0.0218868 7.66406 0.0578384ZM12.2617 1.36135C12.4297 1.44506 12.5547 1.5487 12.6562 1.68423C12.8867 1.97922 12.9297 2.17853 12.9297 2.93991V3.58967H9.99609H7.0625L7.07812 2.86018C7.08984 2.22238 7.10156 2.11076 7.17188 1.95131C7.29297 1.68423 7.47656 1.49688 7.74219 1.35736L7.98047 1.23777H10H12.0195L12.2617 1.36135ZM18.7344 5.02472C18.6562 5.63462 18.2539 6.59132 17.8086 7.23709C17.4727 7.71545 16.7539 8.4529 16.2422 8.83559C15.3086 9.53717 14.2031 10.0634 12.9648 10.4022L12.5469 10.5178L12.5352 9.88796C12.5195 9.19036 12.5 9.13057 12.2266 8.93923L12.0977 8.85153H10H7.90234L7.77344 8.93923C7.5 9.13057 7.48047 9.19036 7.46484 9.88796L7.45312 10.5178L7.09375 10.4221C4.86328 9.81621 3.04688 8.59242 2.05078 7.02582C1.67188 6.42788 1.33594 5.57084 1.26562 5.02472L1.23828 4.82541H10H18.7617L18.7344 5.02472ZM1.37109 8.20177C1.59766 8.5127 2.25781 9.20232 2.62109 9.51325C3.34375 10.1311 4.46875 10.7968 5.44531 11.1835C5.91406 11.3708 6.59766 11.5821 7.12891 11.7057C7.30078 11.7416 7.45703 11.7894 7.47266 11.8014C7.49219 11.8173 7.53125 11.9369 7.5625 12.0645C7.67578 12.5109 7.88281 12.8697 8.22266 13.2165C8.73828 13.7427 9.27734 13.9699 10 13.9699C10.7109 13.9699 11.2617 13.7427 11.7617 13.2364C12.0938 12.9016 12.2578 12.6305 12.3828 12.2199C12.5234 11.7615 12.5039 11.7854 12.7773 11.7296C12.9141 11.6977 13.2461 11.614 13.5117 11.5383C14.9414 11.1277 16.3359 10.3982 17.3711 9.51724C17.7773 9.17043 18.3867 8.52864 18.6328 8.19778L18.8086 7.95861L18.8203 8.3971C18.8281 8.63627 18.8281 10.3025 18.8203 12.1003L18.8086 15.3691L18.7188 15.6082C18.5273 16.1344 18.1328 16.5331 17.6484 16.7005L17.4062 16.7842H10.0156C2.72266 16.7842 2.62109 16.7842 2.37109 16.7045C1.88281 16.549 1.47656 16.1424 1.28125 15.6082L1.19141 15.3691L1.17969 11.6698C1.17188 9.63682 1.17578 7.97455 1.18359 7.97455C1.19531 7.97455 1.27734 8.0782 1.37109 8.20177ZM11.3203 10.8726C11.2969 11.8014 11.25 11.9847 10.9453 12.3156C10.4219 12.8856 9.57812 12.8856 9.05469 12.3156C8.75 11.9847 8.70312 11.8014 8.67969 10.8726L8.66406 10.0873H10H11.3359L11.3203 10.8726Z"
                                                                            fill="currentColor" />
                                                                    </svg><span
                                                                        class="lg:my-0 my-3 ltr:ml-2 ltr:lg:mr-0 ltr:mr-9 rtl:mr-2 rtl:lg:ml-0 rtl:ml-9">{{ __('Office') }}</span>
                                                                </div>
                                                            </div>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <label id="errorMsg"></label>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="mt-4 w-full address-textarea">
                            <label for="delivery-instructions"
                                class="dm-sans font-medium text-gray-12 text-sm">{{ __('Delivery Instructions') . '( ' . __('Optional') . ' )' }}</label>
                            <textarea
                                class="block w-full px-2 py-2 mt-2 text-gray-12 bg-white border border-gray-200 rounded-sm focus:border-gray-12"
                                rows="4" name="note">{{ old('note') }}</textarea>
                        </div>
                        <div class="mt-4 w-full radio-container-payment flex lg:justify-start justify-center">
                            <div>
                            </div>
                            <a href="{{ route('site.cart') }}"
                                class="flex relative mt-30p arrow-hover font-medium dm-sans text-gray-10 text-base p-3 rounded-sm ltr:pl-4 rtl:pr-4">
                                <svg class="mt-2 absolute ltr:mr-3 rtl:ml-3 neg-transition-scale"
                                    width="15" height="10" viewBox="0 0 15 10" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M4.70711 0L6.12132 1.41421L3.82843 3.70711H13.4142C13.9665 3.70711 14.4142 4.15482 14.4142 4.70711C14.4142 5.25939 13.9665 5.70711 13.4142 5.70711H3.82843L6.12132 8L4.70711 9.41421L0 4.70711L4.70711 0Z"
                                        fill="currentColor" />
                                </svg>
                                <span
                                    class="dm-sans font-medium ltr:ml-4 rtl:mr-4">{{ __('Back to Cart') }}</span>
                            </a>
                        </div>
                        {{-- ship different address end --}}
                    </div>
                </div>
                <div
                    class="md:w-42% lg:w-1/3 flex flex-col ltr:md:ml-auto rtl:md:mr-auto w-full mb-10">
                    <div class="flex justify-between flex-wrap lg:justify-center">
                        <div class="rounded bg-white dark:bg-gray-2 w-full border checked-loader">
                            <div class="w-full px-5 py-5 text-gray-12 font-medium dm-sans">
                                <h3 class="font-bold dm-bold text-lg text-gray-12">{{ __('Order Summary') }}</h3>
                                <div class="flex justify-between mt-3 text-sm border-b pb-3">
                                    <p>
                                        {{ __('Subtotal') }}
                                    </p>
                                    <div class='text-right'><span
                                            id="cart-subtotal">{{ formatNumber($selectedTotal) }}</span>
                                    </div>
                                </div>
                                @if (isActive('Shipping'))
                                    <div class="flex justify-between mt-3 w-full">
                                        <div class="w-full" id="shipping_method">
                                            @php
                                                $shipCount = 0;
                                                $shipingIntailValue = 0;
                                            @endphp
                                            @if (is_array($shipping) && count($shipping) > 0)
                                                <div class="text-sm">{{ __('Shipping') }}</div>
                                                <ul>
                                                    @foreach ($shipping as $key => $ship)
                                                        @php
                                                            if ($shipCount == $shippingIndex) {
                                                                $shipingIntailValue = $ship;
                                                            } else {
                                                                $shipCount == 0 ? ($shipingIntailValue = $ship) : '';
                                                            }
                                                        @endphp
                                                        <li>
                                                            <div class="mt-2 w-full">
                                                                <div class="flex justify-between items-center w-full">
                                                                    <div
                                                                        class="flex items-center shipping-radio-button-custom">
                                                                        <input type="radio" name="shipping_method"
                                                                            data-value="{{ $ship }}"
                                                                            class="shipping_method cursor-pointer"
                                                                            data-index="{{ $shipCount }}"
                                                                            {{ $shipCount == $shippingIndex ? 'checked' : '' }}
                                                                            id={{ $shipCount }}>
                                                                        <label for={{ $shipCount }}
                                                                            class="text-sm cursor-pointer ltr:ml-2 rtl:mr-2">{{ $key }}:</label>
                                                                    </div>
                                                                    <label> {{ formatNumber($ship) }}</label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        @php $shipCount++; @endphp
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                @php $couponOffer = 0 @endphp
                                @if (isActive('Coupon') && preference('coupons') == 1)
                                    <div class="flex justify-between mt-3 display-none couponOffer">
                                        <div class="dm-sans text-sm text-gray-12 font-medium">
                                            {{ __('Coupon offer') }}
                                        </div>
                                        @php $couponOffer = $coupon; @endphp
                                        <div class="dm-sans text-sm text-gray-12 font-medium">
                                            <span id="couponOffer">{{ formatNumber($couponOffer) }}</span>
                                        </div>
                                    </div>
                                @endif
                                @if (preference('taxes') == 1)
                                    <div id="customTax" class="display-none">
                                        @php $tempTax = 0; @endphp
                                        @if (is_array($tax))
                                            @foreach ($tax as $key => $allTax)
                                                <div class="flex justify-between mt-3">
                                                    <div class="text-sm">{{ $key }}</div>
                                                    <div class='text-sm text-right'>
                                                        <span class="customTax">{{ formatNumber($allTax) }}</span>
                                                    </div>
                                                </div>
                                                @php $tempTax += $allTax; @endphp
                                            @endforeach
                                        @else
                                            <div class="flex justify-between mt-3">
                                                <div class="text-sm">{{ __('Tax') }}</div>
                                                <div class='text-sm text-right'>
                                                    <span class="customTax">{{ formatNumber($tax) }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                <div class="flex justify-between mt-3 border-t">
                                    <div class="text-xl mt-2">
                                        {{ __('Total Amount') }}</div>
                                    <div class="text-base mt-2">
                                        @if (is_array($tax))
                                            <span
                                                id="cart-total-d">{{ formatNumber($selectedTotal - $couponOffer + $tempTax + $shipingIntailValue) }}</span>
                                            <span class="display-none"
                                                id="cart-total">{{ $selectedTotal - $couponOffer + $tempTax + $shipingIntailValue }}</span>
                                        @else
                                            <span
                                                id="cart-total-d">{{ formatNumber($selectedTotal - $couponOffer + $tax + $shipingIntailValue) }}</span>
                                            <span class="display-none"
                                                id="cart-total">{{ $selectedTotal - $couponOffer + $tax + $shipingIntailValue }}</span>
                                        @endif
                                    </div>
                                </div>
                                <button type="submit"
                                    class="process-goto relative flex justify-center items-center text-center lg:px-4 md:px-2 px-4 py-4 text-sm md:text-base text-white w-full mt-5 rounded dm-bold font-bold primary-bg-hover hover:text-gray-12 bg-black"
                                    id="makePayment">{{ __('Make Payment') }}
                                    <svg class="relative neg-transition-scale ltr:ml-2 rtl:mr-2"
                                        width="15" height="10" viewBox="0 0 15 10" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M10.1016 0L8.62991 1.50221L11.016 3.93778H1.04064C0.46591 3.93778 0 4.41335 0 5C0 5.58665 0.46591 6.06222 1.04064 6.06222H11.016L8.62991 8.49779L10.1016 10L15 5L10.1016 0Z"
                                            fill="currentColor" />
                                    </svg>
                                </button>
                                <br>
                                @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                        <label class="error">{{ $error }}</label>
                                    @endforeach
                                @endif
                                @php
                                    $gateways = (new \Modules\Gateway\Entities\GatewayModule())->payableGateways();
                                @endphp
                                @if (is_array($gateways) && count($gateways) > 0)
                                    <div>
                                        <h3 class="font-medium dm-sans text-sm text-gray-10 my-6">
                                            {{ __('Accepted payment method') }}</h3>
                                        <div class="flex flex-wrap gap-x-6 gap-y-2">
                                            @foreach ($gateways as $gateway)
                                                <div>
                                                    <img src="{{ asset(moduleConfig($gateway->alias . '.logo')) }}"
                                                        alt="{{ __('Image') }}"
                                                        class="w-16 h-7 object-contain m-auto">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

@endsection

@section('js')
    <script>
        "use strict";
        var userId = {{ Auth::check() ? \Illuminate\Support\Facades\Auth::user()->id : 0 }};
        let oldCountry = "{!! old('country') ?? 'null' !!}";
        let oldState = "{!! old('state') ?? 'null' !!}";
        let oldCity = "{!! old('city') ?? 'null' !!}";
        var dispalyTaxTotal = "{{ preference('display_tax_totals') }}";
        var calculateTaxShipping = "{{ preference('calculate_tax') }}";
        var oldShipDifferent = "{!! old('ship_different') !!}"
    </script>
    <script src="{{ asset('public/dist/js/custom/jquery.blockUI.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/checkout.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('/public/dist/js/custom/site/address.min.js') }}"></script>
@endsection
