<?php

use App\Models\{Customer, Language};

if (! function_exists('DbDateFormat')) {
    /**
     * Data Date Format
     *
     * @param  string  $value
     * @return string
     */
    function DbDateFormat($value = null)
    {
        if (empty($value)) {
            return '';
        }
        $preference = preference('date_format_type');
        $pattern = ['/', '.', ' '];
        $value = str_replace($pattern, '-', $value);
        $data = str_replace($pattern, ['-'], $preference);
        $data = explode('-', $data);
        $mm = $data[0];
        if ($mm == 'mm') {
            $datas = explode('-', str_replace($pattern, ['-'], $value));
            $value = $datas[1] . '-' . $datas[0] . '-' . $datas[2];
        } else {
            $value = str_replace($pattern, ['-'], $value);
        }

        return date('Y-m-d', strtotime($value));
    }
}

if (! function_exists('formatDate')) {
    /**
     * Format Date
     *
     * @param  string  $value
     * @return string
     */
    function formatDate($value)
    {
        $format = preference('date_format');
        $separator = preference('date_sepa');
        if ($format == '0') {
            // yyyy-mm-dd
            $format = 'Y' . $separator . 'm' . $separator . 'd';
            $date = date($format, strtotime(strtr($value, $separator, '-')));
        } elseif ($format == '1') {
            // dd-mm-yyyy
            $format = 'd' . $separator . 'm' . $separator . 'Y';
            $date = date($format, strtotime(strtr($value, $separator, '-')));
        } elseif ($format == '2') {
            // mm-dd-yyyy
            $format = 'm' . $separator . 'd' . $separator . 'Y';
            $date = date($format, strtotime(strtr($value, $separator, '-')));
        } elseif ($format == '3') {
            // D-M-yyyy
            $format = 'd' . $separator . 'M' . $separator . 'Y';
            $date = date($format, strtotime(strtr($value, $separator, '-')));
        } elseif ($format == '4') {
            // yyyy-mm-D
            $format = 'Y' . $separator . 'M' . $separator . 'd';
            $date = date($format, strtotime(strtr($value, $separator, '-')));
        }

        return $date;
    }
}

if (! function_exists('timeZoneFormatDate')) {
    /**
     * Timezone Format Date
     *
     * @param  string  $value
     * @return string
     */
    function timeZoneFormatDate($value)
    {
        $middleware = str_replace('auth:', '', isset(request()->route()->middleware()[1]) ? request()->route()->middleware()[1] : null);
        if ($middleware == 'customer') {
            $timezone = Customer::getTimezone();
        } else {
            $timezone = preference('default_timezone');
        }
        if (empty($timezone)) {
            $timezone = config('app.timezone');
        }

        $today = new DateTime($value, new DateTimeZone(config('app.timezone')));
        $today->setTimezone(new DateTimeZone($timezone));
        $value = $today->format('Y-m-d h:m:s');

        $date_format_type = preference('date_format_type');
        $separator = preference('date_sepa');

        $data = str_replace(['/', '.', ' ', '-'], $separator, $date_format_type);
        $data = explode($separator, $data);

        $first = $data[0];
        $second = $data[1];
        $third = $data[2];

        if ($first == 'yyyy' && $second == 'mm' && $third == 'dd') {
            $dateInfo = str_replace(['/', '.', ' ', '-'], $separator, $value);
            $datas = explode($separator, $dateInfo);
            $year = $datas[0];
            $month = $datas[1];
            $day = $datas[2];
            $value = $year . $separator . $month . $separator . $day;
        } elseif ($first == 'dd' && $second == 'mm' && $third == 'yyyy') {
            $dateInfo = str_replace(['/', '.', ' ', '-'], $separator, $value);
            $datas = explode($separator, $dateInfo);
            $year = $datas[0];
            $month = $datas[1];
            $day = $datas[2];
            $value = $day . $separator . $month . $separator . $year;
        } elseif ($first == 'mm' && $second == 'dd' && $third == 'yyyy') {
            $dateInfo = str_replace(['/', '.', ' ', '-'], $separator, $value);
            $datas = explode($separator, $dateInfo);
            $year = $datas[0];
            $month = $datas[1];
            $day = $datas[2];
            $value = $month . $separator . $day . $separator . $year;
        } elseif ($first == 'dd' && $second == 'M' && $third == 'yyyy') {
            $dateInfo = str_replace(['/', '.', ' ', '-'], $separator, $value);
            $datas = explode($separator, $dateInfo);
            $year = $datas[0];
            $month = $datas[1];
            $day = $datas[2];

            $dateObj = DateTime::createFromFormat('!m', $month);
            $monthName = $dateObj->format('M');

            $value = $day . $separator . $monthName . $separator . $year;
        } elseif ($first == 'yyyy' && $second == 'M' && $third == 'dd') {
            $dateInfo = str_replace(['/', '.', ' ', '-'], $separator, $value);
            $datas = explode($separator, $dateInfo);
            $year = $datas[0];
            $month = $datas[1];
            $day = $datas[2];

            $dateObj = DateTime::createFromFormat('!m', $month);
            $monthName = $dateObj->format('M');
            $value = $year . $separator . $monthName . $separator . $day;
        }

        return $value;
    }
}

