<button {{ $attributes->merge([
    'class' => 'btn btn-square btn-light f-w-600 btn-sm mb-0 collapsed filterbtn ltr:me-1 rtl:ms-1',
    'type' => 'button',
    'data-bs-toggle' => 'collapse',
    'data-bs-target' => '#filterPanel',
    'aria-expanded' => 'true',
    'aria-controls' => 'filterPanel',
]) }}>
    <span class="{{ $iconClass ?? 'fas fa-filter ltr:me-1 rtl:ms-1' }}"></span>{{ $label ?? __('Filter') }}
</button>
