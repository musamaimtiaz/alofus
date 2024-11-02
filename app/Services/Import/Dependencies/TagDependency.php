<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md Abdur Rahaman Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 08-12-2022
 */

namespace App\Services\Import\Dependencies;

use App\Models\Tag;

class TagDependency
{
    /**
     * @var bool
     */
    protected $createNewEnabled = true;

    /**
     * @var array
     */
    protected $tags = [];

    public function __construct()
    {
        Tag::select('name', 'id')->groupBy('name')->get()->map(function ($tag) {
            $this->pushTag($tag);
        });
    }

    /**
     * Process the given tag string
     *
     * @param  string  $tag
     * @return array;
     */
    public function process($tag)
    {
        $tags = array_filter(array_map('trim', explode(',', $tag)));

        if (count($tags) == 0) {
            return null;
        }

        $ids = [];

        foreach ($tags as $tag) {
            $ids[] =  $this->addTag($tag);
        }

        $ids = array_filter($ids);

        return $ids;
    }

    /**
     * Get tag id by tag name
     *
     * @param  string  $name
     * @return mixed
     */
    protected function getTagIdByName($name)
    {
        return $this->tagExists($name) ? $this->tags[$name] : false;
    }

    /**
     * Add new tag
     *
     * @param  string  $tag
     * @return array|null
     */
    protected function addTag($tag)
    {
        if (! $this->tagExists($tag) && $this->canCreate()) {
            $id = $this->createNewTag($tag);
        } else {
            $id = $this->getTagIdByName($tag);
        }

        return $id ?? null;
    }

    /**
     * Check if the tag already exists
     *
     * @param  string  $tag
     * @return bool
     */
    protected function tagExists($tag)
    {
        return isset($this->tags[$tag]);
    }

    /**
     * Create new tag using tag name
     *
     * @param  string  $name
     * @return int
     */
    protected function createNewTag($name)
    {
        $tag = Tag::firstOrCreate([
            'name' => $name,
        ]);

        $this->pushTag($tag);

        return $tag->id;
    }

    /**
     * Push tag to to the list
     *
     * @param  Tag  $tag
     * @return void
     */
    protected function pushTag($tag)
    {
        $this->tags[$tag->name] = $tag->id;
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
