@extends('admin.layouts.app')
@section('page_title', 'Sliders')
@section('content')
    <!-- Main content -->
    <div class="col-sm-12 list-container" id="slider-list-container">
        <div class="card">
            <div class="card-header">
                <h5><a href="{{ route('slider.index') }}">{{ __('Sliders') }}</a></h5>
                <div class="card-header-right d-inline-block">
                    @if (in_array('Modules\CMS\Http\Controllers\SliderController@store', $prms))
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#add-category-name"
                            class="add-payment-term btn btn-outline-primary custom-btn-small">
                            <span class="fa fa-plus"> &nbsp;</span>
                            {{ __('Add :x', ['x' => 'Slider']) }}
                        </a>
                    @endif
                </div>
            </div>
            <div class="card-body px-0">
                <div class="card-block pt-2 px-2">
                    <div class="col-sm-12 row m-0 p-0">
                        @forelse ($sliders as $slider)
                            <!-- [ Design-sprint section ] start -->

                            <div class="col-xl-4 col-md-12">
                                <div class="card Design-sprint theme-bg1 box-shadow-unset border">
                                    <div class="card-header borderless pb-0">
                                        <h5 class="d-block mb-2">{{ $slider->name }}</h5>
                                        @if ($slider->status == 'Active')
                                            <span
                                                class="d-inline-block badge badge-info mt-4">{{ __($slider->status) }}</span>
                                        @else
                                            <span
                                                class="d-inline-block badge badge-danger mt-4">{{ __($slider->status) }}</span>
                                        @endif
                                        <div class="card-header-right">
                                            @if (in_array('Modules\CMS\Http\Controllers\SliderController@update', $prms))
                                                <span class="header-btn slider-icon mr-2 cursor_pointer"
                                                    id="{{ $slider->id }}" name="{{ $slider->name }}"
                                                    status="{{ $slider->status }}" data-bs-toggle="modal"
                                                    data-placement="top" data-bs-target="#edit-slider"
                                                    title="{{ __('Edit slider') }}">
                                                    <i class="feather icon-edit neg-transition-scale-svg "></i>
                                                </span>
                                            @endif
                                            @if (in_array('Modules\CMS\Http\Controllers\SliderController@delete', $prms))
                                                <form method="post"
                                                    action="{{ route('slider.delete', ['id' => $slider->id]) }}"
                                                    id="delete-slider-{{ $slider->id }}" accept-charset="UTF-8"
                                                    class="display_inline">
                                                    @csrf
                                                    <span
                                                        class="header-btn slider-icon delete-button hw-1-8rem cursor_pointer"
                                                        data-bs-toggle="modal" data-label="Delete" data-delete="slider"
                                                        data-bs-target="#confirmDelete" data-id="{{ $slider->id }}"
                                                        title="{{ __('Delete slider') }}"
                                                        data-title="{{ __('Delete :x', ['x' => __('Slider')]) }}"
                                                        data-message="{{ __('Are you sure to delete this?') }}">
                                                        <i class="feather icon-trash-2"></i>
                                                    </span>
                                                </form>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="card-block">

                                        <ul class="design-image">
                                            <a href="{{ route('slide.create', ['slug' => $slider->slug]) }}">
                                                <li><button class="btn "><i
                                                            class="fas fa-plus f-14 ltr:me-0 rtl:ms-0"></i></button>
                                                </li>
                                            </a>
                                            @forelse ($slider->slides as $slide)
                                                @if ($loop->iteration <= 3)
                                                    <a href="{{ route('slide.create', ['slug' => $slider->slug]) }}">
                                                        <li><img width="40" height="40"
                                                                class="rounded-circle object-fit-cover neg-transition-scale"
                                                                src="{{ $slide->fileUrl() }}" alt="chat-user"></li>
                                                    </a>
                                                @endif
                                            @empty
                                                {{ __('No slide added yet.') }}
                                            @endforelse
                                            @if (count($slider->slides) > 3)
                                                <li>+{{ count($slider->slides) - 3 }}</li>
                                            @endif

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- [ Design-sprint section ] end -->
                        @empty
                            {{ __('No slider available.') }}
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add slider --}}
    <div id="add-category-name" class="modal fade display_none" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Add :x', ['x' => __('Slider')]) }}</h4>
                    <a type="button" class="close h4" data-bs-dismiss="modal">×</a>
                </div>
                <form action="{{ route('slider.store') }}" method="post" id="addPaymentForm" class="form-horizontal">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-sm-4 control-label f-14 require" for="store-term">{{ __('Name') }}</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control f-14 inputFieldDesign" name="name"
                                    placeholder="{{ __('Name') }}" id="store-term" value="" required
                                    minlength="3"
                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 control-label f-14">{{ __('Status') }}</label>
                            <div class="col-sm-7">
                                <input type="hidden" name="status" value="Inactive">
                                <div class="switch d-inline m-r-10">
                                    <input class="is_default" type="checkbox" name="status" value="Active" id="is_default"
                                        checked>
                                    <label for="is_default" class="cr"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer py-0">
                        <div class="form-group row">
                            <label for="btn_save" class="col-sm-3 control-label f-14"></label>
                            <div class="col-sm-12">
                                <button type="submit"
                                    class="btn custom-btn-submit ltr:float-right rtl:float-left">{{ __('Create') }}</button>
                                <button type="button"
                                    class="py-13 custom-btn-cancel float-end ltr:me-2 rtl:ms-2 h4"
                                    data-bs-dismiss="modal">{{ __('Close') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit slider --}}
    <div id="edit-slider" class="modal fade display_none" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Edit :x', ['x' => __('Slider')]) }}</h4>
                    <a type="button" class="close h4" data-bs-dismiss="modal">×</a>
                </div>
                <form action="{{ route('slider.update') }}" method="post" id="edit-slider-form"
                    class="form-horizontal">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" class="edit-id" id="edit-id" name="id">

                        <div class="form-group row">
                            <label class="col-sm-4 control-label f-14 require"
                                for="store-term">{{ __('Name') }}</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control f-14 inputFieldDesign" name="name"
                                    placeholder="{{ __('Name') }}" id="name" value="" required
                                    minlength="3"
                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 control-label f-14">{{ __('Status') }}</label>
                            <div class="col-sm-7">
                                <input type="hidden" name="status" value="Inactive">
                                <div class="switch d-inline m-r-10">
                                    <input class="is_default" type="checkbox" name="status" id="edit_status">
                                    <label for="is_default" class="cr"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer py-0">
                        <div class="form-group row">
                            <label for="btn_save" class="col-sm-3 control-label f-14"></label>
                            <div class="col-sm-12">
                                <button type="submit"
                                    class="btn custom-btn-submit float-end">{{ __('Update') }}</button>
                                <button type="button"
                                    class="py-13 custom-btn-cancel float-end h4 ltr:me-2 rtl:ms-2"
                                    data-bs-dismiss="modal">{{ __('Close') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Delete slider --}}
    @include('admin.layouts.includes.delete-modal')
@endsection

@section('js')
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
    <script src="{{ asset('Modules/CMS/Resources/assets/js/slider.min.js') }}"></script>
@endsection
