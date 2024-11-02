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
                    <dt>{{ __('Select Slider') }}</dt>
                </label>
                <div class="col-sm-8">
                    <select type="text" class="form-control select3" name="slider">
                        @foreach (\Modules\CMS\Service\Homepage::getSliders() as $slider)
                            <option {{ $component && $component->slider == $slider->slug ? 'selected' : '' }}
                                value="{{ $slider->slug }}">{{ $slider->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @include('cms::edit.sub.appearance', ['fields' => ['width', 'margin', 'rounded', 'height']])
            @include('cms::pieces.submit-btn')
        </form>
    </div>
</div>
