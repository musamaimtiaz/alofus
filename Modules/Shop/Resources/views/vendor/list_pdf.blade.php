@extends('vendor.layouts.list_pdf')

@section('pdf-title')
    <title>{{ __(':x List', ['x' => __('Shop')]) }}</title>
@endsection

@section('header-info')
    <td colspan="2" class="tbody-td">
        <p class="title">
            <span class="title-text"></span><strong>{{ __(':x List', ['x' => __('Shop')]) }}</strong>
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
            <td class="text-center list-th"> {{ __('Shop Name') }} </td>
            <td class="text-center list-th"> {{ __('Vendor') }} </td>
            <td class="text-center list-th"> {{ __('Email') }} </td>
            <td class="text-center list-th"> {{ __('Website') }} </td>
            <td class="text-center list-th"> {{ __('Phone') }} </td>
            <td class="text-center list-th"> {{ __('Status') }} </td>
            <td class="text-center list-th"> {{ __('Created') }} </td>
        </tr>
        </thead>
        @foreach ($shops as $key => $shop)
            <tr>
                <td class="text-center list-td"> {!! wrapIt($shop->name, 10, ['columns' => 5]) !!} </td>
                <td class="text-center list-td"> {!! wrapIt($shop->vendor->name, 10, ['columns' => 5]) !!} </td>
                <td class="text-center list-td"> {!! wrapIt($shop->email, 10, ['columns' => 5]) !!} </td>
                <td class="text-center list-td"> {!! wrapIt($shop->website, 10, ['columns' => 5]) !!} </td>
                <td class="text-center list-td"> {!! wrapIt($shop->phone, 10, ['columns' => 5]) !!} </td>
                <td class="text-center list-td"> {{ $shop->status }} </td>
                <td class="text-center list-td"> {{ timeZoneFormatDate($shop->created_at) }} </td>
            </tr>
        @endforeach
    </table>
@endsection
