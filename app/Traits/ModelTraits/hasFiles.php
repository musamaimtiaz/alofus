<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Millat <[millat.techvill@gmail.com]>
 *
 * @created 18-09-2021
 */

namespace App\Traits\ModelTraits;

use App\Models\File;
use Illuminate\Http\UploadedFile;
use Modules\MediaManager\Http\Models\MediaManager;
use Modules\MediaManager\Http\Models\ObjectFile;

trait hasFiles
{
    /**
     * object type of file
     *
     * @return string
     */
    protected function objectType()
    {
        return self::getTable();
    }

    protected function checkDirectory()
    {
        return date('Ymd');
    }

    /**
     * object id of file
     *
     * @return string
     */
    protected function objectId()
    {
        return ! is_null($this->id) ? $this->id : static::max('id');
    }

    /**
     * upload folder of object file
     *
     * @return string
     */
    protected function uploadPath()
    {
        return createDirectory(implode(DIRECTORY_SEPARATOR, ['public', 'uploads', $this->checkDirectory()]));
    }

    /**
     * Upload thumbnail path
     *
     * @param  string  $size
     * @return string
     */
    protected function thumbnailPath($size = 'small')
    {
        return createDirectory(implode(DIRECTORY_SEPARATOR, ['public', 'uploads', config('martvill.thumbnail_dir'), $size, $this->checkDirectory()]));
    }

    protected function uploadPathNew()
    {
        return createDirectory(implode(DIRECTORY_SEPARATOR, ['public', 'uploads']));
    }

    /**
     * file path of a give file
     *
     * @param  string  $fileName
     * @return string
     */
    protected function filePath($fileName)
    {
        return implode(DIRECTORY_SEPARATOR, [$this->uploadPathNew(), $fileName]);
    }

    //remove it later start
    protected function filePathOld($fileName)
    {
        return implode(DIRECTORY_SEPARATOR, [$this->uploadPathOld(), $fileName]);
    }

    protected function uploadPathOld()
    {
        return createDirectory(implode(DIRECTORY_SEPARATOR, ['public', 'uploads', $this->objectType()]));
    }
    //remove it later end

    protected function filePathNew($fileName)
    {
        return implode(DIRECTORY_SEPARATOR, [$this->uploadPathNew(), $fileName]);
    }

    /**
     * default file
     *
     * @param  string  $fileName
     * @return string
     */
    protected function defaultFileUrl(string $type)
    {
        return url(defaultImage($type));
    }

    /**
     * difine relationship of a model
     *
     * @return collection
     */
    public function file()
    {
        return $this->hasOne('App\Models\File', 'object_id')->where('object_type', $this->objectType());
    }

    public function objectFile()
    {
        return $this->hasOne('Modules\MediaManager\Http\Models\ObjectFile', 'object_id')->where(['object_type' => $this->objectType()]);
    }

    public function fileNew($id)
    {
        return File::where(['id' => $id]);
    }

    /**
     * upload file(s)
     *
     * @return none
     */
    public function uploadFiles(array $options = [])
    {
        foreach (request()->all() as $key => $value) {
            $file = [];
            if (request()->hasFile($key)) {
                if (isset($options['pagebuilder'])) {
                    $file = request()->file($key);
                } elseif (is_array($value)) {
                    $file = [request()->$key];
                    if (is_multidimensional([request()->$key])) {
                        $file = request()->$key;
                    }
                } elseif (pathinfo($value->getClientOriginalName(), PATHINFO_EXTENSION) != 'csv') {
                    $file = [request()->$key];
                    if (is_multidimensional([request()->$key])) {
                        $file = request()->$key;
                    }
                } elseif (pathinfo($value->getClientOriginalName(), PATHINFO_EXTENSION) == 'csv') {
                    $file = [request()->$key];
                    if (is_multidimensional([request()->$key])) {
                        $file = request()->$key;
                    }
                }

            }
            if (isset(request()->attachments) && ! empty(request()->attachments)) {
                $file = request()->attachments;
                if (is_multidimensional(request()->attachments)) {
                    foreach (request()->attachments as $key => $value) {
                        $file = $value;
                    }
                }
            }

            if (count($file) > 0) {
                if (isset(request()->deleted_files) && ! empty(request()->deleted_files)) {
                    $deleted = explode(',', request()->deleted_files);
                    foreach ($file as $k => $val) {
                        if (in_array($val->getClientOriginalName(), $deleted)) {
                            unset($file[$k]);
                        }
                    }
                    if (empty($file)) {
                        return false;
                    }
                }

                $fileIds = (new File())->store($file, $this->uploadPath(), $options);
                if (isset($options['pagebuilder'])) {
                    return $fileIds;
                }
                if (isset($options['isSavedInObjectFiles']) && $options['isSavedInObjectFiles'] == true) {
                    ObjectFile::storeInObjectFiles($this->objectType(), $this->objectId(), $fileIds);
                }
                if (! empty($fileIds) && isset($options['thumbnail']) && $options['thumbnail'] == true && checkFileValidation($value->getClientOriginalExtension(), 3) == true) {
                    $this->createThumbnail($fileIds);
                }
            }
        }
    }

