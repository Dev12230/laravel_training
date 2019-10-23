<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ManageFiles;
use App\Traits\ModelInstance;
use App\Image;

class ImagesController extends Controller
{
    use ManageFiles,ModelInstance;

    /**
     * Store a newly created image in storage.
     *
     * @param  Url of image
     */
    public function store($url)
    {
        return Image::create(['image'=>$url]);
    }

    /**
     * Remove the specified image from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $image=Image::find($id);
        $image->delete();
    }

    /**
     * Retrieve stored images using ids of them.
     * get class(News or Event) using (getImages(fn) URL)  using  ModelInstance trait
     * find object from this class using $request
     * get images of this object
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getImages(Request $request)
    {

        $model_object=app($this->getClass($request))::find($request->id); 
        $images=$model_object->image;

        return response()->json($images);
    }

    /**
     * get model Name(News or Event) using ( uploadToServers(fn) URL)  using  ModelInstance trait
     * Upload image direct to server
     * Create image in storage and store
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadToServer(Request $request)
    {
        $url = $this->UploadImage($request->file('image'), $this->getModelName($request));
        $image = $this->store($url);
        return response()->json(['id' => $image->id,'name'=>$url]);
    }
}
