<?php

namespace Modules\GeoLocale\Repositories\Interfaces;

interface CountryRepositoryInterface
{
    /**
     * Country List
     *
     * @return json $data
     */
    public function index($request);

    /**
     * Country details
     *
     * @param  object  $request
     * @param  string  $ciso
     * @return json $data
     */
    public function show($request, $ciso);

    /**
     * Store Country
     *
     * @param  CountryStoreRequest  $request
     * @return json $response
     */
    public function store($data);

    /**
     * Update Country
     *
     * @param  CountryUpdateRequest  $request
     * @param  int  $id
     * @return json $response
     */
    public function update($data, $id);

    /**
     * delete country
     *
     * @param  int  $id
     * @return json $response
     */
    public function destroy($id);

    /**
     * search country
     *
     * @param string keyword
     * @return json $response
     */
    public function search($keyword);
}
