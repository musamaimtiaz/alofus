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
        @foreach ($products as $key => $product)
            <tr>
                <td class="text-center list-td"> {!! wrapIt($product->name, 10, ['columns' => 6]) !!} </td>
                <td class="text-center list-td"> {!! wrapIt(optional($product->productCategory->category)->name, 10, ['columns' => 6]) !!} </td>
                <td class="text-center list-td"> {!! wrapIt(optional($product->brand)->name , 10, ['columns' => 6]) !!} </td>
                <td class="text-center list-td"> {!! wrapIt(optional($product->vendor)->name, 10, ['columns' => 6]) !!} </td>
                <td class="text-center list-td"> {!! wrapIt($product->code, 10, ['columns' => 6]) !!} </td>
                <td class="text-center list-td"> {!! wrapIt($product->sku, 10, ['columns' => 6]) !!} </td>
                <td class="text-center list-td"> {{ $product->price }} </td>
                <td class="text-center list-td"> {{ timeZoneFormatDate($product->created_at) }} {{ timeZoneGetTime($product->created_at) }} </td>
            </tr>
        @endforeach
    </table>
@endsection
