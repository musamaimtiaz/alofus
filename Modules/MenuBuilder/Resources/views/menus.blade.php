<li id="menu-item-{{ $m->id }}"
    class="menu-item display-list-item menu-item-depth-{{ $m->depth }} menu-item-page menu-item-edit-inactive pending list-item" id="{{ $m->id }}" data-val="{{ $m->depth }}">
    <dl class="menu-item-bar" id="{{ $m->id }}">
        <dt class="menu-item-handle">
            <span class="item-title"><i class="feather feather icon-move"></i> <span class="menu-item-title"> <span
                        id="menutitletemp_{{ $m->id }}">{{ $m->label }}</span>
                    <span class="color-transparent d-none">|{{ $m->id }}|</span>
                </span> <span class="is-submenu"
                    style="@if($m->depth==0)display: none;@endif">{{ __('Subelement') }}
                </span>
            </span>
            <span class="item-controls"> <span
                    class="item-type">{{ __('Link') }}</span> <span
                    class="item-order hide-if-js">
                    <a href="{{ $currentUrl }}?action=move-up-menu-item&menu-item={{ $m->id }}&_wpnonce=8b3eb7ac44"
                        class="item-move-up"><abbr
                            title="Move Up">↑</abbr>
                    </a>
                    | <a href="{{ $currentUrl }}?action=move-down-menu-item&menu-item={{ $m->id }}&_wpnonce=8b3eb7ac44"
                        class="item-move-down"><abbr
                            title="Move Down">↓</abbr>
                        </a>
                </span>
                <a class="item-edit"
                    id="edit-{{ $m->id }}"
                    href="{{ $currentUrl }}?edit-menu-item={{ $m->id }}#menu-item-settings-{{ $m->id }}">
                </a>
            </span>
        </dt>
    </dl>
    <div class="menu-item-settings"
        id="menu-item-settings-{{ $m->id }}">
        <input type="hidden" class="edit-menu-item-id"
            name="menuid_{{ $m->id }}"
            value="{{ $m->id }}" />
        <input type="hidden" class="edit-menu-depth"
            id="depthlabelmenu_{{ $m->id }}"
            name="depth_{{ $m->id }}"
            value="{{ $m->depth }}" />
        <p class="description description-thin">
            <label
                for="edit-menu-item-title-{{ $m->id }}">
                {{ __('Label') }}
                <br>
                <input type="text"
                    id="idlabelmenu_{{ $m->id }}"
                    class="widefat edit-menu-item-title custom-input-field"
                    name="idlabelmenu_{{ $m->id }}"
                    value="{{ $m->label }}">
            </label>
        </p>
        <p class="field-css-classes description description-thin">
            <label
                for="edit-menu-item-classes-{{ $m->id }}">
                {{ __('Class CSS (optional)') }}
                <br>
                <input type="text"
                    id="clases_menu_{{ $m->id }}"
                    class="widefat edit-menu-item-classes custom-input-field"
                    name="clases_menu_{{ $m->id }}"
                    value="{{ $m->class }}">
            </label>
        </p>

        <p class="field-css-classes description description-thin">
            <label for="edit-menu-item-icon-{{ $m->id }}">
                {{ __('Icon (optional)') }}
                <br>
                <input type="text"
                    id="clases_icon_{{ $m->id }}"
                    class="form-control icp icp-auto iconpicker-component iconpicker-input edit-menu-item-icon custom-input-field"
                    name="icon_menu_{{ $m->id }}" id="{{ $m->id }}"
                    value="{{ $m->icon }}">
            </label>
        </p>
        <p class="field-css-url description description-wide">
            <label for="edit-menu-item-url-{{ $m->id }}">
               {{ __('URL') }}
                <br>
                <input type="text"
                    id="url_menu_{{ $m->id }}"
                    class="widefat edit-menu-item-url custom-input-field"
                    id="url_menu_{{ $m->id }}"
                    value="{{ $m->link }}">
            </label>
        </p>
        <p class="field-css-classes description description-thin">
            <label
                for="edit-menu-item-attribute-{{ $m->id }}">
                {{ __('Permission (optional)') }}
                <?php
                $jsonDecode = isset($m->params) && !empty($m->params) ? json_decode(json_encode($m->params),true) : '';
                $perm = '';
                $fullArray = '';
               if ($jsonDecode) {
                   $fullArray = json_encode($m->params);
                   $perm = $jsonDecode['permission'];
               }
                ?>
                <br>
                <input type="text"
                    id="attribute_menu_{{ $m->id }}"
                    class="widefat custom-input-field"
                    name="attribute_menu_{{ $m->id }}"
                    value="{{ $perm }}" readonly>
                <input type="hidden"
                    id="attribute_menu_{{ $m->id }}"
                    class="widefat code edit-menu-item-attribute"
                    name="attribute_menu_{{ $m->id }}"
                    value="{{ $fullArray }}" readonly>
            </label>
        </p>
        <div
            class="menu-item-actions description-wide submitbox">
            <a onclick="deleteitem({{ $m->id }})"
                class="item-delete submitdelete text-danger deletion delete-{{ $m->id }}"
                id="{{ $m->id }}" href="#">{{ __('Delete') }}
            </a>
        </div>
    </div>
    <ul class="menu-item-transport"></ul>
</li>
