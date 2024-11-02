@extends('.site.layouts.app')
@section('page_title', __('Vendor Resigtration'))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/select2/css/select2.min.css') }}">
@endsection
@section('content')
@php
    $uppercase = $lowercase = $number = $symbol = $length = 0;
    if (env('PASSWORD_STRENGTH') != null && env('PASSWORD_STRENGTH') != '') {
        $length = filter_var(env('PASSWORD_STRENGTH'), FILTER_SANITIZE_NUMBER_INT);
        $conditions = explode('|', env('PASSWORD_STRENGTH'));
        $uppercase = in_array('UPPERCASE', $conditions);
        $lowercase = in_array('LOWERCASE', $conditions);
        $number = in_array('NUMBERS', $conditions);
        $symbol = in_array('SYMBOLS', $conditions);
    }
@endphp
    <!-- component -->
    <div class="bg-gray-23 lg:bg-cover bg-center">
        <span><img class="3xl:h-full h-36" src="{{ asset('public/frontend/assets/img/be-seller/registration-header-bg.svg') }}" alt="{{ __('Image') }}"></span>
    </div>
    <div class="3xl:mx-470p 2xl:mx-64 xl:mx-32 md:mx-20 mx-5 mb-70p 3xl:-mt-132p -mt-28 relative border border-gray-2 bg-white rounded-lg">
        <p class="lg:mt-12 mt-6 text-gray-10 lg:text-lg text-xs dm-sans font-medium text-center">
            {{ __('Register now with few easy steps!') }}</p>
        <p class="lg:mt-2.5 mt-2 text-gray-12 lg:text-28 text-19 dm-bold font-bold uppercase text-center px-5 lg:px-0">
            {{ __('Seller Registration Form') }}</p>
        <div class="primary-bg-color lg:h-1 h-3p rounded-lg lg:w-93p w-60p mx-auto lg:mt-3.5 mt-3"></div>
        <p class="lg:mt-8 mt-22p roboto-medium font-medium text-gray-10 lg:text-sm text-xs text-center lg:px-52 px-15p">
            {{ __('Note: Please make sure to fill in the form with your actual information or else your account may become banned or suspended.') }}
        </p>
        @error('fail')
            <div class="flex justify-center">
                <p class="password-validation-error block text-center text-11 mt-1 text-red-500 p-2 font-bold text-sm mb-2">{{ $message }}</p>
            </div>
        @enderror
        @php
            $colors = ['fail' => 'text-red-500', 'info' => 'text-red-500', 'success' => 'text-green-1']
        @endphp
        @foreach (['success', 'fail', 'info'] as $msg)
            @if ($message = Session::get($msg))
                <div class="flex justify-center">
                    <p class="{{ $colors[$msg] }} block text-center text-11 mt-1 p-2 font-bold text-sm mb-2">{{ $message }}</p>
                </div>
            @endif
        @endforeach
        <form method="post" action="{{ route('site.seller.signUpStore') }}"
            class="lg:mt-8 mt-30p xl:mx-130p lg:mx-70p mx-15p" onsubmit="return formValidation()">
            @csrf
            @error('name')
                <div class="flex justify-center">
                    <p class="password-validation-error block text-center text-11 text-red-500 p-2 font-bold text-sm">{{ $message }}</p>
                </div>
            @enderror
            <div class="flex">
                <div class="primary-bg-color w-2p lg:h-23p h-5 mt-2p ltr:mr-2 rtl:ml-2"> </div>
                <p class="text-gray-12 mb-5 uppercase dm-bold font-bold lg:text-lg text-base">{{ __('Basic Details') }}
                </p>
            </div>
            <div class="grid lg:grid-cols-2 grid-cols-1 lg:gap-3 gap-0">
                <div class="lg:mb-3 mb-3.5">
                    <label class="text-sm dm-sans font-medium capitalize text-gray-12 require-profile">{{ __('First Name') }}</label>
                    <input class="border-gray-2 rounded-sm pr-3 w-full mt-1.5 lg:mt-1p h-46p roboto-medium pl-18p font-medium text-sm text-gray-10 form-control border focus:border-gray-12"
                        type="text" name="f_name" required oninvalid="this.setCustomValidity('This field is required.')"
                        value="{{ old('f_name') }}" placeholder="{{ __('Enter Your :x', ['x' => __('First Name')]) }}">
                    @error('f_name')
                        <span class="password-validation-error block text-11 mt-1 text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="lg:mb-3 mb-3.5">
                    <label class="text-sm dm-sans font-medium capitalize text-gray-12"> {{ __('Last Name') }}</label>
                    <input class="border-gray-2 rounded-sm w-full mt-1.5 lg:mt-1p h-46p proboto-medium pl-18p font-medium text-sm text-gray-10 form-control focus:border-gray-12" type="text" name="l_name" required oninvalid="this.setCustomValidity('This field is required.')" value="{{ old('l_name') }}" placeholder="{{ __('Enter Your :x', ['x' => __('Last Name')]) }}">
                    @error('l_name')
                        <span class="password-validation-error block text-11 mt-1 text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="grid lg:grid-cols-2 grid-cols-1 lg:gap-3">
                <div class="lg:order-none lg:mb-3 mb-3.5">
                    <label class="text-sm dm-sans font-medium capitalize text-gray-12 require-profile">{{ __('Phone Number') }}</label>
                    <input class="border-gray-2 mt-1.5 lg:mt-1p rounded-sm w-full h-46p roboto-medium pl-18p font-medium text-sm text-gray-10 form-control border focus:border-gray-12" type="text" name="phone" required oninvalid="this.setCustomValidity('This field is required.')" value="{{ old('phone') }}" placeholder="{{ __('Enter Your :x', ['x' => __('Phone Number')]) }}">
                    @error('phone')
                        <span class="password-validation-error block text-11 mt-1 text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="lg:order-none lg:mb-3 mb-3.5">
                    <label class="text-sm dm-sans font-medium capitalize text-gray-12 require-profile">{{ __('Email Address') }}</label>
                    <input class="border-gray-2 mt-1.5 lg:mt-1p rounded-sm w-full h-46p pl-18p roboto-medium font-medium text-sm text-gray-10 form-control focus:border-gray-12" type="email" name="email" required oninvalid="this.setCustomValidity('This field is required.')" value="{{ old('email') }}" placeholder="{{ __('Enter Your :x', ['x' => __('Email')]) }}" autocomplete="new-email">
                    @error('email')
                        <span class="password-validation-error block text-11 mt-1 text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="lg:mb-3 mb-3.5">
                <label class="text-sm dm-sans font-medium capitalize text-gray-12 require-profile">{{ __('Shop') . ' / ' . __('Vendor Address') }}</label>
                <input class="border-gray-2 rounded-sm w-full mt-1.5 lg:mt-1p h-46p roboto-medium pl-18p font-medium text-sm text-gray-10 form-control focus:border-gray-12" type="text" name="address" required oninvalid="this.setCustomValidity('This field is required.')" value="{{ old('address') }}" placeholder="{{ __('Enter Your :x', ['x' => __('Address')]) }}">
                @error('address')
                    <span class="password-validation-error block text-11 mt-1 text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="grid lg:grid-cols-2 grid-cols-1 lg:gap-3 gap-15p">
                <div class="w-full">
                    <label class="text-sm dm-sans font-medium capitalize text-gray-12 require-profile">{{ __('Country ') }}
                    </label>
                    <select name="country" id="country" value="{{ old('country') }}" class="border-gray-2 mt-1.5 lg:mt-1p rounded-sm w-full h-46p roboto-medium pl-18p font-medium text-sm text-gray-10 form-control border focus:border-gray-12 addressSelect sl_common_bx"  required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                        <option value="">{{ __('Select Country') }}</option>
                    </select>
                </div>
                <div class="w-full">
                    <label class="text-sm dm-sans font-medium capitalize text-gray-12 require-profile">{{ __('State') . ' / ' . __('Province') }}
                    </label>
                    <select name="state" id="state" value="{{ old('state') }}" class="border-gray-2 mt-1.5 lg:mt-1p rounded-sm w-full h-46p roboto-medium pl-18p font-medium text-sm text-gray-10 form-control border focus:border-gray-12 addressSelect sl_common_bx" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                        <option value="">{{ __('Select State') }}</option>
                    </select>
                </div>
            </div>
            <div class="grid lg:grid-cols-2 grid-cols-1 lg:gap-3 gap-15p">
                <div class="lg:mb-3 mt-3.5">
                    <label class="text-sm dm-sans font-medium capitalize text-gray-12 require-profile">{{ __('City ') }}</label>
                    <select name="city" id="city" value="{{ old('city') }}" class="border-gray-2 rounded-sm w-full h-46p mt-1.5 lg:mt-1p roboto-medium pl-18p font-medium text-sm text-gray-10 form-control border focus:border-gray-12 addressSelect sl_common_bx" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                        <option value="">{{ __('Select City') }}</option>
                    </select>
                </div>
                <div class="lg:mb-3 mt-3.5">
                    <label class="mt-3p text-sm dm-sans font-medium capitalize text-gray-12 require-profile">
                        {{ __('Postcode') . ' / ' . __('ZIP') }}</label>
                    <input type="text" class="border-gray-2 rounded-sm w-full h-46p mt-1.5 lg:mt-1p roboto-medium pl-18p font-medium text-sm text-gray-10 form-control border focus:border-gray-12" name="post_code" required oninvalid="this.setCustomValidity('This field is required.')" value="{{ old('post_code') }}" placeholder="{{ __('Enter Your :x', ['x' => __('Postcode')]) }}">
                    @error('post_code')
                        <span class="password-validation-error block text-11 mt-1 text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="flex lg:mt-52p mt-9 mb-5">
                <div class="primary-bg-color w-2p mt-2p h-23p ltr:mr-2 rtl:ml-2"></div>
                <p class="text-gray-12 uppercase dm-bold font-bold lg:text-lg text-base">{{ __('Shop Details') }}</p>
            </div>
            <div class="mb-3">
                <label class="text-sm dm-sans font-medium capitalize text-gray-12 require-profile">{{ __('Shop Name') }}
                </label>
                <input class="border-gray-2 rounded-sm w-full mt-1.5 lg:mt-1p h-46p roboto-medium pl-18p font-medium text-sm text-gray-10 form-control focus:border-gray-12" type="text" name="shop_name" maxlength="191" required
                    oninvalid="this.setCustomValidity('This field is required.')" value="{{ old('shop_name') }}"
                    placeholder="{{ __('Enter Your :x', ['x' => __('Shop Name')]) }}">
                @error('shop_name')
                    <span class="password-validation-error block text-11 mt-1 text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="lg:mt-52p mt-10 mb-5 flex">
                <div class="primary-bg-color w-2p mt-2p h-23p ltr:mr-2 rtl:ml-2">
                </div>
                <p class="text-gray-12 uppercase dm-bold font-bold lg:text-lg text-base">{{ __('Account') }}</p>
            </div>
            <div class="grid lg:grid-cols-2 grid-cols-1 lg:gap-3 gap-0 lg:mt-5 mt-18p">
                <div class="w-full">
                    <div class="flex justify-between">
                        <label class="text-sm dm-sans font-medium capitalize text-gray-12 require-profile">
                            {{ __('Enter Password ') }} </label>
                        <div class="help-tip text-justify relative">
                            <p class="text-11 text-gray-10 roboto-medium font-medium px-3 bottom-2 right-5 py-2 border border-gray-2 rounded bg-gray-25 absolute"> {{ __('Passwors must be at least :x characters. Contain uppercase and lowercase letters, numbers and special characters.', ['x' => $length]) }}
                            </p>
                        </div>
                    </div>
                    <div class="mb-5 relative pass">
                        <input class="pass-field w-full border rounded-sm mt-2p border-gray-2 form-control h-46p roboto-regular font-normal text-gray-12 ltr:pr-11 rtl:pl-11 password-validation" type="password" name="password" id="password_seller" autocomplete="new-password">
                        <span class="pass-show toggle-password absolute top-3.5 h-4 ltr:right-1.5 ltr:pl-1.5 ltr:pr-3 rtl:left-1.5 rtl:pr-1.5 rtl:pl-3 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="19"
                                viewBox="0 0 22 19" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M19.9803 18.3977L3.07666 1.49408L4.57074 0L21.4743 16.9036L19.9803 18.3977Z" fill="#C8C8C8" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.9929 17.2707L14.4406 15.7184C13.4135 16.2565 12.3254 16.5941 11.2185 16.5941C9.60656 16.5941 8.03448 15.8782 6.63251 14.8696C5.2389 13.8669 4.1022 12.6384 3.38356 11.7659C3.27816 11.638 3.19943 11.5422 3.13422 11.458C3.08259 11.3914 3.04971 11.345 3.02826 11.3117C3.04971 11.2785 3.08259 11.232 3.13422 11.1654C3.19943 11.0812 3.27816 10.9854 3.38356 10.8575C4.08655 10.004 5.18959 8.80983 6.54184 7.81967L5.03242 6.31025C3.60813 7.39869 2.47352 8.63887 1.75261 9.51414C1.72769 9.54439 1.70172 9.5755 1.67499 9.60752L1.67497 9.60754C1.34384 10.0042 0.896484 10.54 0.896484 11.3117C0.896484 12.0834 1.34384 12.6192 1.67497 13.0159L1.6752 13.0161C1.70185 13.0481 1.72775 13.0791 1.75261 13.1093C2.53426 14.0583 3.80225 15.4363 5.39852 16.5847C6.98645 17.7272 8.98944 18.707 11.2185 18.707C12.9829 18.707 14.6055 18.0932 15.9929 17.2707ZM7.84501 4.6406C8.88436 4.20027 10.0187 3.91638 11.2185 3.91638C13.4476 3.91638 15.4506 4.89623 17.0385 6.03868C18.6348 7.18712 19.9028 8.56513 20.6845 9.51414C20.7094 9.54438 20.7353 9.57548 20.7621 9.60749L20.7621 9.60754C21.0932 10.0042 21.5406 10.54 21.5406 11.3117C21.5406 12.0834 21.0932 12.6192 20.7621 13.0159C20.7354 13.0479 20.7094 13.079 20.6845 13.1093C20.1703 13.7335 19.4458 14.5433 18.5558 15.3513L17.0597 13.8553C17.8837 13.1162 18.5651 12.3589 19.0535 11.7659C19.1589 11.638 19.2376 11.5422 19.3028 11.458C19.3545 11.3914 19.3874 11.345 19.4088 11.3117C19.3873 11.2784 19.3545 11.232 19.3028 11.1654C19.2376 11.0812 19.1589 10.9854 19.0535 10.8575C18.3349 9.98496 17.1982 8.7565 15.8045 7.75385C14.4026 6.7452 12.8305 6.02933 11.2185 6.02933C10.6364 6.02933 10.0595 6.12269 9.49389 6.28948L7.84501 4.6406Z" fill="#C8C8C8" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.3602 12.1556C15.4155 11.8829 15.4445 11.6007 15.4445 11.3117C15.4445 8.97781 13.5525 7.08582 11.2186 7.08582C10.9296 7.08582 10.6473 7.11483 10.3746 7.17009L15.3602 12.1556ZM7.69709 8.97478C7.25201 9.64413 6.99268 10.4476 6.99268 11.3117C6.99268 13.6456 8.88468 15.5376 11.2186 15.5376C12.0827 15.5376 12.8862 15.2783 13.5555 14.8332L11.9984 13.2761C11.7571 13.372 11.494 13.4247 11.2186 13.4247C10.0516 13.4247 9.10562 12.4787 9.10562 11.3117C9.10562 11.0363 9.15833 10.7732 9.25419 10.5319L7.69709 8.97478Z" fill="#C8C8C8" />
                            </svg>
                        </span>
                        <span class="pass-hide toggle-password absolute top-3.5 h-4 ltr:right-1.5 ltr:pl-1.5 ltr:pr-3 rtl:left-1.5 rtl:pr-1.5 rtl:pl-3 cursor-pointer hidden">
                            <svg class="mt-1.5" xmlns="http://www.w3.org/2000/svg" width="20" height="14" viewBox="0 0 20 14" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.77051 9C10.8751 9 11.7705 8.10457 11.7705 7C11.7705 5.89543 10.8751 5 9.77051 5C8.66594 5 7.77051 5.89543 7.77051 7C7.77051 8.10457 8.66594 9 9.77051 9ZM9.77051 11C11.9796 11 13.7705 9.20914 13.7705 7C13.7705 4.79086 11.9796 3 9.77051 3C7.56137 3 5.77051 4.79086 5.77051 7C5.77051 9.20914 7.56137 11 9.77051 11Z" fill="#898989" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.42941 3.63233C4.11029 4.58138 3.03435 5.74418 2.35413 6.57005C2.25436 6.69118 2.17984 6.78179 2.11811 6.86149C2.06925 6.92459 2.03813 6.96852 2.01782 7C2.03813 7.03148 2.06925 7.07541 2.11811 7.13851C2.17984 7.21821 2.25436 7.30882 2.35413 7.42995C3.03435 8.25582 4.11029 9.41862 5.42941 10.3677C6.75643 11.3224 8.24447 12 9.77027 12C11.2961 12 12.7841 11.3224 14.1111 10.3677C15.4303 9.41862 16.5062 8.25582 17.1864 7.42995C17.2862 7.30882 17.3607 7.21821 17.4224 7.13851C17.4713 7.07541 17.5024 7.03147 17.5227 7C17.5024 6.96852 17.4713 6.92458 17.4224 6.86149C17.3607 6.78179 17.2862 6.69118 17.1864 6.57005C16.5062 5.74418 15.4303 4.58138 14.1111 3.63233C12.7841 2.6776 11.2961 2 9.77027 2C8.24447 2 6.75643 2.6776 5.42941 3.63233ZM4.26138 2.00884C5.76442 0.927471 7.66034 0 9.77027 0C11.8802 0 13.7761 0.927472 15.2792 2.00885C16.7901 3.0959 17.9903 4.40025 18.7302 5.29853C18.7538 5.32717 18.7784 5.35662 18.8037 5.38694C19.1171 5.76236 19.5406 6.26957 19.5406 7C19.5406 7.73043 19.1171 8.23764 18.8037 8.61306C18.7784 8.64338 18.7538 8.67283 18.7302 8.70148C17.9903 9.59976 16.7901 10.9041 15.2792 11.9912C13.7761 13.0725 11.8802 14 9.77027 14C7.66034 14 5.76442 13.0725 4.26138 11.9912C2.75044 10.9041 1.55022 9.59975 0.810357 8.70147C0.786765 8.67283 0.762175 8.64338 0.736868 8.61306C0.423444 8.23764 -5.96046e-08 7.73043 0 7C0 6.26957 0.423445 5.76236 0.736869 5.38694C0.762176 5.35662 0.786766 5.32717 0.810358 5.29852C1.55022 4.40024 2.75044 3.0959 4.26138 2.00884Z" fill="#898989" />
                            </svg>
                        </span>
                        <span class="password-validation-error block text-11 mt-1 text-red-500"></span>
                        @error('password')
                            <span class="password-validation-error block text-11 mt-1 text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="w-full">
                    <label class="text-sm dm-sans font-medium capitalize text-gray-12 require-profile">{{ __('Repeat Password') }}
                    </label>
                    <input class="border-gray-2 mt-1.5 lg:mt-1p rounded-sm w-full h-46p roboto-medium pl-18p font-medium text-sm text-gray-10 form-control border focus:border-gray-12" type="password" name="password_confirmation" id="password_confirm" autocomplete="new-password_confirmation">
                    <span class="password-validation-match-error block text-11 mt-1"></span>
                </div>
            </div>
            <div class="flex justify-center items-center mb-8 lg:mt-10 mt-8">
                <button class="flex xl:mr-8 md:mx-0 process-goto relative mx-auto text-base w-52 transition duration-150 ease-in-out h-50p justify-center text-center rounded-sm 2 items-center bg-gray-12 primary-bg-hover dm-bold font-bold text-white hover:text-gray-12" onclick="formValidation()" id="btnSubmits">{{ __('Register') }}
                    <svg class="ltr:ml-1.5 rtl:mr-1.5 neg-transition-scale relative" xmlns="http://www.w3.org/2000/svg" width="13" height="8"
                        viewBox="0 0 13 8" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M8.92948 0L7.75346 1.20177L9.66016 3.15022H1.68894C1.22968 3.15022 0.857371 3.53068 0.857371 4C0.857371 4.46932 1.22968 4.84978 1.68894 4.84978H9.66016L7.75346 6.79823L8.92948 8L12.8438 4L8.92948 0Z"
                            fill="currentColor" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script>
        'use strict';
        var uppercase = "{!! $uppercase !!}";
        var lowercase = "{!! $lowercase !!}";
        var number = "{!! $number !!}";
        var symbol = "{!! $symbol !!}";
        var length = "{!! $length !!}";
        var oldCountry = "{!! old('country') ?? 'null' !!}";
        var oldState = "{!! old('state') ?? 'null' !!}";
        var oldCity = "{!! old('city') ?? 'null' !!}";
    </script>
    <script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('/public/dist/js/custom/site/seller.min.js') }}"></script>
    <!-- Sign Up Script -->
    @includeIf ('externalcode::layouts.scripts.signUpScript')
@endsection
