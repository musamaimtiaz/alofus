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
use App\Traits\ModelTraits\hasFiles;
use Illuminate\Support\Facades\DB;
use Modules\MediaManager\Http\Models\ObjectFile;

class Blog extends Model
{
    use hasFiles;
    use ModelTrait;

    /**
     * Default number of blogs to fetch from database
     */
    private static $limit = 9;

    public function image()
    {
        return $this->hasOne('App\Models\File', 'object_id')->where('object_type', 'blogs');
    }

    public function objectImage()
    {
        return $this->hasOne('Modules\MediaManager\Http\Models\ObjectFile', 'object_id')->where('object_type', 'blogs');
    }

    /**
     * Relation with User Model
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * Relation with blogCategory Model
     */
    public function blogCategory()
    {
        return $this->belongsTo('Modules\Blog\Http\Models\BlogCategory', 'category_id');
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
            $fileIds = [];
            if (request()->has('file_id')) {
                foreach (request()->file_id as $data) {
                    $fileIds[] = $data;
                }
            }
            ObjectFile::storeInObjectFiles($this->objectType(), $this->objectId(), $fileIds);

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
    public function updateBlog($data = [], $id = null)
    {
        $result = $this->where('id', $id);
        if ($result->exists()) {
            if ($result->update($data)) {
                if (request()->file_id) {
                    return $result->first()->updateFiles(['isUploaded' => false, 'isOriginalNameRequired' => true, 'thumbnail' => true]);
                } else {
                    return $result->first()->deleteFromMediaManager();
                }
            }
        }

        return false;
    }

    public function getAllBlogDT($from = null, $to = null, $categoryId = null, $authorId = null)
    {
        $result = Blog::with(['user', 'blogCategory'])->orderBy('created_at', 'desc');
        if (! empty($from)) {
            $result->whereDate('created_at', '>=', DbDateFormat($from));
        }
        if (! empty($to)) {
            $result->whereDate('created_at', '<=', DbDateFormat($to));
        }
        if (! empty($categoryId)) {
            $result->where('category_id', $categoryId);
        }

        if (! empty($authorId)) {
            $result->where('user_id', $authorId);
        }

        return $result;
    }

    /**
     * Get the latest blogs
     *
     * @param  int  $limit
     * @return collection
     */
    public static function latestBlogs($limit = null)
    {
        return parent::take(self::getLimit($limit))->latest()->with('user')->get();
    }

    /**
     * Get the selected blogs
     *
     * @param  int  $limit
     * @param  array  $ids
     * @return collection
     */
    public static function selectedBlogs($limit = null, $ids = [])
    {
        return parent::with('user')
            ->whereIn('id', $ids)
            ->limit(self::getLimit($limit))
            ->orderBy(DB::raw('FIELD(id, ' . implode(',', $ids) . ')'))
            ->get();
    }

    /**
     * Scope a query to only archives filters
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeArchiveFilter($query, $filters)
    {
        if ($filters && $filters['year']) {
            $query->whereYear('created_at', $filters['year']);
        }
    }

    /**
     * Scope a query to only include active posts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeActivePost($query)
    {
        $query->where('status', 'active');
    }

    /**
     * Get archives
     *
     * @return collection
     */
    public static function archives()
    {
        $archives = Blog::whereHas('blogCategory', function ($query) {
            $query->where('status', 'Active');
        })->SelectRaw('YEAR(created_at) as year, COUNT(id) as post_count')
            ->where('status', 'Active')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();

        return $archives;
    }

    /**
     * Return the maximum limit
     *
     * @param  int|null  $limit
     * @return int
     */
    public static function getLimit($limit = null)
    {
        return $limit && $limit > 0 ? $limit : self::$limit;
    }

    /**
     * Query and get active brands
     *
     * @return Collection|null
     */
    public static function getActiveBlogs()
    {
        return static::select('id', 'title')->active()->get();
    }
}
