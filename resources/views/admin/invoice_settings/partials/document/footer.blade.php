<div class="tab-pane fade" id="v-pills-documentFooter" role="tabpanel" aria-labelledby="v-pills-documentFooter-tab">
    <div class="row">
        <div class="col-sm-12">

            <div class="form-group row">
                <label for="meta_title" class="col-sm-3 text-left col-form-label ">{{ __('Footer') }}</label>
                <div class="col-sm-9 d-flex">
                    <div>
                        <input type="hidden" name="invoice[document][footer][is_footer]" value="0">
                        <div class="switch switch-bg d-inline m-r-10">
                            <input type="checkbox" name="invoice[document][footer][is_footer]"
                                {{ $invoice?->document?->footer?->is_footer ? 'checked' : '' }}
                                value="{{ $invoice?->document?->footer?->is_footer }}" id="show-footer">
                            <label for="show-footer" class="cr"></label>
                        </div>
                    </div>

                    <div class="mt-1">
                        <span>{{ __('Enable invoice pdf footer') }}</span>
                    </div>
                </div>
            </div>

            <div class="conditional" data-if="#show-footer">
                <div class="form-group row">
                    <label for="meta_title" class="col-sm-3 text-left col-form-label ">{{ __('Main') }}</label>
                    <div class="col-sm-9 d-flex">
                        <div>
                            <input type="hidden" name="invoice[document][footer][is_main_footer]" value="0">
                            <div class="switch switch-bg d-inline m-r-10">
                                <input type="checkbox" name="invoice[document][footer][is_main_footer]"
                                    value="{{ $invoice?->document?->footer?->is_main_footer }}"
                                    {{ $invoice?->document?->footer?->is_main_footer ? 'checked' : '' }}
                                    id="show-main-footer">
                                <label for="show-main-footer" class="cr"></label>
                            </div>
                        </div>
                        <div class="mt-1">
                            <span>{{ __('Enable invoice pdf main footer section') }}</span>
                        </div>
                    </div>
                </div>

                <div class="form-group row conditional" data-if="#show-main-footer">
                    <label for="meta_title" class="col-sm-3 text-left col-form-label ">{{ __('Label') }}</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control inputFieldDesign"
                            name="invoice[document][footer][main_footer][label]" placeholder="{{ __('label') }}"
                            value="{{ $invoice?->document?->footer?->main_footer?->label }}">
                    </div>
                </div>
                <div class="form-group row conditional" data-if="#show-main-footer">

                    <label for="meta_title" class="col-sm-3 text-left col-form-label ">{{ __('Content') }}</label>
                    <div class="col-sm-6">
                        <textarea class="form-control custom" placeholder="{{ __('Content') }}"
                            name="invoice[document][footer][main_footer][content]" rows="6">{{ $invoice?->document?->footer?->main_footer?->content }}</textarea>
                    </div>
                </div>

                <div class="form-group row conditional" data-if="#show-main-footer">
                    <label for="footer-bottom-title"
                        class="col-sm-3 text-left col-form-label ">{{ __('Text Color') }}</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control demo inputFieldDesign" data-control="hue"
                            name="invoice[document][footer][main_footer][text_color]"
                            value="{{ $invoice?->document?->footer?->main_footer?->text_color }}">
                    </div>
                </div>

                <div class="form-group row conditional" data-if="#show-main-footer">
                    <label for="meta_title" class="col-sm-3 text-left col-form-label">{{ __('Alignment') }}</label>
                    <div class="col-sm-8">
                        <div class="form-group d-inline mr-2">
                            <div class="radio radio-warning d-inline">
                                <input type="radio" name="invoice[document][footer][main_footer][align]"
                                    value="left"
                                    {{ $invoice?->document?->footer?->main_footer?->align == 'left' ? 'checked' : '' }}
                                    id="footer-main-alignment-left">
                                <label for="footer-main-alignment-left" class="cr">{{ __('Left') }}</label>
                            </div>
                        </div>
                        <div class="form-group d-inline mr-2">
                            <div class="radio radio-warning d-inline">
                                <input type="radio" name="invoice[document][footer][main_footer][align]"
                                    value="center"
                                    {{ $invoice?->document?->footer?->main_footer?->align == 'center' ? 'checked' : '' }}
                                    id="footer-main-alignment-center">
                                <label for="footer-main-alignment-center" class="cr">{{ __('Center') }}</label>
                            </div>
                        </div>
                        <div class="form-group d-inline mr-2">
                            <div class="radio radio-warning d-inline">
                                <input type="radio" name="invoice[document][footer][main_footer][align]"
                                    value="right" id="footer-main-alignment-right"
                                    {{ $invoice?->document?->footer?->main_footer?->align == 'right' ? 'checked' : '' }}>
                                <label for="footer-main-alignment-right" class="cr">{{ __('Right') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="conditional" data-if="#show-footer">
                <div class="form-group row">
                    <label for="meta_title" class="col-sm-3 text-left col-form-label ">{{ __('CopyRight') }}</label>
                    <div class="col-sm-9 d-flex">
                       <div>
                        <input type="hidden" name="invoice[document][footer][is_copy_right_footer]" value="0">
                        <div class="switch switch-bg d-inline m-r-10">
                            <input type="checkbox" name="invoice[document][footer][is_copy_right_footer]"
                                {{ $invoice?->document?->footer->is_copy_right_footer ? 'checked' : '' }}
                                value="{{ $invoice?->document?->footer?->is_copy_right_footer }}"
                                id="show-copy-right-footer">
                            <label for="show-copy-right-footer" class="cr"></label>
                        </div>
                       </div>

                        <div class="mt-1">
                            <span>{{ __('Enable invoice pdf copy right section') }}</span>
                        </div>
                    </div>
                </div>

                <div class="form-group row conditional" data-if="#show-copy-right-footer">

                    <label for="meta_title" class="col-sm-3 text-left col-form-label ">{{ __('Content') }}</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control inputFieldDesign"
                            name="invoice[document][footer][copy_right_footer][content]"
                            placeholder="{{ __('Content') }}"
                            value="{{ $invoice?->document?->footer?->copy_right_footer?->content }}">
                    </div>
                </div>

                <div class="form-group row conditional" data-if="#show-copy-right-footer">
                    <label for="footer-bottom-title"
                        class="col-sm-3 text-left col-form-label ">{{ __('Text Color') }}</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control demo inputFieldDesign" data-control="hue"
                            name="invoice[document][footer][copy_right_footer][text_color]"
                            value="{{ $invoice?->document?->footer?->copy_right_footer?->text_color }}">
                    </div>
                </div>

                <div class="form-group row conditional" data-if="#show-copy-right-footer">
                    <label for="meta_title" class="col-sm-3 text-left col-form-label">{{ __('Alignment') }}</label>
                    <div class="col-sm-8">
                        <div class="form-group d-inline mr-2">
                            <div class="radio radio-warning d-inline">
                                <input type="radio" name="invoice[document][footer][copy_right_footer][align]"
                                    value="left" id="footer-copy-right-alignment-left"
                                    {{ $invoice?->document?->footer?->copy_right_footer?->align == 'left' ? 'checked' : '' }}>
                                <label for="footer-copy-right-alignment-left"
                                    class="cr">{{ __('Left') }}</label>
                            </div>
                        </div>
                        <div class="form-group d-inline mr-2">
                            <div class="radio radio-warning d-inline">
                                <input type="radio" name="invoice[document][footer][copy_right_footer][align]"
                                    value="center" id="footer-copy-right-alignment-center"
                                    {{ $invoice?->document?->footer?->copy_right_footer?->align == 'center' ? 'checked' : '' }}>
                                <label for="footer-copy-right-alignment-center"
                                    class="cr">{{ __('Center') }}</label>
                            </div>
                        </div>
                        <div class="form-group d-inline mr-2">
                            <div class="radio radio-warning d-inline">
                                <input type="radio" name="invoice[document][footer][copy_right_footer][align]"
                                    value="right" id="footer-copy-right-alignment-right"
                                    {{ $invoice?->document?->footer?->copy_right_footer?->align == 'right' ? 'checked' : '' }}>
                                <label for="footer-copy-right-alignment-right"
                                    class="cr">{{ __('Right') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
