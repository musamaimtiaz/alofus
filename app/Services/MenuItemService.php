<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 30-10-2023
 */

namespace App\Services;

use Modules\MenuBuilder\Http\Models\{
    MenuItems, AdminMenus as Menus
};

class MenuItemService
{
    /**
     * Get Menu
     */
    private function getMenuId(string|int $menuName): ?int
    {
        $menu = Menus::getAll()->pluck('id', 'name')->toArray();

        if (is_numeric($menuName) && is_int($menuName + 0) && in_array($menuName, $menu)) {
            return $menuName;
        }

        return array_key_exists($menuName, $menu) ? $menu[$menuName] : null;
    }

    /**
     * Get default option
     */
    private function getDefaultOption(): array
    {
        return [
            'parent' => 0,
            'link' => null,
            'params' => null,
            'is_default' => 1,
            'icon' => null,
            'is_custom_menu' => 0,
            'class' => null,
            'sort' => 0,
        ];
    }

    /**
     * Get parent
     *
     * @param null|int|string
     */
    private function hasParent($parent): bool
    {
        return ! is_null($parent) && $parent != 0;
    }

    /**
     * Get parent Id
     */
    private function getParentId(string|int $parent, $menuId = 1): int
    {
        if (is_numeric($parent) && is_int($parent + 0)) {
            return (int) $parent;
        }

        $menuItem = MenuItems::where(['menu' => $menuId, 'depth' => 0, 'label' => $parent])->first();

        return $menuItem?->id ?? 0;
    }

    /**
     * Add Menu Item
     */
    public function addMenuItem(string|int $menuName, string $label, array $option): int|bool
    {
        try {
            $data = array_intersect_key(array_replace($this->getDefaultOption(), $option), $this->getDefaultOption());

            $data['menu'] = $this->getMenuId($menuName);

            if (is_null($data['menu'])) {
                return false;
            }

            $data['label'] = $label;
            $data['depth'] = $this->hasParent($data['parent']);
            $data['parent'] = $this->getParentId($data['parent'], $data['menu']);

            $condition = array_intersect_key($data, array_flip(['label', 'menu', 'depth', 'parent']));

            if (isset($option['id'])) {
                $condition['id'] = $data['id'] = $option['id'];
            }

            MenuItems::updateOrInsert($condition, $data);

            if (! $data['depth']) {
                return MenuItems::where($condition)->first()?->id ?? 0;
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
