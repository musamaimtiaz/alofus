@extends('admin.layouts.app')
@section('page_title', __('SMS Setup'))

@section('content')
    <!-- Main content -->
    <div class="col-sm-12" id="sms-configuration-settings-container">
        <div class="card min-h-600">
            <div class="card-body row">
                <div class="col-lg-3 ltr:ps-1 ltr:ps-lg-3 ltr:pe-0 rtl:pe-1 rtl:pe-lg-3 rtl:ps-0">
                    @include('admin.layouts.includes.sms-settings-menu')
                </div>
                <div class="col-lg-9 ltr:ps-1 ltr:ps-lg-0 rtl:pe-1 rtl:pe-lg-0">
                    <div class="card card-info shadow-none mb-0">
                        <x-backend.sms.error-message />
                        
                        <x-backend.sms.card-title title="{{ __('Setup') }}" />
                    </div>
                    <div>
                        @foreach (\App\Lib\Menus\Admin\SmsSettings::getConfigs() as $key => $item)
                            <div class="mx-1 mt-4 border">
                                <div class="row my-3 px-1">
                                    <div class="row align-items-center justify-content-center">
                                        <div class="col-auto ml-3">
                                            <img class="img-fluid rounded-circle w-40p" src="{{ asset($item['image']) }}" alt="chat-user" />
                                        </div>
                                        <div class="col">
                                            <div class="d-flex parent-title">
                                                <h6 class="d-inline-block text-muted text-uppercase"><strong>{{ $item['title'] }}</strong>
                                                    @if(config('notification.default_sms_gateway') == $key)<span class="badge badge-mv-secondary f-12 f-w-600">{{ __('Default') }}</span>@endif
                                                </h6>
                                            </div>
                                            <p class="m-b-0 text-muted">{{ $item['description'] }}</p>
                                        </div>
                                        <div class="col-auto text-right">
                                            <a href="{{ $item['link'] }}" class="mt-3 text-c-blue mb-4 text-uppercase">{{ __('Manage') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
@endsection
