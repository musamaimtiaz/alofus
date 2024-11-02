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
use Modules\Shipping\Entities\ShippingZoneShippingMethod;
use Modules\Shipping\Http\Resources\ShippingZoneMethodResource;
use Modules\Shipping\Http\Requests\{
    ShippingZoneMethodStoreRequest,
    ShippingZoneMethodUpdateRequest,
};

class ShippingZoneMethodController extends Controller
{
    /**
     * Shipping zone method
     *
     * @return json $data
     */
    public function index(Request $request)
    {
        $configs = $this->initialize([], $request->all());
        $shippingZoneMethod = ShippingZoneShippingMethod::with(['shippingZone', 'shippingMethod']);

        $keyword = isset($request->keyword) ? trim(xss_clean($request->keyword)) : null;
        if (! empty($keyword)) {
            if (preg_match('/^[1-9]+[0-9]*$/', $keyword)) {
                $shippingZoneMethod->where(function ($query) use ($keyword) {
                    $query->where('id', $keyword);
                });
            } elseif (strlen($keyword) >= 2) {
                $shippingZoneMethod->where(function ($query) use ($keyword) {
                    $query->where('method_title', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('tax_status', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('cost', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('cost_type', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('calculation_type', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('requirements', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('status', 'LIKE', '%' . $keyword . '%');
                });
            }
        }

        return $this->response([
            'data' => ShippingZoneMethodResource::collection($shippingZoneMethod->paginate($configs['rows_per_page'])),
            'pagination' => $this->toArray($shippingZoneMethod->paginate($configs['rows_per_page'])->appends($request->all())),
        ]);
    }

    /**
     * Store Shipping zone method
     *
     * @return json $response
     */
    public function store(ShippingZoneMethodStoreRequest $request)
    {
        $response = (new ShippingZoneShippingMethod())->storeData($request->validated());
        if ($response['status'] == 'success') {
            return $this->successResponse($response);
        }

        return $this->errorResponse([$response]);
    }

    /**
     * Detail Shipping zone method
     *
     * @param  int  $id
     * @return json $response
     */
    public function detail($id)
    {
        $response = $this->checkExistence($id, 'shipping_zone_shipping_methods');
        $data = ShippingZoneShippingMethod::getAll()->where('id', $id)->first();
        if ($response['status'] === true && ! empty($data)) {
            return $this->response(['data' => new ShippingZoneMethodResource($data)]);
        }

        return $this->errorResponse($response);
    }

    /**
     * Update Shipping Zone Method Information
     *
     * @return json $response
     */
    public function update(ShippingZoneMethodUpdateRequest $request, $id)
    {
        $response = $this->checkExistence($id, 'shipping_zone_shipping_methods');
        if ($response['status'] === true) {
            $response = (new ShippingZoneShippingMethod())->updateData($request->validated(), $id);
            if ($response['status'] == 'success') {
                return $this->successResponse($response);
            }
        }

        return $this->errorResponse($response);
    }

    /**
     * Remove Specific Shipping Zone Method
     *
     * @param  Request  $id
     * @return json $response
     */
    public function destroy($id)
    {
        $response = $this->checkExistence($id, 'shipping_zone_shipping_methods');
        if ($response['status'] === true) {
            $response  = (new ShippingZoneShippingMethod())->removeData($id);
            if ($response['status'] == 'success') {
                return $this->successResponse($response);
            }
        }

        return $this->errorResponse($response);
    }
}
