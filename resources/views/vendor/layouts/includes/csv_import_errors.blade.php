@extends('vendor.layouts.app')
@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5>{{ __('Your import found following issues') }}</h5>
                <br /><br />
                <p><b>{{ __('Total imported row') }} : {{ $totalRow }}</b></p>
                <p><b>{{ __('Total inserted row') }} : {{ $totalRow - count($errorMessages) }}</b></p>
            </div>
            <div class="card-block table-border-style">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="import-error-sl">{{ __('Column No') }}</th>
                                <th>{{ __('Column Data') }}</th>
                                <th>{{ __('Errors') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($errorMessages as $key => $value)
                                <tr>
                                    <td><strong>{{ $key + 1 }}</strong></td>
                                    <td>
                                        @foreach ($value['data'] as $k => $val)
                                            <p class="mb-m5"><strong>{{ $k }}</strong> : {{ $val }} </p>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($value['fails'] as $msg)
                                            <p class="text-danger mb-0">{{ $msg }} </p>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
