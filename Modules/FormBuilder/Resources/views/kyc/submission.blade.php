@extends('formbuilder::vendor-layout')

@section('page_title', __('Submission Details'))

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-md-flex justify-content-between align-items-center">
                    <h5>{{ __('KYC Submission') }}</h5>
                    <div class="mt-2 mt-md-0">
                        <div class="btn-toolbar" role="toolbar">
                            <div class="btn-group" role="group">
                                @if (isset($form) && $form->allows_edit == 1)
                                    <a href="{{ route('kyc.user.show', ['id' => $submission->id, 'edit' => true]) }}"
                                        class="btn btn-primary btn-sm" title="{{ __('Edit KYC Data') }}">
                                        <i class="feather icon-edit neg-transition-scale-svg  m-0"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-2 py-0 word-break">
                    <ul class="list-group list-group-flush">
                        @foreach ($form_headers as $header)
                            <li class="list-group-item rounded-0 py-3">
                                <strong>{!! ucwords($header['label']) !!}: </strong>
                                <span class="ltr:float-right rtl:float-left">
                                    {{ $submission->renderEntryContent($header['name'], $header['type']) }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Details') }}</h5>
                </div>
                <div class="card-body px-2 py-0 text-break">
                    <ul class="list-group list-group-flush">
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
@endsection
