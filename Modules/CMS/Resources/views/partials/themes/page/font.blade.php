<div class="tab-pane fade" id="v-pills-font" role="tabpanel" aria-labelledby="v-pills-font-tab">
    <div class="row">
        <div class="col-sm-12 pr-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-main">
                    <thead class="text-dark border-top-gray bg-light-gray">
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th width="350">{{ __('Font Family') }}</th>
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
                                        $fonts = $themeOption->where('name', $data . '_template_font_family');
                                        $font = 'DM Sans, sans-serif';
                                        if ($fonts->count()) {
                                            $font = $fonts->first()->value;
                                        }
                                    @endphp

                                    <div class="form-group">
                                        <select name="{{ $data }}_template_font_family" id="" class="select2-hide-search">
                                            @foreach ($fontFamilies as $fontFamily)
                                                <option @selected($font == $fontFamily) value="{{ $fontFamily }}">{{ $fontFamily }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

