<?php

namespace App\Models;

use App\Traits\ModelTrait;
use App\Traits\ModelTraits\hasFiles;
use Auth;
use Image;
use Response;

class File extends Model
{
    use hasFiles;
    use ModelTrait;

    public $timestamps = false;

    private $_tempDirectory = 'public/contents/temp/';

    protected $casts = [
        'params' => 'array',
    ];

    /**
     * Foreign key with User model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userAvatar()
    {
        return $this->belongsTo('App\Models\User', 'object_id');
    }

    /**
     * Foreign key with User model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'uploaded_by');
    }

    /**
     * [store description]
     *
     * @param  [array] $files      [description]
     * @param  [string] $uploadPath [description]
     * @param  [string] $objectType [description]
     * @param  [int] $objectId   [description]
     * @return [array]             [description]
     */
    public function store($files = null, $uploadPath = null, $options = [], $uploadFrom = 'web')
    {
        $userId = Auth::user()->id;
        $ids = [];
        $urls = [];
        $params = [];
        if (empty($files) || empty($uploadPath)) {
            return $ids;
        }
        $options = array_merge(['isOriginalNameRequired' => false, 'isUploaded' => false, 'size' => []], $options);
        $filePath	  = $options['isUploaded'] ? $this->_tempDirectory : '';
        foreach ($files as $file) {
            if (preference('file_size') * 1024 >= $file->getSize() / 1024) {
                $attribute = [
                    'size' => $file->getSize() / 1024,
                    'type' => $file->getClientOriginalExtension(),
                ];
                $checkFileExtention = checkFileValidation($file->getClientOriginalExtension());
                $fileSize = $file->getSize() / 1024;
                $fileExtention = $file->getClientOriginalExtension();
                $continue = false;
                switch ($options['isUploaded']) {
                    case true:
                        $filename = $file;
                        $originalFileName = implode(array_slice(explode('_', $filename), 2));
                        if (file_exists($filePath . $filename)) {
                            $continue = rename($filePath . $filename, $uploadPath . DIRECTORY_SEPARATOR . $filename);
                        }

                        break;
                    default:
                        $filename = preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', $file->getClientOriginalName()));
                        $originalFileName = $file->getClientOriginalName();
                        $filename = $this->checkDirectory() . DIRECTORY_SEPARATOR . md5(uniqid()) . '.' . $file->getClientOriginalExtension();

                        if (! empty($options['size'])) {
                            try {
                                $img = Image::make($file->getRealPath());
                            } catch (\Intervention\Image\Exception\NotReadableException $e) {
                                // Exception message will be send later on.
                            }
                            $continue = $img->resize($options['size'][0], $options['size'][1], function ($constraint) {
                                $constraint->aspectRatio();
                            })->save($uploadPath . DIRECTORY_SEPARATOR . $filename);
                        } else {
                            $continue = $file->move($uploadPath, $filePath . $filename);
                        }

                        break;
                }

                if ($continue) {
                    $list = [];
                    foreach ($attribute as $key => $array_item) {
                        if (! is_null($array_item)) {
                            $list[$key] = $array_item;
                        }
                    }
                    if ($checkFileExtention) {
                        $data                     = new File();
                        $data->params        	  = $list;
                        $data->original_file_name = $options['isOriginalNameRequired'] ? $originalFileName : null;
                        $data->file_name          = $filename;
                        $data->file_size          = $fileSize;
                        $data->object_type        = $fileExtention;
                        $data->uploaded_by        = ! empty($userId) ? $userId : null;
                        if ($data->save()) {
                            $ids[] = $data->id;
                        }
                    }

                }
            }

        }

        return count($urls) > 0 ? ['urls' => $urls, 'ids' => $ids] : $ids;
    }

    public function storeFromUrl($url = null, $uploadPath = null, $options = [])
    {
        $ids = null;
        if (empty($url) || empty($uploadPath)) {
            return $ids;
        }
        $ids = [];
        $info = pathinfo($url);
        $contents = file_get_contents($url);
        $originalFileName = $info['basename'];
        $imSize = getimagesize($url);
        $attribute = [
            'size' => $imSize['bits'] ? $imSize['bits'] : null,
            'type' => 'jpg',
        ];
        $filename = preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', $originalFileName));
        $filename = md5(uniqid()) . '.' . 'jpg';
        $continue = file_put_contents($uploadPath . DIRECTORY_SEPARATOR . $filename, $contents);
        $file = $this->checkDirectory() . DIRECTORY_SEPARATOR . $filename;
        if ($continue) {
            $list = [];
            foreach ($attribute as $key => $array_item) {
                if (! is_null($array_item)) {
                    $list[$key] = $array_item;
                }
            }
            $data                     = new File();
            $data->params             = $list;
            $data->original_file_name = $options['isOriginalNameRequired'] ? $originalFileName . '.jpg' : null;
            $data->file_name          = $file;
            $data->uploaded_by        = ! empty($options['uploaded_by']) ? $options['uploaded_by'] : null;
            if ($data->save()) {
                $ids[] = $data->id;
            }
        }

        return $ids;
    }

