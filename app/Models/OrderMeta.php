<?php

namespace App\Models;

use App\Traits\ModelTraits\Cachable;

class OrderMeta extends MetaData
{
    use Cachable;

    protected $table = 'orders_meta';

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'type',
        'key',
        'value',
    ];

    /**
     * Foreign key with Vendor model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
}
