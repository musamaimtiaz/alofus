<a {{ $attributes->merge([
        'class' => 'btn btn-sm btn-danger mb-0 d-none ltr:me-1 rtl:ms-1',
        'href' => 'javascript:void(0)',
        'data-bs-toggle' => 'modal',
        'data-bs-target' => '#batchDelete',
    ]) }}
>
    <span class="{{ $iconClass ?? 'feather icon-trash' }} ltr:me-1 rtl:ms-1"></span>
    {{ $label ?? __('Batch Delete') }} (<span class="batch-delete-count">0</span>)
</a>
