<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 25-07-2021
 */

namespace App\Models;

use App\Rules\CheckValidFile;
use App\Services\Brand\BrandCategorizingService;
use Modules\MediaManager\Http\Models\ObjectFile;
use Validator;
use App\Traits\ModelTrait;
use App\Traits\ModelTraits\hasFiles;

class Brand extends Model
{
    use hasFiles;
    use ModelTrait;

    /**
     * Default number of brands to fetch from database
     */
    private static $limit = 9;

    /**
     * Relation with Product model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function product()
    {
        return $this->hasMany('App\Models\Product', 'brand_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function image()
    {
        return $this->hasOne('App\Models\File', 'object_id')->where('object_type', 'BRAND');
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
            'name' => 'required|min:3|max:50|unique:brands,name',
            'status' => 'required|in:Active,Inactive',
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
            'name' => ['required', 'min:3', 'max:50', 'unique:brands,name,' . $id],
            'status' => 'required|in:Active,Inactive',
        ]);

        return $validator;
    }

    /**
     * Store
     *
     * @return false
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
     * Update Brand
     *
     * @param  array  $data
     * @param  null  $id
     * @return bool
     */
    public function updateBrand($data = [], $id = null)
    {
        $result = $this->where('id', $id);

        if ($result->exists()) {
            $result->update($data);

            if (request()->file_id) {
                $result->first()->updateFiles(['isUploaded' => false, 'isOriginalNameRequired' => true]);
            } else {
                $result->first()->deleteFromMediaManager();
            }

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
            try {
                $record->delete();
                //delete file region
                $record->deleteFiles();
                $data['status'] = 'success';
                $data['message'] = __('The :x has been successfully deleted.', ['x' => __('Brand')]);
            } catch (Exception $e) {
                $data['message'] = $e->getMessage();
            }
        }

        return $data;
    }

    /**
     * best seller
     *
     * @return mixed|null
     */
    public static function bestSeller($limit = null)
    {
        $brands = (new BrandCategorizingService())
            ->setLimit(self::getLimit($limit))
            ->bestSellerBrands()
            ->get();

        return $brands;
    }

    /**
     * popular brands
     *
     * @return mixed|null
     */
    public static function popularBrand($limit = null)
    {
        $brands = (new BrandCategorizingService())
            ->setLimit(self::getLimit($limit))
            ->popularBrands()
            ->get();

        return $brands;
    }

    /**
     * random brands
     *
     * @return mixed|null
     */
    public static function randomBrands($limit = null)
    {
        $brands = (new BrandCategorizingService())
            ->setLimit(self::getLimit($limit))
            ->randomBrands()
            ->get();

        return $brands;
    }

    /**
     * Selected Brands
     *
     * @param  array  $brands  Array of category ids
     * @return collection
     */
    public static function selectedBrands($brands = [], $limit = null)
    {
        return (new BrandCategorizingService())
            ->setLimit(self::getLimit($limit))
            ->selectedBrands($brands)->get();
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
     * Types of brand categories available
     *
     * @var array
     */
    public static function brandCategory()
    {
        return [
            'bestSeller' => __('Best Seller'),
            'popularBrand' => __('Popular Brands'),
            'randomBrands' => __('Random Brands'),
            'selectedBrands' => __('Selected Brands'),
        ];
    }

    /**
     * Query and get active brands
     *
     * @return Collection|null
     */
    public static function getActiveBrands()
    {
        return static::select('id', 'name')->active()->get();
    }
}
