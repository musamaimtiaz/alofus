@extends('site.layouts.app')

@section('page_title', $page->name)

@section('seo')
    <meta name="robots" content="index, follow">
    <meta name="title" content="{{ $page->meta_title ?? $page->title }}">
    <meta name="description" content="{{ $page->meta_description }}" />
    <meta name="keywords" content="">

    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $page->meta_title ?? $page->title }}">
    <meta itemprop="description" content="{{ $page->meta_description }}">
    <meta itemprop="image" content="{{ $page->fileUrl() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $page->meta_title ?? $page->title }}">
    <meta property="og:description" content="{{ $page->meta_description }}">
    <meta property="og:image" content="{{ $page->fileUrl() }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $page->meta_title ?? $page->title }}">
    <meta property="twitter:description" content="{{ $page->meta_description }}">
    <meta property="twitter:image" content="{{ $page->fileUrl() }}">
@endsection


@section('content')
    @foreach ($page->components as $component)
        @include('cms::templates.blocks.' . $component->layout->file)
    @endforeach
@endsection

@section('js')
    <script>
        const ajaxLoadUrl = "{{ route('ajax-product') }}"
    </script>
    <script src="{{ asset('public/dist/js/custom/site/home.min.js') }}"></script>
    <script src="{{ asset('public/frontend/assets/slick/slick.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/common.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/wishlist.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/compare.min.js') }}"></script>
@endsection
