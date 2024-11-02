@extends('../site/layouts.app')

@section('page_title', __('Order Track'))
@section('content')
<div class="mx-4 lg:mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92">
    <div class="pt-38p">
        <p class="text-gray-12 text-18 roboto-medium"><span>{{ __('Order Reference') }}</span></p>
        <span class="primary-text-color dm-bold text-32">{{ $order->reference }}</span>
        @guest
            <p>{!! __('For more details, :x', ['x' => '<a href="javascript:void(0)" class="underline font-bold open-login-modal">' . __('please login to your account.') . '</a>']) !!}</p>
        @endguest
    </div>
    <div class="grid grid-cols-2 gap-4 sm:flex sm:flex-wrap mt-30p">
        <div class="md:pr-38p md:border-r">
            <span class="text-gray-10 text-13 roboto-medium">{{ __('ORDER DATE') }}</span>
            <p class="text-gray-12 text-18 dm-sans mt-5p">{{ $order->order_date }}</p>
        </div>
        <div class="sm:pr-11 sm:pl-29p md:border-r">
            <span class="text-gray-10 text-13 roboto-medium">{{ __('STATUS') }}</span>
            <p class="text-gray-12 text-18 dm-sans mt-5p">{{ optional($order->orderStatus)->name }}</p>
        </div>
        <div class="sm:pr-11 sm:pl-29p md:border-r">
            <span class="text-gray-10 text-13 roboto-medium">{{ __('PAYMENT STATUS') }}</span>
            <p class="text-gray-12 text-18 dm-sans mt-5p">{{ $order->payment_status }}</p>
        </div>
        <div class="md:pr-11 md:pl-29p pr-29p pl-0">
            <span class="text-gray-10 text-13 roboto-medium">{{ __('TOTAL') }}</span>
            <p class="text-gray-12 text-18 dm-sans mt-5p">{{ formatNumber($order->total) }}</p>
        </div>
    </div>
    <div class="mt-58p">
        <p class="text-gray-12 dm-bold lg:text-20 text-13">{{ __('ORDER DETAILS') }}</p>
    </div>
    <div class="flex flex-col border border-gray-2 px-29p w-full pt-4 pb-5 rounded mt-8 mb-60p">
        <p class="mb-13p mt-1p"><span class="dm-sans text-gray-12 text-base">{{ __('Products') }}</span></p>
        <div class="w-full border-b border-gray-2"></div>
        @foreach ($order->orderDetails as $item)
            @php
                $vendor = $item->vendor;
                if (is_null($item->parent_id)) {
                    $product = $item->product;
                } else {
                    $product = $item->parentProduct;
                }
            @endphp
            <div class="flex flex-row justify-between mt-19p">
                <div class="flex flex-col">
                    <p class="dm-sans text-gray-12 text-sm">
                        @if (optional($product)->slug)
                            <a href="{{ route('site.productDetails', ['slug' => $product->slug]) }}">{{ $item->product_name }}</a>
                        @else
                            <span>{{ $item->product_name }}</span>
                        @endif
                        <span class="px-4">x</span>
                        <span>{{ (int) $item->quantity }}</span>
                    </p>
                    <p class="text-gray-10 roboto-medium text-xs mt-3p">
                        @if (!is_null(optional($vendor)->name))
                            <span>{{ __('Vendor') }}</span>
                            <span class="px-1">:</span>
                            <a href="{{ route('site.shop', ['alias' => $vendor->shops->first()->alias]) }}" class="text-gray-600">{{ $vendor->name }}</a>
                        @endif
                    </p>
                </div>
                <div class="right-side">
                    <span class="dm-sans text-gray-12 text-sm">{{ formatNumber($item->price * $item->quantity) }}</span>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

