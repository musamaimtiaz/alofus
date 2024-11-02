@extends('admin.layouts.app')
@section('page_title', __('Support'))
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('Modules/Ticket/Resources/assets/css/jqueryui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/summer-note/summernote-lite.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/Ticket/Resources/assets/css/ticket-reply.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Modules/Ticket/Resources/assets/css/custom-badges.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Modules/Ticket/Resources/assets/css/invoice-style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/MediaManager/Resources/assets/css/media-manager.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Modules/Ticket/Resources/assets/css/ticket-reply.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/product.min.css') }}">
@endsection
@section('content')
    <div class="col-sm-12" id="reply-ticket-container">
        <div class="card">
            <div class="card-header">
                <h5 class="top-bar-title font-weight-bold">{{ __('Ticket No') }}: #{{ $ticketDetails->id }}</h5>
                <span class="cbadge cbadge-outlined f-12 px-2 py-1 border-B0BEC5 fw-normal"
                    style="color: {{ optional($ticketDetails->threadStatus)->color }}"
                    id="status_label">{{ __(optional($ticketDetails->threadStatus)->name) }}</span>
                <div class="card-header-right">

                </div>
            </div>

            <div class="card-block">
                <div class="row">
                    <p class="font-weight-bold p-l-20 p-b-0 mb-2 f-16"><span class="fw-medium">{{ __('Subject') }}:</span>
                        <span class="font-weight-normal">{{ $ticketDetails->subject }}</span></p>
                </div>
                <div class="row">
                    <div class="col-md-9 col-sm-12 m-t-5">
                        <div id="removeLiPriority" class="btn-group">
                            <button type="button"
                                class="cbadge cbadge-default cbadge-outlined f-14 px-2 py-1 mb-2 dropdown-toggle"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="priority">
                                {{ __('Priority') }} : <span class="badge text-black priority-style priority-color"
                                    style="background-color: {{ priorityColor(optional($ticketDetails->priority)->name) }}">{{ __(optional($ticketDetails->priority)->name) }}</span>
                            </button>
                            <ul class="dropdown-menu scrollable-menu status task-priority-name w-150p" role="menu">
                                @foreach ($priority as $key => $value)
                                    <li class="properties"><a
                                            class="ticket_priority_change f-14 color_black w-100 d-inline-block"
                                            ticket_id="{{ $ticketDetails->id }}" data-id="{{ $value->id }}"
                                            data-value="{{ $value->name }} ">{{ $value->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>


                        <p class="cbadge cbadge-default department-padding cbadge-outlined f-14 px-2 py-2 mb-2">
                            {{ __('Department') }}:
                            <span class="departmentText f-12"> {{ __(optional($ticketDetails->department)->name) }}</span>
                        </p>
                        @php $color = $ticketDetails->priority == 'High' ? '#099909' : '#367fa9' @endphp
                        <div id="removeLi" class="btn-group">
                            <button style="color:{{ optional($ticketDetails->threadStatus)->color }} !important"
                                type="button"
                                class="badge badgePadding cbadge-default cbadge-outlined text-white f-12 dropdown-toggle p-2"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="ticket-status">
                                {{ __(optional($ticketDetails->threadStatus)->name) }}&nbsp;<span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu scrollable-menu status task-priority-name w-150p" role="menu">
                                @foreach ($ticketStatuses as $key => $value)
                                    <li class="properties"><a
                                            class="admin_ticket_status_change f-14 color_black w-100 d-inline-block"
                                            ticket_id="{{ $ticketDetails->id }}" data-id="{{ $value->id }}"
                                            data-value="{{ $value->name }} ">{{ __($value->name) }}</a></li>
                                @endforeach
                            </ul>
                        </div>&nbsp
                    </div>
                    <div class="col-md-3">
                        <select id="assignee" class="form-control select2">
                            <option value=''>{{ __('No Assignee') }}</option>
                            @foreach ($assignee as $data)
                                <option value="{{ $data->id }}"
                                    {{ $data->id == $ticketDetails->assigned_member_id ? 'selected' : '' }}>
                                    {{ $data->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <hr class="m-t-0">
            <div class="card-block">
                <form class="form-horizontal" id="reply_form" action="{{ route('admin.threadReply.store') }}"
                    method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" id="ticketId" name="ticket_id" value="{{ $ticketDetails->id }}">
                    <input type="hidden" name="user_id" value="{{ $ticketDetails->user_id }}">
                    <input type="hidden" id="customer_id" name="sender_id" value="{{ $ticketDetails->sender_id }}">
                    <input type="hidden" name="name" value="{{ $ticketDetails->name }}">
                    <input type="hidden" name="email" value="{{ $ticketDetails->email }}">
                    <input type="hidden" name="receiver_id" value="{{ $ticketDetails->receiver_id }}">
                    <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group row">
                                <div class="col-md-1 col-sm-1"></div>
                                <div class="col-md-5 col-sm-5">
                                    <input class="form-control auto col-md-12 form-height"
                                        placeholder="{{ __('Canned Message Title') }}" id="cannedMsg_search">
                                    <ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content"
                                        id="no_div_msg" tabindex="0">
                                        <li>{{ __('No record found') }} </li>
                                    </ul>
                                </div>
                                <div class="col-md-1 col-sm-1"></div>
                                <div class="col-md-5 col-sm-5">
                                    <input class="form-control auto col-md-12 form-height"
                                        placeholder="{{ __('Canned Link Title') }}" id="cannedLink_search">
                                    <ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content"
                                        id="no_div_link" tabindex="0">
                                        <li>{{ __('No record found') }} </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-sm-1">
                                    <label class="control-label require">{{ __('Reply') }}</label>
                                </div>
                                <div class="col-sm-11">
                                    <textarea class="ticket_message-reply form-control txtAreaCanned" name="message" id="summernote">{{ old('message') }}</textarea>
                                    <label id="ticket_messages-error" class="error" for="ticket_messages"></label>
                                    <span id="canned_msg" class="btn btn-primary custom-btn-small f-12 my-3"
                                        data-bs-toggle="modal" data-type="canned_message"
                                        data-bs-target="#modal-canned">{{ __('Save Canned Message') }}</span>
                                    <span id="canned_link" class="btn btn-primary custom-btn-small f-12 my-3"
                                        data-type="canned_link">{{ __('Save Canned Link') }}</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-1">
                                    <label class="control-label">{{ __('Status') }}</label>
                                </div>
                                <div class="col-sm-3">
                                    <input id="thread-status_id" type="text" class="form-control"
                                        value="{{ $ticketStatus->id }}" name="thread_status_id" hidden>
                                    <select name="status_id" class="form-control select2-hide-search reply-select2">
                                        @foreach ($ticketStatuses as $data)
                                            <option {{ $data->id == 7 ? 'selected' : '' }} value="{{ $data->id }}">
                                                {{ __($data->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-1 ">
                                    <label class="col-form-label pr-0 ml-1">{{ __('File') }}</label>
                                </div>
                                <div class="col-sm-7">
                                    <div class="custom-file has-media-manager has-thumbnail" data-val="multiple"
                                        id="image-status">
                                        <input class="form-control up-images attachment d-none" name="attachment"
                                            id="validatedCustomFile" accept="image/*">
                                        <label
                                            class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                                            for="validatedCustomFile">{{ __('Upload image') }}</label>
                                    </div>
                                    <div class="d-flex" id="ticket-image">
                                        <!-- img will be shown here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 m-t-5" id='reply-btn'>
                            <button type="submit"
                                class="btn custom-btn-submit btn-reply mr-0 ltr:float-right rtl:float-left"
                                id="add_ticket_btn"><i
                                    class="comment_spinner spinner fa fa-spinner fa-spin custom-btn-small display_none"></i><span
                                    id="spinnerText">{{ __('Reply') }} </span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @if ($ticketReplies->count() > 0)
            <div class="card shadow-none">
                <div class="card-header">
                    <h5 class="card-header-text">{{ __('Message') }}</h5>
                </div>
                <div class="bg-white">
                    @if ($ticketReplies->count() > 0)
                        @foreach ($ticketReplies as $data)
                            <!-- Customer Reply-->
                            @if (!empty($data->sender))
                                <div class="card customer-card m-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-2 px-2">
                                                <h6 class="media-heading txt-primary text-left"><a
                                                        href="{{ route('vendors.edit', ['id' => $data->id]) }}">{{ optional($data->sender)->name }}</a>
                                                </h6>
                                                <a href="{{ route('vendors.edit', ['id' => $data->id]) }}"
                                                    class="float-left">
                                                    <img class="rounded-circle" width="45" height="45"
                                                        alt=" " src='{{ optional($data->sender)->fileUrl() }}'>
                                                </a>
                                            </div>
                                            <div class="col-sm-10">
                                                {!! $data->message !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer mx-2 p-2">
                                        <span><i class="feather icon-clock"></i>&nbsp{{ timeZoneFormatDate($data->date) }}
                                            &nbsp{{ timeZoneGetTime($data->date) }}</span>
                                        @foreach ($data->filesUrlNew() as $key => $file)
                                            @php
                                                $str = explode('.', $file->file_name);
                                                $file->extension = $str[count($str) - 1];
                                                $url = url('public/dist') . '/js/html5lightbox/no_preview.png?v' . $file->id;
                                                $extra = '';
                                                $div = '';
                                                if (in_array($file->extension, ['jpg', 'png', 'jpeg', 'gif', 'pdf', 'flv', 'webm', 'mp4', 'ogv', 'swf', 'm4v', 'ogg'])) {
                                                    $url = url($filePath) . '/' . $file->file_name;
                                                } elseif (in_array($file->extension, ['csv', 'xls', 'xlsx', 'doc', 'docx', 'ppt', 'pptx', 'txt'])) {
                                                    $url = '#pdiv-' . $file->id;
                                                    $extra = 'data-width=900 data-height=600';
                                                    $div =
                                                        '<div id="pdiv-' .
                                                        $file->id .
                                                        '" class="display_none">
                                                            <div class="lightboxcontainer">
                                                                <iframe width="100%" height="100%" src="//docs.google.com/gview?url=' .
                                                        url($filePath) .
                                                        '/' .
                                                        $file->file_name .
                                                        '&embedded=true" frameborder="0" allowfullscreen></iframe>
                                                                <div class="clear_both"></div>
                                                            </div>
                                                            </div>';
                                                }
                                                if (strlen($file->original_file_name) > 10) {
                                                    $file_full_name = substr_replace($file->original_file_name, '...', 10);
                                                } else {
                                                    $file_full_name = $file->original_file_name;
                                                }
                                            @endphp
                                            <div data-bs-placement="top" data-bs-toggle="tooltip"
                                                title="{{ $file->original_file_name }}" class="file"> <a
                                                    {{ $extra }} href="{{ $url }}"
                                                    class="m-r-10 f-15 text-muted html5lightbox color_8e8e8e"
                                                    data-group="{{ $file->object_type . '-' . $file->object_id }}"
                                                    title="{{ $file->original_file_name }}"
                                                    data-attachment="{{ $file->id }}"
                                                    data-original-title="{{ $file->original_file_name }}"
                                                    download="{{ $file->file_name }}"><i
                                                        class="{{ getFileIcon($file->file_name) }} file-name"></i>{{ $file_full_name }}</a>
                                            </div>
                                            {{ $div }}
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <!-- Admin Reply-->
                            @if (!empty($data->receiver))
                                <div class="card admin-card m-4">
                                    <div class="card-body mx-0">
                                        <div
                                            class="row d-flex flex-xl-row-reverse flex-md-row-reverse flex-sm-row-reverse">
                                            <div class="col-sm-2 px-2">
                                                <h6 class="media-heading txt-primary text-right"><a
                                                        href="{{ route('users.profile') }}">{{ optional($data->receiver)->name }}</a>
                                                </h6>
                                                <a href="{{ route('users.profile') }}"
                                                    class="ltr:float-right ltr:me-4 rtl:float-left rtl:ms-4">
                                                    <img class="rounded-circle" width="45" height="45"
                                                        alt=" " src='{{ optional($data->receiver)->fileUrl() }}'>
                                                </a>
                                            </div>
                                            <div class="col-sm-10 px-2">
                                                {!! $data->message !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer mx-2 p-2">
                                        <span><i class="feather icon-clock"></i>&nbsp{{ timeZoneFormatDate($data->date) }}
                                            &nbsp{{ timeZoneGetTime($data->date) }}</span>
                                        @if (Auth::user()->id == $data->receiver_id)
                                            &nbsp | &nbsp
                                            <span class="btn btn-xs btn-secondary edit-btn" data-bs-toggle="modal"
                                                data-type="admin_replay" data-id="{{ $data->id }}"
                                                data-message="{{ $data->message }}" data-bs-target="#modal-default"><i
                                                    class="feather icon-edit neg-transition-scale-svg  f-12"></i></span>
                                            <span class="btn btn-xs btn-secondary canned-btn" data-bs-toggle="modal"
                                                data-type="admin_replay" data-id="{{ $data->id }}"
                                                data-message="{{ $data->message }}" data-bs-target="#modal-canned">
                                                <i class="feather icon-message-circle f-12"></i></span>
                                        @endif
                                        @php
                                            $files = $data->fileName();
                                        @endphp
                                        &nbsp | &nbsp
                                        @foreach ($data->filesUrlNew() as $key => $file)
                                            @php
                                                $str = explode('.', $file->original_file_name);
                                                $file->extension = $str[count($str) - 1];
                                                $url = url('public/dist') . '/js/html5lightbox/no_preview.png?v' . $file->id;
                                                $extra = '';
                                                $div = '';
                                                $imagePath = public_path() . '/' . 'uploads' . '/' . $file->file_name;
                                                if (in_array($file->extension, ['jpg', 'png', 'jpeg', 'gif', 'pdf', 'flv', 'webm', 'mp4', 'ogv', 'swf', 'm4v', 'ogg'])) {
                                                    $url = url($filePath) . '/' . $file->file_name;
                                                } elseif (in_array($file->extension, ['csv', 'xls', 'xlsx', 'doc', 'docx', 'ppt', 'pptx', 'txt'])) {
                                                    $url = '#pdiv-' . $file->id;
                                                    $extra = 'data-width=900 data-height=600';
                                                    $div =
                                                        '<div id="pdiv-' .
                                                        $file->id .
                                                        '" class="display_none">
                                                <div class="lightboxcontainer">
                                                  <iframe width="100%" height="100%" src="//docs.google.com/gview?url=' .
                                                        url($filePath) .
                                                        '/' .
                                                        $file->file_name .
                                                        '&embedded=true" frameborder="0" allowfullscreen></iframe>
                                                  <div class="clear_both"></div>
                                                </div>
                                              </div>';
                                                }
                                                if (strlen($file->original_file_name) > 10) {
                                                    $file_full_name = substr_replace($file->original_file_name, '...', 10);
                                                } else {
                                                    $file_full_name = $file->original_file_name;
                                                }
                                            @endphp
                                            <div data-bs-placement="top" data-bs-toggle="tooltip"
                                                title="{{ $file->original_file_name }}" class="file"> <a
                                                    {{ $extra }} href="{{ $url }}"
                                                    class="m-r-10 f-15 text-muted html5lightbox color_8e8e8e"
                                                    data-group="{{ $file->object_type . '-' . $file->object_id }}"
                                                    title="{{ $file->original_file_name }}"
                                                    data-attachment="{{ $file->id }}"
                                                    data-original-title="{{ $file->original_file_name }}"
                                                    download="{{ $file->file_name }}"><i
                                                        class="{{ getFileIcon($file->file_name) }} file-name"></i>{{ $file_full_name }}</a>
                                            </div>
                                            {{ $div }}
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        @endif
    </div>
    @include('mediamanager::image.modal_image')

    {{-- Modal Start --}}
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <form method="POST" action="{{ url('admin/update/admin_reply') }}" id="replyModal">
                {{ csrf_field() }}
                <input type="hidden" name="id" id="reply_id">
                <input type="hidden" name="in_type" id="update_type">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('Update Reply') }}</h4>
                        <a type="button" class="close h5" data-bs-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></a>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <textarea class="form-control reply-modal" name="message" id="summernote1"></textarea>
                            <label id="reply-modal-error" class="error" for="reply-modal"></label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="py-2 custom-btn-cancel"
                            data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit"
                            class="btn py-2 custom-btn-submit ltr:me-2 rtl:ms-2">{{ __('Update') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Note Modal Start --}}

    {{-- Canned Message Modal Start --}}
    <div class="modal fade" id="modal-canned" role="dialog">
        <div class="modal-dialog">
            <form method="POST" id="cannedForm">
                {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('Canned Message') }}</h4>
                        <a type="button" class="close h5" data-bs-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></a>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" name="title" id="title" class="form-control"
                                placeholder="{{ __('Provide Title') }}">
                            <label id="title-error" class="error" for="title"></label>
                        </div>
                        <div class="form-group">
                            <textarea id="txtAreaCanned" name="canned_message" class="ticket_message canned-message form-control txtAreaCanned"></textarea>
                            <label id="txtAreaCanned-error" class="error" for="txtAreaCanned"></label>
                            <label id="canned-modal-error" class="error" for="reply-modal"></label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="py-2 custom-btn-cancel"
                            data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit"
                            class="btn py-2 custom-btn-submit ltr:me-2 rtl:ms-2">{{ __('Save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Canned Link Modal Start --}}
    <div class="modal fade" id="modal-link" role="dialog">
        <div class="modal-dialog modal-lg">
            <form method="POST" id="linkForm">
                {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('Canned Link') }}</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="col-md-12 col-sm-12" id="custom_link">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="type" id="type" value="reply">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger custom-btn-small"
                            data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary custom-btn-small">{{ __('Save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('public/dist/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/summer-note/summernote-lite.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/dist/js/html5lightbox/html5lightbox.min.js') }}"></script>
    <script src="{{ asset('Modules/Ticket/Resources/assets/js/message.min.js') }}"></script>
    <script src="{{ asset('Modules/Ticket/Resources/assets/js/canned.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/sweetalert/js/sweetalert.min.js') }}"></script>
    {!! translateValidationMessages() !!}
@endsection
