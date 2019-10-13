<?php

namespace App\Traits;
 
trait ManageUploads
{
 
    public function UploadImage($image)
    {
        $imageName = time().$image->getClientOriginalName();
        return $image->storeAs('uploads', $imageName,'public');
    }

    public function UploadFile($file)
    {
         return $file->store('files', 'public');
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
