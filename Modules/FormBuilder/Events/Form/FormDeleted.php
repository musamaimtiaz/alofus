<?php

namespace Modules\FormBuilder\Events\Form;

use Modules\FormBuilder\Entities\Form;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

class FormDeleted
{
    use Queueable;
    use SerializesModels;

    /**
     * The deleted form
     *
     * @var Modules\FormBuilder\Models\Form
     */
    public $form;

    /**
     * Create a new event instance.
     *
     * @param  Modules\FormBuilder\Models\Form  $form
     * @return void
     */
    public function __construct(Form $form)
    {
        $this->form = $form;
    }
}
