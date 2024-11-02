<?php

namespace Modules\CMS\Entities;

use App\Models\Model;
use App\Traits\ModelTraits\hasFiles;

class Page extends Model
{
    use hasFiles;

    protected $fillable = ['name', 'slug', 'description', 'status', 'meta_title', 'layout', 'type', 'meta_description', 'default'];

    public function scopeSlug($query, $slug)
    {
        $query->where('slug', $slug);
    }

    public function scopeHome($query)
    {
        $query->where('type', 'home');
    }

    public function scopeDefault($query, $flag = 1)
    {
        $query->where('default', $flag);
    }

    public function components()
    {
        return $this->hasMany(\Modules\CMS\Entities\Component::class);
    }

    public function storeFiles()
    {
        return $this->uploadFiles(
            [
                'isUploaded' => false,
                'isOriginalNameRequired' => true,
                'isMediaManager' => true,
                'thumbnail' => false,
                'url' => true,
                'pagebuilder' => true,
            ]
        );
    }
}
