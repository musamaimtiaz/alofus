<?php

namespace Modules\GeoLocale\Repositories\Interfaces;

interface CityRepositoryInterface
{
    /**
     * Get all cities of a specific countries with country code
     *
     * @param  string  $ciso
     * @param  object  $request
     * @return json $response
     */
    public function getCountryCities($request, $ciso);

    /**
     * Get all cities of a specific country and states with country code and state code
     *
     * @param  object  $request
     * @param  string  $ciso
     * @param  string  $siso
     * @return json $response
     */
    public function getStateCities($request, $ciso, $siso);

    /**
     * Store city
     *
     * @param  CityStoreRequest  $request
     * @return json $response
     */
    public function store($data);

    /**
     * Update city
     *
     * @param  CityUpdateRequest  $request
     * @param  int  $id
     * @return json $response
     */
    public function update($data, $id);

    /**
     * delete city
     *
     * @param  int  $id
     * @return json $response
     */
    public function destroy($id);
}
