<?php

namespace Modules\Gateway\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gateway extends Model
{
    use HasFactory;

    protected $fillable = ['alias', 'name', 'sandbox', 'data', 'instruction', 'image', 'status'];

    protected static function newFactory()
    {
        return \Modules\Gateway\Database\factories\GatewayFactory::new();
    }

    /**
     * Add condition to return the specific module data
     * when calling this function from a Child Module class
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeThis($query)
    {
        return $query->where('alias', $this->classNameLower());
    }

    /**
     * Filter modules by status
     */
    public function scopeActive($query, $status = 1)
    {
        $query->where('status', $status);
    }

    /**
     * Get the class name. If any child class object
     * like (Paypal/Stripe) calls this then it returns the child class name
     */
    public function getClassName()
    {
        return class_basename($this);
    }

    /**
     * Get class name in lower case
     */
    public function classNameLower()
    {
        return strtolower($this->getClassName());
    }

    /**
     * Get the image of the module
     */
    public function getImageAttribute()
    {
        return addonThumbnail($this->attributes['name']);
    }

    public function getDataAttribute()
    {
        return json_decode($this->attributes['data']);
    }
}
