<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md Abdur Rahaman Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 07-08-2022
 */

namespace App\Services\Actions;

class VendorProductAction extends ProductAction
{
    /**
     * Update assigned routes and view file names
     *
     * @return void
     */
    protected function updateRouteAndViews()
    {
        $this->routeAndViews['product.edit'] = 'vendor.product.edit';
    }
}
