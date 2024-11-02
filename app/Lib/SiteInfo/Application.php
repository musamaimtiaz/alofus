<?php

namespace App\Lib\SiteInfo;

use Modules\Addons\Entities\Addon;

class Application
{
    private array $database = [];

    public function getInfo(): array
    {
        $this->database['version'] = $this->getVersion();
        $this->database['active_addons'] = $this->getActiveAddons();
        $this->database['inactive_addons'] = $this->getInactiveAddons();

        return $this->database;
    }

    public function getVersion(): string
    {
        return martvillVersion();
    }

    public function getActiveAddons(): array
    {
        $addons = Addon::all();
        $enabledAddons = [];

        $enabledAddons = array_filter($addons, function ($addon) {
            return ! $addon->get('core') && $addon->isEnabled();
        });

        $enabledAddons = array_map(function ($addon) {
            return ($addon->get('display_name') != null) ? $addon->get('display_name') : $addon->get('name');
        }, $enabledAddons);

        return ['count' => count($enabledAddons), 'names' => implode(', ', $enabledAddons)];
    }

    public function getInactiveAddons(): array
    {
        $addons = Addon::all();
        $enabledAddons = [];

        $enabledAddons = array_filter($addons, function ($addon) {
            return ! $addon->get('core') && $addon->isDisabled();
        });

        $enabledAddons = array_map(function ($addon) {
            return ($addon->get('display_name') != null) ? $addon->get('display_name') : $addon->get('name');
        }, $enabledAddons);

        return ['count' => count($enabledAddons), 'names' => implode(', ', $enabledAddons)];
    }
}
