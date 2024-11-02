@php
    $component = isset($component) ? $component : null;
@endphp
<div class="card dd-content {{ $editorClosed ?? 'card-hide' }}">
    <div class="card-body">
        <form action="{{ route('builder.update', ['id' => '__id']) }}" data-type="component" method="post"
            class="component_form form-parent silent-form" novalidate>
            @csrf
            @include('cms::hidden_fields')
            <div class="form-group row">
                <label class="col-sm-3 control-label">{{ __('Title') }}</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control section_name inputFieldDesign" name="title" id="title"
                        value="{{ $component ? $component->title : '' }}">
                    <div class="d-flex mt-2">
                        <span class="badge badge-danger h-100 mt-1">{{ __('Note') }}!</span>
                        <small
                            class="mt-1 ltr:ms-2 rtl:me-2">{{ __("Newsletter section won't be visible if the Newsletter Module is deactivated") }}</small>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label">{{ __('Message') }}</label>
                <div class="col-sm-8">
                    <textarea name="message" class="form-control" rows="2">{{ $component ? $component->message : '' }}</textarea>
                </div>
            </div>
            @include('cms::edit.sub.appearance', ['fields' => ['margin']])
            @include('cms::pieces.submit-btn')
        </form>
    </div>
</div>
