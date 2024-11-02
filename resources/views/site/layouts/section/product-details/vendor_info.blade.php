<div class="c-tab mt-8" id="product-vendor-info-panel">
    <div class="c-tab__content">
        <div class="flex flex-wrap">
            <div class="w-46% h-60">
                <img class="w-full h-full object-cover neg-transition-scale" src="{{ optional($vendorDetails->cover)->fileUrl() ?? $vendorDetails->fileUrl() }}" alt="{{ __('Image') }}">
            </div>
            <div class="w-54% ltr:pl-5 rtl:pr-5">
                <div class="flex">
                    <div class="w-60p h-60p border flex justify-center items-center rounded-sm">
                        <img class="w-full h-full" src="{{ optional($vendorDetails->logo)->fileUrl() ?? $vendorDetails->fileUrl() }}" alt="{{ __('Image') }}">
                    </div>
                    <div class="flex flex-col justify-center ltr:pl-15p rtl:pr-15p">
                        <p class="dm-bold text-gray-12 text-lg" >{{ $vendorDetails->name }}</p>

                        <div class="flex items-center cursor-pointer">
                            <ul class="flex rtl-direction-space-left space-x-5p">
                                @for ($i = 1; $i <= 5; $i++)
                                    <li>
                                        <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6.15238 0L7.53368 4.25119H12.0036L8.38736 6.87857L9.76866 11.1298L6.15238 8.50238L2.5361 11.1298L3.9174 6.87857L0.301119 4.25119H4.77109L6.15238 0Z" fill="{{ isset($vendorReview['avg_rating']) && $vendorReview['avg_rating'] >= $i ? ' var(--primary-color) ' : '#C4C4C4' }}"/>
                                        </svg>
                                    </li>
                                @endfor

                            </ul>
                            <span class="roboto-medium font-medium text-sm text-gray-10 pl-2">({{ $vendorReview['total_review'] ?? 0 }} {{ ($vendorReview['total_review'] && $vendorReview['total_review'] > 1) ? __('Reviews') : __('Review') }})</span>
                        </div>
                    </div>
                </div>

                <div class="flex mt-5 roboto-medium text-sm text-gray-10">
                    <p class="w-23%">
                        {{ __('Owner Name') }}:
                    </p>
                    <p class="w-77%">
                        {{ $vendorDetails->name }}
                    </p>
                </div>
               @if(isset($vendorDetails->website) && !is_null($vendorDetails->website))
                <div class="flex mt-5 roboto-medium text-sm text-gray-10">
                    <p class="w-23%">
                        {{ __('Website') }}:
                    </p>
                    <p class="w-23%">
                        {{ $vendorDetails->website }}
                    </p>
                </div>
                @endif
                <div class="flex mt-5 roboto-medium text-sm text-gray-10">
                    <p class="w-23%">
                        {{ __('Phone') }}:
                    </p>
                    <p class="w-77%">
                        {{ $vendorDetails->phone ?? null }}
                    </p>
                </div>
                @if(isset($vendorDetails->shops[0]->alias))
                    <a href="{{ route('site.shop', ['alias' => $vendorDetails->shops[0]->alias]) }}" class="relative text-gray-12 font-medium text-base inline-flex items-center dm-sans justify-end mt-5 process-visit rtl:mr-4 rtl:pr-4">{{ __('Visit Store') }}
                        <svg class="w-4 h-4 mt-0.5 absolute ltr:ml-2 rtl:mr-2" viewBox="0 0 15 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.70696 0L8.29274 1.41421L10.5856 3.70711H0.999849C0.447564 3.70711 -0.000150681 4.15482 -0.000150681 4.70711C-0.000150681 5.25939 0.447564 5.70711 0.999849 5.70711H10.5856L8.29274 8L9.70696 9.41421L14.4141 4.70711L9.70696 0Z" fill="currentColor"></path>
                        </svg>
                    </a>
                @endif

            </div>
        </div>
    </div>

    <div class="flex flex-wrap mt-30p gap-x-30p">
        <div class="relative h-60p ltr:border-r ltr:pr-30p">
            <p class="text-gray-10 text-sm roboto-medium font-medium mt-1">{{ __('Positive Seller Ratings') }}</p>
            <p class="text-xl font-bold mt-3 absolute bottom-0 ml-1 primary-text-color">{{ \App\Models\Product::positiveRating($vendor_id, $id) }}%</p>
        </div>

        <div class="relative border-r h-60p rtl:flex justify-center">
            <p class="text-gray-10 text-sm roboto-medium font-medium mt-1 pr-30p">{{ __('Ship on Time') }}</p>
            <p class="text-xl font-bold mt-3 absolute bottom-0 ml-1 text-green-4">{{ $vendorDetails->onTimeShipment() }}%</p>
        </div>

        <div class="relative h-60p rtl:border-r">
            <p class="text-gray-10 text-sm roboto-medium font-medium mt-1 pr-30p">{{ __('Seller Reviews') }}</p>
            <p class="text-xl font-bold mt-3 absolute bottom-0 ml-1 text-green-4 rtl:pr-30p">{{ $vendorReview['total_review'] ?? 0 }}</p>
        </div>
    </div>
</div>
