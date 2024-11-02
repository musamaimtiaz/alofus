@extends('packages.installer.layout')

@section('content')
    <div class="card">
        <div class="card-content black-text">
            <div class="center-align">
                <p class="card-title">{{ __("Verify Envato Purchase Code") }}</p>
                <hr>
            </div>
            @if(isset($responseError))
                <div class="center-align red-text">
                    {{ $responseError }}
                </div>
            @endif
            <form class="form-horizontal" action="{{ url('install/verify-envato-purchase-code?bypass=' . $bypass) }}" method="post">
                {{ csrf_field() }}
                <div class="input-field">
                    <input type="text" id="username" class="form-control" id="envatoUsername" placeholder="Enter any data" name="envatoUsername" value="{{ old('envatoUsername') }}">
                    <label for="username">
                        {{ __("Envato username") }}
                    </label>
                    @if (isset($errors) && $errors->has('envatoUsername'))
                        <small class="red-text text-lighten-2">{{$errors->first('envatoUsername')}}</small>
                    @endif
                </div>

                <div class="input-field">
                    <input type="text" id="envatopurchasecode" placeholder="Enter any data" class="form-control" id="envatopurchasecode" name="envatopurchasecode" value="{{ old('envatopurchasecode') }}">
                    <label for="envatopurchasecode">
                        {{ env('APP_NAME', '') }} {{ __("purchase code") }}
                    </label>
                    @if (isset($errors) && $errors->has('envatopurchasecode'))
                        <small class="red-text text-lighten-2">{{$errors->first('envatopurchasecode')}}</small>
                    @endif
                </div>

                <div class="card-action">
                    <div class="row">
                        <div class="left">
                            <a class="btn waves-effect blue waves-light" href="{{ url('install/permissions') }}">
                                {{ __("BACK") }}
                                <i class="material-icons left">arrow_back</i>
                            </a>
                        </div>
                        <div class="right">
                            <button type="submit" class="btn waves-effect blue waves-light">
                                {{ __("VERIFY PURCHASE CODE") }}
                                <i class="material-icons right">send</i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
