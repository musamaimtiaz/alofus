<?php

namespace App\Lib;

class PhpInfo
{
    /**
     * phpinfo constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param  bool  $tb
     * @return array
     */
    public static function phpinfo_general($tb = false)
    {
        return self::_parse_phpinfo(INFO_GENERAL, $tb);
    }

    /**
     * @param  bool  $tb
     * @return array
     */
    public static function phpinfo_configuration($tb = false)
    {
        return self::_parse_phpinfo(INFO_CONFIGURATION, $tb);
    }

    /**
     * @param  bool  $tb
     * @return array
     */
    public static function phpinfo_environment($tb = false)
    {
        return self::_parse_phpinfo(INFO_ENVIRONMENT, $tb);
    }

    /**
     * @param  bool  $tb
     * @return array
     */
    public static function phpinfo_variable($tb = false)
    {
        return self::_parse_phpinfo(INFO_VARIABLES, $tb);
    }

    /**
     * @param  bool  $tb
     * @return array
     */
    public static function phpinfo_modules($tb = false)
    {
        $cat = 'None';
        $info_arr = [];
        ob_start();

        if (function_exists('phpinfo') && phpinfo(INFO_MODULES)) {
            $info_lines = explode("\n", strip_tags(ob_get_clean(), '<tr><td><h2>'));

            foreach ($info_lines as $line) {
                if (preg_match('~<h2>(.*)</h2>~', $line, $title)) {
                    $cat = $title[1];
                }
                if (
                    preg_match('~<tr><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td></tr>~', $line, $val)
                    or
                    preg_match('~<tr><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td></tr>~', $line, $val)
                ) {
                    if ($tb) {
                        $info_arr[$cat][] = ['n' => trim($val[1]), 'v' => trim(str_replace(';', '; ', $val[2]))];
                    } else {
                        $info_arr[$cat][trim($val[1])] = trim(str_replace(';', '; ', $val[2]));
                    }
                }
            }
        }

        return $info_arr;
    }

    /**
     * @param  bool  $tb
     * @return array
     */
    public static function phpinfo_credits($tb = false)
    {
        return self::_parse_phpinfo(INFO_CREDITS, $tb);
    }

    /**
     * @return string
     */
    public static function phpinfo_license()
    {
        $license_string = '';
        ob_start();

        if (function_exists('phpinfo') && phpinfo(INFO_LICENSE)) {
            $info_lines = explode("\n", strip_tags(ob_get_clean(), '<tr><td><h2>'));
            $license_string = implode('. ', [$info_lines[29], $info_lines[31], $info_lines[33]]);
        }

        return $license_string;
    }

    /**
     * @param  bool  $tb
     * @return array
     */
    public static function all($tb = false)
    {
        $res = [];
        $res['General'] = self::phpinfo_general($tb);
        $res['Configuration'] = self::phpinfo_configuration($tb);
        $res['Environment'] = self::phpinfo_environment($tb);
        $res['Variable'] = self::phpinfo_variable($tb);
        $res['Modules'] = self::phpinfo_modules($tb);
        $res['Credits'] = self::phpinfo_credits($tb);
        $res['License'] = self::phpinfo_license();

        return $res;
    }

    /**
     * @param  bool  $tb
     * @return array
     */
    private static function _parse_phpinfo($type, $tb)
    {
        $info_arr = [];
        ob_start();

        if (function_exists('phpinfo') && phpinfo($type)) {
            $info_lines = explode("\n", strip_tags(ob_get_clean(), '<tr><td><h2>'));

            foreach ($info_lines as $line) {
                if (
                    preg_match('~<tr><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td></tr>~', $line, $val)
                    or
                    preg_match('~<tr><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td></tr>~', $line, $val)
                ) {
                    if ($tb) {
                        $info_arr[] = ['n' => trim($val[1]), 'v' => trim(str_replace(';', '; ', $val[2]))];
                    } else {
                        $info_arr[trim($val[1])] = trim(str_replace(';', '; ', $val[2]));
                    }
                }
            }
        }

        return $info_arr;
    }
}
