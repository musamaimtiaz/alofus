<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 10-08-2022
 *
 * @modified 01-10-2022
 */

namespace Modules\CMS\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\CMS\Http\Models\Slider;
use Modules\CMS\Http\Resources\SliderResource;

class SliderController extends Controller
{
    /**
     * Coupon List
     *
     * @param  Request  $request
     * @return json $data
     */
    public function index()
    {
        $sliders = Slider::with('slides');

        return $this->response([
            'data' => SliderResource::collection($sliders->get()),
        ]);
    }
}
