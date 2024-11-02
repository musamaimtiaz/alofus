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
use Modules\Shipping\Entities\ShippingZone;
use Modules\Shipping\Http\Resources\ShippingZoneResource;
use Modules\Shipping\Http\Requests\{
    ShippingZoneStoreRequest, ShippingZoneUpdateRequest
};

class ShippingZoneController extends Controller
{
    /**
     * Shipping zone List
     *
     * @return json $data
     */
    public function index(Request $request)
    {
        $configs = $this->initialize([], $request->all());
        $shippingZone = ShippingZone::select('id', 'name');

        $keyword = isset($request->keyword) ? trim(xss_clean($request->keyword)) : null;
        if (! empty($keyword)) {
            if (preg_match('/^[1-9]+[0-9]*$/', $keyword)) {
                $shippingZone->where(function ($query) use ($keyword) {
                    $query->where('id', $keyword);
                });
            } elseif (strlen($keyword) >= 2) {
                $shippingZone->where(function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%' . $keyword . '%');
                });
            }
        }

        return $this->response([
            'data' => ShippingZoneResource::collection($shippingZone->paginate($configs['rows_per_page'])),
            'pagination' => $this->toArray($shippingZone->paginate($configs['rows_per_page'])->appends($request->all())),
        ]);
    }

    /**
     * Store Shipping Zone
     *
     * @return json $response
     */
    public function store(ShippingZoneStoreRequest $request)
    {
        $response = (new ShippingZone())->storeData($request->validated());
        if ($response['status'] == 'success') {
            return $this->successResponse($response);
        }

        return $this->errorResponse([$response]);
    }

    /**
     * Detail Shipping Zone
     *
     * @param  int  $id
     * @return json $response
     */
    public function detail($id)
    {
        $response = $this->checkExistence($id, 'shipping_zones');
        $data = ShippingZone::getAll()->where('id', $id)->first();
        if ($response['status'] === true && ! empty($data)) {
            return $this->response(['data' => new ShippingZoneResource($data)]);
        }

        return $this->errorResponse($response);
    }

    /**
     * Update Shipping Zone Information
     *
     * @param  int  $id
     * @return json $response
     */
    public function update(ShippingZoneUpdateRequest $request, $id)
    {
        $response = $this->checkExistence($id, 'shipping_zones');
        if ($response['status'] === true) {
            $response = (new ShippingZone())->updateData($request->validated(), $id);
            if ($response['status'] == 'success') {
                return $this->successResponse($response);
            }
        }

        return $this->errorResponse($response);
    }

    /**
     * Remove Specific Shipping Zone
     *
     * @param  Request  $id
     * @return json $response
     */
    public function destroy($id)
    {
        $response = $this->checkExistence($id, 'shipping_zones');
        if ($response['status'] === true) {
            $response  = (new ShippingZone())->removeData($id);
            if ($response['status'] == 'success') {
                return $this->successResponse($response);
            }
        }

        return $this->errorResponse($response);
    }
}
