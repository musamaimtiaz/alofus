<?php

/**
 * @author Jesse G. Donat <donatj@gmail.com>
 *
 * @contributor Soumik Datta <soumik.techvill@gmail.com>
 *
 * @link https://github.com/donatj/PhpUserAgent
 */

namespace App\Services;

class UserAgentParserService
{
    protected $PLATFORM        = 'platform';

    protected $BROWSER         = 'browser';

    protected $BROWSER_VERSION = 'version';

    /**
     * Parses a user agent string into its important parts
     *
     * @param  string|null  $u_agent  User agent string to parse or null. Uses $_SERVER['HTTP_USER_AGENT'] on NULL
     * @return string[] an array with 'browser', 'version' and 'platform' keys
     *
     * @throws \InvalidArgumentException on not having a proper user agent to parse.
     */
    public function parse(?string $u_agent = null)
    {
        if ($u_agent === null && isset($_SERVER['HTTP_USER_AGENT'])) {
            $u_agent = (string) $_SERVER['HTTP_USER_AGENT'];
        }

        if ($u_agent === null) {
            throw new \InvalidArgumentException('parse_user_agent requires a user agent');
        }

        $platform = null;
        $browser  = null;
        $version  = null;

        $return = [$this->PLATFORM => &$platform, $this->BROWSER => &$browser, $this->BROWSER_VERSION => &$version];

        if (! $u_agent) {
            return $return;
        }

        if (preg_match('/\((.*?)\)/m', $u_agent, $parent_matches)) {
            preg_match_all(<<<'REGEX'
/(?P<platform>BB\d+;|Android|Adr|Symbian|Sailfish|CrOS|Tizen|iPhone|iPad|iPod|Linux|(?:Open|Net|Free)BSD|Macintosh|
Windows(?:\ Phone)?|Silk|linux-gnu|BlackBerry|PlayBook|X11|(?:New\ )?Nintendo\ (?:WiiU?|3?DS|Switch)|Xbox(?:\ One)?)
(?:\ [^;]*)?
(?:;|$)/imx
REGEX
                , $parent_matches[1], $result);

            $priority = ['Xbox One', 'Xbox', 'Windows Phone', 'Tizen', 'Android', 'FreeBSD', 'NetBSD', 'OpenBSD', 'CrOS', 'X11', 'Sailfish'];

            $result[$this->PLATFORM] = array_unique($result[$this->PLATFORM]);
            if (count($result[$this->PLATFORM]) > 1) {
                if ($keys = array_intersect($priority, $result[$this->PLATFORM])) {
                    $platform = reset($keys);
                } else {
                    $platform = $result[$this->PLATFORM][0];
                }
            } elseif (isset($result[$this->PLATFORM][0])) {
                $platform = $result[$this->PLATFORM][0];
            }
        }

        if ($platform == 'linux-gnu' || $platform == 'X11') {
            $platform = 'Linux';
        } elseif ($platform == 'CrOS') {
            $platform = 'Chrome OS';
        } elseif ($platform == 'Adr') {
            $platform = 'Android';
        } elseif ($platform === null) {
            if (preg_match_all('%(?P<platform>Android)[:/ ]%ix', $u_agent, $result)) {
                $platform = $result[$this->PLATFORM][0];
            }
        }

        preg_match_all(<<<'REGEX'
%(?P<browser>Camino|Kindle(\ Fire)?|Firefox|Iceweasel|IceCat|Safari|MSIE|Trident|AppleWebKit|
TizenBrowser|(?:Headless)?Chrome|YaBrowser|Vivaldi|IEMobile|Opera|OPR|Silk|Midori|(?-i:Edge)|EdgA?|CriOS|UCBrowser|Puffin|
OculusBrowser|SamsungBrowser|SailfishBrowser|XiaoMi/MiuiBrowser|
Baiduspider|Applebot|Facebot|Googlebot|YandexBot|bingbot|Lynx|Version|Wget|curl|
Valve\ Steam\ Tenfoot|
NintendoBrowser|PLAYSTATION\ (?:\d|Vita)+)
\)?;?
(?:[:/ ](?P<version>[0-9A-Z.]+)|/[A-Z]*)%ix
REGEX
            , $u_agent, $result);

        // If nothing matched, return null (to avoid undefined index errors)
        if (! isset($result[$this->BROWSER][0], $result[$this->BROWSER_VERSION][0])) {
            if (preg_match('%^(?!Mozilla)(?P<browser>[A-Z0-9\-]+)(/(?P<version>[0-9A-Z.]+))?%ix', $u_agent, $result)) {
                return [$this->PLATFORM => $platform ?: null, $this->BROWSER => $result[$this->BROWSER], $this->BROWSER_VERSION => empty($result[$this->BROWSER_VERSION]) ? null : $result[$this->BROWSER_VERSION]];
            }

            return $return;
        }

