<div class="tab-pane fade" id="v-pills-layout" role="tabpanel" aria-labelledby="v-pills-layout-tab">
    <div class="row">
        <div class="col-sm-12 ltr:pe-0 rtl:ps-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-main">
                    <thead class="text-dark border-top-gray bg-light-gray">
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th width="250">{{ __('Primary Color') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($layouts as $data)
                            <tr>
                                <td>
                                    {{ ucFirst(str_replace('_', ' ', $data)) }}
                                    {{-- This empty from will be remove during render --}}
                                    <form></form>
                                </td>
                                <td>
                                    @php
                                        $primaryColor = $themeOption->where('name', $data . '_template_primary_color');
                                        $color = '#FCCA19';
                                        if ($primaryColor->count()) {
                                            $color = $primaryColor->first()->value;
                                        }
                                    @endphp
                                    <div>
                                        <input type="text"
                                            class="form-control demo layout-primary-color inputFieldDesign"
                                            data-control="hue" name="{{ $data }}_template_primary_color"
                                            value="{{ $color }}">
                                    </div>
                                </td>
                                <td width="300" class="flex justify-content-center">
                                    <div class="header-btns-lg">
                                        @if ($data != 'default')
                                            <span class="header-btn btn-primary font-bold" id="layout-edit"
                                                data-bs-toggle="modal" data-bs-target="#edit-layout"
                                                data-layout="{{ ucFirst(str_replace('_', ' ', $data)) }}">
                                                <i
                                                    class="feather icon-edit neg-transition-scale-svg  ltr:me-2 rtl:ms-2"></i>{{ __('Edit') }}
                                            </span>
                                            <form method="post"
                                                action="{{ route('theme.layout.delete', ['layout' => $data]) }}"
                                                id="delete-layout-{{ $data }}" accept-charset="UTF-8"
                                                class="display_inline">
                                                @csrf
                                                <span class="header-btn delete-button" data-bs-toggle="modal"
                                                    data-label="Delete" data-delete="layout"
                                                    data-bs-target="#confirmDelete" data-id="{{ $data }}"
                                                    title="{{ __('Delete Layout') }}"
                                                    data-title="{{ __('Delete :x', ['x' => __('Layout')]) }}"
                                                    data-message="{{ __('Are you sure to delete this?') }}">
                                                    <i
                                                        class="feather icon-trash-2 ltr:me-2 rtl:ms-2"></i>{{ __('Delete') }}
                                                </span>
                                            </form>
                                        @endif
                                        @if ($data != $layout)
                                            <span class="header-btn folding font-bold btn-primary" id="layout-setting"
                                                data-val="{{ $data }}">
                                                <i
                                                    class="feather icon-settings ltr:me-2 rtl:ms-2"></i>{{ __('Setting') }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="10" class="pt-3">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#add-layout"
                                    class="btn custom-btn-submit">{{ __('Add New Layout') }}</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
