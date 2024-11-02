<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Kabir Ahmed <[kabir.techvill@gmail.com]>
 *
 * @created 02-15-2022
 */

namespace Modules\Ticket\Http\Models;

use App\Models\Model;

class Priority extends Model
{
    public $timestamps = false;

    public function threads()
    {
        return $this->hasMany('Modules\Ticket\Http\Models\Thread', 'priority_id');
    }
}
