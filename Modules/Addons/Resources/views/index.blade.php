<link rel="stylesheet" type="text/css" href="{{ asset('Modules/Addons/Resources/assets/css/addon.min.css') }}">

@php
    $addons = \Modules\Addons\Entities\Addon::all();
    $addons = array_filter($addons, function ($addon) {
        return !$addon->get('core');
    });

    $enabledAddons = array_filter($addons, function ($addon) {
        return $addon->isEnabled();
    });

    $disabledAddons = array_filter($addons, function ($addon) {
        return $addon->isDisabled();
    });

    $numberOfAddons = count($addons);
@endphp

@if (session('AddonMessage'))
    <div class="addon-alert addon-alert-{{ session('AddonStatus') == 'success' ? 'success' : 'danger' }}">
        <span class="addon-alert-closebtn">&times;</span>
        <strong>{{ session('AddonMessage') }}</strong>
    </div>
@endif

<div class="addons-section">
    <div class="addons-card">
        <h5>{{ __('Addons') }}</h5>
        <button id="addon-install-btn" class="install-button">{{ __('Upload Addon') }}</button>
    </div>

    <div class="{{ $numberOfAddons > 0 ? 'addon-form-hide' : 'addon-dblock' }} addon-form-flow">
        <form id="addons-form-container" action="{{ route('addon.upload') }}" method="post" class="addons-form"
            enctype="multipart/form-data">
            @csrf
            <div class="form-align">
                <div class="input-file-container upl-mod-con">
                    <span class="upl-text">{{ __('Upload Zip File') }}&nbsp;</span>
                    <label for="addon-module">
                        <div class="module-box">
                            <span class="custom-file-name-level">{{ __('Choose file') }}</span>
                            <span class="browse-module">{{ __('Browse') }}</span>
                        </div>
                    </label>
                    <input id="addon-module" type="file" name="attachment" accept=".zip,.rar,.7zip" required>
                    <div class="upload-file-note mt-2">
                        <span class="note-title">{{ __('Note') }}!</span>
                        <span class="note-text">{{ __('Upload your addon zip file.') }}</span>
                    </div>
                </div>

                <div class="input-file-container">
                    <div class="float-end py-3">
                        <button id="cancel-addform" class="cancel-style" type="button">{{ __('Cancel') }}</button>
                        <button class="submit-style" type="submit">{{ __('Upload Now') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div id="a-tab-container" class="addons-tab-container d-flex justify-content-between align-items-center">
        <div>
            <span id="ins-addon-tab" class="addons-tab addons-active">{{ __('All') }}
                ({{ $numberOfAddons }})</span>
            <span id="active-addon-tab" class="addons-tab">{{ __('Active') }} ({{ count($enabledAddons) }})</span>
            <span id="inactive-addon-tab" class="addons-tab">{{ __('Inactive') }}
                ({{ count($disabledAddons) }})</span>
            <a href="https://martvill.techvill.net/plugins" target="_blank" class="addons-tab ml-2">
                <i class="feather icon-external-link"></i>
                {{ __('Explore Available Addons') }}
                <div class="spinner-grow spinner-grow-sm text-warning" role="status">
                    <span class="sr-only">Loading...</span>
                    </div>
            </a>

        </div>
        <input class="search-box" type="text" placeholder="{{ __('Search addon') }}">
    </div>
    <div id="addons-ins-table-container" class="addons-table-container">
        @if ($numberOfAddons > 0)
            <table>
                <tbody>
                    @foreach ($addons as $addon)
                        @if ($addon->get('core'))
                            @continue
                        @endif
                        <tr data-status="{{ $addon->isEnabled() ? 1 : 0 }}">
                            <td>
                                <img class="addons-img object-contain neg-transition-scale"
                                    src="{{ addonThumbnail($addon->getName()) }}" alt="{{ $addon->getName() }}">
                            </td>
                            <td>
                                <span
                                    class="addons-name">{{ $addon->get('display_name', $addon->getName()) }}</span>&nbsp;
                                @if ($addon->get('type') == 'premium')
                                    <span class="badge badge-warning padding_3">{{ __('Premium') }}</span>
                                @endif
                                <br>
                                <span class="pt-2">
                                    <a href="{{ route('addon.switch-status', $addon->getAlias()) }}"
                                        class="addons-act">
                                        {!! $addon->isEnabled()
                                            ? "<span class='addons-anchor'>" . __('Deactivate') . '</span>'
                                            : "<span class='addons-anchor'>" . __('Activate') . '</span>' !!}
                                    </a>

                                    @if (!$addon->isEnabled())
                                        <span class="addon-border">|</span>
                                        <a href="javascript:void(0)" class="addon-modal-trigger text-danger"
                                            data-name="{{ $addon->getName() }}"
                                            data-url="{{ route('addon.removeAlert', $addon->getAlias()) }}">
                                            {{ __('Delete') }}
                                        </a>
                                    @endif

                                    @if ($addon->isEnabled() && moduleConfig($addon->getLowerName() . '.options'))
                                        @foreach (moduleConfig($addon->getLowerName() . '.options') as $option)
                                            @php
                                                $link = settingsModalLink($option);
                                                $modal = settingModalStatus($option);
                                            @endphp

                                            <span class="addon-border">|</span>
                                            <a href="{{ $modal ? 'javascript:void(0)' : $link }}"
                                                class="addons-anchor {{ $modal ? 'addon-modal-trigger' : '' }}"
                                                data-name="{{ $addon->getName() }}" data-url={{ $link }}
                                                target="{{ isset($option['target']) ? $option['target'] : '' }}">
                                                {{ isset($option['label']) ? __($option['label']) : '' }}
                                            </a>
                                        @endforeach
                                    @endif

                                </span>
                            </td>
                            <td>
                                @if ($addon->isEnabled())
                                    <span class="act">{{ __('Active') }}</span>
                                @else
                                    <span class="inact">{{ __('Inactive') }}</span>
                                @endif
                            </td>
                            <td>
                                @if ($addon->get('description'))
                                    <span class="addon-dblock add-des">{!! __($addon->get('description')) !!}</span>
                                @endif
                                <span class="text-dark">{{ __('version') }}: {{ $addon->get('version', 0) }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

<div class="addon-modal-window addon-modal-hidden">
    <div class="addon-modal-container">
        <div class="addon-modal-head">
            <div class="addon-modal-title"></div>
            <div class="addon-modal-close">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10"
                    fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M0.366117 0.366117C0.854272 -0.122039 1.64573 -0.122039 2.13388 0.366117L9.63388 7.86612C10.122 8.35427 10.122 9.14573 9.63388 9.63388C9.14573 10.122 8.35427 10.122 7.86612 9.63388L0.366117 2.13388C-0.122039 1.64573 -0.122039 0.854272 0.366117 0.366117Z"
                        fill="#898989" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M9.63388 0.366117C9.14573 -0.122039 8.35427 -0.122039 7.86612 0.366117L0.366117 7.86612C-0.122039 8.35427 -0.122039 9.14573 0.366117 9.63388C0.854272 10.122 1.64573 10.122 2.13388 9.63388L9.63388 2.13388C10.122 1.64573 10.122 0.854272 9.63388 0.366117Z"
                        fill="#898989" />
                </svg>
            </div>
        </div>
        <div class="modal-form-data">
            <div class="form"></div>
            <ul class="addon-form-loading addon-modal-dnone">
                <div id="addon-res-loader">
                    <svg id="loading-spinner" width="80" height="80" viewBox="0 0 80 80" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <circle id="loading-circle-large" cx="40" cy="40" r="36" stroke="#FCCA19"
                            stroke-width="8" />
                    </svg>
                </div>
            </ul>
        </div>

    </div>
</div>

<script src="{{ asset('Modules/Addons/Resources/assets/js/addons.min.js') }}"></script>
