<div>
    <!-- Qty section -->
    @if (!$product->isGroupedProduct())
        <div class="my-4 flex flex-wrap md:justify-start gap-3 mt-5">
            {{-- not external product --}}
            @if (!$product->isExternalProduct() && isset($meta['individual_sale']) && $meta['individual_sale'] == 0)
                <div class="flex justify-start items-center gap-2 lg:gap-0">
                    <p class="lg:hidden text-sm roboto-medium text-gray-12">{{ __('Quantity') }}:</p>
                    <div class="flex flex-wrap w-36 lg:w-135p h-10 lg:h-54p text-xl border rounded"
                        id="cart-item-details-{{ $code }}">
                        <a href="javascript:void(0)"
                            class="cart-item-qty-dec m-auto text-2xl p-2 flex items-center font-thin text-gray-600 hover:text-gray-700 rounded-l cursor-pointer outline-none md:text-center"
                            data-itemCode={{ $code }}>
                            <span class="inline-block">
                                <svg width="13" height="2" viewBox="0 0 13 2" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13 2H0L0 0H13V2Z"
                                        fill="#898989" />
                                </svg>
                            </span>
                        </a>

                        <div
                            class="flex items-center dm-bold font-bold text-20 text-gray-12 text-center cart-item-quantity">
                            1</div>
                        <a href="javascript:void(0)"
                            class="cart-item-qty-inc m-auto flex items-center text-2xl font-thin text-gray-600 hover:text-gray-700 rounded-r cursor-pointer p-2 md:text-center"
                            data-itemCode={{ $code }}>
                            <span class="inline-block">
                                <svg width="15" height="15" viewBox="0 0 15 15" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M8.87909 -8.02595e-08L8.87909 14.077L7.04297 14.077L7.04297 0L8.87909 -8.02595e-08Z"
                                        fill="#898989" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M15 7.95643L0.923044 7.95642L0.923044 6.1203L15 6.1203L15 7.95643Z"
                                        fill="#898989" />
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            @endif

                {{-- external product --}}
                @if ($product->isExternalProduct())
                    @if (isset($external_products['url']) && $external_products['url'] != '')
                    <div class="w-full">
                        <a href="{{ $external_products['url'] }}" target="_blank">
                            <button
                                class="primary-bg-color font-bold w-full h-54p py-3 2xl:p-2 rounded flex justify-center items-center">
                                <svg class="text-gray-12" width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.88135 10C5.32906 10 4.88135 9.55228 4.88135 9L4.88135 5C4.88135 2.23858 7.11992 -1.25946e-06 9.88135 -6.82991e-07C12.6428 -1.0602e-06 14.8813 2.23858 14.8813 5L14.8813 9C14.8813 9.55228 14.4336 10 13.8813 10C13.3291 10 12.8813 9.55228 12.8813 9L12.8813 5C12.8813 3.34315 11.5382 2 9.88135 2C8.22449 2 6.88135 3.34314 6.88135 5L6.88135 9C6.88135 9.55228 6.43363 10 5.88135 10Z" fill="currentColor"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.49955 5C5.52029 5 5.5411 5 5.56198 5L14.2634 5C15.0834 4.99996 15.7934 4.99991 16.3668 5.07436C16.983 5.15438 17.5746 5.33421 18.0725 5.79236C18.5704 6.25051 18.7988 6.82513 18.9297 7.4326C19.0515 7.99774 19.1104 8.70533 19.1785 9.52254L19.6975 15.7509C19.6991 15.77 19.7007 15.7891 19.7023 15.8081C19.7404 16.2651 19.7772 16.7051 19.7573 17.069C19.7351 17.4768 19.6367 17.9518 19.2664 18.3542C18.8961 18.7567 18.431 18.8941 18.0264 18.9502C17.6654 19.0002 17.2239 19.0001 16.7653 19C16.7462 19 16.727 19 16.7079 19H3.05505C3.03587 19 3.01671 19 2.99759 19C2.53902 19.0001 2.09749 19.0002 1.73653 18.9502C1.33195 18.8941 0.866803 18.7567 0.496488 18.3542C0.126173 17.9518 0.0278088 17.4768 0.00556347 17.069C-0.0142834 16.7051 0.0224672 16.2651 0.0606358 15.8081C0.0622278 15.7891 0.0638222 15.77 0.0654151 15.7509L0.579256 9.58478C0.58099 9.56397 0.582717 9.54323 0.584438 9.52256C0.652492 8.70535 0.711417 7.99775 0.833217 7.4326C0.964137 6.82513 1.19247 6.25051 1.69039 5.79236C2.18831 5.33421 2.77991 5.15438 3.39615 5.07436C3.96946 4.99991 4.67951 4.99996 5.49955 5ZM3.6537 7.05771C3.25295 7.10975 3.12078 7.19404 3.04461 7.26412C2.96844 7.33421 2.87347 7.45892 2.78833 7.85396C2.69715 8.27703 2.64713 8.85352 2.57235 9.75087L2.05851 15.917C2.01383 16.4531 1.99123 16.7516 2.00259 16.96C2.00274 16.9627 2.00289 16.9654 2.00305 16.968C2.00562 16.9684 2.00825 16.9687 2.01093 16.9691C2.21772 16.9977 2.51706 17 3.05505 17H16.7079C17.2458 17 17.5452 16.9977 17.752 16.9691C17.7547 16.9687 17.7573 16.9684 17.7599 16.968C17.76 16.9654 17.7602 16.9627 17.7603 16.96C17.7717 16.7516 17.7491 16.4531 17.7044 15.917L17.1906 9.75087C17.1158 8.85352 17.0658 8.27703 16.9746 7.85396C16.8894 7.45892 16.7945 7.33421 16.7183 7.26412C16.6421 7.19404 16.51 7.10975 16.1092 7.05771C15.68 7.00198 15.1014 7 14.2009 7H5.56198C4.66152 7 4.08288 7.00198 3.6537 7.05771Z" fill="currentColor"/>
                                </svg>
                                <span class="ltr:pl-2 rtl:pr-2 p-5p dm-bold font-bold text-gray-12 text-lg">{{ isset($external_products['text']) && !empty($external_products['text']) ? $external_products['text'] : __('Buy Product') }}</span>
                            </button>
                        </a>
                    </div>
                    @endif
                @else
                    <a href="javascript:void(0)" class="add-to-cart cart-details-page" id="item-add-to-cart"
                        data-itemCode={{ $code }}>
                        <button
                            class="primary-bg-color font-bold py-2 px-12 rounded flex justify-center items-center">
                            <svg class="text-gray-12" width="20" height="19" viewBox="0 0 20 19" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M5.88135 10C5.32906 10 4.88135 9.55228 4.88135 9L4.88135 5C4.88135 2.23858 7.11992 -1.25946e-06 9.88135 -6.82991e-07C12.6428 -1.0602e-06 14.8813 2.23858 14.8813 5L14.8813 9C14.8813 9.55228 14.4336 10 13.8813 10C13.3291 10 12.8813 9.55228 12.8813 9L12.8813 5C12.8813 3.34315 11.5382 2 9.88135 2C8.22449 2 6.88135 3.34314 6.88135 5L6.88135 9C6.88135 9.55228 6.43363 10 5.88135 10Z"
                                    fill="currentColor" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M5.49955 5C5.52029 5 5.5411 5 5.56198 5L14.2634 5C15.0834 4.99996 15.7934 4.99991 16.3668 5.07436C16.983 5.15438 17.5746 5.33421 18.0725 5.79236C18.5704 6.25051 18.7988 6.82513 18.9297 7.4326C19.0515 7.99774 19.1104 8.70533 19.1785 9.52254L19.6975 15.7509C19.6991 15.77 19.7007 15.7891 19.7023 15.8081C19.7404 16.2651 19.7772 16.7051 19.7573 17.069C19.7351 17.4768 19.6367 17.9518 19.2664 18.3542C18.8961 18.7567 18.431 18.8941 18.0264 18.9502C17.6654 19.0002 17.2239 19.0001 16.7653 19C16.7462 19 16.727 19 16.7079 19H3.05505C3.03587 19 3.01671 19 2.99759 19C2.53902 19.0001 2.09749 19.0002 1.73653 18.9502C1.33195 18.8941 0.866803 18.7567 0.496488 18.3542C0.126173 17.9518 0.0278088 17.4768 0.00556347 17.069C-0.0142834 16.7051 0.0224672 16.2651 0.0606358 15.8081C0.0622278 15.7891 0.0638222 15.77 0.0654151 15.7509L0.579256 9.58478C0.58099 9.56397 0.582717 9.54323 0.584438 9.52256C0.652492 8.70535 0.711417 7.99775 0.833217 7.4326C0.964137 6.82513 1.19247 6.25051 1.69039 5.79236C2.18831 5.33421 2.77991 5.15438 3.39615 5.07436C3.96946 4.99991 4.67951 4.99996 5.49955 5ZM3.6537 7.05771C3.25295 7.10975 3.12078 7.19404 3.04461 7.26412C2.96844 7.33421 2.87347 7.45892 2.78833 7.85396C2.69715 8.27703 2.64713 8.85352 2.57235 9.75087L2.05851 15.917C2.01383 16.4531 1.99123 16.7516 2.00259 16.96C2.00274 16.9627 2.00289 16.9654 2.00305 16.968C2.00562 16.9684 2.00825 16.9687 2.01093 16.9691C2.21772 16.9977 2.51706 17 3.05505 17H16.7079C17.2458 17 17.5452 16.9977 17.752 16.9691C17.7547 16.9687 17.7573 16.9684 17.7599 16.968C17.76 16.9654 17.7602 16.9627 17.7603 16.96C17.7717 16.7516 17.7491 16.4531 17.7044 15.917L17.1906 9.75087C17.1158 8.85352 17.0658 8.27703 16.9746 7.85396C16.8894 7.45892 16.7945 7.33421 16.7183 7.26412C16.6421 7.19404 16.51 7.10975 16.1092 7.05771C15.68 7.00198 15.1014 7 14.2009 7H5.56198C4.66152 7 4.08288 7.00198 3.6537 7.05771Z"
                                    fill="currentColor" />
                            </svg>
                            <span
                                class="ltr:pl-2 rtl:pr-2 p-5p dm-bold font-bold text-gray-12 text-lg">{{ __('Add to Cart') }}</span>
                        </button>
                    </a>
                @endif

        </div>
    @elseif($product->isGroupedProduct())
       <div class="mt-6">
        <p class="text-gray-10 mb-3 roboto-medium font-medium text-sm leading-4">{{ __('This is a grouped product. Add to your cart what you want.') }}</p>
        <div class="bg-gray-11 h-56 delivery-scrollbar p-3.5 pb-0 rounded-md overflow-y-auto">
            @php
            $isSimpleAvailable = false;
        @endphp
        @foreach ($groupProducts['productDetails'] as $groupProduct)
            @if ($groupProduct->isSimpleProduct())
                @php
                    $isSimpleAvailable = true;
                    $stockDisplayFormat = preference('stock_display_format');
                    $lowStockThreshold = $groupProduct->getStockThreshold();
                    $stock_quantity = $groupProduct->getStockQuantity();
                    $manage_stocks = $groupProduct->isStockManageable();
                    $stock_status = $groupProduct->getStockStatus();
                    $stock_hide = $groupProduct->meta_hide_stock;
                    $backorders = $groupProduct->isAllowBackorder();
                @endphp
                {{-- simple product --}}
                <div class="flex justify-between items-center mb-3.5">
                    <div class="flex items-center justify-start">
                        <div class="p-1.5 bg-white object-cover rounded border-gray-2 h-53p w-53p">
                            <img class="object-cover w-full h-full" src="{{ $groupProduct->getFeaturedImage() }}" alt="{{ __('Image') }}">
                        </div>
                        <div class="ltr:ml-2.5 rtl:mr-2.5 flex flex-col dm-sans font-medium text-sm leading-4">
                            <a class="text-gray-12" href="{{ route('site.productDetails', ['slug' => $groupProduct->slug]) }}" title="{{ $groupProduct->name }}">
                              {{ trimWords($groupProduct->name,25) }}</a>
                            <span class="primary-text-color mt-1.5">
                                {{ $groupProduct->offerCheck() ? formatNumber($groupProduct->sale_price) : formatNumber($groupProduct->regular_price) }}
                            </span>
                            @if($manage_stocks == 1 && $stock_status == 'In Stock' && $stock_hide == 0 && $stock_quantity >= 0 && !is_null($stock_quantity))
                                @if($stockDisplayFormat == 'always_show')
                                  <span class="text-gray-10">{{ __(':x items remaining', ['x' => $stock_quantity]) }}</span>
                                @elseif($stockDisplayFormat == 'sometime_show' && $stock_quantity <= $lowStockThreshold && $lowStockThreshold != 0)
                                    <span class="text-gray-10">{{__('Only :x left in stock.', ['x' => $stock_quantity])}}</span>
                                @endif
                            @elseif($manage_stocks == 0 && $stock_status == 'Out Of Stock' || $manage_stocks == 1 && $stock_hide == 0 && $stock_quantity <= 0 && $backorders == 0)
                                @if($stockDisplayFormat == 'always_show' || $stockDisplayFormat == 'sometime_show')
                                <span class="text-gray-10">{{ __('Out Of Stock') }}</span>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="flex flex-wrap justify-start items-center gap-x-2 lg:gap-x-0">
                        <div class="flex flex-wrap h-8 text-xl border bg-white rounded-sm"
                            id="cart-item-details-{{ $groupProduct->code }}">
                            <a href="javascript:void(0)" class="cart-item-qty-dec m-auto text-11 p-2 flex items-center text-gray-10 hover:text-gray-12 rounded-l cursor-pointer outline-none md:text-center" data-isIndividual="{{ $groupProduct->meta_individual_sale }}" data-itemCode={{ $groupProduct->code }}>
                                <span class="inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="2" viewBox="0 0 8 2" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.41481 1.40002H0L0 0.259277H7.41481V1.40002Z" fill="#898989"/>
                                    </svg>
                                </span>
                            </a>
                            <div class="flex items-center justify-center dm-bold font-bold text-11 text-gray-12 text-center cart-item-quantity w-6">0</div>
                            <a href="javascript:void(0)" class="cart-item-qty-inc m-auto flex items-center text-11 text-gray-10 hover:text-graty-12 rounded-r cursor-pointer p-2 md:text-center" data-isIndividual="{{ $groupProduct->meta_individual_sale }}" data-itemCode={{ $groupProduct->code }}>
                                <span class="inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 9 9" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.82754 0.837097L4.82755 8.86618L3.78027 8.86618L3.78027 0.837097L4.82754 0.837097Z" fill="#898989"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.31934 5.37521L0.290257 5.37521L0.290257 4.32794L8.31934 4.32794L8.31934 5.37521Z" fill="#898989"/>
                                        </svg>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

            @elseif($groupProduct->isVariableProduct())
                @php
                    $varaiblePrice = $groupProduct->getPrice();
                @endphp
               <div class="flex justify-between items-center mb-4">
                   <div class="flex items-center justify-start">
                       <div class="p-1.5 w-53p h-53p bg-white object-cover rounded border-gray-2">
                           <img class="h-full w-full object-cover" src="{{ $groupProduct->getFeaturedImage() }}" alt="{{ __('Image') }}">
                       </div>

                        <div class="ltr:ml-2.5 rtl:mr-2.5 flex flex-col dm-sans font-medium text-sm leading-4">
                                <a class="text-gray-12" href="{{ route('site.productDetails', ['slug' => $groupProduct->slug]) }}" title="{{ $groupProduct->name }}">{{ trimWords($groupProduct->name, 20) }}</a>
                                <span class="primary-text-color mt-1.5">{{ is_array($varaiblePrice) ? formatNumber($varaiblePrice[0]) . ' - ' . formatNumber($varaiblePrice[1]) : formatNumber($varaiblePrice) }}</span>
                        </div>
                   </div>
                    <button class="primary-bg-color py-9p px-3.5 font-bold rounded-sm flex justify-center items-center open-view-modal" data-itemCode="{{ $groupProduct->code }}">
                        <span class="dm-bold font-bold text-gray-12 text-xs">{{ __('Option') }}</span>
                    </button>
               </div>
                @elseif($groupProduct->isGroupedProduct())
                @php
                    $groupPrice = $groupProduct->groupProducts();
                @endphp
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center justify-start">
                        <div class="px-2 py-4 bg-white object-cover rounded border-gray-2">
                            <img class="h-5 w-10 " src="{{ $groupProduct->getFeaturedImage() }}" alt="{{ __('Image') }}">
                        </div>

                        <div class="ltr:ml-2.5 rtl:mr-2.5 flex flex-col dm-sans font-medium text-sm leading-4">
                            <a class="text-gray-12" href="{{ route('site.productDetails', ['slug' => $groupProduct->slug]) }}" title="{{ $groupProduct->name }}">{{ trimWords($groupProduct->name, 20) }}</a>
                            <span class="primary-text-color mt-1.5">{{ formatNumber($groupPrice['min']) . ' - ' . formatNumber($groupPrice['max']) }}</span>
                        </div>
                    </div>
                    <a href="{{ route('site.productDetails', ['slug' => $groupProduct->slug]) }}">
                    <button class="primary-bg-color py-9p px-3.5 font-bold rounded-sm flex justify-center items-center open-view-modal">
                        <span class="dm-bold font-bold text-gray-12 text-xs">{{ __('View') }} {{ __('Products') }}</span>
                    </button>
                    </a>
                </div>
            @elseif($groupProduct->isExternalProduct())
                @php
                    $urlText = $groupProduct->meta_external_product;
                @endphp
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center justify-start">
                        <div class="px-2 py-4 bg-white object-cover rounded border-gray-2">
                            <img class="h-5 w-10 " src="{{ $groupProduct->getFeaturedImage() }}" alt="{{ __('Image') }}">
                        </div>

                        <div class="ltr:ml-2.5 rtl:mr-2.5 flex flex-col dm-sans font-medium text-sm leading-4">
                            <a class="text-gray-12" href="{{ $urlText['url'] }}" title="{{ $groupProduct->name }}">{{ trimWords($groupProduct->name, 20) }}</a>
                            <span class="primary-text-color mt-1.5">{{ $groupProduct->offerCheck() ? formatNumber($groupProduct->sale_price) : formatNumber($groupProduct->regular_price) }}</span>
                        </div>
                    </div>
                    <a href="{{ $urlText['url'] }}" target="_blank">
                        <button class="primary-bg-color py-9p px-3.5 font-bold rounded-sm flex justify-center items-center" data-itemCode="{{ $groupProduct->code }}">
                            <span class="dm-bold font-bold text-gray-12 text-xs">{{ isset($urlText['text']) && $urlText['text'] != '' ? $urlText['text'] : __('Buy Product') }}</span>
                        </button>
                    </a>
                </div>
            @endif
        @endforeach

        </div>
      <div class="mt-6 flex justify-between items-center">
      <div class="w-full">
        @if ($isSimpleAvailable)
        <a href="javascript:void(0)" class="add-to-cart cart-details-page" id="item-add-to-cart">
            <button
                class="primary-bg-color font-bold w-full py-2 px-68p rounded flex justify-center items-center">
                <svg class="text-gray-12" width="20" height="19" viewBox="0 0 20 19" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M5.88135 10C5.32906 10 4.88135 9.55228 4.88135 9L4.88135 5C4.88135 2.23858 7.11992 -1.25946e-06 9.88135 -6.82991e-07C12.6428 -1.0602e-06 14.8813 2.23858 14.8813 5L14.8813 9C14.8813 9.55228 14.4336 10 13.8813 10C13.3291 10 12.8813 9.55228 12.8813 9L12.8813 5C12.8813 3.34315 11.5382 2 9.88135 2C8.22449 2 6.88135 3.34314 6.88135 5L6.88135 9C6.88135 9.55228 6.43363 10 5.88135 10Z"
                        fill="currentColor" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M5.49955 5C5.52029 5 5.5411 5 5.56198 5L14.2634 5C15.0834 4.99996 15.7934 4.99991 16.3668 5.07436C16.983 5.15438 17.5746 5.33421 18.0725 5.79236C18.5704 6.25051 18.7988 6.82513 18.9297 7.4326C19.0515 7.99774 19.1104 8.70533 19.1785 9.52254L19.6975 15.7509C19.6991 15.77 19.7007 15.7891 19.7023 15.8081C19.7404 16.2651 19.7772 16.7051 19.7573 17.069C19.7351 17.4768 19.6367 17.9518 19.2664 18.3542C18.8961 18.7567 18.431 18.8941 18.0264 18.9502C17.6654 19.0002 17.2239 19.0001 16.7653 19C16.7462 19 16.727 19 16.7079 19H3.05505C3.03587 19 3.01671 19 2.99759 19C2.53902 19.0001 2.09749 19.0002 1.73653 18.9502C1.33195 18.8941 0.866803 18.7567 0.496488 18.3542C0.126173 17.9518 0.0278088 17.4768 0.00556347 17.069C-0.0142834 16.7051 0.0224672 16.2651 0.0606358 15.8081C0.0622278 15.7891 0.0638222 15.77 0.0654151 15.7509L0.579256 9.58478C0.58099 9.56397 0.582717 9.54323 0.584438 9.52256C0.652492 8.70535 0.711417 7.99775 0.833217 7.4326C0.964137 6.82513 1.19247 6.25051 1.69039 5.79236C2.18831 5.33421 2.77991 5.15438 3.39615 5.07436C3.96946 4.99991 4.67951 4.99996 5.49955 5ZM3.6537 7.05771C3.25295 7.10975 3.12078 7.19404 3.04461 7.26412C2.96844 7.33421 2.87347 7.45892 2.78833 7.85396C2.69715 8.27703 2.64713 8.85352 2.57235 9.75087L2.05851 15.917C2.01383 16.4531 1.99123 16.7516 2.00259 16.96C2.00274 16.9627 2.00289 16.9654 2.00305 16.968C2.00562 16.9684 2.00825 16.9687 2.01093 16.9691C2.21772 16.9977 2.51706 17 3.05505 17H16.7079C17.2458 17 17.5452 16.9977 17.752 16.9691C17.7547 16.9687 17.7573 16.9684 17.7599 16.968C17.76 16.9654 17.7602 16.9627 17.7603 16.96C17.7717 16.7516 17.7491 16.4531 17.7044 15.917L17.1906 9.75087C17.1158 8.85352 17.0658 8.27703 16.9746 7.85396C16.8894 7.45892 16.7945 7.33421 16.7183 7.26412C16.6421 7.19404 16.51 7.10975 16.1092 7.05771C15.68 7.00198 15.1014 7 14.2009 7H5.56198C4.66152 7 4.08288 7.00198 3.6537 7.05771Z"
                        fill="currentColor" />
                </svg>
                <span class="ltr:pl-2 rtl:pr-2 p-5p dm-bold font-bold text-gray-12 text-lg">{{ __('Add to Cart') }}</span>
            </button>
        </a>
    @endif
      </div>
      </div>
       </div>
    @endif

</div>
