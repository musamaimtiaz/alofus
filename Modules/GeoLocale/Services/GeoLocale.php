<?php

namespace Modules\GeoLocale\Services;

use Modules\GeoLocale\Entities\{
    City, Continent, Country, Division
};

/**
 * GeoLocale
 */
class GeoLocale
{
    public static function Continents()
    {
        return Continent::orderBy('name', 'asc')->get();
    }

    public static function Countries()
    {
        return Country::orderBy('name', 'asc')->get();
    }

    public static function getContinentByCode($code)
    {
        return Continent::getByCode($code);
    }

    public static function getCountryByCode($code)
    {
        return Country::getByCode($code);
    }

    public static function getByCode($code)
    {
        $code = strtolower($code);
        if (strpos($code, '-')) {
            [$country_code, $code] = explode('-', $code);
            $country = self::getCountryByCode($country_code);
        } else {
            return self::getCountryByCode($code);
        }
        if ($country->has_division) {
            return Division::where([
                ['country_id', $country->id],
                ['code', $code],
            ])->first();
        }

        return City::where([
            ['country_id', $country->id],
            ['code', $code],
        ])->first();

        throw new \Modules\GeoLocale\Exceptions\InvalidCodeException('Code is invalid');
    }
}
