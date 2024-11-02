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
            <td class="text-center list-th"> {{ __('Order') }} </td>
            <td class="text-center list-th"> {{ __('Customer') }} </td>
            <td class="text-center list-th"> {{ __('Vendor') }} </td>
            <td class="text-center list-th"> {{ __('Total') }} </td>
            <td class="text-center list-th"> {{ __('Order Status') }} </td>
            <td class="text-center list-th"> {{ __('Payment Status') }} </td>
            <td class="text-center list-th"> {{ __('Created') }} </td>
        </tr>
        </thead>
        @foreach ($orders as $key => $order)
            <tr>
                <td class="text-center list-td"> {{ $order->reference }} </td>
                <td class="text-center list-td"> {!! wrapIt(optional($order->user)->name, 10, ['columns' => 1]) !!} </td>
                <td class="text-center list-td"> {{ $order->vendorName($order->id) }} </td>
                <td class="text-center list-td"> {{ formatNumber($order->total) }} </td>
                <td class="text-center list-td"> {{ optional($order->orderStatus)->name }} </td>
                <td class="text-center list-td"> {{ $order->paymentStatus($order->total, $order->paid) }} </td>
                <td class="text-center list-td"> {{ timeZoneFormatDate($order->created_at) }} {{ timeZoneGetTime($order->created_at) }} </td>
            </tr>
        @endforeach
    </table>
@endsection
