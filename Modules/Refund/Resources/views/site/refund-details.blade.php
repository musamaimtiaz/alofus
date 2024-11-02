@extends('../site/layouts.user_panel.app')
@section('page_title', __('Refund Details'))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/lightbox/css/lightbox.min.css') }}">
@endsection
@section('content')
    <div class="dark:bg-red-1 h-full xl:px-74p px-5 pt-30p xl:pt-14">
        <div class="md:flex md:justify-between">
            <div>
                <div class="flex items-center">
                    <span class="ltr:mr-4 rtl:ml-4 lg:mt-0 mt-1">
                        <svg class="h-30p w-10 xl:w-53p xl:h-11 neg-transition-scale" xmlns="http://www.w3.org/2000/svg" width="53" height="44" viewBox="0 0 53 44" fill="none">
                            <rect x="36.1779" y="27.377" width="16.6222" height="16.6222" rx="2" fill="#FCCA19" />
                            <rect width="32.2667" height="32.2667" rx="2" fill="#FCCA19" />
                        </svg>
                    </span>
                    <h1 class="dm-sans font-medium lg:pt-0 text-2xl xl:text-4xl text-gray-12 mb-1 dark:text-gray-2">
                        {{ __('Refund Details') }}
                    </h1>
                </div>
                <p class="dark:text-gray-2 lg:mt-1.5 roboto-medium font-medium text-base xl:text-xl mt-2 text-20 text-gray-10 leading-6"> {{ __('We got you covered about your concern..') }}</p>
            </div>
            <div>
                <a href="{{ route('site.refundRequest') }}" class="flex relative md:mt-2 mt-30p arrow-hover font-medium dm-sans text-gray-10 text-base rounded-sm ltr:pl-4 rtl:pr-4">
                    <svg class="mt-2 absolute ltr:mr-3 rtl:ml-3 neg-transition-scale" width="15" height="10" viewBox="0 0 15 10" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M4.70711 0L6.12132 1.41421L3.82843 3.70711H13.4142C13.9665 3.70711 14.4142 4.15482 14.4142 4.70711C14.4142 5.25939 13.9665 5.70711 13.4142 5.70711H3.82843L6.12132 8L4.70711 9.41421L0 4.70711L4.70711 0Z"
                            fill="currentColor" />
                    </svg>
                    <span class="ltr:ml-4 rtl:mr-4 dm-sans font-medium">{{ __('Back') }}</span>
                </a>
            </div>
        </div>
        <div class="flex 2xl:flex-row flex-col gap-50p md:mt-74p mt-4">
            <div class="lg:w-480p">
                <div>
                    <div class="flex cursor-pointer rounded justify-between xl:p-10 p-5 border-t border border-gray-2 ltr:xl:pr-20 rtl:xl:pl-20">
                        <div >
                            <div class="mb-9">
                                <p class="text-gray-10 lg:text-sm text-13 roboto-medium font-medium lg:mb-2 mb-1.5 uppercase">
                                    {{ __('Reference') }}
                                </p>
                                <p class="dm-bold text-lg font-bold text-gray-12">
                                    {{ $refund->reference }}
                                </p>
                            </div>
                            <div class= "justify-start items-start">
                                <p class="text-gray-10 lg:text-sm text-13 roboto-medium font-medium lg:mb-2 mb-1.5 uppercase">
                                    {{ __('Refund Reason') }}
                                </p>
                                <p class="dm-sans text-lg font-medium w-36 text-gray-12">{{ optional($refund->refundReason)->name }}</p>
                            </div>
                        </div>
                        <div>
                            <div class="mb-8">
                                <p class="text-gray-10 lg:text-sm text-13 roboto-medium font-medium mb-2 uppercase">
                                    {{ __('Status') }}
                                </p>

                                @php
                                    $color = ['Opened' => 'bg-gray-11 ; text-gray-10 ', 'In progress' => 'bg-green-2 ; text-green-1', 'Accepted' => 'bg-green-2 ; text-green-1', 'Declined' => 'bg-pinks-2 ; text-reds-3'];
                                @endphp
                                <p class="{{ $color[$refund->status] }} roboto-medium font-medium px-4 py-1 text-center rounded text-base dark:text-gray-2">
                                    {{ $refund->status }}
                                </p>
                            </div>
                            <div class="justify-start items-start">
                                <p class="text-gray-10 lg:text-sm text-13 roboto-medium font-medium mb-2 uppercase">
                                    {{ __('Refund Amount') }}
                                </p>
                                <p class="dm-sans text-lg font-medium text-gray-12">
                                    {{ formatNumber($refund->quantity_sent * optional($refund->orderDetail)->price) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lg:p-10 p-5 border lg:mt-50p mt-5 border-gray-2 rounded">
                    <p class="dm-bold font-bold lg:mb-5 mb-4 text-gray-12 lg:text-xl text-base">{{ __('Product Details') }}</p>
                    <div class="flex items-center lg:mb-10 mb-5">
                        <div class="bg-gray-11 lg:h-28 h-72p lg:w-28 w-72p justify-center p-3 flex items-center rounded">
                                <img class="lh-full w-full" src="{{ $refund->getRefundImage() }}"
                                     alt="{{ __('Image') }}" />
                        </div>
                        <div class="text-left items-center ltr:ml-5 rtl:mr-5 dm-sans text-gray-12">
                            <p class="text-sm lg:text-lg font-bold">{{ formatNumber(optional($refund->orderDetail)->price) }}</p>
                            <p class="text-13 lg:text-lg">
                                {{ trimWords(optional(optional($refund->orderDetail)->item)->name, 50) }}
                            </p>
                        </div>
                    </div>
                    <div class="flex mb-10">
                        <div class="roboto-medium font-medium capitalize lg:text-base text-xs ltr:mr-50p rtl:ml-50p text-gray-10">
                            <p>{{ __('Seller') }}</p>
                            @if ($refund->orderDetail->payloads != null)
                            @foreach (json_decode($refund->orderDetail->payloads) as $key => $payload)
                                <p>{{ $key }}</p>
                            @endforeach
                            @endif
                            <p>{{ __('qty')}}</p>
                        </div>
                        <div class="roboto-medium font-medium capitalize lg:text-base text-xs text-gray-10">
                            <p><span class="ltr:mr-3 rtl:ml-3 whitespace-nowrap">:</span>{{ __(optional(optional($refund->orderDetail)->vendor)->name) }} </p>
                            @if ($refund->orderDetail->payloads != null)
                            @foreach (json_decode($refund->orderDetail->payloads) as $payload)
                                <p><span class="ltr:mr-3 rtl:ml-3">:</span>{{ $payload }}</p>
                            @endforeach
                            @endif
                            <p><span class="ltr:mr-3 rtl:ml-3">:</span>{{ $refund->quantity_sent }}</p>
                        </div>
                    </div>
                    @if($refund->objectFile()->get()->isNotEmpty())
                        <div>
                            <p class="dm-sans lg:text-sm text-xs font-medium text-gray-12 lg:mb-4 mb-3">{{ __('Uploaded Pictures') }}:</p>
                            <div class="flex flex-wrap">
                                @foreach ($refund->filesUrlold() as $file)
                                    <div class="fixSize user-img-con">
                                        <a class="cursor_pointer" href='{{ $file }}' data-lightbox="image-1"> <img class="lg:h-70p h-54p lg:w-70p w-54p rounded mb-4 ltr:lg:mr-18p ltr:mr-4 rtl:lg:ml-18p rtl:ml-4" src='{{ $file }}' alt="" class="img-thumbnail attachment-styles"></a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div>
                @if (count($refundProcesses))
                <div class="refund-details xl:w-556p w-full 2xl:ml-50p 2xl:mt-0 md:mt-50p mb-50p lg:p-6 p-0 mt-5 border border-gray-2 rounded">
                    <p class="dm-bold font-bold m-5 lg:m-0 lg:mb-5 text-gray-12 lg:text-xl text-lg">{{ __('Message Box') }}</p>
                    <div>
                        <div class="flex flex-col max-h-128 p-4 ltr:lg:pl-0 rtl:lg:pr-0 message-box refund-message-box-scroll overflow-auto">
                            @foreach ($refundProcesses as $process)
                                <div>
                                    <div class="flex mb-9">
                                        @if (auth()->user()->id != $process->user->id)
                                            <div class="ltr:mr-3 rtl:ml-3">
                                                <img class="rounded-full h-12 w-12" src="{{ $process->user->fileUrl() }}" alt="">
                                            </div>

                                            <div class="w-full refund-chat">
                                                <div class="flex bio">
                                                    <h5 class="user-name m-0"> <span class="roboto-regular font-normal text-xss text-gray-12">{{ optional($process->user)->name }}</span></h5>
                                                    <p class="title"> <span class="roboto-regular font-normal text-xss text-gray-10">{{ (auth()->user()->role()->name == $process->user->role()->name) ? __('You') : $process->user->role()->name }}</span></p>
                                                </div>
                                                <div class="message">
                                                    <p class="m-0 dm-sans font-normal text-gray-12 lg:text-sm text-xss">{{ $process->note }}</p>
                                                </div>
                                                <p class="time block">
                                                   <span class="roboto-regular font-normal text-xss text-gray-10">{{ strtotime($process->created_at) < strtotime('-3 days') ? timeZoneFormatDate($process->created_at) : \Carbon\Carbon::parse($process->created_at)->diffForhumans() }}</span>
                                                </p>
                                            </div>
                                        @else
                                            <div class="w-full refund-chat">
                                                <div class="flex justify-end bio rtl:gap-2">
                                                    <h5 class="user-name m-0"> <span class="roboto-regular font-normal text-xss text-gray-12">{{ optional($process->user)->name }}</span></h5>
                                                    <p class="title"><span class="roboto-regular font-normal text-xss text-gray-10">{{ (auth()->user()->role()->name == $process->user->role()->name) ? __('You') : $process->user->role()->name }}</span></p>
                                                </div>

                                                <div class="message">
                                                    <p class="m-0 dm-sans font-normal text-gray-12 lg:text-sm text-xss">{{ $process->note }}</p>
                                                </div>

                                                <p class="time block ltr:text-right rtl:text-left">
                                                   <span class="roboto-regular font-normal text-xss text-gray-10">{{ strtotime($process->created_at) < strtotime('-3 days') ? timeZoneFormatDate($process->created_at) : \Carbon\Carbon::parse($process->created_at)->diffForhumans() }}</span>
                                            </p>
                                            </div>

                                            <div class="ltr:ml-3 rtl:mr-3">
                                                <img class="rounded-full h-12 w-12" src="{{ $process->user->fileUrl() }}" alt="">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                @if (in_array($refund->status, ['Opened', 'In progress']))
                <div class="xl:w-556p w-full">
                    <form action="{{ route('site.refundProcess') }}" method="post">
                        @csrf
                        <input type="hidden" name="refund_id" value="{{ $refund->id }}">
                        <textarea name="note" class="border-gray-2 w-full" rows="3" placeholder="{{ __('Enter your message here...') }}"></textarea>
                        <div class="flex">
                            <button type="submit" class="w-full dm-sans transition duration-200 items-center cursor-pointer py-3.5 font-medium text-sm whitespace-nowrap text-white h-46p bg-gray-12 hover:bg-yellow-1 hover:text-gray-12 mb-7p rounded">{{ __('Send') }}</button>
                        </div>
                    </form>
                </div>
                @endif
            </div>
            <div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('public/dist/js/custom/site/common.min.js') }}"></script>
    <script src="{{ asset('public/dist/plugins/lightbox/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/refund.min.js') }}"></script>
@endsection
