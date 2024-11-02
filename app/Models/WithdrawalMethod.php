<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 20-02-2022
 */

namespace App\Models;

class WithdrawalMethod extends Model
{
    public $timestamps = false;

    /**
     * Relation with UserWithdrawalSetting model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function withdrawalSetting()
    {
        return $this->hasOne(UserWithdrawalSetting::class)->where('user_id', auth()->user()->id);
    }

    /**
     * Update
     *
     * @param  array  $request
     * @return array
     */
    public function updateData($data = [])
    {
        $withdrawal = [];
        foreach ($data as $key => $value) {
            $withdrawal[] = ['method_name' => ucfirst($key), 'status' => $value];
        }

        if (parent::upsert($withdrawal, ['method_name'], ['status'])) {
            self::forgetCache();

            return 1;
        }

        return 0;
    }
}
