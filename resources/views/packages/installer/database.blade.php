@extends('packages.installer.layout')

@section('style')
    <link rel="stylesheet" href="{{ asset('public/dist/css/installer.min.css') }}">
@endsection

@section('content')
    <div class="card">
         <form method="post" action="{{ url('install/database') }}">
            <div class="card-content black-text">
                <p class="card-title center-align">{{ __("Databse Settings") }}</p>
                <p class="center-align">{{ __("If you dont know how to fill this form contact your hosting provider.") }}</p>
                <hr>
                {{ csrf_field() }}
                <div class="input-field">
                    <i class="material-icons prefix">settings</i>
                    <input type="text" id="dbname" name="dbname" value="{{ $database }}" required>
                    <label for="dbname">{{ __("Databse Name") }}</label>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">perm_identity</i>
                    <input type="text" id="username" name="username" value="{{ $username }}" required>
                    <label for="username">{{ __("Database User") }}</label>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">vpn_key</i>
                    <input type="text" id="password" name="password" value="{{ $password }}">
                    <label for="password">{{ __("Database Password") }}</label>
                </div>
                <div class="input-field ">
                    <i class="material-icons prefix black-text">select_all</i>
                    <input type="text" id="port" name="port" value="{{ $port }}" required>
                    <label for="port">{{ __("Databse Port") }}</label>
                </div>
                <div class="input-field ">
                    <i class="material-icons prefix black-text">language</i>
                    <input type="text" id="host" name="host" value="{{ $host }}" required>
                    <label for="host">{{ __("Host name (should be 'localhost', if it does not work ask your hoster)") }}</label>
				</div>
            </div>
            <div class="card-action">
                <div class="row">
                     <div class="left">
                        <a class="btn waves-effect blue waves-light" href="{{ url('install/verify-envato-purchase-code') }}">
                            {{ __("BACK") }}
                            <i class="material-icons left">arrow_back</i>
                        </a>
                      </div>
                      <div class="right">
                        <button type="submit" class="btn waves-effect blue waves-light">
                            {{ __("CREATE DATABASE") }}
                            <i class="material-icons right">send</i>
                        </button>
                      </div>
                  </div>
            </div>
        </form>
    </div>
    <div class="card-panel teal red">
        <div class="card-content white-text">
            {{ __("Installing the database...") }}
            <br>
            <div class="progress">
                <div class="indeterminate red"></div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('public/dist/js/custom/installer.min.js') }}"></script>
@endsection