        if (preg_match('/rv:(?P<version>[0-9A-Z.]+)/i', $u_agent, $rv_result)) {
            $rv_result = $rv_result[$this->BROWSER_VERSION];
        }

        $browser = $result[$this->BROWSER][0];
        $version = $result[$this->BROWSER_VERSION][0];

        $lowerBrowser = array_map('strtolower', $result[$this->BROWSER]);

        $find = function ($search, &$key = null, &$value = null) use ($lowerBrowser) {
            $search = (array) $search;

            foreach ($search as $val) {
                $xkey = array_search(strtolower($val), $lowerBrowser);
                if ($xkey !== false) {
                    $value = $val;
                    $key   = $xkey;

                    return true;
                }
            }

            return false;
        };

        $findT = function (array $search, &$key = null, &$value = null) use ($find) {
            $value2 = null;
            if ($find(array_keys($search), $key, $value2)) {
                $value = $search[$value2];

                return true;
            }

            return false;
        };

        $key = 0;
        $val = '';
        if ($findT(['OPR' => 'Opera', 'Facebot' => 'iMessageBot', 'UCBrowser' => 'UC Browser', 'YaBrowser' => 'Yandex', 'Iceweasel' => 'Firefox', 'Icecat' => 'Firefox', 'CriOS' => 'Chrome', 'Edg' => 'Edge', 'EdgA' => 'Edge', 'XiaoMi/MiuiBrowser' => 'MiuiBrowser'], $key, $browser)) {
            $version = is_numeric(substr($result[$this->BROWSER_VERSION][$key], 0, 1)) ? $result[$this->BROWSER_VERSION][$key] : null;
        } elseif ($find('Playstation Vita', $key, $platform)) {
            $platform = 'PlayStation Vita';
            $browser  = 'Browser';
        } elseif ($find(['Kindle Fire', 'Silk'], $key, $val)) {
            $browser  = $val == 'Silk' ? 'Silk' : 'Kindle';
            $platform = 'Kindle Fire';
            if (! ($version = $result[$this->BROWSER_VERSION][$key]) || ! is_numeric($version[0])) {
                $version = $result[$this->BROWSER_VERSION][array_search('Version', $result[$this->BROWSER])];
            }
        } elseif ($find('NintendoBrowser', $key) || $platform == 'Nintendo 3DS') {
            $browser = 'NintendoBrowser';
            $version = $result[$this->BROWSER_VERSION][$key];
        } elseif ($find('Kindle', $key, $platform)) {
            $browser = $result[$this->BROWSER][$key];
            $version = $result[$this->BROWSER_VERSION][$key];
        } elseif ($find('Opera', $key, $browser)) {
            $find('Version', $key);
            $version = $result[$this->BROWSER_VERSION][$key];
        } elseif ($find('Puffin', $key, $browser)) {
            $version = $result[$this->BROWSER_VERSION][$key];
            if (strlen($version) > 3) {
                $part = substr($version, -2);
                if (ctype_upper($part)) {
                    $version = substr($version, 0, -2);

                    $flags = ['IP' => 'iPhone', 'IT' => 'iPad', 'AP' => 'Android', 'AT' => 'Android', 'WP' => 'Windows Phone', 'WT' => 'Windows'];
                    if (isset($flags[$part])) {
                        $platform = $flags[$part];
                    }
                }
            }
        } elseif ($find(['Applebot', 'IEMobile', 'Edge', 'Midori', 'Vivaldi', 'OculusBrowser', 'SamsungBrowser', 'Valve Steam Tenfoot', 'Chrome', 'HeadlessChrome', 'SailfishBrowser'], $key, $browser)) {
            $version = $result[$this->BROWSER_VERSION][$key];
        } elseif ($rv_result && $find('Trident')) {
            $browser = 'MSIE';
            $version = $rv_result;
        } elseif ($browser == 'AppleWebKit') {
            if ($platform == 'Android') {
                $browser = 'Android Browser';
            } elseif (strpos((string) $platform, 'BB') === 0) {
                $browser  = 'BlackBerry Browser';
                $platform = 'BlackBerry';
            } elseif ($platform == 'BlackBerry' || $platform == 'PlayBook') {
                $browser = 'BlackBerry Browser';
            } else {
                $find('Safari', $key, $browser) || $find('TizenBrowser', $key, $browser);
            }

            $find('Version', $key);
            $version = $result[$this->BROWSER_VERSION][$key];
        } elseif ($pKey = preg_grep('/playstation \d/i', $result[$this->BROWSER])) {
            $pKey = reset($pKey);

            $platform = 'PlayStation ' . preg_replace('/\D/', '', $pKey);
            $browser  = 'NetFront';
        }

        return $return;
    }
}
