<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 20-06-2022
 */

namespace Modules\GeoLocale\Http\Controllers;

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
     * @return json $data
     */
    public function index(Request $request)
    {
        return json_encode($this->stateRepository->index($request));
    }

    /**
     * State Details
     *
     * @param  string  $ciso
     * @param  string  $siso
     * @return json $data
     */
    public function show(Request $request, $ciso, $siso)
    {
        return json_encode($this->stateRepository->show($request, $ciso, $siso));
    }

    /**
     * Get all states of a  specific country by country code
     *
     * @param  string  $ciso
     * @return json $data
     */
    public function getCountryStates(Request $request, $ciso)
    {
        return json_encode($this->stateRepository->getCountryStates($request, $ciso));
    }

    /**
     * Store division
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function store(StateStoreRequest $request)
    {
        $this->setSessionValue($this->stateRepository->store($request->validated()));

        return back();
    }

    /**
     * Update division
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function update(StateUpdateRequest $request, $id)
    {
        $this->setSessionValue($this->stateRepository->update($request->validated(), $id));

        return back();
    }

    /**
     * delete
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $this->setSessionValue($this->stateRepository->destroy($id));

        return back();
    }

    /**
     * search state
     *
     * @param  string  $stateKeyword
     * @return \Illuminate\Routing\Redirector
     */
    public function search($stateKeyword, $countryCode = null)
    {
        return $this->stateRepository->search($stateKeyword, $countryCode);

    }
}
