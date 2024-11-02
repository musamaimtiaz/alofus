<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 01-02-2022
 *
 * @modified 20-06-2022
 */

namespace App\Http\Controllers;

use App\Models\{
    OrderStatus,
    OrderStatusRole,
    Role
};
use Illuminate\Http\Request;
use DB;

class OrderStatusController extends Controller
{
    /**
     * Status List
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data['list_menu'] = 'status';
        $data['orderStatuses'] = OrderStatus::getAll()->sortBy('order_by');
        $data['roles'] = Role::getAll();

        return view('admin.order_status.index', $data);
    }

    /**
     * Status Store
     */
    public function store(Request $request)
    {
        $response = $this->messageArray(__('Something went wrong, please try again.'), 'fail');
        $validator = OrderStatus::storeValidation($request->all());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();
            $statusId = (new OrderStatus())->store($request->only('name', 'is_default', 'order_by', 'color', 'payment_scenario'));
            if (! empty($statusId)) {
                $roleData = [];
                foreach ($request->role_ids as $roleId) {
                    $roleData[] = [
                        'order_status_id' => $statusId,
                        'role_id' => $roleId,
                    ];
                }
                (new OrderStatusRole())->store($roleData);
                $response = $this->messageArray(__('The :x has been successfully saved.', ['x' => __('Order Status')]), 'success');
            }
            DB::commit();
            $this->setSessionValue($response);
        } catch (Exception $e) {
            DB::rollBack();
        }

        return redirect()->back();
    }

    /**
     * Status edit
     */
    public function edit(Request $request)
    {
        $result = [];
        if (isset($request->id) && ! empty($request->id)) {
            $statusData = OrderStatus::getAll()->where('id', $request->id)->first();
            $roleIds = [];
            foreach ($statusData->role as $roleId) {
                $roleIds[] = $roleId->id;
            }
            $result['id']  = $statusData->id;
            $result['name']  = $statusData->name;
            $result['is_core']  = in_array($statusData->slug, coreStatusSlug());
            $result['payment_scenario']  = $statusData->payment_scenario;
            $result['color']  = $statusData->color;
            $result['order_by']  = $statusData->order_by;
            $result['roleIds'] = $roleIds;
            $result['is_default'] = $statusData->is_default;
        }

        return json_encode($result);
    }

    /**
     * Status Update
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $response = $this->messageArray(__('Something went wrong, please try again.'), 'fail');
        $validator = OrderStatus::updateValidation($request->all(), $request->status_id);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if ((new OrderStatus())->statusUpdate($request->only('name', 'is_default', 'order_by', 'color', 'payment_scenario'), $request->status_id)) {
            $response = $this->messageArray(__('The :x has been successfully saved.', ['x' => __('Order Status')]), 'success');
            $orderStatusRole = OrderStatusRole::getAll()->where('order_status_id', $request->status_id)->pluck('role_id')->toArray();
            $exists = [];
            foreach ($request->role_ids as $roleId) {
                $exists[] = $roleId;
                if (! in_array($roleId, $orderStatusRole)) {
                    (new OrderStatusRole())->store(['role_id' => $roleId, 'order_status_id' => $request->status_id]);
                }
            }
            $deletedRoles = array_diff($orderStatusRole, $exists);
            if (count($deletedRoles) > 0) {
                foreach ($deletedRoles as $deleteRole) {
                    (new OrderStatusRole())->remove($request->status_id, $deleteRole);
                }
            }
        } else {
            $response = $this->messageArray(__('Please make a status as default.'), 'fail');
        }
        $this->setSessionValue($response);

        return redirect()->back();
    }

    /**
     * @param  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $status = (new OrderStatus())->remove($request->id);
        $response = $this->messageArray($status['message'], $status['type']);
        $this->setSessionValue($response);

        return redirect()->back();
    }
}
