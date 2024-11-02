<?php

namespace App\Lib\SiteInfo;

use DateTime;
use DateTimeZone;

class Server
{
    private $server = [];

    public function getInfo()
    {
        $this->server['server_architecture'] = $this->getServerArchitecture();
        $this->server['httpd_software'] = $this->getHttpdSoftware();
        $this->server['php_version'] = $this->getPhpVersion();
        $this->server['php_sapi'] = $this->getPhpSapi();
        $this->server['file_uploads'] = $this->isFileUploadsEnabled();
        $this->server['max_input_variables'] = $this->getMaxInputVariables();
        $this->server['time_limit'] = $this->getTimeLimit();
        $this->server['memory_limit'] = $this->getMemoryLimit();
        $this->server['max_input_time'] = $this->getMaxInputTime();
        $this->server['upload_max_filesize'] = $this->getUploadMaxFilesize();
        $this->server['php_post_max_size'] = $this->getPhpPostMaxSize();
        $this->server['curl_version'] = $this->getCurlVersion();
        $this->server['allow_url_fopen'] = $this->isAllowUrlFopen();
        $this->server['extensions'] = implode(', ', $this->getExtensions());
        $this->server['suhosin'] = $this->isSuhosinEnabled();
        $this->server['imagick_availability'] = $this->isImagickAvailable();
        $this->server['gd_version'] = $this->getGdVersion();
        $this->server['gd_formats'] = $this->getGdFormats();
        $this->server['current_time'] = $this->getCurrentDateTime();
        $this->server['utc_time'] = $this->getUtcDateTime();
        $this->server['server_time'] = $this->getServerDateTime();

        return $this->server;
    }

    public function getServerArchitecture()
    {
        return sprintf('%s %s %s', php_uname('s'), php_uname('r'), php_uname('m'));
    }

    public function getHttpdSoftware()
    {
        return isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : __('Unable to determine what web server software is used');
    }

    public function getPhpVersion()
    {
        return phpversion();
    }

    public function getPhpSapi()
    {
        return php_sapi_name();
    }

    public function isFileUploadsEnabled()
    {
        return (bool) ini_get('file_uploads');
    }

    public function getMaxInputVariables()
    {
        return ini_get('max_input_vars');
    }

    public function getTimeLimit()
    {
        return ini_get('max_execution_time');
    }

    public function getMemoryLimit()
    {
        return ini_get('memory_limit');
    }

    public function getMaxInputTime()
    {
        return ini_get('max_input_time');
    }

    public function getUploadMaxFilesize()
    {
        return ini_get('upload_max_filesize');
    }

    public function getPhpPostMaxSize()
    {
        return ini_get('post_max_size');
    }

    public function getCurlVersion()
    {
        return curl_version()['version'] . ' ' . curl_version()['ssl_version'];
    }

    public function isSuhosinEnabled()
    {
        return extension_loaded('suhosin');
    }

    public function isImagickAvailable()
    {
        return extension_loaded('imagick');
    }

    public function getCurrentDateTime()
    {
        $date = new DateTime('now', new DateTimeZone('UTC'));

        return $date->format(DateTime::ATOM);
    }

    public function getUtcDateTime()
    {
        $date = new DateTime('now', new DateTimeZone('UTC'));

        return $date->format(DateTime::RFC850);
    }

    public function getServerDateTime()
    {
        return date('Y-m-d\TH:i:sP');
    }

    private function gd()
    {
        if (extension_loaded('gd')) {
            return gd_info();
        } else {
            return false;
        }
    }

    public function getGdVersion()
    {
        if ($this->gd()) {
            return $this->gd()['GD Version'];
        } else {
            return null;
        }
    }

    public function getGdFormats()
    {
        if (! $this->gd()) {
            return [];
        }

        $gd = $this->gd();

        $gdImageFormats     = [];
        $gdSupportedFormats = [
            'GIF Create' => 'GIF',
            'JPEG'       => 'JPEG',
            'PNG'        => 'PNG',
            'WebP'       => 'WebP',
            'BMP'        => 'BMP',
            'AVIF'       => 'AVIF',
            'HEIF'       => 'HEIF',
            'TIFF'       => 'TIFF',
            'XPM'        => 'XPM',
        ];

        foreach ($gdSupportedFormats as $format_key => $format) {
            $index = $format_key . ' Support';
            if (isset($gd[$index]) && $gd[$index]) {
                array_push($gdImageFormats, $format);
            }
        }

        return implode(', ', $gdImageFormats);
    }

    public function getExtensions()
    {
        $extensions = get_loaded_extensions();
        sort($extensions);

        return $extensions;
    }

    public function isAllowUrlFopen()
    {
        return (bool) ini_get('allow_url_fopen');
    }
}
