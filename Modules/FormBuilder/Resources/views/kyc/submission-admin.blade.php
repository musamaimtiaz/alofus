@extends('formbuilder::layout')

@section('page_title', __('View KYC Submission'))

@section('content')
    <div class="col-md-12">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header d-md-flex justify-content-between align-items-center">
                        <h5><a href="{{ route('formbuilder::kyc.index') }}">{{ __('KYC Submission') }}</a></h5>
                        <div class="mt-2 mt-md-0">
                            <div class="btn-toolbar" role="toolbar">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('formbuilder::kyc.sub-edit', ['id' => $submission->id]) }}"
                                        class="btn btn-primary btn-sm" title="{{ __('Edit KYC Data') }}">
                                        <i class="feather icon-edit neg-transition-scale-svg  m-0"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0 word-break">
                        <ul class="list-group">
                            @foreach ($form_headers as $header)
                                <li class="list-group-item rounded-0 py-3">
                                    <strong>{!! ucfirst($header['label']) !!}: </strong>
                                    <span class="ltr:float-right rtl:float-left">
                                        {{ $submission->renderEntryContent($header['name'], $header['type']) }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Details') }}</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group">
                            <li class="list-group-item rounded-0 py-3">
                                <strong>{{ __('Form') }} : </strong>
                                <span
                                    class="ltr:float-right rtl:float-left">{{ $submission?->form?->name }}</span>
                            </li>
                            <li class="list-group-item rounded-0 py-3">
                                <strong>{{ __('Submitted By') }} : </strong>
                                <span
                                    class="ltr:float-right rtl:float-left">{{ $submission?->user?->name ?? 'Guest' }}</span>
                            </li>
                            <li class="list-group-item rounded-0 py-3">
                                <strong>{{ __('Updated On') }} : </strong>
                                <span
                                    class="ltr:float-right rtl:float-left">{{ $submission->format_updated_at }}</span>
                            </li>
                            <li class="list-group-item rounded-0 py-3">
                                <strong>{{ __('Submitted On') }} : </strong>
                                <span
                                    class="ltr:float-right rtl:float-left">{{ $submission->format_created_at }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
