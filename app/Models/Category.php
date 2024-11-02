<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 28-07-2021
 */

namespace App\Models;

use App\Rules\CheckValidFile;
use App\Traits\ModelTraits\hasFiles;
use App\Services\Category\CategoryCategorizationService;
use Modules\MediaManager\Http\Models\ObjectFile;
use Validator;
use URL;

class Category extends Model
{
    use hasFiles;

    protected $fillable = ['name', 'slug', 'order_by'];

    /**
     * Default number of post to fetch from database
     */
    private static $limit = 10;

    /**
     * Foreign key with Category model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id');
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return URL::to('/');
    }

    /**
     * Relation with Category model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function availableChildrenCategory()
    {
        return $this->categories()->where('status', 'Active');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->hasMany('App\Models\Category', 'parent_id', 'id')->with('categories');
    }

    /**
     * vendor category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vendorCategory()
    {
        return $this->hasMany('App\Models\VendorCategory', 'category_id', 'id');
    }

    public function vendorChildCategory()
    {
        return $this->hasMany('App\Models\VendorCategory', 'category_id', 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function availableMainCategory()
    {
        return $this->childrenCategories()->where('status', 'Active');
    }

    /**
     * Relation with Category model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childrenCategories()
    {
        return $this->hasMany('App\Models\Category', 'parent_id', 'id')->with('categories', 'vendorChildCategory');
    }

    /**
     * Return all parents product
     *
     * @return array
     */
    public static function parents($type = 'web')
    {
        $categories = Category::whereNull('parent_id')->where('is_global', 1)->with('childrenCategories');
        if ($type == 'web') {
            $categories = $categories->where('status', 'Active');
        }

        return $categories->get();
    }

    /**
     * Relation with CategoryAttribute model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoryAttribute()
    {
        return $this->hasMany('App\Models\CategoryAttribute', 'category_id', 'id');
    }

    /**
     * Relation with ProductCategory model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productCategory()
    {
        return $this->hasMany('App\Models\ProductCategory', 'category_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function image()
    {
        return $this->hasOne('App\Models\File', 'object_id')->where('object_type', 'CATEGORY');
    }

    /**
     * Foreign key with Category model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_categories');
    }

    /**
     * Foreign key with product with order model
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasManyThrough
     */
    public function productOrder()
    {
        return $this->hasManyThrough(OrderDetail::class, ProductCategory::class, 'category_id', 'product_id', 'id', 'product_id');
    }

    /**
     * Not Uncategory
     *
     * @return mixed
     */
    public function scopeNotUncategory($query, $col = 'id', $uncategoryId = 1)
    {
        return $query->where($col, '!=', $uncategoryId);
    }

    /**
     * Store Validation
     *
     * @param  array  $data
     * @return mixed
     */
    protected static function storeValidation($data = [])
    {
        $validator = Validator::make($data, [
            'name' => 'required|min:3|max:100',
            'parent_id' => ['nullable', 'exists:categories,id'],
            'slug' => 'required|max:120|unique:categories,slug',
            'status' => 'required|in:Active,Inactive',
            'is_searchable' => 'required|in:1,0',
            'is_featured' => 'required|in:1,0',
            'sell_commissions' => 'nullable|numeric',
            'image'  => [new CheckValidFile(getFileExtensions(3))],
        ]);

        return $validator;
    }

    /**
     * Update Validation
     *
     * @return mixed
     */
    protected static function updateValidation($data, $id)
    {
        $validator = Validator::make($data, [
            'name' => 'required|min:3|max:100',
            'parent_id' => ['nullable', 'exists:categories,id'],
            'slug' => [
                'required',
                'unique:categories,slug,' . $id,
            ],
            'status' => 'required|in:Active,Inactive',
            'is_searchable' => 'required|in:1,0',
            'is_featured' => 'required|in:1,0',
            'sell_commissions' => 'nullable|numeric',
            'image'  => [new CheckValidFile(getFileExtensions(3))],
        ]);

        return $validator;
    }

    /**
     * Store
     *
     * @param  array  $data
     * @return int|null
     */
    public function store($data = [])
    {
        $id = parent::insertGetId($data);
        $fileIds = [];

        if (request()->has('file_id')) {
            foreach (request()->file_id as $data) {
                $fileIds[] = $data;
            }
        }

        ObjectFile::storeInObjectFiles($this->objectType(), $this->objectId(), $fileIds);

        if (! empty($id)) {
            self::forgetCache();

            return $id;
        }

        return false;
    }

    /**
     * Update Category
     *
     * @param  array  $data
     * @param  null  $id
     * @return bool
     */
    public function updateCategory($data = [], $id = null)
    {
        $result = parent::where('id', $id);

        if ($result->exists()) {
            $result->update($data);
            $result->first()->updateFiles(['isUploaded' => false, 'isOriginalNameRequired' => true]);
            self::forgetCache();

            return true;
        }

        return false;
    }

    /**
     * Delete
     *
     * @param  int  $id
     * @return array
     */
    public function remove($id = null)
    {
        $data = ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];
        $record = parent::find($id);

