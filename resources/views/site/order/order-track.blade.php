@extends('../site/layouts.app')

@section('page_title', __('Order Track'))
@section('content')
<div class="overflow-x-hidden">
    <div class="mx-4 lg:mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92">
        <div class="grid md:grid-cols-3 grid-cols-1">
            <form class="lg:w-4/12 w-full order-track-form" action="{{ route('site.trackOrder') }}" method="get">
                <div class="md:pt-40 md:pb-152p p pt-40p pb-18p w-full lg:w-92">
                    <p class="md:text-20 text-13 dm-sans text-gray-12 lg:leading-30px">{{ __('Have an order?') }}<br>
                        {{ __('Want to know where your order is now?') }}</p>
                    <p class="h-56p md:text-40 text-20 mt-1.5 dm-bold"><span class="text-gray-12">{{ __('TRACK') }}</span> <span class="primary-text-color">{{ __('YOUR ORDER') }}</span></p>
                    <div class="relative w-full lg:w-400p mt-3.5 mb-3p z-0">
                        <input name="code" required
                            class="text-18 roboto-regular appearance-none block w-full h-54p bg-white text-gray-10 border border-gray-19 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 form-control"
                            id="grid-last-name"
                            type="text"
                            value="{{ $errors->first('code') }}"
                            placeholder="{{ __('Track code') }}">
                        <div class="absolute top-7p bottom-7p ltr:right-7p rtl:left-7p">
                            <button id="switch" type="submit">
                                <span>
                                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="40" height="40" rx="2" fill="var(--primary-color)"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M22.4483 15.2942L21.0632 16.708L23.3089 19.0003H13.9204C13.3794 19.0003 12.9409 19.4479 12.9409 20.0001C12.9409 20.5522 13.3794 20.9998 13.9204 20.9998H23.3089L21.0632 23.2921L22.4483 24.706L27.0586 20.0001L22.4483 15.2942Z" fill="#2C2C2C"/>
                                    </svg>
                                </span>
                            </button>
                        </div>
                        <label class="error">{{ $errors->first('message') }}</label>
                    </div>

                    <p class="mt-5 text-base roboto-medium text-gray-10 md:w-3/4 w-full leading-7">
                        {{ __('Enter the track code of your order above and know the progress of your product delivery.') }}
                    </p>
                </div>
            </form>

            <div class="md:mt-58p mt-0 w-full col-span-2 lg:flex lg:justify-end relative">
                <span class="mt-2 sm:mt-0 sm:h-468p w-649p animate LtrfadeInRight RtlfadeInLeft">
                    <img class="neg-transition-scale" src="{{ asset('public/frontend/assets/img/be-seller/d-v-man.png') }}" alt="img">
                </span>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="{{ asset('public/dist/js/custom/site/order-track.min.js') }}"></script>
@endsection

