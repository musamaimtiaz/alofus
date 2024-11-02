@extends('admin.layouts.list_pdf')

@section('pdf-title')
    <title>{{ __(':x List', ['x' => __('Product')]) }}</title>
@endsection

@section('header-info')
    <td colspan="2" class="tbody-td">
        <p class="title">
            <span class="title-text"></span><strong>{{ __(':x Lists', ['x' => __('Product')]) }}</strong>
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
            <td class="text-center list-th"> {{ __('Category') }} </td>
            <td class="text-center list-th"> {{ __('Brand') }} </td>
            <td class="text-center list-th"> {{ __('Vendor') }} </td>
            <td class="text-center list-th"> {{ __('Product Code') }} </td>
            <td class="text-center list-th"> {{ __('SKU') }} </td>
            <td class="text-center list-th"> {{ __('Price') }} </td>
            <td class="text-center list-th"> {{ __('Created At') }} </td>
        </tr>
        </thead>
        @foreach ($items as $key => $item)
            <tr>
                <td class="text-center list-td"> {{ $item->name }} </td>
                <td class="text-center list-td"> {{ optional(optional($item->productCategory)->category)->name }} </td>
                <td class="text-center list-td"> {{ optional($item->brand)->name }} </td>
                <td class="text-center list-td"> {{ optional($item->vendor)->name }} </td>
                <td class="text-center list-td"> {{ $item->code }} </td>
                <td class="text-center list-td"> {{ $item->sku }} </td>
                <td class="text-center list-td"> {{ $item->price }} </td>
                <td class="text-center list-td"> {{ timeZoneFormatDate($item->created_at) }} {{ timeZoneGetTime($item->created_at) }} </td>
            </tr>
        @endforeach
    </table>
@endsection