if (! function_exists('timeZoneGetTime')) {
    /**
     * Timezone Get Time
     *
     * @param  string  $data
     * @return string
     */
    function timeZoneGetTime($date)
    {
        $middleware = str_replace('auth:', '', isset(request()->route()->middleware()[1]) ? request()->route()->middleware()[1] : null);

        if ($middleware == 'customer') {
            $timezone = Customer::getTimezone();
        } else {
            $timezone = preference('default_timezone');
        }

        if (! $timezone) {
            $timezone = date_default_timezone_get();
        }

        $userTimezone = new DateTimeZone($timezone);
        $gmtTimezone = new DateTimeZone('GMT');
        $myDateTime = new DateTime($date, $gmtTimezone);
        $offset = $userTimezone->getOffset($myDateTime);
        $myInterval = DateInterval::createFromDateString((string) $offset . 'seconds');
        $myDateTime->add($myInterval);
        $time = $myDateTime->format('h:i A');

        return $time;
    }
}

if (! function_exists('timeZoneList')) {
    /**
     * Timezone List
     *
     * @return array
     */
    function timeZoneList()
    {
        $zones_array = [];
        $timestamp = time();

        foreach (timezone_identifiers_list() as $key => $zone) {
            date_default_timezone_set($zone);
            $zones_array[$key]['zone'] = $zone;
            $zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
        }

        return $zones_array;
    }
}

