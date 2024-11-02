@extends('../site/layouts.app')

@section('page_title', $page->name)

@section('seo')
    @include('site.pages.seo')
@endsection

@section('css')
    @if ($page->css)
        <style>
            {!! $page->css !!}
        </style>
    @endif
@endsection

@section('content')
    @if ($page->css)
    <div>
        {!! $page->description !!}
    </div>
    @else
    <section class="text-gray-600 body-font">
        <div class="mx-4 lg:mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92">
            <div class="flex flex-col text-center w-full mb-10 mt-10">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">{{ $page->name }}</h1>
            </div>
            <div class="blog-page-description">
                {!! $page->description !!}
            </div>
        </div>
    </section>
    @endif
@endsection

