@extends('admin.layouts.list_pdf')

@section('pdf-title')
    <title>{{ __(':x List', ['x' => __('Subscriber')]) }}</title>
@endsection

@section('header-info')
    <td colspan="2" class="tbody-td">
        <p class="title">
            <span class="title-text"></span><strong>{{ __(':x List', ['x' => __('Subscriber')]) }}</strong>
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
            <td class="text-center list-th"> {{ __('Email') }} </td>
            <td class="text-center list-th"> {{ __('Status') }} </td>
            <td class="text-center list-th"> {{ __('Confirmation Date') }} </td>
        </tr>
        </thead>
        @foreach ($subscribers as $key => $subscriber)
            <tr>
                <td class="text-center list-td"> {!! wrapIt($subscriber->email, 20, ['columns' => 1]) !!} </td>
                <td class="text-center list-td"> {{ $subscriber->status }} </td>
                <td class="text-center list-td"> {{ timeZoneFormatDate($subscriber->confirmation_date) }} </td>
            </tr>
        @endforeach
    </table>
@endsection
