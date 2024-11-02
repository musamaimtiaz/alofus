<link rel="stylesheet" href="{{ asset('public/dist/css/intl-tel-input/intlTelInput.min.css') }}">

<!--Overlay Effect-->
<div class="fixed hidden items-center inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto z-50" id="my-modal">
    <!--modal content-->
    <div class="relative mx-5 md:mt-40 xl:mt-20 sm:mx-auto px-15p pb-5 md:py-8 md:px-31p md:pt-2 pt-0.5 border w-508px rounded-lg bg-white modal-h"
        id="modal-main">
        <div id="tabs" class="c-tabs mt-4">

            @php
                $customerSignup = preference('customer_signup');
                $refParam = preference('track_param') ?? null;

                if (isActive('Affiliate')) {
                    $refParam = empty($refParam) ? 'ref' : $refParam;
                }
            @endphp
            <div class="grid grid-cols-2 text-center text-gray-10 text-sm md:text-lg leading-6 mb-4">
                <div class="c-tabs-nav container-all login-active-border {{ !str_contains(Request::fullUrl(), '?'.$refParam) || str_contains(Request::fullUrl(), 'products') ? 'active-border' : '' }}">
                    <a href="javaScript:void(0);"
                        class="is-active block login-active dm-bold font-bold">{{ __('Sign In') }}</a>
                </div>
                @if ($customerSignup == '1')
                    <div class="c-tabs-nav container-all register-active-border {{ str_contains(Request::fullUrl(), '?'.$refParam) && !str_contains(Request::fullUrl(), 'products') ? 'active-border' : '' }}">
                        <a href="javaScript:void(0);"
                            class="register-active block dm-bold font-bold">{{ __('Sign Up') }}</a>
                        <div class="c-tab-nav-marker"></div>
                    </div>
                @endif
            </div>

            <div class="c-tab {{ !str_contains(Request::fullUrl(), '?'.$refParam) || str_contains(Request::fullUrl(), 'products') ? 'is-active' : '' }} mt-3 login-active">
                <div class="c-tab__content">
                    <div class="signin-form-container container-all">
                        <div class="login-message block relative">
                            <!-- login failed or successful message comimg from login js -->
                        </div>
                        <div class="display-none">
                            <span class="resend-contact-info"></span>
                            <div class="login-email-section">
                                <div class="md:mb-10 mb-6 relative">
                                    <input
                                        class="w-full border border-gray-2 rounded ltr:pl-14 ltr:md:pl-16 rtl:pr-14 rtl:md:pr-16 roboto-regular font-normal text-gray-10 text-13 md:text-15 md:h-52p focus:border-gray-12"
                                        type="email" name="email"
                                        placeholder="{{ __('Email Address') }}"
                                        data-type-mismatch="{{ __('Enter a valid :x.', ['x' => strtolower(__('Email'))]) }}">
                                    <span
                                        class="absolute border-gray-2 top-2 h-26p md:top-3 md:h-30p ltr:border-r ltr:md:left-3 ltr:left-2 ltr:pl-1.5 ltr:pr-3 rtl:border-l rtl:md:right-3 rtl:right-2 rtl:pr-1.5 rtl:pl-3">
                                        <svg class="mt-1.5 w-4 h-4 md:w-5 md:h-5" xmlns="http://www.w3.org/2000/svg"
                                            width="18" height="19" viewBox="0 0 18 19" fill="none">
                                            <path
                                                d="M16.3449 17.4054C16.8977 17.2902 17.2269 16.7117 16.9522 16.2183C16.3466 15.1307 15.3926 14.1749 14.1722 13.4465C12.6004 12.5085 10.6745 12 8.69333 12C6.71213 12 4.78628 12.5085 3.21448 13.4465C1.99405 14.1749 1.04002 15.1307 0.434441 16.2183C0.159743 16.7117 0.488979 17.2902 1.04179 17.4054C6.0886 18.4572 11.2981 18.4572 16.3449 17.4054Z"
                                                fill="#898989" />
                                            <circle cx="8.69336" cy="5" r="5" fill="#898989" />
                                        </svg>
                                    </span>
                                    <div>
                                        @if (preference('user_login', 'both') == 'both')
                                            <span class="enable-login-phone-section cursor-pointer float-right roboto-medium font-medium text-gray-10 hover:text-gray-12 text-11 md:text-sm mt-1">{{ __('Use Phone Instead') }}</span>
                                        @endif
                                        <span class="signin-message"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="login-phone-section">
                                <div class="md:mb-10 mb-6 relative">
                                    <input
                                        class="w-full border border-gray-2 rounded ltr:pl-14 ltr:md:pl-16 rtl:pr-14 rtl:md:pr-16 roboto-regular font-normal text-gray-10 text-13 md:text-15 md:h-52p focus:border-gray-12"
                                        type="text" name="phone">
                                    @if (preference('user_login', 'both') == 'both')
                                        <span class="enable-login-email-section cursor-pointer float-right roboto-medium font-medium text-gray-10 hover:text-gray-12 text-11 md:text-sm mt-1">{{ __('Use Email Instead') }}</span>
                                    @endif
                                    <span class="signin-message"></span>
                                </div>
                            </div>
                        </div>
                        <form method="post" id="loginForm">
                            @csrf
                            <div class="phone-email-box">
                                @if(preference('user_login') == 'phone')
                                    <div class="need-login-phone-section"></div>
                                @else
                                    <div class="need-login-email-section"></div>
                                @endif
                            </div>
                            <div class="mb-2 md:mb-3 relative password-container">
                                <input
                                    class="password-field w-full border border-gray-2 rounded form-control ltr:pl-14 ltr:md:pl-16 rtl:pr-14 rtl:md:pr-16 roboto-regular font-normal text-gray-10 text-13 md:text-15 md:h-52p focus:border-gray-12"
                                    type="password" name="password" id="login-password"
                                    placeholder="{{ __('Password') }}" required
                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                <span
                                    class="absolute border-gray-2 top-2 h-26p md:top-3 md:h-30p ltr:border-r ltr:md:left-3 ltr:left-2 ltr:pl-1.5 ltr:pr-3 rtl:border-l rtl:md:right-3 rtl:right-2 rtl:pr-1.5 rtl:pl-3">
                                    <svg class="mt-1 w-4 h-4 md:w-5 md:h-5" xmlns="http://www.w3.org/2000/svg"
                                        width="18" height="20" viewBox="0 0 18 20" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M4 5C4 2.23858 6.23858 0 9 0C11.7614 0 14 2.23858 14 5V6C14 6.55228 13.5523 7 13 7C12.4477 7 12 6.55228 12 6V5C12 3.34315 10.6569 2 9 2C7.34315 2 6 3.34315 6 5V6C6 6.55228 5.55228 7 5 7C4.44772 7 4 6.55228 4 6V5Z"
                                            fill="#898989" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0.87868 5.87868C0 6.75736 0 8.17157 0 11V12C0 15.7712 0 17.6569 1.17157 18.8284C2.34315 20 4.22876 20 8 20H10C13.7712 20 15.6569 20 16.8284 18.8284C18 17.6569 18 15.7712 18 12V11C18 8.17157 18 6.75736 17.1213 5.87868C16.2426 5 14.8284 5 12 5H6C3.17157 5 1.75736 5 0.87868 5.87868ZM9 13C9.55228 13 10 12.5523 10 12C10 11.4477 9.55228 11 9 11C8.44772 11 8 11.4477 8 12C8 12.5523 8.44772 13 9 13ZM12 12C12 13.3062 11.1652 14.4175 10 14.8293V17H8V14.8293C6.83481 14.4175 6 13.3062 6 12C6 10.3431 7.34315 9 9 9C10.6569 9 12 10.3431 12 12Z"
                                            fill="#898989" />
                                    </svg>
                                </span>
                                <span class="password-hide absolute top-3 h-8 cursor-pointer ltr:pl-1.5 ltr:pr-3 ltr:right-1.5 rtl:pr-1.5 rtl:pl-3 rtl:left-1.5">
                                    <svg class="md:mt-1 h-4 md:h-5" xmlns="http://www.w3.org/2000/svg" width="22"
                                        height="19" viewBox="0 0 22 19" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M19.9803 18.3977L3.07666 1.49408L4.57074 0L21.4743 16.9036L19.9803 18.3977Z"
                                            fill="#C8C8C8" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M15.9929 17.2707L14.4406 15.7184C13.4135 16.2565 12.3254 16.5941 11.2185 16.5941C9.60656 16.5941 8.03448 15.8782 6.63251 14.8696C5.2389 13.8669 4.1022 12.6384 3.38356 11.7659C3.27816 11.638 3.19943 11.5422 3.13422 11.458C3.08259 11.3914 3.04971 11.345 3.02826 11.3117C3.04971 11.2785 3.08259 11.232 3.13422 11.1654C3.19943 11.0812 3.27816 10.9854 3.38356 10.8575C4.08655 10.004 5.18959 8.80983 6.54184 7.81967L5.03242 6.31025C3.60813 7.39869 2.47352 8.63887 1.75261 9.51414C1.72769 9.54439 1.70172 9.5755 1.67499 9.60752L1.67497 9.60754C1.34384 10.0042 0.896484 10.54 0.896484 11.3117C0.896484 12.0834 1.34384 12.6192 1.67497 13.0159L1.6752 13.0161C1.70185 13.0481 1.72775 13.0791 1.75261 13.1093C2.53426 14.0583 3.80225 15.4363 5.39852 16.5847C6.98645 17.7272 8.98944 18.707 11.2185 18.707C12.9829 18.707 14.6055 18.0932 15.9929 17.2707ZM7.84501 4.6406C8.88436 4.20027 10.0187 3.91638 11.2185 3.91638C13.4476 3.91638 15.4506 4.89623 17.0385 6.03868C18.6348 7.18712 19.9028 8.56513 20.6845 9.51414C20.7094 9.54438 20.7353 9.57548 20.7621 9.60749L20.7621 9.60754C21.0932 10.0042 21.5406 10.54 21.5406 11.3117C21.5406 12.0834 21.0932 12.6192 20.7621 13.0159C20.7354 13.0479 20.7094 13.079 20.6845 13.1093C20.1703 13.7335 19.4458 14.5433 18.5558 15.3513L17.0597 13.8553C17.8837 13.1162 18.5651 12.3589 19.0535 11.7659C19.1589 11.638 19.2376 11.5422 19.3028 11.458C19.3545 11.3914 19.3874 11.345 19.4088 11.3117C19.3873 11.2784 19.3545 11.232 19.3028 11.1654C19.2376 11.0812 19.1589 10.9854 19.0535 10.8575C18.3349 9.98496 17.1982 8.7565 15.8045 7.75385C14.4026 6.7452 12.8305 6.02933 11.2185 6.02933C10.6364 6.02933 10.0595 6.12269 9.49389 6.28948L7.84501 4.6406Z"
                                            fill="#C8C8C8" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M15.3602 12.1556C15.4155 11.8829 15.4445 11.6007 15.4445 11.3117C15.4445 8.97781 13.5525 7.08582 11.2186 7.08582C10.9296 7.08582 10.6473 7.11483 10.3746 7.17009L15.3602 12.1556ZM7.69709 8.97478C7.25201 9.64413 6.99268 10.4476 6.99268 11.3117C6.99268 13.6456 8.88468 15.5376 11.2186 15.5376C12.0827 15.5376 12.8862 15.2783 13.5555 14.8332L11.9984 13.2761C11.7571 13.372 11.494 13.4247 11.2186 13.4247C10.0516 13.4247 9.10562 12.4787 9.10562 11.3117C9.10562 11.0363 9.15833 10.7732 9.25419 10.5319L7.69709 8.97478Z"
                                            fill="#C8C8C8" />
                                    </svg>
                                </span>
                                <span
                                    class="password-show absolute top-11p h-8 cursor-pointer hidden ltr:pl-1.5 ltr:pr-3 ltr:right-1.5 rtl:pr-1.5 rtl:pl-3 rtl:left-1.5">
                                    <svg class="mt-5p md:mt-2.5 h-3 md:h-3.5" xmlns="http://www.w3.org/2000/svg"
                                        width="20" height="14" viewBox="0 0 20 14" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M9.77051 9C10.8751 9 11.7705 8.10457 11.7705 7C11.7705 5.89543 10.8751 5 9.77051 5C8.66594 5 7.77051 5.89543 7.77051 7C7.77051 8.10457 8.66594 9 9.77051 9ZM9.77051 11C11.9796 11 13.7705 9.20914 13.7705 7C13.7705 4.79086 11.9796 3 9.77051 3C7.56137 3 5.77051 4.79086 5.77051 7C5.77051 9.20914 7.56137 11 9.77051 11Z"
                                            fill="#898989" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M5.42941 3.63233C4.11029 4.58138 3.03435 5.74418 2.35413 6.57005C2.25436 6.69118 2.17984 6.78179 2.11811 6.86149C2.06925 6.92459 2.03813 6.96852 2.01782 7C2.03813 7.03148 2.06925 7.07541 2.11811 7.13851C2.17984 7.21821 2.25436 7.30882 2.35413 7.42995C3.03435 8.25582 4.11029 9.41862 5.42941 10.3677C6.75643 11.3224 8.24447 12 9.77027 12C11.2961 12 12.7841 11.3224 14.1111 10.3677C15.4303 9.41862 16.5062 8.25582 17.1864 7.42995C17.2862 7.30882 17.3607 7.21821 17.4224 7.13851C17.4713 7.07541 17.5024 7.03147 17.5227 7C17.5024 6.96852 17.4713 6.92458 17.4224 6.86149C17.3607 6.78179 17.2862 6.69118 17.1864 6.57005C16.5062 5.74418 15.4303 4.58138 14.1111 3.63233C12.7841 2.6776 11.2961 2 9.77027 2C8.24447 2 6.75643 2.6776 5.42941 3.63233ZM4.26138 2.00884C5.76442 0.927471 7.66034 0 9.77027 0C11.8802 0 13.7761 0.927472 15.2792 2.00885C16.7901 3.0959 17.9903 4.40025 18.7302 5.29853C18.7538 5.32717 18.7784 5.35662 18.8037 5.38694C19.1171 5.76236 19.5406 6.26957 19.5406 7C19.5406 7.73043 19.1171 8.23764 18.8037 8.61306C18.7784 8.64338 18.7538 8.67283 18.7302 8.70148C17.9903 9.59976 16.7901 10.9041 15.2792 11.9912C13.7761 13.0725 11.8802 14 9.77027 14C7.66034 14 5.76442 13.0725 4.26138 11.9912C2.75044 10.9041 1.55022 9.59975 0.810357 8.70147C0.786765 8.67283 0.762175 8.64338 0.736868 8.61306C0.423444 8.23764 -5.96046e-08 7.73043 0 7C0 6.26957 0.423445 5.76236 0.736869 5.38694C0.762176 5.35662 0.786766 5.32717 0.810358 5.29852C1.55022 4.40024 2.75044 3.0959 4.26138 2.00884Z"
                                            fill="#898989" />
                                    </svg>
                                </span>
                            </div>
                            <div class="md:mb-4 md:mt-4 flex justify-between">
                                <div class="form-check">
                                    <input id="flexCheckDefault"
                                        class="form-check-input md:-mt-0.5 ltr:mr-1 rtl:ml-1 neg-transition-scale h-3 w-3 md:h-3.5 md:w-3.5 border text-gray-12 border-gray-10 form-checkbox cursor-pointer"
                                        type="checkbox" name="remember_me">
                                    <label
                                        class="form-check-label roboto-medium font-medium text-gray-10 hover:text-gray-12 cursor-pointer text-11 md:text-sm"
                                        for="flexCheckDefault">{{ __('Remember Me') }}</label>
                                </div>
                                <div>
                                    <span
                                        class="forgot-pass roboto-medium font-medium text-gray-10 hover:text-gray-12 text-11 md:text-sm cursor-pointer">{{ __('Forgot password?') }}</span>
                                </div>
                            </div>
                            @if (isRecaptchaActive())
                                <div class="mb-3 mt-3 md:mt-0">
                                    {!! NoCaptcha::renderJs() !!}
                                    {!! NoCaptcha::display() !!}
                                    <span class="text-red-500 text-xs md:text-sm login-captcha-error-message"></span>
                                </div>
                            @endif
                            <div class="mb-4 md:mt-5 mt-3">
                                <button id="signin-user"
                                    class="bg-gray-12 text-white text-sm md:text-lg leading-6 dm-sans text-center w-full p-2 py-2 md:py-3 rounded transition ease-in-out duration-200 primary-bg-hover hover:text-gray-12 h-10 md:h-52p">
                                    <span class="signin-text"> {{ strtoupper(__('Sign In')) }}</span>
                                    <div class="hidden login-modal-loader">
                                        <svg class="h-4 w-4 md:h-6 md:w-6 loading-spinner" width="80"
                                            height="80" viewBox="0 0 80 80" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <circle class="loading-circle-large" cx="40" cy="40"
                                                r="36" stroke="#2c2c2c" stroke-width="8" />
                                        </svg>
                                    </div>
                                </button>
                            </div>
                            @if (config('martvill.is_demo'))
                                <div class="md:mt-18p text-lg flex items-center">
                                    <hr class="border border-gray-2 w-full">

                                    <p
                                        class="roboto-regular text-gray-10 text-center text-sm md:text-base px-3 md:px-5 leading-5 whitespace-nowrap">
                                        {{ __('Sign in with demo account') }}</p>

                                    <hr class="border border-gray-2 w-full">
                                </div>
                                <div class="flex gap-2.5 justify-center md:justify-between md:my-5 my-4">

                                    <a href="javascript:void(0)" data-type="admin"
                                        class="flex justify-center items-center rounded px-2 md:px-40p transition ease-in-out duration-200 bg-gray-12 primary-bg-hover one-click-login hover:text-gray-12 dm-sans text-xs md:text-lg leading-6 text-white  py-1 md:py-3 relative">{{ __('Admin') }}
                                    </a>

                                    <a href="javascript:void(0)" data-type="customer"
                                        class="flex justify-center items-center px-2 md:px-7 rounded transition ease-in-out duration-200 bg-gray-12 primary-bg-hover one-click-login dm-sans text-xs md:text-lg leading-6 text-white hover:text-gray-12 py-2 md:py-3 relative">{{ __('Customer') }}
                                    </a>

                                    <a href="javascript:void(0)" data-type="vendor"
                                        class="flex justify-center items-center rounded px-2 md:px-40p transition ease-in-out duration-200 bg-gray-12 primary-bg-hover  one-click-login hover:text-gray-12 dm-sans text-xs md:text-lg leading-6 text-white  py-2 md:py-3 relative">{{ __('Vendor') }}
                                    </a>
                                </div>
                            @endif
                            @php
                                $preference = json_decode(preference('sso_service'));
                            @endphp
                            @if (is_array($preference) && count($preference) > 0)
                                <div class="md:mt-18p text-lg flex items-center">
                                    <hr class="border border-gray-2 w-full">

                                    <p
                                        class="roboto-regular text-gray-10 text-center text-sm md:text-base px-3 md:px-5 leading-5 whitespace-nowrap">
                                        {{ __('Sign in with other account') }}</p>

                                    <hr class="border border-gray-2 w-full">
                                </div>
                                <div
                                    class="flex  gap-x-2.5 md:gap-x-5 justify-center md:justify-between md:mt-5 mt-4">
                                    @if (in_array('Google', $preference))
                                        <a href="{{ route('login.google') }}"
                                            class="flex justify-center items-center rounded px-2 md:px-65p transition ease-in-out duration-200 bg-reds-1 hover:bg-reds-4 w-212px">
                                            <span class="ltr:mr-1.5 ltr:md:mr-2.5 rtl:ml-1.5 rtl:md:ml-2.5">
                                                <svg class="h-3 md:h-4 md:w-4 neg-transition-scale" xmlns="http://www.w3.org/2000/svg"
                                                    width="16" height="16" viewBox="0 0 16 16"
                                                    fill="none">
                                                    <path
                                                        d="M7.86666 6.26667V9.6H12.4C11.7333 11.4 10 12.6 8 12.6C5.4 12.6 3.33333 10.5333 3.33333 7.93333C3.33333 5.33333 5.4 3.26667 8 3.26667C9 3.26667 9.93334 3.6 10.7333 4.13333L11 4.33333L13 1.73333L12.7333 1.53333C11.3333 0.533333 9.73333 0 8 0C3.6 0 0 3.6 0 8C0 12.4 3.6 16 8 16C12.4 16 16 12.4 16 8V6.33333H7.86666V6.26667Z"
                                                        fill="white" />
                                                </svg>
                                            </span>
                                            <span
                                                class="roboto-regular text-xs md:text-lg leading-5 text-white py-2 md:py-3 relative rounded">
                                                {{ __('Google') }}
                                            </span>
                                        </a>
                                    @endif
                                    @if (in_array('Facebook', $preference))
                                        <a href="{{ route('login.facebook') }}"
                                            class="flex justify-center items-center px-2 md:px-16 rounded transition ease-in-out duration-200 bg-blues-2 hover:bg-blues-3 w-212px">
                                            <span class="ltr:mr-1.5 ltr:md:mr-2.5 rtl:ml-1.5 rtl:md:ml-2.5">
                                                <svg class="h-3 md:h-4 neg-transition-scale" xmlns="http://www.w3.org/2000/svg"
                                                    width="9" height="17" viewBox="0 0 9 17" fill="none">
                                                    <path
                                                        d="M5.84172 16.9999V9.2454H8.4952L8.89246 6.22333H5.84172V4.29384C5.84172 3.4189 6.08944 2.82258 7.3686 2.82258L9 2.82184V0.118952C8.71772 0.0822564 7.74938 0 6.62277 0C4.27066 0 2.66034 1.40829 2.66034 3.99469V6.22342H0V9.24548H2.66026V17L5.84172 16.9999Z"
                                                        fill="white" />
                                                </svg>
                                            </span>
                                            <span
                                                class="roboto-regular text-xs md:text-lg leading-5 text-white py-2 md:py-3 relative rounded">
                                                {{ __('Facebook') }}
                                            </span>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </form>
                    </div>

                    <div class="send-email-form-container container-all hidden">
                        <div id="send-email-form" class="form">
                            <div class="text-center -mt-2">
                                <h1 class="uppercase dm-bold font-bold text-gray-12 text-base md:text-xl">
                                    {{ __('Reset your password') }}</h1>
                                <p class="text-gray-10 text-sm md:text-base mt-1">
                                    {{ __('Enter your email or phone to send password reset code') }}</p>
                            </div>
                            
                            <div class="reset-phone-email-box pb-3">
                                {{-- Data will load here by JS --}}
                            </div>
                            
                            <div
                                class="send-btn bg-gray-12 text-white text-sm md:text-lg leading-6 dm-sans text-center w-full p-2 py-2 md:py-3 rounded transition ease-in-out duration-200 primary-bg-hover hover:text-gray-12 h-10 md:h-52p cursor-pointer">
                                <span> {{ strtoupper(__('Send')) }}</span>
                                <div class="hidden reset-modal-loader">
                                    <svg class="h-4 w-4 md:h-6 md:w-6 loading-spinner" width="80"
                                        height="80" viewBox="0 0 80 80" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <circle class="loading-circle-large" cx="40" cy="40"
                                            r="36" stroke="#2c2c2c" stroke-width="8" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-center mt-5 text-sm md:text-base text-gray-10 roboto-medium font-medium">
                                {!! __('Back to :x', ['x' => '<span class="text-gray-12 cursor-pointer back-signIn">' . __('Sign in') . '</span>']) !!}
                            </p>
                        </div>
                    </div>

                    <div class="reset-otp-form-container container-all hidden">
                        <form id="reset-otp-form">
                            <div class="-mt-2">
                                <h1 class="text-center uppercase dm-bold font-bold text-gray-12 text-base md:text-xl">
                                    {{ __('ENTER OTP CODE') }}</h1>
                                <div
                                    class="semi-primary-bg-color border primary-border-color primary-text-color py-3 mt-6 px-4 md:px-10 roboto-medium text-sm md:text-base text-center">
                                    <p>{!! __('A 4 digit code has been sent to :x', ['x' => '<span class="email"></span>']) !!}</p>
                                    <p>{{ __('Please use the OTP code below.') }}</p>
                                </div>
                            </div>
                            <div class="mt-9 text-center">
                                @php
                                    $optClasses = "otp-input otp-input-reset w-10 h-10 md:w-14 md:h-14 border border-gray-2 focus:border-gray-12 rounded  md:text-lg text-gray-10 ltr:mr-3 ltr:md:mr-6 ltr:md:pl-6 rtl:ml-3 rtl:md:ml-6 rtl:md:pr-6 roboto-medium font-medium ";
                                @endphp
                                <input class="{{ $optClasses }}" type="text" maxlength=1>
                                <input class="{{ $optClasses }}" type="text" maxlength=1>
                                <input class="{{ $optClasses }}" type="text" maxlength=1>
                                <input class="{{ $optClasses }}" type="text" maxlength=1>
                            </div>
                            <label class="text-red-400 text-center mt-2 block reset-otp-form-msg"></label>
                            <div class="mt-30p text-center dm-sans font-medium text-sm md:text-base text-gray-10">
                                <p>{{ __("Didn't receive the code yet?") }}</p>
                                <a
                                    class="underline cursor-pointer text-gray-12 resend-code-main resend-code">{{ __('Resend Code') }}</a>
                            </div>
                            <div class="mt-26p">
                                <div
                                    class="reset-password-btn bg-gray-12 text-white text-sm md:text-lg leading-6 dm-sans text-center w-full p-2 py-2 md:py-3 rounded transition ease-in-out duration-200 primary-bg-hover hover:text-gray-12 h-10 md:h-52p cursor-pointer">
                                    <span> {{ strtoupper(__('Reset Password')) }}</span>
                                    <div class="hidden otp-modal-loader">
                                        <svg class="h-4 w-4 md:h-6 md:w-6 loading-spinner" width="80"
                                            height="80" viewBox="0 0 80 80" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <circle class="loading-circle-large" cx="40" cy="40"
                                                r="36" stroke="#2c2c2c" stroke-width="8" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <p class="text-center mt-5 text-base text-gray-10 roboto-medium font-medium">
                                {!! __('Back to :x', [
                                    'x' => '<span class="text-gray-12 cursor-pointer back-signIn">' . __('Sign in') . '</span>',
                                ]) !!}</p>
                        </form>
                    </div>

                    <div class="user-verification-form-container container-all hidden">
                        <form id="user-verification-form">
                            <div class="-mt-2">
                                <h1 class="text-center uppercase dm-bold font-bold text-gray-12 text-base md:text-xl">
                                    {{ __('ENTER OTP CODE') }}</h1>
                                <div
                                    class="semi-primary-bg-color border primary-border-color primary-text-color py-3 mt-6 px-4 md:px-10 roboto-medium text-sm md:text-base text-center">
                                    <p>{!! __('A 4 digit code has been sent to :x', ['x' => '<span class="verification-email"></span>']) !!}</p>
                                    <p>{{ __('Please use the OTP code below.') }}</p>
                                </div>
                            </div>
                            <div class="mt-9 text-center">
                                @php
                                    $optClasses = "otp-input otp-input-verification w-10 h-10 md:w-14 md:h-14 ltr:mr-3 ltr:md:mr-6 ltr:md:pl-6 rtl:ml-3 rtl:md:ml-6 rtl:md:pr-6border border-gray-2 focus:border-gray-12 rounded md:text-lg text-gray-10 roboto-medium font-medium";
                                @endphp
                                <input class="{{ $optClasses }}" type="text" maxlength=1>
                                <input class="{{ $optClasses }}" type="text" maxlength=1>
                                <input class="{{ $optClasses }}" type="text" maxlength=1>
                                <input class="{{ $optClasses }}" type="text" maxlength=1>
                            </div>
                            <label class="text-red-400 text-center mt-2 block verification-otp-form-msg"></label>
                            <div class="mt-30p text-center dm-sans font-medium text-sm md:text-base text-gray-10">
                                <p>{{ __("Didn't receive the code yet?") }}</p>
                                <a
                                    class="underline cursor-pointer text-gray-12 resend-verification-code-main resend-verification-code">{{ __('Resend Code') }}</a>
                            </div>
                            <div class="mt-26p">
                                <div
                                    class="user-verification-btn bg-gray-12 text-white text-sm md:text-lg leading-6 dm-sans text-center w-full p-2 py-2 md:py-3 rounded transition ease-in-out duration-200 primary-bg-hover hover:text-gray-12 h-10 md:h-52p cursor-pointer">
                                    <span> {{ strtoupper(__('Verify Account')) }}</span>
                                    <div class="hidden verification-modal-loader">
                                        <svg class="h-4 w-4 md:h-6 md:w-6 loading-spinner" width="80"
                                            height="80" viewBox="0 0 80 80" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <circle class="loading-circle-large" cx="40" cy="40"
                                                r="36" stroke="#2c2c2c" stroke-width="8" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <p class="text-center mt-5 text-base text-gray-10 roboto-medium font-medium">
                                {!! __('Back to :x', [
                                    'x' => '<span class="text-gray-12 cursor-pointer back-signIn">' . __('Sign in') . '</span>',
                                ]) !!}</p>
                        </form>
                    </div>

                    <div class="confirm-password-form-container container-all password-match hidden">
                        <form id="confirm-password-form">
                            <div class="text-center -mt-2">
                                <h1 class="uppercase dm-bold font-bold text-gray-12 text-xl">
                                    {{ __('Set New Password') }}</h1>
                            </div>
                            <div class="mb-2 md:mb-3 relative password-container mt-6">
                                @csrf
                                <input type="hidden" name="id">
                                <input type="hidden" name="token">
                                <input
                                    class="password password-field w-full border border-gray-2 rounded form-control  ltr:pl-14 ltr:md:pl-16 rtl:pr-14 rtl:md:pr-16 roboto-regular font-normal text-gray-10 text-13 md:text-15 md:h-52p focus:border-gray-12"
                                    type="password" name="password" id="password-reset-validation"
                                    placeholder="{{ __('Enter New Password') }}" required
                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                <span
                                    class="absolute border-gray-2 top-2 h-26p md:top-3 md:h-30p ltr:border-r ltr:md:left-3 ltr:left-2 ltr:pl-1.5 ltr:pr-3 rtl:border-l rtl:md:right-3 rtl:right-2 rtl:pr-1.5 rtl:pl-3">
                                    <svg class="mt-1 w-4 h-4 md:w-5 md:h-5" xmlns="http://www.w3.org/2000/svg"
                                        width="18" height="20" viewBox="0 0 18 20" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M4 5C4 2.23858 6.23858 0 9 0C11.7614 0 14 2.23858 14 5V6C14 6.55228 13.5523 7 13 7C12.4477 7 12 6.55228 12 6V5C12 3.34315 10.6569 2 9 2C7.34315 2 6 3.34315 6 5V6C6 6.55228 5.55228 7 5 7C4.44772 7 4 6.55228 4 6V5Z"
                                            fill="#898989" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0.87868 5.87868C0 6.75736 0 8.17157 0 11V12C0 15.7712 0 17.6569 1.17157 18.8284C2.34315 20 4.22876 20 8 20H10C13.7712 20 15.6569 20 16.8284 18.8284C18 17.6569 18 15.7712 18 12V11C18 8.17157 18 6.75736 17.1213 5.87868C16.2426 5 14.8284 5 12 5H6C3.17157 5 1.75736 5 0.87868 5.87868ZM9 13C9.55228 13 10 12.5523 10 12C10 11.4477 9.55228 11 9 11C8.44772 11 8 11.4477 8 12C8 12.5523 8.44772 13 9 13ZM12 12C12 13.3062 11.1652 14.4175 10 14.8293V17H8V14.8293C6.83481 14.4175 6 13.3062 6 12C6 10.3431 7.34315 9 9 9C10.6569 9 12 10.3431 12 12Z"
                                            fill="#898989" />
                                    </svg>
                                </span>
                                <span class="password-hide absolute top-3 right-1.5 h-8 ltr:pl-1.5 ltr:pr-3 ltr:right-1.5 rtl:pr-1.5 rtl:pl-3 rtl:left-1.5 cursor-pointer">
                                    <svg class="md:mt-1 h-4 md:h-5" xmlns="http://www.w3.org/2000/svg" width="22"
                                        height="19" viewBox="0 0 22 19" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M19.9803 18.3977L3.07666 1.49408L4.57074 0L21.4743 16.9036L19.9803 18.3977Z"
                                            fill="#C8C8C8" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M15.9929 17.2707L14.4406 15.7184C13.4135 16.2565 12.3254 16.5941 11.2185 16.5941C9.60656 16.5941 8.03448 15.8782 6.63251 14.8696C5.2389 13.8669 4.1022 12.6384 3.38356 11.7659C3.27816 11.638 3.19943 11.5422 3.13422 11.458C3.08259 11.3914 3.04971 11.345 3.02826 11.3117C3.04971 11.2785 3.08259 11.232 3.13422 11.1654C3.19943 11.0812 3.27816 10.9854 3.38356 10.8575C4.08655 10.004 5.18959 8.80983 6.54184 7.81967L5.03242 6.31025C3.60813 7.39869 2.47352 8.63887 1.75261 9.51414C1.72769 9.54439 1.70172 9.5755 1.67499 9.60752L1.67497 9.60754C1.34384 10.0042 0.896484 10.54 0.896484 11.3117C0.896484 12.0834 1.34384 12.6192 1.67497 13.0159L1.6752 13.0161C1.70185 13.0481 1.72775 13.0791 1.75261 13.1093C2.53426 14.0583 3.80225 15.4363 5.39852 16.5847C6.98645 17.7272 8.98944 18.707 11.2185 18.707C12.9829 18.707 14.6055 18.0932 15.9929 17.2707ZM7.84501 4.6406C8.88436 4.20027 10.0187 3.91638 11.2185 3.91638C13.4476 3.91638 15.4506 4.89623 17.0385 6.03868C18.6348 7.18712 19.9028 8.56513 20.6845 9.51414C20.7094 9.54438 20.7353 9.57548 20.7621 9.60749L20.7621 9.60754C21.0932 10.0042 21.5406 10.54 21.5406 11.3117C21.5406 12.0834 21.0932 12.6192 20.7621 13.0159C20.7354 13.0479 20.7094 13.079 20.6845 13.1093C20.1703 13.7335 19.4458 14.5433 18.5558 15.3513L17.0597 13.8553C17.8837 13.1162 18.5651 12.3589 19.0535 11.7659C19.1589 11.638 19.2376 11.5422 19.3028 11.458C19.3545 11.3914 19.3874 11.345 19.4088 11.3117C19.3873 11.2784 19.3545 11.232 19.3028 11.1654C19.2376 11.0812 19.1589 10.9854 19.0535 10.8575C18.3349 9.98496 17.1982 8.7565 15.8045 7.75385C14.4026 6.7452 12.8305 6.02933 11.2185 6.02933C10.6364 6.02933 10.0595 6.12269 9.49389 6.28948L7.84501 4.6406Z"
                                            fill="#C8C8C8" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M15.3602 12.1556C15.4155 11.8829 15.4445 11.6007 15.4445 11.3117C15.4445 8.97781 13.5525 7.08582 11.2186 7.08582C10.9296 7.08582 10.6473 7.11483 10.3746 7.17009L15.3602 12.1556ZM7.69709 8.97478C7.25201 9.64413 6.99268 10.4476 6.99268 11.3117C6.99268 13.6456 8.88468 15.5376 11.2186 15.5376C12.0827 15.5376 12.8862 15.2783 13.5555 14.8332L11.9984 13.2761C11.7571 13.372 11.494 13.4247 11.2186 13.4247C10.0516 13.4247 9.10562 12.4787 9.10562 11.3117C9.10562 11.0363 9.15833 10.7732 9.25419 10.5319L7.69709 8.97478Z"
                                            fill="#C8C8C8" />
                                    </svg>
                                </span>
                                <span
                                    class="password-show absolute top-11p ltr:pl-1.5 ltr:pr-3 ltr:right-1.5 rtl:pr-1.5 rtl:pl-3 rtl:left-1.5 cursor-pointer hidden">
                                    <svg class="mt-5p md:mt-2.5 h-3 md:h-3.5" xmlns="http://www.w3.org/2000/svg"
                                        width="20" height="14" viewBox="0 0 20 14" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M9.77051 9C10.8751 9 11.7705 8.10457 11.7705 7C11.7705 5.89543 10.8751 5 9.77051 5C8.66594 5 7.77051 5.89543 7.77051 7C7.77051 8.10457 8.66594 9 9.77051 9ZM9.77051 11C11.9796 11 13.7705 9.20914 13.7705 7C13.7705 4.79086 11.9796 3 9.77051 3C7.56137 3 5.77051 4.79086 5.77051 7C5.77051 9.20914 7.56137 11 9.77051 11Z"
                                            fill="#898989" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M5.42941 3.63233C4.11029 4.58138 3.03435 5.74418 2.35413 6.57005C2.25436 6.69118 2.17984 6.78179 2.11811 6.86149C2.06925 6.92459 2.03813 6.96852 2.01782 7C2.03813 7.03148 2.06925 7.07541 2.11811 7.13851C2.17984 7.21821 2.25436 7.30882 2.35413 7.42995C3.03435 8.25582 4.11029 9.41862 5.42941 10.3677C6.75643 11.3224 8.24447 12 9.77027 12C11.2961 12 12.7841 11.3224 14.1111 10.3677C15.4303 9.41862 16.5062 8.25582 17.1864 7.42995C17.2862 7.30882 17.3607 7.21821 17.4224 7.13851C17.4713 7.07541 17.5024 7.03147 17.5227 7C17.5024 6.96852 17.4713 6.92458 17.4224 6.86149C17.3607 6.78179 17.2862 6.69118 17.1864 6.57005C16.5062 5.74418 15.4303 4.58138 14.1111 3.63233C12.7841 2.6776 11.2961 2 9.77027 2C8.24447 2 6.75643 2.6776 5.42941 3.63233ZM4.26138 2.00884C5.76442 0.927471 7.66034 0 9.77027 0C11.8802 0 13.7761 0.927472 15.2792 2.00885C16.7901 3.0959 17.9903 4.40025 18.7302 5.29853C18.7538 5.32717 18.7784 5.35662 18.8037 5.38694C19.1171 5.76236 19.5406 6.26957 19.5406 7C19.5406 7.73043 19.1171 8.23764 18.8037 8.61306C18.7784 8.64338 18.7538 8.67283 18.7302 8.70148C17.9903 9.59976 16.7901 10.9041 15.2792 11.9912C13.7761 13.0725 11.8802 14 9.77027 14C7.66034 14 5.76442 13.0725 4.26138 11.9912C2.75044 10.9041 1.55022 9.59975 0.810357 8.70147C0.786765 8.67283 0.762175 8.64338 0.736868 8.61306C0.423444 8.23764 -5.96046e-08 7.73043 0 7C0 6.26957 0.423445 5.76236 0.736869 5.38694C0.762176 5.35662 0.786766 5.32717 0.810358 5.29852C1.55022 4.40024 2.75044 3.0959 4.26138 2.00884Z"
                                            fill="#898989" />
                                    </svg>
                                </span>
                                <span class="password-validation-error block text-xs md:text-sm mt-1"></span>
                            </div>
                            <div class="mb-3 mt-18p md:mb-5 relative password-container">
                                <input
                                    class="password_confirmation password-field w-full border border-gray-2 rounded form-control ltr:pl-14 ltr:md:pl-16 rtl:pr-14 rtl:md:pr-16 roboto-regular font-normal text-gray-10 text-13 md:text-15 md:h-52p focus:border-gray-12"
                                    type="password" id="test-2" name="password_confirmation"
                                    placeholder="{{ __('Confirm Password') }}">
                                <span
                                    class="absolute border-gray-2 top-2 h-26p md:top-3 md:h-30p ltr:border-r ltr:md:left-3 ltr:left-2 ltr:pl-1.5 ltr:pr-3 rtl:border-l rtl:md:right-3 rtl:right-2 rtl:pr-1.5 rtl:pl-3">
                                    <svg class="mt-1 w-4 h-4 md:w-5 md:h-5" xmlns="http://www.w3.org/2000/svg"
                                        width="18" height="20" viewBox="0 0 18 20" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M4 5C4 2.23858 6.23858 0 9 0C11.7614 0 14 2.23858 14 5V6C14 6.55228 13.5523 7 13 7C12.4477 7 12 6.55228 12 6V5C12 3.34315 10.6569 2 9 2C7.34315 2 6 3.34315 6 5V6C6 6.55228 5.55228 7 5 7C4.44772 7 4 6.55228 4 6V5Z"
                                            fill="#898989" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0.87868 5.87868C0 6.75736 0 8.17157 0 11V12C0 15.7712 0 17.6569 1.17157 18.8284C2.34315 20 4.22876 20 8 20H10C13.7712 20 15.6569 20 16.8284 18.8284C18 17.6569 18 15.7712 18 12V11C18 8.17157 18 6.75736 17.1213 5.87868C16.2426 5 14.8284 5 12 5H6C3.17157 5 1.75736 5 0.87868 5.87868ZM9 13C9.55228 13 10 12.5523 10 12C10 11.4477 9.55228 11 9 11C8.44772 11 8 11.4477 8 12C8 12.5523 8.44772 13 9 13ZM12 12C12 13.3062 11.1652 14.4175 10 14.8293V17H8V14.8293C6.83481 14.4175 6 13.3062 6 12C6 10.3431 7.34315 9 9 9C10.6569 9 12 10.3431 12 12Z"
                                            fill="#898989" />
                                    </svg>
                                </span>
                                <span
                                    class="password-matching absolute top-1 md:top-2 h-8 ltr:pl-1.5 ltr:pr-3 ltr:right-1.5 rtl:pr-1.5 rtl:pl-3 rtl:left-1.5 cursor-pointer hidden">
                                    <svg class="mt-2.5 h-3 md:h-4 neg-transition-scale" xmlns="http://www.w3.org/2000/svg" width="19"
                                        height="15" viewBox="0 0 19 15" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M18.3163 0.462473C17.5102 -0.242925 16.3121 -0.128557 15.6403 0.717921L8.80424 9.33189C8.14548 10.162 7.77515 10.6215 7.47948 10.9039C7.47564 10.9076 7.47188 10.9112 7.46818 10.9147C7.46419 10.9115 7.46013 10.9083 7.456 10.9051C7.13719 10.6519 6.72875 10.2295 6.00113 9.4654L3.2435 6.56972C2.5015 5.79059 1.29849 5.79059 0.556498 6.56972C-0.185497 7.34886 -0.185497 8.61209 0.556498 9.39123L3.31413 12.2869C3.34002 12.3141 3.36587 12.3412 3.39168 12.3684C4.01203 13.02 4.60881 13.6469 5.16407 14.0878C5.78606 14.5817 6.60062 15.0461 7.6445 14.9963C8.68838 14.9466 9.45955 14.4067 10.0364 13.8557C10.5514 13.3639 11.0916 12.6828 11.6532 11.9749C11.6766 11.9454 11.7 11.9159 11.7235 11.8864L18.5596 3.27239C19.2313 2.42592 19.1224 1.16787 18.3163 0.462473Z"
                                            fill="#33C172" />
                                    </svg>
                                </span>
                                <span class="confirm-password-validation-error block text-red-500"></span>
                            </div>
                            <div class="mt-26p">
                                <div
                                    class="password-confirm-btn bg-gray-12 text-white text-sm md:text-lg leading-6 dm-sans text-center w-full p-2 py-2 md:py-3 rounded transition ease-in-out duration-200 primary-bg-hover hover:text-gray-12 h-10 md:h-52p cursor-pointer">
                                    <span> {{ strtoupper(__('Confirm')) }}</span>
                                    <div class="hidden confirm-password-modal-loader">
                                        <svg class="h-4 w-4 md:h-6 md:w-6 loading-spinner" width="80"
                                            height="80" viewBox="0 0 80 80" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <circle class="loading-circle-large" cx="40" cy="40"
                                                r="36" stroke="#2c2c2c" stroke-width="8" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <p class="text-center mt-5 text-base text-gray-10 roboto-medium font-medium">
                                {!! __('Back to :x', [
                                    'x' => '<span class="text-gray-12 cursor-pointer back-signIn">' . __('Sign in') . '</span>',
                                ]) !!}</p>
                        </form>
                    </div>
                    <div class="password-reset-conf-container text-center hidden">
                        <div class="reset-password-anim mb-7 mt-12">
                            <svg class="animation h-10 w-10 md:h-20 md:w-20" viewBox="0 0 26 26"
                                xmlns="http://www.w3.org/2000/svg">
                                <g stroke="currentColor" stroke-width="2" fill="none" fill-rule="evenodd"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path class="circle"
                                        d="M13 1C6.372583 1 1 6.372583 1 13s5.372583 12 12 12 12-5.372583 12-12S19.627417 1 13 1z" />
                                    <path class="tick" d="M6.5 13.5L10 17 l8.808621-8.308621" />
                                </g>
                            </svg>
                        </div>
                        <p class="dm-bold font-bold text-gray-12 text-base md:text-xl uppercase mb-18p">
                            {{ __('Password Reset Complete') }}</p>
                        <p class="text-gray-10 mb-10 roboto-medium text-sm md:text-base">
                            {{ __('Please sign in to your account') }}
                            <span class="px-2 block">{{ __('with the new password.') }}</span>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Registration --}}
            @if ($customerSignup == '1')
                <div class="c-tab mt-3 register-active password-match {{ str_contains(Request::fullUrl(), '?'.$refParam) && !str_contains(Request::fullUrl(), 'products') ? 'is-active' : '' }}">
                    <div class="c-tab__content">
                        <div>
                            <form method="post" id="password-validate-submit">
                                @csrf
                                <div class="mb-3 md:mb-5 relative">

                                    @includeIf('affiliate::layouts.includes.affiliate_hidden')

                                    <input
                                        class="w-full border border-gray-2 rounded form-control ltr:pl-14 ltr:md:pl-16 rtl:pr-14 rtl:md:pr-16 roboto-regular font-normal text-gray-10 registration-name text-13 md:text-15 md:h-52p focus:border-gray-12"
                                        type="text" name="name" placeholder="{{ __('Your Name') }}">
                                    <span
                                        class="absolute border-gray-2 top-2 h-26p md:top-3 md:h-30p ltr:border-r ltr:md:left-3 ltr:left-2 ltr:pl-1.5 ltr:pr-3 rtl:border-l rtl:md:right-3 rtl:right-2 rtl:pr-1.5 rtl:pl-3">
                                        <svg class="mt-1.5 w-4 h-4 md:w-5 md:h-5" xmlns="http://www.w3.org/2000/svg"
                                            width="18" height="19" viewBox="0 0 18 19" fill="none">
                                            <path
                                                d="M16.3449 17.4054C16.8977 17.2902 17.2269 16.7117 16.9522 16.2183C16.3466 15.1307 15.3926 14.1749 14.1722 13.4465C12.6004 12.5085 10.6745 12 8.69333 12C6.71213 12 4.78628 12.5085 3.21448 13.4465C1.99405 14.1749 1.04002 15.1307 0.434441 16.2183C0.159743 16.7117 0.488979 17.2902 1.04179 17.4054C6.0886 18.4572 11.2981 18.4572 16.3449 17.4054Z"
                                                fill="#898989" />
                                            <circle cx="8.69336" cy="5" r="5" fill="#898989" />
                                        </svg>
                                    </span>
                                    <span
                                        class="name-validation-error block text-red-500 text-xs md:text-sm mt-1"></span>
                                </div>
                                <div class="mb-3 md:mb-5 relative">
                                    <input
                                        class="w-full border border-gray-2 rounded form-control ltr:pl-14 ltr:md:pl-16 rtl:pr-14 rtl:md:pr-16 roboto-regular font-normal text-gray-10 registration-email text-13 md:text-15 md:h-52p focus:border-gray-12"
                                        type="email" name="email" placeholder="{{ __('Email Address') }}"
                                        autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
                                    <span
                                        class="absolute border-gray-2 top-2 h-26p md:top-3 md:h-30p ltr:border-r ltr:md:left-3 ltr:left-2 ltr:pl-1.5 ltr:pr-3 rtl:border-l rtl:md:right-3 rtl:right-2 rtl:pr-1.5 rtl:pl-3">
                                        <svg class="mt-1.5 w-4 h-4 md:w-5 md:h-5" xmlns="http://www.w3.org/2000/svg"
                                            width="18" height="14" viewBox="0 0 18 14" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M0.87868 0.87868C0 1.75736 0 3.17157 0 6V8C0 10.8284 0 12.2426 0.87868 13.1213C1.75736 14 3.17157 14 6 14H12C14.8284 14 16.2426 14 17.1213 13.1213C18 12.2426 18 10.8284 18 8V6C18 3.17157 18 1.75736 17.1213 0.87868C16.2426 0 14.8284 0 12 0H6C3.17157 0 1.75736 0 0.87868 0.87868ZM3.5547 3.16795C3.09517 2.8616 2.4743 2.98577 2.16795 3.4453C1.8616 3.90483 1.98577 4.5257 2.4453 4.83205L7.8906 8.46225C8.5624 8.91012 9.4376 8.91012 10.1094 8.46225L15.5547 4.83205C16.0142 4.5257 16.1384 3.90483 15.8321 3.4453C15.5257 2.98577 14.9048 2.8616 14.4453 3.16795L9 6.79815L3.5547 3.16795Z"
                                                fill="#898989" />
                                        </svg>
                                    </span>
                                    <span
                                        class="email-validation-error block text-red-500 text-xs md:text-sm mt-1"></span>
                                </div>
                                
                                <div class="mb-3 md:mb-5 relative">
                                    <input id="phone"
                                        class="w-full border border-gray-2 rounded form-control ltr:pl-14 ltr:md:pl-16 rtl:pr-14 rtl:md:pr-16 roboto-regular font-normal text-gray-10 registration-phone text-13 md:text-15 md:h-52p focus:border-gray-12"
                                        type="text" name="phone">
                                    <span
                                        class="phone-validation-error block text-red-500 text-xs md:text-sm mt-1"></span>
                                </div>

                                <div class="mb-3 md:mb-5 relative password-container">
                                    <input
                                        class="password password-field w-full border border-gray-2 rounded form-control ltr:pl-14 ltr:md:pl-16 rtl:pr-14 rtl:md:pr-16 roboto-regular font-normal text-gray-10 text-13 md:text-15 md:h-52p focus:border-gray-12 password-validation"
                                        type="password" id="password" name="password"
                                        placeholder="{{ __('Password') }}" autocomplete="off" readonly
                                        onfocus="this.removeAttribute('readonly');">
                                    <span
                                        class="absolute border-gray-2 top-2 h-26p md:top-3 md:h-30p ltr:border-r ltr:md:left-3 ltr:left-2 ltr:pl-1.5 ltr:pr-3 rtl:border-l rtl:md:right-3 rtl:right-2 rtl:pr-1.5 rtl:pl-3">
                                        <svg class="mt-0.5 md:mt-0 w-4 h-5 md:w-5 md:h-6 neg-transition-scale"
                                            xmlns="http://www.w3.org/2000/svg" width="18" height="24"
                                            viewBox="0 0 18 24" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M0.87868 9.11904C0 9.99772 0 11.4119 0 14.2404V15.2404C0 19.0116 0 20.8972 1.17157 22.0688C2.34315 23.2404 4.22876 23.2404 8 23.2404H10C13.7712 23.2404 15.6569 23.2404 16.8284 22.0688C18 20.8972 18 19.0116 18 15.2404V14.2404C18 11.4119 18 9.99772 17.1213 9.11904C16.2426 8.24036 14.8284 8.24036 12 8.24036H6C3.17157 8.24036 1.75736 8.24036 0.87868 9.11904ZM9 16.2404C9.55228 16.2404 10 15.7926 10 15.2404C10 14.6881 9.55228 14.2404 9 14.2404C8.44772 14.2404 8 14.6881 8 15.2404C8 15.7926 8.44772 16.2404 9 16.2404ZM12 15.2404C12 16.5466 11.1652 17.6578 10 18.0697V20.2404H8V18.0697C6.83481 17.6578 6 16.5466 6 15.2404C6 13.5835 7.34315 12.2404 9 12.2404C10.6569 12.2404 12 13.5835 12 15.2404Z"
                                                fill="#898989" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M3.8978 3.9514C6.07928 2.06218 9.25455 1.86447 11.6535 3.4685L12.0273 3.71839C13.8931 4.96591 14.8551 7.19065 14.4862 9.40454L12.5134 9.07576C12.7531 7.63721 12.128 6.1916 10.9156 5.38099L10.5419 5.1311C8.89174 4.02777 6.70764 4.16376 5.2071 5.46326L4.32433 6.22776C3.90685 6.58931 3.27531 6.54397 2.91375 6.12648C2.5522 5.709 2.59754 5.07746 3.01503 4.7159L3.8978 3.9514Z"
                                                fill="#898989" />
                                        </svg>
                                    </span>
                                    <span
                                        class="password-hide absolute top-3 h-7 cursor-pointer ltr:pl-1.5 ltr:pr-3 ltr:right-1.5 rtl:pr-1.5 rtl:pl-3 rtl:left-1.5">
                                        <svg class="md:mt-1 h-4 md:h-5" xmlns="http://www.w3.org/2000/svg"
                                            width="22" height="19" viewBox="0 0 22 19" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M19.9803 18.3977L3.07666 1.49408L4.57074 0L21.4743 16.9036L19.9803 18.3977Z"
                                                fill="#C8C8C8" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M15.9929 17.2707L14.4406 15.7184C13.4135 16.2565 12.3254 16.5941 11.2185 16.5941C9.60656 16.5941 8.03448 15.8782 6.63251 14.8696C5.2389 13.8669 4.1022 12.6384 3.38356 11.7659C3.27816 11.638 3.19943 11.5422 3.13422 11.458C3.08259 11.3914 3.04971 11.345 3.02826 11.3117C3.04971 11.2785 3.08259 11.232 3.13422 11.1654C3.19943 11.0812 3.27816 10.9854 3.38356 10.8575C4.08655 10.004 5.18959 8.80983 6.54184 7.81967L5.03242 6.31025C3.60813 7.39869 2.47352 8.63887 1.75261 9.51414C1.72769 9.54439 1.70172 9.5755 1.67499 9.60752L1.67497 9.60754C1.34384 10.0042 0.896484 10.54 0.896484 11.3117C0.896484 12.0834 1.34384 12.6192 1.67497 13.0159L1.6752 13.0161C1.70185 13.0481 1.72775 13.0791 1.75261 13.1093C2.53426 14.0583 3.80225 15.4363 5.39852 16.5847C6.98645 17.7272 8.98944 18.707 11.2185 18.707C12.9829 18.707 14.6055 18.0932 15.9929 17.2707ZM7.84501 4.6406C8.88436 4.20027 10.0187 3.91638 11.2185 3.91638C13.4476 3.91638 15.4506 4.89623 17.0385 6.03868C18.6348 7.18712 19.9028 8.56513 20.6845 9.51414C20.7094 9.54438 20.7353 9.57548 20.7621 9.60749L20.7621 9.60754C21.0932 10.0042 21.5406 10.54 21.5406 11.3117C21.5406 12.0834 21.0932 12.6192 20.7621 13.0159C20.7354 13.0479 20.7094 13.079 20.6845 13.1093C20.1703 13.7335 19.4458 14.5433 18.5558 15.3513L17.0597 13.8553C17.8837 13.1162 18.5651 12.3589 19.0535 11.7659C19.1589 11.638 19.2376 11.5422 19.3028 11.458C19.3545 11.3914 19.3874 11.345 19.4088 11.3117C19.3873 11.2784 19.3545 11.232 19.3028 11.1654C19.2376 11.0812 19.1589 10.9854 19.0535 10.8575C18.3349 9.98496 17.1982 8.7565 15.8045 7.75385C14.4026 6.7452 12.8305 6.02933 11.2185 6.02933C10.6364 6.02933 10.0595 6.12269 9.49389 6.28948L7.84501 4.6406Z"
                                                fill="#C8C8C8" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M15.3602 12.1556C15.4155 11.8829 15.4445 11.6007 15.4445 11.3117C15.4445 8.97781 13.5525 7.08582 11.2186 7.08582C10.9296 7.08582 10.6473 7.11483 10.3746 7.17009L15.3602 12.1556ZM7.69709 8.97478C7.25201 9.64413 6.99268 10.4476 6.99268 11.3117C6.99268 13.6456 8.88468 15.5376 11.2186 15.5376C12.0827 15.5376 12.8862 15.2783 13.5555 14.8332L11.9984 13.2761C11.7571 13.372 11.494 13.4247 11.2186 13.4247C10.0516 13.4247 9.10562 12.4787 9.10562 11.3117C9.10562 11.0363 9.15833 10.7732 9.25419 10.5319L7.69709 8.97478Z"
                                                fill="#C8C8C8" />
                                        </svg>
                                    </span>
                                    <span
                                        class="password-show absolute top-11p h-8 cursor-pointer hidden ltr:pl-1.5 ltr:pr-3 ltr:right-1.5 rtl:pr-1.5 rtl:pl-3 rtl:left-1.5">
                                        <svg class="md:mt-2.5 mt-5p h-3 md:h-3.5" xmlns="http://www.w3.org/2000/svg"
                                            width="20" height="14" viewBox="0 0 20 14" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M9.77051 9C10.8751 9 11.7705 8.10457 11.7705 7C11.7705 5.89543 10.8751 5 9.77051 5C8.66594 5 7.77051 5.89543 7.77051 7C7.77051 8.10457 8.66594 9 9.77051 9ZM9.77051 11C11.9796 11 13.7705 9.20914 13.7705 7C13.7705 4.79086 11.9796 3 9.77051 3C7.56137 3 5.77051 4.79086 5.77051 7C5.77051 9.20914 7.56137 11 9.77051 11Z"
                                                fill="#898989" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M5.42941 3.63233C4.11029 4.58138 3.03435 5.74418 2.35413 6.57005C2.25436 6.69118 2.17984 6.78179 2.11811 6.86149C2.06925 6.92459 2.03813 6.96852 2.01782 7C2.03813 7.03148 2.06925 7.07541 2.11811 7.13851C2.17984 7.21821 2.25436 7.30882 2.35413 7.42995C3.03435 8.25582 4.11029 9.41862 5.42941 10.3677C6.75643 11.3224 8.24447 12 9.77027 12C11.2961 12 12.7841 11.3224 14.1111 10.3677C15.4303 9.41862 16.5062 8.25582 17.1864 7.42995C17.2862 7.30882 17.3607 7.21821 17.4224 7.13851C17.4713 7.07541 17.5024 7.03147 17.5227 7C17.5024 6.96852 17.4713 6.92458 17.4224 6.86149C17.3607 6.78179 17.2862 6.69118 17.1864 6.57005C16.5062 5.74418 15.4303 4.58138 14.1111 3.63233C12.7841 2.6776 11.2961 2 9.77027 2C8.24447 2 6.75643 2.6776 5.42941 3.63233ZM4.26138 2.00884C5.76442 0.927471 7.66034 0 9.77027 0C11.8802 0 13.7761 0.927472 15.2792 2.00885C16.7901 3.0959 17.9903 4.40025 18.7302 5.29853C18.7538 5.32717 18.7784 5.35662 18.8037 5.38694C19.1171 5.76236 19.5406 6.26957 19.5406 7C19.5406 7.73043 19.1171 8.23764 18.8037 8.61306C18.7784 8.64338 18.7538 8.67283 18.7302 8.70148C17.9903 9.59976 16.7901 10.9041 15.2792 11.9912C13.7761 13.0725 11.8802 14 9.77027 14C7.66034 14 5.76442 13.0725 4.26138 11.9912C2.75044 10.9041 1.55022 9.59975 0.810357 8.70147C0.786765 8.67283 0.762175 8.64338 0.736868 8.61306C0.423444 8.23764 -5.96046e-08 7.73043 0 7C0 6.26957 0.423445 5.76236 0.736869 5.38694C0.762176 5.35662 0.786766 5.32717 0.810358 5.29852C1.55022 4.40024 2.75044 3.0959 4.26138 2.00884Z"
                                                fill="#898989" />
                                        </svg>
                                    </span>
                                    <span class="password-validation-error block text-xs md:text-sm mt-1"></span>
                                </div>

                                <div class="mb-3 md:mb-5 relative password-container">
                                    <input
                                        class="password_confirmation password-field w-full border border-gray-2 rounded form-control ltr:pl-14 ltr:md:pl-16 rtl:pr-14 rtl:md:pr-16 roboto-regular font-normal text-gray-10 text-13 md:text-15 md:h-52p focus:border-gray-12"
                                        type="password" id="password_confirmation" name="password_confirmation"
                                        placeholder="{{ __('Confirm Password') }}">
                                    <span
                                        class="absolute border-gray-2 top-2 h-26p md:top-3 md:h-30p ltr:border-r ltr:md:left-3 ltr:left-2 ltr:pl-1.5 ltr:pr-3 rtl:border-l rtl:md:right-3 rtl:right-2 rtl:pr-1.5 rtl:pl-3">
                                        <svg class="mt-1 w-4 h-4 md:w-5 md:h-5" xmlns="http://www.w3.org/2000/svg"
                                            width="18" height="20" viewBox="0 0 18 20" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M4 5C4 2.23858 6.23858 0 9 0C11.7614 0 14 2.23858 14 5V6C14 6.55228 13.5523 7 13 7C12.4477 7 12 6.55228 12 6V5C12 3.34315 10.6569 2 9 2C7.34315 2 6 3.34315 6 5V6C6 6.55228 5.55228 7 5 7C4.44772 7 4 6.55228 4 6V5Z"
                                                fill="#898989" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M0.87868 5.87868C0 6.75736 0 8.17157 0 11V12C0 15.7712 0 17.6569 1.17157 18.8284C2.34315 20 4.22876 20 8 20H10C13.7712 20 15.6569 20 16.8284 18.8284C18 17.6569 18 15.7712 18 12V11C18 8.17157 18 6.75736 17.1213 5.87868C16.2426 5 14.8284 5 12 5H6C3.17157 5 1.75736 5 0.87868 5.87868ZM9 13C9.55228 13 10 12.5523 10 12C10 11.4477 9.55228 11 9 11C8.44772 11 8 11.4477 8 12C8 12.5523 8.44772 13 9 13ZM12 12C12 13.3062 11.1652 14.4175 10 14.8293V17H8V14.8293C6.83481 14.4175 6 13.3062 6 12C6 10.3431 7.34315 9 9 9C10.6569 9 12 10.3431 12 12Z"
                                                fill="#898989" />
                                        </svg>
                                    </span>
                                    <span
                                        class="password-matching absolute top-1 md:top-2 h-8 cursor-pointer hidden ltr:pl-1.5 ltr:pr-3 ltr:right-1.5 rtl:pr-1.5 rtl:pl-3 rtl:left-1.5">
                                        <svg class="mt-2.5 h-3 md:h-4 neg-transition-scale" xmlns="http://www.w3.org/2000/svg"
                                            width="19" height="15" viewBox="0 0 19 15" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M18.3163 0.462473C17.5102 -0.242925 16.3121 -0.128557 15.6403 0.717921L8.80424 9.33189C8.14548 10.162 7.77515 10.6215 7.47948 10.9039C7.47564 10.9076 7.47188 10.9112 7.46818 10.9147C7.46419 10.9115 7.46013 10.9083 7.456 10.9051C7.13719 10.6519 6.72875 10.2295 6.00113 9.4654L3.2435 6.56972C2.5015 5.79059 1.29849 5.79059 0.556498 6.56972C-0.185497 7.34886 -0.185497 8.61209 0.556498 9.39123L3.31413 12.2869C3.34002 12.3141 3.36587 12.3412 3.39168 12.3684C4.01203 13.02 4.60881 13.6469 5.16407 14.0878C5.78606 14.5817 6.60062 15.0461 7.6445 14.9963C8.68838 14.9466 9.45955 14.4067 10.0364 13.8557C10.5514 13.3639 11.0916 12.6828 11.6532 11.9749C11.6766 11.9454 11.7 11.9159 11.7235 11.8864L18.5596 3.27239C19.2313 2.42592 19.1224 1.16787 18.3163 0.462473Z"
                                                fill="#33C172" />
                                        </svg>
                                    </span>
                                    <span class="confirm-password-validation-error block text-red-500"></span>
                                </div>
                                @if (isRecaptchaActive())
                                    <div class="mb-3">
                                        {!! NoCaptcha::renderJs() !!}
                                        {!! NoCaptcha::display() !!}
                                        <span
                                            class="md:text-red-500 text-xs md:text-sm recaptcha-validation-error"></span>
                                    </div>
                                @endif
                                <div class="mb-3.5 md:mb-22p form-check text-center px-10 md:px-0 leading-4">
                                    <label
                                        class="roboto-medium font-medium text-gray-10 text-xs md:text-sm cursor-pointer"
                                        for="flexCheckDefault-1">
                                        {!! __('By creating an account you agree to our :x.', [
                                            'x' =>
                                                "<a href='" .
                                                (option('default_template_page', '') != null
                                                    ? route('site.page', ['slug' => option('default_template_page', '')['term_condition']])
                                                    : '#') .
                                                "' class='text-blues-2'>" .
                                                __('terms & conditions') .
                                                '</a>',
                                        ]) !!}
                                    </label>
                                </div>

                                <div>
                                    <button id="registration-user"
                                        class="bg-gray-12 primary-bg-hover hover:text-gray-12 dm-sans py-2 md:py-3.5 text-white text-center w-full p-2 rounded text-base transition ease-in-out duration-200 h-10 md:h-52p"
                                        type="submit">
                                        <span
                                            class="create-account-text">{{ strtoupper(__('Create account')) }}</span>
                                        <div class="hidden registration-modal-loader">
                                            <svg class="h-4 w-4 md:h-6 md:w-6 loading-spinner" width="80"
                                                height="80" viewBox="0 0 80 80" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <circle class="loading-circle-large" cx="40" cy="40"
                                                    r="36" stroke="#2c2c2c" stroke-width="8" />
                                            </svg>
                                        </div>
                                    </button>
                                </div>
                                @if (is_array($preference) && count($preference) > 0)
                                    <div class="mt-3 md:mt-18p text-lg flex items-center">
                                        <hr class="border border-gray-2 w-full">
                                        <p class="roboto-regular text-gray-10 text-center text-sm md:text-base px-3 md:px-5 leading-5 whitespace-nowrap">
                                            {{ __('or create account with') }}</p>
                                        <hr class="border border-gray-2 w-full">
                                    </div>

                                    <div
                                        class="flex ltr:mr-0 ltr:md:mr-5 rtl:ml-0 rtl:md:ml-5 gap-x-2.5 md:gap-x-5 justify-center md:justify-between md:mt-5 mt-4">
                                        @if (in_array('Google', $preference))
                                            <a href="{{ route('login.google') }}"
                                                class="flex justify-center items-center rounded px-2 md:px-65p transition ease-in-out duration-200 bg-reds-1 hover:bg-reds-4 w-212px">
                                                <span class="ltr:mr-1.5 ltr:md:mr-2.5 rtl:ml-1.5 rtl:md:ml-2.5">
                                                    <svg class="h-3 md:h-4 md:w-4 neg-transition-scale" xmlns="http://www.w3.org/2000/svg"
                                                        width="16" height="16" viewBox="0 0 16 16"
                                                        fill="none">
                                                        <path
                                                            d="M7.86666 6.26667V9.6H12.4C11.7333 11.4 10 12.6 8 12.6C5.4 12.6 3.33333 10.5333 3.33333 7.93333C3.33333 5.33333 5.4 3.26667 8 3.26667C9 3.26667 9.93334 3.6 10.7333 4.13333L11 4.33333L13 1.73333L12.7333 1.53333C11.3333 0.533333 9.73333 0 8 0C3.6 0 0 3.6 0 8C0 12.4 3.6 16 8 16C12.4 16 16 12.4 16 8V6.33333H7.86666V6.26667Z"
                                                            fill="white"></path>
                                                    </svg>
                                                </span>
                                                <span class="roboto-regular text-xs md:text-lg leading-5 text-white py-2 md:py-3 relative rounded">
                                                    {{ __('Google') }}
                                                </span>
                                            </a>
                                        @endif
                                        @if (in_array('Facebook', $preference))
                                            <a href="{{ route('login.facebook') }}"
                                                class="flex justify-center items-center px-2 md:px-16 rounded transition ease-in-out duration-200 bg-blues-2 hover:bg-blues-3 w-212px">
                                                <span class="ltr:mr-1.5 ltr:md:mr-2.5 rtl:ml-1.5 rtl:md:ml-2.5">
                                                    <svg class="h-3 md:h-4 neg-transition-scale" xmlns="http://www.w3.org/2000/svg"
                                                        width="9" height="17" viewBox="0 0 9 17"
                                                        fill="none">
                                                        <path
                                                            d="M5.84172 16.9999V9.2454H8.4952L8.89246 6.22333H5.84172V4.29384C5.84172 3.4189 6.08944 2.82258 7.3686 2.82258L9 2.82184V0.118952C8.71772 0.0822564 7.74938 0 6.62277 0C4.27066 0 2.66034 1.40829 2.66034 3.99469V6.22342H0V9.24548H2.66026V17L5.84172 16.9999Z"
                                                            fill="white"></path>
                                                    </svg>
                                                </span>
                                                <span
                                                    class="roboto-regular text-xs md:text-lg leading-5 text-white py-2 md:py-3 relative rounded">
                                                    {{ __('Facebook') }}
                                                </span>
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="login-close-btn ltr:ml-1 rtl:mr-1 mt-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13"
                fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M0.455612 0.455612C1.06309 -0.151871 2.04802 -0.151871 2.6555 0.455612L11.9888 9.78895C12.5963 10.3964 12.5963 11.3814 11.9888 11.9888C11.3814 12.5963 10.3964 12.5963 9.78895 11.9888L0.455612 2.6555C-0.151871 2.04802 -0.151871 1.06309 0.455612 0.455612Z"
                    fill="#898989" />
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M11.9887 0.455612C11.3812 -0.151871 10.3963 -0.151871 9.78884 0.455612L0.455503 9.78895C-0.151979 10.3964 -0.151979 11.3814 0.455503 11.9888C1.06298 12.5963 2.04791 12.5963 2.65539 11.9888L11.9887 2.6555C12.5962 2.04802 12.5962 1.06309 11.9887 0.455612Z"
                    fill="#898989" />
            </svg>
        </div>
    </div>
