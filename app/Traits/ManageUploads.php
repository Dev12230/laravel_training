<?php

namespace App\Traits;
 
trait ManageUploads
{
 
    public function UploadImage($image)
    {
        return $image->store('uploads', 'public');
    }

    public function UploadFile($file)
    {
         return $file->store('files', 'public');
    }
    
    public function DefaultImage()
    {
        return 'default.png';
 
    }

 



    
    
}