    /**
     * Get files from request
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return array
     */
    private function getTheseFiles($key, $value)
    {
        $output = [];
        if (request()->hasFile($key)) {
            if (is_array($value)) {
                $output = [request()->file($key)];
                if (is_multidimensional([request()->file($key)])) {
                    $output = request()->file($key);
                }
            } elseif (pathinfo($value->getClientOriginalName(), PATHINFO_EXTENSION) != 'csv') {
                $output = [request()->$key];
                if (is_multidimensional([request()->file($key)])) {
                    $output = request()->file($key);
                }
            }

        }
        if (isset(request()->attachments) && ! empty(request()->attachments)) {
            $output = request()->attachments;
            if (is_multidimensional(request()->attachments)) {
                foreach (request()->attachments as $key => $value) {
                    $output = $value;
                }
            }
        }

        return $output;
    }

    /**
     * Checks if input has deleted files then process them
     *
     * @param  array  $files
     * @return bool|array
     */
    private function ifHasDeletedFiles($files)
    {
        if (isset(request()->deleted_files) && ! empty(request()->deleted_files)) {
            $deleted = explode(',', request()->deleted_files);
            foreach ($files as $k => $val) {
                if (in_array($val->getClientOriginalName(), $deleted)) {
                    unset($files[$k]);
                }
            }
            if (empty($files)) {
                return false;
            }
        }

        return $files;
    }

    /**
     * upload file(s) from url
     *
     * @return none
     */
    public function uploadFilesFromUrl($url, array $options = [])
    {
        if (! empty($url)) {
            $fileIds = (new File())->storeFromUrl($url, $this->uploadPath(), $options);

            if (isset($options['isSavedInObjectFiles']) && $options['isSavedInObjectFiles'] == true) {
                ObjectFile::storeInObjectFiles($this->objectType(), $this->objectId(), $fileIds);
            }
            if (! empty($fileIds) && isset($options['thumbnail']) && $options['thumbnail'] == true) {
                $this->createThumbnail($fileIds);
            }
        }
    }

    /**
     * upload file(s)
     *
     * @return none
     */
    public function updateFiles(array $options = [])
    {
        if (! empty(request()->file_id)) {
            foreach (request()->file_id as $data) {
                if (is_null($data)) {
                    continue;
                }
                $mediaManager = MediaManager::select('id')->where(['object_type' => $this->objectType(), 'object_id' => $this->objectId()])->first();
                if ($mediaManager) {
                    $mediaManager->file_id = $data;

                    return $mediaManager->save();
                } else {
                    (new ObjectFile())->storeInObjectFiles($this->objectType(), $this->objectId(), [$data]);
                }
            }
        } else {
            foreach (request()->all() as $key => $value) {
                if (request()->hasFile($key)) {
                    $file = [request()->$key];
                    if (is_multidimensional([request()->$key])) {
                        $file = request()->$key;
                    }

                    $this->deleteFiles(isset($options['thumbnail']) && $options['thumbnail'] == true ? ['thumbnail' => true] : ['thumbnail' => false]);
                    if (! empty($file)) {
                        $fileIds = (new File())->store($file, $this->uploadPath(), $options);

                        if (isset($options['isSavedInObjectFiles']) && $options['isSavedInObjectFiles'] == true) {
                            ObjectFile::storeInObjectFiles($this->objectType(), $this->objectId(), $fileIds);
                        }
                        if (! empty($fileIds) && isset($options['thumbnail']) && $options['thumbnail'] == true) {
                            $this->createThumbnail($fileIds);
                        }
                    }
                }
            }
        }

    }

