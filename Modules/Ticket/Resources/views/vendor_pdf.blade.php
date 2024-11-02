@extends('admin.layouts.list_pdf')

@section('pdf-title')
<title>{{ __('Ticket Lists') }}</title>
@endsection

@section('header-info')
<td colspan="2" class="tbody-td">
    <p class="title">
      <span class="title-text"></span><strong>{{ __('Ticket Lists') }}</strong>
    </p>
    @if (isset($departmentSelected) && !empty($departmentSelected))
    <p class="title">
      <span class="title-text">{{ __('Department:') }} </span>{{ $departmentSelected->name }}
    </p>
    @endif
    @if (isset($statusSelected) && !empty($statusSelected))
    <p class="title">
      <span class="title-text">{{ __('Department:') }} </span>{{ $statusSelected->name }}
    </p>
    @endif
    @if (isset($date_range) && !empty($date_range))
      <p class="title">
        <span class="title-text">{{ __('Period:') }} </span> {{ $date_range }}
      </p>
    @endif
    <p class="title">
      <span class="title-text">{{ __('Print Date:') }} </span> {{ formatDate(date('d-m-Y')) }}
    </p>
</td>
@endsection

@section('list-table')
<table class="list-table">
    <thead class="list-head">
        <tr>
          <td class="text-center list-td"> {{ __('Subject') }} </td>
          <td class="text-center list-td"> {{ __('Department') }} </td>
          <td class="text-center list-td"> {{ __('Status') }} </td>
          <td class="text-center list-td"> {{ __('Priority') }} </td>
          <td class="text-center list-td"> {{ __('Last Reply') }} </td>
          <td class="text-center list-td"> {{ __('Created at') }} </td>
        </tr>
    </thead>
    @foreach ($ticketList as $data)
      <tr>
        <td class="text-center list-td"> {{ $data->subject }}</td>
        <td class="text-center list-td"> {{ optional($data->department)->name }} </td>
        <td class="text-center list-td"> {{ optional($data->threadStatus)->name }} </td>
        <td class="text-center list-td"> {{ optional($data->priority)->name }} </td>
        <td class="text-center list-td">
        @if ($data->last_reply && $data->last_reply != $data->date)
          {{ timeZoneFormatDate($data->last_reply) }}<br>{{ timeZoneGetTime($data->last_reply) }}
        @else
          {{ __('Not Reply Yet') }}
        @endif
        </td>
        <td class="text-center list-td"> {{ timeZoneFormatDate($data->date) }}<br>{{ timeZoneGetTime($data->date) }} </td>
      </tr>
    @endforeach
</table>
@endsection
