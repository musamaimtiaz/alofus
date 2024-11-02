<?php

namespace Modules\GeoLocale\Repositories;

use Illuminate\Http\Request;
use Modules\GeoLocale\Entities\Country;
use Modules\GeoLocale\Http\Resources\{
    CountryResource,
    CountryDetailResource
};
use Modules\GeoLocale\Repositories\Interfaces\CountryRepositoryInterface;

class CountryRepository implements CountryRepositoryInterface
{
    /**
     * Country List
     *
     * @param  Request  $request
     * @return json $data
     */
    public function index($request)
    {
        $countries = Country::select('id', 'name', 'code', 'currency_code', 'currency_name', 'currency_symbol')->orderBy('name')->get();
        if ($request->route()->getPrefix() == 'api') {
            return [
                'data' => CountryResource::collection($countries),
            ];
        }

        return $countries;
    }

    /**
     * Country details
     *
     * @param  object  $request
     * @param  string  $ciso
     * @return json $data
     */
    public function show($request, $ciso)
    {
        $response = ['status' => 0];
        $country = Country::where('code', $ciso)->orWhere('id', $ciso)->first();
        if (! empty($country)) {
            $response = [
                'status' => 1,
                'data' => new CountryDetailResource($country),
            ];
        }

        if ($request->route()->getPrefix() == 'api') {
            return $response;
        }

        $response['data'] = $country;

        return $response;
    }

    /**
     * Store Country
     *
     * @param  CountryStoreRequest  $request
     * @return json $response
     */
    public function store($data)
    {
        $response = ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];

        if ((new Country())->insert($data)) {
            $response = ['status' => 'success', 'message' => __('Country has been successfully saved.')];
        }

        return $response;
    }

    /**
     * Update Country
     *
     * @param  CountryUpdateRequest  $request
     * @param  int  $id
     * @return json $response
     */
    public function update($data, $id)
    {
        $response = ['status' => 'fail', 'message' => __('Country not found.')];
        $result = Country::where('id', $id);
        if ($result->exists()) {
            $result->update($data);
            $response = ['status' => 'success', 'message' => __('The :x has been successfully saved.', ['x' => __('Country')])];
        }

        return $response;
    }

    /**
     * delete country
     *
     * @param  int  $id
     * @return json $response
     */
    public function destroy($id = null)
    {
        $response = ['status' => 'fail', 'message' => __('Country not found.')];
        $record = Country::find($id);
        if (! empty($record)) {
            $record->delete();
            $response = ['status' => 'success', 'message' =>  __('The :x has been successfully deleted.', ['x' => __('Country')])];
        }

        return $response;
    }

    /**
     * search country
     *
     * @param  string  $keyword
     * @return json $response
     */
    public function search($keyword = null)
    {
        return Country::select('id', 'name', 'code')->where('code', 'like', $keyword . '%')->orWhere('name', 'like', $keyword . '%')->orderBy('name')->get();

    }
}