if (! function_exists('getShortLanguageName')) {
    /**
     * Get Short Language Name
     *
     * @param  bool  $allLang
     * @param  string  $languages
     * @return string
     */
    function getShortLanguageName($allLang = false, $languages = null)
    {
        $shortList = [
            'en' => 'English',
            'aa' => 'Afar',
            'ab' => 'Abkhazian',
            'af' => 'Afrikaans',
            'am' => 'Amharic',
            'ar' => 'Arabic',
            'as' => 'Assamese',
            'ay' => 'Aymara',
            'az' => 'Azerbaijani',
            'ba' => 'Bashkir',
            'be' => 'Byelorussian',
            'bg' => 'Bulgarian',
            'bh' => 'Bihari',
            'bi' => 'Bislama',
            'bn' => 'Bengali',
            'br' => 'Breton',
            'ca' => 'Catalan',
            'co' => 'Corsican',
            'cs' => 'Czech',
            'cy' => 'Welsh',
            'da' => 'Danish',
            'de' => 'German',
            'dz' => 'Bhutani',
            'el' => 'Greek',
            'es' => 'Spanish',
            'et' => 'Estonian',
            'eu' => 'Basque',
            'fa' => 'Persian',
            'fi' => 'Finnish',
            'fj' => 'Fiji',
            'fo' => 'Faeroese',
            'fr' => 'French',
            'fy' => 'Frisian',
            'ga' => 'Irish',
            'gd' => 'Scots/Gaelic',
            'gn' => 'Guarani',
            'gu' => 'Gujarati',
            'ha' => 'Hausa',
            'hi' => 'Hindi',
            'hr' => 'Croatian',
            'hu' => 'Hungarian',
            'hy' => 'Armenian',
            'in' => 'Indonesian',
            'is' => 'Icelandic',
            'it' => 'Italian',
            'iw' => 'Hebrew',
            'ja' => 'Japanese',
            'ka' => 'Georgian',
            'kk' => 'Kazakh',
            'kl' => 'Greenlandic',
            'km' => 'Cambodian',
            'kn' => 'Kannada',
            'ko' => 'Korean',
            'ku' => 'Kurdish',
            'ky' => 'Kirghiz',
            'la' => 'Latin',
            'ln' => 'Lingala',
            'lt' => 'Lithuanian',
            'lv' => 'Latvian/Lettish',
            'mg' => 'Malagasy',
            'mi' => 'Maori',
            'mk' => 'Macedonian',
            'ml' => 'Malayalam',
            'mn' => 'Mongolian',
            'mo' => 'Moldavian',
            'mr' => 'Marathi',
            'ms' => 'Malay',
            'mt' => 'Maltese',
            'my' => 'Burmese',
            'ne' => 'Nepali',
            'nl' => 'Dutch',
            'no' => 'Norwegian',
            'oc' => 'Occitan',
            'om' => '(Afan)/Oromoor/Oriya',
            'pa' => 'Punjabi',
            'pl' => 'Polish',
            'ps' => 'Pashto/Pushto',
            'pt' => 'Portuguese',
            'rm' => 'Rhaeto-Romance',
            'rn' => 'Kirundi',
            'ro' => 'Romanian',
            'ru' => 'Russian',
            'rw' => 'Kinyarwanda',
            'sd' => 'Sindhi',
            'sg' => 'Sangro',
            'sh' => 'Serbo-Croatian',
            'si' => 'Singhalese',
            'sk' => 'Slovak',
            'sl' => 'Slovenian',
            'sm' => 'Samoan',
            'sn' => 'Shona',
            'so' => 'Somali',
            'sq' => 'Albanian',
            'sr' => 'Serbian',
            'ss' => 'Siswati',
            'st' => 'Sesotho',
            'su' => 'Sundanese',
            'sv' => 'Swedish',
            'sw' => 'Swahili',
            'ta' => 'Tamil',
            'te' => 'Tegulu',
            'tg' => 'Tajik',
            'th' => 'Thai',
            'ti' => 'Tigrinya',
            'tk' => 'Turkmen',
            'tl' => 'Tagalog',
            'tn' => 'Setswana',
            'to' => 'Tonga',
            'tr' => 'Turkish',
            'tw' => 'Twi',
            'uk' => 'Ukrainian',
            'ur' => 'Urdu',
            'uz' => 'Uzbek',
            'vi' => 'Vietnamese',
            'wo' => 'Wolof',
            'xh' => 'Xhosa',
            'yo' => 'Yoruba',
            'zh' => 'Chinese',
            'zu' => 'Zulu',
        ];
        if ($allLang) {
            return $shortList;
        }

        if (is_null($languages)) {
            $languages = Language::all();
        }

        $languages = $languages->pluck('name', 'short_name')->toArray();
        $unique_values = array_unique(array_merge($shortList, $languages));
        $actual_values = array_diff($unique_values, $languages);

        return $actual_values;
    }
}

if (! function_exists('getMonths')) {
    /**
     * [getMonths description]
     *
     * @param  [string] $from [description]
     * @param  [string] $to   [description]
     * @return [array]       [description]
     */
    function getMonths($from = null, $to = null)
    {
        $months = [];
        if (empty($from) || empty($to) || ($to < $from)) {
            return $months;
        }

        while (strtotime($from) <= strtotime($to)) {
            $months[] = date('M Y', strtotime($from));
            $from = date('d M Y', strtotime($from .
                '+ 1 month'));
        }

        return $months;
    }
}

if (! function_exists('updateLanguageFile')) {
    /**
     * updateLanguageFile method
     * To create OR update Translation File
     *
     * @param  string  $code  [Language short name]
     * @return void
     */
    function updateLanguageFile($code)
    {
        $jsonString = [];
        if (file_exists(base_path('resources/lang/' . $code . '.json')) && file_exists(base_path('public/js/lang/' . $code . '.js'))) {
            $jsonString = json_decode(file_get_contents(base_path('resources/lang/' . $code . '.json')), true);
            $moduleLangData = [];
            $moduleEnData = [];

            foreach (\Nwidart\Modules\Facades\Module::getOrdered() as $module) {
                if (file_exists(base_path('Modules\\' . $module->getName() . '\\Resources\\lang\\' . $code . '.json'))) {
                    $moduleLangData = array_merge($moduleLangData, json_decode(file_get_contents(base_path('Modules\\' . $module->getName() . '\\Resources\\lang\\' . $code . '.json')), true));
                    $moduleEnData = array_merge($moduleEnData, json_decode(file_get_contents(base_path('Modules\\' . $module->getName() . '\\Resources\\lang\\en.json')), true));
                }
            }

            $jsonString = array_merge($moduleLangData, $jsonString);
            $enString = json_decode(file_get_contents(base_path('resources/lang/en.json')), true);
            $enString = array_merge($moduleEnData, $enString);
            $keys = array_keys($enString);

            foreach ($jsonString as $key => $value) {
                if (in_array($key, $keys)) {
                    $array = $enString[$key];
                    if (is_array($array)) {
                        foreach ($array as $k => $v) {
                            if (in_array($k, array_keys($value))) {
                                $enString[$key][$k] = $value[$k];
                            } else {
                                $enString[$key][$k] = $v;
                            }
                        }
                    } else {
                        $enString[$key] = $value;
                    }
                }
            }

            saveJSONFile($code, $enString);
            saveJSFile($code, $enString);
        } else {
            file_put_contents(base_path(createDirectory('resources/lang/') . $code . '.json'), file_get_contents(base_path('resources/lang/en.json')));
            file_put_contents(base_path(createDirectory('public/js/lang/') . $code . '.js'), file_get_contents(base_path('public/js/lang/en.js')));
        }
    }
}

