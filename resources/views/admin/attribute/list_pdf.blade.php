@extends('admin.layouts.list_pdf')
@section('pdf-title')
    <title>{{ __(':x List', ['x' => __('Attribute')]) }}</title>
@endsection

@section('header-info')
    <td colspan="2" class="tbody-td">
        <p class="title">
            <span class="title-text"></span><strong>{{ __(':x List', ['x' => __('Attribute')]) }}</strong>
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
            <td class="text-center list-th"> {{ __('Attribute Group') }} </td>
            <td class="text-center list-th"> {{ __('Is Filterable') }} </td>
            <td class="text-center list-th"> {{ __('Status') }} </td>
            <td class="text-center list-th"> {{ __('Created At') }} </td>
        </tr>
        </thead>
        @foreach ($attributes as $key => $attribute)
            <tr>
                <td class="text-center list-td"> {!! wrapIt($attribute->name, 10, ['columns' => 2]) !!} </td>
                <td class="text-center list-td"> {!! wrapIt(optional($attribute->attributeGroup)->name, 10, ['columns' => 2]) !!} </td>
                <td class="text-center list-td"> {{ $attribute->is_filterable == "1" ? __("Yes") : __("No"), }} </td>
                <td class="text-center list-td"> {{ $attribute->status }} </td>
                <td class="text-center list-td"> {{ timeZoneFormatDate($attribute->created_at) }} {{ timeZoneGetTime($attribute->created_at) }} </td>
            </tr>
        @endforeach
    </table>
@endsection
