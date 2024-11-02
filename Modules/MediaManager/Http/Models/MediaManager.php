<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Kabir Ahmed <[kabir.techvill@gmail.com]>
 *
 * @created 05-02-2022
 */

namespace Modules\MediaManager\Http\Models;

use App\Models\Model;
use App\Traits\ModelTrait;
use App\Traits\ModelTraits\hasFiles;

class MediaManager extends Model
{
    use hasFiles;
    use ModelTrait;

    protected $table = 'object_files';

    public $timestamps = false;

    public function store($data = [])
    {
        try {
            $this->uploadFiles(['isUploaded' => false, 'isOriginalNameRequired' => true, 'isMediaManager' => true, 'thumbnail' => true]);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
