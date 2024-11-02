<div>
    <p class="dashboard-setting" type="button" data-bs-toggle="collapse" data-bs-target="#dashboardSetting" aria-expanded="false" aria-controls="dashboardSetting">
        <i class="feather icon-settings me-1"></i> <span>{{ __('Dashboard Option') }}</span>
    </p>
</div>
<div class="collapse" id="dashboardSetting">
    <div class="card card-body">
        <div class="d-flex justify-content-between">
            <div class="d-flex text-dark">
                <i class="feather icon-help-circle me-1 f-20 mt-2p"></i>
                <p class="f-16 me-2">{{ __('Widget') }}</p>
            </div>
            <a class="mt-1 f-12 text-primary" href="{{ $route }}">{{ __('Reset Dashboard') }}</a>
        </div>
        <div>
            <div class="row">
                @foreach ($widget as $key => $value)
                    @continue(isset($value['visibility']) ? !$value['visibility'] : false)
                    <div class="form-group col-4">
                        <div class="checkbox checkbox-warning d-inline">
                            <input class="dashboard-option-checkbox" type="checkbox" id="{{ $key }}" {{isset($value['visibility']) && !$value['visibility'] ? '' : 'checked' }}>
                            <label for="{{ $key }}" class="cr">{{ $value['label'] ?? $key }}</label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
