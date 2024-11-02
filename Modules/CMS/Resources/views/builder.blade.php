@extends('admin.layouts.app')
@section('page_title', __('Homepage Builder'))
@section('content')
    @include('mediamanager::image.modal_image')
    @php
        $homeService = new \Modules\CMS\Service\HomepageService();
    @endphp
    <div class="col-md-12 no-print notification-msg-bar smoothly-hide">
        <div class="noti-alert pad">
            <div class="alert bg-dark text-light m-0 text-center">
                <span class="notification-msg"></span>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="col-sm-12 list-container">
        <div class="card">
            <div class="card-header d-md-flex justify-content-between align-items-center">
                <div>
                    <h5>
                        <a href="{{ route('page.home') }}">{{ __('Homepages') }}</a>
                        >>
                        <a href="javascript:void();">{{ $page->name }}</a>

                    </h5>
                </div>
                <div class="d-flex justify-content-end align-items-center">
                    <div class="form-group d-flex mb-0">
                        <button class="btn btn-success btn-sm has-spinner-loader mb-0" id="update_page" type="submit"><i
                                class="feather icon-save ltr:me-1 rtl:ms-1"></i>{{ __('Save') }}
                        </button>
                    </div>
                    <div class="form-group d-flex mb-0">
                        <a class="btn btn-sm btn-info mb-0" href="{{ route('site.page', $page->slug) }}" target="_blank"><i
                                class="feather icon-eye ltr:me-1 rtl:ms-1"></i>{{ __('Preview') }}</a>
                    </div>
                    <div class="form-group d-flex mb-0">
                        <button class="btn btn-sm btn-primary mb-0 ltr:me-0 rtl:ms-0" id="add-new-widget"><i
                                class="feather icon-plus ltr:me-1 rtl:ms-1"></i>{{ __('Add Section') }}</button>
                    </div>
                </div>
        </div>
            <div class="card-body px-4">
                <div class="card-block pt-2 px-0">
                    <ul id="sortable" class="selector">
                        @foreach ($page->components as $component)
                            <li class="ui-state-default" data-id="{{ $level = uniqid('level_') }}">
                                <div class="component-header">
                                    <i class="feather feather icon-move"></i>
                                    <div class="header-text">
                                        <h5 class="header-title">
                                            {{ $component->title ?? optional($component->layout)->name }}
                                        </h5>
                                        @include('cms::pieces.header-badges', [
                                            'layout' => $component->layout,
                                        ])
                                    </div>
                                    <div class="header-btns">
                                        <span class="header-btn delete-button" data-bs-toggle="modal"
                                            data-bs-target="#confirmDelete"
                                            data-component="{{ $component->title ?? optional($component->layout)->name }}"
                                            data-component-id="{{ $component->id }}">
                                            <i class="feather icon-trash-2"></i>
                                        </span>
                                        <span class="header-btn folding closed btn-primary">
                                            <i class="feather icon-chevron-up"></i>
                                        </span>
                                    </div>

                                </div>
                                @include('cms::edit.' . $component->layout->file)
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div>
            <form action="#" id="internal_form">
                @csrf
                <input type="hidden" name="data" id="data">
            </form>
        </div>
    </div>
    <div id="confirmDelete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteLabel">{{ __('Delete Section') }}</h5>
                    <a type="button" class="close h5" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </a>
                </div>
                <div class="modal-body">
                    <p>{{ __('Are you sure to delete this section?') }}</p>
                    <p><strong>{{ __('Section') }}:</strong><span class="ml-" id="component-title"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="py-2 custom-btn-cancel"
                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="button" id="confirmDeleteSubmitBtn" data-task="1"
                        class="btn py-2 custom-btn-submit delete-section-btn">{{ __('Delete') }}
                    </button>
                    <span class="ajax-loading"></span>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('Modules/CMS/Resources/assets/css/draganddrop.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Modules/CMS/Resources/assets/css/style.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}">
@endpush

@section('js')
    <script src="{{ asset('public/dist/plugins/lightbox/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/moment.min.js') }}"></script>
    <script src="{{ asset('Modules/CMS/Resources/assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}"></script>

    <script>
        let selectorData = @json($layouts);
        const selector = `{!! $selector !!}`;
        const sortable = $('#sortable');
        let request;
        let __page = {{ $page->id }};
        const __gridDeleteUrl = `{{ route('builder.delete', ['id' => $page->id]) }}`;
        const __savePageUrl = "{{ route('builder.updateAll', ['id' => $page->id]) }}";
        let popupNotification;
        let deletingSectionId;
        let deletingSection;
        const ajaxResourceUrl = `{{ route('ajaxResourceSelect') }}`;
        const queryOperations = @json($queryOperations);
    </script>

    <script src="{{ asset('public/dist/js/xss.min.js') }}"></script>
    <script src="{{ asset('Modules/CMS/Resources/assets/js/builder.min.js') }}"></script>
    <script src="{{ asset('Modules/CMS/Resources/assets/js/query.min.js') }}"></script>
@endsection
