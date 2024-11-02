<div {{ $attributes->merge([
        'class' => 'collapse p-0',
        'id' => 'filterPanel',
    ]) }}
>
    <div class="row mx-2 my-2">
        {{ $slot }}
    </div>
</div>
