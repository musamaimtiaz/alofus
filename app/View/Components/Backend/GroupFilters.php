<?php

namespace App\View\Components\Backend;

use Illuminate\View\Component;

class GroupFilters extends Component
{
    /**
     * The groups.
     *
     * @var array
     */
    public $groups;

    /**
     * The column.
     *
     * @var string
     */
    public $column;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($groups = [], $column = '')
    {
        $this->groups = $groups;
        $this->column = $column;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.backend.group-filters');
    }

    /**
     * Whether the component should be rendered
     */
    public function shouldRender(): bool
    {
        // if there are no groups, don't render the component
        return ! empty($this->groups);
    }
}
