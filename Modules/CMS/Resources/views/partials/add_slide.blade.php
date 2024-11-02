
<div class="card card-info border-tl-radius-0 box-shadow-unset">
    <div class="card-body mt-neg-12">
        <form action="{{ route('slide.store') }}" method="post" class="form-horizontal">
            @csrf
            <div class="tab-content p-0 box-shadow-unset" id="topNav-v-pills-tabContent">
                {{-- Image and button --}}
                <div class="tab-pane fade" id="v-pills-image-and-button" role="tabpanel" aria-labelledby="v-pills-general-tab">
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="form-group row">
                                <label class="col-sm-3 text-left col-form-label">{{ __('Image') }}</label>
                                <div class="col-sm-8">
                                    <div data-toggle="modal" data-target="#exampleModalCenter"
                                        class="custom-file" data-val="single" id="image-status">
                                        <input class="custom-file-input form-control d-none d-none" name="attachment"
                                            id="validatedCustomFile" accept="image/*">
                                        <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center d-flex justify-content-between align-items-center position-relative"
                                            for="validatedCustomFile">{{ __('Upload image') }}</label>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="meta_title"
                                    class="col-sm-3 text-left col-form-label">{{ __('Button Title') }}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control inputFieldDesign" id="password" name="button_title"
                                        placeholder="{{ __('Button Title') }}"
                                        value="{{ !empty(old('button_title')) ? old('button_title') : '' }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="meta_description"
                                    class="col-sm-3 text-left col-form-label">{{ __('Button Link') }}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control inputFieldDesign" id="password" name="button_link"
                                        placeholder="{{ __('Button Link') }}"
                                        value="{{ !empty(old('button_link')) ? old('button_link') : '' }}">
                                </div>
                            </div>
                            <div class="row mt-9">
                                <label for="meta_description"
                                    class="col-sm-3 col-12 text-left col-form-label">{{ __('Button Alignment') }}</label>
                                <div class="col-sm-8 col-12 mt-9">
                                    <div class="form-group d-inline ltr:me-2 rtl:ms-2' }}">
                                        <div class="radio radio-warning d-inline">
                                            <input type="radio" name="button_position" value="left" id="butotn-alignment-left" checked>
                                            <label for="butotn-alignment-left" class="cr">{{ __('Left') }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group d-inline ltr:me-2 rtl:ms-2">
                                        <div class="radio radio-warning d-inline">
                                            <input type="radio" name="button_position" value="center" id="button-alignment-center">
                                            <label for="button-alignment-center" class="cr">{{ __('Center') }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group d-inline ltr:me-2 rtl:ms-2">
                                        <div class="radio radio-warning d-inline">
                                            <input type="radio" name="button_position" value="right" id="button-alignment-right">
                                            <label for="button-alignment-right" class="cr">{{ __('Right') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mt-14p">
                                <label for="meta_description" class="col-sm-3 text-left col-form-label">{{ __('Button Text Color') }}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control demo inputFieldDesign" data-control="hue" name="button_font_color" placeholder="{{ __('Button Text Color') }}" value="#ffffff">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="meta_description" class="col-sm-3 text-left col-form-label">{{ __('Button Background Color') }}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control demo inputFieldDesign" data-control="hue" name="button_bg_color" placeholder="{{ __('Button Background Color') }}" value="#000000">
                                </div>
                            </div>

                            <div class="row mt-14">
                                <div class="col-md-3">
                                    <label>{{ __('Animation') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <select class="form-control select2-hide-search" id="button_animation"
                                            name="button_animation">
                                            @foreach ($animations as $key => $animation)
                                                <option value="{{ $animation }}">{{ $animation }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-14">
                                <div class="col-md-3">
                                    <label>{{ __('Delay') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text rounded-0 ltr:rounded-start rtl:rounded-end">{{ __('Sec') }}</span>
                                        </div>
                                        <input type="text" placeholder="0.0 - 4.0" class="form-control positive-float-number validation-sec" name="button_delay"
                                            value="{{ !empty(old('button_delay')) ? old('button_delay') : '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row d-none">
                                <label for="meta_description"
                                    class="col-sm-3 text-left col-form-label">{{ __('Slider') }}</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="slider_id">
                                        <option value="{{ $slider->id }}">{{ $slider->name }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="Status" class="col-sm-3 col-form-label">{{ __('Open In New Window') }}</label>
                                <div class="col-sm-8">
                                    <input type="hidden" name="is_open_in_new_window" value="No">
                                    <div class="switch switch-bg d-inline m-r-10">
                                        <input class="status" type="checkbox" value="Yes"
                                            name="is_open_in_new_window" id="is_private" checked>
                                        <label for="is_private" class="cr"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="mt-neg-12" id="img-container">
                                <!-- img will be shown here -->
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer py-0 mt-9">
                        <div class="form-group row">
                            <label for="btn_save" class="col-sm-3 control-label"></label>
                            <div class="col-sm-12">
                                <button data-id="v-pills-title-tab" type="button" class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left switch-tab">{{ __('Next') }}</button>
                                <button type="button" class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left" disabled>{{ __('Previous') }}</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Title --}}
                <div class="tab-pane fade" id="v-pills-title" role="tabpanel" aria-labelledby="v-pills-title-tab">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>{{ __('Title') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control inputFieldDesign" name="title_text"
                                            placeholder="{{ __('Title') }}" maxlength="191"
                                            value="{{ !empty(old('title_text')) ? old('title_text') : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>{{ __('Text Size') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="number" class="form-control inputFieldDesign" name="title_font_size"
                                            placeholder="{{ __('Text Size') }}"
                                            value="{{ !empty(old('title_font_size')) ? old('title_font_size') : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>{{ __('Text Color') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control demo inputFieldDesign" data-control="hue" name="title_font_color"
                                            placeholder="{{ __('Text Color') }}"
                                            value="{{ !empty(old('title_font_color')) ? old('title_font_color') : '#000000' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-md-3">
                                    <label>{{ __('Alignment') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group d-inline ltr:me-2 rtl:ms-2">
                                        <div class="radio radio-warning d-inline">
                                            <input type="radio" name="title_direction" value="left" id="title-direction-left" checked>
                                            <label for="title-direction-left" class="cr">{{ __('Left') }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group d-inline ltr:me-2 rtl:ms-2">
                                        <div class="radio radio-warning d-inline">
                                            <input type="radio" name="title_direction" value="center" id="title-direction-center">
                                            <label for="title-direction-center" class="cr">{{ __('Center') }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group d-inline ltr:me-2 rtl:ms-2">
                                        <div class="radio radio-warning d-inline">
                                            <input type="radio" name="title_direction" value="right" id="title-direction-right">
                                            <label for="title-direction-right" class="cr">{{ __('Right') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-3">
                                    <label>{{ __('Animation') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <select class="form-control select2-hide-search" id="title_animation"
                                            name="title_animation">
                                            @foreach ($animations as $key => $animation)
                                                <option value="{{ $animation }}">{{ $animation }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-14">
                                <div class="col-md-3">
                                    <label>{{ __('Delay') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text rounded-0 ltr:rounded-start rtl:rounded-end">{{ __('Sec') }}</span>
                                        </div>
                                        <input type="text" placeholder="0.0 - 4.0" class="form-control positive-float-number validation-sec" name="title_delay"
                                            value="{{ !empty(old('title_delay')) ? old('title_delay') : '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer py-0 mt-9">
                        <div class="form-group row">
                            <label for="btn_save" class="col-sm-3 control-label"></label>
                            <div class="col-sm-12">
                                <button data-id="v-pills-sub-title-tab" type="button" class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left switch-tab">{{ __('Next') }}</button>
                                <button data-id="v-pills-general-tab" type="button" class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left switch-tab">{{ __('Previous') }}</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sub Title --}}
                <div class="tab-pane fade" id="v-pills-sub-title" role="tabpanel" aria-labelledby="v-pills-sub-title-tab">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>{{ __('Title') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control inputFieldDesign" name="sub_title_text"
                                            placeholder="{{ __('Title') }}" maxlength="191"
                                            value="{{ !empty(old('sub_title_text')) ? old('sub_title_text') : '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <label>{{ __('Text Size') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="number" class="form-control inputFieldDesign" name="sub_title_font_size"
                                            placeholder="{{ __('Text Size') }}"
                                            value="{{ !empty(old('sub_title_font_size')) ? old('sub_title_font_size') : '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <label>{{ __('Text Color') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control demo inputFieldDesign" data-control="hue" name="sub_title_font_color"
                                            placeholder="{{ __('Text Color') }}"
                                            value="{{ !empty(old('sub_title_font_color')) ? old('sub_title_font_color') : '#000000' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-3">
                                    <label>{{ __('Alignment') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group d-inline ltr:me-2 rtl:ms-2">
                                        <div class="radio radio-warning d-inline">
                                            <input type="radio" name="sub_title_direction" value="left" id="sub-title-direction-left" checked>
                                            <label for="sub-title-direction-left" class="cr">{{ __('Left') }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group d-inline ltr:me-2 rtl:ms-2">
                                        <div class="radio radio-warning d-inline">
                                            <input type="radio" name="sub_title_direction" value="center" id="sub-title-direction-center">
                                            <label for="sub-title-direction-center" class="cr">{{ __('Center') }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group d-inline ltr:me-2 rtl:ms-2">
                                        <div class="radio radio-warning d-inline">
                                            <input type="radio" name="sub_title_direction" value="right" id="sub-title-direction-right">
                                            <label for="sub-title-direction-right" class="cr">{{ __('Right') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-3">
                                    <label>{{ __('Animation') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <select class="form-control select2-hide-search" id="sub_title_animation"
                                            name="sub_title_animation">
                                            @foreach ($animations as $key => $animation)
                                                <option value="{{ $animation }}">{{ $animation }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-14">
                                <div class="col-md-3">
                                    <label>{{ __('Delay') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text rounded-0 ltr:rounded-start rtl:rounded-end">{{ __('Sec') }}</span>
                                        </div>
                                        <input type="text" placeholder="0.0 - 4.0" class="form-control positive-float-number validation-sec"
                                            name="sub_title_delay"
                                            value="{{ !empty(old('sub_title_delay')) ? old('sub_title_delay') : '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer py-0 mt-9">
                        <div class="form-group row">
                            <label for="btn_save" class="col-sm-3 control-label"></label>
                            <div class="col-sm-12">
                                <button data-id="v-pills-description-tab" type="button" class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left switch-tab">{{ __('Next') }}</button>
                                <button data-id="v-pills-title-tab" type="button" class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left switch-tab">{{ __('Previous') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Description --}}
                <div class="tab-pane fade" id="v-pills-description" role="tabpanel" aria-labelledby="v-pills-description-tab">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>{{ __('Title') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control inputFieldDesign" name="description_title_text"
                                            placeholder="{{ __('Title') }}" maxlength="191"
                                            value="{{ !empty(old('description_title_text')) ? old('description_title_text') : '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <label>{{ __('Text Size') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="number" class="form-control inputFieldDesign" name="description_title_font_size"
                                            placeholder="{{ __('Text Size') }}"
                                            value="{{ !empty(old('description_title_font_size')) ? old('description_title_font_size') : '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <label>{{ __('Text Color') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control demo inputFieldDesign" data-control="hue" name="description_title_font_color"
                                            placeholder="{{ __('Text Color') }}"
                                            value="{{ !empty(old('description_title_font_color')) ? old('description_title_font_color') : '#000000' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-3">
                                    <label>{{ __('Alignment') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group d-inline ltr:me-2 rtl:ms-2">
                                        <div class="radio radio-warning d-inline">
                                            <input type="radio" name="description_title_direction" value="left" id="description-title-direction-left" checked>
                                            <label for="description-title-direction-left" class="cr">{{ __('Left') }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group d-inline ltr:me-2 rtl:ms-2">
                                        <div class="radio radio-warning d-inline">
                                            <input type="radio" name="description_title_direction" value="center" id="description-title-direction-center">
                                            <label for="description-title-direction-center" class="cr">{{ __('Center') }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group d-inline ltr:me-2 rtl:ms-2">
                                        <div class="radio radio-warning d-inline">
                                            <input type="radio" name="description_title_direction" value="right" id="description-title-direction-right">
                                            <label for="description-title-direction-right" class="cr">{{ __('Right') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-3">
                                    <label>{{ __('Animation') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <select class="form-control select2-hide-search" id="description_title_animation"
                                            name="description_title_animation">
                                            @foreach ($animations as $key => $animation)
                                                <option value="{{ $animation }}">{{ $animation }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-14">
                                <div class="col-md-3">
                                    <label>{{ __('Delay') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text rounded-0 ltr:rounded-start rtl:rounded-end">{{ __('Sec') }}</span>
                                        </div>
                                        <input type="text" placeholder="0.0 - 4.0" class="form-control positive-float-number validation-sec" name="description_title_delay"
                                            value="{{ !empty(old('description_title_delay')) ? old('description_title_delay') : '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer py-0 mt-9">
                        <div class="form-group row">
                            <label for="btn_save" class="col-sm-3 control-label"></label>
                            <div class="col-sm-12">
                                <button type="submit" class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left coupon-submit-button" id="footer-btn">{{ __('Save') }}</button>
                                <a href="{{ route('slider.index') }}" class="py-2 form-submit custom-btn-cancel ltr:float-right ltr:me-2 rtl:float-left rtl:ms-2 coupon-submit-button">{{ __('Cancel') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- form-picker-custom Js -->
<script src="{{ asset('public/datta-able/js/pages/form-picker-custom.min.js') }}"></script>
