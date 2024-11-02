<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 26-05-2021
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\{
    RoleResource,
    RoleDetailResource
};
use App\Models\{
    Role,
};
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Role List
     *
     * @return json $data
     */
    public function index(Request $request)
    {
        $data           = [];
        $configs        = $this->initialize([], $request->all());
        $role           = Role::select('roles.*');
        $name           = isset($request->name) ? $request->name : null;
        if (! empty($name)) {
            $role->where('name', strtolower($name));
        }

        $type = isset($request->type) ? $request->type : null;
        if (! empty($type)) {
            $role->where('type', strtolower($type));
        }

        $keyword = isset($request->keyword) ? $request->keyword : null;
        if (! empty($keyword)) {
            if (is_int($keyword)) {
                $role->where('id', $keyword);
            } elseif (strlen($keyword) >= 2) {
                $role->where(function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('type', 'LIKE', '%' . $keyword . '%');
                });
            }
        }

        return $this->response([
            'data' => RoleResource::collection($role->paginate($configs['rows_per_page'])),
            'pagination' => $this->toArray($role->paginate($configs['rows_per_page'])->appends($request->all())),
        ]);
    }

    /**
     * Store Role
     *
     * @return json $data
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            if (isset($request->type) && array_key_exists(strtolower($request->type), ['global' => 'global', 'vendor' => 'vendor'])) {
                $request['type'] = strtolower($request->type);
            }
            $validator = Role::storeValidation($request->all());
            if ($validator->fails()) {
                return $this->unprocessableResponse($validator->messages());
            }
            if ((new Role())->store($request->all())) {
                return $this->okResponse([], __('The :x has been successfully saved.', ['x' => __('Role')]));
            }

            return $this->errorResponse();
        }
    }

    /**
     * Detail Role
     *
     * @param  Request  $request
     * @return json $data
     */
    public function detail($id)
    {
        $response       = $this->checkExistence($id, 'roles');
        $roleData   = Role::getAll()->where('id', $id)->first();
        if ($response['status'] === true && ! empty($roleData)) {
            return $this->response(['data' => new RoleDetailResource($roleData)]);
        }

        return $this->response([], 204, $response['message']);
    }

    /**
     * Update Role Information
     */
    public function update(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $response = $this->checkExistence($id, 'roles');
            if ($response['status'] === true) {
                if (isset($request->type) && array_key_exists(strtolower($request->type), ['global' => 'global', 'vendor' => 'vendor'])) {
                    $request['type'] = strtolower($request->type);
                }
                $validator = Role::updateValidation($request->all(), $id);
                if ($validator->fails()) {
                    return $this->unprocessableResponse($validator->messages());
                }
                if ((new Role())->updateRole($request->all(), $id)) {
                    return $this->okResponse([], __('The :x has been successfully saved.', ['x' => __('Role')]));
                } else {
                    return $this->okResponse([], __('No changes found.'));
                }
            }

            return $this->response([], 204, $response['message']);
        }

    }

    /**
     * Remove the specified Role from db.
     *
     * @return json $data
     */
    public function destroy(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $response = $this->checkExistence($id, 'roles');
            if ($response['status'] === true) {
                $result  = (new Role())->remove($id);

                return $this->okResponse([], $result['message']);
            }

            return $this->response([], 204, $response['message']);
        }
    }
}
