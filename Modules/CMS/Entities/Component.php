<?php

namespace Modules\CMS\Entities;

use App\Models\Model;
use App\Traits\ModelTraits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Component extends Model
{
    use Cachable;
    use HasFactory;

    protected $fillable = ['page_id', 'layout_id', 'level'];

    public function properties()
    {
        return $this->hasMany(\Modules\CMS\Entities\ComponentProperty::class, 'component_id', 'id');
    }

    public function page()
    {
        return $this->belongsTo(\Modules\CMS\Entities\Page::class);
    }

    public function layout()
    {
        return $this->belongsTo(\Modules\CMS\Entities\Layout::class);
    }

    public static function componentReorder($page_id, $oldLevel, $newLevel)
    {
        $updatableComponents = self::where('page_id', $page_id);
        if ($oldLevel) {
            if ($newLevel == $oldLevel) {
                return;
            } elseif ($newLevel > $oldLevel) {
                $updatableComponents->where('level', '>', $oldLevel)
                    ->where('level', '<=', $newLevel)
                    ->decrement('level');
            } else {
                $updatableComponents->where('level', '<', $oldLevel)
                    ->where('level', '>=', $newLevel)
                    ->increment('level');
            }
        } else {
            $updatableComponents->where('level', '>=', $newLevel)->increment('level');
        }

    }

    public function __get($name)
    {
        $result = parent::__get($name);

        if ($result) {
            return $result;
        }

        if (! $this->propertiesLoaded()) {
            return $result;
        }

        $this->generatePropertiesArray();

        return isset($this->relations['propertiesArray'][$name]) ? $this->relations['propertiesArray'][$name] : $result;
    }

    public function __isset($name)
    {
        $result = parent::__get($name);

        if ($result) {
            return $result;
        }

        if (! $this->propertiesLoaded()) {
            return $result;
        }

        $this->generatePropertiesArray();

        return $this->isPropertiesArrayGenerated() && isset($this->relations['propertiesArray'][$name]);
    }

    private function propertiesLoaded()
    {
        return isset($this->relations['properties']);
    }

    private function isPropertiesArrayGenerated()
    {
        return isset($this->relations['propertiesArray']);
    }

    private function generatePropertiesArray()
    {
        if ($this->propertiesLoaded() && ! $this->isPropertiesArrayGenerated()) {
            $this->relations['propertiesArray'] = $this->relations['properties']->pluck('value', 'name');
        }
    }

    private function getPropertiesArray()
    {
        return $this->propertiesLoaded() ? $this->relations['propertiesArray'] : [];
    }
}
