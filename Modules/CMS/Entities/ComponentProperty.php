<?php

namespace Modules\CMS\Entities;

use App\Models\Model;
use App\Traits\ModelTraits\Cachable;
use App\Traits\ModelTraits\hasFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ComponentProperty extends Model
{
    use Cachable;
    use HasFactory;
    use hasFiles;

    public $timestamps = false;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\CMS\Database\factories\ComponentPropertyFactory::new();
    }

    public function component()
    {
        return $this->belongsTo(Component::class);
    }

    public function getValueAttribute()
    {
        $value = $this->attributes['value'];
        if ($this->attributes['type'] == 'array') {
            return json_decode($value, 1);
        }

        return $value;
    }

    public function getObjectType()
    {
        return $this->objectType();
    }

    public function getObjectId()
    {
        return $this->objectId();
    }
}
