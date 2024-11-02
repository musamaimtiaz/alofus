<a {{ $attributes->merge([
        'class' => 'btn btn-sm btn-mv-primary mb-0 ltr:me-1 rtl:ms-1',
        'href' => '#',
    ]) }}
>
    <span class="{{ $iconClass ?? 'fa fa-plus' }}"> &nbsp;</span>{{ $label ?? __('Add New') }}
</a>
