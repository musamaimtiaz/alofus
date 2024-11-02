<div class="d-block mt-1">
    @foreach ($groups as $key => $value)
        <span
            class="@if (!empty($column)) group-filter @endif @if ($loop->first) active @endif"
            data-filter-key="{{ $column }}" data-filter-value="{{ $key }}">
            {{ ucfirst(strtolower($key)) }} <span class="text-muted">({{ $value }})</span>
        </span>
        @if (!$loop->last)
            |
        @endif
    @endforeach
</div>
