@extends('../site/layouts.user_panel.app')
@section('page_title', __('Setting'))
@section('content')
    <!-- My profile -->
    <div class="dark:bg-red-1 settings-page h-full ltr:xl:pl-74p rtl:xl:pr-74p px-5 pt-30p lg:pt-14 bg-white">
        <div>
            <div class="flex items-center">
                <span class="ltr:mr-4 rtl:ml-4 lg:mt-0 mt-1">
                    <svg class="h-30p w-10 xl:w-53p xl:h-11 neg-transition-scale" xmlns="http://www.w3.org/2000/svg" width="53" height="44"
                        viewBox="0 0 53 44" fill="none">
                        <rect x="36.1779" y="27.377" width="16.6222" height="16.6222" rx="2" fill="#FCCA19" />
                        <rect width="32.2667" height="32.2667" rx="2" fill="#FCCA19" />
                    </svg>
                </span>
                <h1 class="dm-sans font-medium lg:pt-0 text-2xl xl:text-4xl text-gray-12 mb-1 dark:text-gray-2">{{ __('Settings') }}</h1>
            </div>
            <p class="dark:text-gray-2 lg:mt-1.5 roboto-medium font-medium text-base xl:text-xl mt-4 text-20 text-gray-10 leading-6">{{ __('Configure your account settings and be secured') }}</p>
        </div>
        <div class="flex lg:mt-75p mt-30p mb-5 dm-bold font-bold text-gray-12 xl:text-2xl text-lg uppercase">
            <p>{{ __('security settings') }}</p>
        </div>
        <div class="bg-white w-full" x-data="{ selected: null }">
            <ul class="shadow-box">
                <li class=" xl:w-2/3 2xl:w-1/2 w-full border rounded border-gray-2">
                    <button type="button" class="w-full" @click="selected !== 1 ? selected = 1 : selected = null">
                        <div class="flex items-center justify-between">
                            <div class="w-full cursor-pointer lg:px-30p px-15p lg:py-30p py-4">
                                <p class="text-gray-12 leading-6 ltr:text-left rtl:text-right mb-2 lg:text-lg text-base dm-sans font-medium">
                                    {{ __('Change Password') }} <br>
                                    <span class="text-gray-10 lg:text-base text-sm ltr:text-left rtl:text-right roboto-medium font-medium">{{ __('You set a unique password to protect your account.') }}</span>
                                </p>
                            </div>
                            <span class="ltr:lg:pr-10 ltr:pr-4 rtl:lg:pl-10 rtl:pl-4">
                                <svg class="lg:w-5 lg:h-2.5 w-2.5 h-1.5" xmlns="http://www.w3.org/2000/svg" width="20" height="11"
                                    viewBox="0 0 20 11" fill="none" x-bind:class="selected == 1 ? 'transform rotate-180' : ''">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M1.08332e-07 1.91549L2.10853 1.44724e-07L10 7.16901L17.8915 3.32934e-07L20 1.91549L10 11L1.08332e-07 1.91549Z" fill="#898989" />
                                </svg>
                            </span>
                        </div>
                    </button>
                    <div class="relative overflow-hidden transition-all max-h-0 duration-700"
                        x-ref="container2"
                        x-bind:style="selected == 1 ? 'max-height: ' + $refs.container2.scrollHeight + 'px' : ''">
                        <div class="px-5 py-0 robot-medium font-medium text-justify lg:text-sm text-13 text-gray-10">
                            <div>
                                <div class="w-full">
                                    <form action="{{ route('site.userProfileUpdatePassword') }}" method="POST"
                                        class="3xl:px-40 2xl:px-20 px-5 pt-3p" id="password-validate-submi">
                                        @csrf
                                        <div class="ltr:lg:pr-7 ltr:pr-0 rtl:lg:pl-7 rtl:pl-0">
                                            <div class="flex flex-col">
                                                <label class="require-profile mb-3p dm-sans font-medium text-sm text-gray-12" for="old_password">{{ __('Old Password') }} </label>
                                                <input type="password" id="old_password" name="old_password" class="px-18p w-full lg:h-46p h-10 text-gray-10 border rounded-sm focus:outline-none focus:border-gray-12 border-gray-2 form-control" placeholder="{{ __('****************') }}" required minlength="5" oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                                    data-min-length="{{ __(':x should contain at least :y characters.', ['x' => __('Old Password'), 'y' => 5]) }}">
                                            </div>
                                            <div class="flex flex-col mt-15p">
                                                <label class="require-profile mb-3p leading-none dm-sans font-medium text-sm text-gray-12" for="new_password">{{ __('New Password') }} </label>
                                                <input type="password" id="new_password" name="new_password" class="px-18p w-full lg:h-46p h-10 text-gray-10 border rounded-sm focus:outline-none focus:border-gray-12 border-gray-2 form-control password-validation" required minlength="5" oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')" data-min-length="{{ __(':x should contain at least :y characters.', ['x' => __('New Password'), 'y' => 5]) }}">
                                            </div>
                                            <div class="flex flex-col mt-15p">
                                                <label class="require-profile leading-18p mb-3p dm-sans font-medium text-sm text-gray-12" for="confirm_password">{{ __('Confirm Password') }} </label>
                                                <input type="password" id="confirm_password" name="confirm_password" class="px-18p w-full lg:h-46p h-10 text-gray-10 border rounded-sm focus:outline-none focus:border-gray-12 border-gray-2 form-control" required minlength="5" oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')" data-min-length="{{ __(':x should contain at least :y characters.', ['x' => __('Confirm Password'), 'y' => 5]) }}">
                                            </div>
                                            <div class="flex mt-5 mb-20 justify-end">
                                                <div @click="selected !== 1 ? selected = 1 : selected = null" class="dm-sans flex items-center justify-center transition duration-200 rounded cursor-pointer font-medium text-sm text-gray-12 px-8 lg:h-46p h-10 bg-white border border-gray-2 mb-7p hover:border-gray-12"><a href="javascript:void(0);">{{ __('Cancel') }}</a>
                                                </div>
                                                <button type="submit" class="dm-sans transition duration-200 items-center cursor-pointer whitespace-nowrap font-medium text-sm text-white px-6 lg:h-46p h-10 bg-gray-12 hover:bg-yellow-1 hover:text-gray-12 mb-7p rounded ltr:ml-3 rtl:mr-3">{{ __('Save Change') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                {{-- delete account --}}
                @if (optional(optional(auth()->user()->role()))->slug != 'super-admin')
                    <li class="xl:w-2/3 2xl:w-1/2 w-full border rounded mt-5 border-gray-2">
                        <button type="button" class="w-full"
                            @click="selected !== 2 ? selected = 2 : selected = null">
                            <div class="flex items-center justify-between">
                                <div class="w-full cursor-pointer lg:px-30p px-15p lg:py-30p py-5">
                                    <p class="text-gray-12 leading-6 ltr:text-left rtl:text-right mb-2 lg:text-lg text-base dm-sans font-medium">{{ __('Delete Account') }}<br><span class="text-gray-10 lg:text-base text-sm ltr:text-left rtl:text-right roboto-medium font-medium">{{ __("You can't get back your account anymore.") }}</span>
                                    </p>
                                </div>
                                <span class="ltr:lg:pr-10 ltr:pr-4 rtl:lg:pl-10 rtl:pl-4">
                                    <svg class="lg:w-5 lg:h-2.5 w-2.5 h-1.5" xmlns="http://www.w3.org/2000/svg" width="20" height="11" viewBox="0 0 20 11" fill="none" x-bind:class="selected == 2 ? 'transform rotate-180' : ''">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.08332e-07 1.91549L2.10853 1.44724e-07L10 7.16901L17.8915 3.32934e-07L20 1.91549L10 11L1.08332e-07 1.91549Z" fill="#898989" />
                                    </svg>
                                </span>
                            </div>
                        </button>
                        <div class="relative overflow-hidden transition-all max-h-0 duration-700" x-ref="container3" x-bind:style="selected == 2 ? 'max-height: ' + $refs.container3.scrollHeight + 'px' : ''">
                            <div class="px-5 py-0 robot-medium font-medium lg:text-sm text-13 text-gray-10">
                                <div class="border-gray-2 w-full rounded" id="delete">
                                    <div class="w-full 3xl:px-40 2xl:px-20 px-5">
                                        <div class="lg:pt-30p pt-5">
                                            <div class="flex">
                                                <svg class="w-6 h-6 lg:w-8 h-8" xmlns="http://www.w3.org/2000/svg"
                                                    width="32" height="32" viewBox="0 0 32 32" fill="none">
                                                    <circle cx="16" cy="16" r="16" fill="#F9E8E8" />
                                                    <path d="M17.7925 8L17.5367 18.9463H15.3411L15.0746 8H17.7925ZM15 22.3037C15 21.9129 15.1279 21.586 15.3837 21.3231C15.6466 21.0531 16.009 20.9181 16.4709 20.9181C16.9256 20.9181 17.2845 21.0531 17.5474 21.3231C17.8103 21.586 17.9417 21.9129 17.9417 22.3037C17.9417 22.6803 17.8103 23.0036 17.5474 23.2736C17.2845 23.5365 16.9256 23.668 16.4709 23.668C16.009 23.668 15.6466 23.5365 15.3837 23.2736C15.1279 23.0036 15 22.6803 15 22.3037Z" fill="#C8191C" />
                                                </svg>
                                                <span class="dm-sans font-medium lg:text-lg text-sm text-gray-12 inline-block ltr:ml-2.5 rtl:mr-2.5 mt-1 leading-6">{{ __('Are you sure you want to delete this account?') }}</span>
                                            </div>
                                            <div class="roboto-medium font-medium mt-2 lg:text-sm text-11 ltr:text-left ltr:ml-10 rtl:text-right rtl:mr-10 text-gray-10"><p> {!! chunk_split(__('Once deleted, every information and files will be lost forever.'), 42) !!}
                                                </p>
                                            </div>
                                        </div>
                                        <form action="{{ route('site.userDelete') }}" method="post" class="ltr:lg:pr-6 ltr:pr-0 rtl:lg:pl-6 rtl:pl-0">
                                            @csrf
                                            <div class="lg:mt-30p mt-6 ltr:lg:pr-6 ltr:pr-0 rtl:lg:pl-6 rtl:pl-0">
                                                <p class="ltr:text-left rtl:text-right mb-3p dm-sans font-medium text-sm text-gray-12">{{ __('Enter password to delete your account.') }} </p>
                                                <div>
                                                    <input class="px-18p w-full lg:h-46p h-10 text-gray-10 border rounded-sm focus:outline-none focus:border-gray-12 border-gray-2 form-control block" type="password" name="password" id="password" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                                </div>
                                                <div class="flex mt-5 mb-3p justify-end">
                                                    <button type="button" class="close-setting dm-sans items-center transition duration-200 rounded mb-10 pt-3 pb-3.5 cursor-pointer font-medium text-sm text-gray-12 px-11 h-46p bg-white border border-gray-2 hover:border-gray-12"
                                                        @click="selected !== 2 ? selected = 2 : selected = null"> {{ __('Cancel') }}
                                                    </button>
                                                    <button type="submit" class="dm-sans transition duration-200 cursor-pointer font-medium text-sm text-white px-5 h-46p bg-gray-12 hover:bg-yellow-1 hover:text-gray-12 rounded ltr:ml-3 rtl:mr-3"> {{ __('Delete Account') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
        <div class="flex lg:mt-30p mt-30p mb-5 dm-bold font-bold text-gray-12 xl:text-2xl text-lg uppercase">
            <p>{{ __('Login Activities') }}</p>
        </div>
        <div class=" xl:w-2/3 bg-white 2xl:w-1/2 w-full border rounded border-gray-2">
            <a href="{{ route('site.userActivity') }}">
                <div class="flex items-center justify-between">
                    <div class="w-full cursor-pointer lg:px-30p px-15p lg:py-30p py-4">
                        <p class="text-gray-12 leading-6 ltr:text-left rtl:text-right mb-2 lg:text-lg text-base dm-sans font-medium">
                            {{ __('Currently on') }} <br>
                            <span class="text-gray-10 lg:text-base text-sm ltr:text-left rtl:text-right roboto-medium font-medium">
                                <span class="ltr:pr-2 rtl:pl-2">{{ $browser . ' ' . $version }}</span>
                                •
                                <span class="ltr:pl-2 rtl:pr-2">{{ $platform }}</span>
                            </span>
                        </p>
                    </div>
                    <span class="ltr:lg:pr-10 ltr:pr-4 rtl:lg:pl-10 rtl:pl-4 text-gray-12 leading-6 dm-sans font-medium">
                        {{ __('Details') }}
                    </span>
                </div>
            </a>
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
    <script src="{{ asset('/public/dist/js/custom/site/settings.min.js') }}"></script>
    <script src="{{ asset('/public/dist/js/custom/validation.min.js') }}"></script>

@endsection
