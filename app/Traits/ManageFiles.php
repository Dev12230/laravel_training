<?php

namespace App\Traits;

use App\Image;
use App\File;
 
trait ManageFiles
{
    /**
     * Upload image in storage
     * @param  requested image & $model name
     * @return image url
     */
    public function Upload($request, $model)
    {
        if ($image =$request->file('image')) {
            return $image->store('uploads/'.$model.'', 'public');
        } elseif ($file=$request->file('file')) {
            return $file->store('files/'.$model.'', 'public');
        } elseif ($file=$request->video_pc) {
            return $file->store('videos/'.$model.'', 'public');
        }
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
    public function getStoredFiles($file, $request)
    {
        if ($file==$request->input('image')) {
            return Image::whereIn('id', $file)->get()->getDictionary();
        } elseif ($file==$request->input('file')) {
            return File::whereIn('id', $file)->get()->getDictionary();
        }
    }

    public function getStoredMedia($request)
    {
        if (isset($request->image_id)) {
            return Image::find($request->image_id);
        } elseif (isset($request->file_id)) {
            return File::find($request->file_id);
        }
    }
}
