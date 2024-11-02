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
                <label class="col-sm-3 control-label">
                    <dt>{{ __('Insert your custom code here:') }}</dt>
                </label>
                <div class="col-sm-8">
                    <textarea name="content" rows="20" class="form-control inputFieldDesign">{!! $component ? $component->content : '' !!}</textarea>
                </div>
            </div>
            @include('cms::edit.sub.appearance', ['fields' => ['margin', 'width']])
            @include('cms::pieces.submit-btn')
        </form>
    </div>
</div>
