<?php

namespace Modules\MenuBuilder\Http\Models;

use App\Models\Model;

class Menus extends Model
{
    protected $table = 'admin_menus';

    /**
     * Check the name of menu
     *
     * @return bool
     */
    public function getModuleName($permission = null)
    {
        $permission = json_decode($permission, true);
        if ($permission['permission']) {
            $explodedItem = explode('\\', $permission['permission']);
            if (! empty($explodedItem) && ! empty($explodedItem[1]) && $explodedItem[1] == 'Http') {
                return true;
            }

            return isActive($explodedItem[1]);
        }

    }

    public static function byName($name)
    {
        return self::whereName($name)->first();
    }

    /**
     * Foreign key with MenuItems model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany('Modules\MenuBuilder\Http\Models\MenuItems', 'menu')->with('child')->where('parent', 0)->orderBy('sort', 'ASC');
    }
}
