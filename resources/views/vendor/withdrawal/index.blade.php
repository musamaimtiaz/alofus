@extends('vendor.layouts.app')
@section('page_title', __('Withdrawal'))

@section('content')
    <!-- Main content -->
    <div class="list-container" id="vendor-withdrawal-container">

        <div class="card">
            <div class="card-header bb-none pb-0">
                <h5>{{ __('Withdrawals History') }}</h5>
                <x-backend.group-filters :groups="$groups" :column="'status'" />
                <div class="card-header-right my-2 mx-md-0 mx-sm-4">
                    <x-backend.button.anchor href="{{ route('vendorWithdrawal.setting') }}" :label="'Setting'" :iconClass="'fa fa-cog'" />
                    <x-backend.button.anchor href="{{ route('vendorWithdrawal.money') }}" :label="'Withdraw'" :iconClass="'far fa-credit-card'" />
                    <x-backend.button.export />
                    <x-backend.button.filter />
                </div>
            </div>

            <x-backend.datatable.filter-panel>
                <div class="col-md-12 px-3">
                    <x-backend.datatable.input-search />
                </div>
            </x-backend.datatable.filter-panel>

            <x-backend.datatable.table-wrapper>
                @include('vendor.layouts.includes.yajra-data-table')
            </x-backend.datatable.table-wrapper>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        'use strict';
        var pdf = "{{ in_array('App\Http\Controllers\Vendor\WithdrawalController@pdf', $prms) ? '1' : '0' }}";
        var csv = "{{ in_array('App\Http\Controllers\Vendor\WithdrawalController@csv', $prms) ? '1' : '0' }}";
    </script>
    <script src="{{ asset('public/dist/js/custom/permission.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/withdrawal.min.js') }}"></script>
@endsection
