<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Kabir Ahmed <[kabir.techvill@gmail.com]>
 *
 * @created 26-12-2021
 */

namespace Modules\CMS\Http\Models;

use App\Models\Model;
use App\Traits\ModelTrait;
use Modules\MediaManager\Http\Models\ObjectFile;
use App\Traits\ModelTraits\{
    Cachable, hasFiles
};

class Slide extends Model
{
    use Cachable;
    use hasFiles;
    use ModelTrait;

    /**
     * Relation wirh File Model
     *
     * @var bool
     */
    public function image()
    {
        return $this->hasOne('App\Models\File', 'object_id')->where('object_type', 'pages');
    }

    /**
     * Foreign key with ObjectFile model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function objectImage()
    {
        return $this->hasOne('Modules\MediaManager\Http\Models\ObjectFile', 'object_id')->where('object_type', 'slides');
    }

    /**
     * Foreign key with Slider model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function slider()
    {
        return $this->belongsTo(Slider::class);
    }

    /**
     * Animation style value
     *
     * @return array
     */
    protected function animationStyle()
    {
        return [
            'fadeIn' => __('fadeIn'),
            'fadeInDown' => __('fadeInDown'),
            'fadeInLeft' => __('fadeInLeft'),
            'fadeInRight' => __('fadeInRight'),
            'fadeInUp' => __('fadeInUp'),
            'flip' => __('flip'),
            'flipInX' => __('flipInX'),
            'flipInY' => __('flipInY'),
            'slideInUp' => __('slideInUp'),
            'slideInDown' => __('slideInDown'),
            'slideInLeft' => __('slideInLeft'),
            'slideInRight' => __('slideInRight'),
            'rollIn' => __('rollIn'),
        ];
    }

    /**
     * Store Slide
     *
     * @param  array  $data
     * @return bool
     */
    public function store($data = [])
    {
        if (parent::insertGetId($data)) {
            $fileIds = [];
            if (request()->has('file_id')) {
                foreach (request()->file_id as $data) {
                    $fileIds[] = $data;
                }
            }
            ObjectFile::storeInObjectFiles($this->objectType(), $this->objectId(), $fileIds);
            self::forgetCache();

            return true;
        }

        return false;
    }

    /**
     * Update Slide
     *
     * @param  array  $data
     * @param  int  $id
     * @return bool
     */
    public function updateData($data = [], $id = null)
    {
        $result = parent::where('id', $id);
        if ($result->exists()) {
            if ($result->update($data)) {
                $result->first()->updateFiles(['isUploaded' => false, 'isOriginalNameRequired' => true, 'thumbnail' => true]);
                self::forgetCache();

                return true;
            }
        }

        return false;
    }

    /**
     * Delete Slide
     *
     * @param  int  $id
     * @return array $data
     */
    public function remove($id = null)
    {
        $data = ['status' => 'fail', 'message' => __('Slide does not found.')];
        $slide = $this->where('id', $id)->first();
        if (empty($slide)) {
            return $data;
        }

        if ($slide->delete()) {
            $slide->deleteFileObjects(['thumbnail' => true]);
            $data = ['status' => 'success', 'message' => __('Slide has been successfully deleted.')];
            self::forgetCache();
        }

        return $data;
    }
}
