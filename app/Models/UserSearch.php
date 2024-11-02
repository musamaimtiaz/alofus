<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class UserSearch extends Model
{
    use ModelTrait;

    /**
     * relation with search table
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function search()
    {
        return $this->belongsTo('App\Models\Search', 'search_id');
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
            return $id;
        }

        return false;
    }
}
