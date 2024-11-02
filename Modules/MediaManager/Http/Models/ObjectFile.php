<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Kabir Ahmed <[kabir.techvill@gmail.com]>
 *
 * @created 02-07-2022
 */

namespace Modules\MediaManager\Http\Models;

use App\Models\Model;
use App\Traits\ModelTraits\hasFiles;

class ObjectFile extends Model
{
    use hasFiles;

    public $timestamps = false;

    public static function storeInObjectFiles($objectType = null, $objectId = null, $fileIds = null)
    {
        $objectFiles = [];
        if (count($fileIds) > 0) {
            foreach ($fileIds as $data) {
                $objectFiles[] = [
                    'object_type' => $objectType,
                    'object_id' => $objectId,
                    'file_id' => $data,
                ];
            }

            return parent::insert($objectFiles);
        }

    }

    public function deleteFiles($objectType = null, $objectId = null, $options = [], $path = null)
    {
        $result['status'] = 0;
        $result['fileStatus'] = __(':x does not exist.', ['x' => __('Attachment')]);
        $files = $this->getFiles($objectType, $objectId, $options);
        if (! empty($files)) {
            foreach ($files as $key => $value) {
                if ($this->where('id', $value->id)->delete()) {
                    $result['status'] = 1;
                }
            }
        }

        return json_encode($result);
    }

    public function unlinkFile($file)
    {
        $result['status'] = 0;
        $result['fileStatus'] = __(':x does not exist.', ['x' => __('Attachment')]);
        if (file_exists($file)) {
            @unlink($file);
            $result['status'] = 1;
            $result['fileStatus'] = __('Attachment deleted');
        }

        return $result;
    }

    public function getFiles($objectType = null, $objectId = null, $options = [])
    {
        $options = array_merge(['ids' => [], 'isExcept' => false, 'limit' => null], $options);
        if (empty($objectType) && empty($objectId) && empty($options['ids'])) {
            return [];
        }
        $query = $this->whereNotNull('object_id')->select();
        if (! empty($objectType) && ! empty($objectId)) {
            $objectId = ! is_array($objectId) ? [$objectId] : $objectId;
            $query->where('object_type', $objectType)->whereIn('object_id', $objectId);
        }
        if (! empty($options['ids'])) {
            if ($options['isExcept']) {
                $query->whereNotIn('id', $options['ids']);
            } else {
                $query->whereIn('id', $options['ids']);
            }
        }
        if (! empty($options['limit'])) {
            $query->limit($options['limit']);
        }

        return $query->get();
    }
}
