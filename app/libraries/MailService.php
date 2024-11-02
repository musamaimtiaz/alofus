<?php

namespace App\libraries;

use Mail;

class MailService
{
    public function send(array $data, $htmlTemplate, $textTemplate = null)
    {
        $template = $htmlTemplate ? [$htmlTemplate, $textTemplate] : ['text' => $textTemplate];
        Mail::send($template, $data, function ($message) use ($data) {
            unset($data['content']);
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $val) {
                        $message->{$key}($val);
                    }
                } else {
                    try {
                        $message->{$key}($value);
                    } catch (\ErrorException $e) {
                        $message->{$key} = $value;
                    }
                }
            }
        });
    }
}
