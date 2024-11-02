<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md. Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 05-09-2022
 */

namespace App\Services\Actions\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed execute(String $action, Request $request) Execute the requested action
 */
class OrderActionFacade extends Facade
{
    /**
     * Order alias
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return '\App\Services\Actions\OrderAction';
    }
}
