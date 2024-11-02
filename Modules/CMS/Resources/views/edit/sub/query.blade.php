@php
    $queries = \App\Constants\Product::queryCollection();
@endphp
<div class="form-group row form-parent queryOptions {{ $component && $component->showcase_type == 'queryProducts' ? 'd-flex' : 'd-none' }}">
    <div class="col-12">
        <hr>
    </div>
    <label class="col-md-3 control-label">
        <dt>{{ __('Product Filter') }}</dt>
    </label>
    <div class="col-md-8">
        <div class="accordion {{ $accordId = uniqid('accord_') }}">
            @forelse ($component->query ?? [] as $query)
                @php
                    $query = miniCollection($query);
                    $inputType = $query->type == 'orderBy' ? 'order' : 'query';
                @endphp
                @include('cms::edit.sub.queryinput', [
                    'index' => $loop->index,
                    'queryArray' => $queries->$inputType[$query->column] ?? miniCollection([]),
                    'type' => $inputType,
                    'query' => $query,
                    'total' => count($component->query),
                ])

            @empty
                @include('cms::edit.sub.queryinput', [
                    'index' => 0,
                    'queryArray' => $queries->query ?? miniCollection([]),
                    'type' => 'query',
                    'query' => miniCollection([]),
                    'total' => 1,
                ])
            @endforelse
        </div>
    </div>
</div>
