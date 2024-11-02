<?php

namespace App\Models;

class Location extends Model
{
    /**
     * Relation with StockManagement model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stockManagement()
    {
        return $this->hasMany('App\Models\StockManagement', 'location_id', 'id');
    }
}
