<?php

namespace Modules\Paypal\Services\Core;

use PayPalHttp\Injector;

class GzipInjector implements Injector
{
    public function inject($httpRequest)
    {
        $httpRequest->headers['Accept-Encoding'] = 'gzip';
    }
}
