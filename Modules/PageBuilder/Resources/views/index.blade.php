@extends('pagebuilder::layouts.master')
@section('page_title', $page->name)
@section('content')
    <div class="notification-msg-bar smoothly-hide">
        <div class="noti-alert pad">
            <div class="alert bg-dark text-light m-0 text-center">
                <span class="notification-msg"></span>
            </div>
        </div>
    </div>

    <div class="editor-row">
        <div class="editor-canvas">
            <div id="gjs" class="overflow-hidden h-100vh">
                {!! $page->description !!}
                <style>
                    {!! $page->css !!}
                </style>
            </div>
        </div>
    </div>
@endsection



@push('scripts')
    <script>
        var pageStoreUrl = '{{ route('pb.store', ['slug' => $page->slug]) }}';
        var uploadImage = '{{ route('pb.store-image') }}';
        var pagePreviewUrl = '{{ route('site.page', $page->slug) }}';
        var images = @json($images);
    </script>
    <script src="{{ asset('Modules/PageBuilder/Resources/assets/js/grape.min.js') }}"></script>
    <script src="{{ asset('Modules/PageBuilder/Resources/assets/js/grapejs-preset-webpage.min.js') }}"></script>
    <script src="{{ asset('Modules/PageBuilder/Resources/assets/js/block-basic.min.js') }}"></script>
    <script src="{{ asset('Modules/PageBuilder/Resources/assets/js/grape-tabs.min.js') }}"></script>
    <script src="{{ asset('Modules/PageBuilder/Resources/assets/js/custom-code.min.js') }}"></script>
    <script src="{{ asset('Modules/PageBuilder/Resources/assets/js/css-perser.min.js') }}"></script>
    <script src="{{ asset('Modules/PageBuilder/Resources/assets/js/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('Modules/PageBuilder/Resources/assets/js/grape-rich-editor.min.js') }}"></script>
    <script src="{{ asset('Modules/PageBuilder/Resources/assets/js/sharedspace.min.js') }}"></script>
    <script src="{{ asset('Modules/PageBuilder/Resources/assets/js/grape-form.min.js') }}"></script>
    <script src="{{ asset('Modules/PageBuilder/Resources/assets/js/grape-tailwind.min.js') }}"></script>
    <script src="{{ asset('Modules/PageBuilder/Resources/assets/js/app.min.js') }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('Modules/PageBuilder/Resources/assets/css/grapejs.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/PageBuilder/Resources/assets/css/grapejs-preset.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/PageBuilder/Resources/assets/css/pagebuilder.min.css') }}">
@endpush
