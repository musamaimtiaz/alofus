@extends('formbuilder::layout')

@section('page_title', __('Submission Details'))

@section('content')
    <div class="col-md-12 row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5><a href="{{ route('formbuilder::submissions.all')}}">{{ __('Viewing Submission #:x for form :y', ['x' => $submission->id, 'y' => $submission?->form?->name]) }}</a></h5>
                    <div class="card-header-right d-inline-block">
                        <div class="btn-toolbar " role="toolbar">
                            <div class="btn-group" role="group">
                                <a href="{{ $submission->form ? route('formbuilder::forms.submissions.index', $submission->form->id) : '' }}"
                                    class="btn btn-primary  btn-sm" title="{{ __('Back To Submissions') }}">
                                    <i class="fa fa-arrow-left neg-transition-scale"></i>
                                </a>
                                <form
                                    action="{{ route('formbuilder::forms.submissions.destroy', [$submission->form, $submission]) }}"
                                    method="POST" id="deleteSubmissionForm_{{ $submission->id }}" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger btn-sm rounded-0 confirm-form"
                                        data-form="deleteSubmissionForm_{{ $submission->id }}"
                                        data-message="{{ __('Delete submission') }}"
                                        title="{{ __('Delete this submission?') }}">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @foreach ($form_headers as $header)
                            <li class="list-group-item">
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
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item rounded-0 py-3">
                            <strong>{{ __('Form') }} : </strong>
                            <span class="ltr:float-right rtl:float-left">{{ $submission?->form?->name }}</span>
                        </li>
                        <li class="list-group-item rounded-0 py-3">
                            <strong>{{ __('Submitted By') }} : </strong>
                            <span class="ltr:float-right rtl:float-left">{{ $submission?->user?->name ?? __('Guest') }}</span>
                        </li>
                        <li class="list-group-item rounded-0 py-3">
                            <strong>{{ __('Updated On') }} : </strong>
                            <span class="ltr:float-right rtl:float-left">{{ $submission->format_updated_at }}</span>
                        </li>
                        <li class="list-group-item rounded-0 py-3">
                            <strong>{{ __('Submitted On') }} : </strong>
                            <span class="ltr:float-right rtl:float-left">{{ $submission->format_created_at }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
