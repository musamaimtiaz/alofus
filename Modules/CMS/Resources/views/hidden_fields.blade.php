<input type="hidden" name="level" class="order {{ isset($level) ? $level : '' }}" value="{{ $component->level ?? '' }}">
<input type="hidden" name="component" class="component" value="{{ $component->id ?? '' }}">
<input type="hidden" name="layout" class="layout"
    value="{{ isset($component) ? $component->layout->id : $layout->id }}">
