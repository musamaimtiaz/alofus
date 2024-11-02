<?php

namespace Modules\CMS\Service;

use Illuminate\Support\Facades\Facade;

class Homepage extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Modules\CMS\Service\HomepageService';
    }
}
