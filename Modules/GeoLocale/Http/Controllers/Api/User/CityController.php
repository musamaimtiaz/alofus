<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 23-06-2022
 */

namespace Modules\GeoLocale\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\GeoLocale\Repositories\Interfaces\CityRepositoryInterface;
use Modules\GeoLocale\Http\Requests\{
    CityStoreRequest,
    CityUpdateRequest
};

class CityController extends Controller
{
    private $cityRepository;

    public function __construct(CityRepositoryInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    /**
     * Get all cities of a specific countries with country code
     *
     * @param  string  $ciso
     * @return json $response
     */
    public function getCountryCities(Request $request, $ciso)
    {
        $response = $this->cityRepository->getCountryCities($request, $ciso);

        if ($response['status'] == 1) {
            return $this->response(
                [
                    'data' => $response['data'],
                ]
            );
        }

        return $this->notFoundResponse([], __('City not found.'));
    }

    /**
     * Get all cities of a specific country and states with country code and state code
     *
     * @param  string  $ciso
     * @param  string  $siso
     * @return json $response
     */
    public function getStateCities(Request $request, $ciso, $siso)
    {
        $response = $this->cityRepository->getStateCities($request, $ciso, $siso);

        if ($response['status'] == 1) {
            return $this->response(
                [
                    'data' => $response['data'],
                ]
            );
        }

        return $this->notFoundResponse([], __('City not found.'));
    }

    /**
     * Store city
     *
     * @return json $response
     */
    public function store(CityStoreRequest $request)
    {
        $response = $this->cityRepository->store($request->validated());
        if ($response['status'] == 'fail') {
            return $this->errorResponse([], 500, $response['message']);
        }

        return $this->response($response);
    }

    /**
     * Update city
     *
     * @param  int  $id
     * @return json $response
     */
    public function update(CityUpdateRequest $request, $id)
    {
        $response = $this->cityRepository->update($request->validated(), $id);
        if ($response['status'] == 'fail') {
            return $this->errorResponse([], 404, $response['message']);
        }

        return $this->response($response);
    }

    /**
     * delete city
     *
     * @param  int  $id
     * @return json $response
     */
    public function destroy($id)
    {
        $response = $this->cityRepository->destroy($id);
        if ($response['status'] == 'fail') {
            return $this->errorResponse([], 404, $response['message']);
        }

        return $this->response($response);
    }
}
