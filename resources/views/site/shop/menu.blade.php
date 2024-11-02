<div class="md:flex gap-5 mt-5 mx-0 lg:mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92 relative flex justify-start items-center overflow-auto">
    <div class="border-b mt-10 py-2 border-line">
        <div class="relative flex">
            <div class="{{ Route::currentRouteNamed( 'site.shop' ) ? 'active-vendor text-gray-12' : '' }} relative flex ltr:mr-12 rtl:ml-12 custom-bottom-borders font-medium dm-sans h-6 lg:text-lg text-base cursor-pointer text-gray-10 hover:text-gray-12">
                <a class="md:px-12 whitespace-nowrap" href="{{ route('site.shop', ['alias' => $shop->alias]) }}">
                    {{ __('All Products') }}</a>
            </div>
            <div class="{{ Route::currentRouteNamed( 'site.shop.profile' ) ? 'active-vendor text-gray-12' : '' }} relative flex custom-bottom-borders font-medium dm-sans h-6 lg:text-lg text-base cursor-pointer text-gray-10 hover:text-gray-12">
                <a class="md:px-11 whitespace-nowrap" href="{{ route('site.shop.profile', ['alias' => $shop->alias]) }}"> {{ __('Vendor Profile') }} </a>
            </div>
        </div>
    </div>
</div>
