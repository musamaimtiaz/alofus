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
                                <div class="d-grid"><a class="btn btn-light sys-info-statu-btn text-uppercase active"
                                        href="{{ route('systemUpdate.upgrade') }}">{{ __('Manual') }}</a></div>
                            </div>
                            <div class="col-6">
                                <div class="d-grid"><a class="btn btn-light sys-info-statu-btn text-uppercase"
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
        <div class="card">
            <div class="card-body mt-3">
                <div class="col-sm-2"></div>
                <div class="col-sm-12">
                    <div class="row align-items-center justify-content-center alert alert-{{ $upgrader['status'] ? 'secondary' : 'danger' }} mt-3">
                        <div class="col">
                            <h5 class="m-0">{{ $upgrader['message'] }}</h5>
                        </div>
                        @if ($upgrader['status'])
                            <div class="col-auto">
                                <a href="{{ route('systemUpdate.upgrade', ['waiting' => true]) }}" class="btn custom-btn-submit" id="update_now">{{ __('Update Now') }}</a>
                            </div>
                        @endif
                    </div>
                    @if ($upgrader['status'])
                    <div class="row alert alert-warning">
                        {!! $upgrader['json']['description'] !!}
                    </div>
                    @elseif (isset($upgrader['needPermission']) && $upgrader['needPermission'])
                        <table>
                            <tr>
                                <th>{{ __('Directory Name') }}</th>
                                <th>{{ __('Need Permission') }}</th>
                            </tr>
                            @foreach ($upgrader['permissionRequire'] as $directory)
                                <tr>
                                    <td>{{ $directory }}</td>
                                    <td class="text-center">777</td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
                <div class="col-sm-2"></div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
@endsection