    public function fileName(array $options = [])
    {
        $options = array_merge([
            'default' => true,
            'type' => $this->objectType(),
        ], $options);

        return $file = $this->file()->get();
    }

    /**
     * get file url from model instance
     */
    public function fileUrl(array $options = []): string
    {
        $options = array_merge([
            'default' => true,
            'type' => $this->objectType(),
        ], $options);

        if (cache()->has(config('cache.prefix') . '.loadItem.' . $this->id)) {
            return url($this->filePath(cache()->get(config('cache.prefix') . '.loadItem.' . $this->id)));
        } else {
            $files = $this->objectFile()->first();
            // remove it later start
            if (is_null($files)) {
                $file = $this->file()->first();
                if (is_null($file)) {
                    return $this->defaultFileUrl($options['type']);
                }

                if (! file_exists($this->filePathOld($file->file_name))) {
                    return $this->defaultFileUrl($options['type']);
                }

                return url($this->filePathOld($file->file_name));
            }
            // remove it later end
            $file = $this->fileNew($files->file_id)->first();

            $fileName = substr($file->file_name, strrpos($file->file_name, '\\') + 1);

            if (is_null($file)) {
                return $this->defaultFileUrl($options['type']);
            }
            if (! file_exists($this->filePath($file->file_name))) {

                if (isset($options['defaultImage'])) {
                    return '';
                }

                return $this->defaultFileUrl($options['type']);
            }
            if ($this->table == 'items' && isset($options['home'])) {
                cache()->put([config('cache.prefix') . '.loadItem.' . $this->id => $file->file_name], now()->addDays(1));
            }

            return url($this->filePath($file->file_name));
        }
    }

    public function fileUrlNew(array $options = []): string
    {
        $file = $this->fileNew($options['id'])->first();
        $fileName = substr($file->file_name, strrpos($file->file_name, '\\') + 1);
        if (isset($options['isMediamanager']) && (is_null($file) || (! file_exists($this->filePath($file->file_name))))) {
            return '';
        }
        if (is_null($file)) {
            return $this->defaultFileUrl('media_managers');
        }
        if (! file_exists($this->filePath($file->file_name))) {
            return $this->defaultFileUrl($options['type']);
        }

        return url($this->filePathNew($file->file_name));
    }

    /**
     * get files url
     */
    public function filesUrl(array $options = []): array
    {
        $options = array_merge([
            'default' => true,
            'type' => $this->objectType(),
        ], $options);

        $files = $this->file()->get();

        if ($files->count() <= 0) {
            return [$this->defaultFileUrl($options['type'])];
        }

        $filesUrl = [];

        foreach ($files as $key => $file) {

            if (! file_exists($this->filePathOld($file->file_name))) {
                $filesUrl[$key] = $this->defaultFileUrl($options['type']);
            } else {
                $filesUrl[$key] = url($this->filePathOld($file->file_name));
            }
        }

        return $filesUrl;
    }

    public function filesUrlNew(array $options = []): array
    {
        $options = array_merge([
            'default' => true,
            'type' => $this->objectType(),
        ], $options);
        if (cache()->has(config('cache.prefix') . '.loadItem.' . $this->id)) {
            return url($this->filePath(cache()->get(config('cache.prefix') . '.loadItem.' . $this->id)));
        } else {
            $files = $this->objectFile()->get();

            if ($files->count() <= 0) {
                return [];
            }

            $filesUrlNew = [];
            $filesPath = [];

            foreach ($files as $key => $file) {
                $file = $this->fileNew($file->file_id)->first();
                if (! file_exists($this->filePath($file->file_name))) {
                    $filesUrlNew[$key] = '';
                    $filesPath[$key] = $this->defaultFileUrl($options['type']);
                } else {
                    $filesUrlNew[$key] = $file;
                    $filesPath[$key] = url($this->filePath($file->file_name));
                }
            }

            return ! empty($options['imageUrl']) ? $filesPath : $filesUrlNew;
        }
    }

