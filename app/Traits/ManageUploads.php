<?php

namespace App\Traits;
 
trait ManageUploads
{
 
    public function UploadImage($image,$model)
    {
        return $image->store('uploads/'.$model->getTable().'', 'public');
    }

    public function UploadFile($file,$model)
    {
         return $file->store('files/'.$model->getTable().'', 'public');
    }
    
    public function DefaultImage()
    {
        return 'default.png';
    }

    public function serverUpload($request,$model)
    {
        if ($image = $request->file('image')) {
            $Url = $this->UploadImage($image,$model);
        } elseif ($file = $request->file('file')) {
            $Url = $this->UploadFile($file,$model);
        }
        return $Url;
    }
}
