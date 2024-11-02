@extends('admin.layouts.list_pdf')

@section('pdf-title')
    <title>{{ __(':x List', ['x' => __('Coupon')]) }}</title>
@endsection

@section('header-info')
    <td colspan="2" class="tbody-td">
        <p class="title">
            <span class="title-text"></span><strong>{{ __(':x List', ['x' => __('Coupon')]) }}</strong>
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
            <td class="text-center list-th"> {{ __('Code') }} </td>
            <td class="text-center list-th"> {{ __('Discount Type') }} </td>
            <td class="text-center list-th"> {{ __('Discount Amount') }} </td>
            <td class="text-center list-th"> {{ __('Start Date') }} </td>
            <td class="text-center list-th"> {{ __('End Date') }} </td>
            <td class="text-center list-th"> {{ __('Status') }} </td>
        </tr>
        </thead>
        @foreach ($coupons as $key => $coupon)
            <tr>
                <td class="text-center list-td"> {!! wrapIt($coupon->name, 10, ['columns' => 2]) !!} </td>
                <td class="text-center list-td"> {!! wrapIt($coupon->code, 10, ['columns' => 2]) !!} </td>
                <td class="text-center list-td"> {{ $coupon->discount_type }} </td>
                <td class="text-center list-td"> {{ formatCurrencyAmount($coupon->discount_amount) }} </td>
                <td class="text-center list-td"> {{ timeZoneFormatDate($coupon->start_date) }} </td>
                <td class="text-center list-td"> {{ timeZoneFormatDate($coupon->end_date) }} </td>
                <td class="text-center list-td"> {{ $coupon->status }} </td>
            </tr>
        @endforeach
    </table>
@endsection
