<div {{ $attributes->merge([
    'class' => 'card-body p-0',
]) }}>
    <div class="card-block px-2">
        <div class="col-sm-12 px-3">
            {{ $slot }}
        </div>
    </div>
</div>
