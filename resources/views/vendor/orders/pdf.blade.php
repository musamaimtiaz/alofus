@extends('admin.layouts.list_pdf')

@section('pdf-title')
    <title>{{ __(':x List', ['x' => __('Order')]) }}</title>
@endsection

@section('header-info')
    <td colspan="2" class="tbody-td">
        <p class="title">
            <span class="title-text"></span><strong>{{ __(':x Lists', ['x' => __('Order')]) }}</strong>
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
            <td class="text-center list-th"> {{ __('Invoice') }} </td>
            <td class="text-center list-th"> {{ __('Customer') }} </td>
            <td class="text-center list-th"> {{ __('Number of Products') }} </td>
            <td class="text-center list-th"> {{ __('Total Amount') }} </td>
            <td class="text-center list-th"> {{ __('Status') }} </td>
            <td class="text-center list-th"> {{ __('Payment Status') }} </td>
            <td class="text-center list-th"> {{ __('Created at') }} </td>
        </tr>
        </thead>
        @foreach ($orders as $key => $order)
            <tr>
                <td class="text-center list-td"> {{ $order->reference }} </td>
                <td class="text-center list-td"> {!! wrapIt(optional($order->user)->name, 10, ['columns' => 1]) !!} </td>
                <td class="text-center list-td"> {{ formatCurrencyAmount($order->getTotalVendorProduct(session()->get('vendorId'), $order->id)) }} </td>
                <td class="text-center list-td"> {{ formatCurrencyAmount($order->vendorProductPrice(session()->get('vendorId'), $order->id)) }} </td>
                <td class="text-center list-td"> {{ $order->status }} </td>
                <td class="text-center list-td"> {{ $order->paymentStatus($order->total, $order->paid) }} </td>
                <td class="text-center list-td"> {{ timeZoneFormatDate($order->created_at) }} {{ timeZoneGetTime($order->created_at) }} </td>
            </tr>
        @endforeach
    </table>
@endsection
