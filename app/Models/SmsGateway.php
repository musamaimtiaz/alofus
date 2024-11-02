<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 14-01-2024
 */

namespace App\Models;

class SmsGateway extends Model
{
    /**
     * timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = ['name', 'alias', 'data', 'status', 'instruction'];

    /**
     * Cast
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];
}
