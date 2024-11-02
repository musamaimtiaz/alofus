<section>
    @php
        $fixedMenu = isset($slides) && $slides->count() && isset($header['bottom']['category_expand']) && $header['bottom']['category_expand'] == 1;
    @endphp
    @if ((isset($header['bottom']['show_page_menu']) && $header['bottom']['show_page_menu'] == 1) ||
        (isset($header['bottom']['show_download_app']) && $header['bottom']['show_download_app'] == 1))
        <div style="border-bottom: 1px solid {{ $header['bottom']['border_bottom'] }}" class="w-full mt-16 absolute">
        </div>
    @endif
    <header style="background: {{ $header['bottom']['bg_color'] }}; border-top: 1px solid {{ $header['bottom']['border_top'] }}" class="header">
        <div class="flex justify-between lg:mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92">
            @if (isset($header['bottom']['show_category']) && $header['bottom']['show_category'] == 1)
                <div class="group group-category dm-sans lg:w-23% md:w-25% h-16 hidden md:block">
                    <div style="color: {{ $header['bottom_category']['text_color'] }}; background: {{ $header['bottom_category']['bg_color'] }}"
                        class="relative md:flex items-center border-r border-l cursor-pointer h-16 px-5 hidden md:block">
                        <svg width="20" height="15" viewBox="0 0 20 15" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M0 1.25C0 0.559644 0.559644 0 1.25 0H18.75C19.4404 0 20 0.559644 20 1.25C20 1.94036 19.4404 2.5 18.75 2.5H1.25C0.559644 2.5 0 1.94036 0 1.25Z"
                                fill="{{ $header['bottom_category']['text_color'] }}" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M0 7.5C0 6.80964 0.559644 6.25 1.25 6.25H18.75C19.4404 6.25 20 6.80964 20 7.5C20 8.19036 19.4404 8.75 18.75 8.75H1.25C0.559644 8.75 0 8.19036 0 7.5Z"
                                fill="{{ $header['bottom_category']['text_color'] }}" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0 13.75C0 13.0596 0.559644 12.5 1.25 12.5H18.75C19.4404 12.5 20 13.0596 20 13.75C20 14.4404 19.4404 15 18.75 15H1.25C0.559644 15 0 14.4404 0 13.75Z"
                                fill="{{ $header['bottom_category']['text_color'] }}" />
                        </svg>
                        <span class="text-base ltr:ml-3 rtl:mr-3">{{ __('Categories') }}</span>
                        <span class="absolute ltr:mr-4 ltr:right-0 rtl:ml-4 rtl:left-0">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                            </svg>
                        </span>
                    </div>
                    <?php
                        $uncategorized = App\Models\Category::parents();
                        $categories = $uncategorized->where('id', '!=', 1);
                    ?>
                    <div
                        class="bg-white border {{ $fixedMenu ? 'transform scale-1 z-30' : 'transform scale-0 group-hover:scale-100 z-30' }} relative h-100 w-full hidden md:block">
                        <div class="accordion-homepage-wrapper">
                            <div class="overflow-hidden tran menu-full-details {{ count($categories) > 8 ? ' height-437p ' : '  ' }} ">
                                @foreach ($categories as $category)
                                    @php $checkChildCategory =count($category->childrenCategories) @endphp
                                    <li class="border-b text-left text-gray-10 category-list-decoration">
                                        <button class="text-left outline-none focus:outline-none w-full">
                                            <div class="primary-bg-hover">
                                                <a class="title-font font-medium text-sm"
                                                    href="{{ route('site.productSearch', ['categories' => $category->slug]) }}">
                                                    <div
                                                        class="flex items-center justify-between w-full categories-menu h-12 ltr:pl-5 ltr:pr-4 rtl:pr-5 rtl:pl-4">
                                                        <div class="flex justify-center items-center">
                                                            <div class="h-5 w-5">
                                                                <img class="h-full neg-transition-scale" src="{{ $category->fileUrl() }}" alt="{{ __('Image') }}">
                                                            </div>
                                                            <span
                                                                class="text-sm cursor-pointer text-one ltr:pl-3 rtl:pr-3 rtl:text-right">
                                                                {{ trimWords( $category->name, 25) }}
                                                            </span>
                                                        </div>
                                                        @if ($checkChildCategory)
                                                            <span class="neg-transition-scale">
                                                                <svg class="fill-current h-4 w-4"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                                                </svg>
                                                            </span>
                                                        @endif
                                                    </div>
                                            </a>
                                            </div>
                                        </button>
                                        @if ($checkChildCategory)
                                            <ul
                                                class="bg-white border absolute top-0 ul-mr min-h-full w-63 ltr:border-l-0 ltr:right-1p rtl:border-r-0 rtl:left-1p">
                                                @foreach ($category->childrenCategories as $childCategory)
                                                    <li class="border-b text-gray-10 w-63 ltr:text-left rtl:text-right">
                                                        <button
                                                            class="w-full category-hover flex items-center outline-none focus:outline-none ltr:text-left rtl:text-right">
                                                            <div
                                                                class="w-64 h-12 flex-shrink-0 md:mx-0 mx-auto text-center p-1 py-2 relative ltr:md:text-left rtl:md:text-right">
                                                                <a href="{{ route('site.productSearch', ['categories' => $childCategory->slug]) }}"
                                                                    class="flex title-font font-medium items-center justify-center m-1 md:justify-start ltr:ml-2 rtl:mr-2">
                                                                    <span
                                                                        class="text-sm cursor-pointer text-one ltr:ml-3 rtl:mr-3">{{ trimWords( $childCategory->name, 30) }}</span>
                                                                    @if (count($childCategory->categories))
                                                                        <span
                                                                            class="absolute top-0 text-center text-sm h-6 w-6 p-0.5 mt-3 ltr:-right-1 ltr:ml-3 rtl:-left-1 rtl:mr-3 neg-transition-scale">
                                                                            <svg class="fill-current h-4 w-4"
                                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                                                <path
                                                                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                                                            </svg>
                                                                        </span>
                                                                    @endif
                                                                </a>
                                                            </div>
                                                        </button>
                                                        @if ($childCategory->categories->count() > 0)
                                                            <ul
                                                                class="bg-white border pb-0.5 absolute top-0 ul-mr min-h-full w-63 ltr:right-0.5 rtl:left-0.5">
                                                                @foreach ($childCategory->categories as $grandChildCategory)
                                                                    <li class="border-b text-gray-10 w-63 ltr:text-left rtl:text-right">
                                                                        <button
                                                                            class="w-full category-hover flex items-center outline-none focus:outline-none ltr:text-left rtl:text-right">
                                                                            <div
                                                                                class="w-64 h-12 flex-shrink-0 md:mx-0 mx-auto text-center p-1 py-2 relative ltr:md:text-left rtl:md:text-right">
                                                                                <a href="{{ route('site.productSearch', ['categories' => $grandChildCategory->slug]) }}"
                                                                                    class="flex title-font font-medium items-center justify-center m-1 md:justify-start ltr:ml-2 rtl:mr-2">
                                                                                    <span
                                                                                        class="text-sm cursor-pointer text-one ltr:ml-3 rtl:mr-3">
                                                                                        {{ trimWords( $grandChildCategory->name, 30) }}
                                                                                    </span>
                                                                                    @if (count($grandChildCategory->categories))
                                                                                        <span class="absolute top-0 text-center text-sm h-6 w-6 p-0.5 mt-3 ltr:-right-1 ltr:ml-3 rtl:-left-1 rtl:mr-3 neg-transition-scale">
                                                                                            <svg class="fill-current h-4 w-4"
                                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                                viewBox="0 0 20 20">
                                                                                                <path
                                                                                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                                                                            </svg>
                                                                                        </span>
                                                                                    @endif
                                                                                </a>
                                                                            </div>
                                                                        </button>
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
                                @if (count($categories) > 8)
                                    <div class="absolute w-full cursor-pointer justify-between expand-button flex bg-white bottom-0 add">
                                        <div class="w-full py-3 flex-shrink-0 md:mx-0 mx-auto text-center p-1 relative  ltr:md:text-left rtl:md:text-right">
                                            <a class="flex justify-between text-center items-center">
                                                <span class="text-gray-10 font-medium text-sm text-one uppercase ltr:ml-2.5 rtl:mr-2.5">{{ __('See All Categories') }} </span>
                                                <svg class="ltr:mr-2 rtl:ml-2" width="11" height="7" viewBox="0 0 11 7"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M5.5 5L4.83564 5.74741L5.5 6.33796L6.16436 5.74741L5.5 5ZM0.335636 1.74741L4.83564 5.74741L6.16436 4.25259L1.66436 0.252591L0.335636 1.74741ZM6.16436 5.74741L10.6644 1.74741L9.33564 0.252591L4.83564 4.25259L6.16436 5.74741Z" fill="#898989" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @php
                $menus = Modules\MenuBuilder\Http\Models\MenuItems::menus(4);
            @endphp
            <div class="{{ isset($header['bottom']['show_category']) && $header['bottom']['show_category'] == 1 ? 'md:ml-5 lg:ml-0 ml-0 md:w-3/4 w-full header-margin-right' : 'w-full ' }}">
                <div class="flex justify-between mx-4 md:mx-0">
                    @if (isset($header['bottom']['show_page_menu']) && $header['bottom']['show_page_menu'] == 1)
                        <div id="nav-wrap" class="w-full md:w-5/6 lg:w-72% md:mt-3 nav-wrap ltr:mr-0 ltr:md:mr-5 rtl:ml-0 rtl:md:ml-5">
                            <ul class="header-menu-nav text-white md:text-black mx-1 md:mx-1 custom-border">
                                @foreach ($menus as $menu)
                                    @php
                                        $url = $menu->url(empty($menu->params) ? 'page' : '');
                                        $url = str_contains($url, url('/')) || str_contains($url, 'http') ? $url : url('/' . $url);
                                        $activeUrl = $url;
                                        if (strpos($activeUrl, '?')) {
                                            $activeUrl = explode('?', $activeUrl)[0];
                                        }
                                    @endphp
                                    <li class="first-dropdown-li">
                                        <a style="color: {{ $header['bottom']['text_color'] }}" class="first-list mb-2 dm-sans text-base custom-bottom-border {{ !empty($menu->class) ? $menu->class : '' }} {{ str_replace('/#', '', $activeUrl) == url()->current() ? 'active-border-bottom' : ' ' }}"
                                            href="{{ $url }}">{{ ucwords($menu->label) }}</a>
                                        <ul class="dm-sans text-sm hidden md:block bg-white first-dropdown menu dropdown-enable box-shadow-dropdown">
                                            @foreach ($menu->child as $submenu)
                                                @php
                                                    $childUrl = $submenu->url(empty($submenu->params) ? 'page' : '');
                                                    $childUrl = str_contains($childUrl, url('/')) || str_contains($childUrl, 'http') ? $childUrl : url('/' . $childUrl);
                                                @endphp
                                                <li class="whitespace-normal border-b break-all">
                                                    <button class="outline-none focus:outline-none first-dropdown-menu w-full ltr:text-left rtl:text-right">
                                                        <div class="primary-bg-hover {{ str_replace('/#', '', $childUrl) == url()->current() ? 'primary-bg-color text-gray-12' : ' ' }}">
                                                            <a class="w-48" href="{{ $childUrl }}">
                                                                <div class="flex items-center justify-between w-full menuss-hover px-15p py-4">
                                                                    <span class="text-sm cursor-pointer w-36">
                                                                        {{ ucwords($submenu->label) }}
                                                                    </span>
                                                                    @if ($submenu->child->count())
                                                                        <span>
                                                                            <svg class="neg-transition-scale" xmlns="http://www.w3.org/2000/svg" width="5" height="9" viewBox="0 0 5 9" fill="none">
                                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.870679 3.60997e-07L-3.93887e-07 0.948839L3.25864 4.5L2.27018e-07 8.05116L0.87068 9L5 4.5L0.870679 3.60997e-07Z" fill="currentColor"/>
                                                                            </svg>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </button>
                                                    <ul class="dm-sans text-sm font-medium hidden md:block child-dropdown box-shadow-dropdown">
                                                        @foreach ($submenu->child as $subChildMenu)
                                                            @php
                                                                $subChildUrl = $subChildMenu->url(empty($subChildMenu->params) ? 'page' : '');
                                                                $subChildUrl = str_contains($subChildUrl, url('/')) || str_contains($subChildUrl, 'http') ? $subChildUrl : url('/' . $subChildUrl);
                                                            @endphp
                                                            <li class="whitespace-normal bg-white border-b break-all">
                                                                <button class="outline-none focus:outline-none first-dropdown-menu w-full ltr:text-left rtl:text-right">
                                                                    <div class="primary-bg-hover">
                                                                        <a class="w-48" href="{{ $subChildUrl }}">
                                                                            <div class="flex items-center justify-between w-full menuss-hover px-15p py-4">
                                                                                <span class="text-sm cursor-pointer w-36">
                                                                                    {{ $subChildMenu->label }}
                                                                                </span>
                                                                                <span>
                                                                                    <svg class="neg-transition-scale" xmlns="http://www.w3.org/2000/svg" width="5" height="9" viewBox="0 0 5 9" fill="none">
                                                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.870679 3.60997e-07L-3.93887e-07 0.948839L3.25864 4.5L2.27018e-07 8.05116L0.87068 9L5 4.5L0.870679 3.60997e-07Z" fill="currentColor"/>
                                                                                    </svg>
                                                                                </span>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                </button>
                                                                <ul class="dm-sans text-sm font-medium hidden md:block child-dropdown box-shadow-dropdown">
                                                                    <li class="whitespace-normal bg-white border-b break-all">
                                                                        <button class="outline-none focus:outline-none first-dropdown-menu w-full ltr:text-left rtl:text-right">
                                                                            <div class="primary-bg-hover">
                                                                                <a class="w-48"
                                                                                    href="javaScript:void(0);">
                                                                                    <div
                                                                                        class="flex items-center justify-between w-full menuss-hover px-15p py-4">
                                                                                        <span class="text-sm cursor-pointer w-36">
                                                                                            Food
                                                                                        </span>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                        </button>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    @if (isset($header['bottom']['show_download_app']) && $header['bottom']['show_download_app'] == 1)
                    
                      <div class="hidden md:block">
                        <div class="flex justify-end items-center">
                            <div class="flex {{ isset($header['bottom']) && count(array_filter($header['bottom'])) == 1 ? 'ml-6' : 'justify-end' }}">
                                @php
                                    $textColor = $header['bottom']['text_color'];
                                @endphp
                                <div>
                                    <div class="relative inline-block ltr:text-left rtl:text-right">
                                        
                                        <div style="background: {{ $header['bottom']['bg_color'] }}; color: {{ $header['bottom']['text_color'] }} ;" class="inline-flex justify-center items-center w-full bg-white text-13 font-medium text-gray-700 cursor-pointer test-click height-63px">
                                            {{-- <svg class="ltr:mr-2 rtl:ml-2" width="14" height="20" viewBox="0 0 14 20"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <mask id="path-1-outside-1_513_1062" maskUnits="userSpaceOnUse"
                                                    x="2" y="0" width="10" height="6"
                                                    fill="black">
                                                    <rect fill="white" x="2" width="10" height="6" />
                                                    <path d="M8.33333 3H5.66667C5.51167 3 5.43417 3 5.37059 2.98296C5.19804 2.93673 5.06327 2.80196 5.01704 2.62941C5 2.56583 5 2.48833 5 2.33333C5 2.25584 5 2.21709 5.00852 2.1853C5.03164 2.09902 5.09902 2.03164 5.1853 2.00852C5.21709 2 5.25584 2 5.33333 2H8.66667C8.74416 2 8.78291 2 8.8147 2.00852C8.90098 2.03164 8.96836 2.09902 8.99148 2.1853C9 2.21709 9 2.25584 9 2.33333C9 2.48833 9 2.56583 8.98296 2.62941C8.93673 2.80196 8.80196 2.93673 8.62941 2.98296C8.56583 3 8.48833 3 8.33333 3Z" />
                                                </mask>
                                                <path
                                                    d="M5.01704 2.62941L3.08519 3.14705L3.08519 3.14705L5.01704 2.62941ZM5.37059 2.98296L4.85295 4.91481H4.85295L5.37059 2.98296ZM8.98296 2.62941L7.05111 2.11177L7.05111 2.11177L8.98296 2.62941ZM8.62941 2.98296L9.14705 4.91481L9.14705 4.91481L8.62941 2.98296ZM8.99148 2.1853L10.9233 1.66766L10.9233 1.66766L8.99148 2.1853ZM8.8147 2.00852L8.29706 3.94037L8.29707 3.94037L8.8147 2.00852ZM5.00852 2.1853L6.94037 2.70293L5.00852 2.1853ZM5.1853 2.00852L5.70293 3.94037L5.1853 2.00852ZM5.66667 5H8.33333V1H5.66667V5ZM8.66667 0H5.33333V4H8.66667V0ZM3 2.33333C3 2.35957 2.98282 2.76502 3.08519 3.14705L6.94889 2.11177C6.99348 2.2782 6.99913 2.40436 7.00005 2.42453C7.00059 2.43631 7.00036 2.43764 7.00019 2.41833C7.00002 2.39894 7 2.37464 7 2.33333H3ZM5.66667 1C5.62536 1 5.60106 0.999984 5.58167 0.999812C5.56236 0.999641 5.56369 0.99941 5.57547 0.999947C5.59564 1.00087 5.7218 1.00652 5.88823 1.05111L4.85295 4.91481C5.23498 5.01718 5.64043 5 5.66667 5V1ZM3.08519 3.14705C3.31635 4.00978 3.99022 4.68365 4.85295 4.91481L5.88823 1.05111C6.40587 1.18981 6.81019 1.59413 6.94889 2.11177L3.08519 3.14705ZM7 2.33333C7 2.37464 6.99998 2.39894 6.99981 2.41833C6.99964 2.43764 6.99941 2.43631 6.99995 2.42453C7.00087 2.40436 7.00652 2.2782 7.05111 2.11177L10.9148 3.14705C11.0172 2.76502 11 2.35957 11 2.33333H7ZM8.33333 5C8.35957 5 8.76502 5.01718 9.14705 4.91481L8.11177 1.05111C8.2782 1.00652 8.40436 1.00087 8.42453 0.999947C8.43631 0.99941 8.43764 0.999641 8.41833 0.999812C8.39894 0.999984 8.37464 1 8.33333 1V5ZM7.05111 2.11177C7.18981 1.59413 7.59413 1.18981 8.11177 1.05111L9.14705 4.91481C10.0098 4.68365 10.6836 4.00978 10.9148 3.14705L7.05111 2.11177ZM11 2.33333C11 2.31271 11.0005 2.23053 10.9969 2.15106C10.9927 2.06084 10.9807 1.88178 10.9233 1.66766L7.05963 2.70293C7.01077 2.5206 7.003 2.37681 7.00101 2.33329C6.99994 2.30984 6.99991 2.29541 6.99995 2.29969C6.99998 2.30405 7 2.3114 7 2.33333H11ZM8.66667 4C8.6886 4 8.69595 4.00002 8.70031 4.00005C8.70459 4.00009 8.69016 4.00006 8.66671 3.99899C8.62318 3.997 8.47939 3.98923 8.29706 3.94037L9.33235 0.0766677C9.11822 0.0192933 8.93916 0.00725603 8.84894 0.0031414C8.76947 -0.000483036 8.68729 0 8.66667 0V4ZM10.9233 1.66766C10.7153 0.8912 10.1088 0.284717 9.33234 0.0766666L8.29707 3.94037C7.69316 3.77855 7.22145 3.30684 7.05963 2.70293L10.9233 1.66766ZM7 2.33333C7 2.3114 7.00002 2.30405 7.00005 2.29969C7.00009 2.29541 7.00006 2.30984 6.99899 2.33329C6.997 2.37682 6.98923 2.5206 6.94037 2.70293L3.07667 1.66766C3.01929 1.88178 3.00726 2.06084 3.00314 2.15106C2.99952 2.23053 3 2.31271 3 2.33333H7ZM5.33333 0C5.31271 0 5.23053 -0.000483036 5.15106 0.0031414C5.06084 0.00725603 4.88178 0.0192934 4.66766 0.076667L5.70293 3.94037C5.5206 3.98923 5.37682 3.997 5.33329 3.99899C5.30984 4.00006 5.29541 4.00009 5.29969 4.00005C5.30405 4.00002 5.3114 4 5.33333 4V0ZM6.94037 2.70293C6.77855 3.30684 6.30684 3.77855 5.70293 3.94037L4.66766 0.076667C3.8912 0.284718 3.28472 0.8912 3.07667 1.66766L6.94037 2.70293Z"
                                                    fill="{{ $textColor }}" mask="url(#path-1-outside-1_513_1062)" />
                                                <rect x="1" y="1" width="12" height="18"
                                                    rx="2" stroke="{{ $textColor }}" stroke-width="2" />
                                                <circle cx="7" cy="16" r="1" fill="{{ $textColor }}" />
                                            </svg> --}}
                                            <svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" version="1.1"  x="0" y="0" viewBox="0 0 511.999 511.999" style="enable-background:new 0 0 512 512" xml:space="preserve" class="svg_img header_svg svg_loc" src="https://allofus.hssolsdemos.com/assets/img/icons/location.svg" alt="icon"><g>
                                                <g xmlns="http://www.w3.org/2000/svg">
                                                    <g>
                                                        <path d="M409.124,63.426C368.224,22.525,313.843,0,256.001,0S143.777,22.525,102.877,63.426    c-40.901,40.902-63.426,95.282-63.426,153.123c0,117.012,110.638,214.337,170.077,266.623c8.26,7.266,15.393,13.541,21.076,18.849    c7.12,6.651,16.259,9.977,25.396,9.977c9.139,0,18.276-3.326,25.397-9.977c5.683-5.309,12.816-11.583,21.076-18.849    c59.439-52.287,170.077-149.611,170.077-266.623C472.549,158.708,450.025,104.328,409.124,63.426z M282.663,460.654    c-8.441,7.425-15.73,13.838-21.74,19.451c-2.761,2.577-7.085,2.578-9.847,0c-6.009-5.615-13.299-12.027-21.74-19.452    c-55.88-49.155-159.895-140.654-159.895-244.103c0-102.868,83.689-186.557,186.558-186.557    c102.868,0,186.557,83.689,186.557,186.557C442.557,319.999,338.543,411.498,282.663,460.654z" fill="#000000" data-original="#000000"></path>
                                                    </g>
                                                </g>
                                                <g xmlns="http://www.w3.org/2000/svg">
                                                    <g>
                                                        <path d="M256.001,112.938c-52.621,0-95.431,42.809-95.431,95.43s42.81,95.43,95.431,95.43s95.43-42.809,95.43-95.43    S308.622,112.938,256.001,112.938z M256.001,273.805c-36.083,0-65.439-29.356-65.439-65.438s29.356-65.438,65.439-65.438    s65.438,29.356,65.438,65.438S292.084,273.805,256.001,273.805z" fill="#000000" data-original="#000000"></path>
                                                    </g>
                                                </g>
                                                <g xmlns="http://www.w3.org/2000/svg">
                                                </g>
                                                <g xmlns="http://www.w3.org/2000/svg">
                                                </g>
                                                <g xmlns="http://www.w3.org/2000/svg">
                                                </g>
                                                <g xmlns="http://www.w3.org/2000/svg">
                                                </g>
                                                <g xmlns="http://www.w3.org/2000/svg">
                                                </g>
                                                <g xmlns="http://www.w3.org/2000/svg">
                                                </g>
                                                <g xmlns="http://www.w3.org/2000/svg">
                                                </g>
                                                <g xmlns="http://www.w3.org/2000/svg">
                                                </g>
                                                <g xmlns="http://www.w3.org/2000/svg">
                                                </g>
                                                <g xmlns="http://www.w3.org/2000/svg">
                                                </g>
                                                <g xmlns="http://www.w3.org/2000/svg">
                                                </g>
                                                <g xmlns="http://www.w3.org/2000/svg">
                                                </g>
                                                <g xmlns="http://www.w3.org/2000/svg">
                                                </g>
                                                <g xmlns="http://www.w3.org/2000/svg">
                                                </g>
                                                <g xmlns="http://www.w3.org/2000/svg">
                                                </g>
                                                </g></svg>
                                            <p class="text-sm 2xl:text-base dm-sans">
                                                {{ __('User Current Location') }}</p>
                                            <svg class="ltr:ml-2.5 rtl:mr-2.5" width="9" height="5" viewBox="0 0 9 5"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M9 0.870679L8.05116 -4.35362e-07L4.5 3.25864L0.948838 -1.2491e-07L-1.80498e-07 0.870679L4.5 5L9 0.870679Z"
                                                    fill="{{ $textColor }}" />
                                            </svg>
                                        </div>
                                        @if ($header['bottom']['show_google_play'] || $header['bottom']['show_app_store'])
                                            <div
                                                class="hidden origin-top-right absolute w-48 border rounded-t-none rounded bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 test-drop ltr:right-0 rtl:left-0">
                                                <div>
                                                    
                                                    <ul class="loc-grid">
                                                        <li class="loc-list current">
                                                         <span>current Location</span>
                                                        </li>
                                                        <li class="loc-list"><span class="ms-detail">rajkot, in</span></li>
                                                        <li class="loc-list">
                                                            <span class="ms-detail">Mountain View, us</span></li>
                                                        <li class="loc-list"><span class="ms-detail">Birmingham, UK</span></li>
                                                        <li class="loc-list"><span class="ms-detail">Jakarta, id</span></li>
                                                        <li class="loc-list"> <span class="ms-detail">lima, pe</span></li>
                                                    </ul>
                                                    {{-- @if ($header['bottom']['show_google_play'])
                                                    <a href="{{ isset($header['bottom']['google_play_link']) ? $header['bottom']['google_play_link'] : '#' }}"
                                                        class="flex p-15p text-base font-medium text-gray-10 roboto-medium hover:bg-gray-100 hover:text-gray-900"
                                                        role="menuitem">
                                                        @if ($downloadGooglePlay->objectFile)
                                                            <img src="{{ $downloadGooglePlay->fileUrl() }}" alt="{{ __('Image') }}">
                                                        @else
                                                            {{ __('Google Play') }}
                                                        @endif
                                                    </a>
                                                    @endif
                                                    @if ($header['bottom']['show_app_store'])
                                                        <a href="{{ isset($header['bottom']['app_store_link']) ? $header['bottom']['app_store_link'] : '#' }}"
                                                            class="flex p-15p text-base font-medium text-gray-10 roboto-medium hover:bg-gray-100 hover:text-gray-900"
                                                            role="menuitem">
                                                            @if ($downloadAppStore->objectFile)
                                                                <img src="{{ $downloadAppStore->fileUrl() }}" alt="{{ __('Image') }}">
                                                                @else{{ __('IOS') }}
                                                            @endif
                                                        </a>
                                                    @endif --}}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
                    @endif
                </div>
            </div>
        </div>
        </div>
    </header>
    @if ($fixedMenu && isset($header['bottom']['show_category']) && $header['bottom']['show_category'] == 1)
        <div class="lg:mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92">
            @if (isset($slides) && $slides->count())
                <div class="md:w-3/4 w-full -mt-2 ltr:ml-auto rtl:mr-auto">
                    <div class="slideshow-container md:mt-6 ltr:md:mr-5 ltr:mr-0 ltr:ml-0 ltr:lg:mr-0 rtl:md:ml-5 rtl:ml-0 rtl:mr-0 rtl:lg:ml-0">
                        <div class="swiper mySwiper custom-swiper">
                            <div class="swiper-wrapper">
                                @php
                                   $buttonDirection = ['left' => 'justify-start', 'right' => 'justify-end', 'center' => 'justify-center'];
                                @endphp
                                @foreach ($slides as $slide)
                                <div class="swiper-slide">
                                    <div class="relative z-0 flex align-items-center">
                                        <div class="costume-title w-full px-5 sm:px-11">
                                            <div class="text-{{ $slide->title_direction }}">
                                                <p class="sliders-animation inline-block anim text-x-title dm-regular animated small-title" data-animation="{{ $slide->title_animation }}"
                                                    style="animation-delay: {{ $slide->title_delay }}s; color: {{ $slide->title_font_color }}; font-size: {{ $slide->title_font_size . 'px' }}">
                                                    {!! $slide->title_text !!}
                                                </p>
                                            </div>
                                           <div class="text-{{ $slide->sub_title_direction }}">
                                                <p class="sliders-animation inline-block anim text-y-title dm-bold animated bold-title" data-animation="{{ $slide->sub_title_animation }}"
                                                    style="animation-delay: {{ $slide->sub_title_delay }}s; color: {{ $slide->sub_title_font_color }}; font-size: {{ $slide->sub_title_font_size . 'px' }}">
                                                    {!! $slide->sub_title_text !!}
                                                </p>
                                           </div>
                                            <div class="text-{{ $slide->description_title_direction }}">
                                                <p class="sliders-animation inline-block anim text-z-title dm-regular mt-3 animated bottom-title" data-animation="{{ $slide->description_title_animation }}"
                                                    style="animation-delay: {{ $slide->description_title_delay }}s; color: {{ $slide->description_title_font_color }}; font-size: {{ $slide->description_title_font_size . 'px' }}">
                                                    {!! $slide->description_title_text !!}
                                                </p>
                                            </div>
                                            @if (!empty($slide->button_title))
                                                <div class="flex {{ $buttonDirection[strtolower($slide->button_position)] }}">
                                                    <a style="animation-delay: {{ $slide->button_delay }}s;" href="{{ $slide->button_link }}"
                                                        {{ $slide->is_open_in_new_window == 'Yes' ? 'target=_blank' : '' }}
                                                        class="sliders-animation animated anim"
                                                        data-animation="{{ $slide->button_animation }}">
                                                        <p class="process-goto shop-btn cursor-pointer relative flex justify-center text-gray-12 rounded-sm md:text-base text-xss items-center md:py-2 py-1.5 w-max md:px-8 px-5 dm-sans mt-2 border md:border-none border-gray-12"
                                                            style="color: {{ $slide->button_font_color }}; background: {{ $slide->button_bg_color . 'dd' }}; --hover-bg-color:{{ $slide->button_bg_color }}; --hover-color:{{ $slide->button_font_color }}">
                                                            {!! $slide->button_title !!}
                                                            <svg class="relative md:w-2.5 md:h-2 w-2 h-6p ltr:ml-5p rtl:mr-2.5 neg-transition-scale" width="10" height="7" viewBox="0 0 10 7"
                                                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M6.7344 0L5.75327 1.05155L7.34399 2.75644H0.69376C0.310607 2.75644 0 3.08934 0 3.5C0 3.91066 0.310607 4.24356 0.69376 4.24356H7.34399L5.75327 5.94845L6.7344 7L10 3.5L6.7344 0Z"
                                                                fill="currentColor"></path>
                                                        </svg>
                                                        </p>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                        <img class="hero-slide-img md:rounded-lg object-cover w-full" src="{{ $slide->fileUrl() }}">
                                    </div>
                                </div>
                                @endforeach

                                <a class="md:flex hidden">
                                    <span class="prev swiper-button-prev items-center justify-center">
                                        <svg class="neg-transition-scale" width="9" height="11" viewBox="0 0 9 13" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.32668 0.337159L8.66402 1.65614L3.65882 6.59262L8.66402 11.5291L7.32667 12.8481L0.98413 6.59262L7.32668 0.337159Z" fill="currentColor"></path>
                                        </svg>
                                    </span>
                                </a>
                                <a class="md:flex hidden">
                                  <span class="next swiper-button-next items-center justify-center">
                                        <svg class="neg-transition-scale" width="9" height="11" viewBox="0 0 9 13" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2.3231 0.337159L0.985761 1.65614L5.99096 6.59262L0.985762 11.5291L2.32311 12.8481L8.66565 6.59262L2.3231 0.337159Z" fill="currentColor"></path>
                                        </svg>
                                  </span>
                                </a>
                                @foreach ($slides as $slide)
                                    <div class="swiper-pagination"></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif
</section>
