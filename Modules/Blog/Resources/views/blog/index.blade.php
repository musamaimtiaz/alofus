@extends('admin.layouts.app')
@section('page_title', __('Blogs'))
@section('css')
    <link rel="stylesheet" href="{{ asset('Modules/Blog/Resources/assets/css/blog.min.css') }}">
@endsection
@section('content')

    <!-- Main content -->
    <div class="col-sm-12 list-container" id="blog-list-container">
        <div class="card">
            <div class="card-header bb-none pb-0">
                <h5>{{ __('Blogs') }}</h5>
                <x-backend.group-filters :groups="$groups" :column="'status'" />
                <div class="card-header-right my-2 mx-md-0 mx-sm-4">
                    <x-backend.button.batch-delete />
                    @if (in_array('Modules\Blog\Http\Controllers\BlogController@create', $prms))
                        <x-backend.button.add-new href="{{ route('blog.create') }}" />
                    @endif
                    <x-backend.button.filter />
                </div>
            </div>

            <x-backend.datatable.filter-panel>
                <div class="col-md-6">
                    <x-backend.datatable.input-search />
                </div>
                <div class="col-md-3">
                    <select class="select2 filter" name="category_id">
                        <option value="">{{ __('All Category') }}</option>
                        @foreach ($categorize as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="select2 filter" name="author_id">
                        <option value="">{{ __('All Author') }}</option>
                        @foreach ($authors as $author)
                            <option value="{{ $author->id }}">{{ $author->name }}</option>
                        @endforeach
                    </select>
                </div>
            </x-backend.datatable.filter-panel>

            <x-backend.datatable.table-wrapper class="need-batch-operation" data-namespace="\Modules\Blog\Http\Models\Blog"
                data-column="id">
                @include('admin.layouts.includes.yajra-data-table')
            </x-backend.datatable.table-wrapper>
            @include('admin.layouts.includes.delete-modal')
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('public/dist/js/moment.min.js') }}"></script>
    <script src="{{ asset('Modules/Blog/Resources/assets/js/blog.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/yajra-export.min.js') }}"></script>
@endsection
