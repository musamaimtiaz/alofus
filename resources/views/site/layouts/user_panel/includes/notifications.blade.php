@foreach (['success', 'danger', 'fail', 'warning', 'info'] as $msg)
    @if ($message = Session::get($msg))
        <div class="absolute z-10 hide-notification-popup ltr:right-0 rtl:left-0">
            <div class="{{ $msg == 'fail' ? ' border-reds-1 bg-white ' : ' border-green-1 bg-white' }} mt-10 w-417 dm-sans font-medium text-gray-12 text-lg ltr:pl-30p rtl:pr-30p py-30p border-b-4 rounded hidden xl:block"
                role="alert" x-data="{ open: true }" x-show.transition="open">
                <div class="flex justify-between">
                    <div class="flex">
                        @if ($msg == 'success')
                            <svg class="mt-2 neg-transition-scale" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                viewBox="0 0 32 32 " fill="none">
                                <path d="M18.3163 0.462473C17.5102 -0.242925 16.3121 -0.128557 15.6403 0.717921L8.80424 9.33189C8.14548 10.162 7.77515 10.6215 7.47948 10.9039C7.47564 10.9076 7.47188 10.9112 7.46818 10.9147C7.46419 10.9115 7.46013 10.9083 7.456 10.9051C7.13719 10.6519 6.72875 10.2295 6.00113 9.4654L3.2435 6.56972C2.5015 5.79059 1.29849 5.79059 0.556498 6.56972C-0.185497 7.34886 -0.185497 8.61209 0.556498 9.39123L3.31413 12.2869C3.34002 12.3141 3.36587 12.3412 3.39168 12.3684C4.01203 13.02 4.60881 13.6469 5.16407 14.0878C5.78606 14.5817 6.60062 15.0461 7.6445 14.9963C8.68838 14.9466 9.45955 14.4067 10.0364 13.8557C10.5514 13.3639 11.0916 12.6828 11.6532 11.9749C11.6766 11.9454 11.7 11.9159 11.7235 11.8864L18.5596 3.27239C19.2313 2.42592 19.1224 1.16787 18.3163 0.462473Z" fill="#009651" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"
                                fill="none">
                                <circle cx="16" cy="16" r="16" fill="#F3F3F3" />
                                <path d="M17.7925 8L17.5367 18.9463H15.3411L15.0746 8H17.7925ZM15 22.3037C15 21.9129 15.1279 21.586 15.3837 21.3231C15.6466 21.0531 16.009 20.9181 16.4709 20.9181C16.9256 20.9181 17.2845 21.0531 17.5474 21.3231C17.8103 21.586 17.9417 21.9129 17.9417 22.3037C17.9417 22.6803 17.8103 23.0036 17.5474 23.2736C17.2845 23.5365 16.9256 23.668 16.4709 23.668C16.009 23.668 15.6466 23.5365 15.3837 23.2736C15.1279 23.0036 15 22.6803 15 22.3037Z" fill="#898989" />
                            </svg>
                        @endif
                        <p class="ltr:ml-2.5 rtl:mr-2.5 leading-5 mt-1 w-312p">{{ $message }}</p>
                    </div>
                    <span class="cursor-pointer rounded-full mt-1 ltr:mr-3 rtl:ml-3" x-on:click="open = false">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-12" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect x="0" y="0" width="16" height="16" stroke="none"></rect>
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </span>
                </div>
            </div>
        </div>
        <div class="my-auto block xl:hidden" x-data="{ showModal1: true }" :class="{ 'overflow-y-hidden': showModal1 }">
            <!-- Modal1 -->
            <div class="fixed inset-0 bg-black bg-opacity-50 pt-60 duration-300 z-50 overflow-y-auto" x-show="showModal1"
                x-transition:enter="transition duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition duration-300"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <div class="relative sm:w-1/2 sm:mx-auto mx-5 my-10 opacity-100">
                    <div class="relative bg-white shadow-lg rounded-md text-gray-900 z-50"
                        @click.away="showModal1 = false" x-show="showModal1"
                        x-transition:enter="transition transform duration-300" x-transition:enter-start="scale-0"
                        x-transition:enter-end="scale-100" x-transition:leave="transition transform duration-300"
                        x-transition:leave-start="scale-100" x-transition:leave-end="scale-0">
                        <div class="{{ $msg == 'fail' ? ' border-reds-1' : ' border-green-1' }} bg-white mx-auto dm-sans font-medium text-gray-12 text-sm mt-20 px-30p py-30p border-b-4 rounded"
                            role="alert" x-data="{ open: true }" x-show.transition="open">
                            <div class="flex">
                                @if ($msg == 'success')
                                    <svg class="mt-2 neg-transition-scale" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32 " fill="none">
                                        <path d="M18.3163 0.462473C17.5102 -0.242925 16.3121 -0.128557 15.6403 0.717921L8.80424 9.33189C8.14548 10.162 7.77515 10.6215 7.47948 10.9039C7.47564 10.9076 7.47188 10.9112 7.46818 10.9147C7.46419 10.9115 7.46013 10.9083 7.456 10.9051C7.13719 10.6519 6.72875 10.2295 6.00113 9.4654L3.2435 6.56972C2.5015 5.79059 1.29849 5.79059 0.556498 6.56972C-0.185497 7.34886 -0.185497 8.61209 0.556498 9.39123L3.31413 12.2869C3.34002 12.3141 3.36587 12.3412 3.39168 12.3684C4.01203 13.02 4.60881 13.6469 5.16407 14.0878C5.78606 14.5817 6.60062 15.0461 7.6445 14.9963C8.68838 14.9466 9.45955 14.4067 10.0364 13.8557C10.5514 13.3639 11.0916 12.6828 11.6532 11.9749C11.6766 11.9454 11.7 11.9159 11.7235 11.8864L18.5596 3.27239C19.2313 2.42592 19.1224 1.16787 18.3163 0.462473Z" fill="#009651" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 32 32" fill="none">
                                        <circle cx="16" cy="16" r="16" fill="#F3F3F3" />
                                        <path d="M17.7925 8L17.5367 18.9463H15.3411L15.0746 8H17.7925ZM15 22.3037C15 21.9129 15.1279 21.586 15.3837 21.3231C15.6466 21.0531 16.009 20.9181 16.4709 20.9181C16.9256 20.9181 17.2845 21.0531 17.5474 21.3231C17.8103 21.586 17.9417 21.9129 17.9417 22.3037C17.9417 22.6803 17.8103 23.0036 17.5474 23.2736C17.2845 23.5365 16.9256 23.668 16.4709 23.668C16.009 23.668 15.6466 23.5365 15.3837 23.2736C15.1279 23.0036 15 22.6803 15 22.3037Z" fill="#898989" />
                                    </svg>
                                @endif
                                <p class="ltr:ml-2.5 rtl:mr-2.5 leading-5 mt-1">{{ $message }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @break
@endif
@endforeach
@if ($errors->any())
<div class="absolute hide-notification-popup z-10 ltr:right-0 rtl:left-0">
    @foreach ($errors->all() as $error)
        <div class="{{ $msg == 'fail' ? '' : 'border-reds-1 bg-white ' }} w-417 dm-sans font-medium text-gray-12 text-lg ltr:pl-30p rtl:pr-30p py-30p border-b-4 rounded hidden xl:block mt-10"
            role="alert" x-data="{ open: true }" x-show.transition="open">
            <div class="flex justify-between">
                <div class="flex">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"
                        fill="none">
                        <circle cx="16" cy="16" r="16" fill="#F3F3F3" />
                        <path d="M17.7925 8L17.5367 18.9463H15.3411L15.0746 8H17.7925ZM15 22.3037C15 21.9129 15.1279 21.586 15.3837 21.3231C15.6466 21.0531 16.009 20.9181 16.4709 20.9181C16.9256 20.9181 17.2845 21.0531 17.5474 21.3231C17.8103 21.586 17.9417 21.9129 17.9417 22.3037C17.9417 22.6803 17.8103 23.0036 17.5474 23.2736C17.2845 23.5365 16.9256 23.668 16.4709 23.668C16.009 23.668 15.6466 23.5365 15.3837 23.2736C15.1279 23.0036 15 22.6803 15 22.3037Z" fill="#898989" />
                    </svg>
                    <p class="ltr:ml-2.5 rtl:mr-2.5 leading-5 mt-1 w-312p">{{ $error }}</p>
                </div>
                <span class="cursor-pointer rounded-full mt-1 ltr:mr-3 rtl:ml-3" x-on:click="open = false">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-12" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect x="0" y="0" width="16" height="16" stroke="none">
                        </rect>
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </span>
            </div>
        </div>
    @endforeach
</div>
<div class="my-auto block xl:hidden" x-data="{ showModal1: true }" :class="{ 'overflow-y-hidden': showModal1 }">
    <!-- Modal1 -->
    <div class="fixed inset-0 bg-black bg-opacity-50 pt-60 duration-300 z-50 overflow-y-auto" x-show="showModal1"
        x-transition:enter="transition duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="relative sm:w-1/2 sm:mx-auto mx-5 my-10 opacity-100">
            <div class="relative bg-white shadow-lg rounded-md text-gray-900 z-50"
                @click.away="showModal1 = false" x-show="showModal1"
                x-transition:enter="transition transform duration-300" x-transition:enter-start="scale-0"
                x-transition:enter-end="scale-100" x-transition:leave="transition transform duration-300"
                x-transition:leave-start="scale-100" x-transition:leave-end="scale-0">
                <div class="{{ $msg == 'fail' ? ' ' : 'border-reds-1 ' }} bg-white mx-auto dm-sans font-medium text-gray-12 text-sm mt-10 px-30p py-30p border-b-4 rounded"
                    role="alert" x-data="{ open: true }" x-show.transition="open">
                    <div class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                            viewBox="0 0 32 32" fill="none">
                            <circle cx="16" cy="16" r="16" fill="#F3F3F3" />
                            <path d="M17.7925 8L17.5367 18.9463H15.3411L15.0746 8H17.7925ZM15 22.3037C15 21.9129 15.1279 21.586 15.3837 21.3231C15.6466 21.0531 16.009 20.9181 16.4709 20.9181C16.9256 20.9181 17.2845 21.0531 17.5474 21.3231C17.8103 21.586 17.9417 21.9129 17.9417 22.3037C17.9417 22.6803 17.8103 23.0036 17.5474 23.2736C17.2845 23.5365 16.9256 23.668 16.4709 23.668C16.009 23.668 15.6466 23.5365 15.3837 23.2736C15.1279 23.0036 15 22.6803 15 22.3037Z" fill="#898989" />
                        </svg>
                        <p class="ltr:ml-2.5 rtl:mr-2.5 leading-5 mt-1">{{ $error }} </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
{{-- @endforeach --}}
<script src="{{ asset('/public/dist/js/custom/site/notification-popup.min.js') }}"></script>
