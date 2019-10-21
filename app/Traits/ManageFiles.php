<?php

namespace App\Traits;
use App\Image;
use App\File;
 
trait ManageFiles
{
   /**
     * upload image to server.
     *
     * @return image url
     */
    public function UploadImage($image,$model)
    {
        return $image->store('uploads/'.$model.'', 'public');
    }

    /**
     * upload file to server .
     *
     * @return file url
     */
    public function UploadFile($file,$model)
    {
        return $file->store('files/'.$model.'', 'public');
    }

    /**
     * upload default image .
     *
     * @return image url
     */
    public function DefaultImage()
    {
        return 'default.png';
    }

    /**
     * get uploaded and already stored files or images using ids  
     *
     * @return files
     */
    public function getStoredFiles($request){
        if($ids=$request->input('image')){
            return Image::whereIn('id', $ids)->get()->getDictionary();
        }else if($ids=$request->input('file')){
            return File::whereIn('id', $ids)->get()->getDictionary();
        }
    }
}
