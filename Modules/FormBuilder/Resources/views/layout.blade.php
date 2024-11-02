@extends(moduleConfig('formbuilder.layout_file'))

@prepend(moduleConfig('formbuilder.layout_js_stack', 'scripts'))
    <script type="text/javascript">
        window.FormBuilder = {
            csrfToken: '{{ csrf_token() }}',
        }
    </script>
    <script src="{{ asset('Modules/FormBuilder/Resources/assets/js/jquery-ui.min.js') }}" defer></script>
    <script src="{{ asset('Modules/FormBuilder/Resources/assets/js/sweetalert.min.js') }}" defer></script>
    <script src="{{ asset('Modules/FormBuilder/Resources/assets/js/jquery-formbuilder/form-builder.min.js') }}" defer>
    </script>
    <script src="{{ asset('Modules/FormBuilder/Resources/assets/js/jquery-formbuilder/form-render.min.js') }}" defer>
    </script>
    <script src="{{ asset('Modules/FormBuilder/Resources/assets/js/parsleyjs/parsley.min.js') }}" defer></script>
    <script src="{{ asset('Modules/FormBuilder/Resources/assets/js/clipboard/clipboard.min.js') }}?b=ck24" defer></script>
    <script src="{{ asset('Modules/FormBuilder/Resources/assets/js/moment.min.js') }}"></script>
    <script
        src="{{ asset('Modules/FormBuilder/Resources/assets/js/script.min.js') }}"
        defer></script>
@endprepend

@prepend(moduleConfig('formbuilder.layout_css_stack', 'scripts'))
    <link rel="stylesheet" type="text/css" href="{{ asset('Modules/FormBuilder/Resources/assets/js/footable/css/footable.standalone.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Modules/FormBuilder/Resources/assets/css/styles.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/product.min.css') }}">

@endprepend
