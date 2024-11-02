<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 20-02-2022
 */

namespace App\Models;

class UserWithdrawalSetting extends Model
{
    public $timestamps = false;

    /**
     * Relation with User model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Update
     *
     * @param  array  $request
     * @return array
     */
    public function updateData($data = [])
    {
        if ($data['is_default'] == 1) {
            parent::where(['is_default' => 1, 'user_id' => $data['user_id']])->update(['is_default' => 0]);
        }
        if (parent::updateOrInsert(['user_id' => $data['user_id'], 'withdrawal_method_id' => $data['withdrawal_method_id']], $data)) {
            self::forgetCache();

            return ['status' => 'success', 'message' => __('Withdrawal setting save successfully.')];
        }

        return ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];

    }
}
