@extends('admin.layouts.app2')

@section('content')
<div class="login-box-body">
    <p class="login-box-msg">{{ __('Reset Password') }}</p>
    <form action='{{ route('password.resets') }}' method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $user->id }}">
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="{{ __('Password') }}" name="password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="{{ __('Confirm password') }}" name="password_confirmation"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <button type="submit" class="btn btn-primary shadow-2 mb-4">{{ __('Reset Password') }}</button>
    </form>
    <a class="text-decoration-none" href="{{ route('login') }}">{{ __('Log In') }}</a><br>
</div>
@endsection
