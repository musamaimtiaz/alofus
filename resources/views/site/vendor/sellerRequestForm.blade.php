@extends('../site/layouts.user_panel.app')
@section('page_title', __('Seller Request Form'))
@section('css')
     <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/select2/css/select2.min.css') }}">
@endsection
@section('content')
    <!-- Seller Registration Form -->
    <div class="dark:bg-red-1 h-full xl:px-74p px-5 pt-30p xl:pt-14">
        <div>
            <div class="flex lg:items-center">
                <span class="ltr:mr-4 rtl:ml-4 lg:mt-0 mt-1">
                    <svg class="h-30p w-10 xl:w-53p xl:h-11 neg-transition-scale" xmlns="http://www.w3.org/2000/svg" width="53" height="44" viewBox="0 0 53 44" fill="none">
                        <rect x="36.1779" y="27.377" width="16.6222" height="16.6222" rx="2" fill="#FCCA19" />
                        <rect width="32.2667" height="32.2667" rx="2" fill="#FCCA19" />
                    </svg>
                </span>
                <h1 class="dm-sans font-medium lg:pt-0 text-2xl xl:text-4xl text-gray-12 mb-1 dark:text-gray-2">
                    {{ __('Seller Request Form') }}
                </h1>
            </div>
        </div>
        <form action="{{ route('site.seller.requestStore') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div>
                <div class="items-center 3xl:w-1/2 2xl:w-2/3 lg:w-full lg:w-ful mt-27p">
                    <div>
                        <div class="mb-3">
                            <label class="whitespace-nowrap text-sm dm-sans font-medium capitalize text-gray-12 require-profile"
                                for="shop_name"> {{ __('Shop Name') }}</label>
                            <input class="border-gray-2 rounded-sm w-full lg:h-46p h-10 roboto-medium ltr:pl-18p rtl:pr-18p font-medium text-sm text-gray-10 form-control focus:border-gray-12"
                                name="shop_name" type="text" id="shop_name" value="{{ old('shop_name') }}" required
                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}') ">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="whitespace-nowrap text-sm dm-sans font-medium capitalize text-gray-12 require-profile"
                            for="number"> {{ __('Phone Number') }}</label>
                        <input class="border-gray-2 rounded-sm w-full lg:h-46p h-10 roboto-medium ltr:pl-18p rtl:pr-18p font-medium text-sm text-gray-10 form-control focus:border-gray-12"
                            name="phone" type="tel" value="{{ old('phone') }}" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                    </div>
                    <div>
                        <div class="mb-3">
                            <label class="whitespace-nowrap text-sm dm-sans font-medium capitalize text-gray-12 require-profile"
                                for="alias"> {{ __('Alias') }}</label>
                            <input class="border-gray-2 rounded-sm w-full lg:h-46p h-10 roboto-medium ltr:pl-18p rtl:pr-18p font-medium text-sm text-gray-10 form-control focus:border-gray-12"
                                name="alias" type="text" id="alias" value="{{ old('alias') }}" required
                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}') ">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="text-sm dm-sans font-medium capitalize text-gray-12 require-profile" for="address">
                            {{ __('Address') }}</label>
                        <input class="border-gray-2 rounded-sm w-full lg:h-46p h-10 roboto-medium ltr:pl-18p rtl:pr-18p font-medium text-sm text-gray-10 form-control focus:border-gray-12"
                            type="text" name="address" value="{{ old('address') }}" id="address" required
                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}') ">
                    </div>
                    <div class="mb-3">
                        <label class="text-sm dm-sans font-medium capitalize text-gray-12 require-profile" for="address">
                            {{ __('Country') }}</label>
                        <select name="country" id="country" value="{{ old('country') }}" class="border-gray-2 rounded-sm w-full lg:h-46p h-10 roboto-medium ltr:pl-18p rtl:pr-18p font-medium text-sm text-gray-10 form-control focus:border-gray-12 addressSelect sl_common_bx"  required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                            <option value="">{{ __('Select Country') }}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="text-sm dm-sans font-medium capitalize text-gray-12 require-profile" for="description">
                            {{ __('State') }}</label>
                        <select name="state" id="state" value="{{ old('state') }}" class="border-gray-2 rounded-sm w-full lg:h-46p h-10 roboto-medium ltr:pl-18p rtl:pr-18p font-medium text-sm text-gray-10 form-control focus:border-gray-12 addressSelect sl_common_bx"  required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                            <option value="">{{ __('Select State') }}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="text-sm dm-sans font-medium capitalize text-gray-12 require-profile"
                            for="description">
                            {{ __('City') }}</label>
                        <select name="city" id="city" value="{{ old('city') }}" class="border-gray-2 rounded-sm w-full lg:h-46p h-10 roboto-medium ltr:pl-18p rtl:pr-18p font-medium text-sm text-gray-10 form-control focus:border-gray-12 addressSelect sl_common_bx"  required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                            <option value="">{{ __('Select City') }}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="text-sm dm-sans font-medium capitalize text-gray-12 require-profile"
                            for="description">
                            {{ __('Description') }}</label>
                        <textarea class="border-gray-2 rounded-sm w-full roboto-medium ltr:pl-18p rtl:pr-18p font-medium text-sm text-gray-10 form-control focus:border-gray-12" type="text" name="description" id="description" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}') "></textarea>
                    </div>
                    <div class="flex gap-3 mt-5">
                        <div class="lg:order-none order-last dm-sans text-center transition duration-200 rounded py-3.5 cursor-pointer font-medium text-sm text-gray-12 h-46p bg-white border border-gray-2 mb-7p hover:border-gray-12 px-8">
                            <a href="{{ route('site.userProfile') }}"> {{ __('Cancel') }}</a>
                        </div>
                        <button type="submit" class="dm-sans transition duration-200 items-center cursor-pointer py-3.5 px-6 font-medium text-sm whitespace-nowrap text-white h-46p bg-gray-12 primary-bg-hover hover:text-gray-12 mb-7p rounded">{{ __('Submit') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script>
        'use strict';
        var oldCountry = "{!! old('country') ?? 'null' !!}";
        var oldState = "{!! old('state') ?? 'null' !!}";
        var oldCity = "{!! old('city') ?? 'null' !!}";
    </script>
    <script src="{{ asset('/public/dist/js/custom/validation.min.js') }}"></script>
    <script src="{{ asset('/public/dist/js/custom/user.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('/public/dist/js/custom/site/seller.min.js') }}"></script>
@endsection
