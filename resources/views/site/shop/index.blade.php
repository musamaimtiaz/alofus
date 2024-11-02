@extends('site.layouts.app')
@section('page_title', $vendor->name)
@section('seo')
    @include('site.shop.seo', ['page' => $vendorPage])
@endsection
@section('content')
    <section class="">
        {{-- profile and top benner --}}
        @include('site.shop.top_banner')
        
        @if(empty($vendorPage) || preference('is_vendor_shop_decoration_active', '') != 1)
            {{-- menu items and search --}}
            @include('site.shop.menu')

            <!-- All product section start -->
            @include('site.layouts.section.shop.all-product')
            <!-- All product section end -->
        @else
            @foreach ($vendorPage->components as $component)
                @include('cms::templates.blocks.' . $component->layout->file)
            @endforeach
        @endif
    </section>
@endsection
@section('js')
    <script src="{{ asset('public/dist/js/custom/site/wishlist.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/compare.min.js') }}"></script>
    
    <script>
        const ajaxLoadUrl = "{{ route('vendor.ajax-product') }}"
    </script>
    <script src="{{ asset('public/dist/js/custom/site/home.min.js') }}"></script>
    <script src="{{ asset('public/frontend/assets/slick/slick.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/common.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/wishlist.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/compare.min.js') }}"></script>
@endsection
