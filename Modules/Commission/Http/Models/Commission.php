<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 07-02-2022
 */

namespace Modules\Commission\Http\Models;

use App\Models\Model;
use Validator;

class Commission extends Model
{
    /**
     * commission store or update validation
     *
     * @return mixed
     */
    protected static function storeOrUpdateValidation($data = [])
    {
        $validator = Validator::make($data, [
            'amount' => 'required|numeric',
            'is_commission_active' => 'sometimes|in:on',
            'is_category_based' => 'sometimes|in:on',
        ]);

        return $validator;
    }

    /**
     * Store or Update
     *
     * @param  array  $data
     * @return bool
     */
    public function storeOrUpdate($data = [])
    {
        if (parent::updateOrInsert(['id' => 1], $data)) {
            self::forgetCache();

            return true;
        }

        return false;
    }
}
