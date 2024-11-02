@extends('admin.layouts.list_pdf')

@section('pdf-title')
    <title>{{ __(':x List', ['x' => __('Attribute Group')]) }}</title>
@endsection

@section('header-info')
    <td colspan="2" class="tbody-td">
        <p class="title">
            <span class="title-text"></span><strong>{{ __(':x List', ['x' => __('Attribute Group')]) }}</strong>
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
            <td class="text-center list-th"> {{ __('Vendor') }} </td>
            <td class="text-center list-th"> {{ __('Summary') }} </td>
            <td class="text-center list-th"> {{ __('Status') }} </td>
            <td class="text-center list-th"> {{ __('Created At') }} </td>
        </tr>
        </thead>
        @foreach ($attributeGroup as $key => $groups)
            <tr>
                <td class="text-center list-td"> {{ $groups->name }} </td>
                <td class="text-center list-td"> {{ optional($groups->vendor)->name }} </td>
                <td class="text-center list-td"> {{ $groups->summary }} </td>
                <td class="text-center list-td"> {{ $groups->status }} </td>
                <td class="text-center list-td"> {{ timeZoneFormatDate($groups->created_at) }} {{ timeZoneGetTime($groups->created_at) }} </td>
            </tr>
        @endforeach
    </table>
@endsection
