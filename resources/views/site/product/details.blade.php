@php
    $definedData = get_defined_vars();
@endphp
@extends('../site/layouts.app')
@section('page_title', $name)
@section('seo')
    @include('site.layouts.section.product-details.seo')
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/swiper/swiper-bundle.min.css') }}">
@endsection
@section('content')

    <!-- Details section start -->
    <section class="mx-5 lg:mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92 md:mt-30p mt-5" id="item-details-container">

        @doAction('before_signle_product_breadcrumb', $definedData)

        <nav class="text-gray-600 text-sm" aria-label="Breadcrumb">
            <ol
                class="list-none p-0 flex flex-wrap md:inline-flex text-xs md:text-sm roboto-medium font-medium text-gray-10 leading-5">
                <li class="flex items-center">

                    <svg class="-mt-1 ltr:mr-2 rtl:ml-2" width="13" height="15" viewBox="0 0 13 15" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M5.35643 1.89407C4.93608 2.1717 4.43485 2.59943 3.69438 3.23412L2.916 3.9013C2.0595 4.63545 1.82512 4.85827 1.69934 5.13174C1.57357 5.4052 1.55692 5.72817 1.55692 6.85625V10.1569C1.55692 10.9127 1.55857 11.4013 1.60698 11.7613C1.65237 12.099 1.72565 12.2048 1.7849 12.264C1.84416 12.3233 1.94997 12.3966 2.28759 12.442C2.64759 12.4904 3.13619 12.492 3.89206 12.492H8.56233C9.31819 12.492 9.80679 12.4904 10.1668 12.442C10.5044 12.3966 10.6102 12.3233 10.6695 12.264C10.7287 12.2048 10.802 12.099 10.8474 11.7613C10.8958 11.4013 10.8975 10.9127 10.8975 10.1569V6.85625C10.8975 5.72817 10.8808 5.4052 10.755 5.13174C10.6293 4.85827 10.3949 4.63545 9.53838 3.9013L8.76 3.23412C8.01953 2.59943 7.5183 2.1717 7.09795 1.89407C6.69581 1.62848 6.44872 1.55676 6.22719 1.55676C6.00566 1.55676 5.75857 1.62848 5.35643 1.89407ZM4.49849 0.595063C5.03749 0.239073 5.5849 0 6.22719 0C6.86948 0 7.41689 0.239073 7.95589 0.595063C8.4674 0.932894 9.04235 1.42573 9.7353 2.01972L10.5515 2.71933C10.5892 2.75162 10.6264 2.78347 10.6632 2.81492C11.3564 3.40806 11.8831 3.85873 12.1694 4.48124C12.4557 5.10375 12.4551 5.79693 12.4543 6.70926C12.4543 6.75764 12.4542 6.80662 12.4542 6.85625L12.4542 10.2081C12.4543 10.8981 12.4543 11.4927 12.3903 11.9688C12.3217 12.479 12.167 12.9681 11.7703 13.3648C11.3736 13.7615 10.8845 13.9162 10.3742 13.9848C9.89812 14.0488 9.30358 14.0488 8.61355 14.0488H3.84083C3.1508 14.0488 2.55626 14.0488 2.08015 13.9848C1.56991 13.9162 1.08082 13.7615 0.68411 13.3648C0.2874 12.9681 0.132701 12.479 0.064101 11.9688C9.07021e-05 11.4927 0.000124017 10.8981 0.000162803 10.2081L0.000164659 6.85625C0.000164659 6.80662 0.000122439 6.75763 8.07765e-05 6.70926C-0.000705247 5.79693 -0.00130245 5.10374 0.285011 4.48124C0.571324 3.85873 1.09802 3.40806 1.79122 2.81492C1.82798 2.78347 1.8652 2.75162 1.90288 2.71933L2.68126 2.05215C2.69391 2.0413 2.70652 2.03049 2.71909 2.01972C3.41204 1.42573 3.98698 0.932893 4.49849 0.595063Z"
                            fill="#898989" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M3.50293 9.37853C3.50293 8.51876 4.19991 7.82178 5.05969 7.82178H7.39482C8.25459 7.82178 8.95158 8.51876 8.95158 9.37853V13.2704C8.95158 13.7003 8.60309 14.0488 8.1732 14.0488C7.74331 14.0488 7.39482 13.7003 7.39482 13.2704V9.37853H5.05969V13.2704C5.05969 13.7003 4.71119 14.0488 4.28131 14.0488C3.85142 14.0488 3.50293 13.7003 3.50293 13.2704V9.37853Z"
                            fill="#898989" />
                    </svg>

                    <a href="{{ route('site.index') }}">{{ __('Home') }}</a>
                    <p class="px-2">/</p>
                    @php
                        $totalLen = 152;
                        $pathLen = strlen(__('Home'));
                        $pathLen += 3;
                    @endphp
                    @if (!empty($categoryPath))
                </li>
                @foreach ($categoryPath as $key => $path)
                    @php
                        $pathLen += 3;
                        $pathLen += strlen($path['slug']);
                    @endphp
                    <li class="flex items-center">
                        <a href="{{ route('site.productSearch', ['categories' => $path['slug']]) }}">{{ $path['name'] }}</a>
                        <p class="px-2">/</p>
                    </li>
                @endforeach
                <li>
                    @endif
                    @php
                        $widthLen = $totalLen - $pathLen;
                        $widthLen = $widthLen > 0 ? $widthLen : 0;
                    @endphp
                    <a href="javascript:void(0)" class="text-gray-12"
                        aria-current="page">{{ trimWords($name, $widthLen) }}</a>
                </li>
            </ol>
        </nav>

        @doAction('before_signle_product_summary', $definedData)

        <div class="flex flex-wrap mt-4 md:mt-6 relative">


            @include('site.layouts.section.product-details.slider')
            <div id="item-details-wishlist" class="md:px-3 w-full sm:w-1/2 lg:w-36% md:order-none">

                @doAction('before_signle_product_summary_categories_metas', $definedData)

                <div>
                    <div class="md:flex flex-wrap hidden">
                        @if (!empty(end($categories)))
                            <div class="flex-initial px-2 text-gray-10 bg-gray-11 mb-2 rounded-sm ltr:mr-2 rtl:ml-2">
                                <p class="roboto-medium font-medium text-xs py-1">{{ __('Category') }}:
                                    {{ end($categories) }}</p>
                            </div>
                        @endif
                        @if (!empty($brand))
                            <div class="flex-initial px-2 text-gray-10 bg-gray-11 mb-2 rounded-sm ltr:mr-2 rtl:ml-2">
                                <p class="roboto-medium font-medium text-xs py-1">{{ __('Brand') }}: {{ $brand }}
                                </p>
                            </div>
                        @endif
                        @if (!empty($sku))
                            <div class="flex-initial px-2 text-gray-10 bg-gray-11 mb-2 rounded-sm ltr:mr-2 rtl:ml-2">
                                <p class="roboto-medium font-medium text-xs py-1">{{ __('SKU') }}: {{ $sku }}
                                </p>
                            </div>
                        @endif
                    </div>

                    @doAction('before_signle_product_summary_product_name', $definedData)

                    <div class="md:mt-4">
                        <h3 class="text-gray-12 dm-bold font-bold text-xl 2xl:text-22 -mt-1">
                            {{ $name }}
                        </h3>
                    </div>

                    @doAction('before_signle_product_summary_rating_metas', $definedData)

                    <div
                        class="flex md:flex-col lg:flex-row justify-start items-center md:items-start lg:justify-start lg:items-center gap-x-4 md:gap-x-0 lg:gap-x-4 md:mt-3 mt-3">
                        {{-- ratting --}}
                        @if ($reviews_allowed == 1 && preference('reviews_enable_product_review') == 1)
                            @include('site.layouts.section.product-details.rating')
                        @endif
                        <div class="flex justify-start items-center x:gap-x-3 gap-x-4 mt-0 md:mt-4 lg:mt-0">
                            {{-- share button --}}
                            @include('site.layouts.section.product-details.share_button')

                            @if (preference('wishlist'))
                                @php
                                    $active = false;
                                    if (auth()->user()) {
                                        foreach (auth()->user()->wishlist as $key => $wishlist) {
                                            if ($id == $wishlist->product_id) {
                                                $active = true;
                                            }
                                        }
                                    }
                                @endphp
                                {{-- Wish-list --}}
                                <div>
                                    <div class="flex items-center h-7 w-7 p-1 cursor-pointer text-transparent wishlist"
                                        data-id="{{ $id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="{{ $active ? 'color_fill svg-bg ' : 'text-gray-10' }} -mt-1"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            @endif

                            {{-- compare --}}
                            @if (preference('compare'))
                                <div data-itemId="{{ $id }}"
                                    class="h-7 w-7 p-1 compareText cursor-pointer {{ isCompared($id) ? 'compare-remove' : 'add-to-compare' }}">
                                    <div>
                                        <svg width="17" height="17" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M2.84923 0.0139465C2.80785 0.0214701 2.67995 0.0478029 2.5671 0.0703735C2.45424 0.0929451 2.2022 0.186991 2.00658 0.281036C1.7094 0.423985 1.59655 0.502984 1.34074 0.758788C1.08494 1.01835 1.00594 1.12745 0.862989 1.42463C0.641041 1.88734 0.592138 2.10552 0.595899 2.60585C0.603423 3.23031 0.783991 3.72311 1.19779 4.22719C1.44983 4.5319 1.93887 4.85918 2.34891 4.99084L2.4881 5.03599L2.50315 8.18463C2.51819 11.6831 2.50315 11.4875 2.77776 12.048C3.10128 12.7139 3.72198 13.218 4.45177 13.4061C4.64739 13.4587 4.94081 13.4738 6.02422 13.485L7.3559 13.5039L6.85934 14.0004L6.36654 14.4932L6.81796 14.9446L7.26938 15.3961L8.36407 14.3051C8.96597 13.7032 9.48134 13.1615 9.51143 13.0938C9.57914 12.9396 9.57914 12.7364 9.51143 12.5822C9.48134 12.5145 8.96597 11.9728 8.36407 11.3709L7.26938 10.28L6.81796 10.7314L6.36654 11.1828L6.8631 11.6831L7.36343 12.1835L6.02798 12.1722L4.69253 12.1609L4.50444 12.0593C4.27873 11.9389 4.03797 11.6944 3.91759 11.4649L3.82731 11.2957L3.81602 8.16583L3.8085 5.03975L3.94769 4.99084C5.08376 4.62595 5.83612 3.46354 5.69694 2.3049C5.56527 1.23654 4.88438 0.420224 3.86493 0.107992C3.61288 0.0289936 3.01475 -0.0274334 2.84923 0.0139465ZM3.45113 1.32682C4.04173 1.48106 4.41792 1.96257 4.41792 2.56823C4.41792 2.86917 4.3502 3.08736 4.18092 3.31683C3.94393 3.65163 3.57903 3.8322 3.15018 3.83596C2.54076 3.83596 2.05925 3.45978 1.90502 2.85413C1.73949 2.19204 2.14953 1.51492 2.83042 1.33059C3.09751 1.25911 3.18404 1.25911 3.45113 1.32682Z"
                                                fill="#898989" />
                                            <path
                                                d="M8.18316 1.12749C7.57751 1.73315 7.0659 2.27861 7.04333 2.33504C6.99066 2.48175 6.99442 2.68113 7.05838 2.82408C7.08847 2.89179 7.60384 3.43349 8.20573 4.03539L9.30042 5.12632L9.75184 4.6749L10.2033 4.22348L9.7067 3.72315L9.20638 3.22283L10.5418 3.23412L11.8773 3.2454L12.0654 3.34697C12.2911 3.46735 12.5318 3.71187 12.6522 3.94134L12.7425 4.11062L12.7538 7.24046L12.7613 10.3665L12.6221 10.4154C12.1669 10.5622 11.6666 10.912 11.3845 11.2882C11.0271 11.7584 10.8653 12.2437 10.8653 12.8381C10.8653 13.5528 11.1099 14.1397 11.6139 14.6437C11.9488 14.9785 12.2535 15.1629 12.7237 15.3058C13.1224 15.43 13.7168 15.43 14.1156 15.3058C14.9921 15.035 15.6165 14.418 15.8799 13.5566C16.2673 12.2926 15.5676 10.9082 14.3074 10.4493L14.0817 10.3665L14.0667 7.2367C14.0554 4.41157 14.0479 4.08805 13.9914 3.8661C13.792 3.13255 13.2692 2.4968 12.5995 2.17704C12.118 1.95133 12.0353 1.94005 10.5644 1.92124L9.2139 1.90243L9.71046 1.40587L10.2033 0.91307L9.75937 0.469173C9.51861 0.228417 9.30795 0.0290403 9.30042 0.0290403C9.28914 0.0290403 8.78505 0.525601 8.18316 1.12749ZM13.8598 11.638C14.2472 11.7735 14.5519 12.1233 14.6648 12.5522C14.8943 13.455 14.0366 14.3127 13.1337 14.0832C12.3099 13.8726 11.9111 13.0186 12.2798 12.2587C12.5544 11.6945 13.2503 11.4199 13.8598 11.638Z"
                                                fill="#898989" />
                                        </svg>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    @doAction('before_signle_product_summary_offer', $definedData)

                    @include('site.layouts.section.product-details.offer')

                    @doAction('before_signle_product_summary_variation', $definedData)

                    @if (!$product->isGroupedProduct() && !$product->isExternalProduct())
                        @include('site.layouts.section.product-details.variation')
                    @endif

                    @doAction('before_signle_product_summary_add_to_cart', $definedData)

                    @include('site.layouts.section.product-details.add_to_cart')

                    @doAction('after_signle_product_summary_add_to_cart', $definedData)
                </div>
                <span class="text-sm text-gray-10 roboto-medium font-medium">{{ $purchase_note }}</span>
            </div>
            

            <div class="w-full sm:w-full lg:w-28% md:order-none ltr:md:pl-3 rtl:md:pr-3">

                @doAction('before_signle_product_summary_delivery', $definedData)

                @include('site.layouts.section.product-details.delivery')

                @doAction('after_signle_product_summary_delivery', $definedData)

            </div>
        </div>

        @doAction('before_signle_product_detail', $definedData)

        <div id="item-details-section" class="flex flex-wrap mt-6">
            <div class="w-full lg:w-72% ltr:lg:pr-3 rtl:lg:pl-3">
                @doAction('before_signle_product_detail_tabs', $definedData)
                <section class="md:mb-10">
                    <div id="tabs" class="c-tabs">
                        <div class="flex dm-sans">
                            <div class="c-tabs-nav d-tab w-full" id="nav-line">
                                @php
                                    $initialTab = -1;
                                    $ratingTab = -1;
                                @endphp
                                @if (
                                    !empty(strip_tags($description)) ||
                                        strpos($description, '<img src') ||
                                        !empty($summary) ||
                                        (isset($videos) && is_array($videos) && count($videos) > 0))
                                    @php
                                        $initialTab++;
                                        $ratingTab++;
                                    @endphp
                                    <a href="javascript:void(0)" class="c-tabs-nav__link is-active"
                                        id="product-description">{{ __('Description') }}</a>
                                @endif
                                @if (
                                    !empty($attributes) ||
                                        !empty($weight) ||
                                        (is_array($dimensions) &&
                                            count($dimensions) > 0 &&
                                            isset($dimensions['length']) &&
                                            $dimensions['length'] != '') ||
                                        (is_array($dimensions) &&
                                            count($dimensions) > 0 &&
                                            isset($dimensions['width']) &&
                                            $dimensions['width'] != '') ||
                                        (is_array($dimensions) &&
                                            count($dimensions) > 0 &&
                                            isset($dimensions['height']) &&
                                            $dimensions['height'] != ''))
                                    @php
                                        $initialTab != 0 ? ($initialTab = 1) : '';
                                        $ratingTab++;
                                    @endphp
                                    <a href="javascript:void(0)" class="c-tabs-nav__link"
                                        id="product-specification">{{ __('Specification') }}</a>
                                @endif
                                @if (!empty($vendorDetails))
                                    @php
                                        $initialTab != 0 && $initialTab != 1 ? ($initialTab = 2) : '';
                                        $ratingTab++;
                                    @endphp
                                    <a href="javascript:void(0)" class="c-tabs-nav__link vendor-info"
                                        id="product-vendor-info">{{ __('Vendor Info') }}</a>
                                @endif
                                @if ($reviews_allowed == 1 && preference('reviews_enable_product_review') == 1)
                                    @php
                                        $initialTab != 0 && $initialTab != 1 && $initialTab != 2 ? ($initialTab = 3) : '';
                                        $ratingTab++;
                                    @endphp
                                    <a href="javascript:void(0)" class="c-tabs-nav__link"
                                        id="product-review">{{ __('Reviews') }} ({{ $reviewCount }})</a>
                                @endif
                            </div>
                        </div>
                        @if (
                            !empty(strip_tags($description)) ||
                                strpos($description, '<img src') ||
                                !empty($summary) ||
                                (isset($videos) && is_array($videos) && count($videos) > 0))
                            @include('site.layouts.section.product-details.description')
                        @endif
                        @if (
                            !empty($attributes) ||
                                !empty($weight) ||
                                (is_array($dimensions) &&
                                    count($dimensions) > 0 &&
                                    isset($dimensions['length']) &&
                                    $dimensions['length'] != '') ||
                                (is_array($dimensions) &&
                                    count($dimensions) > 0 &&
                                    isset($dimensions['width']) &&
                                    $dimensions['width'] != '') ||
                                (is_array($dimensions) &&
                                    count($dimensions) > 0 &&
                                    isset($dimensions['height']) &&
                                    $dimensions['height'] != ''))
                            @include('site.layouts.section.product-details.specification')
                        @endif
                        @if (!empty($vendorDetails))
                            @include('site.layouts.section.product-details.vendor_info')
                        @endif
                        @if ($reviews_allowed == 1 && preference('reviews_enable_product_review') == 1)
                            @include('site.layouts.section.product-details.review')
                        @endif
                    </div>
                </section>

                @doAction('before_signle_product_detail_related_products', $definedData)

                @include('site.layouts.section.product-details.related-products')

                @doAction('after_signle_product_detail_related_products', $definedData)
            </div>
            <div class="w-full lg:w-28% md:mt-4 ltr:lg:pl-3 rtl:lg:pr-3">

                @doAction('before_signle_product_detail_vendor', $definedData)

                @if (!empty($vendorDetails))
                    <div class="relative z-ng px-2 pb-15p border rounded rounded-b-none">
                        <div class="flex flex-wrap px-2">
                            <div class="w-4/5">
                                <p class="text-gray-10 dm-bold font-bold text-xs pt-4">{{ __('Sold By') }}</p>
                                <p class="text-base text-gray-12 dm-bold font-bold">{{ $vendorDetails->name }}</p>
                            </div>
                            <div class="w-1/5">
                                <div class="mt-4">
                                    <img class="w-full h-full"
                                        src="{{ optional($vendorDetails->logo)->fileUrl() ?? $vendorDetails->fileUrl() }}"
                                        alt="{{ __('Image') }}">
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-wrap mt-2">
                            <div class="w-1/3">
                                <div class="relative h-75p px-2 ltr:border-r">
                                    <p class="text-gray-10 text-11 roboto-medium font-medium mt-1">
                                        {{ __('Positive Seller Ratings') }}</p>
                                    <p class="text-xl roboto-medium font-medium mt-3 absolute bottom-0">
                                        {{ \App\Models\Product::positiveRating($vendor_id) }}%</p>
                                </div>
                            </div>

                            <div class="w-1/3">
                                <div class="relative border-r h-75p px-2">
                                    <p class="text-gray-10 text-11 roboto-medium font-medium mt-1">
                                        {{ __('Ship on Time') }}</p>
                                    <p class="text-xl roboto-medium font-medium mt-3 absolute bottom-0">
                                        {{ $vendorDetails->onTimeShipment() }}%</p>
                                </div>
                            </div>

                            <div class="w-1/3">
                                <div class="relative h-75p px-2 rtl:border-r">
                                    <p class="text-gray-10 text-11 roboto-medium font-medium mt-1">
                                        {{ __('Seller Reviews') }}</p>
                                    <p class="text-xl roboto-medium font-medium mt-3 absolute bottom-0">
                                        {{ $vendorReview['total_review'] ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (isset($vendorDetails->shops[0]->name))
                        <a href="{{ route('site.shop', ['alias' => $vendorDetails->shops[0]->alias]) }}"
                            class="process-goto relative flex justify-center text-gray-10 hover:text-gray-12 font-medium text-sm items-center py-2 dm-sans bg-gray-11 border border-t-0 rounded rounded-t-none">
                            <span class="ltr:-ml-5 rtl:-mr-5">{{ __('Go to Store') }}</span>
                            <svg class="relative ltr:ml-2 rtl:mr-2 neg-transition-scale" width="12" height="7"
                                viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M8.08128 0L6.90393 1.05155L8.81279 2.75644H0.832512C0.372728 2.75644 0 3.08934 0 3.5C0 3.91066 0.372728 4.24356 0.832512 4.24356H8.81279L6.90393 5.94845L8.08128 7L12 3.5L8.08128 0Z"
                                    fill="currentColor" />
                            </svg>
                        </a>
                    @endif
                    @auth
                        @if (isActive('Ticket') && preference('chat'))
                            <a href="javascript:void(0)"
                                data-vendor="{{ route('chat.send-product-details', ['code' => $product->code]) }}"
                                class="send-item-message process-goto relative flex justify-center text-gray-10 hover:text-gray-12 font-medium text-sm items-center py-2 dm-sans bg-gray-11 border border-t-0 rounded rounded-t-none">
                                <span class="ltr:-ml-5 rtl:-mr-5">{{ __('Send Message') }}</span>
                                <svg class="relative ltr:ml-2 rtl:mr-2" width="17" height="17"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                </svg>
                            </a>
                        @endif
                    @endauth

                    @doAction('before_signle_product_detail_same_shop_products', $definedData)

                    @include('site.layouts.section.product-details.same-shop')

                    @doAction('after_signle_product_detail_same_shop_products', $definedData)

                @endif
            </div>
        </div>

        @doAction('after_signle_product_detail', $definedData)

    </section>
    <!-- Details section end -->
@endsection
@section('js')
    @php
        $allImage = [];
        foreach ($images as $im) {
            $allImage[] = getBackgroundImage($im);
        }
        $format = getFormatedCountdown();
        $formatSaleTo = date($format, strtotime(strtr($sale_to, ' ', '')));
    @endphp
    <script>
        var itemId = "{{ $id }}";
        var reviewUrl = "{{ route('fetch.review') }}";
        var attributePriceWithId = '{!! json_encode($filterVariation['attributePriceWithId']) !!}';
        var defaultImages = '{!! json_encode($allImage) !!}';
        var slideCounts = {{ count($images) ?? 0 }};
        var possbileVariations = '{!! json_encode($filterVariation['possibleVariation']) !!}';
        var defaultAttributes = '{!! json_encode($default_attributes) !!}';
        itemType = "{{ $type }}";
        isManageStock = "{{ $manage_stocks }}";
        stockQty = "{{ $stock_quantity }}";
        var offerFlag = "{{ $offerFlag }}";
        var formatedSaleTo = "{{ $formatSaleTo }}";
        var initialTab = "{{ $initialTab }}";
        var ratingTab = "{{ $ratingTab }}";
        backOrders = "{{ $backorders }}";
        var stockHide = "{{ $stock_hide }}";
        var featured = "{{ isset($featured) ? 1 : 0 }}";
        var reviewAvg = "{{ $review_average }}";
        var rattingRequired = "{{ preference('rating_required') }}";
        let oldCountry = "{!! 'null' !!}";
        let oldState = "{!! 'null' !!}";
        let oldCity = "{!! 'null' !!}";
        var messurementWeight = "{{ preference('measurement_weight') }}";
        var messurementDimension = "{{ preference('measurement_dimension') }}";
        var stockDisplayFormat = "{{ preference('stock_display_format') }}";
        isGroupProduct = "{{ $product->isGroupedProduct() }}";
        tempIsGroupProduct = isGroupProduct;
        tempItemType = "{{ $type }}";
        var videoExtensions = @json(getFileExtensions(6));
    </script>
    <!-- Product Tracking Script JS -->
    @includeIf ('externalcode::layouts.scripts.productDetailsScript')
    <script src="{{ asset('public/frontend/assets/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/flatpickr.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/wishlist.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/compare.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/description-tabs.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/jquery.blockUI.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/product-details.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/delivery-address.min.js') }}"></script>
@endsection
