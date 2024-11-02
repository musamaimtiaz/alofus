<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sabbir Al-Razi <[sabbir.techvill@gmail.com]>
 *
 * @created 20-05-2021
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cache;

class RoleUser extends Model
{
    use HasFactory;

    /**
     * timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = false;

    public function users()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function roles()
    {
        return $this->belongsTo('App\Models\Role', 'role_id');
    }

    /**
     * Store
     *
     * @param  array  $data
     * @return bool
     */
    public function store($data = [])
    {
        if (parent::insert($data)) {
            return true;
        }

        return false;
    }

    /**
     * get roel id by user
     * Get the roles of a user by user ID
     *
     * @param  int  $userId
     * @return array
     */
    public static function getRoleIDByUser($userId)
    {
        $data = Cache::get(config('cache.prefix') . '-role-id-by-user-' . $userId);

        if (empty($data)) {

            $data = optional(parent::where('user_id', $userId)->first())->role_id;
            Cache::put(config('cache.prefix') . '-role-id-by-user-' . $userId, $data, 7 * 86400);
        }

        return $data;
    }

    /**
     * Update RoleUser
     *
     * @param  array  $data
     * @param  null  $id
     * @return bool
     */
    public function update($data = [], $id = null)
    {
        $result = parent::where('user_id', $data['user_id']);
        if ($result->exists()) {
            $result->update($data);
            Cache::forget(config('cache.prefix') . '-role-id-by-user-' . $data['user_id']);

            return true;
        } else {
            parent::insert($data);
            Cache::forget(config('cache.prefix') . '-role-id-by-user-' . $data['user_id']);
        }

        return false;
    }

    /**
     * delete
     *
     * @param  int  $id
     * @return object
     */
    public function remove($id)
    {
        $data = ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];
        $record = parent::where('user_id', $id);
        if (! empty($record)) {
            $record->delete();
            $data['status'] = 'success';
            Cache::forget(config('cache.prefix') . '-role-id-by-user-' . $id);
        }
    }
}
