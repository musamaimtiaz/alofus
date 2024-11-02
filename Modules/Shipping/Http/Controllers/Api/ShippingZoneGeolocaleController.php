<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 28-09-2021
 */

namespace Modules\Shipping\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Shipping\Entities\ShippingZoneGeolocale;
use Modules\Shipping\Http\Resources\ShippingZoneGeolocaleResource;
use Modules\Shipping\Http\Requests\{
    ShippingZoneGeolocaleStoreRequest,
    ShippingZoneGeolocaleUpdateRequest,
};

class ShippingZoneGeolocaleController extends Controller
{
    /**
     * Shipping zone location
     *
     * @return json $data
     */
    public function index(Request $request)
    {
        $configs = $this->initialize([], $request->all());
        $shippingZoneGeolocale = ShippingZoneGeolocale::with(['shippingZone']);

        $keyword = isset($request->keyword) ? trim(xss_clean($request->keyword)) : null;
        if (! empty($keyword)) {
            if (preg_match('/^[1-9]+[0-9]*$/', $keyword)) {
                $shippingZoneGeolocale->where(function ($query) use ($keyword) {
                    $query->where('id', $keyword)
                        ->orWhere('zip', 'LIKE', '%' . $keyword . '%');
                });
            } elseif (strlen($keyword) >= 2) {
                $shippingZoneGeolocale->where(function ($query) use ($keyword) {
                    $query->where('country', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('state', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('city', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('description', 'LIKE', '%' . $keyword . '%');
                });
            }
        }

        return $this->response([
            'data' => ShippingZoneGeolocaleResource::collection($shippingZoneGeolocale->paginate($configs['rows_per_page'])),
            'pagination' => $this->toArray($shippingZoneGeolocale->paginate($configs['rows_per_page'])->appends($request->all())),
        ]);
    }

    /**
     * Store Shipping zone location
     *
     * @return json $response
     */
    public function store(ShippingZoneGeolocaleStoreRequest $request)
    {
        $response = (new ShippingZoneGeolocale())->storeData($request->validated());
        if ($response['status'] == 'success') {
            return $this->successResponse($response);
        }

        return $this->errorResponse([$response]);
    }

    /**
     * Detail Shipping zone location
     *
     * @param  int  $id
     * @return json $response
     */
    public function detail($id)
    {
        $response = $this->checkExistence($id, 'shipping_zone_geolocales');
        $data = ShippingZoneGeolocale::getAll()->where('id', $id)->first();
        if ($response['status'] === true && ! empty($data)) {
            return $this->response(['data' => new ShippingZoneGeolocaleResource($data)]);
        }

        return $this->errorResponse($response);
    }

    /**
     * Update Shipping Zone Location Information
     *
     * @return json $response
     */
    public function update(ShippingZoneGeolocaleUpdateRequest $request, $id)
    {
        $response = $this->checkExistence($id, 'shipping_zone_geolocales');
        if ($response['status'] === true) {
            $response = (new ShippingZoneGeolocale())->updateData($request->validated(), $id);
            if ($response['status'] == 'success') {
                return $this->successResponse($response);
            }
        }

        return $this->errorResponse($response);
    }

    /**
     * Remove Specific Shipping Zone Location
     *
     * @param  Request  $id
     * @return json $data
     */
    public function destroy($id)
    {
        $response = $this->checkExistence($id, 'shipping_zone_geolocales');
        if ($response['status'] === true) {
            $response  = (new ShippingZoneGeolocale())->removeData($id);
            if ($response['status'] == 'success') {
                return $this->successResponse($response);
            }
        }

        return $this->errorResponse($response);
    }
}