        if (! empty($record)) {
            if ($record->product_counts > 0) {
                $data['message'] = __('Can not be deleted. This category has records!');

                return $data;
            } elseif (isset($record->childrenCategories)) {
                $childProductCount = $record->childrenCategories->where('product_counts', '>', 0)->pluck('id')->toArray();
                $childOne = $record->childrenCategories->pluck('id')->toArray();
                $childTwo = Category::whereIn('parent_id', $childOne)->where('product_counts', '>', 0)->pluck('id')->toArray();
                if (count($childProductCount) > 0 || count($childTwo) > 0) {
                    $data['message'] = __('Can not be deleted. This category has records!');

                    return $data;
                }
            }

            $record->delete();

            try {
                //delete file region
                $record->deleteFiles();
                //end region
                $data['status'] = 'success';
                $data['message'] = __('The :x has been successfully deleted.', ['x' => __('Category')]);
            } catch (Exception $e) {
                $data['message'] = $e->getMessage();
            }
        }

        return $data;
    }

    /**
     * update node position
     *
     * @param  array  $data
     * @return bool
     */
    public function nodeUpdate($data = [])
    {
        $position = $data['position'] + 1;
        $oldPosition = $data['old_position'] + 1;
        $parentId = $data['parent_id'] != '#' ? $data['parent_id'] : null;
        $oldParentId = $data['old_parent_id'] != '#' ? $data['old_parent_id'] : null;
        $category = parent::find($data['id']);

        if (! empty($category)) {
            $category->parent_id = $parentId;
            $category->order_by = $position;
            $category->save();
            self::forgetCache();

            if ($this->reOrder($data['id'], $parentId, $oldParentId, $position, $oldPosition)) {
                self::forgetCache();

                return true;
            }
        }

        return false;
    }

    /**
     * re-order node position
     *
     * @param  null  $id
     * @param  null  $parentId
     * @param  null  $oldParentId
     * @param  null  $position
     * @param  null  $oldPosition
     * @return bool
     */
    public function reOrder($id = null, $parentId = null, $oldParentId = null, $position = null, $oldPosition = null)
    {
        $flagReorder = 0;

        if ($parentId != null) {
            $new = 1;
            $parentReorder = parent::where('parent_id', $parentId)->orderBy('order_by', 'ASC')->get();

            foreach ($parentReorder as $key => $order) {
                if ($order->id != $id) {
                    parent::where('id', $order->id)->update(['order_by' => $new >= $position ? ++$new : $new++]);
                }
            }
            $flagReorder = 1;
        }

        if ($parentId != $oldParentId || $parentId == null) {
            if ($oldParentId == null || $parentId == null) {
                $root = 1;
                $RootParent = parent::whereNull('parent_id')->orderBy('order_by', 'ASC')->get();

                foreach ($RootParent as $rootOrder) {
                    if ($rootOrder->id != $id) {
                        if ($flagReorder == 1) {
                            parent::where('id', $rootOrder->id)->update(['order_by' => $root++]);
                        } else {
                            parent::where('id', $rootOrder->id)->update(['order_by' => $root >= $position ? ++$root : $root++]);
                        }
                    }
                }
            }
            if ($oldParentId != null) {
                $rootFromChild = 1;
                $RootParentFromChild = parent::where('parent_id', $oldParentId)->orderBy('order_by', 'ASC')->get();

                foreach ($RootParentFromChild as $FromChild) {
                    parent::where('id', $FromChild->id)->update(['order_by' => $rootFromChild++]);
                }
            }
        }

        return true;
    }

    /**
     * Best category of the month
     *
     * @param  int  $limit
     * @return collection
     */
    public static function bestSellerCategories($limit = null)
    {
        return (new CategoryCategorizationService())
            ->setLimit(self::getLimit($limit))
            ->bestSellerCategories()->get();
    }

    /**
     * Random category
     *
     * @param  int  $limit
     * @return collection
     */
    public static function randomCategories($limit = null)
    {
        return (new CategoryCategorizationService())
            ->noCache()
            ->setLimit(self::getLimit($limit))
            ->randomCategories()->get();
    }

    /**
     * Popular category
     *
     * @param  int  $limit
     * @return collection
     */
    public static function popularCategories($limit = null)
    {
        return (new CategoryCategorizationService())
            ->setLimit(self::getLimit($limit))
            ->popularCategories()->get();
    }

    /**
     * Selected category
     *
     * @param  int  $limit  Limit
     * @param  array  $categories  Array of category ids
     * @return collection
     */
    public static function selectedCategories($limit = null, $categories = [])
    {
        return (new CategoryCategorizationService())
            ->setLimit(self::getLimit($limit))
            ->selectedCategories($categories)->get();
    }

    /**
     * Active categories
     *
     * @param  array  $fields
     * @return collection
     */
    public static function activeCategories($fields = ['id', 'name'])
    {
        return parent::where('status', 'Active')->select($fields)->get();
    }

    /**
     * Return the maximum limit
     *
     * @param  int|null  $limit
     * @return int
     */
    private static function getLimit($limit = null)
    {
        return $limit && $limit > 0 ? $limit : self::$limit;
    }

    /**
     * Get category type options
     *
     * @return array
     */
    public static function categoryCategory()
    {
        return [
            'selectedCategories' => __('Selected Categories'),
            'bestSellerCategories' => __('Best Seller Categories'),
            'popularCategories' => __('Popular Categories'),
            'randomCategories' => __('Random Categories'),

        ];
    }
}
