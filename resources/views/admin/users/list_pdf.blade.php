@extends('admin.layouts.list_pdf')

@section('pdf-title')
<title>{{ __(':x List', ['x' => __('User')]) }}</title>
@endsection

@section('header-info')
<td colspan="2" class="tbody-td">
    <p class="title">
      <span class="title-text"></span><strong>{{ __(':x List', ['x' => __('User')]) }}</strong>
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
            <td class="text-center list-th"> {{ __('Role') }} </td>
            <td class="text-center list-th"> {{ __('Status') }} </td>
            <td class="text-center list-th"> {{ __('Created At') }} </td>
        </tr>
    </thead>
    @foreach ($users as $key => $user)
        <tr>
            <td class="text-center list-td"> {!! wrapIt($user->name, 10, ['columns' => 2]) !!} </td>
            <td class="text-center list-td"> {!! wrapIt($user->email, 10, ['columns' => 2]) !!} </td>
            <td class="text-center list-td"> {{ ucfirst($user->role()->name) }} </td>
            <td class="text-center list-td"> {{ ucfirst($user->status) }} </td>
            <td class="text-center list-td"> {{ timeZoneFormatDate($user->created_at) }} {{ timeZoneGetTime($user->created_at) }} </td>
        </tr>
    @endforeach
</table>
@endsection
