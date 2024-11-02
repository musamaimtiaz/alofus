<?php

namespace Modules\MenuBuilder\Http\Models;

use App\Models\Model;
use URL;

class AdminMenus extends Model
{
    protected $table = 'menus';

    protected $fillable = ['name'];

    public function getUrl()
    {
        return URL::to('/');
    }
}
