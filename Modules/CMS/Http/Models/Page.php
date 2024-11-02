<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Kabir Ahmed <[kabir.techvill@gmail.com]>
 *
 * @created 26-12-2021
 */

namespace Modules\CMS\Http\Models;

use App\Models\Model;
use App\Traits\ModelTrait;
use App\Traits\ModelTraits\hasFiles;
use Modules\MediaManager\Http\Models\ObjectFile;

class Page extends Model
{
    use hasFiles;
    use ModelTrait;

    protected $fillable = ['name', 'slug', 'description', 'status', 'vendor_id', 'meta_title', 'default', 'layout', 'type', 'meta_description', 'default'];

    /**
     * Relation wirh File Model
     *
     * @var bool
     */
    public function image()
    {
        return $this->hasOne('App\Models\File', 'object_id')->where('object_type', 'pages');
    }

    /**
     * store
     *
     * @param  array  $data
     * @return bool
     */
    public function store($data = [])
    {
        $page = parent::create($data);
        if ($page->default) {
            $this->updateDefault($page->id);
        }

        $fileIds = [];
        if (request()->has('file_id')) {
            foreach (request()->file_id as $data) {
                $fileIds[] = $data;
            }
        }
        ObjectFile::storeInObjectFiles($this->objectType(), $this->objectId(), $fileIds);
        self::forgetCache(['pages']);

        return $page->id;
    }

    /**
     * Update
     *
     * @param  array  $data
     * @param  int  $id
     * @return bool
     */
    public function updatePage($data = [], $id = null)
    {
        $result = $this->where('id', $id);

        if ($result->exists()) {
            if ($result->update($data)) {
                self::forgetCache(['pages']);
                $result->first()->updateFiles(['isUploaded' => false, 'isOriginalNameRequired' => true, 'thumbnail' => true]);

                return true;
            }
        }

        return false;

    }

    /**
     * delete
     *
     * @param  int  $id
     * @return array
     */
    public function remove($id = null)
    {
        $page = Page::where('id', $id)->first();
        if (empty($page)) {
            $data = ['status' => 'fail', 'message' => __('page does not found.')];
        } else {
            $page->delete();
            $data = ['status' => 'success', 'message' => __('Page has been successfully deleted.')];
        }
        self::forgetCache(['pages']);

        return $data;
    }

    /**
     * Pages
     *
     * @return array
     */
    public static function getAllPages()
    {
        return Page::where('status', 'Active')->get();
    }

    /**
     * Pages except home page
     *
     * @return collection
     */
    public function pages()
    {
        return Page::where('type', '!=', 'home')->get();
    }

    /**
     * Update default status
     *
     * @param int id
     */
    public function updateDefault($id)
    {
        $parent = parent::where('id', '!=', $id)->where('default', 1);

        if (str_contains(request()->url(), 'vendor/')) {
            $parent = $parent->where('vendor_id', auth()->user()->vendor()->vendor_id);
        }

        return $parent->update(['default' => 0]);
    }
}
