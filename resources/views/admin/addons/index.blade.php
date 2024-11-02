@extends('admin.layouts.app')
@section('page_title', __('Addons'))
@section('content')
    <!-- Main content -->
    <div class="col-sm-12 list-container" id="brand-list-container">
        @include('addons::index')
    </div>
@endsection
