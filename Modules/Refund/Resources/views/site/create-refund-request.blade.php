@extends('../site/layouts.user_panel.app')
@section('page_title', __('Create Refund'))
@section('css')
    <link rel="stylesheet" href="{{ asset('Modules/Refund/Resources/assets/css/refund.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/select2/css/select2.min.css') }}">
@endsection
@section('content')
    <div class="dark:bg-red-1 h-full xl:px-74p px-5 pt-30p xl:pt-14 bg-white">
        <div>
            <div class="flex items-center">
                <span class="ltr:mr-4 rtl:ml-4 lg:mt-0 mt-1">
                    <svg class="h-30p w-10 xl:w-53p xl:h-11 neg-transition-scale" xmlns="http://www.w3.org/2000/svg" width="53" height="44" viewBox="0 0 53 44" fill="none">
                        <rect x="36.1779" y="27.377" width="16.6222" height="16.6222" rx="2" fill="#FCCA19" />
                        <rect width="32.2667" height="32.2667" rx="2" fill="#FCCA19" />
                    </svg>
                </span>
                <h1 class="dm-sans font-medium lg:pt-0 text-2xl xl:text-4xl text-gray-12 mb-1 dark:text-gray-2">
                    {{ __('Your Refunds') }}
                </h1>
            </div>
            <p
                class="dark:text-gray-2 lg:mt-1.5 roboto-medium font-medium text-base xl:text-xl mt-4 text-20 text-gray-10 leading-6">
                {{ __('We got you covered about your concern..') }}</p>
        </div>
        <div class="lg:mt-74p mt-10 mb-5 xl:w-2/3 3xl:w-1/2 w-full flex justify-between">
            <p class="dm-bold font-bold text-gray-12 xl:text-2xl lg:text-xl text-lg uppercase">{{ __('Requesting refund') }}</p>
            <a href="{{ route('site.refundRequest') }}"
                class="flex relative lg:mt-2 arrow-hover font-medium dm-sans text-gray-10 text-base ltr:pl-4 rtl:pr-4 rounded-sm">
                <svg class="mt-2 absolute ltr:mr-3 rtl:ml-3 neg-transition-scale" width="15" height="10" viewBox="0 0 15 10" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M4.70711 0L6.12132 1.41421L3.82843 3.70711H13.4142C13.9665 3.70711 14.4142 4.15482 14.4142 4.70711C14.4142 5.25939 13.9665 5.70711 13.4142 5.70711H3.82843L6.12132 8L4.70711 9.41421L0 4.70711L4.70711 0Z"
                        fill="currentColor" />
                </svg>
                <span class="ltr:ml-4 rtl:mr-4 dm-sans font-medium">{{ __('Back') }}</span>
            </a>
        </div>
        <div  class="xl:w-2/3 3xl:w-1/2 w-full border border-gray-2 rounded">
            <p class="ltr:lg:ml-30p ltr:ml-5 rtl:lg:mr-30p rtl:mr-5 lg:mt-30p mt-5 dm-sans font-medium text-gray-12 lg:text-lg text-base">
                {{ __('Required Information') }}</p>
            <p class="ltr:lg:ml-30p ltr:ml-5 rtl:lg:mr-30p rtl:mr-5 mt-2 roboto-medium font-medium text-gray-10 lg:text-base text-sm">
                {{ __('Please fill in accurate details for the refund of the product.') }}
            </p>
            <form action="{{ route('site.orderRefund') }}" method="POST" enctype="multipart/form-data"  class="lg:mt-60p mt-9 3xl:px-40 2xl:px-32 xl:px-24 lg:px-20 sm:px-20 md:px-5 px-5" >
                @csrf
                <input type="hidden" name="order_detail_id">
                <section class="flex flex-col ltr:sm:mr-4 ltr:md:mr-0 ltr:lg:mr-4 ltr:mr-0 rtl:sm:ml-4 rtl:md:ml-0 rtl:lg:ml-4 rtl:ml-0">
                    <label class="require-profile mb-3p dm-sans font-medium text-sm text-gray-12">{{ __('Select Order Number') }}
                    </label>
                    <select name="order_reference"
                        class="w-full form-control h-46p refund-select border-gray-2 cursor-pointer appearance-none sl_common_bx z-0"
                        required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                        <option value="">{{ __('Select one') }}</option>
                        @foreach ($orders as $key => $value)
                            <option {{ isset(request()->order_id) && request()->order_id == $key ? 'selected' : '' }}
                                value="{{ $value }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </section>
                <section class="flex mt-15p flex-col ltr:sm:mr-4 ltr:md:mr-0 ltr:lg:mr-4 ltr:mr-0 rtl:sm:ml-4 rtl:md:ml-0 rtl:lg:ml-4 rtl:ml-0">
                    <label class="require-profile mb-3p dm-sans font-medium text-sm text-gray-12">{{ __('Select Product') }} </label>
                    <select id="order_items" name="order_items"
                        class="form-control w-full h-46p border-gray-2 cursor-pointer sl_common_bx z-0 refund-select"
                        required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                        <option class="bg-red-100 text-red-300 " value="">{{ __('Select one') }}</option>
                    </select>
                </section>
                <section class="flex flex-col mt-15p ltr:sm:mr-4 ltr:md:mr-0 ltr:lg:mr-4 ltr:mr-0 rtl:sm:ml-4 rtl:md:ml-0 rtl:lg:ml-4 rtl:ml-0">
                    <label class="require-profile mb-3p dm-sans font-medium text-sm text-gray-12">{{ __('Select Quantity') }} </label>
                    <select id="item_quantity" name="quantity_sent"
                        class="form-control w-full h-46p border-gray-2 cursor-pointer refund-select sl_common_bx z-0"
                        required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                        <option value="">{{ __('Select one') }}</option>
                    </select>
                </section>

                <section class="flex flex-col mt-15p ltr:sm:mr-4 ltr:md:mr-0 ltr:lg:mr-4 ltr:mr-0 rtl:sm:ml-4 rtl:md:ml-0 rtl:lg:ml-4 rtl:ml-0">
                     <label class="require-profile mb-3p dm-sans font-medium text-sm text-gray-12">
                    {{ __('Select Your Reason') }}
                </label>
                    <select name="refund_reason_id"
                        class="form-control border-gray-2 cursor-pointer w-full refund-select sl_common_bx z-0" required
                        oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                        <option value="">{{ __('Select one') }}</option>
                        @foreach ($reasons as $reason)
                            <option value="{{ $reason->id }}">{{ $reason->name }}</option>
                        @endforeach
                    </select>
                </section>
                <div class="refund-image w-full">
                    <div id="refund_image" class="flex flex-wrap gap-2">
                    </div>
                </div>
                <div class="flex lg:mt-4 mt-18p w-full">
                    <label
                        class="cursor-pointer flex items-center justify-center text-center lg:h-24 lg:w-24 w-20 h-20 bg-gray-11 mb-9p rounded-md"
                        for="imgInp">
                        <input class="sr-only cursor-pointer" name="image[]" accept="image/*" type='file' id="imgInp"
                            multiple />
                        <img class="m-auto rounded-md" id="blah"
                            src="{{ asset('public/frontend/assets/img/refund/Group 9186.png') }}" alt="your image" />
                    </label>
                    <div class="lg:mt-3.5 mt-1 ltr:ml-4 rtl:mr-4">
                        <p class="dm-sans font-medium lg:text-sm text-13 text-gray-12 whitespace-nowrap lg:mb-3 mb-2">
                            {{ __('Upload Images of the Product') }}
                        </p>
                        <div class="roboto-medium font-medium lg:text-xs text-xss text-gray-10">
                            <p id="image_limit">{{ __('You can upload atmost 5 images.') }}</p>
                            {{ __('Example: product images, receipt papers etc.') }}
                        </div>
                    </div>

                </div>
                <label class="text-red-500" id="image_error"></label>
                <div class="w-full text-right lg:mt-15p mt-18p mb-30p ltr:lg:pr-4 ltr:pr-0 rtl:lg:pl-4 rtl:pl-0">
                    <button type="submit" class="dm-sans transition duration-200 items-center cursor-pointer font-medium text-sm text-white lg:w-52 w-full h-46p bg-gray-12 hover:bg-yellow-1 hover:text-gray-12 rounded">{{ __('Send Request') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        var product_id = "{{ request()->product_id }}";
    </script>
    <script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/common.min.js') }}"></script>
    <script src="{{ asset('Modules/Refund/Resources/assets/js/refund.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>

@endsection
