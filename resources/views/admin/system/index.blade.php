@extends('admin.layouts.app')
@section('page_title', __('System Information'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-block text-center mt-3">
                <i class="feather icon-info f-30 text-c-success"></i>
                <h4 class="f-w-600 mt-2 text-muted text-uppercase">{{ __('System Information') }}</h4>
                <span
                    class="text-muted">{{ __('This page provides a comprehensive overview of your application configuration details.') }}</span>
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-12">
                        <div class="row m-t-30" style="margin-bottom: -17px">
                            <div class="col-6">
                                <div class="d-grid"><a class="btn btn-light sys-info-statu-btn text-uppercase"
                                        href="{{ route('systemInfo.index') }}">{{ __('Status') }}</a></div>
                            </div>
                            <div class="col-6">
                                <div class="d-grid"><a class="btn btn-light sys-info-statu-btn text-uppercase active"
                                        href="{{ route('systemInfo.index', ['info' => 1]) }}">{{ __('Info') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body p-l-15 mt-3">
                <h6 class="mt-2 text-muted text-uppercase f-w-600">{{ __('Application') }}</h6>
                <hr>
                <table class="sys-info-table table table-striped table-hover table-borderless table-responsive">
                    <tbody>
                        @foreach ($application as $key => $value)
                            @php
                                $isAddons = in_array($key, ['active_addons', 'inactive_addons']);
                            @endphp
                            <tr>
                                <td width="40%">{{ ucfirst(str_replace('_', ' ', $key)) }} @if ($isAddons) ({{ $value['count'] }}) @endif</td>

                                @if ($isAddons)
                                    <td width="60%"><span title="{{ $value['names'] }}">{{ trimWords($value['names'], 60) }}</span></td>
                                @elseif ( $key == 'version' )
                                    <td width="60%"><span class="badge badge-info" title="{{ $value }}">{{ $value }}</span></td>
                                @else
                                    <td width="60%"><span title="{{ $value }}">{{ trimWords($value, 60) }}</span></td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h6 class="mt-2 text-muted text-uppercase f-w-600">{{ __('Server') }}</h6>
                <hr>
                <table class="sys-info-table table table-striped table-hover table-borderless table-responsive">
                    <tbody>
                        @foreach ($server as $key => $value)
                            <tr>
                                <td width="40%">{{ ucfirst(str_replace('_', ' ', $key)) }}</td>

                                @if ($value === true)
                                    <td width="60%"><span class="badge badge-success">{{ __('true') }}</span>
                                    </td>
                                @elseif($value === false)
                                    <td width="60%"><span class="badge badge-danger">{{ __('false') }}</span>
                                    </td>
                                @else
                                    <td width="60%"><span
                                            title="{{ $value }}">{{ trimWords($value, 60) }}</span></td>
                                @endif
                            </tr>
                        @endforeach

                    </tbody>
                </table>

                <h6 class="mt-4 text-muted text-uppercase f-w-600">{{ __('Database') }}</h6>
                <hr>
                <table class="sys-info-table table table-striped table-hover table-borderless table-responsive">
                    <tbody>
                        @foreach ($database as $key => $value)
                            <tr>
                                <td width="40%">{{ ucfirst(str_replace('_', ' ', $key)) }}</td>

                                @if (config('martvill.is_demo') && in_array($key, ['database_username', 'database_host', 'database_name']))
                                    <td width="60%">{{ 'xxxxxxx' }}</td>
                                @else
                                    <td width="60%">{{ $value }}</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

