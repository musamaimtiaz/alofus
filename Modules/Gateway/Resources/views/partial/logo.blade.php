@php
    $logo = \Modules\CMS\Http\Models\ThemeOption::getAll()->where('name', 'default_template_header_logo')
            ->first()
            ->fileUrl();
@endphp
<img src="{{ $logo }}" width="188" height="30" class="logo" alt="{{ __('Logo') }}">

