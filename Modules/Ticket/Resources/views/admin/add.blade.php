@extends('admin.layouts.app')
@section('page_title', __('Supports'))
@section('css')
    {{-- select2 css --}}
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/summer-note/summernote-lite.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/dist/css/invoice-style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/MediaManager/Resources/assets/css/media-manager.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/product.min.css') }}">
@endsection

@section('content')
    <!-- Main content -->
    <div class="col-sm-12" id="add-ticket-container">
        <div class="card user-list">
            <div class="card-header">
                <h5><a href="{{ route('admin.tickets') }}">{{ __('Tickets') }}</a> >> {{ __('New Ticket') }}</h5>
                <div class="card-header-right">

                </div>
            </div>
            <div class="card-block">
                <div class="form-tabs">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active text-uppercase fw-bold" id="home-tab" data-toggle="tab" href="#home"
                                role="tab" aria-controls="home" aria-selected="true">{{ __('Ticket Information') }}</a>
                        </li>
                        <li class="nav-item"></li>
                    </ul>
                </div>
                <div class="tab-content pl-4" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <form id="add_ticket_form" class="form-horizontal" action="{{ route('admin.ticketStore') }}"
                            method="post" enctype="multipart/form-data">
                            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label require">{{ __('Subject') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" value="{{ old('subject') }}"
                                                class="form-control form-height" name="subject" id="subject"
                                                maxlength="191" required>
                                            <input type="hidden" name="object_type" value="TICKET">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label require">{{ __('Message') }}</label>
                                        <div class="col-sm-8">
                                            <textarea class="ticket_message form-control" name="message" id="summernote">{{ old('message') }}</textarea>
                                            <label id="ticket_messages-error" class="error" for="ticket_messages"></label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label require">{{ __('Assignee') }}</label>
                                        <div class="col-sm-3">
                                            <select id="assign_id" name="assign_id"
                                                class="form-control select2 sl_common_bx" required required
                                                oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                                @foreach ($assignees as $data)
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label class="col-sm-2 col-form-label require pr-0">{{ __('Status') }}</label>
                                        <div class="col-sm-3">
                                            <select name="status_id" class="form-control select2-hide-search sl_common_bx"
                                                required
                                                oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                                @foreach ($ticketStatus as $data)
                                                    <option value="{{ $data->id }}">{{ __($data->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!--department-->
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label require">{{ __('Department') }}</label>
                                        <div class="col-sm-3">
                                            <select id="department_id" name="department_id"
                                                class="form-control select2-hide-search sl_common_bx" required
                                                oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                                @foreach ($departments as $data)
                                                    <option value="{{ $data->id }}">{{ __($data->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label class="col-sm-2 col-form-label pr-0 require">{{ __('Priority') }}</label>
                                        <div class="col-sm-3">
                                            <select id="priority_id" name="priority_id"
                                                class="form-control select2-hide-search sl_common_bx" required
                                                oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                                @foreach ($priorities as $data)
                                                    <option value="{{ $data->id }}">{{ __($data->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row select-customer-div">
                                        <label class="col-sm-2 col-form-label require">{{ __('Vendor') }}</label>
                                        <div class="col-sm-3">
                                            <div class="ticket-customer">
                                                @php
                                                    $customerId = isset($getCustomer) ? (int) $getCustomer->customer_id : '';
                                                @endphp
                                                <select id="customer_id" class="form-control select2 sl_common_bx"
                                                    name="receiver_id" required
                                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                                    <option>{{ __('Select One') }}</option>
                                                    @foreach ($users as $data)
                                                        <option {{ $data->id == $customerId ? 'selected' : '' }}
                                                            data-name="{{ $data->name }}"
                                                            data-email="{{ $data->email }}"
                                                            value="{{ $data->id }}">
                                                            {{ $data->name }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="customerId" value="{{ $customerId }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row customer-info-div">
                                        <label class="col-sm-2 col-form-label">{{ __('To') }}</label>
                                        <div class="col-sm-3">
                                            <input id="assign_name" type="text" class="form-control form-height"
                                                name="to" readonly>
                                        </div>
                                        <label class="col-sm-2 col-form-label pr-0">{{ __('Email') }}</label>
                                        <div class="col-sm-3">
                                            <input id="assign_email" type="text" class="form-control form-height"
                                                readonly name="email">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 control-label">{{ __('Featured Image') }}</label>
                                        <div class="col-sm-8">
                                            <div class="custom-file has-media-manager has-thumbnail" data-val="multiple"
                                                id="image-status">
                                                <input class="form-control up-images attachment d-none" name="attachment"
                                                    id="validatedCustomFile" accept="image/*">
                                                <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                                                    for="validatedCustomFile">{{ __('Upload image') }}</label>
                                            </div>
                                            <div class="d-flex" id="ticket-image">
                                                <!-- img will be shown here -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-8 m-t-15">
                                            <a href="{{ route('admin.tickets') }}"
                                                class="py-2 custom-btn-cancel">{{ __('Cancel') }}</a>
                                            <button class="btn py-2 ltr:ms-1 rtl:me-1 custom-btn-submit" type="submit" id="add_ticket_btn"><i
                                                    class="comment_spinner spinner fa fa-spinner fa-spin custom-btn-small display_none"></i><span
                                                    id="spinnerText">{{ __('Create') }} </span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="flag" id="flag" value="no">
                        </form>
                    </div>
                    @include('mediamanager::image.modal_image')
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        'use strict';
        var projectId = "{{ !empty($getProject) ? $getProject : '' }}";
    </script>
    <script src="{{ asset('public/datta-able/plugins/summer-note/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/sweetalert/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('Modules/Ticket/Resources/assets/js/message.min.js') }}"></script>
@endsection
