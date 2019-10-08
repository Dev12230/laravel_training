<?php

namespace App\Traits;
 
trait ManageUploads
{
 
    public function UploadImage($request,$model,$image)
    {
         $imgUrl=$image->store('uploads', 'public');
         $this->SaveImage($model,$request,$imgUrl);
    }
    
    public function SaveImage($model,$request,$imgUrl){
         $request->isMethod('POST')
         ? $model->image()->create(['image'=> $imgUrl])
         : $model->image()->Update(['image'=>$imgUrl]);
    }

    public function DefaultImage($request,$model)
    {
        $imgUrl='default.png';
        $this->SaveImage($model,$request,$imgUrl);
    }

    public function UploadFile($request,$model,$file)
    {
         $fileUrl=$file->store('files', 'public');
         $this->SaveFile($model,$request,$fileUrl);
    }

    public function SaveFile($model,$request,$fileUrl){
        $request->isMethod('POST')
        ? $model->file()->create(['file'=> $fileUrl])
        : $model->file()->Update(['file'=> $fileUrl]);
   }


    
    
}