    /**
     * [getFiles description]
     *
     * @param  [string] $objectType [description]
     * @param  [int] $objectId   [description]
     * @param  [array] $options   [description]
     * @return [array]             [description]
     */
    public function getFiles($objectType = null, $objectId = null, $options = [])
    {
        $options = array_merge(['ids' => [], 'isExcept' => false, 'limit' => null], $options);
        if (empty($objectType) && empty($objectId) && empty($options['ids'])) {
            return [];
        }
        $query = $this->whereNotNull('file_name')->select();
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

    public function allFiles()
    {
        return File::select(['id', 'file_name'])->orderBy('id', 'desc')->get();
    }

    public static function getAllFiles($options = [])
    {
        $sortValue = request()->sort_value ?? null;
        $name = request()->search ?? null;
        $sortName = request()->sort_name ?? null;
        $result = File::query()->sortByDefinedValue($sortValue);
        $user = User::whereHas('roleUser', function ($query) {
            $query->where('role_id', 1);
        })->active()->where('id', auth()->user()->id)->first();

        if ($name) {
            $result = $result->where('original_file_name', $name);
        }
        if ($sortName) {
            $result = $result->where('original_file_name', 'like', '%' . $sortName . '%');
        }
        if (is_null($user)) {
            $result = $result->where('uploaded_by', auth()->user()->id);
        }

        if (request()->imageType) {
            $type = explode(',', request()->imageType);
            $result = $result->whereIn('object_type', $type);
        }

        return $result->whereNotNull('uploaded_by')->simplePaginate(preference('row_per_page', 10));
    }

    /**
     * [getFiles description]
     *
     * @param  [string] $objectType [description]
     * @param  [int] $objectId   [description]
     * @param  [array] $options  [description]
     * @return [array]           [description]
     */
    public function copyFiles($source, $destination, $fromObjectType = null, $fromObjectId = null, $toObjectType = null, $toObjectId = null, $options = [])
    {
        $fileList = ['status' => 0, 'fileStatus' => __(':x does not exist.', ['x' => __('Attachment')]), 'files' => []];
        if (empty($source) || empty($destination) || empty($fromObjectType) || empty($fromObjectId)) {
            return $fileList;
        }
        $options = array_merge(['ids' => [], 'isTemporary' => false, 'isOriginalNameRequired' => false], $options);
        $files = $this->getFiles($fromObjectType, $fromObjectId, $options);
        if (! empty($files)) {
            $fileList['status'] = 1;
            $fileList['fileStatus'] = __('Attachment found');
            foreach ($files as $key => $file) {
                $originalName = implode('_', array_slice(explode('_', $file->file_name), 2));
                $copiedName = md5(time()) . '_' . Auth::user()->id . '_' . $originalName;
                if ($options['isTemporary']) {
                    if (copy($source . DIRECTORY_SEPARATOR . $file->file_name, $this->_tempDirectory . DIRECTORY_SEPARATOR . $copiedName)) {
                        $fileList['files'][] = $copiedName;
                    }
                } else {
                    if (file_exists($source . DIRECTORY_SEPARATOR . $file->file_name) && copy($source . DIRECTORY_SEPARATOR . $file->file_name, $destination . DIRECTORY_SEPARATOR . $copiedName)) {
                        $data               	  = new File();
                        $data->object_id	  	  = $toObjectId;
                        $data->object_type 		  = $toObjectType;
                        $data->file_name 		  = $copiedName;
                        $data->original_file_name = $options['isOriginalNameRequired'] ? $originalName : null;
                        if ($data->save()) {
                            $fileList['files'][] = $copiedName;
                        }
                    }
                }
            }
        }

        return json_encode($fileList);
    }

    /**
     * [deleteFiles description]
     *
     * @param  [string] $objectType [description]
     * @param  [int] $objectId   [description]
     * @param  [int]  $id           [description]
     * @return [json]                [description]
     */
    public function deleteFiles($objectType = null, $objectId = null, $options = [], $path = null)
    {
        $result['status'] = 0;
        $result['fileStatus'] = __(':x does not exist.', ['x' => __('Attachment')]);
        $files = $this->getFiles($objectType, $objectId, $options);
        if (! empty($files)) {
            foreach ($files as $key => $value) {
                if ($this->where('id', $value->id)->delete()) {
                    $result = $this->unlinkFile($path . DIRECTORY_SEPARATOR . $value->file_name);
                    if (isset($options['thumbnail']) && isset($options['thumbnailPath']) && $options['thumbnail'] == true) {
                        $this->unlinkFile($options['thumbnailPath'] . DIRECTORY_SEPARATOR . $value->file_name);
                    }
                    $result['status'] = 1;
                }
            }
        }

        return json_encode($result);
    }

    /**
     * [unlinkFile description]
     *
     * @param  [string] $file [description]
     * @return [array]       [description]
     */
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

    /**
     * Resize image thumbnail
     *
     * @param  string  $uploadedFilePath
     * @param  string  $uploadedFileName
     * @param  string  $thumbnailPath
     * @param  string  $oldFileName
     * @return void
     */
    public function resizeImageThumbnail($uploadedFilePath, $uploadedFileName, $thumbnailPath, $oldFileName = null)
    {
        if (isset($oldFileName) && ! empty($oldFileName)) {
            if (file_exists($thumbnailPath . DIRECTORY_SEPARATOR . $oldFileName)) {
                unlink(base_path() . DIRECTORY_SEPARATOR . $thumbnailPath . DIRECTORY_SEPARATOR . $oldFileName);
            }
        }

        $nameWithSlash = strstr($uploadedFileName, DIRECTORY_SEPARATOR);
        $replacedFilename = str_replace(DIRECTORY_SEPARATOR, '', $nameWithSlash);

        $sizes = $this->sizeRatio();
        foreach ($sizes as $name => $ratio) {
            try {
                $img = Image::make($uploadedFilePath . DIRECTORY_SEPARATOR . $replacedFilename);

                $thumbnailPath = createDirectory($this->thumbnailPath($name));
                foreach ($ratio as $key => $value) {
                    $img->resize($key, $value, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($thumbnailPath . DIRECTORY_SEPARATOR . $replacedFilename);
                }
            } catch (\Intervention\Image\Exception\NotReadableException $e) {
                // Show some exception message
            }
        }
    }

    /**
     * Size ratio
     *
     * @return array
     */
    public function sizeRatio()
    {
        return [
            'small' => [150 => 150],
            'medium' => [300 => 300],
        ];
    }

    /**
     * Download Attachment
     *
     * @param  int  $id
     * @return array
     */
    public function downloadAttachment($id)
    {
        $id = base64_decode($id);
        $file = File::where('id', $id)->first();
        if ($file) {
            $imageName = str_replace('\\', '', $file->original_file_name);
            $image = public_path('uploads' . DIRECTORY_SEPARATOR . $file->file_name);
            if (file_exists($image)) {
                switch (strtolower(pathinfo($file->file_name, PATHINFO_EXTENSION))) {
                    case 'pdf':
                        $mime = 'application/pdf';

                        break;
                    case 'zip':
                        $mime = 'application/zip';

                        break;
                    case 'jpeg':
                    case 'jpg':
                        $mime = 'image/jpg';

                        break;
                    default:
                        $mime = 'application/force-download';
                }

                $headers = [
                    'Content-Type' => $mime,
                ];

                return Response::download($image, $imageName, $headers);
            } else {
                if (file_exists(public_path('dist\img' . DIRECTORY_SEPARATOR . 'default_product.jpg'))) {
                    return Response::download(public_path('dist\img' . DIRECTORY_SEPARATOR . 'default_product.jpg'), 'default_product.jpg', ['image/jpg']);
                }
                $data = ['status' => 'fail', 'message' => __('The file you are looking for is not found.')];
                Session::flash($data['status'], $data['message']);

                return redirect()->back();
            }

        } else {
            $data = ['status' => 'fail', 'message' => __('This file does not exist.')];
            Session::flash($data['status'], $data['message']);

            return redirect()->back();
        }
    }

    /**
     * Sort by value
     *
     * @param  string  $value
     * @return query
     */
    public function scopeSortByDefinedValue($query, $value)
    {
        switch ($value) {
            case 'oldest':
                $query->orderBy('id', 'asc');

                break;
            case 'smallest':
                $query->orderBy('file_size', 'asc');

                break;
            case 'largest':
                $query->orderBy('file_size', 'desc');

                break;
            default:
                $query->orderBy('id', 'desc');
        }

        return $query;
    }
}
