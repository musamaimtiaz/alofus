@if ($errors->all())
    <div class="payment-alert bg-warning my-2 p-2">
        <p class="p-0 m-0">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </p>
        <span id="payment-alert-icon"><i class="fa fa-times"></i></span>
    </div>
@endif
