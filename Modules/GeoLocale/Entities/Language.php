<?php

namespace Modules\GeoLocale\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\GeoLocale\Traits\GeoLocaleTrait;

/**
 * Language.
 */
class Language extends Model
{
    use GeoLocaleTrait;

    /**
     * The database table doesn't use 'created_at' and 'updated_at' so we disable it from Inserts/Updates.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'geolocale_languages';
}
