<div class="btn-group mb-0">
    <button {{ $attributes->merge([
        'class' => 'btn btn-square btn-light f-w-600 btn-sm mb-0 ltr:me-1 rtl:ms-1',
        'type' => 'button',
        'data-bs-toggle' => 'dropdown',
        'aria-haspopup' => 'true',
        'aria-expanded' => 'true',
    ]) }}>
        <span class="{{ $iconClass ?? 'fas fa-angle-double-down' }}">&nbsp;</span>{{ $label ?? __('Export') }}
    </button>
    <div class="dropdown-menu" x-placement="bottom-start"
         style="position: absolute; transform: translate3d(0px, 43px, 0px); top: 0px; left: 0px; will-change: transform;">
        <a class="dropdown-item f-14" href="#" id="csv">{{ __('CSV') }}</a>
        <a class="dropdown-item f-14" href="#" id="pdf">{{ __('PDF') }}</a>
    </div>
</div>
