<?php

namespace Modules\CMS\Entities;

use App\Models\Model;
use App\Traits\ModelTraits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LayoutType extends Model
{
    use Cachable;
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\CMS\Database\factories\LayoutTypeFactory::new();
    }

    public function layouts()
    {
        return $this->hasMany(Layout::class);
    }
}