</div>

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
<script>
    var uppercase = "{!! $uppercase !!}";
    var lowercase = "{!! $lowercase !!}";
    var number = "{!! $number !!}";
    var symbol = "{!! $symbol !!}";
    var length = "{!! $length !!}";
    var currentUrl = "{!! session('nextUrl') !!}";
    var loginNeeded = "{!! session('loginRequired') ? 1 : 0 !!}";
    var affiliateRegistration = 0;
    var isActiveAffiliate = "{{ isActive('Affiliate') }}";
    if (loginNeeded == 0 && isActiveAffiliate == 1) {
        loginNeeded = "{!! !auth()->check() && str_contains(Request::fullUrl(), '?'.$refParam) && !str_contains(Request::fullUrl(), 'products') ? 1 : 0 !!}";
        affiliateRegistration = loginNeeded == 1 ? 1 : 0;
        var affiliateReg = "{{ Route::has('site.affiliate.registration') ? route('site.affiliate.registration') : '#' }}";
    }
    var otpUrl = "{!! route('site.verification.otp') !!}";
    var otpActive = "{!! \App\Models\User::userVerification('otp') !!}";
</script>
@if (config('martvill.is_demo'))
    <script>
        var demoCredentials = '{!! json_encode(config('martvill.credentials')) !!}';
    </script>
@endif
@php
    session()->put('nextUrl', null);
@endphp

<script>
    const utilJs = "{{ asset('public/dist/js/intl-tel-input/utils.min.js') }}";
    const isActiveDefaultSignupStatus = "{{ preference('user_default_signup_status') == 'Active' }}"
</script>
<script src="{{ asset('public/dist/js/intl-tel-input/intlTelInput.min.js') }}"></script>
<script src="{{ asset('public/dist/js/custom/site/set-dial-code.min.js') }}"></script>

<script src="{{ asset('public/dist/js/custom/site/password-validation.min.js') }}"></script>
<script src="{{ asset('public/dist/js/custom/site/login.min.js') }}"></script>
<script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>

