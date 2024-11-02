<?php

namespace Modules\MenuBuilder\Http\Models;

use App\Models\Model;

class MenuItems extends Model
{
    protected $table = null;

    protected $casts = [
        'params' => 'array',
    ];

    protected $fillable = ['label', 'link', 'parent', 'sort', 'class', 'menu', 'depth', 'role_id'];

    /**
     * Foreign key with AdminMenus model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function adminMenu()
    {
        return $this->belongsTo('Modules\MenuBuilder\Http\Models\AdminMenus', 'menu');
    }

    /**
     * Get sons
     *
     * @param  int  $id
     * @return array
     */
    public function getsons($id)
    {
        return $this->where('parent', $id)->get();
    }

    /**
     * Get all from menu
     *
     * @param  int  $id
     * @return array
     */
    public function getAllMenus($id)
    {
        return $this->where('menu', $id)->orderBy('sort', 'asc')->get();
    }

    /**
     * Find the next root
     *
     * @param  string  $menu
     * @return array
     */
    public static function getNextSortRoot($menu)
    {
        return self::where('menu', $menu)->max('sort') + 1;
    }

    /**
     * Foreign key with Menus model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent_menu()
    {
        return $this->belongsTo('Modules\MenuBuilder\Http\Models\Menus', 'menu');
    }

    /**
     * Foreign key with MenuItems model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function child()
    {
        return $this->hasMany('Modules\MenuBuilder\Http\Models\MenuItems', 'parent')->orderBy('sort', 'ASC')->with('child');
    }

    /**
     * store
     *
     * @param  array  $info
     * @return bool
     */
    public function store($info = [])
    {
        return parent::insert($info);
    }

    /**
     * Check permission
     *
     * @return bool
     */
    public function getPermissionAttribute()
    {
        if (empty($this->params['permission'])) {
            return;
        }

        return $this->params['permission'];
    }

    public function getModuleName()
    {
        $permission = $this->getPermissionAttribute();
        if (empty($permission)) {
            return true;
        }

        $explodedItem = explode('\\', $permission);
        if (isset($explodedItem[1])) {
            if ($explodedItem[1] == 'Http') {
                return true;
            }

            return isActive($explodedItem[1]);
        }

        return true;
    }

    /**
     * Get laberl name with uppper case
     *
     * @return bool
     */
    public function getLabelNameAttribute()
    {
        return ucfirst($this->label);
    }

    /**
     * Get prefix
     *
     * @return bool
     */
    public function url($prefix = null)
    {
        if ($this->is_default == 0) {
            return $this->link;
        }
        $url = ! is_null($prefix) ? url($prefix) : url('/');

        if (! empty($this->link)) {
            return $url . '/' . $this->link;
        }

        return $url;
    }

    /**
     * Get route name from json field
     *
     * @return bool
     */
    public function getRoutesAttribute()
    {
        return isset($this->params['route_name']) ? $this->params['route_name'] : [];
    }

    /**
     * Check the parent menu
     *
     * @return bool
     */
    public function isParent()
    {
        return $this->child->isNotEmpty();
    }

    /**
     * Make decission for link active
     *
     * @return bool
     */
    public function isLinkActive()
    {
        if (! $this->isParent()) {
            return in_array(\Request::route()->getName(), $this->routes);
        }

        foreach ($this->child as $child) {
            if (in_array(\Request::route()->getName(), $child->routes)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get menus
     *
     * @param  int  $id
     * @return object
     */
    public static function menus($id)
    {
        return parent::with(['child'])->where(['menu' => $id, 'parent' => 0])->orderby('sort', 'asc')->get();
    }
}
