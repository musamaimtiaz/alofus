<?php

namespace Modules\GeoLocale\Repositories;

use Modules\GeoLocale\Entities\{
    Country, Division
};
use Modules\GeoLocale\Http\Resources\{
    CountryStateResource,
    StateDetailResource,
    StateResource
};
use Modules\GeoLocale\Repositories\Interfaces\StateRepositoryInterface;

class StateRepository implements StateRepositoryInterface
{
    /**
     * Get all states
     *
     * @param  object  $request
     * @return json $response
     */
    public function index($request)
    {
        $states = Division::select('id', 'name', 'country_id', 'code')->with('country')->get();

        if ($request->route()->getPrefix() == 'api') {
            return [
                'data' => StateResource::collection($states),
            ];
        }

        return $states;
    }

    /**
     * State details by country code and state code
     *
     * @param  object  $request
     * @param  string  $ciso
     * @param  string  $siso
     * @return json $response
     */
    public function show($request, $ciso, $siso)
    {
        $response = ['status' => 0];
        $country_id = Country::select('id')->where('code', $ciso)->orWhere('id', $ciso)->first()->id;
        $division = Division::where('country_id', $country_id)->where('code', $siso)->orWhere('id', $siso)->with('country')->first();
        if (! empty($division)) {
            $response = [
                'status' => 1,
                'data' => new StateDetailResource($division),
            ];
        }

        if ($request->route()->getPrefix() == 'api') {
            return $response;
        }

        $response['data'] = $division;

        return $response;
    }

    /**
     * Get all states of a  specific country by country code
     *
     * @param  object  $request
     * @param  string  $ciso
     * @return json $response
     */
    public function getCountryStates($request, $ciso)
    {
        $response = ['status' => 0];
        $country = Country::where('code', $ciso)->orWhere('id', $ciso)->with('divisions')->first();

        if (empty($country)) {
            return $response;
        }

        $response = [
            'status' => 1,
            'data' => CountryStateResource::collection($country->divisions()->get()),
        ];

        if ($request->route()->getPrefix() == 'api') {
            return $response;
        }

        $response['data'] = $country->divisions()->get();

        return $response;
    }

    /**
     * Store State
     *
     * @param  StateStoreRequest  $request
     * @return json $response
     */
    public function store($data)
    {
        $response = ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];

        if ((new Division())->insert($data)) {
            $response = ['status' => 'success', 'message' => __('State has been successfully saved.')];
        }

        return $response;
    }

    /**
     * Update State
     *
     * @param  StateUpdateRequest  $request
     * @param  int  $id
     * @return json $response
     */
    public function update($data, $id)
    {
        $response = ['status' => 'fail', 'message' => __('State not found.')];
        $result = Division::where('id', $id);
        if ($result->exists()) {
            $result->update($data);
            $response = ['status' => 'success', 'message' => __('The :x has been successfully saved.', ['x' => __('State')])];
        }

        return $response;
    }

    /**
     * delete state
     *
     * @param  int  $id
     * @return json $response
     */
    public function destroy($id = null)
    {
        $response = ['status' => 'fail', 'message' => __('State not found.')];
        $record = Division::find($id);
        if (! empty($record)) {
            $record->delete();
            $response = ['status' => 'success', 'message' =>  __('The :x has been successfully deleted.', ['x' => __('State')])];
        }

        return $response;
    }

    /**
     * search state
     *
     * @param  string  $stateKeyword
     * @return \Illuminate\Routing\Redirector
     */
    public function search($stateKeyword, $countryCode)
    {
        $query = Division::query()->select('id', 'name', 'code');

        if (! is_null($countryCode)) {
            $country = Country::select('id')->firstWhere('code', $countryCode);
            $query->where('country_id', $country->id);
        }

        return $query->where('name', 'like', $stateKeyword . '%')->orderBy('name')->get();
    }
}
