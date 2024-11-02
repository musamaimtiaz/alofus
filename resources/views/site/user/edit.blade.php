@extends('../site/layouts.user_panel.app')
@section('page_title', __('Profile'))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/intl-tel-input/intlTelInput.min.css') }}">
@endsection
@section('content')
    <!-- My profile -->
    <div class="dark:bg-red-1 h-full xl:px-74p px-5 pt-30p xl:pt-14" id="site-user-edit-container">
        <div>
            <div class="flex lg:items-center">
                <span class="lg:mt-0 mt-1 ltr:mr-4 rtl:ml-4">
                    <svg class="h-30p w-10 xl:w-53p xl:h-11 neg-transition-scale" xmlns="http://www.w3.org/2000/svg" width="53" height="44" viewBox="0 0 53 44" fill="none">
                        <rect x="36.1779" y="27.377" width="16.6222" height="16.6222" rx="2" fill="#FCCA19" />
                        <rect width="32.2667" height="32.2667" rx="2" fill="#FCCA19" />
                    </svg>
                </span>
                <h1 class="dm-sans font-medium lg:pt-0 text-2xl xl:text-4xl text-gray-12 mb-1 dark:text-gray-2">{{ __('Your Profile') }}
                </h1>
            </div>
            <p class="dark:text-gray-2 lg:mt-1.5 roboto-medium font-medium text-base xl:text-xl mt-2 text-20 text-gray-10 leading-6">{{ __('What you show about yourself to the world..') }}</p>
        </div>
        <div class="flex lg:mt-75p mt-10 dm-bold font-bold text-gray-12 xl:text-2xl text-base uppercase">
            <svg class="xl:w-5 xl:h-5 w-3.5 h-3.5 mt-1 ltr:mr-3 rtl:ml-3 neg-transition-scale" xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                <path d="M13.8111 0.06563C13.6306 0.0984421 13.3298 0.176373 13.1451 0.246098C12.3974 0.520903 12.6423 0.30352 7.19391 5.4961C4.26774 8.28106 2.06773 10.4098 1.9732 10.541C1.88727 10.6641 1.77125 10.8691 1.71969 11.0004C1.66383 11.1275 1.4232 12.116 1.18688 13.1947C0.684141 15.4547 0.65836 15.6926 0.856016 16.2258C0.989219 16.5826 1.22125 16.9271 1.48336 17.1486C1.8443 17.4521 2.46734 17.6777 2.9357 17.6777C3.09899 17.6777 6.77711 17.001 7.40875 16.8533C7.52477 16.8246 7.7611 16.7385 7.93727 16.6605C8.25524 16.517 8.34977 16.4309 13.3384 11.673C18.6923 6.5625 18.658 6.59942 18.9287 5.97598C19.122 5.52071 19.1994 5.17207 19.2252 4.63477C19.2595 3.79395 19.0533 3.05977 18.5806 2.39122C18.2756 1.95235 16.9779 0.717777 16.617 0.520903C15.7834 0.06563 14.7693 -0.0984325 13.8111 0.06563ZM14.8381 2.13692C15.2806 2.21485 15.5213 2.37071 16.1959 3.02696C16.8705 3.68321 17.0037 3.88008 17.0896 4.33535C17.1455 4.65118 17.0638 5.08594 16.8877 5.36895C16.8189 5.48379 14.8638 7.39102 11.8861 10.2539L6.99625 14.9502L4.97242 15.2742C3.86383 15.4547 2.9443 15.59 2.9357 15.5818C2.92711 15.5736 3.09898 14.7 3.31813 13.6459L3.71344 11.7223L8.5861 7.0711C12.8529 2.99414 13.4888 2.40352 13.7166 2.29688C14.1162 2.10411 14.417 2.06309 14.8381 2.13692Z" fill="#2C2C2C" />
                <path d="M1.41481 19.0431C0.757386 19.2728 0.551136 20.1341 1.03239 20.6591C1.10114 20.7371 1.24293 20.8396 1.33746 20.8888L1.51364 20.9791L9.82809 20.9914C19.0836 20.9996 18.4261 21.0201 18.7742 20.7207C18.873 20.6386 18.9847 20.4951 19.0277 20.4049C19.1222 20.208 19.1351 19.8224 19.0492 19.6297C18.959 19.4205 18.7226 19.1908 18.4863 19.0883L18.2715 18.9898L9.91403 18.9939C3.59333 18.9939 1.52223 19.0062 1.41481 19.0431Z" fill="#2C2C2C" />
            </svg>
            <p>{{ __('Edit profile') }}</p>
        </div>
        <form action="{{ route('site.userProfileUpdate') }}" method="post" id="edit_user_profile_form" enctype="multipart/form-data">
            @csrf
            <div class="border-t mt-5 w-full lg:block hidden border-line ltr:mr-75p rtl:ml-75p"></div>
                <div>
                    <p class="dm-bold font-bold text-gray-12 lg:block hidden uppercase text-lg leading-6 mt-10">{{ __('Profile Display') }}
                    </p>
                    <div class="mt-25p flex">
                        <img class="lg:h-32 lg:w-32 h-24 w-24 rounded-full neg-transition-scale" id="blah" src="{{ $user->fileUrl() }}" alt="your image" />
                        <div class="lg:mt-27p mt-1 text-center ltr:ml-23p rtl:mr-23p">
                            <label class="dm-sans flex cursor-pointer items-center justify-center lg:py-3.5 py-2.5 font-medium lg:text-sm text-13 text-white whitespace-nowrap lg:w-141p w-32 lg:h-46p h-10 bg-gray-12 mb-9p rounded" for="imgInp"><input class="sr-only cursor-pointer" accept="image/*" type='file' id="imgInp" name="image" />{{ __('Change Photo') }}</label>
                            @if ($user->objectFile()->get()->isNotEmpty())
                            <div x-data="{ showModal1: false }" :class="{ 'overflow-y-hidden': showModal1 }">
                                <a href="javascript:void(0)" @click="showModal1 = true" class="dm-sans text-gray-10 font-medium lg:text-sm text-13 hover:text-gray-12">{{ __('Remove') }}</a>
                                <!-- Modal1 -->
                                <div class="fixed inset-0 w-full h-full bg-black bg-opacity-50 pt-60 duration-300 overflow-y-auto z-50"x-show="showModal1" x-transition:enter="transition duration-300"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                    <div class="relative sm:w-3/4 md:w-1/2 lg:w-1/3 mx-2 sm:mx-auto my-10 opacity-100">
                                        <div class="relative bg-white shadow-lg p-4 rounded-md text-gray-900 z-50"
                                            @click.away="showModal1 = false" x-show="showModal1" x-transition:enter="transition transform duration-300" x-transition:enter-start="scale-0" x-transition:enter-end="scale-100"
                                            x-transition:leave="transition transform duration-300" x-transition:leave-start="scale-100"
                                            x-transition:leave-end="scale-0">
                                            <svg class="lg:block hidden ltr:ml-auto rtl:mr-auto cursor-pointer hover:text-gray-12 text-gray-10"
                                                    @click="showModal1 = false" xmlns="http://www.w3.org/2000/svg"
                                                    width="13" height="13" viewBox="0 0 13 13"
                                                    fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.455612 0.455612C1.06309 -0.151871 2.04802 -0.151871 2.6555 0.455612L11.9888 9.78895C12.5963 10.3964 12.5963 11.3814 11.9888 11.9888C11.3814 12.5963 10.3964 12.5963 9.78895 11.9888L0.455612 2.6555C-0.151871 2.04802 -0.151871 1.06309 0.455612 0.455612Z" fill="currentColor" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9887 0.455612C11.3812 -0.151871 10.3963 -0.151871 9.78884 0.455612L0.455503 9.78895C-0.151979 10.3964 -0.151979 11.3814 0.455503 11.9888C1.06298 12.5963 2.04791 12.5963 2.65539 11.9888L11.9887 2.6555C12.5962 2.04802 12.5962 1.06309 11.9887 0.455612Z" fill="currentColor" />
                                                    </svg>
                                                    <div>
                                                        <div class="flex">
                                                            <div class="flex flex-col justify-center bg-red-100 items-center h-10 w-10 rounded-full dark:text-gray-2 ltr:ml-4 rtl:mr-4">
                                                                <svg class="lg:w-8 lg:h-8 w-26p h-26p"xmlns="http://www.w3.org/2000/svg" width="32"height="32" viewBox="0 0 32 32" fill="none">
                                                                    <circle cx="16" cy="16" r="16" fill="#F9E8E8" />
                                                                    <path d="M17.7925 8L17.5367 18.9463H15.3411L15.0746 8H17.7925ZM15 22.3037C15 21.9129 15.1279 21.586 15.3837 21.3231C15.6466 21.0531 16.009 20.9181 16.4709 20.9181C16.9256 20.9181 17.2845 21.0531 17.5474 21.3231C17.8103 21.586 17.9417 21.9129 17.9417 22.3037C17.9417 22.6803 17.8103 23.0036 17.5474 23.2736C17.2845 23.5365 16.9256 23.668 16.4709 23.668C16.009 23.668 15.6466 23.5365 15.3837 23.2736C15.1279 23.0036 15 22.6803 15 22.3037Z" fill="#C8191C" />
                                                                </svg>
                                                            </div>
                                                           <div class="flex flex-col">
                                                            <span class="text-left leading-4 dm-sans font-medium lg:text-lg text-gray-12 lg:mb-1.5 mb-1 text-sm mt-2.5 ltr:lg:pr-0 ltr:pr-3 ltr:ml-2 rtl:lg:pl-0 rtl:pl-3 rtl:mr-2">{{ __('Are you sure you want to delete this?') }}</span>
                                                           </div>
                                                        </div>
                                                    </div>
                                            <div class="flex justify-end lg:mt-8 lg:mx-0 mx-2 mt-6 ltr:lg:mr-30p rtl:lg:ml-30p">
                                                <button type="button" @click="showModal1 = false" class="dm-sans items-center transition duration-200 rounded px-3 lg:px-8 cursor-pointer font-medium lg:text-sm text-gray-12 lg:h-46p w-max h-10 bg-white border border-gray-2 text-xs hover:border-gray-12">{{ __('Cancel') }}
                                                </button>
                                                <a href="{{ route('site.userProfileDelete') }}" class="dm-sans transition duration-200 items-center cursor-pointer py-3.5 lg:px-6 font-medium lg:text-sm text-white lg:h-46p bg-gray-12 hover:bg-yellow-1 hover:text-gray-12 text-xs w-max px-3 h-10 rounded ltr:ml-3 rtl:mr-3">{{ __('Yes, Delete') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div>
                    <p class="dm-bold font-bold text-gray-12 uppercase lg:text-lg text-base leading-6 lg:mt-60p mt-10">{{ __('personal information') }}</p>
                    <div class="items-center 3xl:w-1/2 2xl:w-2/3 lg:w-full mt-27p">
                        <div>
                            <div class="grid grid-cols-2 lg:gap-3 gap-15p">
                                <div class="mb-0">
                                    <label class="text-sm dm-sans font-medium capitalize text-gray-12 require-profile" for="name">
                                        {{ __('Name') }}</label>
                                    <input class="border-gray-2 rounded-sm w-full lg:h-46p h-10 roboto-medium font-medium text-sm text-gray-10 form-control border focus:border-gray-12 ltr:pr-3 ltr:pl-18p rtl:pl-3 rtl:pr-18p" type="text" name="name" id="name" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')" value="{{ !empty(old('name')) ? old('name') : $user->name }}">
                                </div>
                                <div class="mb-3">
                                    <label class="text-sm dm-sans font-medium capitalize text-gray-12 require-profile" for="email">
                                        {{ __('Email Address') }}</label>
                                    <input class="border-gray-2 rounded-sm w-full lg:h-46p h-10 roboto-medium font-medium text-sm text-gray-10 form-control focus:border-gray-12 ltr:pl-18p rtl:pr-18p" type="email" name="email" id="email" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')" value="{{ !empty(old('email')) ? old('email') : $user->email }}">
                                </div>
                            </div>
                            <div class="grid lg:grid-cols-2 grid-cols-1 lg:gap-3">
                                <div class="mb-3">
                                    <label class="text-sm dm-sans font-medium capitalize text-gray-12" for="select">{{ __('Gender') }}</label>
                                    <select id="select" name="gender" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')" class="border-gray-2 rounded-sm w-full h-46p roboto-medium ltr:pl-18p rtl:pr-18p font-medium text-sm text-gray-10 form-control appearance-none genderSelect z-0">
                                        <option value="Male" {{  old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                                        <option value="Female" {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="mb-3p capitalize dm-sans font-medium text-sm text-gray-12" for="Date">{{ __('Date of Birth') }}</label>
                                    <input class="border-gray-2 rounded-sm w-full h-46p roboto-medium uppercase font-medium text-sm text-gray-10 form-control focus:border-gray-12 ltr:pl-18p rtl:pr-18p" type="date" name="birthday" id="date" onkeydown="return false" value="{{ $user->birthday }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="whitespace-nowrap text-sm dm-sans font-medium capitalize text-gray-12" for="phone"> {{ __('Phone Number') }}</label>
                                <input class="border-gray-2 rounded-sm w-full lg:h-46p h-10 roboto-medium font-medium text-sm text-gray-10 form-control focus:border-gray-12 ltr:pl-18p rtl:pr-18p" name="phone" type="tel" id="phone" value="{{ !empty(old('phone')) ? old('phone') : $user->phone }}">
                            </div>
                            <div class="mb-3">
                                <label class="text-sm dm-sans font-medium capitalize text-gray-12 require-profile" for="address">
                                    {{ __('Address') }}</label>
                                <input name="address" class="border border-gray-2 focus:border-gray-12 rounded-sm w-full lg:h-46p h-10 roboto-medium font-medium text-sm form-control ltr:pl-18p rtl:pr-18p" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')" value="{{ !empty(old('address')) ? old('address') : $user->address }}">
                            </div>
                        </div>
                        <div class="flex gap-3 mt-5">
                            <a href="{{ route('site.dashboard') }}" class="lg:order-none order-last dm-sans text-center transition duration-200 rounded flex justify-center items-center cursor-pointer font-medium text-sm text-gray-12 px-12 h-46p bg-white border border-gray-2 mb-7p hover:border-gray-12">
                                {{ __('Cancel') }}
                            </a>
                            <button class="dm-sans transition duration-200 items-center cursor-pointer py-3.5 px-6 font-medium text-sm whitespace-nowrap text-white h-46p bg-gray-12 hover:bg-yellow-1 hover:text-gray-12 mb-7p rounded ">{{ __('Save Changes') }} </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script>
        const utilJs = "{{ asset('public/dist/js/intl-tel-input/utils.min.js') }}";
    </script>
    <script src="{{ asset('public/dist/js/intl-tel-input/intlTelInput.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/set-dial-code.min.js') }}"></script>
    
    <script src="{{ asset('/public/dist/js/custom/validation.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{ asset('/public/dist/js/custom/user.min.js') }}"></script>
@endsection
