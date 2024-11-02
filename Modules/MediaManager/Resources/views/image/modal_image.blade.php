@section('css')
    <link rel="stylesheet" href="{{ asset('Modules/MediaManager/Resources/assets/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/MediaManager/Resources/assets/css/media-manager.min.css') }}">
@endsection
<div class="modal fade all-image-modal" id="exampleModalCenter"
    tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false"
    data-backdrop="static">
    <div class="img-preview-modal modal-dialog modal-width modal-dialog-centered"
        role="document">
        <div class="modal-content">
            <div class="modal-header image-modal img-preview-modal-header">
                <div class="uploaded-file">
                    <p id="select-file" class="modal-title-color modal-title me-3 p-2" id="exampleModalLongTitle">
                        {{ __('Select File') }}</p>
                    <p id="upload-new" class="modal-title p-2" id="exampleModalLongTitle">{{ __('Upload New') }}</p>
                </div>
                <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button>
                @php
                    $acceptedFiles = getFileExtensions();
                    $acceptedFiles=checkNullExtension($acceptedFiles);
                    $Files = implode(',', $acceptedFiles);
                    $array = explode(',', '.' . implode(',.', $acceptedFiles));
                    $acceptedFilesNew = implode(',', $array);
                @endphp

            </div>
            <div class="modal-body position-relative img-preview-modal-body image-modal-body">
                <div id="upload-card-header" class="card-header image-card-header">
                    <div class="select-dropdown-section">
                        <div class="dropdown">
                            <select class="form-select h-40 form-control-xs sort-option-modal">
                                <option {{ request()->sort_value == 'newest' ? ' selected' : '' }} value="newest">
                                    {{ __('Sort by newest') }}</option>
                                <option {{ request()->sort_value == 'oldest' ? ' selected' : '' }} value="oldest">
                                    {{ __('Sort by oldest') }}</option>
                                <option {{ request()->sort_value == 'largest' ? ' selected' : '' }} value="largest">
                                    {{ __('Sort by largest') }}</option>
                                <option {{ request()->sort_value == 'smallest' ? ' selected' : '' }} value="smallest">
                                    {{ __('Sort by smallest') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="position-static search-section">
                        <input type="text" id="search-input" class="form-control form-control-xs search-image upload-search-image" placeholder="{{ __('Search your files') }}">
                        <i class="search-icon"><span></span></i>
                    </div>
                </div>
                <div class="h-100">
                    <div id="select-items">
                        <?php
                        $files = App\Models\File::getAllFiles();
                        ?>
                        <div id="image-card-container" class="modal-img-container mx-3 media-manager-child-card gap-4">
                            @include('mediamanager::image.child_paginate')
                        </div>
                    </div>
                    <div id="browse-file">
                        <div class="form-group" id="file-type">
                            <label class="col-md-8 control-label"></label>
                            <div class="col-md-8 upload-note ps-4">
                                <span class="badge badge-danger">{{ __('Note') }}!</span>
                                {{ __('Allowed File Extensions:') }} <span
                                    id="accepted-type">{{ $Files }}</span>
                            </div>
                        </div>
                        <div class="uploaded-file-design">
                            <div class="card-block upload-file-card p-0 h-100">
                                <form action="{{ route('mediaManager.store') }}" class="dropzone form-border-design">
                                    @csrf
                                    <div class="fallback">
                                        <input name="file" type="file" multiple />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="loader" class="loader-section">
                <div class="loader-background-design">
                </div>
                <div id="loader-section" class="loader"></div>
            </div>

            <div class="modal-footer justify-content-between img-preview-modal-footer">
                <div class="d-flex align-items-center file-number-show flex-grow-1 overflow-hidden">
                    <div>
                        <div id="file-count" class="me-3">
                            <p> <span id="add-file-count">0</span> {{ __('Files selected') }}</p>
                        </div>
                        <div id="clear-items" class="d-none">
                            <p class="border-0 text-danger m-0 text-nowrap">{{ __('Clear all') }}</p>
                        </div>
                    </div>
                    <div class="image-modal-pagination" id="modal-pagination-container">
                        {!! $files->links() !!}
                    </div>
                </div>
                <div class="modal-button-section">
                    <button type="button" id="clear-item"
                        class="image-modal-clear-button btn btn-warning">{{ __('Clear') }}</button>
                    <button type="button" class="image-modal-add-button btn btn-file-add">{{ __('Add') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('Modules/MediaManager/Resources/assets/js/media-manager.min.js') }}"></script>
<script type="text/javascript">
    'use strict';
    var maxFileSize = "{{ preference('file_size') }}";
    var acceptedFiles = "{{ $acceptedFilesNew }}";
</script>
<script src="{{ asset('public/datta-able/plugins/sweetalert/js/sweetalert.min.js') }}"></script>
<script src="{{ asset('public/dist/plugins/dropzone/dropzone.min.js') }}"></script>