if (! function_exists('getDateFormats')) {
    /**
     * Get Date Formats
     *
     * @return array
     */
    function getDateFormats()
    {
        return [
            'yyyymmdd {2020 12 31}',
            'ddmmyyyy {31 12 2020}',
            'mmddyyyy {12 31 2020}',
            'ddMyyyy {31 Dec 2020}',
            'yyyyMdd {2020 Dec 31}',
        ];
    }
}

if (! function_exists('getDateformatId')) {
    /**
     * check data and return boolean or array key
     *
     * @param  null  $keyword
     * @param  string  $searchBy
     * @param  string  $return
     * @return bool|int|string
     */
    function getDateformatId($keyword = null, $searchBy = 'key', $return = 'value')
    {
        $format = getDateFormats();

        if ($searchBy == 'value') {
            if (in_array($keyword, $format)) {
                return $return == 'key' ? array_keys($format, $keyword)[0] : true;
            }

            return false;
        }
        if (array_key_exists($keyword, $format)) {
            return $format[$keyword];
        }

        return false;
    }
}

if (! function_exists('dateExists')) {
    /**
     * current date exists or not between two dates
     *
     * @param  null|string  $from
     * @param  null|string  $to
     * @return bool
     */
    function dateExists($from = null, $to = null)
    {
        $today = date('Y-m-d');
        $today = date('Y-m-d', strtotime($today));
        $from = date('Y-m-d', strtotime($from));
        $to = date('Y-m-d', strtotime($to));
        if (($today >= $from) && ($today <= $to)) {
            return true;
        } else {
            return false;
        }
    }
}

if (! function_exists('timeToGo')) {
    function timeToGo($datetime, $full = false, $time = 'left')
    {
        $now = new DateTime();
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = [
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        ];
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (! $full) {
            $string = array_slice($string, 0, 1);
        }

        return $string ? implode(', ', $string) . ' ' . $time : 'just now';
    }
}

if (! function_exists('randomDateBefore')) {
    /**
     *  Generate random date between today to last 60 days
     *
     * @return date
     */
    function randomDateBefore($days = 60)
    {
        $val = rand(strtotime(now()), strtotime(now()->subDays($days)));

        // Convert back to desired date format
        return date('Y-m-d H:i:s', $val);
    }
}

if (! function_exists('randomDateAfter')) {
    /**
     *  Generate random date between today to next 60 days
     *
     * @return date
     */
    function randomDateAfter($days = 60)
    {
        $val = rand(strtotime(now()), strtotime(now()->addDays($days)));

        // Convert back to desired date format
        return date('Y-m-d H:i:s', $val);
    }
}

if (! function_exists('availableFrom')) {
    /*
 * @param $from
 * @return bool
 */
    function availableFrom($from)
    {
        $today = date('Y-m-d');
        $from = date('Y-m-d', strtotime($from));
        if (($today >= $from)) {
            return true;
        } else {
            return false;
        }
    }
}

if (! function_exists('availableTo')) {
    /**
     * @return bool
     */
    function availableTo($to)
    {
        $today = date('Y-m-d');
        $to = date('Y-m-d', strtotime($to));
        if (($today <= $to)) {
            return true;
        } else {
            return false;
        }
    }
}

if (! function_exists('offsetDate')) {
    function offsetDate($offset = null)
    {
        if ($offset) {
            return date('Y-m-d', strtotime($offset . ' day'));
        }

        return date('Y-m-d');
    }
}

