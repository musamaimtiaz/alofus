<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 20-06-2022
 */

namespace Modules\GeoLocale\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\GeoLocale\Entities\Country;

class GeoLocaleController extends Controller
{
    /**
     * Country List
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('geolocale::index');
    }
}
