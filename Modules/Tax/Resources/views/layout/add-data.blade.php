<table class="d-none table-hovered">
    <tr class="add-new-data">
        <td>
            <input type="hidden" name="id">
            <input type="hidden" name="tax_class_id">
            <input type="text" class="form-control" name="name">
        </td>
        <td>
            <input type="text" class="form-control geolocale-country" list="country-list" maxlength="30" name="country">
        </td>
        <td>
            <input type="text" class="form-control geolocale-state" list="state-list" maxlength="30" name="state">
        </td>
        <td>
            <input type="text" class="form-control" maxlength="30" name="city">
        </td>
        <td>
            <input type="text" class="form-control" maxlength="10" name="postcode">
        </td>
        <td>
            <input type="text" class="form-control positive-float-number" maxlength="16" name="tax_rate">
        </td>
        <td>
            <input type="number" class="form-control positive-int-number" maxlength="11" name="priority">
        </td>

        <th>
            <div>
                <div class="switch switch-bg m-r-10">
                    <input type="checkbox" name="compound" class="checkActivity" id="compound" value="0">
                    <label for="compound" class="cr"></label>
                </div>
            </div>
        </th>
        <th>
            <div>
                <div class="switch switch-bg m-r-10">
                    <input type="checkbox" name="shipping" class="checkActivity" id="shipping" value="0">
                    <label for="shipping" class="cr"></label>
                </div>
            </div>
        </th>
        <td>
            <span class="text-dark cursor_pointer delete-button action-btn d-flex justify-content-center" title="{{ __('Delete Tax Rate') }}">
                <i class="fa fa-trash"></i>
            </span>
        </td>
    </tr>
</table>
