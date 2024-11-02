@extends('site.layouts.app')
@section('page_title', __('Product Compare List'))
@section('seo')
    <meta name="robots" content="index, follow">
    <meta name="title" content="{{ preference('company_name').' | '.__('Multivendor Ecommerce store') }}">
    <meta name="description" content='{{ __("The best ecommerce site out in the market with a lots of user friendly features to help the sellers increase their sales. We have everything that you might need to establish your store's online presence.") }}' />
    <meta name="keywords" content="{{ preference('company_name').', '.__('eCommerce').', '.__('Multivendor').', '.__('Multivendor eCommerce') }}">
@endsection

@section('content')

    <section id="compare-details-container" class="mx-4 lg:mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92 mt-6">
        {{-- breadcrumbs --}}
        <nav class="my-8 container mx-auto px-4 text-gray-600 text-sm" aria-label="Breadcrumb">
            <ol class="list-none p-0 inline-flex">
                <li class="flex items-center">
                    <span>
                        <svg class="ltr:mr-1.5 rtl:ml-1.5"  xmlns="http://www.w3.org/2000/svg" width="13" height="15" viewBox="0 0 13 15" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.35643 1.89407C4.93608 2.1717 4.43485 2.59943 3.69438 3.23412L2.916 3.9013C2.0595 4.63545 1.82512 4.85827 1.69934 5.13174C1.57357 5.4052 1.55692 5.72817 1.55692 6.85625V10.1569C1.55692 10.9127 1.55857 11.4013 1.60698 11.7613C1.65237 12.099 1.72565 12.2048 1.7849 12.264C1.84416 12.3233 1.94997 12.3966 2.28759 12.442C2.64759 12.4904 3.13619 12.492 3.89206 12.492H8.56233C9.31819 12.492 9.80679 12.4904 10.1668 12.442C10.5044 12.3966 10.6102 12.3233 10.6695 12.264C10.7287 12.2048 10.802 12.099 10.8474 11.7613C10.8958 11.4013 10.8975 10.9127 10.8975 10.1569V6.85625C10.8975 5.72817 10.8808 5.4052 10.755 5.13174C10.6293 4.85827 10.3949 4.63545 9.53838 3.9013L8.76 3.23412C8.01953 2.59943 7.5183 2.1717 7.09795 1.89407C6.69581 1.62848 6.44872 1.55676 6.22719 1.55676C6.00566 1.55676 5.75857 1.62848 5.35643 1.89407ZM4.49849 0.595063C5.03749 0.239073 5.5849 0 6.22719 0C6.86948 0 7.41689 0.239073 7.95589 0.595063C8.4674 0.932894 9.04235 1.42573 9.7353 2.01972L10.5515 2.71933C10.5892 2.75162 10.6264 2.78347 10.6632 2.81492C11.3564 3.40806 11.8831 3.85873 12.1694 4.48124C12.4557 5.10375 12.4551 5.79693 12.4543 6.70926C12.4543 6.75764 12.4542 6.80662 12.4542 6.85625L12.4542 10.2081C12.4543 10.8981 12.4543 11.4927 12.3903 11.9688C12.3217 12.479 12.167 12.9681 11.7703 13.3648C11.3736 13.7615 10.8845 13.9162 10.3742 13.9848C9.89812 14.0488 9.30358 14.0488 8.61355 14.0488H3.84083C3.1508 14.0488 2.55626 14.0488 2.08015 13.9848C1.56991 13.9162 1.08082 13.7615 0.68411 13.3648C0.2874 12.9681 0.132701 12.479 0.064101 11.9688C9.07021e-05 11.4927 0.000124017 10.8981 0.000162803 10.2081L0.000164659 6.85625C0.000164659 6.80662 0.000122439 6.75763 8.07765e-05 6.70926C-0.000705247 5.79693 -0.00130245 5.10374 0.285011 4.48124C0.571324 3.85873 1.09802 3.40806 1.79122 2.81492C1.82798 2.78347 1.8652 2.75162 1.90288 2.71933L2.68126 2.05215C2.69391 2.0413 2.70652 2.03049 2.71909 2.01972C3.41204 1.42573 3.98698 0.932893 4.49849 0.595063Z" fill="#898989"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.50293 9.37853C3.50293 8.51876 4.19991 7.82178 5.05969 7.82178H7.39482C8.25459 7.82178 8.95158 8.51876 8.95158 9.37853V13.2704C8.95158 13.7003 8.60309 14.0488 8.1732 14.0488C7.74331 14.0488 7.39482 13.7003 7.39482 13.2704V9.37853H5.05969V13.2704C5.05969 13.7003 4.71119 14.0488 4.28131 14.0488C3.85142 14.0488 3.50293 13.7003 3.50293 13.2704V9.37853Z" fill="#898989"/>
                        </svg>
                    </span>
                    <a class="text-gray-10 roboto-medium font-medium text-sm" href="{{ route('site.index') }}">{{ __('Home') }}</a>
                </li>
                <span class="mx-2">/</span>
                <li>
                    <a class="text-gray-12 roboto-medium font-medium text-sm" href="{{ route('site.compare') }}" aria-current="page">{{ __('Compare Products') }}</a>
                </li>
            </ol>
        </nav>

        <!-- Compare Products Start -->
        <section>
            <div>
                <div class="block w-full overflow-auto">
                    <table class="compare-table {{ \App\Compare\Compare::totalProduct() == 0 ? 'display-none' : '' }}">
                        <tbody>
                            <tr>
                                <td class="text-15 text-gray-10 ltr:pr-12 ltr:text-right rtl:pl-12 rtl:text-left dm-sans font-medium whitespace-nowrap w-28">{{ __('Products') }}</td>
                                @php $index = 1 @endphp
                                @foreach($compareProducts['productName'] as $key => $productName)
                                <td class="value-{{ $key }} pb-30p ltr:pr-2.5 rtl:pl-2.5 relative text-center">
                                    <div href="" class="bg-gray-11 rounded h-225p w-225p flex justify-center items-center mb-13p mt-14">
                                        <img  src="{{ $productName['image'] }}"  alt="product image" class="w-full h-full border rounded object-cover neg-transition-scale">
                                    </div>
                                    <a href="{{ route('site.productDetails', ['slug' => $productName['slug']]) }}" class="dm-sans font-medium text-sm text-gray-12 whitespace-wrap ltr:ml-7 rtl:mr-7" title="{{ $productName['name'] }}">{{ trimWords($productName['name'], 25) }}
                                    </a>
                                    <div class="btn btn-remove absolute cursor-pointer h-14 w-12 ltr:left-25 rtl:right-25 top-2 pt-2.5 pb-25p px-3.5 compare-remove" data-itemId = "{{ $key }}">
                                        <div title='clear field' id='clear' class='clear-field text-gray-10'>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 13 13" fill="currentColor">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.455734 0.455612C1.06322 -0.151871 2.04814 -0.151871 2.65562 0.455612L11.989 9.78895C12.5964 10.3964 12.5964 11.3814 11.989 11.9888C11.3815 12.5963 10.3965 12.5963 9.78907 11.9888L0.455734 2.6555C-0.151749 2.04802 -0.151749 1.06309 0.455734 0.455612Z" />
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9888 0.455612C11.3814 -0.151871 10.3964 -0.151871 9.78896 0.455612L0.455626 9.78895C-0.151857 10.3964 -0.151857 11.3814 0.455626 11.9888C1.06311 12.5963 2.04803 12.5963 2.65551 11.9888L11.9888 2.6555C12.5963 2.04802 12.5963 1.06309 11.9888 0.455612Z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </td>
                                @endforeach

                            </tr>
                            <tr class="bg-gray-11 h-20">
                                <td class="text-15 text-gray-10 dm-sans font-medium  py-6 ltr:pr-12 ltr:text-right ltr:pl-6 rtl:pl-12 rtl:text-left rtl:pr-6 whitespace-nowrap w-28">{{ __('Price') }}</td>

                                @foreach ($compareProducts['price'] as $key => $price)
                                <td class="value-{{ $key }} roboto-medium font-medium text-sm text-gray-12">
                                    {{ $price }}
                                </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="text-15 text-gray-10 dm-sans font-medium py-6  ltr:pr-12 ltr:text-right ltr:pl-6 rtl:pl-12 rtl:text-left rtl:pr-6 whitespace-nowrap h-20 w-28">{{ __('Availability') }}</td>
                                @foreach($compareProducts['availability'] as $key => $av)
                                <td class="value-{{ $key }} rounded roboto-medium font-medium text-sm {{ $av == true ? 'text-green-1' : 'primary-text-color'}}">
                                    {{ $av == true ? __('Available') : __('Not Available') }}
                                </td>
                                @endforeach
                            </tr>
                            <tr class="bg-gray-11">
                                <td class="text-15 text-gray-10 dm-sans font-medium py-6 ltr:pr-12 ltr:text-right ltr:pl-6 rtl:pl-12 rtl:text-left rtl:pr-6 whitespace-nowrap pt-7 w-28 align-middle">{{ __('Summary') }}</td>

                                @foreach($compareProducts['summary'] as $key => $summary)
                                <td class="value-{{ $key }} roboto-medium font-medium text-sm  text-gray-10 ltr:pr-4 rtl:pl-4 pt-8 pb-7 w-56"> {{ $summary }}</td>
                                @endforeach

                            </tr>
                            <tr class="h-20">
                                <td class="text-15 text-gray-10 dm-sans font-medium py-6 ltr:pr-12 ltr:text-right ltr:pl-6 rtl:pl-12 rtl:text-left rtl:pr-6 whitespace-nowrap w-28">{{ __('Rating & Reviews') }}
                                </td>

                                @foreach ($compareProducts['rating'] as $key => $rating)
                                    <td class="value-{{ $key }}">
                                        <div class="flex gap-1.5 items-center primary-text-color">
                                            @if($rating > 0)
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if ($rating >= $i)
                                                        <span class="value-{{$key}}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16" fill="none">
                                                            <path d="M8.5 0L10.4084 5.87336L16.584 5.87336L11.5878 9.50329L13.4962 15.3766L8.5 11.7467L3.50383 15.3766L5.41219 9.50329L0.416019 5.87336L6.59163 5.87336L8.5 0Z" fill="currentColor"/>
                                                            </svg>
                                                        </span>
                                                    @else
                                                        <span class="value-{{$key}}">
                                                            <svg width="17" height="16" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" viewBox="0 0 17 16" fill="currentColor">
                                                                <path d="M8.5 0L10.4084 5.87336L16.584 5.87336L11.5878 9.50329L13.4962 15.3766L8.5 11.7467L3.50383 15.3766L5.41219 9.50329L0.416019 5.87336L6.59163 5.87336L8.5 0Z" fill="currentColor"/>
                                                            </svg>
                                                        </span>
                                                    @endif
                                                @endfor
                                                    <span class="rating-count roboto-medium font-medium text-13 text-gray-10"> ({{ $compareProducts['ratingCount'][$key] ?? 0 }} {{ __('Reviews') }}) </span>
                                             @else
                                                 <span> {{ __('Not reviewed yet') }} </span>
                                            @endif
                                        </div>
                                    </td>
                                @endforeach
                           </tr>
                            <tr class="bg-gray-11 text-gray-10 h-20">
                                <td class="text-15 dm-sans font-medium py-6 ltr:pr-12 ltr:text-right ltr:pl-6 rtl:pl-12 rtl:text-left rtl:pr-6 w-28 whitespace-nowrap">{{ __('Category') }}</td>
                                @foreach($compareProducts['category'] as $key => $category)
                                <td class="value-{{ $key }} roboto-medium font-medium text-sm">{{ $category }}</td>
                                @endforeach
                            </tr>
                            <tr class="h-20 text-gray-10">
                                <td class="text-15 dm-sans font-medium py-6 ltr:pr-12 ltr:text-right ltr:pl-6 rtl:pl-12 rtl:text-left rtl:pr-6 w-28 whitespace-nowrap">{{ __('SKU') }}</td>
                                @foreach($compareProducts['sku'] as $key => $sku)
                                <td class="value-{{ $key }} roboto-medium font-medium text-sm">{{ $sku }}</td>
                                @endforeach
                            </tr>
                            @php
                                $cnt = 0 ; $totalAttribute = count($compareProducts['productAttributeValuesCheck']);
                                $productIds = array_keys($compareProducts['category']);
                            @endphp
                            @foreach ($compareProducts['productAttributeValuesCheck'] as $key2 => $values)
                                @if($totalAttribute / 2 == 0)
                                    <tr class="{{ $cnt%2 == 0 ? "bg-gray-11 h-20" : "h-20 text-gray-10" }}">
                                @else
                                    <tr class="{{ $cnt%2 != 0 ? "bg-gray-11 h-20" : "h-20 text-gray-10" }}">
                                @endif
                                    <td class="text-15 text-gray-10 dm-sans font-medium py-6 ltr:pr-12 ltr:text-right ltr:pl-6 rtl:pl-12 rtl:text-left rtl:pr-6 w-28 whitespace-nowrap">{{ $key2 }}</td>
                                    @php $cnt++ ; $valuesOrderWise = [];
                                        foreach($productIds as $id) {
                                            $valuesOrderWise[$id] = $values[$id];
                                        }
                                    @endphp
                                    @foreach ($valuesOrderWise as $key3 => $val)
                                        <td class="roboto-medium font-medium text-sm value-{{ $key3 }}">{{ $val }}</td>
                                    @endforeach
                                </tr>
                            @endforeach

                            <tr class="text-gray-10 bg-gray-11 h-20">
                                <td class="text-15 dm-sans font-medium py-6 ltr:pr-12 ltr:text-right ltr:pl-6 rtl:pl-12 rtl:text-left rtl:pr-6 w-28 whitespace-nowrap">{{ __('Brand') }}</td>
                                @foreach($compareProducts['brand'] as $key => $brand)
                                <td class="value-{{ $key }} roboto-medium font-medium text-sm">{{ $brand }}</td>
                                @endforeach
                            </tr>
                            <tr>
                               <td class="text-15 text-gray-10 dm-sans font-medium py-6 align-top ltr:pr-12 ltr:text-right ltr:pl-6 rtl:pl-12 rtl:text-left rtl:pr-6 w-28 h-20 whitespace-nowrap">{{ __('Actions') }}</td>
                                @php $userId = isset(Auth::user()->id) ? Auth::user()->id : null @endphp
                                @foreach ($compareProducts['productName'] as $key => $productName)
                               <td class="py-7 value-{{ $key }}">
                                   <div class="flex flex-col gap-y-2">
                                       @php
                                           $wishlisted = false;
                                           if (auth()->user()) {
                                               $wishlisted = $product->isWishlist($key, optional(auth()->user())->id);
                                           }
                                       @endphp
                                       @if (preference('wishlist'))
                                            <div class="flex align-items-center ltr:-ml-0.5 rtl:-mr-0.5 mb-2">
                                                <div data-id="{{ $key }}" class="wishlist h-6 w-6 p-1 text-gray-12 primary-bg-hover border border-gray-2 rounded-full cursor-pointer bg-white {{ $wishlisted ? 'remove-wishlist primary-bg-color ' : 'add-wishlist' }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                    </svg>
                                                </div>
                                                <span class="roboto-medium font-medium text-sm text-gray-10 hover:text-gray-12 ltr:ml-2 rtl:mr-2">{{ !$wishlisted ? __('Add to wishlist') : __('In wishlist') }}</span>
                                            </div>
                                        @endif

                                       @if($productName['type'] != 'Variable Product')
                                           @php
                                              $inCart = \Cart::cartCollection()->where('id', $key)->first();
                                           @endphp
                                           @if($productName['type'] == 'Grouped Product')
                                               <a href="{{ route('site.productDetails', ['slug' => $productName['slug']]) }}" class="roboto-medium font-medium text-sm text-gray-10 mt-3 hover:text-gray-12">
                                                <span>
                                                  <svg class="inline-block ltr:mr-1.5 rtl:ml-1.5" xmlns="http://www.w3.org/2000/svg" width="20" height="14" viewBox="0 0 20 14" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M9.77051 9C10.8751 9 11.7705 8.10457 11.7705 7C11.7705 5.89543 10.8751 5 9.77051 5C8.66594 5 7.77051 5.89543 7.77051 7C7.77051 8.10457 8.66594 9 9.77051 9ZM9.77051 11C11.9796 11 13.7705 9.20914 13.7705 7C13.7705 4.79086 11.9796 3 9.77051 3C7.56137 3 5.77051 4.79086 5.77051 7C5.77051 9.20914 7.56137 11 9.77051 11Z" fill="#898989"/>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.42941 3.63233C4.11029 4.58138 3.03435 5.74418 2.35413 6.57005C2.25436 6.69118 2.17984 6.78179 2.11811 6.86149C2.06925 6.92459 2.03813 6.96852 2.01782 7C2.03813 7.03148 2.06925 7.07541 2.11811 7.13851C2.17984 7.21821 2.25436 7.30882 2.35413 7.42995C3.03435 8.25582 4.11029 9.41862 5.42941 10.3677C6.75643 11.3224 8.24447 12 9.77027 12C11.2961 12 12.7841 11.3224 14.1111 10.3677C15.4303 9.41862 16.5062 8.25582 17.1864 7.42995C17.2862 7.30882 17.3607 7.21821 17.4224 7.13851C17.4713 7.07541 17.5024 7.03147 17.5227 7C17.5024 6.96852 17.4713 6.92458 17.4224 6.86149C17.3607 6.78179 17.2862 6.69118 17.1864 6.57005C16.5062 5.74418 15.4303 4.58138 14.1111 3.63233C12.7841 2.6776 11.2961 2 9.77027 2C8.24447 2 6.75643 2.6776 5.42941 3.63233ZM4.26138 2.00884C5.76442 0.927471 7.66034 0 9.77027 0C11.8802 0 13.7761 0.927472 15.2792 2.00885C16.7901 3.0959 17.9903 4.40025 18.7302 5.29853C18.7538 5.32717 18.7784 5.35662 18.8037 5.38694C19.1171 5.76236 19.5406 6.26957 19.5406 7C19.5406 7.73043 19.1171 8.23764 18.8037 8.61306C18.7784 8.64338 18.7538 8.67283 18.7302 8.70148C17.9903 9.59976 16.7901 10.9041 15.2792 11.9912C13.7761 13.0725 11.8802 14 9.77027 14C7.66034 14 5.76442 13.0725 4.26138 11.9912C2.75044 10.9041 1.55022 9.59975 0.810357 8.70147C0.786765 8.67283 0.762175 8.64338 0.736868 8.61306C0.423444 8.23764 -5.96046e-08 7.73043 0 7C0 6.26957 0.423445 5.76236 0.736869 5.38694C0.762176 5.35662 0.786766 5.32717 0.810358 5.29852C1.55022 4.40024 2.75044 3.0959 4.26138 2.00884Z" fill="#898989"/>
                                                  </svg>
                                                </span>
                                                   {{ __('View') }}
                                               </a>
                                           @else
                                               <div class="{{ $productName['stockStatus']['outOfStockVisibility'] != 1 ? 'add-to-cart' : '' }} flex align-items-center ltr:-ml-0.5 rtl:-mr-0.5" data-itemCode = {{ $productName['code'] }}>
                                                   <div class="h-6 w-6 p-1 text-gray-12 primary-bg-hover border border-gray-2 rounded-full bg-white cursor-pointer">
                                                       <svg viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                           <path fill-rule="evenodd" clip-rule="evenodd"
                                                                 d="M3.81845 6.09833C3.48337 6.09833 3.21173 5.82669 3.21173 5.49161L3.21173 3.06475C3.21173 1.38935 4.56991 0.0311725 6.24531 0.0311728C7.92071 0.0311726 9.27889 1.38935 9.27889 3.06475L9.27889 5.49161C9.27889 5.82669 9.00725 6.09833 8.67217 6.09833C8.33709 6.09833 8.06545 5.82669 8.06545 5.49161L8.06545 3.06475C8.06545 2.05951 7.25055 1.2446 6.24531 1.2446C5.24007 1.2446 4.42516 2.05951 4.42516 3.06475L4.42516 5.49161C4.42516 5.82669 4.15353 6.09833 3.81845 6.09833Z"
                                                                 fill="#2C2C2C"/>
                                                           <path fill-rule="evenodd" clip-rule="evenodd"
                                                                 d="M3.58666 3.06488C3.59925 3.06488 3.61187 3.06488 3.62454 3.06488L8.9038 3.06488C9.40133 3.06485 9.83213 3.06483 10.18 3.11C10.5538 3.15855 10.9128 3.26765 11.2149 3.54562C11.517 3.82358 11.6555 4.17222 11.7349 4.54078C11.8088 4.88366 11.8446 5.31296 11.8859 5.80877L12.2008 9.5876C12.2017 9.5992 12.2027 9.61078 12.2037 9.62235C12.2268 9.8996 12.2491 10.1666 12.2371 10.3873C12.2236 10.6348 12.1639 10.9229 11.9392 11.1671C11.7146 11.4113 11.4323 11.4947 11.1869 11.5287C10.9679 11.559 10.7 11.559 10.4218 11.5589C10.4102 11.5589 10.3986 11.5589 10.3869 11.5589H2.10355C2.09191 11.5589 2.08029 11.5589 2.06868 11.5589C1.79046 11.559 1.52258 11.559 1.30358 11.5287C1.05812 11.4947 0.775903 11.4113 0.551227 11.1671C0.326551 10.9229 0.266872 10.6348 0.253375 10.3873C0.241334 10.1666 0.263631 9.8996 0.286789 9.62234C0.287755 9.61078 0.288722 9.5992 0.289688 9.5876L0.601444 5.84654C0.602496 5.83391 0.603543 5.82133 0.604588 5.80879C0.645877 5.31297 0.681628 4.88366 0.755526 4.54078C0.834957 4.17222 0.97349 3.82358 1.27559 3.54562C1.57768 3.26765 1.93662 3.15855 2.3105 3.11C2.65833 3.06483 3.08913 3.06485 3.58666 3.06488ZM2.46675 4.31332C2.22362 4.3449 2.14342 4.39604 2.09721 4.43856C2.051 4.48108 1.99338 4.55675 1.94172 4.79642C1.8864 5.05311 1.85605 5.40287 1.81068 5.94731L1.49893 9.68837C1.47182 10.0136 1.45811 10.1948 1.46501 10.3212C1.46509 10.3229 1.46519 10.3245 1.46528 10.326C1.46684 10.3263 1.46843 10.3265 1.47006 10.3267C1.59552 10.3441 1.77714 10.3455 2.10355 10.3455H10.3869C10.7133 10.3455 10.8949 10.3441 11.0204 10.3267C11.022 10.3265 11.0236 10.3263 11.0252 10.326C11.0253 10.3245 11.0254 10.3229 11.0255 10.3212C11.0324 10.1948 11.0186 10.0136 10.9915 9.68837L10.6798 5.94731C10.6344 5.40287 10.6041 5.05311 10.5487 4.79642C10.4971 4.55675 10.4395 4.48108 10.3932 4.43856C10.347 4.39604 10.2668 4.3449 10.0237 4.31332C9.76332 4.27951 9.41224 4.27831 8.86592 4.27831H3.62454C3.07822 4.27831 2.72714 4.27951 2.46675 4.31332Z"
                                                                 fill="#2C2C2C"/>
                                                       </svg>
                                                   </div>
                                                   @if($productName['stockStatus']['outOfStockVisibility'] != 1 )
                                                   <span class="roboto-medium font-medium text-sm text-gray-10 hover:text-gray-12 ltr:ml-2 rtl:mr-2">{{ empty($inCart) ? __('Add to cart') : __('In cart') }}</span>
                                                   @else
                                                       <span class="roboto-medium font-medium text-sm text-gray-10 hover:text-gray-12 ltr:ml-2 rtl:mr-2">{{ __('Stock Out') }}</span>
                                                   @endif
                                               </div>
                                           @endif
                                       @else
                                           <a href="javascript:void(0)" class="open-view-modal roboto-medium font-medium text-sm text-gray-10 mt-3 hover:text-gray-12" data-itemCode = {{ $productName['code'] }}>
                                                <span>
                                                  <svg class="inline-block ltr:mr-1.5 rtl:ml-1.5" xmlns="http://www.w3.org/2000/svg" width="20" height="14" viewBox="0 0 20 14" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M9.77051 9C10.8751 9 11.7705 8.10457 11.7705 7C11.7705 5.89543 10.8751 5 9.77051 5C8.66594 5 7.77051 5.89543 7.77051 7C7.77051 8.10457 8.66594 9 9.77051 9ZM9.77051 11C11.9796 11 13.7705 9.20914 13.7705 7C13.7705 4.79086 11.9796 3 9.77051 3C7.56137 3 5.77051 4.79086 5.77051 7C5.77051 9.20914 7.56137 11 9.77051 11Z" fill="#898989"/>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.42941 3.63233C4.11029 4.58138 3.03435 5.74418 2.35413 6.57005C2.25436 6.69118 2.17984 6.78179 2.11811 6.86149C2.06925 6.92459 2.03813 6.96852 2.01782 7C2.03813 7.03148 2.06925 7.07541 2.11811 7.13851C2.17984 7.21821 2.25436 7.30882 2.35413 7.42995C3.03435 8.25582 4.11029 9.41862 5.42941 10.3677C6.75643 11.3224 8.24447 12 9.77027 12C11.2961 12 12.7841 11.3224 14.1111 10.3677C15.4303 9.41862 16.5062 8.25582 17.1864 7.42995C17.2862 7.30882 17.3607 7.21821 17.4224 7.13851C17.4713 7.07541 17.5024 7.03147 17.5227 7C17.5024 6.96852 17.4713 6.92458 17.4224 6.86149C17.3607 6.78179 17.2862 6.69118 17.1864 6.57005C16.5062 5.74418 15.4303 4.58138 14.1111 3.63233C12.7841 2.6776 11.2961 2 9.77027 2C8.24447 2 6.75643 2.6776 5.42941 3.63233ZM4.26138 2.00884C5.76442 0.927471 7.66034 0 9.77027 0C11.8802 0 13.7761 0.927472 15.2792 2.00885C16.7901 3.0959 17.9903 4.40025 18.7302 5.29853C18.7538 5.32717 18.7784 5.35662 18.8037 5.38694C19.1171 5.76236 19.5406 6.26957 19.5406 7C19.5406 7.73043 19.1171 8.23764 18.8037 8.61306C18.7784 8.64338 18.7538 8.67283 18.7302 8.70148C17.9903 9.59976 16.7901 10.9041 15.2792 11.9912C13.7761 13.0725 11.8802 14 9.77027 14C7.66034 14 5.76442 13.0725 4.26138 11.9912C2.75044 10.9041 1.55022 9.59975 0.810357 8.70147C0.786765 8.67283 0.762175 8.64338 0.736868 8.61306C0.423444 8.23764 -5.96046e-08 7.73043 0 7C0 6.26957 0.423445 5.76236 0.736869 5.38694C0.762176 5.35662 0.786766 5.32717 0.810358 5.29852C1.55022 4.40024 2.75044 3.0959 4.26138 2.00884Z" fill="#898989"/>
                                                  </svg>
                                                </span>
                                               {{ __('Quick View') }}
                                           </a>
                                       @endif
                                   </div>
                               </td>
                                @endforeach

                            </tr>
                        </tbody>
                    </table>
                    <div id="compareEmpty" class="flex justify-center items-center flex-col mt-10 mb-20 {{ \App\Compare\Compare::totalProduct() > 0 ? 'display-none' : '' }}">
                        <div>
                            <img class="neg-transition-scale" src="{{ asset('public/frontend/assets/img/compare/emp-com.svg')}}" alt="{{ __('Image') }}">
                        </div>
                        <div>
                            <span class="block text-center dm-sans font-medium text-gray-10 text-xl mt-7">{{ __('There are no products added for comparison yet.') }}</span>
                             <span class="text-center block dm-sans font-medium text-gray-10 text-sm mt-3">{{ __('To compare products') }},</span>
                            <span class="text-center block dm-sans font-medium text-gray-10 text-sm"> <a href="javascript:void(0)"><img class="inline px-1 cursor-pointer neg-transition-scale" src="{{ asset('public/frontend/assets/img/compare/empty-click.svg')}}" alt="{{ __('Image') }}"></a> {{ __('click on the button on the product page') }}.</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Compare Products end -->
    </section>
    <!-- Details section end -->

@endsection
@section('js')
    <script src="{{ asset('public/dist/js/custom/site/wishlist.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/compare.min.js') }}"></script>
@endsection
