@php
    // column count
    $count = 0;
    if (isset($footer['main'])) {
        foreach ($footer['main'] as $key => $value) {
            if (is_array($value) && $value['status']) {
                $count++;
            }
        }
    }
@endphp
@if (isActive('Popup'))
    @php
        $routeName = request()->route()->getName();
        $routePage = ['Home' => 'site.index', 'Product Details' => 'site.productDetails', 'Cart' => 'site.cart', 'Checkout' => 'site.checkOut', 'Confirm Order' => 'site.orderConfirm'];
        $popups = \Modules\Popup\Entities\Popup::getAll()->where('status', 'Active')
                ->where('start_date', '<=', date("Y-m-d"))
                ->where('end_date', '>=', date("Y-m-d"))
    @endphp
    @foreach ($popups as $key => $popup)
        @php
            if (!empty($popup) && $routePage[$popup->page_link] == $routeName) {
                $content = json_decode($popup->param);

                // Default content
                $arr = ['Center' => "top: 50%; left: 50%; transform: translate(-50%, -50%);", 'Top Left' => "top: 0; left: 0;", 'Top Right' => "top: 0; right: 0;", 'Bottom Left' => "bottom: 0; left: 0;", 'Bottom Right' => "bottom: 0; right: 0;"];

                $style = "height: {$content->height}px; width: {$content->width}px;";
                $style .= $arr[$content->position];
                if ($content->background == 'Color') {
                    $style .= "background: {$content->popup_bg_color};";
                } else {
                    $file = getBackgroundImage($popup->fileUrl());
                    $style .= "background-image: url({$file}); background-size: cover;";
                }

                // Default content end
                if ($popup->type == 'Another page link') {
                    $btnStyle = "--textHoverColor: {$content->button_hover_text_color}; --bgHoverColor: {$content->button_hover_bg_color};";
                    $btnStyle .= "color: {$content->button_text_color};";
                    $btnStyle .= "background: {$content->button_bg_color};";
                    $btnStyle .= "margin: " . (!empty($content->button_margin_top) ? $content->button_margin_top : 0) . 'px ' . (!empty($content->button_margin_right) ? $content->button_margin_right : 0) . 'px ' . (!empty($content->button_margin_bottom) ? $content->button_margin_bottom : 0) . 'px ' . (!empty($content->button_margin_left) ? $content->button_margin_left : 0) . 'px;';
                    $btnStyle .= "display: inline-block; padding: 8px 16px; border-radius: 5px;";
                } else if ($popup->type == 'Send mail') {
                    $mailStyle = "margin: " . (!empty($content->email_margin_top) ? $content->email_margin_top : 0) . 'px ' . (!empty($content->email_margin_right) ? $content->email_margin_right : 0) . 'px ' . (!empty($content->email_margin_bottom) ? $content->email_margin_bottom : 0) . 'px ' . (!empty($content->email_button_margin_left) ? $content->email_button_margin_left : 0) . 'px;';
                } else if ($popup->type == 'Subscribed') {
                    $subscribeStyle = "margin: " . (!empty($content->subscription_margin_top) ? $content->subscription_margin_top : 0) . 'px ' . (!empty($content->subscription_margin_right) ? $content->subscription_margin_right : 0) . 'px ' . (!empty($content->subscription_margin_bottom) ? $content->subscription_margin_bottom : 0) . 'px ' . (!empty($content->subscription_button_margin_left) ? $content->subscription_button_margin_left : 0) . 'px;';
                }
            }
        @endphp

        @if (!empty($popup) && $routePage[$popup->page_link] == $routeName)
            <div class="{{ $content->position == 'Center' ? 'custom-modal-overlay' : '' }} custom-modal-over">
                <div class="{{ $content->position == 'Center' ? 'absolute' : 'fixed' }} overflow-auto z-index-999" style="{{ $style }}">
                    <span data-popupName = "{{ $popup->name }}"
                        data-popupShowAfter = {{ $popup->show_time }}
                        data-loginRequired = "{{ $popup->login_enabled }}"
                        data-isLogin = "{{ auth()->user() ? 'true' : 'false' }}"
                        data-popupPage = {{ $routePage[$popup->page_link] == $routeName ? 'true' : 'false' }}
                        class="close-modal close-popup-window">X</span>

                    @foreach ($content->text as $text)
                        @php
                            $textStyle = "
                                word-break: break-word;
                                color: $text->text_color;
                                font-size: {$text->text_size}px;
                                margin: " . (!empty($text->text_margin_top) ? $text->text_margin_top : 0) . 'px ' . (!empty($text->text_margin_right) ? $text->text_margin_right : 0) . 'px ' . (!empty($text->text_margin_bottom) ? $text->text_margin_bottom : 0) . 'px ' . (!empty($text->text_margin_left) ? $text->text_margin_left : 0) . 'px;' .
                                "text-align: $text->text_alignment;
                            ";
                            if ($text->text_font_weight == 'italic') {
                                $textStyle .= "font-style: italic;";
                            } else {
                                $textStyle .= "font-weight: $text->text_font_weight;";
                            }
                        @endphp

                        <div style="{{ $textStyle }}">
                            {{ $text->text }}
                        </div>
                    @endforeach

                    @if ($popup->type == 'Another page link')
                        <a class="hover_variable close-popup-window" style="{{ $btnStyle }}" href="{{ $content->button_link }}">{{ $content->button_title }}</a>
                    @elseif ($popup->type == 'Send mail')
                        <form action="{{ route('popup.mail') }}" method="post">
                            @csrf
                            <div style="{{ $mailStyle }}" class="flex">
                                <input type="hidden" name="id" value="{{ $popup->id }}">
                                <input style="border: 1px solid {{ $content->email_button_bg_color }}" type="text" class="form-control" placeholder="{{ $content->email_placeholder }}" name="email">
                                <div class="input-group-append">
                                    <button class="h-10 block p-2 hover_variable close-popup-window" style="--textHoverColor: {{ $content->email_button_hover_text_color }}; --bgHoverColor: {{ $content->email_button_hover_bg_color }}; color: {{ $content->email_button_text_color }}; background: {{ $content->email_button_bg_color }}"
                                        type="submit">
                                        {{ $content->email_button_name }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    @elseif ($popup->type == 'Subscribed')
                        <form action="{{ route('subscriber.store') }}" method="post">
                            @csrf
                            <div style="{{ $subscribeStyle }}" class="flex">
                                <input style="border: 1px solid {{ $content->subscription_button_bg_color }}" type="text" class="form-control" placeholder="{{ $content->subscription_email_placeholder }}" name="email">
                                <div class="input-group-append">
                                    <button type="submit" class="h-10 block p-2 hover_variable close-popup-window" style="--textHoverColor: {{ $content->subscription_button_hover_text_color }}; --bgHoverColor: {{ $content->subscription_button_hover_bg_color }}; color: {{ $content->subscription_button_text_color }}; background: {{ $content->subscription_button_bg_color }}"
                                        class="btn">
                                        {{ $content->subscription_button_name }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        @endif
    @endforeach
@endif
@php
    $direction = ['left' => 'justify-start', 'center' => 'justify-center', 'right' => 'justify-end'];
@endphp

@if ($count)
    <section class="bg-gray-12 text-white mt-5" style="color: {{ isset($footer['main']['text_color']) ? $footer['main']['text_color'] : '' }}; background: {{ isset($footer['main']['bg_color']) ? $footer['main']['bg_color'] : '' }}">
        <footer class="body-font pb-30p sm:pb-11 mx-4 lg:mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92">
            <div class="flex flex-wrap lg:flex-nowrap gap-7 pt-12 {{ $direction[$footer['main']['direction']] }}">
                @if (isset($footer['main']['about_us']['status']) && $footer['main']['about_us']['status'] == 1)
                    <div class="w-full sm:w-1/3 md:w-1/5 order-{{ isset($footer['main']['about_us']['sort']) ? $footer['main']['about_us']['sort'] : 1 }}">
                        <div class="flex-shrink-0 md:mx-0 mx-auto">
                            @if ($footerLogo->objectFile)
                                <div class="flex">
                                    <a href="{{ route('site.index') }}">
                                        <img class="w-44 neg-transition-scale" height="30.14px" src="{{ $footerLogo->fileUrl() }}" alt="{{ __('Image') }}">
                                    </a>
                                </div>
                            @endif

                            <p class="text-sm font-medium roboto-regular mt-5 break-all">
                                {!! isset($footer['main']['about_us']['data']['short_details']) ? $footer['main']['about_us']['data']['short_details'] : '' !!}
                            </p>
                        </div>
                        @if ($paymentMethods->objectFile)
                            <div class="flex space-x-4 mt-7 items-center">
                                <img class="w-full sm:w-auto neg-transition-scale" src="{{ $paymentMethods->fileUrl() }}" alt="{{ __('Image') }}">
                            </div>
                        @endif

                        <div class="mt-8">
                            <p class="text-base dm-regular break-all">{{ isset($footer['main']['about_us']['data']['download_app']) ? $footer['main']['about_us']['data']['download_app'] : '' }}</p>
                            <div class="flex space-x-2 md:flex-col md:space-x-0 c-flex">
                                @if ($googlePlay->objectFile)
                                    <div class="flex xs:justify-center md:justify-start">
                                        <a href="{{ isset($footer['main']['about_us']['data']['google_play_link']) ? $footer['main']['about_us']['data']['google_play_link'] : '' }}" class="mt-15p" target="_blank">
                                            <img class="w-263p sm:w-32 neg-transition-scale" src="{{ $googlePlay->fileUrl() }}" alt="{{ __('Image') }}">
                                        </a>
                                    </div>
                                @endif
                                @if ($appStore->objectFile)
                                    <div class="flex xs:justify-center md:justify-start">
                                        <a href="{{ isset($footer['main']['about_us']['data']['app_store_link']) ? $footer['main']['about_us']['data']['app_store_link'] : '' }}" class="md:mt-11p mt-15p" target="_blank">
                                            <img class="w-263p sm:w-32 neg-transition-scale" src="{{ $appStore->fileUrl() }}" alt="{{ __('Image') }}">
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                @if (isset($footer['main']))
                    @foreach ($footer['main'] as $key => $value)
                        @if (in_array($key, ['useful_links', 'pages', 'categories']) && $value['status'])
                            <div class="w-27% sm:w-1/3 md:w-1/5 grid justify-center order-{{ $value['sort'] }}">
                                <ul class="text-sm font-medium roboto-regular leading-8 break-all">
                                    <p class="mb-4 font-medium text-base dm-sans break-all">
                                        {!! $value['title'] !!}
                                    </p>
                                    @foreach ($value['data'] ?? [] as $widget)
                                        <a href="{{ $widget['link'] }}">
                                            <li class="hover:text-orange-500 cursor-pointer transition-all break-all">
                                                {!! $widget['label'] !!}
                                            </li>
                                        </a>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endforeach
                @endif

                @if (isset($footer['main']['contact_us']['status']) && $footer['main']['contact_us']['status'] == 1)
                    <div class="w-full sm:w-1/3 md:w-1/5 order-{{ isset($footer['main']['contact_us']['sort']) ? $footer['main']['contact_us']['sort'] : 1 }}">
                        @if (isset($footer['main']['contact_us']['title']) && !empty($footer['main']['contact_us']['title']))
                            <p class="mb-23p font-medium text-base break-all">
                                {!! $footer['main']['contact_us']['title'] !!}
                            </p>
                        @endif

                        @if (isset($footer['main']['contact_us']['data']['address']) && !empty($footer['main']['contact_us']['data']['address']))
                            <div class="flex-shrink-0 md:mx-0 mx-auto ltr:md:text-left rtl:md:text-right mt-4 break-all">
                                <a class="flex title-font font-medium md:justify-start">
                                    <div class="ltr:mr-15p rtl:ml-15p">
                                        <svg class="neg-transition-scale" width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8 2C4.68629 2 2 4.68629 2 8C2 10.1458 3.09211 11.9159 4.45503 13.2906C5.77773 14.6248 7.27659 15.5032 8 15.8837C8.72341 15.5032 10.2223 14.6248 11.545 13.2906C12.9079 11.9159 14 10.1458 14 8C14 4.68629 11.3137 2 8 2ZM0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8C16 10.8706 14.5326 13.1178 12.9653 14.6987C11.397 16.2805 9.64481 17.2838 8.85847 17.6917C8.31691 17.9726 7.68309 17.9726 7.14153 17.6917C6.35519 17.2838 4.60299 16.2805 3.03474 14.6987C1.46741 13.1178 0 10.8706 0 8ZM8 6C6.89543 6 6 6.89543 6 8C6 9.10457 6.89543 10 8 10C9.10457 10 10 9.10457 10 8C10 6.89543 9.10457 6 8 6ZM4 8C4 5.79086 5.79086 4 8 4C10.2091 4 12 5.79086 12 8C12 10.2091 10.2091 12 8 12C5.79086 12 4 10.2091 4 8Z" fill="{{ $footer['main']['text_color'] }}"/>
                                        </svg>
                                    </div>

                                    <span class="text-sm ltr:ml-1 rtl:mr-1 font-medium hover:text-orange-500 cursor-pointer transition-all rtl-direction-space-location roboto-regular">
                                        {!! $footer['main']['contact_us']['data']['address'] !!}
                                    </span>
                                </a>
                            </div>
                        @endif

                        @if (isset($footer['main']['contact_us']['data']['email']) && !empty($footer['main']['contact_us']['data']['email']))
                            <div class="flex-shrink-0 md:mx-0 mx-auto text-center ltr:md:text-left rtl:md:text-right mt-5 break-all">
                                <a class="flex title-font font-medium items-center md:justify-start">
                                    <div class="ltr:mr-15p rtl:ml-15p">
                                        <svg class="neg-transition-scale" width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.93417 2.43991e-06C4.95604 3.63201e-06 4.97799 4.8241e-06 5 4.8241e-06L13.0658 2.43991e-06C13.9523 -4.73896e-05 14.7161 -9.01893e-05 15.3278 0.0821453C15.9833 0.170277 16.6117 0.369022 17.1213 0.878684C17.631 1.38835 17.8297 2.0167 17.9179 2.67221C18.0001 3.28388 18.0001 4.0477 18 4.9342V9.06581C18.0001 9.95231 18.0001 10.7161 17.9179 11.3278C17.8297 11.9833 17.631 12.6117 17.1213 13.1213C16.6117 13.631 15.9833 13.8297 15.3278 13.9179C14.7161 14.0001 13.9523 14.0001 13.0658 14H4.93417C4.04769 14.0001 3.28387 14.0001 2.67221 13.9179C2.0167 13.8297 1.38835 13.631 0.878684 13.1213C0.369022 12.6117 0.170277 11.9833 0.0821453 11.3278C-9.01893e-05 10.7161 -4.73896e-05 9.95232 2.43991e-06 9.06583L4.8241e-06 5C4.8241e-06 4.97799 3.63201e-06 4.95604 2.43991e-06 4.93417C-4.73896e-05 4.04769 -9.01893e-05 3.28387 0.0821453 2.67221C0.170277 2.0167 0.369022 1.38835 0.878684 0.878684C1.38835 0.369022 2.0167 0.170277 2.67221 0.0821453C3.28387 -9.01893e-05 4.04769 -4.73896e-05 4.93417 2.43991e-06ZM2.93871 2.06431C2.50497 2.12263 2.36902 2.21677 2.2929 2.2929C2.21677 2.36902 2.12263 2.50497 2.06431 2.93871C2.00213 3.40122 2 4.02893 2 5V9C2 9.97108 2.00213 10.5988 2.06431 11.0613C2.12263 11.495 2.21677 11.631 2.2929 11.7071C2.36902 11.7832 2.50497 11.8774 2.93871 11.9357C3.40122 11.9979 4.02893 12 5 12H13C13.9711 12 14.5988 11.9979 15.0613 11.9357C15.495 11.8774 15.631 11.7832 15.7071 11.7071C15.7832 11.631 15.8774 11.495 15.9357 11.0613C15.9979 10.5988 16 9.97108 16 9V5C16 4.02893 15.9979 3.40122 15.9357 2.93871C15.8774 2.50497 15.7832 2.36902 15.7071 2.2929C15.631 2.21677 15.495 2.12263 15.0613 2.06431C14.5988 2.00213 13.9711 2 13 2H5C4.02893 2 3.40122 2.00213 2.93871 2.06431Z" fill="{{ $footer['main']['text_color'] }}"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.65831 8.44711L0.552734 4.89432L1.44716 3.10547L8.55273 6.65826C8.83426 6.79902 9.16563 6.79902 9.44716 6.65826L16.5527 3.10547L17.4472 4.89432L10.3416 8.44711C9.49701 8.8694 8.50289 8.8694 7.65831 8.44711Z" fill="{{ $footer['main']['text_color'] }}"/>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium hover:text-orange-500 cursor-pointer transition-all rtl-direction-space roboto-regular">
                                        {!! $footer['main']['contact_us']['data']['email'] !!}
                                    </span>
                                </a>
                            </div>
                        @endif

                        @if (isset($footer['main']['contact_us']['data']['phone']) && !empty($footer['main']['contact_us']['data']['phone']))
                            <div class="flex-shrink-0 md:mx-0 mx-auto text-centerltr:md:text-left rtl:md:text-right mt-25p break-all">
                                <a class="flex title-font font-medium items-center md:justify-start">
                                    <div class="ltr:mr-15p rtl:ml-15p">
                                        <svg class="neg-transition-scale" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.24788 2.03712C1.73186 3.61331 1.57693 6.06186 2.89428 7.81831L4.07584 9.39373C5.32663 11.0615 6.80812 12.5429 8.47584 13.7937L10.0513 14.9753C11.8077 16.2926 14.2563 16.1377 15.8324 14.6217L13.2473 12.0365L12.2261 13.0577C11.7595 13.5243 11.0466 13.64 10.4563 13.3449C7.88947 12.0614 5.80813 9.9801 4.52471 7.41325C4.22958 6.82299 4.34526 6.1101 4.81191 5.64345L5.83306 4.6223L3.24788 2.03712ZM1.89539 0.559966C2.64201 -0.186654 3.85252 -0.186657 4.59914 0.559965L7.24727 3.20809C8.02832 3.98914 8.02832 5.25547 7.24727 6.03652L6.46774 6.81605C7.51362 8.76109 9.10848 10.356 11.0535 11.4018L11.8331 10.6223C12.6141 9.84126 13.8804 9.84125 14.6615 10.6223L17.3096 13.2704C18.0562 14.017 18.0562 15.2276 17.3096 15.9742C15.0325 18.2513 11.4275 18.5075 8.85126 16.5753L7.27584 15.3937C5.4565 14.0292 3.84034 12.4131 2.47584 10.5937L1.29428 9.01831C-0.637914 6.44206 -0.381716 2.83708 1.89539 0.559966Z" fill="{{ $footer['main']['text_color'] }}"/>
                                        </svg>
                                    </div>

                                    <span class="text-sm font-medium hover:text-orange-500 cursor-pointer transition-all rtl-direction-space roboto-regular">
                                        {!! $footer['main']['contact_us']['data']['phone'] !!}
                                    </span>
                                </a>
                            </div>
                        @endif

                        @if (isset($footer['main']['contact_us']['data']['social_title']) && !empty($footer['main']['contact_us']['data']['social_title']))
                            <p
                                class="{{ !empty($footer['main']['contact_us']['data']['phone']) || !empty($footer['main']['contact_us']['data']['email']) || !empty($footer['main']['contact_us']['data']['address']) ? 'mt-50p' : '' }} dm-regular text-base break-all">
                                {!! $footer['main']['contact_us']['data']['social_title'] !!}
                            </p>
                        @endif

                        <div class="mt-5 border-gray-13 flex">
                            <div class="flex gap-7 sm:gap-3 flex-wrap">
                                @if (isset($footer['main']['contact_us']['data']['social_data']))
                                    @foreach ($footer['main']['contact_us']['data']['social_data'] as $data)
                                        @if (!empty($data['link']))
                                            <a href="{{ $data['link'] }}" title="Youtube" target="_blank"
                                                class="primary-bg-hover hover:text-gray-800 text-white flex items-center justify-center w-8 h-8 bg-gray-3 rounded-full social-transition">
                                                <img class="social-icon neg-transition-scale" src="{{ asset('Modules/CMS/Resources/views/partials/themes/footer/svg/' . $data['label']) . '.svg' }}" alt="{{ __('Image') }}">
                                            </a>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </footer>
    </section>
@endif
<section style="color: {{ isset($footer['bottom']['text_color']) ? $footer['bottom']['text_color'] : '' }}; background: {{ isset($footer['bottom']['bg_color']) ? $footer['bottom']['bg_color'] : '' }}">
    @if ($footer['bottom']['status'])
        <div style="border-top: 1px solid {{ $footer['bottom']['border_top'] }}" class="border-gray-13 mx-4 lg:mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92">
            <p class="md:py-3 py-7 font-medium dm-sans mx-4 text-{{ isset($footer['bottom']['position']) ? $footer['bottom']['position'] : '' }}">{!! isset($footer['bottom']['title']) ? $footer['bottom']['title'] : '' !!}</p>
        </div>
    @endif
</section>
<script>
    var subscribeUrl = '{!! isActive("Newsletter") ? route('subscriber.store') : '' !!}';
    var sessionFail = "{!! session('fail') ? session('fail') : '' !!}"
    var sessionSuccess = "{!! session('success') ? session('success') : '' !!}"
</script>

