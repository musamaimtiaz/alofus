<?php

use Barryvdh\DomPDF\Facade\Pdf as PDF;

if (! function_exists('getFileIcon')) {
    /**
     * getFileIcon method
     * Get awesome font (version 5) icon for files
     *
     * @param  string  $file
     * @return string
     */
    function getFileIcon($file = null)
    {
        if (empty($file)) {
            return null;
        }

        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        switch ($ext) {
            case 'docx':
            case 'doc':
                return 'far fa-file-word';

                break;
            case 'pdf':
                return 'far fa-file-pdf';

                break;
            case 'xlsx':
            case 'xls':
            case 'csv':
                return 'far fa-file-excel';

                break;
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
                return 'far fa-image';

                break;
            default:
                return 'far fa-file';
        }
    }
}

if (! function_exists('getFileIconAF4')) {
    /**
     * getFileIconAF4 method
     * Get awesome font (version 4) icon for files
     *
     * @param  string  $file
     * @return string
     */
    function getFileIconAF4($file = null)
    {

        if (empty($file)) {
            return null;
        }

        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        $icon = 'fa-paperclip';
        $icons = [
            'audio' => 'fa-file-audio-o',
            'mp3' => 'fa-file-audio-o',
            'mp4' => 'fa-file-video-o',
            'video' => 'fa-file-video-o',
            'swf' => 'fa-film',
            'image' => 'fa-file-image-o',
            'gif' => 'fa-file-image-o',
            'jpg' => 'fa-file-image-o',
            'jpeg' => 'fa-file-image-o',
            'png' => 'fa-file-image-o',
            'pdf' => 'fa-file-pdf-o',
            'text' => 'fa-file-text-o',
            'txt' => 'fa-file-text-o',
            'word' => 'fa-file-word-o',
            'doc' => 'fa-file-word-o',
            'docx' => 'fa-file-word-o',
            'ppt' => 'fa-file-powerpoint-o',
            'pptx' => 'fa-file-powerpoint-o',
            'xls' => 'fa-file-excel-o',
            'xlsx' => 'fa-file-excel-o',
            'excel' => 'fa-file-excel-o',
            'csv' => 'fa-file-excel-o',
            'flv' => 'fa-film',
            'avi' => 'fa-file-video-o',
            'wmv' => 'fa-file-video-o',
            'asf' => 'fa-file-video-o',
            'mov' => 'fa-file-video-o',
            'webm' => 'fa-file-video-o',
            'm4v' => 'fa-file-video-o',
            'ogg' => 'fa-file-video-o',
            'ogv' => 'fa-file-video-o',
            'mkv' => 'fa-file-video-o',
            '3gp' => 'fa-file-video-o',
            'zip' => 'fa-file-archive-o',
            'rar' => 'fa-file-archive-o',
        ];

        if (in_array($ext, array_keys($icons))) {
            $icon = $icons[$ext];
        }

        return '<i class="fa ' . $icon . '"></i>';
    }
}

if (! function_exists('checkFileValidation')) {
    /**
     * Check File Validation
     *
     * @param  string  $ext
     * @param  int  $type
     * @return bool
     */
    function checkFileValidation($ext, $type = 0)
    {
        return in_array(strtolower($ext), getFileExtensions($type)) ? true : false;
    }
}

if (! function_exists('fetchAllFileExtensions')) {
    /**
     * Fetch File Extensions
     *
     * @return array
     */
    function fetchAllFileExtensions()
    {
        $extensions = preference('file_extension');

        return ! empty($extensions) ? json_decode($extensions, true) : [__('No Extension Available')];
    }
}

if (! function_exists('checkNullExtension')) {
    /**
     * Check Null Extension
     *
     * @return array
     */
    function checkNullExtension($data)
    {
        return $data == null ? [__('No Extension Available')] : $data;
    }

}

if (! function_exists('getFileExtensions')) {
    /**
     * Get File Extensions
     *
     * @param  int  $type
     * @return array
     */
    function getFileExtensions($type = 0)
    {
        $extensions = [
            0 => fetchAllFileExtensions(),
            1 => ['jpg', 'jpeg', 'png', 'gif', 'doc', 'docx', 'pdf'],
            2 => ['jpg', 'jpeg', 'png', 'gif', 'bmp'],
            3 => ['jpg', 'jpeg', 'png', 'webp'],
            4 => ['ico'],
            5 => ['doc', 'docx', 'xls', 'xlsx', 'csv', 'pdf', 'mp4', '3gp', 'zip'],
            6 => ['mp4', 'mkv', 'webm', 'mov', 'ogg', 'avi', 'flv', 'mpeg'],
        ];

        return $extensions[$type];
    }
}

