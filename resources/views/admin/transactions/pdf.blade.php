@extends('admin.layouts.list_pdf')

@section('pdf-title')
<title>{{ __(':x List', ['x' => __('Transaction')]) }}</title>
@endsection

@section('header-info')
<td colspan="2" class="tbody-td">
    <p class="title">
      <span class="title-text"></span><strong>{{ __(':x List', ['x' => __('Transaction')]) }}</strong>
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
            <td class="text-center list-th"> {{ __('User') }} </td>
            <td class="text-center list-th"> {{ __('Currency') }} </td>
            <td class="text-center list-th"> {{ __('Method') }} </td>
            <td class="text-center list-th"> {{ __('Amount') }} </td>
            <td class="text-center list-th"> {{ __('Fee') }} </td>
            <td class="text-center list-th"> {{ __('Total') }} </td>
            <td class="text-center list-th"> {{ __('Type') }} </td>
            <td class="text-center list-th"> {{ __('Status') }} </td>
        </tr>
    </thead>
    @foreach ($transactions as $key => $transaction)
        <tr>
            <td class="text-center list-td"> {{ optional($transaction->user)->name }} </td>
            <td class="text-center list-td"> {{ optional($transaction->currency)->name }} </td>
            <td class="text-center list-td"> {{ optional($transaction->withdrawalMethod)->method_name }} </td>
            <td class="text-center list-td"> {{ formatCurrencyAmount($transaction->amount) }} </td>
            <td class="text-center list-td"> {{ formatCurrencyAmount($transaction->charge_amount + $transaction->commission_amount + $transaction->discount_amount) }} </td>
            <td class="text-center list-td"> {{ formatCurrencyAmount($transaction->total_amount) }} </td>
            <td class="text-center list-td"> {{ $transaction->transaction_type }} </td>
            <td class="text-center list-td"> {{ $transaction->status }} </td>
        </tr>
    @endforeach
</table>
@endsection
