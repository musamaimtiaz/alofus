<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Millat <[millat.techvill@gmail.com]>
 *
 * @created 18-09-2021
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cache;
use Route;
use App\Models\{
    Role,
    Permission,
    PermissionRole
};

class PermissionRoleController extends Controller
{
    /**
     * Permissions
     *
     * @param  RoleListDataTable  $dataTable
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $permissions = Permission::getAll()->sortBy('controller_name');
        $permissionRole = PermissionRole::getAll()->toArray();
        $prms = [];
        $modules = [];

        foreach (\Nwidart\Modules\Facades\Module::getOrdered() as $key => $value) {
            $modules[] = 'Modules\\' . $key;
        }
        foreach ($permissions as $permission) {
            $group = explode('Controller', $permission->controller_name)[0];

            if (! array_key_exists($group, $prms)) {
                $type = [
                    'vendor' => 'App\Http\Controllers\Vendor\\',
                    'customer' => 'App\Http\Controllers\Site\\',
                    'customer_api' => 'App\Http\Controllers\Api\User\\',
                    'vendor_api' => 'App\Http\Controllers\Api\Vendor\\',
                    'admin_api' => 'App\Http\Controllers\Api\\',
                ];

                $prms[$group]['admin'] = [];
                foreach ($type as $key => $value) {
                    $prms[$group][$key] = [];
                }
            }
            foreach ($type as $key => $value) {
                $path = str_replace($modules, 'App', $permission->controller_path);

                if (strpos($path, $value) !== false) {
                    array_push($prms[$group][$key], [
                        'id' => $permission->id,
                        'name' => $permission->method_name,
                        'role_ids' => $this->rolesByPermission($permissionRole, $permission->id),
                    ]);

                    continue 2;
                }
            }
            array_push($prms[$group]['admin'], [
                'id' => $permission->id,
                'name' => $permission->method_name,
                'role_ids' => $this->rolesByPermission($permissionRole, $permission->id),
            ]);

        }
        $data['list_menu'] = 'permission';
        $data['permissions'] = $prms;
        $data['roles'] = Role::getAll()->toArray();

        return view('admin.permissionrole.index', $data);
    }

    /**
     * rolesByPermission description
     *
     * @param  array  $rolePermissions  [description]
     * @param  int  $permissionID  [description]
     * @return array [description]
     */
    public function rolesByPermission(array $rolePermissions, int $permissionID): array
    {
        $roleIDs = [];

        foreach ($rolePermissions as $rolePermission) {
            if ($rolePermission['permission_id'] == $permissionID && ! in_array($rolePermission['role_id'], $roleIDs)) {
                array_push($roleIDs, $rolePermission['role_id']);
            }
        }

        return $roleIDs;
    }

    /**
     * assignPermission description
     *
     * @param  Request  $request  [description]
     * @return bool [description]
     */
    public function assignPermission(Request $request)
    {
        if (! isset($request->role_id) && ! isset($request->permission_id)) {
            return response()->json(false);
        }

        if ($request->role_id == 1) {
            return response()->json(false);
        }

        $isPrmsRoleExit = PermissionRole::where([
            'permission_id' => $request->permission_id,
            'role_id' => $request->role_id,
        ]);

        if ($isPrmsRoleExit->first()) {
            (new PermissionRole())->remove($isPrmsRoleExit);
            Cache::forget(config('cache.prefix') . '-permission-role');
            Cache::forget(config('cache.prefix') . '-permission-name-by-role-' . $request->role_id);

            return response()->json(true);
        }

        (new PermissionRole())->store($request->only('permission_id', 'role_id'));
        Cache::forget(config('cache.prefix') . '-permission-role');
        Cache::forget(config('cache.prefix') . '-permission-name-by-role-' . $request->role_id);

        return response()->json(true);
    }

    /**
     * generate permission from route
     *
     * @return back
     */
    public function generatePermission()
    {
        $prms = Permission::getAll()->toArray();
        $routeCollection = Route::getRoutes();
        $routes = [];
        $permissions = [];

        $key = 0;
        foreach ($routeCollection as $route) {

            // get all route, including api
            $action = $route->getAction();

            if (array_key_exists('controller', $action)) {

                $explodedControllerPath = explode('\\', $action['controller']);

                // If controller is Facade then skip
                if (in_array($explodedControllerPath[0], ['Facade'])) {
                    continue;
                }

                $explodedAction = explode('@', $action['controller']);
                $explodedController = explode('\\', $explodedAction[0]);

                if ($this->isPermissionExist($action['controller'], $prms) || ! isset($explodedAction[1])) {
                    continue;
                }

                $permissions[$key]['name'] = $action['controller'];
                $permissions[$key]['controller_path'] = $explodedAction[0];
                $permissions[$key]['controller_name'] = end($explodedController);
                $permissions[$key]['method_name'] = $explodedAction[1];

                $key++;
            }

        }

        $notUsedPermission = $this->notUsedPermission($prms, $routeCollection);

        if (empty($permissions) && empty($notUsedPermission)) {
            return redirect()->back()->withFail(__('Nothing to generated'));
        }

        if (! empty($permissions)) {
            Permission::insertPermission($permissions);
        }

        if (! empty($notUsedPermission)) {
            Permission::whereIn('id', $notUsedPermission)->delete();
        }

        return redirect()->back()->withSuccess(__('Permission generated.'));
    }

    /**
     * check permission already exist or not
     *
     * @param  string  $permission
     * @param  array  $permissions
     * @return bool [description]
     */
    protected function isPermissionExist($permission, $permissions)
    {
        foreach ($permissions as $prm) {
            if ($this->inArrays($permission, $prm)) {
                return true;
            }
        }

        return false;
    }

    protected function inArrays($needle, $haystack, $strict = false)
    {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->inArrays($needle, $item, $strict))) {
                return true;
            }
        }

        return false;
    }

    protected function notUsedPermission($prms, $routeCollection)
    {
        $permissions = [];
        foreach ($routeCollection as $route) {
            $action = $route->getAction();
            if (array_key_exists('controller', $action)) {

                $explodedControllerPath = explode('\\', $action['controller']);
                if (in_array($explodedControllerPath[0], ['Facade'])) {
                    continue;
                }

                array_push($permissions, $action['controller']);
            }

        }

        $notUsedPermissionIDs = [];

        foreach ($prms as $prm) {
            if (! in_array($prm['name'], $permissions)) {
                array_push($notUsedPermissionIDs, $prm['id']);
            }
        }

        return $notUsedPermissionIDs;
    }
}
