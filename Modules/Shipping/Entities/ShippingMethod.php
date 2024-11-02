<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 19-07-2022
 */

namespace Modules\Shipping\Entities;

use App\Models\Model;

class ShippingMethod extends Model
{
    /**
     * timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Foreign key with ShippingZoneShippingMethod model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shippingZoneShippingMethods()
    {
        return $this->hasMany(ShippingZoneShippingMethod::class);
    }
}
