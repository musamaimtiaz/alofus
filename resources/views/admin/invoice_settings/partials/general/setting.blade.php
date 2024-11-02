<div class="tab-pane fade show active" id="v-pills-social-share" role="tabpanel" aria-labelledby="v-pills-social-share-tab">
    <div class="row">
        <div class="col-sm-12">
             <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label ">{{ __('Company name') }}</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control inputFieldDesign" name="invoice[general][company_name]" placeholder="{{ __('company name') }}" value="{{ $invoice?->general?->company_name }}" maxlength="50">
                </div>
            </div>
            <div class="form-group row">
                <label for="meta_title"
                    class="col-sm-4 text-left col-form-label">{{ __('How you want to view the PDF') }}</label>
                <div class="col-sm-6">
                    <div class="switch switch-bg d-inline m-r-10">
                        <select class="form-control select2-hide-search" name="invoice[general][pdf_view]">
                            <option value="new_tap" {{ $invoice?->general?->pdf_view == 'new_tap' ? 'selected' : ''}}>{{ __('Open the PDF in a new tab') }}</option>
                            <option value="same_tap"  {{ $invoice?->general?->pdf_view == 'same_tap' ? 'selected' : '' }}>{{ __('Open the PDF in same tab') }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label">{{ __('Page size') }}</label>
                <div class="col-sm-6">
                    <div class="switch switch-bg d-inline m-r-10">
                        <select class="form-control select2-hide-search" name="invoice[general][page_size]">
                            <option value="a4" {{ $invoice?->general?->page_size == 'a4' ? 'selected' : '' }}>A4</option>
                            <option value="a3" {{ $invoice?->general?->page_size == 'a3' ? 'selected' : '' }}>A3</option>
                            <option value="a2" {{ $invoice?->general?->page_size == 'a2' ? 'selected' : '' }}>A2</option>
                            <option value="a1" {{ $invoice?->general?->page_size == 'a1' ? 'selected' : '' }}>A1</option>
                            <option value="a0" {{ $invoice?->general?->page_size == 'a0' ? 'selected' : '' }}>A0</option>
                            <option value="legal" {{ $invoice?->general?->page_size == 'legal' ? 'selected' : '' }}>Legal</option>
                            <option value="letter" {{ $invoice?->general?->page_size == 'letter' ? 'selected' : '' }}>Letter</option>
                            <option value="half-letter" {{ $invoice?->general?->page_size == 'half-letter' ? 'selected' : '' }}>Half-Letter</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="meta_title" class="col-sm-4 text-left col-form-label">{{ __('Invoice type') }}</label>
                <div class="col-sm-6">
                    <div class="switch switch-bg d-inline">
                        <select class="form-control select2-hide-search" name="invoice[general][invoice_type]">
                            <option value="global" {{ $invoice?->general?->invoice_type == 'global' ? 'selected' : '' }}>{{ __('Global') }}</option>
                            <option value="vendor" {{ $invoice?->general?->invoice_type == 'vendor' ? 'selected' : '' }}>{{ __('Vendor') }}</option>
                        </select>
                    </div>
                    <div class="mt-2 pt-4" id="note_txt_1">
                        <div class="mt-2">
                            <span>{{ __('When \'global\' is selected, all PDFs should be the same. When \'vendor\' is selected, the PDF downloaded by the vendor should display the respective vendor\'s logo or name.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row preview-parent">
                <label for="meta_title" class="col-sm-4 text-left col-form-label ">{{ __('Upload Logo') }}</label>
                <div class="col-sm-6">
                    <div class="custom-file media-manager-img" data-val="single" data-returntype="ids"
                        id="image-status">
                        <input class="custom-file-input is-image form-control d-none"
                            name="invoice[general][logo]" value="{{ $invoice?->general?->logo }}">

                        <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                            for="validatedCustomFile">{{ __('Logo') }}</label>
                    </div>
                    <div id="note_txt_1">
                        <div class="mb-3">
                            <span>{{ __('Upload a logo which will be used across the invoice.') }}</span>
                        </div>
                    </div>
                    <div class="preview-image">

                        <div class="d-flex flex-wrap mt-2">
                            @if($invoice?->general?->logo)
                                <div class="position-relative border boder-1 p-1 mr-2 rounded mt-2 old-image">
                                    <div
                                        class="position-absolute rounded-circle text-center img-delete-icon"
                                        data-objectId="{{ $invoice?->general?->logo }}">
                                        <i class="fa fa-times"></i>
                                    </div>

                                    <img class="upl-img object-contain neg-transition-scale" class="p-1"
                                        src="{{ $logo }}">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
