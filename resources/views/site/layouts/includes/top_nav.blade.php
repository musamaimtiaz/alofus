@php
    $carts = \App\Cart\Cart::cartCollection()->sortKeys();
    $textColor = $header['top']['text_color'];
@endphp

<section style="background: {{ $header['top']['bg_color'] }}" class="{{ isset($header['top']['show_header']) && $header['top']['show_header'] == 1 ? '' : 'md:hidden' }}">
    <div class="mx-4 pt-2p lg:mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92 font-medium text-base flex justify-between items-center h-16 md:h-10 roboto-medium">
        <div class="flex items-center rtl:order-1 rtl:md:order-none rtl:mr-auto rtl:md:m-[unset]">
            <div style="color: {{ $header['top']['text_color'] }}" class="hidden md:block">
                <ul class="flex flex-col sm:flex-row text-xs">
                    @if (isset($header['top']['show_phone']) && $header['top']['show_phone'] == 1)
                        <li>
                            <a href="javascript: void(0)" class="w-fill flex ltr:pr-30p rtl:pl-30p">
                                <svg class="neg-transition-scale" width="13" height="13" viewBox="0 0 13 13" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.37104 0.70694L1.84948 0.228499C2.15415 -0.0761661 2.64811 -0.0761666 2.95277 0.228499L4.97006 2.24579C5.27472 2.55045 5.27472 3.04441 4.97006 3.34908L3.57172 4.74742C3.33855 4.98059 3.28074 5.3368 3.42821 5.63175C4.28072 7.33676 5.66324 8.71928 7.36826 9.57179C7.6632 9.71926 8.01941 9.66145 8.25259 9.42828L9.65092 8.02994C9.95559 7.72528 10.4495 7.72528 10.7542 8.02994L12.7715 10.0472C13.0762 10.3519 13.0762 10.8459 12.7715 11.1505L12.2931 11.629C10.6459 13.2761 8.03822 13.4614 6.17467 12.0638L5.23194 11.3567C3.87173 10.3366 2.66343 9.12827 1.64327 7.76806L0.936223 6.82533C-0.461438 4.96178 -0.276117 2.3541 1.37104 0.70694Z" fill="{{ $textColor }}" />
                                </svg>
                                <span class="rtl-direction-space -mt-0.5 ltr:pl-2 rtl:pr-2">{!! isset($header['top']['phone']) ? $header['top']['phone'] : '' !!}</span>
                            </a>
                        </li>
                    @endif

                    @if (isset($header['top']['show_email']) && $header['top']['show_email'] == 1)
                        <li>
                            <a href="#" class="w-fill flex">
                                <svg class="neg-transition-scale" width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.781049 0.815917C0 1.63183 0 2.94503 0 5.57143V7.42857C0 10.055 0 11.3682 0.781049 12.1841C1.5621 13 2.81918 13 5.33333 13H10.6667C13.1808 13 14.4379 13 15.219 12.1841C16 11.3682 16 10.055 16 7.42857V5.57143C16 2.94503 16 1.63183 15.219 0.815917C14.4379 0 13.1808 0 10.6667 0H5.33333C2.81918 0 1.5621 0 0.781049 0.815917ZM3.15973 2.94167C2.75126 2.6572 2.19938 2.7725 1.92707 3.19921C1.65475 3.62591 1.76513 4.20243 2.1736 4.4869L7.01387 7.8578C7.61102 8.27368 8.38898 8.27368 8.98613 7.8578L13.8264 4.4869C14.2349 4.20243 14.3452 3.62591 14.0729 3.19921C13.8006 2.7725 13.2487 2.6572 12.8403 2.94167L8 6.31257L3.15973 2.94167Z" fill="{{ $textColor }}"/>
                                </svg>
                                <span class="rtl-direction-space -mt-0.5 ltr:pl-2 rtl:pr-2">{!! isset($header['top']['email']) ? $header['top']['email'] : '' !!}</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="md:hidden rtl:order-2">
                <svg class="burger pointer" width="27" height="21" viewBox="0 0 27 21" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M0 18.5233C0 17.6563 0.737949 16.9535 1.64826 16.9535H11.5378C12.4481 16.9535 13.186 17.6563 13.186 18.5233C13.186 19.3902 12.4481 20.093 11.5378 20.093H1.64826C0.737949 20.093 0 19.3902 0 18.5233Z"
                        fill="#2C2C2C" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M0 10.0465C0 9.00615 0.749663 8.16278 1.67442 8.16278H18.4186C19.3434 8.16278 20.093 9.00615 20.093 10.0465C20.093 11.0869 19.3434 11.9302 18.4186 11.9302H1.67442C0.749663 11.9302 0 11.0869 0 10.0465Z"
                        fill="#2C2C2C" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M0 1.56977C0 0.702809 0.755519 0 1.6875 0H25.3125C26.2445 0 27 0.702809 27 1.56977C27 2.43673 26.2445 3.13953 25.3125 3.13953H1.6875C0.755519 3.13953 0 2.43673 0 1.56977Z"
                        fill="#2C2C2C" />
                </svg>
            </div>
            @if (isset($header['main']['show_logo']) && $header['main']['show_logo'] == 1 && $headerLogo->objectFile)
                <div class="md:hidden ml-10 rtl:order-1">
                    <a href="{{ route('site.index') }}">
                        <img class="w-36 h-11 object-contain neg-transition-scale" src="{{ $headerLogo->fileUrl() }}" alt="{{ __('Image') }}">
                    </a>
                </div>
            @endif
        </div>
        <div class="flex items-center">
            <div style="color: {{ $header['top']['text_color'] }}" class="hidden md:block">
                @php
                    $languages  = \App\Models\Language::getAll()->where('status', 'Active');
                @endphp
                <ul class="flex flex-col sm:flex-row">
                    @if (isset($header['top']['show_seller']) && $header['top']['show_seller'] == 1 && preference('vendor_signup') == '1' && (!Auth::check() || auth()->user()->role()->slug != 'super-admin' && auth()->user()->role()->slug != 'vendor-admin'))
                        <li class="flex items-center">
                            <a href="{{ route('site.seller.signUp') }}" class="flex w-fill ltr:pl-30p rtl:pr-0">
                                <svg class="neg-transition-scale" width="19" height="15" viewBox="0 0 19 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.1481 8.24503C12.3121 8.12948 12.3903 7.9282 12.3568 7.73064L11.9505 5.36374L13.6688 3.69013C13.8105 3.55222 13.8627 3.33976 13.803 3.14966C13.7397 2.95956 13.5757 2.82165 13.3781 2.79183L11.0037 2.44518L9.94143 0.294465C9.85198 0.11555 9.66933 0 9.46805 0C9.26677 0 9.08413 0.11555 8.99467 0.294465L7.93236 2.44518L5.558 2.79183C5.36045 2.82165 5.19645 2.95956 5.13308 3.14966C5.06971 3.33976 5.1219 3.54849 5.26727 3.69013L6.9856 5.36374L6.57931 7.73064C6.54577 7.9282 6.62777 8.12575 6.78805 8.24503C6.95205 8.3643 7.16452 8.37921 7.34343 8.28603L9.46805 7.1678L11.5927 8.28603C11.6747 8.32703 11.9393 8.39412 12.1481 8.24503V8.24503ZM9.71779 6.10922C9.47178 6.02722 9.47178 6.02722 9.2295 6.10922L7.80563 6.85843L8.07773 5.27055C8.10755 5.09909 8.05164 4.92763 7.92491 4.80463L6.77314 3.67895L8.36847 3.44785C8.53993 3.42176 8.68903 3.31367 8.76357 3.16084L9.47551 1.71833L10.1874 3.16084C10.2657 3.31739 10.4111 3.42549 10.5825 3.44785L12.1779 3.67895L11.0261 4.80463C10.9031 4.9239 10.8472 5.09909 10.8733 5.27055L11.1454 6.85843L9.71779 6.10922Z" fill="{{ $textColor }}"/>
                                <path d="M18.9133 9.80298C18.85 9.61288 18.6859 9.47497 18.4884 9.44515L16.114 9.0985L15.0517 6.94779C14.9623 6.76887 14.7796 6.65332 14.5783 6.65332C14.3771 6.65332 14.1944 6.76887 14.105 6.94779L13.0427 9.0985L10.6683 9.44515C10.4707 9.47497 10.3067 9.61288 10.2434 9.80298C10.18 9.99308 10.2322 10.2018 10.3776 10.3435L12.0959 12.0171L11.6896 14.384C11.6561 14.5815 11.7381 14.7791 11.8983 14.8983C12.0623 15.0176 12.2748 15.0325 12.4537 14.9393L14.5783 13.8211L16.703 14.9393C16.7812 14.9803 17.0459 15.0474 17.2583 14.8983C17.4224 14.7828 17.5006 14.5815 17.4671 14.384L17.0608 12.0171L18.7791 10.3435C18.9245 10.2018 18.9767 9.99308 18.9133 9.80298V9.80298ZM16.1289 11.4542C16.0059 11.5735 15.95 11.7487 15.9761 11.9201L16.2482 13.508L14.8244 12.7588C14.5783 12.6768 14.5783 12.6768 14.3361 12.7588L12.9122 13.508L13.1843 11.9201C13.2141 11.7487 13.1582 11.5772 13.0315 11.4542L11.8797 10.3323L13.475 10.1012C13.6465 10.0751 13.7956 9.96699 13.8701 9.81416L14.5821 8.37165L15.294 9.81416C15.3723 9.97071 15.5176 10.0788 15.6891 10.1012L17.2844 10.3323L16.1289 11.4542Z" fill="{{ $textColor }}"/>
                                <path d="M8.27157 9.44515L5.89721 9.0985L4.8349 6.94779C4.74544 6.76887 4.5628 6.65332 4.36152 6.65332C4.16024 6.65332 3.97759 6.76887 3.88814 6.94779L2.82583 9.0985L0.451467 9.44515C0.253914 9.47497 0.0899081 9.61288 0.0265422 9.80298C-0.0368237 9.99308 0.01536 10.2018 0.160729 10.3435L1.87906 12.0171L1.47278 14.384C1.43923 14.5815 1.52123 14.7791 1.68151 14.8983C1.84552 15.0176 2.05798 15.0325 2.23689 14.9393L4.36152 13.8211L6.48614 14.9393C6.56441 14.9803 6.82906 15.0474 7.04152 14.8983C7.20553 14.7828 7.2838 14.5815 7.25026 14.384L6.84397 12.0171L8.56231 10.3435C8.70395 10.2055 8.75613 9.99308 8.69649 9.80298C8.63313 9.61288 8.46912 9.47124 8.27157 9.44515V9.44515ZM5.91212 11.4542C5.78911 11.5735 5.7332 11.7487 5.75929 11.9201L6.0314 13.508L4.60753 12.7588C4.36152 12.6768 4.36152 12.6768 4.11924 12.7588L2.69537 13.508L2.96747 11.9201C2.99729 11.7487 2.94137 11.5772 2.81464 11.4542L1.65915 10.3323L3.25448 10.1012C3.42594 10.0751 3.57503 9.96699 3.64958 9.81416L4.36152 8.37165L5.07345 9.81416C5.15173 9.97071 5.2971 10.0788 5.46856 10.1012L7.06389 10.3323L5.91212 11.4542Z" fill="{{ $textColor }}"/>
                                </svg>
                                <span class="text-xs rtl-direction-space ml-7p">{{ __('Be a seller') }}</span>
                            </a>
                        </li>
                    @endif

                    @includeIf('affiliate::layouts.includes.be_affiliate')

                    @if (isset($header['top']['show_compare']) && $header['top']['show_compare'] == 1)
                        @php
                            $productCount = \App\Compare\Compare::totalProduct();
                        @endphp
                        <li class="flex items-center">
                            <a href="{{ route('site.compare') }}" class="flex w-fill ltr:pl-30p rtl:pr-30p">
                                <div class="flex items-center justify-center text-xss roboto-medium rounded-full mr-7p rtl:ml-7p {{ !empty($productCount) ? 'w-4 h-4' : '' }} bg-reds-3 text-white" id="totalCompareItem">
                                    {{ !empty($productCount) ? $productCount : ''  }}
                                </div>
                                <svg class="neg-transition-scale" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.0488 0.0126572C2.01118 0.0194979 1.8949 0.043438 1.79229 0.0639582C1.68969 0.0844793 1.46055 0.169981 1.2827 0.255483C1.01252 0.385445 0.909917 0.457267 0.677352 0.689831C0.444787 0.925816 0.372966 1.025 0.243003 1.29518C0.0412193 1.71585 -0.00324155 1.91422 0.000178515 2.36908C0.00701865 2.93682 0.171182 3.38484 0.547389 3.84313C0.776534 4.12016 1.22114 4.4177 1.59393 4.53741L1.72047 4.57845L1.73415 7.44104C1.74783 10.6217 1.73415 10.4439 1.98382 10.9535C2.27794 11.5588 2.84225 12.0171 3.50575 12.1881C3.68359 12.236 3.95036 12.2497 4.93534 12.2599L6.14604 12.277L5.69459 12.7285L5.24656 13.1765L5.65697 13.5869L6.06738 13.9973L7.06262 13.0055C7.60983 12.4583 8.07838 11.9658 8.10574 11.9042C8.1673 11.764 8.1673 11.5793 8.10574 11.4391C8.07838 11.3775 7.60983 10.8851 7.06262 10.3378L6.06738 9.34602L5.65697 9.75643L5.24656 10.1668L5.69801 10.6217L6.15288 11.0766L4.93876 11.0663L3.72463 11.0561L3.55363 10.9637C3.34842 10.8543 3.12954 10.632 3.0201 10.4233L2.93802 10.2694L2.92776 7.42394L2.92092 4.58187L3.04746 4.53741C4.08032 4.20566 4.76433 3.14886 4.63779 2.09548C4.51809 1.12418 3.89906 0.382025 2.97222 0.0981588C2.74307 0.0263376 2.19928 -0.0249634 2.0488 0.0126572ZM2.59601 1.20626C3.13296 1.34648 3.47497 1.78425 3.47497 2.33488C3.47497 2.60849 3.41341 2.80685 3.2595 3.01548C3.04404 3.31986 2.71229 3.48403 2.3224 3.48745C1.76835 3.48745 1.33058 3.14544 1.19036 2.59481C1.03988 1.99288 1.41267 1.37726 2.0317 1.20968C2.27452 1.1447 2.35319 1.1447 2.59601 1.20626Z" fill="{{ $textColor }}"/>
                                    <path d="M6.89801 1.02512C6.34738 1.57575 5.88225 2.07166 5.86173 2.12296C5.81385 2.25634 5.81727 2.4376 5.87541 2.56757C5.90277 2.62913 6.37132 3.12162 6.91853 3.66883L7.91377 4.66065L8.32418 4.25024L8.73459 3.83983L8.28314 3.38496L7.82827 2.93009L9.04239 2.94036L10.2565 2.95062L10.4275 3.04296C10.6327 3.1524 10.8516 3.3747 10.9611 3.58333L11.0431 3.73723L11.0534 6.58273L11.0602 9.4248L10.9337 9.46926C10.5199 9.60265 10.065 9.92071 9.80849 10.2627C9.48358 10.6902 9.33652 11.1314 9.33652 11.6718C9.33652 12.3216 9.55882 12.8551 10.0171 13.3134C10.3215 13.6178 10.5985 13.7854 11.026 13.9154C11.3886 14.0282 11.9289 14.0282 12.2915 13.9154C13.0883 13.6691 13.6561 13.1082 13.8955 12.325C14.2477 11.1759 13.6116 9.91729 12.4659 9.50005L12.2607 9.4248L12.247 6.57931C12.2367 4.01084 12.2299 3.71671 12.1786 3.51493C11.9973 2.84801 11.5219 2.27002 10.9132 1.97932C10.4754 1.77411 10.4002 1.76385 9.06291 1.74675L7.83511 1.72965L8.28656 1.2782L8.73459 0.830173L8.33102 0.426605C8.11213 0.207721 7.92061 0.0264578 7.91377 0.0264578C7.90351 0.0264578 7.44522 0.477906 6.89801 1.02512ZM12.0589 10.5808C12.4112 10.7039 12.6882 11.022 12.7908 11.4119C12.9994 12.2327 12.2196 13.0125 11.3988 12.8038C10.6498 12.6123 10.2873 11.836 10.6225 11.1451C10.8721 10.6321 11.5048 10.3824 12.0589 10.5808Z" fill="{{ $textColor }}"/>
                                </svg>
                                <span class="text-xs rtl-direction-space ml-7p">{{ __('Compare') }}</span>
                            </a>
                        </li>
                    @endif

                    @if (isset($header['top']['show_currency']) && $header['top']['show_currency'] == 1)
                        <li class="flex items-center">
                            <a href="#" class="flex w-fill ltr:pl-30p rtl:pr-30p">
                                <span class="neg-transition-scale">
                                    {{ currency()->symbol }}
                                </span>
                                <span class="text-xs rtl-direction-space ml-7p mt-1.5">{{ currency()->name }}</span>
                            </a>
                        </li>
                    @endif

                    @if ($languages->isNotEmpty() && isset($header['top']['show_language']) && $header['top']['show_language'] == 1)
                        <button class="rtl-direction-space-left flex items-center justify-end ltr:pl-30p rtl:pr-30p">
                            <span class="text-sm roboto-medium text-gray-12 ltr:mr-6 rtl:ml-6">
                                <svg class="ltr:-mr-2 rtl:-ml-2" width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.22222 0V4.27867C5.02711 4.15124 3.92648 3.73362 3.09069 3.09917C2.62635 2.74669 2.26451 2.34416 2.00906 1.91439C3.10808 0.870404 4.57949 0.169659 6.22222 0ZM7.77778 0V4.27867C8.97289 4.15124 10.0735 3.73362 10.9093 3.09917C11.3736 2.7467 11.7355 2.34416 11.9909 1.91439C10.8919 0.870406 9.42051 0.169659 7.77778 0ZM13.0019 3.13255C12.6939 3.53233 12.3204 3.90054 11.8902 4.22711C10.7609 5.08438 9.30819 5.60689 7.77778 5.73959L7.77778 7.26013C8.41133 7.31505 9.03445 7.437 9.62923 7.62402C10.4661 7.88714 11.2354 8.27553 11.8902 8.77263C12.3177 9.09708 12.692 9.46462 13.0021 9.86715C13.6356 8.88358 14 7.73154 14 6.5C14 5.26833 13.6356 4.11619 13.0019 3.13255ZM11.991 11.0856C11.7336 10.653 11.3698 10.2501 10.9093 9.90056C10.4086 9.52047 9.80605 9.21303 9.13305 9.00142C8.69923 8.86501 8.24368 8.77083 7.77778 8.72112V13C9.42054 12.8303 10.892 12.1296 11.991 11.0856ZM6.22222 13L6.22222 8.72112C5.75632 8.77083 5.30077 8.86501 4.86695 9.00142C4.19395 9.21303 3.5914 9.52047 3.09069 9.90056C2.63019 10.2501 2.26635 10.653 2.00901 11.0856C3.10803 12.1296 4.57946 12.8303 6.22222 13ZM0.997862 9.86715C1.30804 9.46462 1.68235 9.09708 2.10976 8.77263C2.76462 8.27553 3.53394 7.88714 4.37077 7.62402C4.96555 7.437 5.58867 7.31505 6.22222 7.26013V5.73959C4.69181 5.60689 3.23909 5.08438 2.10976 4.22711C1.67956 3.90054 1.30615 3.53233 0.998052 3.13255C0.364433 4.11618 0 5.26833 0 6.5C0 7.73154 0.364361 8.88358 0.997862 9.86715Z" fill="{{ $textColor }}"/>
                                </svg>
                            </span>

                            @php
                                $langData = Cache::get(config('cache.prefix') . '-user-language-' . optional(Auth::guard('user')->user())->id);
                                if (!auth()->user()) {
                                    $langData = Cache::get(config('cache.prefix') . '-guest-language-' . request()->server('HTTP_USER_AGENT'));
                                }
                                if (empty($langData)) {
                                    $langData = preference('dflt_lang');
                                }
                            @endphp
                            <div id="directionSwitch" class="dropdown rounded shadow-none relative lang-dropdown lang"
                                data-value={{ $languages->where('short_name', $langData)->first()->direction }}>
                                <div class="select flex justify-between items-center lang-p">
                                    <p class="msg roboto-medium msg-color ltr:mr-1.5 rtl:ml-1.5">
                                        {{ $languages->where('short_name', $langData)->first()->name }} </p>
                                    <svg width="7" height="4" viewBox="0 0 7 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M3.93933e-08 0.696543L0.737986 8.80039e-09L3.5 2.60691L6.26201 7.46738e-08L7 0.696543L3.5 4L3.93933e-08 0.696543Z"
                                            fill="{{ $textColor }}" />
                                    </svg>
                                </div>
                                <input type="hidden" name="Showing" value="English">
                                <ul class="dropdown-menu language-dropdown border border-gray-11 ltr:-right-2 rtl:-left-2 top-30p">
                                    @foreach ($languages as $language)
                                        <li id="{{ $language->name }}" class="Showing lang-change text-gray-10 {{ $langData == $language->short_name ? ' primary-bg-color text-gray-12' : '' }}">
                                            <a class="roboto-medium text-xs text-left lang" data-short_name="{{ $language->short_name }}">
                                                {{ $language->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </button>
                    @endif
                </ul>
            </div>
        </div>
        <div class="md:hidden">
            <div class="flex justify-end items-end rev rtl:order-2 rtl:md:order-none rtl:ml-auto rtl:md:m-[unset]">
                <ul class="flex">
                    <li>
                        @auth
                            <!--user dropdown start-->
                            <div class="flex relative inline-block">
                                <div class="relative text-sm" x-data="{ open: false }" x-cloak>
                                    <button @click="open = !open" class="flex items-center focus:outline-none">
                                        <div class="flex flex-col justify-center mr-10 bg-gray-100 items-center h-9 w-9 rounded-full pink-blue dark:text-gray-2 hover:text-purple-500 cursor-pointer">
                                            <img class="h-9 w-9 rounded-full pink-blue dark:text-gray-2 hover:text-purple-500 cursor-pointer" src="{{ Auth::user()->fileUrl() }}" alt="Avatar of User">
                                        </div>
                                    </button>
                                    <div x-show.transition="open" @click.away="open = false"
                                        class="absolute right-0 w-40 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700 overflow-auto z-50">
                                        <ul class="list-reset text-gray-600">
                                            @if (isset($header['main']['show_account']) && $header['main']['show_account'] == 1)
                                                <li class="flex">
                                                    <a href="{{ route('site.dashboard') }}"
                                                        class="inline-flex items-center w-full px-2 py-1 text-sm transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200">
                                                        <svg class="w-4 h-4 ltr:mr-3 rtl:ml-3 neg-transition-scale" aria-hidden="true" fill="none"
                                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path
                                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                            </path>
                                                        </svg>
                                                        <span>{{ __('My Account') }}</span>
                                                    </a>
                                                </li>
                                            @endif
                                            @if (auth()->user()->role()->slug == 'super-admin')
                                                <li class="flex">
                                                    <a href="{{ route('dashboard') }}" target="_blank" class="inline-flex items-center w-full px-2 py-1 text-sm transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200">
                                                        <svg class="w-4 h-4 mr-3 neg-transition-scale" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M22 2H13V4H18.5858L10.2929 12.2929C9.90237 12.6834 9.90237 13.3166 10.2929 13.7071C10.6834 14.0976 11.3166 14.0976 11.7071 13.7071L20 5.41421V11H22V2Z" fill="#898989"/>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.90036 5.04616C7.39907 5.00096 8.04698 5 9 5C9.55228 5 10 4.55229 10 4C10 3.44772 9.55228 3 9 3L8.95396 3C8.05849 2.99998 7.31952 2.99997 6.71983 3.05432C6.09615 3.11085 5.52564 3.23242 5 3.5359C4.39192 3.88697 3.88697 4.39192 3.5359 5C3.23242 5.52564 3.11085 6.09615 3.05432 6.71983C2.99997 7.31953 2.99998 8.05851 3 8.95399V14.0705C2.99996 15.4247 2.99993 16.5413 3.11875 17.4251C3.24349 18.3529 3.51546 19.1723 4.17157 19.8284C4.82768 20.4845 5.64711 20.7565 6.57494 20.8813C7.4587 21.0001 8.57532 21 9.92945 21H15.046C15.9415 21 16.6805 21 17.2802 20.9457C17.9039 20.8892 18.4744 20.7676 19 20.4641C19.6081 20.113 20.113 19.6081 20.4641 19C20.7676 18.4744 20.8891 17.9039 20.9457 17.2802C21 16.6805 21 15.9415 21 15.046L21 15C21 14.4477 20.5523 14 20 14C19.4477 14 19 14.4477 19 15C19 15.953 18.999 16.6009 18.9538 17.0996C18.9099 17.5846 18.8305 17.8295 18.732 18C18.5565 18.304 18.304 18.5565 18 18.7321C17.8295 18.8305 17.5846 18.9099 17.0996 18.9538C16.6009 18.999 15.953 19 15 19H10C8.55752 19 7.57625 18.9979 6.84143 18.8991C6.13538 18.8042 5.80836 18.6368 5.58579 18.4142C5.36321 18.1916 5.19584 17.8646 5.10092 17.1586C5.00212 16.4237 5 15.4425 5 14V9C5 8.04698 5.00096 7.39908 5.04616 6.90036C5.09011 6.41539 5.1695 6.17051 5.26795 6C5.44348 5.69596 5.69596 5.44349 6 5.26795C6.17051 5.16951 6.41539 5.09011 6.90036 5.04616Z" fill="#898989"/>
                                                        </svg>
                                                    <span class="break-all">{{ __('Admin Panel') }}</span>
                                                    </a>
                                                </li>
                                            @endif

                                            @if (auth()->user()->role()->slug == 'super-admin' || (auth()->user()->role()->slug == 'vendor-admin' && optional(auth()->user()->vendors()->first())->status == 'Active'))
                                                <li class="flex">
                                                    <a href="{{ route('vendor-dashboard') }}" target="_blank" class="inline-flex items-center w-full px-2 py-1 text-sm transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200">
                                                        <svg class="w-4 h-4 mr-3 neg-transition-scale" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M22 2H13V4H18.5858L10.2929 12.2929C9.90237 12.6834 9.90237 13.3166 10.2929 13.7071C10.6834 14.0976 11.3166 14.0976 11.7071 13.7071L20 5.41421V11H22V2Z" fill="#898989"/>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.90036 5.04616C7.39907 5.00096 8.04698 5 9 5C9.55228 5 10 4.55229 10 4C10 3.44772 9.55228 3 9 3L8.95396 3C8.05849 2.99998 7.31952 2.99997 6.71983 3.05432C6.09615 3.11085 5.52564 3.23242 5 3.5359C4.39192 3.88697 3.88697 4.39192 3.5359 5C3.23242 5.52564 3.11085 6.09615 3.05432 6.71983C2.99997 7.31953 2.99998 8.05851 3 8.95399V14.0705C2.99996 15.4247 2.99993 16.5413 3.11875 17.4251C3.24349 18.3529 3.51546 19.1723 4.17157 19.8284C4.82768 20.4845 5.64711 20.7565 6.57494 20.8813C7.4587 21.0001 8.57532 21 9.92945 21H15.046C15.9415 21 16.6805 21 17.2802 20.9457C17.9039 20.8892 18.4744 20.7676 19 20.4641C19.6081 20.113 20.113 19.6081 20.4641 19C20.7676 18.4744 20.8891 17.9039 20.9457 17.2802C21 16.6805 21 15.9415 21 15.046L21 15C21 14.4477 20.5523 14 20 14C19.4477 14 19 14.4477 19 15C19 15.953 18.999 16.6009 18.9538 17.0996C18.9099 17.5846 18.8305 17.8295 18.732 18C18.5565 18.304 18.304 18.5565 18 18.7321C17.8295 18.8305 17.5846 18.9099 17.0996 18.9538C16.6009 18.999 15.953 19 15 19H10C8.55752 19 7.57625 18.9979 6.84143 18.8991C6.13538 18.8042 5.80836 18.6368 5.58579 18.4142C5.36321 18.1916 5.19584 17.8646 5.10092 17.1586C5.00212 16.4237 5 15.4425 5 14V9C5 8.04698 5.00096 7.39908 5.04616 6.90036C5.09011 6.41539 5.1695 6.17051 5.26795 6C5.44348 5.69596 5.69596 5.44349 6 5.26795C6.17051 5.16951 6.41539 5.09011 6.90036 5.04616Z" fill="#898989"/>
                                                        </svg>
                                                    <span>{{ __('Vendor Panel') }}</span>
                                                    </a>
                                                </li>
                                            @endif
                                            <li class="flex">
                                                <a href="{{ route('site.logout') }}"
                                                    class="inline-flex items-center w-full px-2 py-1 text-sm transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200">
                                                    <svg class="w-4 h-4 ltr:mr-3 rtl:ml-3" aria-hidden="true" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path
                                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                                        </path>
                                                    </svg>
                                                    <span>{{ __('Logout') }}</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- user dropdown end -->
                        @else
                            <!-- unauthenticated -->
                            <div
                                class="flex flex-col justify-center mr-11 items-center cursor-pointer open-login-modal">
                                <svg width="21" height="22" viewBox="0 0 21 22" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M10.4102 2.38517C8.43424 2.38517 6.83243 3.98698 6.83243 5.96291C6.83243 7.93885 8.43424 9.54066 10.4102 9.54066C12.3861 9.54066 13.9879 7.93885 13.9879 5.96291C13.9879 3.98698 12.3861 2.38517 10.4102 2.38517ZM4.44727 5.96291C4.44727 2.66969 7.11695 0 10.4102 0C13.7034 0 16.3731 2.66969 16.3731 5.96291C16.3731 9.25614 13.7034 11.9258 10.4102 11.9258C7.11695 11.9258 4.44727 9.25614 4.44727 5.96291Z"
                                        fill="#2C2C2C" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M4.00564 15.9486C5.86929 14.8761 8.11934 14.311 10.4085 14.311C12.6976 14.311 14.9477 14.8761 16.8113 15.9486C18.6743 17.0207 20.0908 18.5688 20.7471 20.4058C20.9687 21.0261 20.6455 21.7085 20.0253 21.9301C19.405 22.1517 18.7226 21.8286 18.501 21.2083C18.0701 20.0024 17.0911 18.8615 15.6216 18.0159C14.1528 17.1706 12.3198 16.6961 10.4085 16.6961C8.49717 16.6961 6.66414 17.1706 5.19535 18.0159C3.72586 18.8615 2.74681 20.0024 2.31597 21.2083C2.09437 21.8286 1.41193 22.1517 0.791676 21.9301C0.171426 21.7085 -0.151748 21.0261 0.0698463 20.4058C0.726164 18.5688 2.14268 17.0207 4.00564 15.9486Z"
                                        fill="#2C2C2C" />
                                </svg>
                            </div>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="block md:hidden">
        <div id="overlay" class="fixed z-50 top-0 left-0 bg-darken-4" ></div>
        <div id="sidenav" class="flex flex-col fixed z-50 top-0 left-0 bg-gray-12 text-gray-2">
            <div class="mx-5">
                <div class="close flex items-center justify-center relative pointer mb-2 float-right mt-30p rtl:ml-5">
                    <svg class="cross" width="13" height="13" viewBox="0 0 13 13" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.455612 0.455612C1.06309 -0.151871 2.04802 -0.151871 2.6555 0.455612L11.9888 9.78895C12.5963 10.3964 12.5963 11.3814 11.9888 11.9888C11.3814 12.5963 10.3964 12.5963 9.78895 11.9888L0.455612 2.6555C-0.151871 2.04802 -0.151871 1.06309 0.455612 0.455612Z"
                            fill="white" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M11.9897 0.455612C11.3822 -0.151871 10.3973 -0.151871 9.78981 0.455612L0.45648 9.78895C-0.151003 10.3964 -0.151003 11.3814 0.45648 11.9888C1.06396 12.5963 2.04889 12.5963 2.65637 11.9888L11.9897 2.6555C12.5972 2.04802 12.5972 1.06309 11.9897 0.455612Z"
                            fill="white" />
                    </svg>
                </div>
                @if (isset($header['main']['show_logo']) && $header['main']['show_logo'] == 1 && $headerMobileLogo->objectFile)
                    <div class="flex items-center mt-30p">
                        <a href="{{ route('site.index') }}">
                            <img class="w-36 h-11 object-contain neg-transition-scale"
                                src="{{ $headerMobileLogo->fileUrl() }}" alt="{{ __('Image') }}">
                        </a>
                    </div>
                @endif
                <div class="flex items-center cursor-pointer mt-30p">
                    @if (isset($header['main']['show_account']) && $header['main']['show_account'] == 1)
                        @if ((Auth::user() && Auth::user()->role()->type == 'global' && Auth::user()->role()->slug == 'super-admin') || (Auth::user() && Auth::user()->role()->type == 'global' && Auth::user()->role()->slug == 'customer'))
                            <!--user dropdown start-->
                            <div class="flex relative inline-block">
                                <div class="relative text-sm">
                                    <button class="flex items-center focus:outline-none ">
                                        <div class="flex flex-col justify-center bg-gray-100 items-center h-12 w-12 rounded-full cursor-pointer">
                                            <img class="h-12 w-12 rounded-full pink-blue cursor-pointer"
                                                src="{{ Auth::user()->fileUrl() }}" alt="Avatar of User">
                                        </div>
                                    </button>
                                </div>
                            </div>
                            <!-- user dropdown end -->
                        @else
                            <svg class="open-login-modal" width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="25" cy="25" r="25" fill="#3C3C3C" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M24.7266 18C23.0697 18 21.7266 19.3431 21.7266 21C21.7266 22.6569 23.0697 24 24.7266 24C26.3834 24 27.7266 22.6569 27.7266 21C27.7266 19.3431 26.3834 18 24.7266 18ZM19.7266 21C19.7266 18.2386 21.9651 16 24.7266 16C27.488 16 29.7266 18.2386 29.7266 21C29.7266 23.7614 27.488 26 24.7266 26C21.9651 26 19.7266 23.7614 19.7266 21Z" fill="#ABABAB" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M19.3588 29.3732C20.9215 28.4738 22.8082 28 24.7277 28C26.6472 28 28.5339 28.4738 30.0966 29.3732C31.6587 30.2722 32.8465 31.5702 33.3968 33.1106C33.5826 33.6307 33.3116 34.203 32.7915 34.3888C32.2714 34.5746 31.6992 34.3036 31.5134 33.7835C31.1521 32.7723 30.3312 31.8157 29.099 31.1066C27.8674 30.3978 26.3303 30 24.7277 30C23.125 30 21.588 30.3978 20.3564 31.1066C19.1242 31.8157 18.3032 32.7723 17.942 33.7835C17.7562 34.3036 17.1839 34.5746 16.6638 34.3888C16.1437 34.203 15.8728 33.6307 16.0586 33.1106C16.6089 31.5702 17.7967 30.2721 19.3588 29.3732Z" fill="#ABABAB" />
                            </svg>
                        @endif
                        <div class="ltr:ml-3 rtl:mr-3">
                            <p class="dm-bold font-bold text-sm">
                                @auth
                                    {{ Auth::user()->name }}
                                @else
                                <p class="open-login-modal">{{ __('No Account') }}</p>
                                @endauth
                            </p>
                            <p class="roboto-medium font-medium text-11 mt-0.5 cursor-pointer">
                                @auth
                                    {{ Auth::user()->email }}
                                @else
                                <p class="open-login-modal">{{ __('Register or login now') }}</p>
                            @endauth
                            </p>
                        </div>
                    @endif
                </div>
                <div class="flex items-center mt-35p">
                    <svg class="neg-transition-scale" width="14" height="17" viewBox="0 0 14 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.8877 1.82952C5.38875 2.1649 4.79817 2.67836 3.94593 3.4218L3.04594 4.2069C2.07069 5.05765 1.75458 5.35299 1.58498 5.72828C1.41463 6.10522 1.40008 6.54516 1.40008 7.85203V11.736C1.40008 12.619 1.40152 13.2121 1.45995 13.6544C1.51589 14.0779 1.61252 14.2565 1.72659 14.3726C1.83897 14.487 2.0096 14.583 2.41987 14.6392C2.85156 14.6983 3.43139 14.6998 4.30004 14.6998H9.69996C10.5686 14.6998 11.1484 14.6983 11.5801 14.6392C11.9904 14.583 12.161 14.487 12.2734 14.3726C12.3875 14.2565 12.4841 14.0779 12.54 13.6544C12.5985 13.2121 12.5999 12.619 12.5999 11.736V7.85204C12.5999 6.54516 12.5854 6.10522 12.415 5.72828C12.2454 5.35299 11.9293 5.05765 10.9541 4.2069L10.0541 3.4218C9.20183 2.67836 8.61125 2.1649 8.1123 1.82952C7.62942 1.50494 7.30682 1.39998 7 1.39998C6.69318 1.39998 6.37058 1.50494 5.8877 1.82952ZM5.10671 0.667625C5.71201 0.260758 6.30804 0 7 0C7.69196 0 8.28799 0.260758 8.89329 0.667624C9.47411 1.05804 10.1306 1.63076 10.9392 2.33611L11.8744 3.15192C11.9112 3.18405 11.9476 3.21574 11.9835 3.24702C12.8054 3.96323 13.3799 4.4639 13.6908 5.15174C14.0009 5.83803 14.0005 6.60465 14 7.70605C13.9999 7.75407 13.9999 7.80272 13.9999 7.85204V11.7837C13.9999 12.6066 14 13.2929 13.928 13.8378C13.8521 14.412 13.6851 14.9334 13.272 15.3538C12.8572 15.776 12.34 15.9482 11.7699 16.0262C11.2321 16.0998 10.5557 16.0998 9.74887 16.0998H4.25112C3.44434 16.0998 2.76788 16.0998 2.23008 16.0262C1.66003 15.9482 1.14281 15.776 0.727991 15.3538C0.314855 14.9334 0.147889 14.412 0.0720281 13.8378C4.9191e-05 13.2929 7.1385e-05 12.6066 9.79206e-05 11.7837L9.89219e-05 7.85203C9.89219e-05 7.80272 7.35546e-05 7.75406 4.8521e-05 7.70604C-0.000526334 6.60465 -0.000926452 5.83803 0.309224 5.15174C0.620073 4.4639 1.19463 3.96323 2.01654 3.24702C2.05243 3.21574 2.0888 3.18405 2.12564 3.15192L3.06084 2.3361C3.86938 1.63076 4.52589 1.05803 5.10671 0.667625Z" fill="#DFDFDF" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.19922 10.4999C4.19922 9.72668 4.82601 9.09988 5.5992 9.09988H8.39916C9.17235 9.09988 9.79914 9.72668 9.79914 10.4999V15.3998C9.79914 15.7864 9.48574 16.0998 9.09915 16.0998C8.71256 16.0998 8.39916 15.7864 8.39916 15.3998V10.4999H5.5992V15.3998C5.5992 15.7864 5.2858 16.0998 4.89921 16.0998C4.51261 16.0998 4.19922 15.7864 4.19922 15.3998V10.4999Z" fill="#DFDFDF" />
                    </svg>
                    <p class="dm-sans text-sm font-medium ltr:ml-13p rtl:mr-13p"><a href="{{ route('site.index') }}">{{ __('Home') }}</a></p>
                </div>
                @if (isset($header['main']['show_track']) && $header['main']['show_track'] == 1)
                    <div class="flex items-center mt-5">
                        <svg class="neg-transition-scale" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7 1.16667C3.77834 1.16667 1.16667 3.77834 1.16667 7C1.16667 10.2217 3.77834 12.8333 7 12.8333C10.2217 12.8333 12.8333 10.2217 12.8333 7C12.8333 3.77834 10.2217 1.16667 7 1.16667ZM0 7C0 3.13401 3.13401 0 7 0C10.866 0 14 3.13401 14 7C14 10.866 10.866 14 7 14C3.13401 14 0 10.866 0 7Z" fill="#DFDFDF" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.3292 3.67087C10.4854 3.82711 10.54 4.0582 10.4701 4.26782L9.01175 8.64282C8.95369 8.817 8.817 8.95369 8.64282 9.01175L4.26782 10.4701C4.0582 10.54 3.82711 10.4854 3.67087 10.3292C3.51463 10.1729 3.46008 9.94183 3.52995 9.73222L4.98828 5.35722C5.04635 5.18303 5.18303 5.04635 5.35722 4.98828L9.73222 3.52995C9.94183 3.46008 10.1729 3.51463 10.3292 3.67087ZM6.00285 6.00285L5.00568 8.99435L7.99718 7.99718L8.99435 5.00568L6.00285 6.00285Z" fill="#DFDFDF" />
                        </svg>
                        <p class="dm-sans text-sm font-medium ltr:ml-13p rtl:mr-13p"><a href="{{ route('site.trackOrder') }}">{{ __('Track Order') }}</a></p>
                    </div>
                @endif
            </div>
            <hr class="my-5 h-px border-t border-gray-600 mx-5">
            @if (isset($header['bottom']['show_category']) && $header['bottom']['show_category'] == 1)
            <?php
            $uncategorized = App\Models\Category::parents();
            $categories = $uncategorized->where('id', '!=', 1);
            ?>
                <div id="accordian" class="relative flex-1 px-5">
                    <ul class="flex flex-col space-y-6 dm-sans font-medium text-sm">
                        @foreach ($categories as $category)
                        @php $checkChildCategory = $category->childrenCategories @endphp

                        <li>
                            <div class="flex justify-between items-center">
                                <p><a href="{{ route('site.productSearch', ['categories' => $category->slug]) }}">{{ $category->name }}</a></p>
                                <h3>
                                    <a class="clicks rotate" href="#">
                                        <svg class="" width="5" height="9" viewBox="0 0 5 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.870679 3.60997e-07L-3.02758e-07 0.948839L3.25864 4.5L3.18147e-07 8.05116L0.87068 9L5 4.5L0.870679 3.60997e-07Z" fill="#DFDFDF"/>
                                        </svg>
                                    </a>
                                </h3>
                            </div>
                            @if ($checkChildCategory)
                            <ul class="mt-3">
                                @foreach ($category->childrenCategories as $childCategory)
                                <li>
                                    <div class="flex justify-between items-center">
                                        <p><a href="{{ route('site.productSearch', ['categories' => $childCategory->slug]) }}">{{ $childCategory->name }}</a></p>
                                        <h3>
                                            <a class="clicks rotate" href="#">
                                                <svg class="" width="5" height="9" viewBox="0 0 5 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.870679 3.60997e-07L-3.02758e-07 0.948839L3.25864 4.5L3.18147e-07 8.05116L0.87068 9L5 4.5L0.870679 3.60997e-07Z" fill="#DFDFDF"/>
                                                </svg>
                                            </a>
                                        </h3>
                                    </div>
                                    @if ($childCategory->categories->count() > 0)
                                    <ul>
                                        @foreach ($childCategory->categories as $grandChildCategory)
                                        <li>
                                            <div class="flex justify-between items-center">
                                                <p><a href="{{ route('site.productSearch', ['categories' => $grandChildCategory->slug]) }}">{{ $grandChildCategory->name }}</a></p>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                    <div class="mt-5">
                        <a class="flex items-center">
                            <span class="dm-sans font-medium text-sm cursor-pointer uppercase">
                                {{ __('See All Categories') }}
                            </span>
                            <svg class="ltr:ml-2.5 rtl:mr-2.5 neg-transition-scale" width="12" height="8" viewBox="0 0 12 8" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 4L10.7071 3.29289L11.4142 4L10.7071 4.70711L10 4ZM1 5C0.447715 5 0 4.55228 0 4C0 3.44772 0.447715 3 1 3V5ZM7.70711 0.292893L10.7071 3.29289L9.29289 4.70711L6.29289 1.70711L7.70711 0.292893ZM10.7071 4.70711L7.70711 7.70711L6.29289 6.29289L9.29289 3.29289L10.7071 4.70711ZM10 5H1V3H10V5Z"
                                    fill="#DFDFDF" />
                            </svg>
                        </a>
                    </div>
                </div>
            @endif
            <hr class="my-5 h-px border-t border-gray-600 mx-5">
            <div class="mx-5 pb-7">
                @auth
                    <a href="{{ route('site.logout') }}">
                        <div class="flex items-center">
                            <svg class="neg-transition-scale" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M10.8075 2.05033C11.1229 1.7349 11.6343 1.7349 11.9497 2.05033C12.9287 3.02929 13.5954 4.27657 13.8655 5.63444C14.1356 6.99231 13.997 8.39977 13.4672 9.67885C12.9373 10.9579 12.0401 12.0512 10.889 12.8204C9.73785 13.5895 8.38447 14.0001 7 14.0001C5.61553 14.0001 4.26215 13.5895 3.11101 12.8204C1.95987 12.0512 1.06266 10.9579 0.532846 9.67886C0.00303305 8.39977 -0.13559 6.99231 0.134506 5.63444C0.404602 4.27657 1.07129 3.02929 2.05025 2.05033C2.36568 1.7349 2.87708 1.7349 3.1925 2.05033C3.50793 2.36575 3.50793 2.87715 3.1925 3.19258C2.43945 3.94563 1.92662 4.90507 1.71885 5.94959C1.51108 6.9941 1.61772 8.07676 2.02527 9.06067C2.43282 10.0446 3.12297 10.8855 4.00847 11.4772C4.89396 12.0689 5.93502 12.3847 7 12.3847C8.06498 12.3847 9.10604 12.0689 9.99153 11.4772C10.877 10.8855 11.5672 10.0446 11.9747 9.06067C12.3823 8.07676 12.4889 6.9941 12.2811 5.94959C12.0734 4.90507 11.5605 3.94563 10.8075 3.19258C10.4921 2.87715 10.4921 2.36575 10.8075 2.05033Z"
                                    fill="#DFDFDF" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M6.9991 -3.38342e-08C7.44517 -5.25204e-08 7.80679 0.361616 7.80679 0.807692L7.80679 3.90384C7.80679 4.34992 7.44517 4.71154 6.9991 4.71154C6.55302 4.71154 6.19141 4.34992 6.19141 3.90384L6.19141 0.807692C6.19141 0.361616 6.55302 -1.51481e-08 6.9991 -3.38342e-08Z"
                                    fill="#DFDFDF" />
                            </svg>
                            <p class="dm-sans font-medium text-sm ltr:ml-3 rtl:mr-3">{{ __('Logout') }}</p>
                        </div>
                    </a>
                @else
                    <div class="flex items-center">
                        <svg class="neg-transition-scale" width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M5.49627 1.4486C6.66013 1.21709 7.86651 1.33591 8.96285 1.79003C10.0592 2.24415 10.9962 3.01317 11.6555 3.99985C12.3148 4.98653 12.6667 6.14655 12.6667 7.33321C12.6667 8.51988 12.3148 9.6799 11.6555 10.6666C10.9962 11.6533 10.0592 12.4223 8.96285 12.8764C7.86651 13.3305 6.66013 13.4493 5.49627 13.2178C4.3324 12.9863 3.26332 12.4149 2.42422 11.5758L1.48143 12.5186C2.50699 13.5441 3.81365 14.2426 5.23615 14.5255C6.65865 14.8085 8.13312 14.6633 9.47309 14.1082C10.8131 13.5532 11.9583 12.6133 12.7641 11.4073C13.5699 10.2014 14 8.78359 14 7.33321C14 5.88284 13.5699 4.46504 12.7641 3.2591C11.9583 2.05316 10.8131 1.11324 9.47309 0.558211C8.13312 0.00317755 6.65866 -0.142045 5.23615 0.140909C3.81365 0.423862 2.50699 1.12228 1.48143 2.14785L2.42422 3.09064C3.26332 2.25154 4.3324 1.68011 5.49627 1.4486Z"
                                fill="#DFDFDF" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M6.51974 3.58344L5.4786 4.41635L7.27874 6.66651H0.665929C0.297745 6.66651 -0.000726121 6.96499 -0.000726121 7.33317C-0.000726121 7.70135 0.297745 7.99982 0.665929 7.99982H7.27874L5.4786 10.25L6.51974 11.0829L9.51953 7.33317L6.51974 3.58344Z"
                                fill="#DFDFDF" />
                        </svg>
                        <p class="dm-sans font-medium text-sm open-login-modal ltr:ml-3 rtl:mr-3">{{ __('Login') }}</p>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</section>
