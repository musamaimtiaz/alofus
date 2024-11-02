<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Kabir Ahmed <[kabir.techvill@gmail.com]>
 *
 * @created 30-12-2021
 */

namespace Modules\Blog\Http\Models;

use App\Models\Model;
use App\Traits\ModelTrait;

class BlogCategory extends Model
{
    use ModelTrait;

    public function blog()
    {
        return $this->hasMany('Modules\Blog\Http\Models\Blog', 'category_id');
    }

    /**
     * store
     *
     * @param  array  $data
     * @return bool
     */
    public function store($data = [])
    {
        if (parent::insertGetId($data)) {
            return true;
        }

        return false;
    }

    /**
     * Update
     *
     * @param  array  $data
     * @param  int  $id
     * @return array
     */
    public function updateCategory($data = [])
    {
        $result = $this->where('id', $data['id']);
        if ($result->exists()) {
            $result->update($data);

            return true;
        }

        return false;
    }

    protected function getAllBlogCategory($name = null, $status = null)
    {
        $blog = BlogCategory::select('id', 'name', 'status', 'created_at')->orderBy('created_at', 'desc');
        if (! empty($name)) {
            $blog->where('name', $name);
        }
        if (! empty($status)) {
            $blog->where('status', $status);
        }

        return $blog;

    }
}
