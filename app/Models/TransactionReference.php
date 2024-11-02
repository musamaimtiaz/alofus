<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 14-12-2021
 */

namespace App\Models;

class TransactionReference extends Model
{
    public $timestamps = false;

    public function createReference($reference_type, $object_id)
    {
        $reference = $this->where('reference_type', $reference_type)->latest('id')->first();
        $newReference = new TransactionReference();
        $newReference->object_id = $object_id;
        $newReference->reference_type = $reference_type;
        if (! empty($reference)) {
            $refNo = (int) explode('/', $reference->code)[0];
            $newReference->code = sprintf('%03d', $refNo + 1) . '/' . date('Y');
        } else {
            $newReference->code = sprintf('%03d', 1) . '/' . date('Y');
        }

        if ($newReference->save()) {
            return $newReference;
        }

        return null;
    }
}
