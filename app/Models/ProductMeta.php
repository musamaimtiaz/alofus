<?php

namespace App\Models;

use App\Traits\ModelTraits\Cachable;

class ProductMeta extends MetaData
{
    use Cachable;

    protected $table = 'products_meta';

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'key',
        'value',
        'type',
    ];
}
