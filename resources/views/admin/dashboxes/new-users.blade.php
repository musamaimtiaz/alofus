<a href="{{ route('users.index') }}" target="_blank">
    <div class="card mb-0">
        <div class="card-block">
            <div class="row d-flex align-items-center">
                <div class="col-auto">
                    <i class="feather icon-user-plus f-30 text-c-yellow rides-icon neg-transition-scale-svg "></i>
                </div>
                <div class="col text-left">
                    <h3 class="font-weight-500">{{ $newUsers }}
                        @include('admin.dashboxes.partials.compare', [
                            'change' => $newUsersCompare,
                        ])
                    </h3>
                    <span class="d-block text-uppercase font-weight-600 c-gray-5">{{ __("Users") }} <small class="font-weight-600 c-gray-5">({{ __('last :x days', ['x' => 30]) }})</small></span>
                </div>
            </div>
        </div>
    </div>
</a>
