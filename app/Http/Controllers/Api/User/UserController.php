<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 25-01-2022
 */

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\{TopSellerResource, userDetailResource, WalletResource};
use App\Models\{Product, Order, OrderStatus, User, Wallet};

class UserController extends Controller
{
    /**
     * User profile
     *
     * @return json $data
     */
    public function profile()
    {
        $id = auth()->guard('api')->user()->id;
        $response = $this->checkExistence($id, 'users');
        if ($response['status']) {
            return $this->response([
                'data' => new userDetailResource(User::getAll()->where('id', $id)->first()),
            ]);
        }

        return $this->response([], 204, $response['message']);
    }

    /**
     * Update User Information
     *
     * @return json $data
     */
    public function update(Request $request)
    {
        $id = auth()->guard('api')->user()->id;
        $response = $this->checkExistence($id, 'users');
        if ($response['status'] === true) {
            $validator = User::siteUpdateValidation($request->all(), $id);
            if ($validator->fails()) {
                return $this->unprocessableResponse($validator->messages());
            }

            if ((new User())->updateUser($request->only('name', 'email', 'phone', 'birthday', 'address', 'gender'), $id)) {
                return $this->okResponse([], __('The :x has been successfully saved.', ['x' => __('Customer Info')]));
            } else {
                return $this->okResponse([], __('No changes found.'));
            }
        }

        return $this->response([], 204, $response['message']);
    }

    /**
     * Update password
     *
     * @return json $response
     */
    public function updatePassword(Request $request)
    {
        $id = auth()->guard('api')->user()->id;
        $response = $this->checkExistence($id, 'users', ['getData' => true]);
        if ($response['status']) {
            $validator = User::siteUpdatePasswordValidation($request->all());
            if ($validator->fails()) {
                return $this->unprocessableResponse($validator->messages());
            }
            if (! Hash::check($request->old_password, $response['data']->password)) {
                return $this->errorResponse([], 422, __('Old password is wrong.'));
            }
            $request['password'] = Hash::make(trim($request->new_password));

            if ((new User())->siteUpdatePassword($request->only('password'), $id)) {
                return $this->okResponse([], __('The :x has been successfully saved.', ['x' => __('Password')]));
            } else {
                return $this->okResponse([], __('Nothing is updated.'));
            }
        }

        return $this->response([], 500, $response['message']);
    }

    /**
     * Delete
     *
     * @return json $response
     */
    public function destroy(Request $request)
    {
        $id = auth()->guard('api')->user()->id;
        $response = $this->checkExistence($id, 'users', ['getData' => true]);
        if ($response['status']) {
            if (auth()->user()->role()->slug == 'super-admin') {
                return $this->response([], 422, __("Admin account can't be deleted."));
            }

            if (! Hash::check($request->password, $response['data']->password)) {
                return $this->response([], 422, __('Password does not match'));
            }
            if (User::where('id', $id)->update(['status' => 'Deleted'])) {
                \Auth::guard('api')->user()->token()->delete();

                return $this->okResponse([], __('Your :x has been successfully deleted.', ['x' => __('Account')]));
            }
        }

        return $this->response([], 404, $response['message']);
    }

    /**
     * Top seller
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function topSeller(Request $request)
    {
        $configs = $this->initialize([], $request->all());
        $items = Product::select('vendor_id')
            ->distinct()
            ->whereNotNull('total_sales')
            ->where('status', 'Active')
            ->orderBy('total_sales', 'DESC')
            ->take(20)
            ->with('vendor:id,name,email,phone,status')
            ->get();

        return $this->response([
            'data' => TopSellerResource::collection($items),
        ]);
    }

    /**
     * order track
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function track(Request $request)
    {
        $order = Order::where('reference', $request->reference ?? null)->first();
        if (empty($order)) {
            return $this->notFoundResponse([], __('Order not found.'));
        }

        $orderStatus = OrderStatus::getAll()->sortBy('order_by');
        $data = [];
        $orderData = [
            'is_delivery' => 1,
            'order_by' => optional($order->orderStatus)->order_by,
        ];
        foreach ($orderStatus as $status) {
            $active = optional($order->orderStatus)->order_by >= $status->order_by ? true : false;
            $orderDate = $status->orderHistories()->latest()->first();
            $data[] = [
                'name' => $status->name,
                'is_active' =>   $order->orderStatus->order_by >= $status->order_by ? true : false,
                'orderDate' => ! empty($orderDate) && $active == true ? timeZoneFormatDate($orderDate->created_at) . ' ' . timeZoneGetTime($orderDate->created_at) : '',
            ];
        }

        return $this->response([
            'data' => $data,
            'orderData' => $orderData,
        ]);
    }

    /**
     * Get User Wallet
     *
     * @return json
     */
    public function wallet($id = null)
    {
        if (is_null($id)) {
            $id = auth()->user()->id;
        }

        $wallets = Wallet::with(['user', 'currency'])->where('user_id', $id)->get();

        if ($wallets->count()) {
            return $this->response([
                'data' => WalletResource::collection($wallets),
            ]);
        }

        return $this->notFoundResponse([], __('Your wallet is empty.'));
    }

    public function addonActivity(Request $request)
    {
        if (isset($request->name)) {
            return $this->successResponse([
                'data' => isActive($request->name),
            ]);
        }

        return $this->errorResponse([], 500);
    }

    /**
     * remove user image
     *
     * @return mixed
     */
    public function removeImage()
    {
        if ((new User())->removeProfileImage()) {
            return $this->okResponse([], __('Profile image remove successfully.'));
        }

        return $this->errorResponse([], 500);
    }
}
