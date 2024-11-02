<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 24-11-2021
 */

namespace App\Cart\Facades;

use Illuminate\Support\Facades\Facade;

class Cart extends Facade
{
    /**
     * Cart alias
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Cart';
    }
}
