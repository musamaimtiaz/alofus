<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md Abdur Rahaman Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 08-12-2022
 */

namespace App\Enums;

abstract class ProductStatus
{
    public static $Published = 'Published';

    public static $Draft = 'Draft';

    public static $PendingReview = 'Pending Review';
}
