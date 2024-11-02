<?php

if (! function_exists('array2string')) {
    function array2string($data)
    {
        $log_a = '';
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $log_a .= "\r\n'" . $key . "' => [\r\n" . array2string($value) . "\r\n],";
            } else {
                $log_a .= "'" . $key . "'" . ' => ' . "'" . str_replace("'", "\\'", $value) . "',\r\n";
            }
        }

        return $log_a;
    }
}

if (! function_exists('xss_clean')) {
    function xss_clean($data)
    {
        // Fix &entity\n;
        $data = str_replace(['&amp;', '&lt;', '&gt;'], ['&amp;amp;', '&amp;lt;', '&amp;gt;'], $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

        // Remove any attribute starting with "on" or xmlns
        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

        // Remove javascript: and vbscript: protocols
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

        // Remove namespaced elements (we do not need them)
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

        do {
            // Remove really unwanted tags
            $old_data = $data;
            $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
        } while ($old_data !== $data);

        return $data;
    }
}

if (! function_exists('sanitize_output')) {
    function sanitize_output($value, int $strip = 0)
    {
        $value = htmlspecialchars($value, ENT_QUOTES);

        if ($strip == 1) {
            $string = stripslashes($value);
        }
        $value = str_replace('&amp;#', '&#', $value);

        return $value;
    }
}

if (! function_exists('formatText')) {
    function formatText($string, $doSlash = true)
    {
        $string = str_replace(["'", "\r\n"], ['`', '\\r\\n'], $string);
        if ($doSlash) {
            $string = addslashes($string);
        }

        return $string;
    }
}

if (! function_exists('stripBeforeSave')) {
    /**
     * stripBeforeSave method
     * This function strips or skips HTML tags
     *
     * @param  string  $string  [The text that will be stripped]
     * @param  array  $options
     * @return string
     */
    function stripBeforeSave($string = null, $options = ['skipAllTags' => true, 'mergeTags' => false])
    {
        $finalString = [];
        if ($options['skipAllTags'] === false) {
            $allow = '<h1><h2><h3><h4><h5><h6><p><b><br><hr><i><pre><small><strike><strong><sub><sup><time><u><form><input><textarea><button><select><option><label><frame><iframe><img><audio><video><a><link><nav><ul><ol><li><table><th><tr><td><thead><tbody><div><span><header><footer><main><section><article>';
            if (isset($options['mergeTags']) && $options['mergeTags'] === true && isset($options['allowedTags'])) {
                $allow .= is_array($options['allowedTags']) ? implode('', $options['allowedTags']) : trim($options['allowedTags']);
            } else {
                $allow = isset($options['allowedTags']) && is_array($options['allowedTags']) ? implode('', $options['allowedTags']) : trim($options['allowedTags']);
            }
            if (is_array($string)) {
                foreach ($string as $key => $value) {
                    $finalString[$key] = strip_tags($value, $allow);
                }
            } else {
                $finalString = strip_tags($string, $allow);
            }
        } else {
            if (is_array($string)) {
                foreach ($string as $key => $value) {
                    $finalString[$key] = strip_tags($value);
                }
            } else {
                $finalString = strip_tags($string);
            }
        }

        return ! empty($finalString) ? $finalString : null;
    }
}

if (! function_exists('cleanedUrl')) {
    /**
     * niceUrl method
     * return pretty URL
     *
     * @param  string  $url
     * @return string
     */
    function cleanedUrl($url = '')
    {
        $url = trim($url);

        $prohibited = [' ', '!', "'", '"', '@', '#', '$', '%', '^', '&', '*', '?', ',', '/', '<', '>', ':', ';', 'é', 'è', '{', '}', ')', '('];
        $replace = ['-', '', '', '', '', '', '', '', '', '-', '', '', '', '', '', '', '', '', '', 'e', 'e', '', '', '', ''];

        return strtolower(str_replace($prohibited, $replace, $url));
    }
}

if (! function_exists('trimWords')) {
    /**
     * trim word
     *
     * @return string
     */
    function trimWords($text, $num_words = 30, $more = null)
    {
        if (is_null($more)) {
            $more = '...';
        }

        $num_words = (int) $num_words;

        $text = trim(preg_replace("/[\n\r\t ]+/", ' ', $text), ' ');
        preg_match_all('/./u', $text, $words_array);
        $words_array = array_slice($words_array[0], 0, $num_words + 1);
        $sep = '';

        if (count($words_array) > $num_words) {
            array_pop($words_array);
            $text = implode($sep, $words_array);
            $text = $text . $more;
        } else {
            $text = implode($sep, $words_array);
        }

        return $text;
    }
}

if (! function_exists('stripExceptA2Z')) {
    /**
     * Strip everything except A - Z
     *
     * @param  string  $text
     * @return string
     */
    function stripExceptA2Z($text)
    {
        return preg_replace(['/[\[{\(].*?[\]}\)]/i', '/[^a-zA-Z]/i'], '', $text);
    }
}

if (! function_exists('prepareColumnName')) {
    /**
     * Strip everything except A - Z and lowercase the text
     *
     * @param  string  $text
     * @return string
     */
    function prepareColumnName($text)
    {
        return strtolower(stripExceptA2Z($text));
    }
}

if (! function_exists('convertToBytes')) {
    /**
     * Converts a string to a string of equal bytes. Supports up to Petabyte.
     * PHP allows shortcuts for byte values, including K (kilo), M (mega) and G (giga) etc.
     *
     * Example input: '64M', '1G', '24M'.
     * Example output: '1024'
     *
     * @param  string  $from
     * @return string|null
     */
    function convertToBytes($from)
    {
        $units = ['B', 'K', 'M', 'G', 'T', 'P'];
        $number = substr($from, 0, -1);

        $suffix = strtoupper(substr($from, -1));
        $exponent = array_flip($units)[$suffix] ?? null;

        if ($exponent === null) {
            return null;
        }

        return strval($number * (1024 ** $exponent));
    }
}

if (! function_exists('convertBytesToOtherUnit')) {
    /**
     * Converts a bytes string to specified unit byte.
     * Supports up to Petabyte & skips decimal points
     *
     * Example output: '64M', '1G', '24M'.
     *
     * @param  string  $bytes
     * @param  string  $unit
     * @return string
     */
    function convertBytesToOtherUnit($bytes, $unit = 'M')
    {
        $units = ['B' => 0, 'K' => 1, 'M' => 2, 'G' => 3, 'T' => 4, 'P' => 5];
        $value = 0;

        if ($bytes > 0) {
            if (! array_key_exists($unit, $units)) {
                $pow = floor(log($bytes) / log(1024));
                $unit = array_search($pow, $units);
            }
            $value = ($bytes / pow(1024, floor($units[$unit])));
        }

        return sprintf('%d' . $unit, $value);
    }
}