if (! function_exists('lastWeek')) {
    /**
     * Get the last weeks first & last day
     *
     * @return array
     */
    function lastWeek()
    {
        return [
            'start' => now()->startOfWeek()->subWeek()->toDateString(),
            'end' => now()->endOfWeek()->subWeek()->toDateString(),
        ];
    }
}

if (! function_exists('lastMonth')) {
    function lastMonth()
    {
        return [
            'start' => now()->startOfMonth()->subMonth()->toDateString(),
            'end' => now()->endOfMonth()->subMonth()->toDateString(),
        ];
    }
}

if (! function_exists('lastYear')) {
    function lastYear()
    {
        return [
            'start' => now()->startOfYear()->subYear()->toDateString(),
            'end' => now()->endOfYear()->subYear()->toDateString(),
        ];
    }
}

if (! function_exists('currentWeek')) {
    /**
     * Get the last weeks first & last day
     *
     * @return array
     */
    function currentWeek()
    {
        return [
            'start' => now()->startOfWeek()->toDateString(),
            'end' => now()->endOfWeek()->toDateString(),
        ];
    }
}

if (! function_exists('currentMonth')) {
    function currentMonth()
    {
        return [
            'start' => now()->startOfMonth()->toDateString(),
            'end' => now()->endOfMonth()->toDateString(),
        ];
    }
}

if (! function_exists('currentYear')) {
    function currentYear()
    {
        return [
            'start' => now()->startOfYear()->toDateString(),
            'end' => now()->endOfYear()->toDateString(),
        ];
    }
}

if (! function_exists('firstDayOfTheMonth')) {
    /**
     * First day of the current month
     *
     * @return string
     */
    function firstDayOfTheMonth()
    {
        return date('m-01-Y');
    }
}

if (! function_exists('lastDayOfTheMonth')) {
    /**
     * Last day of the current month
     *
     * @return string
     */
    function lastDayOfTheMonth()
    {
        return date('m-t-Y');
    }
}

if (! function_exists('tomorrow')) {
    /**
     * Tomorrow date
     *
     * @return string
     */
    function tomorrow()
    {
        return offsetDate('+1');
    }
}

if (! function_exists('getDay')) {
    /**
     * 1-31 day from date
     *
     * @param  string  $date
     * @return int
     */
    function getDay($date)
    {
        return (int) date('d', strtotime($date));
    }
}

if (! function_exists('languageDirection')) {
    /**
     * Get default language direction
     *
     * @return string
     */
    function languageDirection()
    {
        return \Cache::get(config('cache.prefix') . '-language-direction') ?? 'ltr';
    }
}
if (! function_exists('randomDateBetween')) {
    /**
     *  Generate random date between two days.
     *
     * @param  $start  (minus value for before date)
     * @param  $end  (minus value for before date)
     * @return date
     */
    function randomDateBetween($start = 1, $end = 30)
    {
        return now()->addDays(rand($start, $end));
    }
}

if (! function_exists('formatDateTime')) {

    /**
     *  Date time format
     *
     * @param  data  $value
     * @param  bool  $is_12_hour_format
     * @param  string  $time_separator
     * @return string
     */
    function formatDateTime($value, $is_12_hour_format = true, $time_separator = 'at')
    {
        $format = preference('date_format');
        $separator = preference('date_sepa');
        $timeFormat = '|' . 'G:i';

        if (! ctype_space($time_separator)) {
            $time_separator = ' ' . $time_separator . ' ';
        }

        if ($is_12_hour_format) {
            $timeFormat = '|' . 'g:i a';
        }

        switch ($format) {
            case '4':
                // yyyy-mm-D
                $format = 'Y' . $separator . 'M' . $separator . 'd' . $timeFormat;

                break;
            case '3':
                // D-M-yyyy
                $format = 'd' . $separator . 'M' . $separator . 'Y' . $timeFormat;

                break;
            case '2':
                // mm-dd-yyyy
                $format = 'm' . $separator . 'd' . $separator . 'Y' . $timeFormat;

                break;
            case '1':
                // dd-mm-yyyy
                $format = 'd' . $separator . 'm' . $separator . 'Y' . $timeFormat;

                break;
            default:
                // yyyy-mm-dd
                $format = 'Y' . $separator . 'm' . $separator . 'd' . $timeFormat;
        }

        $date = date($format, strtotime(strtr($value, $separator, '-')));
        $date = str_replace('|', $time_separator, $date);

        return $date;
    }
}
