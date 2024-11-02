@extends('vendor.layouts.list_pdf')

@section('pdf-title')
    <title>{{ __(':x List', ['x' => __('Withdrawal')]) }}</title>
@endsection

@section('header-info')
    <td colspan="2" class="tbody-td">
        <p class="title">
            <span class="title-text"></span><strong>{{ __(':x Lists', ['x' => __('Withdrawal')]) }}</strong>
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
            <td class="text-center list-th"> {{ __('Currency') }} </td>
            <td class="text-center list-th"> {{ __('Method') }} </td>
            <td class="text-center list-th"> {{ __('Amount') }} </td>
            <td class="text-center list-th"> {{ __('Fee') }} </td>
            <td class="text-center list-th"> {{ __('Total') }} </td>
            <td class="text-center list-th"> {{ __('Type') }} </td>
            <td class="text-center list-th"> {{ __('Date') }} </td>
            <td class="text-center list-th"> {{ __('Updated At') }} </td>
            <td class="text-center list-th"> {{ __('Status') }} </td>
        </tr>
        </thead>
        @foreach ($withdrawals as $key => $withdrawal)
            <tr>
                <td class="text-center list-td"> {{ optional($withdrawal->currency)->name }} </td>
                <td class="text-center list-td"> {{ optional($withdrawal->withdrawalMethod)->method_name }} </td>
                <td class="text-center list-td"> {{ formatCurrencyAmount($withdrawal->amount) }} </td>
                <td class="text-center list-td"> {{ formatCurrencyAmount($withdrawal->charge_amount + $withdrawal->commission_amount + $withdrawal->discount_amount) }} </td>
                <td class="text-center list-td"> {{ formatCurrencyAmount($withdrawal->total_amount) }} </td>
                <td class="text-center list-td"> {{ $withdrawal->transaction_type }} </td>
                <td class="text-center list-td"> {{ timeZoneFormatDate($withdrawal->transaction_date) }} </td>
                <td class="text-center list-td"> {{ !empty($withdrawal->updated_at) ? timeZoneFormatDate($withdrawal->updated_at) . timeZoneGetTime($withdrawal->updated_at) : '' }}  </td>
                <td class="text-center list-td"> {{ $withdrawal->status }} </td>
            </tr>
        @endforeach
    </table>
@endsection
