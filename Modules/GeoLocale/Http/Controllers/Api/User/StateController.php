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
use Modules\GeoLocale\Repositories\Interfaces\StateRepositoryInterface;
use Modules\GeoLocale\Http\Requests\{
    StateStoreRequest, StateUpdateRequest
};

class StateController extends Controller
{
    private $stateRepository;

    public function __construct(StateRepositoryInterface $stateRepository)
    {
        $this->stateRepository = $stateRepository;
    }

    /**
     * Get all states
     *
     * @return json $response
     */
    public function index(Request $request)
    {
        $response = $this->stateRepository->index($request);

        return $this->response(
            [
                'data' => $response['data'],
            ]
        );
    }

    /**
     * State details by country code and state code
     *
     * @param  string  $ciso
     * @param  string  $siso
     * @return json $response
     */
    public function show(Request $request, $ciso, $siso)
    {
        $response = $this->stateRepository->show($request, $ciso, $siso);
        if ($response['status'] == 1) {
            return $this->response($response['data']);
        }

        return $this->notFoundResponse([], __('State not found.'));
    }

    /**
     * Get all states of a  specific country by country code
     *
     * @param  string  $ciso
     * @return json $response
     */
    public function getCountryStates(Request $request, $ciso)
    {
        $response = $this->stateRepository->getCountryStates($request, $ciso);

        if ($response['status'] == 1) {
            return $this->response(
                [
                    'data' => $response['data'],
                ]
            );
        }

        return $this->notFoundResponse([], __('State not found.'));
    }

    /**
     * Store State
     *
     * @return json $response
     */
    public function store(StateStoreRequest $request)
    {
        $response = $this->stateRepository->store($request->validated());
        if ($response['status'] == 'fail') {
            return $this->errorResponse([], 500, $response['message']);
        }

        return $this->response($response);
    }

    /**
     * Update State
     *
     * @param  int  $id
     * @return json $response
     */
    public function update(StateUpdateRequest $request, $id)
    {
        $response = $this->stateRepository->update($request->validated(), $id);
        if ($response['status'] == 'fail') {
            return $this->errorResponse([], 404, $response['message']);
        }

        return $this->response($response);
    }

    /**
     * delete state
     *
     * @param  int  $id
     * @return json $response
     */
    public function destroy($id)
    {
        $response = $this->stateRepository->destroy($id);
        if ($response['status'] == 'fail') {
            return $this->errorResponse([], 404, $response['message']);
        }

        return $this->response($response);
    }
}
