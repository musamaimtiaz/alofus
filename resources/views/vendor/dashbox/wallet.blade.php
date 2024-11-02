<a href="{{ route('vendorTransaction.index') }}" target="_blank">
    <div class="card mb-0">
        <div class="card-block">
            <div class="row d-flex align-items-center">
                <div class="col-auto">
                    <span class="wallet-symbol f-30 text-c-yellow neg-transition-scale-svg ">{{ $wallet->currency->symbol }}</span>
                </div>
                <div class="col text-left">
                    <h3 class="font-weight-500">
                        {{ $wallet->currency->name }}
                    </h3>
                    <span class="d-block text-uppercase font-weight-600 c-gray-5">
                        {{ formatCurrencyAmount($wallet->balance) }}
                    </span>
                </div>

            </div>
        </div>
    </div>
</a>
