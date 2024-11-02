<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Millat <[millat.techvill@gmail.com]>
 *
 * @created 06-09-2021
 */

namespace App\Traits;

use App\Traits\ModelTraits\{
    FormatDateTime,
    Cachable,
    EloquentHelper,
    Filterable
};

trait ModelTrait
{
    use Cachable;
    use EloquentHelper;
    use Filterable;
    use FormatDateTime;
}
