<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 24-10-2021
 */

namespace Modules\Shop\Http\Controllers\Api\Vendor;

use Illuminate\Http\Request;
use App\Models\VendorUser;
use Modules\Shop\Http\Models\Shop;
use App\Http\Controllers\Controller;
use Modules\Shop\Http\Resources\VendorShopResource;

class ShopController extends Controller
{
    /**
     * Shop List
     *
     * @return json $data
     */
    public function index(Request $request)
    {
        $configs = $this->initialize([], $request->all());
        $shops = Shop::where('vendor_id', session()->get('vendorId'))->with(['vendor']);

        $vendor = isset($request->vendor) ? trim(xss_clean($request->vendor)) : null;
        if (! empty($vendor)) {
            $shops->whereHas('vendor', function ($q) use ($vendor) {
                $q->where('name', strtolower($vendor));
            })->with('vendor');
        }

        $name = isset($request->name) ? trim(xss_clean($request->name)) : null;
        if (! empty($name)) {
            $shops->where('name', strtolower($name));
        }

        $email = isset($request->email) ? trim(xss_clean($request->email)) : null;
        if (! empty($email)) {
            $shops->where('email', strtolower($email));
        }

        $website = isset($request->website) ? trim(xss_clean($request->website)) : null;
        if (! empty($website)) {
            $shops->where('website', strtolower($website));
        }

        $alias = isset($request->alias) ? trim(xss_clean($request->alias)) : null;
        if (! empty($alias)) {
            $shops->where('alias', strtolower($alias));
        }

        $phone = isset($request->phone) ? trim(xss_clean($request->phone)) : null;
        if (! empty($phone)) {
            $shops->where('phone', strtolower($phone));
        }

        $fax = isset($request->fax) ? trim(xss_clean($request->fax)) : null;
        if (! empty($fax)) {
            $shops->where('fax', strtolower($fax));
        }

        $address = isset($request->address) ? trim(xss_clean($request->address)) : null;
        if (! empty($address)) {
            $shops->where('address', strtolower($address));
        }

        $description = isset($request->description) ? trim(xss_clean($request->description)) : null;
        if (! empty($description)) {
            $shops->where('description', strtolower($description));
        }

        $status = isset($request->status) ? trim(xss_clean($request->status)) : null;
        if (! empty($status)) {
            $shops->where('status', strtolower($status));
        }

        $keyword = isset($request->keyword) ? trim(xss_clean($request->keyword)) : null;
        if (! empty($keyword)) {
            if (preg_match('/^[1-9]+[0-9]*$/', $keyword)) {
                $shops->where(function ($query) use ($keyword) {
                    $query->where('id', $keyword);
                });
            } elseif (strlen($keyword) >= 2) {
                $shops->where(function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%' . $keyword . '%')
                        ->orwhereHas('vendor', function ($q) use ($keyword) {
                            $q->where('name', 'LIKE', '%' . $keyword . '%');
                        })->with('vendor')
                        ->orwhere('email', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('website', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('alias', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('phone', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('fax', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('address', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('description', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('status', 'LIKE', '%' . $keyword . '%');
                });
            }
        }

        return $this->response([
            'data' => VendorShopResource::collection($shops->paginate($configs['rows_per_page'])),
            'pagination' => $this->toArray($shops->paginate($configs['rows_per_page'])->appends($request->all())),
        ]);
    }

    /**
     * Store Shop
     *
     * @return json $data
     */
    public function store(Request $request)
    {
        $request['vendor_id'] = VendorUser::getAll()->where('user_id', auth('api')->user()->id)->first()->vendor_id;
        $validator = Shop::storeValidation($request->all());
        if ($validator->fails()) {
            return $this->unprocessableResponse($validator->messages());
        }
        if ((new Shop())->store($request->only('name', 'vendor_id', 'email', 'website', 'alias', 'phone', 'fax', 'address', 'description', 'status'))) {
            return $this->okResponse([], __('The :x has been successfully saved.', ['x' => __('Shop')]));
        }

        return $this->errorResponse();
    }

    /**
     * Detail Shop
     *
     * @param  int  $id
     * @return json $data
     */
    public function detail($id)
    {
        $response = $this->checkExistence($id, 'shops');
        $shopData = Shop::getAll()->where('id', $id)->first();
        if ($response['status'] === true && ! empty($shopData)) {
            return $this->response(['data' => new VendorShopResource($shopData)]);
        }

        return $this->response([], 204, $response['message']);
    }

    /**
     * Update Shop Information
     *
     * @return json $response
     */
    public function update(Request $request, $id)
    {
        $response = $this->checkExistence($id, 'shops');
        if ($response['status'] === true) {
            $request['vendor_id'] = VendorUser::getAll()->where('user_id', auth('api')->user()->id)->first()->vendor_id;
            $validator = Shop::updateValidation($request->all(), $id);
            if ($validator->fails()) {
                return $this->unprocessableResponse($validator->messages());
            }
            if ((new Shop())->updateShop($request->all(), $id)) {
                return $this->okResponse([], __('The :x has been successfully saved.', ['x' => __('Shop')]));
            } else {
                return $this->okResponse([], __('No changes found.'));
            }
        }

        return $this->response([], 204, $response['message']);
    }

    /**
     * Remove the specified Shop from db.
     *
     * @param  int  $id
     * @return json $response
     */
    public function destroy($id)
    {
        $response = $this->checkExistence($id, 'shops');
        if ($response['status'] === true) {
            if ((new Shop())->shopCount($id) > 1) {
                $result = (new Shop())->remove($id);
            } else {
                $result['message'] = __('This is your only shop, can not be deleted.');
            }

            return $this->okResponse([], $result['message']);
        }

        return $this->response([], 204, $response['message']);
    }
}
