@extends('../site/layouts.app')
@section('page_title', __('User Verification'))
@section('content')
    <div class="lg:flex" id="login-container">
        <div class="hidden lg:flex items-center justify-center bg-green-50 color_switch_log flex-1 h-screen">
            @include('../site/layouts/partials.login_signup_bac')
        </div>
        <div class="lg:w-1/2 xl:max-w-screen-sm">
            <div class="mt-24 px-12 sm:px-24 md:px-48 lg:px-12 lg:mt-16 xl:px-24 xl:max-w-2xl">
                <h2 class="text-center font-display font-semibold lg:text-left sm:text-xl md:text-2xl lg:text-3xl md: 2xl:text-5xl
                  xl:text-bold text-green-500">{{ __('Enter Your :x', ['x' => __('Email')]) }}</h2>
                <div class="mt-12">
                    <form method="post" action="{{ route('site.emailStore') }}">
                        @csrf
                        <div>
                            <div class="text-md font-bold text-gray-700 tracking-wide">{{ __('Email') }}</div>
                            <input type="email" name="email" class="w-full text-sm py-2 border-b border-gray-300 focus:outline-none focus:border-indigo-500" placeholder="{{ __('Email') }}" required>
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <li class="text-red-500">{{ $error }}</li>
                                @endforeach
                            @endif
                            @foreach (['success', 'fail'] as $msg)
                                @if($message = Session::get($msg))
                                    <strong class="{{ $msg == 'fail' ? 'text-red-500' : 'text-green-400' }}">{{ $message }}</strong>
                                    @break
                                @endif
                            @endforeach
                        </div>
                        <div class="mt-10 mb-10">
                            <button type="submit" class="bg-green-500 color_switch_bac color_switch_hover text-white p-2 2xl:p-4 w-full rounded-full tracking-wide
                                font-semibold font-display focus:outline-none focus:shadow-outline hover:bg-green-600
                                shadow-lg">
                                {{ __('Submit') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
@endsection
