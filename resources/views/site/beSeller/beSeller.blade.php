@extends('../site/layouts.app')
@section('page_title', __('Details'))
@section('content')
    <!-- component -->
    <div class="bg-image md:bg-cover">
        <div class="lg:mx-4 2xl:mx-64 xl:mx-32 mx-5 ltr:3xl:mr-36 ltr:3xl:ml-92 ltr:md:text-left rtl:3xl:ml-36 rtl:3xl:mr-92 rtl:md:text-right md:flex md:justify-between md:items-start items-center text-center justify-center">
            <div class="xl:pt-135p lg:pt-28 lg:2/5 md:w-1/2 pt-52p text-gray-12">
                <p class="mt-1 dm-sans font-medium lg:text-xl md:text-lg text-15">{{ __('Want your shop to go online?') }}</p>
                <p class="dm-bold lg:mt-2 seller-title leading-60p uppercase mt-2.5 lg:text-46 md:text-40 text-3xl font-bold">{{ __('Become a seller') }}</p>
                <p class="font-normal dm-regular lg:mt-5p mt-2 lg:mx-0 lg:px-0 mx-auto lg:text-26 md:text-base xs:text-lg text-base">{{ __('And millions of shoppers can’t wait to') }}</p>
                <p class="font-normal dm-regular lg:mt-3.5 lg:mx-0 lg:px-0 mx-auto lg:text-26 md:text-base xs:text-lg text-base">{{ __('See what you have in store!') }}</p>
                <div class="md:justify-start justify-center flex">
                    <a class="flex process-goto relative lg:mt-30p md:mt-15p mt-30p text-base w-180 h-46p justify-center text-center rounded-sm border border-gray-12 items-center primary-bg-color dm-bold font-bold"
                        href="{{ route('site.seller-registration') }}">{{ __('Register Now') }}<svg class="ltr:ml-1.5 rtl:mr-1.5 relative neg-transition-scale"
                            xmlns="http://www.w3.org/2000/svg" width="13" height="8" viewBox="0 0 13 8" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M8.92948 0L7.75346 1.20177L9.66016 3.15022H1.68894C1.22968 3.15022 0.857371 3.53068 0.857371 4C0.857371 4.46932 1.22968 4.84978 1.68894 4.84978H9.66016L7.75346 6.79823L8.92948 8L12.8438 4L8.92948 0Z"
                                fill="#2C2C2C" />
                        </svg></a>
                </div>
            </div>
            <div>
                <img class="2xl:w-850p md:h-521 md:w-532p 2xl:mt-0 xs:w-322p xs:h-52 mx-auto md:mt-16 mt-9" src="{{ asset('public/frontend/assets/img/be-seller/header_image.svg')}}" alt="{{ __('Image') }}">
            </div>
        </div>
    </div>
    <div class="xl:mt-33 lg:mt-70p mt-50p mx-4 text-center lg:mx-4 2xl:mx-64 3xl:mx-92">
        <p class="dm-bold font-bold text-gray-12 lg:text-lg uppercase text-15">{{ __('Why sell on multivendor?') }}</p>
        <div class="primary-bg-color lg:h-1.5 h-5p lg:w-64 w-216p mx-auto -mt-3">
        </div>
        <p class="dm-sans font-normal text-gray-12 lg:text-2xl text-base lg:mt-21p mt-18p lg:px-56 md:px-40 px-0">{{ __('Join a
            online mega marketplace where nearly 50 million buyers around the world shop for unique items ')}}</p>
        <div class="xl:mx-32 mx-5 2xl:mx-0 grid md:grid-cols-3 grid-cols-1 lg:mt-50p mt-8 lg:gap-10 gap-0">
            <div class="hover:bg-gray-20 hover:rounded-lg cursor-pointer transition ease-in-out delay-130">
                <img class="mx-auto lg:my-50p mt-30p mb-6 lg:w-105p lg:h-84p w-72p h-14"
                    src="{{ asset('public/frontend/assets/img/be-seller/low-fees.svg')}}" alt="{{ __('Image') }}">
                <p class="text-gray-12 lg:text-22 text-lg dm-bold font-bold lg:mb-7 mb-3 uppercase">{{ __('Low fees') }}</p>
                <p class="text-gray-10 lg:text-base text-sm lg:mx-6 mx-7 lg:mb-70p mb-7 roboto-medium font-medium">{{ __('It
                    doesn’t take much to list your items and once you make a sale, Multivendor’s transaction fee is just 2.5%') }}</p>
            </div>
            <div class="hover:bg-gray-20 hover:rounded-lg cursor-pointer transition ease-in-out delay-130">
                <img class="mx-auto lg:mt-50p lg:mb-14 mb-6 mt-30p lg:w-90p lg:h-78p w-60p h-53p"
                    src="{{ asset('public/frontend/assets/img/be-seller/swift.svg') }}" alt="{{ __('Image') }}">
                <p class="text-gray-12 lg:text-22 text-lg dm-bold font-bold lg:mb-7 mb-3 uppercase">{{ __('Swift System') }}</p>
                <p class="text-gray-10 lg:text-base text-sm lg:mx-6 mx-7 lg:mb-66p mb-7 roboto-medium font-medium">{{ __('Our tools
                    are designed based on the best e-commerce experience for both sellers and customers.') }}</p>
            </div>
            <div class="hover:bg-gray-20 hover:rounded-lg cursor-pointer transition ease-in-out delay-130">
                <img class="mx-auto lg:my-50p mt-30p mb-6 lg:w-105p lg:h-84p w-72p h-14"
                    src="{{ asset('public/frontend/assets/img/be-seller/support.svg') }}" alt="{{ __('Image') }}">
                <p class="text-gray-12 lg:text-22 text-lg dm-bold font-bold lg:mb-7 mb-3 uppercase">{{ __('24/7 support') }}</p>
                <p class="text-gray-10 lg:text-base text-sm lg:mx-6 mx-7 lg:mb-70p mb-7 roboto-medium font-medium">{{ __('We have a
                    well trained dedicated service team that is available all the time for any troubleshooting.')}}</p>
            </div>
        </div>
        <div class="xl:mt-130p lg:mt-70p mt-54p">
            <p class="dm-bold font-bold text-gray-12 lg:text-lg text-15 uppercase">{{ __('The process') }}</p>
            <div class="primary-bg-color h-1.5 lg:w-120p w-97p mx-auto -mt-3">
            </div>
            <p class="lg:mt-21p mt-18p dm-bold font-bold text-gray-12 uppercase lg:text-26 tex-lg lg:px-0 px-4">{{ __('Become a
                successful seller in 3 easy steps') }}
            </p>
            <div class="lg:mx-16 2xl:mx-0 grid lg:grid-cols-2 grid-cols-1 lg:mt-70p mt-35p">
                <div class="ltr:lg:mr-60p rtl:lg:ml-60p mx-auto lg:text-right text-center">
                    <p class="dm-bold font-bold lg:text-26 text-lg text-gray-12 uppercase lg:mb-2 mb-2.5">{{ __('Step 1') }}</p>
                    <p class="dm-sans font-medium lg:text-xl text-base text-gray-12 lg:mb-50p mb-7">{{ __('Register & list your
                        products') }}</p>
                    <div class="roboto-medium font-medium text-gray-10 lg:text-base text-sm ">
                        <div class="flex lg:items-end lg:justify-end items-start text-left lg:text-right justify-start mb-5">
                            <img class="ltr:mr-3 rtl:ml-3 mt-1 lg:hidden block"
                                src="{{ asset('public/frontend/assets/img/be-seller/arrow-left.svg') }}" alt="{{ __('Image') }}">
                            <p>{{ __('Fill in the sign up form with your personal and shop details') }}</p>
                            <img class="ltr:ml-3 rtl:mr-3 mb-1.5 lg:block hidden" src="{{ asset('public/frontend/assets/img/be-seller/arrow-right.svg') }}" alt="{{ __('Image') }}">
                        </div>
                        <div class="flex lg:items-end lg:justify-end items-start text-left lg:text-right justify-start mb-5">
                            <img class="ltr:mr-3 rtl:ml-3 mt-1 lg:hidden block" src="{{ asset('public/frontend/assets/img/be-seller/arrow-left.svg') }}" alt="{{ __('Image') }}">
                            <p>{{ __('Login to the vendor dashboard account with your credentials') }}</p>
                            <img class="ltr:ml-3 rtl:mr-3 mb-1.5 lg:block hidden" src="{{ asset('public/frontend/assets/img/be-seller/arrow-right.svg') }}" alt="{{ __('Image') }}">
                        </div>
                        <div class="flex lg:items-end lg:justify-end items-start text-left justify-start mb-5">
                            <img class="ltr:mr-3 rtl:ml-3 mt-1 lg:hidden block"
                                src="{{ asset('public/frontend/assets/img/be-seller/arrow-left.svg') }}" alt="{{ __('Image') }}">
                            <p>{{ __('List your products by providing all relevant information') }}</p>
                            <img class="ltr:ml-3 rtl:mr-3 mb-1.5 lg:block hidden" src="{{ asset('public/frontend/assets/img/be-seller/arrow-right.svg') }}" alt="{{ __('Image') }}">
                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="ltr:mr-60p rtl:ml-60p lg:block hidden items-center">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 34 34" fill="none">
                                <circle cx="17" cy="17" r="17" fill="var(--primary-color)" />
                                <circle cx="16.9992" cy="17" r="6.8" fill="white" />
                            </svg>
                            <svg class="ltr:ml-4 rtl:mr-4" xmlns="http://www.w3.org/2000/svg" width="1" height="400"
                                viewBox="0 0 1 400" fill="none">
                                <line x1="0.5" x2="0.5" y2="400" stroke="#898989" stroke-dasharray="8 8" />
                            </svg>
                        </div>
                    </div>
                    <span class="lg:block hidden h-300p">
                        <img src="{{ asset('public/frontend/assets/img/be-seller/shopping-icon.svg') }}" alt="{{ __('Image') }}">
                    </span>
                    <span class="lg:hidden block mx-auto mt-6">
                        <img src="{{ asset('public/frontend/assets/img/be-seller/shopping-small-icon.svg') }}" alt="{{ __('Image') }}">
                    </span>
                </div>
                <div class=" flex ltr:mr-60p ltr:justify-end rtl:ml-60p rtl:justify-start">
                    <span class="w-421-h-376 lg:block hidden">
                        <img src="{{ asset('public/frontend/assets/img/be-seller/shopping-icon-2.svg') }}" alt="{{ __('Image') }}">
                    </span>
                </div>
                <div class="flex">
                    <div class="ltr:lg:mr-60p rtl:lg:ml-60p lg:block hidden items-center">
                        <div>
                            <svg class="-mt-1" xmlns="http://www.w3.org/2000/svg" width="34" height="34"
                                viewBox="0 0 34 34" fill="none">
                                <circle cx="17" cy="17" r="17" fill="#2C2C2C" />
                            </svg>
                            <svg class="ltr:ml-4 rtl:mr-4" xmlns="http://www.w3.org/2000/svg" width="1" height="440"
                                viewBox="0 0 1 440" fill="none">
                                <line x1="0.5" x2="0.5" y2="440" stroke="#898989" stroke-dasharray="8 8" />
                            </svg>
                        </div>
                    </div>
                    <div class="ltr:lg:text-left rtl:lg:text-right mx-auto lg:mt-0 mt-11 text-center">
                        <p class="dm-bold font-bold lg:text-26 text-lg text-gray-12 uppercase lg:mb-2 mb-2.5">{{ __('Step 2') }}</p>
                        <p class="dm-sans font-medium lg:text-xl text-base text-gray-12 lg:mb-50p mb-7">{{ __('Receive orders &
                            sell your products') }}</p>
                        <div class="roboto-medium xxs:px-10 sm:mx-0 font-medium text-gray-10 lg:text-base text-sm">
                            <div class="flex ltr:text-left ltr:items-start rtl:text-right rtl:items-end justify-start mb-5">
                                <img class="ltr:mr-3 rtl:ml-3 mt-1" src="{{ asset('public/frontend/assets/img/be-seller/arrow-left.svg') }}" alt="{{ __('Image') }}">
                                <p>{{ __('Start selling once products are listed') }}</p>
                            </div>
                            <div class="flex items-start ltr:text-left ltr:items-start rtl:text-right rtl:items-end justify-start mb-5">
                                <img class="ltr:mr-3 rtl:ml-3 mt-1"
                                    src="{{ asset('public/frontend/assets/img/be-seller/arrow-left.svg') }}" alt="{{ __('Image') }}">
                                <p>{{ __('Receive orders and manage them through your vendor dashboard account') }}</p>
                            </div>
                            <div class="flex items-start ltr:text-left ltr:items-start rtl:text-right rtl:items-end justify-start mb-5">
                                <img class="ltr:mr-3 rtl:ml-3 mt-1"
                                    src="{{ asset('public/frontend/assets/img/be-seller/arrow-left.svg') }}" alt="{{ __('Image') }}">
                                <p>{{ __('On receiving orders, simply package the product leave your worries to us.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <img class="lg:hidden block mx-auto mt-6"
                    src="{{ asset('public/frontend/assets/img/be-seller/shopping-small-4.svg') }}" alt="{{ __('Image') }}">
                <div class="ltr:lg:mr-60p rtl:lg:ml-60p mx-auto lg:text-right lg:mt-0 mt-11 text-center">
                    <p class="dm-bold font-bold lg:text-26 text-lg text-gray-12 uppercase lg:mb-2 mb-2.5">{{ __('Step 3') }}</p>
                    <p class="dm-sans font-medium lg:text-xl text-base text-gray-12 lg:mb-50p mb-7">{{ __('Register & list your
                        products') }}</p>
                    <div class="roboto-medium xxs:mx-10 sm:mx-16 lg:mx-0 font-medium text-gray-10 text-base">
                        <div class="flex lg:items-end lg:justify-end items-start ltr:text-left rtl:text-right lg:text-right justify-start mb-5">
                            <img class="ltr:mr-3 rtl:ml-3 mt-1.5 lg:hidden block" src="{{ asset('public/frontend/assets/img/be-seller/arrow-left.svg') }}" alt="{{ __('Image') }}">
                            <p>{{ __('Receive quick and hassle-free payments directly in your account') }}</p>
                            <img class="ltr:ml-3 rtl:mr-3 mb-1.5 lg:block hidden" src="{{ asset('public/frontend/assets/img/be-seller/arrow-right.svg') }}" alt="{{ __('Image') }}">
                        </div>
                        <div class="flex lg:items-end lg:justify-end items-start ltr:text-left rtl:text-right lg:text-right justify-start mb-5">
                            <img class="ltr:mr-3 rtl:ml-3 mt-1 lg:hidden block" src="{{ asset('public/frontend/assets/img/be-seller/arrow-left.svg') }}" alt="{{ __('Image') }}">
                            <p class="ltr:3xl:pl-20 ltr:xl:pl-0 ltr:pl-0 rtl:3xl:pr-20 rtl:xl:pr-0 rtl:pr-0">{{ __('Expand your business. Go furthur through our seasonal
                                sales, offers and events. Rank up and become an asset.') }}</p>
                            <img class="ltr:ml-3 rtl:mr-3 mb-30p lg:block hidden" src="{{ asset('public/frontend/assets/img/be-seller/arrow-right.svg') }}" alt="{{ __('Image') }}">
                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="ltr:mr-60p rtl:ml-60p lg:block hidden items-center">
                        <div>
                            <svg class="-mt-1" xmlns="http://www.w3.org/2000/svg" width="34" height="34"
                                viewBox="0 0 34 34" fill="none">
                                <circle cx="17" cy="17" r="17" fill="var(--primary-color)" />
                            </svg>
                        </div>
                    </div>
                    <span class="h-312p w-441 lg:block hidden">
                        <img src="{{ asset('public/frontend/assets/img/be-seller/shopping-5.svg') }}" alt="{{ __('Image') }}">
                    </span>
                    <span class="lg:hidden block mx-auto mt-6">
                        <img src="{{ asset('public/frontend/assets/img/be-seller/shopping-6.svg') }}" alt="{{ __('Image') }}">
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="xl:mt-130p mt-60p bg-gray-11 bg-cover bg-photo">
        <div class="3xl:mx-92 2xl:mx-64 xl:mx-32 mx-5 md:flex md:justify-between justify-center">
            <div class="lg:pt-70p pt-54p md:w-1/2 dm-sans text-gray-12">
                <div>
                    <p class="ltr:md:text-left rtl:md:text-right text-center dm-bold font-bold text-gray-12 lg:text-lg text-15 uppercase">{{ __('Join us today') }}</p>
                    <div class="primary-bg-color h-1.5 ltr:text-left rtl:text-right lg:w-130p w-28 md:mx-0 mx-auto -mt-3"></div>
                </div>
                <p class="dm-sans lg:mt-18p mt-22p lg:text-26 text-lg ltr:md:text-left rtl:md:text-right text-center font-medium uppercase">{{ __('Gain new customers from') }}</p>
                <p class="font-normal lg:text-40 mt-1p text-26 uppercase ltr:md:text-left rtl:md:text-right text-center"> <span class="primary-text-color mx-1.5">
                    {{ __('All around') }}</span>{{ __('The world!') }}</p>
                <p class="roboto-medium font-medium lg:text-base text-sm lg:mt-4 mt-3.5 lg:w-532p ltr:md:text-left rtl:md:text-right text-center md:px-0 px-5 text-gray-10">  {{ __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Enim placerat metus, sit a. Ut ullamcorper risus tempor porta mauris id.') }}
                  </p>
                <div class="xl:flex mt-7 justify-start ltr:md:text-left rtl:md:text-right text-center items-center">
                    <a class="flex process-goto relative ltr:xl:mr-6 rtl:xl:ml-6 md:mx-0 mx-auto text-base w-44 h-50p justify-center text-center rounded-sm border border-gray-12 items-center primary-bg-color dm-bold font-bold"
                    href="{{ route('site.seller-registration') }}">{{ __('Register Now') }}<svg class="neg-transition-scale ltr:ml-1.5 rtl:mr-1.5 relative" xmlns="http://www.w3.org/2000/svg" width="13" height="8" viewBox="0 0 13 8" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.92948 0L7.75346 1.20177L9.66016 3.15022H1.68894C1.22968 3.15022 0.857371 3.53068 0.857371 4C0.857371 4.46932 1.22968 4.84978 1.68894 4.84978H9.66016L7.75346 6.79823L8.92948 8L12.8438 4L8.92948 0Z" fill="#2C2C2C" />
                        </svg></a>
                    <div class="text-gray-12 md:mb-5 xl:mb-0 mb-0 lg:flex md:mt-15p xl:mt-0 mt-6 text-lg dm-sans font-medium">
                        <p class="md:px-0 xs:px-24 x:px-12">{{ __('Already a seller?') }}
                        <div class="md:px-0 xs:px-20 x:px-12">
                            <a class="underline ltr:ml-2p ltr:mr-1 rtl:mr-2p rtl:ml-1" href="#">{{ __('Login') }}</a>{{ __('to your account.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <img class="xl:w-532p xl:h-411p xl:mt-0 lg:mt-36 lg:w-400p lg:h-312p mx-auto md:mt-32 mt-0 md:px-0 px-5"src="{{ asset('public/frontend/assets/img/be-seller/human.svg') }}" alt="{{ __('Image') }}">
            </div>
        </div>
    </div>
    <div class="lg:mt-130p mt-54p">
        <p class="dm-bold text-center font-bold text-gray-12 lg:text-lg text-15 uppercase">{{ __('Seller stories') }}</p>
        <div class="primary-bg-color h-1.5 lg:w-141p w-116p mx-auto -mt-3">
        </div>
        <p class="lg:mt-21p mt-18p dm-bold font-bold text-center 2xl:mx-92 xs:mx-5 x:mx-2 3xl:px-300p text-gray-12 uppercase lg:text-26 text-lg">{{ __('See sellers share about their success in multivendor') }}
        </p>
    </div>
    <div class="ltr:3xl:ml-92 ltr:3xl:mr-173p rtl:3xl:mr-92 rtl:3xl:ml-173p 2xl:mx-64 xl:mx-32 mx-5 lg:mt-16 mt-8 justify-between md:flex">
        <div class="md:w-1/2 xl:w-42%">
            <div>
                <div class="lg:block hidden">
                    <div class="flex justify-end xl:mt-36">
                        <svg class="neg-transition-scale ltr:mr-4 rtl:ml-4" xmlns="http://www.w3.org/2000/svg" width="17" height="11"
                            viewBox="0 0 17 11" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M5.55152 0L7.21943 1.65243L4.51521 4.33155H15.8206C16.472 4.33155 17 4.85469 17 5.5C17 6.14532 16.472 6.66845 15.8206 6.66845H4.51521L7.21943 9.34757L5.55152 11L0 5.5L5.55152 0Z"
                                fill="#D9D9D9" />
                        </svg>
                        <svg class="neg-transition-scale" xmlns="http://www.w3.org/2000/svg" width="17" height="11" viewBox="0 0 17 11" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4485 0L9.78057 1.65243L12.4848 4.33155H1.17939C0.52803 4.33155 -5.52377e-07 4.85469 -5.52377e-07 5.5C-5.52377e-07 6.14532 0.52803 6.66845 1.17939 6.66845H12.4848L9.78057 9.34757L11.4485 11L17 5.5L11.4485 0Z" fill="#898989" />
                        </svg>
                    </div>
                </div>
                <div class="border md:mt-4 mt-0 mx-0 border-gray-21 rounded-lg">
                    <div class="flex lg:mx-7 mx-15p justify-between">
                        <div class="lg:mt-6 mt-5 flex">
                            <img class="lg:w-16 lg:h-16 w-54p h-54p"src="{{ asset('public/frontend/assets/img/be-seller/seller-human-icon2.svg') }}" alt="{{ __('Image') }}">
                            <div class="ltr:xs:ml-18p ltr:lg:ml-2 ltr:x:ml-2 rtl:xs:mr-18p rtl:lg:mr-2 rtl:x:mr-2 mt-5p lg:mt-2">
                                <p class="text-gray-12 lg:text-xl text-lg dm-sans font-medium">{{ __('Tim Karela') }}</p>
                                <p class="text-gray-10 mt-5p xs:text-13 x:text-xss text-xs roboto-medium font-medium">{{ __('Co-Owner,
                                    Azghar Fashions') }}</p>
                            </div>
                        </div>
                        <div class="mt-8">
                            <img class="lg:w-72p lg:h-47p w-46p h-30p" src="{{ asset('public/frontend/assets/img/be-seller/invert-coma.svg') }}">
                        </div>
                    </div>
                    <p class="roboto-medium font-medium lg:text-sm text-13 text-gray-10 lg:mx-7 mx-15p text-justify leading-6 mt-4 mb-5">{{ __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Enim placerat metus, sit. Ut ullamcorper
                        risus tempor porta mauris id ornaretincidunt. Condimen tum inter dum mi viverra consequat, elementum. Accumsan tempus, ut sit interd um vighaouthsu lo pica lomo esthgilo.') }}
                       </p>
                </div>
            </div>
            <div class="lg:flex ltr:md:text-left rtl:md:text-right text-center lg:mt-10 mt-6">
                <div class="flex md:justify-start justify-center seller-images">
                    <img class="ltr:lg:-mr-6 ltr:-mr-4 rtl:lg:-ml-6 rtl:-ml-4 3xl:w-66p 3xl:h-66p w-12 h-12 "
                        src="{{ asset('public/frontend/assets/img/be-seller/human-icon-3.svg') }}">
                    <img class="ltr:lg:-mr-6 ltr:-mr-4 rtl:lg:-ml-6 rtl:-ml-4 3xl:w-66p 3xl:h-66p w-12 h-12 "
                        src="{{ asset('public/frontend/assets/img/be-seller/human-icon-4.svg') }}">
                    <img class="ltr:lg:-mr-6 ltr:-mr-4 rtl:lg:-ml-6 rtl:-ml-4 3xl:w-66p 3xl:h-66p w-12 h-12 "
                        src="{{ asset('public/frontend/assets/img/be-seller/human-icon-5.svg') }}">
                    <img class="ltr:lg:-mr-6 ltr:-mr-4 rtl:lg:-ml-6 rtl:-ml-4 3xl:w-66p 3xl:h-66p w-12 h-12 "
                        src="{{ asset('public/frontend/assets/img/be-seller/human-icon-6.svg') }}">
                    <img class="ltr:lg:-mr-6 ltr:-mr-4 rtl:lg:-ml-6 rtl:-ml-4 3xl:w-66p 3xl:h-66p w-12 h-12 "
                        src="{{ asset('public/frontend/assets/img/be-seller/human-icon-7.svg') }}">
                    <img class="ltr:lg:-mr-6 ltr:-mr-4 rtl:lg:-ml-6 rtl:-ml-4 3xl:w-66p 3xl:h-66p w-12 h-12 "
                        src="{{ asset('public/frontend/assets/img/be-seller/human-icon-8.svg') }}">
                    <img class="ltr:lg:-mr-6 ltr:-mr-4 rtl:lg:-ml-6 rtl:-ml-4 3xl:w-66p 3xl:h-66p w-12 h-12 "
                        src="{{ asset('public/frontend/assets/img/be-seller/human-icon-9.svg') }}">
                    <img class="ltr:lg:-mr-6 ltr:-mr-4 rtl:lg:-ml-6 rtl:-ml-4 3xl:w-66p 3xl:h-66p w-12 h-12 "
                        src="{{ asset('public/frontend/assets/img/be-seller/human-icon-10.svg') }}">
                </div>
                <div class="xl:pt-5 md:pt-3 pt-5">
                    <a class="text-gray-12 dm-sans font-medium text-sm ltr:md:ml-11 rtl:ml-0 rtl:md:mr-11 rtl:mr-0" href="javascript:void(0)">{{ __('And many more') }}</a>
                </div>
            </div>
        </div>
        <div class="ltr:xl:ml-70p ltr:lg:ml-5 ltr:ml-0 rtl:xl:mr-70p rtl:lg:mr-5 rtl:mr-0">
            <span>
                <img class="h-591-w-708 lg:w-411p w-318p h-263p md:px-5 px-0 mx-auto md:mt-0 mt-11" src="{{ asset('public/frontend/assets/img/be-seller/seller-image-1.png') }}" alt="{{ __('Image') }}">
            </span>
        </div>
    </div>
    <div class="bg-gray-11">
        <div class="xl:mt-130p mt-50p md:mx-5 xl:mx-32 2xl:mx-64 3xl:mx-92 mx-auto">
            <div class="lg:pt-20 pt-54p">
                <p class="dm-bold text-center font-bold text-gray-12 lg:text-lg text-15 uppercase">{{ __('frequestly asked
                    questions') }}</p>
                <div class="primary-bg-color h-1.5 lg:w-275p w-225p mx-auto -mt-3">
                </div>
                <p class="lg:mt-21p mt-18p dm-bold font-bold text-gray-12 text-center uppercase lg:text-26 text-lg">{{ __('Common
                    questions about multivendor') }}
                </p>
            </div>
            <div>
                <div class="mt-12 grid lg:grid-cols-2 grid-cols-1 gap-30p">
                    <div class="mx-5 lg:mx-0">
                        <div class="bg-white w-full border border-gray-2" x-data="{ selected: 1 }">
                            <ul class="shadow-box">
                                <li class="border border-b">
                                    <div>
                                      <p class="accordion__title w-full cursor-pointer lg:px-5 px-15p py-4 text-gray-12 dm-sans font-medium lg:text-lg text-15 ltr:text-left rtl:text-right">{{ __('How do fees work on Multivendor?') }}</p>
                                        <div class="px-5 py-0 accordion__des robot-medium font-medium text-justify lg:text-sm text-13 text-gray-10">
                                            <div class="border-t border-gray-2 mx-5 items-center text-center"></div>
                                           <p class="pt-4 px-5">{{ __('Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit quis autem ipsa asperiores eum architecto tempora facere porro perspiciatis
                                            debitis ducimus, obcaecati adipisci totam, id quod doloremque nulla.Tempora obcaecati dolorem veniam architecto suscipit non explicabo amet repellendus Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit quis autem ipsa asperiores eum architecto tempora facere porro perspiciatis debitis ducimus, obcaecati adipisci totam, id quod doloremque nulla.Tempora obcaecati dolorem veniam architecto suscipit non explicabo
                                            amet repellendus Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit quis
                                            autem ipsa asperiores eum architecto tempora facere porro perspiciatis debitis ducimus, obcaecati adipisci totam, id quod doloremque nulla.Tempora obcaecati dolorem veniam architecto suscipit non explicabo amet repellendus ') }}
                                           </p>
                                          </div>
                                    </div>
                                </li>
                                <li class="border border-b">
                                    <div>
                                      <p class="accordion__title w-full cursor-pointer lg:px-5 px-15p py-18p text-gray-12 dm-sans font-medium lg:text-lg text-15 ltr:text-left rtl:text-right">{{ __('How do I get paid?') }}</p>
                                        <div class="px-5 py-0 accordion__des robot-medium font-medium text-justify lg:text-sm text-13 text-gray-10">
                                            <div class="border-t border-gray-2 mx-5 items-center text-center"></div>
                                                 <p class="pt-4 px-5 pb-5">{{ __('Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit quis autem ipsa asperiores eum architecto tempora facere porro perspiciatis debitis ducimus, obcaecati adipisci totam, id quod doloremque nulla.Tempora obcaecati dolorem veniam architecto suscipit non explicabo amet repellendus Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit quis autem ipsa asperiores eum architecto tempora facere porro perspiciatis debitis ducimus, obcaecati adipisci totam, id quod doloremque nulla.Tempora obcaecati dolorem veniam architecto suscipit non explicabo amet repellendus Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit quis autem ipsa asperiores eum architecto tempora facere porro perspiciatis debitis ducimus, obcaecati adipisci totam, id quod doloremque nulla.Tempora obcaecati dolorem veniam architecto suscipit non explicabo amet repellendus ') }}
                                           </p>
                                          </div>
                                    </div>
                                </li>
                                <li class="border border-b">
                                    <div>
                                      <p class="accordion__title w-full cursor-pointer lg:px-5 px-15p py-18p text-gray-12 dm-sans font-medium lg:text-lg text-15 ltr:text-left rtl:text-right">{{ __('What documents do I need for registration?')}}</p>
                                        <div class="px-5 py-0 accordion__des robot-medium font-medium text-justify lg:text-sm text-13 text-gray-10">
                                            <div class="border-t border-gray-2 mx-5 items-center text-center"></div>
                                                 <p class="pt-4 px-5 pb-5">{{ __('Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit quis autem ipsa asperiores eum architecto tempora facere porro perspiciatis debitis ducimus, obcaecati adipisci totam, id quod doloremque nulla.Tempora obcaecati dolorem veniam architecto suscipit non explicabo amet repellendus Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit quis autem ipsa asperiores eum architecto tempora facere porro perspiciatis debitis ducimus, obcaecati adipisci totam, id quod doloremque nulla.Tempora obcaecati dolorem veniam architecto suscipit non explicabo amet repellendus Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit quis autem ipsa asperiores eum architecto tempora facere porro perspiciatis debitis ducimus, obcaecati adipisci totam, id quod doloremque nulla.Tempora obcaecati dolorem veniam architecto suscipit non explicabo amet repellendus ') }}
                                                 </p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="mx-5 lg:mx-0">
                        <div class="bg-white border border-gray-2">
                            <ul>
                                <li class="border border-b">
                                    <div>
                                      <p class="accordion__title w-full cursor-pointer lg:px-5 px-15p py-18p text-gray-12 dm-sans font-medium lg:text-lg text-15 ltr:text-left rtl:text-right">{{ __('How do I get paid?')}}</p>
                                        <div class="px-5 py-0 accordion__des robot-medium font-medium text-justify lg:text-sm text-13 text-gray-10">
                                            <div class="border-t border-gray-2 mx-5 items-center text-center"></div>
                                            <p class="pt-4 px-5 pb-5">{{ __('Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit quis autem ipsa asperiores eum architecto tempora facere porro perspiciatis
                                            debitis ducimus, obcaecati adipisci totam, id quod doloremque nulla.Tempora obcaecati dolorem veniam architecto suscipit non explicabo amet repellendus Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit quis autem ipsa asperiores eum architecto tempora facere porro perspiciatis debitis ducimus, obcaecati adipisci totam, id quod doloremque nulla.Tempora obcaecati dolorem veniam architecto suscipit non explicabo
                                            amet repellendus Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit quis
                                            autem ipsa asperiores eum architecto tempora facere porro perspiciatis debitis ducimus, obcaecati adipisci totam, id quod doloremque nulla.Tempora obcaecati dolorem veniam architecto suscipit non explicabo amet repellendus ') }}
                                            </p>
                                     </div>
                                    </div>
                                </li>
                                <li class="border border-b">
                                    <div>
                                      <p class="accordion__title w-full cursor-pointer lg:px-5 px-15p py-18p text-gray-12 dm-sans font-medium lg:text-lg text-15 ltr:text-left rtl:text-right">{{ __('Do I need a debit card or credit card to create a shop?')}}</p>
                                        <div class="px-5 py-0 accordion__des robot-medium font-medium text-justify lg:text-sm text-13 text-gray-10">
                                            <div class="border-t border-gray-2 mx-5 items-center text-center"></div>
                                                <p class="pt-4 px-5 pb-5">{{ __('Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit quis autem ipsa asperiores eum architecto tempora facere porro perspiciatis debitis ducimus, obcaecati adipisci totam, id quod doloremque nulla.Tempora obcaecati dolorem veniam architecto suscipit non explicabo amet repellendus Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit quis autem ipsa asperiores eum architecto tempora facere porro perspiciatis debitis ducimus, obcaecati adipisci totam, id quod doloremque nulla.Tempora obcaecati dolorem veniam architecto suscipit non explicabo amet repellendus Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit quis autem ipsa asperiores eum architecto tempora facere porro perspiciatis debitis ducimus, obcaecati adipisci totam, id quod doloremque nulla.Tempora obcaecati dolorem veniam architecto suscipit non explicabo amet repellendus ') }}
                                               </p>
                                          </div>
                                    </div>
                                </li>
                                <li class="border border-b">
                                    <div>
                                      <p class="accordion__title w-full cursor-pointer lg:px-5 px-15p py-18p text-gray-12 dm-sans font-medium lg:text-lg text-15 ltr:text-left rtl:text-right">{{ __('Do you have any courier partners?')}}</p>
                                        <div class="px-5 accordion__des robot-medium font-medium text-justify lg:text-sm text-13 text-gray-10">
                                            <div class="border-t border-gray-2 mx-5 items-center text-center"></div>
                                                <p class="pt-4 px-5 pb-5">{{ __('Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit quis autem ipsa asperiores eum architecto tempora facere porro perspiciatis debitis ducimus, obcaecati adipisci totam, id quod doloremque nulla.Tempora obcaecati dolorem veniam architecto suscipit non explicabo amet repellendus Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit quis autem ipsa asperiores eum architecto tempora facere porro perspiciatis debitis ducimus, obcaecati adipisci totam, id quod doloremque nulla.Tempora obcaecati dolorem veniam architecto suscipit non explicabo amet repellendus Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit quis autem ipsa asperiores eum architecto tempora facere porro perspiciatis debitis ducimus, obcaecati adipisci totam, id quod doloremque nulla.Tempora obcaecati dolorem veniam architecto suscipit non explicabo amet repellendus ') }}
                                               </p>
                                          </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:mt-60p mt-9 lg:pb-20 pb-11 text-center">
                <p class="text-gray-12 lg:text-23 text-lg xs:px-16 x:p-8 lg:px-0 dm-sans font-medium">{{ __('Still have more
                    questions? Feel free to contact us.')}}
                </p>
                <a class="flex process-goto relative lg:mt-30p mt-18p text-base w-215 mx-auto h-50p justify-center text-center rounded-sm items-center primary-bg-color dm-bold font-bold"
                    href="#">{{ __('Contact Us')}}<svg class="neg-transition-scale ltr:ml-1.5 rtl:mr-1.5 relative" xmlns="http://www.w3.org/2000/svg" width="13" height="8"
                        viewBox="0 0 13 8" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.92948 0L7.75346 1.20177L9.66016 3.15022H1.68894C1.22968 3.15022 0.857371 3.53068 0.857371 4C0.857371 4.46932 1.22968 4.84978 1.68894 4.84978H9.66016L7.75346 6.79823L8.92948 8L12.8438 4L8.92948 0Z" fill="#2C2C2C" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
    <div class="lg:mt-130p mt-11">
        <div class="ltr:3xl:ml-92 rtl:xl:ml-32 rtl:3xl:mr-92 rtl:xl:mr-32 2xl:mx-64 md:mx-5 md:flex justify-between">
            <div class="mt-70p md:w-2/5 dm-sans text-gray-12">
                <div class="items-center flex justify-center md:justify-start">
                    <img src="{{ asset('public/frontend/assets/img/be-seller/multivendor_logo.svg') }}" alt="{{ __('Image') }}">
                </div>
                <p class="dm-bold font-bold ltr:lg:mr-32 ltr:lg:ml-0 rtl:lg:ml-32 rtl:lg:mr-0 xs:mx-16 x:8 ltr:md:text-left rtl:md:text-right text-center lg:text-32 text-2xl mt-18p text-gray-12 uppercase">{{ __('Vendor')}}<span class="primary-text-color mx-1.5">{{ __('Mobile app')}}</span>{{ __('Coming soon..')}}</p>
                <p class="roboto-medium font-medium mt-15p lg:text-base text-sm text-center ltr:md:text-left rtl:md:text-right lg:w-532p md:px-0 px-5 lg:px-0 text-gray-10"> {{ __('We are here to give all the solution you need to run your online business. And that’s why we are coming up with an individual mobile app for our sellers. Stay updated online anywhere anytime.')}}
                   </p>
                <p class="dm-sans font-medium text-gray-12 ltr:md:text-left rtl:md:text-right text-center lg:text-lg text-15 mt-30p">{{ __('Subscribe to
                    receive the app when it launches!')}}
                </p>
                <div class="flex ltr:pr-3 rtl:pl-3 md:mx-0 mx-5 lg:mx-0 text-gray-22 items-center relative border border-gray-2 lg:w-354p h-46p mt-3 lg:mt-1.5 bg-white">
                    <input class="border-0 text-sm focus:outline-none w-345p px-15p text-gray-22 font-15 roboto-medium font-medium" placeholder="Email address here" type="text" name="email"/>
                    <button type="submit" class="absolute process-goto ltr:right-1 ltr:ml-3 rtl:left-1 rtl:mr-3 border border-gray-2 primary-bg-color rounded-sm">
                        <svg class="mx-11p my-13p relative neg-transition-scale" xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.08128 0L6.90393 1.20177L8.81279 3.15022H0.832512C0.372728 3.15022 0 3.53068 0 4C0 4.46932 0.372728 4.84978 0.832512 4.84978H8.81279L6.90393 6.79823L8.08128 8L12 4L8.08128 0Z" fill="#2C2C2C" />
                        </svg>
                    </button>
                </div>
                <div class="form-check flex justify-center md:justify-start items-center lg:items-left text-center lg:mt-3.5 mt-18p">
                    <input class="h-4 w-4 border border-gray-2 rounded-sm bg-white text-gray-12 transition duration-200 ltr:mr-2 rtl:ml-2 cursor-pointer" type="checkbox">
                    <label class="form-check-label inline-block text-gray-10 lg:text-sm text-xs dm-sans font-medium">
                        {{ __('Get regular new offers, discounts & more!') }}
                    </label>
                </div>
            </div>
            <div class="z-index-negative">
                <img class="w-833-h-744 -mb-32 xl:mt-49p x:px-5 mx-auto mt-50p md:mt-40 m-290 md:-mb-275p md:h-411p md:w-690p" src="{{ asset('public/frontend/assets/img/be-seller/mobile.svg') }}" alt="{{ __('Image') }}">
            </div>
        </div>
    </div>
@endsection
@section('js')
<script src="{{ asset('/public/dist/js/custom/site/be-seller.min.js') }}"></script>
@endsection
