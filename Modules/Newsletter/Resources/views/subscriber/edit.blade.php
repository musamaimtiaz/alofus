@extends('admin.layouts.app')
@section('page_title', __('Edit Subscriber'))
@section('css')
  <link rel="stylesheet" href="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}">
@endsection

@section('content')
  <div class="col-sm-12" id="subscriber-edit-container">
        <div class="card">
            <div class="card-header">
                <h5><a href="{{ route('subscriber.index') }}">{{ __('Subscriber') }}</a> >> {{ __('Edit Subscriber') }}</h5>
            </div>
            <div class="card-body table-border-style">
                <div class="form-tabs">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                        <a class="nav-link active text-uppercase font-bold">{{ __('Subscriber Information') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <form action="{{ route('subscriber.update', ['id' => $subscriber->id]) }}" method="post" class="form-horizontal">
                                @csrf

                                <div class="form-group row">
                                    <label class="col-sm-2 control-label require" for="email">{{ __('Email') }}</label>
                                    <div class="col-sm-6">
                                        <input type="text" placeholder="{{ __('Email') }}" class="form-control inputFieldDesign" id="email" name="email" required maxlength="120" oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')" value="{{ !empty(old('email')) ? old('email') : $subscriber->email }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 control-label require" for="confirmation_date">{{ __('Confirmation Date') }}</label>
                                    <div class="d-flex col-sm-6 date">
                                        <div class="input-group-prepend">
                                            <i class="fas fa-calendar-alt input-group-text rounded-0 h-40 ltr:rounded-start rtl:rounded-end"></i>
                                        </div>
                                        <input class="form-control inputFieldDesign rounded-0 ltr:rounded-end rtl:rounded-start" id="confirmation_date" type="text" name="confirmation_date" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')" value="{{ $subscriber->confirmation_date }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 control-label require" for="status">{{ __('Status') }}</label>
                                    <div class="col-sm-6">
                                        <select class="form-control select2-hide-search sl_common_bx" id="status" name="status" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                            <option value="">{{ __('Select One') }}</option>
                                            <option value="Active" {{ old('status', $subscriber->status) == "Active" ? 'selected' : '' }}>{{ __('Active') }}</option>
                                            <option value="Inactive" {{ old('status', $subscriber->status) == "Inactive" ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-8 px-0 mt-2 mt-md-0">
                                    <a href="{{ route('subscriber.index') }}" class="btn custom-btn-cancel all-cancel-btn">{{ __('Cancel') }}</a>
                                    <button class="btn custom-btn-submit" type="submit" id="submitBtn"><i class="comment_spinner spinner fa fa-spinner fa-spin custom-btn-submit display_none"></i><span id="spinnerText">{{ __('Submit') }}</span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  </div>
@endsection

@section('js')
    <script src="{{ asset('public/dist/js/moment.min.js') }}"></script>
    <script src="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/newsletter.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
@endsection
