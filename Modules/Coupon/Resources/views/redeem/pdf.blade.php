@extends('admin.layouts.list_pdf')

@section('pdf-title')
    <title>{{ __(':x List', ['x' => __('Coupon Redeem')]) }}</title>
@endsection

@section('header-info')
    <td colspan="2" class="tbody-td">
        <p class="title">
            <span class="title-text"></span><strong>{{ __(':x List', ['x' => __('Coupon Redeem')]) }}</strong>
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
            <td class="text-center list-th"> {{ __('Coupon') }} </td>
            <td class="text-center list-th"> {{ __('Customer') }} </td>
            <td class="text-center list-th"> {{ __('Order') }} </td>
            <td class="text-center list-th"> {{ __('Discount Amount') }} </td>
            <td class="text-center list-th"> {{ __('Created at') }} </td>
        </tr>
        </thead>
        @foreach ($redeems as $key => $redeem)
            <tr>
                <td class="text-center list-td"> {!! wrapIt($redeem->coupon_code, 10, ['columns' => 2]); !!} </td>
                <td class="text-center list-td"> {!! wrapIt($redeem->user_name, 10, ['columns' => 2]) !!} </td>
                <td class="text-center list-td"> {{ $redeem->order_code }} </td>
                <td class="text-center list-td"> {{ formatNumber($redeem->discount_amount) }} </td>
                <td class="text-center list-td"> {{ $redeem->format_created_at }} </td>
            </tr>
        @endforeach
    </table>
@endsection
