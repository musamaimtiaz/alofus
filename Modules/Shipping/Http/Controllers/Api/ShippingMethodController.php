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
use Modules\Shipping\Entities\ShippingMethod;
use Modules\Shipping\Http\Resources\ShippingMethodResource;

class ShippingMethodController extends Controller
{
    /**
     * Shipping Method List
     *
     * @return json $data
     */
    public function index(Request $request)
    {
        $configs = $this->initialize([], $request->all());
        $shippingMethod = ShippingMethod::select('id', 'name', 'status', 'description');

        $keyword = isset($request->keyword) ? trim(xss_clean($request->keyword)) : null;
        if (! empty($keyword)) {
            if (preg_match('/^[1-9]+[0-9]*$/', $keyword)) {
                $shippingMethod->where(function ($query) use ($keyword) {
                    $query->where('id', $keyword);
                });
            } elseif (strlen($keyword) >= 2) {
                $shippingMethod->where(function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('status', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('description', 'LIKE', '%' . $keyword . '%');
                });
            }
        }

        return $this->response([
            'data' => ShippingMethodResource::collection($shippingMethod->paginate($configs['rows_per_page'])),
            'pagination' => $this->toArray($shippingMethod->paginate($configs['rows_per_page'])->appends($request->all())),
        ]);
    }

    /**
     * Detail Shipping Method
     *
     * @param  int  $id
     * @return json $response
     */
    public function detail($id)
    {
        $response = $this->checkExistence($id, 'shipping_methods');
        $data = ShippingMethod::getAll()->where('id', $id)->first();
        if ($response['status'] === true && ! empty($data)) {
            return $this->response(['data' => new ShippingMethodResource($data)]);
        }

        return $this->errorResponse($response);
    }
}
