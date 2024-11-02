<?php

namespace Modules\FormBuilder\Traits;

use Modules\FormBuilder\Entities\Form;
use Modules\FormBuilder\Entities\Submission;

trait HasFormBuilderTraits
{
    /**
     * A User can have one or many forms
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function forms()
    {
        return $this->hasMany(Form::class);
    }

    /**
     * A User can have one or many submission
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
