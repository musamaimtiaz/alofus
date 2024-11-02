@extends('../site/layouts.user_panel.app')
@section('page_title', __('Order Details'))
@section('content')
    <div class="dark:bg-red-1 h-full xl:px-74p px-5 pt-30p xl:pt-14">
        <div class="flex justify-between">
            <div>
                <div class="flex items-center">
                    <span class="mr-4 lg:mt-0 mt-1">
                        <svg class="h-30p w-10 lg:w-53p lg:h-11" xmlns="http://www.w3.org/2000/svg" width="53" height="44" viewBox="0 0 53 44" fill="none">
                            <rect x="36.1779" y="27.377" width="16.6222" height="16.6222" rx="2" fill="#FCCA19" />
                            <rect width="32.2667" height="32.2667" rx="2" fill="#FCCA19" />
                        </svg>
                    </span>
                    <h1 class="dark:text-gray-2 dm-sans font-medium lg:pt-0 text-2xl lg:text-4xl text-gray-12 mb-1 dark:text-gray-2">
                        {{ __('Order Details') }}
                    </h1>
                </div>
                <p class="dark:text-gray-2 lg:mt-1.5 roboto-medium font-medium text-base lg:text-xl mt-2 text-20 text-gray-10 leading-6"> {{ __('Take a look at all the orders you made, their status and much more..') }}</p>
            </div>
            <div class="lg:block hidden">
                <a href="javascript:void(0)" class="flex relative mt-2 arrow-hover font-medium dm-sans text-gray-10 text-base pl-4 rounded-sm">
                    <svg class="mt-2 mr-2 absolute" width="15" height="10" viewBox="0 0 15 10" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.70711 0L6.12132 1.41421L3.82843 3.70711H13.4142C13.9665 3.70711 14.4142 4.15482 14.4142 4.70711C14.4142 5.25939 13.9665 5.70711 13.4142 5.70711H3.82843L6.12132 8L4.70711 9.41421L0 4.70711L4.70711 0Z" fill="currentColor" />
                    </svg>
                    <span class="ml-4 dm-sans font-medium">{{ __('Back') }}</span>
                </a>
            </div>
        </div>
        <div class="mt-75p flex justify-between">
            <div>
                <p class="text-gray-10 upperc ase roboto-medium font-medium text-lg">{{ __("seller") }}</p>
                <p class="dm-sans font-bold text-gray-12 text-28">{{ __("Xtreme Local Super Shop") }}</p>
                <p class="text-lg roboto-medium font-medium text-gray-10">{{ __("Order Date: 12 Feb, 2022 at 4:32 pm") }}</p>
            </div>
            <div class="text-right">
                <p class="text-gray-10 upperc ase roboto-medium font-medium text-lg">{{ __("shipping address") }}</p>
                <p class="dm-sans font-bold text-gray-12 text-28">{{ __("JOY BUANGARO CUMILLA") }}</p>
                <p class="text-lg roboto-medium font-medium text-gray-10">{{ __("RT3/A, Kazi Sheikhs & Jonns, Tongi, Gazipur, Dhaka, Bangladesh.") }}</p>
            </div>
        </div>
        <div class="mt-18p w-28 text-center h-10 rounded-sm">
            <p class="dm-sans font-medium text-xl text-green-1 bg-green-2">{{ __("Paid") }}</p>
        </div>
        <div>
            <div class="flex mt-20 justify-center items-center">
                <div class="uppercase relative">
                    <div class="flex justify-center items-center">
                        <div class="h-9 w-9 bg-green-2 rounded-full flex justify-center items-center text-green-3">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="12" viewBox="0 0 15 12"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14.4602 0.369979C13.8238 -0.19434 12.878 -0.102846 12.3476 0.574336L6.95072 7.46551C6.43064 8.12958 6.13827 8.49723 5.90485 8.72315C5.90182 8.72608 5.89885 8.72894 5.89593 8.73174C5.89278 8.72923 5.88958 8.72667 5.88631 8.72404C5.63463 8.52153 5.31217 8.18356 4.73773 7.57232L2.56065 5.25578C1.97487 4.63247 1.02512 4.63247 0.43934 5.25578C-0.146446 5.87909 -0.146446 6.88967 0.43934 7.51298L2.61642 9.82953C2.63686 9.85128 2.65727 9.873 2.67764 9.89469C3.16739 10.416 3.63853 10.9175 4.0769 11.2702C4.56794 11.6653 5.21102 12.0368 6.03513 11.9971C6.85924 11.9573 7.46807 11.5253 7.92348 11.0846C8.33003 10.6911 8.75656 10.1463 9.19993 9.57991C9.21838 9.55633 9.23686 9.53273 9.25538 9.50909L14.6523 2.61791C15.1826 1.94073 15.0967 0.934297 14.4602 0.369979Z" fill="currentColor" />
                                </svg>
                            </span>
                        </div>
                        <div class="p-4 text-green-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="353" height="6" viewBox="0 0 353 6" fill="none">
                                <path d="M352.887 3.00003L350 0.113279L347.113 3.00003L350 5.88678L352.887 3.00003ZM-4.37114e-08 3.5L350 3.50003L350 2.50003L4.37114e-08 2.5L-4.37114e-08 3.5Z" fill="#33C172" />
                            </svg>
                        </div>
                    </div>
                    <p class="absolute -left-14 mt-7 text-base dm-bold font-bold text-gray-10">{{ __('Payment pending') }}
                    </p>
                </div>
                <div class="uppercase relative">
                    <div class="flex justify-center items-center">
                        <div class="h-9 w-9 bg-white rounded-full flex justify-center items-center border border-gray-12 text-gray-12 dm-sans text-base font-bold">
                            <span> 2 </span>
                        </div>
                        <div class="p-4 text-green-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="353" height="6" viewBox="0 0 353 6" fill="none">
                                <path d="M352.887 3.00003L350 0.113279L347.113 3.00003L350 5.88678L352.887 3.00003ZM-4.37114e-08 3.5L350 3.50003L350 2.50003L4.37114e-08 2.5L-4.37114e-08 3.5Z" fill="#898989" />
                            </svg>
                        </div>
                    </div>
                    <p class="absolute -left-7 mt-7 dm-bold font-bold text-gray-12">{{ __('processing') }}</p>
                </div>
                <div class="uppercase relative">
                    <div class="flex justify-center items-center">
                        <div class="h-9 w-9 bg-gray-11 rounded-full flex justify-center items-center text-gray-10 dm-sans text-base font-bold">
                            <span>  3 </span>
                        </div>
                        <div class="p-4 text-green-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="353" height="6" viewBox="0 0 353 6" fill="none">
                                <path d="M352.887 3.00003L350 0.113279L347.113 3.00003L350 5.88678L352.887 3.00003ZM-4.37114e-08 3.5L350 3.50003L350 2.50003L4.37114e-08 2.5L-4.37114e-08 3.5Z" fill="#DFDFDF" />
                            </svg>
                        </div>
                    </div>
                    <p class="absolute -left-4 mt-7 dm-bold text-center font-bold text-gray-10">{{ __('shipped') }}</p>
                </div>
                <div class="uppercase relative ">
                    <div class="flex justify-center items-center">
                        <div class="h-9 w-9 bg-gray-11 rounded-full flex justify-center items-center text-gray-10 dm-sans text-base font-bold">
                            <span> 4 </span>
                        </div>
                    </div>
                    <p class="absolute -left-5 mt-7 text-center dm-bold font-bold text-gray-10">{{ __('delivered') }}</p>
                </div>
            </div>
        </div>
        <div class="mt-28 p-12 h-245p pl-24 bg-gray-11 flex rounded-sm">
            <div>
                <p class="text-gray-12 mb-2.5 text-sm dm-sans font-medium">{{ __("Order Placed") }}</p>
                <p class="roboto-medium font-medium text-xs text-gray-10">{{ __("We have successfully received your orders.") }}</p>
            </div>
            <div class="ml-50p">
                <p class="text-gray-12 mb-2.5 text-sm dm-sans font-medium">27 Feb, 2022</p>
                <p class="roboto-medium font-medium text-xs text-gray-10">8:01 pm</p>
            </div>

        </div>
        <div class="overflow-x-auto hidden xl:block rounded-sm mt-60p">
            <table class="w-full bg-white dark:bg-gray-2 overflow-hidden table-striped dark:border-gray-0">
                <thead>
                    <tr class="text-left bg-gray-11 border border-gray-2 dark:bg-gray-2">
                        <th class="px-6 py-4 text-gray-12 dm-sans font-medium text-xl dark:text-gray-2">{{ __('Products') }}</th>
                        <th class="px-6 py-4 text-gray-12 dm-sans font-medium text-xl dark:text-gray-2">{{ __('Status') }}</th>
                        <th class="px-6 py-4 text-gray-12 dm-sans font-medium text-xl dark:text-gray-2">{{ __('Cost') }}</th>
                        <th class="px-6 py-4 text-gray-12 dm-sans font-medium text-xl dark:text-gray-2">{{ __('Quantity') }}</th>
                        <th class="px-6 py-4 text-gray-12 dm-sans font-medium text-xl dark:text-gray-2">{{ __('Amount') }}</th>
                        <th class="px-6 py-4 text-gray-12 dm-sans font-medium text-xl dark:text-gray-2">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="focus-within:bg-gray-200 border border-gray-2 overflow-hidden">
                        <td class="dark:border-t-gray-2 dark:bg-gray-3 ">
                            <div>
                                <div>
                                    <div class=" items-center flex mb-8 mt-5">
                                        <span class="bg-gray-17 ml-6 h-12 w-12 rounded-sm flex justify-center items-center">
                                            <img class="w-8 h-8" src="{{ asset('public/frontend/assets/img/product/shoe-2.png') }}" alt="{{ __('Image') }}" />
                                        </span>
                                        <div class="ml-8">
                                            <a>
                                                <span class="dm-sans font-medium text-gray-12 pt-2 flex items-center dark:text-gray-2">{{ __("Zoopie XL Sneakers for Men") }} </span>
                                                <span class="text-sm mt-2 roboto-medium font-medium text-gray-10">{{ __("Color") }}: {{ __("White-Clay, Size: 42") }}</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="items-center flex mb-8 mt-5">
                                        <span class="bg-gray-17 ml-6 h-12 w-12 rounded-sm flex justify-center items-center">
                                            <img class="w-8 h-8" src="{{ asset('public/frontend/assets/img/product/shoe-2.png') }}" alt="{{ __('Image') }}" />
                                        </span>
                                        <div class="ml-8">
                                            <a>
                                                <span class="dm-sans font-medium text-gray-12 pt-2 flex items-center dark:text-gray-2"> {{ __("MAG\'s Boom Boom Sneakers from UK") }}</span>
                                                <span class="text-sm mt-2 roboto-medium font-medium text-gray-10">{{ __("Color") }}: White-Clay, Size: 42</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="dark:border-t-gray-2 dark:bg-gray-3 ">
                            <div>
                                <span class="roboto-medium font-medium text-gray-10 px-6   flex items-center dark:text-gray-2">
                                    {{ __("Processing") }}
                                </span>
                                <span class="roboto-medium font-medium text-gray-10 px-6 pt-14 flex items-center dark:text-gray-2">
                                    {{ __("Processing") }}
                                </span>
                            </div>
                        </td>
                        <td class="dark:border-t-gray-2 dark:bg-gray-3">
                            <div>
                                <span class="roboto-medium font-medium text-gray-12 px-6   flex items-center dark:text-gray-2">
                                    $12.00
                                </span>
                                <span class="roboto-medium font-medium text-gray-12 px-6 pt-14 flex items-center dark:text-gray-2">
                                    $55.00
                                </span>
                            </div>
                        </td>
                        <td class="dark:border-t-gray-2 dark:bg-gray-3">
                            <div>
                                <span class="roboto-medium font-medium text-gray-12 px-6   flex items-center dark:text-gray-2"> x 1
                                </span>
                                <span class="roboto-medium font-medium text-gray-12 px-6 pt-14 flex items-center dark:text-gray-2"> x 3</span>
                            </div>
                        </td>
                        <td class="dark:border-t-gray-2 dark:bg-gray-3">
                            <div>
                                <span class="roboto-medium font-medium text-gray-12 px-6   flex items-center dark:text-gray-2"> $12.00 </span>
                                <span class="roboto-medium font-medium text-gray-12 px-6 pt-14 flex items-center dark:text-gray-2"> $165.00</span>
                            </div>
                        </td>
                        <td class="dark:border-t-gray-2 dark:bg-gray-3">
                            <div class="flex ml-5">
                                <div class="w-30p h-30p ">
                                    <a class="text-gray-10 justify-center items-center flex bg-gray-2 p-1.5 rounded-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16" fill="none">
                                            <path d="M6.54542 0.395768C6.34304 0.613717 6.17491 0.800529 6.17491 0.809871C6.17491 0.822325 6.42399 1.06829 6.72912 1.35785C7.03113 1.64742 7.28022 1.89961 7.28022 1.91518C7.28022 1.93386 7.19615 1.93698 7.0685 1.92452C6.83809 1.90273 6.26831 1.9432 5.83242 2.01793C3.64359 2.38533 1.73187 3.79576 0.741764 5.76664C0.200006 6.85016 -0.0335097 7.9181 0.00385293 9.15418C0.0349884 10.2159 0.243596 11.0566 0.710629 12.0093C2.28608 15.2318 6.00989 16.7388 9.39432 15.5214C9.83644 15.3657 10.456 15.0512 10.8764 14.771C12.6417 13.6003 13.7471 11.7664 13.9775 9.63367C14.021 9.204 13.9993 8.27616 13.9308 7.8496C13.8716 7.48221 13.7315 6.93422 13.6007 6.5606C13.3703 5.90364 12.8877 5.05052 12.4238 4.48386C12.1 4.08532 11.3527 3.38166 11.2967 3.41591C11.2811 3.42525 11.1037 3.6432 10.9044 3.90162L10.5401 4.37177L10.7394 4.54613C12.9749 6.4921 13.4108 9.71462 11.7637 12.165C11.1441 13.0897 10.207 13.8463 9.15769 14.2697C7.63516 14.8862 5.94762 14.8208 4.44689 14.086C3.51594 13.6315 2.67216 12.8686 2.12107 11.9844C1.02821 10.219 0.950372 8.07689 1.91557 6.23367C2.65037 4.83258 3.98608 3.76774 5.51795 3.36921C5.71099 3.31628 6.00677 3.25401 6.17802 3.2291C6.47381 3.18551 7.28022 3.16371 7.28022 3.20108C7.28022 3.21042 7.05293 3.45639 6.77582 3.74595C6.4956 4.03862 6.2652 4.2877 6.25897 4.30016C6.24963 4.32818 6.99688 5.05052 7.03425 5.05052C7.07161 5.05052 9.47527 2.52544 9.47527 2.48496C9.47527 2.46317 8.99267 1.98679 8.40109 1.42635C7.80952 0.862801 7.23351 0.311703 7.12143 0.202728L6.91593 0.000347137L6.54542 0.395768Z" fill="#898989" />
                                            <path d="M6.56442 6.0743C6.56442 6.41679 6.57687 6.395 6.34024 6.43547C6.02577 6.49152 5.61167 6.70012 5.36882 6.91807C4.9516 7.30104 4.81772 7.958 5.04189 8.54957C5.12596 8.77997 5.41552 9.07888 5.66772 9.2003C5.91991 9.32173 6.35892 9.43071 6.82907 9.48675C7.80673 9.60818 8.18346 9.78876 8.18346 10.1344C8.18346 10.4395 7.9624 10.645 7.53585 10.7477C7.3179 10.7976 6.87266 10.8007 6.65783 10.7477C6.27175 10.6606 5.90435 10.4177 5.7798 10.1748C5.74556 10.1063 5.71131 10.041 5.70508 10.0347C5.70197 10.0285 5.47156 10.1188 5.19757 10.234C4.83951 10.3866 4.69629 10.4613 4.69629 10.4955C4.69629 10.5236 4.7679 10.6606 4.85197 10.8007C5.05123 11.1245 5.34391 11.3922 5.67706 11.5573C5.91991 11.6756 6.34647 11.8063 6.49281 11.8063C6.56131 11.8063 6.56131 11.8157 6.57065 12.1551L6.57999 12.5069L7.1342 12.5162L7.6853 12.5225V12.1519V11.7814L7.83475 11.7628C8.40453 11.6818 8.98053 11.2988 9.20471 10.8474C9.33548 10.5827 9.37595 10.3523 9.35727 10.0161C9.33236 9.5677 9.18603 9.25635 8.88401 9.00726C8.55398 8.73327 8.13053 8.6025 7.15599 8.46239C6.38383 8.35031 6.20947 8.29115 6.11295 8.10122C5.9635 7.81166 6.20013 7.51276 6.6516 7.41935C7.21515 7.30104 7.83163 7.45672 8.13053 7.78675L8.26442 7.93932L8.73768 7.72137L9.21094 7.50031L9.12376 7.34463C9.00544 7.12979 8.73145 6.83712 8.51661 6.69701C8.34537 6.58804 8.12742 6.50086 7.81918 6.4199L7.6853 6.38566V6.07741V5.76606H7.12486H6.56442V6.0743Z" fill="#898989" />
                                        </svg></a>
                                </div>
                                <div class="w-30p h-30p ml-3">
                                    <a class="text-gray-10 justify-center items-center flex bg-gray-2 p-1.5 rounded-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                            fill="none">
                                            <g clip-path="url(#clip0_5183_2833)">
                                                <rect width="15.7895" height="15" transform="translate(0.105469 0.894531)" fill="#DFDFDF" />
                                                <path d="M10.7355 0.941409C10.606 0.964847 10.3901 1.02051 10.2575 1.07032C9.72093 1.2666 9.89671 1.11133 5.98635 4.82031C3.88622 6.80957 2.30728 8.33008 2.23943 8.42383C2.17775 8.51172 2.09449 8.6582 2.05748 8.75195C2.01739 8.84277 1.84469 9.54883 1.67508 10.3193C1.31427 11.9336 1.29576 12.1035 1.43762 12.4844C1.53322 12.7393 1.69975 12.9854 1.88787 13.1436C2.14691 13.3604 2.59408 13.5215 2.93022 13.5215C3.04741 13.5215 5.68721 13.0381 6.14054 12.9326C6.22381 12.9121 6.39342 12.8506 6.51986 12.7949C6.74807 12.6924 6.81591 12.6309 10.3963 9.23242C14.2388 5.58203 14.2141 5.6084 14.4084 5.16309C14.5472 4.83789 14.6027 4.58887 14.6212 4.20508C14.6459 3.60449 14.4979 3.08008 14.1586 2.60254C13.9397 2.28907 13.0083 1.40723 12.7493 1.2666C12.151 0.941409 11.4232 0.824222 10.7355 0.941409ZM11.4726 2.4209C11.7902 2.47657 11.9629 2.58789 12.4471 3.05664C12.9312 3.52539 13.0268 3.66602 13.0885 3.99121C13.1286 4.2168 13.07 4.52735 12.9436 4.72949C12.8942 4.81153 11.4911 6.17383 9.35395 8.21875L5.84449 11.5732L4.39198 11.8047C3.59634 11.9336 2.93639 12.0303 2.93022 12.0244C2.92405 12.0186 3.04741 11.3945 3.20468 10.6416L3.4884 9.26758L6.98552 5.94531C10.0478 3.03321 10.5042 2.61133 10.6677 2.53516C10.9545 2.39746 11.1704 2.36817 11.4726 2.4209Z" fill="#898989" />
                                                <path d="M1.83833 14.4973C1.3665 14.6614 1.21847 15.2766 1.56386 15.6516C1.61321 15.7073 1.71497 15.7805 1.78282 15.8157L1.90926 15.8801L7.87657 15.8889C14.5193 15.8948 14.0474 15.9094 14.2972 15.6956C14.3681 15.637 14.4483 15.5344 14.4792 15.47C14.547 15.3294 14.5563 15.054 14.4946 14.9163C14.4298 14.7669 14.2602 14.6028 14.0906 14.5296L13.9364 14.4592L7.93825 14.4622C3.40186 14.4622 1.91543 14.471 1.83833 14.4973Z" fill="#898989" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_5183_2833">
                                                    <rect width="15.7895" height="15" fill="white" transform="translate(0.105469 0.894531)" />
                                                </clipPath>
                                            </defs>
                                        </svg></a>
                                </div>
                            </div>
                            <div class="mt-12">
                                <div class="flex ml-5">
                                    <div class="w-30p h-30p ">
                                        <a class="text-gray-10 justify-center items-center flex bg-gray-2 p-1.5 rounded-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg"  width="14" height="16" viewBox="0 0 14 16" fill="none">
                                                <path d="M6.54542 0.395768C6.34304 0.613717 6.17491 0.800529 6.17491 0.809871C6.17491 0.822325 6.42399 1.06829 6.72912 1.35785C7.03113 1.64742 7.28022 1.89961 7.28022 1.91518C7.28022 1.93386 7.19615 1.93698 7.0685 1.92452C6.83809 1.90273 6.26831 1.9432 5.83242 2.01793C3.64359 2.38533 1.73187 3.79576 0.741764 5.76664C0.200006 6.85016 -0.0335097 7.9181 0.00385293 9.15418C0.0349884 10.2159 0.243596 11.0566 0.710629 12.0093C2.28608 15.2318 6.00989 16.7388 9.39432 15.5214C9.83644 15.3657 10.456 15.0512 10.8764 14.771C12.6417 13.6003 13.7471 11.7664 13.9775 9.63367C14.021 9.204 13.9993 8.27616 13.9308 7.8496C13.8716 7.48221 13.7315 6.93422 13.6007 6.5606C13.3703 5.90364 12.8877 5.05052 12.4238 4.48386C12.1 4.08532 11.3527 3.38166 11.2967 3.41591C11.2811 3.42525 11.1037 3.6432 10.9044 3.90162L10.5401 4.37177L10.7394 4.54613C12.9749 6.4921 13.4108 9.71462 11.7637 12.165C11.1441 13.0897 10.207 13.8463 9.15769 14.2697C7.63516 14.8862 5.94762 14.8208 4.44689 14.086C3.51594 13.6315 2.67216 12.8686 2.12107 11.9844C1.02821 10.219 0.950372 8.07689 1.91557 6.23367C2.65037 4.83258 3.98608 3.76774 5.51795 3.36921C5.71099 3.31628 6.00677 3.25401 6.17802 3.2291C6.47381 3.18551 7.28022 3.16371 7.28022 3.20108C7.28022 3.21042 7.05293 3.45639 6.77582 3.74595C6.4956 4.03862 6.2652 4.2877 6.25897 4.30016C6.24963 4.32818 6.99688 5.05052 7.03425 5.05052C7.07161 5.05052 9.47527 2.52544 9.47527 2.48496C9.47527 2.46317 8.99267 1.98679 8.40109 1.42635C7.80952 0.862801 7.23351 0.311703 7.12143 0.202728L6.91593 0.000347137L6.54542 0.395768Z" fill="#898989" />
                                                <path d="M6.56442 6.0743C6.56442 6.41679 6.57687 6.395 6.34024 6.43547C6.02577 6.49152 5.61167 6.70012 5.36882 6.91807C4.9516 7.30104 4.81772 7.958 5.04189 8.54957C5.12596 8.77997 5.41552 9.07888 5.66772 9.2003C5.91991 9.32173 6.35892 9.43071 6.82907 9.48675C7.80673 9.60818 8.18346 9.78876 8.18346 10.1344C8.18346 10.4395 7.9624 10.645 7.53585 10.7477C7.3179 10.7976 6.87266 10.8007 6.65783 10.7477C6.27175 10.6606 5.90435 10.4177 5.7798 10.1748C5.74556 10.1063 5.71131 10.041 5.70508 10.0347C5.70197 10.0285 5.47156 10.1188 5.19757 10.234C4.83951 10.3866 4.69629 10.4613 4.69629 10.4955C4.69629 10.5236 4.7679 10.6606 4.85197 10.8007C5.05123 11.1245 5.34391 11.3922 5.67706 11.5573C5.91991 11.6756 6.34647 11.8063 6.49281 11.8063C6.56131 11.8063 6.56131 11.8157 6.57065 12.1551L6.57999 12.5069L7.1342 12.5162L7.6853 12.5225V12.1519V11.7814L7.83475 11.7628C8.40453 11.6818 8.98053 11.2988 9.20471 10.8474C9.33548 10.5827 9.37595 10.3523 9.35727 10.0161C9.33236 9.5677 9.18603 9.25635 8.88401 9.00726C8.55398 8.73327 8.13053 8.6025 7.15599 8.46239C6.38383 8.35031 6.20947 8.29115 6.11295 8.10122C5.9635 7.81166 6.20013 7.51276 6.6516 7.41935C7.21515 7.30104 7.83163 7.45672 8.13053 7.78675L8.26442 7.93932L8.73768 7.72137L9.21094 7.50031L9.12376 7.34463C9.00544 7.12979 8.73145 6.83712 8.51661 6.69701C8.34537 6.58804 8.12742 6.50086 7.81918 6.4199L7.6853 6.38566V6.07741V5.76606H7.12486H6.56442V6.0743Z" fill="#898989" />
                                            </svg></a>
                                    </div>
                                    <div class="w-30p h-30p ml-3">
                                        <a class="text-gray-10 justify-center items-center flex bg-gray-2 p-1.5 rounded-sm" >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 16 16" fill="none">
                                                <g clip-path="url(#clip0_5183_2833)">
                                                    <rect width="15.7895" height="15" transform="translate(0.105469 0.894531)" fill="#DFDFDF" />
                                                    <path d="M10.7355 0.941409C10.606 0.964847 10.3901 1.02051 10.2575 1.07032C9.72093 1.2666 9.89671 1.11133 5.98635 4.82031C3.88622 6.80957 2.30728 8.33008 2.23943 8.42383C2.17775 8.51172 2.09449 8.6582 2.05748 8.75195C2.01739 8.84277 1.84469 9.54883 1.67508 10.3193C1.31427 11.9336 1.29576 12.1035 1.43762 12.4844C1.53322 12.7393 1.69975 12.9854 1.88787 13.1436C2.14691 13.3604 2.59408 13.5215 2.93022 13.5215C3.04741 13.5215 5.68721 13.0381 6.14054 12.9326C6.22381 12.9121 6.39342 12.8506 6.51986 12.7949C6.74807 12.6924 6.81591 12.6309 10.3963 9.23242C14.2388 5.58203 14.2141 5.6084 14.4084 5.16309C14.5472 4.83789 14.6027 4.58887 14.6212 4.20508C14.6459 3.60449 14.4979 3.08008 14.1586 2.60254C13.9397 2.28907 13.0083 1.40723 12.7493 1.2666C12.151 0.941409 11.4232 0.824222 10.7355 0.941409ZM11.4726 2.4209C11.7902 2.47657 11.9629 2.58789 12.4471 3.05664C12.9312 3.52539 13.0268 3.66602 13.0885 3.99121C13.1286 4.2168 13.07 4.52735 12.9436 4.72949C12.8942 4.81153 11.4911 6.17383 9.35395 8.21875L5.84449 11.5732L4.39198 11.8047C3.59634 11.9336 2.93639 12.0303 2.93022 12.0244C2.92405 12.0186 3.04741 11.3945 3.20468 10.6416L3.4884 9.26758L6.98552 5.94531C10.0478 3.03321 10.5042 2.61133 10.6677 2.53516C10.9545 2.39746 11.1704 2.36817 11.4726 2.4209Z" fill="#898989" />
                                                    <path d="M1.83833 14.4973C1.3665 14.6614 1.21847 15.2766 1.56386 15.6516C1.61321 15.7073 1.71497 15.7805 1.78282 15.8157L1.90926 15.8801L7.87657 15.8889C14.5193 15.8948 14.0474 15.9094 14.2972 15.6956C14.3681 15.637 14.4483 15.5344 14.4792 15.47C14.547 15.3294 14.5563 15.054 14.4946 14.9163C14.4298 14.7669 14.2602 14.6028 14.0906 14.5296L13.9364 14.4592L7.93825 14.4622C3.40186 14.4622 1.91543 14.471 1.83833 14.4973Z" fill="#898989" />
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_5183_2833">
                                                        <rect width="15.7895" height="15" fill="white"
                                                            transform="translate(0.105469 0.894531)" />
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="focus-within:bg-gray-200 border border-t-0 border-gray-2 overflow-hidden">
                        <td class="dark:border-t-gray-2 dark:bg-gray-3 dm-sans font-medium text-gray-12 px-6 py-18p"></td>
                        <td class="dark:border-t-gray-2 dark:bg-gray-3 dm-sans font-medium text-gray-12 px-6 py-18p"></td>
                        <td class="dark:border-t-gray-2 dark:bg-gray-3 dm-sans font-medium text-gray-12 px-6 py-18p"></td>
                        <td class="dark:border-t-gray-2 dark:bg-gray-3 dm-sans font-medium text-gray-12 px-6 py-18p"></td>
                        {{ __('Subtotal') }}</td>
                        <td class="dark:border-t-gray-2 text-lg dark:bg-gray-3 dm-sans font-medium text-gray-12 px-6 py-18p">
                            $182.99
                        </td>
                    </tr>
                    <tr class="dark:border-t-gray-2 dark:bg-gray-3 border border-gray-2"></tr>
                    <tr class="focus-within:bg-gray-200 overflow-hidden dark:border-t-gray-2 dark:bg-gray-3 border border-gray-2">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="dm-sans font-medium text-gray-12 text-lg px-6 py-18p">{{ __('Shipping') }}</td>
                        <td class="dm-sans font-medium text-gray-12 text-lg px-6 py-18p"> $15.00</td>
                    </tr>
                    <tr class="focus-within:bg-gray-200 overflow-hidden dark:border-t-gray-2 dark:bg-gray-3 border border-gray-2">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="dm-sans font-medium text-gray-12 text-lg px-6 py-18p">{{ __('Discount') }}</td>
                        <td class="dm-sans font-medium text-gray-12 text-lg px-6 py-18p">$21.45</td>
                    </tr>
                    <tr class="dark:border-t-gray-2 dark:bg-gray-3 border border-gray-2"></tr>
                    <tr class="focus-within:bg-gray-200 overflow-hidden dark:border-t-gray-2 dark:bg-gray-3 border border-gray-2">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="dm-sans font-medium text-gray-12 text-lg px-6 py-18p">{{ __('Grand Total') }}</td>
                        <td class="dm-sans font-medium text-gray-12 text-lg px-6 py-18p">$197.99</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
