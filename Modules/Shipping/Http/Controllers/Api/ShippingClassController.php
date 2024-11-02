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
use Modules\Shipping\Entities\ShippingClass;
use Modules\Shipping\Http\Resources\ShippingClassResource;
use Modules\Shipping\Http\Requests\{
    ShippingClassStoreRequest,
    ShippingClassUpdateRequest,
};

class ShippingClassController extends Controller
{
    /**
     * Shipping Class List
     *
     * @return json $data
     */
    public function index(Request $request)
    {
        $configs = $this->initialize([], $request->all());
        $shippingClass = ShippingClass::select('id', 'name', 'slug', 'description');

        $keyword = isset($request->keyword) ? trim(xss_clean($request->keyword)) : null;
        if (! empty($keyword)) {
            if (preg_match('/^[1-9]+[0-9]*$/', $keyword)) {
                $shippingClass->where(function ($query) use ($keyword) {
                    $query->where('id', $keyword);
                });
            } elseif (strlen($keyword) >= 2) {
                $shippingClass->where(function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('slug', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('description', 'LIKE', '%' . $keyword . '%');
                });
            }
        }

        return $this->response([
            'data' => ShippingClassResource::collection($shippingClass->paginate($configs['rows_per_page'])),
            'pagination' => $this->toArray($shippingClass->paginate($configs['rows_per_page'])->appends($request->all())),
        ]);
    }

    /**
     * Store Shipping CLass
     *
     * @return json $response
     */
    public function store(ShippingClassStoreRequest $request)
    {
        $response = (new ShippingClass())->storeData($request->validated());
        if ($response['status'] == 'success') {
            return $this->successResponse($response);
        }

        return $this->errorResponse([$response]);
    }

    /**
     * Detail Shipping Class
     *
     * @param  int  $id
     * @return json $response
     */
    public function detail($id)
    {
        $response = $this->checkExistence($id, 'shipping_classes');
        $data = ShippingClass::getAll()->where('id', $id)->first();
        if ($response['status'] === true && ! empty($data)) {
            return $this->response(['data' => new ShippingClassResource($data)]);
        }

        return $this->errorResponse($response);
    }

    /**
     * Update Shipping Class Information
     *
     * @return json $response
     */
    public function update(ShippingClassUpdateRequest $request, $id)
    {
        $response = $this->checkExistence($id, 'shipping_classes');
        if ($response['status'] === true) {
            $response = (new ShippingClass())->updateData($request->validated(), $id);
            if ($response['status'] == 'success') {
                return $this->successResponse($response);
            }
        }

        return $this->errorResponse($response);
    }

    /**
     * Remove Specific Shipping Class
     *
     * @param  int  $id
     * @return json $data
     */
    public function destroy($id)
    {
        $response = $this->checkExistence($id, 'shipping_zones');
        if ($response['status'] === true) {
            $response  = (new ShippingClass())->removeData($id);
            if ($response['status'] == 'success') {
                return $this->successResponse($response);
            }
        }

        return $this->errorResponse($response);
    }
}
