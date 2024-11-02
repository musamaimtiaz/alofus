<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 27-01-2022
 */

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\{
    UserAddressesResource,
};
use App\Models\{
    Address,
};
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * User addresses
     *
     * @return json $response
     */
    public function addresses(Request $request)
    {
        $configs = $this->initialize([], $request->all());
        $address = Address::where('user_id', auth()->guard('api')->user()->id);
        if ($address->count() == 0) {
            return $this->notFoundResponse();
        }
        $firstName = isset($request->first_name) ? $request->first_name : null;
        if (! empty($firstName)) {
            $address->where('first_name', strtolower($firstName));
        }

        $lastName = isset($request->last_name) ? $request->last_name : null;
        if (! empty($lastName)) {
            $address->where('last_name', strtolower($lastName));
        }

        $phone = isset($request->phone) ? $request->phone : null;
        if (! empty($phone)) {
            $address->where('phone', strtolower($phone));
        }

        $city = isset($request->city) ? $request->city : null;
        if (! empty($city)) {
            $address->where('city', strtolower($city));
        }

        $keyword = isset($request->keyword) ? $request->keyword : null;
        if (! empty($keyword)) {
            if (is_int($keyword)) {
                $address->where(function ($query) use ($keyword) {
                    $query->where('id', $keyword)
                        ->orwhere('phone', 'LIKE', '%' . $keyword . '%');
                });
            } elseif (strlen($keyword) >= 2) {
                $address->where(function ($query) use ($keyword) {
                    $query->where('first_name', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('last_name', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('phone', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('address_1', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('address_2', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('city', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('country', 'LIKE', '%' . $keyword . '%');
                });
            }
        }

        return $this->response([
            'data' => UserAddressesResource::collection($address->paginate($configs['rows_per_page'])),
            'pagination' => $this->toArray($address->paginate($configs['rows_per_page'])->appends($request->all())),
        ]);
    }

    /**
     * User address store
     *
     * @return json $response
     */
    public function storeAddress(Request $request)
    {
        $request['user_id'] = $request->user_id ?? auth()->guard('api')->user()->id;

        $validator = Address::storeValidation($request->all());
        if ($validator->fails()) {
            return $this->unprocessableResponse($validator->messages());
        }
        if ((new Address())->store($request->only('user_id', 'first_name', 'last_name', 'phone', 'email', 'company_name', 'type_of_place', 'address_1', 'address_2', 'state', 'country', 'city', 'zip', 'is_default'))) {
            return $this->createdResponse([], __('The :x has been successfully saved.', ['x' => __('Address')]));
        }

        return $this->response([], 500, __('Something went wrong, please try again.'));
    }

    /**
     * User address update
     *
     * @return json $response
     */
    public function updateAddress(Request $request)
    {
        $result = $this->checkExistence($request->id, 'addresses');
        if ($result['status'] === true) {
            $request['user_id'] = $request->user_id ?? auth()->guard('api')->user()->id;
            if (Address::getAll()->where('id', $request->id)->where('is_default', 1)->count() > 0) {
                $request['is_default'] = 1;
            }
            $validator = Address::updateValidation($request->all(), $request->id);
            if ($validator->fails()) {
                return $this->unprocessableResponse($validator->messages());
            }

            if ((new Address())->updateData($request->all(), $request->id)['status'] == 'success') {
                return $this->okResponse([], __('The :x has been successfully saved.', ['x' => __('Address')]));
            }
        }

        return $this->response([], 500, __('Something went wrong, please try again.'));
    }

    /**
     * User address delete
     *
     * @param  int  $id
     * @return json $response
     */
    public function destroyAddress($id = null)
    {
        $result = $this->checkExistence($id, 'addresses', ['getData' => true]);
        $userId = auth()->guard('api')->user()->id;
        if ($result['status'] === true && $result['data']->user_id == $userId) {
            $response = (new Address())->remove($id);

            return $this->okResponse([], $response['message']);
        }

        return $this->notFoundResponse([], __('Address does not found.'));
    }
}
