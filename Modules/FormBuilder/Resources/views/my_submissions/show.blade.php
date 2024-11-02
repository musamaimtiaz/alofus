@extends('formbuilder::layout')

@section('page_title', __('View Submission'))

@section('content')
    <div class="col-sm-8">
        <div class="card">
            <div class="card-header d-md-flex justify-content-between align-items-center">
                <h5>
                    {{ __('Form') }}:
                    <strong>{{ $submission?->form?->name }}</strong>
                </h5>
                <div class="d-md-flex justify-content-end align-items-center">
                    <div class="btn-toolbar "
                        role="toolbar">
                        <div class="btn-group" role="group">
                            <a href="{{ route('formbuilder::entry.index') }}"
                                class="btn btn-primary btn-sm ltr:me-2 rtl:ms-2"
                                title="{{ __('Back To My Submissions') }}">
                                <i class="feather icon-arrow-left m-0"></i>
                            </a>
                            @if ($submission && $submission->form->allowsEdit())
                                <a href="{{ route('formbuilder::entry.edit', $submission) }}" class="btn btn-primary btn-sm"
                                    title="{{ __('Edit this submission') }}">
                                    <i class="feather icon-edit neg-transition-scale-svg  m-0"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="card-block pt-2 py-0 px-2">
                    <div class="col-sm-12">
                        <ul class="list-group list-group-flush">
                            @foreach ($form_headers as $header)
                                <li class="list-group-item rounded-0 py-3">
                                    <strong>{!! ucwords($header['label']) !!} : </strong>
                                    <span class="ltr:float-right rtl:float-left">
                                        {{ $submission->renderEntryContent($header['name'], $header['type']) }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card">
            <div class="card-header">
                <h5>Details</h5>
            </div>

            <div class="card-body p-0">
                <div class="card-block pt-2 py-0 px-2">
                    <div class="col-sm-12">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item rounded-0 py-3">
                                <strong>{{ __('Form') }} : </strong>
                                <span
                                    class="ltr:float-right rtl:float-left">{{ $submission?->form?->name }}</span>
                            </li>
                            <li class="list-group-item rounded-0 py-3">
                                <strong>{{ __('Submitted By') }} : </strong>
                                <span
                                    class="ltr:float-right rtl:float-left">{{ $submission?->user?->name ?? __('Guest') }}</span>
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
