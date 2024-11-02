<?php

namespace App\Models;

use App\Traits\ModelTraits\hasFiles;
use Illuminate\Database\Eloquent\Model;
use Modules\MediaManager\Http\Models\ObjectFile;

class Seo extends Model
{
    use hasFiles;

    /**
     * Foreign key with Blog model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function blog()
    {
        return $this->belongsTo('Modules\Blog\Http\Models\Blog', 'blog_id');
    }

    /**
     * Store or Update
     *
     * @param  array  $data
     * @return bool
     */
    public function storeOrUpdate($data = [], $columnName = null)
    {
        if (! empty($columnName)) {
            $result = parent::where($columnName, $data[$columnName])->first();
            if (parent::updateOrInsert([$columnName => $data[$columnName]], $data)) {
                if (! empty($result)) {
                    $result->first()->updateFiles(['isUploaded' => false, 'isOriginalNameRequired' => true, 'thumbnail' => false]);
                } else {
                    $fileIds = [];
                    if (request()->has('file_id')) {
                        foreach (request()->file_id as $data) {
                            $fileIds[] = $data;
                        }
                    }
                    ObjectFile::storeInObjectFiles($this->objectType(), $this->objectId(), $fileIds);
                }

                return true;
            }
        }

        return false;
    }
}
