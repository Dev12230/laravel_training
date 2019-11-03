<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MediaRequest;
use App\Traits\ManageFiles;
use App\Traits\ModelInstance;
use App\Folder;
use App\Image;

class ImagesController extends Controller
{
    use ManageFiles,ModelInstance;

    public function store(Request $request)
    {
        $url = $this->Upload($request, $this->getModelName($request));
        $image= Image::create(['image'=>$url]);
        return response()->json(['id' => $image->id,'name'=>$url]);
    }

    public function destroy($id)
    {
        $image=Image::find($id);
        $image->delete();
    }

    public function getImages(Request $request)
    {
        $model_object=app($this->getClass($request))::find($request->id);
        $images=$model_object->image;
        return response()->json($images);
    }
}
