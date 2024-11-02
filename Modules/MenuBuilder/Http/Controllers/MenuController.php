<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Kabir Ahmed <[kabir.techvill@gmail.com]>
 *
 * @created 30-11-2021
 */

namespace Modules\MenuBuilder\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\MenuBuilder\Http\Models\MenuItems;
use Modules\MenuBuilder\Http\Models\AdminMenus;

class MenuController extends Controller
{
    /**
     * Store Menu
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createNewMenu()
    {
        $menuId = AdminMenus::create(['name' => request()->input('menuname')]);

        return json_encode(['resp' => $menuId->id]);
    }

    /**
     * Delete Menu
     *
     * @param  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteMenu()
    {
        $menuitem = MenuItems::find(request()->input('id'));
        if (! empty($menuitem)) {
            $menuitem->delete();

            return json_encode(['resp' => __('Deleted Successfully'), 'error' => 1]);
        } else {
            return json_encode(['resp' => __('Something went wrong'), 'error' => 3]);
        }
    }

    /**
     * Delete Menu Item
     *
     * @param  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete()
    {
        $getall = MenuItems::where('menu', request()->input('id'));
        if (! empty($getall)) {
            $menudelete = MenuItems::where('menu', (request()->input('id')));
            if ($menudelete && $menudelete->delete()) {
                return json_encode(['resp' => __('You delete this item')]);
            }
        } else {
            return json_encode(['resp' => __('Something went wrong'), 'error' => 3]);
        }
    }

    /**
     * Update Item
     */
    public function update()
    {
        $arraydata = request()->input('arraydata');
        if (is_array($arraydata)) {
            foreach ($arraydata as $value) {
                $menuitem = MenuItems::find($value['id']);
                if (! empty($menuitem)) {
                    $menuitem->label = $value['label'];
                    $menuitem->link = ! empty($value['link']) ? $value['link'] : null;
                    $menuitem->params = ! empty($value['params']) ? json_decode($value['params']) : null;
                    $menuitem->class = ! empty($value['class']) ? $value['class'] : null;
                    $menuitem->icon = ! empty($value['icon']) ? $value['icon'] : null;
                    $menuitem->save();
                }
            }

            return json_encode(['resp' => __('success'), 'success' => 1]);
        } else {
            $menuitem = MenuItems::find(request()->input('id'));
            $menuitem->label = request()->input('label');
            $menuitem->link = ! empty(request()->input('url')) ? request()->input('url') : null;
            $menuitem->class = ! empty(request()->input('clases')) ? request()->input('clases') : null;
            $menuitem->save();

            return json_encode(['resp' => __('success'), 'success' => 1]);
        }

        return json_encode(['resp' => __('error'), 'error' => 2]);
    }

    /**
     * Create Custom Menu
     *
     * @param  $customName
     */
    public function addCustomMenu(Request $request)
    {
        if (request()->input('customName')) {
            $sort = MenuItems::getNextSortRoot(request()->input('idmenu'));
            foreach (request()->input('customName') as $key => $value) {
                $dataStore[] = [
                    'label' => $value,
                    'link' => request()->input('categoryUrl')[$key],
                    'params' => ! empty($request['permissionAttribute']) ? $request['permissionAttribute'][$key] : null,
                    'is_default' => ! empty(request()->input('isDeletable')) ? (int) request()->input('isDeletable') : 0,
                    'menu' => request()->input('idmenu'),
                    'sort' => $sort,
                ];
                $sort = $sort + 1;
            }
            (new MenuItems())->store($dataStore);
            serialize($request['array']);
        } else {
            $menuitem = new MenuItems();
            $menuitem->label = ! empty(request()->input('customName')) ? request()->input('customName') : request()->input('labelmenu');
            $menuitem->link = ! empty(request()->input('linkmenu')) ? request()->input('linkmenu') : '';
            $menuitem->menu = request()->input('idmenu');
            $menuitem->is_custom_menu = 1;
            $menuitem->sort = MenuItems::getNextSortRoot(request()->input('idmenu'));
            $menuitem->params = request()->input('idmenu') == 4 ? ['permission' => 'no-prefix'] : null;
            $menuitem->save();
        }
    }

    /**
     * Serialize Menu
     *
     * @param  $idmenu
     * @return \Illuminate\Http\RedirectResponse
     */
    public function generateMenuControl()
    {
        AdminMenus::where('id', request()->input('idmenu'))->update(['name' => request()->input('menuname')]);

        if (is_array(request()->input('arraydata'))) {
            foreach (request()->input('arraydata') as $value) {
                $menuitem = MenuItems::find($value['id']);
                if (! empty($menuitem)) {
                    $menuitem->parent = $value['parent'];
                    $menuitem->sort = $value['sort'];
                    $menuitem->depth = $value['depth'];
                    $menuitem->save();
                }
            }
        }

        return json_encode(['resp' => 2]);
    }
}
