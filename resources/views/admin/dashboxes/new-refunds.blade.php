<a href="{{ route('refund.index') }}" target="_blank">
    <div class="card mb-0">
        <div class="card-block">
            <div class="row d-flex align-items-center">
                <div class="col-auto">
                    <i class="feather icon-repeat f-30 text-c-yellow rides-icon neg-transition-scale-svg "></i>
                </div>
                <div class="col text-left">
                    <h3 class="font-weight-500">{{ $newRefunds }}
                        @include('admin.dashboxes.partials.compare', [
                            'change' => $newRefundsCompare,
                        ])</h3>
                    <span class="d-block text-uppercase font-weight-600 c-gray-5">{{ __('Refund Requests') }}</span>
                </div>
            </div>
        </div>
    </div>
</a>
