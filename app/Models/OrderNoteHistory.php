<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 01-06-2022
 */

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Support\Facades\Validator;

class OrderNoteHistory extends Model
{
    use ModelTrait;

    protected $fillable = ['order_id', 'user_id', 'note'];

    /**
     * Foreign key with user model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Foreign key with order model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Store Validation
     *
     * @param  array  $data
     * @return mixed
     */
    public static function storeValidation($data = [])
    {
        $validator = Validator::make($data, [
            'user_id' => 'required|exists:users,id',
            'order_id' => 'required|exists:orders,id',
            'note' => 'required|max:191',
        ]);

        return $validator;
    }

    /**
     * Store
     *
     * @param  array  $data
     * @return bool|object
     */
    public function storeData($data = [])
    {
        if ($data = parent::create($data)) {
            return $data;
        }

        return false;
    }
}
