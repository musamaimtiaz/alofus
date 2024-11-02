<div class="noti-alert pad no-print warningMessage mt-2 px-2">
    <div class="alert warning-message abc">
        <strong id="warning-msg" class="msg"></strong>
    </div>
</div>
<div class="row px-4 mt-14">
    <div class="col-sm-12 p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-main">
                <thead>
                    <tr>
                        <th scope="col">{{ __('Name') }}</th>
                        <th scope="col">{{ __('Slug') }}</th>
                        <th scope="col">{{ __('Description') }}</th>
                        <th width="120" scope="col">{{ __('Product Count') }}</th>
                        <th width="5" scope="col">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($shippingClasses as $class)
                    <tr>
                        <td>
                            <input type="text" class="form-control" maxlength="120" name="name" value="{{ $class->name }}">
                        </td>
                        <td>
                            <input type="text" class="form-control" maxlength="120" name="slug" value="{{ $class->slug }}">
                        </td>
                        <td>
                            <input type="text" class="form-control" maxlength="1000" name="description" value="{{ $class->description }}">
                        </td>
                        <td class="vertical-align-middle text-center">
                            0
                        </td>

                        <td>
                            <span class="text-dark cursor_pointer delete-button action-btn d-flex justify-content-center" title="{{ __('Delete Tax Rate') }}">
                                <i class="fa fa-trash"></i>
                            </span>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="5">{{ __('No shipping class found.') }}</td>
                        </tr>
                    @endforelse
                    <tr>
                        <td class="d-none">
                            <input type="hidden" name="name" value="No shipping class cost">
                            <input type="hidden" name="slug" value="no-class">
                            <input type="hidden" name="description">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="10" class="pt-3">
                            <button type="button" data-id="1" class="btn custom-btn-submit add-new-class add-btn">{{ __('Add New') }}</button>
                            <button type="submit" data-id="1" class="btn custom-btn-submit save-class">{{ __('Save') }}</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
