<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md Abdur Rahaman Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 19-11-2022
 */

namespace App\Services\Import\Dependencies;

use App\Models\Category as CategoryModel;

class Category
{
    /**
     * @var bool
     */
    protected $createNewEnabled = true;

    /**
     * @var array
     */
    protected $categories = [];

    /**
     * @var array
     */
    protected $slugs = [];

    /**
     * @var int
     */
    protected $orderByMin = 0;

    public function __construct()
    {
        CategoryModel::select('name', 'slug', 'order_by', 'id')->groupBy('name')->get()->map(function ($category) {
            $this->pushCategory($category);
            $this->orderByMin = min($this->orderByMin, $category->order_by);
        });
    }

    /**
     * Process the given category string
     *
     * @param  string|null  $category
     * @return array;
     */
    public function process($category = null)
    {
        if (is_null($category)) {
            return [1];
        }

        $temporary = explode('|', $category);

        if (count($temporary) == 0) {
            return [1];
        }

        $categories = explode(',', $temporary[0]);

        if (count($categories) == 0) {
            return null;
        }

        $ids = [];

        foreach ($categories as $category) {
            $ids[] =  $this->addCategory($category);
        }

        $ids = array_filter($ids);

        return count($ids) == 0 ? [1] : $ids;
    }

    /**
     * Get category id by category name
     *
     * @param  string  $name
     * @return mixed
     */
    protected function getCategoryIdByName($name)
    {
        return $this->categoryExists($name) ? $this->categories[$name] : false;
    }

    /**
     * Add new category
     *
     * @param  string  $category
     * @return array|null
     */
    protected function addCategory($category)
    {
        $categories = explode('>', $category);

        foreach ($categories as $category) {

            $category = trim($category);

            if (! $this->categoryExists($category) && $this->canCreate()) {
                $id = $this->createNewCategory($category);
            } else {
                $id = $this->getCategoryIdByName($category);
            }
        }

        return $id ?? null;
    }

    /**
     * Check if the category already exists
     *
     * @param  string  $category
     * @return bool
     */
    protected function categoryExists($category)
    {
        return isset($this->categories[$category]);
    }

    /**
     * Create new category using category name
     *
     * @param  string  $name
     * @return int
     */
    protected function createNewCategory($name)
    {
        $category = CategoryModel::create([
            'name' => $name,
            'slug' => $this->generateSlug($name),
            'order_by' => $this->orderByMin,
        ]);

        $this->pushCategory($category);

        return $category->id;
    }

    /**
     * Generate slug
     *
     * @param  string  $name
     * @return string
     */
    protected function generateSlug($name)
    {
        $counter = 1;
        $ext = '';
        do {
            $slug = \Str::slug($name) . $ext;
            $ext = '-' . $counter;
        } while ($this->slugExists($slug) && $counter++);

        return $slug;
    }

    /**
     * Check if the slug already exists
     *
     * @param  string  $slug
     * @return bool
     */
    protected function slugExists($slug)
    {
        return isset($this->slugs[$slug]);
    }

    /**
     * Push category to to the list
     *
     * @param  CategoryModel  $category
     * @return void
     */
    protected function pushCategory($category)
    {
        $this->categories[$category->name] = $category->id;
        array_push($this->slugs, $category->slug);
    }

    /**
     * Disable creating new instance
     *
     * @return self
     */
    public function disableCreateNew()
    {
        $this->createNewEnabled = false;

        return $this;
    }

    /**
     * Checks if creating new instance is enabled
     *
     * @return bool
     */
    protected function canCreate()
    {
        return $this->createNewEnabled;
    }
}
