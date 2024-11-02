<div class="card chart-order-status mb-0 h-100">
    <div class="card-header d-flex justify-content-between">
        <h5 class="font-weight-600 c-gray-5">{{ __('ORDER STATUS THIS MONTH') }}</h5>
    </div>
    <div class="card-block h-360">
        @if (max($orderStatus['count']))
            <canvas id="chart-donut-1" class="w-100 h-300px"></canvas>
        @else
            <h6 class="text-secondary">{{ __('No data found.') }}</h6>
        @endif
    </div>
</div>
<script>
    let chartOrderStatus = @json($orderStatus);
</script>
