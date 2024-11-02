@extends('../site/layouts.user_panel.app')
@section('page_title', __('Addresses'))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/select2/css/select2.min.css') }}">
@endsection
@section('content')
    <div class="dark:bg-red-1 h-full xl:relative xl:px-74p px-5 pt-30p xl:pt-14">
        <div>
            <div class="flex">
                <span class="lg:mt-0 mt-1 ltr:mr-4 rtl:ml-4">
                    <svg class="h-30p w-10 xl:w-53p xl:h-11 neg-transition-scale" xmlns="http://www.w3.org/2000/svg" width="53" height="44" viewBox="0 0 53 44" fill="none">
                        <rect x="36.1779" y="27.377" width="16.6222" height="16.6222" rx="2" fill="#FCCA19" />
                        <rect width="32.2667" height="32.2667" rx="2" fill="#FCCA19" />
                    </svg>
                </span>
                <h1 class="dm-sans font-medium lg:pt-0 text-2xl xl:text-4xl text-gray-12 mb-1 dark:text-gray-2">
                    {{ __('Address Book') }}
                </h1>
            </div>
            <p class="dark:text-gray-2 lg:mt-1.5 roboto-medium font-medium text-base xl:text-xl mt-2 text-20 text-gray-10 leading-6">
                {{ __('Your Location, the place you get all the goods received..') }}</p>
        </div>
        {{-- saved address --}}
        @if ($addresses->count() > 0)
            <div class="lg:mt-20 mt-12 ltr:3xl:mr-89p rtl:3xl:ml-89p">
                <div class="flex flex-wrap justify-between items-center">
                    <div class="dm-sans justify-center items-center flex dm-bold font-bold text-gray-12 xl:text-2xl text-lg uppercase"><p>{{ __('Saved addresses') }}</p>
                    </div>
                    @if (count($addresses) > 0)
                        <div class="flex rounded justify-center items-center border border-gray-12">
                            <a href="{{ route('site.addressCreate') }}" class="text-sm lg:px-30p px-4 lg:py-3.5 py-2 whitespace-nowrap transition delay-150 dm-sans font-medium text-gray-12 hover:text-white hover:bg-gray-12">{{ __('+ Add New Address') }}</a>
                        </div>
                    @endif
                </div>
                <div
                    class="grid 2xl:grid-cols-3 lg:grid-cols-2 grid-cols-1 3xl:gap-x-50p 2xl:gap-x-6 lg:gap-x-5 lg:gap-y-10 gap-y-5 mt-3">
                    @foreach ($addresses as $address)
                        <div class="w-full h-full mb-6 px-5 border {{ $address->is_default == 1 ? 'border-yellow-1 bg-yellow-4 dark:border-gray-0 dark:bg-gray-3' : 'border' }} rounded ltr:lg:pl-30p rtl:lg:pr-30p">
                            <div class="flex justify-between w-full">
                                <div class="flex">
                                    <svg class="mt-30p mb-2p neg-transition-scale" xmlns="http://www.w3.org/2000/svg" width="41" height="38" viewBox="0 0 41 38" fill="none">
                                        <rect x="23.3564" y="22.9004" width="10.7315" height="10.7315" rx="2" fill="#FCCA19" />
                                        <rect y="5.22559" width="20.8318" height="20.8318" rx="2" fill="#FCCA19" />
                                        <path d="M19.6072 0.126698C18.5973 0.312351 17.4685 0.683655 16.5328 1.14408C15.3892 1.70846 15.1144 2.07235 15.4783 2.53276C15.7159 2.83723 16.0055 2.79268 16.8967 2.31741C17.8101 1.83471 18.9463 1.45597 19.9562 1.27775C20.9142 1.11437 22.5034 1.1218 23.4688 1.27775C27.2858 1.93125 30.3528 4.64179 31.5707 8.4514C32.8926 12.5729 31.9198 17.1251 28.682 21.9744C27.4566 23.8087 25.8674 25.7394 24.1966 27.4178C23.2237 28.3906 21.8128 29.6827 21.7162 29.6827C21.5009 29.6827 18.8052 27.0613 17.5725 25.6503C13.748 21.2689 11.6612 17.0954 11.3122 13.115C11.0449 10.0629 12.0845 6.79537 14.0153 4.59723C14.3644 4.20365 14.4312 4.08483 14.4312 3.83976C14.4312 3.50559 14.1713 3.24567 13.8445 3.24567C13.5846 3.24567 12.8271 4.03284 12.2182 4.95369C9.64134 8.80785 9.39627 13.8576 11.5573 18.7069L11.7504 19.1376H10.0646C8.45315 19.1376 8.36404 19.145 8.00016 19.3158C7.56944 19.5163 7.1313 19.9916 6.97535 20.4298C6.84911 20.7639 5 35.3563 5 35.9727C5 36.745 5.43814 37.4653 6.12877 37.8069L6.51493 38H21.7088H36.9027L37.2888 37.8069C38.0092 37.4505 38.4176 36.7598 38.4176 35.9281C38.4102 35.6979 38.1206 33.173 37.7567 30.3214L37.1032 25.1305L36.8953 24.9448C36.6576 24.7443 36.3457 24.7592 36.1007 24.982C35.9224 25.1379 35.9299 25.4053 36.1452 27.1207C36.2492 27.893 36.316 28.5391 36.3086 28.5465C36.2937 28.5614 33.7169 28.5614 30.5682 28.554L24.8426 28.5317L25.808 27.492C27.9022 25.2345 29.6102 22.9695 30.8281 20.8085L31.1474 20.2367L32.952 20.2664C35.3506 20.2961 35.2764 20.2515 35.5066 21.9967C35.67 23.2294 35.7442 23.3705 36.2343 23.3705C36.5759 23.3705 36.7839 23.1552 36.7839 22.7913C36.7839 22.2789 36.5611 20.7417 36.4348 20.4075C36.2715 19.9619 35.8556 19.5238 35.41 19.3158C35.0536 19.145 34.9645 19.1376 33.3901 19.1376C32.4767 19.1376 31.7341 19.1153 31.7341 19.0856C31.7341 19.0633 31.8975 18.6401 32.098 18.1425C33.7763 14.0061 33.7392 9.88464 31.994 6.32752C30.4642 3.20854 27.7314 1.04011 24.308 0.223236C23.6322 0.0598602 23.3129 0.0301552 21.9687 0.00787735C20.6543 -0.0144005 20.283 0.00787735 19.6072 0.126698ZM10.124 21.8407V23.4373L10.3171 23.5859C10.5399 23.7567 10.8444 23.7864 11.0226 23.6453C11.2825 23.4448 11.3122 23.2443 11.3122 21.7368V20.2441L11.8098 20.2664L12.3073 20.2887L12.6638 20.9199C12.8643 21.2689 13.2133 21.8407 13.4361 22.2046L13.852 22.8507L13.7925 25.9622C13.7406 28.903 13.748 29.0812 13.8817 29.2966C14.1416 29.7496 14.2084 29.757 17.1937 29.757H19.9043L20.3053 30.106C21.6271 31.2645 21.7459 31.2719 22.8302 30.3511L23.5208 29.757H30.0038C33.5684 29.757 36.4868 29.7644 36.4868 29.7718C36.4868 29.7867 36.5537 30.3139 36.6353 30.9452C36.717 31.5764 36.7839 32.1036 36.7839 32.1111C36.7839 32.1259 35.7962 32.1334 34.5932 32.1334C32.1648 32.1334 32.0831 32.1482 31.8084 32.6012C31.6673 32.824 31.6598 32.9874 31.6598 34.8587V36.8861H30.3974H29.1349V34.8587C29.1349 32.9874 29.1275 32.824 28.9864 32.6012C28.6968 32.1259 28.7933 32.1334 24.605 32.1334H20.8102L20.632 32.319C20.387 32.5566 20.387 32.8982 20.632 33.1359L20.8102 33.3215H24.3822H27.9468V35.1038V36.8861L17.3794 36.8712C7.35409 36.8489 6.80455 36.8415 6.61147 36.7153C6.50008 36.641 6.35156 36.4628 6.28472 36.3217C6.1659 36.0841 6.1659 35.9949 6.29215 34.9701C6.35898 34.3686 6.44067 33.7522 6.46295 33.5963L6.50751 33.3215H12.5895H18.6715L18.8497 33.1359C19.0948 32.8982 19.0948 32.5566 18.8497 32.319L18.6715 32.1334H12.6489H6.62632L6.67088 31.8883C6.71544 31.6135 6.9308 29.9055 6.9308 29.8164C6.9308 29.7867 7.71797 29.757 8.68336 29.757C11.2899 29.757 11.186 29.8535 11.2231 27.2915L11.2528 25.5315L11.0597 25.3384C10.8147 25.0934 10.4731 25.0934 10.2354 25.3384C10.0498 25.5167 10.0498 25.5241 10.0498 27.0464V28.5688H8.56455H7.07189L7.11645 28.3237C7.13873 28.1975 7.35409 26.4672 7.59915 24.4919C7.84421 22.5165 8.07442 20.8456 8.11155 20.7788C8.31948 20.3926 8.66109 20.2738 9.55222 20.259L10.124 20.2515V21.8407ZM16.6368 26.4301C16.8744 26.6974 17.4165 27.2915 17.8398 27.7445L18.6047 28.5688H16.7779H14.951V27.3212C14.951 26.6306 14.9733 25.7172 14.9956 25.2865L15.0476 24.5067L15.6194 25.2196C15.9387 25.6132 16.3917 26.1553 16.6368 26.4301ZM36.9547 33.5592C37.0958 34.3463 37.2443 35.9355 37.1997 36.1583C37.1403 36.4851 36.8804 36.7301 36.5091 36.8192C36.3532 36.8564 35.4694 36.8861 34.5412 36.8861H32.848V35.1038V33.3215H34.8828H36.9175L36.9547 33.5592Z" fill="#2C2C2C" />
                                        <path d="M20.6315 3.47598C19.4433 3.61707 18.1066 4.09234 17.0447 4.74584C16.1832 5.28053 14.9505 6.49099 14.3861 7.36727C11.527 11.7858 13.094 17.6302 17.7724 19.9917C22.0647 22.1527 27.3521 20.4224 29.5131 16.145C30.9093 13.3824 30.7682 10.1669 29.1196 7.49352C28.5849 6.61723 27.2482 5.28053 26.3793 4.74584C24.649 3.68391 22.6291 3.23834 20.6315 3.47598ZM23.2306 4.7607C24.6342 5.06517 25.8446 5.69639 26.8843 6.69149C28.9042 8.60744 29.7137 11.37 29.0379 14.0211C28.169 17.3777 25.1466 19.7318 21.7083 19.7318C17.1635 19.7318 13.5915 15.64 14.2153 11.1472C14.6163 8.2287 16.7847 5.73352 19.6067 4.91665C19.9631 4.81268 20.4755 4.69386 20.7429 4.65673C21.3741 4.56762 22.5771 4.6196 23.2306 4.7607Z" fill="#2C2C2C" />
                                    </svg>
                                    <p class="mt-9 dm-sans font-medium lg:text-lg text-base rtl:lg:ml-4 ltr:ml-2.5 rtl:lg:mr-4 rtl:mr-2.5">
                                        {{ __('Address') . ' ' . $loop->iteration . ' (' . ucfirst(__($address->type_of_place)) . ')' }}
                                    </p>
                                </div>
                                <div class="flex">
                                    <a href="{{ route('site.addressEdit', ['id' => $address->id]) }}">
                                        <svg class="mt-30p border rounded-sm {{ $address->is_default == 1 ? 'border-yellow-1 hover:border-white text-gray-12 rounded address-edit' : 'border' }} text-gray-10 transition ease-in-out delay-130 hover:text-gray-12 hover:border-gray-12 border border-gray-2 ltr:lg:ml-54p ltr:ml-5 rtl:lg:mr-54p rtl:mr-5 neg-transition-scale" xmlns="http://www.w3.org/2000/svg" width="38" height="38"
                                            viewBox="0 0 38 38" fill="none">
                                            <rect x="0.5" y="0.5" width="37" height="37" rx="1.5" fill="white" stroke="#DFDFDF" />
                                            <path d="M22.4647 10.0594C22.3007 10.0891 22.0272 10.1596 21.8593 10.2227C21.1796 10.4713 21.4022 10.2746 16.4491 14.9727C13.7889 17.4924 11.7889 19.4184 11.703 19.5371C11.6249 19.6484 11.5194 19.834 11.4725 19.9527C11.4218 20.0678 11.203 20.9621 10.9882 21.9381C10.5311 23.9828 10.5077 24.198 10.6874 24.6805C10.8085 25.0033 11.0194 25.315 11.2577 25.5154C11.5858 25.79 12.1522 25.9941 12.578 25.9941C12.7264 25.9941 16.0702 25.3818 16.6444 25.2482C16.7499 25.2223 16.9647 25.1443 17.1249 25.0738C17.4139 24.9439 17.4999 24.866 22.035 20.5613C26.9022 15.9375 26.871 15.9709 27.1171 15.4068C27.2928 14.9949 27.3632 14.6795 27.3866 14.1934C27.4178 13.4326 27.2303 12.7684 26.8007 12.1635C26.5233 11.7664 25.3436 10.6494 25.0155 10.4713C24.2577 10.0594 23.3358 9.91094 22.4647 10.0594ZM23.3983 11.9334C23.8007 12.0039 24.0194 12.1449 24.6327 12.7387C25.246 13.3324 25.3671 13.5105 25.4452 13.9225C25.496 14.2082 25.4218 14.6016 25.2616 14.8576C25.1991 14.9615 23.4218 16.6871 20.7147 19.2773L16.2694 23.5264L14.4296 23.8195C13.4218 23.9828 12.5858 24.1053 12.578 24.0979C12.5702 24.0904 12.7264 23.3 12.9257 22.3463L13.285 20.6059L17.7147 16.3977C21.5936 12.709 22.1718 12.1746 22.3788 12.0781C22.7421 11.9037 23.0155 11.8666 23.3983 11.9334Z" fill="currentColor" />
                                            <path d="M11.1949 27.23C10.5973 27.4378 10.4098 28.2171 10.8473 28.6921C10.9098 28.7626 11.0387 28.8554 11.1246 28.8999L11.2848 28.9816L18.8434 28.9927C27.2574 29.0001 26.6598 29.0187 26.9762 28.7478C27.066 28.6736 27.1676 28.5437 27.2066 28.462C27.2926 28.2839 27.3043 27.9351 27.2262 27.7607C27.1441 27.5714 26.9293 27.3636 26.7145 27.2708L26.5191 27.1818L18.9215 27.1855C13.1754 27.1855 11.2926 27.1966 11.1949 27.23Z" fill="currentColor" />
                                        </svg>
                                    </a>
                                    @if ($address->is_default <> 1)
                                    <div x-data="{ showModal1: false }" :class="{ 'overflow-y-hidden': showModal1 }">
                                        <main class=" w-full flex flex-col sm:flex-row justify-center items-center">
                                            <svg @click="showModal1 = true" class="mt-30p cursor-pointer border rounded-sm {{ $address->is_default == 1 ? 'border-yellow-1 hover:border-white text-gray-12 rounded address-edit' : 'border' }} text-gray-10 transition delay-150 hover:text-gray-12 hover:border-gray-12 border border-gray-2 ltr:ml-3 rtl:mr-3" xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 38 38" fill="none">
                                                <rect x="0.5" y="0.5" width="37" height="37" rx="1.5" fill="white" stroke="#DFDFDF" />
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M17 23.9995C16.4477 23.9995 16 23.5518 16 22.9995L16 19.9994C16 19.4471 16.4477 18.9993 17 18.9993C17.5523 18.9993 18.0001 19.4471 18.0001 19.9994L18.0001 22.9995C18.0001 23.5518 17.5523 23.9995 17 23.9995Z" fill="currentColor" />
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M21.001 23.9995C20.4487 23.9995 20.001 23.5518 20.001 22.9995L20.001 19.9994C20.001 19.4471 20.4487 18.9993 21.001 18.9993C21.5533 18.9993 22.001 19.4471 22.001 19.9994L22.001 22.9995C22.001 23.5518 21.5533 23.9995 21.001 23.9995Z" fill="currentColor"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.0263 16.0158C10.7893 15.9996 10.4796 15.9991 10 15.9991V13.999C10.0107 13.999 10.0214 13.999 10.032 13.999C10.0535 13.999 10.0748 13.999 10.096 13.999H27.9047C27.9259 13.999 27.9472 13.999 27.9687 13.999L28.0007 13.999V15.9991C27.521 15.9991 27.2114 15.9996 26.9744 16.0158C26.7464 16.0314 26.6595 16.058 26.6179 16.0752C26.3729 16.1767 26.1782 16.3714 26.0767 16.6164C26.0595 16.6581 26.0329 16.7449 26.0173 16.9729C26.0011 17.2099 26.0006 17.5195 26.0006 17.9992L26.0006 24.0652C26.0006 24.9517 26.0007 25.7156 25.9184 26.3273C25.8303 26.9828 25.6316 27.6112 25.1219 28.1209C24.6122 28.6305 23.9838 28.8293 23.3283 28.9174C22.7166 28.9997 21.9528 28.9996 21.0662 28.9996H16.9344C16.0479 28.9996 15.2841 28.9997 14.6724 28.9174C14.0168 28.8293 13.3885 28.6305 12.8788 28.1209C12.3691 27.6112 12.1704 26.9828 12.0822 26.3273C12 25.7156 12 24.9517 12.0001 24.0652L12.0001 17.9992C12.0001 17.5195 11.9995 17.2099 11.9834 16.9729C11.9678 16.7449 11.9412 16.6581 11.9239 16.6164C11.8225 16.3714 11.6278 16.1767 11.3827 16.0752C11.3411 16.058 11.2543 16.0314 11.0263 16.0158ZM24.1733 15.9991H13.8273C13.9211 16.2767 13.9597 16.5568 13.9788 16.8367C14.0002 17.15 14.0002 17.5285 14.0001 17.9672L14.0001 23.9994C14.0001 24.9705 14.0023 25.5982 14.0645 26.0608C14.1228 26.4945 14.2169 26.6305 14.293 26.7066C14.3692 26.7827 14.5051 26.8769 14.9389 26.9352C15.4014 26.9974 16.0291 26.9995 17.0003 26.9995H21.0004C21.9715 26.9995 22.5992 26.9974 23.0618 26.9352C23.4955 26.8769 23.6315 26.7827 23.7076 26.7066C23.7837 26.6305 23.8779 26.4945 23.9362 26.0608C23.9984 25.5982 24.0005 24.9705 24.0005 23.9994V17.9672C24.0005 17.5285 24.0005 17.15 24.0219 16.8367C24.041 16.5568 24.0795 16.2767 24.1733 15.9991Z" fill="currentColor" />
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M20.4076 10.1212C19.9836 10.0399 19.4909 10 19.0016 10C18.5124 10 18.0196 10.0399 17.5957 10.1212C17.3837 10.1619 17.1762 10.2153 16.9882 10.2856C16.8174 10.3495 16.5845 10.4556 16.3875 10.6394C15.9837 11.0162 15.9617 11.649 16.3385 12.0529C16.6941 12.4339 17.2776 12.4749 17.6815 12.1618C17.6838 12.1609 17.6864 12.1599 17.6891 12.1589C17.7424 12.1389 17.8351 12.1118 17.9725 12.0855C18.2471 12.0328 18.6103 12.0001 19.0016 12.0001C19.3929 12.0001 19.7562 12.0328 20.0308 12.0855C20.1681 12.1118 20.2608 12.1389 20.3142 12.1589C20.3169 12.1599 20.3194 12.1609 20.3217 12.1618C20.7257 12.4749 21.3092 12.4339 21.6648 12.0529C22.0415 11.649 22.0196 11.0162 21.6158 10.6394C21.4187 10.4556 21.1858 10.3495 21.0151 10.2856C20.8271 10.2153 20.6196 10.1619 20.4076 10.1212Z" fill="currentColor" />
                                            </svg>
                                        </main>
                                        <!-- Modal1 -->
                                        <div class="fixed inset-0 w-full h-full bg-black bg-opacity-50 pt-60 duration-300 overflow-y-auto" x-show="showModal1" x-transition:enter="transition duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                            <div class="relative sm:w-3/4 md:w-1/2 lg:w-1/2 xl:w-1/3 mx-2 sm:mx-auto my-10 opacity-100">
                                                <div class="relative bg-white shadow-lg p-4 rounded-md text-gray-900 z-50"
                                                    @click.away="showModal1 = false" x-show="showModal1"x-transition:enter="transition transform duration-300"x-transition:enter-start="scale-0" x-transition:enter-end="scale-100" x-transition:leave="transition transform duration-300" x-transition:leave-start="scale-100"x-transition:leave-end="scale-0">
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
                                                            <span class="leading-4 dm-sans font-medium lg:text-lg text-gray-12 lg:mb-1.5 mb-1 text-sm mt-2.5 ltr:lg:pr-0 ltr:pr-3 ltr:ml-2 rtl:lg:pl-0 rtl:pl-3 rtl:mr-2">{{ __('Are you sure you want to delete this?') }}</span>
                                                            <p class="text-gray-10 roboto-medium font-medium lg:text-sm text-11 whitespace-pre-line ltr:lg:pr-0 ltr:pr-10 ltr:ml-2 rtl:lg:pl-0 rtl:pl-10 rtl:mr-2">{{ __('Please keep in mind that once deleted, you can not undo it.') }}
                                                            </p>
                                                           </div>
                                                        </div>
                                                    </div>

                                                    <div class="flex justify-end lg:mt-8 lg:mx-0 mx-2 mt-6 ltr:lg:mr-30p rtl:lg:ml-30p">
                                                        <button class="dm-sans items-center transition duration-200 rounded px-3 lg:px-8 cursor-pointer font-medium lg:text-sm text-gray-12 lg:h-46p w-max h-10 bg-white border border-gray-2 text-xs hover:border-gray-12" @click="showModal1 = false"> {{ __('Cancel') }}
                                                        </button>
                                                        <form action="{{ route('site.addressDelete', ['id' => $address->id]) }}" method="post">
                                                            @csrf
                                                            <button type="submit" class="dm-sans transition duration-200 items-center cursor-pointer py-3.5 lg:px-6 font-medium lg:text-sm text-white lg:h-46p bg-gray-12 hover:bg-yellow-1 hover:text-gray-12 text-xs w-max px-3 h-10 rounded  ltr:ml-3 rtl:mr-3">{{ __('Yes, Delete') }}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-8">
                                <div class="mb-5">
                                    <span class="dm-sans font-medium text-gray-12 text-lg leading-6 break-all">{{ ucfirst($address->first_name) }}</span>
                                    <span class="dm-sans font-medium text-gray-12 text-lg break-all">{{ ucfirst($address->last_name) }}</span>
                                </div>
                                <div class="roboto-medium font-medium text-base capitalize break-all mb-5 text-gray-10">
                                    <p>{{ $address->address_1 }}</p>
                                    <p>{{ $address->address_2 }}</p>
                                    <p>{{ __('City') }}: {{ $address->city }}</p>
                                    <p>{{ __('postcode') }}: {{ $address->zip }}</p>
                                    <p>{{ __('country') }}: {{ optional($address->country1)->name }}</p>
                                </div>
                                <div class="dm-sans font-medium text-gray-12 text-base">
                                    <p class="break-all capitalize mb-2.5">{{ __('Phone') }}: {{ $address->phone }}</p>
                                    <p class="break-all">{{ __('Email') }}: {{ $address->email }}</p>
                                </div>
                            </div>
                            <div class="flex mt-49p">
                                @if ($address->is_default == 1)
                                    <input type="checkbox" checked disabled class="rounded-full text-gray-12 {{ $address->is_default == 1 ? 'border-yellow-1 hover:border-gray-12 bg-yellow-4 text-yellow-1 rounded address-edit' : 'border' }} neg-transition-scale">
                                    <p class="dm-sans font-medium text-base -mt-1 text-gray-12 ltr:ml-2 rtl:mr-2">{{ __('Used as default address') }}
                                    </p>
                                @else
                                    <a href="{{ route('address.makeDefault', ['id' => $address->id]) }}" class="dm-sans cursor-pointer font-medium text-base text-gray-10 underline">{{ __('Make Default Address') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            {{-- form --}}
            <div class="flex lg:mt-75p mt-10 dm-bold font-bold text-gray-12 text-base xl:text-2xl uppercase">
                <svg class="ltr:mr-3 rtl:ml-3 neg-transition-scale xl:w-5 xl:h-5 w-3.5 h-3.5 mt-1" xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21"
                    fill="none">
                    <path d="M13.8111 0.06563C13.6306 0.0984421 13.3298 0.176373 13.1451 0.246098C12.3974 0.520903 12.6423 0.30352 7.19391 5.4961C4.26774 8.28106 2.06773 10.4098 1.9732 10.541C1.88727 10.6641 1.77125 10.8691 1.71969 11.0004C1.66383 11.1275 1.4232 12.116 1.18688 13.1947C0.684141 15.4547 0.65836 15.6926 0.856016 16.2258C0.989219 16.5826 1.22125 16.9271 1.48336 17.1486C1.8443 17.4521 2.46734 17.6777 2.9357 17.6777C3.09899 17.6777 6.77711 17.001 7.40875 16.8533C7.52477 16.8246 7.7611 16.7385 7.93727 16.6605C8.25524 16.517 8.34977 16.4309 13.3384 11.673C18.6923 6.5625 18.658 6.59942 18.9287 5.97598C19.122 5.52071 19.1994 5.17207 19.2252 4.63477C19.2595 3.79395 19.0533 3.05977 18.5806 2.39122C18.2756 1.95235 16.9779 0.717777 16.617 0.520903C15.7834 0.06563 14.7693 -0.0984325 13.8111 0.06563ZM14.8381 2.13692C15.2806 2.21485 15.5213 2.37071 16.1959 3.02696C16.8705 3.68321 17.0037 3.88008 17.0896 4.33535C17.1455 4.65118 17.0638 5.08594 16.8877 5.36895C16.8189 5.48379 14.8638 7.39102 11.8861 10.2539L6.99625 14.9502L4.97242 15.2742C3.86383 15.4547 2.9443 15.59 2.9357 15.5818C2.92711 15.5736 3.09898 14.7 3.31813 13.6459L3.71344 11.7223L8.5861 7.0711C12.8529 2.99414 13.4888 2.40352 13.7166 2.29688C14.1162 2.10411 14.417 2.06309 14.8381 2.13692Z" fill="#2C2C2C" />
                    <path d="M1.41481 19.0431C0.757386 19.2728 0.551136 20.1341 1.03239 20.6591C1.10114 20.7371 1.24293 20.8396 1.33746 20.8888L1.51364 20.9791L9.82809 20.9914C19.0836 20.9996 18.4261 21.0201 18.7742 20.7207C18.873 20.6386 18.9847 20.4951 19.0277 20.4049C19.1222 20.208 19.1351 19.8224 19.0492 19.6297C18.959 19.4205 18.7226 19.1908 18.4863 19.0883L18.2715 18.9898L9.91403 18.9939C3.59333 18.9939 1.52223 19.0062 1.41481 19.0431Z" fill="#2C2C2C" />
                </svg>
                <p>{{ __('New address') }}</p>
            </div>
            <div class="items-center 3xl:w-1/2 2xl:w-2/3 lg:w-full lg:mt-27p mt-5 address-form">
                <div>
                    <form action="{{ route('site.addressStore') }}" method="post" id="addressForm" onsubmit=" return formValidation()">
                        @csrf
                        <div class="grid grid-cols-2 lg:gap-3 gap-15p">
                            <div class="lg:mb-3 mb-3.5">
                                <label class="text-sm dm-sans font-medium capitalize text-gray-12 require-profile"for="first_name">
                                    {{ __('First Name') }}</label>
                                <input class="border-gray-2 rounded-sm w-full mt-1.5 lg:mt-1p lg:h-46p h-10 roboto-medium font-medium text-sm text-gray-10 form-control border focus:border-gray-12  " type="text" id="first_name" name="first_name" type="text" value="{{ old('first_name') }}" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                            </div>
                            <div class="lg:mb-3 mb-3.5">
                                <label class="text-sm dm-sans font-medium capitalize text-gray-12" for="last_name">{{ __('Last Name') }}</label>
                                <input class="border-gray-2 rounded-sm w-full mt-1.5 lg:mt-1p lg:h-46p h-10 roboto-medium ltr:pl-18p rtl:pr-18p font-medium text-sm text-gray-10 form-control focus:border-gray-12" id="last_name" name="last_name" value="{{ old('last_name') }}" type="text">
                            </div>
                        </div>
                        <div class="lg:mb-3 mb-3.5">
                            <label class=" text-sm dm-sans font-medium capitalize text-gray-12" for="company_name">{{ __('Company Name') . ' ( ' . __('Optional') . ' )' }} </label>
                            <input class="border-gray-2 rounded-sm w-full mt-1.5 lg:mt-1p lg:h-46p h-10 roboto-medium ltr:pl-18p rtl:pr-18p font-medium text-sm text-gray-10 form-control focus:border-gray-12"type="text" name="company_name" id="compnay_name" value="{{ old('company_name') }}">
                        </div>
                        <div class="grid lg:grid-cols-2 grid-cols-1 lg:gap-3">
                            <div class="order-2 lg:order-none lg:mb-3 mb-3.5">
                                <label class="text-sm dm-sans font-medium capitalize text-gray-12 require-profile" for="phone"> {{ __('Phone Number') }}
                                </label>
                                <input class="border-gray-2 mt-1.5 lg:mt-1p rounded-sm w-full lg:h-46p h-10 roboto-medium ltr:pl-18p rtl:pr-18p font-medium text-sm text-gray-10 form-control border focus:border-gray-12" type="text" id="phone" name="phone" value="{{ old('phone') }}" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                            </div>
                            <div class="order-first lg:order-none lg:mb-3 mb-3.5">
                                <label class="text-sm dm-sans font-medium capitalize text-gray-12"for="email">{{ __('Email Address') }}</label>
                                <input class="border-gray-2 mt-1.5 lg:mt-1p rounded-sm w-full lg:h-46p h-10 ltr:pl-18p rtl:pr-18p roboto-medium font-medium text-sm text-gray-10 form-control focus:border-gray-12" type="email" name="email" id="email"
                                    data-type-mismatch="{{ __('Enter a valid :x.', ['x' => strtolower(__('Email'))]) }}">
                            </div>
                        </div>
                        <div class="lg:mb-3 mb-3.5">
                            <label class="lg:block hidden mt-3p text-sm dm-sans font-medium capitalize text-gray-12 require-profile"
                                for="address_1">{{ __('Street Address 1') }} </label>
                            <label class="lg:hidden block text-sm dm-sans font-medium capitalize text-gray-12 require-profile" for="address_1">{{ __('Street Address') }} </label>
                            <input id="address_1" name="address_1" type="text" value="{{ old('address_1') }}" class="border-gray-2 rounded-sm w-full mt-2 lg:mt-3p lg:h-46p h-10 roboto-medium ltr:pl-18p rtl:pr-18p font-medium text-sm text-gray-10 form-control focus:border-gray-12" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                        </div>
                        <div class="lg:block hidden lg:mb-3 mb-3.5">
                            <label class="text-sm dm-sans font-medium capitalize text-gray-12" for="address_2">{{ __('Street Address 2') }}</label>
                            <input id="address_2" name="address_2" type="text" value="{{ old('address_2') }}" class="border-gray-2 rounded-sm w-full mt-1.5 lg:mt-1p lg:h-46p h-10 roboto-medium ltr:pl-18p rtl:pr-18p font-medium text-sm text-gray-10 form-control focus:border-gray-12">
                        </div>
                        <div class="grid grid-cols-2 lg:gap-3 gap-15p mb-3.5">
                            <div class="w-full validSelect">
                                <label class="text-sm dm-sans font-medium capitalize text-gray-12 require-profile block" for="country"> {{ __('Country') }} </label>
                                <select name="country" id="country" class="border-gray-2 mt-1.5 lg:mt-1p rounded-sm w-full lg:h-46p h-10 roboto-medium ltr:pl-18p rtl:pr-18p font-medium text-sm text-gray-10 form-control border focus:border-gray-12 block required-field addressSelect" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"><option value="">{{ __('Select Country') }}</option>
                                </select>
                            </div>
                            <div class="w-full validSelect">
                                <label class="text-sm dm-sans font-medium capitalize text-gray-12 require-profile block" for="state">{{ __('State') . ' / ' . __('Province') }} </label>
                                <select name="state" id="state" class="border-gray-2 mt-1.5 lg:mt-1p rounded-sm w-full lg:h-46p h-10 roboto-medium ltr:pl-18p rtl:pr-18p font-medium text-sm text-gray-10 form-control border focus:border-gray-12 block required-field addressSelect" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"> <option value="">{{ __('Select State') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 lg:gap-3 gap-15p mb-3.5">
                            <div class="lg:mb-3 mb-3.5 validSelect">
                                <label class="text-sm dm-sans font-medium capitalize mb-2.5 lg:mb-1 text-gray-12 require-profile block" for="city">{{ __('City') }}</label>
                                <select name="city" id="city" class="border-gray-2 rounded-sm w-full lg:h-46p mt-1.5 lg:mt-1p h-10 roboto-medium ltr:pl-18p rtl:pr-18p font-medium text-sm text-gray-10 form-control border focus:border-gray-12 block required-field addressSelect" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"><option value="">{{ __('Select City') }}</option>
                                </select>
                            </div>
                            <div>
                                <label class="lg:block hidden text-sm dm-sans font-medium capitalize text-gray-12" for="zip"> {{ __('Postcode') . ' / ' . __('ZIP') }} </label>
                                <label class="lg:hidden block lg:mt-2p text-sm dm-sans font-medium capitalize text-gray-12" for="zip"> {{ __('Postcode') }} </label>
                                <input id="zip" name="zip" maxlength="10" type="text" value="{{ old('zip') }}"class="border-gray-2 rounded-sm w-full h-46p lg:mt-2 roboto-medium ltr:pl-18p rtl:pr-18p font-medium text-sm text-gray-10 form-control border focus:border-gray-12">
                            </div>
                        </div>
                        <div class="lg:mt-15p mt-18p">
                            <p class="lg:block hidden text-sm dm-sans font-medium capitalize text-gray-12">{{ __('Select the type of your place') }} *</p>
                            <p class="lg:hidden block text-sm dm-sans font-medium capitalize text-gray-12">{{ __('type of place') }} *</p>
                            <div class="flex mt-3p">
                                <div class="radio-buttons radio-btn-func">
                                    <label class="custom-radio">
                                        <input type="radio" id="optionsRadios1" class="display-none radio-test" name="type_of_place" value="home" />
                                        <span class="radio-btn lg:w-141p lg:h-53p border border-gray-2 rounded dm-sans cursor-pointer relative inline-block font-medium text-center lg:text-sm text-xs ltr:pl-18p rtl:pr-18p text-gray-10">
                                            <svg class="ltr:mr-13p rtl:ml-13p absolute opacity-0 lg:my-22p mt-15p" xmlns="http://www.w3.org/2000/svg" width="11" height="9" viewBox="0 0 11 9" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11 1.41885L4.38163 9L8.22563e-07 4.81748L1.64177 3.25031L4.22561 5.71673L9.21633 -4.01642e-07L11 1.41885Z" fill="currentColor" />
                                            </svg>
                                            <div class="ltr:lg:ml-18p ltr:ml-2 rtl:lg:mr-18p rtl:mr-2">
                                                <div class="flex items-center"><svg class=" my-18p lg:block hidden" xmlns="http://www.w3.org/2000/svg" width="16" height="18" viewBox="0 0 16 18" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"d="M6.57318 1.76695C5.97512 2.15794 5.27179 2.75321 4.27687 3.59733L3.22194 4.49239C2.09056 5.4523 1.68078 5.81759 1.46221 6.28799C1.24439 6.75675 1.23083 7.29905 1.23083 8.77444V13.2024C1.23083 14.2048 1.23218 14.8929 1.30238 15.4097C1.36998 15.9075 1.49089 16.1528 1.66444 16.3246C1.83961 16.498 2.09219 16.6198 2.60059 16.6875C3.12551 16.7573 3.82351 16.7586 4.83519 16.7586H11.1648C12.1765 16.7586 12.8745 16.7573 13.3994 16.6875C13.9078 16.6198 14.1604 16.498 14.3356 16.3246C14.5091 16.1528 14.63 15.9075 14.6976 15.4097C14.7678 14.8929 14.7692 14.2048 14.7692 13.2024V8.77444C14.7692 7.29905 14.7556 6.75675 14.5378 6.28799C14.3192 5.81759 13.9094 5.4523 12.7781 4.49239L11.7231 3.59733C10.7282 2.75321 10.0249 2.15794 9.42682 1.76695C8.84342 1.38555 8.42216 1.24138 8 1.24138C7.57784 1.24138 7.15658 1.38555 6.57318 1.76695ZM5.90376 0.725255C6.59589 0.27277 7.25143 0 8 0C8.74858 0 9.40411 0.27277 10.0962 0.725255C10.7663 1.1633 11.5277 1.80936 12.4835 2.62032L13.5703 3.54241C13.6072 3.57366 13.6435 3.60449 13.6794 3.63494C14.6614 4.4675 15.3044 5.01269 15.6522 5.76119C16.0007 6.51119 16.0004 7.3524 16 8.63193C16 8.67884 15.9999 8.72633 15.9999 8.77444V13.2476C16 14.1936 16 14.9673 15.917 15.5782C15.8301 16.2179 15.642 16.7707 15.1976 17.2106C14.7548 17.6489 14.2011 17.8329 13.5604 17.9182C12.9455 18 12.1659 18 11.2083 18H4.79168C3.83408 18 3.05447 18 2.43959 17.9182C1.79889 17.8329 1.24518 17.6489 0.802382 17.2106C0.357973 16.7707 0.169894 16.2179 0.0830068 15.5782C2.77297e-05 14.9673 4.46799e-05 14.1936 6.54405e-05 13.2476L6.61741e-05 8.77444C6.61741e-05 8.72633 4.92282e-05 8.67883 3.25023e-05 8.63192C-0.000424671 7.3524 -0.0007253 6.51119 0.347765 5.76119C0.695552 5.01269 1.33858 4.46751 2.32056 3.63494C2.35647 3.60449 2.39284 3.57366 2.42967 3.54241L3.51646 2.62033C4.47226 1.80937 5.23373 1.1633 5.90376 0.725255Z" fill="currentColor" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5 11.3333C5 10.597 5.53726 10 6.2 10H9.8C10.4627 10 11 10.597 11 11.3333V17.3333C11 17.7015 10.7314 18 10.4 18C10.0686 18 9.8 17.7015 9.8 17.3333V11.3333H6.2V17.3333C6.2 17.7015 5.93137 18 5.6 18C5.26863 18 5 17.7015 5 17.3333V11.3333Z" fill="currentColor" />
                                                    </svg><span class="ltr:ml-2 ltr:lg:mr-0 ltr:mr-9 rtl:mr-2 rtl:lg:ml-0 rtl:ml-9  my-3">{{ __('Home') }}</span>
                                                </div>
                                            </div>
                                        </span>
                                    </label>
                                    <label class="custom-radio ltr:ml-2 rtl:mr-2">
                                        <input type="radio" class="display-none radio-test" id="optionsRadios2" name="type_of_place" value="office"/>
                                        <span class="radio-btn lg:w-141p lg:h-53p border border-gray-2 rounded dm-sans cursor-pointer relative inline-block font-medium text-center lg:text-sm text-xs ltr:pl-18p rtl:pr-18p text-gray-10">
                                            <svg class="ltr:mr-13p rtl:ml-13p absolute opacity-0 lg:my-22p mt-15p" xmlns="http://www.w3.org/2000/svg" width="11" height="9" viewBox="0 0 11 9" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11 1.41885L4.38163 9L8.22563e-07 4.81748L1.64177 3.25031L4.22561 5.71673L9.21633 -4.01642e-07L11 1.41885Z" fill="currentColor" />
                                            </svg>
                                            <div class="ltr:lg:ml-18p ltr:ml-2 rtl:lg:mr-18p rtl:mr-2">
                                                <div class="flex items-center">
                                                    <svg class="my-18p lg:block hidden" xmlns="http://www.w3.org/2000/svg"
                                                        width="20" height="18" viewBox="0 0 20 18" fill="none">
                                                        <path d="M7.66406 0.0578384C7.14453 0.189384 6.56641 0.603956 6.26562 1.06636C6.18359 1.19392 6.0625 1.44107 6 1.61647C5.89062 1.92341 5.88672 1.97124 5.86719 2.76052L5.85156 3.58967H3.14844C0.136719 3.58967 0.277344 3.57771 0.0898438 3.86472L0 4.00025L0.0078125 9.84411L0.0195312 15.688L0.125 15.9989C0.417969 16.8838 1.09375 17.5735 1.97266 17.8884L2.28516 18H10H17.7148L18.0273 17.8884C18.9062 17.5735 19.582 16.8838 19.875 15.9989L19.9805 15.688L19.9922 9.84411L20 4.00025L19.9102 3.86472C19.7227 3.57771 19.8633 3.58967 16.8516 3.58967H14.1484L14.1328 2.78045C14.1172 2.043 14.1055 1.94732 14.0117 1.65633C13.7578 0.879007 13.0938 0.245192 12.3398 0.0618248C12.0039 -0.0179005 7.99219 -0.0218868 7.66406 0.0578384ZM12.2617 1.36135C12.4297 1.44506 12.5547 1.5487 12.6562 1.68423C12.8867 1.97922 12.9297 2.17853 12.9297 2.93991V3.58967H9.99609H7.0625L7.07812 2.86018C7.08984 2.22238 7.10156 2.11076 7.17188 1.95131C7.29297 1.68423 7.47656 1.49688 7.74219 1.35736L7.98047 1.23777H10H12.0195L12.2617 1.36135ZM18.7344 5.02472C18.6562 5.63462 18.2539 6.59132 17.8086 7.23709C17.4727 7.71545 16.7539 8.4529 16.2422 8.83559C15.3086 9.53717 14.2031 10.0634 12.9648 10.4022L12.5469 10.5178L12.5352 9.88796C12.5195 9.19036 12.5 9.13057 12.2266 8.93923L12.0977 8.85153H10H7.90234L7.77344 8.93923C7.5 9.13057 7.48047 9.19036 7.46484 9.88796L7.45312 10.5178L7.09375 10.4221C4.86328 9.81621 3.04688 8.59242 2.05078 7.02582C1.67188 6.42788 1.33594 5.57084 1.26562 5.02472L1.23828 4.82541H10H18.7617L18.7344 5.02472ZM1.37109 8.20177C1.59766 8.5127 2.25781 9.20232 2.62109 9.51325C3.34375 10.1311 4.46875 10.7968 5.44531 11.1835C5.91406 11.3708 6.59766 11.5821 7.12891 11.7057C7.30078 11.7416 7.45703 11.7894 7.47266 11.8014C7.49219 11.8173 7.53125 11.9369 7.5625 12.0645C7.67578 12.5109 7.88281 12.8697 8.22266 13.2165C8.73828 13.7427 9.27734 13.9699 10 13.9699C10.7109 13.9699 11.2617 13.7427 11.7617 13.2364C12.0938 12.9016 12.2578 12.6305 12.3828 12.2199C12.5234 11.7615 12.5039 11.7854 12.7773 11.7296C12.9141 11.6977 13.2461 11.614 13.5117 11.5383C14.9414 11.1277 16.3359 10.3982 17.3711 9.51724C17.7773 9.17043 18.3867 8.52864 18.6328 8.19778L18.8086 7.95861L18.8203 8.3971C18.8281 8.63627 18.8281 10.3025 18.8203 12.1003L18.8086 15.3691L18.7188 15.6082C18.5273 16.1344 18.1328 16.5331 17.6484 16.7005L17.4062 16.7842H10.0156C2.72266 16.7842 2.62109 16.7842 2.37109 16.7045C1.88281 16.549 1.47656 16.1424 1.28125 15.6082L1.19141 15.3691L1.17969 11.6698C1.17188 9.63682 1.17578 7.97455 1.18359 7.97455C1.19531 7.97455 1.27734 8.0782 1.37109 8.20177ZM11.3203 10.8726C11.2969 11.8014 11.25 11.9847 10.9453 12.3156C10.4219 12.8856 9.57812 12.8856 9.05469 12.3156C8.75 11.9847 8.70312 11.8014 8.67969 10.8726L8.66406 10.0873H10H11.3359L11.3203 10.8726Z" fill="currentColor" />
                                                    </svg><span class="ltr:ml-2 ltr:lg:mr-0 ltr:mr-9 rtl:mr-2 rtl:lg:ml-0 rtl:ml-9 lg:my-0 my-3">{{ __('Office') }}</span>
                                                </div>
                                            </div>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <br>
                            <p id="radio-error-msg" class="hidden font-normal text-11 text-reds-5 -mt-5 radio-error-msg">{{ __('This field is required.') }}</p>
                        </div>
                        @if ($addresses->count() > 0)
                        <div class="form-check mt-0">
                            <input type="hidden" name="is_default" value="0">
                            <input name="is_default" value="1" class=" h-4 w-4 border border-gray-2 rounded-sm bg-white text-gray-12 transition duration-200 lg:mt-1 mt-1.5 align-top ltr:mr-2 rtl:ml-2 neg-transition-scale cursor-pointer"type="checkbox"
                                id="flexCheckDefault">
                            <label class="form-check-label inline-block text-gray-10 lg:text-sm text-xs dm-sans font-medium" for="flexCheckDefault">{{ __('Use this as default address in the future') }}
                            </label>
                        </div>
                    @endif
                        <div class="flex gap-3 lg:mt-5 mt-6">
                            <button class="lg:order-none order-last dm-sans text-center transition duration-200 rounded py-3.5 cursor-pointer font-medium text-sm text-gray-12 w-141p h-46p bg-white border border-gray-2 mb-7p hover:border-gray-12 ltr:lg:ml-0 ltr:ml-3 rtl:lg:mr-0 rtl:mr-3"> <a href="{{ route('site.address') }}"> {{ __('Cancel') }}</a>
                            </button>
                            <button type="submit" id="btnSubmit" class="dm-sans transition duration-200 items-center cursor-pointer py-3 px-6 font-medium text-sm whitespace-nowrap text-white bg-gray-12 save-add-func hover:bg-yellow-1 hover:text-gray-12 mb-7p rounded">{{ __('Save Address') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            {{-- end form --}}
        @endif
    </div>
@endsection
@section('js')
    <script>
        'use strict';
        let oldCountry = "{!! old('country') ?? 'null' !!}";
        let oldState = "{!! old('state') ?? 'null' !!}";
        let oldCity = "{!! old('city') ?? 'null' !!}";
    </script>
    <script src="{{ asset('/public/dist/js/custom/validation.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('/public/dist/js/custom/site/address.min.js') }}"></script>
@endsection
