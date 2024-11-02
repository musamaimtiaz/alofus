<li class="ui-state-default selector-template" data-id="tempid">
    <div class="component-header">
        <i class="feather feather icon-move"></i>
        <div class="header-text">
            <h5 class="header-title">
                {{ __('Select block') }}
            </h5>
        </div>
        <div class="header-btns">
            <span class="header-btn delete-button" data-bs-toggle="modal" data-bs-target="#confirmDelete"
                data-component="{{ __('New section') }}" data-component-id="0">
                <i class="feather icon-trash-2"></i>
            </span>
            <span class="header-btn folding btn-primary">
                <i class="feather icon-chevron-up"></i>
            </span>
        </div>
    </div>
    <div class="card dd-content">
        <div class="card-body">
            <form action="{{ route('builder.form', ['file' => '__file']) }}" method="post" id="layout_selector"
                class="form-horizontal silent-form">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-3 control-label" for="category" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="{{ __('Type of the section you want to add.') }}">{{ __('Section Type') }}</label>
                    <div class="col-sm-8">
                        <select class="form-control select3" name="type" id="l_category"
                            data-placeholder="{{ __('Select block type') }}">
                            @foreach ($layouts as $layout)
                                <option value="{{ slugMe($layout->name) . '-' . $layout->id }}">{{ $layout->name }}
                                </option>
                            @endforeach
                        </select>
                        <input id="l_layout" type="hidden" name="file">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label" for="category" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="{{ __('Design of the section.') }}">{{ __('Section BLock') }}</label>
                    <div class="col-sm-8">
                        @foreach ($layouts as $key => $type)
                            <div class="row layoutBlocks {{ $key != 0 ? 'd-none' : '' }}" id="{{ slugMe($type->name) . '-' . $type->id }}"
                                >
                                @foreach ($type->layouts as $item)
                                    <div class="col-6 col-md-4">
                                        <div class="card mb-3 selectable selectedBlock" data-val="{{ $item->file }}">
                                            <img class="card-img-top" src="{{ getBlockThumbnail($item->image) }}"
                                                alt="Card image cap">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $item->name }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group d-flex">
                    <button class="btn btn-primary custom-btn-small ltr:float-right rtl:float-left"
                        data-url="{{ route('builder.form', ['file' => 'layout_1']) }}" data-layout="0" type="submit"
                        id="layout_select">{{ __('Select') }}
                        <div class="spinner-border border1px loading-spinner spinner1rem d-none" role="status">
                            <span class="sr-only">{{ __("Loading") }}...</span>
                        </div>
                    </button>
                    <label for="btn_save" class="col-sm-0 ltr:ms-3 rtl:me-3 control-label message"></label>
                </div>
            </form>
        </div>
    </div>
</li>
