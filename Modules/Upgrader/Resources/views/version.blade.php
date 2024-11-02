@extends('admin.layouts.app')
@section('page_title', __('System Information'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-block text-center mt-3">
                <i class="feather icon-airplay f-30 text-c-success"></i>
                <h4 class="f-w-600 mt-2 text-muted text-uppercase">{{ __('System Upgrade') }}</h4>
                <span class="text-muted">{{ __('Current version: ') }}</span> <span class="badge badge-info">{{ config('martvill.file_version', env('MARTVILL_VERSION', '1.0.0')) }}</span>
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-12">
                        <div class="row m-t-30" style="margin-bottom: -17px">
                            <div class="col-6">
                                <div class="d-grid"><a class="btn btn-light sys-info-statu-btn text-uppercase"
                                        href="{{ route('systemUpdate.upgrade') }}">{{ __('Manual') }}</a></div>
                            </div>
                            <div class="col-6">
                                <div class="d-grid"><a class="btn btn-light sys-info-statu-btn text-uppercase active"
                                        href="{{ route('version.check') }}">{{ __('Automatic') }}</a>
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
        @if ($status == 'success')
            <div class="d-flex justify-content-start alert alert-warning">
                <b>{{ __('Before performing an update, it is strongly recommended to create a full backup of your current installation (files and database) and review the changelog') }}
                <a href="https://help.techvill.net/backup-martvill-files-and-database/" target="_blank"><i class="feather icon-external-link"></i> {{ __('See backup documentation') }}</a></b>
            </div>
        @endif
        
        <div class="card">
            <div class="card-body mt-3">
                <form action="{{ route('version.download') }}" method="post">
                    @csrf
                    <input type="hidden" name="version" value="{{ $latestVersion }}">

                    @if ($status == 'success')
                        <div class="form-group row">
                            <div class="col-sm-4 d-flex align-items-center">
                                <label for="">{{ __('Purchase Key/Code') }}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control inputFieldDesign" id="purchaseCode"
                                    name="purchase_code" placeholder="{{ __('Purchase code') }}" required
                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                            </div>
                            <div class="offset-4 col-md-8">
                                <small class="text-muted">
                                    <a class="text-warning" target="_blank" href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-">{{ __('Where Is My Purchase Code?') }}</a>
                                </small>
                            </div>
                        </div>
                    @endif
                    
                    <div class="form-group row mb-0">
                        <div class="col-sm-4">
                            <label for="">{{ __('Current version') }}</label>
                        </div>
                        <div class="col-md-8">
                            <p>{{ $currentVersion }}</p>
                        </div>
                    </div>
                    
                    <div class="form-group row mb-0">
                        <div class="col-sm-4">
                            <label for="">{{ __('Latest version') }}</label>
                        </div>
                        <div class="col-md-8">
                            <p>{{ $latestVersion }}</p>
                        </div>
                    </div>
                    
                    <div class="form-group row mb-0">
                        <div class="col-sm-4 d-flex align-items-center">
                            <label for="">{{ __('Status') }}</label>
                        </div>
                        <div class="col-md-8">
                            @if ($status == 'success')
                                <div class="text-center text-danger font-bold">
                                    <div class="d-flex align-items-center">
                                        <span class="feather icon-alert-octagon f-20 me-2 mt-1"></span>
                                        <p class="mb-1 mt-2">{{ __('An update version is available') }}</p>
                                    </div>
                                </div>
                            @else
                                <div class="text-center text-success font-bold">
                                    <div class="d-flex align-items-center">
                                        <span class="feather icon-check-circle f-20 me-2 mt-1"></span>
                                        <p class="mb-1 mt-2">{{ __('Your system is up to date.') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    @if ($status == 'success')
                        <div class="col-sm-12 px-0 m-l-10 mt-3 pr-0 d-flex justify-content-end">
                            <a href="{{ route('dashboard') }}" class="btn custom-btn-cancel all-cancel-btn" type="submit">{{ __('Cancel') }}</a>
                            <button class="btn custom-btn-submit" type="submit">{{ __('Download Now') }}</button>
                        </div>
                    @endif

                    @if (session('status') == 'fail')
                        <div class="col-sm-12 mt-4">
                            {!! session('message') !!}
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
    <script src="{{ asset('Modules/Upgrader/Resources/assets/js/update.min.js') }}"></script>
@endsection
