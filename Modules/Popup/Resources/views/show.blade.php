@extends('admin.layouts.app')
@section('page_title', __('View Popup'))
@section('content')

<!-- Main content -->
<div class="col-sm-12 list-container" id="popup-show-container">
    <div class="card">
        <div class="card-header">
            <h5> <a href="{{ route('popup.index') }}">{{ __('Popup') }} >> </a>{{ __('View Popup') }} </h5>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="card min-h-100">
        <div class="card-body position-relative">
            @php
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
                    $mailStyle = "margin: " . (!empty($content->email_margin_top) ? $content->email_margin_top : 0) . 'px ' . (!empty($content->email_margin_right) ? $content->email_margin_right : 0) . 'px ' . (!empty($content->email_margin_bottom) ? $content->email_margin_bottom : 0). 'px ' . (!empty($content->email_button_margin_left) ? $content->email_button_margin_left : 0) . 'px;';
                } else if ($popup->type == 'Subscribed') {
                    $subscribeStyle = "margin: " . (!empty($content->subscription_margin_top) ? $content->subscription_margin_top : 0) . 'px ' . (!empty($content->subscription_margin_right) ? $content->subscription_margin_right : 0) . 'px ' . (!empty($content->subscription_margin_bottom) ? $content->subscription_margin_bottom : 0) . 'px ' . (!empty($content->subscription_button_margin_left) ? $content->subscription_button_margin_left : 0) . 'px;';
                }
            @endphp
            <div class="position-absolute overflow-auto" style="{{ $style }}">
                @foreach ($content->text as $text)
                    @php
                        $textStyle = "
                            color: $text->text_color;
                            font-size: {$text->text_size}px;
                            margin: " . (!empty($text->text_margin_top) ? $text->text_margin_top : 0) . 'px ' . (!empty($text->text_margin_right) ? $text->text_margin_right : 0) . 'px ' . (!empty($text->text_margin_bottom) ? $text->text_margin_bottom : 0) . 'px ' . (!empty($text->text_margin_left) ? $text->text_margin_left : 0). 'px;' .
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
                    <a style="{{ $btnStyle }}" class="hover_variable" href="{{ $content->button_link }}">{{ $content->button_title }}</a>
                @elseif ($popup->type == 'Send mail')
                    <div style="{{ $mailStyle }}" class="input-group mb-3 w-75">
                        <input style="border: 1px solid {{ $content->email_button_bg_color }}" type="text" class="form-control" placeholder="{{ $content->email_placeholder }}" >
                        <div class="input-group-append">
                            <a class="hover_variable" style="--textHoverColor: {{ $content->email_button_hover_text_color }}; --bgHoverColor: {{ $content->email_button_hover_bg_color }}; color: {{ $content->email_button_text_color }}; background: {{ $content->email_button_bg_color }}"
                                href="javascript:void(0)" class="btn" >
                                {{ $content->email_button_name }}
                            </a>
                        </div>
                    </div>
                @elseif ($popup->type == 'Subscribed')
                    <div style="{{ $subscribeStyle }}" class="input-group mb-3 w-75">
                        <input style="border: 1px solid {{ $content->subscription_button_bg_color }}" type="text" class="form-control" placeholder="{{ $content->subscription_email_placeholder }}" >
                        <div class="input-group-append">
                            <a class="hover_variable" style="--textHoverColor: {{ $content->subscription_button_hover_text_color }}; --bgHoverColor: {{ $content->subscription_button_hover_bg_color }}; color: {{ $content->subscription_button_text_color }}; background: {{ $content->subscription_button_bg_color }}"
                                href="javascript:void(0)" class="btn" >
                                {{ $content->subscription_button_name }}
                            </a>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>

@endsection


