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
use Modules\GeoLocale\Repositories\Interfaces\CountryRepositoryInterface;
use Modules\GeoLocale\Http\Requests\{
    CountryStoreRequest, CountryUpdateRequest
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
     * @return json $response
     */
    public function index(Request $request)
    {
        return json_encode($this->countryRepository->index($request));
    }

    /**
     * Detail Country
     *
     * @param  string  $ciso
     * @return json $response
     */
    public function show(Request $request, $ciso)
    {
        return json_encode($this->countryRepository->show($request, $ciso));
    }

    /**
     * Store Country
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function store(CountryStoreRequest $request)
    {
        $this->setSessionValue($this->countryRepository->store($request->validated()));

        return back();
    }

    /**
     * Update Country
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function update(CountryUpdateRequest $request, $id)
    {
        $this->setSessionValue($this->countryRepository->update($request->validated(), $id));

        return back();
    }

    /**
     * delete country
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $this->setSessionValue($this->countryRepository->destroy($id));

        return back();
    }

    /**
     * search country
     *
     * @param string keyword
     * @return \Illuminate\Routing\Redirector
     */
    public function search($keyword)
    {
        return $this->countryRepository->search($keyword);

    }
}
