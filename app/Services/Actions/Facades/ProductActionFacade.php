<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md Abdur Rahaman Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 06-06-2022
 */

namespace App\Services\Actions\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed execute(String $action, Request $request) Execute the requested action
 */
class ProductActionFacade extends Facade
{
    /**
     * Cart alias
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return '\App\Services\Actions\ProductAction';
    }
}
