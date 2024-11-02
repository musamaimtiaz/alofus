@extends('../site/layouts.app')
@section('page_title', __('Cart'))
@section('content')
    @php
        $carts = \App\Cart\Cart::cartCollection()->sortKeys();
    @endphp
    <!-- order-summary start -->
    <section class="mx-4 lg:mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92">
        <nav class="text-gray-600 text-sm mt-5 md:mt-30p" aria-label="Breadcrumb">
            <ol class="list-none p-0 inline-flex text-xs md:text-sm roboto-medium font-medium text-gray-10">
                <li class="flex items-center">
                    @include('site.layouts.includes.svg.home')
                    <a href="{{ route('site.index') }}">{{ __('Home') }}</a>
                    <p class="px-7p">/</p>
                </li>
                <li class="flex items-center">
                    <a class="text-gray-12" href="{{ route('site.cart') }}">{{ __('Cart') }}</a>
                </li>
            </ol>
        </nav>
        @include('site.layouts.includes.order_steps', ['stepsNumber' => 1])
    </section>

    <section class="text-gray-600 body-font relative mx-4 lg:mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92 mt-11 md:mt-80p"
        id="cart-details-container">
        <div class="md:flex sm:flex-nowrap flex-wrap md:pt-8">
            <div class="md:w-2/3 overflow-hidden flex justify-start relative mb-10 rtl-direction-space-left-cart">
                <div class="bg-white dark:bg-gray-2 rounded shadow w-full ltr:md:pr-6 rtl:md:pl-6">
                    <!--  ToastBar  -->
                    <div class="w-full dark:text-gray-2 flex items-center" id="couponMsg">
                    </div>
                    <!-- Order Summary  -->
                    <div id="cart-items">
                        <h3 class="text-sm md:text-xl font-medium dm-sans text-gray-12">
                            {{ __('Select the items you want to buy') }}</h3>
                        @if (count($carts) > 0)
                            <!--     BOX     -->
                            <div class="border rounded vendor-select px-5 py-3 mt-15p md:mt-30p flex items-center justify-between mx-1.5 md:mx-0"
                                id="selecAllBox">
                                <label class="c-check -mt-0.5">
                                    <input type="checkbox" class="form-checkbox -mt-0.5 neg-transition-scale" id="cart-select-all"
                                        {{ $selectAllDisable == true ? 'disabled' : '' }}>
                                    <span class="text-xs md:text-sm text-gray-10 dm-sans font-medium">{{ __('Select All') }}
                                        (<span id="totalCartitemPage">{{ $carts->count() }}</span> {{ __('Products') }})
                                    </span>
                                </label>
                                <button class="text-xl flex justify-center items-center" id="delete-selected-item">
                                    <p class="text-xs md:text-sm dm-sans text-gray-10">{{ __('Delete All') }}</p>
                                    <svg class="ltr:ml-1.5 rtl:mr-1.5" width="11" height="12" viewBox="0 0 11 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M4.27713 8.55566C3.93962 8.55566 3.66602 8.28206 3.66602 7.94455L3.66602 6.11122C3.66602 5.77371 3.93962 5.50011 4.27713 5.50011C4.61463 5.50011 4.88824 5.77371 4.88824 6.11122L4.88824 7.94455C4.88824 8.28206 4.61463 8.55566 4.27713 8.55566Z"
                                            fill="#898989" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M6.72244 8.55566C6.38493 8.55566 6.11133 8.28206 6.11133 7.94455L6.11133 6.11122C6.11133 5.77371 6.38493 5.50011 6.72244 5.50011C7.05995 5.50011 7.33355 5.77371 7.33355 6.11122L7.33355 7.94455C7.33355 8.28206 7.05995 8.55566 6.72244 8.55566Z"
                                            fill="#898989" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0.627147 3.67726C0.482326 3.66738 0.293103 3.66705 0 3.66705V2.44483C0.00653662 2.44483 0.0130517 2.44482 0.0195452 2.44482C0.0326672 2.44482 0.0457011 2.44482 0.0586465 2.44483H10.9414C10.9543 2.44482 10.9673 2.44482 10.9805 2.44482L11 2.44483V3.66705C10.7069 3.66705 10.5177 3.66738 10.3729 3.67726C10.2335 3.68677 10.1805 3.70303 10.155 3.71357C10.0053 3.77559 9.88632 3.89456 9.8243 4.0443C9.81376 4.06973 9.7975 4.12279 9.78799 4.26212C9.77811 4.40694 9.77778 4.59617 9.77778 4.88927L9.77778 8.59615C9.77781 9.1379 9.77784 9.60468 9.72758 9.97848C9.67372 10.3791 9.55227 10.7631 9.24081 11.0745C8.92935 11.386 8.54535 11.5074 8.14476 11.5613C7.77097 11.6115 7.30419 11.6115 6.76245 11.6115H4.23755C3.6958 11.6115 3.22903 11.6115 2.85524 11.5613C2.45465 11.5074 2.07065 11.386 1.75919 11.0745C1.44773 10.7631 1.32628 10.3791 1.27242 9.97848C1.22216 9.60468 1.22219 9.13791 1.22222 8.59616L1.22222 4.88927C1.22222 4.59617 1.22189 4.40694 1.21201 4.26212C1.2025 4.12279 1.18624 4.06973 1.1757 4.0443C1.11368 3.89456 0.994713 3.77559 0.844973 3.71357C0.819543 3.70303 0.766479 3.68677 0.627147 3.67726ZM8.66116 3.66705H2.33884C2.39616 3.8367 2.41972 4.00783 2.4314 4.17892C2.44446 4.37036 2.44445 4.60166 2.44444 4.86972L2.44444 8.55594C2.44444 9.14937 2.44574 9.53297 2.48374 9.81562C2.51938 10.0807 2.57691 10.1638 2.62343 10.2103C2.66996 10.2568 2.75303 10.3143 3.0181 10.35C3.30074 10.388 3.68434 10.3893 4.27778 10.3893H6.72222C7.31566 10.3893 7.69926 10.388 7.9819 10.35C8.24697 10.3143 8.33004 10.2568 8.37656 10.2103C8.42309 10.1638 8.48062 10.0807 8.51626 9.81562C8.55426 9.53297 8.55556 9.14937 8.55556 8.55594V4.86972C8.55555 4.60166 8.55554 4.37036 8.5686 4.17892C8.58028 4.00783 8.60384 3.8367 8.66116 3.66705Z"
                                            fill="#898989" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M6.3585 0.0740851C6.09941 0.0243837 5.79831 0 5.49933 0C5.20035 3.64251e-08 4.89924 0.0243837 4.64015 0.0740852C4.51063 0.0989319 4.38382 0.131564 4.26894 0.174548C4.16459 0.213591 4.02227 0.27841 3.90185 0.390756C3.65508 0.621001 3.64168 1.0077 3.87192 1.25448C4.08919 1.48735 4.44577 1.5124 4.69264 1.32102C4.69404 1.32048 4.69558 1.31989 4.69724 1.31927C4.72984 1.30707 4.78648 1.29052 4.87042 1.27442C5.03823 1.24223 5.2602 1.22222 5.49933 1.22222C5.73845 1.22222 5.96042 1.24223 6.12824 1.27442C6.21217 1.29052 6.26881 1.30707 6.30142 1.31927C6.30308 1.31989 6.30461 1.32048 6.30602 1.32102C6.55288 1.5124 6.90946 1.48734 7.12673 1.25448C7.35697 1.0077 7.34357 0.621 7.0968 0.390755C6.97639 0.27841 6.83407 0.213591 6.72972 0.174548C6.61483 0.131564 6.48802 0.0989318 6.3585 0.0740851Z"
                                            fill="#898989" />
                                    </svg>
                                </button>
                            </div>
                        @endif
                        @if (count($cartData) > 0)
                            @foreach ($cartData->groupBy('vendor_id') as $key => $cartData)
                                @php
                                    $estimateTime = '';
                                    if (isset($cartData[0]['vendor_id'])) {
                                        $minDays = $cartData->where('vendor_id', $cartData[0]['vendor_id'])->min('estimated_delivery');
                                        $maxDays = $cartData->where('vendor_id', $cartData[0]['vendor_id'])->max('estimated_delivery');
                                    } else {
                                        $minDays = $cartData->where('vendor_id', null)->min('estimated_delivery');
                                        $maxDays = $cartData->where('vendor_id', null)->max('estimated_delivery');
                                    }

                                    if (!empty($minDays) && !empty($maxDays)) {
                                        $estimateTime = $minDays != $maxDays ? $minDays . " - " . $maxDays . " " . __('days') : $minDays . " " . __('days');
                                    } elseif (!empty($minDays) && empty($maxDays)) {
                                        $estimateTime = $minDays . " " . __('days');
                                    } elseif (empty($minDays) && !empty($maxDays)) {
                                        $estimateTime = $maxDays . " " . __('days');
                                    }
                                @endphp
                                <div class="border my-5 rounded vendor-parent mx-1.5 md:mx-0 vendor-box-before-{{ $cartData[0]['vendor_id'] ?? 0 }}">
                                    @if (isset($vendors[$cartData[0]['vendor_id']]))
                                        <div class="vendor-area rounded-t px-5 py-3 flex items-center justify-between shop-box bg-gray-11">
                                            <label class="flex items-center c-check">
                                                <input type="checkbox" class="form-checkbox cart-shop neg-transition-scale" data-shop_id="{{ $cartData[0]['shop_id'] }}" data-vendor_id="{{ $cartData[0]['vendor_id'] ?? null }}"
                                                    {{ \App\Models\Product::isVendorSelected($cartData[0]['vendor_id']) ? 'disabled' : '' }}>
                                                <span class="text-sm dm-sans font-medium text-gray-12  ltr:ml-3 rtl:mr-3">{{ $vendors[$cartData[0]['vendor_id']] }}</span>
                                            </label>
                                            <p class="text-xs text-gray-12 dm-sans">
                                                {{ $estimateTime }}
                                            </p>
                                        </div>
                                    @else
                                        <div class="vendor-area rounded-t px-5 py-3 flex items-center justify-between shop-box bg-gray-11">
                                            <label class="flex items-center c-check">
                                              <input type="checkbox" class="form-checkbox hide-checkbox cart-shop" data-vendor_id="0">
                                            </label>
                                            <p class="text-xs text-gray-12 dm-sans">
                                                {{ $estimateTime }}
                                            </p>
                                        </div>
                                    @endif
                                    <div class="vendor-block">
                                        @foreach ($cartData as $cart)
                                            <div class="rounded-t-none w-full rounded px-2.5 md:px-5 items-center grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 cart-item-header pb-15p md:pb-0"
                                                id="cart-item-{{ $cart['index'] }}">
                                                <div
                                                    class="col-span-1 md:col-span-2 grid grid-cols-3 md:grid-cols-3 pb-2 md:pb-4 items-center">
                                                    <div class="c-check mt-4">
                                                        <div class="flex items-center check-bg">
                                                            <input type="checkbox" name="items[]"
                                                                {{ in_array($cart['index'], $selectedCarts) && $cart['availability'] == 1 && $cart['inventoryEnable'] == true ? 'checked' : '' }}
                                                                {{ $cart['availability'] == 0 || $cart['inventoryEnable'] == false ? 'disabled' : '' }}
                                                                value="{{ $cart['index'] }}"
                                                                class="neg-transition-scale form-checkbox cart-item-single cart-vendor-{{ $cart['vendor_id'] != null ? $cart['vendor_id'] : 0 }}"
                                                                data-price="{{ $cart['price'] }}"
                                                                data-quantity="{{ $cart['quantity'] }}"
                                                                data-shop_id="{{ $cart['shop_id'] != null ? $cart['shop_id'] : 0 }}"
                                                                data-index="{{ $cart['index'] }}"
                                                                data-tax="{{ $cart['tax_rate'] }}"
                                                                data-shipping="{{ $cart['shipping'] }}">
                                                            <div
                                                                class="flex items-center sm:w-24 sm:h-24 w-68p h-68p md:w-20 md:h-20 md:m-3 border rounded  ltr:ml-2 rtl:md:ml-3 rtl:mr-2 rtl:md:mr-3">
                                                                <img class="w-full h-full object-cover neg-transition-scale"
                                                                    src="{{ $cart['photo'] }}" class="w-full p-2">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-span-2 mt-4">
                                                        <div
                                                            class="md:mt-2 ltr:x:pl-4 ltr:xs:pl-0 ltr:xxs:-ml-19% ltr:xxs:pl-6 ltr:sm:-ml-19% ltr:pl-4 ltr:md:ml-0 ltr:md:pl-8 ltr:lg:pl-5 ltr:xl:pl-6 ltr:2xl:pl-2 rtl:x:pr-4 rtl:xs:pr-0 rtl:xxs:-mr-19% rtl:xxs:pr-6 rtl:sm:-mr-19% rtl:pr-4 rtl:md:mr-0 rtl:md:pr-8 rtl:lg:pr-5 rtl:xl:pr-6 rtl:2xl:pr-2">
                                                            <h3
                                                                class="text-xs md:text-15 dm-sans font-medium text-gray-12 leading-5">
                                                                <a
                                                                    href="{{ route('site.productDetails', ['slug' => $cart['type'] == 'Variable Product' ? $cart['parent_slug'] : $cart['slug']]) }}">{{ $cart['name'] }}</a>
                                                            </h3>
                                                            @if ($cart['type'] == 'Variable Product')
                                                                <div class="md:-mt-0 -mt-1.5">
                                                                    @php
                                                                        $variationMeta = (array) json_decode($cart['variation_meta']);
                                                                        $commaCount = 0;
                                                                    @endphp
                                                                    @if ($variationMeta != null && count($variationMeta) > 0)
                                                                        @foreach ($variationMeta as $metaKey => $name)
                                                                            @php $commaCount++ @endphp
                                                                            @if ($loop->iteration == 1)
                                                                                <span
                                                                                    class="text-gray-10 text-xss md:text-xs roboto-medium {{ $loop->last ? ' ' : 'border-r' }} ltr:pr-1 rtl:pl-1">
                                                                                    {{ $metaKey . ' : ' . $name }}
                                                                                    {{ count($variationMeta) < $commaCount ? ',' : '' }}
                                                                                </span>
                                                                            @else
                                                                                <span
                                                                                    class="text-gray-10 text-xss md:text-xs roboto-medium {{ $loop->last ? ' ' : 'border-r' }} ltr:pr-1 ltr:pl-1.5 rtl:pl-1 rtl:pr-1.5">
                                                                                    {{ $metaKey . ' : ' . $name }}
                                                                                    {{ count($variationMeta) < $commaCount ? ',' : '' }}
                                                                                </span>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            @endif
                                                            <h4 class="text-sm font-medium dm-sans text-gray-12">
                                                                <span></span><span
                                                                    class="cart-item-price">{{ formatNumber($cart['price']) }}</span>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="w-full flex justify-between items-center md:justify-center md:mt-4">
                                                    <div class="flex flex-wrap justify-start gap-x-5 ltr:pl-6 ltr:ml-28% ltr:xxs:pl-2.5 ltr:xxs:ml-23% ltr:sm:pl-0 ltr:sm:ml-23% ltr:md:ml-0 ltr:md:pl-0 rtl:pr-6 rtl:mr-28% rtl:xxs:pr-2.5 rtl:xxs:mr-23% rtl:sm:pr-0 rtl:sm:mr-23% rtl:md:mr-0 rtl:md:pr-0">
                                                        <div class="flex flex-wrap text-xl border rounded md:mb-2.5 lg:mb-0 ltr:md:-ml-19% ltr:lg:ml-0 rtl:md:-mr-19% rtl:lg:mr-0">
                                                            @if ($cart['is_individual_sale'] == 0)
                                                                <a href="javascript:void(0)"
                                                                    class="flex items-center justify-center cart-page-item-qty-dec m-auto text-2xl font-thin text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-7 md:h-9 w-8 cursor-pointer outline-none text-center  ltr:rounded-l rtl:rounded-r"
                                                                    data-itemId="{{ $cart['id'] }}"
                                                                    data-index="{{ $cart['index'] }}"
                                                                    data-price="{{ $cart['price'] }}"
                                                                    data-type="{{ $cart['type'] }}"
                                                                    data-code="{{ $cart['code'] }}"
                                                                    data-parent_code="{{ $cart['parent_code'] }}">
                                                                    <span class="inline-block">
                                                                        <svg width="9" height="2"
                                                                            viewBox="0 0 9 2" fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                                d="M9 1.2H0L0 0H9V1.2Z" fill="#2C2C2C" />
                                                                        </svg>
                                                                    </span>
                                                                </a>
                                                            @endif
                                                            <div class="h-7 md:h-9 w-9 cart-item-quantity dm-sans font-medium text-sm text-gray-12 flex items-center justify-center">
                                                                <p>
                                                                    {{ $cart['quantity'] }}
                                                                </p>
                                                            </div>
                                                            @if ($cart['is_individual_sale'] == 0)
                                                                <a href="javascript:void(0)"
                                                                    class="flex items-center justify-center cart-page-item-qty-inc text-2xl font-thin text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-7 md:h-9 w-8 cursor-pointer ltr:rounded-r rtl:rounded-l"
                                                                    data-itemId="{{ $cart['id'] }}"
                                                                    data-index="{{ $cart['index'] }}"
                                                                    data-price="{{ $cart['price'] }}"
                                                                    data-type="{{ $cart['type'] }}"
                                                                    data-code="{{ $cart['code'] }}"
                                                                    data-parent_code="{{ $cart['parent_code'] }}">
                                                                    <span class="inline-block">
                                                                        <svg width="10" height="10"
                                                                            viewBox="0 0 10 10" fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                                d="M5.2 -5.24537e-08L5.2 9.2L4 9.2L4 0L5.2 -5.24537e-08Z"
                                                                                fill="#2C2C2C" />
                                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                                d="M9.19922 5.2L-0.000782065 5.2L-0.000782013 4L9.19922 4L9.19922 5.2Z"
                                                                                fill="#2C2C2C" />
                                                                        </svg>
                                                                    </span>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <button class="md:hidden text-gray-12 px-1 delete-cart-item"
                                                        data-index="{{ $cart['index'] }}">
                                                        <svg width="14" height="15" viewBox="0 0 11 12"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M4.27713 8.55566C3.93962 8.55566 3.66602 8.28206 3.66602 7.94455L3.66602 6.11122C3.66602 5.77371 3.93962 5.50011 4.27713 5.50011C4.61463 5.50011 4.88824 5.77371 4.88824 6.11122L4.88824 7.94455C4.88824 8.28206 4.61463 8.55566 4.27713 8.55566Z"
                                                                fill="#898989" />
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M6.72244 8.55566C6.38493 8.55566 6.11133 8.28206 6.11133 7.94455L6.11133 6.11122C6.11133 5.77371 6.38493 5.50011 6.72244 5.50011C7.05995 5.50011 7.33355 5.77371 7.33355 6.11122L7.33355 7.94455C7.33355 8.28206 7.05995 8.55566 6.72244 8.55566Z"
                                                                fill="#898989" />
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M0.627147 3.67775C0.482326 3.66787 0.293103 3.66754 0 3.66754V2.44531C0.00653662 2.44531 0.0130517 2.44531 0.0195452 2.44531C0.0326672 2.44531 0.0457011 2.44531 0.0586465 2.44531H10.9414C10.9543 2.44531 10.9673 2.44531 10.9805 2.44531L11 2.44531V3.66754C10.7069 3.66754 10.5177 3.66787 10.3729 3.67775C10.2335 3.68725 10.1805 3.70352 10.155 3.71405C10.0053 3.77608 9.88632 3.89505 9.8243 4.04478C9.81376 4.07022 9.7975 4.12328 9.78799 4.26261C9.77811 4.40743 9.77778 4.59665 9.77778 4.88976L9.77778 8.59664C9.77781 9.13839 9.77784 9.60517 9.72758 9.97896C9.67372 10.3796 9.55227 10.7635 9.24081 11.075C8.92935 11.3865 8.54535 11.5079 8.14476 11.5618C7.77097 11.612 7.30419 11.612 6.76245 11.612H4.23755C3.6958 11.612 3.22903 11.612 2.85524 11.5618C2.45465 11.5079 2.07065 11.3865 1.75919 11.075C1.44773 10.7635 1.32628 10.3796 1.27242 9.97896C1.22216 9.60517 1.22219 9.1384 1.22222 8.59665L1.22222 4.88976C1.22222 4.59665 1.22189 4.40743 1.21201 4.26261C1.2025 4.12328 1.18624 4.07022 1.1757 4.04478C1.11368 3.89505 0.994713 3.77608 0.844973 3.71405C0.819543 3.70352 0.766479 3.68725 0.627147 3.67775ZM8.66116 3.66754H2.33884C2.39616 3.83718 2.41972 4.00832 2.4314 4.17941C2.44446 4.37085 2.44445 4.60215 2.44445 4.87021L2.44444 8.55642C2.44444 9.14986 2.44574 9.53346 2.48374 9.81611C2.51938 10.0812 2.57691 10.1642 2.62343 10.2108C2.66996 10.2573 2.75303 10.3148 3.0181 10.3505C3.30074 10.3885 3.68434 10.3898 4.27778 10.3898H6.72222C7.31566 10.3898 7.69926 10.3885 7.9819 10.3505C8.24697 10.3148 8.33004 10.2573 8.37657 10.2108C8.42309 10.1642 8.48062 10.0812 8.51626 9.81611C8.55426 9.53346 8.55556 9.14986 8.55556 8.55642V4.87021C8.55555 4.60215 8.55554 4.37085 8.5686 4.17941C8.58028 4.00832 8.60384 3.83718 8.66116 3.66754Z"
                                                                fill="#898989" />
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M6.3585 0.0740851C6.09941 0.0243837 5.79831 0 5.49933 0C5.20035 3.64251e-08 4.89924 0.0243837 4.64015 0.0740852C4.51063 0.0989319 4.38382 0.131564 4.26894 0.174548C4.16459 0.213591 4.02227 0.27841 3.90185 0.390756C3.65508 0.621001 3.64168 1.0077 3.87192 1.25448C4.08919 1.48735 4.44577 1.5124 4.69264 1.32102C4.69404 1.32048 4.69558 1.31989 4.69724 1.31927C4.72984 1.30707 4.78649 1.29052 4.87042 1.27442C5.03823 1.24223 5.2602 1.22222 5.49933 1.22222C5.73845 1.22222 5.96042 1.24223 6.12824 1.27442C6.21217 1.29052 6.26881 1.30707 6.30142 1.31927C6.30308 1.31989 6.30461 1.32048 6.30602 1.32102C6.55288 1.5124 6.90946 1.48734 7.12673 1.25448C7.35697 1.0077 7.34357 0.621 7.0968 0.390755C6.97639 0.27841 6.83407 0.213591 6.72972 0.174548C6.61483 0.131564 6.48802 0.0989318 6.3585 0.0740851Z"
                                                                fill="#898989" />
                                                        </svg>
                                                    </button>
                                                </div>

                                                <div class="ltr:pl-8 rtl:pr-8">
                                                    <div class="md:flex md:items-end lg:flex-col items-center ltr:md:-ml-14 ltr:lg:ml-0 rtl:md:-mr-14 rtl:lg:mr-0">
                                                        @if (preference('wishlist'))
                                                            @php
                                                                $active = false;
                                                                if (auth()->user()) {
                                                                    foreach (auth()->user()->wishlist as $key => $wishlist) {
                                                                        if ($cart['id'] == $wishlist->product_id) {
                                                                            $active = true;
                                                                        }
                                                                    }
                                                                }
                                                            @endphp
                                                            <div class="md:flex md:pb-0 lg:pb-2 hidden whitespace-nowrap">
                                                                <div class="flex items-center cursor-pointer w-6 h-6 p-1 text-transparent mt-1 wishlist md:border-r lg:border-none  ltr:lg:pr-0 rtl:lg:pl-0"
                                                                    data-id="{{ $cart['id'] }}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="23"
                                                                        height="23"
                                                                        class="{{ $active ? 'color_fill svg-bg ' : 'text-gray-10' }}"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                                                        </path>
                                                                    </svg>
                                                                </div>
                                                                <p class="roboto-medium text-xs text-gray-10  mt-2 ltr:pl-1 rtl:pr-1">
                                                                    {{ __('Save for later') }}
                                                                </p>
                                                            </div>
                                                        @endif

                                                        <div class="md:flex md:border-t-0 lg:border-t md:pt-0 lg:pt-2 hidden whitespace-nowrap  ltr:md:ml-4 rtl:md:mr-4">
                                                            <button
                                                                class="flex text-gray-12 px-1 delete-cart-item md:mt-0 lg:mt-1"
                                                                data-index="{{ $cart['index'] }}">
                                                                <svg width="16" height="17" viewBox="0 0 16 17"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M6.02924 12.0576C5.55357 12.0576 5.16797 11.672 5.16797 11.1963L5.16797 8.61252C5.16797 8.13685 5.55357 7.75124 6.02924 7.75124C6.50491 7.75124 6.89052 8.13685 6.89052 8.61252L6.89052 11.1963C6.89052 11.672 6.50491 12.0576 6.02924 12.0576Z"
                                                                        fill="#898989" />
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M9.47456 12.0576C8.99889 12.0576 8.61328 11.672 8.61328 11.1963L8.61328 8.61252C8.61328 8.13685 8.99889 7.75124 9.47456 7.75124C9.95022 7.75124 10.3358 8.13685 10.3358 8.61252L10.3358 11.1963C10.3358 11.672 9.95023 12.0576 9.47456 12.0576Z"
                                                                        fill="#898989" />
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M0.883875 5.18226C0.67977 5.16833 0.413088 5.16786 0 5.16786V3.44531C0.00921245 3.44531 0.0183945 3.44531 0.0275462 3.44531C0.0460398 3.44531 0.0644092 3.44531 0.082654 3.44531H15.4203C15.4385 3.44531 15.4569 3.44531 15.4754 3.44531L15.5029 3.44531V5.16786C15.0899 5.16786 14.8232 5.16833 14.6191 5.18226C14.4227 5.19565 14.3479 5.21858 14.3121 5.23342C14.101 5.32084 13.9334 5.48851 13.846 5.69954C13.8311 5.73538 13.8082 5.81017 13.7948 6.00654C13.7809 6.21064 13.7804 6.47732 13.7804 6.89041L13.7804 12.1147C13.7804 12.8783 13.7805 13.5361 13.7097 14.0629C13.6337 14.6275 13.4626 15.1687 13.0236 15.6077C12.5847 16.0466 12.0435 16.2178 11.4789 16.2937C10.9521 16.3645 10.2942 16.3645 9.53072 16.3644H5.97222C5.20871 16.3645 4.55086 16.3645 4.02406 16.2937C3.45948 16.2178 2.91829 16.0466 2.47933 15.6077C2.04037 15.1687 1.8692 14.6275 1.7933 14.0629C1.72247 13.5361 1.7225 12.8783 1.72255 12.1148L1.72255 6.89041C1.72255 6.47732 1.72208 6.21064 1.70816 6.00654C1.69476 5.81017 1.67183 5.73538 1.65699 5.69954C1.56957 5.48851 1.40191 5.32084 1.19087 5.23342C1.15503 5.21858 1.08024 5.19565 0.883875 5.18226ZM12.2067 5.16786H3.29627C3.37705 5.40696 3.41026 5.64815 3.42671 5.88928C3.44512 6.15908 3.44511 6.48506 3.4451 6.86286L3.4451 12.0581C3.4451 12.8944 3.44693 13.4351 3.50048 13.8334C3.55071 14.207 3.6318 14.3241 3.69736 14.3896C3.76292 14.4552 3.88001 14.5363 4.25358 14.5865C4.65193 14.6401 5.19256 14.6419 6.02892 14.6419H9.47402C10.3104 14.6419 10.851 14.6401 11.2494 14.5865C11.6229 14.5363 11.74 14.4552 11.8056 14.3896C11.8711 14.3241 11.9522 14.207 12.0025 13.8334C12.056 13.4351 12.0578 12.8944 12.0578 12.0581V6.86286C12.0578 6.48506 12.0578 6.15908 12.0762 5.88928C12.0927 5.64815 12.1259 5.40696 12.2067 5.16786Z"
                                                                        fill="#898989" />
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M8.96309 0.104413C8.59794 0.0343653 8.17358 0 7.75221 0C7.33084 5.1336e-08 6.90648 0.0343654 6.54133 0.104413C6.35878 0.139431 6.18006 0.185421 6.01815 0.246001C5.87108 0.301027 5.6705 0.39238 5.5008 0.550715C5.153 0.875213 5.13412 1.42022 5.45862 1.76801C5.76482 2.0962 6.26738 2.13152 6.61529 1.8618C6.61728 1.86102 6.61944 1.8602 6.62178 1.85932C6.66773 1.84213 6.74756 1.81881 6.86585 1.79612C7.10237 1.75074 7.4152 1.72255 7.75221 1.72255C8.08922 1.72255 8.40205 1.75074 8.63857 1.79612C8.75686 1.81881 8.83669 1.84213 8.88264 1.85932C8.88498 1.8602 8.88714 1.86102 8.88913 1.8618C9.23704 2.13152 9.7396 2.0962 10.0458 1.76801C10.3703 1.42021 10.3514 0.875212 10.0036 0.550714C9.83392 0.392379 9.63334 0.301026 9.48627 0.246001C9.32436 0.185421 9.14564 0.13943 8.96309 0.104413Z"
                                                                        fill="#898989" />
                                                                </svg>
                                                                <p class="roboto-medium text-xs text-gray-10 mt-0.5 md:block hidden  ltr:pl-1 rtl:pr-1">
                                                                    {{ __('Delete item') }}
                                                                </p>
                                                            </button>
                                                        </div>
                                                        @if ($cart['availability'] == 0 || $cart['inventoryEnable'] == false)
                                                            <div
                                                                class="md:flex md:border-t-0 lg:border-t md:pt-0 lg:pt-2 hidden whitespace-nowrap ltr:md:ml-4 rtl:md:mr-4">
                                                                <p class="roboto-medium text-xs text-red-600 mt-0.5 md:block hidden  ltr:pl-1 rtl:pr-1">
                                                                    {{ __('Not Available.') }}
                                                                </p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h3 class="text-xl mt-4 font-bold dark:text-gray-2 text-center" class="cart-empty">
                                {{ __('Empty!') }}
                            </h3>
                        @endif
                        @if($errors->any())
                            <span class="text-red-300">{{ implode('', $errors->all()) }}</span>
                        @endif

                    </div>
                    <div>
                        <a href="{{ route('site.index') }}"
                            class="flex relative mt-30p arrow-hover font-medium dm-sans text-gray-10 text-base ltr:pl-4 rtl:pr-4">
                            <svg class="mt-2 absolute ltr:mr-3 rtl:ml-3 neg-transition-scale" width="15" height="10" viewBox="0 0 15 10"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.70711 0L6.12132 1.41421L3.82843 3.70711H13.4142C13.9665 3.70711 14.4142 4.15482 14.4142 4.70711C14.4142 5.25939 13.9665 5.70711 13.4142 5.70711H3.82843L6.12132 8L4.70711 9.41421L0 4.70711L4.70711 0Z"
                                    fill="currentColor" />
                            </svg>
                            <span class="ltr:ml-4 rtl:mr-4">{{ __('Continue Shopping') }}</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="md:w-42% lg:w-1/3 flex flex-col w-full mb-10 ltr:md:ml-auto rtl:md:mr-auto">
                <div class="flex justify-between flex-wrap lg:justify-center">
                    <div class="rounded bg-white dark:bg-gray-2 w-full border checked-loader">
                        <div class="w-full px-5 py-5 text-gray-12 font-medium dm-sans">
                            <h3 class="dm-sans text-lg text-gray-12">{{ __('Order Summary') }}</h3>
                            <div class="flex justify-between mt-3 text-sm border-b pb-3">
                                <p>
                                    {{ __('Subtotal') }}
                                </p>
                                <div class='text-right'>
                                    <span id="cart-subtotal">0</span>
                                </div>
                            </div>
                            @if (isActive('Shipping'))
                                <div class="flex justify-between mt-3">
                                    <div id="shipping_method">
                                    </div>
                                </div>
                            @endif

                            @php $couponOffer = 0; @endphp

                            @if (isset($coupon) && !empty($coupon))
                                @php  $couponOffer = $coupon; @endphp
                            @endif

                            @if (isActive('Coupon') && preference('coupons') == 1)
                                <div class="flex justify-between mt-3 display-none couponOffer">
                                    <div class="dm-sans text-sm text-gray-12 font-medium">
                                        {{ __('Coupon offer') }}
                                    </div>
                                    <div class='dm-sans text-sm text-gray-12 font-medium'><span
                                            id="couponOffer">{{ formatCurrencyAmount($couponOffer) }}</span></div>
                                </div>
                            @endif

                            @if (preference("taxes") == 1)
                                <div id="customTax">
                                    <div class="flex justify-between mt-3">
                                        <div class="text-sm">{{ __('Tax') }}</div>
                                        <div class='text-sm text-right'><span class="customTax"></span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="flex justify-between mt-3 border-t">
                                <div class="text-base md:text-xl mt-2">
                                    {{ __('Total Amount') }}</div>
                                <div class="text-base mt-2">
                                    <span id="cart-total">{{ formatCurrencyAmount($totalPrice - $couponOffer) }}</span>
                                </div>
                            </div>
                            @if (isActive('Coupon') && preference('coupons') == 1)
                                <div class="mt-10">
                                    <p class="font-hkbold text-secondary text-sm">{{ __('Have a coupon? Apply Now.') }}
                                    </p>
                                    <div class="flex justify-between mt-13p border rounded color_switch_borders">
                                        <input type="text" placeholder="{{ __('Type Coupon Code') }}"
                                            class="w-3/5 xl:w-2/3 focus:outline-none rounded form-input rtl-direction-space text-sm roboto-regular"
                                            id="discount_code">
                                        <div class="py-2 rounded ltr:pr-1.5 rtl:pl-1.5" aria-label="Apply button" id="checkCoupon">
                                            <a href="javascript:void(0)" class="text-white primary-text-hover">
                                                <svg class="neg-transition-scale" width="34" height="34" viewBox="0 0 34 34" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="0.5" y="0.5" width="33" height="33"
                                                        rx="1.5" fill="currentColor" stroke="#DFDFDF" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M19.0813 13L17.9039 14.2018L19.8128 16.1502H11.8325C11.3727 16.1502 11 16.5307 11 17C11 17.4693 11.3727 17.8498 11.8325 17.8498H19.8128L17.9039 19.7982L19.0813 21L23 17L19.0813 13Z"
                                                        fill="#2C2C2C" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                    <label id="checkOutMsg"></label>
                                </div>
                            @endif

                            <div id="applied-coupon"></div>
                            <a href="javascript:void(0)"
                                class="checkOut process-goto relative flex justify-center items-center text-center lg:px-4 md:px-2 px-4 py-4 text-sm md:text-base text-white w-full mt-5 rounded dm-bold font-bold primary-bg-hover hover:text-gray-12 bg-black">
                                <span>{{ __('Proceed to Checkout') }}</span>
                                <svg class="relative neg-transition-scale ltr:ml-2 rtl:mr-2" width="15" height="10" viewBox="0 0 15 10"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M10.1016 0L8.62991 1.50221L11.016 3.93778H1.04064C0.46591 3.93778 0 4.41335 0 5C0 5.58665 0.46591 6.06222 1.04064 6.06222H11.016L8.62991 8.49779L10.1016 10L15 5L10.1016 0Z"
                                        fill="currentColor" />
                                </svg>
                            </a>
                            @php
                                $gateways = (new \Modules\Gateway\Entities\GatewayModule())->payableGateways();
                            @endphp

                            @if (is_array($gateways) && count($gateways) > 0)
                                <div>
                                    <h3 class="font-medium dm-sans text-sm text-gray-10 my-6">
                                        {{ __('Accepted payment method') }}</h3>
                                    <div class="flex flex-wrap gap-x-6 gap-y-2 mt-5 mb-5">
                                        @foreach ($gateways as $gateway)
                                        <div>
                                            <img class="w-16 h-7 m-auto object-contain neg-transition-scale" src="{{ asset(moduleConfig($gateway->alias . '.logo')) }}" alt="{{ __('Image') }}">
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- order-summary end -->
@endsection
@section('js')
    <script src="{{ asset('public/dist/js/custom/site/wishlist.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/jquery.blockUI.min.js') }}"></script>
@endsection
