@extends('admin.layouts.app')
@section('page_title', __('Edit :x', ['x' => __('Role')]))
@section('css')

@endsection

@section('content')
    <div class="col-sm-12" id="role-edit-container">
        <div class="card">
            <div class="card-body row">
                <div class="col-lg-3 ltr:ps-1 ltr:ps-lg-3 ltr:pe-0 rtl:pe-1 rtl:pe-lg-3 rtl:ps-0">
                    @include('admin.layouts.includes.account_settings_menu')
                </div>
                <div class="col-lg-9 ltr:ps-1 ltr:ps-lg-0 rtl:pe-1 rtl:pe-lg-0">
                    <div class="card card-info shadow-none mb-0">
                        <div class="card-header p-t-20 border-bottom">
                            <h5><a href="{{ route('roles.index') }}">{{ __('Roles') }}</a> >> {{ __('Edit') }}</h5>
                        </div>
                        <div class="card-body table-border-style  p-1 ltr:ps-md-2 rtl:pe-md-2" >
                            <div class="form-tabs  p-1 ltr:ps-md-2 rtl:pe-md-2">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active text-uppercase">{{ __('Role Information') }}</a>
                                    </li>
                                </ul>
                                <div class="tab-content p-0 shadow-none" id="myTabContent">
                                    <div class="tab-pane p-0 fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <form action="{{ route('roles.update', ['id' => $roles->id]) }}" method="post" id="roleEdit" class="form-horizontal">
                                            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                                            <div class="form-group row">
                                                <label class="col-sm-2 control-label require" for="name">{{ __('Name') }}</label>
                                                <div class="col-sm-6">
                                                    <input type="text" placeholder="{{ __('Name') }}" class="form-control inputFieldDesign" id="name" name="name" required pattern="^[a-zA-Z ]*$" value="{{ !empty(old('name')) ? old('name') : $roles->name }}" oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')" oninput="this.setCustomValidity('')" data-pattern = "{{ __('Only alphabet and white space are allowed.') }}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 control-label require" for="slug">{{ __('Slug') }}</label>
                                                <div class="col-sm-6">
                                                    <input type="text" placeholder="{{ __('Slug') }}" class="form-control {{ in_array($roles->slug, defaultRoles()) ? 'readonly' : '' }} inputFieldDesign" id="slug" name="slug" {{ in_array($roles->slug, defaultRoles()) ? 'readonly' : '' }} value="{{ !empty(old('slug')) ? old('slug') : $roles->slug }}" required pattern="^[a-zA-Z\-]*$" oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')" data-pattern="{{ __('Only alphabet and white space are allowed.') }}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 control-label" for="type">{{ __('Type') }}</label>
                                                <div class="col-sm-6">
                                                    <select class="form-control select2-hide-search" name="type" id="type" {{ in_array($roles->slug, defaultRoles()) ? 'disabled' : '' }}>
                                                        <option value="global" {{ old('type', $roles->type) == 'global' ? 'selected' : ''}}>{{ __('Global') }}</option>
                                                        <option value="vendor" {{ old('type', $roles->type) == 'vendor' ? 'selected' : ''}}>{{ __('Vendor') }}</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 control-labe" for="description">{{ __('Description') }}</label>
                                                <div class="col-sm-6">
                                                    <textarea type="text" placeholder="{{ __('Description') }}" class="form-control" id="description" name="description">{{ !empty(old('description')) ? old('description') : $roles->description }}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 mt-2 mt-md-0 px-0">
                                                <a href="{{ route('roles.index') }}" class="py-2 custom-btn-cancel mb-0 ltr:me-2 rtl:ms-2">{{ __('Cancel') }}</a>
                                                <button class="btn py-2 custom-btn-submit m-0" type="submit" id="submitBtn"><i class="comment_spinner spinner fa fa-spinner fa-spin custom-btn-small display_none"></i><span id="spinnerText">{{ __('Update') }}</span></button>
                                            </div>
                                        </form>
                                    </div>
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
<script src="{{ asset('public/dist/js/jquery.validate.min.js') }}"></script>
{!! translateValidationMessages() !!}
<script src="{{ asset('public/dist/js/custom/roles.min.js') }}"></script>
<script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
@endsection
