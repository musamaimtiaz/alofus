<a {{ $attributes->merge([
        'class' => 'btn btn-square btn-light f-w-600 btn-sm mb-0 ltr:me-1 rtl:ms-1',
        'href' => '#',
    ]) }}
>
    <span class="{{ $iconClass ?? 'icon' }}"> &nbsp;</span>{{ $label ?? __('achore') }}
</a>