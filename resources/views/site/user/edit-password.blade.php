@extends('../site/layouts.user_panel.app')
@section('page_title', __('Profile'))
@section('content')
<!-- My profile -->
<div class="dark:bg-red-1 px-4 py-8 m-2">
    <h2 class="block w-full text-xl font-bold text-gray-600 dark:text-gray-2 mb-6">
        {{ __('Update Pasword') }} <i class="fa fa-key inline-block ml-2" aria-hidden="true"></i>
    </h2>
    <div class="holder">
        <div>
            <div class="container mx-auto w-full h-full">
                <div class="max-w-screen-sm mx-auto w-full h-full flex flex-col items-center justify-center">
                    <div class="bg-white dark:bg-gray-form p-5 mt-8 shadow w-full rounded">
                        <h1 class="text-xl font-semibold border-b pb-2 mr-4 text-gray-700 capitalize dark:text-gray-2 dark:border-b-gray-2">{{ __('Change Password') }}</h1>
                        <form action="{{ route('site.userProfileUpdatePassword') }}" method="POST" class="flex flex-col space-y-4" id="password-validate-submit">
                            @csrf
                            <div class="flex flex-col space-y-2 dark:text-gray-2">
                                <label for="old_password">{{ __('Old Password') }}<span class="text-red-600">*</span> </label>
                                <input type="password" id="old_password" name="old_password"
                                    class="px-2 py-1 border rounded-md focus:outline-none focus:border-blue-400 dark:bg-gray-2 dark:border-gray-0 form-control" placeholder="{{ __('Old Password') }}"
                                    required minlength="5" oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')" data-min-length="{{ __(':x should contain at least :y characters.', ['x' => __('Old Password'), 'y' => 5]) }}">
                            </div>
                            <div class="flex flex-col space-y-2 dark:text-gray-2">
                                <label for="new_password">{{ __('New Password') }}<span class="text-red-600">*</span></label>
                                <input type="password" id="new_password" name="new_password"
                                    class="px-2 py-1 border rounded-md focus:outline-none focus:border-blue-400 dark:bg-gray-2 dark:border-gray-0 form-control password-validation" placeholder="{{ __('New Password') }}"
                                    required minlength="5" oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')" data-min-length="{{ __(':x should contain at least :y characters.', ['x' => __('New Password'), 'y' => 5]) }}">
                                <span class="password-validation-error text-sm text-red-600"></span>
                            </div>
                            <div class="flex flex-col space-y-2 pb-4 dark:text-gray-2">
                                <label for="confirm_password">{{ __('Confirm Password') }}<span class="text-red-600">*</span></label>
                                <input type="password" id="confirm_password" name="confirm_password"
                                    class="px-2 py-1 border rounded-md focus:outline-none focus:border-blue-400 dark:bg-gray-2 dark:border-gray-0 form-control" placeholder="{{ __('Confirm Password') }}"
                                    required minlength="5" oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')" data-min-length="{{ __(':x should contain at least :y characters.', ['x' => __('Confirm Password'), 'y' => 5]) }}">
                            </div>

                            <div class="w-full my-6 border-t dark:border-t-gray-2 flex justify-end">
                                <div class="mt-5">
                                    <a href="{{ route('site.userSetting') }}" class="border text-gray-500 rounded text-sm py-2 mr-3 px-3 border-green-400 hover:bg-green-500 hover:text-white font-semibold duration-200 dark:bg-green-1 dark:text-gray-2 dark:border-gray-0">Cancel</a>
                                    <button type="submit" class="border rounded text-sm py-2 px-3 bg-green-500 text-white hover:text-white hover:bg-green-600 font-semibold duration-200 dark:bg-green-1 dark:text-gray-2 dark:border-gray-0">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@php
    $uppercase = $lowercase = $number = $symbol = $length = 0;
    if (env('PASSWORD_STRENGTH') != null && env('PASSWORD_STRENGTH') != '') {
        $length = filter_var(env('PASSWORD_STRENGTH'), FILTER_SANITIZE_NUMBER_INT);
        $conditions = explode('|', env('PASSWORD_STRENGTH'));
        $uppercase = in_array("UPPERCASE", $conditions);
        $lowercase = in_array("LOWERCASE", $conditions);
        $number = in_array("NUMBERS", $conditions);
        $symbol = in_array("SYMBOLS", $conditions);
    }
@endphp
@endsection
@section('js')
    <script>
        'use strict';
        var uppercase = "{!! $uppercase !!}";
        var lowercase = "{!! $lowercase !!}";
        var number = "{!! $number !!}";
        var symbol = "{!! $symbol !!}";
        var length = "{!! $length !!}";
    </script>
    <script src="{{ asset('/public/dist/js/custom/site/password-validation.min.js') }}"></script>
    <script src="{{ asset('/public/dist/js/custom/validation.min.js') }}"></script>
@endsection
