<?php

namespace Modules\GeoLocale\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\GeoLocale\Traits\GeoLocaleTrait;

/**
 * Division
 */
class Division extends Model
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
    protected $table = 'geolocale_divisions';

    /**
     * append names
     *
     * @var array
     */
    protected $appends = ['local_name', 'local_full_name', 'local_alias', 'local_abbr'];

    /**
     * Relation with Country model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Relation with City model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities()
    {
        return $this->hasMany(City::class);
    }

    /**
     * Get next level
     *
     * @return City
     */
    public function children()
    {
        return $this->cities;
    }

    /**
     * Get up level
     *
     * @return Country
     */
    public function parent()
    {
        return $this->country;
    }

    /**
     * Relation with DivisionLocale model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locales()
    {
        return $this->hasMany(DivisionLocale::class);
    }

    /**
     * Get Division by name
     *
     * @param  string  $name
     * @return collection
     */
    public static function getByName($name)
    {
        $localized = DivisionLocale::where('name', $name)->first();
        if (is_null($localized)) {
            return $localized;
        }

        return $localized->region;
    }

    /**
     * Search Division by name
     *
     * @param  string  $name
     * @return collection
     */
    public static function searchByName($name)
    {
        return DivisionLocale::where('name', 'like', '%' . $name . '%')
            ->get()->map(function ($item) {
                return $item->division;
            });
    }

    /**
     * Get state name by country and state code
     *
     * @param  string  $countryCode
     * @param  string  $stateCode
     * @return string
     */
    public static function getStateNameByCountryStateCode($countryCode, $stateCode)
    {
        $country = Country::firstWhere('code', $countryCode);

        if (is_null($country)) {
            return $stateCode;
        }

        $state = parent::firstWhere(['country_id' => $country->id, 'code' => $stateCode]);

        if (is_null($state)) {
            return $stateCode;
        }

        return $state->name;
    }
}
