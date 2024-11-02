<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 17-09-2022
 */

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderStatusResource;
use App\Models\{
    OrderStatus,
};

class OrderStatusController extends Controller
{
    /**
     * Order Status
     *
     * @return json $data
     */
    public function index()
    {
        $orderStatus = OrderStatus::orderBy('order_by')->get();

        return $this->response([
            'data' => OrderStatusResource::collection($orderStatus),
        ]);
    }
}
