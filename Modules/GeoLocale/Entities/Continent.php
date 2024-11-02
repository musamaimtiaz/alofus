<?php

namespace Modules\GeoLocale\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\GeoLocale\Traits\GeoLocaleTrait;

/**
 * Continent
 */
class Continent extends Model
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
    protected $table = 'geolocale_continents';

    /**
     * append names
     *
     * @var array
     */
    protected $appends = ['local_name', 'local_full_name', 'local_alias', 'local_abbr'];

    /**
     * Relation with Country model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function countries()
    {
        return $this->hasMany(Country::class);
    }

    /**
     * Children
     *
     * @return Collection
     */
    public function children()
    {
        return $this->countries;
    }

    /**
     * Parent
     *
     * @return Collection
     */
    public function parent()
    {
        return null;
    }

    /**
     * return Continent locales
     *
     * @return void
     */
    public function locales()
    {
        return $this->hasMany(ContinentLocale::class);
    }

    /**
     * Get Continent by name
     *
     * @param  string  $name
     * @return collection
     */
    public static function getByName($name)
    {
        $localized = ContinentLocale::where('name', $name)->first();
        if (is_null($localized)) {
            return $localized;
        }

        return $localized->Continent;
    }

    /**
     * Search Continent by name
     *
     * @param  string  $names
     * @param  mixed  $name
     * @return collection
     */
    public static function searchByName($name)
    {
        return ContinentLocale::where('name', 'like', '%' . $name . '%')
            ->get()->map(function ($item) {
                return $item->Continent;
            });
    }
}