if (! function_exists('nameConversion')) {
    /**
     * Name Conversion
     *
     * @param  string  $fileName
     * @return string
     */
    function nameConversion($fileName)
    {
        if (strlen($fileName) > 20) {
            $charStart = substr($fileName, 0, 12);
            $charEnd = substr($fileName, -7);
            $fileName = $charStart . '...' . $charEnd;
        }

        return $fileName;
    }
}

if (! function_exists('getSVGFlag')) {
    /**
     * Get SVG Flag
     *
     * @param  string  $code
     * @return string
     */
    function getSVGFlag($code = 'en')
    {
        $code = strtolower($code);
        $flags = [
            'ar' => 'sa',
            'zh' => 'cn',
            'en' => 'gb',
            'hn' => 'in',
            'rs' => 'ru',
            'bn' => 'bd',
            'ur' => 'pk',
            'cs' => 'cz',
            'zu' => 'za',
            'aa' => 'dj',
            'am' => 'et',
            'ab' => 'ru',
            'as' => 'in',
            'ay' => 'bo',
            'ba' => 'ru',
            'ba' => 'ru',
            'bh' => 'in',
            'bi' => 'vu',
            'br' => 'fr',
            'ca' => 'es',
            'co' => 'fr',
            'cy' => 'gb',
            'da' => 'dk',
            'dz' => 'bt',
            'el' => 'gr',
            'et' => 'ee',
            'fa' => 'ir',
            'fy' => 'nl',
            'ga' => 'ie',
            'gd' => 'gb-sct',
            'gn' => 'py',
            'gu' => 'in',
            'ha' => 'ne',
            'hi' => 'in',
            'hy' => 'am',
            'in' => 'id',
            'iw' => 'il',
            'ja' => 'jp',
            'ka' => 'ge',
            'kk' => 'kz',
            'kl' => 'gl',
            'km' => 'kh',
            'kn' => 'in',
            'ko' => 'kr',
            'ku' => 'iq',
            'ky' => 'kg',
            'la' => 'va',
            'ln' => 'ca',
            'mi' => 'nz',
            'ml' => 'in',
            'mo' => 'md',
            'mr' => 'in',
            'ms' => 'bn',
            'my' => 'mm',
            'ne' => 'np',
            'oc' => 'es-ct',
            'om' => 'et',
            'pa' => 'in',
            'ps' => 'af',
            'rm' => 'ch',
            'rn' => 'bl',
            'sd' => 'pk',
            'sg' => 'cf',
            'sh' => 'rs',
            'sl' => 'si',
            'si' => 'lk',
            'sm' => 'ws',
            'sn' => 'zw',
            'sq' => 'al',
            'sr' => 'rs',
            'ss' => 'sz',
            'st' => 'ls',
            'su' => 'id',
            'sv' => 'se',
            'sw' => 'tz',
            'ta' => 'in',
            'te' => 'in',
            'tg' => 'tj',
            'ti' => 'er',
            'tk' => 'tm',
            'tl' => 'ph',
            'tn' => 'bw',
            'tw' => 'gh',
            'uk' => 'ua',
            'ur' => 'pk',
            'vi' => 'vn',
            'wo' => 'sn',
            'xh' => 'za',
            'yo' => 'ng',
        ];
        if (in_array($code, array_keys($flags))) {
            return $flags[$code];
        }

        return $code;
    }
}

if (! function_exists('createDirectory')) {
    /**
     * create directory method
     * The a directory by the given path if not exists
     *
     * @param  string  $path
     * @param  int  $permission
     * @return $path
     */
    function createDirectory($path = '', $permission = null)
    {
        if (empty($path)) {
            return $path;
        }

        $permission = empty($permission) ? config('app.filePermission') : $permission;

        if (! file_exists($path)) {
            mkdir($path, $permission, true);
        }

        return $path;
    }
}

