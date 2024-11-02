@php
$favicon = App\Models\Preference::getFavicon();
@endphp
@if (!empty($favicon))
    <link rel='shortcut icon' href="{{ $favicon }}" type='image/x-icon' />
@endif
