<?php

namespace Modules\CMS\Service;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;
use Modules\Blog\Http\Models\Blog;
use Modules\CMS\Entities\Page;
use Modules\CMS\Http\Models\Slide;
use Modules\CMS\Http\Models\Slider;

class HomepageService
{
    /**
     * Returns dynamic homepage components
     *
     * @return mixed
     */
    public function home($vendorId = null)
    {
        $page = Page::query()
            ->when(! request('page'), fn ($query) => $query->default())
            ->when(request('page'), fn ($query) => $query->where('slug', request('page')))
            ->with(['components.properties', 'components.layout:id,file'])
            ->when(! is_null($vendorId), fn ($query) => $query->where('vendor_id', $vendorId))
            ->unless(! is_null($vendorId), fn ($query) => $query->whereNull('vendor_id'))
            ->when(true, function ($query) {
                $query->with(['components' => function ($query) {
                    $query->orderBy('level');
                }]);
            })
            ->first();

        return $page ?? false;
    }

    /**
     * Get specific category/type of products
     *
     * @param  string  $type  product category/type
     * @param  int  $limit  maximum number of product
     * @return mixed
     */
    public function getProducts($type, $limit = 10, $data = [])
    {
        try {
            return Product::$type($limit, $data) ?? [];
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * returns product types name
     *
     * @param  string  $name
     * @return string
     */
    public function getCategoryTitle($name)
    {
        $types = self::productTypes();
        if (isset($types[$name])) {
            return $types[$name];
        } else {
            return ucfirst($name);
        }
    }

    /**
     * Get sidebar file name
     *
     * @param  string  $type  Sidebar type
     * @return string View file name
     */
    public function getSidebar($type)
    {
        $sidebars = [
            'slider' => 'cms::partials.gridbox_slider',
            'slide' => 'cms::partials.gridbox_banner',
            'flash_sale' => 'cms::partials.flash',
        ];

        return isset($sidebars[$type]) ? $sidebars[$type] : null;
    }

    /**
     * Get category list of specific type
     *
     * @param  string  $type
     * @param  array  $ids
     * @return Collection
     */
    public function categories($type, $return = null, $limit = null, $ids = [])
    {
        try {
            if ($type == 'selectedCategories') {
                if (is_array($ids) && count($ids) > 0) {
                    return Category::selectedCategories($limit, $ids);
                }

                return $return;
            }

            return Category::$type($limit);
        } catch (\Exception $e) {
            return $return;
        }
    }

    /**
     * Get Brands list of specific type
     *
     * @param  string  $type
     * @param  array  $ids
     * @return Collection
     */
    public function brands($type, $return = null, $limit = null, $ids = [])
    {
        try {
            if ($type == 'selectedBrands') {
                if (is_array($ids) && count($ids) > 0) {
                    return Brand::selectedBrands($ids, $limit);
                }

                return $return;
            }

            return Brand::$type($limit);
        } catch (\Exception $e) {
            return $return;
        }
    }

    /**
     * Get blogs collection depending on the blog type
     *
     * @param  string  $type
     * @param  int  $limit
     * @param  mixed  $return
     * @param  array  $ids
     * @return mixed
     */
    public function getBlogs($type = 'latestBlogs', $limit = 10, $return = null, $ids = [])
    {
        try {
            if ($type == 'selectedBlogs') {
                return Blog::selectedBlogs($limit, $ids);
            }

            return Blog::$type($limit);
        } catch (\Exception $e) {
            return $return;
        }
    }

    /**
     * Get category type options
     *
     * @return array
     */
    public static function categoryOptions()
    {
        return Category::categoryCategory();
    }

    /**
     * Get brands type array
     *
     * @return array
     */
    public static function brandsOptions()
    {
        return Brand::brandCategory();
    }

    /**
     * Get Blogs type
     *
     * @return array
     */
    public static function blogsOptions()
    {
        return [
            'latestBlogs' => __('Latest Blogs'),
            'selectedBlogs' => __('Selected Blogs'),
        ];
    }

    public static function getCategoryList()
    {
        return Category::activeCategories();
    }

    /**
     * Get the active brand list
     *
     * @return null|collection
     */
    public static function getBrandsList()
    {
        $brands = Brand::getActiveBrands();
        if ($brands) {
            return $brands->pluck('name', 'id')->toArray();
        }

        return [];
    }

    /**
     * Get the active brand list
     *
     * @return null|collection
     */
    public static function getBlogsList()
    {
        $blogs = Blog::getActiveBlogs();
        if ($blogs) {
            return $blogs->pluck('title', 'id')->toArray();
        }

        return [];
    }

    public static function productTypes()
    {
        return Product::productCategoryOptions();
    }

    /**
     * Get column count
     *
     * @param  Model  $component
     * @param  int  $total
     * @return int
     */
    public function getColumnCount($component, $total = 10)
    {
        $row = intval($component->row);
        $col = intval($component->column);

        if ($col > 0 && $col <= 12) {
            return $col;
        }

        if ($row > 0) {
            $col = intval(ceil($total / $row));

            return $col == 0 ? 1 : $col;
        }

        return $total > 12 ? intval($total / 12) : $total;
    }

    /**
     * Get filterable data
     *
     * @param  string  $type
     * @param  string  $type
     * @return mixed
     */
    public function getFilterableData($type, $values)
    {

        $request = request();
        $request['column'] = $type . 'ById';
        $request['q'] = $values;

        $data = (new AjaxResourceService($request))->get();

        if (! $data) {
            return [];
        }

        return $data;
    }

    /**
     * Get all the sliders
     *
     * @return null|Collection
     */
    public function getSliders()
    {
        return Slider::select('name', 'slug')->active()->get();
    }

    /**
     * Get Slider
     *
     * @param  string  $slug
     * @return null|Collection
     */
    public function getSlider($slug)
    {
        return Slide::whereHas('slider', function ($query) use ($slug) {
            $query->where(['slug' => $slug, 'status' => 'Active']);
        })->get();
    }
}
