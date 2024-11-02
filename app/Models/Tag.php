<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use ModelTrait;

    protected $fillable = ['name', 'vendor_id', 'status'];

    /**
     * Relation with ProductTag model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productTag()
    {
        return $this->hasMany('App\Models\ProductTag', 'tag_id', 'id');
    }

    /**
     * Store
     *
     * @return false
     */
    public function store($data = [])
    {
        $id = parent::insertGetId($data);

        if (! empty($id)) {
            self::forgetCache();

            return $id;
        }

        return false;
    }
}
