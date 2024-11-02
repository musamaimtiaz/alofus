@extends('vendor.layouts.app')
@section('page_title', __('Homepages'))
@section('content')

    <!-- Main content -->
    <div class="col-sm-12 list-container homepage-container" id="vendor-home-container">
        <div class="card">
            <div class="card-header">
                <h5><a href="{{ route('vendor.home') }}">{{ __('Homepages') }}</a></h5>
                <div class="card-header-right d-inline-block">
                    @if (in_array('Modules\CMS\Http\Controllers\Vendor\HomeController@create', $prms))
                        <a href="{{ route('vendor.home.create') }}" class="btn btn-outline-primary custom-btn-small">
                            <span class="fa fa-plus"> &nbsp;</span>{{ __('Add Homepage') }}
                        </a>
                    @endif
                </div>
            </div>

            <div class="card-body px-0">
                <div class="card-block pt-2 px-2">
                    <div class="col-sm-12 row m-0 p-0">
                        @forelse ($pages as $page)
                            <div class="col-12 col-xl-4 col-md-6 col-sm-6">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="card-title text-editable d-flex justify-content-between">
                                            <h5>{{ $page->name }}
                                            </h5>
                                            <span class="header-btn folding editable" data-id="{{ $page->id }}"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Quick edit') }}"
                                                data-bs-original-title="{{ __('Quick edit') }}">
                                                <i class="feather icon-edit neg-transition-scale-svg -2"></i>
                                            </span>
                                        </div>
                                        @if ($page->default)
                                            <span class="badge badge-success">{{ __('Default') }}</span>
                                        @else
                                            @if ($page->status == 'Active')
                                                <span class="badge badge-info">{{ __($page->status) }}</span>
                                            @else
                                                <span class="badge badge-danger">{{ __($page->status) }}</span>
                                            @endif
                                        @endif
                                        <p class="card-text">
                                        <dl class="dl-horizontal row">
                                            <dt class="col-12">{{ __('Meta Informations') }}:</dt>
                                            <dt class="col-sm-4">{{ __('Title') }}</dt>
                                            <dd class="col-sm-8">{{ formatString($page->meta_title, 40) }}</dd>
                                            <dt class="col-sm-4">{{ __('Description') }}</dt>
                                            <dd class="col-sm-8">{{ formatString($page->meta_description) }}</dd>
                                        </dl>
                                        </p>
                                        <div class="header-btns-lg">
                                            <a href="{{ route('vendor.builder.edit', $page->slug) }}" target="_blank"
                                                class="header-btn folding btn-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="{{ __('Edit with pagebuilder') }}"
                                                data-bs-original-title="{{ __('Edit it pagebuilder') }}">
                                                <i
                                                    class="feather icon-grid ltr:me-2 rtl:ms-2"></i>{{ __('Builder') }}
                                            </a>
                                            <a href="{{ route('vendor.home.edit', $page->slug) }}"
                                                class="header-btn folding btn-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="{{ __('Edit page') }}"
                                                data-bs-original-title="{{ __('Edit page') }}">
                                                <i
                                                    class="feather icon-edit neg-transition-scale-svg  ltr:me-2 rtl:ms-2"></i>{{ __('Edit') }}
                                            </a>
                                            <a href="{{ route('site.shop', ['alias' => auth()->user()?->shop()?->alias ?? 'unknown', 'homepage' => $page->slug]) }}" target="_blank"
                                                class="header-btn folding btn-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="{{ __('View page') }}"
                                                data-bs-original-title="{{ __('View page') }}">
                                                <i
                                                    class="feather icon-eye ltr:me-2 rtl:ms-2"></i>{{ __('Preview') }}
                                            </a>
                                            @if (!$page->default)
                                                <span class="header-btn delete-button" data-bs-toggle="tooltip"
                                                    data-id="{{ $page->id }}" data-bs-toggle="modal"
                                                    data-bs-placement="top" title="{{ __('Delete page') }}"
                                                    data-bs-original-title="{{ __('Delete page') }}">
                                                    <i
                                                        class="feather icon-trash-2 ltr:me-2 rtl:ms-2"></i>{{ __('Delete') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            {{ __('No pages available.') }}
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('cms::pieces.delete-modal')

    <div id="updatePage" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="updatePageLabel"
        aria-hidden="true">
        <form method="post" action="{{ route('vendor.home.update', ['id' => '__id__']) }}" class="silent-form"
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
                                    id="pageSlug" placeholder={{ __('Slug') }}>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 mt-2" for="status">{{ __('Status') }}</label>
                            <div class="col-sm-9">
                                <input name="status" type="hidden" value="Inactive">
                                <div class="switch switch-bg d-inline">
                                    <input name="status" class="status_c inputFieldDesign" type="checkbox"
                                        id="switch-1" value="Active" checked="">
                                    <label for="switch-1" class="cr"></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <label class="col-sm-3 mt-2" for="default">{{ __('Default') }}</label>
                            <div class="col-sm-9 d-flex">
                                <input name="default" type="hidden" value="0">
                                <div class="switch switch-bg d-inline">
                                    <input name="default" class="default_c" type="checkbox" id="switch-2"
                                        value="1" checked="">
                                    <label for="switch-2" class="cr"></label>
                                </div>
                                <div class="mt-2">
                                    <span class="badge badge-danger mt-1">{{ __('Note') }}!</span>
                                    <small
                                        class="mt-1 ltr:ms-2 rtl:me-2">{{ __('Status must be active to make it default.') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="py-2 custom-btn-cancel"
                            data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit"
                            class="btn custom-btn-submit has-spinner-loader">{{ __('Update') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('css')
    <link href="{{ asset('Modules/CMS/Resources/assets/css/draganddrop.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('Modules/Addons/Resources/assets/css/addon.min.css') }}">
@endsection

@section('js')
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
    <script>
        let tempId;
        let pages = {!! json_encode($pages->toArray()) !!};
        const updateForm = $('#updatePageFrom');
        let updatePageUrl = "{{ route('vendor.home.update', ['id' => '__id__']) }}";
        let deletePageUrl = "{{ route('vendor.home.delete', ['id' => '__id__']) }}";
    </script>
    <script src="{{ asset('Modules/CMS/Resources/assets/js/app.js') }}"></script>

@endsection
