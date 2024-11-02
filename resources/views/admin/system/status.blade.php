@extends('admin.layouts.app')
@section('page_title', __('System Status'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-block text-center mt-3">
                <i class="feather icon-activity f-30 text-c-success"></i>
                <h4 class="f-w-600 mt-2 text-muted text-uppercase">{{ __('System Status') }}</h4>
                <span
                    class="text-muted">{{ __('This page displays the current status of your application.') }}</span>
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-12">
                        <div class="row m-t-30" style="margin-bottom: -17px">
                            <div class="col-6">
                                <div class="d-grid"><a class="btn btn-light sys-info-statu-btn text-uppercase active"
                                        href="{{ route('systemInfo.index') }}">{{ __('Status') }}</a></div>
                            </div>
                            <div class="col-6">
                                <div class="d-grid"><a class="btn btn-light sys-info-statu-btn text-uppercase"
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
            <div class="card-body mt-3">
                <h6 class="mt-2 text-muted text-uppercase f-w-600">{{ __('php.ini Configuration') }}</h6>
                <hr>
                <table class="sys-info-table table table-striped table-hover table-borderless table-responsive">
                    <tbody>
                        @if (!empty($configurations))
                            <tr>
                                <th width="30%">Name</th>
                                <th width="30%">Current </th>
                                <th width="30%">Recommended</th>
                                <th width="10%">Status</th>
                            </tr>
                            <tr>
                                <td>file_uploads</td>
                                <td>{{ $configurations['file_uploads'] }}</td>
                                <td>On</td>
                                <td>
                                    @if ($configurations['file_uploads'] === 'On')
                                        <i class="fas fa-check-circle text-success neg-transition-scale"></i>
                                    @else
                                        <i class="fas fa-times-circle text-danger"></i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>max_file_uploads</td>
                                <td>{{ $configurations['max_file_uploads'] }}</td>
                                <td>20+</td>
                                <td>
                                    @if ((int) $configurations['max_file_uploads'] >= 20)
                                        <i class="fas fa-check-circle text-success neg-transition-scale"></i>
                                    @else
                                        <i class="fas fa-times-circle text-danger"></i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>upload_max_filesize</td>
                                <td>{{ $configurations['upload_max_filesize'] }}</td>
                                <td>128M+</td>
                                <td>
                                    @if ((int) str_replace('M', '', $configurations['upload_max_filesize']) >= 128)
                                        <i class="fas fa-check-circle text-success neg-transition-scale"></i>
                                    @else
                                        <i class="fas fa-times-circle text-danger"></i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>post_max_size</td>
                                <td>{{ $configurations['post_max_size'] }}</td>
                                <td>128M+</td>
                                <td>
                                    @if ((int) str_replace('M', '', $configurations['post_max_size']) >= 128)
                                        <i class="fas fa-check-circle text-success neg-transition-scale"></i>
                                    @else
                                        <i class="fas fa-times-circle text-danger"></i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>allow_url_fopen</td>
                                <td>{{ $configurations['allow_url_fopen'] }}</td>
                                <td>On</td>
                                <td>
                                    @if ($configurations['allow_url_fopen'] === 'On')
                                        <i class="fas fa-check-circle text-success neg-transition-scale"></i>
                                    @else
                                        <i class="fas fa-times-circle text-danger"></i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>max_execution_time</td>
                                <td>{{ $configurations['max_execution_time'] }}</td>
                                <td>600+</td>
                                <td>
                                    @if ((int) $configurations['max_execution_time'] >= 600)
                                        <i class="fas fa-check-circle text-success neg-transition-scale"></i>
                                    @else
                                        <i class="fas fa-times-circle text-danger"></i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>max_input_time</td>
                                <td>{{ $configurations['max_input_time'] }}</td>
                                <td>120+</td>
                                <td>
                                    @if ((int) $configurations['max_input_time'] >= 120)
                                        <i class="fas fa-check-circle text-success neg-transition-scale"></i>
                                    @else
                                        <i class="fas fa-times-circle text-danger"></i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>max_input_vars</td>
                                <td>{{ $configurations['max_input_vars'] }}</td>
                                <td>1000+</td>
                                <td>
                                    @if ((int) $configurations['max_input_vars'] >= 1000)
                                        <i class="fas fa-check-circle text-success neg-transition-scale"></i>
                                    @else
                                        <i class="fas fa-times-circle text-danger"></i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>memory_limit</td>
                                <td>{{ $configurations['memory_limit'] }}</td>
                                <td>256M+</td>
                                <td>
                                    @if ((int) str_replace('M', '', $configurations['memory_limit']) >= 256)
                                        <i class="fas fa-check-circle text-success neg-transition-scale"></i>
                                    @else
                                        <i class="fas fa-times-circle text-danger"></i>
                                    @endif
                                </td>
                            </tr>
                        @else
                            <tr class="text-center">
                                <td colspan="4">
                                    {{ __('phpinfo() is disabled. Please contact with your hosting provider.') }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <h6 class="mt-4 text-muted text-uppercase f-w-600">{{ __('Extension') }}</h6>
                <hr>
                <table class="sys-info-table table table-striped table-hover table-borderless table-responsive">
                    <tbody>
                        @if (!empty($extensionArray))
                            <tr>
                                <td width="90%">json</td>
                                <td>
                                    @if (in_array('json', $extensionArray))
                                        <i class="fas fa-check-circle text-success neg-transition-scale"></i>
                                    @else
                                        <i class="fas fa-times-circle text-danger"></i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td width="90%">mbstring</td>
                                <td>
                                    @if (in_array('mbstring', $extensionArray))
                                        <i class="fas fa-check-circle text-success neg-transition-scale"></i>
                                    @else
                                        <i class="fas fa-times-circle text-danger"></i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td width="90%">openssl</td>
                                <td>
                                    @if (in_array('openssl', $extensionArray))
                                        <i class="fas fa-check-circle text-success neg-transition-scale"></i>
                                    @else
                                        <i class="fas fa-times-circle text-danger"></i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td width="90%">tokenizer</td>
                                <td>
                                    @if (in_array('tokenizer', $extensionArray))
                                        <i class="fas fa-check-circle text-success neg-transition-scale"></i>
                                    @else
                                        <i class="fas fa-times-circle text-danger"></i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td width="90%">curl</td>
                                <td>
                                    @if (in_array('curl', $extensionArray))
                                        <i class="fas fa-check-circle text-success neg-transition-scale"></i>
                                    @else
                                        <i class="fas fa-times-circle text-danger"></i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td width="90%">pdo</td>
                                <td>
                                    @if (in_array('pdo', $extensionArray))
                                        <i class="fas fa-check-circle text-success neg-transition-scale"></i>
                                    @else
                                        <i class="fas fa-times-circle text-danger"></i>
                                    @endif
                                </td>
                            </tr>
                        @else
                            <tr class="text-center">
                                <td colspan="2">
                                    {{ __('phpinfo() is disabled. Please contact with your hosting provider.') }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <h6 class="mt-4 text-muted text-uppercase f-w-600">{{ __('Filesystem Permissions') }}</h6>
                <hr>
                <table class="sys-info-table table table-striped table-hover table-borderless table-responsive">
                    <tbody>
                        @foreach ($fileSystemPaths as $fileSystemPath)
                            <tr>
                                <td width="90%">{{ $fileSystemPath }}</td>
                                <td>
                                    @if (is_writable(base_path($fileSystemPath)))
                                        <i class="fas fa-check-circle text-success neg-transition-scale"></i>
                                    @else
                                        <i class="fas fa-times-circle text-danger"></i>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

