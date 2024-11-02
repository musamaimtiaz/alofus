<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md Abdur Rahaman Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 19-11-2022
 */

namespace App\Services\Import;

class ReaderGenerator
{
    public $handler;

    public function __construct($file)
    {
        $this->handler = fopen($file, 'r');
    }

    public function getRow($delimeter = ',')
    {
        while (! feof($this->handler)) {
            $row = fgetcsv($this->handler, 0, $delimeter);
            yield $row;
        }

        fclose($this->handler);

    }
}
