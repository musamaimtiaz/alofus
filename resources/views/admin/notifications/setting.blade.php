@extends('admin.layouts.app')
@section('page_title', __('Notifications Setting'))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/dist/css/notification.min.css') }}">
@endsection
@section('content')
<!-- Main content -->
<div class="col-sm-12 list-container" id="notification-setting-list-container">
    <div class="card">
        <div class="card-body row">
            <div
                class="col-lg-3 col-12 z-index-10  ltr:ps-md-3 ltr:pe-0 ltr:ps-0 rtl:pe-md-3 rtl:ps-0 rtl:pe-0">
                @include('admin.layouts.includes.account_settings_menu')
            </div>
            <div class="col-lg-9 col-12 ltr:ps-0 rtl:pe-0">
                <div class="card card-info shadow-none mb-0">
                    <div class="card-header p-t-20 border-bottom">
                        <h5> {{ __('Notifications Setting') }} </h5>
                    </div>

                    <div class="card-body p-0 role-table">
                        <div class="card-block pt-0 px-2">
                            <div class="col-sm-12">
                                <table class="table text-center myTable role-permission-table">
                                    <thead class="thead-sticky table-header">
                                        <tr>
                                            <th class="text-left" width="27%">{{ __('Notification') }}</th>
                                            @php
                                                $columnWidth = intval(80 / count($channels)) . '%';
                                            @endphp

                                            @foreach ($channels as $channel)
                                                <th width="{{ $columnWidth }}">{{ $channel }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($classes as $class)
                                            <tr data-bs-toggle="collapse"
                                                class="accordion-toggle"
                                                data-bs-target="#demo10">
                                                <td width="27%" class="text-left">
                                                    <span class="d-block">{{ $class['label'] }}</span>
                                                </td>

                                                @foreach ($channels as $orginalChannel => $formatedChannel)
                                                    <td class="text-center" width="{{ $columnWidth }}">
                                                        @php
                                                            $settingKey = $class['class'] . '_' . $orginalChannel;
                                                            $isKeyExist = array_key_exists($settingKey, $settings);
                                                        @endphp
                                                        
                                                        @if (! in_array($orginalChannel, $class['channel']))
                                                            <span><i class="fas fa-times p-icon neg-transition-scale"></i></span>
                                                        @else                             
                                                            <span class="prms"
                                                                data-notification_type="{{ $class['class'] }}"
                                                                data-channel="{{ $orginalChannel }}">
                                                                <i class="fas {{ $isKeyExist && $settings[$settingKey] == '1' ? 'fa-check text-success' : 'fa-times text-danger' }} p-icon p-prms cursor_pointer"
                                                                    id="p_icon_{{ class_basename($class['class']) }}_{{ class_basename($orginalChannel) }}"></i>
                                                            </span>
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="{{ asset('public/dist/js/custom/notification.min.js') }}"></script>
@endsection
