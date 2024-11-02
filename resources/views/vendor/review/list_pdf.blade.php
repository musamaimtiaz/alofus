@extends('admin.layouts.list_pdf')

@section('pdf-title')
    <title>{{ __(':x List', ['x' => __('Review')]) }}</title>
@endsection

@section('header-info')
    <td colspan="2" class="tbody-td">
        <p class="title">
            <span class="title-text"></span><strong>{{ __(':x Lists', ['x' => __('Review')]) }}</strong>
        </p>
        <p class="title">
            <span class="title-text">{{ __('Print Date') }}: </span> {{ formatDate(date('d-m-Y')) }}
        </p>
    </td>
@endsection

@section('list-table')
    <table class="list-table">
        <thead class="list-head">
            <tr>
                <td class="text-center list-th"> {{ __('Comment') }} </td>
                <td class="text-center list-th"> {{ __('Product') }} </td>
                <td class="text-center list-th"> {{ __('Customer') }} </td>
                <td class="text-center list-th"> {{ __('Rating') }} </td>
                <td class="text-center list-th"> {{ __('Is Public') }} </td>
                <td class="text-center list-th"> {{ __('Status') }} </td>
                <td class="text-center list-th"> {{ __('Created At') }} </td>
            </tr>
        </thead>
        @foreach ($reviews as $key => $reviews)
            <tr>
                <td class="text-center list-td"> {!! wrapIt($reviews->comments, 10, ['columns' => 3]) !!} </td>
                <td class="text-center list-td"> {!! isset($reviews->product->name) ? wrapIt($reviews->product->name, 10, ['columns' => 3]) : null !!} </td>
                <td class="text-center list-td"> {!! isset($reviews->user->name) ? wrapIt($reviews->user->name, 10, ['columns' => 3]) : null !!} </td>
                <td class="text-center list-td"> {{ $reviews->rating }} </td>
                <td class="text-center list-td"> {{ $reviews->is_public == 0 ? __('No') : __('Yes') }} </td>
                <td class="text-center list-td"> {{ $reviews->status }} </td>
                <td class="text-center list-td"> {{ timeZoneFormatDate($reviews->created_at) }} {{ timeZoneGetTime($reviews->created_at) }} </td>
            </tr>
        @endforeach
    </table>
@endsection
