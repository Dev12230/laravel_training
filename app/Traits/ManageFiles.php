<?php

namespace App\Traits;

use App\Image;
use App\File;
 
trait ManageFiles
{
    /**
     * Create resource in storage
     * @param  requested file & $model name
     * @return image url
     */
    public function UploadImage($image, $model)
    {
        return $image->store('uploads/'.$model.'', 'public');
    }

    /**
     * Create resource in storage
     * @param  requested file & $model name e
     * @return file url
     */
    public function UploadFile($file, $model)
    {
        return $file->store('files/'.$model.'', 'public');
    }

    /**
     * Get default image .
     *
     * @return default image url
     */
    public function DefaultImage()
    {
        return 'default.png';
    }

    /**
     * Retrieve uploaded and already stored files or images using ids
     * @param request
     * @return files
     */
    public function getStoredFiles($request)
    {
        if ($ids=$request->input('image')) {
            return Image::whereIn('id', $ids)->get()->getDictionary();
        } elseif ($ids=$request->input('file')) {
            return File::whereIn('id', $ids)->get()->getDictionary();
        }
    }
}
