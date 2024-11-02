<div class="attribute-dlt ui-sortable-handle" data-serial="{{ $idx }}">
    <div class="d-flex justify-content-between align-items-center border-t h-40p mx-25n px-32p bg-F5 col-attr collapse-header"
        data-bs-toggle="collapse" href="#{{ $unid = 'col_' . uniqid() }}">
        <p class="label-title m-0 ml-16n-res font-weight-600 attribute-box-title">{{ __('Custom Attribute') }}</p>
        <div class="d-flex align-items-center">
            <svg class="cursor-move mt-0" width="16" height="11" viewBox="0 0 16 11" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <rect width="16" height="1" fill="#898989" />
                <rect y="5" width="16" height="1" fill="#898989" />
                <rect y="10" width="16" height="1" fill="#898989" />
            </svg>
            <span class="toggle-btn ml-10p d-flex mt-0 h-20 w-20 align-items-center justify-content-center active"
                data-bs-toggle="collapse" href="#{{ $unid }}">
                <svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M4.18767 5.90789L7.81732 1.34361C8.24162 0.810056 7.87956 -1.43628e-09 7.21678 -9.33983e-09L0.783223 -8.60592e-08C0.120445 -9.39628e-08 -0.241618 0.810055 0.182683 1.34361L3.81233 5.90789C3.91 6.0307 4.09 6.0307 4.18767 5.90789Z"
                        fill="#2C2C2C" />
                </svg>
            </span>
            <form method="post" action="#" accept-charset="UTF-8"
                id="delete-attribute-{{ $uniq = 'attr' . uniqid() }}" class="delete_attribute">
                {{ method_field('DELETE') }}
                @csrf
                <span class="f-11 red-9E ml-10p cursor-pointer" title="{{ __('Delete') }}"
                    class="btn btn-xs btn-danger" type="button" data-id="{{ $uniq }}" data-delete="attribute"
                    data-label="Delete" data-bs-toggle="modal" data-bs-target="#confirmDelete"
                    data-title="{{ __('Delete :x', ['x' => __('Attribute')]) }}"
                    data-message="{{ __('Are you sure to delete this attribute?') }}">
                    {{ __('Delete') }}
                </span>
            </form>
        </div>
    </div>
    <div class="collapse show" id="{{ $unid }}">
        <div class="row m-0 px-7 pb-30p">
            <div class="col-md-3 p-0">
                <div class="form-group mb-2 mr-2">
                    <label class="control-label gray-89">{{ __('Name') }}:</label>
                    <input type="text" class="form-control inputFieldDesign attribute-name"
                        name="attribute_names[{{ $idx }}]" value="Custom Attribute">
                </div>
                <input type="hidden" name="attribute_position[{{ $idx }}]" value="{{ $idx }}">
                <div class="checkbox checkbox-primary d-inline p-0">
                    <input type="hidden" name="attribute_visibilities[{{ $idx }}]" value="0">
                    <input type="checkbox" id="{{ $cid = uniqid() }}" value="1"
                        name="attribute_visibilities[{{ $idx }}]">
                    <label for="{{ $cid }}" class="crs visi-title f-12 mb-0"> {{ __('Visible on the product page') }}
                    </label>
                </div>
                <div class="conditional-dom not-simple-dom not-grouped-dom not-external-dom">
                    <div class="checkbox checkbox-primary d-inline p-0">
                        <input type="hidden" name="attribute_variations[{{ $idx }}]" value="0">
                        <input type="checkbox" id="{{ $cid = uniqid() }}" value="1"
                            name="attribute_variations[{{ $idx }}]">
                        <label for="{{ $cid }}" class="crs visi-title f-12 mb-0"> {{ __('Used for variations') }}
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-7 p-0-res attr">
                <label class="sp-title control-label text-left gray-89 mt-10-res">{{ __('Values') }}:</label>
                <textarea name="attribute_values[{{ $idx }}]" class="form-control h-94p" rows="3"
                    placeholder="{{ __('List of values separated by |') }}"></textarea>
            </div>
        </div>
    </div>
</div>
