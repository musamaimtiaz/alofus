<?php

namespace Modules\GeoLocale\Repositories;

use Modules\GeoLocale\Http\Resources\CountryCityResource;
use Modules\GeoLocale\Repositories\Interfaces\CityRepositoryInterface;
use Modules\GeoLocale\Entities\{
    City, Country, Division
};

class CityRepository implements CityRepositoryInterface
{
    /**
     * Get all cities of a specific countries with country code
     *
     * @param  object  $request
     * @param  string  $ciso
     * @return json $response
     */
    public function getCountryCities($request, $ciso)
    {
        $response = ['status' => 0];
        $country = Country::where('code', $ciso)->orWhere('id', $ciso)->with('cities')->first();

        if (! empty($country)) {
            $response = [
                'status' => 1,
                'data' => CountryCityResource::collection($country->cities()->get()),
            ];
        }

        if ($request->route()->getPrefix() == 'api') {
            return $response;
        }

        $response['data'] = $country->cities()->get();

        return $response;
    }

    /**
     * Get all cities of a specific country and states with country code and state code
     *
     * @param  object  $request
     * @param  string  $ciso
     * @param  string  $siso
     * @return json $response
     */
    public function getStateCities($request, $ciso, $siso)
    {
        $response = ['status' => 0];
        $countryId = Country::select('id')->where('code', $ciso);

        if (! $countryId->exists()) {
            $countryId = $countryId->orWhere('id', $ciso);
        }

        $countryId = $countryId->first()->id;
        $divisionId = Division::select('id')->where('country_id', $countryId ?? 0)->where('code', $siso);

        if (! $divisionId->exists()) {
            $divisionId = $divisionId->orWhere('id', $siso);
        }

        $divisionId = $divisionId->first()->id;
        $cities = City::where('country_id', $countryId ?? 0)->where('division_id', $divisionId ?? 0);

        if (! empty($cities)) {
            $response = ['status' => 1];
        }

        if ($request->route()->getPrefix() == 'api') {
            $response['data'] = CountryCityResource::collection($cities->get());

            return $response;
        }

        $response['data'] = $cities->get();

        return $response;
    }

    /**
     * Store city
     *
     * @param  CityStoreRequest  $request
     * @return json $response
     */
    public function store($data)
    {
        $response = ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];

        if ((new City())->insert($data)) {
            $response = ['status' => 'success', 'message' => __('City has been successfully saved.')];
        }

        return $response;
    }

    /**
     * Update city
     *
     * @param  CityUpdateRequest  $request
     * @param  int  $id
     * @return json $response
     */
    public function update($data, $id)
    {
        $response = ['status' => 'fail', 'message' => __('City not found.')];
        $result = City::where('id', $id);
        if ($result->exists()) {
            $result->update($data);
            $response = ['status' => 'success', 'message' => __('The :x has been successfully saved.', ['x' => __('City')])];
        }

        return $response;
    }

    /**
     * delete city
     *
     * @param  int  $id
     * @return json $response
     */
    public function destroy($id = null)
    {
        $response = ['status' => 'fail', 'message' => __('City not found.')];
        $record = City::find($id);
        if (! empty($record)) {
            $record->delete();
            $response = ['status' => 'success', 'message' =>  __('The :x has been successfully deleted.', ['x' => __('City')])];
        }

        return $response;
    }
}
