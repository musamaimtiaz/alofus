@extends('admin.layouts.app')
@section('page_title', __('Media Manager'))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/fileupload/css/fileupload.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/MediaManager/Resources/assets/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/MediaManager/Resources/assets/css/media-manager.min.css') }}">
@endsection
@section('content')

    <div class="col-sm-12" id="media-manager-container">
        <div class="card">
            <div class="card-header d-md-flex justify-content-between align-items-center">
                <h5 class="mb-0 h6"><a href="{{ route('mediaManager.uploadedFiles') }}">{{ __('All files') }}</h5>
                @if (in_array('Modules\MediaManager\Http\Controllers\MediaManagerController@create', $prms))
                    <a href="{{ route('mediaManager.create') }}"
                        class="btn m-0 btn-outline-primary custom-btn-small add-files-btn">
                        <span class="fa fa-plus"> &nbsp;</span>{{ __('Add Files') }}
                    </a>
                @endif
            </div>
            <form action='{{ route('mediaManager.uploadedFiles') }}' method="get" class="form-horizontal px-4"
                id="media-list" enctype="multipart/form-data">
                <div class="form-search-container" class="mx-2">
                    <div class="dropdown col-md-3 p-0 mb-3">
                        <select class="form-control select2 form-control-xs sort-option" name="sort_value">
                            <option {{ request()->sort_value == 'newest' ? ' selected' : '' }} value="newest">
                                {{ __('Sort by newest') }}</option>
                            <option {{ request()->sort_value == 'oldest' ? ' selected' : '' }} value="oldest">
                                {{ __('Sort by oldest') }}</option>
                            <option {{ request()->sort_value == 'smallest' ? ' selected' : '' }} value="smallest">
                                {{ __('Sort by smallest') }}</option>
                            <option {{ request()->sort_value == 'largest' ? ' selected' : '' }} value="largest">
                                {{ __('Sort by largest') }}</option>
                        </select>
                    </div>
                    <div class="justify-content-between align-items-center d-flex position-relative mb-3">
                        <input type="text" class="form-control form-control-xs search-button image-search-button"
                            name="sort_name" placeholder="{{ __('Search your files') }}"
                            value="{{ !empty(request('sort_name')) ? request('sort_name') : '' }}">
                        <button type="submit" class="search-button media-manager-search"><i
                                class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
            <div class="card-block">
                <div class="card-arrangement-design">
                    @if (count($files) >= 1)
                        @foreach ($files as $file)
                        @php $imagePath = $file->fileUrlNew(['id' => $file->id, 'type' => 'items', 'isMediamanager' => true]) @endphp
                        @if(!empty($imagePath))
                            <div class="card-design">
                                <div class="thumbnail card-border-design position-relative">
                                    <div class="card-dropdown">
                                        <span class="dropdown-icon" data-bs-toggle="dropdown"><i
                                                class="fa fa-ellipsis-v"></i></span>
                                        <div class="dropdown-menu dropdown-menu-right media-dropdown" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item image-drop-down-menu dropdown-menus-design text-left"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal" href="#"
                                                id="{{ $file->id }}"
                                                type="{{ isset($file->params['type']) ? $file->params['type'] : '' }}"
                                                size="{{ !empty($file->file_size) ? $file->file_size . __('KB') : '' }}"
                                                name="{{ $file->original_file_name }}"
                                                user="{{ isset($file->user) && !empty($file->user->name) ? $file->user->name : '' }}"
                                                time="{{ $file->created_at }}">
                                                <i class="fa fa-info-circle ltr:me-2 rtl:ms-2"></i>
                                                {{ __('Details Info') }}</a>
                                            <a class="dropdown-item image-drop-down-menu dropdown-menus-design text-left"
                                                href="{{ route('mediaManager.download', ['id' => $file->id]) }}">
                                                <i class="fa fa-download ltr:me-2 rtl:ms-2"></i>
                                                {{ __('Download') }}</a>
                                            <a class="dropdown-item copy-link image-drop-down-menu dropdown-menus-design text-left"
                                                data-url="{{ $file->fileUrlNew(['id' => $file->id, 'type' => 'products']) }}"
                                                href="javascript:void(0)">
                                                <i class="fa fa-copy ltr:me-2 rtl:ms-2"></i>
                                                {{ __('Copy Link') }}</a>
                                            <a class="dropdown-item delete-image image-drop-down-menu dropdown-menus-design text-left"
                                                data-id="{{ $file->id }}" href="javascript:void(0)">
                                                <i class="fa fa-trash ltr:me-2 rtl:ms-2"></i>
                                                {{ __('Delete') }}</a>
                                        </div>
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">
                                                        {{ __('File Info') }}</h5>
                                                    <a type="button" class="close h5" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </a>
                                                </div>
                                                <div id="info-modal-content">
                                                    <div class="modal-body c-scrollbar-light position-relative">
                                                        <div class="form-group">
                                                            <label class="pb-2">{{ __('File Name') }}</label>
                                                            <input type="text" class="form-control inputFieldDesign" readonly id="file-name">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="pb-2">{{ __('File Type') }}</label>
                                                            <input type="text" class="form-control inputFieldDesign" readonly id="file-type">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="pb-2">{{ __('File Size') }}</label>
                                                            <input type="text" class="form-control inputFieldDesign" readonly id="file-size">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="pb-2">{{ __('Uploaded By') }}</label>
                                                            <input type="text" class="form-control inputFieldDesign" readonly id="uploaded-by">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="pb-2">{{ __('Uploaded At') }}</label>
                                                            <input type="text" class="form-control inputFieldDesign" readonly id="uploaded-date">
                                                            <input type="hidden" class="form-control inputFieldDesign" readonly id="file-id">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="text-center">
                                                            <a class="btn btn-secondary info-download-button"
                                                                id="download-image" href="javascript:void(0)"
                                                                target="_blank">{{ __('Download') }}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-3">
                                        <div class="thumb-{{ $file->id }}" id="modal-img-des-container">
                                            <div>
                                                @if (isset($file->params) &&
                                                !empty($file->params['type'] && in_array($file->params['type'], getFileExtensions(6))))
                                                <video class="media-manager-image img-fluid img-thumbnail p-0 mb-1 image-id neg-transition-scale" controls>
                                                    <source src="{{ $imagePath }}" type="video/mp4">
                                                </video>
                                                @elseif (isset($file->params) &&
                                                    !empty($file->params['type'] && in_array($file->params['type'], getFileExtensions(5))))
                                                    <div
                                                        class="card-file-thumb img-fluid img-thumbnail image-id p-4 media-manager-image">
                                                        <i class="fa fa-file fa-6" aria-hidden="true"></i>
                                                    </div>
                                                @else

                                                    <img src="{{ $imagePath }}"
                                                        id="{{ $file->id }}" alt="{{ __('Image') }}"
                                                        class="media-manager-image img-fluid img-thumbnail p-0 mb-1 image-id neg-transition-scale" />
                                                @endif
                                            </div>
                                            <div class="pb-1">
                                                <p class="m-0 font-weight-bold">
                                                    {{ nameConversion($file->original_file_name) }}</p>
                                                <small
                                                    class="image-size-name">{{ !empty($file->file_size) ? number_format($file->file_size, preference('decimal_digits'), '.', ',') : '' }}
                                                    {{ __('KB') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    @else
                        <p class="no-file-message">{{ __('Media not found') }}</p>
                    @endif
                </div>
                <div class="media-manager-pagiantion image-modal-pagination"> {{ $files->links() }} </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('public/datta-able/plugins/sweetalert/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/fileupload/js/dropzone.min.js') }}"></script>
    <script src="{{ asset('Modules/MediaManager/Resources/assets/js/media-manager.min.js') }}"></script>
@endsection
