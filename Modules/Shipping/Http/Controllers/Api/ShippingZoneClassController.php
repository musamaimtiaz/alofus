<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 30-09-2021
 */

namespace Modules\Shipping\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Shipping\Entities\ShippingZoneShippingClass;
use Modules\Shipping\Http\Resources\ShippingZoneClassResource;
use Modules\Shipping\Http\Requests\{
    ShippingZoneClassStoreRequest,
    ShippingZoneClassUpdateRequest,
};

class ShippingZoneClassController extends Controller
{
    /**
     * Shipping zone class
     *
     * @return json $data
     */
    public function index(Request $request)
    {
        $configs = $this->initialize([], $request->all());
        $shippingZoneClass = ShippingZoneShippingClass::with(['shippingZone']);

        $keyword = isset($request->keyword) ? trim(xss_clean($request->keyword)) : null;
        if (! empty($keyword)) {
            if (preg_match('/^[1-9]+[0-9]*$/', $keyword)) {
                $shippingZoneClass->where(function ($query) use ($keyword) {
                    $query->where('id', $keyword);
                });
            } elseif (strlen($keyword) >= 2) {
                $shippingZoneClass->where(function ($query) use ($keyword) {
                    $query->where('cost', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('cost_type', 'LIKE', '%' . $keyword . '%');
                });
            }
        }

        return $this->response([
            'data' => ShippingZoneClassResource::collection($shippingZoneClass->paginate($configs['rows_per_page'])),
            'pagination' => $this->toArray($shippingZoneClass->paginate($configs['rows_per_page'])->appends($request->all())),
        ]);
    }

    /**
     * Store Shipping zone class
     *
     * @return json $response
     */
    public function store(ShippingZoneClassStoreRequest $request)
    {
        $response = (new ShippingZoneShippingClass())->storeData($request->validated());
        if ($response['status'] == 'success') {
            return $this->successResponse($response);
        }

        return $this->errorResponse([$response]);
    }

    /**
     * Detail Shipping zone class
     *
     * @param  int  $id
     * @return json $response
     */
    public function detail($id)
    {
        $response = $this->checkExistence($id, 'shipping_zone_shipping_classes');
        $data = ShippingZoneShippingCLass::getAll()->where('id', $id)->first();
        if ($response['status'] === true && ! empty($data)) {
            return $this->response(['data' => new ShippingZoneClassResource($data)]);
        }

        return $this->errorResponse($response);
    }

    /**
     * Update Shipping Zone Class Information
     *
     * @return json $response
     */
    public function update(ShippingZoneClassUpdateRequest $request, $id)
    {
        $response = $this->checkExistence($id, 'shipping_zone_shipping_classes');
        if ($response['status'] === true) {
            $response = (new ShippingZoneShippingClass())->updateData($request->validated(), $id);
            if ($response['status'] == 'success') {
                return $this->successResponse($response);
            }
        }

        return $this->errorResponse($response);
    }

    /**
     * Remove Specific Shipping Zone class
     *
     * @param  Request  $id
     * @return json $response
     */
    public function destroy($id)
    {
        $response = $this->checkExistence($id, 'shipping_zone_shipping_classes');
        if ($response['status'] === true) {
            $response  = (new ShippingZoneShippingClass())->removeData($id);
            if ($response['status'] == 'success') {
                return $this->successResponse($response);
            }
        }

        return $this->errorResponse($response);
    }
}
