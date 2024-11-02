@extends('../site/layouts.app')
@section('page_title', __('Order Confirmation'))
@section('content')
    <section class="mx-4 lg:mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92">
        <nav class="text-gray-600 text-sm mt-5 md:mt-30p" aria-label="Breadcrumb">
            <ol class="list-none p-0 inline-flex text-xs md:text-sm roboto-medium font-medium text-gray-10">
                <li class="flex items-center">
                    <svg class="-mt-1 ltr:mr-7p rtl:ml-7p" width="13" height="15" viewBox="0 0 13 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.35643 1.89407C4.93608 2.1717 4.43485 2.59943 3.69438 3.23412L2.916 3.9013C2.0595 4.63545 1.82512 4.85827 1.69934 5.13174C1.57357 5.4052 1.55692 5.72817 1.55692 6.85625V10.1569C1.55692 10.9127 1.55857 11.4013 1.60698 11.7613C1.65237 12.099 1.72565 12.2048 1.7849 12.264C1.84416 12.3233 1.94997 12.3966 2.28759 12.442C2.64759 12.4904 3.13619 12.492 3.89206 12.492H8.56233C9.31819 12.492 9.80679 12.4904 10.1668 12.442C10.5044 12.3966 10.6102 12.3233 10.6695 12.264C10.7287 12.2048 10.802 12.099 10.8474 11.7613C10.8958 11.4013 10.8975 10.9127 10.8975 10.1569V6.85625C10.8975 5.72817 10.8808 5.4052 10.755 5.13174C10.6293 4.85827 10.3949 4.63545 9.53838 3.9013L8.76 3.23412C8.01953 2.59943 7.5183 2.1717 7.09795 1.89407C6.69581 1.62848 6.44872 1.55676 6.22719 1.55676C6.00566 1.55676 5.75857 1.62848 5.35643 1.89407ZM4.49849 0.595063C5.03749 0.239073 5.5849 0 6.22719 0C6.86948 0 7.41689 0.239073 7.95589 0.595063C8.4674 0.932894 9.04235 1.42573 9.7353 2.01972L10.5515 2.71933C10.5892 2.75162 10.6264 2.78347 10.6632 2.81492C11.3564 3.40806 11.8831 3.85873 12.1694 4.48124C12.4557 5.10375 12.4551 5.79693 12.4543 6.70926C12.4543 6.75764 12.4542 6.80662 12.4542 6.85625L12.4542 10.2081C12.4543 10.8981 12.4543 11.4927 12.3903 11.9688C12.3217 12.479 12.167 12.9681 11.7703 13.3648C11.3736 13.7615 10.8845 13.9162 10.3742 13.9848C9.89812 14.0488 9.30358 14.0488 8.61355 14.0488H3.84083C3.1508 14.0488 2.55626 14.0488 2.08015 13.9848C1.56991 13.9162 1.08082 13.7615 0.68411 13.3648C0.2874 12.9681 0.132701 12.479 0.064101 11.9688C9.07021e-05 11.4927 0.000124017 10.8981 0.000162803 10.2081L0.000164659 6.85625C0.000164659 6.80662 0.000122439 6.75763 8.07765e-05 6.70926C-0.000705247 5.79693 -0.00130245 5.10374 0.285011 4.48124C0.571324 3.85873 1.09802 3.40806 1.79122 2.81492C1.82798 2.78347 1.8652 2.75162 1.90288 2.71933L2.68126 2.05215C2.69391 2.0413 2.70652 2.03049 2.71909 2.01972C3.41204 1.42573 3.98698 0.932893 4.49849 0.595063Z" fill="#898989"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M3.50293 9.37853C3.50293 8.51876 4.19991 7.82178 5.05969 7.82178H7.39482C8.25459 7.82178 8.95158 8.51876 8.95158 9.37853V13.2704C8.95158 13.7003 8.60309 14.0488 8.1732 14.0488C7.74331 14.0488 7.39482 13.7003 7.39482 13.2704V9.37853H5.05969V13.2704C5.05969 13.7003 4.71119 14.0488 4.28131 14.0488C3.85142 14.0488 3.50293 13.7003 3.50293 13.2704V9.37853Z" fill="#898989"></path>
                    </svg>
                    <a href="{{ route('site.index') }}">{{ __('Home') }}</a>
                    <p class="px-7p">/</p>
                </li>
                <li class="flex items-center">
                    <a class="text-gray-12" href="{{ route('site.cart') }}">{{ __('Cart') }}</a>
                </li>
            </ol>
        </nav>
        <div class="flex justify-center items-center mt-5 ltr:-ml-5 ltr:md:-ml-0 rtl:-mr-5 rtl:md:-mr-0">
            @include('site.layouts.includes.order_steps',['stepsNumber' => 4])
        </div>
    </section>
    <section class="mx-5 lg:mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92 border border-gray-2 flex flex-col md:flex-row items-center justify-center h-150p mt-116p rounded">
        <span class="text-green-3 ltr:mr-18p rtl:ml-18p">
            <svg xmlns="http://www.w3.org/2000/svg" width="37" height="37" viewBox="0 0 37 37" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M18.5 37C28.7173 37 37 28.7173 37 18.5C37 8.28273 28.7173 0 18.5 0C8.28273 0 0 8.28273 0 18.5C0 28.7173 8.28273 37 18.5 37ZM18.0236 25.9826L28.3013 13.6493L25.1431 11.0174L16.3063 21.6215L11.7313 17.0465L8.82428 19.9535L14.9909 26.1202L16.5826 27.7118L18.0236 25.9826Z" fill="currentColor"/>
            </svg>
        </span>
        <h1 class="dm-bold font-bold text-base md:text-22 text-gray-12 text-center uppercase mt-4 md:mt-0">{{ __('Thank you. Your order has been received.') }}</h1>
    </section>

    <section class="mx-5 lg:mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92 mt-12 break-all">
        <div class="rounded-md grid grid-cols-2 md:grid-cols-4 xl:grid-cols-5 mb-7 lg:mb-8 xl:mb-10 gap-5">
                <div class="mt-3 md:border-gray-2 last:border-0 dm-sans font-medium text-18 text-gray-12 { languageDirection() == 'ltr' ? 'pr-2 md:border-r' : 'pl-2 md:border-l' }}">
                    <span class="uppercase roboto-medium font-medium text-13 text-gray-10 block mb-1.5 md:mb-0 whitespace-nowrap">{{ __('Order Number') }} </span>{{ $order->reference }}
                </div >
                <div class="md:border-gray-2 last:border-0 dm-sans font-medium text-18 text-gray-12 ltr:pr-2 ltr:md:pl-3 ltr:md:border-r ltr:text-right ltr:md:text-left rtl:pl-2 rtl:md:pr-3 rtl:md:border-l">
                        <span class="uppercase roboto-medium font-medium text-13 text-gray-10 block mb-1.5 md:mb-0 whitespace-nowrap">{{ __('Order Date') }} </span>{{ formatDate($order->order_date) }}
                </div>
                <div class="md:border-gray-2 last:border-0 dm-sans font-medium text-18 text-gray-12 ltr:pr-2 ltr:md:pl-3 ltr:md:border-r ltr:md:text-left rtl:pl-2 rtl:md:pr-3 rtl:md:border-l">
                    <span class="uppercase roboto-medium font-medium text-13 text-gray-10 block mb-1.5 md:mb-0 whitespace-nowrap">{{ __('Status') }} </span> {{ optional($order->orderStatus)->name }}
                </div>
                <div class="md:border-gray-2 last:border-0 dm-sans font-medium text-18 text-gray-12 ltr:pr-2 ltr:md:pl-3 ltr:md:border-r ltr:text-right ltr:md:text-left rtl:pl-2 rtl:md:pr-3 rtl:md:border-l">
                <span class="uppercase roboto-medium font-medium text-13 text-gray-10 block mb-1.5 md:mb-0 whitespace-nowrap">{{ __('Email') }}</span>{{ Auth::check() ? Auth::user()->email : $order->metadata->where('key', 'shipping_address_email')->first()->value }}
                </div>
                <div class="md:border-gray-2 last:border-0 dm-sans font-medium text-18 text-gray-12 ltr:pr-2 ltr:xl:pl-0 ltr:md:pl-3 ltr:md:border-r ltr:md:text-left rtl:pl-2 rtl:xl:pr-0 rtl:md:pr-3 rtl:md:border-l">
                    <span class="uppercase roboto-medium font-medium text-13 text-gray-10 block mb-1.5 md:mb-0 whitespace-nowrap">{{ __('Total') }} </span>{{ formatNumber($order->total, optional($order->currency)->symbol) }}
                </div>
            @if(!is_null(optional($order->paymentMethod)->gateway))
                <div class=" dm-sans font-medium text-18 text-gray-12 ltr:pr-2 ltr:xl:pl-0 ltr:md:pl-3 ltr:text-right ltr:md:text-left rtl:pl-2 rtl:xl:pr-0 rtl:md:pr-3">
                <span class="uppercase roboto-medium font-medium text-13 text-gray-10 block mb-1.5 md:mb-0 whitespace-nowrap">{{ __('Payment Method') }} </span>{{ paymentRenamed(optional($order->paymentMethod)->gateway) }}
                </div>
            @endif
            @if(!Auth::check())
                <div class=" last:border-0 dm-sans font-medium text-18 text-gray-12 xl:pl-0 md:pl-3 text-right md:text-center pr-2">
                    <span class="uppercase roboto-medium font-medium text-13 text-gray-10 block mb-1.5 md:mb-0 whitespace-nowrap">{{ __('Download Invoice') }} </span><a href="{{ route('site.invoice.print.guest', ['id' => $order->id, 'type' => 'pdf']) }}"><i class="fa fa-download" aria-hidden="true"></i></a>
                </div>
            @endif
        </div>
    </section>

    <section class="mx-5 lg:mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92 mt-10 mb-70p">
        <div>
            <h2 class="dm-bold font-bold text-18 text-gray-12 mb-4 uppercase">
                {{ __('Order Details') }} </h2>
            <div class="border border-gray-2 px-4 md:px-7 rounded">
                <table class="w-full font-semibold text-sm lg:text-base">
                    <thead class="border-b border-gray-2 m-5">
                        <tr>
                            <th class="first:rounded-ts-md pt-6 pb-15p dm-sans font-medium text-gray-12 text-lg md:text-base  ltr:text-left rtl:text-right">{{ __('Products') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orderDetails as $key => $detail)
                        <tr class="font-normal last:border-b-0">
                            <td colspan="2" class="dm-sans font-medium text-gray-12 text-sm {{ $loop->first ? 'pt-6' : ''}} {{ $loop->last ? 'pb-6' : 'pb-3' }}">
                                <div class="flex justify-between flex-col md:flex-row">
                                    <div>
                                        @php
                                            $slug = $detail->product->type == 'Variation' ? $detail->product->parentDetail->slug : $detail->product->slug
                                        @endphp
                                        <a href="{{ !is_null($slug) ? route('site.productDetails', ['slug' => $slug]) : 'javascript:void(0)' }}" target="_blank">{{ $detail->product_name }}</a> <span class="mx-2 text-sm">x</span> {{ formatCurrencyAmount($detail->quantity) }}
                                        @if(isset($detail->vendor->name))
                                            <a href="{{ isset($detail->vendor->shops[0]) ? route('site.shop', ['alias' => $detail->vendor->shops[0]->alias]) : 'javascript:void(0)' }}" target="_blank"><span class="block text-xs roboto-medium font-medium text-gray-10 pt-1">{{ __('Vendor') }}: {{ $detail->vendor->name }}</span></a>
                                        @endif
                                    </div>
                                    <span class="mt-1.5 md:mt-0 {{ $loop->first ? '' : 'align-top'}} dm-sans font-medium text-gray-12 text-sm ltr:md:text-right">{{ formatNumber($detail->price, optional($order->currency)->symbol) }}
                                    </span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="odd:bg-skin-secondary border-t border-gray-2 dm-sans font-medium text-gray-12">
                            <td class="py-6">{{ __('Shipping') }}:
                                @if(!is_null($order->shipping_title))
                                    ({{ $order->shipping_title }})
                                @endif
                            </td>
                            <td class="ltr:text-right rtl:text-left">{{  formatNumber($order->shipping_charge, optional($order->currency)->symbol) }}  <span class="text-[13px] font-normal ps-1.5 inline-block"></span></td>
                        </tr>
                        @if(preference("taxes") == 1)
                        <tr class="odd:bg-skin-secondary border-t border-gray-2 dm-sans font-medium text-gray-12">
                            <td class="py-6">{{ __('Tax') }}:</td>
                            <td class="ltr:text-right rtl:text-left">{{ formatNumber($order->tax_charge, optional($order->currency)->symbol) }} <span class="text-[13px] font-normal ps-1.5 inline-block"></span></td>
                        </tr>
                        @endif
                        @if(isset($order->couponRedeems) && $order->couponRedeems->sum('discount_amount') > 0 && isActive('Coupon'))
                        <tr class="odd:bg-skin-secondary border-t border-gray-2 dm-sans font-medium text-gray-12">
                            <td class="py-6">{{ __('Coupon offer') }}:</td>
                            <td class="ltr:text-right rtl:text-left">{{ formatNumber($order->couponRedeems->sum('discount_amount'), optional($order->currency)->symbol) }} </td>
                        </tr>
                        @endif
                        <tr class="odd:bg-skin-secondary border-t border-gray-2 dm-bold font-bold text-gray-12 text-base md:text-20">
                            <td class="py-6">{{ __('Grand Total') }}: </td>
                            <td class="ltr:text-right rtl:text-left">{{  formatNumber($order->total, optional($order->currency)->symbol) }}</td>
                        </tr>
                        @if(!empty($order->note))
                        <tr class="border-t border-gray-2">
                            <td class="py-6">{{ __('Note') }}: </td>
                            <td class="ltr:text-right rtl:text-left">{{ $order->note }}</td>
                        </tr>
                        @endif
                    </tfoot>
                </table>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <!-- Order Tracking Script JS -->
    @includeIf ('externalcode::layouts.includes.orderConfirmScript')
@endsection