    // remove it later start
    public function filesUrlold(array $options = []): array
    {
        $options = array_merge([
            'default' => true,
            'type' => $this->objectType(),
        ], $options);

        $files = $this->objectFile()->get();

        if ($files->count() <= 0) {
            return [$this->defaultFileUrl($options['type'])];
        }

        $filesUrl = [];

        foreach ($files as $key => $file) {
            $file = $this->fileNew($file->file_id)->first();
            if (! file_exists($this->filePath($file->file_name))) {
                $filesUrl[$key] = $this->defaultFileUrl($options['type']);
            } else {
                $filesUrl[$key] = url($this->filePath($file->file_name));
            }
        }

        return $filesUrl;
    }
    //remove it later end

    /**
     * delete from media manger
     *
     * @return bool
     */
    public function deleteFromMediaManager($options = [])
    {
        $objectFile = $this->objectFile();
        if (! $objectFile->exists()) {
            return true;
        }

        return $objectFile->delete() ? true : false;
    }

    /**
     * delete of object file(s)
     *
     * @return json
     */
    public function deleteFiles(array $options = [])
    {
        $fileIDs = ObjectFile::where(['object_type' => $this->objectType(), 'object_id' => $this->objectId()])
            ->get()
            ->pluck('file_id')
            ->toArray();
        if (empty($fileIDs)) {
            return false;
        }

        $IDs = [$fileIDs];
        if (is_multidimensional([$fileIDs])) {
            $IDs = $fileIDs;
        }

        $option = ['ids' => $IDs, 'isExceptId' => false];
        if (isset($options['thumbnail']) && $options['thumbnail'] == true) {
            $option = array_merge(['thumbnail' => true, 'thumbnailPath' => $this->uploadPath() . '/thumbnail'], $option);
        }

        return (new File())->deleteFiles(
            null,
            null,
            $option,
            $this->uploadPathNew()
        );
    }

    public function deleteFileObjects(array $options = [])
    {
        $fileIDs = ObjectFile::where(['object_type' => $this->objectType(), 'object_id' => $this->objectId()])
            ->get()
            ->pluck('id')
            ->toArray();
        if (empty($fileIDs)) {
            return false;
        }
        $IDs = [$fileIDs];
        if (is_multidimensional([$fileIDs])) {
            $IDs = $fileIDs;
        }

        $option = ['ids' => $IDs, 'isExceptId' => false];
        if (isset($options['thumbnail']) && $options['thumbnail'] == true) {
            $option = array_merge(['thumbnail' => true, 'thumbnailPath' => $this->uploadPath() . '/thumbnail'], $option);
        }

        return (new ObjectFile())->deleteFiles(
            $this->objectType(),
            $this->objectId(),
            $option,
            $this->uploadPath()
        );
    }

    /**
     * create thumbnail(s)
     *
     * @return none
     */
    public function createThumbnail(array $fileIds = [])
    {
        foreach ($fileIds as $key => $fileId) {
            $this->makeThumbnail($fileId);
        }
    }

    /**
     * make thumbnail
     *
     * @param  int  $id
     * @return bool
     */
    public function makeThumbnail($id)
    {
        $uploadedFileName = File::find($id)->file_name;
        $uploadedFilePath = asset($this->uploadPath());
        $thumbnailPath = createDirectory($this->uploadPath());
        (new File())->resizeImageThumbnail($uploadedFilePath, $uploadedFileName, $thumbnailPath);

        return true;
    }

    /**
     * check if valid image
     *
     * @param  mixed  $file
     * @return bool
     */
    private function checkIfValidImage($file)
    {
        try {
            if (! $file instanceof UploadedFile) {
                return false;
            }

            return checkFileValidation($file->getClientOriginalExtension(), 3);
        } catch (\Throwable $th) {
            return false;
        }
    }
}
