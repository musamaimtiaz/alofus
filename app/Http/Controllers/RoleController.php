<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sabbir Al-Razi <[sabbir.techvill@gmail.com]>
 *
 * @created 20-05-2021
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\DataTables\RoleListDataTable;
use App\Models\{
    Role,
    RoleUser,
    PermissionRole
};

class RoleController extends Controller
{
    /**
     * Role List
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(RoleListDataTable $dataTable)
    {
        $data['list_menu'] = 'role';

        return $dataTable->render('admin.roles.index', $data);
    }

    /**
     * Create
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $data['list_menu'] = 'role';

        return view('admin.roles.create', $data);
    }

    /**
     * Store
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $data = ['status' => 'fail', 'message' => __('Invalid Request')];
        if ($request->isMethod('post')) {
            if (isset($request->type) && array_key_exists(strtolower($request->type), ['global' => 'global', 'vendor' => 'vendor'])) {
                $request['type'] = strtolower($request->type);
            }

            $validator = Role::storeValidation($request->all());
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            if ((new Role())->store($request->only('name', 'slug', 'type', 'description'))) {
                $data['status'] = 'success';
                $data['message'] = __('The :x has been successfully saved.', ['x' => __('Role')]);
            } else {
                $data['message'] = __('Something went wrong, please try again.');
            }
        }

        Session::flash($data['status'], $data['message']);

        return redirect()->route('roles.index');
    }

    /**
     * Edit
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id = null)
    {
        $data['list_menu'] = 'role';
        $data['roles'] = Role::find($id);

        if (empty($data['roles'])) {
            Session::flash('fail', __('The :x does not exist.', ['x' => strtolower(__('Role'))]));

            return redirect()->route('roles.index');
        }

        return view('admin.roles.edit', $data);
    }

    /**
     * Update
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id = null)
    {
        $result = $this->checkExistence($id, 'roles', ['getData' => 1]);
        if ($result['status'] === false) {
            Session::flash('fail', $result['message']);

            return redirect()->route('roles.index');
        }

        $response = ['status' => 'fail', 'message' => __('Invalid Request')];
        if ($request->isMethod('post')) {
            if (isset($request->type) && array_key_exists(strtolower($request->type), ['global' => 'global', 'vendor' => 'vendor'])) {
                $request['type'] = strtolower($request->type);
            }

            $validator = Role::updateValidation($request->all(), $id);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            if (in_array($result['data']->slug, defaultRoles())) {
                $response = (new Role())->updateRole($request->except(['type', 'slug']), $id);
            } else {
                $response = (new Role())->updateRole($request->all(), $id);
            }
        }

        Session::flash($response['status'], $response['message']);

        return redirect()->route('roles.index');
    }

    /**
     * Delete
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, $id = null)
    {
        $result = $this->checkExistence($id, 'roles', ['getData' => 1]);
        if ($result['status'] === false) {
            Session::flash('fail', $result['message']);

            return redirect()->route('roles.index');
        } elseif (in_array($result['data']->slug, defaultRoles())) {
            Session::flash('fail', __('You can not delete this :x.', ['x' => strtolower(__('Role'))]));

            return redirect()->route('roles.index');
        }

        if ($request->isMethod('post')) {
            $response = (new Role())->remove($id);
        }

        Session::flash($response['status'], $response['message']);

        return redirect()->route('roles.index');
    }
}
