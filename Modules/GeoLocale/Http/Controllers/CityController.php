<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 23-06-2022
 */

namespace Modules\GeoLocale\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\GeoLocale\Repositories\Interfaces\CityRepositoryInterface;
use Modules\GeoLocale\Http\Requests\{
    CityStoreRequest, CityUpdateRequest
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
     * @return \Illuminate\Routing\Redirector
     */
    public function getCountryCities(Request $request, $ciso)
    {
        return json_encode($this->cityRepository->getCountryCities($request, $ciso));
    }

    /**
     * Get all cities of a specific country and states with country code and state code
     *
     * @param  string  $ciso
     * @param  string  $siso
     * @return \Illuminate\Routing\Redirector
     */
    public function getStateCities(Request $request, $ciso, $siso)
    {
        return json_encode($this->cityRepository->getStateCities($request, $ciso, $siso));
    }

    /**
     * Store city
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function store(CityStoreRequest $request)
    {
        $this->setSessionValue($this->cityRepository->store($request->validated()));

        return back();
    }

    /**
     * Update city
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function update(CityUpdateRequest $request, $id)
    {
        $this->setSessionValue($this->cityRepository->update($request->validated(), $id));

        return back();
    }

    /**
     * delete city
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $this->setSessionValue($this->cityRepository->destroy($id));

        return back();
    }
}
