@extends('admin.layouts.list_pdf')

@section('pdf-title')
    <title>{{ __(':x List', ['x' => __('Brand')]) }}</title>
@endsection

@section('header-info')
    <td colspan="2" class="tbody-td">
        <p class="title">
            <span class="title-text"></span><strong>{{ __(':x Lists', ['x' => __('Brand')]) }}</strong>
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
            <td class="text-center list-th"> {{ __('Name') }} </td>
            <td class="text-center list-th"> {{ __('Description') }} </td>
            <td class="text-center list-th"> {{ __('Status') }} </td>
            <td class="text-center list-th"> {{ __('Created At') }} </td>
        </tr>
        </thead>
        @foreach ($brands as $key => $brands)
            <tr>
                <td class="text-center list-td"> {!! wrapIt($brands->name, 10, ['columns' => 4]) !!} </td>
                <td class="text-center list-td"> {!! wrapIt($brands->description, 10, ['columns' => 4]) !!} </td>
                <td class="text-center list-td"> {{ $brands->status }} </td>
                <td class="text-center list-td"> {{ timeZoneFormatDate($brands->created_at) }} {{ timeZoneGetTime($brands->created_at) }} </td>
            </tr>
        @endforeach
    </table>
@endsection
