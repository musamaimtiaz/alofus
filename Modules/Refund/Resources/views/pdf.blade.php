@extends('admin.layouts.list_pdf')

@section('pdf-title')
    <title>{{ __(':x List', ['x' => __('Refund')]) }}</title>
@endsection

@section('header-info')
    <td colspan="2" class="tbody-td">
        <p class="title">
            <span class="title-text"></span><strong>{{ __(':x List', ['x' => __('Refund')]) }}</strong>
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
            <td class="text-center list-th"> {{ __('Order Id') }} </td>
            <td class="text-center list-th"> {{ __('Shipping') }} </td>
            <td class="text-center list-th"> {{ __('Refund Reason') }} </td>
            <td class="text-center list-th"> {{ __('Refund Method') }} </td>
            <td class="text-center list-th"> {{ __('Quantity') }} </td>
            <td class="text-center list-th"> {{ __('Amount') }} </td>
            <td class="text-center list-th"> {{ __('Status') }} </td>
        </tr>
        </thead>
        @foreach ($refunds as $key => $refund)
            <tr>
                <td class="text-center list-td"> {{ optional(optional($refund->orderDetail)->order)->reference }} </td>
                <td class="text-center list-td"> {{ $refund->shipping_method }} </td>
                <td class="text-center list-td"> {{ optional($refund->refundReason)->name }} </td>
                <td class="text-center list-td"> {{ $refund->refund_method }} </td>
                <td class="text-center list-td"> {{ $refund->quantity_sent }} </td>
                <td class="text-center list-td"> {{ formatNumber(optional($refund->orderDetail)->price) }} </td>
                <td class="text-center list-td"> {{ $refund->status }} </td>
            </tr>
        @endforeach
    </table>
@endsection
