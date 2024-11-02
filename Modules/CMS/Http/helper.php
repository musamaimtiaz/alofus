<?php

if (! function_exists('totalSimilarProducts')) {
    /**
     * Check how many similar items are in the same section
     *
     * @param  object  $data
     * @param  string  $field  Basic field name
     * @return int|bool
     */
    function totalSimilarProducts($data, $field)
    {
        if (! isset($data)) {
            return false;
        }
        $count = 1;
        while (true) {
            if (! $data->{$field . $count}) {
                break;
            }
            $count++;
        }

        return $count - 1;
    }
}

if (! function_exists('randomString')) {
    /**
     * Generate random string
     *
     * @param  int  $length
     * @return string
     */
    function randomString($length = 5)
    {
        return substr(str_shuffle('examghfgh786868plestringletsgo'), 0, $length);
    }
}

if (! function_exists('slugMe')) {
    /**
     * Slugify string
     *
     * @param  string|array  $string
     *                                $return $string
     */
    function slugMe($string)
    {
        if (is_array($string)) {
            $slug = '';
            foreach ($string as $str) {
                $slug .= slugMe($str) . '-';
            }

            return $slug;
        }

        return str_replace(' ', '-', $string);
    }
}

if (! function_exists('getBlockThumbnail')) {
    /**
     * Get block thumbnail
     *
     * @param  string  $file
     * @return string
     */
    function getBlockThumbnail($file = '')
    {
        if (strlen($file) < 1) {
            return implode('/', [url('/'), defaultImage('items')]);
        }

        return asset('Modules/CMS/Resources/assets/img/blocks/' . $file);
    }
}

if (! function_exists('formatString')) {
    /**
     * Format string to a specific length
     *
     * @param  string  $string
     * @param  int  $length
     * @return string
     */
    function formatString($string, $length = 75)
    {
        if (strlen($string) <= $length) {
            return $string;
        }

        return substr($string, 0, $length - 3) . '...';
    }
}
