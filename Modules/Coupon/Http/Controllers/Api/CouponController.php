<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 21-11-2021
 */

namespace Modules\Coupon\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\Coupon\Http\Models\Coupon;
use Illuminate\Http\Request;
use Modules\Coupon\Http\Resources\{
    CouponDetailResource,
    CouponResource
};

class CouponController extends Controller
{
    /**
     * Coupon List
     *
     * @return json $data
     */
    public function index(Request $request)
    {
        $configs = $this->initialize([], $request->all());
        $coupons = Coupon::select('coupons.*');

        $name = isset($request->name) ? trim(xss_clean($request->name)) : null;
        if (! empty($name)) {
            $coupons->where('name', strtolower($name));
        }

        $code = isset($request->code) ? trim(xss_clean($request->code)) : null;
        if (! empty($code)) {
            $coupons->where('code', strtolower($code));
        }

        $discountType = isset($request->discount_type) ? trim(xss_clean($request->discount_type)) : null;
        if (! empty($discountType)) {
            $coupons->where('discount_type', strtolower($discountType));
        }

        $discountAmount = isset($request->discount_amount) ? trim(xss_clean($request->discount_amount)) : null;
        if (! empty($discountAmount)) {
            $coupons->where('discount_amount', strtolower($discountAmount));
        }

        $status = isset($request->status) ? trim(xss_clean($request->status)) : null;
        if (! empty($status)) {
            $coupons->where('status', strtolower($status));
        }

        $keyword = isset($request->keyword) ? trim(xss_clean($request->keyword)) : null;
        if (! empty($keyword)) {
            if (preg_match('/^[1-9]+[0-9]*$/', $keyword)) {
                $coupons->where(function ($query) use ($keyword) {
                    $query->where('id', $keyword);
                });
            } elseif (strlen($keyword) >= 2) {
                $coupons->where(function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('code', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('discount_type', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('discount_amount', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('status', 'LIKE', '%' . $keyword . '%');
                });
            }
        }

        return $this->response([
            'data' => CouponResource::collection($coupons->paginate($configs['rows_per_page'])),
            'pagination' => $this->toArray($coupons->paginate($configs['rows_per_page'])->appends($request->all())),
        ]);
    }

    /**
     * Store Coupon
     *
     * @return json $data
     */
    public function store(Request $request)
    {
        $validator = Coupon::storeValidation($request->all());
        if ($validator->fails()) {
            return $this->unprocessableResponse($validator->messages());
        }
        $request['start_date'] = DbDateFormat($request->start_date);
        $request['end_date'] = DbDateFormat($request->end_date);
        if ((new Coupon())->store($request->all())) {
            return $this->okResponse([], __('The :x has been successfully saved.', ['x' => __('Coupon')]));
        }

        return $this->errorResponse();
    }

    /**
     * Detail Coupon
     *
     * @param  int  $id
     * @return json $response
     */
    public function detail($id = null)
    {
        $response = $this->checkExistence($id, 'coupons');

        if ($response['status'] === true) {
            $coupon = Coupon::getAll()->where('id', $id)->first();

            return $this->response(['data' => new CouponDetailResource($coupon)]);
        }

        return $this->response([], 204, $response['message']);
    }

    /**
     * Update Coupon Information
     *
     * @param  int  $id
     * @return json $response
     */
    public function update(Request $request, $id = null)
    {
        $response = $this->checkExistence($id, 'coupons');
        if ($response['status'] === true) {
            $validator = Coupon::updateValidation($request->all(), $id);
            if ($validator->fails()) {
                return $this->unprocessableResponse($validator->messages());
            }
            $request['start_date'] = DbDateFormat($request->start_date);
            $request['end_date'] = DbDateFormat($request->end_date);
            if ($updateMessage = (new Coupon())->updateData($request->all(), $id)) {
                return $this->okResponse([], $updateMessage['message']);
            } else {
                return $this->okResponse([], __('No changes found.'));
            }
        }

        return $this->response([], 204, $response['message']);
    }

    /**
     * Remove the specified Coupon from db.
     *
     * @return json $response
     */
    public function destroy($id = null)
    {
        $response = $this->checkExistence($id, 'coupons');
        if ($response['status'] === true) {
            $result = (new Coupon())->remove($id);

            return $this->okResponse([], $result['message']);
        }

        return $this->response([], 204, $response['message']);
    }
}
