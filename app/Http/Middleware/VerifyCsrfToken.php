<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/gateway/pay/*/callback',
        '/gateway/pay/*/payment_webhook',
        'gateway/pay/*/complete',
        'gateway/pay/*/cancelled',
    ];
}
