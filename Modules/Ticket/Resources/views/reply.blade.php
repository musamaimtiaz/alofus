@extends('vendor.layouts.app')
@section('page_title', __('Conversation'))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/summer-note/summernote-lite.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/Ticket/Resources/assets/css/ticket-reply.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Modules/Ticket/Resources/assets/css/jqueryui.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Modules/Ticket/Resources/assets/css/custom-badges.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Modules/Ticket/Resources/assets/css/invoice-style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/MediaManager/Resources/assets/css/media-manager.min.css') }}">

@endsection
@section('content')
    <div id="add-ticket-container">
        <div class="card">
            <div class="card-header">
                <h5>{{ __('Ticket No') }}: #{{ $ticketDetails->id }}</h5>
                <span class="cbadge cbadge-outlined f-14 border-B0BEC5"
                    style="color: {{ optional($ticketDetails->threadStatus)->color }}"
                    id="status_label">{{ optional($ticketDetails->threadStatus)->name }}</span>
            </div>

            <div class="card-block">
                <div class="d-flex">
                    <p class="font-weight-bold font-bold p-b-0 ltr:ps-1 rtl:pe-1 mb-2 f-16">{{ __('Subject') }}:</p>
                    <span class="f-16">
                        &nbsp;{{ $ticketDetails->subject }}
                    </span>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 m-t-5">
                        <p class="cbadge cbadge-default cbadge-outlined ltr:ms-sm-0 rtl:me-sm-0 mb-1">{{ __('Department') }}:
                            <span class="departmentText"> {{ optional($ticketDetails->department)->name }}</span>
                        </p>
                        <p class="cbadge cbadge-default cbadge-outlined mb-1">{{ __('Priority') }}:
                            <span style="color: {{ priorityColor(optional($ticketDetails->priority)->name) }}">
                                {{ optional($ticketDetails->priority)->name }}</span>
                        </p>
                        @if (!empty($ticketDetails->assigned_member_id))
                            <span
                                class="cbadge cbadge-outlined cbadge-default ltr:ms-sm-0 rtl:me-sm-0 mb-1 bolder-info">{{ __('Assignee') }}:
                                {{ optional($ticketDetails->assignedMember)->name }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <hr class="m-t-0">
            <div class="card-block">
                <form class="form-horizontal" id="reply_form" action="{{ route('vendor.threadReply.store') }}"
                    method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="ticket_id" value="{{ $ticketDetails->id }}">
                    <input type="hidden" name="user_id" value="{{ $ticketDetails->user_id }}">
                    <input type="hidden" id="receiver_id" name="receiver_id" value="{{ $ticketDetails->receiver_id }}">
                    <input type="hidden" name="name" value="{{ $ticketDetails->name }}">
                    <input type="hidden" name="email" value="{{ $ticketDetails->email }}">
                    <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-sm-1">
                                    <label class="control-label require">{{ __('Reply') }}</label>
                                </div>
                                <div class="col-sm-11">
                                    <textarea class="ticket_message form-control" name="message" id="summernote">{{ old('message') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-1 control-label">{{ __('Featured Image') }}</label>
                                <div class="col-sm-11">
                                    <div class="custom-file has-media-manager has-thumbnail" data-val="multiple"
                                        id="image-status">
                                        <input class="form-control up-images attachment d-none" name="attachment"
                                            id="validatedCustomFile" accept="image/*">
                                        <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                                            for="validatedCustomFile">{{ __('Upload image') }}</label>
                                    </div>
                                    <div class="d-flex flex-wrap" id="ticket-image">
                                        <!-- img will be shown here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 m-t-5">
                            <button type="submit" class="btn custom-btn-submit btn-reply ltr:float-right ltr:me-0 rtl:float-left rtl:ms-0"
                                id="btnSubmit"><i
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
                <div class="card-block p-0">
                    @if ($ticketReplies->count() > 0)
                        @foreach ($ticketReplies as $data)
                            <!-- Customer Reply-->
                            @if (!empty($data->receiver))
                                <div class="card customer-card m-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-2 px-2">
                                                <h6 class="media-heading txt-primary text-left"><a
                                                        href="javascript::void">{{ $data->receiver->name }}</a></h6>
                                                <a href="javascript::void" class="float-left">
                                                    <img class="rounded-circle" width="45" height="45"
                                                        alt=" "
                                                        src='{{ optional($data->receiver)->fileUrl() }}'>
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
                                        @php
                                            $files = $data->fileName();
                                        @endphp
                                        @foreach ($data->filesUrlNew() as $key => $file)
                                            @if (!empty($file))
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
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <!-- Admin Reply-->
                            @if (!empty($data->sender))
                                <div class="card admin-card m-4">
                                    <div class="card-body mx-0">
                                        <div
                                            class="row d-flex flex-xl-row-reverse flex-md-row-reverse flex-sm-row-reverse">
                                            <div class="col-sm-2 px-2">
                                                <h6 class="media-heading txt-primary text-right"><a
                                                        href="{{ route('vendor.profile') }}">{{ $data->sender->name }}</a>
                                                </h6>
                                                <a href="{{ route('vendor.profile') }}" class="ltr:float-right ltr:me-4 rtl:float-left rtl:ms-4">
                                                    <img class="rounded-circle" width="45" height="45"
                                                        alt=" " src='{{ optional($data->sender)->fileUrl() }}'>
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


                                        @php
                                            $files = $data->fileName();

                                        @endphp
                                        @foreach ($data->filesUrlNew() as $key => $file)
                                            @if (!empty($file))
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
                                            @endif
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

    {{-- Modal Start --}}
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('vendor.updateReply') }}" id="replyModal">
                {{ csrf_field() }}
                <input type="hidden" name="id" id="reply_id">
                <input type="hidden" name="in_type" id="update_type">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('Update Reply') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <textarea class="form-control reply-modal" name="message" id="summernote1"></textarea>
                            <label id="reply-modal-error" class="error" for="reply-modal"></label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn custom-btn-submit">{{ __('Update') }}</button>
                        <button type="button" class="btn custom-btn-cancel"
                            data-dismiss="modal">{{ __('Cancel') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include('mediamanager::image.modal_image')

@endsection

@section('js')
    <script src="{{ asset('public/datta-able/plugins/summer-note/summernote-lite.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/dist/js/html5lightbox/html5lightbox.min.js') }}"></script>
    <script src="{{ asset('Modules/Ticket/Resources/assets/js/message.min.js') }}"></script>
    {!! translateValidationMessages() !!}
@endsection
