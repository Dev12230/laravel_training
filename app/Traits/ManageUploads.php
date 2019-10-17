<?php

namespace App\Traits;
 
trait ManageUploads
{
 
    public function UploadImage($image,$model)
    {
        return $image->store('uploads/'.$model.'', 'public');
    }

    public function UploadFile($file,$model)
    {
         return $file->store('files/'.$model.'', 'public');
    }
    
    public function DefaultImage()
    {
        return 'default.png';
    }
}