if (! function_exists('printPDF')) {
    /**
     * Print PDF
     *
     * @param  object  $data
     * @param  string  $filename
     * @param  string  $template
     * @param  view  $renderView
     * @param  string|null  $type
     * @param  string|null  $pdfVal
     * @return response
     */
    function printPDF($data, $filename, $template, $renderView, $type = null, $pdfVal = null)
    {

        if ($pdfVal == 'email') {

            $pdf = PDF::loadView($template, $data);
            $pdf->setPaper(json_decode(preference('invoice'))?->general?->page_size ?? 'A4', 'portrait');

            return file_put_contents($filename, $pdf->output());

        } else {
            Pdf::setOption(['isHtml5ParserEnabled' => true]);
            $pdf = PDF::loadView($template, $data);
            $pdf->setPaper(json_decode(preference('invoice'))?->general?->page_size ?? 'A4', 'portrait');

            return (! empty($type) && $type == 'print') ? $pdf->stream($filename, ['Attachment' => 0]) : $pdf->download($filename, ['Attachment' => 0]);
        }
    }
}

if (! function_exists('initializeMpdf')) {
    /**
     * Initialize Mpdf
     *
     * @return object
     */
    function initializeMpdf(array $options = [])
    {
        $path = createDirectory('public/datta-able/pdf');

        $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new \Mpdf\Mpdf([
            'tempDir' => $path,
            'mode'        => 'utf-8',
            'format'      => 'A4',
            'orientation' => 'P',
            'fontDir' => array_merge($fontDirs, [public_path('datta-able/pdf/fonts/')]),
            'fontdata' => $fontData + [
                'nikosh' => [
                    'R' => 'Nikosh.ttf',
                    'useOTL' => 0xFF,
                ],
            ],
            'default_font' => 'nikosh',
        ]);

        $mpdf->autoScriptToLang         = true;
        $mpdf->autoLangToFont           = true;
        $mpdf->allow_charset_conversion = false;

        return $mpdf;
    }
}

if (! function_exists('getPdfFont')) {
    /**
     * Get Pdf Font
     *
     * @return array
     */
    function getPdfFont()
    {
        $fontFamily = [];

        $languageShortCode = config('app.locale');
        switch ($languageShortCode) {
            case 'ar':
                $fontFamily['name'] = 'Tajawal' . ', sans-serif';
                $fontFamily['link'] = asset('public/dist/fonts/tajawal.css?v1');

                break;

            default:
                $fontFamily['name'] = 'Helvetica Neue' . ', sans-serif';
                $fontFamily['link'] = '#';

                break;
        }

        return $fontFamily;
    }
}

if (! function_exists('maxFileSize')) {
    /**
     * maxFileSize
     *
     * @param  int  $fileSize
     * @return string
     */
    function maxFileSize($fileSize)
    {
        $data = [];
        $maxFileSize = preference('file_size');
        if (isset($maxFileSize) && ! empty($maxFileSize)) {
            $maxFileSize = (int) $maxFileSize;
            if (($fileSize / 1024) <= $maxFileSize * 1024) {
                $data['status'] = 1;
            } elseif (($fileSize / 1024) > $maxFileSize * 1024) {
                $data['status'] = 0;
                $data['message'] = __('Maximum File Size :x MB.', ['x' => $maxFileSize]);
            }

            return $data;
        }
    }
}

if (! function_exists('readCSVFile')) {
    /**
     * Read a CSV file and return data as array
     *
     * @param  string  $csvFile  csv file path
     * @return array
     */
    function readCSVFile($csvFile, $associative = false, $delimeter = ',')
    {
        if (! file_exists($csvFile) || ! is_readable($csvFile)) {
            return false;
        }

        $row = 1;
        $handle = fopen($csvFile, 'r');
        $out = [];
        while (($data = fgetcsv($handle, 0, $delimeter)) !== false) {
            $out[($row - 1)] = $data;
            $row++;
        }
        fclose($handle);

        if ($associative) {
            $headers = array_map('trim', array_shift($out));
            $asso = [];
            foreach ($out as $i => &$item) {
                foreach ($item as $j => &$value) {
                    $asso[$i][$headers[$j]] = $value;
                }
            }
            $out = $asso;
        }

        return $out;
    }
}

if (! function_exists('getBackgroundImage')) {
    /**
     * Convert back slash to forward
     * Common uses for background image
     *
     * @param  string  $url
     * @return string
     */
    function getBackgroundImage($url)
    {
        return urlSlashReplace($url);
    }
}

if (! function_exists('domPdfImageSource')) {
    /**
     * Convert Image source for dompdf
     * Common uses for dompdf
     *
     * @param  string  $url
     * @return string
     */
    function domPdfImageSource($url, $type = 'image/png')
    {

        return 'data:' . $type . ';base64,' . base64_encode(file_get_contents($url));
    }
}
