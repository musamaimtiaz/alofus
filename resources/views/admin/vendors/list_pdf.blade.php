@extends('admin.layouts.list_pdf')

@section('pdf-title')
    <title>{{ __(':x List', ['x' => __('Vendor')]) }}</title>
@endsection

@section('header-info')
    <td colspan="2" class="tbody-td">
        <p class="title">
            <span class="title-text"></span><strong>{{ __(':x List', ['x' => __('Vendor')]) }}</strong>
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
                <td class="text-center list-th"> {{ __('Email') }} </td>
                <td class="text-center list-th"> {{ __('Phone') }} </td>
                <td class="text-center list-th"> {{ __('Formal Name') }} </td>
                <td class="text-center list-th"> {{ __('Website') }} </td>
                <td class="text-center list-th"> {{ __('Status') }} </td>
                <td class="text-center list-th"> {{ __('Created At') }} </td>
            </tr>
        </thead>
        @foreach ($vendors as $key => $vendor)
            <tr>
                <td class="text-center list-td"> {!! wrapIt($vendor->name, 10, ['columns' => 5]) !!} </td>
                <td class="text-center list-td"> {!! wrapIt($vendor->email, 10, ['columns' => 5]) !!} </td>
                <td class="text-center list-td"> {!! wrapIt($vendor->phone, 10, ['columns' => 5]) !!} </td>
                <td class="text-center list-td"> {!! wrapIt($vendor->formal_name, 10, ['columns' => 5]) !!} </td>
                <td class="text-center list-td"> {!! wrapIt($vendor->website, 10, ['columns' => 5]) !!} </td>
                <td class="text-center list-td"> {{ $vendor->status }} </td>
                <td class="text-center list-td"> {{ timeZoneFormatDate($vendor->created_at) }} {{ timeZoneGetTime($vendor->created_at) }} </td>
            </tr>
        @endforeach
    </table>
@endsection
