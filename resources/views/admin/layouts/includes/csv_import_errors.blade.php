@extends('admin.layouts.app')
@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5>{{ __('Your import found following issues.') }}</h5>
                <br /><br />
                <p><b>{{ __('Total rows') }} : {{ $totalRow }}</b></p>
                <p><b>{{ __('Inserted rows') }} : {{ $totalRow - count($errorMessages) }}</b></p>
                <p><b>{{ __('Errors found') }} : {{ count($errorMessages) }}</b></p>
            </div>
            <div class="card-block table-border-style">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="import-error-sl">SL</th>
                                <th>{{ __('Data') }}</th>
                                <th>{{ __('Errors') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($errorMessages as $key => $value)
                                <tr>
                                    <td><strong>{{ $key + 1 }}</strong></td>
                                    <td width="500" class="d-inline-block overflow-x-scroll">
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
