<a href="{{ route('withdrawal.index', ['status' => 'Pending']) }}" target="_blank">
    <div class="card mb-0">
        <div class="card-block">
            <div class="row d-flex align-items-center">
                <div class="col-auto">
                    <i class="feather icon-share f-30 text-c-yellow neg-transition-scale-svg "></i>
                </div>
                <div class="col text-left">
                    <h3 class="font-weight-500">{{ $withdrawalRequestCount }}</h3>
                    <span class="d-block text-uppercase font-weight-600 c-gray-5">
                        {{ __("Withdrawal Request") }}
                        <small class="font-weight-600 c-gray-5">({{ __('Pending') }})</small>
                    </span>
                </div>
            </div>
        </div>
    </div>
</a>
