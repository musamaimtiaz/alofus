<div class="card mb-3 filter-query-container" data-prefix="query[{{ $index }}]" data-next="{{ $index + 1 }}">
    <div class="card-header p-2" id="headingOne">
        <div class="mb-0 row">
            <div class="col-12 col-md-2 filter-type-container">
                <select name="query[{{ $index }}][type]" class="select2 filter-type">
                    <option disabled selected>{{ __('Query') }}</option>
                    <option {{ $query->type == 'where' ? 'selected' : '' }} value="where">{{ __('Where') }}</option>
                    <option {{ $query->type == 'orWhere' ? 'selected' : '' }} value="orWhere">{{ __('Or Where') }}
                    </option>
                    <option {{ $query->type == 'orderBy' ? 'selected' : '' }} value="orderBy">{{ __('Order By') }}
                    </option>
                </select>
            </div>
            <div class="col-12 col-md-4 filter-column-container">
                <select name="query[{{ $index }}][column]" class="select2 filter-column">
                    <option disabled selected>{{ __('Column') }}</option>
                    @if ($query->type)
                        @foreach ($queries->$type as $value => $column)
                            <option value="{{ $value }}" {{ $query->column == $value ? 'selected' : '' }}>
                                {{ __($column['name']) }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-2 col-12 filter-{{ $type == 'query' ? 'operation' : 'order' }}-container">
                @if ($query->order)
                    <select name="query[{{ $index }}][order]" class="select2 filter-order">
                        <option {{ $query->order == 'asc' ? 'selected' : '' }} value="asc">{{ __('ASC') }}
                        </option>
                        <option {{ $query->order == 'desc' ? 'selected' : '' }} value="desc">{{ __('DESC') }}
                        </option>
                    </select>
                @elseif ($query->operation && $query->column)
                    @php
                        $operations = $queryArray->operations;
                    @endphp
                    <select name="query[{{ $index }}][operation]" class="select2 filter-operation">
                        <option value="" disabled selected>{{ __('Operation') }}</option>
                        @foreach ($operations as $op)
                            <option {{ $op['value'] == $query->operation ? 'selected' : '' }}
                                value="{{ $op['value'] }}">{{ $op['name'] }}</option>
                        @endforeach
                        <option value=""></option>
                    </select>
                @endif
            </div>
            @if ($type == 'query')
                <div class="col-md-4 col-12 filter-value-container">
                    @if ($query->operation)
                        @php
                            $inputField = optional($queryArray->operations[$query->operation])->input;
                        @endphp
                        @if ($inputField->type == 'select')
                            <select
                                name="query[{{ $index }}][value]{{ $inputField->multiple == 'multiple' ? '[]' : '' }}"
                                class="{{ $inputField->class }} filter-value {{ $inputField->ajax == true ? 'has-ajax-query' : 'select2' }}"
                                {{ $inputField->multiple == 'multiple' ? 'multiple="multiple"' : '' }}>
                                @if ($inputField->multiple == 'multiple')
                                    @php
                                        if (!is_array($query->value)) {
                                            $query->value = [$query->value];
                                        }
                                    @endphp
                                    @if ($inputField->ajax == true)
                                        @foreach ($homeService->getFilterableData($query->column, $query->value) as $item)
                                            <option selected value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    @endif
                                @elseif (isset($inputField->options))
                                    @foreach ($inputField->options as $val => $name)
                                        <option {{ $query->value == $val ? 'selected' : '' }}
                                            value="{{ $val }}">
                                            {{ $name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        @elseif ($inputField->type == 'date')
                            <input type="text"
                                class="{{ $inputField->class }} single-date-picker form-control filter-value">
                        @endif
                    @endif
                </div>
            @elseif ($type == 'order')
                <div class="col-md-2 col-12 filter-order-container">
                    @if ($query->filter)
                        <select name="query[{{ $index }}][order]" class="select2 filter-operation">
                            <option {{ $query->filter == 'asc' ? 'selected' : '' }}>{{ __('ASC') }}</option>
                            <option {{ $query->filter == 'desc' ? 'selected' : '' }}>{{ __('DESC') }}</option>
                        </select>
                    @endif
                </div>
            @endif

            <span class="b-icon">
                <span class="accordion-action-group">
                    @if ($index == $total - 1)
                        <span class="accordion-row-action add-row-btn __query __private"
                            data-index="{{ $index + 1 }}"><i class="feather icon-plus"></i></span>
                    @endif
                    @if ($total > 1)
                        <span class="accordion-row-action remove-row-btn __query __private"
                            data-index="{{ $index + 1 }}"><i class="feather icon-minus"></i></span>
                    @endif
                </span>
            </span>
        </div>
    </div>
</div>
