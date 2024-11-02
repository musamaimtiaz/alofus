<?php

namespace Modules\FormBuilder\Services;

class RolesProvider
{
    /**
     * Return the array of roles in the format
     *
     * [
     * 	 1 => 'Role Name',
     * ]
     */
    public function __invoke(): array
    {
        return [
            1 => 'Default',
        ];
    }
}
