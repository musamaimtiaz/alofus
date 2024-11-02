@extends('admin.layouts.app')
@section('page_title', __('Pages'))
@section('content')
    <!-- Main content -->
    <div class="col-sm-12 list-container pages-container" id="coupon-list-container">
        <div class="card">
            <div class="card-header d-md-flex justify-content-between align-items-center">
                <h5><a href="{{ route('page.index') }}">{{ __('Page') }}</a></h5>
                <div>
                    @if (in_array('Modules\CMS\Http\Controllers\CMSController@create', $prms))
                        <a href="{{ route('page.create') }}"
                            class="btn btn-outline-primary custom-btn-small mb-0 ltr:me-0 rtl:ms-0 mt-2 mt-md-0">
                            <span class="fa fa-plus"> &nbsp;</span>{{ __('Add Page') }}
                        </a>
                    @endif
                </div>
            </div>
            <div class="card-body px-3">
                <div class="card-block pt-2 px-0">
                    <div class="col-sm-12 row m-0 p-0">
                        @forelse ($pages as $page)
                            <div class="col-12 col-xl-4 col-md-6">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="card-title d-flex justify-content-between">
                                            <h5>{{ $page->name }}
                                            </h5>
                                            <span class="header-btn folding editable" data-id="{{ $page->id }}"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Quick edit') }}"
                                                data-bs-original-title="{{ __('Quick edit') }}">
                                                <i class="feather icon-edit neg-transition-scale-svg -2"></i>
                                            </span>
                                        </div>
                                        @if ($page->status == 'Active')
                                            <span class="badge badge-info">{{ __($page->status) }}</span>
                                        @else
                                            <span class="badge badge-danger">{{ __($page->status) }}</span>
                                        @endif
                                        <p class="card-text">
                                        <dl class="dl-horizontal row">
                                            <dt class="col-12"><u>{{ __('Meta Informations') }}:</u></dt>
                                            <dt class="col-sm-4">{{ __('Title') }}:</dt>
                                            <dd class="col-sm-8">{{ formatString($page->meta_title, 40) }}</dd>
                                            <dt class="col-sm-4">{{ __('Description') }}:</dt>
                                            <dd class="col-sm-8">{{ formatString($page->meta_description) }}</dd>
                                        </dl>
                                        </p>
                                        <div class="header-btns-lg">
                                            <a href="{{ route('pb.edit', ['slug' => $page->slug]) }}" target="_blank"
                                                class="header-btn folding btn-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="{{ __('Edit with pagebuilder') }}"
                                                data-bs-original-title="{{ __('Edit with pagebuilder') }}">
                                                <i
                                                    class="feather icon-grid ltr:me-2 rtl:ms-2"></i>{{ __('Builder') }}
                                            </a>
                                            <a href="{{ route('page.edit', $page->slug) }}"
                                                class="header-btn folding btn-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="{{ __('Edit page') }}"
                                                data-bs-original-title="{{ __('Edit page') }}">
                                                <i
                                                    class="feather icon-edit neg-transition-scale-svg  ltr:me-2 rtl:ms-2"></i>{{ __('Edit') }}
                                            </a>
                                            @if ($page->status == 'Active')
                                                <a href="{{ route('site.page', $page->slug) }}"
                                                    class="header-btn folding btn-primary" target="_blank"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ __('View page') }}"
                                                    data-bs-original-title="{{ __('View page') }}">
                                                    <i
                                                        class="feather icon-eye ltr:me-2 rtl:ms-2"></i>{{ __('Preview') }}
                                                </a>
                                            @endif
                                            <span class="header-btn delete-button" data-bs-toggle="tooltip"
                                                data-id="{{ $page->id }}" data-bs-toggle="modal" data-bs-placement="top"
                                                title="{{ __('Delete page') }}"
                                                data-bs-original-title="{{ __('Delete page') }}">
                                                <i
                                                    class="feather icon-trash-2 ltr:me-2 rtl:ms-2"></i>{{ __('Delete') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-sm-12 m-0 p-0 text-center">
                                {{ __('No pages available.') }}
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('cms::pieces.delete-modal')

    <div id="updatePage" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="updatePageLabel"
        aria-hidden="true">
        <form method="post" action="{{ route('page.update', ['id' => '__id__']) }}" class="silent-form"
            id="updatePageFrom">
            @csrf
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteLabel">{{ __('Update page') }}</h5>
                        <a type="button" class="close h5" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-sm-3" for="pageName">{{ __('Name') }}</label>
                            <div class="col-sm-9">

                                <input type="text" class="form-control inputFieldDesign" required name="name"
                                    id="pageName" placeholder="{{ __('Name') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3" for="PageSlug">{{ __('Slug') }}</label>
                            <div class="col-sm-9">
                                <input type="text" name="slug" class="form-control inputFieldDesign" required
                                    id="pageSlug" placeholder="{{ __('Slug') }}">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <label class="col-sm-3 mt-2" for="Pagelug">{{ __('Status') }}</label>
                            <div class="col-sm-9">
                                <input name="status" type="hidden" value="Inactive">

                                <div class="switch switch-bg d-inline">
                                    <input name="status" type="checkbox" id="switch-1" value="Active" checked="">
                                    <label for="switch-1" class="cr"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="py-2 custom-btn-cancel"
                            data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit"
                            class="btn py-2 custom-btn-submit has-spinner-loader">{{ __('Update') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection


@section('css')
    <link href="{{ asset('Modules/CMS/Resources/assets/css/draganddrop.min.css') }}" rel="stylesheet">
@endsection

@section('js')
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
    <script>
        let tempId;
        let pages = {!! json_encode($pages->toArray()) !!};
        const updateForm = $('#updatePageFrom');
        let updatePageUrl = "{{ route('page.update', ['id' => '__id__']) }}";
        let deletePageUrl = "{{ route('page.delete', ['id' => '__id__']) }}";
    </script>
    <script src="{{ asset('Modules/CMS/Resources/assets/js/app.min.js') }}"></script>
@endsection
