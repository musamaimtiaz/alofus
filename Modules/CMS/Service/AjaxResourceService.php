<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md Abdur Rahaman Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 26-10-2022
 */

namespace Modules\CMS\Service;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Vendor;

class AjaxResourceService
{
    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $query;

    /**
     * Construct AjaxResourceService
     *
     * @param  Request  $request
     * @return void
     */
    public function __construct($request)
    {
        $method = $request->column;
        $this->query = $request->q;
        $methodArray = explode(' ', $method);
        $method = implode('', $methodArray);
        $this->method = $method;
    }

    /**
     * Get request data resource
     *
     * @return null|Collection
     */
    public function get()
    {
        if (! method_exists($this, $this->method)) {
            return false;
        }

        return call_user_func([$this, $this->method]);
    }

    /**
     * Finds brand by name
     *
     * @return null|Collection
     */
    protected function brand()
    {
        $brands = Brand::select('name', 'id')->active()->whereLike('name', $this->query)->get();

        return $brands;
    }

    /**
     * Finds brand by Id
     *
     * @return null|Collection
     */
    protected function brandById()
    {
        $brands = Brand::select('name', 'id')->active();
        if (is_array($this->query)) {
            $brands->whereIn('id', $this->query);
        } else {
            $brands->whereId($this->query);
        }

        return $brands->get();
    }

    /**
     * Finds brand by Id
     *
     * @return null|Collection
     */
    protected function categoryById()
    {
        $categories = Category::select('name', 'id')->active();
        if (is_array($this->query)) {
            $categories->whereIn('id', $this->query);
        } else {
            $categories->whereId($this->query);
        }

        return $categories->get();
    }

    /**
     * Finds category by name
     *
     * @return null|Collection
     */
    protected function category()
    {
        $categories = Category::select('name', 'id')->active()->whereLike('name', $this->query)->get();

        return $categories;
    }

    /**
     * Finds vendor by name
     *
     * @return null|Collection
     */
    protected function vendor()
    {
        $vendors = Vendor::select('name', 'id')->active()->whereLike('name', $this->query)->get();

        return $vendors;
    }

    /**
     * Finds vendor by Id
     *
     * @return null|Collection
     */
    protected function vendorById()
    {
        $vendors = Vendor::select('name', 'id')->active();
        if (is_array($this->query)) {
            $vendors->whereIn('id', $this->query);
        } else {
            $vendors->whereId($this->query);
        }

        return $vendors->get();
    }

    /**
     * Finds tags by name
     *
     * @return null|Collection
     */
    protected function tag()
    {
        $vendors = Tag::select('name', 'id')->active()->whereLike('name', $this->query)->get();

        return $vendors;
    }

    /**
     * Finds tags by Id
     *
     * @return null|Collection
     */
    protected function tagById()
    {
        $tags = Tag::select('name', 'id')->active();
        if (is_array($this->query)) {
            $tags->whereIn('id', $this->query);
        } else {
            $tags->whereId($this->query);
        }

        return $tags->get();
    }
}
