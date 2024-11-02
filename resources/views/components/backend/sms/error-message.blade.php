@if (session('errorMgs'))
    <div class="alert alert-warning fade in alert-dismissable">
        <strong>{{ __('Warning') }}!</strong> {{ session('errorMgs') }}. <a class="close" href="#"
            data-bs-dismiss="alert" aria-label="close" title="close">×</a>
    </div>
@endif
