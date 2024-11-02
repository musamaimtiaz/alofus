@extends('admin.layouts.app')
@section('page_title', __('Permission Roles'))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/dist/css/role-permission.min.css') }}">
@endsection
@section('content')

    <!-- Main content -->
    <div class="col-sm-12 list-container" id="permission-list-container">
        <div class="card">
            <div class="card-body row">
                <div
                    class="col-lg-3 col-12 z-index-10  ltr:ps-md-3 ltr:pe-0 ltr:ps-0 rtl:pe-md-3 rtl:ps-0 rtl:pe-0">
                    @include('admin.layouts.includes.account_settings_menu')
                </div>
                <div class="col-lg-9 col-12 ltr:ps-0 rtl:pe-0">
                    <div class="card card-info shadow-none mb-0">
                        <div class="card-header p-t-20 border-bottom">
                            <h5> {{ __('Permission Roles') }} </h5>

                            <div class="card-header-right d-inline-block ltr:ps-3 rtl:pe-3">
                                @if (in_array('App\Http\Controllers\RoleController@create', $prms))
                                    <a href="{{ route('roles.create') }}" class="btn btn-outline-primary custom-btn-small">
                                        <span class="fa fa-plus"> &nbsp;</span>{{ __('Add Role') }}
                                    </a>
                                @endif

                                @if (in_array('App\Http\Controllers\PermissionRoleController@generatePermission', $prms))
                                    <a href="{{ route('generatePermission.index') }}"
                                        class="btn btn-primary custom-btn-small">
                                        <span class="fas fa-cogs"> &nbsp;</span>{{ __('Generate Permissions') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="card-body p-0 role-table">
                            <div class="card-block pt-2 px-2">
                                <div class="col-sm-12">
                                    <div class="table-responsive pt-2 panel panel-default border">
                                        <span class="d-block text-warning p-2 font-bold"><i
                                                class="fas fa-exclamation-triangle ltr:me-2 rtl:ms-2"></i>{{ __('Permissions applied here are applicable to access that particular link. Please change it with extreme care.') }}</span>
                                        <table class="table text-center myTable role-permission-table">
                                            <thead class="thead-sticky table-header">
                                                <tr>
                                                    <th width="27%">{{ __('Permissions') }}</th>
                                                    @php
                                                        $columnWidth = intval(80 / count($roles)) . '%';
                                                    @endphp

                                                    @foreach ($roles as $role)
                                                        <th width="{{ $columnWidth }}">{{ $role['name'] }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($permissions as $webApiKey => $webApiValue)
                                                    @foreach ($webApiValue as $groupKey => $groupValue)
                                                        @if (!empty($groupValue))
                                                            @php
                                                                $data[$groupKey][$webApiKey] = $groupValue;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                                @php
                                                    ksort($data);
                                                @endphp
                                                @foreach ($data as $type => $allValue)
                                                    <tr data-bs-toggle="collapse"
                                                        data-value="{{ $type . $loop->iteration }}"
                                                        class="accordion-toggle main-group">
                                                        <td class="text-left">
                                                            <a href="#!" class="collapsed text-dark text-bold"
                                                                data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                                aria-expanded="false" aria-controls="collapseTwo"><i
                                                                    class="fas fa-plus ltr:ps-3 rtl:pe-3 arrow-icon"></i>
                                                                {{ ucwords(str_replace('_api', ' ', $type)) }}</a>
                                                            <span
                                                                class="badge badge-{{ strpos($type, 'api') != false ? 'secondary' : 'info' }}">{{ strpos($type, 'api') != false ? 'api' : 'web' }}</span>
                                                        </td>
                                                        @foreach ($roles as $role)
                                                            @if ($loop->iteration == $loop->count - 1)
                                                                <td colspan="2" class="position-relative">
                                                                    <input type="text"
                                                                        class="w-100 p-2 my-2 form-control position-absolute search-table"
                                                                        placeholder="{{ __('Search for permissions') }}...">
                                                                </td>
                                                            @elseif ($loop->iteration < $loop->count - 1)
                                                                <td></td>
                                                            @endif
                                                        @endforeach
                                                    </tr>
                                                    @foreach ($allValue as $key => $value)
                                                        <tr data-bs-toggle="collapse" data-bs-target="#{{ $type . $key }}"
                                                            class="accordion-toggle sub-group hidden"
                                                            data-value="{{ $type . $loop->parent->iteration }}">
                                                            <td class="text-left search">
                                                                <a href="#!" class="collapsed ml-3"
                                                                    data-bs-toggle="collapse show"
                                                                    data-bs-target="#collapseTwo" aria-expanded="false"
                                                                    aria-controls="collapseTwo"><i
                                                                        class="fas fa-plus ltr:ps-3 rtl:pe-3 arrow-icon"></i>
                                                                    {{ ucfirst(preg_replace('/(?<!\ )[A-Z]/', ' $0', $key)) }}</a>
                                                            </td>
                                                            @foreach ($roles as $role)
                                                                <td></td>
                                                            @endforeach
                                                        </tr>
                                                        <tr>
                                                            <td colspan="12" class="hiddenRow border-none">
                                                                <div class="accordian-body collapse"
                                                                    id="{{ $type . $key }}">
                                                                    <table class="table table-striped text-center">
                                                                        <tbody>
                                                                            @foreach ($value as $methodKey => $methodValue)
                                                                                <tr data-bs-toggle="collapse"
                                                                                    class="accordion-toggle"
                                                                                    data-bs-target="#demo10">
                                                                                    <td width="27%" class="text-left">
                                                                                        <span
                                                                                            class="d-block ml-48">{{ ucfirst(preg_replace('/(?<!\ )[A-Z]/', ' $0', $methodValue['name'])) }}</span>
                                                                                    </td>

                                                                                    @foreach ($roles as $role)
                                                                                        <td class="text-center"
                                                                                            width="{{ $columnWidth }}">

                                                                                            @if ($role['slug'] == 'super-admin')
                                                                                                <span><i
                                                                                                        class="fas fa-check p-icon neg-transition-scale"></i></span>
                                                                                            @else
                                                                                                <span class="prms"
                                                                                                    data-permission_id="{{ $methodValue['id'] }}"
                                                                                                    data-role_id="{{ $role['id'] }}">
                                                                                                    <i class="fas {{ in_array($role['id'], $methodValue['role_ids']) ? 'fa-check text-success' : 'fa-times text-danger' }} p-icon p-prms"
                                                                                                        id="p_icon_{{ $role['id'] }}_{{ $methodValue['id'] }}"></i>
                                                                                                </span>
                                                                                            @endif
                                                                                        </td>
                                                                                    @endforeach
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('admin.layouts.includes.delete-modal')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('public/dist/js/custom/roles.min.js') }}"></script>
@endsection
