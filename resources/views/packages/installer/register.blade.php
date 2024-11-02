@extends('packages.installer.layout')

@section('style')
    <style>
        input { margin-bottom: 2px !important };
    </style>
@endsection

@section('content')
    <div class="card black-text">
         <form method="post" action="{{ url('install/register') }}">
            <div class="card-content">
                <p class="card-title center-align">{{ __("Administrator creation") }}</p>
                <p class="center-align">{{ __("Now you must enter informations to create administrator") }}</p>
                <hr>
                {{ csrf_field() }}
                @foreach ($fields as $key => $value)
                    <div class="input-field">
                        <input type="{{ $value['type'] }}" id="{{ $key }}" name="{{ $key }}" value="{{ old($key) }}">
                        <label for="{{ $key }}">
                            {{ $value['name'] }}
                        </label>
                        @if ($errors->has($key))
                            <small class="red-text text-lighten-2">{{ $errors->first($key) }}</small>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="card-action">
                <div class="row">
                     <p><em>{{ __("You'll need your password to login, so keep it safe.") }}</em></p>
                      <div class="right">
                        <button type="submit" class="btn waves-effect blue waves-light">
                            {{ __("CREATE USER") }}
                            <i class="material-icons right">send</i>
                        </button>
                      </div>
                  </div>
            </div>
        </form>
    </div>
@endsection
