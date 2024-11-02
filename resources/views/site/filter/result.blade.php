@foreach ($response as $res)
<div class="flex search-result overflow-hidden">
    <button class="bg-gray-12 filt mt-18p md:hidden text-white x:text-xs text-sm rounded x:px-2 px-4 x:py-2.5 py-2 absolute">
        <span class="inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" viewBox="0 0 14 12" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M2.16753 6.5C1.76866 6.5 1.44531 6.17665 1.44531 5.77778L1.44531 0.722222C1.44531 0.32335 1.76866 -2.82681e-08 2.16753 -6.31387e-08C2.56641 -9.80092e-08 2.88976 0.32335 2.88976 0.722222L2.88976 5.77778C2.88976 6.17665 2.56641 6.5 2.16753 6.5Z" fill="white"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.49957 3.61108C6.10069 3.61108 5.77734 3.28773 5.77734 2.88886L5.77734 0.722195C5.77734 0.323323 6.10069 -2.72457e-05 6.49957 -2.7327e-05C6.89844 -2.74084e-05 7.22179 0.323322 7.22179 0.722195L7.22179 2.88886C7.22179 3.28773 6.89844 3.61108 6.49957 3.61108Z" fill="white"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M2.16753 11.5557C1.76866 11.5557 1.44531 11.2323 1.44531 10.8334L1.44531 8.66678C1.44531 8.2679 1.76866 7.94455 2.16753 7.94455C2.56641 7.94455 2.88976 8.2679 2.88976 8.66677L2.88976 10.8334C2.88976 11.2323 2.56641 11.5557 2.16753 11.5557Z" fill="white"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.8336 11.5557C10.4347 11.5557 10.1113 11.2323 10.1113 10.8334L10.1113 9.389C10.1113 8.99013 10.4347 8.66678 10.8335 8.66678C11.2324 8.66677 11.5558 8.99012 11.5558 9.389L11.5558 10.8334C11.5558 11.2323 11.2324 11.5557 10.8336 11.5557Z" fill="white"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.49957 11.5557C6.10069 11.5557 5.77734 11.2323 5.77734 10.8334L5.77734 5.77789C5.77734 5.37901 6.10069 5.05566 6.49956 5.05566C6.89844 5.05566 7.22179 5.37901 7.22179 5.77789L7.22179 10.8334C7.22179 11.2323 6.89844 11.5557 6.49957 11.5557Z" fill="white"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.33203 2.88897C4.33203 2.4901 4.65538 2.16675 5.05425 2.16675L7.94314 2.16675C8.34201 2.16675 8.66536 2.4901 8.66536 2.88897C8.66536 3.28784 8.34201 3.61119 7.94314 3.61119L5.05425 3.61119C4.65538 3.61119 4.33203 3.28784 4.33203 2.88897Z" fill="white"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8.66656C0 8.26769 0.32335 7.94434 0.722222 7.94434L3.61111 7.94434C4.00998 7.94434 4.33333 8.26769 4.33333 8.66656C4.33333 9.06543 4.00998 9.38878 3.61111 9.38878H0.722222C0.32335 9.38878 0 9.06543 0 8.66656Z" fill="white"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.66797 9.38897C8.66797 8.9901 8.99132 8.66675 9.39019 8.66675H12.2791C12.678 8.66675 13.0013 8.9901 13.0013 9.38897C13.0013 9.78784 12.678 10.1112 12.2791 10.1112H9.39019C8.99132 10.1112 8.66797 9.78784 8.66797 9.38897Z" fill="white"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.8336 7.22217C10.4347 7.22217 10.1113 6.89882 10.1113 6.49995L10.1113 0.722168C10.1113 0.323296 10.4347 -5.43842e-05 10.8335 -5.44147e-05C11.2324 -5.44452e-05 11.5558 0.323295 11.5558 0.722168L11.5558 6.49995C11.5558 6.89882 11.2324 7.22217 10.8336 7.22217Z" fill="white"/>
                </svg>
        </span>
        {{ __('Filter') }}
    </button>
    <div class="md:w-1/4 w-64 md:mt-5 middle-sidebar-scroll md:relative z-20 md:z-0 md:h-auto h-full fixed top-0 md:top-auto md:right-auto right-0 overflow-y-scroll md:overflow-auto bg-white filter-mobile hidden md:block" id="filter_box_result">
        <div class="border rounded-md px-5 pt-30p pb-2.5">
            <div class="flex justify-between">
                <p class="uppercase roboto-medium text-lg text-gray-12">{{ __('Filters') }}</p>
                <div class="flex items-center reset_all">
                    <p class="roboto-medium text-xs text-gray-10 font-medium cursor-pointer ltr:mr-1.5 rtl:ml-1.5">{{ __('Clear All') }}</p>
                    <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.292893 0.292893C0.683417 -0.0976311 1.31658 -0.0976311 1.70711 0.292893L7.70711 6.29289C8.09763 6.68342 8.09763 7.31658 7.70711 7.70711C7.31658 8.09763 6.68342 8.09763 6.29289 7.70711L0.292893 1.70711C-0.0976311 1.31658 -0.0976311 0.683417 0.292893 0.292893Z" fill="#898989"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.70711 0.292893C7.31658 -0.0976311 6.68342 -0.0976311 6.29289 0.292893L0.292893 6.29289C-0.0976315 6.68342 -0.0976315 7.31658 0.292893 7.70711C0.683417 8.09763 1.31658 8.09763 1.70711 7.70711L7.70711 1.70711C8.09763 1.31658 8.09763 0.683417 7.70711 0.292893Z" fill="#898989"/>
                    </svg>
                </div>
            </div>
            {{--category--}}
            <div class="mt-2.5">
                <div class="border-one pb-3">
                    <h3 class="text-base roboto-medium font-medium text-gray-12 leading-5">
                        {{ __('Related Categories') }}
                    </h3>
                </div>
                <div class="relative overflow-hidden show-details {{ count($res->records->filterable->category_slug) > 6 ? 'h-300p' : '' }}">
                    <ul class="mt-13p cate-hover {{ count($res->records->filterable->category_slug) > 6 ? 'pb-10' : '' }}">
                        @foreach ($res->records->filterable->category_slug as $catKey => $category)
                            @if(isset($res->records->filterable->categories[$catKey]))
                                <li class="mt-5p category-select">
                                    <a href="javascript:void(0)" class="selected roboto-medium font-medium text-15 text-gray-10 selected-category {{ in_array($category, $res->records->filter_applied->categories) ? 'text-color-black' : '' }}" data-category="{{ $category }}">
                                        {{ $res->records->filterable->categories[$catKey] }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                    <div class="absolute w-full cursor-pointer justify-between expand-more bg-white bottom-0 add {{ count($res->records->filterable->category_slug) > 6 ? '' : 'none' }}">
                        <div class="w-full relative">
                            <a>
                                <span class="text-gray-3 roboto-medium font-medium text-15"> {{ __('See All') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            {{--price range--}}
            <div class="mt-0.5">
                {{--price range--}}
                <div class="mt-0.5">
                    <div class="border-one pb-3">
                        <h3 class="text-base roboto-medium font-medium text-gray-12 leading-5">
                            {{ __('Price Range') }}
                        </h3>
                    </div>
                </div>
                {{--min max--}}
                <form class="mt-18p">
                    <div class="xl:flex flex-wrap mb-2 xl:gap-4">
                        <div class="flex items-center">
                            <label class="block tracking-wide text-gray-10 text-sm roboto-medium font-medium ltr:mr-7p rtl:ml-7p" for="Min-range">
                                {{ __('Min') }}.
                            </label>
                            <input class="appearance-none block w-72p h-30p px-2 roboto-medium text-gray-10 text-13 font-medium border border-solid border-gray-200 rounded-sm focus:outline-none focus:bg-white focus:border-gray-500 min_desktop positive-int-number" id="price_minimum" type="text" value="{{ isset($res->records->filter_applied->price_range[0]) ? intval($res->records->filter_applied->price_range[0]) : intval($res->records->filterable->price_range[0]) }}">
                        </div>
                        <div class="flex items-center mt-2 xl:mt-0">
                            <label class="block tracking-wide text-gray-10 text-sm font-medium  roboto-medium ltr:mr-1 xl:mr-7p rtl:ml-1 xl:ml-7p" for="Max-range">
                                {{ __('Max') }}.
                            </label>
                            <input class="appearance-none block w-72p h-30p px-2 roboto-medium text-gray-10 text-13 font-medium border border-solid border-gray-200 rounded-sm focus:outline-none focus:bg-white focus:border-gray-500 max_desktop positive-int-number" id="price_maximum" type="text" value="{{ isset($res->records->filter_applied->price_range[1]) ? intval($res->records->filter_applied->price_range[1]) : intval($res->records->filterable->price_range[1]) }}">
                        </div>
                    </div>
                    <button class="px-2 border rounded mt-2 dm-bold text-sm text-gray-12 w-full h-10 hover:border-gray-12 duration-200 button-update">
                        {{ __('Update') }}
                    </button>
                </form>

                @includeIf('b2b::site.b2b-check-filter')

                {{--color--}}
                @php $count = 0; @endphp
                @foreach ($res->records->filterable->attributes as $key => $attribute)
                    @php
                        $key = str_replace('&', 'and', $key);
                        $key = str_replace('/', 'or', $key);
                        $key = str_replace(',', ' ', $key);
                        $lowerKey = $key; $key = ucfirst($key);
                        @endphp
                    @if($key == "Color")
                        <div class="mt-1.5 relative overflow-hidden show-details {{ count((array)$attribute) > 6 ? 'h-322p' : '' }}">
                            <div class="border-one pb-3">
                                <h3 class="text-base roboto-medium font-medium text-gray-12 leading-5">
                                    {{ $key }}
                                </h3>
                            </div>
                            <div class="mt-18p {{ count((array)$attribute) > 6 ? 'pb-10' : '' }}">
                                @foreach ($attribute as $attKey => $val)
                                    @php
                                        $colorClass = '';
                                         $colors = getColor();
                                         $colorsKey = array_keys(getColor());
                                         if (in_array(strtolower($val), $colorsKey)) {
                                             $colorClass = $colors[strtolower($val)];
                                        } else {
                                            $colorClass = 'bg-custom-white black-check';
                                        }
                                    @endphp
                                    <div class="flex items-center c-check mb-2.5 relative">
                                        <div class="rounds relative ltr:-ml-4 rtl:-mr-4">
                                            <input type="checkbox" id="result-checkbox-{{ $count }}" name="attributes[]" data-inputtype="checkbox" class="option-checkbox neg-transition-scale" data-option="{{ $key }}" value="{{ $key.":".$attKey }}" {{ isset($res->records->filter_applied->attributes->{$lowerKey}) && in_array($attKey, $res->records->filter_applied->attributes->{$lowerKey}) ? 'checked' : '' }}>
                                            <label class="{{ $colorClass }}" for="result-checkbox-{{ $count }}"></label>
                                        </div>
                                        <label for="checkbox-{{ $count++ }}" class="flex items-center roboto-medium text-15 text-gray-10 cursor-pointer ltr:ml-8 rtl:mr-8">
                                            {{ $val }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="absolute w-full cursor-pointer justify-between expand-more bg-white bottom-0 add {{ count((array)$attribute) > 6 ? '' : 'none' }}">
                                <div class="w-full relative">
                                    <a>
                                        <span class="text-gray-3 roboto-medium font-medium text-15"> {{ __('See All') }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="mt-1.5 relative overflow-hidden show-details {{ count((array)$attribute) > 6 ? 'h-312p' : '' }}">
                            <div class="border-one pb-3">
                                <h3 class="text-base roboto-medium font-medium text-gray-12 leading-5">
                                    {{ $key }}
                                </h3>
                            </div>
                            <div class="mt-4 {{ count((array)$attribute) > 6 ? 'pb-10' : '' }}">
                                @if(is_object($attribute))
                                    @foreach ($attribute as $attKey => $val)
                                        <div class="flex items-center c-check mb-5p">
                                            <input id="result-checkbox-{{ $count }}" type="checkbox" name="attributes[]" data-option="{{ $key }}" value="{{ $key.":".$attKey }}" class="option-checkbox neg-transition-scale" {{ isset($res->records->filter_applied->attributes->{$lowerKey}) && in_array($attKey, $res->records->filter_applied->attributes->{$lowerKey}) ? 'checked' : '' }}>
                                            <label for="result-checkbox-{{ $count }}" class="flex items-center roboto-medium text-15 text-gray-10 cursor-pointer ltr:ml-3 rtl:mr-3">
                                                {{ $val }}
                                            </label>
                                        </div>
                                        @php $count++ @endphp
                                    @endforeach
                                @else
                                        @foreach ($attribute as $val)
                                            @php $val = str_replace('&', '', $val); @endphp
                                            <div class="flex items-center c-check mb-5p">
                                                <input id="result-checkbox-{{ $count }}" type="checkbox" name="attributes[]" data-option="{{ $key }}" value="{{ $key.":".$val }}" class="option-checkbox neg-transition-scale" {{ isset($res->records->filter_applied->attributes->{$lowerKey}) && in_array($val, $res->records->filter_applied->attributes->{$lowerKey}) ? 'checked' : '' }}>
                                                <label for="result-checkbox-{{ $count }}" class="flex items-center roboto-medium text-15 text-gray-10 cursor-pointer ltr:ml-3 rtl:mr-3">
                                                    {{ $val }}
                                                </label>
                                            </div>
                                            @php $count++ @endphp
                                        @endforeach
                                @endif
                            </div>
                            <div class="absolute w-full cursor-pointer justify-between expand-more flex bg-white bottom-0 add {{ count((array)$attribute) > 6 ? '' : 'none' }}">
                                <div class="w-full relative">
                                    <a>
                                        <span class="text-gray-3 roboto-medium font-medium text-15"> {{ __('See All') }}</span>
                                    </a>
                                </div>
                            </div>

                        </div>
                    @endif
                @endforeach
                {{--Brand & Option--}}
                @if(count($res->records->filterable->brands) > 0)
                <div class="relative overflow-hidden show-details  {{ count($res->records->filterable->brands) > 6 ? 'h-312p' : '' }}">
                    <div class="border-one pb-3">
                        <h3 class="text-base roboto-medium font-medium text-gray-12 leading-5">
                            {{ __('Brand') }}
                        </h3>
                    </div>
                    <div class="mt-15p {{ count($res->records->filterable->brands) > 6 ? 'pb-10' : '' }}">
                        @foreach ($res->records->filterable->brands as $key => $brand)
                            <div class="flex items-center c-check mb-5p relative">
                                <input id="brand-checkbox-{{ $key }}" class="item-brand" type="checkbox" name="brands[]" value="{{ $brand }}" {{ in_array($brand, $res->records->filter_applied->brands) ? 'checked' : '' }}>
                                <label for="brand-checkbox-{{ $key }}" class="flex items-center roboto-medium text-15 text-gray-10 cursor-pointer ltr:ml-3 rtl:mr-3">
                                    {{ $brand }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="absolute w-full cursor-pointer justify-between expand-more flex bg-white bottom-0 add {{ count($res->records->filterable->brands) > 6 ? '' : 'none' }}">
                        <div class="w-full relative">
                            <a>
                                <span class="text-gray-3 roboto-medium font-medium text-15"> {{ __('See All') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
                @endif
                {{--ratings--}}
                <div>
                    <div class="border-one pb-3">
                        <h3 class="text-base roboto-medium font-medium text-gray-12 leading-5">
                            {{ __('Ratings') }}
                        </h3>
                    </div>

                    <div class="radio-stars mt-0.5">
                        @for($i = 5; $i >= 1 ; $i--)
                            <input class="sr-only" id="radio-{{ $i }}" name="radio-star" class="item-ratings" type="radio" value="{{ $i }}" {{ isset($requestValue['data']['rating']) && $requestValue['data']['rating'] == $i ? 'checked' : '' }}/>
                            <label class="radio-star item-ratings {{ isset($res->records->filter_applied->rating[0]) && $res->records->filter_applied->rating[0] >= $i ? 'star-color' : '' }}" for="radio-{{ $i }}" data-rating="{{ $i }}" data-id = "radio-{{ $i }}"></label>
                        @endfor
                        <span class="radio-star-total roboto-medium" id="rating_star">{{ isset($res->records->filter_applied->rating[0]) ? $res->records->filter_applied->rating[0] : '' }} {{ __('Stars') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full md:w-76% mt-2.5 pb-14" id="res-loader-html">
        <div class="flex justify-end md:justify-between" id="search_top_nav">
            <span class="dm-sans text-lg hidden md:flex justify-items-center my-3 leading-6 text-gray-12 font-medium md:w-1/3 xl:w-1/2 ltr:md:pl-30p rtl:md:pr-30p" id="found_total_item">
                @if(isset($res->records->filter_applied->keyword[0]) && $res->records->filter_applied->keyword[0] != "")
                    {{ $res->records->pagination->total }} {{ __('products found for') }} "{{ $res->records->filter_applied->keyword[0] }}"
                @elseif(isset($res->records->filter_applied->categories[0]) && $res->records->filter_applied->categories[0] != "")
                    {{ $res->records->pagination->total }} {{ __('products found in') }} "{{ $res->records->filter_applied->categories[0] }}"
                @elseif(isset($res->records->filter_applied->brands[0]) && $res->records->filter_applied->brands[0] != "")
                    {{ $res->records->pagination->total }} {{ __('products found in') }} "{{ $res->records->filter_applied->brands[0] }}"
                @elseif(isset($res->records->pagination->total))
                    {{ $res->records->pagination->total }} {{ __('products found') }}
                @endif
                @php
                $sortBy = __('Price Low to High');
                if (isset($res->records->filter_applied->sort_by[0])) {
                    if ($res->records->filter_applied->sort_by[0] == 'Price High to Low') {
                        $sortBy = __('Price High to Low');
                    } elseif ($res->records->filter_applied->sort_by[0] == 'Avg. Ratting') {
                        $sortBy = __('Avg. Ratting');
                    }
                }
                @endphp
            </span>
                <nav class="whitespace-nowrap ltr:text-right rtl:text-left">
                    <button class="rtl-direction-space-left mt-2">
                        <span class="text-sm roboto-medium text-gray-12 hidden md:inline-block ltr:mr-4 rtl:ml-4">{{ __('Sort By:') }}</span>
                        <div class="filter-dropdown dropdown rounded shadow-none border relative">
                            <div class="select flex justify-between items-center gap-1.5">
                                <p class="msg roboto-medium"> {{ $sortBy }} </p>
                                <svg width="7" height="4" viewBox="0 0 7 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.93933e-08 0.696543L0.737986 8.80039e-09L3.5 2.60691L6.26201 7.46738e-08L7 0.696543L3.5 4L3.93933e-08 0.696543Z" fill="#898989"/>
                                </svg>
                            </div>
                            <input type="hidden" name="sort_by" value="Price Low to High" id="sort_by">
                            <ul class="dropdown-menu">
                                <li id="Price Low to High" class="sort_by {{ isset($res->records->filter_applied->sort_by[0]) && $res->records->filter_applied->sort_by[0] == 'Price Low to High' ? 'primary-bg-color text-gray-12' : '' }}">
                                    <a class="roboto-medium text-xs">{{ __('Price Low to High') }}</a>
                                </li>
                                <li id="Price High to Low" class="sort_by {{ isset($res->records->filter_applied->sort_by[0]) && $res->records->filter_applied->sort_by[0] == 'Price High to Low' ? 'primary-bg-color text-gray-12' : '' }}">
                                    <a class="roboto-medium text-xs">{{ __('Price High to Low') }}</a>
                                </li>
                                <li id="Avg. Ratting" class="sort_by {{ isset($res->records->filter_applied->sort_by[0]) && $res->records->filter_applied->sort_by[0] == 'Avg. Ratting' ? 'primary-bg-color text-gray-12' : '' }}">
                                    <a class="roboto-medium text-xs">{{ __('Avg. Ratting') }}</a>
                                </li>
                            </ul>
                        </div>
                    </button>

                    <button class="rtl-direction-space-left mt-2 ml-0.5 mb-3 hidden md:inline-block">
                        <span class="ml-1p mr-3 text-sm roboto-medium text-gray-12">{{ __('Showing') }}:</span>
                        <div class="dropdown rounded shadow-none border relative z-20 showing-width">
                            <div class="select flex justify-between items-center gap-1.5">
                                @php
                                $rowPerPage = isset($res->records->filter_applied->showing[0]) && is_numeric($res->records->filter_applied->showing[0]) ? $res->records->filter_applied->showing[0] : 12;
                               @endphp
                                <p class="msg roboto-medium"> {{ $rowPerPage }} </p>
                                <svg width="7" height="4" viewBox="0 0 7 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.93933e-08 0.696543L0.737986 8.80039e-09L3.5 2.60691L6.26201 7.46738e-08L7 0.696543L3.5 4L3.93933e-08 0.696543Z" fill="#898989"/>
                                </svg>

                            </div>
                            <input type="hidden" name="showing" value="{{ $rowPerPage }}" id="showing">
                            <ul class="dropdown-menu show-list">
                                <li id="12" class="Showing {{ $rowPerPage == 12 ? 'text-center primary-bg-color text-gray-12' : '' }}" data-val="12">
                                    <a class="roboto-medium text-xs">12</a>
                                </li>
                                <li id="24" class="Showing {{ $rowPerPage == 24 ? 'text-center primary-bg-color text-gray-12' : '' }}" data-val="24">
                                    <a class="roboto-medium text-xs">24</a>
                                </li>
                                <li id="48" class="Showing {{ $rowPerPage == 48 ? 'text-center primary-bg-color text-gray-12' : '' }}" data-val="48">
                                    <a class="roboto-medium text-xs">48</a>
                                </li>
                            </ul>
                        </div>
                    </button>

                    <button class="ml-1.5 hidden">
                        <div class="mb-3 flex items-center c-select relative">
                            <span class="mr-2.5 text-sm roboto-medium text-gray-12">{{ __('Showing') }}:</span>
                            <select class="mi form-select w-11 appearance-none block px-3 py-1.5 text-sm roboto-regular font-normal text-gray-10 bg-white bg-clip-padding bg-no-repeat
                                border border-solid border-gray-200
                                rounded-sm
                                transition-all
                                ease
                                m-0" aria-label="Default select example">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                            <div class="absolute right-2">
                                <svg width="7" height="4" viewBox="0 0 7 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.93933e-08 0.696543L0.737986 8.80039e-09L3.5 2.60691L6.26201 7.46738e-08L7 0.696543L3.5 4L3.93933e-08 0.696543Z" fill="#898989"/>
                                </svg>
                            </div>

                        </div>
                    </button>

                    <button type="button" class="mx-1 sm:inline-block text-gray-200 md:ml-3 duration-700" x-on:click="layout = 'grid'"
                            x-bind:class="{'text-[#898989!important]': layout === 'grid'}">
                        <svg class="-mb-5p -ml-3p" width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0H5.42857V5.42857H0V0Z" fill="currentColor"/>
                            <path d="M6.78564 0H12.2142V5.42857H6.78564V0Z" fill="currentColor"/>
                            <path d="M13.5713 0H18.9999V5.42857H13.5713V0Z" fill="currentColor"/>
                            <path d="M13.5713 6.78564H18.9999V12.2142H13.5713V6.78564Z" fill="currentColor"/>
                            <path d="M0 13.5715H5.42857V19.0001H0V13.5715Z" fill="currentColor"/>
                            <path d="M6.78564 13.5715H12.2142V19.0001H6.78564V13.5715Z" fill="currentColor"/>
                            <path d="M13.5713 13.5715H18.9999V19.0001H13.5713V13.5715Z" fill="currentColor"/>
                            <path d="M0 6.78564H5.42857V12.2142H0V6.78564Z" fill="currentColor"/>
                            <path d="M6.78564 6.78564H12.2142V12.2142H6.78564V6.78564Z" fill="currentColor"/>
                        </svg>
                    </button>

                    <button type="button" class="ml-0.5 py-3 sm:inline-block text-gray-200 duration-700" x-on:click="layout = 'list'"
                            x-bind:class="{'text-[#898989!important]': layout === 'list'}">
                        <svg class="-mb-5p neg-transition-scale" width="24" height="19" viewBox="0 0 24 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.78564 0H23.0714V5.42857H6.78564V0Z" fill="currentColor"/>
                            <path d="M0 0H5.42857V5.42857H0V0Z" fill="currentColor"/>
                            <path d="M0 6.78564H5.42857V12.2142H0V6.78564Z" fill="currentColor"/>
                            <path d="M0 13.5715H5.42857V19.0001H0V13.5715Z" fill="currentColor"/>
                            <path d="M6.78564 6.78564H23.0714V12.2142H6.78564V6.78564Z" fill="currentColor"/>
                            <path d="M6.78564 13.5715H23.0714V19.0001H6.78564V13.5715Z" fill="currentColor"/>
                        </svg>
                    </button>

                </nav>
        </div>

            <div id="res-loader-result" class="flex justify-center mt-173p display-none h-1/2">
                <svg class="animate-spin text-gray-700 h-10 " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="#000" stroke-width="3"></circle>
                    <path class="opacity-75" fill="#fff" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>

            <div class="sm:col-span-5 md:col-span-5 lg:col-span-3 md:mt-0 filter-anim product-result"
                 x-bind:class="{'pb-4 lg:col-span-2': layout === 'list','p-3 xl:col-span-2 2xl:col-span-3': layout === 'grid-two'}">

                <div class="grid grid-cols-2 md:grid-cols-3 gap-x-4 lg:gap-x-30p gap-y-4 mt-1 relative ltr:lg:pl-30p ltr:md:pl-4 rtl:lg:pr-30p rtl:md:pr-4"
                     x-bind:class="{'grid grid-cols-2 md:grid-cols-3': layout === 'grid','space-y-5': layout === 'list'}">
                    @if($res->records->pagination->total > 0)
                        {{-- Product list --}}
                        @php
                            $layout = \Modules\CMS\Entities\Page::firstWhere('default', '1')->layout;
                            $isEnableProduct = option($layout . '_template_product', '');
                        @endphp
                        @foreach ($res->records->data as $product)
                            @php
                                $offerFlag = $product->offerCheck;
                                $outStock = false;
                            @endphp
                            <div x-bind:class="{'flex gap-x-4 md:gap-x-30p': layout === 'list',}">
                                <div style="height: {{ $isEnableProduct['height'] }}px" class="bg-white border border-gray-2 rev-img rounded-md relative product-hover">
                                    <div x-bind:class="{'w-103p xxs:w-44 sm:w-56 md:w-60 h-full ': layout === 'list','w-full h-full': layout === 'grid'}" class="flex justify-center items-center">
                                        @if (isset($isEnableProduct['badge']) && $isEnableProduct['badge'] == 1)
                                            <div class="absolute top-2.5 ltr:left-2.5 rtl:right-2.5">
                                                @if($product->isOutOfStock->outOfStockVisibility == 1)
                                                    @php $outStock = true @endphp
                                                    <p class="bg-pinks-2 relative h-4 z-30 text-reds-3 mb-2.5 px-1.5 flex items-center rounded-sm leading-3 roboto-medium font-medium pt-2p text-8 whitespace-nowrap w-max">{{ __('Stock Out') }}</p>
                                                @endif
                                                @if(isset($product->featured) && $outStock == false)
                                                    <p class="primary-bg-color relative z-30 h-18p w-max text-white px-2 mb-2.5 flex items-center rounded-sm leading-3 roboto-medium font-medium text-xss">{{ __('Featured') }}</p>
                                                @endif
                                                @if($product->review_average == 5 && $outStock == false)
                                                    <div class="flex z-30 relative items-center w-max px-1.5 whitespace-nowrap mb-2.5 bg-green-5 h-18p rounded-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
                                                            <path d="M5 0L6.12257 3.45492H9.75528L6.81636 5.59017L7.93893 9.04508L5 6.90983L2.06107 9.04508L3.18364 5.59017L0.244718 3.45492H3.87743L5 0Z" fill="white"/>
                                                        </svg>
                                                        <p class="leading-3 pt-2p roboto-medium font-medium text-white text-xss">{{ __('Top Rated') }}</p>
                                                    </div>
                                                @endif
                                                @if($product->offerCheck && $outStock == false)
                                                    <p class="primary-bg-color z-30 h-4 relative text-gray-12 mb-2.5 px-2 flex items-center rounded-sm leading-3 roboto-medium font-medium text-8 whitespace-nowrap uppercase w-max">{{ formatCurrencyAmount($product->discountPercent) }}% {{ __('off') }}</p>
                                                @endif
                                            </div>
                                        @endif
                                        <a href="{{ route('site.productDetails', ['slug' => $product->slug]) }}" class="w-full h-full z-10"><img class="h-full w-full rounded-md neg-transition-scale object-cover"  src="{{ $product->featured_image_medium }}"
                                              alt="{{ __('Image') }}"></a>
                                    </div>

                                    <div class="w-full h-full hover-icon absolute top-0">
                                        <div class="w-full h-full flex justify-end cursor-pointer pt-15p ltr:pr-5 rtl:pl-5">
                                            <div slot="icon" class="relative hidden md:block">
                                                @if($product->type == \App\Enums\ProductType::$Simple && $outStock == false && isset($isEnableProduct['add_to_cart']) && $isEnableProduct['add_to_cart'] == 1)
                                                    <a href="javascript:void(0)" class="add-to-cart relative z-20" data-itemCode={{ $product->code }}>
                                                        <div class="h-7 w-7 relative p-1 mt-2 text-gray-12 primary-bg-hover duration-100 border border-gray-2 rounded-full bg-white flex justify-center items-center">
                                                            <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.99642 6.79516C3.62113 6.79516 3.31689 6.49093 3.31689 6.11564L3.31689 3.39756C3.31689 1.52111 4.83805 -4.74667e-05 6.7145 -4.70749e-05C8.59095 -4.73313e-05 10.1121 1.52111 10.1121 3.39756L10.1121 6.11564C10.1121 6.49093 9.80788 6.79517 9.43259 6.79517C9.0573 6.79517 8.75306 6.49093 8.75307 6.11564L8.75306 3.39756C8.75306 2.27169 7.84037 1.359 6.7145 1.359C5.58863 1.359 4.67594 2.27169 4.67594 3.39756L4.67594 6.11564C4.67594 6.49093 4.37171 6.79516 3.99642 6.79516Z" fill="#2C2C2C"/>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.73706 3.39771C3.75116 3.39771 3.7653 3.39771 3.77949 3.39771L9.69225 3.39771C10.2495 3.39767 10.732 3.39765 11.1216 3.44823C11.5403 3.50261 11.9423 3.6248 12.2807 3.93613C12.619 4.24745 12.7742 4.63792 12.8631 5.05071C12.9459 5.43474 12.9859 5.91556 13.0322 6.47087L13.3849 10.7031C13.3859 10.7161 13.387 10.7291 13.3881 10.7421C13.414 11.0526 13.439 11.3516 13.4255 11.5988C13.4104 11.876 13.3436 12.1987 13.0919 12.4722C12.8403 12.7457 12.5242 12.8391 12.2493 12.8772C12.004 12.9111 11.704 12.9111 11.3924 12.911C11.3794 12.911 11.3664 12.911 11.3533 12.911H2.07597C2.06294 12.911 2.04992 12.911 2.03692 12.911C1.72532 12.9111 1.42529 12.9111 1.18001 12.8772C0.90509 12.8391 0.589011 12.7457 0.337374 12.4722C0.0857374 12.1987 0.0188967 11.876 0.0037805 11.5988C-0.00970586 11.3516 0.015267 11.0526 0.0412033 10.7421C0.0422851 10.7291 0.0433685 10.7161 0.0444509 10.7031L0.393617 6.51316C0.394795 6.49902 0.395969 6.48493 0.397138 6.47088C0.443382 5.91557 0.483423 5.43474 0.566189 5.05071C0.655152 4.63792 0.810309 4.24745 1.14866 3.93613C1.487 3.6248 1.88901 3.50261 2.30776 3.44823C2.69733 3.39765 3.17983 3.39767 3.73706 3.39771ZM2.48276 4.79596C2.21045 4.83132 2.12063 4.8886 2.06888 4.93622C2.01712 4.98385 1.95258 5.0686 1.89473 5.33703C1.83277 5.62452 1.79878 6.01625 1.74796 6.62602L1.3988 10.816C1.36844 11.1803 1.35308 11.3832 1.36081 11.5248C1.36091 11.5266 1.36101 11.5284 1.36111 11.5302C1.36286 11.5305 1.36465 11.5307 1.36647 11.531C1.50699 11.5504 1.71039 11.552 2.07597 11.552H11.3533C11.7189 11.552 11.9223 11.5504 12.0628 11.531C12.0647 11.5307 12.0665 11.5305 12.0682 11.5302C12.0683 11.5284 12.0684 11.5266 12.0685 11.5248C12.0762 11.3832 12.0609 11.1803 12.0305 10.816L11.6813 6.62602C11.6305 6.01625 11.5965 5.62452 11.5346 5.33703C11.4767 5.0686 11.4122 4.98385 11.3604 4.93622C11.3087 4.8886 11.2189 4.83132 10.9466 4.79596C10.6549 4.75809 10.2617 4.75675 9.64983 4.75675H3.77949C3.1676 4.75675 2.7744 4.75809 2.48276 4.79596Z" fill="#2C2C2C"/>
                                                            </svg>
                                                        </div>
                                                    </a>
                                                @endif
                                                @if (preference('wishlist') && isset($isEnableProduct['wishlist']) && $isEnableProduct['wishlist'] == 1)
                                                    <div data-id="{{ $product->id }}" class="z-20 wishlist h-7 w-7 relative p-1 mt-2 text-gray-12 primary-bg-hover duration-100 border border-gray-2 rounded-full bg-white flex justify-center items-center {{ $product->is_wishlisted ? 'remove-wishlist primary-bg-color ' : 'add-wishlist' }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                @endif
                                                @if (preference('compare') && isset($isEnableProduct['compare']) && $isEnableProduct['compare'] == 1)
                                                    <div data-itemId="{{ $product->id }}" class="z-20 h-7 w-7 relative p-1 mt-2.5 text-gray-12 primary-bg-hover border border-gray-2 duration-100 rounded-full bg-white flex justify-center items-center compare-bg {{ $product->is_compared ? 'compare-remove' : 'add-to-compare' }}">
                                                        <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M2.04937 0.737095C2.01173 0.743939 1.89539 0.767892 1.79274 0.788423C1.69008 0.808954 1.46082 0.8945 1.28288 0.980046C1.01256 1.11008 0.9099 1.18193 0.677215 1.41462C0.44453 1.65073 0.372671 1.74996 0.242641 2.02029C0.0407524 2.44117 -0.00373152 2.63964 -0.000309674 3.09474C0.00653401 3.66277 0.170782 4.11103 0.547185 4.56956C0.776448 4.84673 1.22129 5.14443 1.59427 5.26419L1.72088 5.30525L1.73456 8.16933C1.74825 11.3516 1.73456 11.1737 1.98436 11.6836C2.27864 12.2892 2.84324 12.7478 3.50708 12.9188C3.68501 12.9668 3.95192 12.9804 4.93741 12.9907L6.14874 13.0078L5.69706 13.4595L5.2488 13.9078L5.65942 14.3184L6.07004 14.729L7.06579 13.7367C7.61329 13.1892 8.08208 12.6964 8.10946 12.6348C8.17105 12.4945 8.17105 12.3098 8.10946 12.1695C8.08208 12.1079 7.61329 11.6151 7.06579 11.0676L6.07004 10.0753L5.65942 10.4859L5.2488 10.8965L5.70048 11.3516L6.15558 11.8068L4.94083 11.7965L3.72608 11.7862L3.55498 11.6938C3.34967 11.5843 3.13068 11.3619 3.02118 11.1532L2.93905 10.9992L2.92879 8.15223L2.92194 5.30868L3.04855 5.26419C4.08195 4.93227 4.76632 3.87492 4.63971 2.821C4.51994 1.84919 3.90059 1.10665 2.97327 0.822641C2.74401 0.750783 2.19993 0.699455 2.04937 0.737095ZM2.59687 1.93132C3.1341 2.07161 3.47628 2.50961 3.47628 3.06053C3.47628 3.33427 3.41469 3.53274 3.26071 3.74147C3.04513 4.04602 2.71321 4.21026 2.32312 4.21369C1.76878 4.21369 1.33079 3.8715 1.19049 3.32059C1.03993 2.71834 1.41291 2.10241 2.03226 1.93474C2.27521 1.86972 2.35392 1.86972 2.59687 1.93132Z" fill="#2C2C2C"/>
                                                            <path d="M6.90107 1.74983C6.35015 2.30075 5.88478 2.79692 5.86425 2.84825C5.81634 2.9817 5.81976 3.16305 5.87794 3.29308C5.90531 3.35468 6.3741 3.84742 6.9216 4.39492L7.91735 5.38725L8.32797 4.97663L8.7386 4.56601L8.28691 4.1109L7.83181 3.6558L9.04656 3.66607L10.2613 3.67633L10.4324 3.76872C10.6377 3.87822 10.8567 4.10064 10.9662 4.30937L11.0483 4.46335L11.0586 7.31033L11.0654 10.1539L10.9388 10.1984C10.5248 10.3318 10.0697 10.65 9.81305 10.9922C9.48798 11.42 9.34084 11.8614 9.34084 12.402C9.34084 13.0522 9.56326 13.586 10.0218 14.0445C10.3263 14.3491 10.6035 14.5167 11.0312 14.6468C11.3939 14.7597 11.9346 14.7597 12.2973 14.6468C13.0946 14.4004 13.6626 13.8392 13.9022 13.0556C14.2546 11.9059 13.6181 10.6466 12.4718 10.2292L12.2665 10.1539L12.2528 7.3069C12.2426 4.7371 12.2357 4.44282 12.1844 4.24093C12.003 3.57368 11.5274 2.99538 10.9183 2.70453C10.4803 2.49922 10.405 2.48895 9.06709 2.47184L7.83865 2.45473L8.29033 2.00305L8.7386 1.55479L8.33482 1.15101C8.11582 0.932014 7.9242 0.750657 7.91735 0.750657C7.90709 0.750657 7.44856 1.20234 6.90107 1.74983ZM12.0646 11.3105C12.4171 11.4336 12.6942 11.7519 12.7969 12.142C13.0056 12.9632 12.2255 13.7434 11.4042 13.5347C10.6548 13.343 10.2921 12.5663 10.6275 11.8751C10.8772 11.3618 11.5103 11.112 12.0646 11.3105Z" fill="#2C2C2C"/>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        @if (isset($isEnableProduct['badge']) && $isEnableProduct['badge'] == 1 && $product->type != 'Grouped Product')
                                            <button class="open-view-modal hidden md:block" data-itemCode="{{ $product->code }}">
                                                <p class="z-20 text-gray-12 font-medium absolute inset-x-0 bottom-0 p-1.5 text-center text-sm primary-bg-color rounded-b">
                                                    {{ __('Quick View') }}</p>
                                            </button>
                                        @elseif(isset($isEnableProduct['badge']) && $isEnableProduct['badge'] == 1)
                                            <a href="{{ route('site.productDetails', ['slug' => $product->slug]) }}">
                                                <p class="z-20 text-gray-12 font-medium absolute inset-x-0 bottom-0 p-1.5 text-center text-sm primary-bg-color rounded-b">
                                                    {{ __('View') }}</p>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div x-bind:class="{'text-left flex flex-col justify-center': layout === 'list', 'text-center mt-3': layout === 'grid' }">
                                    <p x-bind:class="{'text-11 xxs:text-15 sm:text-15 md:text-13 rtl:text-right': layout === 'list', 'text-11 sm:text-13 ': layout === 'grid' }" class="text-11 md:text-13 text-gray-10 roboto-medium">{{ $product->categories[0] ?? null }}</p>
                                    <a href="{{ route('site.productDetails', ['slug' => $product->slug]) }}"><p x-bind:class="{'px-4 ': layout === 'grid', 'sm:text-lg rtl:text-right': layout === 'list'}" class="text-13 md:text-base text-gray-12 dm-sans font-medium mt-0.5 line-clamp ltr:mr-2 rtl:ml-2">{{ $product->name }}</p>
                                    </a>
                                    @if(isset($isEnableProduct['price']) && $isEnableProduct['price'] == 1 && $product->offerCheck)
                                        <p class="text-sm md:text-20 text-gray-12 dm-bold mt-1.5" x-bind:class="{'mt-5p sm:text-xl rtl:text-right': layout === 'list', }">
                                            {{ $product->sale_price_formatted }}
                                            <span class="text-lg line-through text-gray-10 pl-1 mt-0.5">{{ $product->regular_price_formatted }}</span>
                                        </p>
                                    @elseif (isset($isEnableProduct['price']) && $isEnableProduct['price'] == 1)
                                        <p class="text-sm md:text-20 text-gray-12 dm-bold mt-1.5" x-bind:class="{'mt-5p sm:text-xl rtl:text-right': layout === 'list', }">
                                            {{ $product->regular_price_formatted }}
                                        </p>
                                    @endif
                                    @if (isset($isEnableProduct['review']) && $isEnableProduct['review'] == 1)
                                        <div class="item-rating mt-1p">
                                            <div class="self-top">
                                                <ul class="flex gap-2p items-center md:gap-5p" x-bind:class="{'justify-start mt-1.5': layout === 'list', 'justify-center': layout === 'grid' }">
                                                    @for($i = 1; $i <= 5; $i++)
                                                     <li class="mt-1 w-18p md:w-4">
                                                        @if ($product->review_average >= $i)
                                                         <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M8.5 0L10.4084 5.87336L16.584 5.87336L11.5878 9.50329L13.4962 15.3766L8.5 11.7467L3.50383 15.3766L5.41219 9.50329L0.416019 5.87336L6.59163 5.87336L8.5 0Z" fill="var(--primary-color)"/>
                                                            </svg>
                                                        @else
                                                            <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg" class=" text-gray-300">
                                                                <path d="M8.5 0L10.4084 5.87336L16.584 5.87336L11.5878 9.50329L13.4962 15.3766L8.5 11.7467L3.50383 15.3766L5.41219 9.50329L0.416019 5.87336L6.59163 5.87336L8.5 0Z" fill="currentColor"/>
                                                            </svg>
                                                        @endif
                                                    </li>
                                                    @endfor
                                                    <li class="mt-1 text-gray-10 text-13 roboto-medium rtl:mr-2">
                                                        ({{ !empty($product->review_average) ? $product->review_average : 0 }})
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endif

                                    <p x-bind:class="{'hidden md:block text-gray-10 roboto-medium font-medium text-sm mt-1.5': layout === 'list', 'hidden': layout === 'grid' }">
                                        {{ $product->summary }}
                                    </p>
                                    @if($product->type == \App\Enums\ProductType::$Simple)
                                    <div x-bind:class="{'hidden md:block text-gray-10 mt-15p': layout === 'list', 'hidden': layout === 'grid' }">
                                        <a href="javascript:void(0)" class="add-to-cart cart-filter-details-page" id="item-add-to-cart" data-itemCode="{{ $product->code }}">
                                            <button class="primary-bg-color border font-bold w-48 h-12 rounded flex justify-center items-center hover:border-gray-12 duration-300">
                                                <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.95246 8.4209C4.48737 8.4209 4.11035 8.04387 4.11035 7.57879L4.11035 4.21038C4.11035 1.88497 5.99547 -0.00014617 8.32087 -0.000145534C10.6463 -0.000145851 12.5314 1.88497 12.5314 4.21038L12.5314 7.57879C12.5314 8.04387 12.1544 8.4209 11.6893 8.4209C11.2242 8.4209 10.8472 8.04387 10.8472 7.57879L10.8472 4.21038C10.8472 2.81513 9.71612 1.68406 8.32087 1.68406C6.92563 1.68406 5.79456 2.81513 5.79456 4.21038L5.79456 7.57879C5.79456 8.04387 5.41754 8.4209 4.95246 8.4209Z" fill="#2C2C2C"/>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.6312 4.21045C4.64866 4.21045 4.66619 4.21045 4.68377 4.21045L12.0112 4.21045C12.7018 4.21041 13.2997 4.21038 13.7825 4.27307C14.3015 4.34045 14.7996 4.49189 15.2189 4.8777C15.6382 5.26351 15.8305 5.7474 15.9408 6.25895C16.0433 6.73486 16.093 7.33073 16.1503 8.0189L16.5873 13.2638C16.5887 13.2799 16.59 13.296 16.5914 13.312C16.6235 13.6969 16.6545 14.0674 16.6377 14.3738C16.619 14.7172 16.5362 15.1172 16.2243 15.4561C15.9125 15.795 15.5208 15.9108 15.1801 15.958C14.8761 16.0001 14.5043 16 14.1181 15.9999C14.102 15.9999 14.0859 15.9999 14.0698 15.9999H2.57267C2.55652 15.9999 2.54039 15.9999 2.52428 15.9999C2.13812 16 1.7663 16.0001 1.46234 15.958C1.12164 15.9108 0.729939 15.795 0.418095 15.4561C0.106251 15.1172 0.0234179 14.7172 0.00468502 14.3738C-0.0120281 14.0674 0.0189198 13.6968 0.0510617 13.312C0.0524023 13.296 0.0537449 13.2799 0.0550863 13.2638L0.487794 8.07131C0.489254 8.05379 0.490709 8.03632 0.492158 8.01892C0.549466 7.33074 0.599088 6.73487 0.701656 6.25895C0.811904 5.7474 1.00418 5.26351 1.42349 4.8777C1.84279 4.49189 2.34098 4.34045 2.85992 4.27307C3.3427 4.21038 3.94064 4.21041 4.6312 4.21045ZM3.07679 5.94325C2.73932 5.98708 2.62802 6.05806 2.56388 6.11708C2.49974 6.17609 2.41976 6.28112 2.34806 6.61378C2.27128 6.97005 2.22916 7.45551 2.16618 8.21118L1.73348 13.4037C1.69585 13.8551 1.67682 14.1065 1.68639 14.2821C1.68652 14.2843 1.68665 14.2866 1.68678 14.2887C1.68894 14.2891 1.69115 14.2894 1.69341 14.2897C1.86755 14.3138 2.11963 14.3157 2.57267 14.3157H14.0698C14.5228 14.3157 14.7749 14.3138 14.949 14.2897C14.9513 14.2894 14.9535 14.2891 14.9557 14.2887C14.9558 14.2866 14.9559 14.2843 14.956 14.2821C14.9656 14.1065 14.9466 13.8551 14.909 13.4037L14.4762 8.21118C14.4133 7.45551 14.3711 6.97005 14.2944 6.61378C14.2227 6.28112 14.1427 6.17609 14.0785 6.11708C14.0144 6.05806 13.9031 5.98708 13.5656 5.94325C13.2042 5.89632 12.7169 5.89466 11.9587 5.89466H4.68377C3.92549 5.89466 3.43821 5.89632 3.07679 5.94325Z" fill="#2C2C2C"/>
                                                </svg>
                                                <span class="pl-2 dm-bold font-bold text-gray-12 text-sm">{{ __('Add to Cart') }}</span>
                                            </button>
                                        </a>
                                    </div>
                                     @else
                                        @if (isset($isEnableProduct['quick_view']) && $isEnableProduct['quick_view'] == 1 && $product->type != 'Grouped Product')
                                            <div x-bind:class="{'hidden md:block text-gray-10 mt-15p': layout === 'list', 'hidden': layout === 'grid' }">
                                                <a href="javascript:void(0)" class="open-view-modal" id="item-add-to-cart" data-itemCode="{{ $product->code }}">
                                                    <button class="primary-bg-color border font-bold w-48 h-12 rounded flex justify-center items-center hover:border-gray-12 duration-300">
                                                        <span class="pl-2 dm-bold font-bold text-gray-12 text-sm">{{ __('Quick View') }}</span>
                                                    </button>
                                                </a>
                                            </div>
                                        @elseif(isset($isEnableProduct['quick_view']) && $isEnableProduct['quick_view'] == 1)
                                            <div x-bind:class="{'hidden md:block text-gray-10 mt-15p': layout === 'list', 'hidden': layout === 'grid' }">
                                                <a href="{{ route('site.productDetails', ['slug' => $product->slug]) }}">
                                                    <button class="primary-bg-color border font-bold w-48 h-12 rounded flex justify-center items-center hover:border-gray-12 duration-300">
                                                        <span class="pl-2 dm-bold font-bold text-gray-12 text-sm">{{ __('Quick View') }}</span>
                                                    </button>
                                                </a>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                @if ($res->records->pagination->total > $res->records->pagination->rows_per_page)
                    @php
                    $lastPage = ceil($res->records->pagination->total / $res->records->pagination->rows_per_page);
                    $pageUrl = !empty($res->records->pagination->next_page_url) ? $res->records->pagination->next_page_url : $res->records->pagination->prev_page_url;
                    $nextPageNumber = $res->records->pagination->current_page;
                    $nextPageNumber = !empty($res->records->pagination->next_page_url) ? $nextPageNumber + 1 : $nextPageNumber - 1;
                    @endphp
                    <div class="flex text-gray-700 justify-center pt-5 mt-25p border-t ltr:ml-30p rtl:mr-30p">
                        @if(!empty($res->records->pagination->prev_page_url))
                            <a href="{{ $res->records->pagination->prev_page_url }}" class="relative process-prev flex justify-center items-center cursor-pointer  text-gray-10 hover:text-gray-12 page-link ltr:mr-1 rtl:ml-1">
                                <svg class="absolute" width="11" height="7" viewBox="0 0 11 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.59216 0L4.6714 1.05155L2.92161 2.75644H10.2369C10.6583 2.75644 11 3.08934 11 3.5C11 3.91066 10.6583 4.24356 10.2369 4.24356H2.92161L4.6714 5.94845L3.59216 7L0 3.5L3.59216 0Z" fill="currentColor"/>
                                </svg>
                                <p class="roboto-medium text-sm ltr:mr-3 rtl:ml-3">{{ __('Prev') }}</p>
                            </a>
                        @endif
                        @if($res->records->pagination->current_page > 3)
                            <a href="{{ $res->records->pagination->current_page == 1 ? 'javascript:void(0)' : str_replace('page='.$nextPageNumber, 'page=1', $pageUrl) }}" class="w-8 flex justify-center items-center cursor-pointer leading-5 roboto-medium text-15 {{ $res->records->pagination->current_page == 1 ? 'primary-bg-color' : 'text-gray-10 page-link' }}  hover:text-gray-12">1</a>
                        @endif
                        @if($res->records->pagination->current_page > 4)
                            <a href="javascript:void(0)" class="w-8 flex justify-center items-center cursor-pointer leading-5 roboto-medium text-15 text-gray-10 hover:text-gray-12">...</a>
                        @endif
                        <div class="flex h-8 font-medium">
                            @if($lastPage > 1)
                                @foreach (range(1, $lastPage) as $i)
                                    @if($i >= $res->records->pagination->current_page - 2 && $i <= $res->records->pagination->current_page + 2)
                                        <a href="{{ $res->records->pagination->current_page == $i ? 'javascript:void(0)' : str_replace('page='.$nextPageNumber, 'page='.$i, $pageUrl) }}" class="w-8 flex justify-center items-center cursor-pointer leading-5 roboto-medium text-15 {{ $res->records->pagination->current_page == $i ? 'primary-bg-color' : 'text-gray-10 page-link' }}  hover:text-gray-12">
                                            {{ $i }}
                                        </a>
                                    @endif
                                @endforeach
                            @endif
                            @if($res->records->pagination->current_page < $lastPage - 3)
                                <a href="javascript:void(0)" class="w-8 flex justify-center items-center cursor-pointer leading-5 roboto-medium text-15 text-gray-10 hover:text-gray-12">...</a>
                            @endif
                            @if($res->records->pagination->current_page < $lastPage - 2)
                                <a href="{{ str_replace('page='.$nextPageNumber, 'page='.$lastPage, $pageUrl) }}" class="w-8 flex justify-center items-center cursor-pointer leading-5 roboto-medium text-15 {{ $res->records->pagination->current_page == $i ? 'primary-bg-color' : 'text-gray-10' }}  hover:text-gray-12 page-link">
                                    {{ $lastPage }}
                                </a>
                            @endif
                        </div>
                        @if(!empty($res->records->pagination->next_page_url))
                            <a href="{{ $res->records->pagination->next_page_url }}" class="relative process-next flex justify-center items-center cursor-pointer page-link  ltr:ml-1 rtl:mr-1">
                                <p class="roboto-medium text-sm text-gray-10 ltr:mr-3 rtl:ml-3">{{ __('Next') }}</p>
                                <svg class="absolute  neg-transition-scale" width="11" height="7" viewBox="0 0 11 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.40784 0L6.3286 1.05155L8.07839 2.75644H0.763135C0.341667 2.75644 0 3.08934 0 3.5C0 3.91066 0.341667 4.24356 0.763135 4.24356H8.07839L6.3286 5.94845L7.40784 7L11 3.5L7.40784 0Z" fill="#898989"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                @endif
            </div>
            @if($res->records->pagination->total <= 0)
            <div class="ltr:pl-30p rtl:pr-30p mt-16">
                <svg class="neg-transition-scale" width="72" height="70" viewBox="0 0 72 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13.8518 7.94375C6.58144 11.9234 0.520508 15.2984 0.379883 15.4391C0.239258 15.5797 0.0845703 15.9594 0.0423828 16.2828L-0.0419922 16.8734L3.97988 20.9094L8.01582 24.9453L4.06426 28.8969C0.450195 32.5109 0.112695 32.8906 0.0423828 33.3969C-0.0138672 33.8609 0.0283203 34.0438 0.295508 34.3531C0.47832 34.55 2.40488 35.7031 4.57051 36.8984L8.50801 39.05L8.57832 46.5875L8.64863 54.125L9.00019 54.4484C9.19707 54.6453 15.258 58.0203 22.458 61.9859C31.5986 66.9922 35.7049 69.1719 36.0002 69.1719C36.2955 69.1719 40.4018 66.9922 49.5424 61.9859C56.7424 58.0203 62.8033 54.6453 63.0002 54.4484L63.3517 54.125L63.4221 46.5875L63.4924 39.05L67.4299 36.8984C69.5955 35.7031 71.508 34.5641 71.6908 34.3672C72.0424 33.9453 72.0846 33.4672 71.8033 32.9188C71.6908 32.7078 69.8908 30.8375 67.7955 28.7422L63.9846 24.9453L68.0064 20.9094L72.0424 16.8734L71.958 16.2828C71.9158 15.9594 71.7611 15.5797 71.6205 15.4391C71.1424 14.975 62.1002 10.0813 61.5799 10.0109C61.158 9.95469 60.9892 10.0109 60.6236 10.3344C60.0049 10.9109 59.9064 11.6 60.3705 12.1625C60.5814 12.4016 62.2408 13.4 64.4627 14.6094C66.5158 15.7344 68.2033 16.6766 68.2033 16.7188C68.2033 16.7609 66.7549 18.2375 64.983 20.0094L61.7627 23.2297L50.1892 16.8734C43.8189 13.3719 38.5596 10.4609 38.5033 10.4047C38.4471 10.3625 39.8533 8.85781 41.6252 7.08594L44.8736 3.85156L45.7455 4.32969C52.3408 7.97188 52.2564 7.92969 53.0299 7.17031C53.5642 6.62188 53.6064 5.75 53.1002 5.28594C52.5658 4.77969 44.958 0.687502 44.5643 0.687502C44.3814 0.687502 44.058 0.785939 43.8752 0.912502C43.6783 1.03906 41.8361 2.825 39.7689 4.89219L36.0002 8.63281L32.2455 4.89219C30.1643 2.825 28.3221 1.03906 28.1252 0.912502C27.9424 0.785939 27.6189 0.687502 27.4221 0.687502C27.2111 0.687502 21.6143 3.68281 13.8518 7.94375ZM30.4314 7.14219L33.6377 10.3484L33.0189 10.7C32.6955 10.8969 27.4221 13.7938 21.3189 17.1406L10.2377 23.2297L6.97519 19.9531C5.18926 18.1531 3.79707 16.6625 3.86738 16.6344C3.95176 16.5922 9.16894 13.7234 15.4689 10.25C21.7689 6.77656 27.0002 3.93594 27.0705 3.93594C27.1549 3.92188 28.6596 5.37031 30.4314 7.14219ZM47.5736 18.6313C53.8455 22.0906 59.0064 24.9172 59.0346 24.9453C59.1049 25.0016 36.183 37.5313 36.0002 37.5313C35.9018 37.5313 30.6564 34.7047 24.3564 31.2453L12.9096 24.9594L13.3877 24.7203C13.6408 24.5797 18.7877 21.7391 24.8205 18.4203C30.8533 15.1016 35.8736 12.3734 35.9721 12.3734C36.0564 12.3594 41.2877 15.1859 47.5736 18.6313ZM21.9377 33.1297L33.6377 39.5422L30.4174 42.7625C28.6596 44.5203 27.1549 45.9688 27.0846 45.9688C26.9721 45.9688 4.58457 33.7344 3.93769 33.3125C3.76894 33.2 4.38769 32.525 6.96113 29.9375C8.73301 28.1656 10.2096 26.7031 10.2236 26.7031C10.2377 26.7031 15.5111 29.5859 21.9377 33.1297ZM65.0392 29.9375C66.8111 31.7094 68.2314 33.1859 68.1892 33.2281C68.0486 33.3688 45.2393 45.8703 45.0143 45.9266C44.8736 45.9547 43.6783 44.8719 41.583 42.7625L38.3627 39.5422L50.0205 33.1297C56.4189 29.6141 61.6924 26.7172 61.7346 26.7172C61.7767 26.7031 63.2533 28.1516 65.0392 29.9375ZM19.6455 45.1813C23.9627 47.5438 27.1408 49.2031 27.3518 49.2031C27.5627 49.2031 27.858 49.1328 28.0268 49.0484C28.1955 48.9641 30.0658 47.1781 32.1752 45.0828L36.0002 41.2578L39.8393 45.0828C41.9346 47.1781 43.8049 48.9641 43.9736 49.0484C44.1424 49.1328 44.4377 49.2031 44.6486 49.2031C44.9299 49.2031 57.8252 42.2844 60.1596 40.8781L60.6096 40.5969V46.6438V52.6906L49.1205 58.9906C42.8064 62.4641 37.5893 65.3188 37.5189 65.3469C37.4627 65.375 37.3924 62.0422 37.3783 57.9359L37.3361 50.4688L36.9424 50.0891C36.6611 49.7938 36.4221 49.6953 36.0002 49.6953C35.5783 49.6953 35.3393 49.7938 35.058 50.0891L34.6643 50.4688L34.6221 57.9359C34.608 62.0422 34.5377 65.375 34.4814 65.3469C34.4111 65.3188 29.1939 62.4641 22.8799 58.9906L11.3908 52.6906V46.6438V40.5969L11.8549 40.8781C12.0939 41.0328 15.6096 42.9594 19.6455 45.1813Z" fill="#898989"/>
                    <path d="M35.3535 45.139C34.5519 45.5328 34.4113 46.7422 35.1003 47.389C35.8597 48.1062 37.1535 47.6422 37.3503 46.5875C37.5472 45.5047 36.366 44.6469 35.3535 45.139Z" fill="#898989"/>
                    <path d="M56.3063 7.6625C55.8141 7.90156 55.5469 8.36563 55.5469 8.98438C55.5469 9.56094 56.2641 10.25 56.8828 10.25C57.4453 10.25 58.1484 9.71563 58.275 9.19531C58.4156 8.63281 58.0219 7.87344 57.4594 7.64844C56.8547 7.39531 56.8406 7.39531 56.3063 7.6625Z" fill="#898989"/>
                </svg>
                @php
                 $category = isset($res->records->filter_applied->categories[0]) ? $res->records->filter_applied->categories[0] : null;
                @endphp
                <p class="dm-sans text-20 text-gray-10 mt-5">
                    {{ __('Sorry, we couldn’t find any results matching') }} “{{ isset($res->records->filter_applied->keyword[0]) && $res->records->filter_applied->keyword[0] != "" ? $res->records->filter_applied->keyword[0] : $category }}”.
                </p>
                <div class="mt-9 invisible-list text-gray-10">
                    <li class="roboto-medium text-sm">
                        {{ __('Check your spelling and try again.') }}
                    </li>
                    <li class="roboto-medium text-sm mt-5p">
                        {{ __('Try a similar but different search term, like sofa instead of settee.') }}
                    </li>
                    <li class="roboto-medium text-sm mt-5p">
                        {{ __('Keep your search term simple as our search facility works best with shorter descriptions.') }}
                    </li>
                    <li class="roboto-medium text-sm mt-5p">
                        {{ __('Try looking within the departments shown below.') }}
                    </li>
                </div>
            </div>
            @endif
        </div>
    </div>
    <script>
        var categoryPath = '{!! json_encode($res->records->category_path) !!}';
    </script>
@endforeach
