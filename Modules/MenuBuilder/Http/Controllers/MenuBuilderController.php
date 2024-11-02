<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Kabir Ahmed <[kabir.techvill@gmail.com]>
 *
 * @created 30-11-2021
 */

namespace Modules\MenuBuilder\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\CMS\Http\Models\Page;
use Modules\MenuBuilder\Http\Models\Menus;
use Modules\MenuBuilder\Http\Models\MenuItems;
use Modules\MenuBuilder\Http\Models\AdminMenus;

class MenuBuilderController extends Controller
{
    /**
     * Menu create
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(Request $request)
    {
        $data['menuId'] = isset($request->menu) ? $request->menu : '';
        if (! empty($data['menuId'])) {
            $data['menus'] = MenuItems::menus($data['menuId']);
            $data['menuName'] = AdminMenus::select('name')->where('id', $data['menuId'])->first();
            $data['adminMenus'] = Menus::where('permission', 'LIKE', '%"menu_level":"' . $data['menuId'] . '"%')->get();
            if ($data['menuId'] == 4) { // 4 reffered to frontend page menu, We will upgrade it later
                $data['pages'] = Page::active()->get();
            }
        } elseif (empty($data['menuId'])) {
            return redirect('/admin/menu-builder?menu=2');
        }
        $data['menulist'] = AdminMenus::select('id', 'name')->get();

        return view('menubuilder::index', $data);
    }
}
