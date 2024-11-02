<?php

namespace Modules\GeoLocale\Repositories\Interfaces;

interface StateRepositoryInterface
{
    /**
     * Get all states
     *
     * @param  object  $request
     * @return json $response
     */
    public function index($request);

    /**
     * State details by country code and state code
     *
     * @param  object  $request
     * @param  string  $ciso
     * @param  string  $siso
     * @return json $response
     */
    public function show($request, $ciso, $siso);

    /**
     * Get all states of a  specific country by country code
     *
     * @param  object  $request
     * @param  string  $ciso
     * @return json $response
     */
    public function getCountryStates($request, $ciso);

    /**
     * Store State
     *
     * @param  StateStoreRequest  $request
     * @return json $response
     */
    public function store($data);

    /**
     * Update State
     *
     * @param  StateUpdateRequest  $request
     * @param  int  $id
     * @return json $response
     */
    public function update($data, $id);

    /**
     * delete state
     *
     * @param  int  $id
     * @return json $response
     */
    public function destroy($id);

    /**
     * search state
     *
     * @param  string  $stateKeyword
     * @return \Illuminate\Routing\Redirector
     */
    public function search($stateKeyword, $countryCode);
}
