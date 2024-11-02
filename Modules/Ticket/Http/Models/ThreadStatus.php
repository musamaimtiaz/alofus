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

class ThreadStatus extends Model
{
    public $timestamps = false;

    public function tickets()
    {
        return $this->hasMany('App\Models\Ticket', 'ticket_status_id');
    }
}
