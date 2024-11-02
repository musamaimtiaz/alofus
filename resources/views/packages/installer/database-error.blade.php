@extends('packages.installer.layout')

@section('content')
    <div class="card lighten-1">
        <div class="card-content black-text">
            <p class="card-title center-align">{{ __("Database Error") }}</p>
            <hr>
            <p>{{ __("Couldn't prepare the database") }}</p>
                <pre class="error"><code class="error">{{ $error }}</code></pre>
            <p>{{ __("Please contact your developer if you don't understand the error message.") }}</p>
        </div>
        <div class="card-action">
            <a class="btn waves-effect red waves-light" href="{{ url('install/database') }}">
                {{ __("TRY AGAIN") }} !
            </a>
        </div>
    </div>
@endsection
