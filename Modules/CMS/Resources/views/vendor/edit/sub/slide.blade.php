@php
    $slide = miniCollection($component->slide ?? []);
@endphp
<div class="form-group row form-parent bannerOptions {{ $component && $component->sidebar == 'slide' ? 'd-flex' : 'd-none' }}">
    <div class="col-12">
        <hr>
    </div>
    <label class="col-md-3 control-label">
        <dt>{{ __('Slide') }}</dt>
    </label>
    <div class="col-md-8">
        <div class="form-group parent-class row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-12 control-label">{{ __('Upper Subtitle') }}</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control inputFieldDesign" value="{{ $slide->u_subtitle ?? '' }}"
                            name="slide[u_subtitle]">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-12 control-label">{{ __('Lower Subtitle') }}</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control inputFieldDesign" value="{{ $slide->l_subtitle ?? '' }}"
                            name="slide[l_subtitle]">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-12 control-label">{{ __('Title') }}</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control inputFieldDesign" value="{{ $slide->title ?? '' }}"
                            name="slide[title]">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-12 control-label">{{ __('Image') }}</small></label>

                    @php
                        $rand = uniqid();
                    @endphp
                    <div class="col-sm-12 image-box">
                        <div class="custom-file media-manager" data-name="slide[image]" data-val="single"
                            id="image-status">
                            <input class="custom-file-input form-control d-none" id="validatedCustomFile{{ $rand }}" accept="image/*">
                            <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                                for="validatedCustomFile{{ $rand }}">{{ __('Upload image') }}</label>
                        </div>
                        <div class="preview-image">
                            @if ($slide->image)
                                <div class="d-flex flex-wrap mt-2">
                                    <div class="position-relative border boder-1 media-box p-1 ltr:me-2 rtl:ms-2 rounded mt-2">
                                        <div class="position-absolute rounded-circle text-center img-remove-icon">
                                            <i class="fa fa-times"></i>
                                        </div>
                                        <img class="upl-img neg-transition-scale" class="p-1"
                                            src="{{ asset('public/uploads') . DIRECTORY_SEPARATOR . $slide->image }}"
                                            alt="{{ __('Image') }}">
                                        <input type="hidden" name="slide[image]" value="{{ $slide->image }}">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-12 control-label">{{ __('Button Text') }}</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control inputFieldDesign" value="{{ $slide->button ?? '' }}"
                            name="slide[button]">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-12 control-label">{{ __('Link') }}</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control inputFieldDesign" value="{{ $slide->link }}" name="slide[link]">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@php
    unset($slide);
@endphp
