<?php

if (! function_exists('addonThumbnail')) {
    function addonThumbnail($name)
    {
        $path = implode(DIRECTORY_SEPARATOR, ['Modules', $name, 'Resources', 'assets', 'thumbnail.png']);

        if (file_exists($path)) {
            return url($path);
        }

        return url(implode(DIRECTORY_SEPARATOR, ['Modules', 'Addons', 'Resources', 'assets', 'thumbnail.png']));
    }
}

if (! function_exists('settingsModalLink')) {
    function settingsModalLink($option)
    {
        if (isset($option['url']) && Route::has($option['url'])) {
            return route($option['url']);
        } elseif (! isset($option['url'])) {
            return 'javascript:void()';
        } else {
            return $option['url'];
        }
    }
}

if (! function_exists('settingModalStatus')) {
    function settingModalStatus($option)
    {
        if (isset($option['type'])) {
            if ($option['type'] == 'modal') {
                return true;
            }
        }

        return false;
    }
}
