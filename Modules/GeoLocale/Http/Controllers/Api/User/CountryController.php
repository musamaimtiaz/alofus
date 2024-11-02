<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 23-06-2022
 */

namespace Modules\GeoLocale\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\GeoLocale\Repositories\Interfaces\CountryRepositoryInterface;
use Modules\GeoLocale\Http\Requests\{
    CountryStoreRequest,
    CountryUpdateRequest
};

class CountryController extends Controller
{
    private $countryRepository;

    public function __construct(CountryRepositoryInterface $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    /**
     * Country List
     *
     * @return json $data
     */
    public function index(Request $request)
    {
        $response = $this->countryRepository->index($request);

        return $this->response(
            [
                'data' => $response['data'],
            ]
        );
    }

    /**
     * Country details
     *
     * @param  string  $ciso
     * @return json $data
     */
    public function show(Request $request, $ciso)
    {
        $response = $this->countryRepository->show($request, $ciso);
        if ($response['status'] == 1) {
            return $this->response($response['data']);
        }

        return $this->notFoundResponse([], __('Country not found.'));

    }

    /**
     * Store Country
     *
     * @return json $response
     */
    public function store(CountryStoreRequest $request)
    {
        $response = $this->countryRepository->store($request->validated());
        if ($response['status'] == 'fail') {
            return $this->errorResponse([], 500, $response['message']);
        }

        return $this->response($response);
    }

    /**
     * Update Country
     *
     * @param  int  $id
     * @return json $response
     */
    public function update(CountryUpdateRequest $request, $id)
    {
        $response = $this->countryRepository->update($request->validated(), $id);
        if ($response['status'] == 'fail') {
            return $this->errorResponse([], 404, $response['message']);
        }

        return $this->response($response);
    }

    /**
     * delete country
     *
     * @param  int  $id
     * @return json $response
     */
    public function destroy($id)
    {
        $response = $this->countryRepository->destroy($id);
        if ($response['status'] == 'fail') {
            return $this->errorResponse([], 404, $response['message']);
        }

        return $this->response($response);
    }
}
