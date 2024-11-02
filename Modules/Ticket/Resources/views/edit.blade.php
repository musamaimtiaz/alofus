@extends('admin.layouts.app')
@section('page_title', __('Conversation'))

@section('css')
{{-- select2 css --}}
<link rel="stylesheet" href="{{ asset('public/datta-able/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('public/dist/css/ticket-edit.min.css')}}">
@endsection

@section('content')
    <!-- Main content -->
<div class="col-sm-12" id="edit-ticket-container">
    <div class="card user-list">
        <div class="card-header">
            <h5><a href="{{ route('admin.tickets') }}">{{ __('Tickets') }}</a> >> {{ __('Edit Ticket') }} #{{ $ticketDetails->id }}</h5>
            <div class="card-header-right">

            </div>
        </div>
        <div class="card-block">
            <div class="form-tabs">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active text-uppercase" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{ __('Ticket Information') }}</a>
                    </li>
                    <li class="nav-item"></li>
                </ul>
            </div>
            <div class="tab-content ltr:ps-4 rtl:pe-4" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <form class="form-horizontal" action="{{ route('admin.threadUpdate') }}" id="edit-ticket-form" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="sub_menu" value="{{ isset($sub_menu) ? $sub_menu : '' }}">
                        <input type="hidden" name="thread_key" value="{{ $ticketDetails->ticket_key }}">
                        <input type="hidden" name="ticket_id" value="{{ $ticketDetails->id }}">
                        <input type="hidden" name="ticket_previous_assigne" value="{{ $ticketDetails->assigned_member_id }}">
                        <input type="hidden" name="ticket_previous_customer_id" value="{{ $ticketDetails->customer_id }}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-2 control-label require">{{ __('Subject') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control ticket-input-design" name="subject" value="{{ $ticketDetails->subject }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 control-label require">{{ __('Assignee') }}</label>
                                    <div class="col-sm-3">
                                        <select name="assign_id" class="form-control select2">
                                            @foreach ($assignees as $data)
                                            <option {{ $data->id == $ticketDetails->assigned_member_id ? 'selected' : '' }} value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                        <label id="assign_id-error" class="error" for="assign_id"></label>
                                    </div>
                                    <label class="col-sm-2 control-label require">{{ __('Status') }}</label>
                                    <div class="col-sm-3">
                                        <select name="status_id" class="form-control select2">
                                            @foreach ($ticketStatus as $data)
                                                <option {{ $data->id == $ticketDetails->thread_status_id ? 'selected' : '' }} value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                        <label id="status_id-error" class="error" for="status_id"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 control-label require">{{ __('Vendor') }}</label>
                                    <div class="col-sm-3">
                                        <select id="vendor_id" name="vendor_id" class="form-control select2">
                                            @foreach ($vendors as $data)
                                                <option {{ $data->id == $ticketDetails->receiver_id ? 'selected' : '' }} data-name="{{ $data->name }}" data-email="{{ $data->email }}"
                                                        value="{{ $data->id }} ">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                        <label id="vendor_id-error" class="error display_inline_block" for="vendor_id"></label>
                                    </div>
                                    <label class="col-sm-2 control-label require">{{ __('Priority') }}</label>
                                    <div class="col-sm-3">
                                        <select name="priority_id" class="form-control select2">
                                            @foreach ($priorities as $data)
                                                <option {{ $data->id == $ticketDetails->priority_id ? 'selected' : '' }} value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 control-label">{{ __('To') }}</label>
                                    <div class="col-sm-3">
                                        <input id="assign_name" type="text" class="form-control ticket-input-design" name="to" readonly>
                                    </div>
                                    <label class="col-sm-2 control-label">{{ __('Email') }}</label>
                                    <div class="col-sm-3">
                                        <input id="assign_email" type="text" class="form-control ticket-input-design" readonly name="email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 control-label require">{{ __('Department') }}</label>
                                    <div class="col-sm-3">
                                        <select name="department_id" class="form-control select2">
                                            @foreach ($departments as $data)
                                                <option {{ $data->id == $ticketDetails->department_id ? 'selected':'' }} value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                        <label id="department_id-error" class="error display_inline_block" for="department_id"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-8 m-t-15">
                                        <button class="btn btn-primary custom-btn-small" type="submit" id="add_ticket_btn">{{ __('Update') }}</button>
                                        <a href="{{ route('admin.tickets') }}" class="btn btn-danger custom-btn-small">{{ __('Cancel') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('public/dist/js/jquery.validate.min.js')}}"></script>
<script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js')}}"></script>
{!! translateValidationMessages() !!}
<script src="{{ asset('Modules/Ticket/Resources/assets/js/message.min.js') }}"></script>
@endsection
