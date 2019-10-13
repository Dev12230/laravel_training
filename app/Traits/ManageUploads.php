<?php

namespace App\Traits;
 
trait ManageUploads
{
 
    public function UploadImage($image)
    {
        $imgName = time().$image->getClientOriginalName();
        return $image->storeAs('uploads', $imgName,'public');
    }

    public function UploadFile($file)
    {
        $fileName = time().$file->getClientOriginalName();
         return $file->storeAs('files',$fileName,'public');
    }
    
    public function DefaultImage()
    {
        return 'default.png';
 
    }

    public function serverUpload($request)
    {
        if($image = $request->file('image')){
            $Url = $this->UploadImage($image);
        }elseif($file = $request->file('file')){
            $Url = $this->UploadFile($file);
        }    
        return response()->json(['url' => $Url]);
    }

 



    
    
}
