<?php

namespace App\Traits;
 
trait ImageUpload
{
 
    public function UploadImage($request, $model)
    {

        $request->hasFile('image')
           ? $imgUrl = $request->file('image')->store('uploads', 'public')
           : $imgUrl='default.png';
    

        $request->isMethod('POST')
           ? $model->image()->create(['image'=> $imgUrl])
           : $model->image()->Update(['image'=>$imgUrl]);
    }
}
