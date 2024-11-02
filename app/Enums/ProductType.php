<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md Abdur Rahaman Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 08-12-2022
 */

namespace App\Enums;

abstract class ProductType
{
    public static $Simple = 'Simple Product';

    public static $Variable = 'Variable Product';

    public static $Variation = 'Variation';

    public static $Grouped = 'Grouped Product';

    public static $External = 'External/Affiliate Product';
}
