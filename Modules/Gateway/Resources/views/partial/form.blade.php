<form action="{{ route(moduleConfig($addon->getAlias() . '.store_route')) }}" method="post">
    @csrf
    <div class="addon-modal-body">
        @php
            $fields = moduleConfig($addon->getAlias() . '.fields');
        @endphp
        @forelse ($fields as $name => $field)
            @php
                $value = old($name, getValueForForm($module, $name));
            @endphp
            <div class="addon-modal-form-row">
                <label for="email" class="addon-modal-label">{{ __($field['label']) }}
                    @if (isset($field['required']) && $field['required'])
                        <span class="addon-modal-danger">*</span>
                    @endif
                </label>
                <div class="addon-modal-field">
                    @if ($field['type'] == 'text')
                        <input type="text"
                            class="addon-modal-input {{ isset($field['class']) ? $field['class'] : '' }}"
                            placeholder="{{ $field['placeholder'] ?? $field['label'] }}" name="{{ $name }}"
                            {{ isset($field['required']) && $field['type'] ? 'required' : '' }}
                            value="{{ config('martvill.is_demo') ? techEncrypt($value) : $value ?? '' }}">
                    @elseif ($field['type'] == 'textarea')
                        <textarea type="text" class="addon-modal-input {{ isset($field['class']) ? $field['class'] : '' }}"
                            placeholder="{{ $field['placeholder'] ?? $field['label'] }}" name="{{ $name }}"
                            {{ isset($field['required']) && $field['type'] ? 'required' : '' }}>{{ $value ?? '' }}</textarea>
                    @elseif ($field['type'] == 'select')
                        <select class="addon-modal-input {{ isset($field['class']) ? $field['class'] : '' }}"
                            name="{{ $name }}"
                            {{ isset($field['required']) && $field['type'] ? 'required' : '' }}>
                            @forelse ($field['options'] as $option => $value)
                                <option
                                    {{ old($option, isset($module) ? $module->$name : '') == $value ? 'selected' : '' }}
                                    value="{{ $value }}">
                                    {{ $option }}
                                </option>
                            @empty
                            @endforelse
                        </select>
                    @endif
                    @if (isset($field['note']))
                        <span class="mt-2">
                            <span class="badge badge-info mr-2 p-1">{{ __('Note') }}</span>{{ $field['note'] }}
                        </span>
                    @endif
                </div>
            </div>
        @empty
        @endforelse
    </div>
    <div class="addon-modal-foot">
        <button class="addon-modal-submit">{{ __('Submit') }}</button>
    </div>
</form>
