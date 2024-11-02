@extends('admin.layouts.app2')
@section('login_title', __('RESET YOUR PASSWORD'))
@section('content')
<div class="login-box-body">
    @if(is_null(session('success')))
    <p class="login-box-msg">{{ __('Enter your email to send password reset link') }}</p>
    @endif
    <form method="POST" action="{{ route('login.sendResetLink')}}" class="admin-reset-password">
        @csrf
        <div class="position-relative">
            <div class="mb-3">
                <input type="email" class="form-control" value="{{ old('email') }}" name="email" placeholder="{{ __('Email') }}">
            </div>
            <span class="position-absolute email-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="19" viewBox="0 0 18 19" fill="none">
                    <path d="M16.3449 17.4054C16.8977 17.2902 17.2269 16.7117 16.9522 16.2183C16.3466 15.1307 15.3926 14.1749 14.1722 13.4465C12.6004 12.5085 10.6745 12 8.69333 12C6.71213 12 4.78628 12.5085 3.21448 13.4465C1.99405 14.1749 1.04002 15.1307 0.434441 16.2183C0.159743 16.7117 0.488979 17.2902 1.04179 17.4054C6.0886 18.4572 11.2981 18.4572 16.3449 17.4054Z" fill="#898989"></path>
                    <circle cx="8.69336" cy="5" r="5" fill="#898989"></circle>
                </svg>
            </span>
        </div>
        <button type="submit" class="send-btn">{{ __('Send') }}
            <svg role="status" class="anim spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"></path>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"></path>
            </svg>
        </button>
        <p class="mb-2 text-muted click-login">{{ __('Click here to') }} <a class="text-decoration-none" href="{{ route('login') }}">{{ __('Log In') }}</a></p>
    </form>
</div>
@endsection



