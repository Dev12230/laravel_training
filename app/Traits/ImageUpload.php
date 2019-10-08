<?php

namespace App\Traits;
 
trait ImageUpload
{
 
    public function UploadImage($request,$model)
    {
       $imgUrl=$request['image']->store('uploads', 'public');
       $this->SaveImage($model,$request,$imgUrl);
    }

    public function DefaultImage($request,$model)
    {
        $imgUrl='default.png';
        $this->SaveImage($model,$request,$imgUrl);
    }

    public function SaveImage($model,$request,$imgUrl){
         $request->isMethod('POST')
         ? $model->image()->create(['image'=> $imgUrl])
         : $model->image()->Update(['image'=>$imgUrl]);
    }
    
    
}
